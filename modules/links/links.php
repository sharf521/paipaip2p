<?
if (!defined('ROOT_PATH'))  die('���ܷ���');//��ֱֹ�ӷ���
check_rank("links_".$_A['query_type']);//���Ȩ��

include_once("links.class.php");
include_once(ROOT_PATH."modules/subsite/subsite.class.php");

$_A['list_purview'] =  array("links"=>array("��������"=>array("links_list"=>"���������б�","links_new"=>"�������","links_del"=>"ɾ������","links_type"=>"��������")));//Ȩ��
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
	$result = linksClass::GetList($data);
	
	if (is_array($result)){
		$pages->set_data($result);
		$_A['links_list'] = $result['list'];
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
		if ($_REQUEST['del_id'] !=1){
			$mysql->db_delete("links_type","id=".$_REQUEST['del_id']);
			$msg = array("ɾ���ɹ�","",$_A['query_url']."/type");
		}else{
			$msg = array("����ID1Ϊϵͳ���ͣ�����ɾ��","",$_A['query_url']."/type");
		}
	}elseif (!isset($_POST['submit'])){
		$_A['links_type_list'] = linksClass::GetTypeList();
	}else{
		foreach ($_POST['id'] as $key => $val){
			$mysql->db_query("update {links_type} set typename='".$_POST['typename'][$key]."' where id=".$val);
		}
		if ($_POST['typename1']!=""){
			$index['typename'] = $_POST['typename1'];
			$mysql->db_add("links_type",$index,"notime");
		}
		$msg = array("���Ͳ����ɹ�","",$_A['query_url']."/type");
	}
}

/**
 * ���
**/
elseif ($_A['query_type'] == "new" || $_A['query_type'] == "edit" ){
	if (isset($_POST['type_id']) && $_POST['type_id']!=""){
		$var = array("type_id","status","order","url","logo","webname","summary","linkman","email", "areaid");
		foreach ( $var as $val){
			$data[$val] = !isset($_POST[$val])?"":$_POST[$val];
		}
		
		$_G['upimg']['file'] = "logoimg";
		$_G['upimg']['mask_status'] = 0;
		$pic_result = $upload->upfile($_G['upimg']);
		if ($pic_result!=""){
			$data['logoimg'] = $pic_result['filename'];
		}
		
		
		if ($_A['query_type'] != "new"){
			$data['id'] = $_POST['id'];
			$result = linksClass::Update($data);
		}else{
			$result = linksClass::Add($data);
		}
		if ($result == false){
			$msg = array("���������������Ա��ϵ");
		}else{
			$msg = array("�����ɹ�","������һҳ",$_A['query_url']);
		}
		$user->add_log($_log,$result);//��¼����
	
	
	}else{
		$_A['links_type_list'] = linksClass::GetTypeList();
		$_A['subsite_list'] = subsiteClass::GetSubsiteList();
		if ($_A['query_type'] == "edit"){
			$_A['links_result'] = linksClass::GetOne(array("id"=>$_REQUEST['id']));
		}
	}
}
	
	
/**
 * ɾ��
**/
elseif ($_A['query_type'] == "del"){
	$data['id'] = $_REQUEST['id'];
	$result = linksClass::Delete($data);
	if ($result !== true){
		$msg = array($result);
	}else{
		$msg = array("ɾ���ɹ�","������һҳ",$_A['query_url']);
	}
	$user->add_log($_log,$result);//��¼����
}


?>