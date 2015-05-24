<?php
/**
 * Created by PhpStorm.
 * User: liutao
 * Date: 15-5-23
 * Time: 下午1:24
 */

class user_manage extends CI_Controller{

    public function login(){

    }

    public function logout(){

    }

    public function add_user(){

    }

    public function edit_user(){

    }

    public function delete_user(){

    }

    public function list_user(){

    }

    public function list_permission_menu(){

    }



    function get_pg_list(){
        $this->output->set_header('Content-Type: text/html; charset=utf8');
        $this->load->library("session");
        $this->load->model("pg_admin_model");
        $this->load->helper('url');
        if(!$this->session->userdata('login')){
            echo 'forbidden to come in !';
            redirect($this->config->item('base_url').'admin/login/');
        }

        $province = $this->input->post("province");
        $city = $this->input->post("city");
        $storeName = $this->input->post("storeName");
        $pgName = $this->input->post("pgName");
        $pageSize = '20';//每页的数据

        $data = $this->pg_admin_model->get_pg_list($province,$city,$storeName,$pgName,$pageSize,intval($this->uri->segment(3)));
        $total_nums = $this->pg_admin_model->count_pg_list($province,$city,$storeName,$pgName); //这里得到从数据库中的总页数
        $this->load->library('pagination');
        $config['base_url'] = $this->config->item('base_url').'/index.php/admin/get_pg_list/';
        $config['total_rows'] = $total_nums;//总共多少条数据
        $config['per_page'] = $pageSize;//每页显示几条数据
        $config['full_tag_open'] = '<p>';
        $config['full_tag_close'] = '</p>';
        $config['first_link'] = '首页';
        $config['first_tag_open'] = '<li>';//“第一页”链接的打开标签。
        $config['first_tag_close'] = '</li>';//“第一页”链接的关闭标签。
        $config['last_link'] = '尾页';//你希望在分页的右边显示“最后一页”链接的名字。
        $config['last_tag_open'] = '<li>';//“最后一页”链接的打开标签。
        $config['last_tag_close'] = '</li>';//“最后一页”链接的关闭标签。
        $config['next_link'] = '下一页';//你希望在分页中显示“下一页”链接的名字。
        $config['next_tag_open'] = '<li>';//“下一页”链接的打开标签。
        $config['next_tag_close'] = '</li>';//“下一页”链接的关闭标签。
        $config['prev_link'] = '上一页';//你希望在分页中显示“上一页”链接的名字。
        $config['prev_tag_open'] = '<li>';//“上一页”链接的打开标签。
        $config['prev_tag_close'] = '</li>';//“上一页”链接的关闭标签。
        $config['cur_tag_open'] = '<li class="current">';//“当前页”链接的打开标签。
        $config['cur_tag_close'] = '</li>';//“当前页”链接的关闭标签。
        $config['num_tag_open'] = '<li>';//“数字”链接的打开标签。
        $config['num_tag_close'] = '</li>';
        $this->pagination->initialize($config);
        //$data['links'] = $this->pagination->create_links();
        $data['data'] = $data;
        $this->load->view('admin/get_pg_list',$data);
    }

    function add_pg(){
        $this->output->set_header('Content-Type: text/html; charset=utf8');
        $this->load->library("session");
        $this->load->model("pg_admin_model");
        $this->load->helper('url');
        if(!$this->session->userdata('login')){
            echo 'forbidden to come in !';
            redirect($this->config->item('base_url').'admin/login/');
        }

        $pgName = $this->input->post("name");
        $phone = $this->input->post("phone");
        $email = $this->input->post("email");
        $store = $this->input->post("store");

        if($pgName == ''){
            $this->output->set_output(json_encode(array("error" => "请填写姓名")));
        }
        if($phone == ''){
            $this->output->set_output(json_encode(array("error" => "请填写电话")));
        }
        if($email == ''){
            $this->output->set_output(json_encode(array("error" => "请填写邮箱")));
        }
        if($store == ''){
            $this->output->set_output(json_encode(array("error" => "请填写门店")));
        }

        $result = $this->pg_admin_model->add_pg($pgName,$phone,$email,$store);

        if($result){
            $this->output->set_output(json_encode(array("data" => "添加成功")));
        }else{
            $this->output->set_output(json_encode(array("data" => "添加失败")));
        }
    }

    function get_pg_by_id(){
        $this->output->set_header('Content-Type: text/html; charset=utf8');
        $this->load->library("session");
        $this->load->model("pg_admin_model");
        $this->load->helper('url');
        if(!$this->session->userdata('login')){
            echo 'forbidden to come in !';
            redirect($this->config->item('base_url').'admin/login/');
        }

        $pgId = $this->input->post("id");
        $data = $this->pg_admin_model->get_pg_by_id($pgId);
        $data['data'] = $data;

        $this->load->view("admin/edit_pg",$data);
    }

    function edit_pg(){
        $this->output->set_header('Content-Type: text/html; charset=utf8');
        $this->load->library("session");
        $this->load->model("pg_admin_model");
        $this->load->helper('url');
        if(!$this->session->userdata('login')){
            echo 'forbidden to come in !';
            redirect($this->config->item('base_url').'admin/login/');
        }
        $pgId = $this->input->post("id");
        $pgName = $this->input->post("name");
        $phone = $this->input->post("phone");
        $email = $this->input->post("email");
        $store = $this->input->post("store");

        if($pgName == ''){
            $this->output->set_output(json_encode(array("error" => "请填写姓名")));
        }
        if($phone == ''){
            $this->output->set_output(json_encode(array("error" => "请填写电话")));
        }
        if($email == ''){
            $this->output->set_output(json_encode(array("error" => "请填写邮箱")));
        }
        if($store == ''){
            $this->output->set_output(json_encode(array("error" => "请填写门店")));
        }

        $result = $this->pg_admin_model->update_pg($pgId,$pgName,$phone,$email,$store);
        if($result){
            $this->output->set_output(json_encode(array("data" => "修改成功")));
        }else{
            $this->output->set_output(json_encode(array("data" => "修改失败")));
        }
    }

    function delete_pg(){
        $this->output->set_header('Content-Type: text/html; charset=utf8');
        $this->load->library("session");
        $this->load->model("pg_admin_model");
        $this->load->helper('url');
        if(!$this->session->userdata('login')){
            echo 'forbidden to come in !';
            redirect($this->config->item('base_url').'admin/login/');
        }
        $pgId = $this->input->post("id");
        $result = $this->pg_admin_model->delete_pg($pgId);
        if($result){
            $this->output->set_output(json_encode(array("data" => "删除成功")));
        }else{
            $this->output->set_output(json_encode(array("data" => "删除失败")));
        }
    }

    function update_pg_status(){
        $this->output->set_header('Content-Type: text/html; charset=utf8');
        $this->load->library("session");
        $this->load->model("pg_admin_model");
        $this->load->helper('url');
        if(!$this->session->userdata('login')){
            echo 'forbidden to come in !';
            redirect($this->config->item('base_url').'admin/login/');
        }
        $pgId = $this->input->post("id");
        $status = $this->input->post("status");

        $result = $this->pg_admin_model->update_pg_status($pgId,$status);
        if($result){
            $this->output->set_output(json_encode(array("data" => "操作成功")));
        }else{
            $this->output->set_output(json_encode(array("data" => "操作失败")));
        }
    }

    function get_pg_store(){
        $this->output->set_header('Content-Type: text/html; charset=utf8');
        $this->load->library("session");
        $this->load->model("pg_admin_model");
        $this->load->helper('url');
        if(!$this->session->userdata('login')){
            echo 'forbidden to come in !';
            redirect($this->config->item('base_url').'admin/login/');
        }
        $province = $this->input->post("province");
        $city = $this->input->post("city");
        $region = $this->input->post("region");
        $result = $this->pg_admin_model->get_pg_store($province,$city,$region);
        //$data['data'] = $result;
        $this->output->set_output(json_encode($result));
        //$this->load->view("admin/add-list",$data);

    }

    function login(){
        $this->output->set_header('Content-Type: text/html; charset=utf8');
        $this->load->library("session");
        $this->load->helper('url');
        if($this->session->userdata('login')){
            redirect($this->config->item('base_url').'admin/get_order_list');
        }else{
            $this->load->view('admin/admin');
        }

    }

    function signin() {
        $this->output->set_header('Content-Type: application/json; charset=utf8');
        $this->load->model('pg_admin_model');
        $openId = $_POST['name'];
        $password = $_POST['password'];
        $result = $this->pg_admin_model->signin($openId, $password);
        if($result){
            $this->load->library("session");
            $this->session->set_userdata('login',array("email" => $openId,"password" => $password,"is_admin" => 1));
            return $this->output->set_output(true);
        }else{
            $this->output->set_output(false);
        }

    }

    function loginout(){
        $this->output->set_header('Content-Type: text/html; charset=utf8');
        $this->load->library("session");
        $this->load->helper('url');
        if($this->session->userdata('login')){
            $this->session->unset_userdata('login');
            redirect($this->config->item('base_url').'admin/login/');
        }else{
            redirect($this->config->item('base_url').'admin/login/');
        }
    }
}