<?php
require_once ('../../core/config.inc.php');
require_once (ROOT_PATH.'modules/account/account.class.php');
require_once (ROOT_PATH.'modules/payment/payment.class.php');
?>

<?php
$version = $_POST["version"];
$charset = $_POST["charset"];
$language = $_POST["language"];
$signType = $_POST["signType"];
$tranCode = $_POST["tranCode"];
$merchantID = $_POST["merchantID"];
$merOrderNum = $_POST["merOrderNum"];
$tranAmt = $_POST["tranAmt"];
$feeAmt = $_POST["feeAmt"];
$frontMerUrl = $_POST["frontMerUrl"];
$backgroundMerUrl = $_POST["backgroundMerUrl"];
$tranDateTime = $_POST["tranDateTime"];
$tranIP = $_POST["tranIP"];
$respCode = $_POST["respCode"];
$msgExt = $_POST["msgExt"];
$orderId = $_POST["orderId"];
$gopayOutOrderId = $_POST["gopayOutOrderId"];
$bankCode = $_POST["bankCode"];
$tranFinishTime = $_POST["tranFinishTime"];
$merRemark1 = $_POST["merRemark1"];
$merRemark2 = $_POST["merRemark2"];
$signValue = $_POST["signValue"];

$signValue2='version=['.$version.']tranCode=['.$tranCode.']merchantID=['.$merchantID.']merOrderNum=['.$merOrderNum.']tranAmt=['.$tranAmt.']feeAmt=['.$feeAmt.']tranDateTime=['.$tranDateTime.']frontMerUrl=['.$frontMerUrl.']backgroundMerUrl=['.$backgroundMerUrl.']orderId=['.$orderId.']gopayOutOrderId=['.$gopayOutOrderId.']tranIP=['.$tranIP.']respCode=['.$respCode.']VerficationCode=[22986113]';

$signValue2 = md5($signValue2);
echo $signValue;
exit;
if ($signValue==$signValue2){
    
	if ($respCode=='0000'){
                accountClass::OnlineReturn(array("trade_no"=>$merOrderNum));
                $msg = '���׳ɹ�';
		echo 'RespCode=0000|JumpURL=http://www.wzdai.com/success.php'; 
                
	}else{
                $msg = '����ʧ�ܣ�';
		echo 'RespCode=9999|JumpURL=http://www.wzdai.com/faild.php';
                
	}
        
}

//*****************************************************************************

?>