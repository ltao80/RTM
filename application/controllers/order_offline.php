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
		$orders = array();
		if($user && $user->store_id) {
			$order = $this->order_offline_model->get_orders_promationId($user->id, $pageIndex, $pageSize, $detail);
            array_push($orders, $order);
		}

        $total_score = $this->order_offline_model->get_order_score_by_storeId($user->id);
		$this->output->set_output(json_encode(array("data" => $orders,"sum_score" => $total_score)));
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
        $platId = $this->config->item("platId");
        return createTempQrcode($platId, $orderCode);
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
	
	function save_order_qrcode() {
		$this->load->helper('common');
		$openId = $this->input->post('openId');
		$details = $this->input->post('details');
		$isGenerateQRCode = $this->input->post("isGenerateQRCode");

		$sceneId = generate_scene_id();
		$orderCode = generate_order_code();
		
		if($isGenerateQRCode == "1") {
			$qrcode = $this->_generate_qrcode($sceneId);
		}
		
		$details = json_decode($details);
		if(count($details) > 0) {
			$user = $this->pg_user_model->get_user_by_openid($openId);
			if($user && $user->store_id) {
				$this->order_offline_model->save_order($orderCode, $user->store_id, $user->id, $details, $isGenerateQRCode, $sceneId);
                $qrcodeImg = json_decode($qrcode, true);
                $this->output->set_output(json_encode(array("success" => true, "ticket" => "https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket=".$qrcodeImg['ticket'], "order_code" => $orderCode)));
			} else {
				$this->output->set_output(json_encode(array("success"=>false, "error"=>"OpenID is unavaible.")));
			}
		} else {
			$this->output->set_output(json_encode(array("success"=>false, "error"=>"Please enter order details.")));
		}
	}

    function save_order() {
        $this->load->helper('common');
        $openId = $this->input->post('openId');
        $details = $this->input->post('details');
        $isGenerateQRCode = $this->input->post("isGenerateQRCode");
		$sceneId = "";
        $orderCode = generate_order_code();
        $details = json_decode($details);
        if(count($details) > 0) {
            $user = $this->pg_user_model->get_user_by_openid($openId);
            if($user && $user->store_id) {
                $this->order_offline_model->save_order($orderCode, $user->store_id, $user->id, $details, $isGenerateQRCode, $sceneId);
                $result = array(
                    "success"=>true,
                    "data" => array(
                        "order_code" => $orderCode
                    )
                );
                $this->output->set_output(json_encode($result));

            } else {
                $this->output->set_output(json_encode(array("success"=>false, "error"=>"OpenID is unavaible.")));
            }
        } else {
            $this->output->set_output(json_encode(array("success"=>false, "error"=>"Please enter order details.")));
        }
    }
}