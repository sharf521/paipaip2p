<?
if (!defined('ROOT_PATH'))  die('���ܷ���');//��ֱֹ�ӷ���
check_rank("lianmeng_".$_t);//���Ȩ��

require_once 'lianmeng.class.php';


$_A['list_purview'] = array("lianmeng"=>array("���˳�Ա"=>array("lianmeng_list"=>"��Ա�б�","lianmeng_new"=>"��ӳ�Ա","lianmeng_del"=>"ɾ����Ա")));//Ȩ��
$_A['list_name'] = $_A['module_result']['name'];
$_A['list_menu'] = "<a href='{$_A['query_url']}/new{$_A['site_url']}'>��ӳ�Ա</a> - <a href='{$_A['query_url']}{$_A['site_url']}'>���˳�Ա�б�</a> ";


/**
 * �������Ϊ�յĻ�����ʾ���е��ļ��б�
**/
if ($_A['query_type'] == "list"){
	$_A['list_title'] = "�б�";
	//�޸�״̬
	if (isset($_REQUEST['id']) && isset($_REQUEST['status'])){
		$sql = "update {lianmeng} set status='".$_REQUEST['status']."' where id = ".$_REQUEST['id'];
		$mysql->db_query($sql);	
	}
	
	if (isset($_REQUEST['user_id'])){
		$data['user_id'] = $_REQUEST['user_id'];
	}
	
	if (isset($_REQUEST['keywords'])){
		$data['keywords'] = $_REQUEST['keywords'];
	}
	if(isset($_REQUEST['site_id'])){
		$data['site_id'] = $_REQUEST['site_id'];
	}
	
	$data['page'] = $_A['page'];
	$data['epage'] = $_A['epage'];
	$result = lianmengClass::GetList($data);
	
	if (is_array($result)){
		$pages->set_data($result);
		$_A['lianmeng_list'] = $result['list'];
		$_A['showpage'] = $pages->show(3);
	
	}else{
		$msg = array($result);
	}
}

/**
 * ���
**/
elseif ($_A['query_type'] == "new"  || $_A['query_type'] == "edit" || $_A['query_type'] == "view" ){
	
	$_A['list_title'] = "���˹���";
	
	if (isset($_POST['name'])){
		$var = array("name","order","status","flag","litpic","clearlitpic","school","xuanyan","intime","province","city","area");
		$data = post_var($var);
		
		if ($_A['query_type'] == "new"){
			$result = lianmengClass::Add($data);
		}else{
			$data['id'] = $_REQUEST['id'];
			$result = lianmengClass::Update($data);
		}
		
		if ($result !== true){
			$msg = array($result);
		}else{
			$msg = array("�����ɹ�");
		}
		$user->add_log($_log,$result);//��¼����
	}
	
	elseif ($_A['query_type'] == "edit" || $_A['query_type'] == "view" ){
		$data['id'] = $_REQUEST['id'];
		$result = lianmengClass::GetOne($data);
		if (is_array($result)){
			$_A['lianmeng_result'] = $result;
			
		}else{
			$msg = array($result);
		}
		
	}
	
}			

	
/**
 * ɾ��
**/
elseif ($_A['query_type'] == "del"){
	$data['id'] = $_REQUEST['id'];
	$result = lianmengClass::Delete($data);
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
elseif ($_A['query_type'] == "lian"){
	$_A['list_title'] = "�����б�";
	
	
	$data['page'] = $_A['page'];
	$data['epage'] = $_A['epage'];
	$result = lianmengClass::GetUnioList($data);
	
	if (is_array($result)){
		$pages->set_data($result);
		$_A['lianmeng_unio_list'] = $result['list'];
		$_A['showpage'] = $pages->show(3);
	
	}else{
		$msg = array($result);
	}
}	
?>