<?php

function objtoarr($obj)
{
	$ret = array();
	foreach($obj as $key =>$value){
		if(gettype($value) == 'array' || gettype($value) == 'object'){
			$ret[$key] = objtoarr($value);
		}
		else{
			$ret[$key] = $value;
		}
	}
	return $ret;
}

//PHP调用WebService方法
function webService($func,$post_data=array())
{
	global $_G;
	$webservice_url = isset($_G['system']['con_webservice_url'])?$_G['system']['con_webservice_url']:"";
	if ($webservice_url==""){
		return array();
	}
	$client = new SoapClient('http://'.$webservice_url.'/Algorithm.asmx?WSDL');	 
	$client->soap_defencoding = 'utf-8';
	$client->decode_utf8 = false;
	$client->xml_encoding = 'utf-8';
	 
	$headers = new SoapHeader('http://localhost/','header',array('name'=>'web','password'=>'112233'));
	$client->__setSoapHeaders(array($headers));
	$result = $client->__Call($func, array($post_data));
	if (is_soap_fault($result))
	{
		trigger_error("SOAP Fault: ", E_USER_ERROR);
		return array();
	}
	else
	{
		//var_dump($result);
		$result=objtoarr($result);
		foreach($result as $re)
		{
			return $re;
		}
	}
}
?>