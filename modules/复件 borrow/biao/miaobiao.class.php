<?php
/*
 * 	秒标业务逻辑类
发标处理 add
投标处理 tender
流标处理（含到期和主动撤消）cancel
审核处理 verify
还款处理 repay
逾期处理 overdue

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
	 * 发标
	 *
	 * @param Array $data
	 * @return Boolen
	 */
	function add($data = array()){
		global $mysql, $_G;
		
		
		$user_id = $data["user_id"];
		
		$userPermission = self::getUserPermission($user_id);
		
		if ($userPermission['is_restructuring'] == 1){
			$result = "你目前是债务重组中，只能发债务重组标。";
			return $result;
		}
		
		$addAudit = parent::checkAddBiaoAudit(array("user_id" => $user_id));
		if ($addAudit!==true){
			return $addAudit;
		}

		$account_result =  accountClass::GetOne(array("user_id"=>$data['user_id']));//获取当前用户的余额

		$freeze_fee = round($data['apr']*$data['account']/(100*12), 2) + self::getBorrowFee($borrow_result);;

		//（可用余额-限制提现总额）的差值大于等于此秒标所需要的利息和借款管理费用之和。
		if(($account_result['use_money'] - $account_result['nocash_money']) < $freeze_fee){
			$result = "可提现金额小于发标需冻结费用，不可以发秒标。";
			return $result;
		}

		//自动审核处理
		if (self::get_auto_verify() == 1){
			$data['status'] = 1;
			$data['verify_user'] = 1;
			$data['verify_remark'] = '自动审核';
			$data['verify_time'] = time();
		}

		$sql = "insert into  {borrow}  set `addtime` = '".time()."',`addip` = '".ip_address()."'";
		foreach($data as $key => $value){
			$sql .= ",`$key` = '$value'";
		}
		$result = $mysql->db_query($sql);

		if (!$result){
			$result = "发标失败。";
			return $result;
		}

		$newid = $mysql->db_insert_id();
		$_G['new_borrow_id'] = $newid;
		
		//秒标如果自动初审，那要冻节发标费用
		$log['user_id'] = $data['user_id'];
		$log['type'] = "borrow_fee_frost";
		$log['money'] = $freeze_fee;
		$log['total'] = $account_result['total'];
		$log['use_money'] =  $account_result['use_money']-$log['money'];
		$log['no_use_money'] =  $account_result['no_use_money']+$log['money'];
		$log['collection'] =  $account_result['collection'];
		$log['to_user'] = 0;
		$log['remark'] = "发布秒还标时冻结的费用";
		$result = accountClass::AddLog($log);//添加记录


		return $result;
	}

	/**
	 * 流标处理
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
		$account_log['remark'] = "解冻发布秒还标[<a href=\'/invest/a{$data['id']}.html\' target=_blank>{$data['name']}</a>]时冻结的费用";

		$result = accountClass::AddLog($account_log);
		return $result;
	}

	/**
	 * 发标审核审核
	 *
	 * @param Array $data
	 * @return Boolen
	 */
	function verify($data = array()){
		global $mysql;

		$result = true;
		//如查初审失败，退回发标费用
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
			$account_log['remark'] = "解冻发布秒还标[<a href=\'/invest/a{$data['id']}.html\' target=_blank>{$data['name']}</a>]时冻结的费用";

			$result = accountClass::AddLog($account_log);
		}


		return $result;
	}

	/**
	 * 满标审核
	 *
	 * @param Array $data
	 * @return Boolen
	 */
	function full_verify($data = array()){
		global $mysql;

		$borrow_result = $data;

		if($borrow_result['status'] == 3){
			$freeze_fee = round($data['apr']*$data['account']/(100*12), 2);

			$account_result =  accountClass::GetOne(array("user_id"=>$borrow_result['user_id']));//获取当前用户的余额
			$log['user_id'] = $borrow_result['user_id'];
			$log['type'] = "borrow_fee_frost_back";
			$log['money'] = $freeze_fee;
			$log['total'] = $account_result['total'];
			$log['use_money'] =  $account_result['use_money']+$log['money'];
			$log['no_use_money'] =  $account_result['no_use_money']-$log['money'];
			$log['collection'] =  $account_result['collection'];
			$log['to_user'] = 0;
			$log['remark'] = "解冻发布秒还标[<a href=\'/invest/a{$borrow_result['id']}.html\' target=_blank>{$borrow_result['name']}</a>]时冻结的费用";
			$result = accountClass::AddLog($log);//添加记录

			$sql="select p1.id from  {borrow_repayment}  as p1  where borrow_id = {$borrow_result['id']}";
			$result = $mysql->db_fetch_array($sql);

			$repay_data['id'] = $result['id'];
			$repay_data['user_id'] = $borrow_result['user_id'];
			//TODO repay里本身是一个完整的事务，这里的事务开始时，会造成前面的事务被提交，事务的完整性被打破了
			$result = borrowClass::Repay($repay_data);
		}
		else{
			//审核失败退回发标时冻结的费用费用，因为秒还标是自动审核成功的，一般不会走到这个分支，但因为现在审核是可以配置的，所以防止点击到审核不通过，转到下面的处理程序
			$account_result =  accountClass::GetOne(array("user_id"=>$borrow_result['user_id']));
			$account_log['user_id'] =$borrow_result['user_id'];
			$account_log['type'] = "borrow_fee_frost_back";

			$account_log['money'] = round($borrow_result['apr']*$data['account']/(100*12), 2);
			$account_log['total'] =$account_result['total'];
			$account_log['use_money'] = $account_result['use_money']+$account_log['money'];
			$account_log['no_use_money'] = $account_result['no_use_money']-$account_log['money'];
			$account_log['collection'] = $account_result['collection'];
			$account_log['to_user'] = "0";
			$account_log['remark'] = "解冻发布秒还标[<a href=\'/invest/a{$borrow_result['id']}.html\' target=_blank>{$borrow_result['name']}</a>]时冻结的费用";

			$result = accountClass::AddLog($account_log);

		}

		return $result;
	}
}
?>