<?
if (!defined('ROOT_PATH'))  die('不能访问');//防止直接访问
check_rank("payment_".$_A['query_type']);//检查权限

require_once 'payment.class.php';
include_once(ROOT_PATH."modules/subsite/subsite.class.php");

$_A['subsite_list'] = subsiteClass::GetSubsiteList();
foreach($_A['subsite_list'] as $subsite)
{
	$_A['subsitenamelist'][$subsite['id']]=$subsite['sitename'];
}


$_A['list_purview'] = array("payment"=>array("支付方式"=>array("payment_list"=>"支付方式管理")));//权限
$_A['list_name'] = $_A['module_result']['name'];
$_A['list_menu'] = "<a href='{$_A['query_url']}{$_A['site_url']}'>已使用</a> - <a href='{$_A['query_url']}/all{$_A['site_url']}'>支付列表</a> ";


//将管理员所属于的分站信息传入
$data['areaid'] = $_SESSION['areaid'];
$_A['areaid'] =  $_SESSION['areaid'];
$_A['admin_type_id'] =  $_SESSION['type_id'];

/**
 * 如果类型为空的话则显示所有的文件列表
**/
if ($_A['query_type'] == "list"){
	$_A['list_title'] = "列表";
	//修改状态
	if (isset($_REQUEST['id']) && isset($_REQUEST['status'])){
		$sql = "update {payment} set status='".$_REQUEST['status']."' where id = ".$_REQUEST['id'];
		$mysql->db_query($sql);	
	}
	
	$result = paymentClass::GetList();
	
	
	foreach($result as $i=>$row)
	{
		$result[$i]['sitename']=$_A['subsitenamelist'][$row['areaid']];
	}
	
	if (is_array($result)){
		$_A['payment_list'] = $result;
	}else{
		$msg = array($result);
	}
}


/**
 * 如果类型为空的话则显示所有的文件列表
**/
elseif ($_A['query_type'] == "all"){
	$_A['list_title'] = "所有的支付列表";
	//修改状态
	
	$result = paymentClass::GetListAll();
	

	if (is_array($result)){
		$_A['payment_list'] = $result;
	}else{
		$msg = array($result);
	}
}
/**
 * 添加
**/
elseif ($_A['query_type'] == "new"  || $_A['query_type'] == "edit" || $_A['query_type'] == "start" ){
	
	$_A['list_title'] = "管理活动";
	
	if (isset($_POST['name'])){
		$var = array("name","nid","order","status","description","fee_type","max_fee","max_money","areaid");
		$data = post_var($var);
		$config = isset($_POST['config'])?$_POST['config']:"";
		$data['config'] = serialize($config);
		$data['type'] = $_A['query_type'];
		if ($_A['query_type'] == "edit"){
			$data['id'] = isset($_POST['id'])?$_POST['id']:"";
		}
		$data['areaid']=(int)$data['areaid'];
		$result = paymentClass::Action($data);
		
		
		if ($result !== true){
			$msg = array($result);
		}else{
			$msg = array("操作成功","",$_A['query_url']);
		}
		$user->add_log($_log,$result);//记录操作
	}
	
	elseif ($_A['query_type'] == "edit" || $_A['query_type'] == "new" || $_A['query_type'] == "start" ){
		$data['nid'] = $_REQUEST['nid'];
		$data['id'] = isset($_REQUEST['id'])?$_REQUEST['id']:"";
	
		$result = paymentClass::GetOne($data);
		if (is_array($result)){
			$result['nid'] = $data['nid'];
			$_A['payment_result'] = $result;
			
		}else{
			$msg = array($result);
		}
		
	}
	
}			

	
/**
 * 删除
**/
elseif ($_A['query_type'] == "del"){
	$data['id'] = $_REQUEST['id'];
	$result = paymentClass::Delete($data);
	if ($result !== true){
		$msg = array($result);
	}else{
		$msg = array("删除成功","",$_A['query_url']);
	}
	$user->add_log($_log,$result);//记录操作
}
	
?>