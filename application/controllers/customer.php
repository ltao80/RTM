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
        $data['id'] = $id;
        $this->load->view('shopping/info', $data);
    }

    public function get(){
        //if(!$this->checkSession())
        //    return json_encode(array('error','unAuthorized request'));
        $id = $_GET["id"];
        log_message("info","get customer by id: ".$id);
        try{
            $customer_info = $this->customer_model->get_customer_by_customer_id($id);
        }catch (Exception $ex){
            log_message('error',"exception occurred when add customer,".$ex->getMessage());
            return json_encode(array("error"=>$ex->getMessage()));
        }

        if(!isset($customer_info)){
            return json_encode(array("error"=>'can not found customer by id: '.$id));
        }else{
            $this->load->view('shopping/info.php', $customer_info);
        }
    }

    public function add(){
        if(!$this->checkSession())
            return json_encode(array('error','unAuthorized request'));
        $name = $_POST['name'];
        $birthday = $_POST['birthday'];
        $phone = $_POST['phone'];
        $email = $_POST['email'];
        $address = $_POST['address'];
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

    public function addDelivery(){
        if(!$this->checkSession())
            return json_encode(array('error','unAuthorized request'));
        $receiver_name = $_POST['receiver_name'];
        $receiver_phone = $_POST['receiver_phone'];
        $receiver_province = $_POST['receiver_province'];
        $receiver_city = $_POST['receiver_city'];
        $receiver_region = $_POST['receiver_region'];
        $receiver_address = $_POST['receiver_address'];
        $is_default = $_POST["is_default"];
        $current_customer_id = $_SESSION["customer_id"];
        log_message("info","add delivery,customer id: ".$current_customer_id);
        try{
            return json_encode($this->customer_model->add_customer_delivery($current_customer_id,$receiver_name,$receiver_phone,$receiver_province,$receiver_city,$receiver_region,$receiver_address,$is_default));
        }catch (Exception $ex){
            log_message('error',"exception occurred when add customer delivery,".$ex->getMessage());
            return json_encode(array("error"=>$ex->getMessage()));
        }

    }

    public function updateDelivery(){
        if(!$this->checkSession())
            return json_encode(array('error','unAuthorized request'));
        $receive_id = $_GET['receive_id'];
        $receiver_name = $_POST['receiver_name'];
        $receiver_phone = $_POST['receiver_phone'];
        $receiver_province = $_POST['receiver_province'];
        $receiver_city = $_POST['receiver_city'];
        $receiver_region = $_POST['receiver_region'];
        $receiver_address = $_POST['receiver_address'];
        $is_default = $_POST["is_default"];
        $current_customer_id = $_SESSION["customer_id"];
        log_message("info","update delivery,customer id: ".$current_customer_id);
        try{
            return json_encode($this->customer_model->update_customer_delivery($receive_id,$receiver_name,$receiver_phone,$receiver_province,$receiver_city,$receiver_region,$receiver_address,$is_default));
        }catch (Exception $ex){
            log_message('error',"exception occurred when update customer delivery,".$ex->getMessage());
            return json_encode(array("error"=>$ex->getMessage()));
        }

    }

    public function listDelivery(){
        if(!$this->checkSession())
            return json_encode(array('error','unAuthorized request'));
        $current_customer_id = $_SESSION["customer_id"];
        log_message("info","list delivery,customer id: ".$current_customer_id);
        try{
            return json_encode($this->customer_model->get_customer_delivery_list($current_customer_id));
        }catch (Exception $ex){
            log_message('error',"exception occurred when list customer delivery,".$ex->getMessage());
            return json_encode(array("error"=>$ex->getMessage()));
        }

    }

    public function deleteDelivery(){
        if(!$this->checkSession())
            return json_encode(array('error','unAuthorized request'));
        $receive_id = $_GET['deceive_id'];
        log_message("info","delete delivery,id: ".$delivery_id);
        try{
            return $this->customer_model->delete_customer_delivery($delivery_id);
        }catch (Exception $ex){
            log_message('error',"exception occurred when delete customer delivery,".$ex->getMessage());
            return json_encode(array("error"=>$ex->getMessage()));
        }

    }

    public function checkSession(){
        if(isset($_SESSION["customer_id"])){
            return true;
        }else
            return false;
    }

} 