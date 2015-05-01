<?php
/**
 * Created by PhpStorm.
 * User: richard
 * Date: 15-4-30
 * Time: 下午5:42
 */

class Customer extends CI_Controller {

    public function index($id, $wechat_id=""){
        $data['customer_info'] = $this->customer_model->get_customer_by_customer_id($id);
        $type = "add";
        if(is_array($data) && $data !=null){
            $type = "update";
        }
        $data['type'] = $type;
        $data['wechat_id'] = $wechat_id;
        $this->load->view('shopping/info.php', $data);
    }

    public function get($id){
        $this->customer_model->get_customer_info($id);
    }

    public function add(){
        $name = $_POST['name'];
        $birthday = $_POST['birthday'];
        $phone = $_POST['phone'];
        $email = $_POST['email'];
        $wechat_id = $_POST["wechat_id"];
        $result = $this->customer_model->add_customer_info($name,$birthday,$phone,$email,$wechat_id);
        if($result){
            return json_decode(array("success" => true, "message" => $result));
        } else {
            return json_decode(array("success" => false, "message" => $result));
        }
    }

    public function update(){
        $name = $_POST['name'];
        $birthday = $_POST['birthday'];
        $phone = $_POST['phone'];
        $email = $_POST['email'];
        $wechat_id = $_POST["wechat_id"];
        $id = $_POST["id"];
        $result = $this->customer_model->update_customer_info($id,$name,$birthday,$phone,$email,$wechat_id);
        if($result){
            return json_decode(array("success" => true, "message" => $result));
        } else {
            return json_decode(array("success" => false, "message" => $result));
        }
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