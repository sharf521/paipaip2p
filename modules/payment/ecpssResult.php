<?php
header("Content-type:text/html; charset=gbk"); 
require_once ('../../core/config.inc.php');
//require_once ('../../core/slock.class.php');
require_once (ROOT_PATH.'modules/account/account.class.php');
include_once(ROOT_PATH."modules/payment/payment.class.php");


$MD5key = "{DSP[TzN";                                   //MD5˽Կ
$BillNo = $_POST["BillNo"];                             //������
$Amount = $_POST["Amount"];                             //���
$Succeed = $_POST["Succeed"];                           //֧��״̬
$Result = $_POST["Result"];                             //֧�����
$SignMD5info = $_POST["SignMD5info"];                   //ȡ�õ�MD5У����Ϣ
$Remark = $_POST["Remark"];                             //��ע
$md5src = $BillNo."&".$Amount."&".$Succeed."&".$MD5key; //У��Դ�ַ���
$md5sign = strtoupper(md5($md5src));                    //MD5������	

if ($SignMD5info==$md5sign) 
 {
  if ($Succeed == '88')
	{        
	 $file = $cachepath['pay'].$BillNo;   //�жϻ������Ƿ��н���cache�ļ� //��������cache�����ļ�   
     $fp = fopen($file , 'w+');    
     @chmod($file, 0777);	  
     if(flock($fp , LOCK_EX | LOCK_NB)){    //�趨ģʽ��ռ�����Ͳ��������� 
	    accountClass::OnlineReturn(array("trade_no"=>$BillNo));
	    echo "��ֵ�ɹ����������ز鿴��ֵ��¼<a href=/?user&q=code/account/recharge> >>>>>></a>";
	    flock($fp , LOCK_UN); 
	    echo "<!--";
	    echo "RECV_ORD_ID_".$UsrSn;
	    echo "-->";
	    fclose($fp);
	    header("location:/?user&q=code/account/recharge");		    
        } else{     
	        echo "��ֵʧ��ERROE:002����������<a href=/?user&q=code/account/recharge> >>>>>></a>";
              }     
     fclose($fp);
    }else {
            print 'Update order status to:'.$Result.$Succeed;//���¶���״̬Ϊ����״̬
          }
        
  }else {
                //��֤ʧ��
                echo $Remark.$Succeed;              
 }

?>