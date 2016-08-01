<?php
class spayPayment {

	public static function ToSubmit($payment){
		$shengpay=new shengpay();
		$array=array(
			'Name'=>'B2CPayment',
			'Version'=>'V4.1.1.1.1',
			'Charset'=>'GBK',
			'MsgSender'=>'106924',
			'SendTime'=>date('YmdHis'),
			'OrderTime'=>date('YmdHis'),
			'PayType'=>'',
			'InstCode'=>'',  
			'PageUrl'=>'http://www.wzdai.com/success.php',
			'NotifyUrl'=>'http://www.wzdai.com/modules/payment/SPAYOrderReturn.php',
			'ProductName'=>'��Ԫ��֧��ƽ̨',
			'BuyerContact'=>'',
			'BuyerIp'=>'',
			'Ext1'=>'',
			'Ext2'=>'',
			'SignType'=>'MD5',
		);
		if(isset($payment['InstCode']) && $payment['InstCode'] != '')$array['InstCode']=$payment['InstCode'];
		if(isset($payment['PayType']) && $payment['PayType'] != '')$array['PayType']=$payment['PayType'];
		$shengpay->init($array);
		#$shengpay->setKey('shengfutongSHENGFUTONGtest');
		$shengpay->takeOrder($payment['trade_no'],$payment['money']);
	}
}

class shengpay{

	private $payHost;
	private $debug=false;
	private $key='TmpreU5ESTNPREl5TkRkeGNTNWpiMjA9';
	private $params=array(
		'Name'=>'',
		'Version'=>'',
		'Charset'=>'',
		'MsgSender'=>'',#���ͷ���ʶ
		'SendTime'=>'',#����֧������ʱ��,�û�ͨ���̻���վ�ύ������֧��ʱ��,����Ϊ14λ����������,��ʽΪ:yyyyMMddHHmmss,��:20110707112233
		'OrderNo'=>'', #�̻�������   oid
		'OrderAmount'=>'',  #֧�����  account
		'OrderTime'=>'',  #�̻������ύʱ��
		'PayType'=>'',
		'InstCode'=>'',
		'PageUrl'=>'',
		'NotifyUrl'=>'', #�̻���̨�ص���ַ
		'ProductName'=>'',  #��Ʒ����
		'BuyerContact'=>'', #֧������ϵ��ʽ
		'BuyerIp'=>'', #���IP��ַ 
		'Ext1'=>'', #��չ1   Ӣ�Ļ������ַ��� ֧����ɺ󣬒���ԭ�����ظ��̻�
		'Ext2'=>'',
		'SignType'=>'MD5',
		'SignMsg'=>'',  #ǩ�����
	);

	function init($array=array()){
		if($this->debug)
			$this->payHost='http://mer.mas.sdo.com/web-acquire-channel/cashier.htm';
		else
			$this->payHost='http://mas.sdo.com/web-acquire-channel/cashier.htm';
		foreach($array as $key=>$value){
			$this->params[$key]=$value;
		}
	}

	function setKey($key){
		$this->key=$key;
	}
	function setParam($key,$value){
		$this->params[$key]=$value;
	}

	function takeOrder($oid,$fee){
		$this->params['OrderNo']=$oid;
		$this->params['OrderAmount']=$fee;
		
		$origin='';
		foreach($this->params as $key=>$value){
			if(!empty($value))
				$origin.=$value;
		}
		$SignMsg=strtoupper(md5($origin.$this->key));
		$this->params['SignMsg']=$SignMsg;
		echo '<meta http-equiv = "content-Type" content = "text/html; charset = '.$this->params['Charset'].'"/>
			<form  method="post" action="'.$this->payHost.'">';
			foreach($this->params as $key=>$value){
				echo '<input type="hidden" name="'.$key.'" value="'.$value.'"/>';
			}
			echo '<input type="submit" name="submit" value="" id="dh">
				<script>var a=document.getElementById("dh");a.click();</script>
			</form>';
	}

	function returnSign(){
		$params=array(
			'Name'=>'',
			'Version'=>'',
			'Charset'=>'',
			'TraceNo'=>'',
			'MsgSender'=>'',
			'SendTime'=>'',
			'InstCode'=>'',
			'OrderNo'=>'',
			'OrderAmount'=>'',
			'TransNo'=>'',
			'TransAmount'=>'',
			'TransStatus'=>'',
			'TransType'=>'',
			'TransTime'=>'',
			'MerchantNo'=>'',
			'ErrorCode'=>'',
			'ErrorMsg'=>'',
			'Ext1'=>'',
			'Ext2'=>'',
			'SignType'=>'MD5',
		);
		
		foreach($_POST as $key=>$value){
			if(isset($params[$key])){
				$params[$key]=$value;
			}
		}
		$TransStatus=(int)$_POST['TransStatus'];
		$origin='';
		foreach($params as $key=>$value){
			if(!empty($value))
				$origin.=$value;
		}
		$SignMsg=strtoupper(md5($origin.$this->key));
		if($SignMsg==$_POST['SignMsg'] and $TransStatus==1){
			return true;
		}else{
			return false;
		}
	}
}