<?php
class Product_Model extends CI_Model {
	
	/**
	 * Get products
	 * 
	 * @param string $condition
	 * @return array
	 */
	function get_products($condition = null) {
		$query = $this->db->query("SELECT pi.*, pim.image_url FROM rtm_product_info pi LEFT JOIN rtm_product_images pim ON pi.id = pim.product_id $condition");
		
		$products = array();
		if($query->num_rows() > 0) {
			foreach($query->result() as $product) {
				$id = $product->id;
				$product->specifications = $this->get_product_specification($id);
				array_push($products, $product);
			}
		}
		
		return $products;
	}
	
	/**
	 * Get specifications of one product
	 * 
	 * @param integer $product_id
	 * @return array
	 */
	function get_product_specification($product_id) {
		$query = $this->db->query("SELECT gs.spec_id, gs.spec_name, ps.score, ps.stock_num, ps.exchange_num, ps.is_for_exchange FROM rtm_product_specification ps INNER JOIN rtm_global_specification gs ON ps.spec_id = gs.spec_id WHERE ps.product_id = $product_id");
		
		$specifications = array();
		if($query->num_rows() > 0) {
			foreach($query->result() as $specification) {
				array_push($specifications, $specification);
			}
		}
		
		return $specifications;
	}

    /**
     * get product detail info list by ids
     * include image and specification
     * @see rtm_product_image
     * @see rtm_product_specification
     * @param $product_ids
     */
    function get_product_list($product_ids){
    	$ids = explode(",", $product_ids);
    	if(count($ids) > 0) {
    		$newIds  = array();
    		foreach($ids as $id) {
    			if(intval($id) > 0) {
    				array_push($newIds, intval($id));
    			}
    		}
    		if(count($newIds) > 0) {
    			$condition = "WHERE pi.id IN(" . implode(",", $newIds) . ")";
    			return $this->get_products($condition);
    		}
    		
    		
    	}
    	
    	return array();
    }

}
