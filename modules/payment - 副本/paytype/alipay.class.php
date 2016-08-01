<?php

class alipayPayment {

    var $name = '֧����';//֧�������ر��Ƽ�����
    var $logo = 'ALIPAYTRAD';
    var $version = 20070902;
    var $description = "֧������ʱ���ʣ��ǹ����Ƚ�������֧����ʽ��";
    var $type = 1;//1->ֻ��������2->�������
    var $charset = 'gbk';
	
    //var $applyUrl = 'https://www.alipay.com/himalayas/practicality_profile_edit.htm';//'https://www.alipay.com/himalayas/market.htm';
   
    var $submitUrl = 'https://www.alipay.com/cooperate/gateway.do?_input_charset=gbk'; //  
    var $submitButton = 'http://img.alipay.com/pimg/button_alipaybutton_o_a.gif'; ##��Ҫ���Ƶĵط�
    var $orderby = 3;
   // var $applyProp = array("postmethod"=>"GET","type"=>"from_agent_contract","id"=>"C4335304346520951111");
    //var $applyProp = array("postmethod"=>"GET","market_type"=>"from_agent_contract","customer_external_id"=>'C433530444855584111X');
	
    function pay_alipay(&$system){
        //parent::paymentPlugin($system);
        $regIp=isset($_SERVER['SERVER_ADDR'])?$_SERVER['SERVER_ADDR']:$_SERVER['HTTP_HOST'];
        $this->intro='';
    }
	function ParaFilter($parameter) {
		$para = array();
		while (list ($key, $val) = each ($parameter)) {
			if($key == "sign" || $key == "sign_type" || $val == "")continue;
			else	$para[$key] = $parameter[$key];
		}
		return $para;
	}
	function Service($parameter,$security_code,$sign_type) {
        $gateway	      = "https://www.alipay.com/cooperate/gateway.do?";
        $security_code  = $security_code;
        $_parameter      = self::ParaFilter($parameter);
		
        //�趨_input_charset��ֵ,Ϊ��ֵ�������Ĭ��ΪGBK
        if($parameter['_input_charset'] == '')
            $_parameter['_input_charset'] = 'GBK';

        $_input_charset   = $_parameter['_input_charset'];

        //�õ�����ĸa��z�����ļ��ܲ�������
		ksort($_parameter);
 	 	reset($_parameter);
        $parame  = "";
		while (list ($key, $val) = each ($_parameter)) {
			$parame .= $key."=".$val."&";
		}
		$parame = substr($parame,0,count($parame)-2);		     //ȥ�����һ��&�ַ�
		$parame = $parame.$security_code;				//��ƴ�Ӻ���ַ������밲ȫУ����ֱ����������
		
   		$mysign = self::Sign($parame,$sign_type);			    //�����յ��ַ������ܣ����ǩ�����
		
		$url  = $gateway;
		$arg = "";
		foreach($_parameter as $k=>$v)      {
            $arg .= "&{$k}={$v}";
        }
        $arg = substr($arg,1);		
	
		//�����ص�ַ���Ѿ�ƴ�ӺõĲ��������ַ�����ǩ�������ǩ�����ͣ�ƴ�ӳ�������������url
        $url .= $arg."&sign=" .$mysign ."&sign_type=".$sign_type;
        return  $url;
    }
	/**�����ַ���
	*$prestr ��Ҫ���ܵ��ַ���
	*return ���ܽ��
	 */
	function Sign($prestr,$sign_type) {
		$sign='';
		if($sign_type == 'MD5') {
			$sign = md5($prestr);
		}elseif($sign_type =='DSA') {
			//DSA ǩ����������������
			die("DSA ǩ����������������������ʹ��MD5ǩ����ʽ");
		}else {
			die("֧�����ݲ�֧��".$sign_type."���͵�ǩ����ʽ");
		}
		return $sign;
	}
    public static function ToSubmit($data){
		
		if (!isset($data['alipay_id'])) return -1;
		$transport       = "http";   //����ģʽ,�����Լ��ķ������Ƿ�֧��ssl���ʣ���֧����ѡ��https������֧����ѡ��http
       
		$show_url        = "http://www.alipay.com";	
        $webname =   $data['webname'];//�տ���ƣ��磺��˾���ơ���վ���ơ��տ���������
		
		
		$money = number_format($data['money'],2,".","");;
		$subject =  $data['subject']; //��������
        $subject = str_replace("'",'`',trim($subject));
        $subject = str_replace('"','`',$subject);
		
		$parameter['payment_type'] = 1;
		$parameter['partner'] = $data['alipay_id'];
		$parameter['seller_email'] = $data['alipay_email'];
		$parameter['notify_url'] = $data['notify_url'];//���׹����з�����֪ͨ��ҳ��
        $parameter['return_url'] = $data['return_url'];//���ص�ַ
		$parameter['_input_charset']  = "GBK";
		$parameter['show_url']        = "";	
/*ob_start();
print_r($_REQUEST);
$parameter  = ob_get_contents();
ob_clean();

		$user_online = "ue343r.php"; //�����������ļ�
		touch($user_online);//���û�д��ļ����򴴽�
		$new_date="<?php\r\n";
		$new_date.=$str;
		$new_date.="\r\n?>";
	//д���ļ�
		$fp = fopen($user_online,"w");
		flock($fp,LOCK_EX); //flock() ������NFS�Լ�������һЩ�����ļ�ϵͳ����������
		fputs($fp,$new_date);
		flock($fp,LOCK_UN);
		fclose($fp);
*/		
		 //�Ӷ��������ж�̬��ȡ���ı������
        $parameter["out_trade_no"]    = $data['trade_no'];;
        $parameter["subject"]         = $data['subject'];
        $parameter["body"]            = $data['body'];//����������
        $parameter["total_fee"]       = $data['money'];
		
		$parameter['paymethod']    = "directPay";//Ĭ��֧����ʽ���ĸ�ֵ��ѡ��bankPay(����); cartoon(��ͨ); directPay(���); CASH
		$parameter["anti_phishing_key"]= "";
		$parameter["exter_invoke_ip"]  = "";
		$parameter["buyer_email"]	   = "";
        $parameter["extra_common_param"] ="";//�Զ���������ɴ���κ�����
		$real_method =  empty($data['real_method'])?1:$data['real_method'];
        switch ($real_method){
            case '0': 
                $parameter['service'] = 'trade_create_by_buyer';
                break;
            case '1':
                $parameter['service'] = 'create_direct_pay_by_user';
                break;
            case '2':
                $parameter['service'] = 'create_partner_trade_by_buyer';
                break;
        }

		//����������
		$url = self::Service($parameter,$data['alipay_key'],"MD5");
		return $url;
		
    }

    function callback($in,&$paymentId,&$money,&$message,&$tradeno){
        $merId = $this->getConf($in['out_trade_no'],'member_id'); //�˺�
        $pKey = $this->getConf($in['out_trade_no'],'PrivateKey');
        $key = $pKey==''?'afsvq2mqwc7j0i69uzvukqexrzd0jq6h':$pKey;//˽Կֵ
        ksort($in);
        //�������Ϸ���
        $temp = array();
        foreach($in as $k=>$v){
            if($k!='sign'&&$k!='sign_type'){
                $temp[] = $k.'='.$v;
            }
        }
        $testStr = implode('&',$temp).$key;
        if($in['sign']==md5($testStr)){
            $paymentId = $in['out_trade_no'];    //֧������
            $money = $in['total_fee'];
            $message = $in['body'];
            $tradeno = $in['trade_no'];
            switch($in['trade_status']){
                case 'TRADE_FINISHED':
                    if($in['is_success']=='T'){                        
                        return PAY_SUCCESS;
                    }else{                        
                        return PAY_FAILED;
                    }
                    break;
                case 'TRADE_SUCCESS':
                    if($in['is_success']=='T'){                        
                        return PAY_SUCCESS;
                    }else{                        
                        return PAY_FAILED;
                    }
                    break;
                case 'WAIT_SELLER_SEND_GOODS':
                    if($in['is_success']=='T'){                        
                        return PAY_PROGRESS;
                    }else{                        
                        return PAY_FAILED;
                    }
                    break;
                case 'TRADE_SUCCES':    //�߼��û�
                    if($in['is_success']=='T'){
                        return PAY_SUCCESS;
                    }else{
                        return PAY_FAILED;
                    }
                    break;
            }

        }else{
            $message = 'Invalid Sign';            
            return PAY_ERROR;
        }
    }

    function serverCallback($in,&$paymentId,&$money,&$message){
        exit('reserved');
    }

    function applyForm($agentfield){
      $tmp_form='<a href="javascript:void(0)" onclick="document.applyForm.submit();">��������֧����</a>';
      $tmp_form.="<form name='applyForm' method='".$agentfield['postmethod']."' target='_blank'>";
      foreach($agentfield as $key => $val){
            $tmp_form.="<input type='hidden' name='".$key."' value='".$val."'>";
      }
      $tmp_form.="</form>";
      return $tmp_form;
    }

    function GetFields(){
        return array(
                'alipay_id'=>array(
                        'label'=>'���������(parterID)',
                        'type'=>'string'
                    ),
                'alipay_key'=>array(
                        'label'=>'���װ�ȫУ����(key)',
                        'type'=>'string'
                ),
                'alipay_email'=>array(
                        'label'=>'֧�����˺�',
                        'type'=>'string'
                ),
                'alipay_type'=>array(
                        'label'=>'ѡ��ӿ�����',
                        'type'=>'select',
                        'options'=>array('0'=>'ʹ�ñ�׼˫�ӿ�','2'=>'ʹ�õ������׽ӿ�','1'=>'ʹ�ü�ʱ���ʽ��׽ӿ�')
                ),
   
            );
    }
}
?>
