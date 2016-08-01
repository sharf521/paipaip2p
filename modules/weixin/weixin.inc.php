<?php
/*error_reporting(7);
header("content-Type: text/html; charset=UTF-8");
date_default_timezone_set('Asia/Shanghai');//时区配置

session_cache_limiter('private, must-revalidate');//返回页面不清空缓存 
session_start();*/
require 'weixin.func.php';
require 'wxapi.class.php'; 

//$token=$_G['Q1']?$_G['Q1']:'nqalkw1389334597';
/*$fp=fopen('aa.txt','w+');
fwrite($fp,'1111');
fclose($fp);*/
$wechatObj = new wxapi($token);
$msg=$wechatObj->request();
if($msg['MsgType']=='event')
{
	if($msg['Event']=='subscribe')
	{
		$wechatObj->response('欢迎订阅！');		
		exit;
	}
	elseif($msg['Event']=='unsubscribe')
	{
		//$wechatObj->response('再见，感谢您这一段时间的支持！');	
		exit;
	}
}
elseif($msg['MsgType']=='text')
{
	if($msg['Content']=='test')
	{
		$str="河南省郑州市中原区建设路桐柏路";
		$wechatObj->response($str);
	}
	elseif($msg['Content']=='news')
	{
		$news[0]=array('Title','remark','http://www.imm0371.com/data/files/mall/city/1.jpg','http://www.imm0371.com');
		$news[1]=array('复元商城','河南省郑州市中原区建设路桐柏路','http://www.imm0371.com/data/files/mall/city/1.jpg','http://www.imm0371.com/article/63.html');
		$wechatObj->response($news,'news');		
	}
	else
	{		
		$pre=substr($msg['Content'],0,6);
		if($pre=='朗读')
		{
			$ms=trim(substr($msg['Content'],6));
			if(!empty($ms))
			{
				$url  = 'http://www.apiwx.com/aaa.php?w=' . urlencode($ms);	
				$wechatObj->response(array('朗读',$ms,$url,$url),'music');	
			}	
		}
		elseif($pre=='翻译')
		{
			$ms=trim(substr($msg['Content'],6));
			if(!empty($ms))
			{
				$content=baiduDic($ms);
				$wechatObj->response($content);
			}	
		}
		else
		{
			$content=get_other($msg['Content']);			
			$wechatObj->response($content);
		}		
	}
}








