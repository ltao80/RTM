<?php
class Pg_index extends CI_Controller {
	function index() {
		$this->load->view('pg/pg_index');
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
	
	function regenerate_qrcode() {
		$this->load->view("pg/qrcode");
	}

	function qrcode_success() {
		$this->load->view("pg/qr_success");
	}

	function history() {
		$this->load->view("pg/history");
    }

    function order_confirm() {
		$this->load->view("pg/order_confirm");
	}

	function search_detail() {
		$this->load->view("pg/search-detail");
	}
}