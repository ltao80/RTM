<?php
class Order_offline_Model extends CI_Model {
	function get_orders($pageIndex = 1, $pageSize = 10) {
		$startIndex = ($pageIndex - 1) * $pageSize;
		
	}
	
	function get_order_detail($orderCode) {
		
	}
}