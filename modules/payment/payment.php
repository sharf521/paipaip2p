<?
if (!defined('ROOT_PATH'))  die('���ܷ���');//��ֱֹ�ӷ���
check_rank("payment_".$_A['query_type']);//���Ȩ��

require_once 'payment.class.php';
include_once(ROOT_PATH."modules/subsite/subsite.class.php");

$_A['subsite_list'] = subsiteClass::GetSubsiteList();
foreach($_A['subsite_list'] as $subsite)
{
	$_A['subsitenamelist'][$subsite['id']]=$subsite['sitename'];
}


$_A['list_purview'] = array("payment"=>array("֧����ʽ"=>array("payment_list"=>"֧����ʽ����")));//Ȩ��
$_A['list_name'] = $_A['module_result']['name'];
$_A['list_menu'] = "<a href='{$_A['query_url']}{$_A['site_url']}'>��ʹ��</a> - <a href='{$_A['query_url']}/all{$_A['site_url']}'>֧���б�</a> ";


//������Ա�����ڵķ�վ��Ϣ����
$data['areaid'] = $_SESSION['areaid'];
$_A['areaid'] =  $_SESSION['areaid'];
$_A['admin_type_id'] =  $_SESSION['type_id'];

/**
 * �������Ϊ�յĻ�����ʾ���е��ļ��б�
**/
if ($_A['query_type'] == "list"){
	$_A['list_title'] = "�б�";
	//�޸�״̬
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
 * �������Ϊ�յĻ�����ʾ���е��ļ��б�
**/
elseif ($_A['query_type'] == "all"){
	$_A['list_title'] = "���е�֧���б�";
	//�޸�״̬
	
	$result = paymentClass::GetListAll();
	

	if (is_array($result)){
		$_A['payment_list'] = $result;
	}else{
		$msg = array($result);
	}
}
/**
 * ���
**/
elseif ($_A['query_type'] == "new"  || $_A['query_type'] == "edit" || $_A['query_type'] == "start" ){
	
	$_A['list_title'] = "����";
	
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
			$msg = array("�����ɹ�","",$_A['query_url']);
		}
		$user->add_log($_log,$result);//��¼����
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
 * ɾ��
**/
elseif ($_A['query_type'] == "del"){
	$data['id'] = $_REQUEST['id'];
	$result = paymentClass::Delete($data);
	if ($result !== true){
		$msg = array($result);
	}else{
		$msg = array("ɾ���ɹ�","",$_A['query_url']);
	}
	$user->add_log($_log,$result);//��¼����
}
	
?>