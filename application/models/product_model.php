<?php
class Product_Model extends CI_Model {
	
	/**
	 * Get products
	 * 
	 * @param string $condition
     * @param int $is_for_exchange
	 * @return array
	 */
	function get_products($condition = null,$is_for_exchange = 0) {
		$query = $this->db->query("SELECT pi.*, pim.image_url FROM rtm_product_info pi LEFT JOIN rtm_product_images pim ON pi.id = pim.product_id  $condition");
		
		$products = array();
		if($query->num_rows() > 0) {
			foreach($query->result() as $product) {
				$id = $product->id;
                $specifications = $this->get_product_specification($id);
                $is_add = false;
                foreach($specifications as $spec){
                    if($spec->is_for_exchange == $is_for_exchange)
                    {
                        $is_add = true;
                        $product->specifications[] = $spec;
                    }
                }
                if($is_add){
                    $products[] = $product;
                }
			}
		}
		
		return $products;
	}

    function get_basic_product_by_id($product_id){
        $this->db->select('name,title,description,source,image_url');
        $this->db->from('rtm_product_info');
        $this->db->join("rtm_product_images","rtm_product_info.id = rtm_product_images.product_id");
        $this->db->where("rtm_product_info.id",$product_id);
        $this->db->group_by('rtm_product_info.id');
        $result = $this->db->get()->result_array();
        if(isset($result) && count($result) > 0){
            return $result[0];
        }else
            return array();
    }

    function get_product_by_id($product_id){
        $this->db->select('*');
        $this->db->from('rtm_product_info');
        $this->db->join("rtm_product_specification","rtm_product_specification.product_id = rtm_product_info.id");
        $this->db->join('rtm_global_specification', 'rtm_product_specification.spec_id = rtm_global_specification.spec_id');
        $this->db->join('rtm_product_images', 'rtm_product_info.id = rtm_product_images.product_id');
        $this->db->where("rtm_product_info.id",$product_id);
        $result = $this->db->get()->result_array();
        if(isset($result) && count($result) > 0){
            return $result[0];
        }else
            return array();
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

    function get_product_specification_list($product_id){
        $this->db->select('rtm_global_specification.spec_name,rtm_product_specification.score,rtm_product_specification.stock_num,rtm_product_specification.exchange_num');
        $this->db->from('rtm_product_info');
        $this->db->join("rtm_product_specification","rtm_product_specification.product_id = rtm_product_info.id");
        $this->db->join('rtm_global_specification', 'rtm_product_specification.spec_id = rtm_global_specification.spec_id');
        $this->db->join('rtm_product_images', 'rtm_product_info.id = rtm_product_images.product_id');
        $this->db->where("rtm_product_info.id", $product_id);
        return  $this->db->get()->result_array();
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

    /**
     *  获取用户积分对换的商品列表
     * @return mixed
     */
    function get_product_for_exchange(){
        $this->db->select('*');
        $this->db->from('rtm_product_info');
        $this->db->join("rtm_product_specification","rtm_product_specification.product_id = rtm_product_info.id");
        $this->db->join('rtm_global_specification', 'rtm_product_specification.spec_id = rtm_global_specification.spec_id');
        $this->db->join('rtm_product_images', 'rtm_product_info.id = rtm_product_images.product_id');
        $this->db->group_by('rtm_product_info.id');
        $this->db->having('is_for_exchange',1);
        return  $this->db->get()->result_array();
    }

    function get_product_for_offline(){
        $this->db->select('*');
        $this->db->from('rtm_product_info');
        $this->db->join("rtm_product_specification","rtm_product_specification.product_id = rtm_product_info.id");
        $this->db->join('rtm_global_specification', 'rtm_product_specification.spec_id = rtm_global_specification.spec_id');
        $this->db->join('rtm_product_images', 'rtm_product_info.id = rtm_product_images.product_id');
        $this->db->group_by('rtm_product_info.id');
        $this->db->having('is_for_exchange',0);
        return  $this->db->get()->result_array();
    }

}
