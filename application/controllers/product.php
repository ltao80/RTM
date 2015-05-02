<?php
class Product extends CI_Controller {
    function __construct() {
        parent::__construct();

    }

	function get_products() {
		$ids = $this->input->get('ids');
		$products = array();
		if($ids) {
			$products = $this->product_model->get_product_list($ids);
		} else {
			$products = $this->product_model->get_products();
		}

        echo json_encode($products);
	}

    public function get_product_json($id) {
        $this->output->set_header('Content-Type: application/json; charset=utf8');
        if(!empty($id)){
            $products = $this->product_model->get_product_by_id($id);
            echo json_encode($products);
        }
    }

    public function get_product_view($id){
        $this->output->set_header('Content-Type: text/html; charset=utf8');
        if(!empty($id)){
            $products = $this->product_model->get_product_by_id($id);
            $data['product_info'] = $products;
            $this->load->view('shopping/product-detail.php', $data);
        }
    }
}

