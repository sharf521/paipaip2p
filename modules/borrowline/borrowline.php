<?
if (!defined('ROOT_PATH'))  die('���ܷ���');//��ֱֹ�ӷ���
check_rank("borrowline_".$_A['query_type']);//���Ȩ��

include_once("borrowline.class.php");

$_A['list_purview'] =  array("borrowline"=>array("���½��"=>array("borrowline_list"=>"����б�","borrowline_new"=>"��ӽ��","borrowline_edit"=>"�༭���","borrowline_del"=>"ɾ�����","borrowline_view"=>"��˽��")));//Ȩ��
$_A['list_name'] = $_A['module_result']['name'];
$_A['list_menu'] = "<a href='{$_A['query_url']}{$_A['site_url']}'>����б�</a> - <a href='{$_A['query_url']}/new{$_A['site_url']}'>��ӽ��</a>  ";


/**
 * �������Ϊ�յĻ�����ʾ���е��ļ��б�
**/
if ($_A['query_type'] == "list"){
	//�޸�״̬
	if (isset($_REQUEST['id']) && isset($_REQUEST['status'])){
		$sql = "update {borrow_line} set status='".$_REQUEST['status']."' where id = ".$_REQUEST['id'];
		$mysql->db_query($sql);	
	}
	
	$_A['list_title'] = "���½��";
	
	if (isset($_REQUEST['user_id'])){
		$data['user_id'] = $_REQUEST['user_id'];
	}
	
	if (isset($_REQUEST['username'])){
		$data['username'] = $_REQUEST['username'];
	}
	
	$data['page'] = $_A['page'];
	$data['epage'] = $_A['epage'];
	$result = borrowlineClass::GetList($data);
	
	if (is_array($result)){
		$pages->set_data($result);
		$_A['borrowline_list'] = $result['list'];
		$_A['showpage'] = $pages->show(3);
	
	}else{
		$msg = array($result);
	}
}


elseif ($_A['query_type'] == "view"  ){
	if (isset($_POST['status']) && $_POST['status']!=""){
		$data['id'] = $_POST['id'];
		$data['status'] = $_POST['status'];
		$data['verify_remark'] = $_POST['verify_remark'];
		$data['verify_user'] = $_G['user_id'];
		$result = borrowlineClass::Verify($data);
		$msg = array("��˳ɹ�");
	}else{
		$data['user_id'] = $_REQUEST['user_id'];
		$data['id'] = $_REQUEST['id'];
		$result = borrowlineClass::GetOne($data);
		if (is_array($result)){
			$_A['borrowline_result'] = $result;
		}else{
			$msg = array($result);
		}
	}
}
/**
 * ���
**/
elseif ($_A['query_type'] == "new"  || $_A['query_type'] == "edit"   ){
	
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
	
	elseif (isset($_POST['name'])){
		$var = array("user_id","borrow_use","borrow_qixian","area","tel","account","pawn","name","xing","sex","email","content");
		$data = post_var($var);

		if ($_A['query_type'] == "new"){
			$result = borrowlineClass::Add($data);
		}else{
			$data['id'] = $_REQUEST['id'];
			$result = borrowlineClass::Update($data);
		}
		
		if ($result !== true){
			$msg = array($result);
		}else{
			$msg = array("�����ɹ�");
		}
		$user->add_log($_log,$result);//��¼����
	}
	
	elseif ($_A['query_type'] == "edit" ){
		$data['user_id'] = $_REQUEST['user_id'];
		$data['id'] = $_REQUEST['id'];
		$result = borrowlineClass::GetOne($data);
		if (is_array($result)){
			$_A['borrowline_result'] = $result;
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
			//$result = borrowlineClass::GetOne($data);
			//$_A['borrowline_result'] = $result;
		}
		
	}
	
}	



/**
 * ɾ��
**/
elseif ($_A['query_type'] == "del"){
	$data['id'] = $_REQUEST['id'];
	$result = borrowlineClass::Delete($data);
	if ($result !== true){
		$msg = array($result);
	}else{
		$msg = array("ɾ���ɹ�","",$_A['query_url']);
	}
	$user->add_log($_log,$result);//��¼����
}


//��ֹ�Ҳ���
else{
	$msg = array("���������벻Ҫ�Ҳ���");
}
?>