<?php
class Global_Model extends CI_Model {
	
	/**
	 * Get all provinces from our system
	 * 
	 * @return array:
	 */
	function get_provinces() {
		$query = $this->db->query('SELECT DISTINCT province FROM rtm_global_store');
		
		$provinces = array();
		
		if($query->num_rows() > 0) {
			foreach($query->result() as $row) {
				array_push($provinces, $row->province);
			}
		}
		
		return $provinces;
	}
	
	/**
	 * Get all regions from our system
	 * 
	 * @return array:
	 */
	function get_regions() {
		$query = $this->db->query("SELECT DISTINCT region FROM rtm_global_store");
		
		$regions = array();
		if($query->num_rows() > 0) {
			foreach($query->result() as $row) {
				array_push($regions, $row->region);
			}
		}
		
		return $regions;
	}
	
	/**
	 * Get all cities from one given province
	 * 
	 * @param string $province
	 * @return array:
	 */
	function get_cities_by_province($province) {
		$query = $this->db->query("SELECT DISTINCT city FROM rtm_global_store WHERE province = '$province'");
		
		$cities = array();
		
		if($query->num_rows() > 0) {
			foreach($query->result() as $row) {
				array_push($cities, $row->city);
			}
		}
		
		return $cities;
	}
	
	/**
	 * Get all cities from one given region
	 * 
	 * @param string $region
	 * @return array
	 */
	function get_cities_by_region($region) {
		$query = $this->db->query("SELECT DISTINCT city FROM rtm_global_store WHERE region = '$region'");
		
		$cities = array();
		
		if($query->num_rows() > 0) {
			foreach($query->result() as $row) {
				array_push($cities, $row->city);
			}
		}
		
		return $cities;
	}
	
	/**
	 * Get stores by given city
	 * 
	 * @param string $city
	 * @return array:
	 */
	function get_stores_by_city($city) {
		$query = $this->db->query("SELECT DISTINCT store_name FROM rtm_global_store WHERE city = '$city'");
		
		$stores = array();
		if($query->num_rows() > 0) {
			foreach($query->result() as $row) {
				array_push($stores, $row->store_name);
			}
		}
		
		return $stores;
	}
	
	/**
	 * Get stores by given province
	 * 
	 * @param string $province
	 * @return array
	 */
	function get_stores_by_province($province) {
		$query = $this->db->query("SELECT DISTINCT store_name FROM rtm_global_store WHERE province = '$province'");
		
		$stores = array();
		if($query->num_rows() > 0) {
			foreach($query->result() as $row) {
				array_push($stores, $row->store_name);
			}
		}
		
		return $stores;
	}
	
	/**
	 * Get stores by given region
	 * 
	 * @param string $region
	 * @return array
	 */
	function get_stores_by_region($region) {
		$query = $this->db->query("SELECT DISTINCT store_name FROM rtm_global_store WHERE region = '$region'");
		
		$stores = array();
		if($query->num_rows() > 0) {
			foreach($query->result() as $row) {
				array_push($stores, $row->store_name);
			}
		}
		
		return $stores;
	}
}