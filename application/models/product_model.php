<?php
/**
 * Created by PhpStorm.
 * User: liutao
 * Date: 5/1/15
 * Time: 9:56 AM
 */

class Product_Model extends CI_Model {

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
