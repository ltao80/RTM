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

    public function score_list()
    {
        if(!$this->checkSession())
            $this->load->view('error.php','unAuthorized request');

        $current_customer_id = $this->session->userdata["customer_id"];
        log_message("info","get customer score list,customer_id:".$current_customer_id);
        try{
            $customer_info = $this->customer_model->get_customer_by_customer_id($current_customer_id);
            $score_list = $this->customer_model->get_consumer_score_list($current_customer_id);
            $data['score_list'] = $score_list;
            $data['customer_info'] = $customer_info;
            $this->load->view('shopping/score-list.php', $data);
        }catch (Exception $ex){
            log_message('error',"exception occurred when list customer score,".$ex->getMessage());
            $this->load->view('error.php',$ex->getMessage());
        }

    }

    public function score_detail($order_code,$order_type){
        if(!$this->checkSession())
            $this->load->view('error.php','unAuthorized request');

        $current_customer_id = $this->session->userdata["customer_id"];
        log_message("info","get customer score detail,customer_id:".$current_customer_id);
        try{
            $detail = $this->customer_model->get_customer_score_detail($order_code,$order_type);
            $data["score_list"] = $detail;
            $this->load->view('shopping/score-detail.php',$data);
        }catch (Exception $ex){
            log_message('error',"exception occurred when list customer score,".$ex->getMessage());
            $this->load->view('error.php',$ex->getMessage());
        }
    }

    public function checkSession(){
        $wechat_id = $this->session->userdata('wechat_id');
        if(isset($wechat_id)){
            return true;
        }else
            return false;
    }
}