<?php
class Pg_admin extends CI_Controller {
	function __construct() {
		parent::__construct();
		$this->output->set_header('Content-Type: application/json; charset=utf8');
	}

    function get_order_list(){
        $this->output->set_header('Content-Type: text/html; charset=utf8');
        $datetime = $_POST['datetime'];
        $pageSize = '3';//每页的数据
        $this->load->model("pg_admin_model");
        $this->load->helper('url');
        $data['data'] = $this->pg_admin_model->get_order_list_by_datetime($datetime,intval($this->uri->segment(3)),$pageSize);
        $total_nums = $this->pg_admin_model->count_order_list($datetime); //这里得到从数据库中的总页数
        $this->load->library('pagination');
        $config['base_url'] = $this->config->item('base_url').'/index.php/pg_admin/get_order_list/';
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
        $data['links'] = $this->pagination->create_links();
        echo $data['links'];
        $this->load->view('pg_admin/get_order_list',$data);
    }
	
	function confirm_user() {
		$this->load->helper('string');
		$openId = $this->input->post("openId");
		$province = $this->input->post("province");
		$city = $this->input->post("city");
		$store = $this->input->post("store");
		$name = $this->input->post("name");
		$phone = $this->input->post("phone");
		$passwordType = $this->config->config["password_type"];
		$passwordLength = $this->config->config["password_length"];
        $password = random_string($passwordType, $passwordLength);

		$result = $this->pg_user_model->confirm_user($openId, $province, $city, $store, $name, $phone, $password);

		if($result) {
            $platId = $this->config->item("platId");
            $msg = "您的密码为:".$password .", 请妥善保管, 谢谢!";
            Wechat::sendCustomerMessageByOpenId($platId, $openId, $msg);
			$this->output->set_output(json_encode(array("success"=>true, "password"=>$password)));
		} else {
			$this->output->set_output(json_encode(array("success"=>false)));
		}
	}

	function login(){
        $this->output->set_header('Content-Type: text/html; charset=utf8');
        $this->load->library("session");
        if($this->session->userdata('login')){
            $this->load->view('pg_admin/order_list');
        }else{
            $this->load->view('pg_admin/pg_admin');
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
            $this->session->set_userdata('login',array("email" => $openId,"password" => $password));
            return $this->output->set_output(true);
        }else{
            $this->output->set_output(false);
        }

	}

    function export(){
        $this->load->library('excel');
        $export = $_GET['export'];
        $datetime = $_GET['datetime'];
        if($export == 'export'){
            $data = $this->pg_admin_model->export_order_list($datetime);
            $sql = $this->db->get('dbtable');

            $query->result();

            $this->excel->filename = 'abc123';

            $this->excel->make_from_db($sql);
        }
    }
}