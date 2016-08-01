<?php
/*
 * 	ծ�������ҵ���߼���
���괦�� add
Ͷ�괦�� tender
���괦�������ں�����������cancel
��˴��� verify
����� repay
���ڴ��� overdue

*/

include_once(ROOT_PATH."modules/borrow/biao/biaotype.class.php");
include_once(ROOT_PATH."modules/borrow/borrow.class.php");
include_once(ROOT_PATH."modules/account/account.class.php");
require_once(ROOT_PATH."modules/remind/remind.class.php");


//liukun add for bug 52 begin
$firePHPEnable=TRUE;
if ($firePHPEnable){
	require_once('modules/FirePHPCore/FirePHP.class.php');
	require_once('modules/FirePHPCore/fb.php');
	ob_start();

	$firephp = FirePHP::getInstance(true);
}
//liukun add for bug 52 end

class restructuringbiaoClass extends biaotypeClass{
	protected $biao_type = "restructuring";


	/**
	 * ����
	 *
	 * @param Array $data
	 * @return Boolen
	 */
	function add($data = array()){
		global $mysql, $_G;



		$borrow_vouch_result = borrowClass::GetAmountOne($data['user_id'],"restructuring");

		//��������ڿ��ý������
		if (($data['account'] > $borrow_vouch_result['account_use'])){
			$result = "ծ�������Ȳ��㡣";
			return $result;
		}


		//�Զ���˴���
		if (self::get_auto_verify() == 1){
			$data['status'] = 1;
			$data['verify_user'] = 1;
			$data['verify_remark'] = '�Զ����';
			$data['verify_time'] = time();
		}

		$sql = "insert into  {borrow}  set `addtime` = '".time()."',`addip` = '".ip_address()."'";
		foreach($data as $key => $value){
			$sql .= ",`$key` = '$value'";
		}
		$result = $mysql->db_query($sql);

		$newid = $mysql->db_insert_id();
		$_G['new_borrow_id'] = $newid;

		return $result;
	}

	/**
	 * ���괦��
	 *
	 * @param Array $data
	 * @return Boolen
	 */
	function cancel($data = array()){
		global $mysql;

		$result = true;
		$vouch_list_result = borrowClass::GetVouchList(array("limit"=>"all","borrow_id"=>$data['id']));
		if ($vouch_list_result!=""){
			foreach ($vouch_list_result as $key => $value){
				//��ͬ�ĵ�����ʽ ����ʽ��һ��
				if ($value['vouch_type'] == 'account'){
					$account_result =  accountClass::GetOne(array("user_id"=> $value['user_id']));
					$log['user_id'] =  $value['user_id'];
					$log['type'] = "tender_vouch_false";//
					$log['money'] = $value['vouch_collection'];
					$log['total'] = $account_result['total'];
					$log['use_money'] = $account_result['use_money']+$log['money'];
					$log['no_use_money'] = $account_result['no_use_money']-$log['money'];
					$log['collection'] = $account_result['collection'];
					$log['to_user'] = 0;
					$log['remark'] = "ծ������곷���������˶�����ö�ȷ�����";
					$result = accountClass::AddLog($log);
					if(!$result){
						return $result;
					}
				}
				else{
					//��Ӷ�ȼ�¼
					$amountlog_result = borrowClass::GetAmountOne($value['user_id'],"tender_vouch");
					$amountlog["user_id"] = $value['user_id'];
					$amountlog["type"] = "tender_vouch_false";
					$amountlog["amount_type"] = "tender_vouch";
					$amountlog["account"] = $value['vouch_collection'];
					$amountlog["account_all"] = $amountlog_result['account_all'];
					$amountlog["account_use"] = $amountlog_result['account_use'] + $amountlog['account'];
					$amountlog["account_nouse"] = $amountlog_result['account_nouse'] - $amountlog['account'];
					$amountlog["remark"] = "ծ������곷���������˵�����ȷ�����";
					$result = borrowClass::AddAmountLog($amountlog);
					if(!$result){
						return $result;
					}
				}

				$sql = "update  {borrow_vouch}  set status=2 where id = {$value['id']}";
				$result = $mysql->db_query($sql);

				if(!$result){
					return $result;
				}
			}
		}

		return $result;
	}

	/**
	 * ��������
	 *
	 * @param Array $data
	 * @return Boolen
	 */
	function vouch($data = array()){
		global $mysql, $_G;


		$result = true;
		$borrow_result = $data['borrow_result'];

		$borrow_id = $borrow_result['id'];

		$vouch_account = $data['money'];

		$vouch_userid = $_G['user_id'];

		//����ʵ�ʵĵ������
		if (($borrow_result['account']-$borrow_result['vouch_account'])<$vouch_account){
			$account_money = $borrow_result['account']-$borrow_result['vouch_account'];
		}else{
			$account_money = $vouch_account;
		}

		//���ݵ���������ʵ������Ľ�������ֻ�Ǳ��𣬻�����Ϣ

		$_data['account'] = $borrow_result['account'];
		$_data['year_apr'] = $borrow_result['apr'];
		$_data['month_times'] = $borrow_result['time_limit'];
		$_data['borrow_time'] = $borrow_result['success_time'];
		$_data['borrow_style'] = $borrow_result['style'];

		$_data['isday'] = $borrow_result['isday'];
		$_data['time_limit_day'] = $borrow_result['time_limit_day'];

		$interest_result = borrowClass::EqualInterest($_data);

		//����ȫ����Ϣ
		$repayment_total_account = 0;
		foreach ($interest_result as $key => $value){
			$repayment_total_account = $repayment_total_account+$value['repayment_account'];//�ܻ����
		}

		$vouch_need = round($repayment_total_account * $account_money / $borrow_result['account'], 2);


		if ($borrow_result['vouch_account']>=$borrow_result['account']){
			$msg = "��ծ������굣����������������ٵ���";
			return $msg;
		}

		//liukun add for bug 58 begin
		if (md5($data['paypassword'])!=$_G['user_result']['paypassword']){
			$msg = "֧���������벻��ȷ";
			return $msg;
		}
		//liukun add for bug 58 end

		//�ж��Ƿ��ǵ�����
		if ($borrow_result['vouch_user']!=""){
			$_vouch_user = explode("|",$borrow_result['vouch_user']);
			if (!in_array($_G['user_result']['username'],$_vouch_user)){
				$msg = "��ծ��������Ѿ�ָ���˵����ˣ��㲻�Ǵ˵����ˣ����ܽ��е���";
				return $msg;
			}
		}
			

		//liukun add for bug 108 begin
		$account_result =  accountClass::GetOne(array("user_id"=>$vouch_userid));//��ȡ��ǰ�û������
		//$uacc = borrowClass::GetUserLog(array('user_id'=>$_G['user_id']));
			
		// 		if ($uacc['total']<$account_money){
		// 			$msg = "�����˻��ܶ�С�����뵣�����ܽ����ܵ���";
		// 			return $msg;
		// 		}



		//��ȡͶ�ʵĵ������borrowClass::GetUserLog
		$vouch_amount =  borrowClass::GetAmountOne($vouch_userid,"tender_vouch");

		//��������Ͷ�ʵ�����ȺͿ����ֽ���
		if (($vouch_amount['account_use'] + ($account_result['use_money'] - $account_result['nocash_money'])) <$vouch_need){
			$msg = "���ĵ��������������֮�Ͳ������б��ε�����";
			return $msg;
		}
		//liukun add for bug 108 end

		//���ÿ�������
		if($account_result['use_money'] >=$vouch_need){
			$used_account = $vouch_need;
			$used_amount = 0;
		}
		else{
			$used_account = $account_result['use_money'];
			$used_amount = $vouch_need - $account_result['use_money'];
		}
		//liukun add for bug 52 begin
		fb($used_account, FirePHP::TRACE);
		fb($used_amount, FirePHP::TRACE);
		//liukun add for bug 52 end

		if ($used_account > 0){
				
			$vouch_account_percent = round($used_account / $repayment_total_account * $borrow_result['account'], 2);
				
			$vouch_data['borrow_id'] = $data['id'];
			$vouch_data['vouch_account'] = $vouch_account;
			$vouch_data['account'] = $vouch_account_percent;
			$vouch_data['user_id'] = $vouch_userid;
			$vouch_data['content'] = $data['content'];
			$vouch_data['status'] = 0;
			$vouch_data['vouch_type'] = "account";
			$vouch_data['vouch_collection'] = $used_account;



			$sql = "insert into  {borrow_vouch}  set `addtime` = '".time()."',`addip` = '".ip_address()."'";
			foreach($vouch_data as $key => $value){
				$sql .= ",`$key` = '$value'";
			}
			$result = $mysql->db_query($sql);
			if ($result != true){
				return $result;
			}
			$vouch_id = $mysql->db_insert_id();

			if ($vouch_id>0){


				//��Ӷ�ȼ�¼
				//���ݵ�������������Ҫ������ܽ���Ϊ������ֻ�ǵ��������ϢҲҪ����
					
				$account_result =  accountClass::GetOne(array("user_id"=>$vouch_userid));
				$log['user_id'] = $vouch_userid;
				$log['type'] = "tender_vouch_sucess";//
				$log['money'] = $used_account;
				$log['total'] = $account_result['total'];
				$log['use_money'] = $account_result['use_money']-$log['money'];
				$log['no_use_money'] = $account_result['no_use_money']+$log['money'];
				$log['collection'] = $account_result['collection'];
				$log['to_user'] = 0;
				$log['remark'] = "�����ɹ�����������";
				$result = accountClass::AddLog($log);
				if ($result != true){
					return $result;
				}
			}else{
				$msg = "����ʧ�ܡ�";
				return $msg;
			}

		}


		if ($used_amount > 0){

			$vouch_amount_percent = round($used_amount / $repayment_total_account * $borrow_result['account'], 2);
				
			$vouch_data['borrow_id'] = $data['id'];
			$vouch_data['vouch_account'] = $vouch_account;
			$vouch_data['account'] = $vouch_amount_percent;
			$vouch_data['user_id'] = $vouch_userid;
			$vouch_data['content'] = $data['content'];
			$vouch_data['status'] = 0;
			$vouch_data['vouch_type'] = "amount";
			$vouch_data['vouch_collection'] = $used_amount;



			$sql = "insert into  {borrow_vouch}  set `addtime` = '".time()."',`addip` = '".ip_address()."'";
			foreach($vouch_data as $key => $value){
				$sql .= ",`$key` = '$value'";
			}
			//liukun add for bug 52 begin
			fb($sql, FirePHP::TRACE);
			//liukun add for bug 52 end

			$result = $mysql->db_query($sql);
			if ($result != true){
				return $result;
			}
			$vouch_id = $mysql->db_insert_id();

			if ($vouch_id>0){


				//��Ӷ�ȼ�¼
				$amountlog_result = borrowClass::GetAmountOne($vouch_userid,"tender_vouch");
				$amountlog["user_id"] = $vouch_userid;
				$amountlog["type"] = "tender_vouch_sucess";
				$amountlog["amount_type"] = "tender_vouch";
				$amountlog["account"] = $used_amount;
				$amountlog["account_all"] = $amountlog_result['account_all'];
				$amountlog["account_use"] = $amountlog_result['account_use'] - $amountlog['account'];
				$amountlog["account_nouse"] = $amountlog_result['account_nouse'] + $amountlog['account'];
				$amountlog["remark"] = "�����ɹ����ᵣ�����";
				$result = borrowClass::AddAmountLog($amountlog);
				if ($result != true){
					return $result;
				}
			}else{
				$msg = "����ʧ�ܡ�";
				return $msg;
			}
		}

		$sql = "update  {borrow}  set vouch_account=vouch_account+{$account_money},vouch_times=vouch_times+1  where id='{$borrow_id}'";
		$result = $mysql->db_query($sql);//�����Ѿ�������Ǯ

		return $result;
	}

	/**
	 * �������
	 *
	 * @param Array $data
	 * @return Boolen
	 */
	function full_verify($data = array()){
		global $mysql;

		$result = true;
		$borrow_id = $data["id"];
		$vouch_award = $data['vouch_award'];
		$borrow_userid = $data['user_id'];
		$borrow_account = $data['account'];
		$interest_result = $data['interest_result'];


		$month_times = $data['time_limit'];

		$borrow_repayment_account = $data['repayment_account'];

		$vouch_list = borrowClass::GetVouchGroupList(array("limit"=>"all","borrow_id"=>$borrow_id));
		//liukun add for bug 52 begin
		fb($vouch_list, FirePHP::TRACE);
		//liukun add for bug 52 end
		if ($vouch_list==""){
			$msg = "��ȡ������¼ʧ�ܡ�";
			return $msg;
		}
		$borrow_url = "<a href=\'/invest/a{$data['id']}.html\' target=_blank>{$data['name']}</a>";
		if ($data['status'] == 3){
			//���ɹ��Ľ���֧����
			$account_result =  accountClass::GetOne(array("user_id"=>$borrow_userid));
			$vouch_log['user_id'] = $borrow_userid;
			$vouch_log['type'] = "vouch_awardpay";
			$vouch_log['money'] = round($vouch_award*$borrow_account/100,2);;
			$vouch_log['total'] = $account_result['total']-$vouch_log['money'];
			$vouch_log['use_money'] = $account_result['use_money']-$vouch_log['money'];
			$vouch_log['no_use_money'] = $account_result['no_use_money'];
			$vouch_log['collection'] = $account_result['collection'];
			$vouch_log['to_user'] = 0;
			$vouch_log['remark'] = "���������[{$borrow_url}]���ɹ��Ľ���֧��";
			$result = accountClass::AddLog($vouch_log);
			if($result !== true){
				return $result;
			}

			foreach ($vouch_list as $key => $value){
				$vouch_account = $value['account'];
				$vouch_userid = $value['user_id'];
				//�����ǻ��������ɵģ����Բ���Ҫ����Ϊÿ����������collection��Ϣ��ֻ����һ������
				// 				$vouch_id = $value['id'];
				$vouch_id = 0;

				$vouch_awa = round(($vouch_award*$value['account'])/100,2);
				$vouch_type = $value['vouch_type'];
				$sql = "update  {borrow_vouch}  set status=1,award_account={$vouch_awa} where user_id = {$vouch_userid} and borrow_id = {$borrow_id}";
				$result = $mysql -> db_query($sql);
				if ($result != true){
					return $result;
				}

				//���ɹ��Ľ���5%��
				$account_result =  accountClass::GetOne(array("user_id"=>$value['user_id']));
				$vouch_log['user_id'] = $value['user_id'];
				$vouch_log['type'] = "vouch_award";
				$vouch_log['money'] = $vouch_awa;
				$vouch_log['total'] = $account_result['total']+$vouch_log['money'];
				$vouch_log['use_money'] = $account_result['use_money']+$vouch_log['money'];
				$vouch_log['no_use_money'] = $account_result['no_use_money'];
				$vouch_log['collection'] = $account_result['collection'];
				$vouch_log['to_user'] = $borrow_userid;
				$vouch_log['remark'] = "���������[{$borrow_url}]���ɹ��Ľ���";
				$result = accountClass::AddLog($vouch_log);
				if ($result != true){
					return $result;
				}


				//������������ӵ�vouch_collection������ȥ
				//collection���Ǹ���vouch_collection�������
				//��Ϊ���ڲ�ֻ��ֻ�еȶϢ���������ծ�������Ķ�ȴ���ҲҪ���ݻ���ƻ�������


				$vouch_collection = $value['vouch_collection'];
				//��Ϊ���ʽ��һ�������廹����Ի�������������ֱ�ӵĽ�����ޣ��ǻ�����㷨���������
				$month_times = count($interest_result);
				$ed_vouch_collection = 0;
				for ($i=0;$i<$month_times;$i++){

					if ($i==$month_times-1){
						$_vouch_account = $vouch_collection - $ed_vouch_collection;
					}else{
						$_vouch_account = round($interest_result[$i]['repayment_account'] * $vouch_collection / $borrow_repayment_account,2);
						$ed_vouch_collection +=$_vouch_account;

					}
					//repair by weego 20120525 for ��껹��ʱ��
					if($isday==1){
						$repay_time=strtotime("$time_limit_day days",time());
					}else{
						$repay_time = get_times(array("time"=>time(),"num"=>$i+1));
					}
					// 2012-06-14 �޸Ļ���ʱ�� LiuYY
					$to_day = date("Y-m-d 23:59:59", $repay_time);
					$repay_time = strtotime($to_day);
					$sql = "insert into  {borrow_vouch_collection}  set borrow_id={$borrow_id},`addtime` = '".time()."',`addip` = '".ip_address()."',
					user_id=$vouch_userid ,`order` = {$i},vouch_id={$vouch_id},status=0,repay_account = '{$_vouch_account}',repay_time='{$repay_time}',
					vouch_type='{$vouch_type}'";
					$result = $mysql->db_query($sql);
					if ($result != true){
						return $result;
					}
				}
			}

			//liukun add for bug 179 begin
			if (1==2){
				$_borrow_account = round($borrow_account/$month_times,2);
				for ($i=0;$i<$month_times;$i++){
					if ($i==$month_times-1){
						$_borrow_account = $borrow_account - $_borrow_account*$i;
					}
					//repair by weego 20120525 for ��껹��ʱ��
					if($isday==1){
						$repay_time=strtotime("$time_limit_day days",time());
					}else{
						$repay_time = get_times(array("time"=>time(),"num"=>$i+1));
					}
					// 2012-06-14 �޸Ļ���ʱ�� LiuYY
					$to_day = date("Y-m-d 23:59:59", $repay_time);
					$repay_time = strtotime($to_day);
					$sql = "insert into  {borrow_vouch_repayment}  set borrow_id={$borrow_id},`addtime` = '".time()."',`addip` = '".ip_address()."',user_id=$borrow_userid ,`order` = {$i},status=0,repay_account = '{$_borrow_account}',repay_time='{$repay_time}'";
					$mysql->db_query($sql);
				}
			}
			//liukun add for bug 179 end


			//�۳�ծ��������
			$amountlog["user_id"] = $borrow_userid;
			$amountlog_result = borrowClass::GetAmountOne($borrow_userid, "restructuring");
			$amountlog["type"] = "restructuring_success";
			$amountlog["amount_type"] = "restructuring";
			$amountlog["remark"] = "ծ�����������ͨ����ȥծ��������";
			$amountlog["account"] = $borrow_account;
			$amountlog["account_all"] = $amountlog_result['account_all'];
			$amountlog["account_use"] = $amountlog_result['account_use'] - $amountlog['account'];
			//ծ�������Ȳ�������
			$amountlog["account_nouse"] = 0;

			//liukun add for bug 52 begin
			fb($amountlog, FirePHP::TRACE);
			//liukun add for bug 52 end
			$result = borrowClass::AddAmountLog($amountlog);
			if ($result != true){
				return $result;
			}
			//����ɹ��������û�is_restructuring״̬Ϊ1���Ժ��û���һֱ����ծ������״̬��ֱ������ծ����
				
			$sql = "update  {user}  set is_restructuring=1 where user_id = {$borrow_userid}";
			$result = $mysql->db_query($sql);
			if ($result != true){
				return $result;
			}
		}
		else {
			//liukun add for bug 101 begin
			foreach ($vouch_list as $key => $value){
				//��ͬ�ĵ�����ʽ ����ʽ��һ��
				if ($value['vouch_type'] == 'account'){
					$account_result =  accountClass::GetOne(array("user_id"=> $value['user_id']));
					$log['user_id'] =  $value['user_id'];
					$log['type'] = "tender_vouch_false";//
					$log['money'] = $value['vouch_collection'];
					$log['total'] = $account_result['total'];
					$log['use_money'] = $account_result['use_money']+$log['money'];
					$log['no_use_money'] = $account_result['no_use_money']-$log['money'];
					$log['collection'] = $account_result['collection'];
					$log['to_user'] = 0;
					$log['remark'] = "ծ���������Уʧ�ܣ������˶�����ö�ȷ�����";
					$result = accountClass::AddLog($log);
					if(!$result){
						return $result;
					}
				}
				else{
					//��Ӷ�ȼ�¼
					$amountlog_result = borrowClass::GetAmountOne($value['user_id'],"tender_vouch");
					$amountlog["user_id"] = $value['user_id'];
					$amountlog["type"] = "tender_vouch_false";
					$amountlog["amount_type"] = "tender_vouch";
					$amountlog["account"] = $value['vouch_collection'];
					$amountlog["account_all"] = $amountlog_result['account_all'];
					$amountlog["account_use"] = $amountlog_result['account_use'] + $amountlog['account'];
					$amountlog["account_nouse"] = $amountlog_result['account_nouse'] - $amountlog['account'];
					$amountlog["remark"] = "ծ���������Уʧ�ܣ������˵�����ȷ�����";
					$result = borrowClass::AddAmountLog($amountlog);
					if(!$result){
						return $result;
					}
				}
				$vouch_userid = $value['user_id'];
				$sql = "update  {borrow_vouch}  set status=2 where user_id = {$vouch_userid} and borrow_id = {$borrow_id}";
				$result = $mysql->db_query($sql);
				if ($result != true){
					return $result;
				}
			}
			//liukun add for bug 101 end

		}
		return $result;
	}

	/**
	 * ����
	 *
	 * @param Array $data
	 * @return Boolen
	 */
	function repay($data = array()){
		global $mysql;

		$result = true;
		$borrow_userid=$data["borrow_userid"];
		$borrow_id=$data["borrow_id"];
		$borrow_account=$data["borrow_account"];
		$repayment_account=$data["repayment_account"];
		$repayment_order = $data['order'];
		$now_time = time();



		$late_days = $data["late_result"]["late_days"];

		//������������������������ڵ渶�ˣ���ô����˻���󣬾�Ҫ��������Ϣ�ͱ�Ϣ����������
		//liukun add for bug 158 begin
		$late_voucher_interest = $data["late_result"]["late_voucher_interest"];

		$sql = "select p1.* from  {borrow_vouch_collection}  as p1 where p1.borrow_id='{$borrow_id}' and `order`={$repayment_order} ";

		$vouch_list = $mysql->db_fetch_arrays($sql);
		if ($vouch_list==""){
			$msg = "��ȡ������¼ʧ�ܡ�";
			return $msg;
		}
		foreach ($vouch_list as $key => $value){

			//�����˵渶�������������Ϣ����,�������������渶������վǿ�Ƶ渶��������������Ϣ����
			//
			if ($value['is_advance'] == 1 || $value['is_advance'] == 2){
				$advance_days = ceil(($now_time - $value['advance_time'])/(60*60*24));

				$account_result =  accountClass::GetOne(array("user_id"=>$value['user_id']));
				$account_log['user_id'] =$value['user_id'];
				$account_log['type'] = "late_collection";
				// 						$account_log['money'] = round($late_voucher_interest * $value['repay_account'] / $repayment_account / 100, 2);
				$account_log['money'] = round($late_voucher_interest * $value['repay_account'] / $repayment_account / $late_days * $advance_days, 2);
				$account_log['total'] = $account_result['total']+$account_log['money'];
				$account_log['use_money'] = $account_result['use_money']+$account_log['money'];
				$account_log['no_use_money'] = $account_result['no_use_money'];
				$account_log['collection'] =$account_result['collection'];
				$account_log['to_user'] = $borrow_userid;
				$account_log['remark'] = "�ͻ���[<a href=\'/invest/a{$data['borrow_id']}.html\' target=_blank>{$data['borrow_name']}</a>]����������Ϣ(ծȨ��)";
				$result = accountClass::AddLog($account_log);
				if ($result!==true){
					return $result;
				}

				//����Ϣ�����������
				$account_result =  accountClass::GetOne(array("user_id"=>$value['user_id']));
				$account_log['user_id'] =$value['user_id'];
				$account_log['type'] = "invest_repayment";
				$account_log['money'] = round($repayment_account * $value['repay_account'] / $repayment_account, 2);
				$account_log['total'] = $account_result['total']+$account_log['money'];
				$account_log['use_money'] = $account_result['use_money']+$account_log['money'];
				$account_log['no_use_money'] = $account_result['no_use_money'];
				$account_log['collection'] =$account_result['collection'];
				$account_log['to_user'] = $borrow_userid;
				$account_log['remark'] = "�ͻ���[<a href=\'/invest/a{$data['borrow_id']}.html\' target=_blank>{$data['borrow_name']}</a>]���Ļ���(ծȨ��)�����{$account_log['money']}Ԫ";
				$result = accountClass::AddLog($account_log);
				if ($result != true){
					return $result;
				}
			}
			elseif($value['is_advance'] == 0){
				//��û�е渶ǰ�����������ָ�
				if($value['vouch_type']=="amount"){
					$amountlog_result = borrowClass::GetAmountOne($value['user_id'],"tender_vouch");
					$amountlog["user_id"] = $value['user_id'];
					$amountlog["type"] = "tender_vouch_repay";
					$amountlog["amount_type"] = "tender_vouch";
					$amountlog["account"] = $value['repay_account'];
					$amountlog["account_all"] = $amountlog_result['account_all'];
					$amountlog["account_use"] = $amountlog_result['account_use'] + $amountlog['account'];
					$amountlog["account_nouse"] = $amountlog_result['account_nouse'] - $amountlog['account'];
					$amountlog["remark"] = "ծ������껹��ɹ���Ͷ�ʵ�����ȷ���";
					$result = borrowClass::AddAmountLog($amountlog);
					if ($result != true){
						return $result;
					}

				}
				else{
					$account_result =  accountClass::GetOne(array("user_id"=> $value['user_id']));
					$log['user_id'] =  $value['user_id'];
					$log['type'] = "tender_vouch_repay";//
					$log['money'] = $value['repay_account'];
					$log['total'] = $account_result['total'];
					$log['use_money'] = $account_result['use_money']+$log['money'];
					$log['no_use_money'] = $account_result['no_use_money']-$log['money'];
					$log['collection'] = $account_result['collection'];
					$log['to_user'] = 0;
					$log['remark'] = "ծ������껹��ɹ��������˿��ö�ȷ�����";
					$result = accountClass::AddLog($log);
					if(!$result){
						return $result;
					}

				}
				$sql = "update  {borrow_vouch_collection}  set repay_yestime = ".time().",repay_yesaccount = {$value['repay_account']},status=1 where id = {$value['id']}";
				$result = $mysql->db_query($sql);
				if ($result != true){
					return $result;
				}
			}

		}

		return $result;

	}

	/**
	 * ���ڴ���
	 *
	 * @param Array $data
	 * @return Boolen
	 */
	function late_repay($data = array()){
		global $mysql;

		$result = true;
		$borrow_id = $data['borrow_id'];
		$repayment_order = $data['order'];


		// 		$sql = "select * from  {borrow_vouch_collection}  where borrow_id=$borrow_id and `order`={$repayment_order} ";
		//��̨���ڿ۳���ʱ��ֻ�۳�û�������渶���ĵ����˵��˻�
		//borrow_vouch_collection is_advance = 0 ������û�������渶���ĲŻᱻ����
		$sql = "select * from  {borrow_vouch_collection}  where borrow_id=$borrow_id and `order`={$repayment_order} and is_advance = 0 ";

		$vouch_collection_list = $mysql->db_fetch_arrays($sql);
		if ($vouch_collection_list!=""){
			foreach ($vouch_collection_list as $key => $value){
				//ִ�е����˵渶����Ȼ��߾�ֵ��

				if($value['vouch_type']=="amount"){
					//������ö�Ƚ��е����ģ�Ҫֱ��ȥ�ۿ������
					//�ж��ٿɹ��渶�Ŀ������ͻָ����ٵ������
					$account_result =  accountClass::GetOne(array("user_id"=> $value['user_id']));
					$use_money = $account_result['use_money'];
					$need_money = $value['repay_account'];
					$should_advance_amount = ($use_money >= $need_money)?0:($need_money - $use_money);
					$can_unfrost_amount = $value['repay_account'] - $should_advance_amount;

					//��������Ե渶����Ҫ�۳���

					$log['user_id'] =  $value['user_id'];
					$log['type'] = "tender_vouch_advance";//
					$log['money'] = $need_money;
					$log['total'] = $account_result['total']-$log['money'];
					$log['use_money'] = $account_result['use_money']-$log['money'];
					$log['no_use_money'] = $account_result['no_use_money'];
					$log['collection'] = $account_result['collection'];
					$log['to_user'] = 0;
					$log['remark'] = "ծ����������ڣ������˿��ö�ȿ۳���";
						
					$result = accountClass::AddLog($log);
					if(!$result){
						return $result;
					}

					if ($should_advance_amount > 0){

						$amountlog_result = borrowClass::GetAmountOne($value['user_id'],"tender_vouch");
						$amountlog["user_id"] = $value['user_id'];
						$amountlog["type"] = "tender_vouch_advance";
						$amountlog["amount_type"] = "tender_vouch";
						$amountlog["account"] = $should_advance_amount;
						$amountlog["account_all"] = $amountlog_result['account_all']- $amountlog['account'];
						$amountlog["account_use"] = $amountlog_result['account_use'];
						$amountlog["account_nouse"] = $amountlog_result['account_nouse'] - $amountlog['account'];
						$amountlog["remark"] = "ծ����������ڣ�Ͷ�ʵ�����ȿ۳�";
						$result = borrowClass::AddAmountLog($amountlog);
						if ($result != true){
							return $result;
						}
					}
					if($can_unfrost_amount > 0){
						$amountlog_result = borrowClass::GetAmountOne($value['user_id'],"tender_vouch");
						$amountlog["user_id"] = $value['user_id'];
						$amountlog["type"] = "tender_vouch_repay";
						$amountlog["amount_type"] = "tender_vouch";
						$amountlog["account"] = $can_unfrost_amount;
						$amountlog["account_all"] = $amountlog_result['account_all'];
						$amountlog["account_use"] = $amountlog_result['account_use'] + $amountlog['account'];
						$amountlog["account_nouse"] = $amountlog_result['account_nouse'] - $amountlog['account'];
						$amountlog["remark"] = "ծ������껹��ɹ���Ͷ�ʵ�����ȷ���";
						$result = borrowClass::AddAmountLog($amountlog);
						if ($result != true){
							return $result;
						}
							
							
							
					}



				}
				else{
					$account_result =  accountClass::GetOne(array("user_id"=> $value['user_id']));
					$log['user_id'] =  $value['user_id'];
					$log['type'] = "tender_vouch_advance";//
					$log['money'] = $value['repay_account'];
					$log['total'] = $account_result['total']-$log['money'];
					$log['use_money'] = $account_result['use_money'];
					$log['no_use_money'] = $account_result['no_use_money']-$log['money'];
					$log['collection'] = $account_result['collection'];
					$log['to_user'] = 0;
					$log['remark'] = "ծ����������ڣ������˿��ö�ȿ۳���";
					$result = accountClass::AddLog($log);
					if(!$result){
						return $result;
					}

				}
				$sql = "update  {borrow_vouch_collection}  set advance_time = ".time().",repay_yesaccount = {$value['repay_account']},is_advance=2 where id = {$value['id']}";
				$result = $mysql->db_query($sql);
				if(!$result){
					return $result;
				}


			}
		}

		return $result;
	}

	/**
	 * ��ñ�ĸ�����Ϣ
	 *
	 * @param Array $data
	 * @return Boolen
	 */
	function getLateInterest($data = array()){
		global $mysql,$_G;
			
		$interest_result = parent::getLateInterest($data);
		$late_interest_rate = self::get_late_interest_rate();
		$repayment_account = $data['repayment_account'];
		$borrow_id = $data['borrow_id'];

		if ($interest_result["late_customer_interest"] > 0 && $late_interest_rate['late_customer_interest_rate'] > 0){
			$late_voucher_interest = $interest_result['late_interest'];
			$late_days = $interest_result['late_days'];

			$total_voucher_interest = 0;
			$sql = "select p1.* from  {borrow_vouch_collection}  as p1 where p1.borrow_id='{$borrow_id}' and is_advance !=0 ";

			$vouch_list = $mysql->db_fetch_arrays($sql);
			foreach ($vouch_list as $key => $value){

				//�����˵渶�������������Ϣ����,�������������渶������վǿ�Ƶ渶��������������Ϣ����
				//
				$advance_days = ceil((time() - $value['advance_time'])/(60*60*24));

				// 						$account_log['money'] = round($late_voucher_interest * $value['repay_account'] / $repayment_account / 100, 2);
				$voucher_interest = round($late_voucher_interest * $value['repay_account'] / $repayment_account / $late_days * $advance_days, 2);
				$total_voucher_interest +=$voucher_interest;
			}
			$interest_result["late_customer_interest"] = round(($interest_result['late_interest'] - $total_voucher_interest) / $late_interest_rate['late_interest_rate'] * $late_interest_rate['late_customer_interest_rate'], 2);
		}
		$interest_result["late_voucher_interest"] = $interest_result['late_interest'];;

		return $interest_result;
	}



}
?>