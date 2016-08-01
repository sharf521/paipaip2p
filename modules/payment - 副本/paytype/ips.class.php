<?php
class ipsPayment {
	var $name = '��ѶIPS����֧��3.0';//��ѶIPS����֧��3.0
	var $description = "��ѶIPS����֧��3.0";
	var $type = 1;//1->ֻ��������2->�������
    var $logo = 'IPS3';
    var $version = 20070615;
    var $charset = 'gb2312';
	
	public static function ToSubmit($payment){
		$form_url = 'https://pay.ips.com.cn/ipayment.aspx'; //��������
		$payment['Mer_code'] = "018808";
		$payment['Mer_key']="05776229573443413392674113551175531867094846613813329053066377849790164630872859064774658780071700682265879928020721316404248456";
		$flag = 0;
		$argv = array(
			'Mer_code'=>$payment['Mer_code'], 
			'Billno' => $payment['trade_no'],
			'Amount' => number_format($payment['money'], 2, '.', ''),
			//'Date' => date("Ymd",time()),
			'Date' => date("Ymd",time()),
			'Currency_Type' => "RMB",
			//֧������
			'Gateway_Type' => "01", //��ǿ�
			//֧������ɹ����ص��̻�URL
			//'Merchanturl' => $payment['return_url'],
			'Merchanturl' => 'http://www.wzdai.com/modules/payment/IPSOrderReturn.php',
			'DispAmount' => number_format($payment['money'], 2, '.', ''),
			//����֧���ӿڼ��ܷ�ʽ
			'OrderEncodeType' => "2",
			//���׷��ؽӿڼ��ܷ�ʽ 
			'RetEncodeType' => "12",
			'DoCredit' => '0',
			'Bankco' =>'',
			//�Ƿ��ṩServer���ط�ʽ 
			'Rettype' => "1",
			//Server����ҳ�� 
			'ServerUrl' => 'http://www.wzdai.com/modules/payment/IPSOrderReturn.php',
		 ); 
		 /*
		  * Author : Liu   2012-05-12
		 */
		 if(isset($payment['bankCode'])){
			$argv['DoCredit'] = '1';
			$argv['Bankco'] = $payment['bankCode'];
		 }
		 //����֧���ӿڵ�Md5ժҪ��ԭ��=������+���+����+֧������+�̻�֤�� 
		 $SignMD5 = md5($argv['Billno'].$argv['Amount'].$argv['Date'].$argv['Currency_Type'] .$payment['Mer_key']  );
		 header("Content-type:text/html; charset=gb2312"); 
	//����Ҫpost���ַ��� 
	?>
			<html>
			  <head>
				<title>��ת......</title>
				<meta http-equiv="content-Type" content="text/html; charset=gb2312" />
			  </head>
			  <body>
				<form action="<?php echo $form_url ?>" method="post" id="frm1">
				  <input type="hidden" name="Mer_code" value="<?php echo $argv['Mer_code'] ?>">
				  <input type="hidden" name="Billno" value="<?php echo $argv['Billno'] ?>">
				  <input type="hidden" name="Amount" value="<?php echo $argv['Amount'] ?>" >
				  <input type="hidden" name="Date" value="<?php echo $argv['Date'] ?>">
				  <input type="hidden" name="Currency_Type" value="<?php echo $argv['Currency_Type'] ?>">
				  <input type="hidden" name="Gateway_Type" value="<?php echo $argv['Gateway_Type'] ?>">
				  <input type="hidden" name="Merchanturl" value="<?php echo $argv['Merchanturl'] ?>">
				  <input type="hidden" name="FailUrl" value="<?php echo $argv['FailUrl'] ?>">
				  <input type="hidden" name="ErrorUrl" value="<?php echo $argv['ErrorUrl'] ?>">
				  <input type="hidden" name="Attach" value="<?php echo $argv['Attach'] ?>">
				  <input type="hidden" name="DispAmount" value="<?php echo $argv['DispAmount'] ?>">
				  <input type="hidden" name="OrderEncodeType" value="<?php echo $argv['OrderEncodeType'] ?>">
				  <input type="hidden" name="RetEncodeType" value="<?php echo $argv['RetEncodeType'] ?>">
				  <input type="hidden" name="Rettype" value="<?php echo $argv['Rettype'] ?>">
				  <input type="hidden" name="ServerUrl" value="<?php echo $argv['ServerUrl'] ?>">
				  <input type="hidden" name="SignMD5" value="<?php echo $SignMD5 ?>">
				  <input type="hidden" name="DoCredit" value="<?php echo $argv['DoCredit'] ?>">
				  <input type="hidden" name="Bankco" value="<?php echo $argv['Bankco'] ?>">
				</form>
				<script language="javascript">
				  document.getElementById("frm1").submit();
				</script>
			  </body>
			</html>
<?php
		exit;
	} // ToSubmit 
} // class 
?>
