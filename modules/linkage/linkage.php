<?
if (!defined('ROOT_PATH'))  die('���ܷ���');//��ֱֹ�ӷ���
check_rank("linkage_list");//���Ȩ��


include_once("linkage.class.php");

$_A['list_purview'] =   array("linkage"=>array("����ģ��"=>array("linkage_list"=>"��������")));//Ȩ��
$_A['list_name'] = $_A['module_result']['name'];
$_A['list_menu'] = "<a href='{$_A['query_url']}{$_A['site_url']}'>��������</a>  -  <a href='{$_A['query_url']}/type_new{$_A['site_url']}'>�����������</a>";
$_A['list_table'] = "";


	
/**
 * �������Ϊ�յĻ�����ʾ���е��ļ��б�
**/
if ($_A['query_type'] == "list"){
	$data['page'] = $_A['page'];
	$data['epage'] = 20;

	$result = linkageClass::GetTypeList($data);
	if (is_array($result)){
		$pages->set_data($result);
		$_A['linkage_list'] = $result['list'];
		$_A['showpage'] = $pages->show(3);
	}else{
		$msg = array($result);
	}
}


/**
 * ���
**/
elseif ($_A['query_type'] == "new"){
	if (isset($_POST['name'])){
		$var = array("name","pid","value","type_id","order");
		$index = post_var($var);
		if($index['value']==""){
			$index['value'] = $index['name'];
		}
		$result = $mysql->db_add("linkage",$index,"notime");
		
		if ($result == false){
			$msg = array("���������������Ա��ϵ");
		}else{
			$msg = array("�����ɹ�","",$_U["url"]);
		}
		$user->add_log($_log,$result);//��¼����
	
	}else{
		$data['limit'] = "all";
		$data['id'] = $_REQUEST['id'];
		$_A['linkage_type_result'] =linkageClass::GetTypeOne($data);
		if (is_array($_A['linkage_type_result'])){
			$data['type_id'] = $_REQUEST['id'];
			$_A['linkage_list'] = linkageClass::GetList($data);
		}else{
			$msg = array($result);
		}
		$pname = empty($pname)?"��������":$pname;
		$magic->assign("pname",$pname);
	}
}

/**
 * ���
**/
elseif ($_A['query_type'] == "subnew"){
	if (isset($_POST['name']) && $_POST['name']!=""){
		$var = array("name","pid","type_id");
		$index = post_var($var);
		$result = $mysql->db_add("linkage",$index,"notime");
		
		if ($result == false){
			$msg = array("���������������Ա��ϵ");
		}else{
			$msg = array("�����ɹ�");
		}
		$user->add_log($_log,$result);//��¼����
	
	}else{
		$linkage_type = $mysql->db_select("linkage_type","id=".$_REQUEST['id']);
		if ($result == false){
			$msg = array("�����������");
		}else{
			$magic->assign("linkage_type",$linkage_type);
		}
		
		$linkage_sub= $mysql->db_select("linkage","id=".$_REQUEST['pid']);
		if ($result == false){
			$msg = array("�����������");
		}else{
			$magic->assign("linkage_sub",$linkage_sub);
		}
		
		if ($msg == ""){
			$result = $mysql->db_selects("linkage","type_id=".$_REQUEST['id']." and pid=".$_REQUEST['pid']," `order` desc");
			$magic->assign("result",$result);
		}
		
		$pname = empty($pname)?"��������":$pname;
		$magic->assign("pname",$pname);
	}
}


/**
 * ����
**/
elseif ($_A['query_type'] == "actions"){
	if (isset($_POST['id'])){
		$data['id'] = $_POST['id'];
		$data['name'] = $_POST['name'];
		$data['value'] = $_POST['value'];
		$data['order'] = $_POST['order'];
		$result = linkageClass::Action($data);
		if ($result !== true){
			$msg = array($result);
		}else{
			$msg = array("�����ɹ�");
		}
	}else{
		//���
		if (isset($_POST['name'])){
			$data['type'] = "add";
			$data['name'] = $_POST['name'];
			$data['type_id'] = $_POST['type_id'];
			$data['value'] = $_POST['value'];
			$data['order'] = $_POST['order'];
			$result = linkageClass::Action($data);
			if ($result !== true){
				$msg = array($result);
			}else{
				$msg = array("�����ɹ�");
			}
		}else{
			$msg = array("��������");
		}
	}
}
/**
 * �鿴
**/
elseif ($_A['query_type'] == "view"){
	$_A['linkage_result'] = linkageClass::GetOne(array("id"=>$_REQUEST['id']));
}

/**
 * ɾ��
**/
elseif ($_A['query_type'] == "del"){
	$id = $_REQUEST['id'];
	$result = linkageClass::Delete(array("id"=>$id));
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
elseif ($_A['query_type'] == "type_new" || $_A['query_type'] == "type_edit"){
	if (isset($_POST['name'])){
		$var = array("name","nid","order");
		$data = post_var($var);
		if ($_A['query_type'] == "type_new"){
			$result = linkageClass::AddType($data);
			if ($result !== true){
				$msg = array($result);
			}else{
				$msg = array("��ӳɹ�");
			}
		}else{
			$data['id'] = $_POST['id'];
			$result = linkageClass::UpdateType($data);
			if ($result !== true){
				$msg = array($result);
			}else{
				$msg = array("��ӳɹ�");
			}
		}
		$user->add_log($_log,$result);//��¼����
	}elseif( $_A['query_type'] == "type_edit"){
		$data['id'] = $_REQUEST['id'];
		$_A['linkage_type_result'] = linkageClass::GetTypeOne($data);
	}
}

/**
 * ɾ��
**/
elseif ($_A['query_type'] == "type_del"){
	$data['id'] = $_REQUEST['id'];
	$result = linkageClass::DeleteType($data);
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
elseif ($_A['query_type'] == "type_action"){
	if (isset($_POST['id'])){
		$data['id'] = $_POST['id'];
		$data['name'] = $_POST['name'];
		$data['nid'] = isset($_POST['nid'])?$_POST['nid']:"";
		$data['order'] = $_POST['order'];
		$result = linkageClass::ActionType($data);
		if ($result !== true){
			$msg = array($result);
		}else{
			$msg = array("�����ɹ�");
		}
	}else{
		if (isset($_POST['name'])){
			$data['type'] = $_POST['type'];
			$data['name'] = $_POST['name'];
			$data['nid'] = $_POST['nid'];
			$data['order'] = $_POST['order'];
			$result = linkageClass::ActionType($data);
			if ($result !== true){
				$msg = array($result);
			}else{
				$msg = array("�����ɹ�");
			}
		}else{
			$msg = array("��������");
		}
	}
}

//��ֹ�Ҳ���
else{
	$msg = array("���������벻Ҫ�Ҳ���","",$url);
}


?>