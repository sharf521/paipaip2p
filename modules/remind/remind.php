<?
if (!defined('ROOT_PATH'))  die('���ܷ���');//��ֱֹ�ӷ���
check_rank("remind_list");//���Ȩ��


include_once("remind.class.php");

$_A['list_purview'] =   array("remind"=>array("��������"=>array("remind_list"=>"���ѹ���")));//Ȩ��
$_A['list_name'] = $_A['module_result']['name'];
$_A['list_menu'] = "<a href='{$_A['query_url']}{$_A['site_url']}'>��������</a>  -  <a href='{$_A['query_url']}/type_new{$_A['site_url']}'>�������</a>";
$_A['list_table'] = "";


	
/**
 * �������Ϊ�յĻ�����ʾ���е��ļ��б�
**/
if ($_A['query_type'] == "list"){
	$data['page'] = $_A['page'];
	$data['epage'] = 20;

	$result = remindClass::GetTypeList($data);
	if (is_array($result)){
		$pages->set_data($result);
		$_A['remind_list'] = $result['list'];
		$_A['showpage'] = $pages->show(3);
	}else{
		$msg = array($result);
	}
}


/**
 * ���
**/
elseif ($_A['query_type'] == "new"){
	if (isset($_POST['name'])){
		$var = array("name","nid","type_id","order","message","phone","email");
		$data = post_var($var);
		$result = remindClass::Add($data);
		if ($result !== true){
			$msg = array($result);
		}else{
			$msg = array("�����ɹ�");
		}
		$user->add_log($_log,$result);//��¼����
	}else{
		$data['limit'] = "all";
		$data['id'] = $_REQUEST['id'];
		$_A['remind_type_result'] =remindClass::GetTypeOne($data);
		if (is_array($_A['remind_type_result'])){
			$data['type_id'] = $_REQUEST['id'];
			$_A['remind_list'] = remindClass::GetList($data);
		}else{
			$msg = array($result);
		}
		$pname = empty($pname)?"��������":$pname;
		$magic->assign("pname",$pname);
	}
}


/**
 * ����
**/
elseif ($_A['query_type'] == "actions"){
	if (isset($_POST['id'])){
		$data['id'] = $_POST['id'];
		$data['name'] = $_POST['name'];
		$data['nid'] = $_POST['nid'];
		$data['order'] = $_POST['order'];$data['order'] = $_POST['order'];
		$data['message'] = $_POST['message'];
		$data['phone'] = $_POST['phone'];
		$data['email'] = $_POST['email'];
		$result = remindClass::Action($data);
		if ($result !== true){
			$msg = array($result);
		}else{
			$msg = array("�����ɹ�");
		}
	}else{
		//���
		if (isset($_POST['name'])){
			$data['type'] = "add";
			$data['name'] = $_POST['name'];
			$data['nid'] = $_POST['nid'];
			$data['type_id'] = $_POST['type_id'];
			$data['order'] = $_POST['order'];
			$data['message'] = $_POST['message'];
			$data['phone'] = $_POST['phone'];
			$data['email'] = $_POST['email'];
			$result = remindClass::Action($data);
			if ($result !== true){
				$msg = array($result);
			}else{
				$msg = array("�����ɹ�");
			}
		}else{
			$msg = array("��������");
		}
	}
}
/**
 * ɾ��
**/
elseif ($_A['query_type'] == "del"){
	$id = $_REQUEST['id'];
	$result = remindClass::Delete(array("id"=>$id));
	if ($result !== true){
		$msg = array($result);
	}else{
		$msg = array("ɾ���ɹ�");
	}
	$user->add_log($_log,$result);//��¼����
}

/**
 * ��������
**/
elseif ($_A['query_type'] == "type_new" || $_A['query_type'] == "type_edit"){
	if (isset($_POST['name'])){
		$var = array("name","nid","order");
		$data = post_var($var);
		if ($_A['query_type'] == "type_new"){
			$result = remindClass::AddType($data);
			if ($result !== true){
				$msg = array($result);
			}else{
				$msg = array("��ӳɹ�");
			}
		}else{
			$data['id'] = $_POST['id'];
			$result = remindClass::UpdateType($data);
			if ($result !== true){
				$msg = array($result);
			}else{
				$msg = array("��ӳɹ�");
			}
		}
		$user->add_log($_log,$result);//��¼����
	}elseif( $_A['query_type'] == "type_edit"){
		$data['id'] = $_REQUEST['id'];
		$_A['remind_type_result'] = remindClass::GetTypeOne($data);
	}
}

/**
 * ɾ��
**/
elseif ($_A['query_type'] == "type_del"){
	$result = LremindClass::DeleteType($_REQUEST['id']);
	if ($result !== true){
		$msg = array($result);
	}else{
		$msg = array("ɾ���ɹ�");
	}
	$user->add_log($_log,$result);//��¼����
}
/**
 * ��������
**/
elseif ($_A['query_type'] == "type_action"){
	if (isset($_POST['id'])){
		$data['id'] = $_POST['id'];
		$data['name'] = $_POST['name'];
		$data['nid'] = $_POST['nid'];
		$data['order'] = $_POST['order'];
		$result = remindClass::ActionType($data);
		if ($result !== true){
			$msg = array($result);
		}else{
			$msg = array("�����ɹ�");
		}
	}else{
		if (isset($_POST['name'])){
			$data['type'] = $_POST['type'];
			$data['name'] = $_POST['name'];
			$data['nid'] = $_POST['nid'];
			$data['order'] = $_POST['order'];
			$result = remindClass::ActionType($data);
			if ($result !== true){
				$msg = array($result);
			}else{
				$msg = array("�����ɹ�");
			}
		}else{
			$msg = array("��������");
		}
	}
}

//��ֹ�Ҳ���
else{
	$msg = array("���������벻Ҫ�Ҳ���","",$url);
}


?>