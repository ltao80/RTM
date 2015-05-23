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
        $this->db->select("lp_promotion_info");
    }
}