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
	echo "验签失败[".$_POST['Sign']."]请点击返回<a href=/?user&q=code/account/recharge> >>>>>></a>";
	exit;	
}

$file = $cachepath['pay'].$UsrSn;   
//判断缓存中是否有交易cache文件
//创建交易cache缓存文件
$fp = fopen($file , 'w+');    
@chmod($file, 0777);	  
if(flock($fp , LOCK_EX | LOCK_NB)){    //设定模式独占锁定和不堵塞锁定
	accountClass::OnlineReturn(array("trade_no"=>$UsrSn));
	echo "充值成功，请点击返回查看充值记录<a href=http://{$_SERVER['SERVER_NAME']}/?user&q=code/account/recharge> >>>>>></a>";
	
	flock($fp , LOCK_UN); 
	echo "<!--";
	echo "RECV_ORD_ID_".$UsrSn;
	echo "-->";
	fclose($fp);
	header("location:/?user&q=code/account/recharge");		    
} else{     
	echo "充值失败ERROE:002，请点击返回<a href=http://{$_SERVER['SERVER_NAME']}/?user&q=code/account/recharge> >>>>>></a>";
}     
fclose($fp);


exit;