<?
 header("Content-type:text/html; charset=gbk"); 
 require_once ('../../core/config.inc.php');
//require_once ('../../core/slock.class.php');
require_once (ROOT_PATH.'modules/account/account.class.php');
//include_once(ROOT_PATH."modules/payment/payment.class.php");

require_once(ROOT_PATH.'modules/payment/paytype/payapi.class.php');

$MerPriv=$_POST['MerPriv'];
$OrdAmt = (float)$_POST['OrdAmt'];
$UsrSn=$_POST['UsrSn'];
$TrxId=$_POST['TrxId'];

$arr=array(
	"OrdAmt"=>sprintf("%.2f",$_POST['OrdAmt']),
	"Pid"=>(int)$_POST['Pid'],
	"MerPriv"=>$MerPriv,
	'TrxId'=>$_POST['TrxId'],
	"UsrSn"=>$UsrSn
);

$pkey=payapiPayment::getKey(); //'p2pHaI8f5cAiEssss8'
if($_POST['Sign'] != payapiPayment::md5_sign($arr,$pkey))
{
	echo "��ǩʧ��[".$_POST['Sign']."]��������<a href=/?user&q=code/account/recharge> >>>>>></a>";
	exit;	
}

$file = $cachepath['pay'].$UsrSn;   
//�жϻ������Ƿ��н���cache�ļ�
//��������cache�����ļ�
$fp = fopen($file , 'w+');    
@chmod($file, 0777);	  
if(flock($fp , LOCK_EX | LOCK_NB)){    //�趨ģʽ��ռ�����Ͳ���������
	accountClass::OnlineReturn(array("trade_no"=>$UsrSn));
	echo "��ֵ�ɹ����������ز鿴��ֵ��¼<a href=http://{$_SERVER['SERVER_NAME']}/?user&q=code/account/recharge> >>>>>></a>";
	
	flock($fp , LOCK_UN); 
	echo "<!--";
	echo "RECV_ORD_ID_".$UsrSn;
	echo "-->";
	fclose($fp);
	header("location:/?user&q=code/account/recharge");		    
} else{     
	echo "��ֵʧ��ERROE:002����������<a href=http://{$_SERVER['SERVER_NAME']}/?user&q=code/account/recharge> >>>>>></a>";
}     
fclose($fp);


exit;