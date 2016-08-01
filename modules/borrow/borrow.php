<?
if (!defined('ROOT_PATH'))  die('不能访问');//防止直接访问
check_rank("borrow_".$_A['query_type']);//检查权限

//include_once("borrow.class.php");

include_once(ROOT_PATH."modules/borrow/borrow.class.php");

require_once(ROOT_PATH."modules/borrow/biao/circulationbiao.class.php");
require_once(ROOT_PATH."modules/blacklist/blacklist.class.php");


//liukun add for bug 52 begin
$firePHPEnable=TRUE;
if ($firePHPEnable){
	require_once('modules/FirePHPCore/FirePHP.class.php');
	require_once('modules/FirePHPCore/fb.php');
	ob_start();

	$firephp = FirePHP::getInstance(true);
}
//liukun add for bug 52 end

$_A['list_purview'] =  array("borrow"=>array("借款管理"=>array("borrow_list"=>"借款列表",
		"borrow_new"=>"添加借款",
		"borrow_edit"=>"编辑借款",
		"borrow_amount"=>"借款额度",
		"borrow_amount_view"=>"额度管理",
		"borrow_del"=>"删除借款",
		"borrow_view"=>"审核借款",
		"borrow_subremark"=>"分站审核借款",
		"borrow_full"=>"满标列表",
		"borrow_repayment"=>"已还款",
		"borrow_liubiao"=>"流标",
		"borrow_late"=>"逾期",
		"borrow_full_view"=>"满标审核",
		"borrow_amount_subsite"=>"分站审核额度申请")));
//  echo serialize($_A['list_purview']);
//权限
$_A['list_name'] = $_A['module_result']['name'];
$_A['list_menu'] = "<a href='{$_A['query_url']}{$_A['site_url']}'>所有借款</a> - <a href='{$_A['query_url']}&status=0{$_A['site_url']}'>发标待审</a> -  <a href='{$_A['query_url']}&status=1{$_A['site_url']}'>正在招标款</a> -  <a href='{$_A['query_url']}/full&status=1{$_A['site_url']}'>己满标待审</a> -  <a href='{$_A['query_url']}/full&status=3{$_A['site_url']}'>满标审核通过</a> - <a href='{$_A['query_url']}/full&status=4{$_A['site_url']}'>满标审核未通过</a> - <a href='{$_A['query_url']}/repayment{$_A['site_url']}&status=1'>已还款</a>  -  <a href='{$_A['query_url']}/liubiao{$_A['site_url']}'>流标</a>  - <a href='{$_A['query_url']}/late{$_A['site_url']}'>已逾期列表</a> - <a href='{$_A['query_url']}/lateFast{$_A['site_url']}'>即将逾期列表</a>  - <a href='{$_A['query_url']}/amount{$_A['site_url']}'>借款额度</a> - <a href='{$_A['query_url']}/tongji{$_A['site_url']}'>统计</a>  ";


/**
 * 如果类型为空的话则显示所有的文件列表
 **/

//将管理员所属于的分站信息传入
$data['areaid'] = $_SESSION['areaid'];
$_A['areaid'] =  $_SESSION['areaid'];
$_A['admin_type_id'] =  $_SESSION['type_id'];
if ($_A['query_type'] == "list"){
	$_A['list_title'] = "信息列表";

	if (isset($_POST['id']) && $_POST['id']!=""){
		$data['id'] = $_POST['id'];
		$data['flag'] = $_POST['flag'];
		$data['view'] = $_POST['view'];
		$result = borrowClass::Action($data);
		if ($result==true){
			$msg = array("修改成功","",$_A['query_url'].$_A['site_url']);
		}else{
			$msg = array("修改失败，请跟管理员联系");
		}

	}else{
		if (isset($_REQUEST['user_id'])){
			$data['user_id'] = $_REQUEST['user_id'];
		}
		if (isset($_REQUEST['status']) && $_REQUEST['status']!=""){
			$data['status'] = $_REQUEST['status'];
		}

		if (isset($_REQUEST['username']) && $_REQUEST['username']!=""){
			$data['username'] = $_REQUEST['username'];
		}

// 		if (isset($_REQUEST['is_vouch'])){
// 			$data['is_vouch'] = $_REQUEST['is_vouch'];
// 		}

		if (isset($_REQUEST['biao_type']) && $_REQUEST['biao_type']!="all"){
			$data['biao_type'] = $_REQUEST['biao_type'];
		}



		$data['page'] = $_A['page'];
		$data['epage'] = $_A['epage'];
		$result = borrowClass::GetList($data);

		

		if (is_array($result)){
			$pages->set_data($result);
			$_A['borrow_list'] = $result['list'];
			$_A['showpage'] = $pages->show(3);

		}else{
			$msg = array($result);
		}
	}
}

/**
 * 额度管理
 **/
elseif ($_A['query_type'] == "amount"){
	check_rank("borrow_amount");//检查权限
	$_A['list_title'] = "额度管理";

	if (isset($_REQUEST['user_id']) && $_REQUEST['user_id']!=""){
		$data['user_id'] = $_REQUEST['user_id'];
	}

	if (isset($_REQUEST['username']) && $_REQUEST['username']!=""){
		$data['username'] = $_REQUEST['username'];
	}

	if (isset($_REQUEST['type']) && $_REQUEST['type']!=""){
		$data['type'] = $_REQUEST['type'];
	}

	if (isset($_REQUEST['status']) && $_REQUEST['status']!=""){
		$data['status'] = $_REQUEST['status'];
	}
	$data['page'] = $_A['page'];
	$data['epage'] = $_A['epage'];
	$result = borrowClass::GetAmountApplyList($data);

	if (is_array($result)){
		$pages->set_data($result);
		$_A['borrow_amount_list'] = $result['list'];
		$_A['showpage'] = $pages->show(3);

	}else{
		$msg = array($result);
	}
}

/**
 * 额度管理
 **/
elseif ($_A['query_type'] == "amount_view"){
	check_rank("borrow_amount_view");//检查权限
	$data['id'] = $_REQUEST['id'];
	$result = borrowClass::GetAmountApplyOne($data);
	if (isset($_POST['status'])){
		$data['user_id'] = $result['user_id'];
		$data['status'] = $_POST['status'];
		$data['type'] = $_POST['type'];
		$data['account'] = $_POST['account'];
		$data['verify_remark'] = $_POST['verify_remark'];

		$result = borrowClass::CheckAmountApply($data);

		if ($result !=1){
			$msg = array($result);
		}else{
			$msg = array("操作成功","",$_A['query_url']."/amount");
		}
		$user->add_log($_log,$result);//记录操作
	}

	else{
		if (is_array($result)){
			$sql = "select * from  {user_amount_type}  where amount_type_name='{$result['type']}'";
			$amount_type_result = $mysql ->db_fetch_array($sql);

			$_A['borrow_amount_result'] = $result;
			$_A['borrow_amount_result']['fee_rate'] = $amount_type_result['fee_rate'] * 100;
				
				
		}else{
			$msg = array($result);
		}

	}


}

/**
 * 额度管理
 **/
elseif ($_A['query_type'] == "amount_subsite"){
	check_rank("borrow_amount_subsite");//检查权限
	$data['id'] = $_REQUEST['id'];
	$result = borrowClass::GetAmountApplyOne($data);
	if (isset($_POST['subsite_remark'])){
		$data['subsite_remark'] = $_POST['subsite_remark'];

		$result = borrowClass::UpdateAmountApply($data);

		if ($result !==true){
			$msg = array($result,"",$_A['query_url']."/amount");
		}else{
			$msg = array("提交审核意见成功","",$_A['query_url']."/amount");
		}
		$user->add_log($_log,$result);//记录操作
	}

	else{
		if (is_array($result)){
			$_A['borrow_amount_result'] = $result;

		}else{
			$msg = array($result);
		}

	}


}


/**
 * 添加
 **/
elseif ($_A['query_type'] == "new"  || $_A['query_type'] == "edit" ){
	check_rank("borrow_new");//检查权限
	$_A['list_title'] = "管理信息";

	//读取用户id的信息
	if (isset($_REQUEST['user_id']) && isset($_POST['username'])){
		if(isset($_POST['user_id']) && $_POST['user_id']!=""){
			$data['user_id'] = $_POST['user_id'];
			$result = userClass::GetOne($data);
		}elseif(isset($_POST['username']) && $_POST['username']!=""){
			$data['username'] = $_POST['username'];
			$result = userClass::GetOne($data);
		}
		if ($result==false){
			$msg = array("找不到此用户");
		}else{
			echo "<script>location.href='".$_A['query_url']."/new&user_id={$result['user_id']}'</script>";
		}
	}

	elseif (isset($_POST['name'])){
		$var = array("user_id","name","use","time_limit","style","account","apr","lowest_account","most_account","valid_time","award","part_account","funds","is_false","open_account","open_borrow","open_tender","open_credit","content");
		$data = post_var($var);
		if ($_POST['status']!=0 || $_POST['status']!=-1){
			$msg = array("此标已经在招标或者已经完成，不能修改","",$_A['query_url'].$_A['site_url']);
		}else{
			if ($_A['query_type'] == "new"){
				$result = borrowClass::Add($data);
			}else{
				$data['id'] = $_POST['id'];
				$result = borrowClass::Update($data);
			}
				
			if ($result !== true){
				$msg = array($result);
			}else{
				$msg = array("操作成功","",$_A['query_url'].$_A['site_url']);
			}
		}
		$user->add_log($_log,$result);//记录操作
	}

	elseif ($_A['query_type'] == "edit" ){
		$data['user_id'] = $_REQUEST['user_id'];
		$data['id'] = $_REQUEST['id'];
		$result = borrowClass::GetOne($data);
		if (is_array($result)){
			$_A['borrow_result'] = $result;
		}else{
			$msg = array($result);
		}

	}


	elseif(isset($_REQUEST['user_id']) && !isset($_POST['username'])){
		$data['user_id'] = $_REQUEST['user_id'];
		$result = userClass::GetOne($data);
		if ($result==false){
			$msg = array("您的输入有误","",$_A['query_url']);
		}else{
			$_A['user_result'] = $result;
			//$result = borrowClass::GetOne($data);
			//$_A['borrow_result'] = $result;
		}

	}

}

/**
 * 查看
 **/
elseif ($_A['query_type'] == "view"){
	check_rank("borrow_view");//检查权限
	$_A['list_title'] = "查看认证";
	if (isset($_POST['id'])){
		$var = array("id","status","verify_remark");
		$data = post_var($var);

		$data['verify_user'] = $_G['user_id'];
		$data['verify_time'] = time();

		$result = borrowClass::Verify($data);


		if ($result ==false){
			$msg = array($result);
		}else{
			//添加用户的动态
			if($data['status']==1){
				//自动投标
				$brsql="select * from  {borrow}  where id ='".$_POST['id']."'";
				$br_row = $mysql->db_fetch_array($brsql);

				if(in_array($br_row['biao_type'], array("miao", "love", "circulation")) || $br_row['pwd']<>''){
					//不自动投标
				}else{
					$auto['id']=$data['id'];
					$auto['user_id']=$br_row['user_id'];
					$auto['total_jie']=$br_row['account'];
					$auto['zuishao_jie']=$br_row['lowest_account'];
					borrowClass::auto_borrow($auto);
				}
				//自动投标
				$_data['user_id'] = $_POST['user_id'];
				$_data['content'] = "成功发布了\"<a href=\'/invest/a{$data['id']}.html\' target=\'_blank\'>{$_POST['name']}</a>\"借款标";
				$result = userClass::AddUserTrend($_data);
			}
			$msg = array("审核操作成功","",$_A['query_url'].$_A['site_url']);
		}
		$user->add_log($_log,$result);//记录操作
	}else{
		$data['id'] = $_REQUEST['id'];
		$data['user_id'] = $_REQUEST['user_id'];
		$_A['borrow_result'] = borrowClass::GetOne($data);
		$userinfo = userClass::GetOne(array("user_id" => $data['user_id']));

		$_A['blacklist_otherinfo'] = blacklistClass::GetCountbycardid(array("card_id" => $userinfo['card_id']));
		$_A['blacklist_info'] = blacklistClass::GetOnebyUserid(array("user_id" => $data['user_id']));
		//liukun add for bug 115 begin
		if ($_A['borrow_result']['biao_type'] == 'circulation'){
			$classname = $_A['borrow_result']['biao_type']."biaoClass";
			$dynaBiaoClass = new $classname();
				
				
			$add_result = $dynaBiaoClass->getAdditionalInfo(array("borrow_id"=>$_A['borrow_result']['id']));
				
			$_A['borrow_additional_info'] = $add_result;
				
		}
		//liukun add for bug 115 end
	}
}

/**
 * 删除
 **/
elseif ($_A['query_type'] == "subremark"){
	//check_rank("borrow_subremark");//检查权限
	$_A['list_title'] = "查看认证";
	if (isset($_POST['id'])){


		$data['id'] = $_POST['id'];
		$data['subsite_status'] = $_POST['subsite_status'];
		$data['subsite_remark'] = $_POST['subsite_remark'];

		$result = borrowClass::UpdateSubRemark($data);


		if ($result ==false){
			$msg = array($result);
		}else{
				
			$msg = array("添加审核意见操作成功","",$_A['query_url'].$_A['site_url']);
		}
		$user->add_log($_log,$result);//记录操作
	}else{
		$data['id'] = $_REQUEST['id'];
		$data['user_id'] = $_REQUEST['user_id'];
		$_A['borrow_result'] = borrowClass::GetOne($data);
		$data['id'] = $_REQUEST['id'];
		$data['user_id'] = $_REQUEST['user_id'];
		$_A['borrow_result'] = borrowClass::GetOne($data);
		$userinfo = userClass::GetOne(array("user_id" => $data['user_id']));

		$_A['blacklist_otherinfo'] = blacklistClass::GetCountbycardid(array("card_id" => $userinfo['card_id']));
		$_A['blacklist_info'] = blacklistClass::GetOnebyUserid(array("user_id" => $data['user_id']));
		//liukun add for bug 115 begin
		if ($_A['borrow_result']['biao_type'] == 'circulation'){
			$classname = $_A['borrow_result']['biao_type']."biaoClass";
			$dynaBiaoClass = new $classname();
				
				
			$add_result = $dynaBiaoClass->getAdditionalInfo(array("borrow_id"=>$_A['borrow_result']['id']));
				
			$_A['borrow_additional_info'] = $add_result;
				
		}
		//liukun add for bug 115 end
	}
}

/**
 * 删除
 **/
elseif ($_A['query_type'] == "del"){
	check_rank("borrow_del");//检查权限
	$data['id'] = $_REQUEST['id'];
	$result = borrowClass::Delete($data);
	if ($result !== true){
		$msg = array($result);
	}else{
		$msg = array("删除成功","",$_A['query_url'].$_A['site_url']);
	}
	$user->add_log($_log,$result);//记录操作
}


/**
 * 满标列表
 **/
elseif ($_A['query_type'] == "full"){
	check_rank("borrow_full");//检查权限
	$_A['list_title'] = "信息列表";

	$data['page'] = $_A['page'];
	$data['epage'] = $_A['epage'];
	$data['type'] = 'review';
	if (isset($_REQUEST['status']) && $_REQUEST['status']!=""){
		$data['status'] = $_REQUEST['status'];
	}
// 	if (isset($_REQUEST['biaoType']) && $_REQUEST['biaoType']!=""){
// 		$data['biaoType'] = $_REQUEST['biaoType'];
// 	}
	if (isset($_REQUEST['biao_type']) && $_REQUEST['biao_type']!="all"){
		$data['biao_type'] = $_REQUEST['biao_type'];
	}
	if (isset($_REQUEST['username']) && $_REQUEST['username']!=""){
		$data['username'] = $_REQUEST['username'];
	}
	$result = borrowClass::GetList($data);
	if (is_array($result)){
		$pages->set_data($result);
		$_A['borrow_list'] = $result['list'];
		$_A['showpage'] = $pages->show(3);
	}else{
		$msg = array($result);
	}
}


/**
 * 满标列表
 **/
elseif ($_A['query_type'] == "cancel"){
	check_rank("borrow_cancel");//检查权限
	$_A['list_title'] = "撤回";

	$data['id'] = $_REQUEST['id'];
	$result =  borrowClass::GetOne($data);
	if ($result['status']==0 || $result['status']==1){
		borrowClass::Cancel($data);
		$msg = array("撤回成功","",$_A['query_url'].$_A['site_url']);
	}else{

		$msg = array("此标不是正在投标，不能撤回");
	}

}

/**
 * 满标列表
 **/
elseif ($_A['query_type'] == "ontop"){
	check_rank("borrow_ontop");//检查权限
	$_A['list_title'] = "撤回";

	$data['id'] = $_REQUEST['id'];
	$result =  borrowClass::GetOne($data);
	if ($result['status']==1 && $result['isontop']==1){
		$result = borrowClass::onTop($result);
		if($result===true){
			$msg = array("置顶成功","",$_A['query_url'].$_A['site_url']);
		}
		else{
			$msg = array($result);
		}
	}else{

		$msg = array("此标不能置顶(只有处于初审通过状态的标才能置顶)。");
	}

}

/**
 * 满标列表
 **/
elseif ($_A['query_type'] == "repayment"){
	check_rank("borrow_repayment");//检查权限
	$_A['list_title'] = "还款信息";

	$data['page'] = $_A['page'];
	$data['epage'] = 25;
	$data['order'] = "repayment_time";
	$data['borrow_status'] = 3;
	if (isset($_REQUEST['status']) && $_REQUEST['status']!=""){
		$data['status'] = $_REQUEST['status'];
	}
	if (isset($_REQUEST['username']) && $_REQUEST['username']!=""){
		$data['username'] = $_REQUEST['username'];
	}
	if (isset($_REQUEST['keywords']) && $_REQUEST['keywords']!=""){
		$data['keywords'] = $_REQUEST['keywords'];
	}

	$result = borrowClass::GetRepaymentList($data);
	if (is_array($result)){
		$pages->set_data($result);
		$_A['borrow_list'] = $result['list'];
		$_A['showpage'] = $pages->show(3);
	}else{
		$msg = array($result);
	}
}


/**
 * 满标列表
 **/
elseif ($_A['query_type'] == "liubiao"){
	check_rank("borrow_liubiao");//检查权限
	$_A['list_title'] = "流标";

	$data['page'] = $_A['page'];
	$data['epage'] = 25;
	if (isset($_REQUEST['status']) && $_REQUEST['status']!=""){
		$data['status'] = $_REQUEST['status'];
	}
	$data['type'] = "late";
	$data['status'] = "1";
	$result = borrowClass::GetList($data);
	if (is_array($result)){
		$pages->set_data($result);
		$_A['borrow_list'] = $result['list'];
		$_A['showpage'] = $pages->show(3);
	}else{
		$msg = array($result);
	}
}
/**
 * 满标列表
 **/
elseif ($_A['query_type'] == "liubiao_edit"){
	check_rank("borrow_liubiao");//检查权限
	$_A['list_title'] = "流标管理";
	if (isset($_POST['status']) && $_POST['status']!=""){
		$data['days'] = (int)$_POST['days'];
		$data['id'] = $_REQUEST['id'];
		$data['status'] = $_POST['status'];
		$result = borrowClass::ActionLiubiao($data);
		$msg = array("操作成功");
	}else{
		$data['id'] = $_REQUEST['id'];
		$result = borrowClass::GetOne($data);
		$_A['borrow_result'] = $result;
	}
}
/**
 * 满标处理
 **/
elseif ($_A['query_type'] == "full_view"){
	global $mysql;
	check_rank("borrow_full_view");//检查权限
	$_A['list_title'] = "满标处理";
	if (isset($_POST['id'])){
		//liukun add for bug 58 begin
		if($_SESSION['valicode']!=$_POST['valicode']){
			$msg = array("验证码不正确");
		}
		//liukun add for bug 58 end
		else{
			$var = array("id","status","repayment_remark");
			$data = post_var($var);
			$data['repayment_user'] = $_G['user_id'];
			 
			$sql = "select * from {borrow}  where id=".$_POST['id']." limit 1";
			$resultBorrow = $mysql->db_fetch_array($sql);
			if($resultBorrow['status']==3 || $resultBorrow['status']==4){
				$msg = array("此标已经审核过或正在审核处理中，不能重复审核");
			}else{

				$result = borrowClass::AddRepayment($data);

				if ($result ==false){
					$msg = array($result);
				}else{
					/*$sqlsf = "select user_id from  {borrow}  where id = ".$_POST['id'];
					 $u = $mysql->db_fetch_arrays($sqlsf);
					$au_row = borrowClass::get_back_list(array("id"=>$_POST['id']));
					$data_z['user_id'] = $u['user_id'];//借款人
					foreach($au_row as $v){
					$data_z['id']=$v['id'];

					$result =  borrowClass::Repay($data_z);//自动还款
					}*/
					$msg = array("操作成功","",$_A['query_url']."/full".$_A['site_url']);
				}

			}
		}
		$user->add_log($_log,$result);//记录操作
	}else{
		$data['id'] = $_REQUEST['id'];
		$_A['borrow_result'] = borrowClass::GetOne($data);
		if ($_A['borrow_result']['status']!=1 || $_A['borrow_result']['account']!=$_A['borrow_result']['account_yes']){
			$msg = array("当前借款标用户已经撤回 或 您的操作有误, 请刷新本页面");
		}
		$data['borrow_id'] = $data['id'];
		$data['page'] = $_A['page'];
		$data['epage'] = $_A['epage'];
		$result = borrowClass::GetTenderList($data);

		//liukun add for bug 55 begin
		$vouchlist_result = borrowClass::GetVouchList($data);

		//liukun add for bug 55 end

		$_A['borrow_repayment'] = borrowClass::GetRepayment(array("id"=>$data['id']));
		if (is_array($result)){
			$pages->set_data($result);
			$_A['borrow_tender_list'] = $result['list'];
			$_A['borrow_vouch_list'] = $vouchlist_result['list'];
			$_A['showpage'] = $pages->show(3);

		}else{
			$msg = array($result);
		}
	}
}

/**
 * 满标处理  逾期列表
 **/
elseif ($_A['query_type'] == "late"){
	check_rank("borrow_late");//检查权限
	$_A['list_title'] = "已逾期";
	if (isset($_POST['id'])){
		if($_SESSION['valicode']!=$_POST['valicode']){
			$msg = array("验证码不正确");
		}else{
			$var = array("id","status","repayment_remark");
			$data = post_var($var);
			$data['repayment_user'] = $_G['user_id'];
			$result = borrowClass::AddRepayment($data);
			if ($result ==false){
				$msg = array($result);
			}else{
				$msg = array("操作成功","",$_A['query_url']."/full".$_A['site_url']);
			}
			$_SESSION['valicode'] = "";
		}
		$user->add_log($_log,$result);//记录操作
	}else{
		$data['page'] = $_A['page'];
		$data['epage'] = $_A['epage'];
		$data['status'] = "0,2";
		$data['username'] = $_REQUEST['username'];
		$data['isday'] = $_REQUEST['isday'];

		$data['repayment_time'] = time();
		$result = borrowClass::GetLateRepaymentList($data);


		if (is_array($result))
		{
			/*//最后一期还款还执行借款人本金保障
			foreach($result['list'] as $i=>$v)
			{
				if($v['insurance']!=0)
				{
					//取最后一期的id
					$lastrepayid=borrowClass::getLastRepaymentId($v['borrow_id']);
					if($v['id']==$lastrepayid)
					{
						$result['list'][$i]['lastRepaymentId']=1;	
					}
				}
			}*/
			$pages->set_data($result);
			$_A['borrow_repayment_list'] = $result['list'];
			$_A['showpage'] = $pages->show(3);
		}else{
			$msg = array($result);
		}
	}
}
elseif($_A['query_type'] =="insurance_do")
{
	
	$result = borrowClass::insurance_do($_GET['id']);
	if ($result ===true){
		$msg = array("操作成功","",$_A['query_url']."/late".$_A['site_url']);
	}else{		
		$msg = array($result);
	}
}
/**
 * 抵押标到期最后一天处理
 **/
elseif ($_A['query_type'] == "lateFast"){
	$_A['list_title'] = "即将逾期";
	if (isset($_POST['id'])){
		if($_SESSION['valicode']!=$_POST['valicode']){
			$msg = array("验证码不正确");
		}else{
			$var = array("id","status","repayment_remark");
			$data = post_var($var);
			$data['repayment_user'] = $_G['user_id'];
			$result = borrowClass::AddRepayment($data);
			if ($result ==false){
				$msg = array($result);
			}else{
				$msg = array("操作成功","",$_A['query_url']."/full".$_A['site_url']);
			}
			$_SESSION['valicode'] = "";
		}
		$user->add_log($_log,$result);//记录操作
	}else{
		$data['page'] = $_A['page'];
		$data['epage'] = $_A['epage'];
		$data['status'] = "0,2";

		$data['username'] = $_REQUEST['username'];
		$data['isday'] = $_REQUEST['isday'];

		//根据预警时间决定查询的开始时间
		//还款时间小于当前时间加上预警时间的都是需要查询出来
		$con_laterepay_alert_days = isset($_G['system']['con_laterepay_alert_days'])?$_G['system']['con_laterepay_alert_days']:3;
		$latepay_time = strtotime(date("Y-m-d 23:59:59", time())) + 3600*24*$con_laterepay_alert_days;

		$data['repayment_time'] = $latepay_time;

		$result = borrowClass::GetLateFastRepaymentList($data);

		if (is_array($result)){
			$pages->set_data($result);
			$_A['borrow_repayment_list'] = $result['list'];
			$_A['showpage'] = $pages->show(3);
		}else{
			$msg = array($result);
		}
	}
}
/**
 * 逾期还款网站代还
 **/
elseif ($_A['query_type'] == "late_repay"){
	check_rank("borrow_late");//检查权限
	$id = $_REQUEST['id'];
	$sql = "select status from  {borrow_repayment}  where id = {$id} limit 1";
	$result = $mysql->db_fetch_array($sql);
	if($result==false){
		$msg = array("您的操作有误");
	}else{
		if ($result['status']==1){
			$msg = array("已经还款，请不要乱操作");
		}elseif ($result['status']==2){
			$msg = array("网站已经代还，请不要乱操作");
		}else{
			$n = borrowClass::LateRepay(array("id"=>$id));
			if($n===true) 
				$msg = array("还款成功");
			else 
				$msg=$n;
		}
	}

}

/**
 * 逾期还款网站代还
 **/
elseif ($_A['query_type'] == "autobuyback"){
	//check_rank("borrow_late");//检查权限
	borrowClass::autobuyback();
	borrowClass::autobuybackInterest();
	$msg = array("流转标回购完成。");
}

elseif ($_A['query_type'] == "cancelvip"){
	//check_rank("borrow_late");//检查权限
	borrowClass::CancelVIP();
	$msg = array("清理过期VIP完成。");
}

elseif ($_A['query_type'] == "cancelaward"){
	//check_rank("borrow_late");//检查权限
	borrowClass::CancelAward();
	$msg = array("非提现活动奖励过期清零完成。");
}
elseif ($_A['query_type'] == "auto"){
	$data = array();
	//自动回购
	$result = borrowClass::autobuyback($data);
	//自动结算流转标认购利息（非到期回购）
	$result = borrowClass::autobuybackInterest($data);
	//取消过期VIP
	$result = borrowClass::CancelVIP($data);
	//非提现充值奖励活动到期，取消充值奖励
	$result = borrowClass::CancelAward($data);
	//被邀请人投标达标提成奖励
	$result = borrowClass::GetInviteTicheng($data);
	//被邀请人可用余额担保提成奖励
	$result = borrowClass::GetInviteVouchTicheng($data);
	//被邀请人申请投资担保额度提成奖励
	$result = borrowClass::GetInviteBorrowTicheng($data);
	//被邀请人发标提成奖励
	$result = borrowClass::createBlackList($data);
	
	$msg = array("后台自动处理完成。");
}

/**
 * 统计
 **/
elseif ($_A['query_type'] == "tongji"){
	$_A['borrow_tongji'] = borrowClass::Tongji($data);
	$_A['account_tongji'] = accountClass::Tongji($data);
}
//防止乱操作
else{
	$msg = array("输入有误，请不要乱操作","",$url);
}
?>