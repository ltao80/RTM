<?php
/**
 * Created by PhpStorm.
 * User: richard
 * Date: 15-4-30
 * Time: 下午5:44
 */

class Scores_Model extends CI_Model {

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

} 