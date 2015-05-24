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

    public function delete_role(){

    }

    public function list_roles(){
        $user_data = $this->verify_current_user("admin/permission_manage/list_roles");
        if(!empty($user_data["error"])){
            $this->load->view("admin/error.php",$user_data);
            return;
        }
        try{
            $this->load->view("admin/role_list.php",$user_data);
        }catch (Exception $ex){
            log_message('error',"exception occurred when list roles,".$ex->getMessage());
            $this->load->view("admin/error.php",$user_data);
        }
    }

}