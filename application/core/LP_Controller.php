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
     * verify current user, include session and permission
     * @param $permission
     */
    function verify_current_user($permission)
    {
        if (empty($this->session->userdata["user_id"])) {
            log_message('warn','session has expired,redirect to login');
            redirect('admin/user_manage/login_index');
        }

        //verify permission
        if(!empty($permission)){
            redirect('admin/user_manage/login_index');
        }
    }

    /**
     * verify current user and return use info and user menu
     * @param $permission
     * @return array
     */
    function get_current_user_data($permission){
        $this->verify_current_user($permission);
        $user_info = array(
            "user_name" => $this->session->userdata["user_name"],
            "store_name" => $this->session->userdata["store_name"]
        );
        $user_menu = $this->user_model->get_permission_menus_by_user_id($this->session->userdata["user_id"]);
        return array(
            "user_info" => $user_info,
            "user_menu" => $user_menu
        );
    }

    function create_pagination($base_url,$total_count,$page_size){
        $this->load->library('pagination');
        $config['base_url'] = $this->config->item('base_url').$base_url;
        $config['total_rows'] = $total_count;//总共多少条数据
        $config['per_page'] = $page_size;//每页显示几条数据
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
        return $this->pagination->create_links();
    }

}