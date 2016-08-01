<?php
/*
 * 	���ҵ���߼���
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


//liukun add for bug 52 begin
$firePHPEnable=TRUE;
if ($firePHPEnable){
	require_once('modules/FirePHPCore/FirePHP.class.php');
	require_once('modules/FirePHPCore/fb.php');
	ob_start();

	$firephp = FirePHP::getInstance(true);
}
//liukun add for bug 52 end

class miaobiaoClass extends biaotypeClass{
	protected $biao_type = "miao";

	/**
	 * ����
	 *
	 * @param Array $data
	 * @return Boolen
	 */
	function add($data = array()){
		global $mysql, $_G;
		
		
		$user_id = $data["user_id"];
		
		$userPermission = self::getUserPermission($user_id);
		
		if ($userPermission['is_restructuring'] == 1){
			$result = "��Ŀǰ��ծ�������У�ֻ�ܷ�ծ������ꡣ";
			return $result;
		}
		
		$addAudit = parent::checkAddBiaoAudit(array("user_id" => $user_id));
		if ($addAudit!==true){
			return $addAudit;
		}

		$account_result =  accountClass::GetOne(array("user_id"=>$data['user_id']));//��ȡ��ǰ�û������

		$freeze_fee = round($data['apr']*$data['account']/(100*12), 2) + self::getBorrowFee($borrow_result);;

		//���������-���������ܶ�Ĳ�ֵ���ڵ��ڴ��������Ҫ����Ϣ�ͽ��������֮�͡�
		if(($account_result['use_money'] - $account_result['nocash_money']) < $freeze_fee){
			$result = "�����ֽ��С�ڷ����足����ã������Է���ꡣ";
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

		if (!$result){
			$result = "����ʧ�ܡ�";
			return $result;
		}

		$newid = $mysql->db_insert_id();
		$_G['new_borrow_id'] = $newid;
		
		//�������Զ�������Ҫ���ڷ������
		$log['user_id'] = $data['user_id'];
		$log['type'] = "borrow_fee_frost";
		$log['money'] = $freeze_fee;
		$log['total'] = $account_result['total'];
		$log['use_money'] =  $account_result['use_money']-$log['money'];
		$log['no_use_money'] =  $account_result['no_use_money']+$log['money'];
		$log['collection'] =  $account_result['collection'];
		$log['to_user'] = 0;
		$log['remark'] = "�����뻹��ʱ����ķ���";
		$result = accountClass::AddLog($log);//��Ӽ�¼


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
		$account_result =  accountClass::GetOne(array("user_id"=>$data['user_id']));
		$account_log['user_id'] =$data['user_id'];
		$account_log['type'] = "borrow_fee_frost_back";

		$account_log['money'] = round($data['apr']*$data['account']/(100*12), 2);
		$account_log['total'] =$account_result['total'];
		$account_log['use_money'] = $account_result['use_money']+$account_log['money'];
		$account_log['no_use_money'] = $account_result['no_use_money']-$account_log['money'];
		$account_log['collection'] = $account_result['collection'];
		$account_log['to_user'] = "0";
		$account_log['remark'] = "�ⶳ�����뻹��[<a href=\'/invest/a{$data['id']}.html\' target=_blank>{$data['name']}</a>]ʱ����ķ���";

		$result = accountClass::AddLog($account_log);
		return $result;
	}

	/**
	 * ����������
	 *
	 * @param Array $data
	 * @return Boolen
	 */
	function verify($data = array()){
		global $mysql;

		$result = true;
		//������ʧ�ܣ��˻ط������
		if($data['status'] == 2){
			$account_result =  accountClass::GetOne(array("user_id"=>$data['user_id']));
			$account_log['user_id'] =$data['user_id'];
			$account_log['type'] = "borrow_fee_frost_back";

			$account_log['money'] = round($data['apr']*$data['account']/(100*12), 2);
			$account_log['total'] =$account_result['total'];
			$account_log['use_money'] = $account_result['use_money']+$account_log['money'];
			$account_log['no_use_money'] = $account_result['no_use_money']-$account_log['money'];
			$account_log['collection'] = $account_result['collection'];
			$account_log['to_user'] = "0";
			$account_log['remark'] = "�ⶳ�����뻹��[<a href=\'/invest/a{$data['id']}.html\' target=_blank>{$data['name']}</a>]ʱ����ķ���";

			$result = accountClass::AddLog($account_log);
		}


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

		$borrow_result = $data;

		if($borrow_result['status'] == 3){
			$freeze_fee = round($data['apr']*$data['account']/(100*12), 2);

			$account_result =  accountClass::GetOne(array("user_id"=>$borrow_result['user_id']));//��ȡ��ǰ�û������
			$log['user_id'] = $borrow_result['user_id'];
			$log['type'] = "borrow_fee_frost_back";
			$log['money'] = $freeze_fee;
			$log['total'] = $account_result['total'];
			$log['use_money'] =  $account_result['use_money']+$log['money'];
			$log['no_use_money'] =  $account_result['no_use_money']-$log['money'];
			$log['collection'] =  $account_result['collection'];
			$log['to_user'] = 0;
			$log['remark'] = "�ⶳ�����뻹��[<a href=\'/invest/a{$borrow_result['id']}.html\' target=_blank>{$borrow_result['name']}</a>]ʱ����ķ���";
			$result = accountClass::AddLog($log);//��Ӽ�¼

			$sql="select p1.id from  {borrow_repayment}  as p1  where borrow_id = {$borrow_result['id']}";
			$result = $mysql->db_fetch_array($sql);

			$repay_data['id'] = $result['id'];
			$repay_data['user_id'] = $borrow_result['user_id'];
			//TODO repay�ﱾ����һ���������������������ʼʱ�������ǰ��������ύ������������Ա�������
			$result = borrowClass::Repay($repay_data);
		}
		else{
			//���ʧ���˻ط���ʱ����ķ��÷��ã���Ϊ�뻹�����Զ���˳ɹ��ģ�һ�㲻���ߵ������֧������Ϊ��������ǿ������õģ����Է�ֹ�������˲�ͨ����ת������Ĵ������
			$account_result =  accountClass::GetOne(array("user_id"=>$borrow_result['user_id']));
			$account_log['user_id'] =$borrow_result['user_id'];
			$account_log['type'] = "borrow_fee_frost_back";

			$account_log['money'] = round($borrow_result['apr']*$data['account']/(100*12), 2);
			$account_log['total'] =$account_result['total'];
			$account_log['use_money'] = $account_result['use_money']+$account_log['money'];
			$account_log['no_use_money'] = $account_result['no_use_money']-$account_log['money'];
			$account_log['collection'] = $account_result['collection'];
			$account_log['to_user'] = "0";
			$account_log['remark'] = "�ⶳ�����뻹��[<a href=\'/invest/a{$borrow_result['id']}.html\' target=_blank>{$borrow_result['name']}</a>]ʱ����ķ���";

			$result = accountClass::AddLog($account_log);

		}

		return $result;
	}
}
?>