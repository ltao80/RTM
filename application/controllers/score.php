<?php
/**
 * Created by PhpStorm.
 * User: liutao
 * Date: 5/1/15
 * Time: 8:27 PM
 */


class Score extends CI_Controller
{

    public function getList()
    {
        $current_customer_id = $_SESSION["customer_id"];
        return $this->customer_model->get_customer_score_list($current_customer_id);
    }

    public function getDetail($order_code,$order_type){
        return $this->customer_model->get_customer_score_detail($order_code,$order_type);
    }
}