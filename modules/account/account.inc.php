<?php
if (!defined('ROOT_PATH'))  die('���ܷ���');//��ֱֹ�ӷ���
include_once("account.class.php");
include_once (ROOT_PATH."core/encrypt.php");

//liukun add for bug 52 begin
$firePHPEnable=TRUE;
if ($firePHPEnable){
	require_once('modules/FirePHPCore/FirePHP.class.php');
	require_once('modules/FirePHPCore/fb.php');
	ob_start();

	$firephp = FirePHP::getInstance(true);
}
//liukun add for bug 52 end

if (isset($_POST['valicode']) && $_POST['valicode']!=$_SESSION['valicode']){
	//if (1!=1){
	$msg = array("��֤�����","",$_U['query_url']."/".$_U['query_type']);
}else{
	$_SESSION['valicode'] = "";
	if ($_U['query_type'] == "list"){

	}

	elseif ($_U['query_type'] == "log"){
		$data['user_id'] = $_G['user_id'];
		$data['page'] = $_U['page'];
		$data['epage'] = 20;
		$data['dotime1'] = isset($_REQUEST['dotime1'])?$_REQUEST['dotime1']:"";
		$data['dotime2'] = isset($_REQUEST['dotime2'])?$_REQUEST['dotime2']:"";
		$data['type'] = isset($_REQUEST['type'])?$_REQUEST['type']:"";
		$result = accountClass::GetLogList($data);
		if (is_array($result)){
			$pages->set_data($result);
			$_U['account_log_list'] = $result['list'];
			$_U['show_page'] = $pages->show(3);
			$_U['account_num'] = $result['account'];
		}else{
			$msg = array($result);
		}
	}

	elseif ($_U['query_type'] == "awardlog"){
		$data['user_id'] = $_G['user_id'];
		$data['page'] = $_U['page'];
		$data['epage'] = 20;
		$data['dotime1'] = isset($_REQUEST['dotime1'])?$_REQUEST['dotime1']:"";
		$data['dotime2'] = isset($_REQUEST['dotime2'])?$_REQUEST['dotime2']:"";
		$data['type'] = isset($_REQUEST['type'])?$_REQUEST['type']:"";
		$result = accountClass::GetAwardLogList($data);
		if (is_array($result)){
			$pages->set_data($result);
			$_U['award_log_list'] = $result['list'];
			$_U['show_page'] = $pages->show(3);
			$_U['account_num'] = $result['account'];
		}else{
			$msg = array($result);
		}
	}

	elseif ($_U['query_type'] == "cash"){
		$data['user_id'] = $_G['user_id'];
		$result = accountClass::GetUserLog($data);
		$_U['cash_log'] = $result;
		$data['page'] = $_U['page'];
		$data['epage'] = $_U['epage'];
		$result = accountClass::GetCashList($data);
		if (is_array($result)){
			$pages->set_data($result);
			$_U['account_cash_list'] = $result['list'];
			$_U['show_page'] = $pages->show(3);
		}else{
			$msg = array($result);
		}
	}

	elseif ($_U['query_type'] == "recharge"){
		$result = accountClass::GetUserLog(array("user_id"=>$_G['user_id']));
		$_U['account_log'] = $result;
	}

	elseif ($_U['query_type'] == "recharge_new"){
		include_once(ROOT_PATH."modules/payment/payment.class.php");
		
		if (isset($_POST['money'])){
			$data['user_id'] = $_G['user_id'];
			$data['type'] = $_POST['type'];
			if ($data['type']==1){
				$data['status'] = 0;//��������ϳ�ֵ
			}else{
				$data['status'] = 0;//��������³�ֵ
			}
			$data['money'] = $_POST['money'];
			
			
			/***/
			//echo $_POST['payment1'];
			//$payment = explode("_",$_POST['payment1']);
			// 			if(count($payment)==2){  // ͨ����������
			// 				if($payment[1]=='g'){  //  xx_g ��β��ͨ�������� ����
			// 					$bco = $payment[0];
			// 					$_POST['payment1']=32;
			// 				}else if($payment[1] == 's'){ //xx_s ��β��ͨ��IPS ����
			// 					$bco = $payment[0];
			// 					$_POST['payment1'] = 10;
			// 				}else if($payment[1] == 't'){
			// 					$bco = $payment[0];
			// 					$_POST['payment1'] = 47;
			// 				}
			// 			}
			//2)ʹ�ù�����

			if($data['type'] == 1 && !is_numeric($_POST['payment1']))
			{
				$_bank = explode("_",$_POST['payment1']);
				$bco = $_bank[0];
				$_POST['payment1']=11;//���ѡ����������ֱ�ӵ��㸶����
				$GateId = $_bank[1];
			}

			//*************************************************************


			if (is_numeric($data['money']) && $data['money'] > 0){
				$data['remark'] = $_POST['remark'];
				$data['type'] = $_POST['type'];
				$url = "";
				if ($data['type']==1){
					$data['payment'] = $_POST['payment1'];

					$data['remark'] = $_POST['payname'.$_POST['payment1']]."���߳�ֵ";
					$data['fee'] = 0;//��ֵ������
				}else{
					$data['payment'] = $_POST['payment2'];
					$data['fee'] = 0;
					// 					if($data['money'] >= 20000){
					// 						$data['hongbao']=round($data['money']*0.001,2);//����ǧ��֮һ�ĺ����
					// 					}
				}


				$data['trade_no'] = time().$_G['user_id'].rand(1,9);
				$result = accountClass::AddRecharge($data);
				if ($data['type']==1)
				{
					if(isset($bco)) //$data['bankCode'] = $bco;
					{$data['InstCode'] = $bco;$data['PayType']='PT001';
					}  //LiuYY 2012-06-01
					$data['subject'] = "�˺ų�ֵ";
					//$data['subject'] = $_G['system']['con_webname']."�˺ų�ֵ";
					$data['body'] = "�˺ų�ֵ";
					if (isset($GateId) && $GateId !=""){
						$data['GateId'] = $GateId;
					}
					if($_POST['payment1']==11)
					{
						$data['OrdAmt']=$data['money'];
						$data['GateId']=$data['GateId'];
						$data['MerPriv'] = $_G['user_id'].'#'.$_SERVER['HTTP_HOST'];//�̻�˽��������
						$data['UsrSn']=$data['trade_no'];
						paymentClass::ToSubmit_auto($data);
						exit;	
					}
					else
					{
						$url = paymentClass::ToSubmit($data);
					}
				}
				if ($result!==true){
					$msg = array($result,"",$_U['query_url']."/".$_U['query_type']);
				}else{
					if ($url!=""){
						header("Location: {$url}");
						exit;
						$msg = array("��վ����ת��֧����վ<br>���û��Ӧ�����������֧����վ�ӿ�","֧����վ",$url);
					}else{
						$msg = array("���Ѿ��ɹ��ύ�˳�ֵ����ȴ�����Ա����ˡ�","",$_U['query_url']."/".$_U['query_type']);
					}
				}
			}else{
				if((float)$data['money'] <= 0)
				{
					$msg = array("���ʳ�ֵ���ܵ���80Ԫ��","",$_U['query_url']."/".$_U['query_type']);
				}
				else
				{
					$msg = array("�����д����","",$_U['query_url']."/".$_U['query_type']);
				}
			}
		}else{
			$_U['account_payment_list'] = paymentClass::GetList(array("status"=>1));
			

		}
	}
	elseif ($_U['query_type'] == "bankxxx"){
		if (isset($_POST['account'])){
			$var = array("user_id","account","bank","branch");
			$data = post_var($var);
			$result = accountClass::ActionBank($data);
			if ($result!==true){
				$msg = array($result);
			}else{
				$msg = array("�����ɹ�");
			}
		}else{
			$data['user_id'] = $_G["user_id"];
			$result = accountClass::GetBankOne($data);
			$data_account = $result['account'];

			$length_of_account = strlen($data_account);//length_of_account Ϊ �˻�����
			$str = $data_account;
			if($length_of_account <= 5){  //����С��5��ȫ��Ϊ*
				for($i=0; $i<$length_of_account;$i++){
					$str[$i] ='*';
				}
			}else{  //���5λΪ*
				for($i=$length_of_account-5;$i < $length_of_account;$i++){
					$str[$i] = '*';
				}
			}
			$result['account_view'] = $str;
			$_U['account_bank_result'] = $result;
		}
	}
	elseif ($_U['query_type'] == "bank"){
		if (isset($_POST['account'])){
			$var = array("user_id","account","bank","branch");
			$data = post_var($var);
			$sqls="select id,code,lasttime from {sms_check} where itype=2 and isuse=0 and user_id=".$_G['user_id']." and lasttime>unix_timestamp() order by id desc limit 1";
			$coderesult= $mysql->db_fetch_array($sqls);
			$sms_available = $_G['sms_available'];
			if ($sms_available == 0 || ($sms_available == 1 && $coderesult["lasttime"]>time()))
			{
				if ($sms_available == 0 || ($sms_available == 1 && $coderesult["code"]==(int)$_POST['mobilecode']))
				{
					if($data['account']=="" || $data['branch']=="" || $data['bank']=="" ){
						$msg = array("��������д�����˺ŵ���Ϣ��������Ϊ��");
					}else{
						$data['user_id'] = $_G["user_id"];
						$result = accountClass::ActionBank($data);
						if ($result!==true){
							$msg = array($result);
						}else{
							if ($sms_available == 1){
								$sql = "update  {sms_check}  set isuse=1 where id=".$coderesult["id"];
								$mysql->db_query($sql);
							}
							$msg = array("�����ɹ�");
						}
					}
				}else
				{
					$msg = array("�ֻ���֤�벻��ȷ��");
				}
			}else{
				$msg = array("�ֻ���֤�벻��ȷ�����·��ͣ�");
			}
		}else{
			$data['user_id'] = $_G["user_id"];
			$result = accountClass::GetBankOne($data);
			$data_account = $result['account'];

			$length_of_account = strlen($data_account);//length_of_account Ϊ �˻�����
			$str = $data_account;
			if($length_of_account <= 5){  //����С��5��ȫ��Ϊ*
				for($i=0; $i<$length_of_account;$i++){
					$str[$i] ='*';
				}
			}else{  //���5λΪ*
				for($i=$length_of_account-5;$i < $length_of_account;$i++){
					$str[$i] = '*';
				}
			}
			$result['account_view'] = $str;
			$_U['account_bank_result'] = $result;
		}
	}
	elseif ($_U['query_type'] == "l2m"){
		if (isset($_POST['amount'])){
			$data['user_id'] = $_G["user_id"];
			$data['trantype'] = $_POST['trantype'];
			$data['malltype'] = $_POST['malltype'];
			$data['amount'] = $_POST['amount'];
			$result = accountClass::L2MbyUc($data);
			if ($result!==true){
				$msg = array($result);
			}else{
				$msg = array("�����ɹ�");
			}
		}else{
			$data['user_id'] = $_G["user_id"];
			$result = accountClass::GetBankOne($data);
			$_U['account_bank_result'] = $result;
			$_U['account_bank_result']['tran_amount'] = $result['use_money'] - $result['nocash_money'];
			$_U['trantype'] = $_REQUEST['trantype'];
			$_U['malltype'] = $_REQUEST['malltype'];


		}
	}

	//�õ����ַ���--����ǰ̨��ʾ
	elseif ($_U['query_type'] == "getCashFee"){
		//include_once(ROOT_PATH."modules/borrow/borrow.class.php");
		//$data['user_id'] = $_G["user_id"];
		//$data['cashAmount'] = $_REQUEST['cashAmount'];
		//$cashFee = borrowClass::GetCashFeeAmount($data);
		echo true;
		exit;
	}


	elseif ($_U['query_type'] == "cash_newxxx"){

		include_once(ROOT_PATH."modules/borrow/borrow.class.php");

		$data['user_id'] = $_G["user_id"];
		$result = accountClass::GetBankOne($data);
		$user = userClass::GetOnes($data);
		$acccount_result = borrowClass::GetCashMaxAmount($data);


		$data_account = $result['account'];
		$length_of_account = strlen($data_account);//length_of_account Ϊ �˻�����
		$str = $data_account;
		if($length_of_account <= 5){  //����С��5��ȫ��Ϊ*
			for($i=0; $i<$length_of_account;$i++){
				$str[$i] ='*';
			}
		}else{  //���5λΪ*
			for($i=$length_of_account-5;$i < $length_of_account;$i++){
				$str[$i] = '*';
			}
		}
		$result['account_view'] = $str;
		$_U['account_bank_result'] = $result;
		if ($result['bank']==""){
			$msg = array("���������˺Ż�û��д������<a href='/index.php?user&q=code/account/bank'><font color='red'><strong>��д</strong></font></a>","","{$_U['query_url']}/bank");
		}else if( $user['real_status']!=1 ) {
			$msg = array("����δͨ��ʵ����֤������<a href='/index.php?user&q=code/user/realname'><font color='red'><strong>��д</strong></font></a>","","/index.php?user&q=code/user/realname&userid={$data['user_id']}");
		}
		//liukun add for bug 121 end
		else if ($user['is_restructuring'] == 1){
			$msg =  array("��Ŀǰ��ծ�������У��������֡�", "", "/index.action?user");
		}
		//liukun add for bug 121 end
		elseif ($acccount_result['maxCashAmount'] < round($_POST['money'],2)){
			$msg =  array("�������������������ֽ�", "", "/index.action?user");
		}
		else{
			if(isset($_POST['money'])){
				if ($result['paypassword']==md5($_POST['paypassword'])){
					$data['status'] = 0;
					$data['total'] = round($_POST['money'],2);
					//repair by weego 20120529 for ���ָ���
					if (is_numeric($data['total'])){
						$data['account'] = $result['account'];
						$data['bank'] = $result['bank'];
						$data['branch'] = $result['branch'];

						/*
						 if (isset($_U["account_cash_status"]) && $_U["account_cash_status"]==1){
						$data["fee"] = GetCashFee($data['total']);
						}else{

						if ($data['total'] <= 30000){
						$data['fee'] = 3;
						}elseif ($data['total'] > 30000 && $data['total']<=50000){
						$data['fee'] = 5;
						}else{
						$data['fee'] = 3;
						}
						}*/

						$dataCash["user_id"]=$data['user_id'];
						$dataCash["cashAmount"]=$data['total'];

						//                                                 $data['fee'] = borrowClass::GetCashFeeAmount($dataCash);

						//add by jackfeng 2012-7-9
						$data['fee'] = 0;
						$data['hongbao']=0;
						// 						if(isset($_POST['hongbaoUsed'])&& $_POST['hongbaoUsed']>0 ){
						// 							$data['hongbao']=$_POST['hongbaoUsed'];//ʹ�ú��
						// 						}else{
						// 							$data['hongbao']=0;
						// 						}
						// 						$sql = "update  {user}  set hongbao = hongbao - ".$data['hongbao']." where user_id=".$result['user_id'];

						// 						$mysql->db_query($sql);

						/*
						 if ($data['total'] >= 5000){
						$data['fee'] = 50;
						}else{
						$data['fee'] = $data['total']*0.01;
						}
						*/
						//update by jackfeng 2012-7-9
						//$data['credited']=$data['total']-$data['fee'];
						// 						$data['credited']=$data['total']-$data['fee']+$data['hongbao'];
						$data['credited']=0;

						$_result = accountClass::AddCash($data);
						if ($_result!==true){
							$msg = array($_result);
						}else{
							$account_result =  accountClass::GetOne(array("user_id"=>$_G['user_id']));
							$log['user_id'] = $_G['user_id'];
							$log['type'] = "cash_frost";
							$log['money'] = $data['total'];
							$log['total'] = $account_result['total'];
							$log['use_money'] =  $account_result['use_money']-$log['money'];
							$log['no_use_money'] =  $account_result['no_use_money']+$log['money'];
							$log['collection'] =  $account_result['collection'];
							$log['to_user'] = "0";
							$log['remark'] = "�û���������";
							accountClass::AddLog($log);

							$msg = array("���������Ѿ��ύ�����ǽ���������������Ϊ�����","",'/index.php?user&q=code/account/cash_new');
						}
					}else{
						$msg = array("�����д����","",'/index.php?user&q=code/account/cash_new');
							
					}
				}else{
					$msg = array("����������д����","",'/index.php?user&q=code/account/cash_new');
				}
			}
		}
	}
	elseif ($_U['query_type'] == "cash_new"){

		include_once(ROOT_PATH."modules/borrow/borrow.class.php");

		$data['user_id'] = $_G["user_id"];
		

		
		$result = accountClass::GetBankOne($data);
		$user = userClass::GetOnes($data);
		$acccount_result = borrowClass::GetCashMaxAmount($data);


		$data_account = $result['account'];
		$length_of_account = strlen($data_account);//length_of_account Ϊ �˻�����
		$str = $data_account;
		if($length_of_account <= 5){  //����С��5��ȫ��Ϊ*
			for($i=0; $i<$length_of_account;$i++){
				$str[$i] ='*';
			}
		}else{  //���5λΪ*
			for($i=$length_of_account-5;$i < $length_of_account;$i++){
				$str[$i] = '*';
			}
		}
		$result['account_view'] = $str;
		$_U['account_bank_result'] = $result;
		if ($result['bank']==""){
			$msg = array("���������˺Ż�û��д������<a href='/index.php?user&q=code/account/bank'><font color='red'><strong>��д</strong></font></a>","","{$_U['query_url']}/bank");
		}else if( $user['real_status']!=1 ) {
			$msg = array("����δͨ��ʵ����֤������<a href='/index.php?user&q=code/user/realname'><font color='red'><strong>��д</strong></font></a>","","/index.php?user&q=code/user/realname&userid={$data['user_id']}");
		}
		else if(userClass::isHasLastRepayment(array('user_id'=>$_G["user_id"])))
		{
			$msg =  array("���Ľ����Ѿ����ڣ��뾡�컹��󣬲����������֡�", "", "/index.action?user");	
		}
		//liukun add for bug 121 end
		else if ($user['is_restructuring'] == 1){
			$msg =  array("��Ŀǰ��ծ�������У��������֡�", "", "/index.action?user");
		}
		//liukun add for bug 121 end
		elseif ($acccount_result['maxCashAmount'] < round($_POST['money'],2)){
			$msg =  array("�������������������ֽ�", "", "/index.action?user");
		}
		else{
			if(isset($_POST['money'])){
				$sqls="select id,code,lasttime from {sms_check} where itype=1 and isuse=0 and user_id=".$data['user_id']." and lasttime>unix_timestamp() order by id desc limit 1";
				$coderesult= $mysql->db_fetch_array($sqls);
				$sms_available = $_G['sms_available'];
				if ($sms_available == 0 || ($sms_available == 1 && $coderesult["lasttime"]>time()))
				{
					if ($sms_available == 0 || ($sms_available == 1 && $coderesult["code"]==(int)$_POST['mobilecode']))
					{
						if ($result['paypassword']==md5($_POST['paypassword'])){
							$data['status'] = 0;
							$data['total'] = round($_POST['money'],2);
							//repair by weego 20120529 for ���ָ���
							if (is_numeric($data['total'])){
								$data['account'] = $result['account'];
								$data['bank'] = $result['bank'];
								$data['branch'] = $result['branch'];

								/*
								 if (isset($_U["account_cash_status"]) && $_U["account_cash_status"]==1){
								$data["fee"] = GetCashFee($data['total']);
								}else{

								if ($data['total'] <= 30000){
								$data['fee'] = 3;
								}elseif ($data['total'] > 30000 && $data['total']<=50000){
								$data['fee'] = 5;
								}else{
								$data['fee'] = 3;
								}
								}*/

								$dataCash["user_id"]=$data['user_id'];
								$dataCash["cashAmount"]=$data['total'];

								//                                                 $data['fee'] = borrowClass::GetCashFeeAmount($dataCash);

								//add by jackfeng 2012-7-9
								$data['fee'] = 0;
								$data['hongbao']=0;
								// 						if(isset($_POST['hongbaoUsed'])&& $_POST['hongbaoUsed']>0 ){
								// 							$data['hongbao']=$_POST['hongbaoUsed'];//ʹ�ú��
								// 						}else{
								// 							$data['hongbao']=0;
								// 						}
								// 						$sql = "update  {user}  set hongbao = hongbao - ".$data['hongbao']." where user_id=".$result['user_id'];

								// 						$mysql->db_query($sql);

								/*
								 if ($data['total'] >= 5000){
								$data['fee'] = 50;
								}else{
								$data['fee'] = $data['total']*0.01;
								}
								*/
								//update by jackfeng 2012-7-9
								//$data['credited']=$data['total']-$data['fee'];
								// 						$data['credited']=$data['total']-$data['fee']+$data['hongbao'];
								$data['credited']=0;

								$_result = accountClass::AddCash($data);
								if ($_result!==true){
									$msg = array($_result);
								}else{
									$account_result =  accountClass::GetOne(array("user_id"=>$_G['user_id']));
									$log['user_id'] = $_G['user_id'];
									$log['type'] = "cash_frost";
									$log['money'] = $data['total'];
									$log['total'] = $account_result['total'];
									$log['use_money'] =  $account_result['use_money']-$log['money'];
									$log['no_use_money'] =  $account_result['no_use_money']+$log['money'];
									$log['collection'] =  $account_result['collection'];
									$log['to_user'] = "0";
									$log['remark'] = "�û���������";
									accountClass::AddLog($log);

									$msg = array("���������Ѿ��ύ�����ǽ���������������Ϊ�����","",'/index.php?user&q=code/account/cash_new');
									if ($sms_available == 1){
										$sql = "update  {sms_check}  set isuse=1 where id=".$coderesult["id"];
										$mysql->db_query($sql);
									}
								}
							}else{
								$msg = array("�����д����","",'/index.php?user&q=code/account/cash_new');
									
							}
						}else{
							$msg = array("����������д����","",'/index.php?user&q=code/account/cash_new');
						}
					}else
					{
						$msg = array("�ֻ���֤�벻��ȷ��");
					}
				}else{
					$msg = array("�ֻ���֤�벻��ȷ�����·��ͣ�");
				}
			}
		}
	}
	elseif ($_U['query_type'] == "cash_new_sms"){
		$data['user_id'] = $_G["user_id"];
		$itype=$_GET["itype"];
		$randnum=rand(100000,999999);
		$lasttime=time()+5*60;
		$sql = "insert into  {sms_check} (code,lasttime,user_id,addtime,itype) values('".$randnum."','".$lasttime."',".$_G["user_id"].",unix_timestamp(),".$itype.")";
		$mysql->db_query($sql);
		if ($itype==1)
		{
			sendSMS($_G["user_id"],"���ȡ����֤���ǣ�".$randnum."����5�������ύ��--".$_G['sitename'],1);
		}elseif($itype==2)
		{
			sendSMS($_G["user_id"],"���������֤���ǣ�".$randnum."����5�������ύ��--".$_G['sitename'],1);
		}
		//echo date("Y-m-d H:i:s",$lasttime) ;
		echo "1";
		return;
	}
	//ȡ����������
	elseif ($_U['query_type'] == "cash_cancel"){
		$data['user_id'] =  $_G['user_id'];
		$data['id'] =  $_REQUEST['id'];
		$cash_result = accountClass::GetCashOne($data);

		if($cash_result!=false && $cash_result['status']==0){
			$data['status'] = 3;
			$_result = accountClass::UpdateCash($data);
			if ($_result!==true){
				$msg = array($_result);
			}else{
				$account_result = accountClass::GetOne($data);
				$log['user_id'] = $data['user_id'];
				$log['type'] = "cash_cancel";
				$log['money'] = $cash_result['total'];
				$log['total'] = $account_result['total'];
				$log['use_money'] = $account_result['use_money']+$cash_result['total'];
				$log['no_use_money'] = $account_result['no_use_money']-$cash_result['total'];
				$log['collection'] =  $account_result['collection'];
				$log['to_user'] = "0";
				$log['remark'] = "ȡ�����ֽⶳ";
				accountClass::AddLog($log);

				//add by jackfeng 2012-7-9 ȡ������ �������
				// 				$sql = "update  {user}  set hongbao = hongbao + ".$cash_result['hongbao']." where user_id=".$data['user_id'];
				// 				$mysql->db_query($sql);


				$msg = array("�ɹ�ȡ������");
			}
		}else{
			$msg = array("�벻Ҫ�Ҳ���");
		}

	}

	//liukun add for bug 253 begin

	//liukun add for test  i_user_info begin
	elseif ($_U['query_type'] == "get_user_info"){
		$con_mall_key = isset($_G['system']['con_mall_key'])?$_G['system']['con_mall_key']:"1234abc5678";

		require_once (ROOT_PATH."core/HttpClient.class.php");
		$srv_ip = 'dev.hndai.com';//���Ŀ������ַ.
		$srv_port = 80;//�˿�
		$url = 'http://dev.hndai.com/index.php?user&q=code/account/i_user_info'; //������post��URL�����ַ
		$fp = '';
		$errno = 0;//������
		$errstr = '';//������
		$timeout = 10;//���û�����Ͼ��ж�
		$e_uc_user_id = DeCode(3285,'E',$con_mall_key);
		$post_str = "user_id={$e_uc_user_id}";//Ҫ�ύ������.
		//������� Socket ���ӡ�
		$fp = fsockopen($srv_ip,$srv_port,$errno,$errstr,$timeout);
		if (!$fp){
			echo('fp fail');
		}
		$content_length = strlen($post_str);
		$post_header = "POST $url HTTP/1.1\r\n";
		$post_header .= "Content-Type: application/x-www-form-urlencoded\r\n";
		$post_header .= "User-Agent: MSIE\r\n";
		$post_header .= "Host: ".$srv_ip."\r\n";
		$post_header .= "Content-Length: ".$content_length."\r\n";
		$post_header .= "Connection: close\r\n\r\n";
		$post_header .= $post_str."\r\n\r\n";
		fwrite($fp,$post_header);

		$inheader = 1;
		while(!feof($fp)){//�����ļ�ָ���Ƿ����ļ�������λ��
			$line = fgets($fp,1024);
			//ȥ���������ͷ��Ϣ
			if ($inheader && ($line == "\n" || $line == "\r\n")) {
				$inheader = 0;
			}
			if ($inheader == 0) {
				//echo $line;
			}
		}
		fclose($fp);
		echo $line;
		die();
	}
	//liukun add for test  i_user_info end

	elseif ($_U['query_type'] == "i_user_info"){
		$con_mall_key = isset($_G['system']['con_mall_key'])?$_G['system']['con_mall_key']:"1234abc5678";
		$e_uc_user_id = $_REQUEST['user_id'];
		$data['uc_user_id'] =  DeCode($e_uc_user_id,'D',$con_mall_key);
		fb($_REQUEST, FirePHP::TRACE);
		fb($data, FirePHP::TRACE);
		$account_result = accountClass::GetOnebyUc($data);
		fb($account_result, FirePHP::TRACE);

		if ($account_result!=false){
			$rss['result']=1;
			$rss['user_id']=$e_uc_user_id;
			$rss['account_total']=round($account_result['total'],2);
			$rss['account_cash']=round(($account_result['use_money']-$account_result['nocash_money']),2);
			$rss['award']=round($account_result['award_interest'],2);
		}else{
			$rss['result']=0;
			$rss['user_id']=$e_uc_user_id;
			$rss['account_total']=0;
			$rss['account_cash']=0;
			$rss['award']=0;
		}
		echo json_encode($rss);
		die();
	}

	//liukun add for bug 253 end

	//liukun add for bug 252 begin
	elseif ($_U['query_type'] == "i_accountl2m"){
		$point2account = isset($_G['system']['con_point2account'])?$_G['system']['con_point2account']:"2.52";
		$con_mall_key = isset($_G['system']['con_mall_key'])?$_G['system']['con_mall_key']:"1234abc5678";
		$href="location:".$_REQUEST['target']."?1=1";

		$op_result=0;
		$request_url = $_SERVER["REQUEST_URI"];
		$mall_op_id= $_REQUEST['op_id'];
		$mall_key = $_REQUEST['mall_key'];
		$money = $_REQUEST['money'];
		//��֤�Ƿ��ǺϷ�����
		$d_mall_op_id = DeCode($mall_key,'D',$con_mall_key);
		if ($d_mall_op_id!=$mall_op_id || $money < 0 || !is_numeric($money)){
			$rs2['result']=3;
			echo json_encode($rs2);
			die();
		}
			
		$e_uc_user_id = $_REQUEST['user_id'];
		$data['uc_user_id'] =  DeCode($e_uc_user_id,'D',$con_mall_key);
		$account_result = accountClass::GetOnebyUc($data);
		if(!is_array($account_result)){
			$rs2['result']=3;
			echo json_encode($rs2);
			die();
		}

		$sql = "select count(*) as op_num from  {mall_operate_log}  where mall_op_id='{$mall_op_id}'";
		$result = $mysql ->db_fetch_array($sql);

		$op_num = $result['op_num'];

		//�ж��Ƿ������
		if ($op_num ==0){
			$op_money= round($money, 2);

			$user_id= $account_result['user_id'];
			if (($account_result['use_money'] - $account_result['nocash_money']) < $op_money){
				$result = false;
			}else{
				$op_log['user_id'] = $user_id;
				$op_log['type'] = "i_accountl2m";
				$op_log['money'] = $op_money;
				$op_log['total'] = $account_result['total']-$op_log['money'];
				$op_log['use_money'] = $account_result['use_money']-$op_log['money'];
				$op_log['no_use_money'] = $account_result['no_use_money'];
				$op_log['collection'] = $account_result['collection'];
				$op_log['to_user'] = "0";
				$op_log['remark'] = "���̳�ת���ʽ�";
				$result=accountClass::AddLog($op_log);
			}
			if ($result!=false){
				$op_result=1;
				$rs2['result']=1;
				$rs2['user_id']=$e_uc_user_id;
				$rs2['money']=$money;
				foreach($rs2 as $key => $value){
					$href .= "&{$key}={$value}";
				}
			}else{
				$op_result=0;
				$rs2['result']=0;
				$href .= "&result=0";
			}
		}
		else{
			$op_result=2;
			$rs2['result']=2;
			$href .= "&result=2";
		}


		$return_url = $href;


		$op_data['mall_op_id'] = $mall_op_id;
		$op_data['process_result'] = $op_result;
		$op_data['request_url'] = $request_url.json_encode($_REQUEST);
		$op_data['return_url'] = $return_url;


		$sql = "insert into  {mall_operate_log}  set `addtime` = '".time()."',`addip` = '".ip_address()."'";
		foreach($op_data as $key => $value){
			$sql .= ",`$key` = '$value'";
		}

		$result = $mysql->db_query($sql);

		echo json_encode($rs2);
		die();



	}
	//liukun add for bug 252 end

	//liukun add for bug 255 begin
	elseif ($_U['query_type'] == "i_accountm2l"){
		$point2account = isset($_G['system']['con_point2account'])?$_G['system']['con_point2account']:"2.52";
		$con_mall_key = isset($_G['system']['con_mall_key'])?$_G['system']['con_mall_key']:"1234abc5678";
		$href="location:".$_REQUEST['target']."?1=1";

		$op_result=0;
		$request_url = $_SERVER["REQUEST_URI"];
		$mall_op_id= $_REQUEST['op_id'];
		$mall_key = $_REQUEST['mall_key'];
		$money = $_REQUEST['money'];
		//��֤�Ƿ��ǺϷ�����
		if ($_REQUEST['mall_key'] != DeCode($mall_op_id,'E',$con_mall_key) || $money < 0 || !is_numeric($money)){
			echo '{"result":0,"error":"no_check"}';	
			die();
		}

		$e_uc_user_id = $_REQUEST['user_id'];
		$data['uc_user_id'] = $e_uc_user_id;
		$account_result = accountClass::GetOnebyUc($data);
		if(!is_array($account_result)){
			$rs3['result']=3;
			echo '{"result":0,"error":"no_user"}';	
			die();
		}

		$sql = "select count(*) as op_num from  {mall_operate_log}  where mall_op_id='{$mall_op_id}' ";
		$result = $mysql ->db_fetch_array($sql);

		$op_num = $result['op_num'];

		//�ж��Ƿ������
		if ($op_num ==0){

			$op_money= round($money, 2);

			$user_id= $account_result['user_id'];
			$op_log['user_id'] = $user_id;
			$op_log['type'] = "i_accountm2l";
			$op_log['money'] = $op_money;
			$op_log['total'] = $account_result['total']+$op_log['money'];
			$op_log['use_money'] = $account_result['use_money']+$op_log['money'];
			$op_log['no_use_money'] = $account_result['no_use_money'];
			$op_log['collection'] = $account_result['collection'];
			$op_log['to_user'] = "0";			
			
			if($_REQUEST['type']==1)
				$op_log['remark'] = "�ӻ����̳�ת���ʽ�";
			else
				$op_log['remark'] = "�ӹ����̳�ת���ʽ�";
			
			$result=accountClass::AddLog($op_log);

			if ($result!=false){
				$op_result=1;
				$rs3['result']=1;
				$rs3['user_id']=$e_uc_user_id;
				$rs3['money']=$money;
				foreach($rs3 as $key => $value){
					$href .= "&{$key}={$value}";
				}
			}else{
				$op_result=0;
				$rs3['result']=0;
				$href .= "&result=0";
			}
		}
		else{
			$op_result=2;
			$rs3['result']=2;
			$href .= "&result=2";
		}


		$return_url = $href;


		$op_data['mall_op_id'] = $mall_op_id;
		$op_data['process_result'] = $op_result;
		$op_data['request_url'] = $request_url.json_encode($_REQUEST);
		$op_data['return_url'] = $return_url;


		$sql = "insert into  {mall_operate_log}  set `addtime` = '".time()."',`addip` = '".ip_address()."'";
		foreach($op_data as $key => $value){
			$sql .= ",`$key` = '$value'";
		}

		$result = $mysql->db_query($sql);

		echo json_encode($rs3);
		die();
	}
	//liukun add for bug 255 end

	//liukun add for bug 256 begin
	elseif ($_U['query_type'] == "i_awardl2m"){
		$point2account = isset($_G['system']['con_point2account'])?$_G['system']['con_point2account']:"2.52";
		$con_mall_key = isset($_G['system']['con_mall_key'])?$_G['system']['con_mall_key']:"1234567890";
		$href="location:".$_REQUEST['target']."?1=1";

		$op_result=0;
		$request_url = $_SERVER["REQUEST_URI"];
		$mall_op_id= $_REQUEST['op_id'];
		$mall_key = $_REQUEST['mall_key'];
		$money = $_REQUEST['money'];
		//��֤�Ƿ��ǺϷ�����
		$d_mall_op_id = DeCode($mall_key,'D',$con_mall_key);
		if ($d_mall_op_id!=$mall_op_id || $money < 0 || !is_numeric($money)){
			$rs2['result']=3;
			echo json_encode($rs2);
			die();
		}

		$sql = "select count(*) as op_num from  {mall_operate_log}  where mall_op_id='{$mall_op_id}'";
		$result = $mysql ->db_fetch_array($sql);

		$op_num = $result['op_num'];

		if ($op_num ==0){
			$op_money= round($money, 2);
			$e_uc_user_id = $_REQUEST['user_id'];
			$data['uc_user_id'] =  DeCode($e_uc_user_id,'D',$con_mall_key);
			$account_result = accountClass::GetOnebyUc($data);
			if(!is_array($account_result)){
				$rs2['result']=3;
				echo json_encode($rs2);
				die();
			}
			if ($account_result['award_interest'] < $op_money){
				$result = false;
			}else{
				fb($account_result, FirePHP::TRACE);
				$uc_user_id=$account_result['uc_user_id'];


				$user_id= $account_result['user_id'];
				$sql = "update  {account}  set ";
				$sql .= " award_interest = award_interest - {$op_money}";
				$sql .= " where user_id=$user_id";
				//liukun add for bug 174 end

				$mysql->db_query($sql);

				//����award��־


				//liukun add for bug 174 begin
				//��Ϣ��־
				$award_log['user_id'] = $user_id;
				$award_log['type'] = "i_awardl2m";
				$award_log['award'] = -$op_money;
				$award_log['remark'] = "���̳�ת����ֵ������׬��Ϣ";
				$sql = "insert into  {recharge_award_log}  set `addtime` = '".time()."',`addip` = '".ip_address()."'";
				foreach($award_log as $key => $value){
					$sql .= ",`$key` = '$value'";
				}
				$result = $mysql->db_query($sql);
			}
			if ($result!=false){
				$op_result=1;
				$rss['result']=1;
				$rss['user_id']=$e_uc_user_id;
				$rss['money']=$money;
				foreach($rss as $key => $value){
					$href .= "&{$key}={$value}";
				}
			}else{
				$op_result=0;
				$href .= "&result=0";
			}
		}
		else{
			$op_result=2;
			$href .= "&result=2";
		}


		$return_url = $href;


		$op_data['mall_op_id'] = $mall_op_id;
		$op_data['process_result'] = $op_result;
		$op_data['request_url'] = $request_url;
		$op_data['return_url'] = $return_url;


		$sql = "insert into  {mall_operate_log}  set `addtime` = '".time()."',`addip` = '".ip_address()."'";
		foreach($op_data as $key => $value){
			$sql .= ",`$key` = '$value'";
		}

		$result = $mysql->db_query($sql);

		header($href);
		die();

	}
	//liukun add for bug 256 end

	//�������
	elseif ($_U['query_type'] == "stock_manage"){
		if (isset($_POST['num']) && $_POST['num']>0){
			$data['user_id'] = $_G['user_id'];
			$data['optype'] = $_POST['optype'];
			$data['num'] = $_POST['num'];
			$data['remark'] = $_POST['remark'];

			$result =  accountClass::AddStockApply($data);//��ȡ��ǰ�û������
			if ($result!==true){
				$msg = $result;
			}else{
				$msg = array("����ɹ�����ȴ�����Ա���","","/index.php?user&q=code/account/stock_manage");
			}

			if ($result!==true){
				$msg = array($msg,"","/index.action?user");
			}
		}else{
			$data['user_id'] = $_G["user_id"];
			$account_result =  accountClass::GetOne($data);//��ȡ��ǰ�û������
			$_U['account_result'] = $account_result;
		}
	}
	elseif ($_U['query_type'] == "get_mall_info"){
		$user_id = $_G["user_id"];

		//��ȡ�̳ǵ��û���Ϣ
		$sql = "select * from  {user}  where user_id = '{$user_id}'";
		$result = $mysql->db_fetch_array($sql);
		if ($result!=false){
			$data['uc_user_id'] = $result['uc_user_id'];//����ܶ�
		}

		$data['malltype'] = "gx";
		$mallinfo = accountClass::GetMallInfobyUc($data);

		$_result['mallinfo'] = $mallinfo;

		$data['malltype'] = "jf";
		$jf_mallinfo = accountClass::GetMallInfobyUc($data);

		$_result['jf_mallinfo'] = $jf_mallinfo;

		echo json_encode($_result);
		exit;
	}
}

$template = "user_account.html.php";
?>
