<?php
class Product extends CI_Controller {
	
	function get_products() {
		$ids = $this->input->get('ids');
		$products = array();
		if($ids) {
			$products = $this->product_model->get_product_list($ids);
		} else {
			$products = $this->product_model->get_products();
		}
		
		$this->output->set_output(json_encode($products));
	}

    public function detail($id) {

        if(!empty($id)){

            $products = $this->product_model->get_product_by_id($id);
            $this->load->view('shopping/product_detail.php', $products);
        }

    }
}

