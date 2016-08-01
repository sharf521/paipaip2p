<?php

class tenpayPayment  {

    var $name = '�Ƹ�ͨ';//֧�������ر��Ƽ�����
    var $logo = 'TENPAY';
    var $version = 20070902;
    var $description = "��Ѷ�Ƹ�ͨ��";
    var $type = 1;//1->ֻ��������2->�������
    var $charset = 'GB2312';
	
    var $submitUrl = 'http://service.tenpay.com/cgi-bin/v3.0/payservice.cgi'; //  
    var $orderby = 3;
 
    public static function ToSubmit($data){
		require_once ("modules/payment/classes/tenpay/PayRequestHandler.class.php");
		/* �̻��� */
		$data["money"] =$data["money"]*100;
		$bargainor_id = $data['member_id'];
		
		/* ��Կ */
		$key = $data['PrivateKey'];
		$cmdno = 2;
		/* ���ش����ַ */
		$return_url = $data['return_url'];
		
		//date_default_timezone_set(PRC);
		$strDate = date("Ymd");
		$strTime = date("His");
		
		//4λ�����
		$randNum = rand(1000, 9999);
		
		//10λ���к�,�������е�����
		$strReq = $strTime . $randNum;
		
		/* �̼Ҷ�����,����������32λ��ȡǰ32λ���Ƹ�ֻͨ��¼�̼Ҷ����ţ�����֤Ψһ�� */
		$sp_billno = $data['trade_no'];
		
		/* �Ƹ�ͨ���׵��ţ�����Ϊ��10λ�̻���+8λʱ�䣨YYYYmmdd)+10λ��ˮ�� */
		$transaction_id = $bargainor_id . $strDate . $strReq;
		
		/* ��Ʒ�۸񣨰����˷ѣ����Է�Ϊ��λ */
		$total_fee = (int)$data['money'] ;
		
		/* ��Ʒ���� */
		$desc = $data['subject'];
		
		/* ����֧��������� */
		$reqHandler = new PayRequestHandler();
		$reqHandler->init();
		$reqHandler->setKey($key);
		
		//----------------------------------------
		//����֧������
		//----------------------------------------
		$reqHandler->setParameter("bargainor_id", $bargainor_id);			//�̻���
		$reqHandler->setParameter("sp_billno", $sp_billno);					//�̻�������
		$reqHandler->setParameter("transaction_id", $transaction_id);		//�Ƹ�ͨ���׵���
		$reqHandler->setParameter("total_fee", $total_fee);					//��Ʒ�ܽ��,�Է�Ϊ��λ
		$reqHandler->setParameter("return_url", $return_url);				//���ش����ַ
		$reqHandler->setParameter("desc", $data['body']);	//��Ʒ����
		
		//�û�ip,���Ի���ʱ��Ҫ�����ip��������ʽ�����ټӴ˲���
		$reqHandler->setParameter("spbill_create_ip", $_SERVER['REMOTE_ADDR']);
		
		//�����URL
		$reqUrl = $reqHandler->getRequestURL();
		return $reqUrl;
    }

   function GetFields(){
        return array(
                'member_id'=>array(
                        'label'=>'�ͻ���',
                        'type'=>'string'
                ),
                'PrivateKey'=>array(
                        'label'=>'˽Կ',
                        'type'=>'string'
                ),
                'authtype'=>array(
                    'label'=>'�̼�֧��ģʽ',
                    'type'=>'select',
                    'options'=>array('0'=>'�ײͰ����̼�','1'=>'����֧���̼�')
                )
            );
    }
}
?>
