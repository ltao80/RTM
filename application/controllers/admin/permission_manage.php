<?php
/**
 *
 * User: liutao
 * Date: 15-5-23
 * Time: 下午1:15
 */

class permission_manage extends LP_Controller{

    public function add_role(){

    }

    public function edit_role($role_id){
        $user_data = $this->verify_current_user("/admin/permission_manage/edit_role");
        if(!empty($user_data["error"])){
            $this->load->view("admin/error.php",$user_data);
            return;
        }

        $role_info = $this->permission_model->get_role($role_id);
        $user_data['role_info'] = $role_info;
    }

    public function delete_role(){

    }

    public function list_role(){
        $user_data = $this->verify_current_user("/admin/permission_manage/list_role");
        if(!empty($user_data["error"])){
            $this->load->view("admin/error.php",$user_data);
            return;
        }
        try{
            $role_name = $this->input->post('role_name');
            $page_size = $this->config->item('page_size');//每页的数据
            $page_index = intval($this->uri->segment(3));
            if(!isset($page_index) || $page_index <= 0)
                $page_index = 1;
            $user_data['role_list'] = $this->permission_model->list_roles($role_name,$page_index,$page_size);
            $this->load->view("admin/role_list.php",$user_data);
        }catch (Exception $ex){
            log_message('error',"exception occurred when list roles,".$ex->getMessage());
            $this->load->view("admin/error.php",$user_data);
        }
    }

}