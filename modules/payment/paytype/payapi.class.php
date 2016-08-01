<?php

class payapiPayment {

	var $name = '默认支付';
	var $logo = 'paypai';
	var $version = 20140910;
	var $description = "默认支付";
	var $type = 1;//1->只能启动，2->可以添加
    var $charset = 'gbk';
	
	
    public static function ToSubmit($data=array()){

        $Pid=$data['pid'];//17 payapi id
		$OrdAmt = sprintf("%.2f",$data['OrdAmt']);		
		
		$para=array(
			"OrdAmt"=>$OrdAmt,
			"Pid"=>$Pid,
			"MerPriv"=>$data['MerPriv'],//商户私有数据项
			//"GateId"=>$_POST['GateId'],
			"UsrSn"=>$data['UsrSn']//time().rand(1000,9999)//流水号
		);
		
		$pkey=$data['pkey'];//私钥
		$para['Sign']=self::md5_sign($para,$pkey);		
		$para['GateId']=$data['GateId'];		
		$para['returl']='http://'.$_SERVER['HTTP_HOST'].'/modules/payment/payapiReturn.php';
		$para['bgreturl']='http://'.$_SERVER['HTTP_HOST'].'/modules/payment/payapiReturn.php';
		$sHtml = "<form id='fupaysubmit' name='fupaysubmit' action='http://pay.fuyuandai.com/gar/RecvMerchant.php' method='post' style='display:none'>";
		while (list ($key, $val) = each ($para)) {
			$sHtml.= "<input type='hidden' name='".$key."' value='".$val."'/>";
		}		
		//submit按钮控件请不要含有name属性
		$sHtml = $sHtml."<input type='submit'></form>";		
		
		$sHtml = $sHtml."<script>document.forms['fupaysubmit'].submit();</script>";
		
		echo $sHtml;
		exit;
		
    }
	
	public static function getKey()
	{
		global $mysql;
		$result=$mysql->db_fetch_array("select config from {payment} where nid='payapi' limit 1");
		$data = unserialize($result['config']);
		return $data['pkey'];	
	}


    function GetFields(){
         return array(
                'pid'=>array(
                        'label'=>'客户号',
                        'type'=>'string'
                    ),
                'pkey'=>array(
                        'label'=>'私钥',
                        'type'=>'string'
                )
            );
    }
	
	function argSort($para) 
	{
		ksort($para);
		reset($para);
		return $para;
	}	
	public static function md5_sign($para,$key='')
	{
		$prestr=self::getsignstr($para);
		$sign=md5($prestr.$key);
		return $sign;
	}
	function getsignstr($para)
	{
		$para=self::argSort($para);
		$arg  = "";
		while (list ($key, $val) = each ($para)) {
			//$arg.=$key."=".$val."&";
			$arg.=$key."=".urlencode($val)."&";
		}
		//去掉最后一个&字符
		$arg = substr($arg,0,count($arg)-2);
		
		//如果存在转义字符，那么去掉转义
		if(get_magic_quotes_gpc()){$arg = stripslashes($arg);}
	
		return $arg;
	}
}