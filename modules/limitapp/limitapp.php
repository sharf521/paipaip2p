<?
if (!defined('ROOT_PATH'))  die('���ܷ���');//��ֱֹ�ӷ���
check_rank("limitapp_".$_A['query_type']);//���Ȩ��

include_once("limitapp.class.php");

$_A['list_purview'] =  array("limitapp"=>array("��ȹ���"=>array("limitapp_list"=>"�����б�","limitapp_new"=>"��Ӷ��","limitapp_edit"=>"�༭������","limitapp_del"=>"ɾ�������","limitapp_view"=>"�������")));//Ȩ��
$_A['list_name'] = $_A['module_result']['name'];
$_A['list_menu'] = "<a href='{$_A['query_url']}{$_A['site_url']}'>�����б�</a> - <a href='{$_A['query_url']}/new{$_A['site_url']}'>�������</a>  ";


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
	if (isset($_REQUEST['status'])){
		$data['status'] = $_REQUEST['status'];
	}
	
	
	$data['page'] = $_A['page'];
	$data['epage'] = $_A['epage'];
	$result = limitappClass::GetList($data);
	
	if (is_array($result)){
		$pages->set_data($result);
		$_A['limitapp_list'] = $result['list'];
		$_A['showpage'] = $pages->show(3);
	
	}else{
		$msg = array($result);
	}
}

	
/**
 * ���
**/
elseif ($_A['query_type'] == "new"  || $_A['query_type'] == "edit" ){
	
	$_A['list_title'] = "������Ϣ";
	
	//��ȡ�û�id����Ϣ
	if (isset($_REQUEST['user_id']) && isset($_POST['username'])){
		if(isset($_POST['user_id']) && $_POST['user_id']!=""){
			$data['user_id'] = $_POST['user_id'];
			$result = userClass::GetOne($data);
		}elseif(isset($_POST['username']) && $_POST['username']!=""){
			$data['username'] = $_POST['username'];
			$result = userClass::GetOne($data);
		}
		if ($result==false){
			$msg = array("�Ҳ������û�");
		}else{
			echo "<script>location.href='".$_A['query_url']."/new&user_id={$result['user_id']}'</script>";
		}
	}
	
	elseif (isset($_POST['account'])){
		$var = array("user_id","account","recommend_userid","content","other_content");
		$data = post_var($var);

		if ($_A['query_type'] == "new"){
			$result = limitappClass::Add($data);
		}else{
			$result = limitappClass::Update($data);
		}
		
		if ($result !== true){
			$msg = array($result);
		}else{
			$msg = array("�����ɹ�");
		}
		$user->add_log($_log,$result);//��¼����
	}
	
	elseif ($_A['query_type'] == "edit" ){
		$data['user_id'] = $_REQUEST['id'];
		$data['id'] = $_REQUEST['id'];
		$result = limitappClass::GetOne($data);
		if (is_array($result)){
			if ($result['status']==1){
				$msg = array("�������Ѿ�ͨ���������޸�");
			}else{
				$_A['limitapp_result'] = $result;
			}
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
			//$result = limitappClass::GetOne($data);
			//$_A['limitapp_result'] = $result;
		}
		
	}
	
}	

/**
 * �鿴
**/
elseif ($_A['query_type'] == "view"){
	$_A['list_title'] = "�������";
	if (isset($_POST['id'])){
		$var = array("id","user_id","status","verify_remark");
		$data = post_var($var);
		$data['verify_time'] = time();
		$result = limitappClass::Update($data);
		
		if ($result !== true){
			$msg = array($result);
		}else{
			$msg = array("�����ɹ�");
		}
		$user->add_log($_log,$result);//��¼����
	}else{
		$data['id'] = $_REQUEST['id'];
		$data['user_id'] = $_REQUEST['user_id'];
		$_A['limitapp_result'] = limitappClass::GetOne($data);
	}
}


/**
 * ɾ��
**/
elseif ($_A['query_type'] == "del"){
	$data['id'] = $_REQUEST['id'];
	$result = limitappClass::Delete($data);
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