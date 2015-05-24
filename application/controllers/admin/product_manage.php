<?php
/**
 * Created by PhpStorm.
 * User: liutao
 * Date: 15-5-23
 * Time: 下午1:21
 */

class product_manage extends CI_Controller {

    function get_exchange_list(){
        $this->output->set_header('Content-Type: text/html; charset=utf8');
        $this->load->helper('url');
        if(!$this->session->userdata('login')){
            echo 'forbidden to come in !';
            redirect($this->config->item('base_url').'pg_admin/login/');
        }

        $type = $this->input->post("type");
        $status = $this->input->post("status");
        $pageSize = '20';//每页的数据

        $data = $this->product_model->get_exchange_list($type,$status,$pageSize,intval($this->uri->segment(3)));
        $total_nums = $this->product_model->count_exchange_list($type,$status); //这里得到从数据库中的总页数
        $this->load->library('pagination');
        $config['base_url'] = $this->config->item('base_url').'/index.php/pg_admin/get_exchange_list/';
        $config['total_rows'] = $total_nums;//总共多少条数据
        $config['per_page'] = $pageSize;//每页显示几条数据
        $config['full_tag_open'] = '<p>';
        $config['full_tag_close'] = '</p>';
        $config['first_link'] = '首页';
        $config['first_tag_open'] = '<li>';//“第一页”链接的打开标签。
        $config['first_tag_close'] = '</li>';//“第一页”链接的关闭标签。
        $config['last_link'] = '尾页';//你希望在分页的右边显示“最后一页”链接的名字。
        $config['last_tag_open'] = '<li>';//“最后一页”链接的打开标签。
        $config['last_tag_close'] = '</li>';//“最后一页”链接的关闭标签。
        $config['next_link'] = '下一页';//你希望在分页中显示“下一页”链接的名字。
        $config['next_tag_open'] = '<li>';//“下一页”链接的打开标签。
        $config['next_tag_close'] = '</li>';//“下一页”链接的关闭标签。
        $config['prev_link'] = '上一页';//你希望在分页中显示“上一页”链接的名字。
        $config['prev_tag_open'] = '<li>';//“上一页”链接的打开标签。
        $config['prev_tag_close'] = '</li>';//“上一页”链接的关闭标签。
        $config['cur_tag_open'] = '<li class="current">';//“当前页”链接的打开标签。
        $config['cur_tag_close'] = '</li>';//“当前页”链接的关闭标签。
        $config['num_tag_open'] = '<li>';//“数字”链接的打开标签。
        $config['num_tag_close'] = '</li>';
        $this->pagination->initialize($config);
        //$data['links'] = $this->pagination->create_links();
        $data['data'] = $data;
        $this->load->view('admin/product_list',$data);
    }

    function add_product(){
        try{
            $this->load->helper('url');
            if(!$this->session->userdata('login')){
                echo 'forbidden to come in !';
                redirect($this->config->item('base_url').'pg_admin/login/');
            }
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
            $this->load->view('error.php',$ex->getMessage());
        }

    }

    function update_product(){
        try{
            $this->load->helper('url');
            if(!$this->session->userdata('login')){
                echo 'forbidden to come in !';
                redirect($this->config->item('base_url').'pg_admin/login/');
            }
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
            $this->load->view('error.php',$ex->getMessage());
        }

    }

    function delete_product(){
        $this->output->set_header('Content-Type: text/html; charset=utf8');
        $this->load->helper('url');
        if(!$this->session->userdata('login')){
            echo 'forbidden to come in !';
            redirect($this->config->item('base_url').'pg_admin/login/');
        }

        $sId = $this->input->post("sId");
        $result = $this->product_model->delete_product($sId);

        $this->output->set_output($result);
    }

    function update_exchange_status(){
        $this->output->set_header('Content-Type: text/html; charset=utf8');
        $this->load->helper('url');
        if(!$this->session->userdata('login')){
            echo 'forbidden to come in !';
            redirect($this->config->item('base_url').'pg_admin/login/');
        }
        $status = $this->input->post("status");
        $sIds = $this->input->post("sIds");
        $result = $this->product_model->update_exchange_status($sIds,$status);

        $this->output->set_output($result);
    }

    function upload_product_image(){
        $config['upload_path'] =   './upload/';            //这个路径很重要
        $config['allowed_types'] = 'gif|jpg|png';
        $config['max_size'] = '1024';
        $config['max_width']  = '1024';
        $config['max_height']  = '768';

        $this->load->library('upload', $config);
        if(!$this->upload->do_upload('cs_ap_img'))
        {
            echo $this->upload->display_errors();
        }
        else
        {
            $data['upload_data']=$this->upload->data();  //文件的一些信息
            $img=$data['upload_data']['file_name'];//取得文件名
            $thumb = $this->make_thumb_url($img);

            return $this->output->set_output(json_encode(array("thumb" => $thumb,"image" => $img)));
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
        $this->output->set_header('Content-Type: text/html; charset=utf8');
        $this->load->helper('url');
        if(!$this->session->userdata('login')){
            echo 'forbidden to come in !';
            redirect($this->config->item('base_url').'pg_admin/login/');
        }

        $pId = $this->input->post("sId");
        $data = $this->product_model->get_product_by_id($pId);
        $data['data'] = $data;
        $this->load->view("admin/product_detail",$data);
    }

    function get_category_list(){
        $this->output->set_header('Content-Type: text/html; charset=utf8');
        $this->load->helper('url');
        if(!$this->session->userdata('login')){
            echo 'forbidden to come in !';
            redirect($this->config->item('base_url').'pg_admin/login/');
        }

        $category = $this->product_model->get_category_list();

        $this->output->set_output(json_encode($category));
    }
}