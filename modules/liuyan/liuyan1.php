<?
if (!defined('ROOT_PATH'))  die('���ܷ���');//��ֱֹ�ӷ���
check_rank("liuyan_".$_t);//���Ȩ��
$module_table = "liuyan_set";//���ӱ�

$result = $module->get_module("liuyan");
if ($t=="install"){
	$list_purview =  array("liuyan"=>array("���Թ���"=>array("liuyan_list"=>"�û��б�","liuyan_reply"=>"�ظ�����","liuyan_set"=>"��������","liuyan_new"=>"�������","liuyan_edit"=>"�޸�����")));//Ȩ��
}elseif ($result == false ){
	$msg = array("��ģ����δ��װ���벻Ҫ�Ҳ���","",$url);
}else{

	$list_name = $result['name'];
	$list_menu = "<a href='{$url}/new{$site_url}'>�������</a> - <a href='{$url}{$site_url}'>�����б�</a> - <a href='{$url}/set{$site_url}'>��������</a> ";

	/**
	 * �������Ϊ�յĻ�����ʾ���е��ļ��б�
	**/
	if ($t == ""){
		$result = $mysql->db_list("liuyan");
		$magic->assign("result",$result['result']);
		$page->set_data(array('total'=>$result['num'],'perpage'=>$epage));
		$magic->assign("page",$page->show(3));
	}
	
	
	/**
	 * ��������
	**/
	elseif ($t == "set"){
		$result = $mysql->db_selects("liuyan_set");
		if ($result !=false){
			foreach ($result as $key => $value){
				$_result[$value['nid']] = $value['value'];
			}
		}else{
			die("��װ����");
		}
		$magic->assign("result",$_result);
		
	}
	elseif ($t == "set_ok"){
		$result = $mysql->db_selects("liuyan_set");
		if ($result !=false){
			foreach ($result as $key => $value){
				$_value = $_POST[$value['nid']];
				$mysql -> db_query("update {liuyan_set} set `value` = '".$_value."' where id=".$value['id']);
			}
		}
		$msg = array("�޸����óɹ�");
	}
	
	/**
	 * ���
	**/
	elseif ($t == "new" || $t == "edit" ){
		$result = $mysql->db_select("liuyan_set","nid='type'");
		$magic->assign("type_list",explode(",",$result['value']));
		if ($t == "edit"){
			$magic->assign("result",$mysql->db_select("liuyan","id=".$_REQUEST['id']));
		}
	}
	
	elseif ($t == "add" || $t == "update"){
		$var = array("title","name","email","tel","fax","company","address","type","status","content");
		$index = post_var($var);
		$pic_name = upload('litpic');
		if (is_array($pic_name)){
			$index['litpic'] = $pic_name[0];
		}
		
		if ($t == "update"){
			$result = $mysql->db_update("liuyan",$index,"id=".$_POST['id']);
		}else{
			$index['user_id'] = $_SESSION['user_id'];
			$result = $mysql->db_add("liuyan",$index);
		}
		if ($result == false){
			$msg = array("���������������Ա��ϵ");
		}else{
			$msg = array("�����ɹ�","","$url");
		}
		$user->add_log($_log,$result);//��¼����
	}
	/**
	 * �鿴
	**/
	elseif ($t == "view"){
		$result = $mysql->db_select("liuyan","id=".$_REQUEST['id']);
		$magic->assign("result",$result);
	}
	/**
	 * �ظ�
	**/
	elseif ($t == "reply"){
		$index['reply'] = $_POST['reply'];
		$index['replytime'] = time();
		$index['replyip'] = ip_address();
		$index['reply_id'] = $_SESSION['user_id'];
		$result = $mysql->db_update("liuyan",$index,"id=".$_POST['id']);
		$msg = array("�����ɹ�","","$url");
		$user->add_log($_log,$result);//��¼����
	}
	
	//ɾ��
	elseif ($t == "del"){
		$result = $mysql->db_delete("liuyan","id=".$_REQUEST['id']);
		if ($result == false){
			$msg = array("���������������Ա��ϵ");
		}else{
			$msg = array("ɾ���ɹ�");
		}
		$user->add_log($_log,$result);//��¼����
	}
}

?>