<?php
/**
 * Created by PhpStorm.
 * User: richard
 * Date: 15-4-30
 * Time: 下午5:42
 */

class Userinfo extends CI_Controller {
	function verify() {
		$openId = $this->input->get('openId');
		$this->load->model("userinfo_model");
		
		$isVerified = $this->userinfo_model->is_confirmed_user($openId);
	}
	
	function confirm_userinfo() {
		$this->load->helper('url');
		redirect("/userinfo/verify");
	}
} 