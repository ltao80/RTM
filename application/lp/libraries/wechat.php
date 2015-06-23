<?php
/**
 * Created by PhpStorm.
 * User: richard
 * Date: 15-5-2
 * Time: 上午12:09
 */

class Wechat {

    private  function getAccessToken($platId) {
        $result = '{"errcode":-1,"errmsg":"system error"}';
        try{
            $getTokenUrl = "http://wxapi.parllay.cn/social/token/get?platId=".$platId;
            log_message("info","get access token url is:".$getTokenUrl);
            $result = doCurlGetRequest($getTokenUrl);
            if(!is_array(json_decode($result, true))) {
                $result = '{"errcode":-2,"errmsg":"get access token error"}';
            }
            log_message("info","get access token result is:".$result);
        }catch(Exception $ex){
            log_message("error","get access token error:".$ex->getMessage());
        }
        return $result;
    }

    public static function sendCustomerMessageByOpenId($platId, $openId, $msg) {
        try {
            $customMessageUrl = "https://api.weixin.qq.com/cgi-bin/message/custom/send?access_token=ACCESS_TOKEN";
            $accessToken = self::getAccessToken($platId);

            $accessToken = json_decode($accessToken, true);
            if(isset($accessToken['errcode']) && $accessToken['errcode'] != 0){
                return '{"errcode":-2,"errmsg":"get access token error"}';
            }else {
                $json = '{
                    "touser":"' . $openId . '",
                    "msgtype":"text",
                    "text":{"content":"' . $msg . '"}
                 }';
                log_message("info","sendCustomerMessageByOpenId json data:".$json);
                $url = str_replace("ACCESS_TOKEN", $accessToken['access_token'], $customMessageUrl);
                log_message("info","sendCustomerMessageByOpenId url:".$url);
                return doCurlPostRequest($url, $json);
            }
        }catch(Exception $ex){
            log_message("error","sendCustomerMessageByOpenId error:".$ex->getMessage());
            return '{"errcode":-1,"errmsg":"system busy"}';
        }
    }

    public static function createTempQrcode($platId, $sceneid) {
        try {
            $qrCodeUrl = "https://api.weixin.qq.com/cgi-bin/qrcode/create?access_token=ACCESS_TOKEN";
            $accessToken = self::getAccessToken($platId);
            $accessToken = json_decode($accessToken, true);
            log_message("info","createTempQrcode get access token:".var_export($accessToken,true));
            if (isset($accessToken['errcode']) && $accessToken['errcode'] != 0) {
                return '{"errcode":-2,"errmsg":"get access token error"}';
            } else {
                $json = '{"expire_seconds": 604800, "action_name": "QR_SCENE", "action_info": {"scene": {"scene_id": ' . $sceneid . '}}}';
                log_message("info","createTempQrcode json data:".$json);
                $qrCodeUrl = str_replace("ACCESS_TOKEN", $accessToken['access_token'], $qrCodeUrl);
                log_message("info","createTempQrcode qrcode url:".$qrCodeUrl);
                return doCurlPostRequest($qrCodeUrl, $json);
            }

        }catch (Exception $ex) {
            log_message("error","createTempQrcode error:".$ex->getMessage());
            return '{"errcode":-1,"errmsg":"system busy"}';
        }
    }

}