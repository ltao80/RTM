<?php
/**
 * Created by PhpStorm.
 * User: richard
 * Date: 15-4-30
 * Time: 下午5:41
 */

class Order_online extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->output->set_header('Content-Type: text/html; charset=utf8');
    }

    public function list_cart() {
        if(!$this->checkSession())
            $this->load->view('error.php',"unAuthorized request");
        $current_customer_id = $this->session->userdata("customer_id");
        log_message("info","list cart,customer_id:".$current_customer_id);
        try{
            $customer_total_score = $this->customer_model->get_score_by_customer_id($current_customer_id);
            $product_list = $this->order_online_model->get_cart_product_list($current_customer_id);
            $data['product_list'] = $product_list == null?array(): $product_list ;
            $data['customer_total_score'] = $customer_total_score;
            $this->load->view('shopping/cart.php', $data);
        }catch (Exception $ex){
            log_message('error',"exception occurred when list cart,".$ex->getMessage());
            $this->load->view('error.php',"exception occurred when get product list for cart");
        }
    }

    public function add_cart(){
        $this->output->set_header('Content-Type: application/json; charset=utf8');
        if(!$this->checkSession())
            $this->load->view('error.php',"unAuthorized request");
        $current_customer_id =$this->session->userdata("customer_id");
        $product_id = $_POST['data']['id'];
        $spec_id = $_POST['data']['size'];
        //TODO 临时写死
        $spec_id = "100";
        $product_num = $_POST['data']['count'];
        log_message("add cart,customer_id:".$current_customer_id.",product_id: ".$product_id.",spec_id: ".$spec_id.",product_num:".$product_num);
        try{
            return json_encode($this->order_online_model->add_product_cart($current_customer_id,$product_id,$spec_id,$product_num));
        }catch (Exception $ex){
            log_message('error',"exception occurred when add cart,".$ex->getMessage());
            return json_encode(array("error"=>$ex->getMessage()));
        }
    }

    public function drop_cart($product_id,$spec_id){
        if(!$this->checkSession())
            $this->load->view('error.php',"unAuthorized request");
        $current_customer_id = $this->session->userdata("customer_id");
        log_message("drop cart,customer_id:".$current_customer_id.",product_id: ".$product_id.",spec_id: ".$spec_id);
        try{
            return json_encode($this->order_online_model->drop_product_cart($current_customer_id,$product_id,$spec_id));
        }catch (Exception $ex){
            log_message('error',"exception occurred when drop cart,".$ex->getMessage());
            return json_encode(array("error"=>$ex->getMessage()));
        }
    }

    public function checkScore($total_score){
        if(!$this->checkSession())
            $this->load->view('error.php',"unAuthorized request");
        $current_customer_id = $this->session->userdata("customer_id");
        log_message("check if customer;s total score is valid,customer_id:".$current_customer_id);
        try {
            //TODO front-end need to produce $total_score by product list in shopping cart
            return json_encode($this->customer_model->check_customer_score($current_customer_id, $total_score));
        }catch (Exception $ex){
            log_message('error',"exception occurred when check score,".$ex->getMessage());
            return json_encode(array("error"=>$ex->getMessage()));
        }
    }

    /**
     * 选择收货地址，留言
     */
    public function confirm_order(){
        try{
            if(!$this->checkSession())
                $this->load->view('error.php',"unAuthorized request");
            $current_customer_id = $this->session->userdata("customer_id");
            log_message("info","check if customer;s total score is valid,customer_id:".$current_customer_id);
            //查询送货地址
            $delivery_list = $this->customer_model->get_customer_delivery_list($current_customer_id);
            $data["delivery_list"] = $delivery_list;
            $this->load->view('shopping/order-confirm.php', $data);
        }catch (Exception $ex){
            log_message('error',"exception occurred when confirm order,".$ex->getMessage());
            $this->load->view('error.php',"exception occurred when confirm order");
        }
    }

    public function make($delivery_id,$delivery_thirdparty_code,$product_list,$message){
        if(!$this->checkSession())
            $this->load->view('error.php',"unAuthorized request");
        $current_customer_id = $this->session->userdata("customer_id");
        //TODO how to populcate $product_list?
        try{
            return json_encode($this->order_online_model->add_order($current_customer_id,$delivery_id,$delivery_thirdparty_code,$product_list,$message));
        }catch (Exception $ex){
            log_message('error',"exception occurred when make order,".$ex->getMessage());
            return json_encode(array("error"=>$ex->getMessage()));
        }
    }

    public function order_list(){
        if(!$this->checkSession())
            $this->load->view('error.php',"unAuthorized request");
        try{
            $customer_id = $this->session->userdata("customer_id");
            $order_list = $this->order_online_model->get_order_list($customer_id);
            $data['order_list'] = isset($order_list)?$order_list : array();
            $this->load->view('shopping/order-list.php', $data);
        }catch (Exception $ex){
            log_message('error',"exception occurred when make order,".$ex->getMessage());
            return json_encode(array("error"=>$ex->getMessage()));
        }
    }

    public function order_detail($order_code){
        if(!$this->checkSession())
            $this->load->view('error.php',"unAuthorized request");
        try{
            $order_detail = $this->order_online_model->get_order_detail($order_code);
            $data['order_detail'] = $order_detail;
            $this->load->view('shopping/order-detail.php', $data);
        }catch (Exception $ex){
            log_message('error',"exception occurred when make order,".$ex->getMessage());
            $this->load->view('error.php',"exception occurred when query order detail");
        }
    }

    public function checkSession(){
        $customer_id = $this->session->userdata("customer_id");
        if(isset($customer_id)){
            return true;
        }else
            return false;
    }

} 