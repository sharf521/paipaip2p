<?
/******************************
 * $File: system.php
* $Description: ϵͳ����
* $Author: ahui
* $Time:2010-03-09
* $Update:None
******************************/
if (!defined('ROOT_PATH'))  die('���ܷ���');//��ֱֹ�ӷ���


include_once(ROOT_PATH."core/system.class.php");


$_A['list_name'] = "ϵͳ����";
//echo md5(123456);
if ($_A['query_class']=="list"){
	$_A['query_class'] = "user";
}
/**
 * �û���Ϣ�������޸�
 **/
if ($_A['query_class'] == "user"){
	$_A['list_title'] = "�޸ĸ�����Ϣ";
	include_once(ROOT_PATH."core/user.class.php");
	if (!isset($_POST['user_id'])){
		$_A['user_result'] = $user->GetOne(array("user_id"=>$_G['user_id']));
	}else{
		$var = array("email","realname","sex","qq","wangwang","tel","phone","address");
		$data = post_var($var);
		$data['user_id'] = $_G['user_id'];
		if (isset($_POST['password']) && $_POST['password'] != ""){
			$data['password'] = $_POST['password'];
			echo $data['password'];
			$result = $user->CheckUsernamePassword($data);
			if ($result  == false){
				$msg = array("ԭ���벻��ȷ");
			}else{
				$data['password'] = $_POST['password1'] ;
			}
		}
		if ($msg==""){
			// 			$result = $user->UpdateUser($data);
				
			// 			if ($result!==true){
			// 				$msg = array($result);
			// 			}else{
			// 				$msg = array("��Ϣ�޸ĳɹ�");
			// 			}
			if ($rdGlobal['uc_on'])
			{
				//liukun add for bug 46 begin
				//TODO liukun ���� ��UC���Ӹ�������Ĳ���
				require_once ROOT_PATH . '/config_ucenter.php';
				require_once ROOT_PATH . '/uc_client/client.php';
				$ucresult = uc_user_edit($_G['user_result']['username'], $_POST['password'], $_POST['password1']);
				//liukun add for bug 46 end
					
				if ($ucresult == -1) {
					$msg = array("�����벻��ȷ,��ʹ����̳�ĵ�¼����","",$url);
				} elseif ($ucresult == -4) {
					$msg = array("Email ��ʽ����","",$url);
				} elseif ($ucresult == -5) {
					$msg = array("Email ������ע��","",$url);
				} elseif ($ucresult == -6) {
					$msg = array("�� Email �Ѿ���ע��","",$url);
				} else{
					$result = $user->UpdateUser($data);
					if ($result == false){
						$msg = array($result);
					}else{
						$msg = array("��Ϣ�޸ĳɹ�","",$url);
					}
				}
			}else{
				$result = $user->UpdateUser($data);
				if ($result == false){
					$msg = array($result);
				}else{
					$msg = array("��Ϣ�޸ĳɹ�","",$url);
				}
			}
		}
	}
}

/**
 * ϵͳ������Ϣ����
 **/
elseif ( $_A['query_class']== "info"){
	check_rank("system_info");//���Ȩ��
	$_A['list_title'] = "ϵͳ����";
	$_A['list_menu'] = "<a href='{$_A['query_url']}'>��������</a> | <a href='{$_A['query_url']}/new'>��Ӳ���</a>";

	if ($_A['query_type'] == "list"){
		if (isset($_POST['value'])){
			$data['value'] = $_POST['value'];
			$data['class'] = "action";
			$data['style'] = "1";
			$result = systemClass::ActionSystem($data);
			if ($result==true){
				$msg = array("�����ɹ�");
			}else{
				$msg = array($result);
			}
		}else{
			$data['class'] = "list";
			$data['style'] = "1";
			$_A['system_list'] = systemClass::ActionSystem($data);
		}

	}elseif ($_A['query_type'] == "new" || $_A['query_type'] == "edit"){
		if (isset($_POST['name'])){
			$var = array("name","nid","status","type","style");
			$data = post_var($var);
			$data['class'] = "add";
			if ($_A['query_type'] == "edit"){
				$data['id'] = $_REQUEST['id'];
				$data['class'] = "update";
			}
			if ($data['type']==0 || $data['type']==3){
				$data['value'] = $_POST['value1'];
			}else{
				$data['value'] = $_POST['value2'];
			}
			$result = systemClass::ActionSystem($data);
			if ($result===true){
				$msg = array("�����ɹ�");
			}else{
				$msg = array($result);
			}
			$user->add_log($_log,$result);//��¼����
		}elseif($_A['query_type'] == "edit"){
			$data['id'] = $_REQUEST['id'];
			$data['class'] = "view";
			$data['style'] = "1";
			$result = systemClass::ActionSystem($data);
			if ($result['status']==0){
				$msg = array("�˲��������޸�");
			}else{
				$_A['system_result'] = $result;
			}
		}
	}
	elseif ($_A['query_type'] == "action"){
		$data['value'] = $_POST['value'];
		$data['class'] = "action";
		$data['style'] = "1";
		$result = systemClass::ActionSystem($data);
		if ($result['status']==0){
			$msg = array("�˲��������޸�");
		}else{
			$_A['system_result'] = $result;
		}

	}
	elseif ($_A['query_type'] == "del"){
		$result = $mysql->db_delete("system","id=".$_REQUEST['id']." and status=1");
		if ($result == false){
			$msg = array("���������������Ա��ϵ");
		}else{
			$msg = array("ɾ���ɹ�");
		}
		$user->add_log($_log,$result);//��¼����
	}
}

/**
 * ͼƬˮӡ����
 **/
elseif ($_A['query_class']== "watermark"){
	check_rank("system_watermark");//���Ȩ��
	$list_name = "ͼƬˮӡ����";
	$result = $mysql->db_selects("system","style=2");
	if ($result == false){
		$sql = "INSERT INTO  {system}  (`name` ,`nid` ,`value` ,`type` ,`style` ,`status`)VALUES ('�ϴ���ͼƬ�Ƿ�ʹ��ͼƬˮӡ����', 'con_watermark_pic', '0', '0', '2', '1'),
		( '�ɼ���ͼƬ�Ƿ�ʹ��ͼƬˮӡ����', 'con_watermark_caijipic', '0', '0', '2', '1'),
		( 'ѡ��ˮӡ���ļ�����', 'con_watermark_type', '0', '0', '2', '1'),
		( 'ˮӡ������', 'con_watermark_font', '', '0', '2', '1'),
		( 'ˮӡͼƬ�ļ���', 'con_watermark_file', '0', '0', '2', '1'),
		( 'ˮӡͼƬ���������С', 'con_watermark_size', '20', '0', '2', '1'),
		( 'ˮӡͼƬ������ɫ', 'con_watermark_color', '#FF0000', '0', '2', '1'),
		( 'ˮӡ����', 'con_watermark_word', '', '0', '2', '1'),
		( 'ˮӡλ��', 'con_watermark_position', '4', '0', '2', '1'),
		( '���ͼƬˮӡ����������', 'con_watermark_imgpct', '0', '0', '2', '1'),
		( '�������ˮӡ����������', 'con_watermark_txtpct', '0', '0', '2', '1');";
		$mysql->db_query($sql);
	}else{
		foreach ($result as $key => $value){
			$_result[$value['nid']] = $value['value'];
		}
		$magic->assign("result",$_result);
	}
	if (isset($_POST['con_watermark_pic'])){
		$var = array("con_watermark_pic","con_watermark_caijipic","con_watermark_type","con_watermark_font","con_watermark_color","con_watermark_txtpct","con_watermark_imgpct","con_watermark_word","con_watermark_size","con_watermark_position");
		$index = post_var($var);
		$pic_name = upload('con_watermark_file');
		if (is_array($pic_name)){
			$index['con_watermark_file'] = $pic_name[0];
		}
		foreach ($index as $key => $value){
			$sql = "update {system} set `value` = '".$value."' where nid='".$key."'";
			$mysql->db_query($sql);
		}
		$msg = array("��Ϣ�޸ĳɹ�");
	}
}


/**
 * ��������
 **/
elseif ($_A['query_class']== "fujian"){
	check_rank("system_fujian");//���Ȩ��
	$list_name = "��������";
	$result = $mysql->db_selects("system","style=3");

	if ($result == false){
		$sql = "INSERT INTO  {system}  (`name` ,`nid` ,`value` ,`type` ,`style` ,`status`)VALUES ( '����ͼ�Ƿ����', 'con_fujian_imgstatus', '', '0', '3', '1'),
		('����ͼĬ�Ͽ��', 'con_fujian_imgwidth', '', '0', '3', '1'),
		( '����ͼĬ�ϸ߶�', 'con_fujian_imgheight', '', '0', '3', '1'),
		( '�ϴ�ͼƬ��ȡ���', 'con_fujian_picwidth', '', '0', '3', '1'),
		( '�ϴ�ͼƬ��ȡ�߶�', 'con_fujian_picheight', '', '0', '3', '1'),
		( '�����ϴ���ͼƬ����', 'con_fujian_imgtype', '', '0', '3', '1'),
		( '�����ϴ����������', 'con_fujian_annextype', '', '0', '3', '1'),
		( '����Ķ�ý���ļ�����', 'con_fujian_mediatype', '', '0', '3', '1')
		;";
		$mysql->db_query($sql);
	}else{
		foreach ($result as $key => $value){
			$_result[$value['nid']] = $value['value'];
		}
		$magic->assign("result",$_result);
	}
	if (isset($_POST['con_fujian_imgwidth'])){
		$var = array("con_fujian_imgwidth","con_fujian_imgstatus","con_fujian_imgheight","con_fujian_picwidth","con_fujian_picheight","con_fujian_imgtype","con_fujian_annextype","con_fujian_mediatype");
		$index = post_var($var);
		foreach ($index as $key => $value){
			$sql = "update {system} set `value` = '".$value."' where nid='".$key."'";
			$mysql->db_query($sql);
		}
		$msg = array("��Ϣ�޸ĳɹ�");
	}
}


/**
 * ���ݿⱸ�ݺͻ�ԭ
 **/
elseif ($_A['query_class']== "dbbackup"){
	check_rank("system_dbbackup");//���Ȩ��
	$_A['list_title'] = "���ݿⱸ�ݻ�ԭ";
	$_A['list_menu'] = "<a href='{$_A['admin_url']}&q=system/dbbackup/back'>���ݱ���</a> - <a href='{$_A['admin_url']}&q=system/dbbackup/revert'>���ݻ�ԭ</a> ";
	$filedir = "data/dbbackup";
	//add by weego 20120703
	die("�رձ��ݻ�ԭ���ܣ�");

	//���ݿ�ı���
	if ($_A['query_type'] == "back"){
		die("�رձ��ݹ��ܣ�");
		if (isset($_POST['name'])){
			$table = $_POST['name'];
			$size = $_POST['size'];
			if ($table==""){
				$msg = array("��ѡ�����б���");
			}else if ($size<50 || $size >2000){
				$msg = array("<font color=red>���ݴ�С������50k��2000k֮��</font>");
			}else{
				/*
				 *ɾ���ļ�������ݲ����´����ļ�
				*/
				del_file($filedir);
				mk_dir($filedir);
				$_SESSION['dbbackup']['table'] = $table;
				$_SESSION['dbbackup']['size'] = $size;

				$data['table'] = $_SESSION['dbbackup']['table'];
				$data['size'] = $_SESSION['dbbackup']['size'];
				$data['tid'] = isset($_REQUEST['tid'])?$_REQUEST['tid']:0;
				$data['limit'] = isset($_REQUEST['limit'])?$_REQUEST['limit']:0;
				$data['filedir'] = $filedir;
				$data['table_page'] = isset($_REQUEST['table_page'])?$_REQUEST['table_page']:0;
				$result = systemClass::BackupTables($data);
				if ($result!=""){
					echo "���ڱ��ݣ�".$data['table'][$data['tid']]."���� �� ��{$data['limit']}�� �����ݣ��벻Ҫ�ر������������";
					$url = $_A['query_url']."/back&tid={$result['tid']}&limit={$result['limit']}&table_page={$result['table_page']}";
					echo "<script>location.href='{$url}';</script>";
					exit;
				}else{
					include_once(ROOT_PATH."core/pclzip.class.php");
					$archive = new PclZip('dbback.zip');
					$v_list = $archive->create('data/dbbackup');
					if ($v_list == 0) {
						die("Error : ".$archive->errorInfo(true));
					}
					$msg = array("���ݳɹ�");
				}
			}
		}elseif (isset($_REQUEST['tid'])){
			$data['table'] = $_SESSION['dbbackup']['table'];
			$data['size'] = $_SESSION['dbbackup']['size'];
			$data['tid'] = isset($_REQUEST['tid'])?$_REQUEST['tid']:0;
			$data['limit'] = isset($_REQUEST['limit'])?$_REQUEST['limit']:0;
			$data['filedir'] = $filedir;
			$data['table_page'] = isset($_REQUEST['table_page'])?$_REQUEST['table_page']:0;
			$result = systemClass::BackupTables($data);
			if ($result!=""){
				echo "���ڱ��ݣ�".$data['table'][$data['tid']]."���� �� ��{$data['limit']}�� �����ݣ��벻Ҫ�ر������������";
				$url = $_A['query_url']."/back&tid={$result['tid']}&limit={$result['limit']}&table_page={$result['table_page']}";
				echo "<script>location.href='{$url}';</script>";
				exit;
			}else{
				include_once(ROOT_PATH."core/pclzip.class.php");
				$archive = new PclZip(ROOT_PATH.'data/dbbackup/dbbackup.zip');
				$v_list = $archive->create('data/dbbackup');
				if ($v_list == 0) {
					die("Error : ".$archive->errorInfo(true));
				}

				$msg = array("���ݳɹ�","",$_A['query_url']."/back");
			}
		}else{

			$_result = systemClass::GetSystemTables();
			$magic->assign("result",$_result);

				
		}
	}
	else if($_A['query_type']=="show"){
		$table =$_REQUEST['table'];
		$sql = "show create table $table";
		$result = $mysql->db_fetch_array($sql);
		echo $result['Create Table'];
		exit;
	}elseif ($_A['query_type'] == "revert"){
		if (isset($_REQUEST['nameid'])){
			$data['nameid'] = $_REQUEST['nameid'];
			$data['filedir'] = $filedir;
			$data['table'] = $_SESSION['dbbackup']['vtable'];
			$result = systemClass::RevertTables($data);
			if ($result!=""){
				$nameid= $data['nameid']+1;
				echo "���ڻ�ԭ��".$result."���� ���ݣ��벻Ҫ�ر������������";
				$url = $_A['query_url']."/revert&nameid={$nameid}";
				echo "<script>location.href='{$url}';</script>";
				exit;
			}else{
				if($_SESSION['dbbackup']['delfile']!=""){
					del_dir($data['filedir']);
				}
				$msg = array("��ԭ�ɹ�","",$_A['query_url']."/revert");
			}

		}elseif (isset($_POST['name'])){
			$show =!isset($_POST['show'])?"":$_POST['show'];
			$_SESSION['dbbackup']['delfile'] = !isset($_POST['delfile'])?"":$_POST['delfile'];
			$_SESSION['dbbackup']['vtable'] = !isset($_POST['name'])?"":$_POST['name'];
			if ( file_exists(ROOT_PATH.$filedir."/show_table.sql")){
				$sql = file_get_contents(ROOT_PATH.$filedir."/show_table.sql");
				$_sql = explode("\r\n",$sql);
				foreach ($_sql as $val){
					if ($val!=""){

						$mysql->db_query($val);
					}
				}
			}
				
				
			$url = $_A['query_url']."/revert&nameid=0";
			echo "<script>location.href='{$url}';</script>";
			exit;

				
			$msg = array("��ԭ�ɹ�");
		}else{
			$result = get_file($filedir,"file");
			$magic->assign("result",$result);
		}
	}elseif ($_A['query_type'] == "revertok"){
		$show =!isset($_REQUEST['show'])?"":$_REQUEST['show'];
		$delfile = !isset($_REQUEST['delfile'])?"":$_REQUEST['delfile'];
		$table = !isset($_REQUEST['name'])?"":$_REQUEST['name'];
		if ($table!=""){
			if (file_exists($filedir."/show_table.sql")){
				$sql = file_get_contents($filedir."/show_table.sql");
				$_sql = explode("\r\n",$sql);
				foreach ($_sql as $val){
					if ($val!=""){
						$mysql->db_query($val,"true");
					}
				}
			}
				
			foreach($table as $key => $value){
				if ($value!="show_table.sql"){
					$sql = file_get_contents($filedir."/".$value);
					$_sql = explode("\r\n",$sql);
					foreach ($_sql as $val){
						if ($val!=""){
							$mysql->db_query($val,"true");
						}
					}
				}
			}
			if($delfile!=""){
				del_dir($filedir);
			}
			$msg = array("��ԭ�ɹ�");
		}else{
			$msg = array("��ѡ��Ҫ��ԭ���ֶ�");
		}

	}
	if ( !isset ($msg) || $msg==""){
		$template_tpl = "admin_dbbackup.html.php";
	}
}



/**
 * �ֻ�����
 **/
elseif ($_A['query_class']== "phone"){
	if($_POST){
		$user_online = ROOT_PATH."core/phone.inc.php"; //�����������ļ�
		touch($user_online);//���û�д��ļ����򴴽�
		if(strlen($_POST['phone_pass'])<>32) $_POST['phone_pass']=md5($_POST['phone_pass']);
		$new_date="<?php\r\n";
		$new_date.="\$_phone_username='".$_POST['phone_uid']."';\r\n";
		$new_date.="\$_phone_userpass='".$_POST['phone_pass']."';\r\n";
		$new_date.="\r\n?>";
		//д���ļ�
		$fp = fopen($user_online,"w");
		flock($fp,LOCK_EX); //flock() ������NFS�Լ�������һЩ�����ļ�ϵͳ����������
		fputs($fp,$new_date);
		flock($fp,LOCK_UN);
		fclose($fp);
		$msg = array("�޸��ֻ������ɹ�","",$_A['query_url']."/phone");
	}else{
		require_once(ROOT_PATH."core/phone.inc.php");
		$magic->assign("uid",$_phone_username);
		$magic->assign("pass",$_phone_userpass);
		$template_tpl = "admin_phone.html.php";
	}
}


/**
 * �Զ����ĵ�
 **/
elseif ($_A['query_class']== "flag"){
	check_rank("system_flag");//���Ȩ��
	$list_name = "�Զ������� ";
	if ($_A['query_type']=="order"){
		$result = $mysql->db_order("flag",$_REQUEST['order'],"id",$_REQUEST['id']);
		$msg = array("�޸�����ɹ�");
	}elseif ($_A['query_type']=="add"){
		$var = array("name","nid","order");
		$index = post_var($var);
		$result = $mysql->db_add("flag",$index,true);
		$msg = array("��ӳɹ�");
	}elseif ($_A['query_type']=="del"){
		if (isset($_REQUEST['id']) && $_REQUEST['id']>3){
			$result = $mysql->db_delete("flag","id=".$_REQUEST['id']);
			$msg = array("ɾ���ɹ�");
		}else{
			$msg = array("ɾ��ʧ��");
		}
	}else{
		$result = $mysql->db_selects("flag","","`order` desc");
		$magic->assign("result",$result);
	}
	$template_tpl = "admin_flag.html.php";
}

/**
 * �����¼
 **/
elseif ($_A['query_class']== "userlog"){
	check_rank("system_userlog");//���Ȩ��
	$data['page'] = $_A['page'];
	$data['epage'] = 25;
	$data['username']  = isset($_REQUEST['username'])?$_REQUEST['username']:"";
	$data['quer']  = isset($_REQUEST['quer'])?$_REQUEST['quer']:"";
	$result = systemClass::GetUserLog($data);
	if (is_array($result)){
		$pages->set_data($result);
		$_A['userlog_list'] = $result['list'];
		$_A['showpage'] = $pages->show(3);
	}else{
		$msg = array($result);
	}
	$template_tpl = "admin_userlog.html.php";
}

/**
 * ͼƬ����
 **/
elseif ($_A['query_class']== "upfiles"){
	check_rank("system_userlog");//���Ȩ��
	$data['page'] = $_A['page'];
	$data['epage'] = 40;
	$data['username']  = isset($_REQUEST['username'])?$_REQUEST['username']:"";
	$data['quer']  = isset($_REQUEST['quer'])?$_REQUEST['quer']:"";
	$result = systemClass::GetUpfiles($data);
	if (is_array($result)){
		$pages->set_data($result);
		$_A['upfiles_list'] = $result['list'];
		$_A['showpage'] = $pages->show(3);
	}else{
		$msg = array($result);
	}
	$template_tpl = "admin_upfiles.html.php";
}

/**
 * �û�������Ϣ����
 **/
elseif ($_A['query_class']== "cache"){
	check_rank("system_userlog");//���Ȩ��
	$data['page'] = $_A['page'];
	$data['epage'] = 40;
	$data['username']  = isset($_REQUEST['username'])?$_REQUEST['username']:"";
	$data['quer']  = isset($_REQUEST['quer'])?$_REQUEST['quer']:"";
	$result = systemClass::GetUpfiles($data);
	if (is_array($result)){
		$pages->set_data($result);
		$_A['upfiles_list'] = $result['list'];
		$_A['showpage'] = $pages->show(3);
	}else{
		$msg = array($result);
	}
	$template_tpl = "admin_upfiles.html.php";
}

/**
 * ������վ
 **/
elseif ($_A['query_class']== "makehtml"){
	check_rank("system_makehtml");//���Ȩ��
	$list_name = "������վ";
	include_once("makehtml.php");

}

/**
 * ��ջ���
 **/
elseif ($_A['query_class']== "clearcache"){
	check_rank("system_clearcache");//���Ȩ��
	if ($_A['query_type']=="do"){
		del_file("data/compile");
		$msg = array("���������");
	}
}

/**
 * ��������
 **/
elseif ($_A['query_class'] == 'email') {
	check_rank("system_email");//���Ȩ��

	$list_name = "�ʼ�����";
	$style = 4;
	$result = $mysql->db_selects("system","style={$style}");
	if (!$result) {
		$sql = "INSERT INTO  {system}  (`name` ,`nid` ,`value` ,`type` ,`style` ,`status`)VALUES
		('SMTP������', 'con_email_host', '', '0', '{$style}', '0'),
		('SMTP�������Ƿ���Ҫ��֤', 'con_email_auth', '1', '1', '{$style}', '0'),
		('�����ַ', 'con_email_email', '', '0', '{$style}', '0'),
		('��������', 'con_email_pwd', '', '0', '{$style}', '0'),
		('������Email', 'con_email_from', '', '0', '{$style}', '0'),
		('�������ǳƻ�����', 'con_email_from_name', '', '0', '{$style}', '0')";
		$mysql->db_query($sql);
	}
	if (isset($_POST['value'])) {
		$value = isset($_POST['value'])?$_POST['value']:array();
		$sql = array();
		foreach ($value as $key => $var) {
			array_push($sql, "set value='{$var}' where style='{$style}' and nid='{$key}'");
		}
		$sql = 'update {system} ' . implode(';update {system} ', $sql) . ';';
		$mysql->db_querys($sql);
		$msg = array('�����ɹ�');

	}
	else{
		$result = $mysql->db_fetch_arrays("select * from {system} where style={$style}");
		$magic->assign('result', $result);
	}
}
//liukun add for bug 37 begin

/**
 * ���ֹ���
 **/
elseif ($_A['query_class']== "biaotype"){
	//TODO bug 37 check rank
	$data['page'] = $_A['page'];
	$data['epage'] = 25;
	$data['username']  = isset($_REQUEST['username'])?$_REQUEST['username']:"";
	$data['quer']  = isset($_REQUEST['quer'])?$_REQUEST['quer']:"";
	$result = systemClass::GetUserLog($data);
	if (is_array($result)){
		$pages->set_data($result);
		$_A['userlog_list'] = $result['list'];
		$_A['showpage'] = $pages->show(3);
	}else{
		$msg = array($result);
	}
	$template_tpl = "admin_userlog.html.php";
}

//liukun add for bug 37 end
/**
 * ���������ģ�����ȡ����ģ��������ļ�
 **/
else{
	$msg = array("����������");
}


$magic->assign("html_template","admin_".(empty($_A['query_class'])?'user':$_A['query_class']).".html");
$template = "admin_system.html.php";
?>