<?php
/**
 * Created by PhpStorm.
 * User: liutao
 * Date: 15-5-23
 * Time: 下午1:17
 */

class customer_manage extends LP_Controller {
    function __construct() {
        parent::__construct();
        $this->output->set_header('Content-Type: text/html; charset=utf8');
    }
    /**
     * 用户信息
     */
    function user_info() {
        $user_data = $this->verify_current_user("/admin/customer_manage/user_info");
        if(!empty($user_data["error"])){
            $this->load->view("admin/error.php",$user_data);
            return;
        }
        $user_data['province'] = $this->global_model->get_provinces();

        try{
            $condition['date_start2'] = $_GET['date_start2'];
            $condition['date_end2'] = $_GET['date_end2'];
            $condition['province'] = $_GET['province'];
            $condition['city'] = $_GET['city'];
            $condition['province2'] = $_GET['province2'];
            $condition['city2'] = $_GET['city2'];
            $condition['region2'] = $_GET['region2'];
            $condition['store2'] = $_GET['store2'];
            $condition['birthday'] = $_GET['birthday'];

            $pageSize = 1;
            $page = $_GET['per_page'];
            if($page > 0){
                $page = $page -1;
            }
            if(isset($_GET['type']) && $_GET['type'] = "submit") {
               $page = 1;
            }

            $data = $this->customer_model->get_customer_order_list($condition, $pageSize, $page);
            $total_nums = $this->customer_model->get_customer_order_list_count($condition);
            $user_data['pager'] = $this->create_pagination("/admin/customer_manage/user_info?".http_build_query($condition)
, $total_nums, $pageSize);
            $user_data['data'] = $data;
            $user_data['total'] = $total_nums;

            $this->load->view("admin/customer_user_list", $user_data);
        }catch (Exception $ex){
            log_message("error,","exception occurred when get user info ".$ex->getMessage());
            $data['error'] = "获取用户信息失败";
            $this->load->view("error.php",$data);
        }

    }

    /**
     * 用户信息详情
     */
    function user_detail_info() {
        $user_data = $this->verify_current_user("/admin/customer_manage/user_detail_info");
        if(!empty($user_data["error"])){
            $this->load->view("admin/error.php",$user_data);
            return;
        }
        try{
            if(isset($_GET['customer_id']) && !empty($_GET['customer_id'])) {
                //获取客户信息
                $user_data['customer_info'] = $this->customer_model->get_customer_by_customer_id($_GET['customer_id']);
                //获取邮寄信息
                $user_data['delivery_info'] = $this->customer_model->get_default_customer_delivery($_GET['customer_id']);
                //获取兑换订单信息
                $user_data['exchange_info'] = $this->customer_model->get_exchange_by_customer_id($_GET['customer_id']);
                //获取积分信息
                $user_data['score_info'] = $this->customer_model->get_socore_detail_by_customer_id($_GET['customer_id']);
                $this->load->view("admin/customer_user_detail", $user_data);
            }
        }catch (Exception $ex){
            log_message("error,","exception occurred when get user detail info,".$ex->getMessage());
            $data['error'] = "获取用户详细信息失败";
            $this->load->view("error.php",$data);
        }
    }

    /**
     * 邮寄信息
     */
    function post_info() {
        $user_data = $this->verify_current_user("/admin/customer_manage/post_info");
        if(!empty($user_data["error"])){
            $this->load->view("admin/error.php",$user_data);
            return;
        }
        try{
            if(isset($_GET['customer_id']) && !empty($_GET['customer_id'])) {
                //获取邮寄信息
                //获取客户信息
                $user_data['customer_info'] = $this->customer_model->get_customer_by_customer_id($_GET['customer_id']);
                $user_data['delivery_info'] = $this->customer_model->get_customer_delivery_list($_GET['customer_id']);
                $this->load->view("admin/customer_post_list", $user_data);
            }
        }catch (Exception $ex){
            log_message("error,","exception occurred when get user detail info,".$ex->getMessage());
            $data['error'] = "获取用户详细信息失败";
            $this->load->view("error.php",$data);
        }

    }

    /**
     * 兑换信息
     */
    function exchange_info() {
        $user_data = $this->verify_current_user("/admin/customer_manage/exchange_info");
        if(!empty($user_data["error"])){
            $this->load->view("admin/error.php",$user_data);
            return;
        }
        try {
            if (isset($_GET['customer_id']) && !empty($_GET['customer_id'])) {

                $condition['date_start'] = $_GET['time_start'];
                $condition['date_end'] = $_GET['time_end'];
                $condition['customer_id'] = $_GET['customer_id'];
                $condition['product_name'] = $_GET['name'];

                $pageSize = 1;
                $page = $_GET['per_page'];
                if ($page > 0) {
                    $page = $page - 1;
                }

                if (isset($_GET['type']) && $_GET['type'] = "submit") {
                    $page = 1;
                }

                $data = $this->order_online_model->get_exchange_list($condition, $pageSize, $page);
                $total_nums = $this->order_online_model->count_exchange_list($condition);
                $user_data['pager'] = $this->create_pagination("/admin/customer_manage/exchange_info?".http_build_query($condition), $total_nums, $pageSize);
                $user_data['data'] = $data;
                $user_data['customer_id'] = $_GET['customer_id'];
                $this->load->view("admin/customer_exchange_list", $user_data);
            } else {
                log_message("error,","customer_id 参数不能为空!");
                $data['error'] = "获取兑换商品列表失败";
                $this->load->view("error.php",$data);
            }
        }catch(Exception $ex) {
            log_message("error,","exception occurred when get exchange list,".$ex->getMessage());
            $data['error'] = "获取兑换商品列表失败";
            $this->load->view("error.php",$data);
        }
    }

    /**
     * 积分信息
     */
    function score_info() {
        $user_data = $this->verify_current_user("/admin/customer_manage/score_info");
        if(!empty($user_data["error"])){
            $this->load->view("admin/error.php",$user_data);
            return;
        }
        try {
            if (isset($_GET['customer_id']) && !empty($_GET['customer_id'])) {

                $condition['date_start'] = $_GET['time_start'];
                $condition['date_end'] = $_GET['time_end'];
                $condition['customer_id'] = $_GET['customer_id'];
                $condition['product_name'] = $_GET['name'];

                $pageSize = 1;
                $page = $_GET['per_page'];
                if ($page > 0) {
                    $page = $page - 1;
                }

                if (isset($_GET['type']) && $_GET['type'] = "submit") {
                    $page = 1;
                }

                $data = $this->order_online_model->get_exchange_list($condition, $pageSize, $page);
                $total_nums = $this->order_online_model->count_exchange_list($condition);
                $user_data['pager'] = $this->create_pagination("/admin/customer_manage/score_info?".http_build_query($condition), $total_nums, $pageSize);
                $user_data['data'] = $data;
                $user_data['customer_id'] = $_GET['customer_id'];
                $this->load->view("admin/customer_score_list", $user_data);
            } else {
                log_message("error,","customer_id 参数不能为空!");
                $data['error'] = "获取兑换商品列表失败";
                $this->load->view("error.php",$data);
            }
        }catch(Exception $ex) {
            log_message("error,","exception occurred when get exchange list,".$ex->getMessage());
            $data['error'] = "获取兑换商品列表失败";
            $this->load->view("error.php",$data);
        }
    }

    /**
     * 门店购买订单信息
     */
    function shopping_order_info() {
        $user_data = $this->verify_current_user("/admin/customer_manage/user_info");
        if(!empty($user_data["error"])){
            $this->load->view("admin/error.php",$user_data);
            return;
        }
    }
}