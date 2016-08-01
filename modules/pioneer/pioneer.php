<?
if (!defined('ROOT_PATH'))  die('不能访问');//防止直接访问
check_rank("liuyan_".$_A['query_type']);//检查权限

include_once("pioneer.class.php");

$_A['list_purview'] =  array("pioneer"=>array("申请管理"=>array("pioneer_list"=>"申请列表","pioneer_del"=>"删除申请")));//权限
$_A['list_name'] = $_A['module_result']['name'];
$_A['list_menu'] = "";


/**
 * 留言列表
**/
if ($_A['query_type'] == "list"){
	$_A['list_title'] = "申请列表";
	
	$data['page'] = $_A['page'];
	$data['epage'] = 20;
	$result = pioneerClass::GetList($data);
	
	if (is_array($result)){
		$pages->set_data($result);
		$_A['pioneer_list'] = $result['list'];
		$_A['showpage'] = $pages->show(3);
	
	}else{
		$msg = array($result);
	}
}

	





/**
**/
elseif ($_A['query_type'] == "del"){
	$data['id'] = $_REQUEST['id'];
	$result = pioneerClass::Delete($data);
	if ($result !== true){
		$msg = array($result);
	}else{
		$msg = array("删除成功");
	}
	$user->add_log($_log,$result);//记录操作
}



//防止乱操作
else{
	$msg = array("输入有误，请不要乱操作","",$url);
}
?>