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

    function add_product_for_exchange($type,$name,$description,$title,$thumb_name,$image_name,$spec,$status){
        $this->db->trans_start();
        $lp_info = array(
            "name" => $name,
            "title" => $title,
            "description" => $description,
            "create_at" => date('Y-m-d H:i:s',time())
        );
        $res = $this->db->insert("lp_product_info",$lp_info);
        if(!$res){
            return false;
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
                "is_for_exchange" => 1,
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

    function update_product_for_exchange($pId,$type,$name,$description,$title,$thumb_name,$image_name,$spec,$status){
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

    function delete_product_for_exchange($sId){
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
        $this->db->select("a.id as pId, b.id as sId, a.name, a.title, a.create_at, b.score, b.stock_num, b.exchange_num, b.status, c.thumbnail_url, c.image_url, d.spec_name, e.type_name");
        $this->db->from("lp_product_info a");
        $this->db->join("lp_global_specification b","b.product_id = a.id");
        $this->db->join("lp_product_images c","c.product_id = a.id");
        $this->db->join("lp_global_specification d","d.spec_id = b.spec_id");
        $this->db->join("lp_type e","e.id = b.type_id");
        $result = $this->db->get()->result_array()[0];
        $sql = $this->db->last_query();
        log_message("info,","query sql is:".$sql);
        return $result;
    }
} 