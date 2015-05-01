<?php
/**
 * Created by PhpStorm.
 * User: richard
 * Date: 15-4-30
 * Time: 下午5:41
 */

class Order extends CI_Controller {

    public function getBasicInfo($id){
        $this->customer_model->get_customer_info($id);
    }


    public function addCart($product_id,$spec_id,$product_num){
        $current_customer_id = $_SESSION["customer_id"];
        $this->order_online_model->home_get_userinfo();
    }
} 