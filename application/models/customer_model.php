<?php
/**
 * Created by PhpStorm.
 * User: richard
 * Date: 15-4-30
 * Time: 下午5:45
 */

class Customer_Model extends CI_Model {

    function get_customer_by_customer_id($customer_id){
       return $this->db->from("rtm_customer_info")->where("id",$customer_id);
    }

    function get_customer_by_wechat_id($wechat_id){
        return $this->db->from("rtm_customer_info")->where("wechat_id",$wechat_id);
    }

    function check_customer_by_wechat_id($wechat_id){
        $this->db->where('wechat_id',$wechat_id);
        return $this->db->count_all_results('rtm_customer_info') > 0 ;
    }

    /**
     * add new customer
     * @param $name
     * @param $address
     * @param $phone
     * @param $email
     * @param $wechat_id
     */
    function add_customer_info($name,$address,$phone,$email,$wechat_id){
        $data = array(
            'name' => $name,
            'address' => $address,
            'phone' => $phone,
            'email' => $email,
            'wechat_id' => $wechat_id
        );
        $this->db->insert("rtm_customer_info",$data);
    }

    function update_customer_info($id,$name,$address,$phone,$email,$wechat_id){
        $this->db->where('id', $id);

        $data = array(
            'name' => $name,
            'address' => $address,
            'phone' => $phone,
            'email' => $email,
            'wechat_id' => $wechat_id
        );
        $this->db->update("rtm_customer_info",$data);
    }

    /**
     * update total score of customer
     * @param $id string CustomerID
     * @param $add_score int 增量的score值
     */
    function update_customer_score($id,$add_score){
        $this->db->where('id',$id);
        $total_score = $this->db->select("total_score");
        $this->db->update("rtm_customer_info",array('total_score',$total_score + $add_score));
    }

    /**
     * update wechat_id for customer
     * @param $id
     * @param $wechat_id
     */
    function update_customer_wechat($id,$wechat_id){
        $this->db->where('id',$id);
        $this->db->update("rtm_customer_info",array('wechat_id',$wechat_id));
    }


    /**
     * get total score of customer
     * @param $id
     * @return mixed
     */
    function get_score_by_customer_id($id){
        $this->db->where('id',$id);
        $this->db->select("total_score");
        return $this->db->get("rtm_customer_info");
    }

    /**
     * add new delivery info for customer
     * @param $receiver_name
     * @param $receiver_phone
     * @param $receiver_province
     * @param $receiver_city
     * @param $receiver_region
     * @param $receiver_address
     * @param $is_default
     */
    function add_customer_delivery($receiver_name,$receiver_phone,$receiver_province,$receiver_city,$receiver_region,$receiver_address,$is_default){
        $data = array(
            'receiver_name' => $receiver_name,
            'receiver_phone' => $receiver_phone,
            'receiver_province' => $receiver_province,
            'receiver_city' => $receiver_city,
            'receiver_region' => $receiver_region,
            'receiver_address' => $receiver_address,
            'is_default' => $is_default
        );
        $this->db->insert("rtm_customer_delivery_info",$data);
    }

    function update_customer_delivery($id,$receiver_name,$receiver_phone,$receiver_province,$receiver_city,$receiver_region,$receiver_address,$is_default){
        $this->db->where('id',$id);
        $data = array(
            'receiver_name' => $receiver_name,
            'receiver_phone' => $receiver_phone,
            'receiver_province' => $receiver_province,
            'receiver_city' => $receiver_city,
            'receiver_region' => $receiver_region,
            'receiver_address' => $receiver_address,
            'is_default' => $is_default
        );
        $this->db->update("rtm_customer_delivery_info",$data);
    }

    function delete_customer_delivery($id){
        $this->db->where("id",$id);
        $this->db->delete("rtm_customer_delivery_info");
    }

    /**
     * get delivery list by customer id
     * @param $id int customer id
     * @result mixed
     */
    function get_customer_delivery_list($id){
        $this->db->where('id',$id);
        $this->db->select('*');
        return $this->db->get('rtm_customer_delivery_info')->result();
    }
} 