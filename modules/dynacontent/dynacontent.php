<?
if (!defined('ROOT_PATH'))  die('���ܷ���');//��ֱֹ�ӷ���
check_rank("dynacontent_".$_A['query_type']);//���Ȩ��

include_once("dynacontent.class.php");
include_once(ROOT_PATH."modules/subsite/subsite.class.php");

$_A['list_purview'] =  array("dynacontent"=>array("��̬����"=>array("dynacontent_list"=>"�����б�","dynacontent_new"=>"�������","dynacontent_del"=>"ɾ������","dynacontent_type"=>"��������")));//Ȩ��
$_A['list_name'] = $_A['module_result']['name'];
$_A['list_menu'] = "<a href='{$_A['query_url']}{$_A['site_url']}'>�����б�</a> - <a href='{$_A['query_url']}/new{$_A['site_url']}'>�������</a> - <a href='{$_A['query_url']}/type{$_A['site_url']}'>��������</a>  ";

//������Ա�����ڵķ�վ��Ϣ����
$data['areaid'] = $_SESSION['areaid'];
/**
 * �������Ϊ�յĻ�����ʾ���е��ļ��б�
**/
if ($_A['query_type'] == "list"){
	$_A['list_title'] = "�����б�";
	
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
 * ��������
**/
elseif ($_A['query_type'] == "type"){
	if (isset($_REQUEST['del_id'])){
			$mysql->db_delete("dynacontent_type","id=".$_REQUEST['del_id']);
			$msg = array("ɾ���ɹ�","",$_A['query_url']."/type");
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
		$msg = array("���Ͳ����ɹ�","",$_A['query_url']."/type");
	}
}

/**
 * ���
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
			$msg = array("���������������Ա��ϵ");
		}else{
			$msg = array("�����ɹ�","������һҳ",$_A['query_url']);
		}
		$user->add_log($_log,$result);//��¼����
	
	
	}else{
		$_A['dynacontent_type_list'] = dynacontentClass::GetTypeList();
		$_A['subsite_list'] = subsiteClass::GetSubsiteList();
		if ($_A['query_type'] == "edit"){
			$_A['dynacontent_result'] = dynacontentClass::GetOne(array("id"=>$_REQUEST['id']));
		}
	}
}
	
	
/**
 * ɾ��
**/
elseif ($_A['query_type'] == "del"){
	$data['id'] = $_REQUEST['id'];
	$result = dynacontentClass::Delete($data);
	if ($result !== true){
		$msg = array($result);
	}else{
		$msg = array("ɾ���ɹ�","������һҳ",$_A['query_url']);
	}
	$user->add_log($_log,$result);//��¼����
}


?>