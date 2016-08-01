<?php
/*
 * 	信用标业务逻辑类
发标处理 add
投标处理 tender
流标处理（含到期和主动撤消）cancel
审核处理 verify
还款处理 repay
逾期处理 overdue

*/

include_once(ROOT_PATH."modules/borrow/biao/biaotype.class.php");
include_once(ROOT_PATH."modules/borrow/borrow.class.php");
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

class creditbiaoClass extends biaotypeClass{
	protected $biao_type = "credit";
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

		$resultAmount = borrowClass::GetAmountOne($user_id,"credit");


		//发标金额大于可用信用额度
		if (($data['account'] > $resultAmount["account_use"])){
			$result = "可用信用额度不足。";
			return $result;
		}

		
		//自动审核处理
		$auto_verify = self::get_auto_verify();
		if ($auto_verify == 1){
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
		
		if(!$result){
			return $result;
		}
		
		$newid = $mysql->db_insert_id();
		$_G['new_borrow_id'] = $newid;
				
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

		$result = true;

		if ($data['status']==3){
			$amountlog_result = borrowClass::GetAmountOne($data['user_id'],"credit");
			$amountlog["user_id"] = $data['user_id'];
			$amountlog["type"] = "borrow_success";
			$amountlog["amount_type"] = "credit";
			$amountlog["account"] = $data['account'];
			$amountlog["account_all"] = $amountlog_result['account_all'];
			$amountlog["account_use"] = $amountlog_result['account_use'] - $amountlog['account'];
			$amountlog["account_nouse"] = $amountlog_result['account_nouse'] + $amountlog['account'];
			$amountlog["remark"] = "借款标满标审核通过，借款信用额度减少";
			$result = borrowClass::AddAmountLog($amountlog);
		}

		return $result;
	}


	/**
	 * 还款
	 *
	 * @param Array $data
	 * @return Boolen
	 */
	function repay($data = array()){
		global $mysql;

		$borrow_userid=$data["borrow_userid"];		

		$amountlog_result = borrowClass::GetAmountOne($borrow_userid,"credit");
		$amountlog["user_id"] = $borrow_userid;
		$amountlog["type"] = "borrrow_repay";
		$amountlog["amount_type"] = "credit";
		//TODO恢复信用额度的算法
		
// 		$amountlog["account"] = round(($data['borrow_account']/$data['time_limit']),2);
		$amountlog["account"] = $data['capital'];
		$amountlog["account_all"] = $amountlog_result['account_all'];
		$amountlog["account_use"] = $amountlog_result['account_use'] + $amountlog['account'];
		$amountlog["account_nouse"] = $amountlog_result['account_nouse'] - $amountlog['account'];
		$amountlog["remark"] = "成功还款，信用额度增加";

		$result = borrowClass::AddAmountLog($amountlog);

		return $result;
	}



}
?>