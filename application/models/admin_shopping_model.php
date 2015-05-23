<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 15-5-22
 * Time: 下午2:28
 */

class Admin_Shopping_Model extends CI_Model{
    function __construct() {
        parent::__construct();
        $this->load->helper('common');
    }

    function get_exchange_list($type,$status,$pageIndex,$pageSize){
        log_message("info,","type is:".$type."status is:".$status);
        if($type != ''){
            $this->db->where("e.type_name",$type);
        }
        if($status != ''){
            $this->db->where("b.status",$status);
        }
        $this->db->select("a.name, a.title, a.create_at, b.score, b.stock_num, b.exchange_num, b.status, c.thumbnail_url, d.spec_name, e.type_name");
        $this->db->from("lp_product_info a");
        $this->db->join("lp_global_specification b","b.product_id = a.id");
        $this->db->join("lp_product_images c","c.product_id = a.id");
        $this->db->join("lp_global_specification d","d.spec_id = b.spec_id");
        $this->db->join("lp_type e","e.id = b.type_id");
        $this->db->order_by("a.create_at","desc");
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
        $this->db->join("lp_global_specification b","b.product_id = a.id");
        $this->db->join("lp_product_images c","c.product_id = a.id");
        $this->db->join("lp_global_specification d","d.spec_id = b.spec_id");
        $this->db->join("lp_type e","e.id = b.type_id");
        $result = $this->db->get()->result_array()[0]['count'];
        $sql = $this->db->last_query();
        log_message("info,","query sql is:".$sql);
        return $result;
    }
} 