<?
if (!defined('ROOT_PATH'))  die('���ܷ���');//��ֱֹ�ӷ���
check_rank("liuyan_".$_A['query_type']);//���Ȩ��

include_once("pioneer.class.php");

$_A['list_purview'] =  array("pioneer"=>array("�������"=>array("pioneer_list"=>"�����б�","pioneer_del"=>"ɾ������")));//Ȩ��
$_A['list_name'] = $_A['module_result']['name'];
$_A['list_menu'] = "";


/**
 * �����б�
**/
if ($_A['query_type'] == "list"){
	$_A['list_title'] = "�����б�";
	
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
		$msg = array("ɾ���ɹ�");
	}
	$user->add_log($_log,$result);//��¼����
}



//��ֹ�Ҳ���
else{
	$msg = array("���������벻Ҫ�Ҳ���","",$url);
}
?>