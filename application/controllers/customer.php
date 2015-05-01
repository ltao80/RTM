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

    public function addDelivery($receiver_name,$receiver_phone,$receiver_province,$receiver_city,$receiver_region,$receiver_address,$is_default){
        $current_customer_id = $_SESSION["customer_id"];
        $this->customer_model->add_customer_delivery($current_customer_id,$receiver_name,$receiver_phone,$receiver_province,$receiver_city,$receiver_region,$receiver_address,$is_default);
    }

    public function updateDelivery($receive_id,$receiver_name,$receiver_phone,$receiver_province,$receiver_city,$receiver_region,$receiver_address,$is_default){
        $this->customer_model->update_customer_delivery($receive_id,$receiver_name,$receiver_phone,$receiver_province,$receiver_city,$receiver_region,$receiver_address,$is_default);
    }

    public function listDelivery(){
        $current_customer_id = $_SESSION["customer_id"];
        return $this->customer_model->get_customer_delivery_list($current_customer_id);
    }

    public function deleteDelivery($delivery_id){
        return $this->customer_model->delete_customer_delivery($delivery_id);
    }

} 