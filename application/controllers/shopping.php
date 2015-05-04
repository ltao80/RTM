<?php
/**
 * Created by PhpStorm.
 * User: richard
 * Date: 15-5-1
 * Time: 下午3:47
 */

class Shopping extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->output->set_header('Content-Type: text/html; charset=utf8');
    }

    public function index($openId=''){
        $data = array("version" => $this->config->config["static_version"]);
        $this->load->view('shopping/index.php',$data);
    }

    public function home($openId){
        /*
         * 1, get the user info
         * 2, get the promation list
         * 3, url: http://domain/shopping/index/{openId}
         * 4, if the openid is not exist, register it.
         */

        $is_exist = $this->customer_model->check_customer_by_wechat_id($openId);
        log_message("info", "get the visit user openId: " . $openId);
        $data = array();
        if (!$is_exist) {
            $name = "";
            $province = "";
            $city = "";
            $region = "";
            $address = "";
            $phone = "";
            $birthday = "";
            $email = "";
            $wechat_id = $openId;

            $new_customer_id= $this->customer_model->add_customer_info($name,$province,$city,$region,$address,$phone,$birthday,$email,$wechat_id);
            log_message("info", "return the add customer result :".$result);
            $data['customer_list'] =  array(
                'name' => $name,
                'province' => $province,
                'city' => $city,
                'region' =>$region,
                'address' => $address,
                'phone' => $phone,
                'email' => $email,
                "total_score" => 0,
                'wechat_id' => $wechat_id,
                'id' => $new_customer_id
            );
        }else{
            $data['customer_list'] = $this->customer_model->get_customer_by_wechat_id($openId);
            log_message("info", "return the add customer result :".var_export($data['customer_list'], true));
        }
        $array_items = array('wechat_id' => '', 'customer_id' => '');
        $this->session->unset_userdata($array_items);
        $this->session->set_userdata('wechat_id',$data['customer_list']['wechat_id']);
        $this->session->set_userdata('customer_id',$data['customer_list']['id']);

        $data['promation_list'] = $this->product_model->get_product_for_exchange();
        log_message("info", "return the promation list result is :".var_export($data['promation_list'], true));

        $this->load->view('shopping/home',$data);
    }


} 