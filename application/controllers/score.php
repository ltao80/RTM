<?php
/**
 * Created by PhpStorm.
 * User: liutao
 * Date: 5/1/15
 * Time: 8:27 PM
 */


class Score extends CI_Controller
{
    function __construct() {
        parent::__construct();
        $this->output->set_header('Content-Type: application/json; charset=utf8');
    }

    public function getList()
    {
        if(!$this->checkSession())
            return json_encode(array('error','unAuthorized request'));
        $current_customer_id = $_SESSION["customer_id"];
        log_message("get customer score list,customer_id:".$current_customer_id);
        try{
            return json_encode($this->customer_model->get_customer_score_list($current_customer_id));
        }catch (Exception $ex){
            log_message('error',"exception occurred when list customer score,".$ex->getMessage());
            return json_encode(array("error"=>$ex->getMessage()));
        }

    }

    public function getDetail($order_code,$order_type){
        if(!$this->checkSession())
            return json_encode(array('error','unAuthorized request'));
        $current_customer_id = $_SESSION["customer_id"];
        log_message("get customer score detail,customer_id:".$current_customer_id);
        try{
            return json_encode($this->customer_model->get_customer_score_detail($order_code,$order_type));
        }catch (Exception $ex){
            log_message('error',"exception occurred when list customer score,".$ex->getMessage());
            return json_encode(array("error"=>$ex->getMessage()));
        }

    }
}