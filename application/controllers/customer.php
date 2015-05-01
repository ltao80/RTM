<?php
/**
 * Created by PhpStorm.
 * User: richard
 * Date: 15-4-30
 * Time: 下午5:42
 */

class Customer extends CI_Controller {

    public function get($id){
        $this->customer_model->get_customer_info($id);
    }

    public function add($name,$address,$phone,$email,$wechat_id){
        $this->customer_model->add_customer_info($name,$address,$phone,$email,$wechat_id);
    }

    public function update($id,$name,$address,$phone,$email,$wechat_id){
        $this->customer_model->update_customer_info($id,$name,$address,$phone,$email,$wechat_id);
    }


} 