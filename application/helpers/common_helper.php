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

/**
 * create order code
 * format: yyyyMMddHHmmssmmm$$$
 * $$$ is random number from 0~1000
 */

function generate_order_code()
{
    $CI =&get_instance();
    $CI->load->helper ( 'string_helper' );
    $randomString = random_string("numeric",3);
    return date("YmdHis").$randomString;
}
