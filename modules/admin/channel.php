<?
/******************************
 * $File: channel.php
 * $Description: ģ�����ģ�͹���
 * $Author: ahui 
 * $Time:2010-03-09
 * $Update:None 
******************************/

if (!defined('ROOT_PATH'))  die('���ܷ���');//��ֱֹ�ӷ���
check_rank("module_".$_t);//���Ȩ��
$code = empty($_REQUEST['code'])?"":$_REQUEST['code'];

$list_name = "ģ�����";
$list_menu = "<a href='{$url}/list'>ģ���б�</a> - <a href='{$url}/new'>���ģ��</a> - <a href='{$admin_url}&q=module/channel/field&code={$code}'>�ֶι���</a> - <a href='{$admin_url}&q=module/{$code}'>���ݹ���</a> ";

/**
 * ��ȡĳһ��ģ�����Ϣ
**/
if ($code != ""){
	$module_res = $module->get_module($code);
	$magic->assign("module_res",$module_res);
}

/**
 * ��ȡ��������ӵ�ģ��
**/
if ($t == "list"){
	$result = $module->get_module();
	$magic->assign("result",$result);
}

/**
 * ��Ӻͱ༭ģ��
**/
elseif ($t == "new" || $t == "edit"){
	if ($t == "new" && isset($_REQUEST['code'])){
		$result = get_module_info($_REQUEST['code']);
		$result['code'] =  $_REQUEST['code'];
		$magic->assign("result",$result);
	}
	$magic->assign("article_fields",$article_field);
	if ($t == "edit"){
		$result = $module->get_module($_REQUEST['code']);
		if ($result['type'] == "system"){
			$msg = array("ϵͳģ�Ͳ��ܱ༭");
		}else{
			$result['default_field'] = explode(",",$result['default_field']);
			$magic->assign("result",$result);
		}
	}
}

/**
 * ��Ӻ��޸�ģ��Ĳ���
**/
elseif ($t == "add" || $t == "update"){
	$var = array("name","status","order","default_field","description","index_tpl","list_tpl","content_tpl","search_tpl","article_status","onlyone","visit_type","title_name","fields","issent","version","author","type");
	$index = post_var($var);
	if (is_array($index['default_field'])){
		$index['default_field'] = join(",",$index['default_field']);
	}
	
	if ($index['name'] == ""){
		$msg = array("�������Ʋ���Ϊ��");
	}else if ($_POST['code'] =="" && $t=="add"){
		$msg =array("�ֶ�������Ϊ��");
	}else{
		if ($t == "add"){
			$index['code'] = $_POST['code'];
			$result = $module->add_module($index,"add");
			if ($result!=false) {
				 $module->create_file_info($index);
				$module->create_file($index,"sql","modules/".$query_site."/cms.sql.php");
				$module->create_file($index,"php","modules/".$query_site."/cms.index.php");
				$module->create_file($index,"tpl","modules/".$query_site."/cms.tpl.php");
			}
		}else{	
			$code = $_POST['code'];
			$result = $module->update_module($index,$code);
		}
		if ($result<0){
			if ($result==-1){
				$msg =array("ģ�����ֶ����Ѿ�����! ");	
			}else{
				$msg =array("���������������Ա��ϵ! ");
			}	
		}else{
			$msg =array("�����ɹ���");
		}
	}
	$user->add_log($_log,$result);//��¼����
}

/**
 * �ֶ�����
**/
else if ($t=="order"){
	$module_id = $_REQUEST['module_id'];
	$order = $_REQUEST['order'];
	if ($module_id!=""){
		$result = $module->order_module($module_id,$order);
		if ($result<0){
			$msg =array("�����޸�ʧ�ܣ��뷵��! Error:($result)");
		}else{
			$msg =array("�����޸ĳɹ����뷵��!");
		}
	}
}

/**
 * �ֶι���
**/
elseif ($t == "field"){
	if ($module_res['type']!="cms" && $module_res['fields']!=1){
		$msg = array("ֻ��cmsģ��������Զ����ֶεĲſ�������ֶ�");
	}else{
		$result = $module->get_fields($code);
		$magic->assign("result",$result);
	}
}


/**
 * ������ֶ�
**/
elseif ($t == "field_new"){
	$magic->assign("fields_type",fields_type());
	$magic->assign("fields_input",fields_input());
}

/**
 * �༭�ֶ�
**/
elseif ($t == "field_edit"){
	$magic->assign("fields_type",fields_type());
	$magic->assign("fields_input",fields_input());
	$magic->assign("result",$module->view_fields($_REQUEST['nid']));
}

/**
 * ��Ӻ��޸��ֶ�
**/
elseif ($t == "field_add" || $t == "field_update"){
	//��ӻ����޸��ֶ�
	$var = array("name","nid","order","type","size","input","description","default","select","order");
	$index = post_var($var);
	if ($index['type']=="varchar" || $index['type']=="int"){
		$index['size'] = 255;
	}
	if ($index['name'] == ""){
		$msg =array("�������Ʋ���Ϊ��");
	}else if ($index['nid']=="" && $t=="field_add"){
		$msg =array("�ֶ�������Ϊ��");
	}else{
		if ($t=="field_add"){
			$result = $module->add_fields($code,$index,$module_res['type']);
		}else{	
			$nid = $_POST['nid'];
			$result = $module->update_fields($code,$index,$nid,$module_res['type']);
		}
		if ($result<0){
			if ($result==-2){
				$msg =array("��ʶ���Ѿ�����! ");	
			}else if ($result==-6 || $result==-8){
				$msg =array("���������������Ա��ϵ!");
			}else if ($result==-3){
				$msg =array("�˱�ʾ��ΪĬ�ϱ�ʾ��������д������!");	
			}else{
				$msg =array("��Ӵ����������Ա��ϵ!");
			}	
		}else{
			$msg =array("�����ɹ���");
		}
	}
}

/**
 * ɾ���ֶ�
**/
else if($t=="field_del"){
	$code = $_REQUEST['code'];
	$nid = $_REQUEST['nid'];
	if ($nid==""){
		$msg =array("����������! Error:(-1)");
	}else{
		$result = $module->del_fields($code,$nid,$module_res['type']);
		if ($result<0){
			$msg =array("���������뷵��! Error:($result)");
		}else{
			$msg =array("�����ɹ����뷵��!");
		}
	}
}

/**
 * �ֶ�����
**/
else if ($t=="field_order"){
	$fields_id = $_REQUEST['fields_id'];
	$order = $_REQUEST['order'];
	if ($fields_id!=""){
		$result = $module->order_fields($fields_id,$order);
		if ($result<0){
			$msg =array("�����޸�ʧ�ܣ��뷵��! Error:($result)");
		}else{
			$msg =array("�����޸ĳɹ����뷵��!");
		}
	}
}

if ($msg!=""){
	$template_tpl = show_msg($msg,$msg_tpl);//�������Ϣ����ֱ�Ӷ�ȡϵͳ����Ϣģ��
}else{
	$template_tpl = "admin_channel.html.php";//����������ģ���ֱ�Ӷ�ȡģ�����ڵ���Ӧģ��
	$magic->assign("template_dir","");
}


$magic->assign("module_tpl",$template_tpl);

?>