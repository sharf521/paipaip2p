 <?
if (!defined('ROOT_PATH'))  die('���ܷ���');//��ֱֹ�ӷ���
check_rank("integral_".$_A['query_type']);//���Ȩ��

include_once("integral.class.php");

$_A['list_purview'] = array(""=>array("��Ʒ�һ�"=>array("integral_list"=>"��Ʒ�һ��б�","integral_new"=>"�����Ʒ�һ�","integral_del"=>"ɾ����Ʒ�һ�","integral_convert"=>"�û��һ���Ϣ")));//Ȩ��
$_A['list_name'] = $_A['module_result']['name'];
$_A['list_menu'] = "<a href='{$_A['query_url']}{$_A['site_url']}'>�һ���Ʒ�б�</a> - <a href='{$_A['query_url']}/new{$_A['site_url']}'>��Ӷһ���Ʒ</a>  - <a href='{$_A['query_url']}/convert{$_A['site_url']}'>�û��һ���Ϣ</a>  ";



/**
 * �������Ϊ�յĻ�����ʾ���е��ļ��б�
**/
if ($_A['query_type'] == "list"){
	$_A['list_title'] = "��Ʒ�һ��б�";
	
	$data['page'] = $_A['page'];
	$data['epage'] = 20;
	$data['name'] = isset($_REQUEST['name'])?$_REQUEST['name']:"";
	$result = integralClass::GetList($data);
	if (is_array($result)){
		$pages->set_data($result);
		$_A['integral_list'] = $result['list'];
		$_A['showpage'] = $pages->show(3);
	
	}else{
		$msg = array($result);
	}
	
}



/**
 * ���
**/
elseif ($_A['query_type'] == "new" || $_A['query_type'] == "edit"){
	if($_A['query_type'] == "edit"){
		$_A['list_title'] = "������Ʒ���";
	}else{
		$_A['list_title'] = "������Ʒ�޸�";
	}
	//��ȡ�û�id����Ϣ
	if (isset($_POST['name'])){
		$var = array('name','need','number','province','city','area','order','flag','content','status','clearlitpic');
		$data = post_var($var);
		
		if($_A['query_type'] == "new"){
			$result = integralClass::Add($data);
		}else{
			$data['id'] = $_REQUEST['id'];
			$result = integralClass::update($data);
		}
		
		if ($result !== true){
			$msg = array($result);
		}else{
			$msg = array("�����ɹ�");
		}
		$user->add_log($_log,$result);//��¼����
	}
	
	elseif($_A['query_type'] == "edit"){
		$data['id'] = $_REQUEST['id'];
		$result = integralClass::GetOne($data);
		if (is_array($result)){
			$_A['integral_result'] = $result;
		}else{
			$msg = array("��������");
		}
	}
}
	
/**
 * �鿴
**/	
elseif ($_A['query_type'] == "view"){
	$data['id'] = $_REQUEST['id'];
	$result = integralClass::GetOne($data);
	if (is_array($result)){
		$_A['integral_result'] = $result;
	}else{
		$msg = array("��������");
	}
}


/**
 * ɾ��
**/
elseif ($_A['query_type'] == "del"){
	$data['id'] = $_REQUEST['id'];
	$result = integralClass::Delete($data);
	if ($result !== true){
		$msg = array($result);
	}else{
		$msg = array("ɾ���ɹ�");
	}
	$user->add_log($_log,$result);//��¼����
}


/**
 * ��ʾ�һ���Ϣ�б�
**/
elseif ($_A['query_type'] == "convert"){
	$_A['list_title'] = "��Ʒ�һ���ϸ��Ϣ";
	
	$data['page'] = $_A['page'];
	$data['epage'] = 20;
	$data['name'] = isset($_REQUEST['name'])?$_REQUEST['name']:"";
	$result = integralClass::GetConvertList($data);
	if (is_array($result)){
		$pages->set_data($result);
		$_A['integral_convert_list'] = $result['list'];
		$_A['showpage'] = $pages->show(3);
	
	}else{
		$msg = array($result);
	}
	
}

	
/**
 * �鿴
**/	
elseif ($_A['query_type'] == "convert_view"){
	if (isset($_POST['status'])){
		$data['status'] = $_POST['status'];
		$data['remark'] = $_POST['remark'];
		$data['id'] = $_POST['id'];
		$result = integralClass::ActionConvert($data);
		$msg = array("�һ��ɹ�");
	}else{
		$data['id'] = $_REQUEST['id'];
		$result = integralClass::GetConvertOne($data);
		if (is_array($result)){
			$_A['integral_convert_result'] = $result;
		}else{
			$msg = array("��������");
		}
	}
}
?>