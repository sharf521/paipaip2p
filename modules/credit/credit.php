<?
if (!defined('ROOT_PATH'))  die('���ܷ���');//��ֱֹ�ӷ���
check_rank("credit_".$_A['query_type']);//���Ȩ��

include_once("credit.class.php");

$_A['list_purview'] =  array("credit"=>array("�������͹���"=>array("credit_list"=>"�鿴�û�����","credit_log"=>"�鿴������ϸ","credit_type_list"=>"���������б�","credit_type_new"=>"��ӻ�������","credit_type_edit"=>"�༭��������","credit_type_del"=>"ɾ����������")));//Ȩ��
$_A['list_name'] = $_A['module_result']['name'];
$_A['list_menu'] = "<a href='{$_A['query_url']}{$_A['site_url']}'>�û�����</a> - <a href='{$_A['query_url']}/rank{$_A['site_url']}'>�ȼ�����</a> - <a href='{$_A['query_url']}/type{$_A['site_url']}'>���������б�</a>";

//������Ա�����ڵķ�վ��Ϣ����
$data['areaid'] = $_SESSION['areaid'];
$_A['areaid'] =  $_SESSION['areaid'];
if ($_A['query_type'] == "list"){
	$_A['list_title'] = "�û������б�";
	
	if (isset($_REQUEST['username'])){
		$data['username'] = $_REQUEST['username'];
	}
	$data['page'] = $_A['page'];
	$data['epage'] = $_A['epage'];
	$result = creditClass::GetList($data);
	if (is_array($result)){
		$pages->set_data($result);
		$_A['credit_list'] = $result['list'];
		$_A['showpage'] = $pages->show(3);
	
	}else{
		$msg = array($result);
	}
}

elseif ($_A['query_type'] == "log"){

	$_A['list_title'] = "�û�������ϸ";
	
	if (isset($_REQUEST['user_id'])){
		$data['user_id'] = $_REQUEST['user_id'];
	}
	$data['page'] = $_A['page'];
	$result = creditClass::GetLogList($data);
	
	if (is_array($result)){
		$pages->set_data($result);
		$_A['credit_list'] = $result['list'];
		$_A['showpage'] = $pages->show(3);
	
	}else{
		$msg = array($result);
	}
}

elseif ($_A['query_type'] == "rank"){
	$_A['list_title'] = "���ֵȼ�";
	if (isset($_POST['name']) && $_POST['name']!=""){
		$data['name'] = $_POST['name'];
		$data['id'] = $_POST['id'];
		$data['rank'] = $_POST['rank'];
		$data['point1'] = $_POST['point1'];
		$data['point2'] = $_POST['point2'];
		$data['pic'] = $_POST['pic'];
		$result = creditClass::ActionRank($data);
		$msg = array("�����ɹ�","",$_A['query_url']);
	}else{
		$result = creditClass::GetRankList($data);
		$_A['credit_rank_list'] = $result;
	}
	
}
elseif ($_A['query_type'] == "rank_new"){
	if (isset($_POST['name']) && $_POST['name']!=""){
		$var = array("name","rank","point1","point2","pic");
		$data = post_var($var);
		$result = creditClass::AddRank($data);
		$msg = array("��ӳɹ�");
	}else{
		$msg = array("��������");
	}
}

/**
 * ɾ��
**/
elseif ($_A['query_type'] == "rank_del"){
	$data['id'] = $_REQUEST['id'];
	$result = creditClass::DeleteRank($data);
	if ($result !== true){
		$msg = array($result);
	}else{
		$msg = array("ɾ���ɹ�");
	}
	$user->add_log($_log,$result);//��¼����
}
/**
 * �������Ϊ�յĻ�����ʾ���е��ļ��б�
**/
elseif ($_A['query_type'] == "type" ){
	$_A['list_title'] = "�����б�";
	
	if (isset($_REQUEST['keywords'])){
		$data['name'] = $_REQUEST['keywords'];
	}
	
	$data['page'] = $_A['page'];
	$data['epage'] = $_A['epage'];
	$result = creditClass::GetTypeList($data);
	
	if (is_array($result)){
		$pages->set_data($result);
		$_A['credit_type_list'] = $result['list'];
		$_A['showpage'] = $pages->show(3);
	
	}else{
		$msg = array($result);
	}
}

/**
 * ���
**/
elseif ($_A['query_type'] == "type_new" || $_A['query_type'] == "type_edit" ){	
	if ($_A['query_type'] == "type_new"){
		$_A['list_title'] = "��ӻ�������";
	}else{
		$_A['list_title'] = "�޸Ļ�������";
	}
	
	if (isset($_POST['name'])){
		$var = array("nid","name","value","cycle","award_times","interval","remark");
		$data = post_var($var);
		
		if ($_A['query_type'] == "type_new"){
			$result = creditClass::AddType($data);
		}else{
			$data['id'] = $_POST['id'];
			$result = creditClass::UpdateType($data);
		}
		
		if ($result !== true){
			$msg = array($result);
		}else{
			$msg = array("�����ɹ�","",$_A['query_url']."/type");
		}
		$user->add_log($_log,$result);//��¼����
	}elseif ($_A['query_type'] == "type_edit" ){
		$data['id'] = $_REQUEST['id'];
		$result = creditClass::GetTypeOne($data);
		if (is_array($result)){
			$_A['credit_type_result'] = $result;
		}else{
			$msg = array($result);
		}
		
	}
}


/**
 * ɾ��
**/
elseif ($_A['query_type'] == "type_del"){
	$data['id'] = $_REQUEST['id'];
	$result = creditClass::DeleteType($data);
	if ($result !== true){
		$msg = array($result);
	}else{
		$msg = array("ɾ���ɹ�","",$_A['query_url']."/type");
	}
	$user->add_log($_log,$result);//��¼����
}

//��ֹ�Ҳ���
else{
	$msg = array("���������벻Ҫ�Ҳ���","",$url);
}

?>