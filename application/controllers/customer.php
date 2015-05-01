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
        if(!$this->checkSession())
            return json_encode(array('error','unAuthorized request'));
        log_message("info","get customer by id: ".$id);
        try{
            $customer_info = $this->customer_model->get_customer_info($id);
        }catch (Exception $ex){
            log_message('error',"exception occurred when add customer,".$ex->getMessage());
            return json_encode(array("error"=>$ex->getMessage()));
        }

        if(is_null($customer_info)){
            return json_encode(array("error"=>'can not found customer by id: '.$id));
        }else{
            return json_encode($customer_info);
        }
    }

    public function add(){
        if(!$this->checkSession())
            return json_encode(array('error','unAuthorized request'));
        $name = $_POST['name'];
        $birthday = $_POST['birthday'];
        $phone = $_POST['phone'];
        $email = $_POST['email'];
        $wechat_id = $_POST["wechat_id"];
        log_message("info","add customer information,name:".$name.",address: ".$address.",phone: ".$phone.",email: ".$email."birthday: ".$birthday."wechat_id: ".$wechat_id);
        try{
            return json_encode($this->customer_model->add_customer_info($name,$address,$phone,$birthday,$email,$wechat_id));
        }catch (Exception $ex){
            log_message('error',"exception occurred when add customer,".$ex->getMessage());
            return json_encode(array("error"=>$ex->getMessage()));
        }

    }

    public function update(){
        if(!$this->checkSession())
            return json_encode(array('error','unAuthorized request'));
        $name = $_POST['name'];
        $birthday = $_POST['birthday'];
        $phone = $_POST['phone'];
        $email = $_POST['email'];
        $wechat_id = $_POST["wechat_id"];
        $id = $_POST["id"];
        
        log_message("info","update customer information,name:".$name.",address: ".$address.",phone: ".$phone.",email: ".$email."birthday: ".$birthday."wechat_id: ".$wechat_id.",customer_id: ".$id);
        try{
            return json_encode($this->customer_model->update_customer_info($id,$name,$address,$phone,$birthday,$email,$wechat_id));
        }catch (Exception $ex){
            log_message('error',"exception occurred when update customer,".$ex->getMessage());
            return json_encode(array("error"=>$ex->getMessage()));
        }
    }

    public function addDelivery($receiver_name,$receiver_phone,$receiver_province,$receiver_city,$receiver_region,$receiver_address,$is_default){
        if(!$this->checkSession())
            return json_encode(array('error','unAuthorized request'));

        $current_customer_id = $_SESSION["customer_id"];
        try{
            return json_encode($this->customer_model->add_customer_delivery($current_customer_id,$receiver_name,$receiver_phone,$receiver_province,$receiver_city,$receiver_region,$receiver_address,$is_default));
        }catch (Exception $ex){
            log_message('error',"exception occurred when add customer delivery,".$ex->getMessage());
            return json_encode(array("error"=>$ex->getMessage()));
        }

    }

    public function updateDelivery($receive_id,$receiver_name,$receiver_phone,$receiver_province,$receiver_city,$receiver_region,$receiver_address,$is_default){
        if(!$this->checkSession())
            return json_encode(array('error','unAuthorized request'));
        $this->customer_model->update_customer_delivery($receive_id,$receiver_name,$receiver_phone,$receiver_province,$receiver_city,$receiver_region,$receiver_address,$is_default);
    }

    public function listDelivery(){
        if(!$this->checkSession())
            return json_encode(array('error','unAuthorized request'));
        $current_customer_id = $_SESSION["customer_id"];
        return $this->customer_model->get_customer_delivery_list($current_customer_id);
    }

    public function deleteDelivery($delivery_id){
        return $this->customer_model->delete_customer_delivery($delivery_id);
    }

    public function checkSession(){
        if(isset($_SESSION["customer_id"])){
            return true;
        }else
            return false;
    }

} 