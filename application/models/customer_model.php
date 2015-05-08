<?php
/**
 * Created by PhpStorm.
 * User: richard
 * Date: 15-4-30
 * Time: 下午5:45
 */

class Customer_Model extends CI_Model {

    function get_customer_by_customer_id($customer_id){
        $this->db->where("id",$customer_id);
        $this->db->select("*");
        $result = $this->db->get("rtm_customer_info")->result_array();
        if(isset($result) && count($result) > 0){
            $birthday = date("Y-m-d", strtotime($result[0]['birthday']));
            $result[0]['birthday'] = $birthday;
            return $result[0];
        }else
            return array();
    }

    function get_customer_by_wechat_id($wechat_id){
        $this->db->where("wechat_id",$wechat_id);
        $this->db->select("*");
        $result = $this->db->get("rtm_customer_info")->result_array();
        if(isset($result) && count($result) > 0){
            $birthday = date("Y-m-d", strtotime($result[0]['birthday']));
            $result[0]['birthday'] = $birthday;
            return $result[0];
        }else
            return array();
    }

    function check_customer_by_wechat_id($wechat_id){
        $this->db->where('wechat_id',$wechat_id);
        return $this->db->count_all_results('rtm_customer_info') > 0 ;
    }

    /**
     * when submit order, need to check if customer has enough score for the product of shopping cart
     * @param $customer_id
     * @return bool
     */
    function check_customer_score($customer_id,$need_score){
        $current_score = $this->get_score_by_customer_id($customer_id);
        if($current_score < $need_score)
            return false;
        else
            return true;
    }

    /**
     *  add new customer
     * @param $name
     * @param $province
     * @param $city
     * @param $region
     * @param $address
     * @param $phone
     * @param $birthday
     * @param $email
     * @param $wechat_id
     * @result insert id
     */
    function add_customer_info($name,$province,$city,$region,$address,$phone,$birthday,$email,$wechat_id){
        $data = array(
            'name' => $name,
            'province' => $province,
            'city' => $city,
            'region' => $region,
            'address' => $address,
            'birthday' => $birthday,
            'phone' => $phone,
            'email' => $email,
            'wechat_id' => $wechat_id
        );
        $this->db->insert("rtm_customer_info",$data);
        return $this->db->insert_id();
    }

    function update_customer_info($id,$name,$province,$city,$region,$address,$phone,$birthday,$email){
        $this->db->where('id', $id);

        $data = array(
            'name' => $name,
            'address' => $address,
            'province'=>$province,
            'city'=>$city,
            'region'=>$region,
            'birthday' => $birthday,
            'phone' => $phone,
            'email' => $email
        );
        $this->db->update("rtm_customer_info",$data);
    }

    /**
     * update total score of customer
     * @param $id string CustomerID
     * @param $add_score int 增量的score值
     */
    function update_customer_score($id,$add_score){
        $this->db->where('id',$id);
        $total_score = $this->db->select("total_score");
        $this->db->update("rtm_customer_info",array('total_score',$total_score + $add_score));
    }

    /**
     * update wechat_id for customer
     * @param $id
     * @param $wechat_id
     */
    function update_customer_wechat($id,$wechat_id){
        $this->db->where('id',$id);
        $this->db->update("rtm_customer_info",array('wechat_id',$wechat_id));
    }


    /**
     * get total score of customer
     * @param $id
     * @return mixed
     */
    function get_score_by_customer_id($id){
        $this->db->where('id',$id);
        $this->db->select('total_score');
        $result = $this->db->get('rtm_customer_info')->result_array();
        if(isset($result) && count($result))
            return $result[0]['total_score'];
        else
            return 0;
    }

    /**
     * add new delivery info for customer
     * @param $customer_id
     * @param $receiver_name
     * @param $receiver_phone
     * @param $receiver_province
     * @param $receiver_city
     * @param $receiver_region
     * @param $receiver_address
     * @param $is_default
     */
    function add_customer_delivery($customer_id,$receiver_name,$receiver_phone,$receiver_province,$receiver_city,$receiver_region,$receiver_address,$is_default){
        if($is_default){
            $this->db->update("rtm_customer_delivery_info",array( 'is_default' => false));
        }
        $data = array(
            'customer_id' => $customer_id,
            'receiver_name' => $receiver_name,
            'receiver_phone' => $receiver_phone,
            'receiver_province' => $receiver_province,
            'receiver_city' => $receiver_city,
            'receiver_region' => $receiver_region,
            'receiver_address' => $receiver_address,
            'is_default' => $is_default
        );
        $this->db->insert("rtm_customer_delivery_info",$data);
    }

    function update_customer_default_delivery($id,$is_default){
        if($is_default){
            $this->db->update("rtm_customer_delivery_info",array( 'is_default' => false));
        }
        $this->db->where('id',$id);
        $data = array(
            'is_default' => $is_default
        );
        $this->db->update("rtm_customer_delivery_info",$data);
    }

    function update_customer_delivery($id,$receiver_name,$receiver_phone,$receiver_province,$receiver_city,$receiver_region,$receiver_address,$is_default){

        if($is_default){
            $this->db->update("rtm_customer_delivery_info",array( 'is_default' => false));
        }
        $this->db->where('id',$id);
        $data = array(
            'receiver_name' => $receiver_name,
            'receiver_phone' => $receiver_phone,
            'receiver_province' => $receiver_province,
            'receiver_city' => $receiver_city,
            'receiver_region' => $receiver_region,
            'receiver_address' => $receiver_address,
            'is_default' => $is_default
        );
        $this->db->update("rtm_customer_delivery_info",$data);
    }

    function delete_customer_delivery($id){
        $this->db->where("id",$id);
        return $this->db->delete("rtm_customer_delivery_info");
    }

    /**
     * get delivery list by customer id
     * @param $customer_id int customer id
     * @result mixed
     */
    function get_customer_delivery_list($customer_id){
        $this->db->where('customer_id',$customer_id);
        $this->db->select('*');
        return $this->db->get('rtm_customer_delivery_info')->result_array();
    }

    function get_default_customer_delivery($customer_id){
        $this->db->select('*');
        $this->db->where('customer_id',$customer_id);
        $this->db->where('is_default',1);
        $result = $this->db->get('rtm_customer_delivery_info')->result_array();
        if(isset($result)&&count($result) > 0){
            return $result[0];
        }else
            return array();
    }

    function get_customer_delivery($delivery_id){
        $this->db->select('*');
        $this->db->where('id',$delivery_id);
        $result = $this->db->get('rtm_customer_delivery_info')->result_array();
        if(isset($result)&&count($result) > 0){
            return $result[0];
        }else
            return array();
    }

    function get_consumer_score($order_code,$order_type){
        $this->db->select('order_code,order_type,total_score,order_datetime,rtm_global_store.store_name');
        $this->db->from('rtm_customer_score_list');
        $this->db->join("rtm_global_store","rtm_global_store.store_id = rtm_customer_score_list.store_id","left");
        $this->db->where('rtm_customer_score_list.order_code',$order_code);
        $this->db->where('rtm_customer_score_list.order_type',$order_type);
        $result = $this->db->get()->result_array();
        if(isset($result)&&count($result) > 0){
            return $result[0];
        }else
            return array();
    }

    function get_score_list($customer_id){
        $this->db->select('order_code,order_type,total_score,order_datetime,rtm_global_store.store_name');
        $this->db->from('rtm_customer_score_list');
        $this->db->join("rtm_global_store","rtm_global_store.store_id = rtm_customer_score_list.store_id","left");
        $this->db->where('rtm_customer_score_list.customer_id',$customer_id);
        return $this->db->get()->result_array();
    }

    /**
     * get score list for customer, here score has two type,consumer(online order) and produce(offline order)
     * @param $customer_id customer id
     */
    function get_consumer_score_list($customer_id){
        $this->db->select('order_code,order_type,total_score,order_datetime');
        $this->db->from('rtm_customer_score_list');
        $this->db->where("order_type",1);
        $this->db->where('customer_id',$customer_id);
        return $this->db->get()->result_array();
    }

    function get_producer_score_list($customer_id){
        $this->db->select('order_code,order_type,total_score,order_datetime,rtm_global_store.store_name');
        $this->db->from('rtm_customer_score_list');
        $this->db->join("rtm_global_store","rtm_global_store.store_id = rtm_customer_score_list.store_id");
        $this->db->where("'rtm_customer_score_list.order_type",2);
        $this->db->where('rtm_customer_score_list.customer_id',$customer_id);
        return $this->db->get()->result_array();
    }

    /**
     * @param $order_code
     * @param $order_type
     * @return array
     */
    function  get_customer_score_detail($order_code,$order_type){
        if($order_type == 1){
            return $this->order_online_model->get_order_detail($order_code);
        }else if($order_type == 2){
            return $this->order_offline_model->get_order_detail($order_code);
        }else{
            return array();
        }
    }
} 