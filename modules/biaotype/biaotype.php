<?
if (!defined('ROOT_PATH'))  die('不能访问');//防止直接访问
check_rank("manager_".$_A['query_type']);//检查权限

$_A['list_purview'] = array("manager"=>array("管 理 员"=>array("manager_list"=>"管理员列表","manager_new"=>"添加管理员","manager_edit"=>"修改管理员","manager_type"=>"管理员类型","manager_type_order"=>"修改类型排序","manager_type_del"=>"删除类型","manager_type_new"=>"添加类型","manager_type_edit"=>"编辑类型")));//权限
$_A['list_name'] = "标种管理";
$_A['list_menu'] = "<a href='{$_A['query_url']}{$_A['site_url']}'>标种列表</a>";
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
	
		$data['page'] = $_A['page'];
		$data['epage'] = $_A['epage'];
		$data['type'] = 1;
		
		global $mysql;
		
		$sql = "select * from  {biao_type}  order by id";
		$result = $mysql ->db_fetch_arrays($sql);
		
// 		$pages->set_data(array(
//             'list' => $list,
//             'total' => $result,
//             'page' => $page,
//             'epage' => $epage,
//             'total_page' => $total_page
//         ));
		
		$_A['biao_type_list'] = $result;
		//$_A['showpage'] = $pages->show(3);
	
}

/**
 * 添加和编辑用户
**/
elseif ($_A['query_type'] == "edit"){

	$_A['list_title'] = "修改标种";


	if (isset($_POST['type_id'])){
			
		$type_id = $_REQUEST['type_id'];
		
		$data['biao_type_name'] = $_POST['biao_type_name'];
		$data['available'] = $_POST['available'];
		$data['password_model'] = $_POST['password_model'];
		$data['happy_model'] = $_POST['happy_model'];
		$data['day_model'] = $_POST['day_model'];
		$data['auto_verify'] = $_POST['auto_verify'];
		$data['auto_full_verify'] = $_POST['auto_full_verify'];
		$data['min_amount'] = $_POST['min_amount'];
		$data['max_amount'] = $_POST['max_amount'];
		$data['min_interest_rate'] = $_POST['min_interest_rate'];
		$data['max_interest_rate'] = $_POST['max_interest_rate'];
		$data['advance_time'] = $_POST['advance_time'];
		$data['advance_scope'] = $_POST['advance_scope'];
		$data['advance_vip_scope'] = $_POST['advance_vip_scope'];
		$data['late_interest_rate'] = $_POST['late_interest_rate'];
		$data['borrow_fee_rate_start'] = $_POST['borrow_fee_rate_start'];
		$data['borrow_fee_rate_start_month_num'] = $_POST['borrow_fee_rate_start_month_num'];
		$data['borrow_fee_rate'] = $_POST['borrow_fee_rate'];
		$data['borrow_day_fee_rate'] = $_POST['borrow_day_fee_rate'];
		$data['interest_fee_rate'] = $_POST['interest_fee_rate'];
		$data['frost_rate'] = $_POST['frost_rate'];
		$data['advance_rate'] = $_POST['advance_rate'];
		$data['advance_vip_rate'] = $_POST['advance_vip_rate'];
		$data['late_customer_interest_rate'] = $_POST['late_customer_interest_rate'];
		$data['max_tender_times'] = $_POST['max_tender_times'];
		$data['show_name'] = $_POST['show_name'];
		$data['can_pay_insurance'] = $_POST['can_pay_insurance'];
		$data['min_insurance_rate'] = $_POST['min_insurance_rate'];
		$data['max_insurance_rate'] = $_POST['max_insurance_rate'];
		
		$data['type_desc'] = $_POST['type_desc'];
		$data['tender_collection_limit_amount'] = $_POST['tender_collection_limit_amount'];
		$data['tender_ip_limit_nums'] = $_POST['tender_ip_limit_nums'];
		$data['tender_ip_limit_minutes'] = $_POST['tender_ip_limit_minutes'];
		
		$data['repay_month'] = $_POST['repay_month'];
		$data['repay_monthinterest'] = $_POST['repay_monthinterest'];
		$data['repay_total'] = $_POST['repay_total'];
		$data['repay_monthearly'] = $_POST['repay_monthearly'];
		
		$data['biao_real_status'] = $_POST['biao_real_status'];
		$data['biao_email_status'] = $_POST['biao_email_status'];
		$data['biao_phone_status'] = $_POST['biao_phone_status'];
		$data['biao_video_status'] = $_POST['biao_video_status'];
		$data['biao_scene_status'] = $_POST['biao_scene_status'];
		$data['biao_credit_status'] = $_POST['biao_credit_status'];
		$data['biao_avatar_status'] = $_POST['biao_avatar_status'];
		$data['biao_vip_status'] = $_POST['biao_vip_status'];
		
		$data['type_desc_url'] = $_POST['type_desc_url'];

		$sql = "update  {biao_type}  set `id` = {$type_id}";
		foreach($data as $key => $value){
			$sql .= ",`$key` = '$value'";
		}
		$sql .= " where `id` = {$type_id}";
		$result = $mysql->db_query($sql);
		if ($result===false){
			$msg = array($result);
		}else{
			$msg = array("修改成功");
		}
			

	}else{

		if ($_A['query_type'] == "edit"){
				
			$type_id = $_REQUEST['type_id'];
			$sql = "select * from  {biao_type}  where id = {$type_id}";
			$result = $mysql ->db_fetch_array($sql);
				
			$_A['biao_type_result'] = $result;
				
		}
	}
}
















?>