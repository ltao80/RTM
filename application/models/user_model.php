<?php
/**
 * Created by PhpStorm.
 * User: liutao
 * Date: 15-5-23
 * Time: 下午1:32
 *
 * id	int(11) AI PK
store_id	int(11)
name	varchar(45)
password	varchar(45)
phone	varchar(45)
email	varchar(45)
wechat_id	varchar(45)
status	tinyint(1)
last_login	datetime
 *
 */

class user_model extends CI_Model{

    function save_user($user_id,$store_id,$name,$password,$phone,$email,$wechat_id,$status) {
        //create new user
        if(!isset($user_id)){
            $data = array(
                'store_id' => $store_id,
                'name' => $name,
                'password' => $password,
                'phone' => $phone,
                'email' => $email,
                'wechat_id' => $wechat_id,
                'status' => 0 //normal status
            );
            $this->db->insert("lp_promotion_info",$data);
        }else{
            $data = array();
            $data['name'] = $name;
            $data['password'] = $password;
            $data['phone'] = $phone;
            $data['email'] = $email;
            if(isset($store_id)){
                $data['store_id'] = $store_id;
            }
            if(isset($wechat_id)){
                $data['wechat_id'] = $wechat_id;
            }
            if(isset($status)){
                $data['status'] = $status;
            }
            $this->db->where('id', $user_id);
            $this->db->update("lp_promotion_info",$data);
        }
    }

    function update_last_login($user_id){
        $data = array(
           'last_login' => date('Y-m-d H:i:s',time())
        );
        $this->db->where('id', $user_id);
        $this->db->update("lp_promotion_info",$data);
    }

    function delete_user($user_id){
        $this->db->where('id', $user_id);
        $this->db->delete("lp_promotion_info");
    }

    function list_user($prefix,$status,$startTime,$endTime,$pageIndex,$pageSize){
        if(isset($prefix)){
            $this->db->where("name",'match',$prefix);
        }
        if(isset($status)){
            $this->db->where("status",$status);
        }
        if(isset($startTime) && isset($endTime)){
            $this->db->where("last_login>",$startTime);
            $this->db->where("last_login<",$endTime);
        }
        $this->db->offset(($pageIndex-1)*$pageSize);
        $this->db->limit($pageSize);
        $this->db->orderBy();
        $this->db->select("lp_promotion_info");
    }

    /**
     * @param $openId
     * @return int  1 : 不存在，进入首次验证页面， 2： 登录， 3： 当天已经登录，无需登录
     */
    function verify($openId) {
        $query = $this->db->query("SELECT * FROM lp_promotion_info WHERE wechat_id = '$openId'");

        if($query->num_rows() > 0) {
            $user = $query->next_row();
            $lastLogin = new DateTime($user->last_login);
            $now = new DateTime();
            if($now->format("y") == $lastLogin->format("y") && $now->format("d") == $lastLogin->format("d") && $now->format("d") == $now->format("d")) {
                return 3;
            } else {
                return 2;
            }
        } else {
            return 1;
        }
    }

    function confirm_user($openId, $province, $city, $store, $name, $phone, $password) {
        log_message("info","confirm user information,opendId:".$openId.",province:".$province.",city:".$city.",store:".$store.",name".$name.",phone:".$phone.",password:".$password);
        $query = $this->db->query("SELECT pi.id FROM lp_promotion_info pi INNER JOIN lp_global_store gs ON pi.store_id = gs.store_id WHERE gs.province = '$province' AND gs.city = '$city' AND gs.store_name = '$store' AND pi.name='$name' AND pi.phone='$phone'");
        if($query->num_rows()) {
            $user = $query->next_row();
            $userId = $user->id;
            $this->db->query("UPDATE lp_promotion_info SET password='$password', wechat_id='$openId', status = 1 WHERE id = $userId");
            return true;
        } else {
            return false;
        }
    }

    function confirm_change($openId) {
        $this->db->query("UPDATE lp_promotion_info SET status = 1 WHERE wechat_id = '$openId'");
    }

    function signin($email, $password) {
        $query = $this->db->query("SELECT * from lp_promotion_info where email = '$email' and password = '$password' and is_admin = 1");
        if($query->num_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }


    function get_pg_list($province,$city,$storeName,$pgName,$pageIndex,$pageSize){
        if($province != ''){
            $this->db->where("b.province",$province);
        }
        if($city != ''){
            $this->db->where("b.city",$city);
        }
        if($storeName != ''){
            $this->db->where("b.store_name",$storeName);
        }
        if($pgName != ''){
            $this->db->where("a.name",$pgName);
        }
        $this->db->select("a.id, a.name, a.phone, a.email, a.status, b.province, b.city, b.store_name");
        $this->db->from("lp_promotion_info a");
        $this->db->join("lp_global_store b","b.store_id = a.store_id");
        $this->db->order_by("a.last_login","desc");
        $this->db->limit($pageIndex,$pageSize);
        $result = $this->db->get()->result_array();

        return $result;
    }

    function count_pg_list($province,$city,$storeName,$pgName){
        if($province != ''){
            $this->db->where("b.province",$province);
        }
        if($city != ''){
            $this->db->where("b.city",$city);
        }
        if($storeName != ''){
            $this->db->where("b.store_name",$storeName);
        }
        if($pgName != ''){
            $this->db->where("a.name",$pgName);
        }
        $this->db->select("count(*) as count");
        $this->db->from("lp_promotion_info a");
        $this->db->join("lp_global_store b","b.store_id = a.store_id");
        $this->db->order_by("a.last_login","desc");
        $result = $this->db->get()->result_array()[0]['count'];

        return $result;
    }

    function add_pg($pgName,$phone,$email,$store){
        $data = array(
            "store_id" => $store,
            "name" => $pgName,
            "password" => "",
            "phone" => $phone,
            "email" => $email,
            "wechat_id" => "",
            "status" => 0,
            "is_admin" => 0,
            "last_login" => date('Y-m-d H:i:s',time())
        );
        $res = $this->db->insert("lp_promotion_info",$data);
        return $res;
    }

    function update_pg($pgId,$pgName,$phone,$email,$store){
        $data = array(
            "store_id" => $store,
            "name" => $pgName,
            "phone" => $phone,
            "email" => $email
        );
        $this->db->where('id',$pgId);
        $res = $this->db->update('lp_promotion_info',$data);
        return $res;
    }

    function delete_pg($pgId){
        $this->db->where('id',$pgId);
        $res = $this->db->delete('lp_promotion_info');
        return $res;
    }

    function update_pg_status($pgId,$status){
        $data = array(
            "status" => $status
        );
        $this->db->where('id',$pgId);
        $res = $this->db->update('lp_promotion_info',$data);
        return $res;
    }

    function get_pg_by_id($pId){
        $this->db->where("a.id",$pId);
        $this->db->select("a.id, a.name, a.phone, a.email, a.status, b.province, b.city, b.store_name");
        $this->db->from("lp_promotion_info a");
        $this->db->join("lp_global_store b","b.store_id = a.store_id");
        $result = $this->db->get()->result_array();

        return $result;
    }

    function get_pg_store($province,$city,$region){
        if($province != ''){
            $this->db->where("province",$province);
        }
        if($city != ''){
            $this->db->where("city",$city);
        }
        if($region != ''){
            $this->db->where("region",$region);
        }
        $this->db->select("*");
        $this->db->from("lp_global_store");
        $result = $this->db->get()->result_array();

        return $result;
    }
}