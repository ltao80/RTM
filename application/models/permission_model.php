<?php
/**
 * Created by PhpStorm.
 * User: liutao
 * Date: 15-5-23
 * Time: 下午1:32
 */

class Permission_Model extends CI_Model {
    public function save_role($role_id){
        $role_name = $this->input->post('name');
        $description = $this->input->post('describe');
        $permission_codes = $this->input->post('permissions');
        $permission_codes = explode(",",$permission_codes);
        if(!isset($role_id)){
            $this->db->trans_start();
            $data = array(
                'role_name' => $role_name,
                'description' => $description,
            );
            $this->db->insert("lp_role_info",$data);
            $role_id = $this->db->insert_id();
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

    public function get_role($role_id){
        $this->db->where("id",$role_id);
        $this->db->select("*");
        $this->db->from("lp_role_info");
        $role_info_result = $this->db->get()->result_array();
        if(count($role_info_result) > 0){
            $role_info = $role_info_result[0];
        }
        return $role_info;
    }

    public function delete_role($role_id){
        $this->db->where("role_id",$role_id);
        $this->db->delete("lp_role_info");
        $rows = $this->db->affected_rows();
        if($rows <= 0)
            throw new RuntimeException("Failed to delete role");
    }

    public function list_roles($pageIndex,$pageSize){
        $this->db->where('role_name <>','administrator');
        $this->db->select("id,role_name,description");
        $this->db->from("lp_role_info");
        $this->db->limit($pageSize,($pageIndex-1)*$pageSize);
        return $this->db->get()->result_array();
    }

    public function get_role_list_total(){
        $this->db->select("id");
        $this->db->from("lp_role_info");
        return $this->db->get()->num_rows();
    }

    public function get_all_roles(){
        $this->db->where("role_name <>","administrator");
        $this->db->select("id,role_name,description");
        $this->db->from("lp_role_info");
        return $this->db->get()->result_array();
    }


    public function get_permission_menu_by_role_ids($role_ids){
        $permission_codes = $this->get_permission_code_by_role_ids($role_ids);
        return $this->get_permission_menu_by_codes($permission_codes);
    }

    public function get_permission_code_by_role_ids($role_ids){
        if(isset($role_ids) && !empty($role_ids)){
            $this->db->where_in("role_id",$role_ids);
        }
        $this->db->select('permission_code');
        $this->db->from("lp_role_permission");
        $this->db->distinct();
        $result = $this->db->get()->result_array();
        foreach($result as $item){
            $permission_codes[] = $item['permission_code'];
        }
        return $permission_codes;
    }

    public function get_permission_menu_by_codes($permission_codes){
        $this->db->where("a.is_nav",1);//this is for navigation
        $this->db->select("a.id,a.menu_name,a.menu_icon,b.permission_code,b.permission_action,a.order_number,a.parent_id");
        $this->db->order_by("order_number");
        $this->db->from("lp_permission_menu a");
        $this->db->join("lp_permission_info b","a.permission_code = b.permission_code","left");
        $menus = $this->db->get()->result_array();
        $main_menus = array();
        $sub_menus = array();
        foreach($menus as $menu){
            if($menu['parent_id'] <= 0){
                $main_menus[] = $menu;
            }else{
                $sub_menus[$menu['parent_id']][] = $menu;
            }
        }
        $result = array();
        foreach($main_menus as $main_menu){
            if(!empty($sub_menus[$main_menu['id']])){
                foreach($sub_menus[$main_menu['id']] as $sub_menu)
                {
                    if(in_array($sub_menu['permission_code'],$permission_codes)){
                        $main_menu['sub_menu'][] = $sub_menu;
                    }
                }
                if(!empty($main_menu['sub_menu'])){
                    $result[] = $main_menu;
                }
            }
        }

        return $result;
    }

    /**
     * @param $role_ids array of role_id
     * @return array
     */
    public function get_all_permission_menu_for_role($role_ids){
        $permission_codes = $this->get_permission_code_by_role_ids($role_ids);
        $this->db->select("a.id,a.menu_name,a.menu_icon,b.permission_code,b.permission_action,a.order_number,a.parent_id");
        $this->db->order_by("order_number");
        $this->db->from("lp_permission_menu a");
        $this->db->join("lp_permission_info b","a.permission_code = b.permission_code","left");
        $menus = $this->db->get()->result_array();
        $main_menus = array();
        $sub_menus = array();
        foreach($menus as &$menu){
            if($menu['parent_id'] <= 0){
                $main_menus[] = $menu;
            }else{
                $sub_menus[$menu['parent_id']][] = $menu;
            }
        }
        $result = array();
        foreach($main_menus as $main_menu){
            if(!empty($sub_menus[$main_menu['id']])){
                foreach($sub_menus[$main_menu['id']] as $sub_menu)
                {
                    if(isset($permission_codes) && !empty($permission_codes)){
                        if(in_array($sub_menu['permission_code'],$permission_codes)){
                            $sub_menu['selected'] = true;
                            $main_menu['selected'] = true;
                        }
                    }
                    $main_menu['sub_menu'][] = $sub_menu;
                }
                if(!empty($main_menu['sub_menu'])){
                    $result[] = $main_menu;
                }
            }
        }

        return $result;

    }

}