<?
if (!defined('ROOT_PATH'))  die('���ܷ���');//��ֱֹ�ӷ���
check_rank("area_list");//���Ȩ��

include_once("area.class.php");

$_A['list_purview'] =  array("area"=>array("����ģ��"=>array("area_list"=>"��������")));
$_A['list_name'] = $_A['module_result']['name'];
$_A['list_menu'] = "<a href='{$_A['query_url']}'>��������</a> - <a href='{$_A['query_url']}/data'>��������</a> - <a href='{$_A['query_url']}/cache'>���ݻ���</a>";
$_A['list_table'] = "";


/**
 * �������Ϊ�յĻ�����ʾ���е��ļ��б�
**/

if ($_A['query_type'] == "list" || $_A['query_type'] == "edit"){
	$_A['list_title'] = "ʡ��";
	$data['page'] = $_A['page'];
	$data['epage'] = 50;
	$data['pid'] = "0";
	if (isset($_REQUEST['action'])  ){
		if ($_REQUEST['action'] =="city"){
			$_A['list_title'] = "����";
			$data['pid'] = $_REQUEST['pid'];
		}elseif ($_REQUEST['action'] =="area"){
			$_A['list_title'] = "����";
			$data['pid'] = $_REQUEST['pid'];
		}
	}
	$result = areaClass::GetList($data);
	if (is_array($result)){
		$pages->set_data($result);
		$_A['area_list'] = $result['list'];
		$_A['showpage'] = $pages->show(3);
	}else{
		$msg = array($result);
	}
	
	if (isset($_POST['name']) && $_POST['name']!=""){
		$var = array("name","pid","nid","order");
		$data = post_var($var);
		if ($_A['query_type'] == "edit"){
			$data['id'] = $_POST['id'];
			$result = areaClass::Update($data);
		}else{
			$result = areaClass::Add($data);
		}
		if ($result !== true){
			$msg = array($result);
		}else{
			$msg = array("�����ɹ�");
		}
		
		$user->add_log($_log,$result);//��¼����
		
	}else{
		if ($_A['query_type'] == "edit"){
			$data['id'] = $_REQUEST['id'];
			$_A['area_result'] = areaClass::GetOne($data);
		}

	}
}


/**
 * ��������
**/
elseif ($_A['query_type'] == "data"){
	$sql = "select count(*) as num from {area} ";
	$result = $mysql->db_fetch_array($sql);
	if ($result['num']>0){
	$msg = array("�������Ѿ������ݣ����Ҫ���°�װ����ж�ش�ģ���ٰ�װ");
	}else{
	include("add_area.php");
	$msg = array("����ɹ�");
	}
}


/**
 * ɾ��
**/
elseif ($_A['query_type'] == "del"){
	$result = areaClass::Delete(array("id"=>$_REQUEST['id']));
	if ($result !== true){
		$msg = array($result);
	}else{
		$msg = array("ɾ���ɹ�");
	}
	$user->add_log($_log,$result);//��¼����
}


?>