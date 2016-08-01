<?php
function get_access_token()
{
	$api['appID']='wxd2fc139a68b7fe8c';
	$api['appsecret']='baeccd113e2f92d11fab2e2d635268df';
	$url_get = 'https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid='.$api['appID'].'&secret='.$api['appsecret'];
	$result = get_url($url_get);	
	$json = json_decode($result);
	return $json->access_token;
}
function post_url($url, $data)
{
	$ch = curl_init();  
	curl_setopt($ch, CURLOPT_URL, $url); 
	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE); 
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
	//curl_setopt($ch, CURLOPT_HTTPHEADER, "Accept-Charset: utf-8");
	curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; MSIE 5.01; Windows NT 5.0)');
	//curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
	curl_setopt($ch, CURLOPT_AUTOREFERER, 1); 
	curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
	$tmpInfo = curl_exec($ch);
	curl_close($ch);
	return $tmpInfo;
}
function get_url($url)
{
	$file_contents = file_get_contents($url);
	if(empty($file_contents))
	{
		$ch = curl_init();
		$timeout = 5;		
		curl_setopt ($ch, CURLOPT_URL, $url);
		//设置cURL 参数，要求结果保存到字符串中还是输出到屏幕上
		curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);		
		curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, $timeout);// 0:无限
		curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, FALSE);// 对认证证书来源的检查
		curl_setopt ($ch, CURLOPT_HEADER, 0 ); // 显示返回的Header区域内容
		$file_contents = curl_exec($ch);
		curl_close($ch);
	}
	return $file_contents;
}

//小九机器人
function xiaojo($keyword)
{
  $data=post_url('http://www.xiaojo.com/bot/chata.php',array("chat"=>$keyword));
  if(!empty($data))
  {
	  return $data;
  }
  else
  {
	  $str=get_url('http://api.ajaxsns.com/api.php?key=free&appid=0&msg='.urlencode($keyword));
	  $json=json_decode($str);
	  if($json->result==0 && !empty($json->content))
	  {
		  return $json->content;
	  }  	  
	  $ran=rand(1,4);
	  switch($ran){
		  case 1:
			  return "今天累了，明天再陪你聊天吧。";
			  break;
		  case 2:
			  return "睡觉喽~~";
			  break;
		  case 3:
			  return "呼呼~~呼呼~~";
			  break;
		  case 4:
			  return "你话好多啊，不跟你聊了";
			  break;
		  default:
			  return "呼呼~~呼呼~~,睡觉喽~~";
			  break;
	  }
  }
}
//百度翻译
function baiduDic($word,$from="auto",$to="auto")
{        
	//首先对要翻译的文字进行 urlencode 处理
	$word_code=urlencode($word);        
	//注册的API Key
	$appid="OWM1tRHt0mgGYXyG3zNylOGS";        
	//生成翻译API的URL GET地址
	$baidu_url = "http://openapi.baidu.com/public/2.0/bmt/translate?client_id=".$appid."&q=".$word_code."&from=".$from."&to=".$to;        
	$text=json_decode(get_url($baidu_url));
	$text = $text->trans_result;
	return $text[0]->dst;
}
//百度翻译-获取目标URL所打印的内容

function ipip($ipaddres)
{	
	$preg="/\A((([0-9]?[0-9])|(1[0-9]{2})|(2[0-4][0-9])|(25[0-5]))\.){3}(([0-9]?[0-9])|(1[0-9]{2})|(2[0-4][0-9])|(25[0-5]))\Z/";
	if(preg_match($preg,$ipaddres))
	{ 
	  $str=get_url('http://ip.taobao.com/service/getIpInfo.php?ip='.$ipaddres);
	  $json=json_decode($str);
	  if($json->code==0)
	  {
		  return $json->data->country.$json->data->area.$json->data->region.$json->data->city.$json->data->county."\n".$json->data->isp;
	  }
	}
}
function shouji($mobile)
{
  if(preg_match('/^1[3458][0-9]{9}$/',$mobile))
  {   
	$str=get_url('http://api.ajaxsns.com/api.php?key=free&appid=0&msg='.($mobile));
	$json=json_decode($str);
	if($json->result==0 && !empty($json->content))
	{
		$str  = str_replace('{br}', "\n", $json->content);
		return $str;
	}
  }	
}
function domain($domain)
{
	$preg = "/^(?:http:\/\/)?www.[0-9a-zA-Z]+_?[0-9a-zA-Z]+.(?:com(?:.cn)?|net|org|info|mobi)$/";
	if(preg_match($preg,$domain))
	{
		$str=get_url('http://api.ajaxsns.com/api.php?key=free&appid=0&msg='.($domain));
		$json=json_decode($str);
		if($json->result==0 && !empty($json->content))
		{
			$str  = str_replace('{br}', "\n", $json->content);
			return $str;
		}
	}	
}



function get_other($msg)
{
	$str=ipip($msg);
	if(!empty($str))	return $str;
	
	$str=shouji($msg);
	if(!empty($str))	return $str;
	
	$str=domain($msg);
	if(!empty($str))	return $str;
	
	return xiaojo($msg);	
}

 


/*$access_token=get_access_token();

$url = "https://api.weixin.qq.com/cgi-bin/menu/get?access_token=".$access_token;
//echo api_notice_increment($url,$data);
$result = file_get_contents($url);
echo $result;
			exit;

$url = "https://api.weixin.qq.com/cgi-bin/menu/create?access_token=".$access_token;
$data = ' {
     "button":[
     {	
          "type":"click",
          "name":"今日歌曲",
          "key":"V1001_TODAY_MUSIC"
      },
      {
           "type":"click",
           "name":"歌手简介",
           "key":"V1001_TODAY_SINGER"
      },
      {
           "name":"菜单",
           "sub_button":[
           {	
               "type":"view",
               "name":"搜索",
               "url":"http://www.soso.com/"
            },
            {
               "type":"view",
               "name":"视频",
               "url":"http://v.qq.com/"
            },
            {
               "type":"click",
               "name":"赞一下我们",
               "key":"V1001_GOOD"
            }]
       }]
 }';*/
//echo post_url($url,$data);