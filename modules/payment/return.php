<?
require_once ('../../core/config.inc.php');
require_once (ROOT_PATH.'modules/account/account.class.php');
require_once (ROOT_PATH.'modules/payment/payment.class.php');


/*if (isset($_REQUEST['trade_status']) && $_REQUEST['trade_status']=="TRADE_SUCCESS" ){
	$trade_no = $_REQUEST['out_trade_no'];
	accountClass::OnlineReturn(array("trade_no"=>$_REQUEST['out_trade_no']));
	echo "<script>location.href='/index.php?user&q=code/account/recharge';</script>";
}
else
*/    
    if (isset($_REQUEST['ipsbillno']) && $_REQUEST['ipsbillno']!=""){
	$billno = $_GET['billno'];
	$amount = $_GET['amount'];
	$mydate = $_GET['date'];
	$succ = $_GET['succ'];
	$msg = $_GET['msg'];
	$attach = $_GET['attach'];
	$ipsbillno = $_GET['ipsbillno'];
	$retEncodeType = $_GET['retencodetype'];
	$currency_type = $_GET['Currency_type'];
	$signature = $_GET['signature'];
	$content = $billno . $amount . $mydate . $succ . $ipsbillno . $currency_type;
	$result = paymentClass::GetOne(array("nid"=>"ips"));
	$cert = $result['fields']['PrivateKey']['value'];
	$signature_1ocal = md5($content . $cert);
	if ($signature_1ocal == $signature){
		if ($succ == 'Y'){
			accountClass::OnlineReturn(array("trade_no"=>$billno));
			$msg = '���׳ɹ�';
		}else{
			$msg = '����ʧ�ܣ�';
		}
	}else{
		$msg = 'ǩ������ȷ��';
	}
	echo "<script>alert('{$msg}');location.href='/index.php?user&q=code/account/recharge';</script>";
}
elseif (isset($_REQUEST['sp_billno']) && $_REQUEST['sp_billno']!=""){
	require_once (ROOT_PATH."modules/payment/classes/tenpay/PayResponseHandler.class.php");
	$result = paymentClass::GetOne(array("nid"=>"tenpay"));
	$key = $result['fields']['PrivateKey']['value'];
	$resHandler = new PayResponseHandler();
	$resHandler->setKey($key);
	
	if($resHandler->isTenpaySign()) {
		//���׵���
		$transaction_id = $resHandler->getParameter("transaction_id");
		$sp_billno = $_REQUEST['sp_billno'];
		//���,�Է�Ϊ��λ
		$total_fee = $resHandler->getParameter("total_fee")/100;
		
		//֧�����
		$pay_result = $resHandler->getParameter("pay_result");
		
		if( 0 == $pay_result ) {
			accountClass::OnlineReturn(array("trade_no"=>$sp_billno));
			$msg = "֧���ɹ�";
		} else {
			$msg = "֧��ʧ��";
		}
			
	} else {
		$msg =  "��֤ǩ��ʧ��" ;
	}
	echo "<script>alert('{$msg}');location.href='/index.php?user&q=code/account/recharge';</script>";
}
elseif (isset($_REQUEST['respCode']) && $_REQUEST['respCode']!=""){
	$billno = $_REQUEST['merOrderNum'];
	$amount = $_REQUEST['tranAmt'];
	$mydate = $_REQUEST['tranFinishTime'];
	$succ = $_REQUEST['respCode'];
	$content = $billno . $amount . $mydate;
	$result = paymentClass::GetOne(array("nid"=>"guofubao"));
	$cert = $result['fields']['PrivateKey']['value'];
	$signature_1ocal = md5($content . $cert);
	/*if ($succ == '0000'){
		accountClass::OnlineReturn(array("trade_no"=>$billno));
		$msg = '���׳�ֵ�ɹ�';
	}else{
		$msg = '���׳�ֵʧ�ܣ�';
	}*/
        if ($succ == '0000'){
            $msg = '��ֵ������ɣ��뼰ʱ�鿴��ֵ״̬,�������ʣ��뼰ʱ��ϵ��վ����Ϳͷ���Ա��лл';
        }else{
            $msg = '���׳�ֵʧ�ܣ�';
        }
	//echo $msg;
	echo "<script>alert('{$msg}');location.href='/index.php?user&q=code/account/recharge';</script>";
}
?>