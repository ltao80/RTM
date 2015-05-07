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
             $this->db->where("a.order_datetime between "."'$datetime'"." and "."'$datetime'");
         }
        $this->db->select('f.wechat_id,f.name,f.phone,c.name,e.spec_name,b.product_num,g.receiver_province,g.receiver_city,g.receiver_region,g.receiver_address');
        $this->db->from('rtm_order_online a');
        $this->db->join('rtm_order_online_detail b','a.order_code = b.order_code');
        $this->db->join('rtm_product_info c','c.id = b.product_id');
        $this->db->join('rtm_product_specification d','d.product_id = b.product_id and d.spec_id = b.spec_id');
        $this->db->join('rtm_global_specification e','d.spec_id = e.spec_id');
        $this->db->join('rtm_customer_info f','f.id = a.customer_id');
        $this->db->join('rtm_customer_delivery_info g','a.delivery_id = g.id');
        return $this->db->limit($pageIndex,$pageSize)->get()->result_array();
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
}