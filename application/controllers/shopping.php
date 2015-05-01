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
         */
        $user_info = $this->customer_model->get_last_ten_entries();
        $this->customer_model->get_customer_info($id);
    }
} 