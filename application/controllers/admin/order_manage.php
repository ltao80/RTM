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
        $user_data = $this->verify_current_user("/admin/order_manage/get_offline_order_list");
        if(!empty($user_data["error"])){
            $this->load->view("admin/error.php",$user_data);
            return;
        }
        $condition['province'] = $_GET["province"];
        $condition['city'] = $_GET["city"];
        $condition['region'] = $_GET["region"];
        $condition['store'] = $_GET["store"];
        $condition['name'] = $_GET["name"];
        $condition['time'] = $_GET["time"];
        //$isScan = $_GET["is_scan"];
        $condition['is_scan'] = $_GET["is_scan"];
        $pageSize = $this->config->item("page_size");
        $page = $_GET['per_page'];

        try{
            $user_data['data'] = $this->order_offline_model->get_offline_order_list($condition['province'],$condition['city'],$condition['region'],$condition['store'],$condition['name'],$condition['time'],$condition['is_scan'],$pageSize,$page);
            $total_nums = $this->order_offline_model->count_offline_order_list($condition['province'],$condition['city'],$condition['region'],$condition['store'],$condition['name'],$condition['time'],$condition['is_scan']);
            $user_data['pager'] = $this->create_pagination("/admin/order_manage/get_offline_order_list?".http_build_query($condition),$total_nums,$pageSize);
            $user_data['province'] = $this->global_model->get_provinces();
            $user_data['condition'] = array($condition['province'],$condition['city'],$condition['region'],$condition['store'],$condition['name'],$condition['time'],$condition['is_scan']);
            $this->load->view('admin/offline_order_list',$user_data);
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
        $region = $this->input->post("region");
        $storeName = $this->input->post("store");
        $pgName = $this->input->post("name");
        $orderDate = $this->input->post("time");
        $isScan = $this->input->post("is_scan");
        try{
            $data = $this->order_offline_model->export_order_list($province,$city,$region,$storeName,$pgName,$orderDate,$isScan);
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
        $order_code = $this->input->post('order_code');
        $delivery_code = $this->input->post('delivery_code');
        $this->output->set_header('Content-Type: application/json; charset=utf8');
        try{
            $result = $this->order_online_model->update_delivery_order_code($order_code,$delivery_code);
            if($result){
                redirect("/admin/order_manage/get_online_order_list");
            }else{
                $user_data['error'] = "发货失败";
                $this->load->view("admin/error.php",$user_data);
            }

        }catch (Exception $ex){
            log_message("error,","exception occurred when update delivery_order_code,".$ex->getMessage());
            $data['error'] = "更新物流单号失败";
            $this->load->view("error.php",$data);
        }

    }


    function get_online_order_list(){
        log_message("info,","get online order list");
        $user_data = $this->verify_current_user("/admin/order_manage/get_online_order_list");
        if(!empty($user_data["error"])){
            $this->load->view("admin/error.php",$user_data);
            return;
        }
        $condition["startTime"] = $_GET['startTime'];
        $condition['endTime'] = $_GET['endTime'];
        $condition['order_code'] = $_GET["order_code"];
        $pageSize = $this->config->item("page_size");
        $page = $_GET['per_page'];

        try{
            $user_data['data'] = $this->order_online_model->get_online_order_list($condition['startTime'],$condition['endTime'],$condition['order_code'],$pageSize,$page);
            $total_nums = $this->order_online_model->count_online_order_list($condition['startTime'],$condition['endTime'],$condition['order_code']);
            $user_data['pager'] = $this->create_pagination("/admin/order_manage/get_online_order_list?".http_build_query($condition),$total_nums,$pageSize);
            $user_data['total_count'] = $this->order_online_model->count_all_online_order();
            $user_data['u_count'] = $this->order_online_model->count_undelivery_online_order();
            $user_data['delivery_count'] = $this->order_online_model->count_delivery_online_order();
            $user_data['complete_count'] = $this->order_online_model->count_complete_online_order();
            $this->load->view("admin/online_order_list",$user_data);
        }catch (Exception $ex){
            log_message("error,","exception occurred when get online order list".$ex->getMessage());
            $data['error'] = "获取线上订单列表失败";
            $this->load->view("error.php",$data);
        }
    }

    function get_delivery_detail(){
        log_message("info,","get delivery detail ");
        $user_data = $this->verify_current_user("/admin/order_manage/get_delivery_detail");
        if(!empty($user_data["error"])){
            $this->load->view("admin/error.php",$user_data);
            return;
        }
        try{
            $orderCode = $_GET["order_code"];
            $detail = $this->order_online_model->get_delivery_detail($orderCode);
            $user_data['data'] = $detail;

            $this->load->view("admin/online_order_detail",$user_data);
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
        $user_data = $this->verify_current_user("/admin/order_manage/delivery");
        if(!empty($user_data["error"])){
            $this->load->view("admin/error.php",$user_data);
            return;
        }
        $user_data['order_code'] = $_GET['order_code'];
        $user_data['company'] = $this->oreder_online_model->get_company($user_data['order_code']);
        $this->load->view("admin/delivery",$user_data);
    }
}