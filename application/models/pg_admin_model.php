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
		$query = $this->db->query("SELECT * FROM rtm_promotion_info WHERE wechat_id = '$openId'");

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
		$query = $this->db->query("SELECT pi.id FROM rtm_promotion_info pi INNER JOIN rtm_global_store gs ON pi.store_id = gs.store_id WHERE gs.province = '$province' AND gs.city = '$city' AND gs.store_name = '$store' AND pi.name='$name' AND pi.phone='$phone'");
		if($query->num_rows()) {
			$user = $query->next_row();
			$userId = $user->id;
			$this->db->query("UPDATE rtm_promotion_info SET password='$password', wechat_id='$openId', status = 1 WHERE id = $userId");
			return true;
		} else {
			return false;
		}
	}

	function confirm_change($openId) {
		$this->db->query("UPDATE rtm_promotion_info SET status = 1 WHERE wechat_id = '$openId'");
	}

	function signin($email, $password) {
		$query = $this->db->query("SELECT * from rtm_promotion_info where email = '$email' and password = '$password' and is_admin = 1");
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
     function get_order_list_by_datetime($datetime,$pageIndex,$pageSize){
         if($datetime != ''){
             //$startTime = date(strtotime($datetime),'Y-m-d H:i:s');
             //$endTime = date(strtotime($datetime)+86400,'Y-m-d H:i:s');
             $this->db->where("a.order_datetime between "."'$datetime'"." and "."'$datetime'");
         }
        $this->db->select('a.order_code,a.delivery_order_code,a.order_datetime,f.wechat_id,f.name as username,f.phone,c.name,e.spec_name,b.product_num,g.receiver_province,g.receiver_city,g.receiver_region,g.receiver_address');
        $this->db->from('rtm_order_online a');
        $this->db->join('rtm_order_online_detail b','a.order_code = b.order_code');
        $this->db->join('rtm_product_info c','c.id = b.product_id');
        $this->db->join('rtm_product_specification d','d.product_id = b.product_id and d.spec_id = b.spec_id');
        $this->db->join('rtm_global_specification e','d.spec_id = e.spec_id');
        $this->db->join('rtm_customer_info f','f.id = a.customer_id');
        $this->db->join('rtm_customer_delivery_info g','a.delivery_id = g.id');
        $this->db->limit($pageIndex,$pageSize);
        $result = $this->db->get()->result_array();
        $data = array();
        $i = 0;
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
                $data[$i] = $item;
                $i++;
            }
        }
         $returnData = array();
         foreach($data as $key => $item){
             $returnData[$key] = $item;
         }

         return $returnData;

    }

    /**
     * count order list
     * @param $datetime
     * @return mixed
     */
    function count_order_list($datetime){
        if($datetime != ''){
            $this->db->where("a.order_datetime between "."'$datetime'"." and "."'$datetime'");
        }
        $this->db->select('count(a.order_code) as count');
        $this->db->from('rtm_order_online a');
        $this->db->join('rtm_order_online_detail b','a.order_code = b.order_code');
        $this->db->join('rtm_product_info c','c.id = b.product_id');
        $this->db->join('rtm_product_specification d','d.product_id = b.product_id and d.spec_id = b.spec_id');
        $this->db->join('rtm_global_specification e','d.spec_id = e.spec_id');
        $this->db->join('rtm_customer_info f','f.id = a.customer_id');
        $this->db->join('rtm_customer_delivery_info g','a.delivery_id = g.id');
        return $this->db->get()->result_array()[0]['count'];
    }

    function update_delivery_order_code($order_code,$delivery_code){
        $result = $this->db->query("update rtm_order_online set delivery_order_code = '$delivery_code' where order_code = '$order_code'");

        return $result;
    }

    function export_order_list($datetime,$order_code){
        $sqlWhere = '';
        if($datetime !=''){
            $sqlWhere .= " and a.order_datetime between '$datetime' and '$datetime'";
        }else if($order_code != ''){
            $sqlWhere .= " and a.order_code in ($order_code)";
        }
        $result = $this->db->query('select a.order_code,a.delivery_order_code,f.wechat_id,f.name,f.phone,c.name,e.spec_name,b.product_num,g.receiver_province,g.receiver_city,g.receiver_region,g.receiver_address from rtm_order_online a left join rtm_order_online_detail b on a.order_code = b.order_code left join rtm_product_info c on c.id = b.product_id left join rtm_product_specification d on d.product_id = b.product_id and d.spec_id = b.spec_id left join rtm_global_specification e on d.spec_id = e.spec_id left join rtm_customer_info f on f.id = a.customer_id left join rtm_customer_delivery_info g on a.delivery_id = g.id where 1=1'.$sqlWhere);

        return $result->result_array();
    }
}