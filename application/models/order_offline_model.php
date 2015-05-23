<?php
class Order_offline_Model extends CI_Model {

    /**
     * 获取列表
     *
     * @param number $pageIndex
     * @param number $pageSize
     * @param string $detail
     * @return multitype:
     */
    function get_order_score_by_promotionId($promationId) {
        $query = $this->db->query("SELECT * FROM lp_order_offline WHERE is_scan_qrcode = 1 AND promotion_id = $promationId");
        $sum_socore = 0;
        if($query->num_rows() > 0) {
            foreach($query->result() as $order) {
                $sum_socore += $order->total_score;
            }
        }
        return $sum_socore;
    }

    /**
     * 获取列表
     *
     * @param number $pageIndex
     * @param number $pageSize
     * @param string $detail
     * @return multitype:
     */
    function get_orders_promationId($promationId, $pageIndex = 1, $pageSize = 10, $detail = true) {
        $startIndex = ($pageIndex - 1) * $pageSize;

        $query = $this->db->query("SELECT * FROM lp_order_offline WHERE is_scan_qrcode = 1 AND promotion_id = $promationId order by order_datetime DESC LIMIT $startIndex, $pageSize");

        $orders = array();
        $sum_score = 0;
        if($query->num_rows() > 0) {
            foreach($query->result() as $order) {
                if($detail) {
                    $order->details = $this->get_order_detail($order->order_code);
                }
                array_push($orders, $order);
            }
        }

        return $orders;
    }

    function get_order_detail1($orderCode) {
        $query = $this->db->query("SELECT ood.*, p.*, spec.spec_name FROM lp_order_offline_detail ood left join lp_product_info p on p.id = ood.product_id left JOIN lp_global_specification spec on ood.spec_id = spec.spec_id left JOIN lp_product_specification ps on p.id = ps.product_id WHERE ood.order_code ='$orderCode' and ps.is_for_exchange = 0");

        $details = array();
        if($query->num_rows() > 0) {
            foreach($query->result_array() as $detail) {
                array_push($details, $detail);
            }
        }

        return $details;
    }

    /**
     * get product list for order detail by order_code
     * @param $order_code
     */
    public function get_order_detail($order_code){
        $this->db->select('lp_product_info.*,lp_order_offline_detail.product_num,lp_product_images.image_url,lp_product_specification.score,lp_global_specification.spec_name,lp_order_offline_detail.spec_id');
        $this->db->from('lp_order_offline_detail');
        $this->db->join('lp_global_specification', 'lp_order_offline_detail.spec_id = lp_global_specification.spec_id','inner');
        $this->db->join("lp_product_info","lp_product_info.id = lp_order_offline_detail.product_id",'inner');
        $this->db->join("lp_product_specification","lp_product_specification.product_id = lp_order_offline_detail.product_id and lp_product_specification.spec_id = lp_order_offline_detail.spec_id","inner");
        $this->db->join("lp_product_images","lp_product_images.product_id = lp_product_info.id","left");
        $this->db->where('lp_order_offline_detail.order_code',$order_code);
        $this->db->order_by("lp_order_offline_detail.product_id");
        return $this->db->get()->result_array();
    }

	function get_order($storeId, $orderCode) {
		$query = $this->db->query("SELECT * FROM lp_order_offline WHERE order_code = '$orderCode' AND store_id = $storeId ");
		
		$order = new stdClass();
		if($query->num_rows() > 0) {
			$order = $query->next_row();
			$order->details = $this->get_order_detail($orderCode);
		}
		
		return $order;
	}

	function find_order_by_receipt($storeId, $receiptId) {
		$query = $this->db->query("SELECT * FROM lp_order_offline WHERE receipt_id='$receiptId' AND store_id = $storeId");
		
		$order = new stdClass();
		if($query->num_rows() > 0) {
			$order = $query->next_row();
			$order->details = $this->get_order_detail($order->order_code);
		}
		
		return $order;
	}
	
	function save_receipt($orderCode, $receiptId) {
		
		$query = $this->db->query("SELECT * FROM lp_order_offline WHERE receipt_id = '$receiptId'");
		if($query->num_rows() > 0) {
			return false;
		} else { 
			$this->db->query("UPDATE lp_order_offline SET receipt_id = '$receiptId' WHERE order_code = '$orderCode'");
			return true;
		}
	}
	
	function update_qrcode_info($orderCode, $sceneId) {
		$this->db->query("UPDATE lp_order_offline SET is_generate_qrcode = 1, scene_id = '$sceneId', generate_datetime = NOW(), is_scan_qrcode = 0, scan_datetime = NULL WHERE order_code = '$orderCode'");
	}
	
	function is_scanned($orderCode) {
		$query = $this->db->query("SELECT is_scan_qrcode FROM lp_order_offline WHERE order_code = '$orderCode' and is_scan_qrcode = 1");
		if($query->num_rows() > 0) {
			$result = $query->next_row();
			
			return ($result->is_scan_qrcode == 1);
		}
		
		return false;
	}
	
	function save_order($orderCode, $storeId, $promotionId, $details, $isGenerateQRCode, $sceneId) {
		$this->db->trans_start();
		$totalScore = 0;
		for($i = 0; $i < count($details); $i++) {
			$totalScore += ($details[$i]->score ? $details[$i]->score : 0) * ($details[$i]->count ? $details[$i]->count : 0);
		}
		$FIELDS = "INSERT INTO lp_order_offline(order_code, store_id, promotion_id, is_scan_qrcode, order_datetime, scene_id, total_score, is_generate_qrcode" . ($isGenerateQRCode == 1 ? ",generate_datetime" : "") . ")";
		$VALUES = " VALUES('$orderCode', $storeId, $promotionId, 0, NOW(), '$sceneId', $totalScore, $isGenerateQRCode" . ($isGenerateQRCode == 1 ? ",NOW()" : "") . ")"; 


		$this->db->query("$FIELDS $VALUES");
		
		foreach($details as $detail) {
			$this->db->query("INSERT lp_order_offline_detail(order_code, product_id, spec_id, product_num) VALUES('$orderCode', {$detail->product_id}, {$detail->spec_id}, {$detail->count})");
		}
		
		$this->db->trans_complete();
	}

    /**
     * 当用户扫描临时二维码成功后回调，主要是注册 customer 和 更新 lp_customer_score_list
     *
     * @param $order_code
     * @param $wechat_id
     */
    function scan_qrcode_callback($order_code,$wechat_id){
        $order_type = 2;
        $query = $this->db->query("SELECT * FROM lp_order_offline WHERE order_code = '$order_code'");
        if($query->num_rows() > 0) {
        	$order = $query->next_row();
        	if($order->is_scan_qrcode == 1) {
        		return 0;
        	}
        } else {
        	return 0;
        }
        $this->db->where("order_code",$order_code);
        $this->db->select("order_code,customer_id, store_id,total_score,order_datetime");
        $produce_score_result = $this->db->get("lp_order_offline")->result_array();
        $total_score = 0;//形成本次订单的积分
        $sum_score = 0;//用户总积分
        foreach($produce_score_result as $item){
            $total_score += $item["total_score"];
        }

        $this->db->trans_start();
        $query = $this->db->query("SELECT * FROM lp_customer_info WHERE wechat_id = '$wechat_id'");
        if($query->num_rows() > 0) {
        	$customer = $query->next_row();
        	$customerId = $customer->id;
            $sum_score = $customer->total_score + $total_score;
        	$this->db->query("UPDATE lp_customer_info SET total_score = total_score +  $total_score  WHERE id = $customerId");
        } else {
            $customer_info = array(
                'name' => '',
                'address' => '',
                'phone' => '',
                'email' => '',
                'birthday' => '',
                'wechat_id' => $wechat_id,
                'total_score' => $total_score
            );
        	$this->db->insert("lp_customer_info",$customer_info);
        	$customerId = $this->db->insert_id();
            $sum_score = $total_score;
        	$this->db->query("UPDATE lp_customer_info SET total_score =  $total_score  WHERE id = $customerId");
        }

        foreach($produce_score_result as $product) {
            $product['order_type'] = $order_type;
            if(is_null($product['customer_id'])){
                $product['customer_id'] = $customerId;
            }
            log_message("info","get the text post xml:" .var_export($product,true));
            $this->db->insert("lp_customer_score_list", $product);
        }
        $this->db->query("UPDATE lp_order_offline SET is_scan_qrcode = 1, scan_datetime = NOW(), customer_id = $customerId, scene_id = NULL WHERE order_code = '$order_code'");
        $this->db->trans_complete();
        log_message("info","total score:" .$total_score);
        return json_encode(array("total_score" =>$total_score, "sum_score" => $sum_score));
    }

    
    /**
     * If generated scene id exists
     * 
     * @param unknown $sceneId
     * @return boolean
     */
    public function is_scene_id_exists($sceneId) {
    	$query = $this->db->query("SELECT * FROM lp_order_offline WHERE scene_id = '$sceneId'");
    	if($query->num_rows() > 0) {
    		return true;
    	} else {
    		return false;
    	}
    }
    
    public function get_order_code_by_scene_id($sceneId) {
    	$query = $this->db->query("SELECT * FROM lp_order_offline WHERE scene_id = '$sceneId' order by order_code desc limit 1 ");
    	if($query->num_rows() > 0) {
    		$order = $query->next_row();
    		return $order->order_code;
    	} else {
    		return null;
    	}
    }

    function get_offline_order_list($province,$city,$storeName,$pgName,$orderDate,$isScan,$pageSize,$pageIndex){
        if($province != ''){
            $this->db->where("e.province",$province);
        }
        if($city != ''){
            $this->db->where("e.city",$city);
        }
        if($storeName != ''){
            $this->db->where("f.store_name",$storeName);
        }
        if($pgName != ''){
            $this->db->where("e.name",$pgName);
        }
        if($orderDate != ''){
            $endTime = date('Y-m-d H:i:s',strtotime($orderDate)+86400);
            $this->db->where("a.order_datetime between "."'$orderDate'"." and "."'$endTime'");
        }
        if($isScan != ''){
            $this->db->where("a.is_scan_qrcode",$isScan);
        }
        $this->db->select("a.order_code, a.order_datetime, a.scan_datetime, b.product_num, c.name, c.title as pTitle, d.spec_name, f.province, f.city, e.wechat_id, e.name as username, e.phone, f.store_name");
        $this->db->from("lp_order_offline a");
        $this->db->join("lp_order_offline_detail b","b.order_code = a.order_code");
        $this->db->join("lp_product_info c","c.id = b.product_id");
        $this->db->join("lp_global_specification d","d.spec_id = b.spec_id");
        $this->db->join("lp_customer_info e","e.id = a.customer_id");
        $this->db->join("lp_global_store f","f.store_id = a.store_id");
        $this->db->order_by("a.order_datetime","desc");
        $this->db->limit($pageIndex,$pageSize);
        $result = $this->db->get()->result_array();
        //$sql = $this->db->last_query();
        //echo $sql;
        //return $result;
        $data = array();
        //$i = 0;
        foreach($result as $val){
            if($data[$val['order_code']]){
                $data[$val['order_code']]['detail'] .= ','. $val['name'].'|'.$val['spec_name'].'|'.$val['product_num'].'瓶';
            }else{
                $item = array();
                $item['detail'] = $val['name'].'|'.$val['spec_name'].'|'.$val['product_num'].'瓶';
                $item['order_code'] = $val['order_code'];
                $item['address'] = $val['province'].'/'.$val['city'];
                $item['store'] = $val['store_name'];
                $item['wechat_id'] = $val['wechat_id'];
                $item['order_datetime'] = $val['order_datetime'];
                $item['scan_datetime'] = $val['scan_datetime'];
                $item['contact'] = $val['username'].'|'.$val['phone'];
                $data[$val['order_code']] = $item;
                //$i++;
            }
        }
        $returnData = array();
        foreach($data as $key => $item){
            $returnData[] = $item;
        }

        return $returnData;

    }

    function count_offline_order_list($province,$city,$storeName,$pgName,$orderDate,$isScan){
        if($province != ''){
            $this->db->where("e.province",$province);
        }
        if($city != ''){
            $this->db->where("e.city",$city);
        }
        if($storeName != ''){
            $this->db->where("f.store_name",$storeName);
        }
        if($pgName != ''){
            $this->db->where("e.name",$pgName);
        }
        if($orderDate != ''){
            $endTime = date('Y-m-d H:i:s',strtotime($orderDate)+86400);
            $this->db->where("a.order_datetime between "."'$orderDate'"." and "."'$endTime'");
        }
        if($isScan != ''){
            $this->db->where("a.is_scan_qrcode",$isScan);
        }
        $this->db->select("count(*) as count");
        $this->db->from("lp_order_offline a");
        $this->db->join("lp_order_offline_detail b","b.order_code = a.order_code");
        $this->db->join("lp_product_info c","c.id = b.product_id");
        $this->db->join("lp_global_specification d","d.spec_id = b.spec_id");
        $this->db->join("lp_customer_info e","e.id = a.customer_id");
        $this->db->join("lp_global_store f","f.store_id = a.store_id");
        $this->db->order_by("a.order_datetime","desc");
        $result = $this->db->get()->result_array()[0]['count'];

        return $result;
    }

    function export_offline_order($province,$city,$storeName,$pgName,$orderDate,$isScan){
        if($province != ''){
            $this->db->where("e.province",$province);
        }
        if($city != ''){
            $this->db->where("e.city",$city);
        }
        if($storeName != ''){
            $this->db->where("f.store_name",$storeName);
        }
        if($pgName != ''){
            $this->db->where("e.name",$pgName);
        }
        if($orderDate != ''){
            $endTime = date('Y-m-d H:i:s',strtotime($orderDate)+86400);
            $this->db->where("a.order_datetime between "."'$orderDate'"." and "."'$endTime'");
        }
        if($isScan != ''){
            $this->db->where("a.is_scan_qrcode",$isScan);
        }

        $this->db->select("a.order_code, a.order_datetime, a.scan_datetime, b.product_num, c.name, c.title as pTitle, d.spec_name, f.province, f.city, e.wechat_id, e.name as username, e.phone, f.store_name");
        $this->db->from("lp_order_offline a");
        $this->db->join("lp_order_offline_detail b","b.order_code = a.order_code");
        $this->db->join("lp_product_info c","c.id = b.product_id");
        $this->db->join("lp_global_specification d","d.spec_id = b.spec_id");
        $this->db->join("lp_customer_info e","e.id = a.customer_id");
        $this->db->join("lp_global_store f","f.store_id = a.store_id");
        $this->db->order_by("a.order_datetime","desc");
        $result = $this->db->get()->result_array();

        $data = array();
        //$i = 0;
        foreach($result as $val){
            if($data[$val['order_code']]){
                $data[$val['order_code']]['detail'] .= ','. $val['name'].'|'.$val['spec_name'].'|'.$val['product_num'].'瓶';
            }else{
                $item = array();
                $item['detail'] = $val['name'].'|'.$val['spec_name'].'|'.$val['product_num'].'瓶';
                $item['order_code'] = $val['order_code'];
                $item['address'] = $val['province'].'/'.$val['city'];
                $item['store'] = $val['store_name'];
                $item['wechat_id'] = $val['wechat_id'];
                $item['order_datetime'] = $val['order_datetime'];
                $item['scan_datetime'] = $val['scan_datetime'];
                $item['contact'] = $val['username'].'|'.$val['phone'];
                $data[$val['order_code']] = $item;
                //$i++;
            }
        }
        $returnData = array();
        foreach($data as $key => $item){
            $returnData[] = $item;
        }

        return $returnData;
    }
}