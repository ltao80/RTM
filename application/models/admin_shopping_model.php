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
            $this->db->where("type",$type);
        }
        if($status != ''){
            $this->db->where("status",$status);
        }
        $this->db->select("a.name, a.title, b.score, b.stock_num, b.exchange_num, b.status, c.thumbnail_url, d.spec_name, e.");
        $this->db->from("");
        $this->db->join("");
        $this->db->order_by("","desc");
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
        $this->db->from("");
        $this->db->join("");
        $this->db->order_by("","desc");
        $result = $this->db->get()->result_array()[0]['count'];
        $sql = $this->db->last_query();
        log_message("info,","query sql is:".$sql);
        return $result;
    }
} 