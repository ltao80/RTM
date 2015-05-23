<?php
/**
 * Created by PhpStorm.
 * User: liutao
 * Date: 15-5-23
 * Time: 下午1:32
 */

class role_module extends CI_Model{
    public function save_role($role_id,$role_name,$description,$permission_codes){
        if(!isset($role_id)){
            $this->db->trans_start();
            $data = array(
                'role_name' => $role_name,
                'description' => $description,
            );
            $this->db->insert("lp_role_info",$data);
            $permissions = array();
            foreach($permission_codes as $permission_code){
                $data = array(
                    "permission_code" => $permission_code,
                    "role_id" => $role_id
                );
                $permissions[] = $data;
            }
            $this->db->insert_batch("lp_role_permission",$permissions);
            $this->db->trans_complete();
        }else{
            $this->db->trans_start();
            $data = array(
                'role_name' => $role_name,
                'description' => $description,
            );
            $this->db->where("id",$role_id);
            $this->db->update("lp_role_info",$data);

            $this->db->where("role_id",$role_id);
            $this->db->delete("lp_role_permission");

            $permissions = array();
            foreach($permission_codes as $permission_code){
                $data = array(
                    "permission_code" => $permission_code,
                    "role_id" => $role_id
                );
                $permissions[] = $data;
            }
            $this->db->insert_batch("lp_role_permission",$permissions);
            $this->db->trans_complete();
        }
    }

    public function delete_role($role_id){
        $this->db->where("role_id",$role_id);
        $this->db->delete("lp_role_info");
        $rows = $this->db->affected_rows();
        if($rows <= 0)
            throw new RuntimeException("Failed to delete role");
    }

    public function query_role_list($role_name,$pageIndex,$pageSize){
        if(isset($province)){
            $this->db->where("name","match",$role_name);
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

    public function get_permissions_by_role_id($role_id){
        $this->db->where("role_id",$role_id);
        $this->db->select('permission_code');
        $this->db->from("lp_role_permission");
        return $this->db->get()->result_array();
    }
}