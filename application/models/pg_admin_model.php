<?php
class Pg_Admin_Model extends CI_Model {
    function __construct() {
        parent::__construct();
        $this->load->helper('common');
    }

    /**
     * @param $openId
     * @return int  1 : 不存在，进入首次验证页面， 2： 登录， 3： 当天已经登录，无需登录
     */
	function verify($openId) {
		$query = $this->db->query("SELECT * FROM lp_promotion_info WHERE wechat_id = '$openId'");

		if($query->num_rows() > 0) {
			$user = $query->next_row();
			$lastLogin = new DateTime($user->last_login);
			$now = new DateTime();
			if($now->format("y") == $lastLogin->format("y") && $now->format("d") == $lastLogin->format("d") && $now->format("d") == $now->format("d")) {
				return 3;
			} else {
				return 2;
			}
		} else {
			return 1;
		}
	}

	function confirm_user($openId, $province, $city, $store, $name, $phone, $password) {
        log_message("info","confirm user information,opendId:".$openId.",province:".$province.",city:".$city.",store:".$store.",name".$name.",phone:".$phone.",password:".$password);
		$query = $this->db->query("SELECT pi.id FROM lp_promotion_info pi INNER JOIN lp_global_store gs ON pi.store_id = gs.store_id WHERE gs.province = '$province' AND gs.city = '$city' AND gs.store_name = '$store' AND pi.name='$name' AND pi.phone='$phone'");
		if($query->num_rows()) {
			$user = $query->next_row();
			$userId = $user->id;
			$this->db->query("UPDATE lp_promotion_info SET password='$password', wechat_id='$openId', status = 1 WHERE id = $userId");
			return true;
		} else {
			return false;
		}
	}

	function confirm_change($openId) {
		$this->db->query("UPDATE lp_promotion_info SET status = 1 WHERE wechat_id = '$openId'");
	}

	function signin($email, $password) {
		$query = $this->db->query("SELECT * from lp_promotion_info where email = '$email' and password = '$password' and is_admin = 1");
		if($query->num_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}

    /**
     * get order list by datetime
     * @param $datetime
     * @param $per_nums
     * @param $start_position
     * @return mixed
     */
     function get_order_list_by_datetime($startTime,$endTime,$pageIndex,$pageSize){
         if($startTime !='' && $endTime !=''){
             $endTime = date('Y-m-d H:i:s',strtotime($endTime)+86400);
             $this->db->where("a.order_datetime between "."'$startTime'"." and "."'$endTime'");
         }
        $this->db->select('a.order_code,a.delivery_order_code,a.order_datetime,f.wechat_id,f.name as username,f.phone,c.name,e.spec_name,b.product_num,g.receiver_province,g.receiver_city,g.receiver_region,g.receiver_address');
        $this->db->from('lp_order_online a');
        $this->db->join('lp_order_online_detail b','a.order_code = b.order_code');
        $this->db->join('lp_product_info c','c.id = b.product_id');
        $this->db->join('lp_product_specification d','d.product_id = b.product_id and d.spec_id = b.spec_id');
        $this->db->join('lp_global_specification e','d.spec_id = e.spec_id');
        $this->db->join('lp_customer_info f','f.id = a.customer_id');
        $this->db->join('lp_customer_delivery_info g','a.delivery_id = g.id');
        $this->db->order_by("a.order_datetime","desc");
        $this->db->limit($pageIndex,$pageSize);
        $result = $this->db->get()->result_array();
        $data = array();
        //$i = 0;
        foreach($result as $val){
            if($data[$val['order_code']]){
                $data[$val['order_code']]['detail'] .= ','. $val['name'].'|'.$val['spec_name'].'|'.$val['product_num'].'瓶';
            }else{
                $item = array();
                $item['detail'] = $val['name'].'|'.$val['spec_name'].'|'.$val['product_num'].'瓶';
                $item['order_code'] = $val['order_code'];
                $item['receiver_province'] = $val['receiver_province'].'/'.$val['receiver_city'];
                $item['username'] = $val['username'];
                $item['wechat_id'] = $val['wechat_id'];
                $item['order_datetime'] = $val['order_datetime'];
                $item['delivery_order_code'] = $val['delivery_order_code'];
                $data[$val['order_code']] = $item;
                //$i++;
            }
        }
         $returnData = array();
         foreach($data as $key => $item){
             $returnData[] = $item;
         }

         return $returnData;

    }

    /**
     * count order list
     * @param $datetime
     * @return mixed
     */
    function count_order_list($startTime,$endTime){
        if($startTime !='' && $endTime !=''){
            $endTime = date('Y-m-d H:i:s',strtotime($endTime)+86400);
            $this->db->where("a.order_datetime between "."'$startTime'"." and "."'$endTime'");
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

    function update_delivery_order_code($order_code,$delivery_code){
        $result = $this->db->query("update lp_order_online set delivery_order_code = '$delivery_code' where order_code = '$order_code'");

        return $result;
    }

    function export_order_list($startTime,$endTime,$order_code){
        $sqlWhere = '';
        if($startTime !='' && $endTime !=''){
            $endTime = date('Y-m-d H:i:s',strtotime($endTime)+86400);
            $sqlWhere .= " and a.order_datetime between '$startTime' and '$endTime'";
        }else if($order_code != ''){
            $sqlWhere .= " and a.order_code in ($order_code)";
        }
        $query = $this->db->query('select a.order_code,a.order_datetime,a.delivery_order_code,f.wechat_id,f.name as username,f.phone,c.name,e.spec_name,b.product_num,g.receiver_province,g.receiver_city,g.receiver_region,g.receiver_address from lp_order_online a left join lp_order_online_detail b on a.order_code = b.order_code left join lp_product_info c on c.id = b.product_id left join lp_product_specification d on d.product_id = b.product_id and d.spec_id = b.spec_id left join lp_global_specification e on d.spec_id = e.spec_id left join lp_customer_info f on f.id = a.customer_id left join lp_customer_delivery_info g on a.delivery_id = g.id where 1=1'.$sqlWhere.' order by a.order_datetime desc');

        $result = $query->result_array();
        $data = array();
        //$i = 0;
        foreach($result as $val){
            if($data[$val['order_code']]){
                $data[$val['order_code']]['detail'] .= ','. $val['name'].'|'.$val['spec_name'].'|'.$val['product_num'].'瓶';
            }else{
                $item = array();
                $item['detail'] = $val['name'].'|'.$val['spec_name'].'|'.$val['product_num'].'瓶';
                $item['order_code'] = $val['order_code'];
                $item['receiver_province'] = $val['receiver_province'].'/'.$val['receiver_city'];
                $item['username'] = $val['username'];
                $item['wechat_id'] = $val['wechat_id'];
                $item['order_datetime'] = $val['order_datetime'];
                $item['delivery_order_code'] = $val['delivery_order_code'];
                $data[$val['order_code']] = $item;
                //$i++;
            }
        }
        $returnData = array();
        foreach($data as $key => $item){
            $returnData[] = $item;
        }

        return $returnData;

    }

    function get_pg_list($province,$city,$storeName,$pgName,$pageIndex,$pageSize){
        if($province != ''){
            $this->db->where("b.province",$province);
        }
        if($city != ''){
            $this->db->where("b.city",$city);
        }
        if($storeName != ''){
            $this->db->where("b.store_name",$storeName);
        }
        if($pgName != ''){
            $this->db->where("a.name",$pgName);
        }
        $this->db->select("a.id, a.name, a.phone, a.email, a.status, b.province, b.city, b.store_name");
        $this->db->from("lp_promotion_info a");
        $this->db->join("lp_global_store b","b.store_id = a.store_id");
        $this->db->order_by("a.last_login","desc");
        $this->db->limit($pageIndex,$pageSize);
        $result = $this->db->get()->result_array();

        return $result;
    }

    function count_pg_list($province,$city,$storeName,$pgName){
        if($province != ''){
            $this->db->where("b.province",$province);
        }
        if($city != ''){
            $this->db->where("b.city",$city);
        }
        if($storeName != ''){
            $this->db->where("b.store_name",$storeName);
        }
        if($pgName != ''){
            $this->db->where("a.name",$pgName);
        }
        $this->db->select("count(*) as count");
        $this->db->from("lp_promotion_info a");
        $this->db->join("lp_global_store b","b.store_id = a.store_id");
        $this->db->order_by("a.last_login","desc");
        $result = $this->db->get()->result_array()[0]['count'];

        return $result;
    }

    function add_pg($pgName,$phone,$email,$store){
        $data = array(
            "store_id" => $store,
            "name" => $pgName,
            "password" => "",
            "phone" => $phone,
            "email" => $email,
            "wechat_id" => "",
            "status" => 0,
            "is_admin" => 0,
            "last_login" => date('Y-m-d H:i:s',time())
        );
        $res = $this->db->insert("lp_promotion_info",$data);
        return $res;
    }

    function update_pg($pgId,$pgName,$phone,$email,$store){
        $data = array(
            "store_id" => $store,
            "name" => $pgName,
            "phone" => $phone,
            "email" => $email
        );
        $this->db->where('id',$pgId);
        $res = $this->db->update('lp_promotion_info',$data);
        return $res;
    }

    function delete_pg($pgId){
        $this->db->where('id',$pgId);
        $res = $this->db->delete('lp_promotion_info');
        return $res;
    }

    function update_pg_status($pgId,$status){
        $data = array(
            "status" => $status
        );
        $this->db->where('id',$pgId);
        $res = $this->db->update('lp_promotion_info',$data);
        return $res;
    }

    function get_pg_by_id($pId){
        $this->db->where("a.id",$pId);
        $this->db->select("a.id, a.name, a.phone, a.email, a.status, b.province, b.city, b.store_name");
        $this->db->from("lp_promotion_info a");
        $this->db->join("lp_global_store b","b.store_id = a.store_id");
        $result = $this->db->get()->result_array();

        return $result;
    }

    function get_pg_store($province,$city,$region){
        if($province != ''){
            $this->db->where("province",$province);
        }
        if($city != ''){
            $this->db->where("city",$city);
        }
        if($region != ''){
            $this->db->where("region",$region);
        }
        $this->db->select("*");
        $this->db->from("lp_global_store");
        $result = $this->db->get()->result_array();

        return $result;
    }

    function get_offline_order_list($province,$city,$storeName,$pgName,$orderDate,$isScan,$pageSize,$pageIndex){
        if($province != ''){
            $this->db->where("e.province",$province);
        }
        if($city != ''){
            $this->db->where("e.city",$city);
        }
        if($storeName != ''){
            $this->db->where("f.store_name",$storeName);
        }
        if($pgName != ''){
            $this->db->where("e.name",$pgName);
        }
        if($orderDate != ''){
            $endTime = date('Y-m-d H:i:s',strtotime($orderDate)+86400);
            $this->db->where("a.order_datetime between "."'$orderDate'"." and "."'$endTime'");
        }
        if($isScan != ''){
            $this->db->where("a.is_scan_qrcode",$isScan);
        }
        $this->db->select("a.order_code, a.order_datetime, a.scan_datetime, b.product_num, c.name, c.title as pTitle, d.spec_name, f.province, f.city, e.wechat_id, e.name as username, e.phone, f.store_name");
        $this->db->from("lp_order_offline a");
        $this->db->join("lp_order_offline_detail b","b.order_code = a.order_code");
        $this->db->join("lp_product_info c","c.id = b.product_id");
        $this->db->join("lp_global_specification d","d.spec_id = b.spec_id");
        $this->db->join("lp_customer_info e","e.id = a.customer_id");
        $this->db->join("lp_global_store f","f.store_id = a.store_id");
        $this->db->order_by("a.order_datetime","desc");
        $this->db->limit($pageIndex,$pageSize);
        $result = $this->db->get()->result_array();
        //$sql = $this->db->last_query();
        //echo $sql;
        //return $result;
        $data = array();
        //$i = 0;
        foreach($result as $val){
            if($data[$val['order_code']]){
                $data[$val['order_code']]['detail'] .= ','. $val['name'].'|'.$val['spec_name'].'|'.$val['product_num'].'瓶';
            }else{
                $item = array();
                $item['detail'] = $val['name'].'|'.$val['spec_name'].'|'.$val['product_num'].'瓶';
                $item['order_code'] = $val['order_code'];
                $item['address'] = $val['province'].'/'.$val['city'];
                $item['store'] = $val['store_name'];
                $item['wechat_id'] = $val['wechat_id'];
                $item['order_datetime'] = $val['order_datetime'];
                $item['scan_datetime'] = $val['scan_datetime'];
                $item['contact'] = $val['username'].'|'.$val['phone'];
                $data[$val['order_code']] = $item;
                //$i++;
            }
        }
        $returnData = array();
        foreach($data as $key => $item){
            $returnData[] = $item;
        }

        return $returnData;

    }

    function count_offline_order_list($province,$city,$storeName,$pgName,$orderDate,$isScan){
        if($province != ''){
            $this->db->where("e.province",$province);
        }
        if($city != ''){
            $this->db->where("e.city",$city);
        }
        if($storeName != ''){
            $this->db->where("f.store_name",$storeName);
        }
        if($pgName != ''){
            $this->db->where("e.name",$pgName);
        }
        if($orderDate != ''){
            $endTime = date('Y-m-d H:i:s',strtotime($orderDate)+86400);
            $this->db->where("a.order_datetime between "."'$orderDate'"." and "."'$endTime'");
        }
        if($isScan != ''){
            $this->db->where("a.is_scan_qrcode",$isScan);
        }
        $this->db->select("count(*) as count");
        $this->db->from("lp_order_offline a");
        $this->db->join("lp_order_offline_detail b","b.order_code = a.order_code");
        $this->db->join("lp_product_info c","c.id = b.product_id");
        $this->db->join("lp_global_specification d","d.spec_id = b.spec_id");
        $this->db->join("lp_customer_info e","e.id = a.customer_id");
        $this->db->join("lp_global_store f","f.store_id = a.store_id");
        $this->db->order_by("a.order_datetime","desc");
        $result = $this->db->get()->result_array()[0]['count'];

        return $result;
    }

    function export_offline_order($province,$city,$storeName,$pgName,$orderDate,$isScan){
        if($province != ''){
            $this->db->where("e.province",$province);
        }
        if($city != ''){
            $this->db->where("e.city",$city);
        }
        if($storeName != ''){
            $this->db->where("f.store_name",$storeName);
        }
        if($pgName != ''){
            $this->db->where("e.name",$pgName);
        }
        if($orderDate != ''){
            $endTime = date('Y-m-d H:i:s',strtotime($orderDate)+86400);
            $this->db->where("a.order_datetime between "."'$orderDate'"." and "."'$endTime'");
        }
        if($isScan != ''){
            $this->db->where("a.is_scan_qrcode",$isScan);
        }

        $this->db->select("a.order_code, a.order_datetime, a.scan_datetime, b.product_num, c.name, c.title as pTitle, d.spec_name, f.province, f.city, e.wechat_id, e.name as username, e.phone, f.store_name");
        $this->db->from("lp_order_offline a");
        $this->db->join("lp_order_offline_detail b","b.order_code = a.order_code");
        $this->db->join("lp_product_info c","c.id = b.product_id");
        $this->db->join("lp_global_specification d","d.spec_id = b.spec_id");
        $this->db->join("lp_customer_info e","e.id = a.customer_id");
        $this->db->join("lp_global_store f","f.store_id = a.store_id");
        $this->db->order_by("a.order_datetime","desc");
        $result = $this->db->get()->result_array();

        $data = array();
        //$i = 0;
        foreach($result as $val){
            if($data[$val['order_code']]){
                $data[$val['order_code']]['detail'] .= ','. $val['name'].'|'.$val['spec_name'].'|'.$val['product_num'].'瓶';
            }else{
                $item = array();
                $item['detail'] = $val['name'].'|'.$val['spec_name'].'|'.$val['product_num'].'瓶';
                $item['order_code'] = $val['order_code'];
                $item['address'] = $val['province'].'/'.$val['city'];
                $item['store'] = $val['store_name'];
                $item['wechat_id'] = $val['wechat_id'];
                $item['order_datetime'] = $val['order_datetime'];
                $item['scan_datetime'] = $val['scan_datetime'];
                $item['contact'] = $val['username'].'|'.$val['phone'];
                $data[$val['order_code']] = $item;
                //$i++;
            }
        }
        $returnData = array();
        foreach($data as $key => $item){
            $returnData[] = $item;
        }

        return $returnData;

    }
}