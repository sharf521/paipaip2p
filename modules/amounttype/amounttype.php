<?
if (!defined('ROOT_PATH'))  die('不能访问');//防止直接访问
check_rank("manager_".$_A['query_type']);//检查权限

$_A['list_purview'] =  array("manager"=>array("管 理 员"=>array("manager_list"=>"管理员列表","manager_new"=>"添加管理员","manager_edit"=>"修改管理员","manager_type"=>"管理员类型","manager_type_order"=>"修改类型排序","manager_type_del"=>"删除类型","manager_type_new"=>"添加类型","manager_type_edit"=>"编辑类型")));//权限
$_A['list_name'] = "额度类型管理";
$_A['list_menu'] = "<a href='{$_A['query_url']}{$_A['site_url']}'>额度类型列表</a>";
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

	$sql = "select * from  {user_amount_type}  order by id";
	$result = $mysql ->db_fetch_arrays($sql);

	// 		$pages->set_data(array(
	//             'list' => $list,
	//             'total' => $result,
	//             'page' => $page,
	//             'epage' => $epage,
	//             'total_page' => $total_page
	//         ));

	$_A['amount_type_list'] = $result;
	//$_A['showpage'] = $pages->show(3);

}

/**
 * 添加和编辑用户
**/
elseif ($_A['query_type'] == "edit"){

	$_A['list_title'] = "修改额度类型";


	if (isset($_POST['type_id'])){

			
		$type_id = $_REQUEST['type_id'];

		$data['amount_type_name'] = $_POST['amount_type_name'];
		$data['fee_rate'] = $_POST['fee_rate'];
		$data['frost_rate'] = $_POST['frost_rate'];
			
		$data['show_name'] = $_POST['show_name'];

		$sql = "update  {user_amount_type}  set `id` = {$type_id}";
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
			$sql = "select * from  {user_amount_type}  where id = {$type_id}";
			$result = $mysql ->db_fetch_array($sql);
				
				
			$_A['amount_type_result'] = $result;
				
		}
	}
}

















?>