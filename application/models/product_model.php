<?php
class Product_Model extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->helper('common');
    }


    /**
	 * Get products
	 * 
	 * @param string $condition
     * @param int $is_for_exchange
	 * @return array
	 */
	function get_products($condition = null,$is_for_exchange = 0) {
		$query = $this->db->query("SELECT pi.*, pim.image_url FROM lp_product_info pi LEFT JOIN lp_product_images pim ON pi.id = pim.product_id  $condition");
		
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
        $this->db->from('lp_product_info');
        $this->db->join("lp_product_images","lp_product_info.id = lp_product_images.product_id");
        $this->db->where("lp_product_info.id",$product_id);
        $this->db->group_by('lp_product_info.id');
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
		$query = $this->db->query("SELECT gs.spec_id, gs.spec_name, ps.score, ps.stock_num, ps.exchange_num, ps.is_for_exchange FROM lp_product_specification ps INNER JOIN lp_global_specification gs ON ps.spec_id = gs.spec_id WHERE ps.product_id = $product_id");
		
		$specifications = array();
		if($query->num_rows() > 0) {
			foreach($query->result() as $specification) {
				array_push($specifications, $specification);
			}
		}
		
		return $specifications;
	}

    function get_product_specification_list($product_id){
        $this->db->select('lp_global_specification.spec_name,lp_product_specification.spec_id,lp_product_specification.score,lp_product_specification.stock_num,lp_product_specification.exchange_num');
        $this->db->from('lp_product_info');
        $this->db->join("lp_product_specification","lp_product_specification.product_id = lp_product_info.id");
        $this->db->join('lp_global_specification', 'lp_product_specification.spec_id = lp_global_specification.spec_id');
        $this->db->join('lp_product_images', 'lp_product_info.id = lp_product_images.product_id');
        $this->db->where("lp_product_info.id", $product_id);
        return  $this->db->get()->result_array();
    }

    /**
     * get product detail info list by ids
     * include image and specification
     * @see lp_product_image
     * @see lp_product_specification
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
        $this->db->from('lp_product_info');
        $this->db->join("lp_product_specification","lp_product_specification.product_id = lp_product_info.id");
        $this->db->join('lp_global_specification', 'lp_product_specification.spec_id = lp_global_specification.spec_id');
        $this->db->join('lp_product_images', 'lp_product_info.id = lp_product_images.product_id');
        $this->db->group_by('lp_product_info.id');
        $this->db->having('is_for_exchange',1);
        return  $this->db->get()->result_array();
    }

    function get_product_for_offline(){
        $this->db->select('*');
        $this->db->from('lp_product_info');
        $this->db->join("lp_product_specification","lp_product_specification.product_id = lp_product_info.id");
        $this->db->join('lp_global_specification', 'lp_product_specification.spec_id = lp_global_specification.spec_id');
        $this->db->join('lp_product_images', 'lp_product_info.id = lp_product_images.product_id');
        $this->db->group_by('lp_product_info.id');
        $this->db->having('is_for_exchange',0);
        return  $this->db->get()->result_array();
    }


    function get_exchange_list($type,$status,$pageIndex,$pageSize){
        log_message("info,","type is:".$type."status is:".$status);
        if($type != ''){
            $this->db->where("a.category_id",$type);
        }
        if($status != ''){
            $this->db->where("b.status",$status);
        }
        $this->db->where("b.is_for_exchange",1);
        $this->db->select("a.name, a.title, a.created_at, b.id, b.score, b.stock_num, b.exchange_num, b.status, c.thumbnail_url, d.spec_name, e.name as category_name");
        $this->db->from("lp_product_info a");
        $this->db->join("lp_product_specification b","b.product_id = a.id");
        $this->db->join("lp_product_images c","c.product_id = a.id");
        $this->db->join("lp_global_specification d","d.spec_id = b.spec_id");
        $this->db->join("lp_product_category e","e.id = a.category_id");
        $this->db->order_by("a.created_at","desc");
        $this->db->limit($pageIndex,$pageSize);
        $result = $this->db->get()->result_array();
        $sql = $this->db->last_query();
        log_message("info,","query sql is:".$sql);
        return $result;
    }

    function count_exchange_list($type,$status){
        log_message("info,","type is:".$type."status is:".$status);
        if($type != ''){
            $this->db->where("type",$type);
        }
        if($status != ''){
            $this->db->where("status",$status);
        }
        $this->db->select("count(*) as count");
        $this->db->from("lp_product_info a");
        $this->db->join("lp_product_specification b","b.product_id = a.id");
        $this->db->join("lp_product_images c","c.product_id = a.id");
        $this->db->join("lp_global_specification d","d.spec_id = b.spec_id");
        $this->db->join("lp_product_category e","e.id = a.category_id");
        $result = $this->db->get()->result_array()[0]['count'];
        $sql = $this->db->last_query();
        log_message("info,","query sql is:".$sql);
        return $result;
    }

    function add_product($type,$name,$description,$title,$thumb_name,$image_name,$spec,$status,$isExchange){
        $this->db->trans_start();
        $lp_info = array(
            "name" => $name,
            "title" => $title,
            "description" => $description,
            "created_at" => date('Y-m-d H:i:s',time())
        );
        $res = $this->db->insert("lp_product_info",$lp_info);
        if(!$res){
            throw new Exception("Fail to add product info:".$lp_info);
            //return false;
        }
        $product_id = $this->db->insert_id();
        $lp_image = array(
            "product_id" => $product_id,
            "thumbnail_url" => $thumb_name,
            "image_url" => $image_name
        );
        $imgRes = $this->db->insert("lp_product_images",$lp_image);
        if(!$imgRes){
            return false;
        }
        $spec = json_decode($spec,true);
        foreach($spec as $item){
            $spec_info = array(
                "product_id" => $product_id,
                "spec_id" => $item['spec_id'],
                "type" => $type,
                "score" => $item['score'],
                "stock_num" => $item['stock_num'],
                "exchange_num" => $item['stock_num'],
                "is_for_exchange" => $isExchange,
                "status" => $status
            );
            $specRes = $this->db->insert("lp_product_specification",$spec_info);
            if(!$specRes){
                return false;
            }
        }

        $this->db->trans_complete();

        return $specRes;
    }

    function update_product($pId,$type,$name,$description,$title,$thumb_name,$image_name,$spec,$status,$isExchange){
        $this->db->trans_start();
        //update the info table
        $this->db->where("id",$pId);
        $pro_info = array(
            "name" => $name,
            "title" => $title,
            "description" => $description
        );
        $res = $this->db->update("lp_product_info",$pro_info);
        if(!$res){
            return false;
        }
        $this->db->where("product_id",$pId);
        $img_info = array(
            "thumbnail_url" => $thumb_name,
            "image_url" => $image_name
        );
        $imgRes = $this->db->update("lp_product_images",$img_info);
        if(!$imgRes){
            return false;
        }
        //update the spec table

        $spec = json_decode($spec,true);
        foreach($spec as $item){
            $this->db->where("id",$item['id']);
            $spec_info = array(
                "type" => $type,
                "score" => $item['score'],
                "stock_num" => $item['stock_num'],
                "exchange_num" => $item['stock_num'],
                "is_for_exchange" => $isExchange,
                "status" => $status
            );
            $specRes = $this->db->update("lp_product_specification",$spec_info);
            if(!$specRes){
                return false;
            }
        }

        $this->db->trans_complete();

        return $specRes;
    }

    function delete_product($sId){
        $this->db->where("id",$sId);
        $res = $this->db->delete("lp_product_specification");

        return $res;
    }

    function update_exchange_status($sIds,$status){
        $this->db->where("id",$sIds);
        $status = array("status" => $status);
        $res = $this->db->update("lp_product_specification",$status);

        return $res;
    }

    function get_product_by_id($pId){
        $this->db->where("b.id",$pId);
        $this->db->select("a.id as pId, b.id as sId, a.name, a.title, a.created_at, b.score, b.stock_num, b.exchange_num, b.status, c.thumbnail_url, c.image_url, d.spec_name, e.name as category_name");
        $this->db->from("lp_product_info a");
        $this->db->join("lp_product_specification b","b.product_id = a.id");
        $this->db->join("lp_product_images c","c.product_id = a.id");
        $this->db->join("lp_global_specification d","d.spec_id = b.spec_id");
        $this->db->join("lp_product_category e","e.id = a.category_id");
        $result = $this->db->get()->result_array()[0];
        $sql = $this->db->last_query();
        log_message("info,","query sql is:".$sql);
        return $result;
    }

}
