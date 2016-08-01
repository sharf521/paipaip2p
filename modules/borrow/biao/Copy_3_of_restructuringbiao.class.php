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
		global $mysql, $_G;



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

		$newid = $mysql->db_insert_id();
		$_G['new_borrow_id'] = $newid;

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
				//不同的担保方式 处理方式不一样
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
					$log['remark'] = "债务重组标撤销，担保人冻结可用额度返还。";
					$result = accountClass::AddLog($log);
					if(!$result){
						return $result;
					}
				}
				else{
					//添加额度记录
					$amountlog_result = borrowClass::GetAmountOne($value['user_id'],"tender_vouch");
					$amountlog["user_id"] = $value['user_id'];
					$amountlog["type"] = "tender_vouch_false";
					$amountlog["amount_type"] = "tender_vouch";
					$amountlog["account"] = $value['vouch_collection'];
					$amountlog["account_all"] = $amountlog_result['account_all'];
					$amountlog["account_use"] = $amountlog_result['account_use'] + $amountlog['account'];
					$amountlog["account_nouse"] = $amountlog_result['account_nouse'] - $amountlog['account'];
					$amountlog["remark"] = "债务重组标撤销，担保人担保额度返还。";
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
	 * 担保处理
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

		//计算实际的担保金额
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
			$msg = "此债务重组标担保金额已满，请勿再担保";
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
			if (!in_array($_G['user_result']['username'],$_vouch_user)){
				$msg = "此债务重组标已经指定了担保人，你不是此担保人，不能进行担保";
				return $msg;
			}
		}
			

		//liukun add for bug 108 begin
		$account_result =  accountClass::GetOne(array("user_id"=>$vouch_userid));//获取当前用户的余额
		//$uacc = borrowClass::GetUserLog(array('user_id'=>$_G['user_id']));
			
		// 		if ($uacc['total']<$account_money){
		// 			$msg = "您的账户总额小于您想担保的总金额，不能担宝";
		// 			return $msg;
		// 		}



		//获取投资的担保额度borrowClass::GetUserLog
		$vouch_amount =  borrowClass::GetAmountOne($vouch_userid,"tender_vouch");

		//担保是用投资担保额度和可提现金额担保
		if (($vouch_amount['account_use'] + ($account_result['use_money'] - $account_result['nocash_money'])) <$vouch_need){
			$msg = "您的担保额度与可用余额之和不够进行本次担保。";
			return $msg;
		}
		//liukun add for bug 108 end

		//先用可用余额担保
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


				//添加额度记录
				//根据担保比例计算需要冻结的总金额，因为担保不只是担保酬金，利息也要考虑
					
				$account_result =  accountClass::GetOne(array("user_id"=>$vouch_userid));
				$log['user_id'] = $vouch_userid;
				$log['type'] = "tender_vouch_sucess";//
				$log['money'] = $used_account;
				$log['total'] = $account_result['total'];
				$log['use_money'] = $account_result['use_money']-$log['money'];
				$log['no_use_money'] = $account_result['no_use_money']+$log['money'];
				$log['collection'] = $account_result['collection'];
				$log['to_user'] = 0;
				$log['remark'] = "担保成功冻结可用余额";
				$result = accountClass::AddLog($log);
				if ($result != true){
					return $result;
				}
			}else{
				$msg = "担保失败。";
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


				//添加额度记录
				$amountlog_result = borrowClass::GetAmountOne($vouch_userid,"tender_vouch");
				$amountlog["user_id"] = $vouch_userid;
				$amountlog["type"] = "tender_vouch_sucess";
				$amountlog["amount_type"] = "tender_vouch";
				$amountlog["account"] = $used_amount;
				$amountlog["account_all"] = $amountlog_result['account_all'];
				$amountlog["account_use"] = $amountlog_result['account_use'] - $amountlog['account'];
				$amountlog["account_nouse"] = $amountlog_result['account_nouse'] + $amountlog['account'];
				$amountlog["remark"] = "担保成功冻结担保额度";
				$result = borrowClass::AddAmountLog($amountlog);
				if ($result != true){
					return $result;
				}
			}else{
				$msg = "担保失败。";
				return $msg;
			}
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
			$msg = "获取担保记录失败。";
			return $msg;
		}
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
				//这里是汇总来生成的，所以不需要单独为每条担保生成collection信息，只生成一条即可
				// 				$vouch_id = $value['id'];
				$vouch_id = 0;

				$vouch_awa = round(($vouch_award*$value['account'])/100,2);
				$vouch_type = $value['vouch_type'];
				$sql = "update  {borrow_vouch}  set status=1,award_account={$vouch_awa} where user_id = {$vouch_userid} and borrow_id = {$borrow_id}";
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
				//因为现在不只是只有等额本息还款法，所以债务重组标的额度处理也要根据还款计划来计算


				$vouch_collection = $value['vouch_collection'];
				//因为还款方式有一次性整体还款，所以还款期数不能是直接的借款期限，是还款计算法算出的期数
				$month_times = count($interest_result);
				$ed_vouch_collection = 0;
				for ($i=0;$i<$month_times;$i++){

					if ($i==$month_times-1){
						$_vouch_account = $vouch_collection - $ed_vouch_collection;
					}else{
						$_vouch_account = round($interest_result[$i]['repayment_account'] * $vouch_collection / $borrow_repayment_account,2);
						$ed_vouch_collection +=$_vouch_account;

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


			//扣除债务重组额度
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
		else {
			//liukun add for bug 101 begin
			foreach ($vouch_list as $key => $value){
				//不同的担保方式 处理方式不一样
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
					$log['remark'] = "债务重组标审校失败，担保人冻结可用额度返还。";
					$result = accountClass::AddLog($log);
					if(!$result){
						return $result;
					}
				}
				else{
					//添加额度记录
					$amountlog_result = borrowClass::GetAmountOne($value['user_id'],"tender_vouch");
					$amountlog["user_id"] = $value['user_id'];
					$amountlog["type"] = "tender_vouch_false";
					$amountlog["amount_type"] = "tender_vouch";
					$amountlog["account"] = $value['vouch_collection'];
					$amountlog["account_all"] = $amountlog_result['account_all'];
					$amountlog["account_use"] = $amountlog_result['account_use'] + $amountlog['account'];
					$amountlog["account_nouse"] = $amountlog_result['account_nouse'] - $amountlog['account'];
					$amountlog["remark"] = "债务重组标审校失败，担保人担保额度返还。";
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
	 * 还款
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

		//如果担保人用余额担保，而且逾期垫付了，那么借款人还款后，就要将逾期利息和本息还给担保人
		//liukun add for bug 158 begin
		$late_voucher_interest = $data["late_result"]["late_voucher_interest"];

		$sql = "select p1.* from  {borrow_vouch_collection}  as p1 where p1.borrow_id='{$borrow_id}' and `order`={$repayment_order} ";

		$vouch_list = $mysql->db_fetch_arrays($sql);
		if ($vouch_list==""){
			$msg = "获取担保记录失败。";
			return $msg;
		}
		foreach ($vouch_list as $key => $value){

			//担保人垫付后才能有逾期利息收入,但不管是主动垫付还是网站强制垫付，都会有逾期利息收入
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
				$account_log['remark'] = "客户对[<a href=\'/invest/a{$data['borrow_id']}.html\' target=_blank>{$data['borrow_name']}</a>]偿还逾期利息(债权表)";
				$result = accountClass::AddLog($account_log);
				if ($result!==true){
					return $result;
				}

				//将本息还款给担保人
				$account_result =  accountClass::GetOne(array("user_id"=>$value['user_id']));
				$account_log['user_id'] =$value['user_id'];
				$account_log['type'] = "invest_repayment";
				$account_log['money'] = round($repayment_account * $value['repay_account'] / $repayment_account, 2);
				$account_log['total'] = $account_result['total']+$account_log['money'];
				$account_log['use_money'] = $account_result['use_money']+$account_log['money'];
				$account_log['no_use_money'] = $account_result['no_use_money'];
				$account_log['collection'] =$account_result['collection'];
				$account_log['to_user'] = $borrow_userid;
				$account_log['remark'] = "客户对[<a href=\'/invest/a{$data['borrow_id']}.html\' target=_blank>{$data['borrow_name']}</a>]借款的还款(债权表)，金额{$account_log['money']}元";
				$result = accountClass::AddLog($account_log);
				if ($result != true){
					return $result;
				}
			}
			elseif($value['is_advance'] == 0){
				//还没有垫付前还款，额度正常恢复
				if($value['vouch_type']=="amount"){
					$amountlog_result = borrowClass::GetAmountOne($value['user_id'],"tender_vouch");
					$amountlog["user_id"] = $value['user_id'];
					$amountlog["type"] = "tender_vouch_repay";
					$amountlog["amount_type"] = "tender_vouch";
					$amountlog["account"] = $value['repay_account'];
					$amountlog["account_all"] = $amountlog_result['account_all'];
					$amountlog["account_use"] = $amountlog_result['account_use'] + $amountlog['account'];
					$amountlog["account_nouse"] = $amountlog_result['account_nouse'] - $amountlog['account'];
					$amountlog["remark"] = "债务重组标还款成功，投资担保额度返还";
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
					$log['remark'] = "债务重组标还款成功，担保人可用额度返还。";
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


		// 		$sql = "select * from  {borrow_vouch_collection}  where borrow_id=$borrow_id and `order`={$repayment_order} ";
		//后台逾期扣除的时候，只扣除没有主动垫付过的担保人的账户
		//borrow_vouch_collection is_advance = 0 担保人没有主动垫付过的才会被处理
		$sql = "select * from  {borrow_vouch_collection}  where borrow_id=$borrow_id and `order`={$repayment_order} and is_advance = 0 ";

		$vouch_collection_list = $mysql->db_fetch_arrays($sql);
		if ($vouch_collection_list!=""){
			foreach ($vouch_collection_list as $key => $value){
				//执行担保人垫付（额度或者净值）

				if($value['vouch_type']=="amount"){
					//如果是用额度进行担保的，要直接去扣可用余额
					//有多少可供垫付的可用余额，就恢复多少担保额度
					$account_result =  accountClass::GetOne(array("user_id"=> $value['user_id']));
					$use_money = $account_result['use_money'];
					$need_money = $value['repay_account'];
					$should_advance_amount = ($use_money >= $need_money)?0:($need_money - $use_money);
					$can_unfrost_amount = $value['repay_account'] - $should_advance_amount;

					//如果余额不足以垫付，就要扣除掉

					$log['user_id'] =  $value['user_id'];
					$log['type'] = "tender_vouch_advance";//
					$log['money'] = $need_money;
					$log['total'] = $account_result['total']-$log['money'];
					$log['use_money'] = $account_result['use_money']-$log['money'];
					$log['no_use_money'] = $account_result['no_use_money'];
					$log['collection'] = $account_result['collection'];
					$log['to_user'] = 0;
					$log['remark'] = "债务重组标逾期，担保人可用额度扣除。";
						
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
						$amountlog["remark"] = "债务重组标逾期，投资担保额度扣除";
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
						$amountlog["remark"] = "债务重组标还款成功，投资担保额度返还";
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
					$log['remark'] = "债务重组标逾期，担保人可用额度扣除。";
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
	 * 获得标的附加信息
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

				//担保人垫付后才能有逾期利息收入,但不管是主动垫付还是网站强制垫付，都会有逾期利息收入
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