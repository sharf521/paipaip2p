<?
if (!defined('ROOT_PATH'))  die('���ܷ���');//��ֱֹ�ӷ���
$codeFields = $code."_fields";
check_rank($code."_".$_A['query_type']);//���Ȩ��

include_once(ROOT_PATH."modules/subsite/subsite.class.php");
include_once($code.".class.php");
$className = $code."Class";
$codeClass = new $className();

$_A['list_purview'] =  array($code=>array("���¹���"=>array($code."_list"=>"�����б�",$code."_new"=>"�������",$code."_edit"=>"�༭����",$code."_del"=>"ɾ������",$code."_view"=>"�鿴����")));//Ȩ��
$_A['list_name'] = $_A['module_result']['name'];
$_A['list_menu'] = "<a href='{$_A['query_url']}{$_A['site_url']}'>{$_A['site_result']['name']}�б�</a> - <a href='{$_A['query_url']}/new{$_A['site_url']}'>���{$_A['site_result']['name']}</a> ";
$_A['list_table'] = "";

//������Ա�����ڵķ�վ��Ϣ����
$data['areaid'] = $_SESSION['areaid'];
$_A['areaid'] =  $_SESSION['areaid'];
$_A['admin_type_id'] =  $_SESSION['type_id'];
/**
 * �������Ϊ�յĻ�����ʾ���е��ļ��б�
**/
if ($_A['query_type'] == "list"){
	$_A['list_title'] = "{$_A['site_result']['name']}�б�";
	//�޸�״̬
	if (isset($_REQUEST['id']) && isset($_REQUEST['status'])){
		$sql = "update {".$code."} set status='".$_REQUEST['status']."' where id = ".$_REQUEST['id'];
		$mysql->db_query($sql);	
	}
	
	
	$data['page'] = $_A['page'];
	$data['epage'] = $_A['epage'];
	$data['code'] = $code;
	$data['site_id'] = $_A['site_id'];
	$data['flag_list'] = $_A['flag_list'];
	$result = $codeClass->GetList($data);
	if (is_array($result)){
		$pages->set_data($result);
		$_A['code_list'] = $result['list'];
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
		$_A['list_title'] = "���{$_A['site_result']['name']}";
	}else{
		$_A['list_title'] = "�޸�{$_A['site_result']['name']}";
	}
	if (isset($_POST['name'])){
		$var = array("name","is_jump","jumpurl","summary","source","publish","content","flag","author","order","status","site_id","province","city","area","areaid");
		$data = post_var($var);
		$data['code'] = $code;
		
		if ($_POST['clearlitpic']==1){
			$data['litpic'] = "";
		}else{
			$_G['upimg']['file'] = "litpic";
			$pic_result = $upload->upfile($_G['upimg']);
			if (!empty($pic_result)){
				$data['litpic'] = $pic_result['filename'];
			}
		}
		//�Զ����ֶ�
		$fields = array();
		if ($_A['module_result']['fields']==1){
			$fields = post_fields(moduleClass::GetFieldsList(array("code"=>$code)));
		}
		
		if ($_A['query_type'] == "new"){
			$data['user_id'] = $_G['user_id'];
			$result = $codeClass->Add(array("data"=>$data,"fields"=>$fields));
		}else{
			$data['id'] = $_POST['id'];
			$result = $codeClass->Update(array("data"=>$data,"fields"=>$fields));
		}
		
		if ($result !== true){
			$msg = array($result);
		}else{
			$msg = array("�����ɹ�","",$_A['query_url'].$_A['site_url']);
		}
		$user->add_log($_log,$result);//��¼����
	}else{
		$_A['site_list'] = siteClass::GetList(array("code"=>$code));
		$_A['subsite_list'] = subsiteClass::GetSubsiteList();
		if ($_A['query_type'] == "edit"){
			$data['code'] = $code;
			$data['id'] = $_REQUEST['id'];
			$result = $codeClass->GetOne($data);
			if (is_array($result)){
				$_A['code_result'] = $result;
			}else{
				$msg = array($result);
			}
		}
		
		//��ʾ�Զ���ı�
		$_res = explode(",",$_A['module_result']['default_field']);
		foreach ($_A['article_fields'] as $key => $value){
			if (count($_res)>0 && in_array($key,$_res)){
				$_filed[$key] = true;
			}else{
				$_filed[$key] = false;
			}
		}
		$_A['show_fields'] = $_filed;
		
		//�Զ����ֶ�
		if ($_A['module_result']['fields']==1){
			$result_fields = "";
			$data['code'] = $code;
			$data['result'] = $_A['code_result'];
			$_A['code_input']  = moduleClass::GetFieldsInput($data);
		}
	}
}

/**
 * �鿴
**/
elseif ($_A['query_type'] == "view"){
	$_A['list_title'] = "�鿴����";
	$data['code'] = $code;
	$data['id'] = $_REQUEST['id'];
	$_A['code_result'] = $codeClass->GetOne($data);
}


/**
 * ɾ��
**/
elseif ($_A['query_type'] == "del"){
	$result = $codeClass->Delete(array("code"=>$code,"id"=>$_REQUEST['id']));
	if ($result !== true){
		$msg = array($result);
	}else{
		$msg = array("ɾ���ɹ�");
	}
	$user->add_log($_log,$result);//��¼����
}


//��ֹ�Ҳ���
else{
	$msg = array("���������벻Ҫ�Ҳ���");
}
?>