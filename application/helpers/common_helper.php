<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 *  短消息函数,可以在某个动作处理后友好的提示信息
 *
 * @param     string  $msg      消息提示信息
 * @param     string  $gourl    跳转地址
 * @param     int     $onlymsg  仅显示信息
 * @param     int     $limittime  限制时间
 * @return    void
 */
function show_msg($msg, $gourl, $onlymsg=0, $limittime=0)
{
	if(empty($GLOBALS['cfg_plus_dir'])) $GLOBALS['cfg_plus_dir'] = '..';

	$htmlhead  = "<html>\r\n<head>\r\n<title>ADS广告系统 提示信息！</title>\r\n<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" />\r\n";
	$htmlhead .= "<base target='_self'/>\r\n<style>div{line-height:160%;}</style></head>\r\n<body leftmargin='0' topmargin='0' bgcolor='#FFFFFF'>".(isset($GLOBALS['ucsynlogin']) ? $GLOBALS['ucsynlogin'] : '')."\r\n<center>\r\n<script>\r\n";
	$htmlfoot  = "</script>\r\n</center>\r\n</body>\r\n</html>\r\n";

	$litime = ($limittime==0 ? 1000 : $limittime);
	$func = '';

	if($gourl=='-1')
	{
			if($limittime==0) $litime = 5000;
			$gourl = "javascript:history.go(-1);";
	}

	if($gourl=='' || $onlymsg==1)
	{
			$msg = "<script>alert(\"".str_replace("\"","'",$msg)."\");</script>";
	}
	else
	{
			//当网址为:close::objname 时, 关闭父框架的id=objname元素
			if(preg_match('/close::/',$gourl))
			{
					$tgobj = trim(preg_replace('/close::/', '', $gourl));
					$gourl = 'javascript:;';
					$func .= "window.parent.document.getElementById('{$tgobj}').style.display='none';\r\n";
			}
			
			$func .= "      var pgo=0;
		function JumpUrl(){
			if(pgo==0){ location='$gourl'; pgo=1; }
		}\r\n";
			$rmsg = $func;
			$rmsg .= "document.write(\"<br /><div style='width:450px;padding:0px;border:1px solid #DADADA;'>";
			$rmsg .= "<div style='padding:6px;font-size:12px;border-bottom:1px solid #DADADA;background:#80bdcb url({$GLOBALS['cfg_plus_dir']}/img/wbg.gif)';'><b>ADS广告系统 提示信息！</b></div>\");\r\n";
			$rmsg .= "document.write(\"<div style='height:130px;font-size:10pt;background:#ffffff'><br />\");\r\n";
			$rmsg .= "document.write(\"".str_replace("\"","'",$msg)."\");\r\n";
			$rmsg .= "document.write(\"";
			
			if($onlymsg==0)
			{
					if( $gourl != 'javascript:;' && $gourl != '')
					{
							$rmsg .= "<br /><a href='{$gourl}'>如果你的浏览器没反应，请点击这里...</a>";
							$rmsg .= "<br/></div>\");\r\n";
							$rmsg .= "setTimeout('JumpUrl()',$litime);";
					}
					else
					{
							$rmsg .= "<br/></div>\");\r\n";
					}
			}
			else
			{
					$rmsg .= "<br/><br/></div>\");\r\n";
			}
			$msg  = $htmlhead.$rmsg.$htmlfoot;
	}
	echo $msg;
}

function P($var)
{
	echo '<pre>';
	print_r($var);
	echo '</pre>';	
}

function is_utf8($word)
{
	if (preg_match("/^([".chr(228)."-".chr(233)."]{1}[".chr(128)."-".chr(191)."]{1}[".chr(128)."-".chr(191)."]{1}){1}/",$word) == true || preg_match("/([".chr(228)."-".chr(233)."]{1}[".chr(128)."-".chr(191)."]{1}[".chr(128)."-".chr(191)."]{1}){1}$/",$word) == true || preg_match("/([".chr(228)."-".chr(233)."]{1}[".chr(128)."-".chr(191)."]{1}[".chr(128)."-".chr(191)."]{1}){2,}/",$word) == true)
	{
		return true;
	}
	else
	{
		return false;
	}
}

function string2KVArray($string, $delimiter = ';', $kv = '=') {
         if ($a = explode($delimiter, $string)) { // create parts
             foreach ($a as $s) { // each part
                 if ($s) {
                     if ($pos = strpos($s, $kv)) { // key/value delimiter
                        $ka[trim(substr($s, 0, $pos))] = trim(substr($s, $pos + strlen($kv)));
                    } else { // key delimiter not found
                         $ka[] = trim($s);
                    }
                }
            }
            return $ka;
        }
}

function getParams($url,$key){
    $url = explode("?",$url);
    parse_str($url[1],$url);
    return $url[$key];
}

function curl_get($url){
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    // 设置cURL 参数，要求结果保存到字符串中还是输出到屏幕上。
    curl_setopt($curl, CURLOPT_BINARYTRANSFER, 1);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_AUTOREFERER, 1);
    curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
    // 运行cURL，请求网页
    $data = curl_exec($curl);
    // 关闭URL请求
    curl_close($curl);
    return $data;
}	

function testhelper($data){
    echo 'your input content is: '.$data;
}

function replace_unicode_escape_sequence($match){
       return mb_convert_encoding(pack('H*', $match[1]), 'UTF-8', 'UCS-2BE'); 
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

function zAddslashes(&$value){
	return str_replace(array('"',"'"), array('&quot;','&#39;'), addslashes($value));
}
/**
 * 分页函数
 *
 * @param $total 信息总数
 * @param $curr_page 当前分页
 * @param $perpage 每页显示数
 * @param $uri_segment URL规则
 * @return 分页
 */
function page($base_url='lists',$total,$perpage=20,$curr_page=1,$num_links=5,$uri_segment=3,$page_query_string=FALSE)
{
	$CI =&get_instance();
	$CI->load->library ( 'pagination' );
	
	$config['base_url']         = $base_url;
	$config['total_rows']       = $total;//数据总条数
	$config['per_page']         = $perpage;//每页显示条数
	$config['uri_segment']      = $uri_segment;//设置URI 的哪个部分包含页数
	$config['num_links']        = $num_links;//5当前页码的前面和后面的“数字”链接的数量
	$config['use_page_numbers'] = TRUE;//默认分页URL中是显示每页记录数,启用use_page_numbers后显示的是当前页码
	$config['full_tag_open']    = '<div class="p_z_bar"><span class="p_z_total">&nbsp;共&nbsp;<font color="#000000">'.$total.'</font>&nbsp;条/&nbsp;<font color="#000000">'.ceil($total / $perpage).'</font>页</span><span class="p_z_pages">&nbsp;当前显示第&nbsp;<font color="#000000">'.$curr_page.'</font>&nbsp;页&nbsp;</span>';//把打开的标签放在所有结果的左侧。
	$config['full_tag_close']   = '</div>';//把关闭的标签放在所有结果的右侧。
	$config['first_link']       = FALSE;//你希望在分页的左边显示“第一页”链接的名字。如果你不希望显示，可以把它的值设为 FALSE
	$config['last_link']        = FALSE;//你希望在分页的右边显示“最后一页”链接的名字。如果你不希望显示，可以把它的值设为 FALSE 。
	$config['prev_link']        = '上一页';//你希望在分页中显示“上一页”链接的名字。如果你不希望显示，可以把它的值设为 FALSE 。
	$config['prev_tag_open']    = '<a class="p_z_redirect">';//“上一页”链接的打开标签 。
	$config['prev_tag_close']   = '</a>';//“上一页”链接的关闭标签 。
	$config['next_link']        = '下一页';//你希望在分页中显示“下一页”链接的名字。如果你不希望显示，可以把它的值设为 FALSE 。
	$config['next_tag_open']    = '<a class="p_z_redirect">';//“下一页”链接的打开标签 。
	$config['next_tag_close']   = '</a>';//“下一页”链接的关闭标签 
	$config['num_tag_open']     = '<a class="p_z_num">';//“数字”链接的打开标签。
	$config['num_tag_close']    = '</a>';//“数字”链接的关闭标签。
	$config['cur_tag_open']     = '<span class="p_z_curpage">';//“当前”链接的打开标签。
	$config['cur_tag_close']    = '</span>';//“当前”链接的关闭标签。
	$config['page_query_string'] = $page_query_string;
	$CI->pagination->initialize($config);//以上参数被 $this->pagination->initialize 方法传递
	
	return $CI->pagination->create_links();//创建分页变量给$pagination
}

/**
* 转化 \ 为 /
* 
* @param	string	$path	路径
* @return	string	路径
*/
function dir_path($path) {
	$path = str_replace('\\', '/', $path);
	if(substr($path, -1) != '/') $path = $path.'/';
	return $path;
}
/**
* 创建目录
* 
* @param	string	$path	路径
* @param	string	$mode	属性
* @return	string	如果已经存在则返回true，否则为flase
*/
function dir_create($path, $mode = 0777) {
	if(is_dir($path)) return TRUE;
	$ftp_enable = 0;
	$path = dir_path($path);
	$temp = explode('/', $path);
	$cur_dir = '';
	$max = count($temp) - 1;
	for($i=0; $i<$max; $i++) {
		$cur_dir .= $temp[$i].'/';
		if (@is_dir($cur_dir)) continue;
		@mkdir($cur_dir, 0777,true);
		@chmod($cur_dir, 0777);
	}
	return is_dir($path);
}

function h( $string)
{
	$string= is_array( $string) ? array_map( "h", $string) : htmlspecialchars( $string);
    return $string;
}

function message( $msg, $url = "" )
{
	echo("<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\">\n");
	if ( $url == "" )
	{
		echo "<script>alert('";
		echo $msg;
		echo "');history.back();</script>";
		exit( );
	}
	echo "<script>alert('".$msg."');top.location='".$url."';</script>";
	exit( );
}