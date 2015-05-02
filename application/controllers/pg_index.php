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

    function find_order_by_receipt() {
        $storeId = $this->input->post("storeId");
        $receiptId = $this->input->post("receiptId");
        $data = $this->order_offline_model->find_order_by_receipt($storeId, $receiptId);
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
        /**
         * the output data formt:
         * {"ticket":"gQH47joAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xL2taZ2Z3TVRtNzJXV1Brb3ZhYmJJAAIEZ23sUwMEmm3sUw==",
         * "expire_seconds":60,
         * "url":"http:\/\/weixin.qq.com\/q\/kZgfwMTm72WWPkovabbI"}
         * the front-end can use the url to display it
         */
        $platId = $this->config->item("platId");
        $orderId = $this->input->post('orderId');
        $result = createTempQrcode($platId, $orderId);
        $this->output->set_output($result);
    }

    function save_receipt() {
        $receiptId = $this->config->item("receiptId");
        $orderCode = $this->input->post("orderCode");
        $result = $this->order_offline_model->save_receipt($orderCode, $receiptId);
        $this->output->set_output(json_decode(array("success" => $result)));
    }

    function history() {
        /*$openId = $this->input->get("openId");
        $user = $this->pg_user_model->get_user_by_openid($openId);
        $pageIndex = $this->input->get('pageIndex');
        $pageSize = $this->input->get('pageSize');
        $detail = $this->input->get('detail');
        $pageIndex = $pageIndex ? intval($pageIndex) : 1;
        $pageSize = $pageSize ? intval($pageSize) : 10;
        $detail = $detail ? ($detail == 'true' ? true : false) : true;
        if($user && $user->store_id) {
            $sum_score = 0;
            $orders = $this->order_offline_model->get_orders_promationId($user->id, $pageIndex, $pageSize, $detail);
            foreach($orders as $order) {
                $sum_score = $sum_score + $order->total_score;
            }
        }*/
        $this->load->view("pg/history");
    }

    function order_confirm() {
		$this->load->view("pg/order_confirm");
	}
}