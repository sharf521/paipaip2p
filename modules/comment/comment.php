<?
if (!defined('ROOT_PATH'))  die('���ܷ���');//��ֱֹ�ӷ���
check_rank("comment_".$_A['query_type']);//���Ȩ��
require_once 'comment.class.php';


$_A['list_purview'] =  array("comment"=>array("���۹���"=>array("comment_list"=>"�����б�","comment_new"=>"�������","comment_del"=>"ɾ������")));//Ȩ��
$_A['list_name'] = $_A['module_result']['name'];
$_A['list_menu'] = "<a href='{$_A['query_url']}{$_A['site_url']}'>�����б�</a>";

/**
 * �������Ϊ�յĻ�����ʾ���е��ļ��б�
**/
if ($_A['query_type'] == "list"){
	//�޸�״̬
	if (isset($_REQUEST['id']) && isset($_REQUEST['status'])){
		$sql = "update {comment} set status='".$_REQUEST['status']."' where id = ".$_REQUEST['id'];
		$mysql->db_query($sql);
	}

	$data['page'] = $_A['page'];
	$data['epage'] = $_A['epage'];
	$result = commentClass::GetList($data);
	
	if (is_array($result)){
		$pages->set_data($result);
		$_A['comment_list'] = $result['list'];
		$_A['showpage'] = $pages->show(3);
	
	}else{
		$msg = array($result);
	}
}


/**
 * ���
**/
elseif ($_A['query_type'] == "new"  || $_A['query_type'] == "edit" || $_A['query_type'] == "view" ){
	
	$_A['list_title'] = "���۹���";
	if (isset($_POST['site_id'])){
		$var = array('user_id','module_code', 'article_id','comment');
		$data = post_var($var);
		
		if ($_A['query_type'] == "edit"){
			$data['id'] = $_REQUEST['id'];
			$result = commentClass::Update($data);
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
		$data['code'] = $_REQUEST['module_code'];
		$result = commentClass::GetOne($data);
		if (is_array($result)){
			$_A['comment_result'] = $result;
			
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
	$result = commentClass::Delete($data);
	if ($result !== true){
		$msg = array($result);
	}else{
		$msg = array("ɾ���ɹ�");
	}
	$user->add_log($_log,$result);//��¼����
}


?>