<?
if (!defined('ROOT_PATH'))  die('���ܷ���');//��ֱֹ�ӷ���
check_rank("user_".$_A['query_type']);//���Ȩ��

require_once ROOT_PATH . '/config_ucenter.php';
require_once ROOT_PATH . '/uc_client/client.php';

require_once(ROOT_PATH."modules/subsite/subsite.class.php");

$_A['list_purview'] =  array("user"=>array("�û�����"=>array("user_list"=>"�û��б�","user_view"=>"�鿴�û���Ϣ","user_new"=>"����û�","user_edit"=>"�޸��û�","user_del"=>"ɾ���û�","user_type"=>"�û�����","user_type_order"=>"�û���������","user_type_del"=>"ɾ���û�����","user_type_new"=>"����û�����","user_type_edit"=>"�༭�û�����")));//Ȩ��
$_A['list_name'] = "�û�����";
$_A['list_menu'] = "<a href='{$_A['query_url']}{$_A['site_url']}'>�û��б�</a> - <a href='{$_A['query_url']}/new{$_A['site_url']}'>����û�</a>";
$_A['list_table'] = "";

//������Ա�����ڵķ�վ��Ϣ����
$data['areaid'] = $_SESSION['areaid'];
$_A['areaid'] =  $_SESSION['areaid'];
$_A['admin_type_id'] =  $_SESSION['type_id'];
/**
 * �û��б�
**/
if ($_A['query_type'] == "list"){
	$_A['list_title'] = "�û��б�";
	
	$data['page'] = $_A['page'];
	$data['epage'] = $_A['epage'];
	$data['type'] = 2;
	$data['username'] = urldecode(isset($_REQUEST['keywords'])?$_REQUEST['keywords']:"");
	$data['email'] = isset($_REQUEST['email'])?$_REQUEST['email']:"";
	$data['realname'] = urldecode(isset($_REQUEST['realname'])?$_REQUEST['realname']:"");
	$result = userClass::GetList($data);
	$pages->set_data($result);
	
	$_A['user_list'] = $result['list'];
	$_A['showpage'] = $pages->show(3);
}
/**
 * �û��б�
**/
if ($_A['query_type'] == "typechange"){
	$_A['list_title'] = "�û��ı���������";
	if (isset($_REQUEST['id']) && $_REQUEST['id']!=""){
		$data['id'] = $_REQUEST['id'];
		$data['status'] = $_REQUEST['status'];
		$data['type'] = "update";
		$result = userClass::TypeChange($data);
		$msg = array("�����޸ĳɹ�","",$_A['query_url']."/typechange");
	}else{
		$data['page'] = $_A['page'];
		$data['epage'] = $_A['epage'];
		$data['type'] = "list";
		//$data['type'] = 2;
		$result = userClass::TypeChange($data);
		$pages->set_data($result);
		
		$_A['user_list'] = $result['list'];
		$_A['showpage'] = $pages->show(3);
	}
}
	
	
	/**
	 * ��Ӻͱ༭�û�
	**/
/**
 * ��Ӻͱ༭�û�
**/
elseif ($_A['query_type'] == "new" || $_A['query_type'] == "edit" || $_A['query_type'] == "view"){
	if ($_A['query_type'] == "new" ){
		$_A['list_title'] = "����û�";
	}else{
		$_A['list_title'] = "�޸��û�";
	}
	
	if (isset($_POST['realname'])){
		$var = array("type_id","username","email","realname","password","sex","qq","wangwang","tel","phone","address","status","province","city","area","card_type","card_id","islock","invite_userid","invite_money","serial_id","areaid");
		$data = post_var($var);
		$data['area'] = post_area();
		$data['birthday'] = get_mktime($_POST['birthday']);
		$purview_usertype = explode(",",$_SESSION['purview']);
		if (!in_array("manager_new_".$index['type_id'],$purview_usertype) && !in_array("other_all",$purview_usertype) ){
			$msg = array("��û��Ȩ����ӻ�������Ĺ���Ա");
		}else{
			if ($_A['query_type'] == "new"){
				$check_username = userClass::CheckUsername(array("username"=>$data['username']));
				$check_email = userClass::CheckEmail(array("email"=>$data['email']));
				if ($check_username) {
					$msg = array("�û����Ѿ�����");
				}elseif ($check_email){
					$msg = array("�����Ѿ�����");
				}else{
					if ($rdGlobal['uc_on'])
					{
						$uid = uc_user_register($data["username"], $data["password"], $data["email"]);
						if ($uid <= 0) {
							if ($uid == -1) {
								$msg = '�û������Ϸ�';
							} elseif ($uid == -2) {
								$msg = '����Ҫ����ע��Ĵ���';
							} elseif ($uid == -3) {
								$msg = '�û����Ѿ�����';
							} elseif ($uid == -4) {
								$msg = 'Email ��ʽ����';
							} elseif ($uid == -5) {
								$msg = 'Email ������ע��';
							} elseif ($uid == -6) {
								$msg = '�� Email �Ѿ���ע��';
							} else {
								$msg = 'δ����';
							}
						}
						if ($msg){
							/* 							echo "<script>alert('$msg');location.href='index.php?user&q=action/reg';</script>";
							// 							exit();*/
						}else{
							$ucsynlogin = uc_user_synlogin($uid);
						}
					}
					//���û�д�����Ϣ����ʾ�ɹ�����
					if($msg){

					}else{
						//����uc user id
						$data['uc_user_id'] = $uid;

						$result = userClass::AddUser($data);
						if ($result>0){
							$msg = array("�û���ӳɹ�","",$_A['query_url']);
						}else{
							$msg = array($result);
						}
					}
				}
				
			}else{
				if ($data['password']==""){
					unset($data['password']);
				}
				$data["user_id"] = $_POST['user_id'];
				$check_email = userClass::CheckEmail(array("email"=>$data['email'],"user_id"=>$data["user_id"]));
				if ($check_email==true){
					$msg = array("�����Ѿ�����");
				}else{
					$result = $user->UpdateUser($data);
					if ($_POST['kefu_userid']!=""){
						$sql = "update  {user_cache}  set kefu_userid=".$_POST['kefu_userid']." where user_id='{$data['user_id']}'";
						$mysql->db_query($sql);
					}
					if ($result===false){
						$msg = array($result);
					}else{
						$msg = array("�޸ĳɹ�");
					}
				}
			}
		}
	}else{
		$_A['subsite_list'] = subsiteClass::GetSubsiteList();
		
		$user_type = userClass::GetTypeList(array("type"=>2));
		if ($user_type==false){
			$msg = array("��û�����ͣ��������","����û�����","{$_A['query_url']}/type_new");
		}else{
			foreach ($user_type as $key => $value){
				$purview_usertype = explode(",",$_SESSION['purview']);
				if (in_array("manager_new_".$value['type_id'],$purview_usertype) || in_array("other_all",$purview_usertype) ){
					$list_type[$value['type_id']] = $value['name']; 
				}
			}
			$magic->assign("list_type",$list_type);
		}
		if ($_A['query_type'] == "edit" || $_A['query_type'] == "view"){
			if ($_REQUEST['user_id']==1){
				$msg = array("�˹���Ա���ܱ༭,���Ҫ�޸ģ��뵽�޸ĸ�����Ϣ");
			}else{
				$_A['user_result'] = userClass::GetOne(array("user_id"=>$_REQUEST['user_id']));
			}
			
			//�û��Ĳ鿴
			if ($_A['query_type'] == "view"){
				$magic->assign("_A",$_A);
				$magic->display("view.tpl","modules/user");exit;
			}
		}
	}
}

	
	
/**
 * ɾ���û�
**/
elseif ($_A['query_type'] == "del"){
	if ($_REQUEST['user_id']==1){
		$msg = array("���û�����ɾ��");
	}else{
		//repair by weego 20120703
		//$result = userClass::DeleteUser(array("user_id"=>$_REQUEST['user_id'],"type"=>2));
		$msg = array("���û�����ɾ��");
		if ($result == false){
			$msg = array("���������������Ա��ϵ");
		}else{
			$msg = array("ɾ���ɹ�");
		}
	}
	$user->add_log($_log,$result);//��¼����
}


/**
 * �û������б�
**/
elseif ($_A['query_type'] == "type"){
	$_A['user_type_list'] = userClass::GetTypeList(array("type"=>2));//0��ʾ�û�������1��ʾ�����������
}

/**
 * ��Ӻͱ༭�û�����
**/
elseif ($_A['query_type'] == "type_new" || $_A['query_type'] == "type_edit"){
	if (isset($_POST['name'])){
		$var = array("name","order","remark","status","summary","purview");
		$data = post_var($var);
		$data['type'] = 2;
		if ($_A['query_type'] == "type_new"){
			$result = userClass::AddType($data);
		}else{
			$data['type_id'] = $_POST['type_id'];
			$result = userClass::UpdateType($data);
		}
		if ($result == false){
			$msg = array($result);
		}else{
			$msg = array("���Ͳ����ɹ�","","{$_A['query_url']}/type");
		}
		
		$user->add_log($_log,$result);//��¼����
	}else{
		if ($_A['query_type'] == "type_edit"){
			$result = userClass::GetTypeOne(array("type_id"=>$_REQUEST['type_id']));
			$magic->assign("result",$result);
		}
	}
}




/**
 * �޸��û���������
**/
elseif ($_A['query_type'] == "type_order"){
	$data['order'] = $_POST['order'];
	$data['type_id'] = $_POST['type_id'];
	$result = userClass::OrderType($data);
	if ($result == false){
		$msg = array("���������������Ա��ϵ");
	}else{
		$msg = array("�����޸ĳɹ�");
	}
	$user->add_log($_log,$result);//��¼����
}


/**
 * ɾ���û�����
**/
elseif ($_A['query_type'] == "type_del"){
	$data['type_id'] = $_REQUEST['type_id'];
	if ($data['type_id']==1){
		$msg = array("��������Ա���ͽ�ֹɾ��");
	}else{
		$result = userClass::DeleteType($data);
		if ($result){
			$msg = array("ɾ���ɹ�");
		}else{
			$msg = array($result);
		}
		$user->add_log($_log,$result);//��¼����
	}
}


/**
 * VIP�û�
**/
elseif ($_A['query_type'] == "vip"){
	$type = isset($_REQUEST['type'])?$_REQUEST['type']:"-1";
	
	$result = userClass::GetList(array("isvip"=>$type));//0��ʾ�û�������1��ʾ�����������
	$pages->set_data($result);
	
	$_A['user_vip_list'] = $result['list'];
	$_A['showpage'] = $pages->show(3);
	
}
/**
 * VIP��˲鿴
**/
elseif ($_A['query_type'] == "vipview"){
	if (isset($_POST['isvip'])){
		$var = array("isvip","vip_veremark");
		$data = post_var($var);
		if ($data['isvip']==1){
			$data['vip_time'] = time();
		}
		$data['user_id'] = $_POST['user_id'];
		$result = userClass::UpdateUser($data);
		
		if ($result == false){
			$msg = array($result);
		}else{
                    
			$msg = array("VIP�û���˳ɹ�","","{$_A['query_url']}/vip");
		}
		
		$user->add_log($_log,$result);//��¼����
	}else{
		$_A['user_result'] = userClass::GetOne(array("user_id"=>$_REQUEST['user_id']));
	}
}
?>