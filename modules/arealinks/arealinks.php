<?
if (!defined('ROOT_PATH'))  die('���ܷ���');//��ֱֹ�ӷ���
check_rank("arealinks_".$_A['query_type']);//���Ȩ��

include_once("arealinks.class.php");

$_A['list_purview'] =  array("arealinks"=>array("�������ݹ���"=>array("arealinks_list"=>"�б�","arealinks_new"=>"���","arealinks_edit"=>"�༭","arealinks_del"=>"ɾ��")));//Ȩ��
$_A['list_name'] = $_A['module_result']['name'];
$_A['list_menu'] = "<a href='{$_A['query_url']}{$_A['site_url']}'>�б�</a> - <a href='{$_A['query_url']}/new{$_A['site_url']}'>���</a>  ";


/**
 * �������Ϊ�յĻ�����ʾ���е��ļ��б�
**/
if ($_A['query_type'] == "list"){
	$_A['list_title'] = "��Ϣ�б�";
	
	$data['page'] = $_A['page'];
	$data['epage'] = 20;
	$data['keywords'] = $_REQUEST['keywords'];
	$result = arealinksClass::GetList($data);
	
	if (is_array($result)){
		$pages->set_data($result);
		$_A['arealinks_list'] = $result['list'];
		$_A['showpage'] = $pages->show(3);
	
	}else{
		$msg = array($result);
	}
}

	
/**
 * ���
**/
elseif ($_A['query_type'] == "new"  || $_A['query_type'] == "edit" ){
	if ($_A['query_type'] == "new" ){
		$_A['list_title'] = "���";
	}else{
		$_A['list_title'] = "�޸�";
	}	
	//��ȡ�û�id����Ϣ
	if (isset($_POST['webname'])){
		$var = array("status","order","url","webname","pr","flag","email","province","city","area","summary","linkman","email");
		$data = post_var($var);
		if ($_POST['clearlogo']==1){
			$data['logo'] = "";
		}else{
			$pic_name = upload('logo');
			if (is_array($pic_name)){
				$data['logo'] = $pic_name[0];
			}
		}
		
		if ($_A['query_type'] != "new"){
			$data['id'] = $_POST['id'];
			$result = arealinksClass::Update($data);
		}else{
			$result = arealinksClass::Add($data);
		}
		
		if ($result !== true){
			$msg = array($result);
		}else{
			$msg = array("�����ɹ�");
		}
		$user->add_log($_log,$result);//��¼����
	}
	
	elseif ($_A['query_type'] == "edit" ){
		$data['id'] = $_REQUEST['id'];
		$result = arealinksClass::GetOne($data);
		if (is_array($result)){
			$_A['arealinks_result'] = $result;
		}else{
			$msg = array($result);
		}
		
	}

	
	
}	

/**
 * �鿴
**/
elseif ($_A['query_type'] == "view"){
	$_A['list_title'] = "�鿴";
	
	$data['id'] = $_REQUEST['id'];
	$_A['arealinks_result'] = arealinksClass::GetOne($data);

}


/**
 * ɾ��
**/
elseif ($_A['query_type'] == "del"){
	$data['id'] = $_REQUEST['id'];
	$result = arealinksClass::Delete($data);
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