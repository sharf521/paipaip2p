<?
if (!defined('ROOT_PATH'))  die('���ܷ���');//��ֱֹ�ӷ���
check_rank("manager_".$_A['query_type']);//���Ȩ��

require_once ROOT_PATH . '/config_ucenter.php';
require_once ROOT_PATH . '/uc_client/client.php';

$_A['list_purview'] = array("manager"=>array("�� �� Ա"=>array("manager_list"=>"����Ա�б�","manager_new"=>"��ӹ���Ա","manager_edit"=>"�޸Ĺ���Ա","manager_type"=>"����Ա����","manager_type_order"=>"�޸���������","manager_type_del"=>"ɾ������","manager_type_new"=>"�������","manager_type_edit"=>"�༭����")));//Ȩ��
$_A['list_name'] = "����Ա����";
$_A['list_menu'] = "<a href='{$_A['query_url']}{$_A['site_url']}'>����Ա�б�</a> - <a href='{$_A['query_url']}/new{$_A['site_url']}'>��ӹ���Ա</a> - <a href='{$_A['query_url']}/type{$_A['site_url']}'>����Ա����</a> ";
$list_table ="";

include_once(ROOT_PATH."modules/subsite/subsite.class.php");

//liukun add for bug 52 begin
$firePHPEnable=TRUE;
if ($firePHPEnable){
	require_once('modules/FirePHPCore/FirePHP.class.php');
	require_once('modules/FirePHPCore/fb.php');
	ob_start();

	$firephp = FirePHP::getInstance(true);
}
//liukun add for bug 52 end
//������Ա�����ڵķ�վ��Ϣ����
$data['areaid'] = $_SESSION['areaid'];
$_A['areaid'] =  $_SESSION['areaid'];
$_A['admin_type_id'] =  $_SESSION['type_id'];
/**
 * ����Ա�б�
**/
if ($_A['query_type'] == "list"){
	$_A['list_title'] = "�б�";
	if (isset($_POST['user_id']) && $_POST['user_id']!=""){
		userClass::ActionUser(array("user_id"=>$_POST['user_id'],"order"=>$_POST['order']));
		$msg = array("�޸ĳɹ�","",$_A['query_url'].$_A['query_site']);
	
	}else{
		$data['page'] = $_A['page'];
		$data['epage'] = $_A['epage'];
		$data['type'] = 1;
		
		$result = $user->GetList($data);
		$pages->set_data($result);
		
		$_A['user_list'] = $result['list'];
		$_A['subsite_list'] = subsiteClass::GetSubsiteList();
		$_A['showpage'] = $pages->show(3);
	}
}

/**
 * ��Ӻͱ༭�û�
**/
elseif ($_A['query_type'] == "new" || $_A['query_type'] == "edit"){
	if ($_A['query_type'] == "new" ){
		$_A['list_title'] = "��ӹ���Ա";
	}else{
		$_A['list_title'] = "�޸Ĺ���Ա";
	}
	
	if (isset($_POST['realname'])){
		$var = array("username","email","type_id","realname","birthday","password","sex","qq","wangwang","tel","phone","address","status","province","city","area","serial_id","areaid");
		$data = post_var($var);
		$data['area'] = post_area();
		$purview_usertype = explode(",",$_SESSION['purview']);
		if (!in_array("manager_new_".$data['type_id'],$purview_usertype) && !in_array("other_all",$purview_usertype) ){
			$msg = array("��û��Ȩ����ӻ�������Ĺ���Ա");
		}else{
			if ($_A['query_type'] == "new"){

				$check_username = $user->CheckUsername(array("username"=>$data['username']));
				$check_email = $user->CheckEmail(array("email"=>$data['email']));
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
						/*	// 							echo "<script>alert('$msg');location.href='index.php?user&q=action/reg';</script>";
							// 							exit();*/
						}else{
							$ucsynlogin = uc_user_synlogin($uid);
						}
					}
					if($msg){
							
					}else{
						$data['uc_user_id'] = $uid;

						$result = $user->AddUser($data);
						if ($result>0){
							$msg = array("����Ա��ӳɹ�","","{$_A['query_url']}&a=system");
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
				$check_email = $user->CheckEmail(array("email"=>$data['email'],"user_id"=>$data["user_id"]));
				if ($check_email){
					$msg = array("�����Ѿ�����");
				}else{
					$result = $user->UpdateUser($data);
					if ($result===false){
						$msg = array($result);
					}else{
						$msg = array("�޸ĳɹ�");
					}
				}
			}
		}
	}else{
		$user_type = $user->GetTypeList(array("type"=>1));
		$_A['subsite_list'] = subsiteClass::GetSubsiteList();
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
		if ($_A['query_type'] == "edit"){
			if ($_REQUEST['user_id']==1){
				$msg = array("�˹���Ա���ܱ༭,���Ҫ�޸ģ��뵽�޸ĸ�����Ϣ");
			}else{
				$_A['user_result'] = $user->GetOne(array("user_id"=>$_REQUEST['user_id']));
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
		$result = $user->DeleteUser(array("user_id"=>$_REQUEST['user_id'],"type"=>1));
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
	$_A['user_type_list'] = $user->GetTypeList(array("type"=>1));//0��ʾ�û�������1��ʾ�����������
}

/**
 * ��Ӻͱ༭�û�����
**/
elseif ($_A['query_type'] == "type_new" || $_A['query_type'] == "type_edit"){
	if (isset($_POST['name'])){
		$var = array("name","order","remark","status","summary","purview");
		$data = post_var($var);
		if ($data['purview']!=""){
			$data['type'] = 1;
			if ($_A['query_type'] == "type_new"){
				$result = $user->AddType($data);
			}else{
				$data['type_id'] = $_POST['type_id'];
				$result = $user->UpdateType($data);
			}
			if ($result == false){
				$msg = array($result);
			}else{
				$msg = array("���Ͳ����ɹ�","","{$_A['query_url']}/type");
			}
		}else{
			$msg = array("��ѡ��Ȩ��");
		}
		$user->add_log($_log,$result);//��¼����
	}else{
		if ($_A['query_type'] == "type_edit"){
			$result = $user->GetTypeOne(array("type_id"=>$_REQUEST['type_id']));
			$magic->assign("result",$result);
		}
		$_A['user_type_list'] = $user->GetTypeList(array("type"=>1));
		$_user_type = "";
		foreach ($_A['user_type_list'] as $key => $value){
			$_user_type['manager_new_'.$value['type_id']] = $value['name']; 
		}
		$_purview = array("other"=>array("����Ȩ��"=>array("other_all"=>"����Ȩ��","site_all"=>"��Ŀ����","module_all"=>"ģ�����","system_all"=>"ϵͳ����","bbs_all"=>"��̳����","subsite_all"=>"��վ�����")),
		"site"=>array("վ�����"=>array("site_list"=>"վ�����","site_new"=>"���վ��","site_edit"=>"�޸�վ��","site_move"=>"�ƶ�վ��","site_del"=>"ɾ��վ��")),
		"module"=>array("ģ�����"=>array("module_list"=>"ģ���б�","module_new"=>"���ģ��","site_edit"=>"�޸�ģ��")),
		"wzdcash"=>array("�����ѡ"=>array("account_deduct"=>"��Ա���ÿ۳�","account_vipTC"=>"�鿴��Ա����","account_cashCK"=>"���ֲο�","account_recharge_new"=>"������³�ֵ","account_recharge_view"=>"��˳�ֵ","account_cash_view"=>"�������","account_ticheng"=>"�鿴�û����","account_moneyCheck"=>"�ʽ���˱�")), 
		"wzdborrow"=>array("�Ŵ���˱�ѡ"=>array("attestation_all_s"=>"�û���Ƶ�ֳ���֤����","borrow_repayment"=>"�ѻ������","borrow_liubiao"=>"����","borrow_late"=>"����","borrow_lateFast"=>"��Ѻ�굽��","borrow_tongji"=>"����ͳ��")), 
		"system"=>array("ϵͳ����"=>array("system_info"=>"ϵͳ����","system_dbbackup"=>"���ݿⱸ��","system_watermark"=>"ͼƬˮӡ","system_email"=>"�ʼ�����","system_clearcache"=>"��ջ���","system_flag"=>"�Զ����ĵ�","system_makehtml"=>"������վ","system_fujian"=>"��������")),
		"manager_new"=>array("��ӹ���Ա"=>$_user_type)
		);
		
		$result = moduleClass::GetList(array("type"=>"install"));
// 		fb($_purview, FirePHP::TRACE);
// 		var_dump($result);
		foreach($result as $key => $value){
			if ($value['purview']!=""){
				
				//$value['purview']= preg_replace('!s:(\d+):"(.*?)";!se', "'s:'.strlen('$2').':\"$2\";'", $value['purview'] );
				//$value['purview']= str_replace("\r", "", $value['purview']);
				/*if($value['code']=='account')
				{
					$arr=unserialize($value['purview']);					
					$arr['account']['�˺��ʽ����']['account_site']='��վ�ʽ����';
					$arr['account']['�˺��ʽ����']['account_site_moneylog']='��վ�ʽ�ʹ�ü�¼';
					$arr['account']['�˺��ʽ����']['account_site_changemoney']='���ķ�վ��֤��';
					$_purview = array_merge($_purview, $arr);
					echo serialize($arr);
					print_r($arr);
				}
				else
				{
					$_purview = array_merge($_purview, unserialize(($value['purview'])));
				}*/
				//echo print_r($value['purview']);
				
				$_purview = array_merge($_purview, unserialize(($value['purview'])));
				
// 				$_purview = array_merge($_purview,$value['purview']);
			}
		}
		$_A['user_purview'] = $_purview;
	}
}




/**
 * �޸��û���������
**/
elseif ($_A['query_type'] == "type_order"){
	$data['order'] = $_POST['order'];
	$data['type_id'] = $_POST['type_id'];
	$result = $user->OrderType($data);
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
		$result = $user->DeleteType($data);
		if ($result){
			$msg = array("ɾ���ɹ�");
		}else{
			$msg = array($result);
		}
		$user->add_log($_log,$result);//��¼����
	}
}

?>