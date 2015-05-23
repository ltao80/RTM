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
}