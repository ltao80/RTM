<?php
/**
 *
 * User: liutao
 * Date: 15-5-23
 * Time: 下午1:15
 */

class permission_manage extends LP_Controller{

    public function new_role(){
        $user_data = $this->verify_current_user("/admin/permission_manage/new_role");
        $all_permissions =  $this->permission_model->get_all_permission_menu_for_role(null);
        $role_info['permissions'] = $all_permissions;
        $user_data['role_info'] = $role_info;
        $this->load->view("admin/edit_role.php",$user_data);
    }

    public function edit_role($role_id){
        $user_data = $this->verify_current_user("/admin/permission_manage/edit_role");
        if(!empty($user_data["error"])){
            $this->load->view("admin/error.php",$user_data);
            return;
        }
        if(!isset($role_id) && empty($role_id)) {
            throw new RuntimeException("role_id parameter must be specified");
        }
        try{
            $role_info = $this->permission_model->get_role($role_id);
            $all_permissions =  $this->permission_model->get_all_permission_menu_for_role(array($role_id));
            $role_info['permissions'] = $all_permissions;
            $user_data['role_info'] = $role_info;
            $this->load->view("admin/edit_role.php",$user_data);
        }catch (Exception $ex){
            log_message('error',"exception occurred when edit role,".$ex->getMessage());
            $this->load->view("admin/error.php",$user_data);
        }
    }

    public function save_role($role_id){
        $user_data = $this->verify_current_user("/admin/permission_manage/save_role");
        if(!empty($user_data["error"])){
            $this->load->view("admin/error.php",$user_data);
            return;
        }
        try{
            $role_name = $this->input->post('name');
            $description = $this->input->post('describe');
            $permissions = $this->input->post("permissions");
            $this->permission_model->save_role($role_id,$role_name,$description,$permissions);
            redirect("admin/permission_manage/list_role");
        }catch (Exception $ex){
            log_message('error',"exception occurred when save role,".$ex->getMessage());
            $this->load->view("admin/error.php",$user_data);
        }
    }

    public function delete_role($role_id){
        $user_data = $this->verify_current_user("/admin/permission_manage/delete_role");
        if(!empty($user_data["error"])){
            $this->load->view("admin/error.php",$user_data);
            return;
        }
        try{
            $this->permission_model->delete_role($role_id);
            redirect("admin/permission_manage/list_role");
        }catch (Exception $ex){
            log_message('error',"exception occurred when delete role,".$ex->getMessage());
            $this->load->view("admin/error.php",$user_data);
        }
    }

    public function list_role(){
        $user_data = $this->verify_current_user("/admin/permission_manage/list_role");
        if(!empty($user_data["error"])){
            $this->load->view("admin/error.php",$user_data);
            return;
        }
        try{
            $page_size = $this->config->item('page_size');//每页的数据
            $page_index = $_GET['per_page'];
            if(!isset($page_index) || empty($page_index)){
                $page_index = 0;
            }
            if($page_index > 0){
                $page_index = $page_index -1;
            }
            $condition = array();
            $role_list = $this->permission_model->list_roles($page_index,$page_size);
            $role_list_total = $this->permission_model->get_role_list_total();
            $user_data['pager'] =$this->create_pagination("/admin/permission_manage/list_role?".http_build_query($condition),$role_list_total,$this->config->item('page_size'));
            $user_data['role_list'] = $role_list;
            $this->load->view("admin/role_list.php",$user_data);
        }catch (Exception $ex){
            log_message('error',"exception occurred when list roles,".$ex->getMessage());
            $this->load->view("admin/error.php",$user_data);
        }
    }

}