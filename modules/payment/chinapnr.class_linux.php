<?php
class chinapnrPayment {

	var $name = '�㸶����';//�㸶����
	var $description = "�㸶����";
	var $type = 1;//1->ֻ��������2->�������
    var $logo = 'IPS3';
    var $version = "10"; //�汾	version
    var $charset = 'gbk';

	
	public static function ToSubmit($payment){
		$form_url = 'https://mas.chinapnr.com/gar/RecvMerchant.do'; //��������		
//		$form_url = 'https://test.chinapnr.com/gar/RecvMerchant.do'; //���Ի���
		$payment['MerId'] = "871746"; //�̻���
		$submitDate=date('Ymd',time());//�����ύ����	
		$submitTime=date('His',time());//�����ύʱ��	
		$user_id = $payment['user_id']; 
		$totalAmount=number_format($payment['money'], 2, '.', '');
		$Version = "10";
		$CmdId = "Buy";
		$MerId = "871746";
		$OrdId = trim($payment['trade_no']);
		$OrdAmt = trim($totalAmount);
		$CurCode = "RMB";
		$Pid = "1111";
		$RetUrl = "http://{$_SERVER['SERVER_NAME']}/modules/payment/chinapnr_return.php";
		$BgRetUrl = "http://{$_SERVER['SERVER_NAME']}/modules/payment/chinapnr_return.php";
		$MerPriv = "1111";
		$GateId = $payment['GateId'];
		$UsrMp = "";
		$DivDetails = "";
		$PayUsrId = "";
			
	$fp = fsockopen("203.171.226.131", '8733', $errno, $errstr, 10);
	if (!$fp) {
		echo "$errstr ($errno)<br />\n";
                die();
	} else {
		
		$MsgData = $Version.$CmdId.$MerId.$OrdId.$OrdAmt.$CurCode.$Pid.$RetUrl.$MerPriv.$GateId.$UsrMp.$DivDetails.$PayUsrId.$BgRetUrl;
		$MsgData_len =strlen($MsgData);
		if($MsgData_len < 100 ){
			$MsgData_len = '00'.$MsgData_len;
		}
		elseif($MsgData_len < 1000 ){
			$MsgData_len = '0'.$MsgData_len;
		}

		$out = 'S'.$MerId.$MsgData_len.$MsgData;
		
		$out_len = strlen($out);
		if($out_len < 100 ){
			$out_len = '00'.$out_len;
		}
		elseif($out_len < 1000 ){
			$out_len = '0'.$out_len;
		}
		$out =$out_len.$out;

		//echo $MsgData_len;exit;
		//$out = '0021S87052400101234567890';
		fputs($fp, $out);

		$ChkValue ='';
		while (!feof($fp)) {
			$ChkValue .= fgets($fp, 128);
		}
		$ChkValue = substr($ChkValue, -264,-8);
		fclose($fp);
		//echo $ChkValue;
	}
	
		 header("Content-type:text/html; charset=gbk"); 
	?>
			<html>
			  <head>
				<title>��ת......</title>
				<meta http-equiv="content-Type" content="text/html; charset=gbk" />
			  </head>
			  <body>
			  <div style="display:none">
			  <?php echo $ChkValue;?>
			  </div>
			 ����㸶����֧��ҳ��>>>>>>>>
				<form id="frm1" name="frm1" method="post" action="<?=$form_url?>">
			 <div style="display:block">
				 <textarea name="ChkValue" cols="60" rows="6"><?=$ChkValue?></textarea>
				</div>
				  <input type=hidden name="Version" value="<?=$Version?>">
				  <input type=hidden name="CmdId" value="<?=$CmdId?>">
				  <input type=hidden name="MerId" value="<?=$MerId?>">
				  <input type=hidden name="OrdId" value="<?=$OrdId?>">
				  <input type=hidden name="OrdAmt" value="<?=$OrdAmt?>">
				  <input type=hidden name="CurCode" value="<?=$CurCode?>">
				  <input type=hidden name="Pid" value="<?=$Pid?>">
				  <input type=hidden name="RetUrl" value="<?=$RetUrl?>">
				  <input type=hidden name="BgRetUrl" value="<?=$BgRetUrl?>">
				  <input type=hidden name="MerPriv" value="<?=$MerPriv?>">
				  <input type=hidden name="GateId" value="<?=$GateId?>">
				  <input type=hidden name="UsrMp" value="<?=$UsrMp?>">
				  <input type=hidden name="DivDetails" value="<?=$DivDetails?>">
				  <input type=hidden name="PayUsrId" value="<?= $PayUsrId ?>">  
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
