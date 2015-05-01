<?php
/**
 * Created by PhpStorm.
 * User: richard
 * Date: 15-4-30
 * Time: 下午5:41
 */

class Order extends CI_Controller {

    public function listCart(){
        if(!$this->checkSession())
            return json_encode(array('error','unAuthorized request'));
        $current_customer_id = $_SESSION["customer_id"];
        log_message("list cart,customer_id:".$current_customer_id);
        try{
            return json_encode($this->order_online_model->get_cart_product_list($current_customer_id));
        }catch (Exception $ex){
            log_message('error',"exception occurred when list cart,".$ex->getMessage());
            return json_encode(array("error"=>$ex->getMessage()));
        }
    }

    public function addCart(){
        if(!$this->checkSession())
            return json_encode(array('error','unAuthorized request'));
        $current_customer_id = $_SESSION["customer_id"];
        $product_id = $_GET['product_id'];
        $spec_id = $_GET['spec_id'];
        $product_num = $_GET['product_num'];
        log_message("add cart,customer_id:".$current_customer_id.",product_id: ".$product_id.",spec_id: ".$spec_id.",product_num:".$product_num);
        try{
            return json_encode($this->order_online_model->add_product_cart($current_customer_id,$product_id,$spec_id,$product_num));
        }catch (Exception $ex){
            log_message('error',"exception occurred when add cart,".$ex->getMessage());
            return json_encode(array("error"=>$ex->getMessage()));
        }
    }

    public function dropCart($product_id,$spec_id){
        if(!$this->checkSession())
            return json_encode(array('error','unAuthorized request'));
        $current_customer_id = $_SESSION["customer_id"];
        log_message("drop cart,customer_id:".$current_customer_id.",product_id: ".$product_id.",spec_id: ".$spec_id);
        try{
            return json_encode($this->order_online_model->drop_product_cart($current_customer_id,$product_id,$spec_id));
        }catch (Exception $ex){
            log_message('error',"exception occurred when drop cart,".$ex->getMessage());
            return json_encode(array("error"=>$ex->getMessage()));
        }

    }

    public function checkScore($total_score){
        if(!$this->checkSession())
            return json_encode(array('error','unAuthorized request'));
        $current_customer_id = $_SESSION["customer_id"];
        log_message("check if customer;s total score is valid,customer_id:".$current_customer_id);
        try {
            //TODO front-end need to produce $total_score by product list in shopping cart
            return json_encode($this->customer_model->check_customer_score($current_customer_id, $total_score));
        }catch (Exception $ex){
            log_message('error',"exception occurred when check score,".$ex->getMessage());
            return json_encode(array("error"=>$ex->getMessage()));
        }
    }

    public function make($delivery_id,$delivery_thirdparty_code,$product_list){
        if(!$this->checkSession())
            return json_encode(array('error','unAuthorized request'));
        $current_customer_id = $_SESSION["customer_id"];
        //TODO how to populcate $product_list?
        try{
            return json_encode($this->order_online_model->add_order($current_customer_id,$delivery_id,$delivery_thirdparty_code,$product_list));
        }catch (Exception $ex){
            log_message('error',"exception occurred when make order,".$ex->getMessage());
            return json_encode(array("error"=>$ex->getMessage()));
        }

    }

    public function checkSession(){
        if(isset($_SESSION["customer_id"])){
            return true;
        }else
            return false;
    }

} 