<?php
header("Content-type:text/html; charset=gbk"); 
require_once ('../../core/config.inc.php');
//require_once ('../../core/slock.class.php');
require_once (ROOT_PATH.'modules/account/account.class.php');
include_once(ROOT_PATH."modules/payment/payment.class.php");


$MD5key = "{DSP[TzN";                                   //MD5私钥
$BillNo = $_POST["BillNo"];                             //订单号
$Amount = $_POST["Amount"];                             //金额
$Succeed = $_POST["Succeed"];                           //支付状态
$Result = $_POST["Result"];                             //支付结果
$SignMD5info = $_POST["SignMD5info"];                   //取得的MD5校验信息
$Remark = $_POST["Remark"];                             //备注
$md5src = $BillNo."&".$Amount."&".$Succeed."&".$MD5key; //校验源字符串
$md5sign = strtoupper(md5($md5src));                    //MD5检验结果	

if ($SignMD5info==$md5sign) 
 {
  if ($Succeed == '88')
	{        
	 $file = $cachepath['pay'].$BillNo;   //判断缓存中是否有交易cache文件 //创建交易cache缓存文件   
     $fp = fopen($file , 'w+');    
     @chmod($file, 0777);	  
     if(flock($fp , LOCK_EX | LOCK_NB)){    //设定模式独占锁定和不堵塞锁定 
	    accountClass::OnlineReturn(array("trade_no"=>$BillNo));
	    echo "充值成功，请点击返回查看充值记录<a href=/?user&q=code/account/recharge> >>>>>></a>";
	    flock($fp , LOCK_UN); 
	    echo "<!--";
	    echo "RECV_ORD_ID_".$UsrSn;
	    echo "-->";
	    fclose($fp);
	    header("location:/?user&q=code/account/recharge");		    
        } else{     
	        echo "充值失败ERROE:002，请点击返回<a href=/?user&q=code/account/recharge> >>>>>></a>";
              }     
     fclose($fp);
    }else {
            print 'Update order status to:'.$Result.$Succeed;//更新订单状态为其他状态
          }
        
  }else {
                //验证失败
                echo $Remark.$Succeed;              
 }

?>