<?
if (!defined('ROOT_PATH'))  die('���ܷ���');//��ֱֹ�ӷ���
check_rank("borrowunion_".$_A['query_type']);//���Ȩ��

include_once("borrowunion.class.php");

$_A['list_purview'] =  array("borrowunion"=>array("�ڴ�����"=>array("borrowunion_list"=>"�����б�","borrowunion_new"=>"��ӻ���","borrowunion_edit"=>"�༭����","borrowunion_del"=>"ɾ������","borrowunion_view"=>"��˻���")));//Ȩ��
$_A['list_name'] = $_A['module_result']['name'];
$_A['list_menu'] = "<a href='{$_A['query_url']}{$_A['site_url']}'>�����б�</a>";


/**
 * �������Ϊ�յĻ�����ʾ���е��ļ��б�
**/
if ($_A['query_type'] == "list"){
	$_A['list_title'] = "�����б�";
	
	if (isset($_REQUEST['user_id'])){
		$data['user_id'] = $_REQUEST['user_id'];
	}
	
	if (isset($_REQUEST['username'])){
		$data['username'] = $_REQUEST['username'];
	}
	
	$data['page'] = $_A['page'];
	$data['epage'] = $_A['epage'];
	$result = borrowunionClass::GetList($data);
	
	if (is_array($result)){
		$pages->set_data($result);
		$_A['borrowunion_list'] = $result['list'];
		$_A['showpage'] = $pages->show(3);
	
	}else{
		$msg = array($result);
	}
}



/**
 * ���
**/
elseif ($_A['query_type'] == "edit" ){
	
	$_A['list_title'] = "������Ϣ";
	
	if (isset($_POST['name'])){
		$var = array("user_id","name","status","range","content");
		$data = post_var($var);
		if (isset($_POST['status'])){
			$data['verify_time'] = time();
			$data['status'] = $_POST['status'];
			$data['verify_remark'] = nl2br($_POST['verify_remark']);
		}
		$result = borrowunionClass::Action($data);
		
		
		if ($result !== true){
			$msg = array($result);
		}else{
			$msg = array("�����ɹ�","",$_A['query_url']);
		}
		$user->add_log($_log,$result);//��¼����
	}
	
	elseif ($_A['query_type'] == "edit" ){
		$data['user_id'] = $_REQUEST['user_id'];
		$data['id'] = $_REQUEST['id'];
		$result = borrowunionClass::GetOne($data);
		
		if (is_array($result)){
			$_A['borrowunion_result'] = $result;
		}else{
			$msg = array($result);
		}
		
	}

	
	elseif(isset($_REQUEST['user_id']) && !isset($_POST['username'])){
		$data['user_id'] = $_REQUEST['user_id'];
		$result = userClass::GetOne($data);
		if ($result==false){
			$msg = array("������������","",$_A['query_url']);
		}else{
			$_A['user_result'] = $result;
			//$result = borrowunionClass::GetOne($data);
			//$_A['borrowunion_result'] = $result;
		}
		
	}
	
}	

/**
 * �鿴
**/
elseif ($_A['query_type'] == "view"){
	$_A['list_title'] = "�鿴��֤";
	if (isset($_POST['id'])){
		$var = array("id","status","verify_remark");
		$data = post_var($var);
		
		$data['verify_user'] = $_G['user_id'];
		$data['verify_time'] = time();
		$result = borrowunionClass::Verify($data);
		
		if ($result ==false){
			$msg = array($result);
		}else{
			$msg = array("�����ɹ�");
		}
		$user->add_log($_log,$result);//��¼����
	}else{
		$data['id'] = $_REQUEST['id'];
		$data['user_id'] = $_REQUEST['user_id'];
		$_A['borrowunion_result'] = borrowunionClass::GetOne($data);
	}
}


/**
 * ɾ��
**/
elseif ($_A['query_type'] == "del"){
	$data['id'] = $_REQUEST['id'];
	$result = borrowunionClass::Delete($data);
	if ($result !== true){
		$msg = array($result);
	}else{
		$msg = array("ɾ���ɹ�");
	}
	$user->add_log($_log,$result);//��¼����
}




//��ֹ�Ҳ���
else{
	$msg = array("���������벻Ҫ�Ҳ���");
}
?>