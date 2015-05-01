<?php
/**
 * Created by PhpStorm.
 * User: richard
 * Date: 15-4-30
 * Time: 下午5:42
 */

class Customer extends CI_Controller {

    public function getBasicInfo($id){
        $this->customer_model->get_customer_info($id);
    }

} 