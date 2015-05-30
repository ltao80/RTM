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

    function save_user($user_id,$store_id,$name,$password,$phone,$email,$role_id,$wechat_id,$status) {
        //create new user
        if(!isset($user_id) || empty($user_id)){
            $promotion_info = array(
                'store_id' => $store_id,
                'name' => $name,
                'password' => $password,
                'phone' => $phone,
                'email' => $email,
                'wechat_id' => $wechat_id,
                'status' => 0,//normal status
                'created_at' => date('Y-m-d H:i:s',time())
            );
            $this->db->trans_start();
            $this->db->insert("lp_promotion_info",$promotion_info);
            $user_id = $this->db->insert_id();
            $role_permission = array(
                'role_id' => $role_id,
                'user_id' => $user_id
            );
            $this->db->insert("lp_user_roles",$role_permission);
            $this->db->trans_complete();

        }else{
            $data = array();
            $data['name'] = $name;
            $data['phone'] = $phone;
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
        $rows = $this->db->affected_rows();
        if($rows <= 0)
            throw new RuntimeException("Failed to update status of user");
    }

    function update_status($user_id,$status){
        $data = array(
            "status" => $status
        );
        $this->db->where('id',$user_id);
        $this->db->update('lp_promotion_info',$data);
        $rows = $this->db->affected_rows();
        if($rows <= 0)
            throw new RuntimeException("Failed to update status of user");
    }

    function update_password($user_id,$password){
        $data = array(
            "password" => $password
        );
        $this->db->where('id',$user_id);
        $this->db->update('lp_promotion_info',$data);
        $rows = $this->db->affected_rows();
        if($rows <= 0)
            throw new RuntimeException("Failed to update password of user");
    }

    function validate_email($email){
        $this->db->where("email",$email);
        $this->db->select("id");
        $this->db->from("lp_promotion_info");
        return $this->db->get()->num_rows() > 0 ? false :true;

    }

    function delete_user($user_id){
        $this->db->where('id', $user_id);
        $this->db->delete("lp_promotion_info");
        $rows = $this->db->affected_rows();
        if($rows <= 0)
            throw new RuntimeException("Failed to update status of user");
    }

    function get_user_list($prefix,$status,$province,$city,$region,$store_id,$pageIndex,$pageSize){
        if(isset($province)){
            $this->db->where("b.province",$province);
        }
        if(isset($city)){
            $this->db->where("b.city",$city);
        }
        if(isset($region)){
            $this->db->where("b.region",$region);
        }
        if(isset($store_id)){
            $this->db->where("b.store_id",$store_id);
        }
        if(isset($prefix)){
            $this->db->like("a.name",$prefix,'both');
        }
        if(isset($status)){
            $this->db->where("a.status",$status);
        }
        $this->db->where("a.store_id != 1");
        $this->db->select("a.id, a.name, a.phone, a.email, a.status, b.province, b.city, b.store_name");
        $this->db->from("lp_promotion_info a");
        $this->db->join("lp_global_store b","b.store_id = a.store_id");
        $this->db->order_by("a.last_login","desc");
        //$this->db->limit($pageIndex,$pageSize);
        return $this->db->get()->result_array();
    }

    function get_user_list_total($prefix,$status,$province,$city,$region,$store_id){
        if(isset($prefix)){
            $this->db->where("a.name",'match',$prefix);
        }
        if(isset($province)){
            $this->db->where("b.province",$province);
        }
        if(isset($city)){
            $this->db->where("b.city",$city);
        }
        if(isset($region)){
            $this->db->where("b.region",$region);
        }
        if(isset($store_id)){
            $this->db->where("a.store_id",$store_id);
        }
        if(isset($status)){
            $this->db->where("a.status",$status);
        }
        $this->db->select("a.id, a.name, a.phone, a.email, a.status, b.province, b.city, b.region,b.store_name");
        $this->db->from("lp_promotion_info a");
        $this->db->join("lp_global_store b","b.store_id = a.store_id","left");
        return $this->db->get()->num_rows();
    }

    function get_user_by_id($user_id){
        $this->db->where("a.id",$user_id);
        $this->db->select("a.id, a.name, a.phone, a.email, a.status, b.province, b.city, b.region,b.store_name,b.store_id");
        $this->db->from("lp_promotion_info a");
        $this->db->join("lp_global_store b","b.store_id = a.store_id");
        $result = $this->db->get()->result_array();
        if(count($result)>0){
            $user_info = $result[0];
            $this->db->select("role_id");
            $this->db->where("user_id",$user_id);
            $this->db->from("lp_user_roles");
            $role_result = $this->db->get()->result_array();
            if(count($role_result) > 0){
                $user_info['role_id'] = $role_result[0]['role_id'];
            }
            return $user_info;
        }else{
            return array();
        }
    }

    function check_user_permission($user_id,$permission_action){
        $permission_actions = $this->get_user_permission_actions_by_id($user_id);
        return in_array($permission_action,$permission_actions);
    }

    function get_user_permission_actions_by_id($user_id){
        $this->db->where("user_id",$user_id);
        $this->db->select("c.permission_action");
        $this->db->from("lp_user_roles a");
        $this->db->join("lp_role_permission b","b.role_id = a.id");
        $this->db->join("lp_permission_info c","b.permission_code = c.permission_code");
        $this->db->distinct();
        $result = $this->db->get()->result_array();
        if(count($result) > 0){
            foreach($result as $val){
                $res[] = $val['permission_action'];
            }
            return $res;
        }else{
            return array();
        }
    }

    function get_permission_menus_by_user_id($user_id){
        $this->db->where("a.user_id",$user_id);
        $this->db->select("b.permission_code");
        $this->db->from("lp_user_roles a");
        $this->db->join("lp_role_permission b","b.role_id = a.role_id");
        $this->db->distinct();
        $result = $this->db->get()->result_array();
        $permission_codes = array();
        foreach($result as $item){
            $permission_codes[] = $item['permission_code'];
        }
        if(count($permission_codes)>0){
            return $this->permission_model->get_permission_menu_by_codes($permission_codes,true);
        }else{
            return array();
        }
    }

    /**
     * @param $openId
     * @return int  1 : 不存在，进入首次验证页面， 2： 登录， 3： 当天已经登录，无需登录
     */
    function verifyOpenId($openId) {
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

    /**
     * verify email and password, if passed, return user_id else return -1
     * @param $email
     * @param $password
     * @return int user id, if not found, return -1
     */
    function verifyLogin($email, $password) {
        $this->db->where("email",$email);
        $this->db->where("password",$password);
        $this->db->select("id");
        $this->db->from("lp_promotion_info");
        $result = $this->db->get()->result_array();
        if(count($result) > 0){
            return $result[0]['id'];
        }else{
            return -1;
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

}