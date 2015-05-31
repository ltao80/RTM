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
        $this->output->set_header('Content-Type: text/html; charset=utf8');
    }

    public function login(){
        $email = $this->input->post("username");
        $password = $this->input->post("password");
        $salt = $this->config->item('password_salt');
        $password = crypt($password, $salt);
        $redirect_url = parse_str($_SERVER['redirect_url'], $_GET);
        if(empty($email) || empty($password)){
            $this->load->view("admin/login.php");
            return;
        }

        $user_id = $this->user_model->verifyLogin($email,$password);
        if($user_id > 0){
            $user_info = $this->user_model->get_user_by_id($user_id);
            $this->session->set_userdata("user_id",$user_info['id']);
            $this->session->set_userdata("role_name",$user_info['role_name']);
            $this->session->set_userdata("user_name",$user_info['name']);
            $this->session->set_userdata("store_name",$user_info['store_name']);
            if(!empty($redirect_url)){
                redirect($redirect_url);
            }else{
                redirect("/admin/user_manage/list_user");
            }
        }else{
            $this->load->view("admin/login.php",array("error"=> "登录失败，请检查邮箱和密码"));
        }

    }

    public function logout(){
        $this->session->set_userdata("user_id","");
        redirect("/admin/user_manage/login");
    }


    public function save_user($user_id){
        log_message('info','save user');
        $user_data = $this->verify_current_user("/admin/user_manage/save_user");
        if(!empty($user_data["error"])){
            $this->load->view("admin/error.php",$user_data);
            return;
        }
        try{
            $user_name = $this->input->post("name");
            $password = $this->input->post("password");
            $salt = $this->config->item('password_salt');
            if(!isset($user_id) || empty($user_id)){
                $password = crypt($password, $salt);
                $email = $this->input->post("email");
            }
            $telephone = $this->input->post("tel");
            $store_id = $this->input->post("store");
            $role_id = $this->input->post("role_id");
            $wechat_id = $this->input->post("wechat_id");
            $this->user_model->save_user($user_id,$store_id,$user_name, $password,$telephone, $email,$role_id,$wechat_id,0);
            redirect("/admin/user_manage/list_user");
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
        $user_data['role_list'] =   $this->permission_model->get_all_roles();
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
                $user_info = $this->user_model->get_user_by_id($user_id);
                $user_info['user_id'] = $user_id;
                $user_data['user_edit_info'] = $user_info;
                $user_data["provinces"] = $this->global_model->get_provinces();
                $user_data['role_list'] =   $this->permission_model->get_all_roles();
            }else{

            }
            $this->load->view("/admin/edit_user.php",$user_data);
        }catch (Exception $ex){
            log_message('error',"exception occurred when edit user,".$ex->getMessage());
            $user_data["error_message"] = "编辑用户出错";
            $this->load->view("admin/error.php",$user_data);
        }

    }

    public function edit_password($user_id){
        $user_data = $this->verify_current_user("/admin/user_manage/edit_user");
        if(!empty($user_data["error"])){
            $this->load->view("admin/error.php",$user_data);
            return;
        }
        $user_info = $this->user_model->get_user_by_id($user_id);
        $user_data['user_name'] = $user_info['name'];
        $user_data['email'] = $user_info['email'];
        $user_data['user_id'] = $user_id;
        $this->load->view("/admin/edit_password.php",$user_data);
    }

    public function delete_user($user_id){
        log_message('info','delete user,id: '.$user_id);
        $user_data = $this->verify_current_user("/admin/user_manage/delete_user");
        if(!empty($user_data["error"])){
            $this->load->view("admin/error.php",$user_data);
            return;
        }
        try{
            $this->user_model->delete_user($user_id);
            $this->view("/admin/user_list.php",$user_data);
        }catch (Exception $ex){
            log_message('error',"exception occurred when delete user,".$ex->getMessage());
            $this->load->view("admin/error.php",$user_data);
        }
    }

    public function search_users(){
        $store_id = $this->input->post("store_id");
        $user_name = $this->input->post("user_name");

    }

    public function list_user(){
        $action = "/admin/user_manage/list_user";
        log_message('info','receive request: '.$action);
        $user_data = $this->verify_current_user($action);
        if(!empty($user_data["error"])){
            $this->load->view("admin/error.php",$user_data);
            return;
        }
        $condition = array();
        if($this->input->get("status")){
            $condition['status'] = $this->input->get("status");
        }
        if($this->input->get("province")){
            $condition['province'] = $this->input->get("province");
        }
        if($this->input->get("city")){
            $condition['city'] = $this->input->get("city");
        }
        if($this->input->get("region")){
            $condition['region'] = $this->input->get("region");
        }
        if($this->input->get("store")){
            $condition['store'] = $this->input->get("store");
        }
        if($this->input->get("name")){
            $condition['name'] = $this->input->get("name");
        }
        $page_index = $_GET['per_page'];
        if(!isset($page_index) || empty($page_index)){
            $page_index = 0;
        }
        if($page_index > 0){
            $page_index = $page_index -1;
        }
        try{
            $user_info_list = $this->user_model->get_user_list($condition['name'],$condition['status'],$condition['province'],$condition['city'],$condition['region'],$condition['store_id'],$page_index,$this->config->item('page_size'));
            $total_count = $this->user_model->get_user_list_total($condition['name'],$condition['status'],$condition['province'],$condition['city'],$condition['region'],$condition['store_id']);
            $user_data['pager'] =$this->create_pagination("/admin/user_manage/list_user?".http_build_query($condition),$total_count,$this->config->item('page_size'));
            $user_data['user_info_list'] = $user_info_list;
            $user_data["provinces"] = $this->global_model->get_provinces();
            $this->load->view('admin/user_list.php',$user_data);
        }catch (Exception $ex){
            log_message('error',"exception occurred when list user,".$ex->getMessage());
            $this->view("admin/error.php",$user_data);
        }
    }

    function validate_email(){
        $this->output->set_header('Content-Type: application/json; charset=utf8');
        $email = $this->input->get('email');
        $this->verify_current_user("/admin/user_manage/validate_email");
        if(!empty($user_data["error"])){
            $this->load->view("admin/error.php",$user_data);
            return;
        }
        try{
            echo json_encode($this->user_model->validate_email($email));
        }catch (Exception $ex){
            log_message('error',"exception occurred when validate email,".$ex->getMessage());
            echo json_encode(array("error" => $ex->getMessage()));
        }

    }

    function update_status(){
        $this->output->set_header('Content-Type: application/json; charset=utf8');
        $user_data = $this->verify_current_user("/admin/user_manage/update_status");
        if(!empty($user_data["error"])){
            $this->load->view("admin/error.php",$user_data);
            return;
        }
        try{
            $user_id = $this->input->post('user_id');
            $status = $this->input->post('status');
            $this->user_model->update_status($user_id,$status);
            echo json_encode(true);
        }catch (Exception $ex){
            log_message('error',"exception occurred when update status,".$ex->getMessage());
            echo json_encode(array("error"=>$ex->getMessage()));
        }
    }

    function update_password(){
        $this->output->set_header('Content-Type: application/json; charset=utf8');
        $user_data = $this->verify_current_user("/admin/user_manage/update_password");
        if(!empty($user_data["error"])){
            $this->load->view("admin/error.php",$user_data);
            return;
        }
        try{
            $user_id = $this->input->post('user_id');
            $password = $this->input->post("password");
            $salt = $this->config->item('password_salt');
            $password = crypt($password, $salt);
            $this->user_model->update_password($user_id,$password);
            redirect("/admin/user_manage/list_user");
        }catch (Exception $ex){
            log_message('error',"exception occurred when update password,".$ex->getMessage());
            $this->view("admin/error.php",$user_data);
        }
    }

    function set_menu_status(){
        $this->output->set_header('Content-Type: application/json; charset=utf8');
        $status = $this->input->get('status');
        $array_items = array('menu_status' => '');
        $this->session->unset_userdata($array_items);
        $this->session->set_userdata('menu_status',$status);
    }

    function get_menu_status(){
        $this->output->set_header('Content-Type: application/json; charset=utf8');
        $status = $this->session->userdata('menu_status');
        echo json_encode($status);
    }

}