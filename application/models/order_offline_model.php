<?php
class Order_offline_Model extends CI_Model {
	function get_orders($pageIndex = 1, $pageSize = 10) {
		$startIndex = ($pageIndex - 1) * $pageSize;
		
		$query = $this->db->query("SELECT * FROM rtm_order_offline LIMIT $startIndex, $pageSize");
		
		
		if($query->num_rows() > 0) {
			
		}
		
	}
	
	function get_order_detail($orderCode) {
		
	}
}