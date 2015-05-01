<?php
/**
 * Created by PhpStorm.
 * User: richard
 * Date: 15-4-30
 * Time: 下午5:43
 */

class Order_Online_Model extends CI_Model {

    /**
     * add product to shopping cart
     * @param $customer_id string 用户ID,系统生成的，不是微信号
     * @param $product_id string 产品ID
     * @param $spec_id string 规格编号
     * @param $product_num int 购买数量
     */
    function add_product_cart($customer_id,$product_id,$spec_id,$product_num){
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
    function drop_product_cart($customer_id,$product_id,$spec_id){
        $query = array(
            'customer_id' => $customer_id,
            'product_id' => $product_id,
            'spec_id' => $spec_id
        );
        $this->db->where($query);
        $this->db->delete('rtm_shopping_cart');
    }

    function get_cart_product_list($customer_id){
        $this->db->where(array('customer_id',$customer_id));
        $this->db->select('*');
        $this->db->get('rtm_shopping_cart')->result();
    }

    /**
     * prepare order,need to check if the stock number is ok for every product
     * @param $customer_id
     * @param $order_list
     */
    function pre_order($customer_id,$order_list){

    }

    /**
     * add product of cart into order
     * @param $customer_id
     * @param $order_list
     */
    function add_order($customer_id,$order_list){
        foreach($order_list as $order_item){

        }

    }
} 