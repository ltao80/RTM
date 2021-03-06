<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * @desc 封装curl的调用接口，post的请求方式
 */
function doCurlPostRequest($url, $requestString, $timeout = 5) {
    if($url == "" || $requestString == "" || $timeout <= 0){
        return false;
    }

    $con = curl_init((string)$url);
    curl_setopt($con, CURLOPT_HEADER, false);
    if (is_array($requestString))
    {
        $sets = array();
        foreach ($requestString AS $key => $val)
        {
            $sets[] = $key . '=' . urlencode($val);
        }
        $requestString = implode('&',$sets);
    }
    curl_setopt($con, CURLOPT_POSTFIELDS, $requestString);
    curl_setopt($con, CURLOPT_POST, true);
    curl_setopt($con, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($con, CURLOPT_TIMEOUT, (int)$timeout);
    $res = curl_exec($con);
    return $res;
}


/**
 * @desc 封装curl的调用接口，get的请求方式
 * $para = array(
"grant_type" => "client_credential",
"appid" => WX_API_APPID,
"secret" => WX_API_APPSECRET
);

$url = WX_API_URL . "token";
interface_log(DEBUG, 0, "url:" . $url . "  req data:" . json_encode($para));
$ret = doCurlGetRequest($url, $para);
 */
function doCurlGetRequest($url, $data = array(), $timeout = 10) {
    if($url == "" || $timeout <= 0){
        return false;
    }
    if($data != array()) {
        $url = $url . '?' . http_build_query($data);
    }
    $con = curl_init((string)$url);
    curl_setopt($con, CURLOPT_HEADER, false);
    curl_setopt($con, CURLOPT_RETURNTRANSFER,true);
    curl_setopt($con, CURLOPT_TIMEOUT, (int)$timeout);
    $result = curl_exec($con);
    return $result;
}

/**
 * @param $token
 * @param $signature
 * @param $timestamp
 * @param $nonce
 * @return bool
 */
function checkSignature($token, $signature, $timestamp, $nonce)
{
    $tmpArr = array($token, $timestamp, $nonce);
    sort($tmpArr);
    $tmpStr = implode( $tmpArr );
    $tmpStr = sha1( $tmpStr );

    if( $tmpStr == $signature ){
        return true;
    }else{
        return false;
    }
}

/**
 * @param $platId
 * @return mixed|string
 */
function getAccessToken($platId) {
    $result = '{"errcode":-1,"errmsg":"system error"}';
    try{
        $getTokenUrl = "http://wxapi.parllay.cn/social/token/get?platId=".$platId;
        log_message("info","get access token url is:".$getTokenUrl);
        $result = doCurlGetRequest($getTokenUrl);
        $token = json_decode($result, true);
        if(!is_array($token)) {
            $result = '{"errcode":-2,"errmsg":"get access token error"}';
        } else {
            if(isset($token['errcode']) && $token['errcode'] == "41002") {
                $getTokenUrl .= "&is_refresh=1";
                $result = doCurlGetRequest($getTokenUrl);
            }
        }
        log_message("info","get access token result is:".$result);
    }catch(Exception $ex){
        log_message("error","get access token error:".$ex->getMessage());
    }
    return $result;
}


/**
 * @param $platId
 * @param $openId
 * @param $msg
 * @return mixed|string
 */
function sendCustomerMessageByOpenId($platId, $openId, $msg) {
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
            $url = str_replace("ACCESS_TOKEN", $accessToken, $customMessageUrl);
            return doCurlPostRequest($url, $json);
        }

    }catch(Exception $ex){
        log_message("error","sendCustomerMessageByOpenId error:".$ex->getMessage());
        return '{"errcode":-1,"errmsg":"system busy"}';
    }
}

/**
 * @param $platId
 * @param $sceneid
 * @return mixed|string
 */
function createTempQrcode($platId, $sceneid) {
    try {
        $qrCodeUrl = "https://api.weixin.qq.com/cgi-bin/qrcode/create?access_token=ACCESS_TOKEN";
        $accessToken = getAccessToken($platId);
        $accessToken = json_decode($accessToken, true);
        if (isset($accessToken['errcode']) && $accessToken['errcode'] != 0) {
            return '{"errcode":-2,"errmsg":"get access token error"}';
        } else {
            $json = '{"expire_seconds": 604800, "action_name": "QR_SCENE", "action_info": {"scene": {"scene_id": ' . $sceneid . '}}}';
            log_message("info","createTempQrcode json:".$json);
            $qrCodeUrl = str_replace("ACCESS_TOKEN", $accessToken['access_token'], $qrCodeUrl);
            log_message("info","get qrcode url is :".$qrCodeUrl);
            return doCurlPostRequest($qrCodeUrl, $json);
        }

    }catch (Exception $ex) {
        log_message("error","createTempQrcode error:".$ex->getMessage());
        return '{"errcode":-1,"errmsg":"system busy"}';
    }
}

function getRemoteAddr( )
{
	$bool = FALSE;
	if ( !empty( $_SERVER['HTTP_VIA'] ) )
	{
		$bool = TRUE;
	}
	else if ( !empty( $_SERVER['REMOTE_HOST'] ) )
	{
		$proxy = array( "proxy", "cache", "inktomi" );
		foreach ( $proxy as $key )
		{
			if ( !( strpos( $key, $_SERVER['REMOTE_HOST'] ) !== FALSE ) )
			{
				continue;
			}
			$bool = TRUE;
			break;
		}
	}
	if ( $bool )
	{
		$http = array( "HTTP_FORWARDED", "HTTP_FORWARDED_FOR", "HTTP_X_FORWARDED", "HTTP_X_FORWARDED_FOR", "HTTP_CLIENT_IP" );
		foreach ( $http as $key )
		{
			if ( empty( $_SERVER[$key] ) )
			{
							continue;
			}
			$addr = $_SERVER[$key];
			break;
		}
		if ( !empty( $addr ) )
		{
			$GLOBALS['_SERVER']['REMOTE_ADDR'] = "0".$addr;
			$GLOBALS['_SERVER']['REMOTE_HOST'] = "";
			$GLOBALS['_SERVER']['HTTP_VIA'] = "";
		}
	}
	return $_SERVER['REMOTE_ADDR'];
}

function is_scene_id_exists($sceneId) {
	$CI = &get_instance();
	return $CI->order_offline_model->is_scene_id_exists($sceneId);
}

/**
 * Generate scene id
 * 
 * @return Ambigous <number, string>
 */
function generate_scene_id() {
	$CI =&get_instance();
	$CI->load->helper ( 'string_helper' );
	$sceneId = random_string("numeric", 7);
	while(is_scene_id_exists(intval($sceneId))) {
		$sceneId = random_string("numeric", 7);
	}
    $sceneId += 100000000;
	return intval($sceneId);
}

/**
 * create order code
 * format: yyyyMMddHHmmssmmm$$$
 * $$$ is random number from 0~1000
 */

function generate_order_code()
{
    $CI =&get_instance();
    $CI->load->helper ( 'string_helper' );
    $randomString = random_string("numeric",5);
    return date("YmdHis").$randomString;
}
