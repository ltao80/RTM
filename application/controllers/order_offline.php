<?php
class Order_offline extends CI_Controller {
	function __construct() {
		parent::__construct();
		$this->output->set_header('Content-Type: application/json; charset=utf8');
	}
	
	function get_orders() {
		$openId = $this->input->get("openId");
		$user = $this->pg_user_model->get_user_by_openid($openId);
		$pageIndex = $this->input->get('pageIndex');
		$pageSize = $this->input->get('pageSize');
		$detail = $this->input->get('detail');
		$pageIndex = $pageIndex ? intval($pageIndex) : 1;
		$pageSize = $pageSize ? intval($pageSize) : 10;
		$detail = $detail ? ($detail == 'true' ? true : false) : true;
		$orders = [];
		if($user && $user->store_id) {
			$orders = $this->order_offline_model->get_orders($user->store_id, $pageIndex, $pageSize, $detail);
		}
		
		$this->output->set_output(json_encode($orders));
	}
	
	function get_order() {
		$openId = $this->input->get('openId');
		$orderCode = $this->input->get('orderCode');
		
		$user = $this->pg_user_model->get_user_by_openid($openId);
		$order = new stdClass();
		if($user && $user->store_id) {
			$order = $this->order_offline_model->get_order($user->store_id, $orderCode);
		}
		
		$this->output->set_output(json_encode($order));
	}
	
	function find_order_by_receipt() {
		$openId = $this->input->post('openId');
		$receiptId = $this->input->post('receiptId');
		$user = $this->pg_user_model->get_user_by_openid($openId);
		
		$order = new stdClass();
		if($user && $user->store_id) {
			$order = $this->order_offline_model->find_order_by_receipt($user->store_id, $receiptId);
		}
		
		$this->output->set_output(json_encode($order));
	}
	
	function _generate_qrcode($orderCode) {
		//TODO: generate QRCode with WeChat API.
		
		//return temporary QRCode for user
		return "https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket=gQEV7zoAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xL21rTnNnMWZsMHFxckZ3bkdvRzlOAAIEW3YcVQMEAAAAAA==";
	}
	
	function save_receipt() {
		$orderCode = $this->input->post("orderCode");
		$receiptId = $this->input->post("receiptId");
		
		$this->order_offline_model->save_receipt($orderCode, $receiptId);
		
		$this->output->set_output(json_encode(array("success"=>true)));
	}
	
	function generate_qrcode() {
		$orderCode = $this->input->post('orderCode');
		
		$QRCodeImage = $this->_generate_qrcode($orderCode);
		
		$this->order_offline_model->update_qrcode_info($orderCode);
		
		$this->output->set_output(json_encode(array("success"=>true, "data" => array("qrcode"=>$QRCodeImage, "order_code" => $orderCode))));
	}
	
	function is_scanned() {
		$orderCode = $this->input->get('orderCode');
		$result = $this->order_offline_model->is_scanned($orderCode);
		
		$this->output->set_output(json_encode(array("success"=>true, "data" => $result)));
	}
	
	function save_order() {
		$this->load->helper('common');
		$openId = $this->input->post('openId');
		$details = $this->input->post('details');
		$isGenerateQRCode = $this->input->post("isGenerateQRCode");
		
		
		$orderCode = generate_order_code();
		
		if($isGenerateQRCode == "1") {
			$QRCodeImage = $this->_generate_qrcode($orderCode);
		}
		
		$details = json_decode($details);
		if(count($details) > 0) {
			$user = $this->pg_user_model->get_user_by_openid($openId);
			if($user && $user->store_id) {
				$this->order_offline_model->save_order($orderCode, $user->store_id, $user->id, $details, $isGenerateQRCode);
				$result = array(
						"success"=>true, 
						"data" => array(
								"order_code" => $orderCode
						)
				);
				if($isGenerateQRCode == "1") {
					$result["data"]["qrcode"] = $QRCodeImage;
				}
				$this->output->set_output(json_encode($result));
			} else {
				$this->output->set_output(json_encode(array("success"=>false, "error"=>"OpenID is unavaible.")));
			}
		} else {
			$this->output->set_output(json_encode(array("success"=>false, "error"=>"Please enter order details.")));
		}
	}
}