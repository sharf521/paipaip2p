<?
if (!defined('ROOT_PATH'))  die('���ܷ���');//��ֱֹ�ӷ���
check_rank("ad_".$_A['query_type']);//���Ȩ��

include_once("ad.class.php");

$_A['list_purview'] =  array("ad"=>array("������"=>array("ad_list"=>"����б�","ad_view"=>"�鿴���","ad_new"=>"��ӹ��","ad_edit"=>"�༭���","ad_del"=>"ɾ�����")));//Ȩ��
$_A['list_name'] = $_A['module_result']['name'];
$_A['list_menu'] = "<a href='{$_A['query_url']}/new{$_A['site_url']}'>��ӹ��</a> - <a href='{$_A['query_url']}{$_A['site_url']}'>����б�</a> ";
$_A['list_table'] = "";


/**
 * �������Ϊ�յĻ�����ʾ���е��ļ��б�
**/
if ($_A['query_type'] == "list"){
	$_A['list_title'] = "����б�";
	//�޸�״̬
	if (isset($_REQUEST['id']) && isset($_REQUEST['status'])){
		$sql = "update {ad} set status='".$_REQUEST['status']."' where id = ".$_REQUEST['id'];
		$mysql->db_query($sql);	
	}
	
	if (isset($_REQUEST['keywords']) && $_REQUEST['keywords']!=""){
		$data['name'] = $_REQUEST['keywords'];
	}
		
	$data['page'] = $_A['page'];
	$data['epage'] = $_A['epage'];
	
	$result = adClass::GetList($data);
	if (is_array($result)){
		$pages->set_data($result);
		$_A['ad_list'] = $result['list'];
		
		
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
		$_A['list_title'] = "��ӹ��";
	}else{
		$_A['list_title'] = "�޸Ĺ��";
	}
	if (isset($_POST['name'])){
		//ģ���ֶεı�
		$var = array("nid","name","timelimit","firsttime","endtime","content","endcontent");
		$data = post_var($var);
		$data['firsttime'] =  get_mktime($data['firsttime']);
		$data['endtime'] =  get_mktime($data['endtime']);
		$_G['upimg']['file'] = "litpic";
		$pic_result = $upload->upfile($_G['upimg']);
		if ($pic_result!=""){
			$data['litpic'] = $pic_result['filename'];
		}
		//��ӱ��Ĵ���
		if ($_A['query_type'] == "new"){
			$result = adClass::Add($data);
			if ($result>0){
				$msg = array("��ӳɹ�","",$_A['query_url']);
			}else{
				$msg = array($result);
			}
		}
		//�޸ı��Ĵ���
		else{
			$data['id'] = $_POST['id'];
			$result = adClass::Update($data);
			if ($result){
				$msg = array("�޸ĳɹ�","",$_A['query_url']);
			}else{
				$msg = array($result);
			}
		}
		
		//userClass::add_log($_log,$result);//��¼����
	}else{
		//��֤����ģ�����Ŀ
		$_A['site_list'] = siteClass::GetList(array("code"=>"ad"));
		
		
		//��ȡ�༭����Ϣ
		if ($_A['query_type'] == "edit"){
			$data['id'] = $_REQUEST['id'];
			$result = adClass::GetOne($data);
			if (is_array($result)){
				$_A['ad_result'] = $result;
			}else{
				$msg = array($result);
			}
			
		}
	
	}
}

/**
 * �鿴
**/
elseif ($_A['query_type'] == "view"){
	$_A['ad_result'] = adClass::GetOne(array("id"=>$_REQUEST['id']));
}
	
	
/**
 * ɾ��
**/
elseif ($_A['query_type'] == "del"){
	$id = $_REQUEST['id'];
	$result = adClass::Delete(array("id"=>$id));
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