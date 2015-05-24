<?php
/**
 * Created by PhpStorm.
 * User: liutao
 * Date: 15-5-23
 * Time: 下午1:18
 */

class order_manage extends CI_Controller {
    function get_offline_order_list(){
        $this->output->set_header('Content-Type: text/html; charset=utf8');
        $this->load->library("session");
        $this->load->model("order_offline_model");
        $this->load->helper('url');
        if(!$this->session->userdata('login')){
            echo 'forbidden to come in !';
            redirect($this->config->item('base_url').'pg_admin/login/');
        }

        $province = $this->input->post("province");
        $city = $this->input->post("city");
        $storeName = $this->input->post("storeName");
        $pgName = $this->input->post("pgName");
        $orderDate = $this->input->post("orderDate");
        $isScan = $this->input->post("isScan");
        $pageSize = '20';//每页的数据

        $data = $this->order_offline_model->get_offline_order_list($province,$city,$storeName,$pgName,$orderDate,$isScan,$pageSize,intval($this->uri->segment(3)));
        $total_nums = $this->order_offline_model->count_offline_order_list($province,$city,$storeName,$pgName,$orderDate,$isScan); //这里得到从数据库中的总页数
        $this->load->library('pagination');
        $config['base_url'] = $this->config->item('base_url').'/index.php/pg_admin/get_offline_order_list/';
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
        $this->load->view('admin/get_offline_list',$data);
    }

    function export_offline_order(){
        $this->output->set_header('Content-Type: text/html; charset=utf8');
        $this->load->library('excel');
        $this->load->model('order_offline_model');
        $province = $this->input->post("province");
        $city = $this->input->post("city");
        $storeName = $this->input->post("storeName");
        $pgName = $this->input->post("pgName");
        $orderDate = $this->input->post("orderDate");
        $isScan = $this->input->post("isScan");
        $data = $this->order_offline_model->export_order_list($province,$city,$storeName,$pgName,$orderDate,$isScan);
        $titles = array(iconv("UTF-8", "GBK", '门店'), iconv("UTF-8", "GBK", '省市'), iconv("UTF-8", "GBK", 'PG姓名'), iconv("UTF-8", "GBK", '用户openId'), iconv("UTF-8", "GBK", '订单详情'), iconv("UTF-8", "GBK", '订单时间'),iconv("UTF-8", "GBK", '订单号'), iconv("UTF-8", "GBK", '扫码时间'));
        $array = array();
        foreach($data as $val){
            $array[] = array(iconv("UTF-8", "GBK", $val['store']),iconv("UTF-8", "GBK", $val['address']),iconv("UTF-8", "GBK", $val['contact']),iconv("UTF-8", "GBK", $val['wechat_id']),iconv("UTF-8", "GBK", $val['detail']),iconv("UTF-8", "GBK", $val['order_code']),iconv("UTF-8", "GBK", $val['order_datetime']),iconv("UTF-8", "GBK", $val['scan_datetime']));
        }
        $this->excel->make_from_array($titles, $array);
        return $this->output->set_output(true);
    }

    function export(){
        $this->output->set_header('Content-Type: text/html; charset=utf8');
        $this->load->library('excel');
        $this->load->model('order_online_model');
        $export = $_POST['export'];
        $startTime = $_POST['startTime'];
        $endTime = $_POST['endTime'];
        $order_code = $_POST['order_code'];//格式需要以,分格
        //if($export == 'export'){
        $data = $this->order_online_model->export_order_list($startTime,$endTime,$order_code);
        $titles = array(iconv("UTF-8", "GBK", '用户opendId'), iconv("UTF-8", "GBK", '用户名'), iconv("UTF-8", "GBK", '省市'), iconv("UTF-8", "GBK", '订单详情'), iconv("UTF-8", "GBK", '订单号'), iconv("UTF-8", "GBK", '订单时间'), iconv("UTF-8", "GBK", '物流单号'));
        $array = array();
        foreach($data as $val){
            $array[] = array(iconv("UTF-8", "GBK", $val['wechat_id']),iconv("UTF-8", "GBK", $val['username']),iconv("UTF-8", "GBK", $val['receiver_province']),iconv("UTF-8", "GBK", $val['detail']),iconv("UTF-8", "GBK", $val['order_code']),iconv("UTF-8", "GBK", $val['order_datetime']),iconv("UTF-8", "GBK", $val['delivery_order_code']));
        }
        $this->excel->make_from_array($titles, $array);
        return $this->output->set_output(true);
        //}
    }

    function update_delivery_order_code(){
        $order_code = $_POST['order_code'];
        $delivery_code = $_POST['delivery_code'];
        $this->output->set_header('Content-Type: application/json; charset=utf8');
        $this->load->model('order_online_model');
        $result = $this->order_online_model->update_delivery_order_code($order_code,$delivery_code);

        return $this->output->set_output(json_encode($result));

    }

    function get_order_list(){
        $this->output->set_header('Content-Type: text/html; charset=utf8');
        $this->load->library("session");
        $this->load->model("order_online_model");
        $this->load->helper('url');
        if(!$this->session->userdata('login')){
            echo 'forbidden to come in !';
            redirect($this->config->item('base_url').'admin/login/');
        }

        $startTime = $_GET['startTime'];
        $endTime = $_GET['endTime'];
        $pageSize = '20';//每页的数据

        $data = $this->order_online_model->get_order_list_by_datetime($startTime,$endTime,$pageSize,intval($this->uri->segment(3)));
        $total_nums = $this->order_online_model->count_order_list($startTime,$endTime); //这里得到从数据库中的总页数
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
        //$data['links'] = $this->pagination->create_links();
        $data['data'] = $data;
        $this->load->view('admin/get_order_list',$data);
    }

    function get_online_order_list(){
        $this->output->set_header('Content-Type: text/html; charset=utf8');
        $this->load->library("session");
        $this->load->model("order_online_model");
        $this->load->helper('url');
        if(!$this->session->userdata('login')){
            echo 'forbidden to come in !';
            redirect($this->config->item('base_url').'admin/login/');
        }

        $startTime = $_GET['startTime'];
        $endTime = $_GET['endTime'];
        $orderCode = $this->input->post("order_code");
        $pageSize = '20';//每页的数据

        $data = $this->order_online_model->get_online_order_list($startTime,$endTime,$orderCode,$pageSize,intval($this->uri->segment(3)));
        $total_nums = $this->order_online_model->count_online_order_list($startTime,$endTime,$orderCode); //这里得到从数据库中的总页数
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
        //$data['links'] = $this->pagination->create_links();
        $data['data'] = $data;
        $this->load->view('admin/get_order_list',$data);
    }

    function get_delivery_detail(){
        $this->output->set_header('Content-Type: text/html; charset=utf8');
        $this->load->library("session");
        $this->load->model("order_online_model");
        $this->load->helper('url');
        if(!$this->session->userdata('login')){
            echo 'forbidden to come in !';
            redirect($this->config->item('base_url').'admin/login/');
        }

        $orderCode = $this->input->post("order_code");
        $detail = $this->order_online_model->get_delivery_detail($orderCode);
        $data['data'] = $detail;

        $this->load->view("admin/get-delivery-detail",$data);

    }

    function export_online_order(){
        $this->output->set_header('Content-Type: text/html; charset=utf8');
        $this->load->library('excel');
        $this->load->model('order_online_model');
        $startTime = $_POST['startTime'];
        $endTime = $_POST['endTime'];
        $order_code = $_POST['order_code'];//格式需要以,分格
        $data = $this->order_online_model->export_online_order($startTime,$endTime,$order_code);
        $titles = array(iconv("UTF-8", "GBK", '兑换商品信息'), iconv("UTF-8", "GBK", '兑换积分'), iconv("UTF-8", "GBK", '买家信息'), iconv("UTF-8", "GBK", '交易状态'), iconv("UTF-8", "GBK", '订单号'), iconv("UTF-8", "GBK", '订单时间'), iconv("UTF-8", "GBK", '物流单号'));
        $array = array();
        foreach($data as $val){
            $array[] = array(iconv("UTF-8", "GBK", $val['wechat_id']),iconv("UTF-8", "GBK", $val['username']),iconv("UTF-8", "GBK", $val['receiver_province']),iconv("UTF-8", "GBK", $val['detail']),iconv("UTF-8", "GBK", $val['order_code']),iconv("UTF-8", "GBK", $val['order_datetime']),iconv("UTF-8", "GBK", $val['delivery_order_code']));
        }
        $this->excel->make_from_array($titles, $array);
        return $this->output->set_output(true);
    }

    /*function delete_online_order(){
        $this->output->set_header('Content-Type: text/html; charset=utf8');
        $this->load->library("session");
        $this->load->model("order_online_model");
        $this->load->helper('url');
        if(!$this->session->userdata('login')){
            echo 'forbidden to come in !';
            redirect($this->config->item('base_url').'admin/login/');
        }

        $orderCode = $this->input->post("order_code");
        $result = $this->order_online_model->delete_online_order($orderCode);
        $this->output->set_output($result);
    }*/

}