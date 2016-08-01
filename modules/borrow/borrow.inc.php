<?php
if (!defined('ROOT_PATH'))  die('���ܷ���');//��ֱֹ�ӷ���
//include_once("borrow.class.php");
include_once(ROOT_PATH."modules/borrow/borrow.class.php");
require_once(ROOT_PATH."modules/borrow/biao/zhouzhuanbiao.class.php");
require_once(ROOT_PATH."modules/borrow/biao/creditbiao.class.php");
require_once(ROOT_PATH."modules/borrow/biao/jinbiao.class.php");
require_once(ROOT_PATH."modules/borrow/biao/fastbiao.class.php");
require_once(ROOT_PATH."modules/borrow/biao/miaobiao.class.php");
require_once(ROOT_PATH."modules/borrow/biao/vouchbiao.class.php");
require_once(ROOT_PATH."modules/borrow/biao/restructuringbiao.class.php");
require_once(ROOT_PATH."modules/borrow/biao/circulationbiao.class.php");
require_once(ROOT_PATH."modules/borrow/biao/pledgebiao.class.php");
require_once(ROOT_PATH."modules/borrow/biao/lovebiao.class.php");


//liukun add for bug 52 begin
$firePHPEnable=TRUE;
if ($firePHPEnable){
	require_once('modules/FirePHPCore/FirePHP.class.php');
	require_once('modules/FirePHPCore/fb.php');
	ob_start();

	$firephp = FirePHP::getInstance(true);
}
//liukun add for bug 52 end

if ($_U['query_type'] == "add" || $_U['query_type'] == "update"){
	//��֤�û��Ƿ��з����� add by weego 20120613
	$gourl="javascript:history.go(-1);";
	$result = borrowClass::GetOnes(array("user_id"=>$_G['user_id']));
	if (!isset($_POST['name']) || $_POST['name'] == ""){
		$msg = array("�����������Ϣ","",$gourl);
	}
	
	//liukun add for bug 58 begin
	elseif ($_POST['valicode']!=$_SESSION['valicode']){
		$msg = array("��֤�벻��ȷ","",$gourl);
	}
	//liukun add for bug 58 end
	
	//liukun add for bug 93 begin
	elseif (!$_POST['biao_type']){
		$msg = array("�������Ͳ���ȷ","","/borrow/index.html");
	}
	//liukun add for bug 93 end
	
	elseif($_POST['style']==1 && $_POST['time_limit']%3!=0){
		$msg = array("��ѡ����ǰ�����������������д3�ı���","",$gourl);
	}elseif($_POST['award']==1 && $_POST['part_account']<5){
		$msg = array("��ѡ����ǰ�����������д�������ֵ(���ܵ���5Ԫ)","",$gourl);
	}elseif($_POST['award']==2 && ($_POST['funds'] < 0.1 || $_POST['funds'] > 6)){
		$msg = array("��ѡ����ǰ���������������д��������ֵ( 0.1% ~ 6% )","","");
	}elseif(isset($_POST['isDXB']) && (!isset($_POST['pwd']) || $_POST['pwd'] == "" ) ){
		$msg = array("��ѡ���˶���꣬�����붨��������.","",$gourl);
	}else{
		
		$var = array("name","use","time_limit","style","account","apr","lowest_account","most_account","valid_time","award","part_account","funds","is_false","open_account","open_borrow","open_tender","open_credit","content","is_vouch","vouch_award","vouch_user","st");
		$data = post_var($var);
		if(isset($_POST['ismb'])){
			$data['time_limit'] = 1;
			$data['is_mb'] = intval($_POST['ismb']);
		}
		if(isset($_POST['isjin'])){
			$data['is_jin'] = intval($_POST['isjin']);
		}
		if(isset($_POST['isfast'])){
			$data['is_fast'] = intval($_POST['isfast']);
			//liukun add for bug 47 begin
			//$data['fastid'] = intval($_POST['fastid']);
			//liukun add for bug 47 end  
		}
		if(isset($_POST['is_vouch'])){
			$data['is_vouch'] = intval($_POST['is_vouch']);
		}
		//���� add by weego for ���  20120513
		if((int)$_POST['isday']==1){
			//liukun add for bug 324 begin
			$data['style'] = 0;
			//liukun add for bug 324 end
			$data['time_limit'] = 1;
			$data['time_limit_day'] = intval($_POST['time_limit_day']);
			$data['isday'] = intval($_POST['isday']);
		}

		//���� add by jackfeng for �������� 20120716
		if((int)$_POST['danbao']==1){
			$data['danbao'] = 1;
		}

		if((int)$_POST['is_nocash']==1){
			$data['is_nocash'] = 1;
		}
		
		/* alpha add for bug 24 ����վ����ת�� begin*/
		if((int)$_POST['is_restructuring']==1){
			$data['is_restructuring'] = 1;
		}
		/* alpha add for bug 24����վ����ת�� end*/

		/* alpha add for bug 8 begin*/
		if((int)$_POST['is_zhouzhuan']==1){
			$data['is_zhouzhuan'] = 1;
		}
		/* alpha add for bug 8 end*/

		/* alpha add for bug 59 begin*/
		if(isset($_POST['mortgage_model'])){
			$data['mortgage_model'] = $_POST['mortgage_model'];
		}
		/* alpha add for bug 59 end*/

		/* alpha add for bug 19 begin*/
		if(isset($_POST['is_circulation']))
		{
			$data['is_circulation'] = $_POST['is_circulation'];
			
			if($data['st']==0)
			{
				$data['begin_month_num'] = $_POST['begin_month_num'];
				$data['increase_month_num'] = $_POST['increase_month_num'];
				$data['increase_apr'] = $_POST['increase_apr'];	
			}
			else
			{			
				
				$data['begin_month_num']=$data['time_limit'];
				$data['increase_month_num'] =$data['time_limit'];
				$data['increase_apr'] = 0;
			}
			
			$data['unit_price'] = $_POST['unit_price'];
			$data['min_unit_num'] = $_POST['min_unit_num'];
			$data['max_unit_num'] = $_POST['max_unit_num'];
		}
		/* alpha add for bug 19 end*/
		
		
		$data['biao_type'] = $_POST['biao_type'];
		
		/* alpha add for bug 127 begin*/
		if((int)$_POST['is_love']==1){
			$data['is_love'] = 1;
		}
		/* alpha add for bug 127 end*/
		
		/* alpha add for bug 8 begin*/
		if((int)$_POST['is_pledge']==1){
			$data['is_pledge'] = 1;
		}
		/* alpha add for bug 8 end*/
		
		/* alpha add for bug 166 begin*/
		if((int)$_POST['ishappy']==1){
			$data['ishappy'] = 1;
		}
		/* alpha add for bug 166 end*/

		/* alpha add for bug 204 begin*/
		if((int)$_POST['isurgent']==1){
			$data['isurgent'] = 1;
		}
		/* alpha add for bug 204 end*/
		/* alpha add for bug 32 begin*/
		if((int)$_POST['isontop']==1){
			$data['isontop'] = 1;
		}
		/* alpha add for bug 32 end*/
		/* alpha add for bug 262 begin*/
		if(isset($_POST['areaid'])){
			$data['areaid'] = $_POST['areaid'];
		}
		/* alpha add for bug 262 end*/
		
		if($_POST['collection_limit'] > 0){
			$data['collection_limit'] = $_POST['collection_limit'];
		}
		if($_POST['ip_limit'] > 0){
			$data['ip_limit'] = $_POST['ip_limit'];
		}

		//����� ����
		if(isset($_POST['pwd'])){
			if(isset($_POST['pwd']) && $_POST['pwd'] != ""){
				$data['pwd'] = htmlspecialchars($_POST['pwd']);
			}
		}

		$data['open_account'] = 1;
		$data['open_borrow'] = 1;
		$data['open_credit'] = 1;
		if ($_POST['submit']=="����ݸ�"){
			$data['status'] = -1;
		}else{
			$data['status'] =0;
		}
		$data['user_id'] = $_G['user_id'];
		$data['insurance']=(int)$_POST['insurance'];

		if ($_U['query_type'] == "add"){
			$result = borrowClass::Add($data);
			
			if($result === true){
				//�Զ���˴���
				$classname = $data['biao_type']."biaoClass";
				$dynaBiaoClass = new $classname();
				$auto_verify = $dynaBiaoClass->get_auto_verify();
				if ($auto_verify == 1){
					$auto['id']=$_G['new_borrow_id'];
					$auto['user_id']=$data['user_id'];
					$auto['total_jie']=$data['account'];
					$auto['zuishao_jie']=$data['lowest_account'];
					borrowClass::auto_borrow($auto);
					unset($_G['new_borrow_id']);
				}
			}
					
		}else{
			$data['id'] = $_POST['id'];
			$data['user_id'] = $_G['user_id'];
			$result = borrowClass::Update($data);
		}
		if ($result===true){
			$msg = array("�������ɹ���","","/index.php?user&q=code/borrow/publish");
		}else{
			/*if($st==1)
				$msg = array($result,"","/publish/index.html?type={$data['biao_type']}");
			else
				$msg = array($result,"","/publish/index.html?type={$data['biao_type']}&st=1");*/
			$msg = array($result,"",$gourl);
		}

	}

}elseif ($_U['query_type'] == "cancel"){
	$data['id'] = $_REQUEST['id'];
	$data['user_id'] = $_G['user_id'];
	
	$result = borrowClass::Cancel($data);

	if ($result===true){
		$msg = array("�����ɹ�!","","index.php?user&q=code/borrow/publish");
	}else{
		$msg = array($result,"","index.php?user&q=code/borrow/publish");

	}
}

//ɾ��
elseif ($_U['query_type'] == "del"){
	$data['id'] = $_REQUEST['id'];
	$data['user_id'] = $_G['user_id'];
	$data['status'] = -1;
	$result = borrowClass::Delete($data);
	if ($result==false){
		$msg = array($result);
	}else{
		$msg = array("�б�ɾ���ɹ�!");
	}
}

//�û�Ͷ��
elseif ($_U['query_type'] == "tender"){
// 	if ($_SESSION['valicode']!=$_POST['valicode']){
// 		$msg = array("��֤�����");
	if(!isset($_POST['id'])){
		$msg = array("���������������");
	}else{
		$fp = fopen(ROOT_PATH."data/tender.txt" ,'w+');
		//@chmod(ROOT_PATH."data/tender.txt", 0777);
		if(flock($fp , LOCK_EX))
		{		
			include_once(ROOT_PATH."modules/account/account.class.php");
			$borrow_id = (int)$_POST['id'];
			$user_id = $_G['user_id'];
			//liukun add for bug 486 begin
			//������²���Ҫ����
			/*$sql = "update  {borrow}  set processing=1,current_userid={$user_id}  where id={$borrow_id} and processing = 0 and current_userid = -1 limit 1";
			$lock_result = $mysql->db_query($sql);		
			$borrow_process_lock = mysql_affected_rows();*/
			//liukun add for bug 486 end
			
			$borrow_result = borrowClass::GetOne(array("id"=>$_POST['id'],"tender_userid"=>$_G['user_id']));//��ȡ����ĵ�����Ϣ		
			$biaotype_info = borrowClass::get_biao_type_info(array("biao_type"=>$borrow_result['biao_type']));		
			$account_money = $_POST['money'];
			//���������
			$dxbPWD = $_POST['dxbPWD'];
			
			//liukun add for bug 151 begin
			//1.�������ʣ���Ͷ����
			$can_account = $borrow_result['account'] - $borrow_result['account_yes'];
			//2.�������Ͷ��ɣ��뱾�ͻ��ۼ�Ͷ����֮��Ĳ���
			$can_single_account = $borrow_result['most_account'] - $borrow_result['tender_yes'];
			//3.�жϸ�����СͶ����ʣ��Ͷ�꣬ȡ�����е�С��Ϊ��СͶ����
			$lowest_account = $borrow_result['lowest_account'];
			
			if($can_account < $lowest_account){
				$lowest_account = $can_account;
			}		
			if($can_single_account < $lowest_account){
				$lowest_account = $can_single_account;
			}		//���ʣ��Ͷ����С����СͶ��������ʾ����Ͷ������һ������ʱ��ʵ��Ͷ����ʣ����Ϊ׼��������Ͷ�������
			if ($account_money > $can_account){
				$account_money = $can_account;
			}
			//���Ͷ������ڸ��˻���Ͷ���ʵ��Ͷ����Ϊ���˻���Ͷ����
			if ($account_money > $can_single_account){
				$account_money = $can_single_account;
			}
			//liukun add for bug 151 end
			//if($lock_result!=true && $borrow_process_lock!=1){
			/*if($borrow_process_lock!=1){
				$msg = array("Ͷ������û�б����ܣ����Ժ����ԣ�");
			}
			else*/if($_G['user_id'] == $borrow_result['user_id']){
				$msg = array("�Լ�����Ͷ�Լ������ı꣡");
			}elseif ($_G['user_result']['islock']==1){
				$msg = array("���˺��Ѿ������������ܽ���Ͷ�꣬�������Ա��ϵ");
			}elseif (!is_array($borrow_result)){
				$msg = array($borrow_result);
			}elseif ($borrow_result['account_yes']>=$borrow_result['account']){
				$msg = array("�˱�������������Ͷ");
			}elseif ($borrow_result['verify_time'] == "" || $borrow_result['status'] != 1){
				$msg = array("�˱���δͨ�����");
			}
			//liukun add for bug ������ԶҲ�������㣬��Ϊ$borrow_result['valid_time']����Ч������ 
			//elseif ($borrow_result['verify_time'] + $borrow_result['valid_time']>time()){
			elseif (($borrow_result['verify_time'] + $borrow_result['valid_time'] * 3600 * 24) <time()){
				$msg = array("�˱��ѹ���");
			}
			elseif(!is_numeric($account_money)){
				$msg = array("��������ȷ�Ľ��");
			}
			//liukun add for bug 151 begin
			elseif($account_money < $lowest_account ){
				$msg = array("����Ͷ����{$account_money}����С����СͶ����{$lowest_account}");
			}
			elseif($can_single_account == 0 ){
				$msg = array("������Ͷ�����Ѿ������������{$borrow_result['most_account']}");
			}
			elseif($dxbPWD != $borrow_result['pwd']){
				$msg = array("������Ķ�������벻��ȷ�����򷢱���ȡ����ȷ������.");
			}
			//liukun add for bug 58 begin
			elseif (md5($_POST['paypassword'])!=$_G['user_result']['paypassword']){
				$msg = array("֧���������벻��ȷ");
			}
			//liukun add for bug 58 end
			else{
				$con_connect_ws = isset($_G['system']['con_connect_ws'])?$_G['system']['con_connect_ws']:"0";
				$account_result =  accountClass::GetOne(array("user_id"=>$_G['user_id']));//��ȡ��ǰ�û������
				//���ѡ����ɱ����Ϸѣ���Ͷ��ʱ��Ҫ�ж�
				if ($con_connect_ws=="1"){
					$insurance = $_POST['insurance'];
				}else{
					$insurance = 0;
				}
				$iptendNum = 0;
				if ($biaotype_info['tender_ip_limit_minutes'] > 0 && $biaotype_info['tender_ip_limit_nums'] > 0){
					$tender_ip_limit_minutes = $biaotype_info['tender_ip_limit_minutes'];

					$tender_ip_limit_time = time() - 60 * $tender_ip_limit_minutes;
					$sql = "Select count(*) as num From {borrow_tender}  where borrow_id={$borrow_id} and addip='".ip_address()."' and addtime > {$tender_ip_limit_time}";

					$tenderResult = $mysql->db_fetch_array($sql);
					$iptendNum=$tenderResult["num"];
				}
				if (($borrow_result['account']-$borrow_result['account_yes'])<$account_money){
					$account_money = $borrow_result['account']-$borrow_result['account_yes'];
				}
				if ($account_result['use_money']<($account_money + $insurance)){
					$msg = array("��������");
				}
				elseif ($account_result['collection'] < $biaotype_info['tender_collection_limit_amount'] && $biaotype_info['tender_collection_limit_amount'] > 0){
					$msg = array("���Ĵ��ս��С��Ͷ�����ơ���{$biaotype_info['tender_collection_limit_amount']}Ԫ��");
				}
				elseif ($biaotype_info['tender_ip_limit_nums'] > 0 && $iptendNum >= $biaotype_info['tender_ip_limit_nums']){
					$msg = array("�����ڵ�IPͶ���ܴ���������Ͷ�����ơ���{$biaotype_info['tender_ip_limit_nums']}�Σ�");
				}
				else{
					$data['borrow_id'] = $_POST['id'];
					$data['money'] = $_POST['money'];
					$data['account'] = $account_money;
					$data['user_id'] = $_G['user_id'];
					$data['status'] = 1;
					$data['insurance'] = $insurance;
					$result = borrowClass::AddTender($data);//��ӽ���				
					if ($result === true){
						
						if ($borrow_result['status'] ==1 && ($borrow_result['account_yes'] + $account_money) >= $borrow_result['account']){
							$classname = $borrow_result['biao_type']."biaoClass";
							$dynaBiaoClass = new $classname();
							$auto_full_verify_result = $dynaBiaoClass->get_auto_full_verify($borrow_result['biao_type']);		
							if ($auto_full_verify_result==1){
								$data_e['id'] = $_POST['id'];
								$data_e['status'] = '3';
								$data_e['repayment_remark'] = '�Զ�����';
								borrowClass::AddRepayment($data_e);
							}
						}					
					}
					else{
						$msg = array($result);
					}
				}
			}
			//liukun add for bug 486 begin
			//������󣬻ָ��������ٴδ����״̬
			/*$sql = "update  {borrow}  set processing=0,current_userid=-1  where id={$borrow_id} and processing = 1 and current_userid = $user_id limit 1";
			$mysql->db_query($sql);*/
			//liukun add for bug 486 begin	
			flock($fp,LOCK_UN);
		}
		fclose($fp);
	}
	if ($result !== true)
	{
		if(empty($msg[0])){	$msg[0]='Ͷ������û�б����ܣ����Ժ����ԣ�';	}
		if(!isset($_POST['id'])){
			$msg = array($msg[0],"","/invest/index.html");
		}
		else{
			$msg = array($msg[0],"","/invest/a{$borrow_result['id']}.html");
		}
	}else{
		$msg = array("Ͷ��ɹ�","","/index.php?user&q=code/borrow/bid");
	}
}

//liukun add for bug 19 begin
//�û�������ת��
elseif ($_U['query_type'] == "purchase"){
	if (1==2){
		// 	if ($_SESSION['valicode']!=$_POST['valicode']){
		$msg = array("��֤�����");
	}elseif (md5($_POST['paypassword'])!=$_G['user_result']['paypassword']){
		$borrow_id = $_POST['id'];
		$msg = array("֧���������벻��ȷ","","/invest/a{$borrow_id}.html");
	}else{
		include_once(ROOT_PATH."modules/account/account.class.php");
		$borrow_id = $_POST['id'];
		$circulation_id = $_POST['circulation_id'];
		$unit_num = $_POST['unit_num'];
		$buy_month_num = $_POST['buy_month_num'];
		$insurance = $_POST['insurance'];

		$borrow_result = borrowClass::GetOne(array("id"=>$borrow_id));//��ȡ����ĵ�����Ϣ
		$circulation_result = borrowClass::GetCirculationOne(array("id"=>$circulation_id));
		if($circulation_result['st'] != 0)
		{
			$buy_month_num = $circulation_result['begin_month_num'];
		}

		$current_time = time();
		$buyer_id = $_G['user_id'];
		$seller_id = $borrow_result['user_id'];

		//���׽����ڹ������ת�굥�ۼ۸�*����
		$unit_price = $circulation_result['unit_price'];

		$account_result =  accountClass::GetOne(array("user_id"=>$buyer_id));//��ȡ��ǰ�û������
		$use_money = $account_result["use_money"] - $insurance;
		$use_award = $account_result["use_award"];


		//�ֱ�����ֽ�ͽ����ɹ���������������ܻ�Ϲ���һ�ݣ�����һ��100�������ֽ�50, ����50
		//������ֽ�750������1000����������10�ݣ��Ǿ����ֽ���7�ݣ�������3��
		$max_money_buy_num = floor($use_money / $unit_price);
		$max_award_buy_num = floor($use_award / $unit_price);


		//Ϊ����û�����Ч�ʣ�����ʧ���ʣ�����û�����һ���ܴ�Ĺ������������Ŀǰ���ɹ�����Ϊʵ�ʹ������
		$valid_unit_num = $circulation_result['valid_unit_num'];
		// 		if ($unit_num > $valid_unit_num){
		// 			$unit_num = $valid_unit_num;
		// 		}
		$account_money = $unit_price * $unit_num;
		//���������

		//************************************************************
		// 		$sql = "Select count(*) as num From {borrow_tender}  where borrow_id={$_POST['id']} and user_id={$_G['user_id']}";

		// 		$tenderResult = $mysql->db_fetch_array($sql);
		// 		$tendNum=$tenderResult["num"];

		//************************************************************

		$sql = "select * from  {user}  where user_id={$buyer_id}";
		$userPermission = $mysql ->db_fetch_array($sql);

		//�ж���ת����Ч��
		$valid_month_num = $circulation_result['duration'] - floor((time() - $borrow_result['verify_time']) / 3600 / 24 / 30);

		//liukun add for bug 241 begin
		$sql = "select sum(unit_num)  as buyed_num, count(*) as tender_times from  {circulation_buy_serial}  where buyer_id={$buyer_id} and circulation_id = {$circulation_id} and buyback = 0";
		$buyed_num_result = $mysql ->db_fetch_array($sql);

		$buyed_num = $buyed_num_result['buyed_num'];

		//liukun add for bug 241 end

		//liukun add for bug 489 begin ��ת�깺��Ҳ�ܴ������ƣ�����û�ع��Ĵ���
		$classname = 'circulation'."biaoClass";
		$dynaBiaoClass = new $classname();
		$max_tender_times = $dynaBiaoClass->get_max_tender_times();



		//liukun add for bug 489 end

		//liukun add for bug 244 begin
		//1.�������ʣ���Ͷ����
		$can_unit_num = $valid_unit_num;
		//2.�������Ͷ��ɣ��뱾�ͻ��ۼ�Ͷ����֮��Ĳ���
		$can_single_unit_num = $circulation_result['max_unit_num'] - $buyed_num;
		//3.�жϸ�����СͶ����ʣ��Ͷ�꣬ȡ�����е�С��Ϊ��СͶ����
		$lowest_unit_num = $circulation_result['min_unit_num'];

		if($can_unit_num < $lowest_unit_num){
			$lowest_unit_num = $can_unit_num;
		}

		if($can_single_unit_num < $lowest_unit_num){
			$lowest_unit_num = $can_single_unit_num;
		}


		//���ʣ��Ͷ����С����СͶ��������ʾ����Ͷ������һ������ʱ��ʵ��Ͷ����ʣ����Ϊ׼��������Ͷ�������
		if ($unit_num > $can_unit_num){
			$unit_num = $can_unit_num;
		}
		//���Ͷ������ڸ��˻���Ͷ���ʵ��Ͷ����Ϊ���˻���Ͷ����
		if ($unit_num > $can_single_unit_num){
			$unit_num = $can_single_unit_num;
		}
		//liukun add for bug 244 end


		if($_G['user_id'] == $borrow_result['user_id']){
			$msg = array("�Լ�����Ͷ�Լ������ı꣡");
		}elseif ($_G['user_result']['islock']==1){
			$msg = array("���˺��Ѿ������������ܽ���Ͷ�꣬�������Ա��ϵ");
		}
		elseif(($max_money_buy_num + $max_award_buy_num)<$unit_num){
			$msg = array("��������");
		}
		elseif (!is_array($borrow_result)){
			$msg = array($borrow_result);
		}elseif($borrow_result['status']!=1){
			$msg = array("����ת��Ŀǰ�����Ϲ���");
		}elseif($valid_unit_num==0){
			$msg = array("û�п��Ϲ���ת�ꡣ");
		}
		// 		elseif($unit_num < $circulation_result['min_unit_num']){
		// 			$msg = array("����С����С�ɹ�����");
		// 		}
		// 		//liukun add for bug 241 begin
		// 		elseif(($unit_num + $buyed_num) > $circulation_result['max_unit_num']){
		// 			$msg = array("�ܹ���������ܴ������ɹ�����");
		// 		}
		//liukun add for bug 241 end

		//liukun add for bug 244 begin
		elseif($unit_num < $lowest_unit_num ){
			$msg = array("���Ĺ������{$unit_num}����С����С�������{$lowest_unit_num}");
		}
		elseif($can_single_unit_num == 0 ){
			$msg = array("�����ܹ�������Ѿ������������{$circulation_result['max_unit_num']}");
		}
		//liukun add for bug 244 end

		//liukun add for bug 187 begin
		elseif($userPermission['is_restructuring'] == 1){
			$msg = array("��Ŀǰ��ծ�������У����ܹ�����ת��");
		}
		//liukun add for bug 187 end
		elseif($valid_month_num < $buy_month_num){
			$msg = array("�������ޣ�{$buy_month_num}�£�������ת����Ч�ڣ�{$valid_month_num}�£�");
		}
		elseif ($buyed_num_result['tender_times'] >= $max_tender_times){
			$msg =  array("�Բ������Ѿ���������Ϲ�����(".$max_tender_times."��)��(��ǰδ�ع��Ϲ��ܴ�����)");
		}
		else{

			$money_buy_num = ($max_money_buy_num >= $unit_num)?$unit_num:$max_money_buy_num;
			$award_buy_num = ($max_money_buy_num >= $unit_num)?0:($unit_num - $max_money_buy_num);
			//liukun add for bug 472 begin
			$mysql->db_query("start transaction");
			//liukun add for bug 472 end
			$transaction_result = true;
			try{
				//��ý�����Ϣ
				$borrow_award = $borrow_result['award'];
				$borrow_funds = $borrow_result['funds'];
				//���ʽ 
				$borrow_style = $borrow_result['style'];
				 
				//������ת����ѹ������
				$circulation_id = $circulation_result['id'];
				$sell_num = $money_buy_num + $award_buy_num;
				$sql = "update  {circulation}  set `valid_unit_num` = valid_unit_num - {$sell_num}, `circulated_num` = `circulated_num` + $sell_num";
				$sql .= " where id=$circulation_id";

				$transaction_result = $mysql->db_query($sql);
				if ($transaction_result !==true){
					throw new Exception();
				}
				//����Ч���ʽ�ֱ�ӽ��н��ף���Ͷ�����˻��۳������������˻�

				//���ӷ����˵��ʽ�
				$account_result =  accountClass::GetOne(array("user_id"=>$seller_id));//��ȡ��ǰ�û������
				$log['user_id'] = $seller_id;
				$log['type'] = "sell_circulation";
				$log['money'] = $sell_num * $unit_price;
				$log['total'] = $account_result['total']+$log['money'];
				$log['use_money'] =  $account_result['use_money']+$log['money'];
				$log['no_use_money'] =  $account_result['no_use_money'];
				$log['collection'] =  $account_result['collection'];
				$log['to_user'] = $buyer_id;
				$log['remark'] = "�ɹ��۳���ת�����";
				$transaction_result = accountClass::AddLog($log);//��Ӽ�¼
				if ($transaction_result !==true){
					throw new Exception();
				}
				//д�빺���¼
				$borrow_url = "<a href=\'/invest/a{$borrow_result['id']}.html\' target=_blank>{$borrow_result['name']}</a>";
				$classname = $borrow_result['biao_type']."biaoClass";
				$dynaBiaoClass = new $classname();
				//��ȡ�����
				if($circulation_result['st'] != 0)//���Ǿ�����ת�Ļ� ��ȡ�����
				{
					$fee_rate = $dynaBiaoClass->get_borrow_fee_rate();
					$borrow_fee = round_money($sell_num * $unit_price * $fee_rate['borrow_fee_rate']*$buy_month_num, 2);
					if ($borrow_fee > 0){
	
						$account_result =  accountClass::GetOne(array("user_id"=>$seller_id));
						$fee_log['user_id'] = $seller_id;
						$fee_log['type'] = "borrow_fee";
						$fee_log['money'] = $borrow_fee;
						$fee_log['total'] = $account_result['total']-$fee_log['money'];
						$fee_log['use_money'] = $account_result['use_money']-$fee_log['money'];
						$fee_log['no_use_money'] = $account_result['no_use_money'];
						$fee_log['collection'] = $account_result['collection'];
						$fee_log['to_user'] = "0";
						$fee_log['remark'] = "���[{$borrow_url}]��������1";
	
						$transaction_result = accountClass::AddLog($fee_log);
						if ($transaction_result !==true){
							throw new Exception();
						};
					}
				}
				//���ᱣ֤��
				$circulation_data['frost_account']=0;
				$frost_rate = $dynaBiaoClass->get_frost_rate();
				if ($frost_rate > 0){
					$frost_account = round($sell_num * $unit_price * $frost_rate, 2);
					$account_result =  accountClass::GetOne(array("user_id"=>$seller_id));
					$margin_log['user_id'] = $seller_id;
					$margin_log['type'] = "margin";
					$margin_log['money'] =$frost_account;
					$margin_log['total'] = $account_result['total'];
					$margin_log['use_money'] = $account_result['use_money']-$margin_log['money'];
					$margin_log['no_use_money'] = $account_result['no_use_money']+$margin_log['money'];
					$margin_log['collection'] = $account_result['collection'];
					$margin_log['to_user'] = 0;
					$margin_log['remark'] = "��������[{$borrow_url}]�ı�֤��";
					$transaction_result = accountClass::AddLog($margin_log);
					if ($transaction_result !==true){
						throw new Exception();
					};
					//���±�֤��
					$sql = "update  {borrow}  set forst_account='{$margin_log['money']}' where id='{$id}'";
					$transaction_result = $mysql -> db_query($sql);
					if ($transaction_result !==true){
						throw new Exception();
					};
						
				}

				//֧��Ͷ�꽱��
				if ($borrow_award ==2){

					$award_money = round($sell_num * $unit_price * $borrow_funds /100, 2);
					//Ͷ�꽱���۳������ӡ�
					$account_result =  accountClass::GetOne(array("user_id"=>$seller_id));
					$log['user_id'] = $seller_id;
					$log['type'] = "award_lower";
					$log['money'] = $award_money;
					$log['total'] = $account_result['total']-$award_money;
					$log['use_money'] = $account_result['use_money']-$award_money;
					$log['no_use_money'] = $account_result['no_use_money'];
					$log['collection'] = $account_result['collection'];
					$log['to_user'] = 0;
					$log['remark'] = "�۳����[{$borrow_url}]�Ľ���";
					$transaction_result = accountClass::AddLog($log);
					if ($transaction_result !==true){
						throw new Exception();
					};
				}


				if($money_buy_num > 0){
					$circulation_data['circulation_id'] = $circulation_result['id'];
					$circulation_data['buyer_id'] = $buyer_id;
					$circulation_data['unit_num'] = $money_buy_num;
					$circulation_data['buytime'] = time();
					$circulation_data['auto_repurchase'] = $_POST['auto_repurchase'];
					$circulation_data['buy_month_num'] = $buy_month_num;
					$circulation_data['buyback'] = 0;
					//liukun add for bug 219 begin
					$circulation_data['begin_interest_time'] = strtotime(date("Y-m-d 23:59:59", $current_time));
					//�����Ϣ����ʱ��
					$circulation_data['end_interest_time'] = $circulation_data['begin_interest_time'] + 30 * 24 * 3600 * $circulation_data['buy_month_num'];
					//liukun add for bug 219 end

					// ��������û���ʵ��Ӧ������
					$buy_apr = $circulation_result['begin_apr'] + ($circulation_data['buy_month_num'] - $circulation_result['begin_month_num']) * $circulation_result['increase_apr'];
					$circulation_data['buy_apr'] = $buy_apr;
					$circulation_data['buy_type'] = "account";

					//���㱾��������ع�ʱӦ����Ϣ
					$circulation_data['capital'] = $circulation_data['unit_num'] * $unit_price;
					
					//���ݻ��ʽ�����»�Ϣ�ͻ�������
					if($borrow_style == 2){
						//����ȫ����ֻ��һ��
						$circulation_data['monthly_interest_repay'] = round($circulation_data['capital'] * $circulation_data['buy_apr'] * $circulation_data['buy_month_num'] / 12 / 100, 2);;
						$circulation_data['repay_month_num'] = 1;
						$circulation_data['interest'] = $circulation_data['monthly_interest_repay'];
					}else{
						//���¸�Ϣ�����ڻ���
						$circulation_data['monthly_interest_repay'] = round($circulation_data['capital'] * $circulation_data['buy_apr'] / 12 / 100, 2);
						$circulation_data['repay_month_num'] = $circulation_data['buy_month_num'];
						$circulation_data['interest'] = $circulation_data['monthly_interest_repay'] * $circulation_data['buy_month_num'];
					}
					
					$circulation_data['frost_account']=round($money_buy_num * $unit_price * $frost_rate, 2);
					

					
					$sql = "insert into  {circulation_buy_serial}  set `addtime` = '".time()."',`addip` = '".ip_address()."'";
					foreach($circulation_data as $key => $value){
						$sql .= ",`$key` = '$value'";
					}
					$transaction_result = $mysql->db_query($sql);
					if ($transaction_result !==true){
						throw new Exception();
					}
					//��ȥͶ���˵��ʽ�
					$account_result =  accountClass::GetOne(array("user_id"=>$buyer_id));//��ȡ��ǰ�û������
					$log['user_id'] = $buyer_id;
					$log['type'] = "purchase_circulation";
					$log['money'] = $circulation_data['capital'];
					$log['total'] = $account_result['total']-$log['money'];
					$log['use_money'] =  $account_result['use_money']-$log['money'];
					$log['no_use_money'] =  $account_result['no_use_money'];
					$log['collection'] =  $account_result['collection'];
					$log['to_user'] = $seller_id;
					$log['remark'] = "�ɹ�������ת�긶��";
					$transaction_result = accountClass::AddLog($log);//��Ӽ�¼
					if ($transaction_result !==true){
						throw new Exception();
					}

					//liukun add for bug 223 begin
					$account_result =  accountClass::GetOne(array("user_id"=>$buyer_id));//��ȡ��ǰ�û������
					$log['user_id'] = $buyer_id;
					$log['type'] = "purchase_circulation_collection";
					$log['money'] = $circulation_data['capital'] + $circulation_data['interest'];
					$log['total'] = $account_result['total']+$log['money'];
					$log['use_money'] =  $account_result['use_money'];
					$log['no_use_money'] =  $account_result['no_use_money'];
					$log['collection'] =  $account_result['collection']+$log['money'];
					$log['to_user'] = $seller_id;
					$log['remark'] = "�ɹ�������ת�����Ӵ���";
					$transaction_result = accountClass::AddLog($log);//��Ӽ�¼
					if ($transaction_result !==true){
						throw new Exception();
					}
					//liukun add for bug 223 end
						
					//�����˽���ѡ��󣬹���Ҫ��ý���
					if ($borrow_award ==2){
							
						$award_money = round($circulation_data['capital'] * $borrow_funds /100, 2);
						//Ͷ�꽱���۳������ӡ�
						$account_result =  accountClass::GetOne(array("user_id"=>$buyer_id));//��ȡ��ǰ�û������
						$log['user_id'] = $buyer_id;
						$log['type'] = "award_add";
						$log['money'] = $award_money;
						$log['total'] = $account_result['total']+$award_money;
						$log['use_money'] = $account_result['use_money']+$award_money;
						$log['no_use_money'] = $account_result['no_use_money'];
						$log['collection'] = $account_result['collection'];
						$log['to_user'] = $seller_id;
						$log['remark'] = "���[{$borrow_url}]�Ľ���";
						$transaction_result = accountClass::AddLog($log);
						if ($transaction_result !==true){
							throw new Exception();
						};
					}
						
				}
					
				if ($award_buy_num > 0){
					$circulation_data['circulation_id'] = $circulation_result['id'];
					$circulation_data['buyer_id'] = $_G['user_id'];
					$circulation_data['unit_num'] = $award_buy_num;
					$circulation_data['buytime'] = time();
					$circulation_data['auto_repurchase'] = $_POST['auto_repurchase'];
					$circulation_data['buy_month_num'] = $_POST['buy_month_num'];
					$circulation_data['buyback'] = 0;

					//liukun add for bug 219 begin
					$circulation_data['begin_interest_time'] = strtotime(date("Y-m-d 23:59:59", $current_time));
					//�����Ϣ����ʱ��
					$circulation_data['end_interest_time'] = $circulation_data['begin_interest_time'] + 30 * 24 * 3600 * $circulation_data['buy_month_num'];
					//liukun add for bug 219 end

					// ��������û���ʵ��Ӧ������
					$buy_apr = $circulation_result['begin_apr'] + ($circulation_data['buy_month_num'] - $circulation_result['begin_month_num']) * $circulation_result['increase_apr'];
					$circulation_data['buy_apr'] = $buy_apr;
					$circulation_data['buy_type'] = "award";

					//���㱾��������ع�ʱӦ����Ϣ
					$circulation_data['capital'] = $circulation_data['unit_num'] * $unit_price;
					
					//���ݻ��ʽ�����»�Ϣ�ͻ�������
					if($borrow_style == 2){
						//����ȫ����ֻ��һ��
						$circulation_data['monthly_interest_repay'] = round($circulation_data['capital'] * $circulation_data['buy_apr'] * $circulation_data['buy_month_num'] / 12 / 100, 2);;
						$circulation_data['repay_month_num'] = 1;
						$circulation_data['interest'] = $circulation_data['monthly_interest_repay'];
					}else{
						//���¸�Ϣ�����ڻ���
						$circulation_data['monthly_interest_repay'] = round($circulation_data['capital'] * $circulation_data['buy_apr'] / 12 / 100, 2);
						$circulation_data['repay_month_num'] = $circulation_data['buy_month_num'];
						$circulation_data['interest'] = $circulation_data['monthly_interest_repay'] * $circulation_data['buy_month_num'];
					}
					
					$circulation_data['frost_account']=round($award_buy_num * $unit_price * $frost_rate, 2);

					$sql = "insert into  {circulation_buy_serial}  set `addtime` = '".time()."',`addip` = '".ip_address()."'";
					foreach($circulation_data as $key => $value){
						$sql .= ",`$key` = '$value'";
					}
					$transaction_result = $mysql->db_query($sql);
					if ($transaction_result !==true){
						throw new Exception();
					}

					$need_award = $award_buy_num * $unit_price;
					$sql = "update  {account}  set `use_award` = `use_award` - {$need_award}";
					$sql .= " where user_id=$buyer_id";

					$transaction_result = $mysql->db_query($sql);
					if ($transaction_result !==true){
						throw new Exception();
					}
					//����award��־

					$award_log['user_id'] = $buyer_id;
					$award_log['type'] = "purchase_circulation";
					$award_log['award'] = -$need_award;
					$award_log['remark'] = "�ɹ�������ת�긶��";
					$sql = "insert into  {recharge_award_log}  set `addtime` = '".time()."',`addip` = '".ip_address()."'";
					foreach($award_log as $key => $value){
						$sql .= ",`$key` = '$value'";
					}
					$transaction_result = $mysql->db_query($sql);
					if ($transaction_result !==true){
						throw new Exception();
					}
						
					//�����˽���ѡ��󣬹���Ҫ��ý���
					if ($borrow_award ==2){
							
						$award_money = round($circulation_data['capital'] * $borrow_funds /100, 2);
						//Ͷ�꽱���۳������ӡ�
						$sql = "update  {account}  set `award_interest` = `award_interest` + {$award_money}";
						$sql .= " where user_id=$buyer_id";

						$transaction_result = $mysql->db_query($sql);
						if ($transaction_result !==true){
							throw new Exception();
						}
						//����award��־

						$award_log['user_id'] = $buyer_id;
						$award_log['type'] = "award_add";
						$award_log['award'] = $award_money;
						$award_log['remark'] = "�ɹ�������ת��õ�����";
						$sql = "insert into  {recharge_award_log}  set `addtime` = '".time()."',`addip` = '".ip_address()."'";
						foreach($award_log as $key => $value){
							$sql .= ",`$key` = '$value'";
						}
						$transaction_result = $mysql->db_query($sql);
						if ($transaction_result !==true){
							throw new Exception();
						}
					}
				}
				//�Ϲ���ת����ɱ����Ϸ�
				$ws_fl_rate = isset($_G['system']['con_ws_fl_rate'])?$_G['system']['con_ws_fl_rate']:0.16;
				$point2account = isset($_G['system']['con_point2account'])?$_G['system']['con_point2account']:2.52;
				$con_connect_ws = isset($_G['system']['con_connect_ws'])?$_G['system']['con_connect_ws']:"0";
				if ($insurance > 0){
					$account_result =  accountClass::GetOne(array("user_id"=>$buyer_id));//��ȡ��ǰ�û������
					$post_data=array();
					$post_data['ID']=$account_result['ws_user_id'];
					$post_data['Money']=round_money($insurance / $ws_fl_rate);
					$post_data['MoneyType']=1;
					$post_data['Count']=1;
					$ws_result = webService('C_Consume',$post_data);
					if ($ws_result >= 1){

						$q_data['user_id'] = $buyer_id;
						$q_data['ws_queue_id'] = $ws_result;
						$q_data['out_money'] = $insurance;
						$q_data['in_should_money'] = round_money($insurance / $ws_fl_rate);
							

						$sql = "insert into  {return_queue}  set `addtime` = '".time()."',`addip` = '".ip_address()."'";
						foreach($q_data as $key => $q_value){
							$sql .= ",`$key` = '$q_value'";
						}
						$transaction_result =  $mysql->db_query($sql);
						if ($transaction_result !==true){
							throw new Exception();
						};

						$ws_log['user_id']=$buyer_id;
						$ws_log['account']=$insurance;
						$ws_log['type']="insurance_fee";
						$ws_log['direction']="0";
						$ws_log['remark']="��webservice�ύͶ�ʱ�������Ϣ";
						$transaction_result = wsaccountClass::addWSlog($ws_log);
						if ($transaction_result !==true){
							throw new Exception();
						}
					}
					//�۳�Ͷ�ʱ����Ϸ�
					$account_result =  accountClass::GetOne(array("user_id"=>$buyer_id));
					$log['user_id'] = $buyer_id;
					$log['type'] = "insurance";
					$log['money'] = $insurance;
					$log['total'] = $account_result['total']-$log['money'];
					$log['use_money'] = $account_result['use_money']-$log['money'];
					$log['no_use_money'] = $account_result['no_use_money'];
					$log['collection'] = $account_result['collection'];
					$log['to_user'] = 0;
					$log['remark'] = "���ɱ����Ϸ�";
					$transaction_result = accountClass::AddLog($log);
					if ($transaction_result !==true){
						throw new Exception();
					};


				}

					
			}
			catch (Exception $e){
				//���뱣֤���в��ɽ��ܵĴ��󶼷����쳣����ִ���˻ع�
				$msg = array($transaction_result);
				$mysql->db_query("rollback");
			}
			//liukun add for bug 472 begin
			if($transaction_result===true){
				$mysql->db_query("commit");
			}else{
				$mysql->db_query("rollback");
			}

		}

		if ($transaction_result !== true){
			$msg = array($msg[0],"","/invest/a{$borrow_result['id']}.html");
		}
		else{
			$msg = array("�Ϲ��ɹ�","","/index.php?user&q=code/borrow/purchased");
		}
	}

}
//liukun add for bug 19 end

//liukun add for bug 19 begin
//�ع��û��Ϲ�����ת��
elseif ($_U['query_type'] == "buyback"){
	//if ($_SESSION['valicode']!=$_POST['valicode']){
	if(1==2){
		$msg = array("��֤�����");
	}else{
		include_once(ROOT_PATH."modules/account/account.class.php");
		$buy_id = $_POST['buy_id'];
		$buy_result = borrowClass::GetCirculationBuyDetail(array("id"=>$buy_id));
		//��ֹ�ظ��ύ
		if($buy_result['buyback']==0)
		{			
			$circulation_result = borrowClass::GetCirculationOne(array("id"=>$buy_result['circulation_id']));
			
			$borrow_result = borrowClass::GetOne(array("id"=>$circulation_result['borrow_id']));						        	//��ȡ����ĵ�����Ϣ	
			$current_time = time();	
			$buyer_id = $buy_result['buyer_id'];
			$seller_id = $borrow_result['user_id'];
	
			$auto_repurchase = $_POST['auto_repurchase'];
	
			$begin_interest_time = $buy_result['begin_interest_time'];
	
			//��Ϊ�к�̨�����Զ��ع������Բ�������û�����3�£��ع�ʱ�Ѿ����ڳ���1���µ����
			$can_interest_month = floor((time() - $begin_interest_time) / 3600 / 24 / 30);
			//��Ϊ��ʼ��Ϣʱ���ǵ�������23��59��59����������Ҫ����һ�£���Ȼ���������̻ع��������ֵ��-1��
			$can_interest_month = ($can_interest_month>=0)?$can_interest_month:0;
	
		}

		if ($_G['user_result']['islock']==1){
			$msg = array("���˺��Ѿ����������������Ա��ϵ");
		}
		elseif($buy_result['buyback']==1)
		{
			$msg = array("���ع��������ظ��ع���");
		}
		elseif($buyer_id!=$_G['user_id'])
		{
			$msg = array("�����ˣ������µ�½��");
		}
		elseif ($can_interest_month <= 0){
			$msg = array("��ת�깺�벻��һ�£����ܻع�");
		}		
		else{

			$circulation_id = $buy_result['circulation_id'];
			$unit_price = $circulation_result['unit_price'];
			$begin_apr= $circulation_result['begin_apr'];
			$unit_num = $buy_result['unit_num'];
			$buy_apr = $buy_result['buy_apr'];
			$buy_type = $buy_result['buy_type'];
			$begin_interest_time = $buy_result['begin_interest_time'];
			$end_interest_time = $buy_result['end_interest_time'];

			//����������Ϣ
			//liukun add for bug 163 begin
			//�û��Ϲ�ʱѡ��Ĺ�������������ع�ʱʱ�䲻�㹻����Ϣֻ���ʼ���ʵ�һ��
			$buy_month_num = $buy_result['buy_month_num'];
			if($can_interest_month < $buy_month_num){
				$buy_apr = $begin_apr / 2;
				// 				$interest = round($unit_num * $unit_price * $buy_apr / 12 / 100 * $can_interest_month, 2);
				$borrow_style = $borrow_result['style'];
				if($borrow_style == 3){
					$interest = round($unit_num * $unit_price * $buy_apr / 12 / 100 * $can_interest_month, 2) - ($buy_result['monthly_interest_repay'] * ($buy_result['buy_month_num'] - $buy_result['repay_month_num']));
				}else {
					$interest = round($unit_num * $unit_price * $buy_apr / 12 / 100 * $can_interest_month, 2);
				}
			}else{
				// 				$interest = $buy_result['interest'];
				$interest = $buy_result['monthly_interest_repay'] * $buy_result['repay_month_num'];

			}
			//liukun add for bug 163 end
			$account_money = $buy_result['capital'];


			$account_result =  accountClass::GetOne(array("user_id"=>$seller_id));//��ȡ�����˵����

			//liukun add for bug 240 begin
			/*
			 if ($account_result['use_money']<($account_money + $interest)){
			$msg = array("���������㣬�޷��ع���");
			*/
			//liukun add for bug 240 end
			if(1==2){
			}else{

				//����Ч���ʽ�ֱ�ӽ��н��ף�����Ͷ�����˻����۳��������˻�

				//�ж��Ƿ���Ҫ�Զ�����

				//�ж���ת����Ч��
				$valid_month_num = $circulation_result['duration'] - floor((time() - $borrow_result['verify_time']) / 3600 / 24 / 30);

				//����ֵ�������Ч��������ó�ֵ�����������ת�꣬�Ͳ������Զ������ˣ���ʹ�û����ù��Զ�����
				$sql = " SELECT count(*) as num FROM  {recharge_award_rule}  where begin_time < ".time()." and end_time > ".time();
				$rule_result = $mysql ->db_fetch_array($sql);

				$valid_award_rule = $rule_result['num'];


				//ֻ���������ڲ��п����Զ������� $can_interest_month == $buy_month_num
				//ֻ����ת����Ч�ڴ����Ϲ��ڲ�������
				//������ ���� �ý��������ҵ�ʱ�ǽ������
				//����Զ��ع���ֻ�ջ���Ϣ
				//liukun add for bug 52 begin

				//liukun add for bug 472 begin
				$mysql->db_query("start transaction");
				//liukun add for bug 472 end
				$transaction_result = true;
				try{
					//д�빺���¼
					$borrow_url = "<a href=\'/invest/a{$borrow_result['id']}.html\' target=_blank>{$borrow_result['name']}</a>";
					$classname = $borrow_result['biao_type']."biaoClass";
					$dynaBiaoClass = new $classname();
					//��ȡ�����
					$interest_fee_rate = $dynaBiaoClass->get_interest_fee_rate();
					//��ȡ�����
					$fee_rate = $dynaBiaoClass->get_borrow_fee_rate();
						
					//liukun add for bug 52 end
					if($auto_repurchase == 1 && ($valid_month_num >= $buy_month_num &&   $can_interest_month == $buy_month_num)
							&&(($buy_type == "award" && $valid_award_rule > 0) || $buy_type == "account")){
						if ($buy_type == "award"){
							//����Ͷ��õ�����Ϣ�������ã�ֻ���ۼƵ���Ϣ��
							//liukun add for bug 174 begin
							$sql = "update  {account}  set ";
							$sql .= " award_interest = award_interest + {$interest}";
							$sql .= " where user_id=$buyer_id";
							//liukun add for bug 174 end

							$transaction_result = $mysql->db_query($sql);
							if ($transaction_result !==true){
								throw new Exception();
							}
							//����award��־


							//liukun add for bug 174 begin
							//��Ϣ��־
							$award_log['user_id'] = $buyer_id;
							$award_log['type'] = "buyback_circulation_interest";
							$award_log['award'] = $interest;
							$award_log['remark'] = "�ɹ��ع���ת���տ��Ϣ��";
							$sql = "insert into  {recharge_award_log}  set `addtime` = '".time()."',`addip` = '".ip_address()."'";
							foreach($award_log as $key => $value){
								$sql .= ",`$key` = '$value'";
							}
							$transaction_result = $mysql->db_query($sql);
							if ($transaction_result !==true){
								throw new Exception();
							}
							//liukun add for bug 174 end
								
							//�۳���Ϣ�����
								
							//liukun add for bug 174 begin
							$interest_fee = round($interest * $interest_fee_rate, 2);
							$sql = "update  {account}  set  ";
							$sql .= " award_interest = award_interest - {$interest_fee}";
							$sql .= " where user_id=$buyer_id";
							//liukun add for bug 174 end
								
							$transaction_result = $mysql->db_query($sql);
							if ($transaction_result !==true){
								throw new Exception();
							};

							$award_log['user_id'] = $buyer_id;
							$award_log['type'] = "tender_mange";
							$award_log['award'] =  -$interest_fee;
							$award_log['remark'] = "�û��ɹ�����۳���Ϣ�Ĺ����";
							$sql = "insert into  {recharge_award_log}  set `addtime` = '".time()."',`addip` = '".ip_address()."'";
							foreach($award_log as $key => $value){
								$sql .= ",`$key` = '$value'";
							}
							$transaction_result = $mysql->db_query($sql);
							if ($transaction_result !==true){
								throw new Exception();
							};

						}
						else{
							//����Ч���ʽ�ֱ�ӽ��н��ף�����Ͷ�����˻����۳��������˻�
							$account_result =  accountClass::GetOne(array("user_id"=>$buyer_id));//��ȡ��ǰ�û������
							$log['user_id'] = $buyer_id;
							$log['type'] = "buyback_circulation";
							$log['money'] = $interest;
							$log['total'] = $account_result['total']+$log['money'];
							$log['use_money'] =  $account_result['use_money']+$log['money'];
							$log['no_use_money'] =  $account_result['no_use_money'];
							$log['collection'] =  $account_result['collection'];
							$log['to_user'] = $seller_id;
							$log['remark'] = "�ɹ��ع���ת���տ��Ϣ��";
							$transaction_result = accountClass::AddLog($log);//��Ӽ�¼
							if ($transaction_result !==true){
								throw new Exception();
							}
							//�Զ�����ʱ�����ղ��䣨��Ϊ�µ��Ϲ���¼�д��ձ������Ϣ�����ϴ��Ϲ���ͬ������ֻҪ���ӱ��λع��õ� ����Ϣ����
								
							//�۳���Ϣ�����
							$interest_fee = round($interest * $interest_fee_rate, 2);
							$account_result =  accountClass::GetOne(array("user_id"=>$buyer_id));
							$log['user_id'] = $buyer_id;
							$log['type'] = "tender_mange";//
							$log['money'] = $interest_fee;
							$log['total'] = $account_result['total']-$log['money'];
							$log['use_money'] = $account_result['use_money']-$log['money'];
							$log['no_use_money'] = $account_result['no_use_money'];
							$log['collection'] = $account_result['collection'];
							$log['to_user'] = 0;
							$log['remark'] = "�û��ɹ�����۳���Ϣ�Ĺ����";
							$transaction_result = accountClass::AddLog($log);
							if ($transaction_result !==true){
								throw new Exception();
							};
							
							//����ǰ��»�Ϣ��ģʽ����ô�����ɹ�Ҫ���Ӵ��գ�����ÿ��֧������Ϣ��
							$borrow_style = $borrow_result['style'];
							if($borrow_style == 3){
								//liukun add for bug 223 begin
								$account_result =  accountClass::GetOne(array("user_id"=>$buyer_id));//��ȡ��ǰ�û������
								$log['user_id'] = $buyer_id;
								$log['type'] = "purchase_circulation_collection";
								$log['money'] = $buy_result['monthly_interest_repay'] * ($buy_result['buy_month_num'] - 1);
								$log['total'] = $account_result['total']+$log['money'];
								$log['use_money'] =  $account_result['use_money'];
								$log['no_use_money'] =  $account_result['no_use_money'];
								$log['collection'] =  $account_result['collection']+$log['money'];
								$log['to_user'] = $seller_id;
								$log['remark'] = "�����ɹ���������ղ��";
								$transaction_result = accountClass::AddLog($log);//��Ӽ�¼
								if ($transaction_result !==true){
									throw new Exception();
								}
								//liukun add for bug 223 end
							}

						}
							
						//�����µ��Ϲ���¼
						$buy_data['circulation_id'] = $buy_result['circulation_id'];
						$buy_data['buyer_id'] = $buy_result['buyer_id'];
						$buy_data['unit_num'] = $buy_result['unit_num'];
						$buy_data['buytime'] = time();
						$buy_data['auto_repurchase'] = $buy_result['auto_repurchase'];
						$buy_data['buy_month_num'] = $buy_result['buy_month_num'];
						$buy_data['buyback'] = 0;
							
						//liukun add for bug 215 begin
						if ($buy_result['auto_repurchase'] == 1){
							$buy_data['begin_interest_time'] = $buy_result['end_interest_time'];
						}
						else{
							//liukun add for bug 219 begin
							$buy_data['begin_interest_time'] = strtotime(date("Y-m-d 23:59:59", $current_time));
							//liukun add for bug 219 end
						}
						//liukun add for bug 215 end
							
						//�����Ϣ����ʱ��
						$buy_data['end_interest_time'] = $buy_data['begin_interest_time'] + 30 * 24 * 3600 * $buy_data['buy_month_num'];
						$buy_data['buy_apr'] = $buy_result['buy_apr'];
						$buy_data['buy_type'] = $buy_result['buy_type'];
							
						//���㱾��������ع�ʱӦ����Ϣ
						$buy_data['capital'] = $buy_result['capital'];

						$borrow_style = $borrow_result['style'];
						$buy_data['monthly_interest_repay'] = $buy_result['monthly_interest_repay'];
						if($borrow_style == 2){
							//����ȫ����ֻ��һ��
							$buy_data['repay_month_num'] = 1;
							$buy_data['interest'] = $buy_data['monthly_interest_repay'];
						}else{
							//���¸�Ϣ�����ڻ���
							$buy_data['repay_month_num'] = $buy_result['buy_month_num'];
							$buy_data['interest'] = $buy_data['monthly_interest_repay'] * $buy_data['buy_month_num'];
						}
						
						$buy_data['frost_account'] = $buy_result['frost_account'];

							
						$sql = "insert into  {circulation_buy_serial}  set `addtime` = '".time()."',`addip` = '".ip_address()."'";
						foreach($buy_data as $key => $value){
							$sql .= ",`$key` = '$value'";
						}
						$transaction_result = $mysql->db_query($sql);
						if ($transaction_result !==true){
							throw new Exception();
						}
						//��������ת�������Զ���������Ҫ���ӿɹ������
						$sell_num = $unit_num;
						$sql = "update  {circulation}  set  `circulated_num` = `circulated_num` + $sell_num";
						$sql .= " where id=$circulation_id";
							
						$transaction_result = $mysql->db_query($sql);
						if ($transaction_result !==true){
							throw new Exception();
						}
						//�۳������˵��ʽ���Ϣ��
						$account_result =  accountClass::GetOne(array("user_id"=>$seller_id));//��ȡ��ǰ�û������
						//liukun add for bug 52 begin
							

						//liukun add for bug 52 end
						$log['user_id'] = $seller_id;
						$log['type'] = "accept_buyback_circulation";
						$log['money'] = $interest;
						$log['total'] = $account_result['total']-$log['money'];
						$log['use_money'] =  $account_result['use_money']-$log['money'];
						$log['no_use_money'] =  $account_result['no_use_money'];
						$log['collection'] =  $account_result['collection'];
						$log['to_user'] = $buyer_id;
						$log['remark'] = "�ɹ����ܻع���ת�����븶���Ϣ��";
						$transaction_result = accountClass::AddLog($log);//��Ӽ�¼
						if ($transaction_result !==true){
							throw new Exception();
						}

						if($circulation_result['st'] != 0)//���Ǿ�����ת�Ļ� ��ȡ�����
						{
							$borrow_fee = round_money($sell_num * $unit_price * $fee_rate['borrow_fee_rate'], 2);
							if ($borrow_fee > 0){
	
								$account_result =  accountClass::GetOne(array("user_id"=>$seller_id));
								$fee_log['user_id'] = $seller_id;
								$fee_log['type'] = "borrow_fee";
								$fee_log['money'] = $borrow_fee;
								$fee_log['total'] = $account_result['total']-$fee_log['money'];
								$fee_log['use_money'] = $account_result['use_money']-$fee_log['money'];
								$fee_log['no_use_money'] = $account_result['no_use_money'];
								$fee_log['collection'] = $account_result['collection'];
								$fee_log['to_user'] = "0";
								$fee_log['remark'] = "���[{$borrow_url}]��������4";
	
								$transaction_result = accountClass::AddLog($fee_log);
								if ($transaction_result !==true){
									throw new Exception();
								};
							}
						}
					}else{
						if ($buy_type == "award"){
							//����Ͷ��õ�����Ϣ�������ã�ֻ���ۼƵ���Ϣ��
							//liukun add for bug 174 begin
							$sql = "update  {account}  set `use_award` = `use_award` + {$account_money}";
							$sql .= ", award_interest = award_interest + {$interest}";
							$sql .= " where user_id=$buyer_id";
							//liukun add for bug 174 end

							$mysql->db_query($sql);

							//����award��־
							//Ͷ�ʱ�����־
							$award_log['user_id'] = $buyer_id;
							$award_log['type'] = "buyback_circulation";
							$award_log['award'] = $account_money;
							$award_log['remark'] = "�ɹ��ع���ת���տ����";
							$sql = "insert into  {recharge_award_log}  set `addtime` = '".time()."',`addip` = '".ip_address()."'";
							foreach($award_log as $key => $value){
								$sql .= ",`$key` = '$value'";
							}
							$transaction_result = $result = $mysql->db_query($sql);
							if ($transaction_result !==true){
								throw new Exception();
							}
							//liukun add for bug 174 begin
							//��Ϣ��־
							$award_log['user_id'] = $buyer_id;
							$award_log['type'] = "buyback_circulation_interest";
							$award_log['award'] = $interest;
							$award_log['remark'] = "�ɹ��ع���ת���տ��Ϣ��";
							$sql = "insert into  {recharge_award_log}  set `addtime` = '".time()."',`addip` = '".ip_address()."'";
							foreach($award_log as $key => $value){
								$sql .= ",`$key` = '$value'";
							}
							$transaction_result = $mysql->db_query($sql);
							if ($transaction_result !==true){
								throw new Exception();
							}
							//liukun add for bug 174 end
								
							//�۳���Ϣ�����
							if ($interest > 0){
								//liukun add for bug 174 begin
								$interest_fee = round($interest * $interest_fee_rate, 2);
							$sql = "update  {account}  set  ";
							$sql .= " award_interest = award_interest - {$interest_fee}";
							$sql .= " where user_id=$buyer_id";
							//liukun add for bug 174 end

							$transaction_result = $mysql->db_query($sql);
							if ($transaction_result !==true){
								throw new Exception();
							};
								
							$award_log['user_id'] = $buyer_id;
							$award_log['type'] = "tender_mange";
							$award_log['award'] =  -$interest_fee;
							$award_log['remark'] = "�û��ɹ�����۳���Ϣ�Ĺ����";
							$sql = "insert into  {recharge_award_log}  set `addtime` = '".time()."',`addip` = '".ip_address()."'";
							foreach($award_log as $key => $value){
								$sql .= ",`$key` = '$value'";
							}
							$transaction_result = $mysql->db_query($sql);
							if ($transaction_result !==true){
								throw new Exception();
							};
						}

					}
					else{
						
						//liukun add for bug 223 begin
						$account_result =  accountClass::GetOne(array("user_id"=>$buyer_id));//��ȡ��ǰ�û������
						$log['user_id'] = $buyer_id;
						$log['type'] = "buyback_circulation_collection";
						$log['money'] = $buy_result['capital'] + $buy_result['interest'];
						$log['total'] = $account_result['total']-$log['money'];
						$log['use_money'] =  $account_result['use_money'];
						$log['no_use_money'] =  $account_result['no_use_money'];
						$log['collection'] =  $account_result['collection']-$log['money'];
						$log['to_user'] = $seller_id;
						$log['remark'] = "�ɹ��ع���ת����ٴ���";
						$transaction_result = accountClass::AddLog($log);//��Ӽ�¼
						if ($transaction_result !==true){
							throw new Exception();
						}
						//liukun add for bug 223 end
						
						//����Ч���ʽ�ֱ�ӽ��н��ף�����Ͷ�����˻����۳��������˻�
						$account_result =  accountClass::GetOne(array("user_id"=>$buyer_id));//��ȡ��ǰ�û������
						$log['user_id'] = $buyer_id;
						$log['type'] = "buyback_circulation";
						$log['money'] = $account_money;
						$log['total'] = $account_result['total']+$log['money'];
						$log['use_money'] =  $account_result['use_money']+$log['money'];
						$log['no_use_money'] =  $account_result['no_use_money'];
						$log['collection'] =  $account_result['collection'];
						$log['to_user'] = $seller_id;
						$log['remark'] = "�ɹ��ع���ת���տ����";
						$transaction_result = accountClass::AddLog($log);//��Ӽ�¼
						if ($transaction_result !==true){
							throw new Exception();
						}
						
						
						if ($interest > 0){
							$account_result =  accountClass::GetOne(array("user_id"=>$buyer_id));//��ȡ��ǰ�û������
							$log['user_id'] = $buyer_id;
							$log['type'] = "buyback_circulation";
							$log['money'] = $interest;
							$log['total'] = $account_result['total']+$log['money'];
							$log['use_money'] =  $account_result['use_money']+$log['money'];
							$log['no_use_money'] =  $account_result['no_use_money'];
							$log['collection'] =  $account_result['collection'];
							$log['to_user'] = $seller_id;
							$log['remark'] = "�ɹ��ع���ת���տ��Ϣ��";
						}else{
							$account_result =  accountClass::GetOne(array("user_id"=>$buyer_id));//��ȡ��ǰ�û������
							$log['user_id'] = $buyer_id;
							$log['type'] = "early_buyback_circulation";
							$log['money'] = -$interest;
							$log['total'] = $account_result['total']-$log['money'];
							$log['use_money'] =  $account_result['use_money']-$log['money'];
							$log['no_use_money'] =  $account_result['no_use_money'];
							$log['collection'] =  $account_result['collection'];
							$log['to_user'] = $seller_id;
							$log['remark'] = "��ǰ�ع�����Ϣ��";
						}
						$transaction_result = accountClass::AddLog($log);//��Ӽ�¼
						if ($transaction_result !==true){
							throw new Exception();
						}

						if ($interest > 0){
							//�۳���Ϣ�����
							$interest_fee = round($interest * $interest_fee_rate, 2);
							$account_result =  accountClass::GetOne(array("user_id"=>$buyer_id));
							$log['user_id'] = $buyer_id;
							$log['type'] = "tender_mange";//
							$log['money'] = $interest_fee;
							$log['total'] = $account_result['total']-$log['money'];
							$log['use_money'] = $account_result['use_money']-$log['money'];
							$log['no_use_money'] = $account_result['no_use_money'];
							$log['collection'] = $account_result['collection'];
							$log['to_user'] = 0;
							$log['remark'] = "�û��ɹ�����۳���Ϣ�Ĺ����";
							$transaction_result = accountClass::AddLog($log);
							if ($transaction_result !==true){
								throw new Exception();
							};
						}
					}

					//������ת��Ŀɹ����������������ת�������Զ���������Ҫ���ӿɹ���������ֲ���
					$sell_num = $unit_num;
					$sql = "update  {circulation}  set `valid_unit_num` = `valid_unit_num` + $sell_num";
					$sql .= " where id=$circulation_id";

					$transaction_result = $mysql->db_query($sql);
					if ($transaction_result !==true){
						throw new Exception();
					}

					//�ⶳ��֤��
					if ($buy_result['frost_account'] > 0){
						$account_result =  accountClass::GetOne(array("user_id"=>$seller_id));
						$account_log['user_id'] =$seller_id;
						$account_log['type'] = "borrow_frost";
						$account_log['money'] = $buy_result['frost_account'];
						$account_log['total'] =$account_result['total'];
						$account_log['use_money'] = $account_result['use_money']+$account_log['money'];
						$account_log['no_use_money'] = $account_result['no_use_money']-$account_log['money'];
						$account_log['collection'] = $account_result['collection'];
						$account_log['to_user'] = "0";
						$account_log['remark'] = "��[{$borrow_url}]��֤��Ľⶳ";
						$transaction_result = accountClass::AddLog($account_log);
						if ($transaction_result !==true){
							throw new Exception();
						};
					}
					//�۳������˵��ʽ𣨱���+��Ϣ��
					$account_result =  accountClass::GetOne(array("user_id"=>$seller_id));//��ȡ��ǰ�û������
					$log['user_id'] = $seller_id;
					$log['type'] = "accept_buyback_circulation";
					$log['money'] = $account_money + $interest;
					$log['total'] = $account_result['total']-$log['money'];
					$log['use_money'] =  $account_result['use_money']-$log['money'];
					$log['no_use_money'] =  $account_result['no_use_money'];
					$log['collection'] =  $account_result['collection'];
					$log['to_user'] = $buyer_id;
					$log['remark'] = "�ɹ����ܻع���ת�����븶�����+��Ϣ��";
					$transaction_result = accountClass::AddLog($log);//��Ӽ�¼
					if ($transaction_result !==true){
						throw new Exception();
					}


				}
				//�����Ƿ���Ҫ�Զ��������϶����ջ�Ͷ����Ϣ

				//���ûع��ɹ����
				$sql = "update  {circulation_buy_serial}  set `buyback` = 1, `buyback_time` = '".time()."'";
				$sql .= " where id={$buy_id}";

				$transaction_result = $mysql->db_query($sql);
				if ($transaction_result !==true){
					throw new Exception();
				}

			}
			catch (Exception $e){
				$msg = array($transaction_result);
				//���뱣֤���в��ɽ��ܵĴ��󶼷����쳣����ִ���˻ع�
				$mysql->db_query("rollback");
			}
			//liukun add for bug 472 begin
			if($transaction_result===true){
				$mysql->db_query("commit");
			}else{
				$mysql->db_query("rollback");
			}
		}
	}
	if ($transaction_result !== true){
		$msg = array($msg[0],"","/index.php?user&q=code/borrow/purchased");
	}
	else{
		$msg = array("�ع��ɹ�","","/index.php?user&q=code/borrow/purchased");
	}
}

}
//liukun add for bug 19 end

//������Ͷ��
elseif ($_U['query_type'] == "vouch"){
	$msg = "";
	//if ($_SESSION['valicode']!=$_POST['valicode']){
	if(1==2){
		$msg = array("��֤�����");
	}
	elseif($_G['user_result']['use_money'] < 0)
	{
		$msg = array("�����˻����Ϊ���������ֵΪ�������ٵ�����");
	}
	elseif ($_G['user_result']['islock']==1){
		$msg = array("���˺��Ѿ������������ܽ��е������������Ա��ϵ");
	}
	else{

		$result = borrowClass::AddVouch($_POST);//array("borrow_id"=>$_POST['id'],"tender_userid"=>$_G['user_id']));//��ӵ�����

		if ($result===true){
			$msg = array("�����ɹ�","","/index.php?user&q=code/borrow/bid");
			//$_SESSION['valicode'] = "";
		}else{
			$msg = array($result);
		}
	}
	if ($result !== true){
		//$msg = array($msg[0],"","/invest/a{$_POST['id']}.html");
		$msg = array($msg[0],"","javascript:history.go(-1);");
		
	}
}


//�鿴Ͷ��
elseif ($_U['query_type'] == "repayment_view"){
	$data['id'] = $_REQUEST['id'];
	if ($data['id']==""){
		$msg = array("������������");
	}
	$data['user_id'] = $_G['user_id'];
	$result =  borrowClass::GetOne($data);//��ȡ��ǰ�û������
	if ($result==false){
		$msg = array("���Ĳ�������");
	}else{
		$_U['borrow_result'] = $result;
	}
}

//����
elseif ($_U['query_type'] == "repay"){
	$data['id'] = $_REQUEST['id'];
	if ($data['id']==""){
		$msg = array("������������");
	}
	$data['user_id'] = $_G['user_id'];
	$result =  borrowClass::Repay($data);//��ȡ��ǰ�û������
	if ($result!==true){
		$msg = array($result,"","/index.php?user&q=code/borrow/repaymentplan");
	}else{
		$msg = array("����ɹ�","","/index.php?user&q=code/borrow/repayment");
	}
}
//�������
elseif ($_U['query_type'] == "limitapp"){
	if (isset($_POST['account']) && $_POST['account']>0){
		$var = array("account","content","type","remark");
		$data = post_var($var);
		$data['user_id'] = $_G['user_id'];
		$result = borrowClass::GetAmountApplyOne(array("user_id"=>$data['user_id'],"type"=>$data['type']));
		$audit_result = borrowClass::getAmountAuditInfo(array("user_id"=>$data['user_id']));
		if ($result!=false && $result['verify_time']+60*60*24*30 >time()){
			$msg = "��һ���º�������";
		}elseif ($result!=false && $result['addtime']+60*60*24*30 >time() && $result['status']==2){
			$msg = "���Ѿ��ύ�����룬��ȴ����";
		}elseif($data['type'] == "tender_vouch" && $audit_result['result']==false){
			$msg = "����Ҫ���VIP���ֻ������š�ʵ������Ƶ������֤�ſ�����Ͷ�ʵ�����ȡ�";
		}
		else{
			$data['status'] = 2;
			
			
			
			$result =  borrowClass::AddAmountApply($data);//��ȡ��ǰ�û������
			if ($result!==true){
				$msg = $result;
			}else{
				$msg = array("�������ɹ�����ȴ�����Ա���","","/index.php?user&q=code/borrow/limitapp");
			}
		}
		
		if ($result!==true){
			$msg = array($msg,"","/index.action?user");
		} 
	}
}

//�����Զ�Ͷ��
elseif ($_U['query_type'] == "auto_add"){
	$_POST['user_id'] = $_G['user_id'];
	$_POST['addtime'] = time();
	$re = borrowClass::add_auto($_POST);
	if($re===false){
		$msg = array("���Ѿ������1���Զ�Ͷ�꣬���ֻ�����1����������ɾ�������޸�","","/index.php?user&q=code/borrow/auto");
	}else{
		$msg = array("�Զ�Ͷ�����óɹ�","","/index.php?user&q=code/borrow/auto");
	}
}

//�޸��Զ�Ͷ��
elseif ($_U['query_type'] == "auto_new"&&is_numeric($_GET['id'])){
	$result = borrowClass::GetAutoId($_GET['id']);
	$_U['auto_result'] = $result;
}

//ɾ���Զ�Ͷ��
elseif ($_U['query_type'] == "auto_del"&&is_numeric($_GET['id'])){
	$result = borrowClass::del_auto($_GET['id']);
	if($result) $msg = array("�Զ�Ͷ��ɾ���ɹ�","","/index.php?user&q=code/borrow/auto");
}

//liukun add for bug 21 begin
//����ծȨת��
elseif ($_U['query_type'] == "post_alienate"){
	$data['borrow_right_id'] = $_POST['borrow_right_id'];
	if(empty($_POST['price']) || empty($_POST['unit'])){
		$msg = array("��Ϣ������","","");
	}
	elseif (($_POST['price'] % $_POST['unit'])!=0){
		$msg = array("ת�ü۸������ת�õ�λ��������","","");
	}
	else{
		$data['price'] = $_POST['price'];
		$data['unit'] = $_POST['unit'];
		$result = borrowClass::AddAlienate($data);
		if($result===true){
			$msg = array("����ծȨת�óɹ�","","/index.php?user&q=code/borrow/alienate_myposted");
		}
		else {
			$msg = array($result);
		}
	}
	if($result!==true){
		$msg = array($msg[0],"","javascript:history.go(-1);");
	}
	
}
//liukun add for bug 21 end

//liukun add for bug 78 begin
//����ծȨ
elseif ($_U['query_type'] == "buy_alienate"){
	$data['right_alienate_id'] = $_POST['right_alienate_id'];
	$data['unit_num'] = abs((int)$_POST['unit_num']);
	$result = borrowClass::BuyAlienate($data);
	if($result===true){ 
		$msg = array("ծȨ����ɹ�","","/index.php?user&q=code/borrow/alienate_buy_list");
	}else{
		//$msg = array($result,"","/index.php?user&q=code/borrow/alienate_market");
		$msg = array($result,"","javascript:history.go(-1);");
	}
}
//liukun add for bug 78 end

//liukun add for bug 81 begin
//����ծȨ
elseif ($_U['query_type'] == "cancel_alienate"){
	$data['right_alienate_id'] = $_GET['right_alienate_id'];
	$result = borrowClass::CancelAlienate($data);
	if($result===true){
		$msg = array("ծȨת�ñ곷���ɹ�","","/index.php?user&q=code/borrow/alienate");
	}
	else {
		$msg = array($result,"","");
	}
}
//liukun add for bug 81 end


elseif ($_U['query_type'] == "buybackconfirm"){
	$data['buy_id'] = $_GET['buy_id'];
	$result = borrowClass::GetBuybackInfo($data);
	if($result['st']>0)
	{
		$msg = array("error���ܻع���","","?user&q=code/borrow/purchased");	
	}
	else
	{
		$_U['buyback_info'] = $result;
	}
}
//liukun add for bug 471 begin
elseif ($_U['query_type'] == "testbreak"){
	//�������䶼���ص�ʱ�򣬿ͻ���һ���жϣ�����ִֹͣ��
	ignore_user_abort(true);//ֻ������ִ�е���ʱ��
	set_time_limit(0);//��һֱִ��ֱ�ӵ�����������Զ������
	$result = borrowClass::Testbreak($data);
}
//liukun add for bug 471 end
elseif ($_U['query_type'] == "testshiwu"){
	exit;
		global $mysql;
		//
		$mysql->db_query("start transaction");
		$sql = "insert into  {test}  set `addtime` = '".time()."', comment='test'";
		foreach($data as $key => $value){
			$sql .= ",`$key` = '$value'";
		}
		$i=1;
		while($i<100){
		$result = $mysql->db_query($sql);
		$i++;
		}
		$mysql->db_query("rollback");
		//ʹ������ʱ�ܻع���ǰ�����ݿ����
		
		//��ʹ�������ʱ��ִ�е�������ݿ�����ж�ִ��ʱ��״̬
		$sql = "insert into  {test}  set `addtime` = '".time()."', comment='test1'";
		foreach($data as $key => $value){
			$sql .= ",`$key` = '$value'";
		}
		$i=101;
		while($i<200){
			$result = $mysql->db_query($sql);
			$i++;
		}
		return $result;
}
elseif ($_U['query_type'] == "testbreakshiwu"){
	exit;
	//���Խ��������û��жϣ����񲻻��ύ��Ҳ���Ǻ�ִ��ǰ״̬һ��
	global $mysql;

	$mysql->db_query("start transaction");
	$sql = "insert into  {test}  set `addtime` = '".time()."', comment='test'";
	foreach($data as $key => $value){
		$sql .= ",`$key` = '$value'";
	}
	while(true){
		$result = $mysql->db_query($sql);
	}
	$mysql->db_query("commit");

	return $result;
}

elseif ($_U['query_type'] == "voucher_advance"){
	$data['id'] = $_REQUEST['id'];
	$data['user_id'] = $_G['user_id'];

	$result = borrowClass::voucherAdvance($data);

	if ($result===true){
		$msg = array("�渶�ɹ�!","","/index.php?user&q=code/borrow/tender_vouch_finish&status=0");
	}else{
		$msg = array($result,"","/index.php?user&q=code/borrow/tender_vouch_finish&status=0");

	}
}

else{
		
}

$template = "user_borrow.html.php";
if($_U['query_type'] == "auto"||$_U['query_type'] == "auto_new")  $template = "auto_user_borrow.html.php";
?>
