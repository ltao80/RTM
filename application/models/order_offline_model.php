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
		$query = $this->db->query("SELECT pi.*, ood.count, pim.image_url, gs.spec_id, gs.spec_name, ps.score FROM rtm_order_offline_detail ood INNER JOIN rtm_product_info pi ON ood.product_id = pi.id INNER JOIN rtm_global_specification gs ON ood.spec_id = gs.spec_id INNER JOIN rtm_product_specification ps ON ood.spec_id = ps.spec_id LEFT JOIN rtm_product_images pim ON pi.id = pim.product_id WHERE ood.order_code ='$orderCode'");
		
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
		$this->db->query("UPDATE rtm_order_offline SET receipt_id = '$receiptId' WHERE order_code = '$orderCode'");
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
		$FIELDS = "INSERT INTO rtm_order_offline(order_code, store_id, promotion_id, is_scan_qrcode, is_generate_qrcode" . ($isGenerateQRCode == 1 ? ",generate_datetime" : "") . ")";
		$VALUES = " VALUES('$orderCode', $storeId, $promotionId, 0, $isGenerateQRCode" . ($isGenerateQRCode == 1 ? ",NOW()" : "") . ")"; 
		 
		$this->db->query("$FIELDS $VALUES");
		
		foreach($details as $detail) {
			$this->db->query("INSERT rtm_order_offline_detail(order_code, product_id, spec_id, count) VALUES('$orderCode', {$detail->product_id}, {$detail->spec_id}, {$detail->count})");
		}
		
		$this->db->trans_complete();
	}
}