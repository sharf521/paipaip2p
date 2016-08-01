<?
if (!defined('ROOT_PATH'))  die('不能访问');//防止直接访问
check_rank("dynacontent_".$_A['query_type']);//检查权限

include_once("dynacontent.class.php");
include_once(ROOT_PATH."modules/subsite/subsite.class.php");

$_A['list_purview'] =  array("dynacontent"=>array("动态内容"=>array("dynacontent_list"=>"内容列表","dynacontent_new"=>"添加内容","dynacontent_del"=>"删除内容","dynacontent_type"=>"内容类型")));//权限
$_A['list_name'] = $_A['module_result']['name'];
$_A['list_menu'] = "<a href='{$_A['query_url']}{$_A['site_url']}'>内容列表</a> - <a href='{$_A['query_url']}/new{$_A['site_url']}'>添加内容</a> - <a href='{$_A['query_url']}/type{$_A['site_url']}'>内容类型</a>  ";

//将管理员所属于的分站信息传入
$data['areaid'] = $_SESSION['areaid'];
/**
 * 如果类型为空的话则显示所有的文件列表
**/
if ($_A['query_type'] == "list"){
	$_A['list_title'] = "链接列表";
	
	$data['page'] = $_A['page'];
	$data['epage'] = 20;
	$data['keywords'] = isset($_REQUEST['keywords'])?$_REQUEST['keywords']:"";
	$result = dynacontentClass::GetList($data);
	
	if (is_array($result)){
		$pages->set_data($result);
		$_A['dynacontent_list'] = $result['list'];
		$_A['showpage'] = $pages->show(3);
	}else{
		$msg = array($result);
	}
}
	
	
/**
 * 链接类型
**/
elseif ($_A['query_type'] == "type"){
	if (isset($_REQUEST['del_id'])){
			$mysql->db_delete("dynacontent_type","id=".$_REQUEST['del_id']);
			$msg = array("删除成功","",$_A['query_url']."/type");
	}elseif (!isset($_POST['submit'])){
		$_A['links_type_list'] = dynacontentClass::GetTypeList();
	}else{
		foreach ($_POST['id'] as $key => $val){
			$mysql->db_query("update {dynacontent_type} set typename='".$_POST['typename'][$key]."' where id=".$val);
		}
		if ($_POST['typename1']!=""){
			$index['typename'] = $_POST['typename1'];
			$mysql->db_add("dynacontent_type",$index,"notime");
		}
		$msg = array("类型操作成功","",$_A['query_url']."/type");
	}
}

/**
 * 添加
**/
elseif ($_A['query_type'] == "new" || $_A['query_type'] == "edit" ){
	if (isset($_POST['type_id']) && $_POST['type_id']!=""){
		$var = array("type_id","order","webname","areaid", "content");
		foreach ( $var as $val){
			$data[$val] = !isset($_POST[$val])?"":$_POST[$val];
		}
		
		if ($_A['query_type'] != "new"){
			$data['id'] = $_POST['id'];
			$result = dynacontentClass::Update($data);
		}else{
			$result = dynacontentClass::Add($data);
		}
		if ($result == false){
			$msg = array("输入有误，请跟管理员联系");
		}else{
			$msg = array("操作成功","返回上一页",$_A['query_url']);
		}
		$user->add_log($_log,$result);//记录操作
	
	
	}else{
		$_A['dynacontent_type_list'] = dynacontentClass::GetTypeList();
		$_A['subsite_list'] = subsiteClass::GetSubsiteList();
		if ($_A['query_type'] == "edit"){
			$_A['dynacontent_result'] = dynacontentClass::GetOne(array("id"=>$_REQUEST['id']));
		}
	}
}
	
	
/**
 * 删除
**/
elseif ($_A['query_type'] == "del"){
	$data['id'] = $_REQUEST['id'];
	$result = dynacontentClass::Delete($data);
	if ($result !== true){
		$msg = array($result);
	}else{
		$msg = array("删除成功","返回上一页",$_A['query_url']);
	}
	$user->add_log($_log,$result);//记录操作
}


?>