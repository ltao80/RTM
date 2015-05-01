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

    function get_customer_by_weixin_id($wechat_id){
        return $this->db->from("rtm_customer_info")->where("wechat_id",$wechat_id);
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

    function update_customer_info($id,$name,$address,$phone,$wechat_id){
        $this->db->where('id', $id);

        $data = array(
            'name' => $name,
            'address' => $address,
            'phone' => $phone,
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
        return  $this->db->select("total_score");
    }

    /**
     * id	int(11) AI PK
    customer_id	int(11)
    receiver_name	varchar(45)
    receiver_phone	varchar(45)
    receiver_province	varchar(45)
    receiver_city	varchar(45)
    receiver_region	varchar(45)
    receiver_address	varchar(250)
    is_default	tinyint(1)
     */
    function add_customer_delivery(){

    }
} 