<?php
class wxapi
{
	private $data = array();
	private $token=''; 
	public function __construct($token)
	{
		$this->token=$token;
		if(!$this->checkSignature()) exit();
		//$xml = file_get_contents("php://input"); 
		$xml = $GLOBALS["HTTP_RAW_POST_DATA"];
		$xml = new SimpleXMLElement($xml); 
		$xml || exit; 
		foreach ($xml as $key => $value) { 
			$this->data[$key] = strval($value); 
		}
	}
	
	public function request(){ 
		return $this->data; 
	}
    /*public function responseMsg($data)
    {
		//get post data, May be due to the different environments
		$postStr = $GLOBALS["HTTP_RAW_POST_DATA"];
      	//extract post data
		if (!empty($postStr))
		{                
			$postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
			$fromUsername = $postObj->FromUserName;
			$toUsername = $postObj->ToUserName;
			$keyword = trim($postObj->Content);
			$time = time();
			$textTpl = "<xml>
						<ToUserName><![CDATA[%s]]></ToUserName>
						<FromUserName><![CDATA[%s]]></FromUserName>
						<CreateTime>%s</CreateTime>
						<MsgType><![CDATA[%s]]></MsgType>
						<Content><![CDATA[%s]]></Content>
						</xml>";             
			if(!empty( $keyword ))
			{
				$msgType = "text";
				$content =$data['content'];
				$resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $content);
				echo $resultStr;
			}
        }
    }*/
	
	public function response($content, $type = 'text', $flag = 0){ 
		$this->data = array( 'ToUserName' => $this->data['FromUserName'], 'FromUserName' => $this->data['ToUserName'], 'CreateTime' => time(), 'MsgType' => $type, ); 
		$this->$type($content); 
		$this->data['FuncFlag'] = $flag; 
		$xml = new SimpleXMLElement('<xml></xml>'); 
		$this->data2xml($xml, $this->data); 
		//exit($xml->asXML()); 
		$str=$xml->asXML();		
		/*$fp = fopen('ce.txt', 'w');
		fwrite($fp, $str);
		fclose($fp);*/
		echo $str;
	} 
	private function text($content){ 
		$this->data['Content'] = $content; 
	} 
	private function music($music){ 
		list( $music['Title'], $music['Description'], $music['MusicUrl'], $music['HQMusicUrl'] ) = $music; 
		$this->data['Music'] = $music; 
	} 
	private function news($news){ 
		$articles = array(); 
		foreach ($news as $key => $value) { 
			list( $articles[$key]['Title'], $articles[$key]['Description'], $articles[$key]['PicUrl'], $articles[$key]['Url'] ) = $value;
			if($key >= 9) { 
				break; 
			} 
		} 
		$this->data['ArticleCount'] = count($articles); 
		$this->data['Articles'] = $articles; 
	} 
	private function data2xml($xml, $data, $item = 'item') { 
		foreach ($data as $key => $value) { 
			is_numeric($key) && $key = $item; 
			if(is_array($value) || is_object($value)){ 
				$child = $xml->addChild($key); 
				$this->data2xml($child, $value, $item); 
			} else { 
				if(is_numeric($value)){ 
					$child = $xml->addChild($key, $value); 
				} else { 
					$child = $xml->addChild($key); 
					$node = dom_import_simplexml($child); 
					$node->appendChild($node->ownerDocument->createCDATASection($value)); 
				} 
			} 
		} 
	}
		
	private function checkSignature()
	{
        $signature = $_GET["signature"];
        $timestamp = $_GET["timestamp"];
        $nonce = $_GET["nonce"];
		$tmpArr = array($this->token, $timestamp, $nonce);
		sort($tmpArr);
		$tmpStr = implode( $tmpArr );
		$tmpStr = sha1( $tmpStr );
		if( $tmpStr == $signature ){
			return true;
		}else{
			return false;
		}
	}
}
