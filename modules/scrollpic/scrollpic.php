<?
if (!defined('ROOT_PATH'))  die('���ܷ���');//��ֱֹ�ӷ���
check_rank("scrollpic_".$_A['query_type']);//���Ȩ��

include_once("scrollpic.class.php");
include_once(ROOT_PATH."modules/subsite/subsite.class.php");

$_A['list_purview'] =  array("scrollpic"=>array("����ͼƬ"=>array("scrollpic_list"=>"�б�","scrollpic_new"=>"���","scrollpic_del"=>"ɾ��","scrollpic_type"=>"����")));//Ȩ��
$_A['list_name'] = $_A['module_result']['name'];
$_A['list_menu'] = "<a href='{$_A['query_url']}{$_A['site_url']}'>�б�</a> - <a href='{$_A['query_url']}/new{$_A['site_url']}'>���</a> - <a href='{$_A['query_url']}/type{$_A['site_url']}'>����</a>  ";


/**
 * �������Ϊ�յĻ�����ʾ���е��ļ��б�
**/
if ($_A['query_type'] == "list"){
	$_A['list_title'] = "�б�";
	
	$data['page'] = $_A['page'];
	$data['epage'] = 20;
	$data['keywords'] = isset($_REQUEST['keywords'])?$_REQUEST['keywords']:"";
	$result = scrollpicClass::GetList($data);
	
	if (is_array($result)){
		$pages->set_data($result);
		$_A['scrollpic_list'] = $result['list'];
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
			$mysql->db_delete("scrollpic_type","id=".$_REQUEST['del_id']);
			$msg = array("ɾ���ɹ�","",$_A['query_url']."/type");
		}else{
			$msg = array("����ID1Ϊϵͳ���ͣ�����ɾ��","",$_A['query_url']."/type");
		}
	}elseif (!isset($_POST['submit'])){
		$_A['scrollpic_type_list'] = scrollpicClass::GetTypeList();
	}else{
		foreach ($_POST['id'] as $key => $val){
			$mysql->db_query("update {scrollpic_type} set typename='".$_POST['typename'][$key]."' where id=".$val);
		}
		if ($_POST['typename1']!=""){
			$index['typename'] = $_POST['typename1'];
			$mysql->db_add("scrollpic_type",$index,"notime");
		}
		$msg = array("���Ͳ����ɹ�","",$_A['query_url']."/type");
	}
}

/**
 * ���
**/
elseif ($_A['query_type'] == "new" || $_A['query_type'] == "edit" ){
	if (isset($_POST['type_id']) && $_POST['type_id']!=""){
		$var = array("type_id","status","order","url","name","summary","areaid");
		foreach ( $var as $val){
			$data[$val] = !isset($_POST[$val])?"":$_POST[$val];
		}
		
		$datapic['file'] = "pic";
		$datapic['code'] = "scrollpic";
		$datapic['user_id'] = $_G['user_id'];
		$datapic['type'] = "new";
		$datapic['aid'] = $data['type_id'];
		$pic_result = $upload->upfile($datapic);
		if ($pic_result!=""){
			$data['pic'] = $pic_result['filename'];
		}
		
		
		if ($_A['query_type'] != "new"){
			$data['id'] = $_POST['id'];
			$result = scrollpicClass::Update($data);
		}else{
			$result = scrollpicClass::Add($data);
		}
		if ($result == false){
			$msg = array("���������������Ա��ϵ");
		}else{
			$msg = array("�����ɹ�","������һҳ",$_A['query_url']);
		}
		$user->add_log($_log,$result);//��¼����
	
	
	}else{
		$_A['scrollpic_type_list'] = scrollpicClass::GetTypeList();
		$_A['subsite_list'] = subsiteClass::GetSubsiteList();
		if ($_A['query_type'] == "edit"){
			$_A['scrollpic_result'] = scrollpicClass::GetOne(array("id"=>$_REQUEST['id']));
		}
	}
}
	
	
/**
 * ɾ��
**/
elseif ($_A['query_type'] == "del"){
	$data['id'] = $_REQUEST['id'];
	$result = scrollpicClass::Delete($data);
	if ($result !== true){
		$msg = array($result);
	}else{
		$msg = array("ɾ���ɹ�","������һҳ",$_A['query_url']);
	}
	$user->add_log($_log,$result);//��¼����
}


?>