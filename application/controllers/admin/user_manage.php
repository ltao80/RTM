<?php
/**
 * Created by PhpStorm.
 * User: liutao
 * Date: 15-5-23
 * Time: 下午1:24
 */

class user_manage extends manage_base{

    public function login($email,$password,$redirect_url){
        $data = array();
        if(!empty($this->session->userdata["user_id"])){
            $user_info = array(
                "user_name" => $this->session->userdata["user_name"],
                "store_name" => $this->session->userdata["store_name"]
            );
            $data["user_info"] = $user_info;
            $this->load->view($redirect_url,$data);
        }else{
            $user_id = $this->user_model->verifyLogin($email,$password);
            if($user_id){
                $user_info = $this->user_model->get_user_by_id($user_id);
                $this->session->set_userdata("user_id",$user_info['id']);
                $this->session->set_userdata("user_name",$user_info['name']);
                $this->session->set_userdata("store_name",$user_info['store_name']);
                $user_info = array(
                    "user_name" => $this->session->userdata["user_name"],
                    "store_name" => $this->session->userdata["store_name"]
                );
                $data["user_info"] = $user_info;
                $data["menu_info"] =
                $this->load->view("admin/admin.php",$data);
            }else{
                $this->view("error.php","登录失败");
            }
        }
    }

    public function logout(){
        $this->session->set_userdata("user_id","");
        $this->load->view("admin/login.php");
    }


    public function save_user($user_id,$store_id,$name,$password,$phone,$email,$wechat_id,$status){
        log_message('info','save user');
        $user_data = $this->get_current_user_data("/admin/user_manage/save_user");
        try{
            $this->user_model->save_user($user_id,$store_id,$name, $password,$phone, $email,$wechat_id,$status);
            $this->view("/admin/user_list.php",$user_data);
        }catch (Exception $ex){
            log_message('error',"exception occurred when save user,".$ex->getMessage());
            $user_data['error'] = "保存用户数据出错";
            $this->view("error.php",$user_data);
        }

    }

    public function edit_user($user_id){
        $user_data = $this->get_current_user_data("/admin/user_manage/edit_user");
        if(!empty($user_id)){
            $user_edit_info = $this->user_model->get_user_by_id($user_id);
            $user_data['user_edit_info'] = $user_edit_info;
        }
        $this->view("/admin/edit_user.php",$user_data);
    }

    public function delete_user($user_id){
        log_message('info','delete user,id: '.$user_id);
        $user_data = $this->get_current_user_data("/admin/user_manage/delete_user");
        try{
            $this->user_model->delete_user($user_id);
            $this->view("/admin/user_list.php",$user_data);
        }catch (Exception $ex){
            log_message('error',"exception occurred when delete user,".$ex->getMessage());
            $user_data['error'] = "删除用户失败";
            $this->view("error.php",$user_data);
        }
    }

    public function list_user(){
        $action = "/admin/user_manage/list_user";
        log_message('info','receive request: '.$action);
        $user_data = $this->get_current_user_data($action);
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
            $user_data['error'] = "获取用户列表失败";
            $this->view("error.php",$user_data);
        }

    }


    function update_status($user_id,$status){
        $user_data = $this->get_current_user_data("/admin/user_manage/update_status");
        try{
            $this->user_model->update_status($user_id,$status);
            $this->load->view('admin/user_manage/user_list',$user_data);
        }catch (Exception $ex){
            log_message('error',"exception occurred when update status,".$ex->getMessage());
            $user_data['error'] = "更新用户状态失败";
            $this->view("error.php",$user_data);
        }
    }

}