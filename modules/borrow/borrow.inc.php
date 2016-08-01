<?php
if (!defined('ROOT_PATH'))  die('不能访问');//防止直接访问
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
	//验证用户是否有发过标 add by weego 20120613
	$gourl="javascript:history.go(-1);";
	$result = borrowClass::GetOnes(array("user_id"=>$_G['user_id']));
	if (!isset($_POST['name']) || $_POST['name'] == ""){
		$msg = array("请填入基本信息","",$gourl);
	}
	
	//liukun add for bug 58 begin
	elseif ($_POST['valicode']!=$_SESSION['valicode']){
		$msg = array("验证码不正确","",$gourl);
	}
	//liukun add for bug 58 end
	
	//liukun add for bug 93 begin
	elseif (!$_POST['biao_type']){
		$msg = array("发标类型不正确","","/borrow/index.html");
	}
	//liukun add for bug 93 end
	
	elseif($_POST['style']==1 && $_POST['time_limit']%3!=0){
		$msg = array("您选择的是按季还款，借款期限请填写3的倍数","",$gourl);
	}elseif($_POST['award']==1 && $_POST['part_account']<5){
		$msg = array("您选择的是按金额奖励，请填写奖励金额值(不能低于5元)","",$gourl);
	}elseif($_POST['award']==2 && ($_POST['funds'] < 0.1 || $_POST['funds'] > 6)){
		$msg = array("您选择的是按比例奖励，请填写奖励比例值( 0.1% ~ 6% )","","");
	}elseif(isset($_POST['isDXB']) && (!isset($_POST['pwd']) || $_POST['pwd'] == "" ) ){
		$msg = array("您选择了定向标，请输入定向标的密码.","",$gourl);
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
		//按天 add by weego for 天标  20120513
		if((int)$_POST['isday']==1){
			//liukun add for bug 324 begin
			$data['style'] = 0;
			//liukun add for bug 324 end
			$data['time_limit'] = 1;
			$data['time_limit_day'] = intval($_POST['time_limit_day']);
			$data['isday'] = intval($_POST['isday']);
		}

		//按天 add by jackfeng for 担保新增 20120716
		if((int)$_POST['danbao']==1){
			$data['danbao'] = 1;
		}

		if((int)$_POST['is_nocash']==1){
			$data['is_nocash'] = 1;
		}
		
		/* alpha add for bug 24 增加站内周转标 begin*/
		if((int)$_POST['is_restructuring']==1){
			$data['is_restructuring'] = 1;
		}
		/* alpha add for bug 24增加站内周转标 end*/

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

		//定向标 密码
		if(isset($_POST['pwd'])){
			if(isset($_POST['pwd']) && $_POST['pwd'] != ""){
				$data['pwd'] = htmlspecialchars($_POST['pwd']);
			}
		}

		$data['open_account'] = 1;
		$data['open_borrow'] = 1;
		$data['open_credit'] = 1;
		if ($_POST['submit']=="保存草稿"){
			$data['status'] = -1;
		}else{
			$data['status'] =0;
		}
		$data['user_id'] = $_G['user_id'];
		$data['insurance']=(int)$_POST['insurance'];

		if ($_U['query_type'] == "add"){
			$result = borrowClass::Add($data);
			
			if($result === true){
				//自动审核处理
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
			$msg = array("借款操作成功。","","/index.php?user&q=code/borrow/publish");
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
		$msg = array("撤销成功!","","index.php?user&q=code/borrow/publish");
	}else{
		$msg = array($result,"","index.php?user&q=code/borrow/publish");

	}
}

//删除
elseif ($_U['query_type'] == "del"){
	$data['id'] = $_REQUEST['id'];
	$data['user_id'] = $_G['user_id'];
	$data['status'] = -1;
	$result = borrowClass::Delete($data);
	if ($result==false){
		$msg = array($result);
	}else{
		$msg = array("招标删除成功!");
	}
}

//用户投标
elseif ($_U['query_type'] == "tender"){
// 	if ($_SESSION['valicode']!=$_POST['valicode']){
// 		$msg = array("验证码错误");
	if(!isset($_POST['id'])){
		$msg = array("请求参数不完整。");
	}else{
		$fp = fopen(ROOT_PATH."data/tender.txt" ,'w+');
		//@chmod(ROOT_PATH."data/tender.txt", 0777);
		if(flock($fp , LOCK_EX))
		{		
			include_once(ROOT_PATH."modules/account/account.class.php");
			$borrow_id = (int)$_POST['id'];
			$user_id = $_G['user_id'];
			//liukun add for bug 486 begin
			//这个更新不需要事务
			/*$sql = "update  {borrow}  set processing=1,current_userid={$user_id}  where id={$borrow_id} and processing = 0 and current_userid = -1 limit 1";
			$lock_result = $mysql->db_query($sql);		
			$borrow_process_lock = mysql_affected_rows();*/
			//liukun add for bug 486 end
			
			$borrow_result = borrowClass::GetOne(array("id"=>$_POST['id'],"tender_userid"=>$_G['user_id']));//获取借款标的单独信息		
			$biaotype_info = borrowClass::get_biao_type_info(array("biao_type"=>$borrow_result['biao_type']));		
			$account_money = $_POST['money'];
			//定向标密码
			$dxbPWD = $_POST['dxbPWD'];
			
			//liukun add for bug 151 begin
			//1.计算借款标剩余可投标量
			$can_account = $borrow_result['account'] - $borrow_result['account_yes'];
			//2.计算最大投标吧，与本客户累计投标量之间的差量
			$can_single_account = $borrow_result['most_account'] - $borrow_result['tender_yes'];
			//3.判断个人最小投标与剩余投标，取两者中的小者为最小投标量
			$lowest_account = $borrow_result['lowest_account'];
			
			if($can_account < $lowest_account){
				$lowest_account = $can_account;
			}		
			if($can_single_account < $lowest_account){
				$lowest_account = $can_single_account;
			}		//如果剩余投标量小于最小投标量，表示这是投标的最后一点差额，这个时候，实际投标以剩余量为准，不考虑投标额限制
			if ($account_money > $can_account){
				$account_money = $can_account;
			}
			//如果投标金额大于个人还可投标金额，实际投标金额为个人还可投标金额
			if ($account_money > $can_single_account){
				$account_money = $can_single_account;
			}
			//liukun add for bug 151 end
			//if($lock_result!=true && $borrow_process_lock!=1){
			/*if($borrow_process_lock!=1){
				$msg = array("投标请求没有被接受，请稍后再试！");
			}
			else*/if($_G['user_id'] == $borrow_result['user_id']){
				$msg = array("自己不能投自己发布的标！");
			}elseif ($_G['user_result']['islock']==1){
				$msg = array("您账号已经被锁定，不能进行投标，请跟管理员联系");
			}elseif (!is_array($borrow_result)){
				$msg = array($borrow_result);
			}elseif ($borrow_result['account_yes']>=$borrow_result['account']){
				$msg = array("此标已满，请勿再投");
			}elseif ($borrow_result['verify_time'] == "" || $borrow_result['status'] != 1){
				$msg = array("此标尚未通过审核");
			}
			//liukun add for bug 这里永远也不会满足，因为$borrow_result['valid_time']是有效天数， 
			//elseif ($borrow_result['verify_time'] + $borrow_result['valid_time']>time()){
			elseif (($borrow_result['verify_time'] + $borrow_result['valid_time'] * 3600 * 24) <time()){
				$msg = array("此标已过期");
			}
			elseif(!is_numeric($account_money)){
				$msg = array("请输入正确的金额");
			}
			//liukun add for bug 151 begin
			elseif($account_money < $lowest_account ){
				$msg = array("您的投标金额{$account_money}不能小于最小投标金额{$lowest_account}");
			}
			elseif($can_single_account == 0 ){
				$msg = array("您的总投标金额已经到达最大限制{$borrow_result['most_account']}");
			}
			elseif($dxbPWD != $borrow_result['pwd']){
				$msg = array("您输入的定向标密码不正确，请向发标者取得正确的密码.");
			}
			//liukun add for bug 58 begin
			elseif (md5($_POST['paypassword'])!=$_G['user_result']['paypassword']){
				$msg = array("支付交易密码不正确");
			}
			//liukun add for bug 58 end
			else{
				$con_connect_ws = isset($_G['system']['con_connect_ws'])?$_G['system']['con_connect_ws']:"0";
				$account_result =  accountClass::GetOne(array("user_id"=>$_G['user_id']));//获取当前用户的余额
				//如果选择缴纳本金保障费，那投标时还要判断
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
					$msg = array("您的余额不足");
				}
				elseif ($account_result['collection'] < $biaotype_info['tender_collection_limit_amount'] && $biaotype_info['tender_collection_limit_amount'] > 0){
					$msg = array("您的待收金额小于投标限制。（{$biaotype_info['tender_collection_limit_amount']}元）");
				}
				elseif ($biaotype_info['tender_ip_limit_nums'] > 0 && $iptendNum >= $biaotype_info['tender_ip_limit_nums']){
					$msg = array("您所在的IP投标总次数大于了投标限制。（{$biaotype_info['tender_ip_limit_nums']}次）");
				}
				else{
					$data['borrow_id'] = $_POST['id'];
					$data['money'] = $_POST['money'];
					$data['account'] = $account_money;
					$data['user_id'] = $_G['user_id'];
					$data['status'] = 1;
					$data['insurance'] = $insurance;
					$result = borrowClass::AddTender($data);//添加借款标				
					if ($result === true){
						
						if ($borrow_result['status'] ==1 && ($borrow_result['account_yes'] + $account_money) >= $borrow_result['account']){
							$classname = $borrow_result['biao_type']."biaoClass";
							$dynaBiaoClass = new $classname();
							$auto_full_verify_result = $dynaBiaoClass->get_auto_full_verify($borrow_result['biao_type']);		
							if ($auto_full_verify_result==1){
								$data_e['id'] = $_POST['id'];
								$data_e['status'] = '3';
								$data_e['repayment_remark'] = '自动复审';
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
			//处理完后，恢复到可以再次处理的状态
			/*$sql = "update  {borrow}  set processing=0,current_userid=-1  where id={$borrow_id} and processing = 1 and current_userid = $user_id limit 1";
			$mysql->db_query($sql);*/
			//liukun add for bug 486 begin	
			flock($fp,LOCK_UN);
		}
		fclose($fp);
	}
	if ($result !== true)
	{
		if(empty($msg[0])){	$msg[0]='投标请求没有被接受，请稍后再试！';	}
		if(!isset($_POST['id'])){
			$msg = array($msg[0],"","/invest/index.html");
		}
		else{
			$msg = array($msg[0],"","/invest/a{$borrow_result['id']}.html");
		}
	}else{
		$msg = array("投标成功","","/index.php?user&q=code/borrow/bid");
	}
}

//liukun add for bug 19 begin
//用户购买流转标
elseif ($_U['query_type'] == "purchase"){
	if (1==2){
		// 	if ($_SESSION['valicode']!=$_POST['valicode']){
		$msg = array("验证码错误");
	}elseif (md5($_POST['paypassword'])!=$_G['user_result']['paypassword']){
		$borrow_id = $_POST['id'];
		$msg = array("支付交易密码不正确","","/invest/a{$borrow_id}.html");
	}else{
		include_once(ROOT_PATH."modules/account/account.class.php");
		$borrow_id = $_POST['id'];
		$circulation_id = $_POST['circulation_id'];
		$unit_num = $_POST['unit_num'];
		$buy_month_num = $_POST['buy_month_num'];
		$insurance = $_POST['insurance'];

		$borrow_result = borrowClass::GetOne(array("id"=>$borrow_id));//获取借款标的单独信息
		$circulation_result = borrowClass::GetCirculationOne(array("id"=>$circulation_id));
		if($circulation_result['st'] != 0)
		{
			$buy_month_num = $circulation_result['begin_month_num'];
		}

		$current_time = time();
		$buyer_id = $_G['user_id'];
		$seller_id = $borrow_result['user_id'];

		//交易金额等于购买的流转标单价价格*份数
		$unit_price = $circulation_result['unit_price'];

		$account_result =  accountClass::GetOne(array("user_id"=>$buyer_id));//获取当前用户的余额
		$use_money = $account_result["use_money"] - $insurance;
		$use_award = $account_result["use_award"];


		//分别计算现金和奖励可购买的最大份数，不能混合购买一份，比如一份100，不能现金50, 奖励50
		//如果有现金750，奖励1000，现在想买10份，那就是现金买7份，奖励买3份
		$max_money_buy_num = floor($use_money / $unit_price);
		$max_award_buy_num = floor($use_award / $unit_price);


		//为提高用户操作效率，减少失败率，如果用户输入一个很大的购买份数，则以目前最大可购份数为实际购买份数
		$valid_unit_num = $circulation_result['valid_unit_num'];
		// 		if ($unit_num > $valid_unit_num){
		// 			$unit_num = $valid_unit_num;
		// 		}
		$account_money = $unit_price * $unit_num;
		//定向标密码

		//************************************************************
		// 		$sql = "Select count(*) as num From {borrow_tender}  where borrow_id={$_POST['id']} and user_id={$_G['user_id']}";

		// 		$tenderResult = $mysql->db_fetch_array($sql);
		// 		$tendNum=$tenderResult["num"];

		//************************************************************

		$sql = "select * from  {user}  where user_id={$buyer_id}";
		$userPermission = $mysql ->db_fetch_array($sql);

		//判断流转标有效期
		$valid_month_num = $circulation_result['duration'] - floor((time() - $borrow_result['verify_time']) / 3600 / 24 / 30);

		//liukun add for bug 241 begin
		$sql = "select sum(unit_num)  as buyed_num, count(*) as tender_times from  {circulation_buy_serial}  where buyer_id={$buyer_id} and circulation_id = {$circulation_id} and buyback = 0";
		$buyed_num_result = $mysql ->db_fetch_array($sql);

		$buyed_num = $buyed_num_result['buyed_num'];

		//liukun add for bug 241 end

		//liukun add for bug 489 begin 流转标购买也受次数限制，所有没回购的次数
		$classname = 'circulation'."biaoClass";
		$dynaBiaoClass = new $classname();
		$max_tender_times = $dynaBiaoClass->get_max_tender_times();



		//liukun add for bug 489 end

		//liukun add for bug 244 begin
		//1.计算借款标剩余可投标量
		$can_unit_num = $valid_unit_num;
		//2.计算最大投标吧，与本客户累计投标量之间的差量
		$can_single_unit_num = $circulation_result['max_unit_num'] - $buyed_num;
		//3.判断个人最小投标与剩余投标，取两者中的小者为最小投标量
		$lowest_unit_num = $circulation_result['min_unit_num'];

		if($can_unit_num < $lowest_unit_num){
			$lowest_unit_num = $can_unit_num;
		}

		if($can_single_unit_num < $lowest_unit_num){
			$lowest_unit_num = $can_single_unit_num;
		}


		//如果剩余投标量小于最小投标量，表示这是投标的最后一点差额，这个时候，实际投标以剩余量为准，不考虑投标额限制
		if ($unit_num > $can_unit_num){
			$unit_num = $can_unit_num;
		}
		//如果投标金额大于个人还可投标金额，实际投标金额为个人还可投标金额
		if ($unit_num > $can_single_unit_num){
			$unit_num = $can_single_unit_num;
		}
		//liukun add for bug 244 end


		if($_G['user_id'] == $borrow_result['user_id']){
			$msg = array("自己不能投自己发布的标！");
		}elseif ($_G['user_result']['islock']==1){
			$msg = array("您账号已经被锁定，不能进行投标，请跟管理员联系");
		}
		elseif(($max_money_buy_num + $max_award_buy_num)<$unit_num){
			$msg = array("您的余额不足");
		}
		elseif (!is_array($borrow_result)){
			$msg = array($borrow_result);
		}elseif($borrow_result['status']!=1){
			$msg = array("此流转标目前不可认购。");
		}elseif($valid_unit_num==0){
			$msg = array("没有可认购流转标。");
		}
		// 		elseif($unit_num < $circulation_result['min_unit_num']){
		// 			$msg = array("不能小于最小可购份数");
		// 		}
		// 		//liukun add for bug 241 begin
		// 		elseif(($unit_num + $buyed_num) > $circulation_result['max_unit_num']){
		// 			$msg = array("总购买份数不能大于最大可购份数");
		// 		}
		//liukun add for bug 241 end

		//liukun add for bug 244 begin
		elseif($unit_num < $lowest_unit_num ){
			$msg = array("您的购买份数{$unit_num}不能小于最小购买份数{$lowest_unit_num}");
		}
		elseif($can_single_unit_num == 0 ){
			$msg = array("您的总购买份数已经到达最大限制{$circulation_result['max_unit_num']}");
		}
		//liukun add for bug 244 end

		//liukun add for bug 187 begin
		elseif($userPermission['is_restructuring'] == 1){
			$msg = array("你目前是债务重组中，不能购买流转标");
		}
		//liukun add for bug 187 end
		elseif($valid_month_num < $buy_month_num){
			$msg = array("购买期限（{$buy_month_num}月）超过流转标有效期（{$valid_month_num}月）");
		}
		elseif ($buyed_num_result['tender_times'] >= $max_tender_times){
			$msg =  array("对不起，你已经超过最大认购次数(".$max_tender_times."次)。(当前未回购认购总次数。)");
		}
		else{

			$money_buy_num = ($max_money_buy_num >= $unit_num)?$unit_num:$max_money_buy_num;
			$award_buy_num = ($max_money_buy_num >= $unit_num)?0:($unit_num - $max_money_buy_num);
			//liukun add for bug 472 begin
			$mysql->db_query("start transaction");
			//liukun add for bug 472 end
			$transaction_result = true;
			try{
				//获得奖励信息
				$borrow_award = $borrow_result['award'];
				$borrow_funds = $borrow_result['funds'];
				//还款方式 
				$borrow_style = $borrow_result['style'];
				 
				//增加流转标的已购买份数
				$circulation_id = $circulation_result['id'];
				$sell_num = $money_buy_num + $award_buy_num;
				$sql = "update  {circulation}  set `valid_unit_num` = valid_unit_num - {$sell_num}, `circulated_num` = `circulated_num` + $sell_num";
				$sql .= " where id=$circulation_id";

				$transaction_result = $mysql->db_query($sql);
				if ($transaction_result !==true){
					throw new Exception();
				}
				//将成效的资金直接进行交易，从投资人账户扣除，存入借款人账户

				//增加发标人的资金
				$account_result =  accountClass::GetOne(array("user_id"=>$seller_id));//获取当前用户的余额
				$log['user_id'] = $seller_id;
				$log['type'] = "sell_circulation";
				$log['money'] = $sell_num * $unit_price;
				$log['total'] = $account_result['total']+$log['money'];
				$log['use_money'] =  $account_result['use_money']+$log['money'];
				$log['no_use_money'] =  $account_result['no_use_money'];
				$log['collection'] =  $account_result['collection'];
				$log['to_user'] = $buyer_id;
				$log['remark'] = "成功售出流转标入款";
				$transaction_result = accountClass::AddLog($log);//添加记录
				if ($transaction_result !==true){
					throw new Exception();
				}
				//写入购买记录
				$borrow_url = "<a href=\'/invest/a{$borrow_result['id']}.html\' target=_blank>{$borrow_result['name']}</a>";
				$classname = $borrow_result['biao_type']."biaoClass";
				$dynaBiaoClass = new $classname();
				//收取管理费
				if($circulation_result['st'] != 0)//不是经典流转的话 收取管理费
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
						$fee_log['remark'] = "借款[{$borrow_url}]的手续费1";
	
						$transaction_result = accountClass::AddLog($fee_log);
						if ($transaction_result !==true){
							throw new Exception();
						};
					}
				}
				//冻结保证金
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
					$margin_log['remark'] = "冻结借款标的[{$borrow_url}]的保证金";
					$transaction_result = accountClass::AddLog($margin_log);
					if ($transaction_result !==true){
						throw new Exception();
					};
					//更新保证金
					$sql = "update  {borrow}  set forst_account='{$margin_log['money']}' where id='{$id}'";
					$transaction_result = $mysql -> db_query($sql);
					if ($transaction_result !==true){
						throw new Exception();
					};
						
				}

				//支付投标奖励
				if ($borrow_award ==2){

					$award_money = round($sell_num * $unit_price * $borrow_funds /100, 2);
					//投标奖励扣除和增加。
					$account_result =  accountClass::GetOne(array("user_id"=>$seller_id));
					$log['user_id'] = $seller_id;
					$log['type'] = "award_lower";
					$log['money'] = $award_money;
					$log['total'] = $account_result['total']-$award_money;
					$log['use_money'] = $account_result['use_money']-$award_money;
					$log['no_use_money'] = $account_result['no_use_money'];
					$log['collection'] = $account_result['collection'];
					$log['to_user'] = 0;
					$log['remark'] = "扣除借款[{$borrow_url}]的奖励";
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
					//计算计息结束时间
					$circulation_data['end_interest_time'] = $circulation_data['begin_interest_time'] + 30 * 24 * 3600 * $circulation_data['buy_month_num'];
					//liukun add for bug 219 end

					// 这里算出用户的实际应得利率
					$buy_apr = $circulation_result['begin_apr'] + ($circulation_data['buy_month_num'] - $circulation_result['begin_month_num']) * $circulation_result['increase_apr'];
					$circulation_data['buy_apr'] = $buy_apr;
					$circulation_data['buy_type'] = "account";

					//计算本金和正常回购时应得利息
					$circulation_data['capital'] = $circulation_data['unit_num'] * $unit_price;
					
					//根据还款方式计算月还息和还款期数
					if($borrow_style == 2){
						//到期全额还款就只有一期
						$circulation_data['monthly_interest_repay'] = round($circulation_data['capital'] * $circulation_data['buy_apr'] * $circulation_data['buy_month_num'] / 12 / 100, 2);;
						$circulation_data['repay_month_num'] = 1;
						$circulation_data['interest'] = $circulation_data['monthly_interest_repay'];
					}else{
						//按月付息，到期还本
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
					//扣去投资人的资金
					$account_result =  accountClass::GetOne(array("user_id"=>$buyer_id));//获取当前用户的余额
					$log['user_id'] = $buyer_id;
					$log['type'] = "purchase_circulation";
					$log['money'] = $circulation_data['capital'];
					$log['total'] = $account_result['total']-$log['money'];
					$log['use_money'] =  $account_result['use_money']-$log['money'];
					$log['no_use_money'] =  $account_result['no_use_money'];
					$log['collection'] =  $account_result['collection'];
					$log['to_user'] = $seller_id;
					$log['remark'] = "成功购进流转标付款";
					$transaction_result = accountClass::AddLog($log);//添加记录
					if ($transaction_result !==true){
						throw new Exception();
					}

					//liukun add for bug 223 begin
					$account_result =  accountClass::GetOne(array("user_id"=>$buyer_id));//获取当前用户的余额
					$log['user_id'] = $buyer_id;
					$log['type'] = "purchase_circulation_collection";
					$log['money'] = $circulation_data['capital'] + $circulation_data['interest'];
					$log['total'] = $account_result['total']+$log['money'];
					$log['use_money'] =  $account_result['use_money'];
					$log['no_use_money'] =  $account_result['no_use_money'];
					$log['collection'] =  $account_result['collection']+$log['money'];
					$log['to_user'] = $seller_id;
					$log['remark'] = "成功购进流转标增加待收";
					$transaction_result = accountClass::AddLog($log);//添加记录
					if ($transaction_result !==true){
						throw new Exception();
					}
					//liukun add for bug 223 end
						
					//设置了奖励选项后，购买要获得奖励
					if ($borrow_award ==2){
							
						$award_money = round($circulation_data['capital'] * $borrow_funds /100, 2);
						//投标奖励扣除和增加。
						$account_result =  accountClass::GetOne(array("user_id"=>$buyer_id));//获取当前用户的余额
						$log['user_id'] = $buyer_id;
						$log['type'] = "award_add";
						$log['money'] = $award_money;
						$log['total'] = $account_result['total']+$award_money;
						$log['use_money'] = $account_result['use_money']+$award_money;
						$log['no_use_money'] = $account_result['no_use_money'];
						$log['collection'] = $account_result['collection'];
						$log['to_user'] = $seller_id;
						$log['remark'] = "借款[{$borrow_url}]的奖励";
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
					//计算计息结束时间
					$circulation_data['end_interest_time'] = $circulation_data['begin_interest_time'] + 30 * 24 * 3600 * $circulation_data['buy_month_num'];
					//liukun add for bug 219 end

					// 这里算出用户的实际应得利率
					$buy_apr = $circulation_result['begin_apr'] + ($circulation_data['buy_month_num'] - $circulation_result['begin_month_num']) * $circulation_result['increase_apr'];
					$circulation_data['buy_apr'] = $buy_apr;
					$circulation_data['buy_type'] = "award";

					//计算本金和正常回购时应得利息
					$circulation_data['capital'] = $circulation_data['unit_num'] * $unit_price;
					
					//根据还款方式计算月还息和还款期数
					if($borrow_style == 2){
						//到期全额还款就只有一期
						$circulation_data['monthly_interest_repay'] = round($circulation_data['capital'] * $circulation_data['buy_apr'] * $circulation_data['buy_month_num'] / 12 / 100, 2);;
						$circulation_data['repay_month_num'] = 1;
						$circulation_data['interest'] = $circulation_data['monthly_interest_repay'];
					}else{
						//按月付息，到期还本
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
					//增加award日志

					$award_log['user_id'] = $buyer_id;
					$award_log['type'] = "purchase_circulation";
					$award_log['award'] = -$need_award;
					$award_log['remark'] = "成功购进流转标付款";
					$sql = "insert into  {recharge_award_log}  set `addtime` = '".time()."',`addip` = '".ip_address()."'";
					foreach($award_log as $key => $value){
						$sql .= ",`$key` = '$value'";
					}
					$transaction_result = $mysql->db_query($sql);
					if ($transaction_result !==true){
						throw new Exception();
					}
						
					//设置了奖励选项后，购买要获得奖励
					if ($borrow_award ==2){
							
						$award_money = round($circulation_data['capital'] * $borrow_funds /100, 2);
						//投标奖励扣除和增加。
						$sql = "update  {account}  set `award_interest` = `award_interest` + {$award_money}";
						$sql .= " where user_id=$buyer_id";

						$transaction_result = $mysql->db_query($sql);
						if ($transaction_result !==true){
							throw new Exception();
						}
						//增加award日志

						$award_log['user_id'] = $buyer_id;
						$award_log['type'] = "award_add";
						$award_log['award'] = $award_money;
						$award_log['remark'] = "成功购进流转标得到奖励";
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
				//认购流转标缴纳本金保障费
				$ws_fl_rate = isset($_G['system']['con_ws_fl_rate'])?$_G['system']['con_ws_fl_rate']:0.16;
				$point2account = isset($_G['system']['con_point2account'])?$_G['system']['con_point2account']:2.52;
				$con_connect_ws = isset($_G['system']['con_connect_ws'])?$_G['system']['con_connect_ws']:"0";
				if ($insurance > 0){
					$account_result =  accountClass::GetOne(array("user_id"=>$buyer_id));//获取当前用户的余额
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
						$ws_log['remark']="向webservice提交投资本金保障信息";
						$transaction_result = wsaccountClass::addWSlog($ws_log);
						if ($transaction_result !==true){
							throw new Exception();
						}
					}
					//扣除投资本金保障费
					$account_result =  accountClass::GetOne(array("user_id"=>$buyer_id));
					$log['user_id'] = $buyer_id;
					$log['type'] = "insurance";
					$log['money'] = $insurance;
					$log['total'] = $account_result['total']-$log['money'];
					$log['use_money'] = $account_result['use_money']-$log['money'];
					$log['no_use_money'] = $account_result['no_use_money'];
					$log['collection'] = $account_result['collection'];
					$log['to_user'] = 0;
					$log['remark'] = "缴纳本金保障费";
					$transaction_result = accountClass::AddLog($log);
					if ($transaction_result !==true){
						throw new Exception();
					};


				}

					
			}
			catch (Exception $e){
				//必须保证所有不可接受的错误都返回异常，并执行了回滚
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
			$msg = array("认购成功","","/index.php?user&q=code/borrow/purchased");
		}
	}

}
//liukun add for bug 19 end

//liukun add for bug 19 begin
//回购用户认购的流转标
elseif ($_U['query_type'] == "buyback"){
	//if ($_SESSION['valicode']!=$_POST['valicode']){
	if(1==2){
		$msg = array("验证码错误");
	}else{
		include_once(ROOT_PATH."modules/account/account.class.php");
		$buy_id = $_POST['buy_id'];
		$buy_result = borrowClass::GetCirculationBuyDetail(array("id"=>$buy_id));
		//防止重复提交
		if($buy_result['buyback']==0)
		{			
			$circulation_result = borrowClass::GetCirculationOne(array("id"=>$buy_result['circulation_id']));
			
			$borrow_result = borrowClass::GetOne(array("id"=>$circulation_result['borrow_id']));						        	//获取借款标的单独信息	
			$current_time = time();	
			$buyer_id = $buy_result['buyer_id'];
			$seller_id = $borrow_result['user_id'];
	
			$auto_repurchase = $_POST['auto_repurchase'];
	
			$begin_interest_time = $buy_result['begin_interest_time'];
	
			//因为有后台进程自动回购，所以不会出现用户购买3月，回购时已经过期超过1个月的情况
			$can_interest_month = floor((time() - $begin_interest_time) / 3600 / 24 / 30);
			//因为开始计息时间是当天晚上23：59：59，所以这里要处理一下，不然购买了立刻回购，这里的值成-1了
			$can_interest_month = ($can_interest_month>=0)?$can_interest_month:0;
	
		}

		if ($_G['user_result']['islock']==1){
			$msg = array("您账号已经被锁定，请跟管理员联系");
		}
		elseif($buy_result['buyback']==1)
		{
			$msg = array("己回购，不能重复回购！");
		}
		elseif($buyer_id!=$_G['user_id'])
		{
			$msg = array("悲剧了，请重新登陆！");
		}
		elseif ($can_interest_month <= 0){
			$msg = array("流转标购入不足一月，不能回购");
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

			//计算所得利息
			//liukun add for bug 163 begin
			//用户认购时选择的购买月数，如果回购时时间不足够，利息只算初始利率的一半
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


			$account_result =  accountClass::GetOne(array("user_id"=>$seller_id));//获取发标人的余额

			//liukun add for bug 240 begin
			/*
			 if ($account_result['use_money']<($account_money + $interest)){
			$msg = array("发标人余额不足，无法回购。");
			*/
			//liukun add for bug 240 end
			if(1==2){
			}else{

				//将成效的资金直接进行交易，增加投资人账户，扣除发标人账户

				//判断是否需要自动续购

				//判断流转标有效期
				$valid_month_num = $circulation_result['duration'] - floor((time() - $borrow_result['verify_time']) / 3600 / 24 / 30);

				//当充值活动不再有效后，如果是用充值奖励购买的流转标，就不能再自动续购了，即使用户设置过自动续购
				$sql = " SELECT count(*) as num FROM  {recharge_award_rule}  where begin_time < ".time()." and end_time > ".time();
				$rule_result = $mysql ->db_fetch_array($sql);

				$valid_award_rule = $rule_result['num'];


				//只有正常到期才有可能自动续购， $can_interest_month == $buy_month_num
				//只有流转标有效期大于认购期才能续购
				//用余额购买 或者 用奖励购买且当时是奖励活动中
				//如果自动回购就只收回利息
				//liukun add for bug 52 begin

				//liukun add for bug 472 begin
				$mysql->db_query("start transaction");
				//liukun add for bug 472 end
				$transaction_result = true;
				try{
					//写入购买记录
					$borrow_url = "<a href=\'/invest/a{$borrow_result['id']}.html\' target=_blank>{$borrow_result['name']}</a>";
					$classname = $borrow_result['biao_type']."biaoClass";
					$dynaBiaoClass = new $classname();
					//收取管理费
					$interest_fee_rate = $dynaBiaoClass->get_interest_fee_rate();
					//收取管理费
					$fee_rate = $dynaBiaoClass->get_borrow_fee_rate();
						
					//liukun add for bug 52 end
					if($auto_repurchase == 1 && ($valid_month_num >= $buy_month_num &&   $can_interest_month == $buy_month_num)
							&&(($buy_type == "award" && $valid_award_rule > 0) || $buy_type == "account")){
						if ($buy_type == "award"){
							//奖励投标得到的利息不能重用，只能累计到利息项
							//liukun add for bug 174 begin
							$sql = "update  {account}  set ";
							$sql .= " award_interest = award_interest + {$interest}";
							$sql .= " where user_id=$buyer_id";
							//liukun add for bug 174 end

							$transaction_result = $mysql->db_query($sql);
							if ($transaction_result !==true){
								throw new Exception();
							}
							//增加award日志


							//liukun add for bug 174 begin
							//利息日志
							$award_log['user_id'] = $buyer_id;
							$award_log['type'] = "buyback_circulation_interest";
							$award_log['award'] = $interest;
							$award_log['remark'] = "成功回购流转标收款（利息）";
							$sql = "insert into  {recharge_award_log}  set `addtime` = '".time()."',`addip` = '".ip_address()."'";
							foreach($award_log as $key => $value){
								$sql .= ",`$key` = '$value'";
							}
							$transaction_result = $mysql->db_query($sql);
							if ($transaction_result !==true){
								throw new Exception();
							}
							//liukun add for bug 174 end
								
							//扣除利息管理费
								
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
							$award_log['remark'] = "用户成功还款扣除利息的管理费";
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
							//将成效的资金直接进行交易，增加投资人账户，扣除发标人账户
							$account_result =  accountClass::GetOne(array("user_id"=>$buyer_id));//获取当前用户的余额
							$log['user_id'] = $buyer_id;
							$log['type'] = "buyback_circulation";
							$log['money'] = $interest;
							$log['total'] = $account_result['total']+$log['money'];
							$log['use_money'] =  $account_result['use_money']+$log['money'];
							$log['no_use_money'] =  $account_result['no_use_money'];
							$log['collection'] =  $account_result['collection'];
							$log['to_user'] = $seller_id;
							$log['remark'] = "成功回购流转标收款（利息）";
							$transaction_result = accountClass::AddLog($log);//添加记录
							if ($transaction_result !==true){
								throw new Exception();
							}
							//自动续购时，代收不变（因为新的认购记录中待收本金和利息都与上次认购相同，所以只要增加本次回购得到 的利息即可
								
							//扣除利息管理费
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
							$log['remark'] = "用户成功还款扣除利息的管理费";
							$transaction_result = accountClass::AddLog($log);
							if ($transaction_result !==true){
								throw new Exception();
							};
							
							//如果是按月还息的模式，那么续购成功要增加待收（就是每月支付的利息）
							$borrow_style = $borrow_result['style'];
							if($borrow_style == 3){
								//liukun add for bug 223 begin
								$account_result =  accountClass::GetOne(array("user_id"=>$buyer_id));//获取当前用户的余额
								$log['user_id'] = $buyer_id;
								$log['type'] = "purchase_circulation_collection";
								$log['money'] = $buy_result['monthly_interest_repay'] * ($buy_result['buy_month_num'] - 1);
								$log['total'] = $account_result['total']+$log['money'];
								$log['use_money'] =  $account_result['use_money'];
								$log['no_use_money'] =  $account_result['no_use_money'];
								$log['collection'] =  $account_result['collection']+$log['money'];
								$log['to_user'] = $seller_id;
								$log['remark'] = "续购成功，补足待收差额";
								$transaction_result = accountClass::AddLog($log);//添加记录
								if ($transaction_result !==true){
									throw new Exception();
								}
								//liukun add for bug 223 end
							}

						}
							
						//生成新的认购记录
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
							
						//计算计息结束时间
						$buy_data['end_interest_time'] = $buy_data['begin_interest_time'] + 30 * 24 * 3600 * $buy_data['buy_month_num'];
						$buy_data['buy_apr'] = $buy_result['buy_apr'];
						$buy_data['buy_type'] = $buy_result['buy_type'];
							
						//计算本金和正常回购时应得利息
						$buy_data['capital'] = $buy_result['capital'];

						$borrow_style = $borrow_result['style'];
						$buy_data['monthly_interest_repay'] = $buy_result['monthly_interest_repay'];
						if($borrow_style == 2){
							//到期全额还款就只有一期
							$buy_data['repay_month_num'] = 1;
							$buy_data['interest'] = $buy_data['monthly_interest_repay'];
						}else{
							//按月付息，到期还本
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
						//增加已流转份数，自动续购不需要增加可购买份数
						$sell_num = $unit_num;
						$sql = "update  {circulation}  set  `circulated_num` = `circulated_num` + $sell_num";
						$sql .= " where id=$circulation_id";
							
						$transaction_result = $mysql->db_query($sql);
						if ($transaction_result !==true){
							throw new Exception();
						}
						//扣除发标人的资金（利息）
						$account_result =  accountClass::GetOne(array("user_id"=>$seller_id));//获取当前用户的余额
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
						$log['remark'] = "成功接受回购流转标申请付款（利息）";
						$transaction_result = accountClass::AddLog($log);//添加记录
						if ($transaction_result !==true){
							throw new Exception();
						}

						if($circulation_result['st'] != 0)//不是经典流转的话 收取管理费
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
								$fee_log['remark'] = "借款[{$borrow_url}]的手续费4";
	
								$transaction_result = accountClass::AddLog($fee_log);
								if ($transaction_result !==true){
									throw new Exception();
								};
							}
						}
					}else{
						if ($buy_type == "award"){
							//奖励投标得到的利息不能重用，只能累计到利息项
							//liukun add for bug 174 begin
							$sql = "update  {account}  set `use_award` = `use_award` + {$account_money}";
							$sql .= ", award_interest = award_interest + {$interest}";
							$sql .= " where user_id=$buyer_id";
							//liukun add for bug 174 end

							$mysql->db_query($sql);

							//增加award日志
							//投资本金日志
							$award_log['user_id'] = $buyer_id;
							$award_log['type'] = "buyback_circulation";
							$award_log['award'] = $account_money;
							$award_log['remark'] = "成功回购流转标收款（本金）";
							$sql = "insert into  {recharge_award_log}  set `addtime` = '".time()."',`addip` = '".ip_address()."'";
							foreach($award_log as $key => $value){
								$sql .= ",`$key` = '$value'";
							}
							$transaction_result = $result = $mysql->db_query($sql);
							if ($transaction_result !==true){
								throw new Exception();
							}
							//liukun add for bug 174 begin
							//利息日志
							$award_log['user_id'] = $buyer_id;
							$award_log['type'] = "buyback_circulation_interest";
							$award_log['award'] = $interest;
							$award_log['remark'] = "成功回购流转标收款（利息）";
							$sql = "insert into  {recharge_award_log}  set `addtime` = '".time()."',`addip` = '".ip_address()."'";
							foreach($award_log as $key => $value){
								$sql .= ",`$key` = '$value'";
							}
							$transaction_result = $mysql->db_query($sql);
							if ($transaction_result !==true){
								throw new Exception();
							}
							//liukun add for bug 174 end
								
							//扣除利息管理费
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
							$award_log['remark'] = "用户成功还款扣除利息的管理费";
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
						$account_result =  accountClass::GetOne(array("user_id"=>$buyer_id));//获取当前用户的余额
						$log['user_id'] = $buyer_id;
						$log['type'] = "buyback_circulation_collection";
						$log['money'] = $buy_result['capital'] + $buy_result['interest'];
						$log['total'] = $account_result['total']-$log['money'];
						$log['use_money'] =  $account_result['use_money'];
						$log['no_use_money'] =  $account_result['no_use_money'];
						$log['collection'] =  $account_result['collection']-$log['money'];
						$log['to_user'] = $seller_id;
						$log['remark'] = "成功回购流转标减少待收";
						$transaction_result = accountClass::AddLog($log);//添加记录
						if ($transaction_result !==true){
							throw new Exception();
						}
						//liukun add for bug 223 end
						
						//将成效的资金直接进行交易，增加投资人账户，扣除发标人账户
						$account_result =  accountClass::GetOne(array("user_id"=>$buyer_id));//获取当前用户的余额
						$log['user_id'] = $buyer_id;
						$log['type'] = "buyback_circulation";
						$log['money'] = $account_money;
						$log['total'] = $account_result['total']+$log['money'];
						$log['use_money'] =  $account_result['use_money']+$log['money'];
						$log['no_use_money'] =  $account_result['no_use_money'];
						$log['collection'] =  $account_result['collection'];
						$log['to_user'] = $seller_id;
						$log['remark'] = "成功回购流转标收款（本金）";
						$transaction_result = accountClass::AddLog($log);//添加记录
						if ($transaction_result !==true){
							throw new Exception();
						}
						
						
						if ($interest > 0){
							$account_result =  accountClass::GetOne(array("user_id"=>$buyer_id));//获取当前用户的余额
							$log['user_id'] = $buyer_id;
							$log['type'] = "buyback_circulation";
							$log['money'] = $interest;
							$log['total'] = $account_result['total']+$log['money'];
							$log['use_money'] =  $account_result['use_money']+$log['money'];
							$log['no_use_money'] =  $account_result['no_use_money'];
							$log['collection'] =  $account_result['collection'];
							$log['to_user'] = $seller_id;
							$log['remark'] = "成功回购流转标收款（利息）";
						}else{
							$account_result =  accountClass::GetOne(array("user_id"=>$buyer_id));//获取当前用户的余额
							$log['user_id'] = $buyer_id;
							$log['type'] = "early_buyback_circulation";
							$log['money'] = -$interest;
							$log['total'] = $account_result['total']-$log['money'];
							$log['use_money'] =  $account_result['use_money']-$log['money'];
							$log['no_use_money'] =  $account_result['no_use_money'];
							$log['collection'] =  $account_result['collection'];
							$log['to_user'] = $seller_id;
							$log['remark'] = "提前回购差额（利息）";
						}
						$transaction_result = accountClass::AddLog($log);//添加记录
						if ($transaction_result !==true){
							throw new Exception();
						}

						if ($interest > 0){
							//扣除利息管理费
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
							$log['remark'] = "用户成功还款扣除利息的管理费";
							$transaction_result = accountClass::AddLog($log);
							if ($transaction_result !==true){
								throw new Exception();
							};
						}
					}

					//增加流转标的可购买份数，增加已流转份数，自动续购不需要增加可购买份数这种操作
					$sell_num = $unit_num;
					$sql = "update  {circulation}  set `valid_unit_num` = `valid_unit_num` + $sell_num";
					$sql .= " where id=$circulation_id";

					$transaction_result = $mysql->db_query($sql);
					if ($transaction_result !==true){
						throw new Exception();
					}

					//解冻保证金
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
						$account_log['remark'] = "对[{$borrow_url}]借款保证金的解冻";
						$transaction_result = accountClass::AddLog($account_log);
						if ($transaction_result !==true){
							throw new Exception();
						};
					}
					//扣除发标人的资金（本金+利息）
					$account_result =  accountClass::GetOne(array("user_id"=>$seller_id));//获取当前用户的余额
					$log['user_id'] = $seller_id;
					$log['type'] = "accept_buyback_circulation";
					$log['money'] = $account_money + $interest;
					$log['total'] = $account_result['total']-$log['money'];
					$log['use_money'] =  $account_result['use_money']-$log['money'];
					$log['no_use_money'] =  $account_result['no_use_money'];
					$log['collection'] =  $account_result['collection'];
					$log['to_user'] = $buyer_id;
					$log['remark'] = "成功接受回购流转标申请付款（本金+利息）";
					$transaction_result = accountClass::AddLog($log);//添加记录
					if ($transaction_result !==true){
						throw new Exception();
					}


				}
				//无论是否需要自动续购，肯定会收回投资利息

				//设置回购成功标记
				$sql = "update  {circulation_buy_serial}  set `buyback` = 1, `buyback_time` = '".time()."'";
				$sql .= " where id={$buy_id}";

				$transaction_result = $mysql->db_query($sql);
				if ($transaction_result !==true){
					throw new Exception();
				}

			}
			catch (Exception $e){
				$msg = array($transaction_result);
				//必须保证所有不可接受的错误都返回异常，并执行了回滚
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
		$msg = array("回购成功","","/index.php?user&q=code/borrow/purchased");
	}
}

}
//liukun add for bug 19 end

//担保标投标
elseif ($_U['query_type'] == "vouch"){
	$msg = "";
	//if ($_SESSION['valicode']!=$_POST['valicode']){
	if(1==2){
		$msg = array("验证码错误");
	}
	elseif($_G['user_result']['use_money'] < 0)
	{
		$msg = array("您的账户余额为负数，请充值为正数后再担保。");
	}
	elseif ($_G['user_result']['islock']==1){
		$msg = array("您账号已经被锁定，不能进行担保，请跟管理员联系");
	}
	else{

		$result = borrowClass::AddVouch($_POST);//array("borrow_id"=>$_POST['id'],"tender_userid"=>$_G['user_id']));//添加担保标

		if ($result===true){
			$msg = array("担保成功","","/index.php?user&q=code/borrow/bid");
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


//查看投标
elseif ($_U['query_type'] == "repayment_view"){
	$data['id'] = $_REQUEST['id'];
	if ($data['id']==""){
		$msg = array("您的输入有误");
	}
	$data['user_id'] = $_G['user_id'];
	$result =  borrowClass::GetOne($data);//获取当前用户的余额
	if ($result==false){
		$msg = array("您的操作有误");
	}else{
		$_U['borrow_result'] = $result;
	}
}

//还款
elseif ($_U['query_type'] == "repay"){
	$data['id'] = $_REQUEST['id'];
	if ($data['id']==""){
		$msg = array("您的输入有误");
	}
	$data['user_id'] = $_G['user_id'];
	$result =  borrowClass::Repay($data);//获取当前用户的余额
	if ($result!==true){
		$msg = array($result,"","/index.php?user&q=code/borrow/repaymentplan");
	}else{
		$msg = array("还款成功","","/index.php?user&q=code/borrow/repayment");
	}
}
//额度申请
elseif ($_U['query_type'] == "limitapp"){
	if (isset($_POST['account']) && $_POST['account']>0){
		$var = array("account","content","type","remark");
		$data = post_var($var);
		$data['user_id'] = $_G['user_id'];
		$result = borrowClass::GetAmountApplyOne(array("user_id"=>$data['user_id'],"type"=>$data['type']));
		$audit_result = borrowClass::getAmountAuditInfo(array("user_id"=>$data['user_id']));
		if ($result!=false && $result['verify_time']+60*60*24*30 >time()){
			$msg = "请一个月后再申请";
		}elseif ($result!=false && $result['addtime']+60*60*24*30 >time() && $result['status']==2){
			$msg = "您已经提交了申请，请等待审核";
		}elseif($data['type'] == "tender_vouch" && $audit_result['result']==false){
			$msg = "您需要完成VIP、手机、征信、实名、视频五项认证才可申请投资担保额度。";
		}
		else{
			$data['status'] = 2;
			
			
			
			$result =  borrowClass::AddAmountApply($data);//获取当前用户的余额
			if ($result!==true){
				$msg = $result;
			}else{
				$msg = array("额度申请成功，请等待管理员审核","","/index.php?user&q=code/borrow/limitapp");
			}
		}
		
		if ($result!==true){
			$msg = array($msg,"","/index.action?user");
		} 
	}
}

//增加自动投标
elseif ($_U['query_type'] == "auto_add"){
	$_POST['user_id'] = $_G['user_id'];
	$_POST['addtime'] = time();
	$re = borrowClass::add_auto($_POST);
	if($re===false){
		$msg = array("您已经添加了1条自动投标，最多只能添加1条，您可以删除或者修改","","/index.php?user&q=code/borrow/auto");
	}else{
		$msg = array("自动投标设置成功","","/index.php?user&q=code/borrow/auto");
	}
}

//修改自动投标
elseif ($_U['query_type'] == "auto_new"&&is_numeric($_GET['id'])){
	$result = borrowClass::GetAutoId($_GET['id']);
	$_U['auto_result'] = $result;
}

//删除自动投标
elseif ($_U['query_type'] == "auto_del"&&is_numeric($_GET['id'])){
	$result = borrowClass::del_auto($_GET['id']);
	if($result) $msg = array("自动投标删除成功","","/index.php?user&q=code/borrow/auto");
}

//liukun add for bug 21 begin
//发布债权转让
elseif ($_U['query_type'] == "post_alienate"){
	$data['borrow_right_id'] = $_POST['borrow_right_id'];
	if(empty($_POST['price']) || empty($_POST['unit'])){
		$msg = array("信息不完整","","");
	}
	elseif (($_POST['price'] % $_POST['unit'])!=0){
		$msg = array("转让价格必须是转让单位的整数倍","","");
	}
	else{
		$data['price'] = $_POST['price'];
		$data['unit'] = $_POST['unit'];
		$result = borrowClass::AddAlienate($data);
		if($result===true){
			$msg = array("发布债权转让成功","","/index.php?user&q=code/borrow/alienate_myposted");
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
//购买债权
elseif ($_U['query_type'] == "buy_alienate"){
	$data['right_alienate_id'] = $_POST['right_alienate_id'];
	$data['unit_num'] = abs((int)$_POST['unit_num']);
	$result = borrowClass::BuyAlienate($data);
	if($result===true){ 
		$msg = array("债权购买成功","","/index.php?user&q=code/borrow/alienate_buy_list");
	}else{
		//$msg = array($result,"","/index.php?user&q=code/borrow/alienate_market");
		$msg = array($result,"","javascript:history.go(-1);");
	}
}
//liukun add for bug 78 end

//liukun add for bug 81 begin
//购买债权
elseif ($_U['query_type'] == "cancel_alienate"){
	$data['right_alienate_id'] = $_GET['right_alienate_id'];
	$result = borrowClass::CancelAlienate($data);
	if($result===true){
		$msg = array("债权转让标撤消成功","","/index.php?user&q=code/borrow/alienate");
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
		$msg = array("error不能回购！","","?user&q=code/borrow/purchased");	
	}
	else
	{
		$_U['buyback_info'] = $result;
	}
}
//liukun add for bug 471 begin
elseif ($_U['query_type'] == "testbreak"){
	//下面两句都不回的时候，客户端一但中断，立即停止执行
	ignore_user_abort(true);//只加这句会执行到超时，
	set_time_limit(0);//会一直执行直接到结束或者永远在运行
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
		//使用事务时能回滚以前的数据库操作
		
		//不使用事务的时候，执行到哪里，数据库就是中断执行时的状态
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
	//测试结果，如果用户中断，事务不会提交，也就是和执行前状态一样
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
		$msg = array("垫付成功!","","/index.php?user&q=code/borrow/tender_vouch_finish&status=0");
	}else{
		$msg = array($result,"","/index.php?user&q=code/borrow/tender_vouch_finish&status=0");

	}
}

else{
		
}

$template = "user_borrow.html.php";
if($_U['query_type'] == "auto"||$_U['query_type'] == "auto_new")  $template = "auto_user_borrow.html.php";
?>
