<?
if (!defined('ROOT_PATH'))  die('���ܷ���');//��ֱֹ�ӷ���

check_rank("discount_".$_A['query_type']);//���Ȩ��

require_once 'discount.class.php';


$_A['list_purview'] = array("discount"=>array("�ۿ۹���"=>array("discount_list"=>"�ۿ��б�","discount_new"=>"����ۿ�","discount_del"=>"ɾ���ۿ�","discount_company"=>"�ۿ��̼�","discount_company_new"=>"����ۿ��̼�","discount_company_new"=>"�༭�ۿ��̼�","discount_company_del"=>"ɾ���ۿ��̼�")));//Ȩ��
$_A['list_name'] = $_A['module_result']['name'];
$_A['list_menu'] = "<a href='{$_A['query_url']}/new{$_A['site_url']}'>�����ۿ���Ϣ</a> - <a href='{$_A['query_url']}{$_A['site_url']}'>�ۿ��б�</a> - <a href='{$_A['query_url']}/company{$_A['site_url']}'>�̼ҹ���</a>  - <a href='{$_A['query_url']}/company_new{$_A['site_url']}'>����̼�</a> ";

	/**
	 * �������Ϊ�յĻ�����ʾ���е��ļ��б�
	**/
if ($_A['query_type'] == "list"){
	$_A['list_title'] = "�б�";
	//�޸�״̬
	if (isset($_REQUEST['id']) && isset($_REQUEST['status'])){
		$sql = "update {discount} set status='".$_REQUEST['status']."' where id = ".$_REQUEST['id'];
		$mysql->db_query($sql);	
	}
	
	$data['page'] = $_A['page'];
	$data['epage'] = $_A['epage'];
	$result = discountClass::GetList($data);
	
	if (is_array($result)){
		$pages->set_data($result);
		$_A['discount_list'] = $result['list'];
		$_A['showpage'] = $pages->show(3);
	
	}else{
		$msg = array($result);
	}
}


/**
 * ���
**/
elseif ($_A['query_type'] == "new"  || $_A['query_type'] == "edit" || $_A['query_type'] == "view" ){
	
	$_A['list_title'] = "�ۿ۹���";
	
	$_A['discount_company_list'] =  discountClass::GetCompanyList(array("limit"=>"all"));
	if (isset($_POST['name'])){
		$var = array(
			'type',
			'business_district',
			'company_id',
			'name',
			'litpic',
			'address',
			'tag',
			'address',
			'comment',
			'province',
			'city',
			'area',
			'post_user',
			'status'
        );
		$data = post_var($var);
		
		$data['start_date'] = maketime('start_date');
		$data['end_date'] = maketime('end_date');
		if ($_A['query_type'] == "new"){
			$result = discountClass::Add($data);
		}else{
			$data['id'] = $_REQUEST['id'];
			$result = discountClass::Update($data);
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
		$result = discountClass::GetOne($data);
		if (is_array($result)){
			$_A['discount_result'] = $result;
			
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
	$result = discountClass::Delete($data);
	if ($result !== true){
		$msg = array($result);
	}else{
		$msg = array("ɾ���ɹ�");
	}
	$user->add_log($_log,$result);//��¼����
}

/**
 * ��˾�б�
**/
elseif ($_A['query_type'] == "company"){
	$data['page'] = $_A['page'];
	$data['epage'] = $_A['epage'];
	$result = discountClass::GetCompanyList($data);
	if (is_array($result)){
		$pages->set_data($result);
		$_A['discount_company_list'] = $result['list'];
		$_A['showpage'] = $pages->show(3);
	
	}else{
		$msg = array($result);
	}
}


/**
 * ���
**/
elseif ($_A['query_type'] == "company_new"  || $_A['query_type'] == "company_edit" || $_A['query_type'] == "company_view" ){
	
	$_A['list_title'] = "��˾����";
	
	if (isset($_POST['name'])){
		$var = array('name','goods','type','linkman','tel','content');
		$data = post_var($var);
		
		if ($_A['query_type'] == "new"){
			$result = discountClass::AddCompany($data);
		}else{
			$data['id'] = $_REQUEST['id'];
			$result = discountClass::UpdateCompany($data);
		}
		
		if ($result !== true){
			$msg = array($result);
		}else{
			$msg = array("�����ɹ�");
		}
		$user->add_log($_log,$result);//��¼����
	}
	
	elseif ($_A['query_type'] == "company_edit" || $_A['query_type'] == "company_view" ){
		$data['id'] = $_REQUEST['id'];
		$result = discountClass::GetCompanyOne($data);
		if (is_array($result)){
			$_A['discount_company_result'] = $result;
		}else{
			$msg = array($result);
		}
	}
	
}		

/**
 * ɾ��
**/
elseif ($_A['query_type'] == "company_del"){
	$data['id'] = $_REQUEST['id'];
	$result = discountClass::DeleteCompany($data);
	if ($result !== true){
		$msg = array($result);
	}else{
		$msg = array("ɾ���ɹ�");
	}
	$user->add_log($_log,$result);//��¼����
}


?>