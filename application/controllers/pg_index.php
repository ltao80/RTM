<?php
class Pg_index extends CI_Controller {
	function index() {
		$this->load->view('pg_index');
	}
	
	function products() {
		$products = $this->product_model->get_products();
		$data = array("products" => $products);
		$this->load->view("pg/products", $data);
	}
	
	function confirm_user() {
		
	}
	
	function signin() {
		
	}
	
	function regenerate_qrcode() {
		
	}
}