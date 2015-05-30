<?php
/**
 * Created by PhpStorm.
 * User: liutao
 * Date: 15-5-23
 * Time: 下午1:17
 */

class customer_manage extends LP_Controller {

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
            $condition['date_start'] = $_GET['date_start2'];
            $condition['date_end'] = $_GET['date_end2'];
            $condition['province'] = $_GET['province'];
            $condition['city'] = $_GET['city'];
            $condition['s_province'] = $_GET['province2'];
            $condition['s_city'] = $_GET['city2'];
            $condition['s_region'] = $_GET['region2'];
            $condition['store_id'] = $_GET['store2'];
            $condition['birthday'] = $_GET['birthday'];

            $pageSize = 1;
            $page = intval($this->uri->segment(4));
            if($page > 0){
                $page = $page -1;
            }
            if(isset($_GET['type']) && $_GET['type'] = "submit") {
                $page = 1;
            }

            $data = $this->customer_model->get_customer_order_list($condition, $pageSize, $page);
            $total_nums = $this->customer_model->get_customer_order_list_count($condition);
            $user_data['pager'] = $this->create_pagination("/admin/customer_manage/user_info/", $total_nums, $pageSize);
            $user_data['data'] = $data;
            $user_data['total'] = $total_nums;

            $this->load->view("admin/member_list", $user_data);
        }catch (Exception $ex){
            log_message("error,","exception occurred when get exchange list,".$ex->getMessage());
            $data['error'] = "获取兑换商品列表失败";
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