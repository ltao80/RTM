<?php
/**
 * Created by PhpStorm.
 * User: liutao
 * Date: 15-5-23
 * Time: 下午1:24
 */

class User_Manage extends LP_Controller{

    public function __construct()
    {
        parent::__construct();
    }

    public function login(){
        $data = array();
        $email = $this->input->post("username");
        $password = $this->input->post("password");
        $salt = $this->config->item('password_salt');
        $password = crypt($password, $salt);
        $redirect_url = $this->input->post("redirect_url");
        if(empty($email) || empty($password)){
            $this->load->view("admin/login.php");
            return;
        }
        if(!empty($this->session->userdata["user_id"])){
            $user_info = array(
                "user_name" => $this->session->userdata["user_name"],
                "store_name" => $this->session->userdata["store_name"]
            );
            $data["user_info"] = $user_info;
            if(!empty($redirect_url)){
                $this->load->view($redirect_url,$data);
            }else{
                redirect("/admin/permission_manage/list_roles");
            }

            return;
        }else{
            $user_id = $this->user_model->verifyLogin($email,$password);
            if($user_id > 0){
                $user_info = $this->user_model->get_user_by_id($user_id);
                $this->session->set_userdata("user_id",$user_info['id']);
                $this->session->set_userdata("user_name",$user_info['name']);
                $this->session->set_userdata("store_name",$user_info['store_name']);
                $user_info = array(
                    "user_name" => $this->session->userdata["user_name"],
                    "store_name" => $this->session->userdata["store_name"]
                );
                $data["user_info"] = $user_info;
                $data["menu_info"] = $this->user_model->get_permission_menus_by_user_id($user_id);
                $this->load->view("admin/admin.php",$data);
            }else{
                $this->load->view("admin/login.php",array("error"=> "登录失败，请检查邮箱和密码"));
            }
        }
    }

    public function logout(){
        $this->session->set_userdata("user_id","");
        redirect("/admin/user_manage/login");
    }


    public function save_user($user_id,$store_id,$name,$password,$phone,$email,$wechat_id,$status){
        log_message('info','save user');
        $user_data = $this->verify_current_user("/admin/user_manage/save_user");
        if(!empty($user_data["error"])){
            $this->load->view("admin/error.php",$user_data);
            return;
        }
        try{
            $this->user_model->save_user($user_id,$store_id,$name, $password,$phone, $email,$wechat_id,$status);
            $this->view("/admin/user_list.php",$user_data);
        }catch (Exception $ex){
            log_message('error',"exception occurred when save user,".$ex->getMessage());
            $this->load->view("admin/error.php",$user_data);
        }
    }

    public function new_user(){
        $user_data = $this->verify_current_user("/admin/user_manage/new_user");
        if(!empty($user_data["error"])){
            $this->load->view("admin/error.php",$user_data);
            return;
        }
        $user_data["provinces"] = $this->global_model->get_provinces();
        $this->load->view("/admin/edit_user.php",$user_data);
    }

    public function edit_user($user_id){
        $user_data = $this->verify_current_user("/admin/user_manage/edit_user");
        if(!empty($user_data["error"])){
            $this->load->view("admin/error.php",$user_data);
            return;
        }
        try{
            if(!empty($user_id)){
                $user_edit_info = $this->user_model->get_user_by_id($user_id);
                $user_data['user_edit_info'] = $user_edit_info;
            }else{
                $user_name = $this->input->post("name");
                $password = $this->input->post("password");
                $salt = substr($password, 0, 2);
                $password = crypt($password, $salt);
                $telephone = $this->input->post("tel");
                $email = $this->input->post("email");
                $store_id = $this->input->post("store");
                $this->user_model->save_user(null,$store_id,$user_name,$password,$telephone,$email,null,0);
                redirect("/admin/user_manage/list_users");
            }
            $this->load->view("/admin/edit_user.php",$user_data);
        }catch (Exception $ex){
            log_message('error',"exception occurred when edit user,".$ex->getMessage());
            $user_data["error_message"] = "编辑用户出错";
            $this->load->view("admin/error.php",$user_data);
        }

    }

    public function delete_user($user_id){
        log_message('info','delete user,id: '.$user_id);
        $user_data = $this->verify_current_user("/admin/user_manage/delete_user");
        try{
            $this->user_model->delete_user($user_id);
            $this->view("/admin/user_list.php",$user_data);
        }catch (Exception $ex){
            log_message('error',"exception occurred when delete user,".$ex->getMessage());
            $this->load->view("admin/error.php",$user_data);
        }
    }

    public function list_users(){
        $action = "/admin/user_manage/list_user";
        log_message('info','receive request: '.$action);
        $user_data = $this->verify_current_user($action);
        $province = $this->input->post("province");
        $city = $this->input->post("city");
        $store_id = $this->input->post("store_id");
        $user_name = $this->input->post("user_name");
        $page_size = $this->config->item['page_size'];//每页的数据
        $page_index = intval($this->uri->segment(3));
        try{
            $data = $this->user_model->get_user_list($province,$city,$store_id,$user_name,$page_size,$page_index);
            $total_count = $this->user_model->get_user_list_total($province,$city,$store_id,$user_name);
            $user_data['pager'] = $this->create_pagination("/admin/user_manage/user_list",$total_count,$page_size);
            $user_data['data'] = $data;
            $this->load->view('admin/user_manage/user_list',$user_data);
        }catch (Exception $ex){
            log_message('error',"exception occurred when list user,".$ex->getMessage());
            $this->view("admin/error.php",$user_data);
        }

    }

    function validate_email(){
        $this->output->set_header('Content-Type: application/json; charset=utf8');
        $email = $this->input->get('email');
        $this->verify_current_user("/admin/user_manage/validate_email");
        echo json_encode($this->user_model->validate_email($email));

    }

    function update_status($user_id,$status){
        $user_data = $this->verify_current_user("/admin/user_manage/update_status");
        try{
            $this->user_model->update_status($user_id,$status);
            $this->load->view('admin/user_manage/user_list',$user_data);
        }catch (Exception $ex){
            log_message('error',"exception occurred when update status,".$ex->getMessage());
            $this->view("admin/error.php",$user_data);
        }
    }

    function set_menu_status(){


    }

}