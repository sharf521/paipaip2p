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
$MerRemark       =  	 $_POST['MerRemark'];		//�Զ�����Ϣ����
	
$md5sign = getSignature($MerNo, $BillNo, $Amount, $Succeed, $MD5key);

if ($MD5info == $md5sign) 
	{       
 			if ($Succeed == '88') 
				{       
                   $file = $cachepath['pay'].$BillNo;  
                       //�жϻ������Ƿ��н���cache�ļ�
                       //��������cache�����ļ�
                   $fp = fopen($file , 'w+');    
                   @chmod($file, 0777);	  
                   if(flock($fp , LOCK_EX | LOCK_NB))
				     {    //�趨ģʽ��ռ�����Ͳ��������� 
	                  accountClass::OnlineReturn(array("trade_no"=>$BillNo));
	                  echo "��ֵ�ɹ����������ز鿴��ֵ��¼<a href=/?user&q=code/account/recharge> >>>>>></a>";
	                  flock($fp , LOCK_UN); 
	                  echo "<!--";
	                  echo "RECV_ORD_ID_".$UsrSn;
	                  echo "-->";
	                  fclose($fp);
	                  header("location:/?user&q=code/account/recharge");		    
                     }else{     
	                   echo "��ֵʧ��ERROE:002����������<a href=/?user&q=code/account/recharge> >>>>>></a>";
                         }     
                     fclose($fp);
                }else {
                     print 'Update order status to:'.$Result.$Succeed;//���¶���״̬Ϊ����״̬
                      }      
    }  else {
                //��֤ʧ��
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