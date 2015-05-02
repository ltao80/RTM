<?php
class Pg_user extends CI_Controller {
	function __construct() {
		parent::__construct();
		$this->output->set_header('Content-Type: application/json; charset=utf8');
	}
	function verify() {
		$this->load->helper('url');
		$openId = $this->input->get("openId");
		if(!$openId) {
			echo "Error";
		} else {
			$status = $this->pg_user_model->verify($openId);
			redirect("/pg_index?verifyStatus=$status&openId=$openId");	
		}
	}
	
	function confirm_user() {
		$this->load->helper('string');
		$openId = $this->input->post("openId");
		$province = $this->input->post("province");
		$city = $this->input->post("city");
		$store = $this->input->post("store");
		$name = $this->input->post("name");
		$phone = $this->input->post("phone");
		$email = $this->input->post("email");
		$passwordType = $this->config->config["password_type"];
		$passwordLength = $this->config->config["password_length"];
		$password = random_string($passwordType, $passwordLength);
		
		$result = $this->pg_user_model->confirm_user($openId, $province, $city, $store, $name, $phone, $email, $password);
		
		if($result) {
            $platId = $this->config->item("platId");
            $msg = "您的密码为:".$password .", 请妥善保管, 谢谢!";
            Wechat::sendCustomerMessageByOpenId($platId, $openId, $msg);
			$this->output->set_output(json_encode(array("success"=>true, "password"=>$password)));
		} else {
			$this->output->set_output(json_encode(array("success"=>false)));
		}
	}
	
	function confirm_change() {
		$openId = $this->input->post('openId');
		
		$this->pg_user_model->confirm_change($openId);
		
		$this->output->set_output(json_encode(array("success"=>true)));
	}
	
	function signin() {
		$openId = $this->input->post("openId");
		$password = $this->input->post("password");
		
		$result = $this->pg_user_model->signin($openId, $password);
		
		$this->output->set_output(json_encode($result));
	}
}