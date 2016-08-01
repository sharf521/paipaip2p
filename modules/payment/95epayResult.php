<?php
header("Content-type:text/html; charset=gbk"); 
require_once ('../../core/config.inc.php');
//require_once ('../../core/slock.class.php');
require_once(ROOT_PATH."modules/account/account.class.php");
include_once(ROOT_PATH."modules/payment/payment.class.php");


$BillNo          =     $_POST["BillNo"];
$Amount          =     $_POST["Amount"];
$Succeed         =     $_POST["Succeed"];     
$MD5info         =     $_POST["MD5info"];
$Result          =     $_POST["Result"];
$MerNo           =     $_POST['MerNo'];
$MD5key          =     "dHSqC}SS";
$MerRemark       =  	 $_POST['MerRemark'];		//自定义信息返回
	
$md5sign = getSignature($MerNo, $BillNo, $Amount, $Succeed, $MD5key);

if ($MD5info == $md5sign) 
	{       
 			if ($Succeed == '88') 
				{       
                   $file = $cachepath['pay'].$BillNo;  
                       //判断缓存中是否有交易cache文件
                       //创建交易cache缓存文件
                   $fp = fopen($file , 'w+');    
                   @chmod($file, 0777);	  
                   if(flock($fp , LOCK_EX | LOCK_NB))
				     {    //设定模式独占锁定和不堵塞锁定 
	                  accountClass::OnlineReturn(array("trade_no"=>$BillNo));
	                  echo "充值成功，请点击返回查看充值记录<a href=/?user&q=code/account/recharge> >>>>>></a>";
	                  flock($fp , LOCK_UN); 
	                  echo "<!--";
	                  echo "RECV_ORD_ID_".$UsrSn;
	                  echo "-->";
	                  fclose($fp);
	                  header("location:/?user&q=code/account/recharge");		    
                     }else{     
	                   echo "充值失败ERROE:002，请点击返回<a href=/?user&q=code/account/recharge> >>>>>></a>";
                         }     
                     fclose($fp);
                }else {
                     print 'Update order status to:'.$Result.$Succeed;//更新订单状态为其他状态
                      }      
    }  else {
                //验证失败
                echo $Result.$Succeed;
            }
         
       
          
  function getSignature($MerNo, $BillNo, $Amount, $Succeed, $MD5key){
			$sign_params  = array(
        	'MerNo'         => $MerNo,
        	'BillNo'        => $BillNo, 
        	'Amount'        => $Amount,   
        	'Succeed'       => $Succeed
    			);
    
			$sign_str = "";
			ksort($sign_params);
			foreach ($sign_params as $key => $val) {              
                
                $sign_str .= sprintf("%s=%s&", $key, $val);
                               
            }
           //print $sign_str;print '<br/><br/><br/>';
  		return strtoupper(md5($sign_str. strtoupper(md5($MD5key))));   


	}        
          
          
          
          
          
?>