<?
if (!defined('ROOT_PATH'))  die('���ܷ���');//��ֱֹ�ӷ���
check_rank("company_".$_A['query_type']);//���Ȩ��

include_once("company.class.php");

$_A['list_purview'] =  array("company"=>array("��˾����"=>array("company_list"=>"��˾�б�","company_new"=>"��ӹ�˾","company_del"=>"ɾ����˾")));//Ȩ��
$_A['list_name'] = $_A['module_result']['name'];
$_A['list_menu'] = "<a href='{$_A['query_url']}{$_A['site_url']}'>��ҵ��Ա������</a> - <a href='{$_A['query_url']}{$_A['site_url']}'>��˾�б�</a> - <a href='{$_A['query_url']}/zhaopin{$_A['site_url']}'>��Ƹ����</a> - <a href='{$_A['query_url']}/news{$_A['site_url']}'>���Ź���</a>  ";
$_A['list_table'] = "";

/**
 * �������Ϊ�յĻ�����ʾ���е��ļ��б�
**/
if ($_A['query_type'] == "list"){
	$_A['list_title'] = "��˾�б�";
	//�޸�״̬
	if (isset($_REQUEST['keywords']) && $_REQUEST['keywords']!=""){
		$data['name'] = $_REQUEST['keywords'];
	}
		
	$data['page'] = $_A['page'];
	$data['epage'] = $_A['epage'];
	$data['flag_list'] = $_A['flag_list'];
	
	$result = companyClass::GetList($data);
	if (is_array($result)){
		$pages->set_data($result);
		$_A['company_list'] = $result['list'];
		$_A['showpage'] = $pages->show(3);
	}else{
		$msg = array($result);
	}
}

//�鿴������Ƿ�����ҵ��Ա
elseif ($_A['query_type'] == "view" ){
	if (isset($_POST['status']) && $_POST['status']!=""){
		$var = array("id","status","verify_remark");
		$data = post_var($var);
		$date['verify_time'] = time();
		$result = companyClass::Update($data);
		$msg = array("��˲����ɹ�");
	}else{
		$data['id'] = $_REQUEST['id'];
		$_A['company_result'] = companyClass::GetOne($data);
	}
}


/**
 * ���
**/
elseif ($_A['query_type'] == "new" || $_A['query_type'] == "edit" ){
	if ($_A['query_type'] == "new"){
		$_A['list_title'] = "��ӹ�˾";
	}else{
		$_A['list_title'] = "�޸Ĺ�˾";
	}
	if (isset($_POST['name'])){
		//ģ���ֶεı�
		$var = array("name","flag","status","weburl","summary","content","province","city","area","address","address","linkman","email","postcode","tel","fax","msn","qq","updatetime","updateip");
		$data = post_var($var);
		
		//�Զ����ֶεı�
		$fields = "";
		if ($_A['module_result']['fields']==1){
			$fields = post_fields(moduleClass::GetFieldsList(array("code"=>"company")));
			
		}
		
		//��ӱ��Ĵ���
		if ($_A['query_type'] == "new"){
			$result = companyClass::Add($data);
			if ($result>0){
				if ($_A['module_result']['fields']==1){
					$fields['id'] = $result;
					$fields['code'] = $code;
					moduleClass::AddFieldsTable($fields);//�����ֶ�
				}
				$msg = array("��ӳɹ�");
			}else{
				$msg = array($result);
			}
		}
		//�޸ı��Ĵ���
		else{
			$data['id'] = $_POST['id'];
			$result = companyClass::Update($data);
			if ($result){
				if ($_A['module_result']['fields']==1){
					$fields['id'] = $data['id'];
					$fields['code'] = $code;
					moduleClass::UpdateFieldsTable($fields);//�����ֶ�
				}
				$msg = array("�޸ĳɹ�");
			}else{
				$msg = array($result);
			}
		}
		
		$user->add_log($_log,$result);//��¼����
	}else{
		//��֤����ģ�����Ŀ
		$_A['site_list'] = siteClass::GetList(array("code"=>"company"));
		
		
		//��ȡ�༭����Ϣ
		if ($_A['query_type'] == "edit"){
			$data['id'] = $_REQUEST['id'];
			$data['fields'] = $_A['module_result']['fields'];
			$result = companyClass::GetOne($data);
			if (is_array($result)){
				$_A['company_result'] = $result;
			}else{
				$msg = array($result);
			}
			
		}
		
		//�Զ����ֶ�
		if ($_A['module_result']['fields']==1){
			$result_fields = "";
			$data['code'] = $code;
			$data['result'] = $_A['company_result'];
			$_A['show_input']  = moduleClass::GetFieldsInput($data);
		}
	}
}

/**
 * �鿴
**/
elseif ($_A['query_type'] == "view"){
	$_A['company_result'] = companyClass::GetOne(array("id"=>$_REQUEST['id']));
}
	
	
/**
 * ɾ��
**/
elseif ($_A['query_type'] == "del"){
	$id = $_REQUEST['id'];
	$result = companyClass::Delete(array("id"=>$id));
	if ($result !== true){
		$msg = array($result);
	}else{
		//�Զ����ֶ�
		
		$data['id'] = $id;
		$data['code'] = "company";
		moduleClass::DeleteFieldsTable($data);
		
		$msg = array("ɾ���ɹ�");
	}
	$user->add_log($_log,$result);//��¼����
}


/**
 * ���Ź���
**/
elseif ($_A['query_type'] == "news"){
	$_A['list_title'] = "��˾�����б�";
	//�޸�״̬
	if (isset($_REQUEST['keywords']) && $_REQUEST['keywords']!=""){
		$data['name'] = $_REQUEST['keywords'];
	}
		
	$data['page'] = $_A['page'];
	$data['epage'] = $_A['epage'];
	$data['flag_list'] = $_A['flag_list'];
	
	$result = companyClass::GetNewsList($data);
	if (is_array($result)){
		$pages->set_data($result);
		$_A['company_list'] = $result['list'];
		$_A['showpage'] = $pages->show(3);
	}else{
		$msg = array($result);
	}
}


/**
 * ��Ƹ��Ϣ
**/
elseif ($_A['query_type'] == "zhaopin"){
	$_A['list_title'] = "��˾�����б�";
	//�޸�״̬
	if (isset($_REQUEST['keywords']) && $_REQUEST['keywords']!=""){
		$data['name'] = $_REQUEST['keywords'];
	}
		
	$data['page'] = $_A['page'];
	$data['epage'] = $_A['epage'];
	$data['flag_list'] = $_A['flag_list'];
	
	$result = companyClass::GetJobList($data);
	if (is_array($result)){
		$pages->set_data($result);
		$_A['company_list'] = $result['list'];
		$_A['showpage'] = $pages->show(3);
	}else{
		$msg = array($result);
	}
}

/**
 * �鿴
**/
elseif ($_A['query_type'] == "zhaopin_edit"){
	if (isset($_POST['name']) && $_POST['name']!=""){
		$var = array("id","status","name","description","demand","num","province","city","area");
		$data = post_var($var);
		$result = companyClass::UpdateJob($data);
		$msg = array("��˲����ɹ�");
	}else{
		$data['id'] = $_REQUEST['id'];
		$_A['company_result'] = companyClass::GetJobOne($data);
	}
}
/**
 * �鿴
**/
elseif ($_A['query_type'] == "news_edit"){
	if (isset($_POST['name']) && $_POST['name']!=""){
		$var = array("id","status","name","content");
		$data = post_var($var);
		$result = companyClass::UpdateNews($data);
		$msg = array("��˲����ɹ�");
	}else{
		$data['id'] = $_REQUEST['id'];
		$_A['company_result'] = companyClass::GetNewsOne($data);
	}
}
	

//��ֹ�Ҳ���
else{
	$msg = array("���������벻Ҫ�Ҳ���","",$url);
}

?>