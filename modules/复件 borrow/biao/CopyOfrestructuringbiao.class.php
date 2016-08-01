<?php
/*
 * 	债务重组标业务逻辑类
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
	 * 发标
	 *
	 * @param Array $data
	 * @return Boolen
	 */
	function add($data = array()){
		global $mysql;



		$borrow_vouch_result = borrowClass::GetAmountOne($data['user_id'],"restructuring");

		//发标金额大于可用借款担保额度
		if (($data['account'] > $borrow_vouch_result['account_use'])){
			$result = "债务重组额度不足。";
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
		$vouch_list_result = borrowClass::GetVouchList(array("limit"=>"all","borrow_id"=>$data['id']));
		if ($vouch_list_result!=""){
			foreach ($vouch_list_result as $key => $value){
				//添加额度记录
				$amountlog_result = borrowClass::GetAmountOne($value['user_id'],"tender_vouch");
				$amountlog["user_id"] = $value['user_id'];
				$amountlog["type"] = "tender_vouch_false";
				$amountlog["amount_type"] = "tender_vouch";
				$amountlog["account"] = $value['vouch_collection'];
				$amountlog["account_all"] = $amountlog_result['account_all'];
				$amountlog["account_use"] = $amountlog_result['account_use'] + $amountlog['account'];
				$amountlog["account_nouse"] = $amountlog_result['account_nouse'] - $amountlog['account'];
				$amountlog["remark"] = "担保标撤销，担保人担保额度返还";
				$result = borrowClass::AddAmountLog($amountlog);
				if(!$result){
					return $result;
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
	 * 担保处理
	 *
	 * @param Array $data
	 * @return Boolen
	 */
	function vouch($data = array()){
		global $mysql, $_G;

		$borrow_result = $data['borrow_result'];
		
		$borrow_id = $borrow_result['id'];
		
		$vouch_account = $data['money'];

		$vouch_userid = $_G['user_id'];
			
		if (($borrow_result['account']-$borrow_result['vouch_account'])<$vouch_account){
			$account_money = $borrow_result['account']-$borrow_result['vouch_account'];
		}else{
			$account_money = $vouch_account;
		}

		//根据担保金额计算实际所需的金额，担保不只是本金，还有利息
		
		$_data['account'] = $borrow_result['account'];
		$_data['year_apr'] = $borrow_result['apr'];
		$_data['month_times'] = $borrow_result['time_limit'];
		$_data['borrow_time'] = $borrow_result['success_time'];
		$_data['borrow_style'] = $borrow_result['style'];
		
		$_data['isday'] = $borrow_result['isday'];
		$_data['time_limit_day'] = $borrow_result['time_limit_day'];
		
		$interest_result = borrowClass::EqualInterest($_data);
		
		//计算全部本息
		$repayment_total_account = 0;
		foreach ($interest_result as $key => $value){
			$repayment_total_account = $repayment_total_account+$value['repayment_account'];//总还金额
		}
		
		$vouch_need = round($repayment_total_account * $account_money / $borrow_result['account'], 2);
		
		
		if ($borrow_result['vouch_account']>=$borrow_result['account']){
			$msg = "此担保标担保金额已满，请勿再担保";
			return $msg;
		}

		//liukun add for bug 58 begin
		if (md5($data['paypassword'])!=$_G['user_result']['paypassword']){
			$msg = "支付交易密码不正确";
			return $msg;
		}
		//liukun add for bug 58 end

		//判断是否是担保人
		if ($borrow_result['vouch_user']!=""){
			$_vouch_user = explode("|",$borrow_result['vouch_user']);

			fb(in_array($_G['user_result']['username'],$_vouch_user), FirePHP::TRACE);
			if (!in_array($_G['user_result']['username'],$_vouch_user)){
				$msg = "此担保标已经指定了担保人，你不是此担保人，不能进行担保";
				return $msg;
			}
		}
			

		//liukun add for bug 109 begin

		//获取投资的担保额度borrowClass::GetUserLog
		$vouch_amount =  borrowClass::GetAmountOne($vouch_userid,"tender_vouch");

		if ($vouch_amount['account_use']<$vouch_need){
			$msg = "您的担保额度不足。";
			return $msg;
		}
		//liukun add for bug 109 end
		
		$used_amount = $vouch_need;
		
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
		$result = $mysql->db_query($sql);
		if ($result != true){
			return $result;
		}
		$vouch_id = $mysql->db_insert_id();

		if ($vouch_id>0){
			

			//添加额度记录
			$amountlog_result = borrowClass::GetAmountOne($vouch_data['user_id'],"tender_vouch");
			$amountlog["user_id"] = $vouch_data['user_id'];
			$amountlog["type"] = "tender_vouch_sucess";
			$amountlog["amount_type"] = "tender_vouch";
			$amountlog["account"] = $used_amount;
			$amountlog["account_all"] = $amountlog_result['account_all'];
			$amountlog["account_use"] = $amountlog_result['account_use'] - $amountlog['account'];
			$amountlog["account_nouse"] = $amountlog_result['account_nouse'] + $amountlog['account'];
			$amountlog["remark"] = "担保成功";
			$result = borrowClass::AddAmountLog($amountlog);
			if ($result != true){
				return $result;
			}
		}else{
			$msg = "担保失败。";
			return $msg;
		}
		
		$sql = "update  {borrow}  set vouch_account=vouch_account+{$account_money},vouch_times=vouch_times+1  where id='{$borrow_id}'";
		$result = $mysql->db_query($sql);//更新已经担保的钱

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

		$borrow_id = $data["id"];
		$vouch_award = $data['vouch_award'];
		$borrow_userid = $data['user_id'];
		$borrow_account = $data['account'];
		$month_times = $data['time_limit'];

		$vouch_list = borrowClass::GetVouchList(array("limit"=>"all","borrow_id"=>$borrow_id));
		//liukun add for bug 52 begin
		fb($vouch_list, FirePHP::TRACE);
		//liukun add for bug 52 end
		if ($vouch_list==""){
			$msg = "获取担保记录失败。";
			return $msg;
		}
		$result = true;
		$borrow_url = "<a href=\'/invest/a{$data['id']}.html\' target=_blank>{$data['name']}</a>";
		if ($data['status'] == 3){
			//借款成功的奖励支出。
			$account_result =  accountClass::GetOne(array("user_id"=>$borrow_userid));
			$vouch_log['user_id'] = $borrow_userid;
			$vouch_log['type'] = "vouch_awardpay";
			$vouch_log['money'] = round($vouch_award*$borrow_account/100,2);;
			$vouch_log['total'] = $account_result['total']-$vouch_log['money'];
			$vouch_log['use_money'] = $account_result['use_money']-$vouch_log['money'];
			$vouch_log['no_use_money'] = $account_result['no_use_money'];
			$vouch_log['collection'] = $account_result['collection'];
			$vouch_log['to_user'] = 0;
			$vouch_log['remark'] = "担保借款标的[{$borrow_url}]借款成功的奖励支出";
			$result = accountClass::AddLog($vouch_log);
			if($result !== true){
				return $result;
			}

			foreach ($vouch_list as $key => $value){
				$vouch_account = $value['account'];
				$vouch_userid = $value['user_id'];
				$vouch_id = $value['id'];
				$vouch_awa = round(($vouch_award*$value['account'])/100,2);
				$vouch_type = $value['vouch_type'];
				$sql = "update  {borrow_vouch}  set status=1,award_fund='{$vouch_award}',award_account={$vouch_awa} where id = {$value['id']}";
				$result = $mysql -> db_query($sql);
				if ($result != true){
					return $result;
				}
				//借款成功的奖励5%。
				$account_result =  accountClass::GetOne(array("user_id"=>$value['user_id']));
				$vouch_log['user_id'] = $value['user_id'];
				$vouch_log['type'] = "vouch_award";
				$vouch_log['money'] = $vouch_awa;
				$vouch_log['total'] = $account_result['total']+$vouch_log['money'];
				$vouch_log['use_money'] = $account_result['use_money']+$vouch_log['money'];
				$vouch_log['no_use_money'] = $account_result['no_use_money'];
				$vouch_log['collection'] = $account_result['collection'];
				$vouch_log['to_user'] = $borrow_userid;
				$vouch_log['remark'] = "担保借款标的[{$borrow_url}]借款成功的奖励";
				$result = accountClass::AddLog($vouch_log);
				if ($result != true){
					return $result;
				}

				//将还款数据添加到vouch_collection标里面去
				//collection中是根据vouch_collection算出来的
				$vouch_collection = $value['vouch_collection'];
				
				$_vouch_account = round($vouch_collection/$month_times,2);
				
				
				for ($i=0;$i<$month_times;$i++){
					if ($i==$month_times-1){
						$_vouch_account = $vouch_collection - $_vouch_account*$i;
					}
					//repair by weego 20120525 for 天标还款时间
					if($isday==1){
						$repay_time=strtotime("$time_limit_day days",time());
					}else{
						$repay_time = get_times(array("time"=>time(),"num"=>$i+1));
					}
					// 2012-06-14 修改还款时间 LiuYY
					$to_day = date("Y-m-d 23:59:59", $repay_time);
					$repay_time = strtotime($to_day);
					$sql = "insert into  {borrow_vouch_collection}  set borrow_id={$value['borrow_id']},`addtime` = '".time()."',`addip` = '".ip_address()."'
							,user_id=$vouch_userid ,`order` = {$i},vouch_id={$vouch_id},status=0,repay_account = '{$_vouch_account}',repay_time='{$repay_time}', 
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
					//repair by weego 20120525 for 天标还款时间
					if($isday==1){
						$repay_time=strtotime("$time_limit_day days",time());
					}else{
						$repay_time = get_times(array("time"=>time(),"num"=>$i+1));
					}
					// 2012-06-14 修改还款时间 LiuYY
					$to_day = date("Y-m-d 23:59:59", $repay_time);
					$repay_time = strtotime($to_day);
					$sql = "insert into  {borrow_vouch_repayment}  set borrow_id={$borrow_id},`addtime` = '".time()."',`addip` = '".ip_address()."',user_id=$borrow_userid ,`order` = {$i},status=0,repay_account = '{$_borrow_account}',repay_time='{$repay_time}'";
					$mysql->db_query($sql);
				}
			}
			//liukun add for bug 179 end

			//扣除借款担保额度
			$amountlog["user_id"] = $borrow_userid;
			$amountlog_result = borrowClass::GetAmountOne($borrow_userid, "restructuring");
			$amountlog["type"] = "restructuring_success";
			$amountlog["amount_type"] = "restructuring";
			$amountlog["remark"] = "债务重组借款审核通过扣去债务重组额度";
			$amountlog["account"] = $borrow_account;
			$amountlog["account_all"] = $amountlog_result['account_all'];
			$amountlog["account_use"] = $amountlog_result['account_use'] - $amountlog['account'];
			//债务重组额度不可重用
			$amountlog["account_nouse"] = 0;

			//liukun add for bug 52 begin
			fb($amountlog, FirePHP::TRACE);
			//liukun add for bug 52 end
			$result = borrowClass::AddAmountLog($amountlog);
			if ($result != true){
				return $result;
			}
			//发标成功后设置用户is_restructuring状态为1，以后用户就一直处于债务重组状态，直到所有债务还完
			
			$sql = "update  {user}  set is_restructuring=1 where user_id = {$borrow_userid}";
			$result = $mysql->db_query($sql);
			if ($result != true){
				return $result;
			}
		}
		else{
			//liukun add for bug 101 begin
			foreach ($vouch_list as $key => $value){
				//添加额度记录
				$amountlog_result = borrowClass::GetAmountOne($value['user_id'],"tender_vouch");
				$amountlog["user_id"] = $value['user_id'];
				$amountlog["type"] = "tender_vouch_false";
				$amountlog["amount_type"] = "tender_vouch";
				$amountlog["account"] = $value['vouch_collection'];
				$amountlog["account_all"] = $amountlog_result['account_all'];
				$amountlog["account_use"] = $amountlog_result['account_use'] + $amountlog['account'];
				$amountlog["account_nouse"] = $amountlog_result['account_nouse'] - $amountlog['account'];
				$amountlog["remark"] = "债务重组借款标[{$borrow_url}]审核失败，担保人担保额度返还";
				$result = borrowClass::AddAmountLog($amountlog);
				if(!$result){
					return $result;
				}
					
				$sql = "update  {borrow_vouch}  set status=2 where id = {$value['id']}";
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
	 * 还款
	 *
	 * @param Array $data
	 * @return Boolen
	 */
	function repay($data = array()){
		global $mysql;

		$borrow_userid=$data["borrow_userid"];
		$borrow_id=$data["borrow_id"];
		$borrow_account=$data["borrow_account"];
		$repayment_account=$data["repayment_account"];


		$late_days = $data["late_result"]["late_days"];
		
		//债务重组标因为只是系统工作人员作为担保人，用额度担保，所以如果逾期，因为没有余额担保这种可能，所以不需要将逾期后用户还款还给担保人
		$result = true;
		//liukun add for bug 159 begin
		//担保人没有垫付之前，借款人还款，担保人担保额度直接恢复
		if ($data['status']!=2){
			$sql = "select * from  {borrow_vouch_collection}  where borrow_id=$borrow_id and `order`={$data['order']}";
			$vouch_collection_list = $mysql->db_fetch_arrays($sql);
			if ($vouch_collection_list!=""){
				foreach ($vouch_collection_list as $key => $value){
					//添加额度记录
					$amountlog_result = borrowClass::GetAmountOne($value['user_id'],"tender_vouch");
					$amountlog["user_id"] = $value['user_id'];
					$amountlog["type"] = "tender_vouch_repay";
					$amountlog["amount_type"] = "tender_vouch";
					$amountlog["account"] = $value['repay_account'];
					$amountlog["account_all"] = $amountlog_result['account_all'];
					$amountlog["account_use"] = $amountlog_result['account_use'] + $amountlog['account'];
					$amountlog["account_nouse"] = $amountlog_result['account_nouse'] - $amountlog['account'];
					$amountlog["remark"] = "担保标还款成功，投资担保额度返还";
					$result = borrowClass::AddAmountLog($amountlog);
					if ($result != true){
						return $result;
					}

					$sql = "update  {borrow_vouch_collection}  set repay_yestime = ".time().",repay_yesaccount = {$amountlog['account']},status=1 where id = {$value['id']}";
					$result = $mysql->db_fetch_array($sql);
					if ($result != true){
						return $result;
					}

				}
			}
		}
		//liukun add for bug 159 end


		return $result;
	}

	/**
	 * 逾期处理
	 *
	 * @param Array $data
	 * @return Boolen
	 */
	function late_repay($data = array()){
		global $mysql;

		$result = true;
		$borrow_id = $data['borrow_id'];
		$repayment_order = $data['order'];

		$sql = "select * from  {borrow_vouch_collection}  where borrow_id=$borrow_id and `order`={$repayment_order}";
		
		$vouch_collection_list = $mysql->db_fetch_arrays($sql);
		if ($vouch_collection_list!=""){
			foreach ($vouch_collection_list as $key => $value){
				//执行担保人垫付（额度）
				//liukun add for bug 184 begin
				if($value['vouch_type']=="amount"){
					$amountlog_result = borrowClass::GetAmountOne($value['user_id'],"tender_vouch");
					$amountlog["user_id"] = $value['user_id'];
					$amountlog["type"] = "tender_vouch_advance";
					$amountlog["amount_type"] = "tender_vouch";
					$amountlog["account"] = $value['repay_account'];
					$amountlog["account_all"] = $amountlog_result['account_all']- $amountlog['account'];
					$amountlog["account_use"] = $amountlog_result['account_use'];
					$amountlog["account_nouse"] = $amountlog_result['account_nouse'] - $amountlog['account'];
					$amountlog["remark"] = "担保标逾期，投资担保额度扣除";
					$result = borrowClass::AddAmountLog($amountlog);
					if ($result != true){
						return $result;
					}
					
					$account_result =  accountClass::GetOne(array("user_id"=> $value['user_id']));
					$log['user_id'] =  $value['user_id'];
					$log['type'] = "tender_vouch_advance";//
					$log['money'] = $value['repay_account'];
					$log['total'] = $account_result['total']-$log['money'];
					$log['use_money'] = $account_result['use_money']-$log['money'];
					$log['no_use_money'] = $account_result['no_use_money'];
					$log['collection'] = $account_result['collection'];
					$log['to_user'] = 0;
					$log['remark'] = "担保标逾期，担保人可用额度扣除。";
					$result = accountClass::AddLog($log);
					if(!$result){
						return $result;
					}
					//TODO 如何处理vouch_collection
					//$sql = "update  {borrow_vouch_collection}  set repay_yestime = ".time().",repay_yesaccount = {$amountlog['account']},status=1 where id = {$value['id']}";
					//$mysql->db_fetch_array($sql);
				}
				//liukun add for bug 184 end
			}
		}

		return $result;
	}
		
	
	/**
	 * 获得标的附加信息
	 *
	 * @param Array $data
	 * @return Boolen
	 */
	function getLateInterest($data = array()){
		global $mysql,$_G;
			
		$interest_result = parent::getLateInterest($data);

		if ($data["status"] == 2){
			//如果网站已经垫付，表示已经执行过担保人垫付（因为会扣除担保人提供的担保金），逾期收入全部归担保人
			$late_voucher_interest = $interest_result['late_interest'];
		}
		else{
			//如查网站没有垫付，担保人没有逾期利息收入
			$late_voucher_interest = 0;
		}
		
		$interest_result["late_voucher_interest"] = $late_voucher_interest;

		return $interest_result;
	}



}
?>