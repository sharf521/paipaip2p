<?
if (!defined('ROOT_PATH'))  die('���ܷ���');//��ֱֹ�ӷ���
check_rank("invite_".$_A['query_type']);//���Ȩ��

	

require_once 'invite.class.php';


$_A['list_purview'] = array("invite"=>array("�˲���Ƹ"=>array("invite_list"=>"��Ƹ�б�","invite_new"=>"�����Ƹ","invite_del"=>"ɾ����Ƹ","invite_type"=>"��Ƹ����")));//Ȩ��
$_A['list_name'] = $_A['module_result']['name'];
$_A['list_menu'] = "<a href='{$_A['query_url']}/new{$_A['site_url']}'>�����Ƹ</a> - <a href='{$_A['query_url']}{$_A['site_url']}'>��Ƹ�б�</a>  - <a href='{$_A['query_url']}/type{$_A['site_url']}'>��Ƹ����</a> ";

/**
 * �������Ϊ�յĻ�����ʾ���е��ļ��б�
**/
if ($_A['query_type'] == "list"){
	$_A['list_title'] = "�б�";
	//�޸�״̬
	if (isset($_REQUEST['id']) && isset($_REQUEST['status'])){
		$sql = "update {invite} set status='".$_REQUEST['status']."' where id = ".$_REQUEST['id'];
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
	$result = inviteClass::GetList($data);
	
	if (is_array($result)){
		$pages->set_data($result);
		$_A['invite_list'] = $result['list'];
		$_A['showpage'] = $pages->show(3);
	
	}else{
		$msg = array($result);
	}
}

/**
 * ���
**/
elseif ($_A['query_type'] == "new"  || $_A['query_type'] == "edit" || $_A['query_type'] == "view" ){	
	$_A['list_title'] = "��Ƹ����";
	
	$_A['invite_type_list'] = inviteClass::GetTypeList();
	
	if (isset($_POST['name'])){
		$var = array("type_id","status","order","flag","name","province","city","area","num","description","demand");
		$data = post_var($var);
		
		if ($_A['query_type'] == "new"){
			$result = inviteClass::Add($data);
		}else{
			$data['id'] = $_REQUEST['id'];
			$result = inviteClass::Update($data);
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
		$result = inviteClass::GetOne($data);
		if (is_array($result)){
			$_A['invite_result'] = $result;
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
	$result = inviteClass::Delete($data);
	if ($result !== true){
		$msg = array($result);
	}else{
		$msg = array("ɾ���ɹ�");
	}
	$user->add_log($_log,$result);//��¼����
}

/**
 * ����
**/
elseif ($_A['query_type']  == "type"){
	if (isset($_REQUEST['del_id'])){
		if ($_REQUEST['del_id'] !=1){
			$mysql->db_delete("invite_type","id=".$_REQUEST['del_id']);
			$msg = array("ɾ���ɹ�");
		}else{
			$msg = array("����ID1Ϊϵͳ���ͣ�����ɾ��");
		}
	}elseif (!isset($_POST['submit'])){
		$result = $mysql->db_selects("invite_type");
		$magic->assign("result",$result);
		$_A['invite_list'] = inviteClass::GetTypeList();
	}else{
		if (isset($_POST['id'])){
			foreach ($_POST['id'] as $key => $val){
				$mysql->db_query("update {invite_type} set typename='".$_POST['typename'][$key]."' where id=".$val);
			}
		}
		if ($_POST['typename1']!=""){
			$index['typename'] = $_POST['typename1'];
			$mysql->db_add("invite_type",$index,"notime");
		}
		$msg = array("���Ͳ����ɹ�","",$_A['query_url']."/type");
	}
}
?>