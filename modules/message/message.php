<?
if (!defined('ROOT_PATH'))  die('���ܷ���');//��ֱֹ�ӷ���
check_rank("message_".$_A['query_type']);//���Ȩ��

include_once("message.class.php");

$_A['list_purview'] =  array("message"=>array("����Ϣ����"=>array("message_list"=>"����Ϣ�б�","message_new"=>"��Ӷ���Ϣ","message_edit"=>"�༭����Ϣ","message_del"=>"ɾ������Ϣ","message_view"=>"��˶���Ϣ")));//Ȩ��
$_A['list_name'] = $_A['module_result']['name'];
$_A['list_menu'] = "<a href='{$_A['query_url']}{$_A['site_url']}'>����Ϣ�б�</a> - <a href='{$_A['query_url']}/new{$_A['site_url']}'>��Ӷ���Ϣ</a>  ";


/**
 * �������Ϊ�յĻ�����ʾ���е��ļ��б�
**/
if ($_A['query_type'] == "list"){
	$_A['list_title'] = "��Ϣ�б�";
	
	if (isset($_REQUEST['user_id'])){
		$data['user_id'] = $_REQUEST['user_id'];
	}
	
	if (isset($_REQUEST['username'])){
		$data['username'] = $_REQUEST['username'];
	}
	
	$data['page'] = $_A['page'];
	$data['epage'] = $_A['epage'];
	$result = messageClass::GetList($data);
	
	if (is_array($result)){
		$pages->set_data($result);
		$_A['message_list'] = $result['list'];
		$_A['showpage'] = $pages->show(3);
	
	}else{
		$msg = array($result);
	}
}

	
/**
 * ���
**/
elseif ($_A['query_type'] == "new"){
	
	$_A['list_title'] = "�������Ϣ";
	
	if (isset($_POST['content'])){
		$var = array("send_userid","receive_userid","type","content");
		$data = post_var($var);
		$data['status'] = 0;
		$result = messageClass::Add($data);
		
		if ($result !== true){
			$msg = array($result);
		}else{
			$msg = array("�����ɹ�");
		}
		$user->add_log($_log,$result);//��¼����
	}
	
}	

/**
 * �鿴
**/
elseif ($_A['query_type'] == "view"){
	$_A['list_title'] = "�鿴����Ϣ";
	if (isset($_POST['id'])){
		$var = array("id","status","verify_remark","jifen");
		$data = post_var($var);
		$data['verify_user'] = $_SESSION['user_id'];
		$result = messageClass::Update($data);
		
		if ($result !== true){
			$msg = array($result);
		}else{
			$msg = array("�����ɹ�");
		}
		$user->add_log($_log,$result);//��¼����
	}else{
		$data['id'] = $_REQUEST['id'];
		$data['user_id'] = $_REQUEST['user_id'];
		$_A['message_result'] = messageClass::GetOne($data);
	}
}


/**
 * ɾ��
**/
elseif ($_A['query_type'] == "del"){
	$data['id'] = $_REQUEST['id'];
	$result = messageClass::Delete($data);
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