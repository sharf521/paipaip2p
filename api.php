<?php


# 基础抬头 其中第三项释放的信息在浏览器debug时可见.
header('Content-language: zh');  
header('Content-type: text/html; charset=utf-8');
header('X-Powered-By: JAVA');

# 设置php文件永远不缓存. 可以在后面进行叠加影响的.
header('Pragma: no-cache');
header('Cache-Control: private',false); // required for certain browsers 
header('Cache-Control: no-cache, no-store, max-age=0, must-revalidate');  
header('Expires: '.gmdate('D, d M Y H:i:s') . ' GMT');
header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');


session_cache_limiter('private,must-revalidate');
session_start();
date_default_timezone_set('Asia/Shanghai');//时区配置


$_path_info = (isset($_SERVER['PATH_INFO'])) ? $_SERVER['PATH_INFO'] : @getenv('PATH_INFO');	
$_path_info=substr($_path_info,1);
$_G['query_string'] = explode("/",$_path_info);
$_G['Q0']=$_G['query_string'][0];
$_G['Q1']=$_G['query_string'][1];
$_G['Q2']=$_G['query_string'][2];

if($_G['Q0']=='weixin')
{
	$token=$_G['Q1']?$_G['Q1']:'nqalkw1389334597';
	
	$echoStr = $_GET["echostr"];
	if(!empty($echoStr))
	{
		echo $echoStr;
		exit;
	}
	require 'modules/weixin/weixin.inc.php';	
}