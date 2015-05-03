<?php
class Pg_index extends CI_Controller {
	function index() {
		$data = array("version" => $this->config["static_version"]);
		$this->load->view('pg/pg_index', $data);
	}
	
	function products() {
		$products = $this->product_model->get_products();
		$data = array("products" => $products);
		$this->load->view("pg/products", $data);
	}
	
	function confirm_user() {
		$provinces = $this->global_model->get_provinces();
		$data = array("provinces" => $provinces);
		$this->load->view("pg/confirm_user", $data);
	}
	
	function signin() {
		$this->load->view("pg/signin");
	}
	
	function search_order() {
		$this->load->view("pg/search_order");
	}

    function find_order_by_receipt() {
        $openId = $this->input->post("openId");
        $receiptId = $this->input->post("receiptId");
        $user = $this->pg_user_model->get_user_by_openid($openId);
        $data = $this->order_offline_model->find_order_by_receipt($user->store_id, $receiptId);
        $this->load->view("pg/find_order_by_receipt", $data);
    }

    function find_order_by_store() {
        $storeId = $this->input->post("storeId");
        $pageIndex  = $this->input->post("pageIndex");
        $pageSize  = $this->input->post("pageSize");
        $data = $this->order_offline_model->get_orders($storeId, $pageIndex, $pageSize, true);
        $this->load->view("pg/find_order_by_store", $data);
    }

    function regenerate_qrcode() {
        $this->load->view("pg/qrcode");
    }

    function save_receipt() {
        $receiptId = $this->input->post("receiptId");
        $orderCode = $this->input->post("orderCode");
        $result = $this->order_offline_model->save_receipt($orderCode, $receiptId);
        $this->output->set_output(json_encode(array("success" => true, "data" => $result)));
    }

    function history() {
        $this->load->view("pg/history");
    }

    function receipt(){
        $this->load->view("pg/save_receipt");
    }

    function order_confirm() {
		$this->load->view("pg/order_confirm");
	}
	
	function qrcode_success() {
		$this->load->view("pg/qr_success");
	}
	
	function search_detail() {
		$orderCode = $this->input->get('orderCode');
		$openId = $this->input->get('openId');
		$user = $this->pg_user_model->get_user_by_openid($openId);
		$product = $this->order_offline_model->get_order($user->store_id, $orderCode);
		
		$this->load->view("pg/search-detail", array("order"=>$product));
	}
}