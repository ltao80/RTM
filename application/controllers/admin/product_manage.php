<?php
/**
 * Created by PhpStorm.
 * User: liutao
 * Date: 15-5-23
 * Time: 下午1:21
 */

class Product_Manage extends LP_Controller {

    public function __construct()
    {
        parent::__construct();
    }

    function list_products(){
        log_message("info,","get product for exchange list");
        $user_data = $this->verify_current_user("/admin/product_manage/list_products");
        if(!empty($user_data["error"])){
            $this->load->view("admin/error.php",$user_data);
            return;
        }
        try{
            $type = $this->input->post("type");
            $status = $this->input->post("status");
            $pageSize = '20';

            $data = $this->product_model->get_exchange_list($type,$status,$pageSize,intval($this->uri->segment(3)));
            $total_nums = $this->product_model->count_exchange_list($type,$status);
            $product_data['pager'] = $this->create_pagination("/admin/product_manageget_exchange_list/",$total_nums,$pageSize);
            $product_data['data'] = $data;

            $this->load->view("admin/product_list",$product_data);
        }catch (Exception $ex){
            log_message("error,","exception occurred when get exchange list,".$ex->getMessage());
            $data['error'] = "获取兑换商品列表失败";
            $this->load->view("error.php",$data);
        }
    }
    function new_product(){
        log_message("info,","new product");
        //echo "this is new product page";exit;
        //$user_data = $this->verify_current_user("/admin/product_manage/new_product");
        if(!empty($user_data["error"])){
            $this->load->view("admin/error.php",$user_data);
            return;
        }
        $this->load->view("/admin/add_product.php");
    }

    function add_product(){
        log_message("info,","add product");
        $user_data = $this->verify_current_user("/admin/product_manage/add_product");
        if(!empty($user_data["error"])){
            $this->load->view("admin/error.php",$user_data);
            return;
        }
        try{
            $type = $this->input->post("type");
            $name = $this->input->post("name");
            $description = $this->input->post("description");
            $title = $this->input->post("title");
            $thumb_name = $this->input->post("thumb_name");
            $image_name = $this->input->post("image_url");
            $spec = $this->input->post("spec");//格式为json格式[{"spec_id":1,"score":"100","stock_num":"100","status":0},{"spec_id":1,"score":"100","stock_num":"100","status":0}]  解析增加product_id 存入数据库中
            $status = $this->input->post("status");
            $isExchange = $this->input->post("isExchange");
            $result = $this->product_model->add_product($type,$name,$description,$title,$thumb_name,$image_name,$spec,$status,$isExchange);

            $this->output->set_output($result);
        }catch (Exception $ex){
            log_message("error,","exception occurred when add product,".$ex->getMessage());
            $data['error'] = "添加商品失败";
            $this->load->view('error.php',$data);
        }

    }

    function update_product(){
        log_message("info,","update product");
        $user_data = $this->verify_current_user("/admin/product_manage/update_product");
        if(!empty($user_data["error"])){
            $this->load->view("admin/error.php",$user_data);
            return;
        }
        try{
            $pId = $this->input->post("pId");
            $type = $this->input->post("type");
            $name = $this->input->post("name");
            $description = $this->input->post("description");
            $title = $this->input->post("title");
            $thumb_name = $this->input->post("thumb_name");
            $image_name = $this->input->post("image_url");
            $spec = $this->input->post("spec");//格式为json格式[{"spec_id":1,"score":"100","stock_num":"100","status":0},{"spec_id":1,"score":"100","stock_num":"100","status":0}]  解析增加product_id 存入数据库中
            $status = $this->input->post("status");
            $isExchange = $this->input->post("isExchange");
            $result = $this->product_model->update_product($pId,$type,$name,$description,$title,$thumb_name,$image_name,$spec,$status,$isExchange);

            $this->out_put->set_output($result);
        }catch (Exception $ex){
            log_message("error,","exception occurred when update product".$ex->getMessage());
            $data['error'] = "更新商品失败";
            $this->load->view('error.php',$data);
        }

    }

    function delete_product(){
        log_message("info,","delete product");
        $user_data = $this->verify_current_user("/admin/product_management/delete_product");
        if(!empty($user_data["error"])){
            $this->load->view("admin/error.php",$user_data);
            return;
        }
        try{
            $sId = $this->input->post("sId");
            $result = $this->product_model->delete_product($sId);

            $this->output->set_output($result);
        }catch (Exception $ex){
            log_message("error,","delete product".$ex->getMessage());
            $data['error'] = "删除商品失败";
            $this->load->view("error.php",$data);
        }
    }

    function update_exchange_status(){
        log_message("info,","update exchage product status");
        $user_data = $this->verify_current_user("/admin/product_manage/update_exchange_status");
        if(!empty($user_data["error"])){
            $this->load->view("admin/error.php",$user_data);
            return;
        }
        try{
            $status = $this->input->post("status");
            $sIds = $this->input->post("sIds");
            $result = $this->product_model->update_exchange_status($sIds,$status);

            $this->output->set_output($result);
        }catch (Exception $ex){
            log_message("error,","exception occurred when update exchange status".$ex->getMessage());
            $data['error'] = "更改兑换商品的状态";
            $this->load->view("error.php",$data);
        }
    }

    function upload_product_image(){
        log_message("info,","upload product image");
        $user_data = $this->verify_current_user("/admin/product_manage/upload_product_image");
        if(!empty($user_data["error"])){
            $this->load->view("admin/error.php",$user_data);
            return;
        }
        try{
            $config['upload_path'] =   './upload/';
            $config['allowed_types'] = 'gif|jpg|png';
            $config['max_size'] = '1024';
            $config['max_width']  = '1024';
            $config['max_height']  = '768';

            $this->load->library('upload', $config);
            if(!$this->upload->do_upload('cs_ap_img'))
            {
                echo $this->upload->display_errors();
            }else{
                $data['upload_data']=$this->upload->data();  //文件的一些信息
                $img=$data['upload_data']['file_name'];//取得文件名
                $thumb = $this->make_thumb_url($img);
                return $this->output->set_output(json_encode(array("thumb" => $thumb,"image" => $img)));
            }
        }catch (Exception $ex){
            log_message("error,","exception occurred when upload product image ".$ex->getMessage());
            $data['error'] = "上传图片失败";
            $this->load->view("error.php",$data);
        }

    }

    function make_thumb_url($image){
        $this->load->library('image_lib');
        $config['image_library'] = 'gd2';
        $config['source_image'] = '/upload/'.$image;
        $config['create_thumb'] = TRUE;
        $config['maintain_ratio'] = TRUE;
        $config['width'] = 75;
        $config['height'] = 50;
        $config['new_image'] = '/upload/';//(必须)设置图像的目标名/路径。
        $config['width'] = 75;//(必须)设置你想要得图像宽度。
        $config['height'] = 50;//(必须)设置你想要得图像高度
        $config['maintain_ratio'] = TRUE;//维持比例
        $config['x_axis'] = '30';//(必须)从左边取的像素值
        $config['y_axis'] = '40';
        $this->load->library('image_lib', $config);
        $this->image_lib->initialize($config);
        $res = $this->image_lib->resize();
        if(!$res){
            echo $this->image_lib->display_errors();
        }
    }

    function get_product_by_id(){
        log_message("info,","get product by id");
        $user_data = $this->verify_current_user("/admin/product_manage/get_product_by_id");
        if(!empty($user_data["error"])){
            $this->load->view("admin/error.php",$user_data);
            return;
        }
        try{
            $pId = $this->input->post("sId");
            $data = $this->product_model->get_product_by_id($pId);
            $data['data'] = $data;
            $this->load->view("admin/product_detail",$data);
        }catch (Exception $ex){
            log_message("error,","exception occurred when get product by id".$ex->getMessage());
            $data['error'] = "获取商品详情失败";
            $this->load->view("error.php",$data);
        }

    }

    function get_category_list(){
        log_message("info,","get category list");
        $user_data = $this->verify_current_user("/admin/product_manage/get_category_list");
        if(!empty($user_data["error"])){
            $this->load->view("admin/error.php",$user_data);
            return;
        }
        try{
            $category = $this->product_model->get_category_list();
            $this->output->set_output(json_encode($category));
        }catch (Exception $ex){
            log_message("error,","exception occurred when get category_list");
            $data['error'] = "获取商品类别失败";
            $this->load->view("error.php",$data);
        }
    }
}