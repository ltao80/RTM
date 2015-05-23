<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 15-5-22
 * Time: 下午2:23
 */

class Admin_shopping extends CI_Controller{
    function __construct() {
        parent::__construct();
        $this->output->set_header('Content-Type: application/json; charset=utf8');
    }

    function get_exchange_list(){
        $this->output->set_header('Content-Type: text/html; charset=utf8');
        $this->load->library("session");
        $this->load->model("admin_shopping_model");
        $this->load->helper('url');
        if(!$this->session->userdata('login')){
            echo 'forbidden to come in !';
            redirect($this->config->item('base_url').'pg_admin/login/');
        }

        $type = $this->input->post("type");
        $status = $this->input->post("status");
        $pageSize = '20';//每页的数据

        $data = $this->admin_shopping_model->get_exchange_list($type,$status,$pageSize,intval($this->uri->segment(3)));
        $total_nums = $this->admin_shopping_model->count_exchange_list($type,$status); //这里得到从数据库中的总页数
        $this->load->library('pagination');
        $config['base_url'] = $this->config->item('base_url').'/index.php/pg_admin/get_exchange_list/';
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
        $this->load->view('pg_admin/get_exchange_list',$data);
    }

    function add_product_for_exchange(){
        $this->output->set_header('Content-Type: text/html; charset=utf8');
        $this->load->library("session");
        $this->load->model("admin_shopping_model");
        $this->load->helper('url');
        if(!$this->session->userdata('login')){
            echo 'forbidden to come in !';
            redirect($this->config->item('base_url').'pg_admin/login/');
        }
        $type = $this->input->post("type");
        $name = $this->input->post("name");
        $description = $this->input->post("description");
        $title = $this->input->post("title");
        $thumb_name = $this->input->post("thumb_name");
        $image_name = $this->input->post("image_url");
        $spec = $this->input->post("spec");//格式为json格式[{"spec_id":1,"score":"100","stock_num":"100","status":0},{"spec_id":1,"score":"100","stock_num":"100","status":0}]  解析增加product_id 存入数据库中
        $result = $this->admin_shopping_model->add_product_for_exchange($type,$name,$description,$title,$thumb_name,$image_name,$spec);

        $this->output->set_output($result);
    }

    function update_product_for_exchange(){
        $this->output->set_header('Content-Type: text/html; charset=utf8');
        $this->load->library("session");
        $this->load->model("admin_shopping_model");
        $this->load->helper('url');
        if(!$this->session->userdata('login')){
            echo 'forbidden to come in !';
            redirect($this->config->item('base_url').'pg_admin/login/');
        }
        $pId = $this->input->post("pId");
        $type = $this->input->post("type");
        $name = $this->input->post("name");
        $description = $this->input->post("description");
        $title = $this->input->post("title");
        $thumb_name = $this->input->post("thumb_name");
        $image_name = $this->input->post("image_url");
        $spec = $this->input->post("spec");//格式为json格式[{"spec_id":1,"score":"100","stock_num":"100","status":0},{"spec_id":1,"score":"100","stock_num":"100","status":0}]  解析增加product_id 存入数据库中

        $result = $this->admin_shopping_model->update_product_for_exchange($pId,$type,$name,$description,$title,$thumb_name,$image_name,$spec);

        $this->out_put->set_output($result);
    }

    function delete_product_for_exchange(){
        $this->output->set_header('Content-Type: text/html; charset=utf8');
        $this->load->library("session");
        $this->load->model("admin_shopping_model");
        $this->load->helper('url');
        if(!$this->session->userdata('login')){
            echo 'forbidden to come in !';
            redirect($this->config->item('base_url').'pg_admin/login/');
        }

        $sId = $this->input->post("sId");
        $result = $this->admin_shopping_model->delete_product_for_exchange($sId);

        $this->output->set_output($result);
    }

    function update_exchange_status(){
        $this->output->set_header('Content-Type: text/html; charset=utf8');
        $this->load->library("session");
        $this->load->model("admin_shopping_model");
        $this->load->helper('url');
        if(!$this->session->userdata('login')){
            echo 'forbidden to come in !';
            redirect($this->config->item('base_url').'pg_admin/login/');
        }
        $status = $this->input->post("status");
        $sIds = $this->input->post("sIds");
        $result = $this->admin_shopping_model->update_exchange_status($sIds,$status);

        $this->output->set_output($result);
    }

    function upload_product_image(){

    }

    function get_product_by_id(){
        $this->output->set_header('Content-Type: text/html; charset=utf8');
        $this->load->library("session");
        $this->load->model("admin_shopping_model");
        $this->load->helper('url');
        if(!$this->session->userdata('login')){
            echo 'forbidden to come in !';
            redirect($this->config->item('base_url').'pg_admin/login/');
        }

        $pId = $this->input->post("pId");
        $data = $this->admin_shopping_model->get_product_by_id($pId);
        $data['data'] = $data;
        $this->load->view("pg_admin/admin_shopping/get_product_detail",$data);
    }
} 