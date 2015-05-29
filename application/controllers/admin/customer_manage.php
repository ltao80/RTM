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

        /*
        try{
            $date_start  = "";
            $date_end = "";
            $province = "";
            $province2 = "";
            $city2 = "";
            $birthday = "";
            $city2 = "";
            $region2 = "";
            $store2 = "";
            $pageSize = '2';

            $data = $this->user_model->get_customer_list($type,$status,$pageSize,intval($this->uri->segment(4)));
            $total_nums = $this->product_model->get_customer_list_count($type,$status);
            $user_data['pager'] = $this->create_pagination("/admin/customer_manage/user_info/",$total_nums,$pageSize);
            $user_data['data'] = $data;

            $this->load->view("admin/product_list",$user_data);
        }catch (Exception $ex){
            log_message("error,","exception occurred when get exchange list,".$ex->getMessage());
            $data['error'] = "获取兑换商品列表失败";
            $this->load->view("error.php",$data);
        }
   */

        $this->load->view("admin/member_list", $user_data);
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