<?
/******************************
 * $File: module.php
 * $Description: ģ���ദ���ļ�
 * $Author: ahui 
 * $Time:2010-03-09
 * $Update:None 
******************************/
if (!defined('ROOT_PATH'))  die('���ܷ���');//��ֱֹ�ӷ���


require_once(ROOT_PATH.'core/module.class.php');//ģ������
$_A['list_name'] = "ģ�����";


$data['type'] = "install";
$_A['module_install_list'] = moduleClass::GetList($data);
unset($data);
/**
 * Ĭ��Ϊģ����б�
**/
if ( $_A['query_class'] == "list"){
	$_A['list_title'] = "ģ���б�";
	$_A['module_list'] = moduleClass::GetList();
}


/**
 * ���ģ��Ϊ�յĻ�����ʾ���ļ��������е�ģ��
**/
elseif ( $_A['query_class'] == "channel"){
	$_A['list_menu'] = "<a href='{$_A['query_url']}'>ȫ��ģ��</a> - <a href='{$_A['query_url']}/install'>�Ѱ�װģ��</a> - <a href='{$_A['query_url']}/unstall'>δ��װģ��</a>";
	
	if($_A['query_type'] == "list"){
		$_A['list_title'] = "ȫ��ģ��";
		$_A['module_list'] = moduleClass::GetList();
	}
	
	elseif($_A['query_type'] == "install"){
		$_A['list_title'] = "�Ѱ�װģ��";
		$data['type'] = "install";
		$_A['module_list'] = moduleClass::GetList($data);
	}
	
	elseif($_A['query_type'] == "unstall"){
		$_A['list_title'] = "δ��װģ��";
		$data['type'] = "unstall";
		$_A['module_list'] = moduleClass::GetList($data);
	}
	
	elseif($_A['query_type'] == "order"){
		moduleClass::OrderModule($_POST['module_id'],$_POST['order']);
		$msg = array("ģ�������޸ĳɹ�");
	}
	
	elseif($_A['query_type'] == "del"){
		$data['code'] = $_REQUEST['code'];
		$result = moduleClass::DeleteModule($data);
		if ($result===true){
			$msg = array("ж�سɹ�");
		}else{
			$msg = array($result);
		}
	}
	
	elseif($_A['query_type'] == "new" || $_A['query_type'] == "edit"){
		if ($_A['query_type'] == "edit"){
			$_A['list_title'] = "�༭ģ��";
			$data['code'] = $_REQUEST['code'];
			$_A['module_result'] = moduleClass::GetOne($data);
		}elseif ($_A['query_type'] == "new"){
			$_A['list_title'] = "��װģ��";
			$_A['module_result'] = get_module_info($_REQUEST['code']);
		}	
		
		if (isset($_POST['name'])){
			$var = array("name","code","status","order","default_field","description","index_tpl","list_tpl","content_tpl","search_tpl","article_status","onlyone","visit_type","title_name","fields","issent","version","author","type");
			$data = post_var($var);
			
			if ($_A['query_type'] == "edit"){
				$result = moduleClass::UpdateModule($data);;
				if ($result!=true){
					$msg = array($result);
				}else{
					$msg = array("�༭�ɹ�");
				}
			}elseif ($_A['query_type'] == "new"){
				
				$data['code'] = $_REQUEST['code'];
				$result = moduleClass::AddModule($data);
				if ($result === true){
					$msg = array("ģ�鰲װ�ɹ�","",$_A['query_url']);
				}else{
					$msg = array($result);
				}
				
				userClass::add_log($_log,$result);//��¼����
			}
		}
		
	}
}



/**
 * ģ���ֶι���
**/
elseif ( $_A['query_class'] == "fields"){
	$code = $_REQUEST['code'];
	$_A['list_menu'] = "<a href='{$_A['admin_url']}&q=module/fields&code={$code}'>�ֶι���</a>- <a href='{$_A['admin_url']}&q=module/fields/new&code={$code}'>����ֶ�</a>";
	
	if($_A['query_type'] == "list"){
		$_A['list_title'] = "ȫ���ֶ�";
		$data['code'] = $code;
		$_A['fields_list'] = moduleClass::GetFieldsList($data);
	}
	
	elseif($_A['query_type'] == "new" || $_A['query_type'] == "edit"){
		$_A['list_title'] = "�ֶι���";
		if (isset($_POST['name'])){
			$var = array("name","nid","order","code","type","size","input","description","default","select","order");
			$data = post_var($var);
			
			if ($_A['query_type'] == "new"){
				$result = moduleClass::AddFields($data);
			}else{	
				$data['fields_id'] = $_POST['fields_id'];
				$result = moduleClass::UpdateFields($data);
			}
			if ($result===true){
				$msg =array("�����ɹ���");
			}else{
				$msg = array($result);
				}
			
		}else{
			$_A['fields_type'] = fields_type();
			$_A['fields_input'] = fields_input();
			if ($_A['query_type'] == "edit"){
				$data['code'] = $_REQUEST['code'];
				$data['fields_id'] = $_REQUEST['fields_id'];
				$_A['fields_result'] = moduleClass::GetFieldsOne($data);
			}
		}
	}
	
	elseif($_A['query_type'] == "order"){
		$data['fields_id'] = $_POST['fields_id'];
		$data['order'] = $_POST['order'];
		moduleClass::OrderFields($data);
		$msg = array("�ֶ������޸ĳɹ�");
	}
	
	elseif($_A['query_type'] == "del"){
		$data['fields_id'] = $_REQUEST['fields_id'];
		$data['code'] = $_REQUEST['code'];
		$result = moduleClass::DeleteFields($data);
		$msg = array("�ֶ�ɾ���ɹ�");
	}
}

/**
 * ���������ģ�����ȡ����ģ��������ļ�
**/
else{
	$code = $_A['query_class'] ;
	
	if (!file_exists(ROOT_PATH."/modules/$code/$code.php")){
		$msg = array("ģ�鲻���ڣ������Ƿ��������");
	}else{
		
		//��ĿID����Ŀ������
		if (!isset($_REQUEST['site_id']) || $_REQUEST['site_id']==0){
			$site_id = "";
			$site_url = "";
		}else{
			require_once(ROOT_PATH.'core/site.class.php');//ģ������
			$site_id = $_REQUEST['site_id'];
			//$site = $module->get_site($site_id);
			$site_url = "&site_id=$site_id";
			$_A['site_result'] = siteClass::GetOne(array("site_id"=>$site_id));
			//$magic->assign("site_name"," -> ".$site['name']);
		}
		
		
		
		//��ȡվ�������
		if ($site_id!=""){
			$_A['list_title'] = $_A['site_result']['name'];
		}
		
		//liukun add for��վ����
		//if ($code!="manager" && $code!="user" && isset($_A['site_result']['rank']) &&!in_array($_G['user_result']['type_id'],explode(",",$_A['site_result']['rank'])) && $_G['user_result']['type_id']!=1 && !in_array("other_all",explode(",",$_SESSION['purview']))){
		if ($code!="manager" && $code!="user" && isset($_A['site_result']['rank']) &&!in_array($_G['user_result']['type_id'],explode(",",$_A['site_result']['rank'])) && $_G['user_result']['type_id']!=1 && !in_array("other_all",explode(",",$_SESSION['purview'])) && !in_array("subsite_all",explode(",",$_SESSION['purview']))){
			$msg =array( "��û�д�Ȩ�޹����վ��");
		}
		
	
		/**
		 * �رմ�ģ��
		**/
		elseif ($_A['query_type'] == "close"){
			$result = $module -> close_module($s);
			$msg = array("���Ѿ��ɹ��ر��˴�ģ�飬�رպ���������ӵ�ʱ�򽫲��ῴ����ģ�顣");
			userClass::add_log($_log,$result);//��¼����
		}
	
		/**
		 * �򿪴�ģ��
		**/
		elseif ($_A['query_type'] == "open"){
			$result = $module -> open_module($s);
			$msg = array("���Ѿ��ɹ������˴�ģ�飬��������������ӵ�ʱ�򽫻ῴ����ģ�顣");
			userClass::add_log($_log,$result);//��¼����
		}
		/**
		 * �޸�����
		**/
		elseif ($_A['query_type'] == "action"){
			
			$type = $_POST['type'];
			if ($type==0){
				$data['code'] = $_A['query_class'];
				$data['id'] = $_POST['id'];
				$data['order'] = $_POST['order'];
				$data['type'] = "order";
				$result = moduleClass::ActionModule($data);
				if ($result == false){
					$msg = array("���������������Ա��ϵ");
				}else{
					$msg = array("�޸�����ɹ�");
				}
			}elseif ($type==1 || $type==2){
				if (isset($_POST['aid'])){
					$status = array("1"=>1,"2"=>0);
					$data['code'] = $_A['query_class'];
					$data['status'] = $status[$type];
					$data['id'] = $_POST['aid'];
					$data['type'] = "status";
					$result = moduleClass::ActionModule($data);
					$msg = array("״̬�޸ĳɹ�");
				}else{
					$msg = array("��ѡ�����");
				}
			}elseif ($type==3 || $type==4 || $type==5 || $type==7  || $type==8  ){
				if (isset($_POST['aid'])){
					$flag = array("3"=>'t',"4"=>'h',"5"=>'f',"7"=>'q');
					$data['code'] = $_A['query_class'];
					if ($type=="8"){
						$data['change'] = "t,q";
					}else{
						$data['change'] = $flag[$type];
					}
					$data['flag'] = $_POST['flag'];
					$data['id'] = $_POST['aid'];
					$data['type'] = "flag";
					$result = moduleClass::ActionModule($data);
					$msg = array("״̬�޸ĳɹ�");
					
				}else{
					$msg = array("��ѡ�����");
				}
			}elseif ($type==6){
				if (isset($_POST['aid'])){
					$data['code'] = $_A['query_class'];
					$data['id'] = $_POST['aid'];
					$data['type'] = "del";
					$result = moduleClass::ActionModule($data);
					$msg = array("ɾ���ɹ�");
				}else{
					$msg = array("��ѡ�����");
				}
				
			}
			userClass::add_log($_log,$result);//��¼����
		}else{
			//��ǰģ�����Ϣ
			$_A['module_result'] = moduleClass::GetOne(array("code"=>$code));
			
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
			
			if ($_A['module_result'] == "" ){
				$msg = array("��ģ����δ��װ�����Ȱ�װ","",$_A['admin_url']."&q=module/channel/new&code=$code");
			}else{
				if (isset($_REQUEST['code'])){
					$code = $_REQUEST['code'];
				}else{
					$code = $_A['query_class'];
				}
				include_once("modules/$code/$code.php");
				$template_tpl = "{$code}.tpl";//����������ģ���ֱ�Ӷ�ȡģ�����ڵ���Ӧģ��
				$magic->assign("template_dir","modules/{$code}/");
				$magic->assign("module_tpl",$template_tpl);
			}
		}
		
	}
}
$template = "admin_module.html.php";
?>