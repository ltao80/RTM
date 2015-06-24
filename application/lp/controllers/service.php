<?php
class Service extends CI_Controller {
	
	function __construct() {
		parent::__construct();
		$this->load->model('global_model');
		$this->output->set_header('Content-Type: application/json; charset=utf8');
	}
	
	function get_provinces() {
		$provinces = $this->global_model->get_provinces();
		$this->output->set_output(json_encode($provinces));
	}
	
	function get_regions() {
		$regions = $this->global_model->get_regions();
		$this->output->set_output(json_encode($regions));
	}
	
	function get_cities_by_province() {
		$province = $this->input->get('province');
		$cities = $this->global_model->get_cities_by_province($province);
		$this->output->set_output(json_encode($cities));
	}
	
	function get_cities_by_region() {
		$region = $this->input->get('region');
		$cities = $this->global_model->get_cities_by_region($region);
		$this->output->set_output(json_encode($cities));
	}
	
	function get_stores_by_city() {
		$city = $this->input->get('city');
		$stores = $this->global_model->get_stores_by_city($city);
		$this->output->set_output(json_encode($stores));
	}
	
	function get_stores_by_province() {
		$province = $this->input->get('province');
		$stores = $this->global_model->get_stores_by_province($province);
		$this->output->set_output(json_encode($stores));
	}
	
	function get_stores_by_region() {
		$region = $this->input->get('region');
		$stores = $this->global_model->get_stores_by_region($region);
		$this->output->set_output(json_encode($stores));
	}
}