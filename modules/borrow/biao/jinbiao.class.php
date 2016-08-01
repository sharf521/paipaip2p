<?php
/*
 * 	净值标业务逻辑类
发标处理 add
投标处理 tender
流标处理（含到期和主动撤消）cancel
审核处理 verify
还款处理 repay
逾期处理 overdue

*/

include_once(ROOT_PATH."modules/borrow/biao/biaotype.class.php");
include_once(ROOT_PATH."modules/borrow/borrow.class.php");
include_once(ROOT_PATH."modules/borrow/amount.class.php");
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

class jinbiaoClass extends biaotypeClass{
	protected $biao_type = "jin";
	/**
	 * 发标
	 *
	 * @param Array $data
	 * @return Boolen
	 */
	function add($data = array()){
		global $mysql, $_G;
		$jin_formula = isset($_G['system']['con_jin_formula'])?$_G['system']['con_jin_formula']:0;
		$jin_formula_vouch = isset($_G['system']['con_jin_formula_vouch'])?$_G['system']['con_jin_formula_vouch']:0;

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
		
		
		$user_data['user_id'] = $data['user_id'];


		$jin_model = "jin_formula";
		//没有启用任何净值公式，不能发标
		if ($jin_formula==0 && $jin_formula_vouch ==0){
			$result = "当前净值无法计算，不能发标。";
			return $result;
		}

		//启用净值公式
		if ($jin_formula==1 && $jin_formula_vouch ==0){
			$jinAmount = accountClass::getJinAmount($user_data);
			$data['jin_model'] = "jin_formula";
		}

		//启用担保模式净值公式
		if ($jin_formula==0 && $jin_formula_vouch ==1){
			$jinAmount = accountClass::getJinAmountVouch($user_data);
			$data['jin_model'] = "jin_formula_vouch";
		}

		//启用两种净值公式，根据是否有担保额度选择净值计算公式
		if ($jin_formula==1 && $jin_formula_vouch ==1){
			$amount_result = amountClass::GetAmountOne($user_id, "tender_vouch");
			//有担保额度时使用担保模式净值公式
			if ($amount_result['account_all'] > 0){
				$jinAmount = accountClass::getJinAmountVouch($user_data);
				$data['jin_model'] = "jin_formula_vouch";
			}
			else{
				$jinAmount = accountClass::getJinAmount($user_data);
				$data['jin_model'] = "jin_formula";
			}
		}

		//发标金额大于可用信用额度
		if (($data['account'] > $jinAmount)){
			$result = "可用净资产不足。";
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
		
		


		//liukun add for bug 88 begin
		if ($result){
			$jinbiao_money = 0;
			//如果是用净值公式发的标，那要保存这个值，当这个值不为0时，不能申请担保额度2
			if($data['jin_model'] == "jin_formula"){
				$jinbiao_money = $data['account'];
			}
			$sql = " update {account} set nocash_money=nocash_money+'{$data['account']}',jinbiao_money = jinbiao_money + {$jinbiao_money} where user_id='{$data['user_id']}'";
			$result = $mysql ->db_query($sql);
		}
		//liukun add for bug 88 end
			
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

		//liukun add for bug 88 begin
		$jinbiao_money = 0;
		//如果是用净值公式发的标，那要保存这个值，当这个值不为0时，不能申请担保额度2
		if($data['jin_model'] == "jin_formula"){
			$jinbiao_money = $data['account'];
		}
		$sql = " update {account} set nocash_money=nocash_money-'{$data['account']}',jinbiao_money = jinbiao_money - {$jinbiao_money} where user_id='{$data['user_id']}'";
		$result = $mysql ->db_query($sql);

		//liukun add for bug 88 end
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
		
		//初审失败，相应不可提现额度扣除
		if($data['status'] == 2){
			$jinbiao_money = 0;
			//如果是用净值公式发的标，那要保存这个值，当这个值不为0时，不能申请担保额度2
			if($data['jin_model'] == "jin_formula"){
				$jinbiao_money = $data['account'];
			}
			$sql = " update {account} set nocash_money=nocash_money-'{$data['account']}', jinbiao_money = jinbiao_money - {$jinbiao_money} where user_id='{$data['user_id']}'";
			$result = $mysql ->db_query($sql);
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
		
		$result = true;
		//复审失败，相应不可提现额度扣除
		if($data['status'] == 4){
			$jinbiao_money = 0;
			//如果是用净值公式发的标，那要保存这个值，当这个值不为0时，不能申请担保额度2
			if($data['jin_model'] == "jin_formula"){
				$jinbiao_money = $data['account'];
			}
			$sql = " update {account} set nocash_money=nocash_money-'{$data['account']}', jinbiao_money = jinbiao_money - {$jinbiao_money} where user_id='{$data['user_id']}'";
			$result = $mysql ->db_query($sql);
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

		
		//如果是最后一期还款，要保证完全扣除掉与借款本金相当的非取现额度,只要分期超过1期才需要这样处理，所以当前还款序号为0时，不需要判断
		/*
			$capital = $borrow_repayment_result['capital'];
		if ($borrow_repayment_result['order'] > 0 &&  $borrow_repayment_result['order']+1 == $borrow_repayment_result['time_limit']){
		$sql = "select sum(capital) capital_yes from  {borrow_repayment}   where borrow_id={$borrow_repayment_result['borrow_id']} and `order` < {$borrow_repayment_result['order']}";
		$result = $mysql->db_fetch_arrays($sql);
		foreach ($result as $key => $value){
		$capital = $borrow_repayment_result['borrow_account'] - $value['capital_yes'];
		}
		}
		*/
		//TODO 恢复提现额度的算法
// 		$nocash_amount = round(($data['borrow_account']/$data['time_limit']),2);
		$nocash_amount = $data['capital'];
		$jinbiao_money = 0;
		//如果是用净值公式发的标，那要保存这个值，当这个值不为0时，不能申请担保额度2
		if($data['jin_model'] == "jin_formula"){
			$jinbiao_money = $data['capital'];
		}

		$sql = "update {account}  set nocash_money = nocash_money -  {$nocash_amount}, jinbiao_money = jinbiao_money - {$jinbiao_money} where user_id = {$borrow_userid}";
		$result = $mysql->db_query($sql);

		return $result;
	}





}
?>