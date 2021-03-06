<?php
class Order_offline_Model extends CI_Model {

    /**
     * 获取列表
     *
     * @param number $pageIndex
     * @param number $pageSize
     * @param string $detail
     * @return multitype:
     */
    function get_order_score_by_promotionId($promationId) {
        $query = $this->db->query("SELECT * FROM rtm_order_offline WHERE is_scan_qrcode = 1 AND promotion_id = $promationId");
        $sum_socore = 0;
        if($query->num_rows() > 0) {
            foreach($query->result() as $order) {
                $sum_socore += $order->total_score;
            }
        }
        return $sum_socore;
    }

    /**
     * 获取列表
     *
     * @param number $pageIndex
     * @param number $pageSize
     * @param string $detail
     * @return multitype:
     */
    function get_orders_promationId($promationId, $pageIndex = 1, $pageSize = 10, $detail = true) {
        $startIndex = ($pageIndex - 1) * $pageSize;

        $query = $this->db->query("SELECT * FROM rtm_order_offline WHERE is_scan_qrcode = 1 AND promotion_id = $promationId order by order_datetime DESC LIMIT $startIndex, $pageSize");

        $orders = array();
        $sum_score = 0;
        if($query->num_rows() > 0) {
            foreach($query->result() as $order) {
                if($detail) {
                    $order->details = $this->get_order_detail($order->order_code);
                }
                array_push($orders, $order);
            }
        }

        return $orders;
    }

    function get_order_detail1($orderCode) {
        $query = $this->db->query("SELECT ood.*, p.*, spec.spec_name FROM rtm_order_offline_detail ood left join rtm_product_info p on p.id = ood.product_id left JOIN rtm_global_specification spec on ood.spec_id = spec.spec_id left JOIN rtm_product_specification ps on p.id = ps.product_id WHERE ood.order_code ='$orderCode' and ps.is_for_exchange = 0");

        $details = array();
        if($query->num_rows() > 0) {
            foreach($query->result_array() as $detail) {
                array_push($details, $detail);
            }
        }

        return $details;
    }

    /**
     * get product list for order detail by order_code
     * @param $order_code
     */
    public function get_order_detail($order_code){
        $this->db->select('rtm_product_info.*,rtm_order_offline_detail.product_num,rtm_product_images.image_url,rtm_product_specification.score,rtm_global_specification.spec_name,rtm_order_offline_detail.spec_id');
        $this->db->from('rtm_order_offline_detail');
        $this->db->join('rtm_global_specification', 'rtm_order_offline_detail.spec_id = rtm_global_specification.spec_id','inner');
        $this->db->join("rtm_product_info","rtm_product_info.id = rtm_order_offline_detail.product_id",'inner');
        $this->db->join("rtm_product_specification","rtm_product_specification.product_id = rtm_order_offline_detail.product_id and rtm_product_specification.spec_id = rtm_order_offline_detail.spec_id","inner");
        $this->db->join("rtm_product_images","rtm_product_images.product_id = rtm_product_info.id","left");
        $this->db->where('rtm_order_offline_detail.order_code',$order_code);
        $this->db->order_by("rtm_order_offline_detail.product_id");
        return $this->db->get()->result_array();
    }

	function get_order($storeId, $orderCode) {
		$query = $this->db->query("SELECT * FROM rtm_order_offline WHERE order_code = '$orderCode' AND store_id = $storeId ");
		
		$order = new stdClass();
		if($query->num_rows() > 0) {
			$order = $query->next_row();
			$order->details = $this->get_order_detail($orderCode);
		}
		
		return $order;
	}

	function find_order_by_receipt($storeId, $receiptId) {
		$query = $this->db->query("SELECT * FROM rtm_order_offline WHERE receipt_id='$receiptId' AND store_id = $storeId");
		
		$order = new stdClass();
		if($query->num_rows() > 0) {
			$order = $query->next_row();
			$order->details = $this->get_order_detail($order->order_code);
		}
		
		return $order;
	}
	
	function save_receipt($orderCode, $receiptId) {
		
		$query = $this->db->query("SELECT * FROM rtm_order_offline WHERE receipt_id = '$receiptId'");
		if($query->num_rows() > 0) {
			return false;
		} else { 
			$this->db->query("UPDATE rtm_order_offline SET receipt_id = '$receiptId' WHERE order_code = '$orderCode'");
			return true;
		}
	}
	
	function update_qrcode_info($orderCode, $sceneId) {
		$this->db->query("UPDATE rtm_order_offline SET is_generate_qrcode = 1, scene_id = '$sceneId', generate_datetime = NOW(), is_scan_qrcode = 0, scan_datetime = NULL WHERE order_code = '$orderCode'");
	}
	
	function is_scanned($orderCode) {
		$query = $this->db->query("SELECT is_scan_qrcode FROM rtm_order_offline WHERE order_code = '$orderCode' and is_scan_qrcode = 1");
		if($query->num_rows() > 0) {
			$result = $query->next_row();
			
			return ($result->is_scan_qrcode == 1);
		}
		
		return false;
	}
	
	function save_order($orderCode, $storeId, $promotionId, $details, $isGenerateQRCode, $sceneId) {
		$this->db->trans_start();
		$totalScore = 0;
		for($i = 0; $i < count($details); $i++) {
			$totalScore += ($details[$i]->score ? $details[$i]->score : 0) * ($details[$i]->count ? $details[$i]->count : 0);
		}
		$FIELDS = "INSERT INTO rtm_order_offline(order_code, store_id, promotion_id, is_scan_qrcode, order_datetime, scene_id, total_score, is_generate_qrcode" . ($isGenerateQRCode == 1 ? ",generate_datetime" : "") . ")";
		$VALUES = " VALUES('$orderCode', $storeId, $promotionId, 0, NOW(), '$sceneId', $totalScore, $isGenerateQRCode" . ($isGenerateQRCode == 1 ? ",NOW()" : "") . ")"; 


		$this->db->query("$FIELDS $VALUES");
		
		foreach($details as $detail) {
			$this->db->query("INSERT rtm_order_offline_detail(order_code, product_id, spec_id, product_num) VALUES('$orderCode', {$detail->product_id}, {$detail->spec_id}, {$detail->count})");
		}
		
		$this->db->trans_complete();
	}

    /**
     * 当用户扫描临时二维码成功后回调，主要是注册 customer 和 更新 rtm_customer_score_list
     *
     * @param $order_code
     * @param $wechat_id
     */
    function scan_qrcode_callback($order_code,$wechat_id){
        $order_type = 2;
        $query = $this->db->query("SELECT * FROM rtm_order_offline WHERE order_code = '$order_code'");
        if($query->num_rows() > 0) {
        	$order = $query->next_row();
        	if($order->is_scan_qrcode == 1) {
        		return 0;
        	}
        } else {
        	return 0;
        }
        $this->db->where("order_code",$order_code);
        $this->db->select("order_code,customer_id, store_id,total_score,order_datetime");
        $produce_score_result = $this->db->get("rtm_order_offline")->result_array();
        $total_score = 0;//形成本次订单的积分
        $sum_score = 0;//用户总积分
        foreach($produce_score_result as $item){
            $total_score += $item["total_score"];
        }

        $this->db->trans_start();
        $query = $this->db->query("SELECT * FROM rtm_customer_info WHERE wechat_id = '$wechat_id'");
        if($query->num_rows() > 0) {
        	$customer = $query->next_row();
        	$customerId = $customer->id;
            $sum_score = $customer->total_score + $total_score;
        	$this->db->query("UPDATE rtm_customer_info SET total_score = total_score +  $total_score  WHERE id = $customerId");
        } else {
            $customer_info = array(
                'name' => '',
                'address' => '',
                'phone' => '',
                'email' => '',
                'birthday' => '',
                'wechat_id' => $wechat_id,
                'total_score' => $total_score
            );
        	$this->db->insert("rtm_customer_info",$customer_info);
        	$customerId = $this->db->insert_id();
        	$this->db->query("UPDATE rtm_customer_info SET total_score =  $total_score  WHERE id = $customerId");
        }

        foreach($produce_score_result as $product) {
            $product['order_type'] = $order_type;
            if(is_null($product['customer_id'])){
                $product['customer_id'] = $customerId;
            }
            log_message("info","get the text post xml:" .var_export($product,true));
            $this->db->insert("rtm_customer_score_list", $product);
        }
        $this->db->query("UPDATE rtm_order_offline SET is_scan_qrcode = 1, scan_datetime = NOW(), customer_id = $customerId, scene_id = NULL WHERE order_code = '$order_code'");
        $this->db->trans_complete();
        log_message("info","total score:" .$total_score);
        return json_encode(array("total_score" =>$total_score, "sum_score" => $sum_score));
    }

    
    /**
     * If generated scene id exists
     * 
     * @param unknown $sceneId
     * @return boolean
     */
    public function is_scene_id_exists($sceneId) {
    	$query = $this->db->query("SELECT * FROM rtm_order_offline WHERE scene_id = '$sceneId'");
    	if($query->num_rows() > 0) {
    		return true;
    	} else {
    		return false;
    	}
    }
    
    public function get_order_code_by_scene_id($sceneId) {
    	$query = $this->db->query("SELECT * FROM rtm_order_offline WHERE scene_id = '$sceneId' order by order_code desc limit 1 ");
    	if($query->num_rows() > 0) {
    		$order = $query->next_row();
    		return $order->order_code;
    	} else {
    		return null;
    	}
    }
}