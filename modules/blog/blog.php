<?
if (!defined('ROOT_PATH'))  die('���ܷ���');//��ֱֹ�ӷ���
check_rank("blog_".$_A['query_type']);//���Ȩ��

include_once("blog.class.php");

$_A['list_purview'] =  array("blog"=>array("���͹���"=>array("blog_list"=>"�����б�","blog_view"=>"���Ͳ鿴","blog_del"=>"ɾ������","blog_type"=>"�������͹���","blog_type_del"=>"��������ɾ��")));//Ȩ��
$_A['list_name'] = $_A['module_result']['name'];
$_A['list_menu'] = "<a href='{$_A['query_url']}/{$_A['site_url']}'>�����б�</a> - <a href='{$_A['query_url']}{$_A['site_url']}'>������������</a> ";
$_A['list_table'] = "";

/**
 * �������Ϊ�յĻ�����ʾ���е��б�
**/
if ($_A['query_type'] == "list"){
	$_A['list_title'] = "�����б�";
	//�޸�״̬
	if (isset($_REQUEST['id']) && isset($_REQUEST['status'])){
		$sql = "update {blog} set status='".$_REQUEST['status']."' where id = ".$_REQUEST['id'];
		$mysql->db_query($sql);	
	}
	
	if (isset($_REQUEST['keywords']) && $_REQUEST['keywords']!=""){
		$data['name'] = $_REQUEST['keywords'];
	}
		
	$data['page'] = $_A['page'];
	$data['epage'] = $_A['epage'];
	$data['flag_list'] = $_A['flag_list'];
	
	$result = blogClass::GetList($data);
	if (is_array($result)){
		$pages->set_data($result);
		$_A['blog_list'] = $result['list'];
		$_A['showpage'] = $pages->show(3);
	}else{
		$msg = array($result);
	}
}

/**
 * �鿴
**/
elseif ($_A['query_type'] == "view"){
	$_A['blog_result'] = blogClass::GetOne(array("id"=>$_REQUEST['id']));
}
	
	
/**
 * ɾ��
**/
elseif ($_A['query_type'] == "del"){
	$id = $_REQUEST['id'];
	$result = blogClass::Delete(array("id"=>$id));
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



/**
 * �������Ϊ�յĻ�����ʾ���е��б�
**/
if ($_A['query_type'] == "type"){
	$_A['list_title'] = "���������б�";
	
	if (isset($_REQUEST['keywords']) && $_REQUEST['keywords']!=""){
		$data['name'] = $_REQUEST['keywords'];
	}
		
	$data['page'] = $_A['page'];
	$data['epage'] = $_A['epage'];
	$data['flag_list'] = $_A['flag_list'];
	
	$result = blogClass::GetTypeList($data);
	if (is_array($result)){
		$pages->set_data($result);
		$_A['blog_list'] = $result['list'];
		$_A['showpage'] = $pages->show(3);
	}else{
		$msg = array($result);
	}
}

?>