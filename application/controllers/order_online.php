<?php
/**
 * Created by PhpStorm.
 * User: richard
 * Date: 15-4-30
 * Time: 下午5:41
 */

class Order extends CI_Controller {

    public function listCart(){
        $current_customer_id = $_SESSION["customer_id"];
        return $this->order_online_model->get_cart_product_list($current_customer_id);
    }

    public function addCart($product_id,$spec_id,$product_num){
        $current_customer_id = $_SESSION["customer_id"];
        return $this->order_online_model->add_product_cart($current_customer_id,$product_id,$spec_id,$product_num);
    }

    public function dropCart($product_id,$spec_id){
        $current_customer_id = $_SESSION["customer_id"];
        return $this->order_online_model->drop_product_cart($current_customer_id,$product_id,$spec_id);
    }

    public function checkScore($total_score){
        $current_customer_id = $_SESSION["customer_id"];
        //TODO front-end need to produce $total_score by product list in shopping cart
        return $this->customer_model->check_customer_score($current_customer_id,$total_score);
    }

    public function make($delivery_id,$delivery_thirdparty_code,$product_list){
        $current_customer_id = $_SESSION["customer_id"];
        //TODO how to populcate $product_list?
        return $this->order_online_model->add_order($current_customer_id,$delivery_id,$delivery_thirdparty_code,$product_list);
    }



} 