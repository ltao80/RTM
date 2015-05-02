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
        $result = $this->db->get("rtm_shopping_cart")->result_array();
        //已经存在商品，更新数量
        if(isset($result) && count($result) > 0){
            $this->db->query("update rtm_shopping_cart set product_num = product_num + $product_num where customer_id = $customer_id and product_id = $product_id and spec_id = $spec_id");
        }else{
            $data = array(
                'customer_id' => $customer_id ,
                'product_id' => $product_id ,
                'spec_id' => $spec_id,
                'product_num' => $product_num,
                'created_at' => date('y-m-d h:i:s',time())
            );
            $this->db->insert('rtm_shopping_cart', $data);
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
        $this->db->delete('rtm_shopping_cart');
    }

    function get_cart_product_list($customer_id){
        $this->db->where('customer_id',$customer_id);
        $this->db->select('rtm_product_info.name,rtm_product_specification.score,rtm_product_images.image_url,rtm_global_specification.spec_name');
        $this->db->from('rtm_shopping_cart');
        $this->db->join("rtm_global_specification","rtm_global_specification.spec_id = rtm_shopping_cart.spec_id");
        $this->db->join("rtm_product_info","rtm_product_info.id = rtm_shopping_cart.product_id");
        $this->db->join("rtm_product_specification","rtm_product_info.id = rtm_product_specification.product_id");
        $this->db->join('rtm_product_images', 'rtm_product_info.id = rtm_product_images.product_id');
        $this->db->group_by('rtm_product_info.id');
        $this->db->order_by("rtm_shopping_cart.created_at","desc");
        $this->db->get()->result_array();
    }



    /**
     * @param $customer_id
     * @param $delivery_id
     * @param $delivery_thirdparty_code
     * @param $product_list
     * @return array fail product list
     */
    function add_order($customer_id,$delivery_id,$delivery_thirdparty_code,$product_list){
        $order_type = 1; //消费积分
        $order_datetime = date('y-m-d h:i:s',time());
        //generate order codes
        $order_code = generate_order_code();

        //check if the order codes exist in rtm_order_online table
        $this->db->where('order_code',$order_code);
        while($this->db->count_all_results('table') > 0){
            $order_code = generate_order_code();
            $this->db->where('order_code',$order_code);
        }
        $this->db->trans_start();
        $failed_order_result = array();
        $total_score = 0;
        foreach($product_list as $product_item){
            $this->db->where('id',$product_item["product_id"]);
            $this->db->where('stock_num >',$product_item["product_num"]);
            $this->db->select('id');
            $total_score = $total_score + $product_item["product_num"] * $product_item["product_score"];
            if(is_null($this->db->get('rtm_product_info')->result())){
                $failed_order_result[] = $product_item["product_id"];
            }
        }
        if(count($failed_order_result) > 0){
            $this->db->trans_complete();
            return $failed_order_result;
        }else{
            //insert order main information
           $order = array('order_code' => $order_code ,
                    'customer_id' => $customer_id ,
                    'delivery_id' => $delivery_id,
                    'delivery_thirdparty_code' => $delivery_thirdparty_code,
                    'order_datetime' => $order_datetime);
            $this->db->insert('rtm_order_online',$order);

            //insert order detail information
            $order_detail = array();
            foreach($product_list as $product_item) {
                $data[] = array(
                    'order_code' => $order_code,
                    'product_id' => $product_item['product_id'],
                    'spec_id' => $product_item['spec_id'],
                    'product_num' => $product_item['product_num']
                );
            }
            $this->db->insert('rtm_order_online_detail',$order_detail);

            //reduce customer total score
            $this->db->where('customer_id',$customer_id);
            $this->db->query("update rtm_customer_info set total_score = total_score - $total_score where id = $customer_id");
            $this->db->query("insert rtm_customer_score_list(customer_id,order_code,order_type,total_score,order_datetime)values($customer_id,$order_code,$order_type,$total_score,$order_datetime)");
            $this->db->trans_complete();
            return $failed_order_result;
        }
    }

    /**
     * get product list for order detail by order_code
     * @param $order_code
     */
    public function get_order_detail($order_code){
        $this->db->where('rtm_order_online.order_code',$order_code);
        $this->db->select('rtm_order_online_detail.product_num,rtm_product_info.name,rtm_product_info.score,rtm_global_specification.spec_name');
        $this->db->from('rtm_order_online');
        $this->db->join("rtm_order_online_detail","rtm_order_online.order_code = rtm_order_online_detail.order_code");
        $this->db->join('rtm_global_specification', 'rtm_order_online_detail.spec_id = rtm_global_specification.spec_id');
        $this->db->join("rtm_product_info","rtm_product_info.id = rtm_order_online_detail.product_id");
        $this->db->join("rtm_product_images","rtm_product_images.product_id = rtm_product_info.id");
        $this->db->group_by("rtm_order_online_detail.product_id");
        $this->db->get()->result_array();
    }
} 