<?php
/**
 * Created by PhpStorm.
 * User: liutao
 * Date: 15-5-24
 * Time: 下午12:39
 */

class LP_Controller extends CI_Controller{

    public function __construct()
    {
        parent::__construct();
    }


    /**
     * verify current user and return use info and user menu
     * @param $permission
     * @return array
     */
    function verify_current_user($permission){
        $user_info = array();
        $user_info['menu_status'] = $this->session->userdata['menu_status'];
        if (empty($this->session->userdata["user_id"])) {
            log_message('warn','session has expired,redirect to login');
            if(!empty($permission)){
                redirect('admin/user_manage/login/'.$permission);
            }else{
                redirect('admin/user_manage/login');
            }
        }else{
            $user_id = $this->session->userdata["user_id"];
            $role_name = $this->session->userdata['role_name'];
            $error_message = "";
            if(!empty($permission)){
                $positions = array();
                $pos = -1;
                while (($pos = strpos($permission, '/', $pos+1)) !== false) {
                    $positions[] = $pos;
                }
                if(count($positions) > 3){
                    $permission_action = substr($permission,0,$positions[2]);
                }else{
                    $permission_action = $permission;
                }

                $result =  $this->user_model->check_user_permission($user_id,$role_name,$permission_action);
                if(!$result){
                    $error_message = "您没有权限访问该页面";
                }
            }else{
                $error_message = "请求参数异常";
            }
            $user_info['user_name'] = $this->session->userdata["user_name"];
            $user_info['store_name'] = $this->session->userdata["store_name"];

            $user_menu = $this->user_model->get_permission_menus_by_user_id($this->session->userdata["user_id"]);

            //handle selected menu
            if(!empty($permission)){
                foreach ($user_menu as &$main_menu) {
                    if($main_menu['permission_action'] == $permission){
                        $main_menu['selected'] = true;
                    }
                    foreach($main_menu['sub_menu'] as &$sub_menu){
                        if($sub_menu['permission_action'] == $permission){
                            $sub_menu['selected'] = true;
                            $main_menu['selected'] = true;
                        }
                    }
                }
            }
            $result = array(
                "user_info" => $user_info,
                "user_menu" => $user_menu
            );
            if(!empty($error_message)){
                $result['error'] = $error_message;
            }
            return $result;
        }
    }

    function create_pagination($base_url,$total_count,$page_size){
        $this->load->library('pagination');
        $config['base_url'] = $this->config->item('base_url').$base_url;
        $config['total_rows'] = $total_count;//总共多少条数据
        $config['per_page'] = $page_size;//每页显示几条数据
        $config['full_tag_open'] = '';
        $config['full_tag_close'] = '';
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
        $config['cur_tag_open'] = '<li class="active"><a href="javascript:void(0)">';//“当前页”链接的打开标签。
        $config['cur_tag_close'] = '</a></li>';//“当前页”链接的关闭标签。
        $config['num_tag_open'] = '<li>';//“数字”链接的打开标签。
        $config['num_tag_close'] = '</li>';
        $config['uri_segment'] = 4;
        $config['use_page_numbers'] = TRUE;
        $config['page_query_string'] = TRUE;
        $this->pagination->initialize($config);

        return $this->pagination->create_links();
    }

}