<?
if (!defined('ROOT_PATH'))  die('���ܷ���');//��ֱֹ�ӷ���
check_rank("attestation_".$_A['query_type']);//���Ȩ��

include_once("attestation.class.php");
include_once(ROOT_PATH."modules/account/account.class.php");
require_once("modules/remind/remind.class.php");
require_once("modules/subsite/subsite.class.php");
require_once(ROOT_PATH."core/webservice.php");
require_once("modules/account/wsaccount.class.php");

//������Ա�����ڵķ�վ��Ϣ����
$data['areaid'] = $_SESSION['areaid'];
$_A['areaid'] =  $_SESSION['areaid'];
$_A['admin_type_id'] =  $_SESSION['type_id'];

$_A['list_purview'] =  array("attestation"=>array("֤������"=>array("attestation_list"=>"֤���б�",
		"attestation_new"=>"���֤��",
		"attestation_edit"=>"�༭֤��",
		"attestation_del"=>"ɾ��֤��",
		"attestation_view"=>"���֤��",
		"attestation_type_list"=>"�����б�",
		"attestation_type_new"=>"�������",
		"attestation_type_edit"=>"�༭����",
		"attestation_type_del"=>"ɾ������",
		"attestation_realname"=>"ʵ����֤",
		"attestation_all"=>"�û���֤��Ϣ",
		"attestation_all_s"=>"�û���֤��Ϣ",
		"attestation_vip"=>"vip��֤",
		"attestation_vipview"=>"vip���",
		"attestation_viewall"=>"�û���֤�б�",
		"attestation_audit"=>"�û���֤����",
		"attestation_view_all"=>"�û���֤�鿴",
		"attestation_subsite_view"=>"��վ����û�֤��",
		"attestation_subsite_audit"=>"��վ����û���֤")));//Ȩ��

// $data['purview'] = serialize($_A['list_purview']);
// echo serialize($_A['list_purview']);
$_A['list_name'] = $_A['module_result']['name'];
if($_G['user_result']['type_id']==3){
	$_A['list_menu'] = " <a href='{$_A['query_url']}/viewall{$_A['site_url']}'>�鿴���е��û�</a>  - <a href='{$_A['query_url']}/vip{$_A['site_url']}'>vip���</a>";
}elseif($_G['user_result']['type_id']==4){
	$_A['list_menu'] = " <a href='{$_A['query_url']}/viewall{$_A['site_url']}'>�鿴���е��û�</a> -  <a href='{$_A['query_url']}/vip{$_A['site_url']}'>vip���</a>   - <a href='{$_A['query_url']}/vip{$_A['site_url']}&type=1'>vip��֤</a>  - <a href='{$_A['query_url']}/all{$_A['site_url']}'>�û���֤��Ϣ</a> - <a href='{$_A['query_url']}/viewall{$_A['site_url']}'>�鿴���е��û�</a>";
}else{
	$_A['list_menu'] = "<a href='{$_A['query_url']}{$_A['site_url']}'>֤���б�</a> - <a href='{$_A['query_url']}/new{$_A['site_url']}'>���֤��</a> - <a href='{$_A['query_url']}/type_list{$_A['site_url']}'>�����б�</a> - <a href='{$_A['query_url']}/type_new{$_A['site_url']}'>�������</a> - <a href='{$_A['query_url']}/realname{$_A['site_url']}'>ʵ����֤</a>  - <a href='{$_A['query_url']}/vip{$_A['site_url']}'>vip���</a>  - <a href='{$_A['query_url']}/vip{$_A['site_url']}&type=1'>vip��֤</a>  - <a href='{$_A['query_url']}/all{$_A['site_url']}'>�û���֤��Ϣ</a> - <a href='{$_A['query_url']}/viewall{$_A['site_url']}'>�鿴���е��û�</a> ";
}

/**
 * �������Ϊ�յĻ�����ʾ���е��ļ��б�
 **/
if ($_A['query_type'] == "list"){
	$_A['list_title'] = "֤���б�";

	if (isset($_REQUEST['user_id']) && $_REQUEST['user_id']!=""){
		$data['user_id'] = $_REQUEST['user_id'];
	}
	if (isset($_REQUEST['type_id'])  && $_REQUEST['type_id']!=""){
		$data['type_id'] = $_REQUEST['type_id'];
	}
	if (isset($_REQUEST['username']) && $_REQUEST['username']!=""){
		$data['username'] = $_REQUEST['username'];
	}
	if (isset($_REQUEST['realname']) && $_REQUEST['realname']!=""){
		$data['realname'] = $_REQUEST['realname'];
	}
	if (isset($_REQUEST['status']) && $_REQUEST['status']!=""){
		$data['status'] = $_REQUEST['status'];
	}

	$data['page'] = $_A['page'];
	$data['epage'] = $_A['epage'];
	$result = attestationClass::GetList($data);

	if (is_array($result)){
		$pages->set_data($result);
		$_A['attestation_list'] = $result['list'];
		$_A['showpage'] = $pages->show(3);

	}else{
		$msg = array($result);
	}
}

/**
 * �������Ϊ�յĻ�����ʾ���е��ļ��б�
 **/
elseif ($_A['query_type'] == "viewall"){
	$_A['list_title'] = "�鿴���е���Ϣ";

	if($_G['user_result']['type_id']==3){
		$data['kefu_userid'] = $_G['user_id'];
	}
	if (isset($_REQUEST['username']) && $_REQUEST['username']!=""){
		$data['username'] = urldecode($_REQUEST['username']);
	}
	if (isset($_REQUEST['realname']) && $_REQUEST['realname']!=""){
		$data['realname'] = urldecode($_REQUEST['realname']);
	}
	if (isset($_REQUEST['keywords']) && $_REQUEST['keywords']!=""){
		$data['username'] = urldecode($_REQUEST['keywords']);
	}
	$data['page'] = $_A['page'];
	$data['epage'] = $_A['epage'];
	$result = userClass::GetList($data);

	if (is_array($result)){
		$pages->set_data($result);
		$_A['viewall_list'] = $result['list'];
		$_A['showpage'] = $pages->show(3);

	}else{
		$msg = array($result);
	}
}
/**
 * VIP��˲鿴
 **/
elseif ($_A['query_type'] == "view_all"){
	if (isset($_POST['vip_status'])){

	}else{
		$_A['user_result'] = userClass::GetOne(array("user_id"=>$_REQUEST['user_id']));
		if ($_A['user_result']['kefu_userid']!=$_G['user_id'] && $_G['user_result']['type_id']==3){
			$msg = array("�벻Ҫ�Ҳ���");
		}
		include_once(ROOT_PATH."modules/userinfo/userinfo.class.php");
		$_A['userinfo_result'] = userinfoClass::GetOne(array("user_id"=>$_REQUEST['user_id']));
	}
}
/**
 * ���
 **/
elseif ($_A['query_type'] == "new" || $_A['query_type'] == "edit" ){
	if ($_A['query_type'] == "new"){
		$_A['list_title'] = "���֤��";
	}else{
		$_A['list_title'] = "�޸�֤��";
	}
	if (isset($_POST['type_id'])){
		$var = array("type_id","content","litpic","user_id","litpic","status","jifen");
		$data = post_var($var);


		if ($_A['query_type'] == "new"){
			$result = attestationClass::Add($data);
		}else{
			$data['id'] = $_POST['id'];
			$result = attestationClass::Update($data);
		}

		if ($result !== true){
			$msg = array($result);
		}else{
			$msg = array("�����ɹ�");
		}
		$user->add_log($_log,$result);//��¼����
	}elseif ($_A['query_type'] == "edit" ){

		$_A['attestation_type_list'] = attestationClass::GetTypeList(array("limit"=>"all"));

		$data['id'] = $_REQUEST['id'];
		$result = attestationClass::GetOne($data);
		if (is_array($result)){
			$_A['attestation_result'] = $result;
		}else{
			$msg = array($result);
		}


	}else{
		$_A['attestation_type_list'] = attestationClass::GetTypeList(array("limit"=>"all"));
	}
}

/**
 * �鿴
 **/
elseif ($_A['query_type'] == "view"){
	require_once("modules/credit/credit.class.php");
	require_once("modules/message/message.class.php");
	$_A['list_title'] = "�鿴��֤";
	$result = creditClass::GetTypeOne(array("nid"=>"zhengjian"));
	$_A['arrestation_value'] = $result['value'];
	$_A['credit_type_id'] = $result['id'];
	$_A['credit_type_name'] = $result['name'];
	if (isset($_POST['id'])){
		// 		if($_SESSION['valicode']!=$_POST['valicode']){
		if(1==2){
			$msg = array("��֤�벻��ȷ");
		}else{
			if (isset($_POST['subsite_remark'])){
				$update_data['id'] = $_POST['id'];
				$update_data['subsite_remark'] = $_POST['subsite_remark'];

				$result = attestationClass::Update($update_data);//��������״̬
				$msg = array("�����ɹ�","",$_A['query_url'].$_A['query_site']);
			}else{
				$var = array("id","status","verify_remark","jifen");
				$data = post_var($var);
				$data['verify_user'] = $_G['user_id'];
				$data['verify_time'] = time();
				if ($data['status']!=1){
					$data['jifen'] = 0;
				}
				$attestation_result = attestationClass::GetOne(array("id"=>$data['id']));
				if ($attestation_result['status']==1){
					$msg = array("��֤���Ѿ����ͨ�����벻Ҫ�ظ���ˡ�");
				}elseif ($data['status']==1){
					$user_id = $_POST['user_id'];

					$result = attestationClass::Update($data);//��������״̬
					$credit['nid'] = "zhengjian";
					$credit['user_id'] = $_POST['user_id'];
					$credit['value'] = $data['jifen'];
					$credit['op_user'] = $_G['user_id'];
					$credit['op'] = 1;//����
					$credit['type_id'] = $_A['credit_type_id'];
					$credit['remark'] = $data['verify_remark'];
					creditClass::UpdateCredit($credit);//���»���

					//liukun add for bug 35 begin
					if ($_POST['fee'] > 0){
						$account_result =  accountClass::GetOne(array("user_id"=>$user_id));//��ȡ��ǰ�û������

						$log['user_id'] = $user_id;
						$log['type'] = "attestation_fee";
						$log['money'] = $_POST['fee'];
						$log['total'] = $account_result['total']-$log['money'];
						$log['use_money'] =  $account_result['use_money']-$log['money'];
						$log['no_use_money'] =  $account_result['no_use_money'];
						$log['collection'] =  $account_result['collection'];
						$log['to_user'] = 0;
						$log['remark'] = "��������շ�";

						accountClass::AddLog($log);//��Ӽ�¼
					}
					//liukun add for bug 35 end
					$message['sent_user'] = $_G['user_id'];
					$message['receive_user'] = $_POST['user_id'];
					$message['name'] = "{$_POST['type_name']}���ͨ������{$data['jifen']}��";
					$message['content'] = "{$_POST['type_name']}���ͨ������{$data['jifen']}��".$data['verify_remark'];
					$message['type'] = "system";
					$message['status'] = 0;
					messageClass::Add($message);//���Ͷ���Ϣ
					$msg = array("�����ɹ�","",$_A['query_url'].$_A['query_site']);
				}elseif ($data['status']==2){
					$message['sent_user'] = $_G['user_id'];
					$message['receive_user'] = $_POST['user_id'];
					$message['name'] = "{$_POST['type_name']}���δͨ��";
					$message['content'] = $data['verify_remark'];
					$message['type'] = "system";
					$message['status'] = 0;
					messageClass::Add($message);//���Ͷ���Ϣ
					$result = attestationClass::Update($data);//��������״̬
					$msg = array("�����ɹ�","",$_A['query_url'].$_A['query_site']);
				}
			}
			$_SESSION['valicode'] = "";
		}
		$user->add_log($_log,$result);//��¼����
	}else{
		$data['id'] = $_REQUEST['id'];
		$_A['attestation_result'] = attestationClass::GetOne($data);
		if ($_A['attestation_result']['status']==1){
			$msg = array("����Ϣ��ͨ����֤���벻Ҫ������֤");
		}

		if ($_SESSION['areaid'] !=0){
			$_A['query_type'] = "subsite_view";
		}
	}
}


/**
 * ɾ��
 **/
elseif ($_A['query_type'] == "del"){
	$data['id'] = $_REQUEST['id'];
	$result = attestationClass::Delete($data);
	if ($result !== true){
		$msg = array($result);
	}else{
		$msg = array("ɾ���ɹ�");
	}
	$user->add_log($_log,$result);//��¼����
}

/**
 * �������Ϊ�յĻ�����ʾ���е��ļ��б�
 **/
elseif ($_A['query_type'] == "type_list"){
	$_A['list_title'] = "֤���б�";

	if (isset($_REQUEST['user_id'])){
		$data['user_id'] = $_REQUEST['user_id'];
	}
	if (isset($_REQUEST['type_id'])){
		$data['type_id'] = $_REQUEST['type_id'];
	}
	if (isset($_REQUEST['username'])){
		$data['username'] = $_REQUEST['username'];
	}

	$data['limit'] = "all";
	$result = attestationClass::GetTypeList($data);
	if (is_array($result)){
		$_A['attestation_type_list'] = $result;
	}else{
		$msg = array($result);
	}
}


/**
 * ���
 **/
elseif ($_A['query_type'] == "type_new" || $_A['query_type'] == "type_edit" ){
	if ($_A['query_type'] == "type_new"){
		$_A['list_title'] = "���֤��";
	}else{
		$_A['list_title'] = "�޸�֤��";
	}
	if (isset($_POST['name'])){
		$var = array("name","order","summary","remark","status","jifen","fee", "urgent_fee");
		$data = post_var($var);

		if ($_A['query_type'] == "type_new"){
			$result = attestationClass::AddType($data);
		}else{
			$data['type_id'] = $_POST['type_id'];
			$result = attestationClass::UpdateType($data);
		}

		if ($result !== true){
			$msg = array($result);
		}else{
			$msg = array("�����ɹ�");
		}
		$user->add_log($_log,$result);//��¼����
	}elseif ($_A['query_type'] == "type_edit" ){
		$data['type_id'] = $_REQUEST['type_id'];
		$result = attestationClass::GetTypeOne($data);
		if (is_array($result)){
			$_A['attestation_type_result'] = $result;
		}else{
			$msg = array($result);
		}
	}
}



/**
 * ɾ��
 **/
elseif ($_A['query_type'] == "type_del"){
	$data['type_id'] = $_REQUEST['type_id'];
	$result = attestationClass::DeleteType($data);
	if ($result !== true){
		$msg = array($result);
	}else{
		$msg = array("ɾ���ɹ�");
	}
	$user->add_log($_log,$result);//��¼����
}

/**
 * �޸��û���������
 **/
elseif ($_A['query_type'] == "type_order"){
	$data['order'] = $_POST['order'];
	$data['type_id'] = $_POST['type_id'];
	$result = attestationClass::OrderType($data);
	if ($result == false){
		$msg = array("���������������Ա��ϵ");
	}else{
		$msg = array("�����޸ĳɹ�");
	}
	$user->add_log($_log,$result);//��¼����
}

/**
 * �������Ϊ�յĻ�����ʾ���е��ļ��б�
 **/
elseif ($_A['query_type'] == "realname"){
	$_A['list_title'] = "ʵ����֤";

	$data['page'] = $_A['page'];
	$data['epage'] = $_A['epage'];
	if (isset($_REQUEST['real_status'])){
		if ($_REQUEST['real_status']==1){
			$data['real_status'] = "1";
		}elseif($_REQUEST['real_status']==0){
			$data['real_status'] = "0";
		}
		else{
			$data['real_status'] = "2";
		}
	}else{
		$data['real_status'] = "0,1,2";
	}
	if (isset($_REQUEST['username'])){
		$data['username'] = urldecode($_REQUEST['username']);
	}
	$data['order'] = "real_status";
	$result = userClass::GetList($data);

	if (is_array($result)){

		$pages->set_data($result);
		$_A['user_real_list'] = $result['list'];
		$_A['showpage'] = $pages->show(3);

	}else{
		$msg = array($result);
	}
}

/**
 * �û����е������Ϣ
 **/
elseif ($_A['query_type'] == "all"){
	$_A['list_title'] = "�û���ص���֤��Ϣ";

	$data['page'] = $_A['page'];
	$data['epage'] = $_A['epage'];
	if (isset($_REQUEST['username'])){
		$data['username'] = urldecode($_REQUEST['username']);
	}
	if (isset($_REQUEST['realname'])){
		$data['realname'] = urldecode($_REQUEST['realname']);
	}
	if (isset($_REQUEST['type'])){
		if ($_REQUEST['type']=="phone"){
			$data['phone_status'] = 1;
			if (isset($_REQUEST['typeStatus'])){
				if ($_REQUEST['typeStatus']=="2"){
					$data['phone_status'] = 2;
				}
			}
		}elseif ($_REQUEST['type']=="video"){
			$data['video_status'] = 1;
			if (isset($_REQUEST['typeStatus'])){
				if ($_REQUEST['typeStatus']=="2"){
					$data['video_status'] = 2;
				}
			}
		}elseif ($_REQUEST['type']=="email"){
			$data['email_status'] = 1;
			if (isset($_REQUEST['typeStatus'])){
				if ($_REQUEST['typeStatus']=="2"){
					$data['email_status'] = 2;
				}
			}
		}elseif ($_REQUEST['type']=="scene"){
			$data['scene_status'] = 1;
			if (isset($_REQUEST['typeStatus'])){
				if ($_REQUEST['typeStatus']=="2"){
					$data['scene_status'] = 2;
				}
			}
		}elseif ($_REQUEST['type']=="realname"){
			$data['real_status'] = 1;
			if (isset($_REQUEST['typeStatus'])){
				if ($_REQUEST['typeStatus']=="2"){
					$data['real_status'] = 2;
				}
			}
		}
	}
	$result = userClass::GetList($data);

	if (is_array($result)){
		$pages->set_data($result);
		$_A['user_all_list'] = $result['list'];
		$_A['showpage'] = $pages->show(3);

	}else{
		$msg = array($result);
	}
}

/**
 * �û����е������Ϣ
 **/
elseif ($_A['query_type'] == "all_s"){
	$_A['list_title'] = "�û���ص���֤��Ϣ";

	$data['page'] = $_A['page'];
	$data['epage'] = $_A['epage'];
	if (isset($_REQUEST['username'])){
		$data['username'] = $_REQUEST['username'];
	}
	if (isset($_REQUEST['realname'])){
		$data['realname'] = $_REQUEST['realname'];
	}
	if (isset($_REQUEST['type'])){
		if ($_REQUEST['type']=="phone"){
			$data['phone_status'] = 1;
			if (isset($_REQUEST['typeStatus'])){
				if ($_REQUEST['typeStatus']=="2"){
					$data['phone_status'] = 2;
				}
			}
		}elseif ($_REQUEST['type']=="video"){
			$data['video_status'] = 1;
			if (isset($_REQUEST['typeStatus'])){
				if ($_REQUEST['typeStatus']=="2"){
					$data['video_status'] = 2;
				}
			}
		}elseif ($_REQUEST['type']=="email"){
			$data['email_status'] = 1;
			if (isset($_REQUEST['typeStatus'])){
				if ($_REQUEST['typeStatus']=="2"){
					$data['email_status'] = 2;
				}
			}
		}elseif ($_REQUEST['type']=="scene"){
			$data['scene_status'] = 1;
			if (isset($_REQUEST['typeStatus'])){
				if ($_REQUEST['typeStatus']=="2"){
					$data['scene_status'] = 2;
				}
			}
		}elseif ($_REQUEST['type']=="realname"){
			$data['real_status'] = 1;
			if (isset($_REQUEST['typeStatus'])){
				if ($_REQUEST['typeStatus']=="2"){
					$data['real_status'] = 2;
				}
			}
		}
	}

	$result = userClass::GetList($data);

	if (is_array($result)){
		$pages->set_data($result);
		$_A['user_all_list'] = $result['list'];
		$_A['showpage'] = $pages->show(3);

	}else{
		$msg = array($result);
	}
}
/**
 * ���
 **/
elseif ($_A['query_type'] == "audit"){
	require_once("modules/credit/credit.class.php");
	require_once("modules/message/message.class.php");

	if (isset($_POST['status'])){
		// 		if($_SESSION['valicode']!=$_POST['valicode']){
		if(1==2){
			$msg = array("��֤�벻��ȷ");
		}else{
			$_name = array("realname"=>"ʵ����֤","email"=>"������֤","phone"=>"�ֻ���֤","video"=>"��Ƶ��֤","scene"=>"�ֳ���֤");
			if ($_POST['status']==2){
				$data['name'] = $_name[$_POST['nid']]."���ûͨ��";
				$user->UpdateUser(array("user_id"=>$_POST['user_id'],"real_status"=>0));//�û�����֤״̬��Ϊ0
				if($_POST['nid']=="phone"){
					$user->UpdateUser(array("user_id"=>$_POST['user_id'],"phone_status"=>2));
				}
			}elseif ($_POST['status']==1){
				$_res = true;
				$_data['user_id'] = $_POST['user_id'];
				$user_result = userClass::GetOne($_data);
				$audit_fee = $_POST['fee'];
				if ($_POST['nid']=="realname"){
					$audit_fee = (isset($_G["system"]["con_realname_fee"])  && $_G["system"]["con_realname_fee"] >0 )?$_G["system"]["con_realname_fee"]:0;
				}

				if ($audit_fee > 0){
					$account_result =  accountClass::GetOne($_data);
					if ($account_result['use_money'] < $audit_fee){
						$_res = false;
						$msg = array("�������㣬�޷���֤��");
					}
				}
				if ($_res){
					if ($_POST['nid']=="realname"){
						if ($user_result['real_status']!=1){
							include_once(ROOT_PATH."/modules/account/account.class.php");
							$account_result =  accountClass::GetOne($_data);
							$log['user_id'] = $_data['user_id'];
							$log['type'] = "realname";
							$realname_money = (isset($_G["system"]["con_realname_fee"])  && $_G["system"]["con_realname_fee"] >0 )?$_G["system"]["con_realname_fee"]:0;
							$log['money'] = $realname_money;
							$log['total'] = $account_result['total']-$log['money'];
							$log['use_money'] = $account_result['use_money']-$log['money'];
							$log['no_use_money'] = $account_result['no_use_money'];
							$log['collection'] = $account_result['collection'];
							$log['to_user'] = 0;
							$log['remark'] = "ʵ����֤�۳�����";
							accountClass::AddLog($log);
							$user->UpdateUser(array("user_id"=>$_POST['user_id'],"real_status"=>1));//�û�����ʵ����״̬
						}else{
							$_res = false;
						}
					}elseif($_POST['nid']=="phone"){
						if ($user_result['phone_status']==1){
							$_res = false;
						}else{
							if ($user_result['phone_status']>1){
								$phone = $user_result['phone_status'];
								$user->UpdateUser(array("user_id"=>$_POST['user_id'],"phone"=>$phone,"phone_status"=>1));
							}else{
								$user->UpdateUser(array("user_id"=>$_POST['user_id'],"phone_status"=>1));
							}
						}
					}elseif ($_POST['nid']=="video"){
						if ($user_result['video_status']==1){

							$_res = false;
						}else{
							if ($_G['system']["con_video_feestatus"]==1){
									
								$account_result =  accountClass::GetOne($_data);
								$log['user_id'] = $_data['user_id'];
								$log['type'] = "video";
								$log['money'] = $_POST['fee'];
								$log['total'] = $account_result['total']-$log['money'];
								$log['use_money'] = $account_result['use_money']-$log['money'];
								$log['no_use_money'] = $account_result['no_use_money'];
								$log['collection'] = $account_result['collection'];
								$log['to_user'] = 0;
								$log['remark'] = "��Ƶ��֤�۳�����";
								accountClass::AddLog($log);
							}
							$user->UpdateUser(array("user_id"=>$_POST['user_id'],"video_status"=>1));//��Ƶ��֤
						}
					}elseif ($_POST['nid']=="scene"){
						if ($user_result['scene_status']==1){
							$_res = false;
						}else{
							if ($_G['system']["con_scene_feestatus"]==1){

								$account_result =  accountClass::GetOne($_data);
								$log['user_id'] = $_data['user_id'];
								$log['type'] = "scene";
								$log['money'] = $_POST['fee'];
								$log['total'] = $account_result['total']-$log['money'];
								$log['use_money'] = $account_result['use_money']-$log['money'];
								$log['no_use_money'] = $account_result['no_use_money'];
								$log['collection'] = $account_result['collection'];
								$log['to_user'] = 0;
								$log['remark'] = "�ֳ���֤�۳�����";
								accountClass::AddLog($log);
							}
							$user->UpdateUser(array("user_id"=>$_POST['user_id'],"scene_status"=>1));//��Ƶ��֤
						}
					}
					if ($_res==true){
						$credit['nid'] = $_POST['nid'];
						$credit['user_id'] = $_POST['user_id'];
						$credit['value'] = $_POST['jifen'];
						$credit['op_user'] = $_G['user_id'];
						$credit['op'] = 1;//����
						$credit['remark'] = nl2br($_POST['content']);
						creditClass::UpdateCredit($credit);//���»���
						// 					$data['name'] = $_name[$_POST['nid']]."���ͨ���������û���{$_POST['jifen']}�֡�";
					}
					$_SESSION['valicode'] = "";
				}
			}
		}
		if ($_res==true){
			// 			$data['sent_user'] = "admin";
			// 			$data['receive_user'] = $_POST['user_id'];
			// 			$data['content'] = nl2br($_POST['content']);
			// 			$data['type'] = "system";
			// 			$data['status'] = 0;
			$message['sent_user'] = "admin";
			$message['receive_user'] = $_POST['user_id'];
			$message['content'] = nl2br($_POST['content']);
			$message['type'] = "system";
			$message['status'] = 0;
			$message['name'] = $_name[$_POST['nid']]."���ͨ���������û���{$_POST['jifen']}�֡�";
			messageClass::Add($message);//���Ͷ���Ϣ
			$msg = array("�޸ĳɹ�","",$_A['query_url']."/all".$_A['site_url']);
		}else{
			if (!isset($msg)){
				$msg = array("���ʧ�ܡ�");
			}else{

			}
		}
	}else{
		$type = $_REQUEST['type'];
		$result = creditClass::GetTypeOne(array("nid"=>$type));
		if($type == "video"){
			$_A['arrestation_value']=10;
		}elseif($type == "scene"){
			$_A['arrestation_value']=20;
		}else{
			$_A['arrestation_value'] = $result['value'];
		}
		$_A['credit_type_id'] = $result['id'];

		$_data['user_id'] = $_REQUEST['user_id'];
		$user_result = userClass::GetOne($_data);
		$_A['user_result']['subsite_remark'] = $user_result['subsite_remark'];

		if ($_SESSION['areaid'] !=0){
			$_A['query_type'] = "subsite_audit";
		}
		$magic->assign("_A",$_A);
		$magic->display("audit.tpl","modules/attestation");exit;
	}


}

/**
 * ���
 **/
elseif ($_A['query_type'] == "subsite_audit"){
	require_once("modules/credit/credit.class.php");
	require_once("modules/message/message.class.php");
	if (isset($_POST['subsite_remark'])){
		$_res = $user->UpdateUser(array("user_id"=>$_POST['user_id'],"subsite_remark"=>$_POST['subsite_remark']));
		if ($_res==true){

			$msg = array("�������ύ�ɹ�","",$_A['query_url']."/all".$_A['site_url']);
		}else{
			$msg = array("�������ύʧ�ܡ�");
		}
	}else{
		$_data['user_id'] = $_REQUEST['user_id'];
		$user_result = userClass::GetOne($_data);
		$_A['user_result']['subsite_remark'] = $user_result['subsite_remark'];
		$magic->assign("_A",$_A);
		$magic->display("audit.tpl","modules/attestation");exit;
	}

}


/**
 * VIP�û�
 **/
elseif ($_A['query_type'] == "vip"){
	$data['page'] = $_A['page'];
	$data['epage'] = $_A['epage'];
	$data['vip_status'] = isset($_REQUEST['type'])?$_REQUEST['type']:"2";
	if($_G['user_result']['type_id']==3){
		$data['kefu_userid'] = $_G['user_id'];
	}
	if (isset($_REQUEST['username']) && $_REQUEST['username']!=""){
		$data['username'] = urldecode($_REQUEST['username']);
	}
	if (isset($_REQUEST['realname']) && $_REQUEST['realname']!=""){
		$data['realname'] = urldecode($_REQUEST['realname']);
	}
	if (isset($_REQUEST['keywords']) && $_REQUEST['keywords']!=""){
		$data['username'] = urldecode($_REQUEST['keywords']);
	}
	if (isset($_REQUEST['kefu']) && $_REQUEST['kefu']!=""){
		$data['kefu_username'] = urldecode($_REQUEST['kefu']);
	}
	$result = userClass::GetList($data);//0��ʾ�û�������1��ʾ�����������
	$pages->set_data($result);

	$_A['user_vip_list'] = $result['list'];
	$_A['showpage'] = $pages->show(3);

}



/**
 * VIP�û�
 **/
elseif ($_A['query_type'] == "jifen"){
	if ($_POST['id']!=""){
		$_val = 0;
		foreach ($_POST['id'] as $key => $_value){
			$sql = "update  {credit_log}  set value='{$_POST['val'][$key]}' where id='{$_value}'";
			$mysql->db_query($sql);
			$_val +=$_POST['val'][$key];
		}
		$sql = "update   {credit}  set value = {$_val}  where user_id='{$_POST['user_id']}'";
		$mysql->db_query($sql);
		$sql = "update   {user_cache}  set credit = {$_val}  where user_id='{$_POST['user_id']}'";
		$mysql->db_query($sql);
		$msg = array("�޸ĳɹ�");
	}else{
		$sql = "select p1.*,p2.username,p2.realname,p3.name as typename from  {credit_log}  as p1
		left join  {user}  as p2 on p1.user_id=p2.user_id
		left join  {credit_type}  as p3 on p1.type_id=p3.id
		where p1.user_id='{$_REQUEST['user_id']}'";
		$result = $mysql->db_fetch_arrays($sql);
		$_A['jifen_result'] = $result;
	}

}

/**
 * VIP��˲鿴
 **/
elseif ($_A['query_type'] == "vipview"){
	global $mysql,$_G;
	$vip_money = (!isset($_G['system']['con_vip_money']) || $_G['system']['con_vip_money']=="")?150:$_G['system']['con_vip_money'];
	$vip_ticheng = (!isset($_G['system']['con_vip_ticheng']) || $_G['system']['con_vip_ticheng']=="")?20:$_G['system']['con_vip_ticheng'];
	$ws_fl_rate = isset($_G['system']['con_ws_fl_rate'])?$_G['system']['con_ws_fl_rate']:0.16;
	$point2account = isset($_G['system']['con_point2account'])?$_G['system']['con_point2account']:2.52;
	$con_connect_ws = isset($_G['system']['con_connect_ws'])?$_G['system']['con_connect_ws']:"0";
	
	if (isset($_POST['vip_status'])){
		$var = array("vip_status","vip_verify_remark","user_id");
		$data = post_var($var);
		if ($data['vip_status']==1){
			$data['vip_verify_time'] = time();
		}
		$user_id=$_REQUEST['user_id'];
		$data['user_id'] = $user_id;
		$result = userClass::GetOne($data);
		$username = $result['username']; 
		$user_subsite_id = $result['areaid'];

		if($result['vip_status']==1){
			$msg = array("vip�Ѿ����ͨ�����벻Ҫ�ظ����");
		}elseif($result['vip_status']==0){
			$msg = array("�Բ��𣬸�vip�Ѿ���ˣ���˽������ͨ�������벻Ҫ�ظ����");
		}else{
			$result = userClass::UpdateUserCache($data);//����
			include_once(ROOT_PATH."/modules/account/account.class.php");
			include_once(ROOT_PATH."/modules/message/message.class.php");
			require_once("modules/credit/credit.class.php");
			if ($data['vip_status']==1){
				//ulk

				//$sqls="update  {user_amount}  set credit=credit+50000,credit_use=credit_use+50000,borrow_vouch=borrow_vouch+50000,borrow_vouch_use=borrow_vouch_use+50000 where user_id='$user_id'";
				//attestationClass::Updatesql($sqls);

				//�۳�vip�Ļ�Ա�ѡ�
				accountClass::AccountVip(array("user_id"=>$user_id,"from"=>"view"));

				$credit['nid'] = "vip";
				$credit['user_id'] = $user_id;
				$credit['value'] = 8;//VIP���ͨ����8��
				$credit['op_user'] = "0";
				$credit['op'] = 1;//����
				$credit['remark'] = "vip���ͨ��";
				creditClass::UpdateCredit($credit);//���»���

				// 				$message['sent_user'] = 0;
				// 				$message['receive_user'] = $user_id;
				// 				$message['name'] = "VIP���ͨ��";
				// 				$message['content'] = "����vip��".date("Y-m-d",time())."ͨ����ˡ�";
				// 				$message['type'] = "system";
				// 				$message['status'] = 0;
				// 				messageClass::Add($message);//���Ͷ���Ϣ
				$msg = array("VIP�û���˳ɹ�","","{$_A['query_url']}/vip");

				//��������
				$remind['nid'] = "vip_yes";
				$remind['sent_user'] = "0";
				$remind['receive_user'] = $user_id;
				$remind['title'] = "��ϲ��,����VIP��Ա�����Ѿ���ͨ���������";
				$remind['content'] = "��ϲ��,����VIP��Ա�����Ѿ���".date("Y-m-d",time())."ͨ����ˡ�";
				$remind['type'] = "system";
				remindClass::SendRemindHouTai($remind);

				//�����û�������վ����VIP�����Ĵ������̣�
				$user_subsite = subsiteClass::GetOne(array("id"=>$user_subsite_id));
				if(is_array($user_subsite)){
					$vip_award_type = $user_subsite['vip_award_type'];
					
					//����VIP�����
					if($vip_award_type == 0){
						$account_result =  accountClass::GetOne(array("user_id"=>$user_id));
						$vip_log['user_id'] = $user_id;
						$vip_log['type'] = "vip_fee_back";
						$vip_log['money'] = $vip_money;
						$vip_log['total'] = $account_result['total']+$vip_log['money'];
						$vip_log['use_money'] = $account_result['use_money']+$vip_log['money'];
						$vip_log['no_use_money'] = $account_result['no_use_money'];
						$vip_log['collection'] = $account_result['collection'];
						$vip_log['to_user'] = "0";
						$vip_log['remark'] = "����VIP��Ա��";
						accountClass::AddLog($vip_log);
					}
					//�����˻�����
					else if($vip_award_type == 1){
						//�������û��Ǳ��˽��ܽ����ģ�����Ҫ���������߽����������
						
						 $sql = "select p1.invite_userid,p1.invite_money,p2.username  from  {user}  as p1 left join  {user}  as p2 on p1.invite_userid = p2.user_id where p1.user_id = '{$user_id}' ";
						$result = $mysql ->db_fetch_array($sql);
						if ($result['invite_userid']!="" && $result['invite_money']<=0){
						//�����������
						$account_result =  accountClass::GetOne(array("user_id"=>$result['invite_userid']));
						$ticheng_log['user_id'] = $result['invite_userid'];
						$ticheng_log['type'] = "vip_ticheng";
						$ticheng_log['money'] = $vip_ticheng;
						$ticheng_log['total'] = $account_result['total']+$ticheng_log['money'];
						$ticheng_log['use_money'] = $account_result['use_money']+$ticheng_log['money'];
						$ticheng_log['no_use_money'] = $account_result['no_use_money'];
						$ticheng_log['collection'] = $account_result['collection'];
						$ticheng_log['to_user'] = "0";
						$ticheng_log['remark'] = "�����û�{$username}ע�Ტ��ΪVIP��Ա���������";
						accountClass::AddLog($ticheng_log);
						$sql = "update  {user}  set invite_money=$vip_ticheng where user_id='{$user_id}'";
						$mysql -> db_query($sql);
						
						
						//��¼ר�õ������־����Ϊ���е�log��¼�޷����������Դ
						$tc_log['user_id'] = $user_id;
						$tc_log['type'] = "vip_ticheng";
						$tc_log['money'] = $vip_ticheng;
						$tc_log['invite_userid'] = $result['invite_userid'];;
						$tc_log['remark'] = "�����û�{$username}ע�Ტ��ΪVIP��Ա���������";
						
						$sql = "insert into  {ticheng_log}  set `addtime` = '".time()."',`addip` = '".ip_address()."'";
						foreach($tc_log as $key => $log_value){
							$sql .= ",`$key` = '$log_value'";
						}
						$mysql->db_query($sql);
						
						
						}
												
						
					}
					//webservice�ӱ��������ߵȶ��
					else if($vip_award_type == 2 || $vip_award_type == 3){
						// liukun add for bug 246 begin
						if ($con_connect_ws=="1"){
							if ($vip_money > 0){
								$account_result =  accountClass::GetOne(array("user_id"=>$user_id));

								$post_data=array();
								$post_data['ID']=$account_result['ws_user_id'];
								//�ӱ�����
								if($vip_award_type == 2){
									$post_data['Money']=round_money($vip_money / $ws_fl_rate);
								}
								//�ȶ��
								else{
									$post_data['Money']=$vip_money;
								}
								$post_data['MoneyType']=1;
								$post_data['Count']=1;
								
								$ws_result = webService('C_Consume',$post_data);
								if ($ws_result >= 1){

									//������ID���б���
									$q_data['user_id'] = $user_id;
									$q_data['ws_queue_id'] = $ws_result;
									$q_data['out_money'] = $vip_money;
									if($vip_award_type == 2){
										$q_data['in_should_money'] = round($vip_money / $ws_fl_rate , 2);
									}else{
										$q_data['in_should_money'] = $vip_money;
									}

									$sql = "insert into  {return_queue}  set `addtime` = '".time()."',`addip` = '".ip_address()."'";
									foreach($q_data as $key => $value){
										$sql .= ",`$key` = '$value'";
									}
									$result = $mysql->db_query($sql);

									$ws_log['user_id']=$user_id;
									$ws_log['account']=$vip_money;
									$ws_log['type']="vip_fee";
									$ws_log['direction']="0";
									$ws_log['remark']="��webservice�ύVIP�ɷ���Ϣ";
									wsaccountClass::addWSlog($ws_log);
								}
							}
						}
						// liukun add for bug 246 end
					}
						
				}
				


			}else{

				$vip_money = (!isset($_G['system']['con_vip_money']) || $_G['system']['con_vip_money']=="")?120:$_G['system']['con_vip_money'];
				$account_result =  accountClass::GetOne(array("user_id"=>$user_id));
				$vip_log['user_id'] = $user_id;
				$vip_log['type'] = "vip";
				$vip_log['money'] = $vip_money;
				$vip_log['total'] = $account_result['total'];
				$vip_log['use_money'] = $account_result['use_money']+$vip_log['money'];
				$vip_log['no_use_money'] = $account_result['no_use_money']-$vip_log['money'];
				$vip_log['collection'] = $account_result['collection'];
				$vip_log['to_user'] = "0";
				$vip_log['remark'] = "vip����û��ͨ������������ʽ�";
				accountClass::AddLog($vip_log);

				//��������
				$remind['nid'] = "vip_no";
				$remind['sent_user'] = "0";
				$remind['receive_user'] = $user_id;
				$remind['title'] = "���ź�,����VIP��Ա���롰û��ͨ�������";
				$remind['content'] = "���ź�������VIP��Ա������".date("Y-m-d",time())."û��ͨ����ˡ�";
				$remind['type'] = "system";
				remindClass::SendRemindHouTai($remind);

				$msg = array("��˳ɹ����û���VIP�û����벻ͨ����","","{$_A['query_url']}/vip");
			}
		}

		$user->add_log($_log,$result);//��¼����
	}else{
		$_A['user_result'] = userClass::GetOne(array("user_id"=>$_REQUEST['user_id']));
	}
}

//��ֹ�Ҳ���
else{
	$msg = array("���������벻Ҫ�Ҳ���","",$url);
}
?>