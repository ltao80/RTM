<?php
/**
 * Created by PhpStorm.
 * User: richard
 * Date: 15-5-2
 * Time: 上午12:57
 */

class wechatcallback extends CI_Controller {

    public function text() {
        $result = "";
        $signature = $_GET['signature'];
        $timestamp= $_GET['timestamp'];
        $nonce = $_GET['nonce'];
        $platId = $this->config->item("platId");
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $postStr = file_get_contents ( "php://input" );
            log_message("info","get the text post xml:" .$postStr);
            if (!empty ( $postStr )) {
                // 获取参数
                $postObj = simplexml_load_string ( $postStr, 'SimpleXMLElement', LIBXML_NOCDATA );
                log_message("info","[token] is:" .$platId ."[signature] is:" .$signature. "[timestamp] is:".$timestamp."[nonce] is:".$nonce);
                if(checkSignature($platId, $signature, $timestamp, $nonce)) {
                    $openId = ( string )trim($postObj->FromUserName);
                    $keyword = ( string )trim($postObj->Content);
                    $content = "";
                    if(in_array($keyword, array("积分","兑换","积分商城"))) {
                        $href = $this->config->item("pgDomain") . "shopping/index/" . $openId;
                        $content = '<a href="' . $href . '">点击进入积分商城</a>';
                    } else if(in_array($keyword, array("pgryjs", "Pgryjs", "PGRYJS"))) {
                        $href = $this->config->item("pgDomain") . "pg_user/verify?&openId=" . $openId;
                        $content = '<a href="' . $href . '">点击进入PG系统</a>';
                    }

                    $textTpl =  "<xml>
                                <ToUserName><![CDATA[%s]]></ToUserName>
                                <FromUserName><![CDATA[%s]]></FromUserName>
                                <CreateTime>%s</CreateTime>
                                <MsgType><![CDATA[%s]]></MsgType>
                                <Content><![CDATA[%s]]></Content>
                                </xml>";
                    $result = sprintf($textTpl, $postObj->FromUserName, $postObj->ToUserName, time(), 'text', $content);
                } else {
                    log_message("error","not valid the http request message. please confirm it");
                }
            }
        }

        echo $result;
    }

    public function scan() {
        $result = "";
        $signature = $_GET['signature'];
        $timestamp= $_GET['timestamp'];
        $nonce = $_GET['nonce'];
        $platId = $this->config->item("platId");
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $postStr = file_get_contents ( "php://input" );
            log_message("info","get the text post xml:" .$postStr);
            if (!empty ( $postStr )) {
                // 获取参数
                $postObj = simplexml_load_string ( $postStr, 'SimpleXMLElement', LIBXML_NOCDATA );
                log_message("info","[token] is:" .$platId ."[signature] is:" .$signature. "[timestamp] is:".$timestamp."[nonce] is:".$nonce);
                if(checkSignature($platId, $signature, $timestamp, $nonce)) {
                    $openId = ( string )trim($postObj->FromUserName);
                    $sceneid = str_replace("qrscene_", "", ( int )trim($postObj->EventKey));
					$orderCode = $this->order_offline_model->get_order_code_by_scene_id($sceneid);
					
                    $is_scan = $this->order_offline_model->is_scanned($orderCode);
                    log_message("info","if use scan the qrcode: ".$is_scan.", the openId is:".$openId."sceneid is:".$sceneid);
                    //查询sceneid是否被扫描过,如果是则返回不做任何处理信息, 否的话需要把该openid注册, 然后查询该二维码的积分
                    if($is_scan) {
                        $content = "该订单积分已被领取，感谢您的关注!";
                    } else {
                        $score = $this->order_offline_model->scan_qrcode_callback($orderCode, $openId);
                        log_message("info","use scan the qrcode, the scodre result is:" .$score);
                        $score = isset($score) ? $score : 0;
                        $content = '尊敬的顾客您好，感谢您参与荣耀积赏活动。' + ($score == 0 ? "" : '您此次获得的积分为'.$score.'积分，如果您想要兑换礼品，请点击菜单栏荣耀积赏-礼品兑换。如果您有任何关于兑换的问题，欢迎在对话栏中向我们的微信客服留言，我们会第一时间答复您的疑问');
                    }

                    $textTpl =  "<xml>
                        <ToUserName><![CDATA[%s]]></ToUserName>
                        <FromUserName><![CDATA[%s]]></FromUserName>
                        <CreateTime>%s</CreateTime>
                        <MsgType><![CDATA[%s]]></MsgType>
                        <Content><![CDATA[%s]]></Content>
                        </xml>";
                    $result = sprintf($textTpl, $postObj->FromUserName, $postObj->ToUserName, time(), 'text', $content);
                    log_message("info","return the scan xml info:" .$result);
                } else {
                    log_message("error","not valid the http request message. please confirm it");
                }
            }
        } else {
            /*$token = "3IJOLW9JCT";
            $timestamp = "1430539747";
            $nonce = "d9609f9a-8c68-4e17-a698-493e82bc5069";
            $signature = 'ca1d2b79c104128d24f853ddc4ac36760a99e539';
            $postStr = '<xml>
                          <ToUserName><![CDATA[gh_2bf896fa401a]]></ToUserName>
                          <FromUserName><![CDATA[oi4S4syCwhFQcsxH-9iab3f2EQGo]]></FromUserName>
                          <CreateTime><![CDATA[1430539747]]></CreateTime>
                          <MsgType><![CDATA[event]]></MsgType>
                          <Event><![CDATA[subscribe]]></Event>
                          <EventKey><![CDATA[qrscene_1111]]></EventKey>
                          <Ticket><![CDATA[TICKET]]></Ticket>
                        </xml>';
            $postObj = simplexml_load_string ( $postStr, 'SimpleXMLElement', LIBXML_NOCDATA );

            log_message("info","[token] is:" .$token ."[signature] is:" .$signature. "[timestamp] is:".$timestamp."[nonce] is:".$nonce);
            if(checkSignature($token, $signature, $timestamp, $nonce)) {
                $openId = ( string )trim($postObj->ToUserName);
                $sceneid = str_replace("qrscene_", "", ( string )trim($postObj->EventKey));
                $is_scan = $this->order_offline_model->is_scanned($sceneid);
                log_message("info","if use scan the qrcode: ".$is_scan);
                //查询sceneid是否被扫描过,如果是则返回不做任何处理信息, 否的话需要把该openid注册, 然后查询该二维码的积分
                if($is_scan) {
                    $content = "该订单积分已被领取，感谢您的关注!";
                } else {
                    $score = $this->order_offline_model->scan_qrcode_callback($sceneid, $openId);
                    log_message("info","use scan the qrcode, the scodre result is:" .$score);
                    $score = isset($score) ? $score : 0;
                    $content = '尊敬的顾客您好，感谢您参与荣耀积赏活动。您此次获得的积分为'.$score.'积分，如果您想要兑换礼品，请点击菜单栏荣耀积赏-礼品兑换。如果您有任何关于兑换的问题，欢迎在对话栏中向我们的微信客服留言，我们会第一时间答复您的疑问';
                }

                $textTpl =  "<xml>
                                <ToUserName><![CDATA[%s]]></ToUserName>
                                <FromUserName><![CDATA[%s]]></FromUserName>
                                <CreateTime>%s</CreateTime>
                                <MsgType><![CDATA[%s]]></MsgType>
                                <Content><![CDATA[%s]]></Content>
                                </xml>";
                $result = sprintf($textTpl, $postObj->FromUserName, $postObj->ToUserName, time(), 'text', $content);
            } else {
                log_message("error","not valid the http request message. please confirm it");
            }*/

        }
        echo  $result;
    }

    public function testGetTempQrcode(){
        $platId = $this->config->item("platId");
        $sceneid = 20150501;
        $result = createTempQrcode($platId, $sceneid);
        var_dump($result);
        //$openId = "fdafaaaaaa";
        //$msg = "你好啊";
        //$result = Wechat::sendCustomerMessageByOpenId($platId, $openId, $msg);
    }

    public function testScan() {
        var_dump($this->session->userdata("aa"));exit;
        $token = "3IJOLW9JCT";
        $timestamp = "1430539747";
        $nonce = "d9609f9a-8c68-4e17-a698-493e82bc5069";
        $tmpArr = array($token, $timestamp, $nonce);
        sort($tmpArr);
        $tmpStr = implode( $tmpArr );
        $tmpStr = sha1( $tmpStr );
        echo $tmpStr;
        //nonce=&timestamp=1430539747&signature=ca1d2b79c104128d24f853ddc4ac36760a99e539

        //nonce=29be456c-ff37-4db4-af8b-4935acef3ad5&timestamp=1430537252&signature=ef28dc68158069bdb5b816b0c94285741c43c798
    }

} 
