<?php
/**
 * Created by PhpStorm.
 * User: richard
 * Date: 15-4-30
 * Time: 下午5:43
 */

class Order_Online_Model extends CI_Model {
    /**
     * @param $pid
     * @param $start_date
     * @param $end_date
     * @return array
     */
    function home_get_userinfo($pid,$start_date,$end_date) {
        /**
         *  this is demo
         */
        $this->db->from("ads")->where("ads_id", "");
        $ad = $this->db->get( )->row_array( );
        if($ad) {
//			$ret['ad_id'] = $id;
            $ret['ad_name'] = $ad['ads_name'];
            $ret['status'] = $ad['status'];
            $ret['maxpv'] = $ad['pv'];
            $ret['mas_platform'] = $ad['mas_platform'];
            $ret['order_id'] = '';
            $ret['order_name'] = '';

            $order_id = $ad['order_id'];
            $this->db->from("order")->where("order_id", $order_id);
            $order = $this->db->get( )->row_array( );
            if($order) {
                $ret['order_id'] = $order_id;
                $ret['order_name'] = $order['order_name'];
                if( ! $ret['maxpv'] ) {
                    $ret['maxpv'] = $order['pv_num'];
                }
            }
        }

        return $ret;
    }

    /**
     * add product to shopping cart
     * @param $customer_id string 用户ID,系统生成的，不是微信号
     * @param $product_id string 产品ID
     * @param $spec_id string 规格编号
     * @param $product_num int 购买数量
     */
    function add_cart($customer_id,$product_id,$spec_id,$product_num){
        $data = array(
            'customer_id' => $customer_id ,
            'product_id' => $product_id ,
            'spec_id' => $spec_id,
            'product_num' => $product_num,
            'created_at' => date('y-m-d h:i:s',time())
        );
        $this->db->insert('rtm_shopping_cart', $data);
    }

    /**
     * drop product from shopping cart
     * @param $customer_id
     * @param $product_id
     * @param $spec_id
     */
    function drop_cart($customer_id,$product_id,$spec_id){
        $query = array(
            'customer_id' => $customer_id,
            'product_id' => $product_id,
            'spec_id' => $spec_id
        );
        $this->db->where($query);
        $this->db->delete('rtm_shopping_cart');
    }
} 