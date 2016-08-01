<?
if (!defined('ROOT_PATH'))  die('不能访问');//防止直接访问
check_rank("manager_".$_A['query_type']);//检查权限

$_A['list_purview'] =  array("manager"=>array("管 理 员"=>array("manager_list"=>"管理员列表","manager_new"=>"添加管理员","manager_edit"=>"修改管理员","manager_type"=>"管理员类型","manager_type_order"=>"修改类型排序","manager_type_del"=>"删除类型","manager_type_new"=>"添加类型","manager_type_edit"=>"编辑类型")));//权限
$_A['list_name'] = "充值奖励规则管理";
$_A['list_menu'] = "<a href='{$_A['query_url']}{$_A['site_url']}'>规则列表</a> - <a href='{$_A['query_url']}/new{$_A['site_url']}'>增加规则</a>";
$list_table ="";

//liukun add for bug 52 begin
$firePHPEnable=TRUE;
if ($firePHPEnable){
	require_once('modules/FirePHPCore/FirePHP.class.php');
	require_once('modules/FirePHPCore/fb.php');
	ob_start();

	$firephp = FirePHP::getInstance(true);
}
//liukun add for bug 52 end

/**
 * 管理员列表
**/
if ($_A['query_type'] == "list"){
	$_A['list_title'] = "列表";
	if (isset($_POST['user_id']) && $_POST['user_id']!=""){
		userClass::ActionUser(array("user_id"=>$_POST['user_id'],"order"=>$_POST['order']));
		$msg = array("修改成功","",$_A['query_url'].$_A['query_site']);
	
	}else{
		$data['page'] = $_A['page'];
		$data['epage'] = $_A['epage'];
		$data['type'] = 1;
		
		global $mysql;
		
		$sql = "select * from  {recharge_award_rule}  order by id";
		$result = $mysql ->db_fetch_arrays($sql);
		
// 		$pages->set_data(array(
//             'list' => $list,
//             'total' => $result,
//             'page' => $page,
//             'epage' => $epage,
//             'total_page' => $total_page
//         ));
		
		$_A['rule_list'] = $result;
		//$_A['showpage'] = $pages->show(3);
	}
}

/**
 * 添加和编辑用户
**/
elseif ($_A['query_type'] == "new" || $_A['query_type'] == "edit"){
	if ($_A['query_type'] == "new" ){
		$_A['list_title'] = "添加规则";
	}else{
		$_A['list_title'] = "修改规则";
	}
	
	if (isset($_POST['award_rate'])){
		
			if ($_A['query_type'] == "new"){
				
				$min_account = $_POST['min_account'];
				$max_account = $_POST['max_account'];
				$award_rate = $_POST['award_rate'];
				$begin_time = strtotime($_POST['begin_time']." 00:00:00");
				$end_time = strtotime($_POST['end_time']." 23:59:59");
				
				
				$sql = "insert into  {recharge_award_rule}  set `min_account` = {$min_account}, `max_account` = {$max_account}, 
						`award_rate` = {$award_rate}, begin_time = '{$begin_time}', end_time = '{$end_time}'  ";
				
				//liukun add for bug 52 begin
				fb($begin_time, FirePHP::TRACE);
				fb($end_time, FirePHP::TRACE);
				fb($sql, FirePHP::TRACE);
				//liukun add for bug 52 end
				
				$result = $mysql ->db_query($sql);
				
				
					if ($result===true){
						$msg = array("增加充值奖励规则成功。");
					}else{
						$msg = array($result);
					}
					
				
			}else{
				$rule_id = $_REQUEST['rule_id'];
				
				$data['min_account'] = $_POST['min_account'];
				$data['max_account'] = $_POST['max_account'];
				$data['award_rate'] = $_POST['award_rate'];
				$data['begin_time'] = strtotime($_POST['begin_time']." 00:00:00");
				$data['end_time'] = strtotime($_POST['end_time']." 23:59:59");
				
				$sql = "update  {recharge_award_rule}  set `id` = {$rule_id}";
				foreach($data as $key => $value){
					$sql .= ",`$key` = '$value'";
				}
				$sql .= " where `id` = {$rule_id}";
				$result = $mysql->db_query($sql);
				if ($result===false){
					$msg = array($result);
				}else{
					$msg = array("修改成功");
				}
			}
		
	}else{
		
		if ($_A['query_type'] == "edit"){
			
			$rule_id = $_REQUEST['rule_id'];
			$sql = "select * from  {recharge_award_rule}  where id = {$rule_id}";
			$result = $mysql ->db_fetch_array($sql);
			//$result['begin_time']=substr($result['begin_time'], 0, 10); 
			//$result['end_time']=substr($result['end_time'], 0, 10); 
			
			$_A['rule_result'] = $result;
			
		}
	}
}


/**
 * 删除用户
**/
elseif ($_A['query_type'] == "del"){
	$rule_id = $_REQUEST['rule_id'];
	$sql = "delete  from  {recharge_award_rule}  where id = {$rule_id}";
	$result =  $mysql->db_query($sql);

	if ($result == false){
		$msg = array("输入有误，请跟管理员联系");
	}else{
		$msg = array("删除成功");
	}

	$user->add_log($_log,$result);//记录操作
}














?>