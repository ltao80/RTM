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
            $pageSize = '2';

            $data = $this->product_model->get_exchange_list($type,$status,$pageSize,intval($this->uri->segment(4)));
            $total_nums = $this->product_model->count_exchange_list($type,$status);
            $product_data['pager'] = $this->create_pagination("/admin/product_manage/list_products/",$total_nums,$pageSize);
            $product_data['data'] = $data;
            $product_data['category'] = $this->product_model->get_category_list();

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
        $user_data = $this->verify_current_user("/admin/product_manage/new_product");
        if(!empty($user_data["error"])){
            $this->load->view("admin/error.php",$user_data);
            return;
        }
        $sId = $this->input->get("sId");
        $data['category'] = $this->product_model->get_category_list();
        if(empty($sId)){
            $this->load->view("/admin/add_product.php",$data);
        }else{
            $data = $this->product_model->get_product_by_id($sId);
            $data['data'] = $data;
            $data['sId'] = $sId;
            $this->load->view("/admin/edit_product.php",$data);
        }

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
            $image = $this->input->post("image");
            $image = json_decode($image,true);
            $thumb_name = $image['thumb'];
            $image_name = $image['image'];
            $created_by = $this->session->userdata("user_id");
            $spec = $this->input->post("total");
            $spec = explode('-',$spec);
            $new_array = array();
            foreach($spec as $val){
                $data = explode(',',$val);
                $spec_id = $data[0];
                $score = $data[1];
                $stock = $data[2];
                $new_array[] = array("spec_id" => $spec_id,"score" => $score,"stock_num" => $stock);
            }
            $status = $this->input->post("status");
            isset($status) ? 1 : 0;
            $isExchange = 1;
            $result = $this->product_model->add_product($type,$name,$description,$title,$thumb_name,$image_name,$created_by,json_encode($new_array),$status,$isExchange);

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
            $sId = $this->input->post("sId");
            $pId = $this->input->post("pId");
            $type = $this->input->post("type");
            $name = $this->input->post("name");
            $description = $this->input->post("description");
            $title = $this->input->post("title");
            $thumb_name = $this->input->post("thumb_name");
            $image_name = $this->input->post("image_url");
            $spec = $this->input->post("spec_id");
            $score = $this->input->post("score");
            $stock = $this->input->post("stock_num");
            $status = $this->input->post("status");
            $isExchange = $this->input->post("isExchange");

            $result = $this->product_model->update_product($sId,$pId,$type,$name,$description,$title,$thumb_name,$image_name,$spec,$score,$stock,$status,$isExchange);

            $this->output->set_output($result);
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
            $sId = $this->input->get("sId");
            $result = $this->product_model->delete_product($sId);
            if($result){
                redirect("/admin/product_manage/list_products");
            }else{
                $data = "删除失败";
                $this->load->view("admin/error.php",$data);
            }
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
            $config['upload_path'] = 'C:\xampp\htdocs\RTM\static\admin\upload';
            $config['allowed_types'] = 'gif|jpg|png';
            $config['max_size'] = '1024';
            $config['max_width']  = '1024';
            $config['max_height']  = '768';
            $this->load->library('upload', $config);
            if(!$this->upload->do_upload('file')){

                $data['error'] = $this->upload->display_errors();
                $this->load->view("admin/error.php",$data);

            }else{

                $data['upload_data']=$this->upload->data();  //文件的一些信息
                $img=$data['upload_data']['file_name'];//取得文件名
                $image = $data['upload_data']['full_path'];
                $res = $this->make_thumb_url($image);
                if($res){
                    $thumb = explode('.',$img);
                    $thumb = $thumb[0].'-thumb.'.$thumb[1];
                    return $this->output->set_output(json_encode(array("thumb" => $thumb,"image" => $img)));
                }else{
                    return false;
                }


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
        $config['source_image'] = $image;
        $config['create_thumb'] = TRUE;
        $config['maintain_ratio'] = TRUE;
        $config['width'] = 150;
        $config['height'] = 150;
        $config['new_image'] = 'C:\xampp\htdocs\RTM\static\admin\upload';//(必须)设置图像的目标名/路径。
        $config['thumb_marker'] = '-thumb';
        $this->load->library('image_lib', $config);
        $this->image_lib->initialize($config);
        $res = $this->image_lib->resize();
        if(!$res){
            $data['error'] = $this->upload->display_errors();
            $this->load->view("admin/error.php",$data);
        }
        return $res;
    }

    function get_product_by_id(){
        log_message("info,","get product by id");
        $user_data = $this->verify_current_user("/admin/product_manage/get_product_by_id");
        if(!empty($user_data["error"])){
            $this->load->view("admin/error.php",$user_data);
            return;
        }
        try{
            $pId = $this->input->get("sId");
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
            return $category;
        }catch (Exception $ex){
            log_message("error,","exception occurred when get category_list");
            $data['error'] = "获取商品类别失败";
            $this->load->view("error.php",$data);
        }
    }
}