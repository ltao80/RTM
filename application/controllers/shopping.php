<?php
/**
 * Created by PhpStorm.
 * User: richard
 * Date: 15-5-1
 * Time: 下午3:47
 */

class Shopping extends CI_Controller {

    public function index($openId){
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
            $this->customer_model->add_customer_info("", "", "", "", $openId);
            log_message("info", "get the visit user openId: " . $openId);
            $data['customer_list'] =  array(
                'name' => " 新注册用户",
                'address' => "",
                'phone' => "",
                'email' => "",
                "total_score" => 0,
                'wechat_id' => $openId
            );
        }else{
            $data['customer_list'] = $this->customer_model->get_customer_by_wechat_id($openId);
        }

        $data['promation_list'] = $this->product_model->get_product_for_exchange();

        log_message("info", "get the visit user openId: " . $openId);
        $this->load->view('shopping/home',$data);
    }
} 