<?php
/**
 * Created by PhpStorm.
 * User: richard
 * Date: 15-4-30
 * Time: 下午5:43
 */

class Order_Online_Model extends CI_Model {

	function __construct() {
		parent::__construct();
		$this->load->helper('common');
	}
    /**
     * add product to shopping cart
     * @param $customer_id string 用户ID,系统生成的，不是微信号
     * @param $product_id string 产品ID
     * @param $spec_id string 规格编号
     * @param $product_num int 购买数量
     */
    function add_product_cart($customer_id,$product_id,$spec_id,$product_num){
        $query = array(
            'customer_id' => $customer_id,
            'product_id' => $product_id,
            'spec_id' => $spec_id
        );
        $this->db->where($query);
        $result = $this->db->get("lp_shopping_cart")->result_array();
        //已经存在商品，更新数量
        if(isset($result) && count($result) > 0){
            $this->db->query("update lp_shopping_cart set product_num = product_num + $product_num where customer_id = $customer_id and product_id = $product_id and spec_id = $spec_id");
        }else{
            $data = array(
                'customer_id' => $customer_id ,
                'product_id' => $product_id ,
                'spec_id' => $spec_id,
                'product_num' => $product_num,
                'created_at' => date('y-m-d H:i:s',time())
            );
            $this->db->insert('lp_shopping_cart', $data);
        }

    }

    /**
     * drop product from shopping cart
     * @param $customer_id
     * @param $product_id
     * @param $spec_id
     */
    function drop_product_cart($customer_id,$product_id,$spec_id){
        $query = array(
            'customer_id' => $customer_id,
            'product_id' => $product_id,
            'spec_id' => $spec_id
        );
        $this->db->where($query);
        $this->db->delete('lp_shopping_cart');
    }

    function get_cart_product_list($customer_id){
        log_message("info","get product list from cart,customer_id:".$customer_id);
        $this->db->select('lp_shopping_cart.product_num,lp_product_info.id,lp_product_info.name,lp_product_specification.spec_id,lp_product_specification.score,lp_product_images.image_url,lp_global_specification.spec_name');
        $this->db->from('lp_shopping_cart');
        $this->db->join("lp_global_specification","lp_global_specification.spec_id = lp_shopping_cart.spec_id");
        $this->db->join("lp_product_info","lp_product_info.id = lp_shopping_cart.product_id");
        $this->db->join("lp_product_specification","lp_product_info.id = lp_product_specification.product_id");
        $this->db->join('lp_product_images', 'lp_product_info.id = lp_product_images.product_id');
        $this->db->group_by('lp_product_info.id');
        $this->db->order_by("lp_shopping_cart.created_at","desc");
        $this->db->where("lp_shopping_cart.customer_id",$customer_id);
        return $this->db->get()->result_array();
    }



    /**
     * @param $customer_id
     * @param $delivery_id
     * @param $delivery_thirdparty_code
     * @param $product_list
     * @return array fail product list
     */
    function add_order($customer_id,$delivery_id,$delivery_order_code,$product_list,$message){
        $order_type = 1; //消费积分
        $order_datetime = date('Y-m-d H:i:s',time());
        //generate order codes
        $order_code = generate_order_code();

        //check if the order codes exist in lp_order_online table
        $this->db->where('order_code',$order_code);
        while($this->db->count_all_results('lp_order_online') > 0){
            $order_code = generate_order_code();
            $this->db->where('order_code',$order_code);
        }

        $failed_order_result = array();
        $total_score = 0;
        //检查库存数量
        foreach($product_list as $product_item){
            $this->db->where('lp_product_info.id',$product_item["product_id"]);
            $this->db->where('lp_product_specification.stock_num >',$product_item["product_num"]);
            $this->db->select('lp_product_info.id,lp_product_specification.score');
            $this->db->from("lp_product_info");
            $this->db->join("lp_product_specification","lp_product_specification.product_id = lp_product_info.id","inner");
            $result = $this->db->get()->result();
            if(is_null($result) || count($result) == 0){
                $failed_order_result[] = $product_item["product_id"];
            }
            $total_score = $total_score + $product_item['product_num']*$result[0]->score;
        }

        if(count($failed_order_result) > 0){
             return 1; //商品库存不够
        }else{
            $this->db->trans_start();
            //insert order main information
           $order = array('order_code' => $order_code ,
               'customer_id' => $customer_id ,
               'delivery_id' => $delivery_id,
               'delivery_company_id' => 1, //default is 顺丰
               'delivery_order_code' => $delivery_order_code,
               'order_datetime' => $order_datetime,
               'total_score' => $total_score,
               'message' => $message
           );
            $this->db->insert('lp_order_online',$order);
            //insert order detail information
            $order_detail = array();
            foreach($product_list as $product_item) {
                $data = array(
                    'order_code' => $order_code,
                    'product_id' => $product_item['product_id'],
                    'spec_id' => $product_item['spec_id'],
                    'product_num' => $product_item['product_num']
                );
                $order_detail[] = $data;
            }
            $this->db->insert_batch('lp_order_online_detail',$order_detail);

            //reduce customer total score
            $this->db->where('customer_id',$customer_id);
            $this->db->query("update lp_customer_info set total_score = total_score - $total_score where id = $customer_id");

            //produce customer score list
            $this->db->query("insert lp_customer_score_list(customer_id,order_code,order_type,total_score,order_datetime)values($customer_id,'$order_code',$order_type,$total_score,'$order_datetime')");
            //clean product with specification from cart
            foreach($product_list as $product_item) {
                $product_id = $product_item["product_id"];
                $spec_id = $product_item["spec_id"];
                $this->db->where('product_id', $product_id);
                $this->db->where('spec_id', $spec_id);
                $this->db->where('customer_id',$customer_id);
                $this->db->delete("lp_shopping_cart");
            }
            $this->db->trans_complete();
            return 0;
        }
    }

    public function get_order_list($customer_id){
        $this->db->select('*');
        $this->db->from('lp_order_online');
        $this->db->where('lp_order_online.customer_id',$customer_id);
        $this->db->order_by("order_datetime","desc");
        $result = $this->db->get()->result_array();
        $order_list = array();
        foreach($result as $order){
            $order["detail"] = $this->get_order_detail($order["order_code"]);
            $order_list[] = $order;
        }
        return $order_list;
    }

    public function get_order_info($order_code){
        $this->db->select('*');
        $this->db->from('lp_order_online');
        $this->db->join("lp_delivery_company","lp_order_online.delivery_company_id=lp_delivery_company.id","left");
        $this->db->where('lp_order_online.order_code',$order_code);
        $this->db->order_by("order_datetime","desc");
        $result = $this->db->get()->result_array();
        if(isset($result) && count($result)>0){
            $order_info = $result[0];
            $order_info['detail'] = $this->get_order_detail($order_code);
        }

        return $order_info;
    }

    /**
     * get product list for order detail by order_code
     * @param $order_code
     */
    public function get_order_detail($order_code){
        $this->db->where('lp_order_online_detail.order_code',$order_code);
        $this->db->select('lp_order_online_detail.product_num,lp_product_info.name,lp_product_images.image_url,lp_product_specification.score,lp_global_specification.spec_name');
        $this->db->from('lp_order_online_detail');
        $this->db->join('lp_global_specification', 'lp_order_online_detail.spec_id = lp_global_specification.spec_id');
        $this->db->join("lp_product_info","lp_product_info.id = lp_order_online_detail.product_id");
        $this->db->join("lp_product_specification","lp_product_specification.product_id = lp_order_online_detail.product_id and lp_product_specification.spec_id = lp_order_online_detail.spec_id");
        $this->db->join("lp_product_images","lp_product_images.product_id = lp_product_info.id");
        return $this->db->get()->result_array();
    }

    /**
     * update delivery order code
     * @param $order_code
     * @param $delivery_code
     * @return mixed
     */

    function update_delivery_order_code($order_code,$delivery_code){
        $result = $this->db->query("update lp_order_online set delivery_order_code = '$delivery_code',status = 1 where order_code = '$order_code'");

        return $result;
    }


    /**
     * get order list by datetime
     * @param $datetime
     * @param $per_nums
     * @param $start_position
     * @return mixed
     */
    function get_online_order_list($startTime,$endTime,$orderCode,$pageIndex,$pageSize){
        if($startTime !='' && $endTime !=''){
            $endTime = date('Y-m-d H:i:s',strtotime($endTime)+86400);
            $this->db->where("a.order_datetime between "."'$startTime'"." and "."'$endTime'");
        }
        if($orderCode != ''){
            $this->db->where("a.order_code",$orderCode);
        }
        $this->db->select('a.order_code,a.delivery_order_code,a.order_datetime,f.wechat_id,f.name as username,f.phone,c.name,c.title,e.spec_name,b.product_num,d.score,a.status,a.total_score,h.thumbnail_url');
        $this->db->from('lp_order_online a');
        $this->db->join('lp_order_online_detail b','a.order_code = b.order_code');
        $this->db->join('lp_product_info c','c.id = b.product_id');
        $this->db->join('lp_product_specification d','d.product_id = b.product_id and d.spec_id = b.spec_id');
        $this->db->join('lp_global_specification e','d.spec_id = e.spec_id');
        $this->db->join('lp_customer_info f','f.id = a.customer_id');
        $this->db->join('lp_customer_delivery_info g','a.delivery_id = g.id');
        $this->db->join('lp_product_images h','h.product_id = c.id');
        $this->db->order_by("a.order_datetime","desc");
        $sql = $this->db->last_query();
        $this->db->limit($pageIndex,$pageSize);
        $result = $this->db->get()->result_array();

        $data = array();
        foreach($result as $val){
            if($data[$val['order_code']]){
                $data[$val['order_code']]['detail'] .= ','.$val['name'].'|'.$val['spec_name'].'|'.$val['product_num'].'瓶';
            }else{
                $item = array();
                $item['detail'] = $val['name'].'|'.$val['spec_name'].'|'.$val['product_num'].'瓶';
                $item['order_code'] = $val['order_code'];
                $item['receiver_province'] = $val['receiver_province'].'/'.$val['receiver_city'];
                $item['username'] = $val['username'];
                $item['wechat_id'] = $val['wechat_id'];
                $item['order_datetime'] = $val['order_datetime'];
                $item['delivery_order_code'] = $val['delivery_order_code'];
                $item['status'] = $val['status'];
                $data[$val['order_code']] = $item;
            }
        }
        $returnData = array();
        foreach($data as $item){
            $returnData[] = $item;
        }

        return $returnData;

    }

    /**
     * count order list
     * @param $datetime
     * @return mixed
     */
    function count_online_order_list($startTime,$endTime,$orderCode){
        if($startTime !='' && $endTime !=''){
            $endTime = date('Y-m-d H:i:s',strtotime($endTime)+86400);
            $this->db->where("a.order_datetime between "."'$startTime'"." and "."'$endTime'");
        }
        if($orderCode != ''){
            $this->db->where("a.order_code",$orderCode);
        }
        $this->db->select('count(a.order_code) as count');
        $this->db->from('lp_order_online a');
        $this->db->join('lp_order_online_detail b','a.order_code = b.order_code');
        $this->db->join('lp_product_info c','c.id = b.product_id');
        $this->db->join('lp_product_specification d','d.product_id = b.product_id and d.spec_id = b.spec_id');
        $this->db->join('lp_global_specification e','d.spec_id = e.spec_id');
        $this->db->join('lp_customer_info f','f.id = a.customer_id');
        $this->db->join('lp_customer_delivery_info g','a.delivery_id = g.id');
        return $this->db->get()->result_array()[0]['count'];
    }

    function get_delivery_detail($orderCode){
        $this->db->where("a.order_code",$orderCode);
        $this->db->select("a.order_code,a.delivery_order_code,a.order_datetime,a.message,f.wechat_id,f.name as username,f.phone,c.name,e.spec_name,b.product_num,d.score,b.status,f.total_score,h.company_name,g.receiver_name,g.receiver_phone,g.receiver_province,g.receiver_city,g.receiver_region,g.receiver_address");
        $this->db->from('lp_order_online a');
        $this->db->join('lp_order_online_detail b','a.order_code = b.order_code');
        $this->db->join('lp_product_info c','c.id = b.product_id');
        $this->db->join('lp_product_specification d','d.product_id = b.product_id and d.spec_id = b.spec_id');
        $this->db->join('lp_global_specification e','d.spec_id = e.spec_id');
        $this->db->join('lp_customer_info f','f.id = a.customer_id');
        $this->db->join('lp_customer_delivery_info g','a.delivery_id = g.id');
        $this->db->join('lp_delivery_company h','h.id = a.delivery_company_id');
        $result = $this->db->get()->result_array();
        $data = array();
        foreach($result as $val){
            if($data[$val['order_code']]){
                $data[$val['order_code']]['detail'] .= ','. $val['name'].'|'.$val['spec_name'].'|'.$val['product_num'].'瓶';
            }else{
                $item = array();
                $item['detail'] = $val['name'].'|'.$val['spec_name'].'|'.$val['product_num'].'瓶';
                $item['order_code'] = $val['order_code'];
                $item['receiver_province'] = $val['receiver_province'].','.$val['receiver_city'].','.$val['receiver_region'].','.$val['receiver_address'];
                //$item['username'] = $val['username'];
                $item['wechat_id'] = $val['wechat_id'];
                $item['order_datetime'] = $val['order_datetime'];
                $item['delivery_order_code'] = $val['delivery_order_code'];
                $item['company_name'] = $val['company_name'];
                $item['receiver_name'] = $val['receiver_name'];
                $item['receiver_phone'] = $val['receiver_phone'];
                $item['total_score'] = $val['total_score'];
                $item['message'] = $val['message'];
                $data[$val['order_code']] = $item;
            }
        }
        $returnData = array();
        foreach($data as $item){
            $returnData[] = $item;
        }

        return $returnData;
    }

    function export_online_order($startTime,$endTime,$order_code){
        if($startTime !='' && $endTime !=''){
            $endTime = date('Y-m-d H:i:s',strtotime($endTime)+86400);
            $this->db->where("a.order_datetime between "."'$startTime'"." and "."'$endTime'");
        }
        if($order_code != ''){
            $this->db->where("a.order_code",$order_code);
        }
        $this->db->select('a.order_code,a.delivery_order_code,a.order_datetime,f.wechat_id,f.name as username,f.phone,c.name,e.spec_name,b.product_num,d.score,b.status,f.total_score');
        $this->db->from('lp_order_online a');
        $this->db->join('lp_order_online_detail b','a.order_code = b.order_code');
        $this->db->join('lp_product_info c','c.id = b.product_id');
        $this->db->join('lp_product_specification d','d.product_id = b.product_id and d.spec_id = b.spec_id');
        $this->db->join('lp_global_specification e','d.spec_id = e.spec_id');
        $this->db->join('lp_customer_info f','f.id = a.customer_id');
        $this->db->join('lp_customer_delivery_info g','a.delivery_id = g.id');
        $this->db->order_by("a.order_datetime","desc");
        $result = $this->db->get()->result_array();

        $data = array();
        foreach($result as $val){
            if($data[$val['order_code']]){
                $data[$val['order_code']]['detail'] .= ','. $val['name'].'|'.$val['spec_name'].'|'.$val['product_num'].'瓶';
            }else{
                $item = array();
                $item['detail'] = $val['name'].'|'.$val['spec_name'].'|'.$val['product_num'].'瓶';
                $item['order_code'] = $val['order_code'];
                //$item['receiver_province'] = $val['receiver_province'].'/'.$val['receiver_city'];
                $item['username'] = $val['username'];
                $item['wechat_id'] = $val['wechat_id'];
                $item['order_datetime'] = $val['order_datetime'];
                $item['delivery_order_code'] = $val['delivery_order_code'];
                $item['total_score'] = $val['total_score'];
                $data[$val['order_code']] = $item;
            }
        }
        $returnData = array();
        foreach($data as $item){
            $returnData[] = $item;
        }

        return $returnData;

    }

    function get_company($order_code){
        $this->db->where("a.order_code",$order_code);
        $this->db->select("b.company_name");
        $this->db->from("lp_order_online a");
        $this->db->join("lp_delivery_company b","b.id = a.delivery_company_id");
        $res = $this->db->get()->result_array()[0];

        return $res;
    }

    function count_all_online_order(){
        $query = $this->db->query("select * from lp_order_online");
        $nums = $query->num_rows();

        return $nums;
    }

    function count_undelivery_online_order(){
        $query = $this->db->query("select * from lp_order_online where status = 2");
        $nums = $query->num_rows();

        return $nums;
    }

    function count_delivery_online_order(){
        $query = $this->db->query("select * from lp_order_online where status = 1 ");
        $nums = $query->num_rows();

        return $nums;
    }

    function count_complete_online_order(){
        $query = $this->db->query("select * from lp_order_online where status = 0");
        $nums = $query->num_rows();

        return $nums;
    }
} 