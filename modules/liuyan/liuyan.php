<?
if (!defined('ROOT_PATH'))  die('���ܷ���');//��ֱֹ�ӷ���
check_rank("liuyan_".$_A['query_type']);//���Ȩ��

include_once("liuyan.class.php");

$_A['list_purview'] =  array("liuyan"=>array("���Թ���"=>array("liuyan_list"=>"�û��б�","liuyan_reply"=>"�ظ�����","liuyan_set"=>"��������","liuyan_new"=>"�������","liuyan_edit"=>"�޸�����")));//Ȩ��
$_A['list_name'] = $_A['module_result']['name'];
$_A['list_menu'] = "<a href='{$_A['query_url']}/new{$site_url}'>�������</a> - <a href='{$_A['query_url']}{$site_url}'>�����б�</a> - <a href='{$_A['query_url']}/set{$site_url}'>��������</a> ";


/**
 * �����б�
**/
if ($_A['query_type'] == "list"){
	$_A['list_title'] = "�����б�";
	
	$data['page'] = $_A['page'];
	$data['epage'] = 20;
	$result = liuyanClass::GetList($data);
	
	if (is_array($result)){
		$pages->set_data($result);
		$_A['liuyan_list'] = $result['list'];
		$_A['showpage'] = $pages->show(3);
	
	}else{
		$msg = array($result);
	}
}

	
/**
 * ���
**/
elseif ($_A['query_type'] == "new"  || $_A['query_type'] == "edit" ){
	
	$_A['list_title'] = "�б�";
	
	if (isset($_POST['title'])){
		$var = array("title","name","email","tel","fax","company","address","type","status","content");
		$data = post_var($var);
		$data['user_id'] = $_G['user_id'];
		$_G['upimg']['file'] = "litpic";
		$pic_result = $upload->upfile($_G['upimg']);
		if ($pic_result!=""){
			$data['litpic'] = $pic_result;
		}
		
		if ($_A['query_type'] != "new"){
			$data['id'] = $_POST['id'];
			$result = liuyanClass::Update($data);
		}else{
			$result = liuyanClass::Add($data);
		}
		
		if ($result !== true){
			$msg = array($result);
		}else{
			$msg = array("�����ɹ�","",$_A['query_url']);
		}
		$user->add_log($_log,$result);//��¼����
	}
	
	else{
		$result = liuyanClass::GetSet();
		if ($result!=false){
			$_A['liuyan_type_list'] = explode("|",$result['type']);
		
			if ($_A['query_type'] == "edit"){
				$data['id'] = $_REQUEST['id'];
				$_A['liuyan_result'] = liuyanClass::GetOne($data);
				
			}
		}
	}

	
	
}	


/**
 * �鿴
**/
elseif ($_A['query_type'] == "view"){
	$data['id'] = $_REQUEST['id'];
	if (isset($_POST['reply'])){
		$data['reply'] = nl2br($_POST['reply']);
		$data['replytime'] = time(); 
		$data['replyip'] = ip_address(); 
		$result = liuyanClass::Update($data);
		$msg = array("�ظ��ɹ�");
	}else{
		$_A['liuyan_result'] = liuyanClass::GetOne($data);
	}
}


/**
**/
elseif ($_A['query_type'] == "del"){
	$data['id'] = $_REQUEST['id'];
	$result = liuyanClass::Delete($data);
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
elseif ($_A['query_type'] == "set"){
	if (isset($_POST['type'])){
		$result = liuyanClass::ActionSet($_POST);
		if ($result !== true){
			$msg = array($result);
		}else{
			$msg = array("���óɹ�");
		}
	}else{
		$_A['liuyan_set'] = liuyanClass::GetSet();
	}
}

//��ֹ�Ҳ���
else{
	$msg = array("���������벻Ҫ�Ҳ���","",$url);
}
?>