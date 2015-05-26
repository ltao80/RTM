<?php
/**
 * Created by PhpStorm.
 * User: liutao
 * Date: 15-5-23
 * Time: 下午1:18
 */

class Order_Manage extends LP_Controller {
    function get_offline_order_list(){
        log_message("info","get offline_order_list");
        //$user_data = $this->verify_current_user("/admin/order_manage/get_offline_order_list");
        if(!empty($user_data["error"])){
            $this->load->view("admin/error.php",$user_data);
            return;
        }
        $province = $this->input->post("province");
        $city = $this->input->post("city");
        $storeName = $this->input->post("storeName");
        $pgName = $this->input->post("pgName");
        $orderDate = $this->input->post("orderDate");
        $isScan = $this->input->post("isScan");
        $pageIndex = intval($this->uri->segment(3));
        $pageSize = '20';//每页的数据
        try{
            $data = $this->order_offline_model->get_offline_order_list($province,$city,$storeName,$pgName,$orderDate,$isScan,$pageSize,$pageIndex);
            $total_nums = $this->order_offline_model->count_offline_order_list($province,$city,$storeName,$pgName,$orderDate,$isScan);
            $offline_data['pager'] = $this->create_pagination("/admin/user_manage/user_list",$total_nums,$pageSize);
            $offline_data['data'] = $data;
            $this->load->view('admin/offline_order_list',$offline_data);
        }catch (Exception $ex){
            log_message('error',"exception occurred when list order offline,".$ex->getMessage());
            $user_data['error'] = "获取线下订单列表失败";
            $this->load->view("error.php",$user_data);
        }
    }

    function export_offline_order(){
        log_message("info","export offline order list");
        $user_data = $this->verify_current_user("/admin/order_manage/export_offline_order");
        if(!empty($user_data["error"])){
            $this->load->view("admin/error.php",$user_data);
            return;
        }
        $this->load->library('excel');
        $province = $this->input->post("province");
        $city = $this->input->post("city");
        $storeName = $this->input->post("storeName");
        $pgName = $this->input->post("pgName");
        $orderDate = $this->input->post("orderDate");
        $isScan = $this->input->post("isScan");
        try{
            $data = $this->order_offline_model->export_order_list($province,$city,$storeName,$pgName,$orderDate,$isScan);
            $titles = array(iconv("UTF-8", "GBK", '门店'), iconv("UTF-8", "GBK", '省市'), iconv("UTF-8", "GBK", 'PG姓名'), iconv("UTF-8", "GBK", '用户openId'), iconv("UTF-8", "GBK", '订单详情'), iconv("UTF-8", "GBK", '订单时间'),iconv("UTF-8", "GBK", '订单号'), iconv("UTF-8", "GBK", '扫码时间'));
            $array = array();
            foreach($data as $val){
                $array[] = array(iconv("UTF-8", "GBK", $val['store']),iconv("UTF-8", "GBK", $val['address']),iconv("UTF-8", "GBK", $val['contact']),iconv("UTF-8", "GBK", $val['wechat_id']),iconv("UTF-8", "GBK", $val['detail']),iconv("UTF-8", "GBK", $val['order_code']),iconv("UTF-8", "GBK", $val['order_datetime']),iconv("UTF-8", "GBK", $val['scan_datetime']));
            }
            $this->excel->make_from_array($titles, $array);
            return $this->output->set_output(true);
        }catch (Exception $ex){
            log_message("error","exception occurred when export order offline list,".$ex->getMessage());
            $user_data['error'] = "导出线下订单失败";
            $this->load->view("error.php",$user_data);
        }

    }

    function update_delivery_order_code(){
        log_message("info,","update delivery order code");
        $user_data = $this->verify_current_user("/admin/order_manage/update_delivery_order_code");
        if(!empty($user_data["error"])){
            $this->load->view("admin/error.php",$user_data);
            return;
        }
        $order_code = $_POST['order_code'];
        $delivery_code = $_POST['delivery_code'];
        $this->output->set_header('Content-Type: application/json; charset=utf8');
        try{
            $result = $this->order_online_model->update_delivery_order_code($order_code,$delivery_code);

            return $this->output->set_output(json_encode($result));
        }catch (Exception $ex){
            log_message("error,","exception occurred when update delivery_order_code,".$ex->getMessage());
            $data['error'] = "更新物流单号失败";
            $this->load->view("error.php",$data);
        }

    }


    function get_online_order_list(){
        log_message("info,","get online order list");
        //$user_data = $this->verify_current_user("/admin/order_manage/get_online_order_list");
        if(!empty($user_data["error"])){
            $this->load->view("admin/error.php",$user_data);
            return;
        }
        $startTime = $_GET['startTime'];
        $endTime = $_GET['endTime'];
        $orderCode = $this->input->post("order_code");
        $pageSize = '20';//每页的数据
        $pageIndex = intval($this->uri->segment(3));
        try{
            $data = $this->order_online_model->get_online_order_list($startTime,$endTime,$orderCode,$pageSize,$pageIndex);
            $total_nums = $this->order_online_model->count_online_order_list($startTime,$endTime,$orderCode);
            $online_data['pager'] = $this->create_pagination("/admin/order_manage/get_online_order_list",$total_nums,$pageSize);
            $online_data['data'] = $data;

            $this->load->view("admin/online_order_list",$online_data);
        }catch (Exception $ex){
            log_message("error,","exception occurred when get online order list".$ex->getMessage());
            $data['error'] = "获取线上订单列表失败";
            $this->load->view("error.php",$data);
        }
    }

    function get_delivery_detail(){
        log_message("info,","get delivery detail ");
        //$user_data = $this->verify_current_user("/admin/order_manage/get_delivery_detail");
        if(!empty($user_data["error"])){
            $this->load->view("admin/error.php",$user_data);
            return;
        }
        try{
            $orderCode = $this->input->post("order_code");
            $detail = $this->order_online_model->get_delivery_detail($orderCode);
            $data['data'] = $detail;

            $this->load->view("admin/online_order_detail",$data);
        }catch (Exception $ex){
            log_message("error,","exception occurred when get delivery detail".$ex->getMessage());
            $data['error'] = "获取发货信息详情失败";
            $this->load->view("error.php",$data);
        }
    }

    function export_online_order(){
        log_message("info,","export online order");
        $user_data = $this->verify_current_user("/admin/order_manage/export_online_order");
        if(!empty($user_data["error"])){
            $this->load->view("admin/error.php",$user_data);
            return;
        }
        try{
            $this->output->set_header('Content-Type: text/html; charset=utf8');
            $this->load->library('excel');
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
        }catch (Exception $ex){
            log_message("error,","exception occurred when export online order".$ex->getMessage());
            $data['error'] = "导出线上数据失败";
            $this->load->view("error.php",$data);
        }

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

    function delivery(){
        log_message("info,","get delivery detail ");
        //$user_data = $this->verify_current_user("/admin/order_manage/delivery");
        if(!empty($user_data["error"])){
            $this->load->view("admin/error.php",$user_data);
            return;
        }
        $this->load->view("admin/delivery");
    }
}