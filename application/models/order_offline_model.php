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
    function get_orders_promationId($promationId, $pageIndex = 1, $pageSize = 10, $detail = true) {
        $startIndex = ($pageIndex - 1) * $pageSize;
        $query = $this->db->query("SELECT * FROM rtm_order_offline WHERE promotion_id = $promationId LIMIT $startIndex, $pageSize");

        $orders = array();
        if($query->num_rows() > 0) {
            foreach($query->result() as $order) {
                if($detail) {
                    $order->details = $this->get_order_detail2($order->order_code);
                }
                array_push($orders, $order);
            }
        }

        return $orders;
    }

	/**
	 * 获取列表
	 * 
	 * @param number $pageIndex
	 * @param number $pageSize
	 * @param string $detail
	 * @return multitype:
	 */
	function get_orders($storeId, $pageIndex = 1, $pageSize = 10, $detail = true) {
		$startIndex = ($pageIndex - 1) * $pageSize;
		$query = $this->db->query("SELECT * FROM rtm_order_offline WHERE store_id = $storeId LIMIT $startIndex, $pageSize");
		
		$orders = array();
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
	
	function get_order_detail($orderCode) {
		$query = $this->db->query("SELECT pi.*, ood.product_num, pim.image_url, gs.spec_id, gs.spec_name, ps.score FROM rtm_order_offline_detail ood INNER JOIN rtm_product_info pi ON ood.product_id = pi.id INNER JOIN rtm_global_specification gs ON ood.spec_id = gs.spec_id INNER JOIN rtm_product_specification ps ON ood.spec_id = ps.spec_id LEFT JOIN rtm_product_images pim ON pi.id = pim.product_id WHERE ood.order_code ='$orderCode'");
		
		$details = array();
		if($query->num_rows() > 0) {
			foreach($query->result() as $detail) {
				array_push($details, $detail);
			}
		}
		
		return $details;
	}

	function get_order($storeId, $orderCode) {
		$query = $this->db->query("SELECT * FROM rtm_order_offline WHERE order_code = '$orderCode' AND store_id = $storeId");
		
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
		return $this->db->query("UPDATE rtm_order_offline SET receipt_id = '$receiptId' WHERE order_code = '$orderCode'");
	}
	
	function update_qrcode_info($orderCode) {
		$this->db->query("UPDATE rtm_order_offline SET is_generate_qrcode = 1, generate_datetime = NOW(), is_scan_qrcode = 0, scan_datetime = NULL WHERE order_code = '$orderCode'");
	}
	
	function is_scanned($orderCode) {
		$query = $this->db->query("SELECT is_scan_qrcode FROM rtm_order_offline WHERE order_code = '$orderCode'");
		if($query->num_rows() > 0) {
			$result = $query->next_row();
			
			return ($result->is_scan_qrcode == 1);
		}
		
		return false;
	}
	
	function save_order($orderCode, $storeId, $promotionId, $details, $isGenerateQRCode) {
		$this->db->trans_start();
		$totalScore = 0;
		for($i = 0; $i < count($details); $i++) {
			$totalScore += ($details[$i]->score ? $details[$i]->score : 0) * ($details[$i]->count ? $details[$i]->count : 0);
		}
		$FIELDS = "INSERT INTO rtm_order_offline(order_code, store_id, promotion_id, is_scan_qrcode, is_generate_qrcode, total_score" . ($isGenerateQRCode == 1 ? ",generate_datetime" : "") . ")";
		$VALUES = " VALUES('$orderCode', $storeId, $promotionId, 0, $isGenerateQRCode, $totalScore" . ($isGenerateQRCode == 1 ? ",NOW()" : "") . ")"; 
		
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
        $this->db->where("order_code",$order_code);
        $this->db->select("order_code,customer_id, store_id,total_score,order_datetime");
        $produce_score_result = $this->db->get("rtm_order_offline")->result_array();
        $total_score = 0;
        //形成本次订单的积分
        foreach($produce_score_result as $item){
            $total_score += $item["total_score"];
        }

        $customer_info = array(
            'name' => '',
            'address' => '',
            'phone' => '',
            'email' => '',
            'birthday' => '',
            'wechat_id' => $wechat_id,
            'total_score' => $total_score
        );

        $this->db->trans_start();
        $this->db->insert("rtm_customer_info",$customer_info);
        foreach($produce_score_result as $product) {
            $product['order_type'] = $order_type;
            $this->db->insert("rtm_customer_score_list", $product);
        }
        $this->db->trans_complete();
        return $total_score;
    }

    /**
     * get product list for order detail by order_code
     * @param $order_code
     */
    public function get_order_detail2($order_code){
        $this->db->where('rtm_order_offline.order_code',$order_code);
        $this->db->select('rtm_order_offline_detail.product_num,rtm_product_info.name,rtm_product_specification.score,rtm_global_specification.spec_name');
        $this->db->from('rtm_order_offline');
        $this->db->join("rtm_order_offline_detail","rtm_order_offline.order_code = rtm_order_offline_detail.order_code");
        $this->db->join('rtm_global_specification', 'rtm_order_offline_detail.spec_id = rtm_global_specification.spec_id');
        $this->db->join("rtm_product_info","rtm_product_info.id = rtm_order_offline_detail.product_id");
        $this->db->join("rtm_product_specification","rtm_product_specification.product_id = rtm_product_info.id");
        $this->db->join("rtm_product_images","rtm_product_images.product_id = rtm_product_info.id");
        $this->db->group_by("rtm_order_offline_detail.product_id");
        $this->db->get()->result_array();
    }
}