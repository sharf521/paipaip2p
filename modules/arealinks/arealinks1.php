<?
if (!defined('ROOT_PATH'))  die('���ܷ���');//��ֱֹ�ӷ���
check_rank("arealinks_".$_t);//���Ȩ��
$sql_admin = "";
$admin_city = "";
$_sql_admin = "";
if (in_array("areaadmin_link",explode(",",$_SESSION['purview'])) && $_SESSION['usertype']==1){
	$sql = "select * from {user} where username = '".$_SESSION['username']."' ";
	$result = $mysql ->db_fetch_array($sql);
	$admin_city = $result['city'];
	if ($admin_city!=""){
	$_sql_admin = " where city =$admin_city";
	$sql_admin = " and city =$admin_city";
	}
}

//��ע�����ȫ���ԵĻ���
$sql = "select * from {xiuwcity} where area=$city_id";
$xiuwcity = $mysql->db_fetch_array($sql);

$result = $module->get_module("arealinks");
if ($result == false && $t!="install"){
	$msg = array("��ģ����δ��װ���벻Ҫ�Ҳ���","",$url);
}else{

	/**
	 * �������Ϊ�յĻ�����ʾ���е��ļ��б�
	**/
	if ($t == ""){
		$result = $mysql->db_list_res("select * from {arealinks} $_sql_admin order by id desc",$p,$epage=10);
		$magic->assign("result",$result);
		$num = $mysql->db_count("arealinks");
		$page->set_data(array('total'=>$num,'perpage'=>$epage));
		$magic->assign("page",$page->show(3));
	}
	
	
	/**
	 * ��װ��ģ��
	**/
	elseif ($t == "install"){
		
		/**
		 * ������ݱ�
		**/
		$sql = file_get_contents("modules/arealinks/arealinks.sql");
		$mysql->db_querys($sql);
			
		
		/**���ģ��info����Ϣ
		**/
		$info = post_var("","module");
		$info['purview'] = serialize(array("arealinks"=>array("��������"=>array("arealinks_list"=>"���������б�","arealinks_new"=>"�������","arealinks_del"=>"ɾ������","arealinks_type"=>"��������"))));
		
		if ($result == false){
			$module->add_module($info);
			$msg = array("��װ�ɹ��������Լ�������ʹ�ô˹���","",$url);
		}else{
			$msg = array("���Ѿ���װ�˴�ģ�飬�����ظ���ӡ�","",$url);
		}
		
		$user->add_log($_log,$result);//��¼����
	}
	
	/**
	 * ж�ش�ģ��
	**/
	elseif ($t == "unstall"){
		$_result = $module -> unstall_module("arealinks","arealinks_type");
		$msg = array("���Ѿ��ɹ�ж����ģ��");
		$user->add_log($_log,$_result);//��¼����
		
	}
	
	/**
	 * �رմ�ģ��
	**/
	elseif ($t == "close"){
		$result = $module -> close_module("arealinks");
		$msg = array("���Ѿ��ɹ��ر��˴�ģ�飬�رպ���������ӵ�ʱ�򽫲��ῴ����ģ�顣");
		$user->add_log($_log,$result);//��¼����
	}
	
	/**
	 * �򿪴�ģ��
	**/
	elseif ($t == "open"){
		$result = $module -> open_module("arealinks");
		$msg = array("���Ѿ��ɹ������˴�ģ�飬��������������ӵ�ʱ�򽫻ῴ����ģ�顣");
		$user->add_log($_log,$result);//��¼����
	}
	
	
	/**
	 * ���
	**/
	elseif ($t == "new" || $t == "edit" ){
		if ($t == "edit"){
			$result = $mysql->db_select("arealinks","id=".$_REQUEST['id']);
			if ($admin_city!="" && $admin_city!=$result['city']){
				$msg = array("��û��Ȩ�޹�����������");
			}else{
			$magic->assign("result",$result);
			}
		}
	}
	
	elseif ($t == "add" || $t == "update"){
		if ($admin_city!="" && $admin_city!=$_POST['city']){
			$msg = array("��û��Ȩ�޹�����������");
		}else{
		
			$var = array("area","status","order","url","webname","pr","email","province","city","summary","linkman","email");
			foreach ( $var as $val){
				$index[$val] = !isset($_POST[$val])?"":$_POST[$val];
			}
			$index["flag"] = !isset($_POST["flag"])?"":join(",",$_POST["flag"]);
			$pic_name = upload('logo');
			if (is_array($pic_name)){
				$index['logo'] = $pic_name[0];
			}
			if (isset($_POST['city']) && $_POST['city']!=""){
				$index['area'] = $_POST['city'];
			}else{
				$index['area'] = $_POST['province'];
			}
			
			if ($t == "update"){
				$result = $mysql->db_update("arealinks",$index,"id=".$_POST['id']);
			}else{
				$result = $mysql->db_add("arealinks",$index);
			}
			if ($result == false){
				$msg = array("���������������Ա��ϵ");
			}else{
				$msg = array("�����ɹ�","������һҳ","$url",$msg_tpl);
			}
		}
		$user->add_log($_log,$result);//��¼����
	}
	
	/**
	 * �鿴
	**/
	elseif ($t == "view"){
		$result = $mysql->db_select("arealinks","id=".$_REQUEST['id']);
		$magic->assign("result",$result);
	}
	
	
	/**
	 * ɾ��
	**/
	elseif ($t == "del"){
		$result = $mysql->db_select("arealinks","id=".$_REQUEST['id']);
		if ($admin_city!="" && $admin_city!=$result['city']){
			$msg = array("��û��Ȩ�޹�����������");
		}else{
			$result = $mysql->db_delete("arealinks","id=".$_REQUEST['id']);
			if ($result == false){
				$msg = array("���������������Ա��ϵ");
			}else{
				$msg = array("ɾ���ɹ�");
			}
		}
		$user->add_log($_log,$result);//��¼����
	}
}


if ($msg!=""){
	$template_tpl = show_msg($msg,$msg_tpl);//�������Ϣ����ֱ�Ӷ�ȡϵͳ����Ϣģ��
}else{
	$template_tpl = "arealinks.tpl";//����������ģ���ֱ�Ӷ�ȡģ�����ڵ���Ӧģ��
	$magic->assign("template_dir","modules/arealinks/");
}

$magic->assign("module_tpl",$template_tpl);
?>