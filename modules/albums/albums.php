<?
if (!defined('ROOT_PATH'))  die('���ܷ���');//��ֱֹ�ӷ���
check_rank("albums_".$_A['query_type']);//���Ȩ��

include_once("albums.class.php");

$_A['list_purview'] =  array("albums"=>array("������"=>array("albums_list"=>"����б�","albums_new"=>"������","albums_del"=>"ɾ�����")));//Ȩ��
$_A['list_name'] = $_A['module_result']['name'];
$_A['list_menu'] = "<a href='{$_A['query_url']}{$_A['site_url']}'>����б�</a> - <a href='{$_A['query_url']}/new{$_A['site_url']}'>������</a> - <a href='{$_A['query_url']}/type{$_A['site_url']}'>�������</a> ";


/**
 * �������Ϊ�յĻ�����ʾ���е��ļ��б�
**/
if ($_A['query_type'] == "list"){
	$_A['list_title'] = "����б�";
	if(isset($_REQUEST['keywords'])){
		$data['keywords'] = $_REQUEST['keywords'];
	}
	if(isset($_REQUEST['site_id'])){
		$data['site_id'] = $_REQUEST['site_id'];
	}
	$data['page'] = $_A['page'];
	$data['epage'] = $_A['epage'];
	$result = albumsClass::GetList($data);
	
	if (is_array($result)){
		$pages->set_data($result);
		$_A['albums_list'] = $result['list'];
		$_A['showpage'] = $pages->show(3);
	
	}else{
		$msg = array($result);
	}
}

	
/**
 * ���
**/
elseif ($_A['query_type'] == "new" || $_A['query_type'] == "edit" ){
	if ($_A['query_type'] == "new"){
		$_A['list_title'] = "��ӻ���";
	}else{
		$_A['list_title'] = "�޸Ļ���";
	}
	if (isset($_POST['name'])){
		$var = array("name","order","site_id","flag","clearlitpic","status","content","province","city","area");
		$data = post_var($var);
		$_G['upimg']['cut_status'] = 1;
		if ($_POST['clearlitpic']==1){
			$data['litpic'] = "";
		}else{
			$_G['upimg']['file'] = "litpic";
			$_G['upimg']['cut_width'] = "100";
			$_G['upimg']['cut_height'] = "100";
			$pic_result = $upload->upfile($_G['upimg']);
			if (!empty($pic_result)){
				$data['litpic'] = $pic_result;
			}
		}
		
		
		$data['pics'] = "";
		if (isset($_POST['_pics'])){
			$data['pics'] .= join(",",$_POST['_pics']);
		}
		$_G['upimg']['file'] = "pics";
		$_G['upimg']['cut_width'] = "800";
		$_G['upimg']['cut_height'] = "600";
		$pic_result = $upload->upfile($_G['upimg']);
		if (!empty($pic_result)){
			$data['pics'] .= ",".join(",",$pic_result);
		}
		
		
		
		if ($_A['query_type'] == "new"){
			$result = albumsClass::Add($data);
		}else{
			$data['id'] = $_POST['id'];
			$result = albumsClass::Update($data);
		}
		
		if ($result !== true){
			$msg = array($result);
		}else{
			$msg = array("�����ɹ�");
		}
		$user->add_log($_log,$result);//��¼����
	}elseif ($_A['query_type'] == "edit" ){
		
		$data['id'] = $_REQUEST['id'];
		$result = albumsClass::GetOne($data);
		if (is_array($result)){
			$_A['albums_result'] = $result;
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
	$result = albumsClass::Delete($data);
	if ($result !== true){
		$msg = array($result);
	}else{
		$msg = array("ɾ���ɹ�");
	}
	$user->add_log($_log,$result);//��¼����
}

/**
 * ɾ��
**/
elseif ($_A['query_type'] == "type_del"){
	$data['id'] = $_REQUEST['id'];
	$result = albumsClass::TypeDelete($data);
	if ($result !== true){
		$msg = array($result);
	}else{
		$msg = array("ɾ�����ͳɹ�");
	}
	$user->add_log($_log,$result);//��¼����
}

/**
 * ɾ��
**/
elseif ($_A['query_type'] == "type_del"){
	$data['id'] = $_REQUEST['id'];
	$result = albumsClass::TypeDelete($data);
	if ($result !== true){
		$msg = array($result);
	}else{
		$msg = array("ɾ�����ͳɹ�");
	}
	$user->add_log($_log,$result);//��¼����
}

//��ֹ�Ҳ���
else{
	$msg = array("���������벻Ҫ�Ҳ���","",$url);
}
?>