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
        $rows = $this->db->affected_rows();
        if($rows <= 0)
            throw new RuntimeException("Failed to update status of user");
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

    function delete_user($user_id){
        $this->db->where('id', $user_id);
        $this->db->delete("lp_promotion_info");
        $rows = $this->db->affected_rows();
        if($rows <= 0)
            throw new RuntimeException("Failed to update status of user");
    }

    function query_user_list($prefix,$status,$province,$city,$pageIndex,$pageSize){
        if(isset($province)){
            $this->db->where("b.province",$province);
        }
        if(isset($city)){
            $this->db->where("b.city",$city);
        }
        if(isset($prefix)){
            $this->db->where("a.name",'match',$prefix);
        }
        if(isset($status)){
            $this->db->where("a.status",$status);
        }
        $this->db->select("a.id, a.name, a.phone, a.email, a.status, b.province, b.city, b.store_name");
        $this->db->from("lp_promotion_info a");
        $this->db->join("lp_global_store b","b.store_id = a.store_id");
        $this->db->order_by("a.last_login","desc");
        $this->db->limit($pageIndex,$pageSize);
        return $this->db->get()->result_array();
    }

    function query_user_count($prefix,$status,$province,$city){
        if(isset($province)){
            $this->db->where("b.province",$province);
        }
        if(isset($city)){
            $this->db->where("b.city",$city);
        }
        if(isset($prefix)){
            $this->db->where("a.name",'match',$prefix);
        }
        if(isset($status)){
            $this->db->where("a.status",$status);
        }
        $this->db->select("a.id, a.name, a.phone, a.email, a.status, b.province, b.city, b.store_name");
        $this->db->from("lp_promotion_info a");
        $this->db->join("lp_global_store b","b.store_id = a.store_id");
        return $this->db->get()->num_rows();
    }

    function get_permission_menus_by_user_id($user_id){
        $this->db->where("user_id",$user_id);
        $this->db->select("b.permission_code");
        $this->db->from("lp_user_roles a");
        $this->db->join("lp_role_permission b","b.role_id = a.id");
        $this->db->distinc();
        $permission_codes = $this->db->get()->result_array();
        return $this->permission_module->get_permission_menu_by_codes(join(",",$permission_codes));
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

    function verifyNamePassword($name, $password) {
        $this->db->where("name",$name);
        $this->db->where("password",$password);
        $this->db->select("id");
        $this->db->from("lp_promotion_info");
        $result = $this->db->get()->num_rows();
        return $result > 0;
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