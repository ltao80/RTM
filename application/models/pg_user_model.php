<?php
class Pg_user_Model extends CI_Model {

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
	
	function signin($openId, $password) {
		$query = $this->db->query("SELECT pi.status, gs.province, gs.city, gs.store_name, pi.phone FROM rtm_promotion_info pi INNER JOIN rtm_global_store gs ON pi.store_id = gs.store_id WHERE pi.wechat_id = '$openId' AND pi.password = '$password'");
		if($query->num_rows() > 0) {
			$user = $query->next_row();
			$result = array("success" => true);
			if($user->status == 2) {
				$result["data"] = $user;
			}
            $current_date = date("Y-m-d",time());
            $this->db->query("update rtm_promotion_info set last_login = '$current_date' WHERE wechat_id = '$openId'");
			return $result;
		} else {
			return array("success" => false, "error" => "Password not correct!");
		}
	}
	
	function get_user_by_openid($openId) {
		$query = $this->db->query("SELECT * FROM rtm_promotion_info WHERE wechat_id = '$openId'");
		$user = null;
		if($query->num_rows() > 0) {
			$user = $query->next_row();
		}
		return $user;
	}
}