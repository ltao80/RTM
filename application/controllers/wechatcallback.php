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
        $token = $_GET['token'];
        $signature = $_GET['signature'];
        $timestamp= $_GET['timestamp'];
        $nonce = $_GET['nonce'];
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $postStr = file_get_contents ( "php://input" );
            log_message("info","get the text post xml:" .$postStr);
            if (!empty ( $postStr )) {
                // 获取参数
                $postObj = simplexml_load_string ( $postStr, 'SimpleXMLElement', LIBXML_NOCDATA );
                log_message("info","[token] is:" .$token ."[signature] is:" .$signature. "[timestamp] is:".$timestamp."[nonce] is:".$nonce);
                if(checkSignature($token, $signature, $timestamp, $nonce)) {
                    $openId = ( string )trim($postObj->ToUserName);
                    $href = $this->config->item("pgDomain") . "shopping/home/" . $openId;
                    $content = '<a href="' . $href . '">点击进入PG页面</a>';

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
        }else{
            /*
            $token = $this->config->item("platId");
            $timestamp = "1348831860";
            $nonce = "123456";
            $signature = '1c8423e450f46d48f2eb63c225302bacfbfc91e2';
            $xml = ' <xml>
                 <ToUserName><![CDATA[toUser]]></ToUserName>
                 <FromUserName><![CDATA[fromUser]]></FromUserName>
                 <CreateTime>1348831860</CreateTime>
                 <MsgType><![CDATA[text]]></MsgType>
                 <Content><![CDATA[this is a test]]></Content>
                 <MsgId>1234567890123456</MsgId>
                 </xml>';
            $postObj = simplexml_load_string ( $xml, 'SimpleXMLElement', LIBXML_NOCDATA );
            log_message("info","[token] is:" .$token ."[signature] is:" .$signature. "[timestamp] is:".$timestamp."[nonce] is:".$nonce);
            if(checkSignature($token, $signature, $timestamp, $nonce)) {
                $openId = ( string )trim($postObj->ToUserName);
                $href = $this->config->item("pgDomain") . "shopping/home/" . $openId;
                $content = '<a href="'.$href.'">点击进入PG页面</a>';

                $textTpl =  "<xml>
                                <ToUserName><![CDATA[%s]]></ToUserName>
                                <FromUserName><![CDATA[%s]]></FromUserName>
                                <CreateTime>%s</CreateTime>
                                <MsgType><![CDATA[%s]]></MsgType>
                                <Content><![CDATA[%s]]></Content>
                                </xml>";
                $result = sprintf($textTpl, $postObj->FromUserName, $postObj->ToUserName, time(), 'text', $content);

                echo $result;exit;
            } else {
                log_message("error","not valid the http request message. please confirm it");
            }*/

        }
        return $result;
    }

    public function scan() {
        $result = "";
        $token = $_GET['token'];
        $signature = $_GET['signature'];
        $timestamp= $_GET['timestamp'];
        $nonce = $_GET['nonce'];
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $postStr = file_get_contents ( "php://input" );
            log_message("info","get the text post xml:" .$postStr);
            if (!empty ( $postStr )) {
                // 获取参数
                $postObj = simplexml_load_string ( $postStr, 'SimpleXMLElement', LIBXML_NOCDATA );
                log_message("info","[token] is:" .$token ."[signature] is:" .$signature. "[timestamp] is:".$timestamp."[nonce] is:".$nonce);
                if(checkSignature($token, $signature, $timestamp, $nonce)) {
                    $openId = ( string )trim($postObj->ToUserName);
                    $sceneid = str_replace("qrscene_", "", ( int )trim($postObj->EventKey));

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
                }
            }
        }
        return $result;
    }

    public function testGetTempQrcode(){
        $this->load->library('session');
        var_dump($this->session->userdata("a"));exit;
        $platId = $this->config->item("platId");
        $sceneid = 20150501;
        //$result = Wechat::createTempQrcode($platId, $sceneid);
        //var_dump($result);
        $openId = "fdafaaaaaa";
        $msg = "你好啊";
        $result = Wechat::sendCustomerMessageByOpenId($platId, $openId, $msg);
    }

    public function testScan() {
        $token = "HT25ODN6N7";
        $timestamp = "1348831860";
        $nonce = "123456";
        $tmpArr = array($token, $timestamp, $nonce);
        sort($tmpArr);
        $tmpStr = implode( $tmpArr );
        $tmpStr = sha1( $tmpStr );
        echo $tmpStr;//deba8afde2e192a263a4ce9c8b8e93af8a20529d
    }

} 