<?
if (!defined('ROOT_PATH'))  die('���ܷ���');//��ֱֹ�ӷ���
check_rank("account_".$_A['query_type']);//���Ȩ��

//liukun add for bug 52 begin
$firePHPEnable=TRUE;
if ($firePHPEnable){
	require_once('modules/FirePHPCore/FirePHP.class.php');
	require_once('modules/FirePHPCore/fb.php');
	ob_start();

	$firephp = FirePHP::getInstance(true);
}
//liukun add for bug 52 end

include_once("account.class.php");
include_once(ROOT_PATH."core/friends.class.php");
include_once("modules/account/wsaccount.class.php");
include_once(ROOT_PATH."modules/borrow/borrow.class.php");
require_once("modules/remind/remind.class.php");

$_A['list_purview'] =  array("account"=>array("�˺��ʽ����"=>array("account_ticheng"=>"����б�",
		"account_list"=>"��Ϣ�б�",
		"account_bank"=>"�����˻�",
		"account_cash"=>"���ּ�¼",
		"account_recharge"=>"��ֵ��¼",
		"account_log"=>"�ʽ��¼",
		"vipTC"=>"�����Ա�б�",
		"tcList"=>"�����Ա����б�",
		"moneyCheck"=>"�ʽ���˱�",
		"wsfl_get_list"=>"��ȡ������¼",
		"wsfl_list"=>"������¼",
		"wsfl_cash"=>"��������",
		"wsfl_cash_report"=>"���������б�",
		"wsfl_queue_list"=>"�������в�ѯ",
		"wsfl_queue_query"=>"����״̬��ѯ",
		"wsfl_queue_close"=>"�������йر�",
		"wsfl_rebate_list"=>"ȫ������"

)));//Ȩ��
// echo serialize($_A['list_purview']);
$_A['list_name'] = $_A['module_result']['name'];
$_A['list_menu'] = "<a href='{$_A['query_url']}/wsfl_get_list{$_A['site_url']}'>��ȡ��������</a> - <a href='{$_A['query_url']}/list{$_A['site_url']}'>�˻���Ϣ�б�</a> - <a href='{$_A['query_url']}/cash&status=0{$_A['site_url']}'>��������</a> - <a href='{$_A['query_url']}/cash&status=1{$_A['site_url']}'>���ֳɹ�</a> -  - <a href='{$_A['query_url']}/cash&status=2{$_A['site_url']}'>����ʧ��</a> - <a href='{$_A['query_url']}/recharge&status=-2&username='>��ֵ��¼</a>  - <a href='{$_A['query_url']}/log{$_A['site_url']}'>�ʽ��¼</a> - <a href='{$_A['query_url']}/recharge_new{$_A['site_url']}'>��ӳ�ֵ</a> - <a href='{$_A['query_url']}/tcList{$_A['site_url']}'>�����Ա����б�</a> - <a href='{$_A['query_url']}/moneyCheck{$_A['site_url']}'>�ʽ���˱�</a>";

//������Ա�����ڵķ�վ��Ϣ����
$data['areaid'] = $_SESSION['areaid'];
$_A['areaid'] =  $_SESSION['areaid'];
$_A['admin_type_id'] =  $_SESSION['type_id'];
/**
 * �������Ϊ�յĻ�����ʾ���е��ļ��б�
 **/

if ($_A['query_type'] == "list"){
	$_A['list_title'] = "�˻���Ϣ�б�";

	if (isset($_REQUEST['user_id']) && $_REQUEST['user_id']!=""){
		$data['user_id'] = $_REQUEST['user_id'];
	}

	if (isset($_REQUEST['username']) && $_REQUEST['username']!=""){
		$data['username'] = urldecode($_REQUEST['username']);
	}

	$data['page'] = $_A['page'];
	$data['epage'] = $_A['epage'];
	$result = accountClass::GetList($data);

	if (isset($_REQUEST['type']) && $_REQUEST['type']=="excel"){

		$title = array("���","�û���","��ʵ����","�����","�������","������","���ս��","�������","���ʲ�");
		$data['limit'] = "all";
		$result = accountClass::GetAccListForExport($data);

		exportData("�˻��б�",$title,$result);
		exit;
	}

	if (is_array($result)){
		$pages->set_data($result);
		$_A['account_list'] = $result['list'];
		$_A['showpage'] = $pages->show(3);

	}else{
		$msg = array($result);
	}
}
/***
 * Author:LiuYY
* 2012-05-04
* ��̨����б�
*/
else if ($_A['query_type'] == "ticheng"){
	$_A['list_title'] = "�˻���Ϣ�б�";

	if (isset($_REQUEST['username']) && $_REQUEST['username']!=""){
		$data['username'] = urldecode($_REQUEST['username']);
	}

	$data['page'] = $_A['page'];
	$data['epage'] = $_A['epage'];
	$result = accountClass::GetTicheng($data);

	if (isset($_REQUEST['type']) && $_REQUEST['type']=="excel"){

		$title = array("���","ʱ��","�û���","Ͷ���ܶ�");
		$data['limit'] = "all";
		$result = accountClass::GetTichengForExport($data);

		exportData("��������б�",$title,$result);
		exit;
	}

	if (is_array($result)){
		$pages->set_data($result);
		$_A['account_ticheng'] = $result['list'];
		$_A['showpage'] = $pages->show(3);

	}else{
		$msg = array($result);
	}
}

/**
 * �����Աע�Ტ����VIP��Ա������б�
 **/
else if ($_A['query_type'] == "vipTC"){
	$_A['list_title'] = "�����Ա�б�";

	$data["user_id"]="-1";

	$data['page'] = $_A['page'];
	$data['epage'] = $_A['epage'];
	$data['user_id']="-1";

	if (isset($_REQUEST['username']) && $_REQUEST['username']!=""){
		$data['username'] = urldecode($_REQUEST['username']);
	}

	if (isset($_REQUEST['username2']) && $_REQUEST['username2']!=""){
		$data['username2'] = urldecode($_REQUEST['username2']);
	}

	$result = friendsClass::GetFriendsInvite($data);
	$list=$result['list'];
	foreach ($list as $key => $value){
		 
		$inviteUserId = $value["invite_userid"];
		$sql = "select username from {user} where `user_id`={$inviteUserId} limit 1";
		$resultValue = $mysql->db_fetch_array($sql);
		$list[$key]['inviteUserName'] = $resultValue["username"];
	}
	$result['list']=$list;

	if (is_array($result)){
		$pages->set_data($result);
		$_A['vipTC_list'] = $result['list'];
		$_A['showpage'] = $pages->show(3);

	}else{
		$msg = array($result);
	}
}

/**
 * �����Աע�Ტ����VIP��Ա������б�
 **/
else if ($_A['query_type'] == "tcList"){
	$_A['list_title'] = "�����Ա����б�";


	$data['page'] = $_A['page'];
	$data['epage'] = $_A['epage'];

	if (isset($_REQUEST['username']) && $_REQUEST['username']!=""){
		$data['invite_username'] = urldecode($_REQUEST['username']);
	}

	if (isset($_REQUEST['username2']) && $_REQUEST['username2']!=""){
		$data['username'] = urldecode($_REQUEST['username2']);
	}

	// 	$result = friendsClass::GetFriendsInvite($data);
	// 	$list=$result['list'];
	// 	foreach ($list as $key => $value){
		
	// 		$inviteUserId = $value["invite_userid"];
	// 		$sql = "select username from {user} where `user_id`={$inviteUserId}";
	// 		$resultValue = $mysql->db_fetch_array($sql);
	// 		$list[$key]['inviteUserName'] = $resultValue["username"];
	// 	}
	$result = accountClass::GetTichenList($data);

	if (is_array($result)){
		$pages->set_data($result);
		$_A['tichen_list'] = $result['list'];
		$_A['showpage'] = $pages->show(3);

	}else{
		$msg = array($result);
	}
}

/**
 * �û��ʽ���������
 */
else if ($_A['query_type'] == "moneyCheck"){
	$_A['list_title'] = "�û��ʽ���������";

	$data["user_id"]="-1";

	$data['page'] = $_A['page'];
	$data['epage'] = $_A['epage'];
	$data['user_id']="-1";

	if (isset($_REQUEST['username']) && $_REQUEST['username']!=""){
		$data['username'] = urldecode($_REQUEST['username']);
	}



	if (isset($_REQUEST['type']) && $_REQUEST['type']=="excel"){

		$title = array("�û���","�ʽ��ܶ�","�����ʽ�","�����ʽ�","�����ʽ�(1)","�����ʽ�(2)","��ֵ�ʽ�(1)","��ֵ�ʽ�(2)","���У�����","���У�����1","���У�����2","�ɹ����ֽ��","����ʵ�ʵ���","���ַ���","Ͷ�꽱�����","Ͷ�������ʽ�","Ͷ��������Ϣ","Ͷ�������Ϣ","����ܽ��","���꽱��","�������","�������","����ѻ���Ϣ","ϵͳ�۷�","�ƹ㽱��","VIP�۷�","�ʽ��ܶ�1","�ʽ��ܶ�2");
		//$data['limit'] = "all";
		$result = accountClass::GetUsersMoneyCheckListForExcel($data);

		exportData("�û��ʽ���������",$title,$result);
		exit;
	}

	$result = accountClass::GetUsersMoneyCheckList($data);
	if (is_array($result)){
		$pages->set_data($result);
		$_A['moneyCheck_list'] = $result['list'];
		$_A['showpage'] = $pages->show(3);

	}else{
		$msg = array($result);
	}
}

/**
 * ���ֲο�
 **/
elseif ($_A['query_type'] == "cashCK"){
	$_A['list_title'] = "���ֲο�";

	if (isset($_REQUEST['user_id']) && $_REQUEST['user_id']!=""){
		$data['user_id'] = $_REQUEST['user_id'];
	}

	if (isset($_REQUEST['username']) && $_REQUEST['username']!=""){
		$data['username'] = urldecode($_REQUEST['username']);
	}

	$data['page'] = $_A['page'];
	$data['epage'] = $_A['epage'];
	$result = accountClass::GetCKList($data);

	if (is_array($result)){
		$pages->set_data($result);
		$_A['account_cashCK_list'] = $result['list'];
		$_A['showpage'] = $pages->show(3);

	}else{
		$msg = array($result);
	}
}
/**
 * ���ּ�¼
 **/
elseif ($_A['query_type'] == "cash"){
	$_A['list_title'] = "���ּ�¼";

	if (isset($_REQUEST['user_id'])){
		$data['user_id'] = $_REQUEST['user_id'];
	}

	if (isset($_REQUEST['username'])){
		$data['username'] = urldecode($_REQUEST['username']);
	}
	if (isset($_REQUEST['status']) && $_REQUEST['status']!=""){
		$data['status'] = $_REQUEST['status'];
	}
	if (isset($_REQUEST['type']) && $_REQUEST['type']=="excel"){
		$title = array("Id","�û�����","��ʵ����","�����˺�","��������","֧��","�����ܶ�","���˽��","������","����ʱ��","״̬");
		$data['limit'] = "all";
		$result = accountClass::GetCashList($data);
		foreach ($result as $key => $value){
			if ($value["status"]==1){
				$state  = "���ͨ��";
			}elseif ($value["status"]==0){
				$state  = "������";
			}elseif ($value["status"]==2){
				$state  = "����ܾ�";
			}
				
			$_data[$key] = array($key+1,$value['username'],$value['realname'],"[".$value['account']."]",$value['bank_name'],$value['branch'],$value['total'],$value['credited'],$value['fee'],date("Y-m-d",$value['addtime']),$state);
		}
		exportData("�����б�",$title,$_data);
		exit;
	}
	$data['page'] = $_A['page'];
	$data['epage'] = $_A['epage'];
	$result = accountClass::GetCashList($data);

	if (is_array($result)){
		$pages->set_data($result);
		$_A['account_cash_list'] = $result['list'];
		$_A['showpage'] = $pages->show(3);

	}else{
		$msg = array($result);
	}
}
/**
 * ������˲鿴
 **/
elseif ($_A['query_type'] == "cash_view"){
	$_A['list_title'] = "������˲鿴";
	if (isset($_POST['id'])){
		
		if(empty($_POST['status']))
		{
			$msg = array("��ѡ�����״̬��");
		}
		else
		{
			$var = array("id","status","credited","fee","verify_remark");
			$data = post_var($var);
			$result = accountClass::GetCashOne(array("id"=>$data['id'],"user_id"=>$_POST['user_id']));
			$hongbao = $result['hongbao'];
			if($result['status'] != 0){
				$msg = array("���ʧ�ܣ���ǰ��������״̬��ԭʼ״̬����ǰ״̬Ϊ:".$result['status']."!(0--��ʼ״̬ 1--����ɹ� 2--����ʧ�� 3--�û�ȡ������)");
			}else{
				if ($data['status']==1){
					$user_id = $_POST['user_id'];
					//�������ַ�
					$total = $result['total'];
					$fee = round($_POST['fee'], 2);
					$credited =  $total - $fee;
					$data['credited']=$credited;
					
	
					$account_result =  accountClass::GetOne(array("user_id"=>$user_id));
					$log['user_id'] = $user_id;
					$log['type'] = "recharge_success";
					$log['money'] = $credited;
					$log['total'] = $account_result['total'] - $log['money'];
					$log['use_money'] = $account_result['use_money'] ;
					$log['no_use_money'] = $account_result['no_use_money'] - $log['money'];
					$log['collection'] = $account_result['collection'];
					$log['to_user'] = "0";
					$log['remark'] = "���ֳɹ�";
					$result = accountClass::AddLog($log);
	
					$account_result =  accountClass::GetOne(array("user_id"=>$user_id));
					$log['user_id'] = $user_id;
					$log['type'] = "cash_fee";
					$log['money'] = $fee;
					$log['total'] = $account_result['total'] - $log['money'];
					$log['use_money'] = $account_result['use_money'] ;
					$log['no_use_money'] = $account_result['no_use_money'] - $log['money'];
					$log['collection'] = $account_result['collection'];
					$log['to_user'] = "0";
					$log['remark'] = "���ֳɹ�������";
					$result = accountClass::AddLog($log);
					
					
					$sql = "select * from  {subsite}  where id=(select areaid from  {user}  where user_id = {$user_id})";
					$site_info_result = $mysql->db_fetch_array($sql);
					$current_time = date("Y-m-d H:i:s", time());
					$con_cash_notice = isset($_G['system']['con_cash_notice'])?$_G['system']['con_cash_notice']:"";
					sendSMS($user_id,"����{$current_time}�ɹ�����{$total}Ԫ��{$con_cash_notice}--".$site_info_result['sitename'],1);
	
					//��������
					$remind['nid'] = "withdraw_yes";
					$remind['sent_user'] = "0";
					$remind['receive_user'] = $_POST['user_id'];
					$remind['title'] = "��������{$total}Ԫ���롰ͨ���������,���ڴ����";
					//$remind['content'] = "���Ѿ���".date("Y-m-d",time())."�ɹ�������{$log['total']}Ԫ";
					$remind['content'] = "��������{$total}Ԫ���롰ͨ���������,���ڴ����";
					$remind['content'] .= "<br>�����ܽ���{$total}";
					$remind['content'] .= "<br>���ֵ��ʽ���{$credited}";
					$remind['content'] .= "<br>���������ѣ���{$fee}";
					$remind['content'] .= "<br>�������У�{$result['branch']}";
					$remind['content'] .= "<br>���ʱ�䣺".date("Y-m-d",time());
					$remind['type'] = "cash";
					remindClass::SendRemindHouTai($remind);
	
					//liukun add for bug 173 begin
					$sql="select * from {account} where user_id={$user_id} limit 1";
					$award_result = $mysql->db_fetch_array($sql);
	
					$award=$award_result['award'];
					if ($award > 0){
						$sql = "update  {account}  set `use_award` = `use_award` - {$award}, `award` = 0 ";
						$sql .= " where user_id=$user_id";
	
						$mysql->db_query($sql);
	
						//����award��־
						$award_log['user_id'] = $user_id;
						$award_log['type'] = "recharge_award_cancel";
						$award_log['award'] = -$award;
						$award_log['remark'] = "��ֵ����ȡ��";
						$sql = "insert into  {recharge_award_log}  set `addtime` = '".time()."',`addip` = '".ip_address()."'";
						foreach($award_log as $key => $value){
							$sql .= ",`$key` = '$value'";
						}
						$mysql->db_query($sql);
					}
					//liukun add for bug 173 end
				}elseif ($data['status']==2){
					$account_result =  accountClass::GetOne(array("user_id"=>$_POST['user_id']));
					$log['user_id'] = $_POST['user_id'];
					$log['type'] = "recharge_false";
					$log['money'] = $result['total'];
					$log['total'] = $account_result['total'];
					$log['use_money'] = $account_result['use_money'] + $log['money'];
					$log['no_use_money'] = $account_result['no_use_money']- $log['money'];
					$log['collection'] = $account_result['collection'];
					$log['to_user'] = "0";
					$log['remark'] = "����ʧ��";
					$result = accountClass::AddLog($log);
	
					// 							//add by jackfeng 2012-7-9 ����ʧ�� �������
					// 							$sql = "update  {user}  set hongbao = hongbao + ".$hongbao." where user_id=".$log['user_id'];
					// 							$mysql->db_query($sql);
	
					//��������
					$remind['nid'] = "withdraw_no";
					$remind['sent_user'] = "0";
					$remind['receive_user'] = $_POST['user_id'];
					//$remind['title'] = "����{$log['total']}Ԫʧ��";
					$remind['title'] = "��������{$log['total']}Ԫ���롰û��ͨ�������,����ϵ�����˽�����";
					$remind['content'] = date("Y-m-d",time())."����{$log['total']}Ԫ�������ʧ��";
					$remind['type'] = "cash";
					remindClass::SendRemindHouTai($remind);
				}
				$data['verify_userid'] = $_G['user_id'];
				$data['verify_time'] = time();
				$data['user_id'] = $_POST['user_id'];				
				
				$result = accountClass::UpdateCash($data);
				if ($result !== true){
					$msg = array($result);
				}else{
					$msg = array("�����ɹ�","",$_A['query_url']."/cash".$_A['site_url']);
				}
	
				$user->add_log($_log,$result);//��¼����
			}
		}
	}else{
		$data['id'] = $_REQUEST['id'];
		$cash_result = accountClass::GetCashOne($data);
		$dataCash["user_id"]=$cash_result['user_id'];
		$dataCash["cashAmount"]=$cash_result['total'];
		$fee = borrowClass::GetCashFeeAmount($dataCash);
		$cash_result['fee'] = $fee;
		$cash_result['credited'] = $cash_result['total'] - $fee;

		$_A['account_cash_result'] = $cash_result;
		//�������ַ�
	}
}

/**
 * �˺ų�ֵ
 **/
elseif ($_A['query_type'] == "recharge_view"){
	global $_G;
	$_A['list_title'] = "��ֵ�鿴";
	$con_recharge_award = isset($_G['system']['con_recharge_award'])?$_G['system']['con_recharge_award']:0;
	$online_recharge_award = isset($_G['system']['con_online_recharge_award'])?$_G['system']['con_online_recharge_award']:0;
	$con_recharge_award_begin = (float)$_G['system']['con_recharge_award_begin'];
	if (isset($_POST['id'])){
		$var = array("id","status","verify_remark");
		$data = post_var($var);
		$result = accountClass::GetRechargeOne(array("id"=>$_POST['id']));
		if ($result['status']!=0){
			$msg = array("�˳�ֵ�Ѿ���ˣ��벻Ҫ�ظ���ˡ�");
		}else{
			$recharge_award = 0;
			if ($data['status']==1){
				//liukun add for bug 169 begin
				$current_time=time();
				$user_id = $result['user_id'];
				$recharge_money = $result['money'];
				$sql="select * from {recharge_award_rule} where min_account <='{$recharge_money}' and max_account >= '{$recharge_money}' and begin_time <= {$current_time} and end_time >= {$current_time} limit 1";
				$rule_result = $mysql->db_fetch_array($sql);
				if($rule_result == false){
					//û�н����
				}
				$award_rate=$rule_result['award_rate'];
				if ($award_rate > 0){
					$recharge_award = round($recharge_money * $award_rate / 100, 2);
					$sql = "update  {account}  set `award` = `award` + {$recharge_award}, `use_award` = `use_award` + {$recharge_award}";
					$sql .= " where user_id=$user_id";

					$mysql->db_query($sql);

					//����award��־
					$award_log['user_id'] = $user_id;
					$award_log['type'] = "recharge_award";
					$award_log['award'] = $recharge_award;
					$award_log['remark'] = "��ֵ����";
					$sql = "insert into  {recharge_award_log}  set `addtime` = '".time()."',`addip` = '".ip_address()."'";
					foreach($award_log as $key => $value){
						$sql .= ",`$key` = '$value'";
					}
					$mysql->db_query($sql);
				}
				//liukun add for bug 169 end

				$account_result =  accountClass::GetOne(array("user_id"=>$result['user_id']));
				$log['user_id'] = $result['user_id'];
				$log['type'] = "recharge";
				$log['money'] = $result['money'];
				$log['total'] = $account_result['total']+$result['money'];
				$log['use_money'] =  $account_result['use_money']+$result['money'];
				$log['no_use_money'] =  $account_result['no_use_money'];
				$log['collection'] = $account_result['collection'];
				$log['to_user'] = "0";
				//$log['remark'] = "�˻���ֵ";
				$log['remark'] = $result['remark'];//�޸�2013-8-6
				accountClass::AddLog($log);

				//��ʱȡ����ֵ������,���
				if(1==2){
					if($result['fee']!=0){
						$account_result =  accountClass::GetOne(array("user_id"=>$result['user_id']));
						$log['user_id'] = $result['user_id'];
						$log['type'] = "fee";
						$log['money'] = $result['fee'];
						$log['total'] =$account_result['total']-$log['money'];
						$log['use_money'] = $account_result['use_money']-$log['money'];
						$log['no_use_money'] = $account_result['no_use_money'];
						$log['collection'] = $account_result['collection'];
						$log['to_user'] = "0";
						$log['remark'] = "��ֵ�����ѿ۳�";
						accountClass::AddLog($log);
					}
					//�ж��Ƿ������³�ֵ���������������add by jackfeng 2012-07-09
					if($result['type']==2){
						if($result['money'] >= 20000){
							$hongbao=round($result['money']*0.001,2);//����ǧ��֮һ�ĺ����
							$sql = "update  {user}  set hongbao = hongbao + ".$hongbao." where user_id=".$result['user_id'];
							$mysql->db_query($sql);
						}
						$remind['nid'] = "recharge";
						$remind['sent_user'] = "0";
						$remind['receive_user'] = $result['user_id'];
						$remind['title'] = "���³�ֵ�������(".$hongbao.")Ԫ";
						$remind['content'] = "���³�ֵ�������(".$hongbao.")Ԫ";
						$remind['type'] = "recharge";
						remindClass::sendRemind($remind);

					}
				}

				//��ֵ�ֽ���
				if($result['type']==2){
					if($result['money'] >= $con_recharge_award_begin)
					{
					$account_result =  accountClass::GetOne(array("user_id"=>$user_id));
					$log['user_id'] = $user_id;
					$log['type'] = "recharge_award";
					$log['money'] =round_money($result['money'] * $con_recharge_award, 2);
					$log['total'] = $account_result['total']+$log['money'];
					$log['use_money'] = $account_result['use_money']+$log['money'];
					$log['no_use_money'] = $account_result['no_use_money'];
					$log['collection'] = $account_result['collection'];
					$log['to_user'] = 0;
					$log['remark'] = "���³�ֵ����";
					accountClass::AddLog($log);
					}
				}
				elseif($result['type']==1){
					$account_result =  accountClass::GetOne(array("user_id"=>$user_id));
					$log['user_id'] = $user_id;
					$log['type'] = "recharge_award";
					$log['money'] =round($result['money'] * $online_recharge_award, 2);
					$log['total'] = $account_result['total']+$log['money'];
					$log['use_money'] = $account_result['use_money']+$log['money'];
					$log['no_use_money'] = $account_result['no_use_money'];
					$log['collection'] = $account_result['collection'];
					$log['to_user'] = 0;
					$log['remark'] = "���߳�ֵ����";
					accountClass::AddLog($log);
				}
				//��������
				$remind['nid'] = "recharge";
				$remind['sent_user'] = "0";
				$remind['receive_user'] = $result['user_id'];
				//$remind['title'] = "�����˻��ɹ���ֵ{$result['money']}Ԫ";
				$remind['title'] = $result['remark'];//�޸�2013-8-6
				$remind['content'] = "���ã����Ѿ���".date("Y-m-d",time())."�ɹ���ֵ{$result['money']}Ԫ";
				$remind['type'] = "recharge";
				remindClass::sendRemind($remind);

			}elseif ($data['status']==2){

				//��������
				// 				$remind['nid'] = "recharge";
				// 				$remind['sent_user'] = "0";
				// 				$remind['receive_user'] = $result['user_id'];
				// 				$remind['title'] = "�����˻���ֵ{$result['money']}Ԫʧ��";
				// 				$remind['content'] = date("Y-m-d",time())."��ֵ{$result['money']}Ԫ���ʧ��";
				// 				$remind['type'] = "recharge";
				//remindClass::sendRemind($remind);
					
			}
				
			$data['verify_userid'] = $_G['user_id'];
			$data['verify_time'] = time();
			//liukun add for bug 221 begin
			$data['award'] = $recharge_award;
			//liukun add for bug 221 end
			$result = accountClass::UpdateRecharge($data);

			if ($result !== true){
				$msg = array($result);
			}else{
				$msg = array("�����ɹ�","",$_A['query_url']."/recharge".$_A['site_url']);
			}
		}
		$user->add_log($_log,$result);//��¼����
	}else{
		$data['id'] = $_REQUEST['id'];
		$_A['account_recharge_result'] = accountClass::GetRechargeOne($data);
	}
}

/**
 * ��ֵ��¼
 **/
elseif ($_A['query_type'] == "recharge"){
	$_A['list_title'] = "��ֵ��¼";

	if (isset($_REQUEST['user_id'])){
		$data['user_id'] = $_REQUEST['user_id'];
	}

	if (isset($_REQUEST['username'])){
		$data['username'] = urldecode($_REQUEST['username']);
	}

	if (isset($_REQUEST['status'])){
		$data['status'] = $_REQUEST['status'];
	}

	if (isset($_REQUEST['dotime1'])){
		$data['dotime1'] = $_REQUEST['dotime1'];
	}

	if (isset($_REQUEST['dotime2'])){
		$data['dotime2'] = $_REQUEST['dotime2'];
	}


	$data['page'] = $_A['page'];
	$data['epage'] = $_A['epage'];

	$result = accountClass::GetRechargeList($data);

	if (is_array($result)){
		$pages->set_data($result);
		$_A['account_recharge_list'] = $result['list'];
		$_A['showpage'] = $pages->show(3);
		if (isset($_REQUEST['type']) && $_REQUEST['type']=="excel"){

			$title = array("���","��ˮ��","��ʵ����","�û�����","����","��������","��ֵ���","����","���˽��","��ֵʱ��","״̬");
			$data['limit'] = "all";

			$result = accountClass::GetRechargeList($data);

			foreach ($result as $key => $value){
				if ($value['type']==1){
					$type = "���ϳ�ֵ";
				}else{ $type = "���³�ֵ";
				}
				if ($value['payment']==0){
					$payment = "�ֶ���ֵ";
				}else{ $payment_name = "���³�ֵ";
				}
				if ($value['status']==0){
					$status = "���";
				}elseif ($value['status']==1){
					$status = "�ɹ�";
				}else{ $status = "ʧ��";
				}

				$_data[$key] = array($key+1,$value['trade_no'], $value['realname'],$value['username'],$type,$value['payment_name'],$value['money'],$value['fee'],$value['total'],date("Y-m-d H:i",$value['addtime']),$status);
			}
			exportData("��ֵ�б�",$title,$_data);
			exit;
		}
	}else{
		$msg = array($result);
	}
}

/**
 * ��ֵ��¼
 **/
elseif ($_A['query_type'] == "recharge_new"){
	if(isset($_POST['username']) && $_POST['username']!=""){
		$_data['username'] = $_POST['username'];
		$result = userClass::GetOnes($_data);
		if ($result==false){
			$msg = array("�û���������");
		}elseif ($result['areaid']!=$data['areaid'] && $data['areaid']!="0"){
			$msg = array("ֻ��Ϊ�Լ�վ����û���ֵ��");
		}
		else{
			$data['user_id'] = $result['user_id'];
			$data['status'] = 0;
			$data['remark']=$_POST['remark'];  //  2013-8-6
			$data['money'] = $_POST['money'];
			$data['type'] = 2;
			$data['payment'] = 0;
			$data['fee'] = 0;
			$data['trade_no'] = time().$result['user_id'].rand(1,9);
			$result = accountClass::AddRecharge($data);
			if ($result !== true){
				$msg = array("����ʧ��");
			}else{
				$msg = array("�����ɹ�");
			}
		}
	}
}

/**
 * �۳�����
 **/
elseif ($_A['query_type'] == "deduct"){
	if(isset($_POST['username']) && $_POST['username']!=""){
		$_data['username'] = $_POST['username'];
		$result = userClass::GetOnes($_data);
		if ($result==false){
			$msg = array("�û���������");
		}elseif ($_POST['valicode']!=$_SESSION['valicode']){
			$msg = array("��֤�벻��ȷ");
		}else{
			$data['user_id'] = $result['user_id'];
			$data['money'] = $_POST['money'];
			$data['type'] = $_POST['type'];
			$data['remark'] = $_POST['remark'];
			$result = accountClass::Deduct($data);
			if ($result !== true){
				$msg = array($result);
			}else{
				$msg = array("�����ѳɹ��۳�","",$_A['query_url']."/deduct");
				$_SESSION['valicode'] = "";
			}
		}
	}
}


/**
 * �ʽ�ʹ�ü�¼
 **/
elseif ($_A['query_type'] == "log"){
	$_A['list_title'] = "�ʽ�ʹ�ü�¼";

	if (isset($_REQUEST['user_id'])){
		$data['user_id'] = $_REQUEST['user_id'];
	}

	if (isset($_REQUEST['username'])){
		$data['username'] =urldecode( $_REQUEST['username']);
	}
	if (isset($_REQUEST['type'])){
		$data['type'] = $_REQUEST['type'];
	}

	if (isset($_REQUEST['dotime1'])){
		$data['dotime1'] = $_REQUEST['dotime1'];
	}

	if (isset($_REQUEST['dotime2'])){
		$data['dotime2'] = $_REQUEST['dotime2'];
	}
	
	if (isset($_REQUEST['borrow_status'])){
		$data['borrow_status'] = $_REQUEST['borrow_status'];
	}

	$data['page'] = $_A['page'];
	$data['epage'] = $_A['epage'];

	if (isset($_REQUEST['typeaction']) && $_REQUEST['typeaction']=="excel"){
		 
		$title = array("��¼ʱ��","�û�����","����","�ܽ��","�������","���ý��","������","���ս��","���׶Է�","��ע","��¼��վ","��ؽ���");
		$data['limit'] = "all";

		$result = accountClass::GetLogListForExcel($data);

		exportData("�ʽ���ˮ��¼",$title,$result);
		exit;
	}

	$result = accountClass::GetLogList($data);

	if (is_array($result)){
		$pages->set_data($result);
		$_A['account_log_list'] = $result['list'];
		$_A['showpage'] = $pages->show(3);

	}else{
		$msg = array($result);
	}
}
/**
 * �ʽ�ʹ�ü�¼
 **/
elseif ($_A['query_type'] == "logtender"){
	$_A['list_title'] = "�ʽ�ʹ�ü�¼";

	if (isset($_REQUEST['user_id'])){
		$data['user_id'] = $_REQUEST['user_id'];
	}

	if (isset($_REQUEST['username'])){
		$data['username'] = urldecode($_REQUEST['username']);
	}

	if (isset($_REQUEST['dotime1'])){
		$data['dotime1'] = $_REQUEST['dotime1'];
	}

	if (isset($_REQUEST['dotime2'])){
		$data['dotime2'] = $_REQUEST['dotime2'];
	}
	if (isset($_REQUEST['subsite_id'])){
		$data['subsite_id'] = $_REQUEST['subsite_id'];
	}
	
	$data['borrow_status'] = 3;
	$data['type'] = "tender";

	$data['page'] = $_A['page'];
	$data['epage'] = $_A['epage'];

	if (isset($_REQUEST['typeaction']) && $_REQUEST['typeaction']=="excel"){
		 
		$title = array("��¼ʱ��","�û�����","����","�ܽ��","�������","���ý��","������","���ս��","���׶Է�","��ע","��¼��վ","��ؽ���");
		$data['limit'] = "all";

		$result = accountClass::GetLogListForExcel($data);

		exportData("�ʽ���ˮ��¼",$title,$result);
		exit;
	}

	$result = accountClass::GetLogList($data);
	if (is_array($result)){
		$pages->set_data($result);
		require_once(ROOT_PATH."modules/subsite/subsite.class.php");
		$_A['subsite_list'] = subsiteClass::GetSubsiteList();
		$_A['account_log_list'] = $result['list'];
		$_A['showpage'] = $pages->show(3);

	}else{
		$msg = array($result);
	}
}


/**
 * �鿴
 **/
elseif ($_A['query_type'] == "view"){
	$_A['list_title'] = "�鿴��֤";
	if (isset($_POST['id'])){
		$var = array("id","status","verify_remark","jifen");
		$data = post_var($var);
		$data['verify_user'] = $_SESSION['user_id'];
		$result = accountClass::Update($data);

		if ($result !== true){
			$msg = array($result);
		}else{
			$msg = array("�����ɹ�");
		}
		$user->add_log($_log,$result);//��¼����
	}else{
		$data['id'] = $_REQUEST['id'];
		$_A['account_result'] = accountClass::GetOne($data);
	}
}
//liukun add for bug 245 begin
elseif ($_A['query_type'] == "wsfl_get_list"){
	$con_connect_ws = isset($_G['system']['con_connect_ws'])?$_G['system']['con_connect_ws']:"0";
	if ($con_connect_ws=="0"){
		die();
	}
	$point2account = isset($_G['system']['con_point2account'])?$_G['system']['con_point2account']:"2.52";
	//ȡ���ϴλ�ȡ����󷵻���¼��id
	$last_process_id = 0;
	$sql="select max(process_id) as last_process_id from  {return_serial}  ";
	$result = $mysql->db_fetch_array($sql);
	fb($result, FirePHP::TRACE);
	if($result == false || $result['last_process_id'] ==null){
		$last_process_id = 0;
	}
	else{
		$last_process_id = $result['last_process_id'];
	}
	$total_rs_num = 0;
	$i=0;
	while(true){
		$i++;
		if($i>50) {break;}//��ֹ��ѭ��
		$post_data=array();
		//ÿ�ζ�����һ�δ���������һ����ʼ
		$post_data['Start']=$last_process_id;
		$post_data['Num']="500";
		//fb($post_data, FirePHP::TRACE);
		fb($last_process_id, FirePHP::TRACE);
		$return_list_result = webService('GetMListInfo',$post_data);
		//liukun add for bug 52 begin
		//liukun add for bug 52 end
		//liukun add for bug 52 begin
		fb($return_list_result, FirePHP::TRACE);
		//liukun add for bug 52 end

		if (is_array($return_list_result['MallRebatesProcess'][0])){
			$fl_list = $return_list_result['MallRebatesProcess'];
		}elseif($return_list_result['MallRebatesProcess']['ProcessID'] > 0){
			$fl_list = $return_list_result;
		}else{
			break;
		}
		$total_rs_num += count($fl_list);
		foreach ($fl_list as $key => $value){
			if ($value['ProcessID'] > $last_process_id){
				$last_process_id = $value['ProcessID'];
			}
			$return_data['process_id'] = $value['ProcessID'];
			$return_data['user_id'] = $value['UserID'];
			$return_data['from_user_id'] = $value['FromUserID'];
			$return_data['plate_num'] = $value['PlateNum'];
			$return_data['mony'] = $value['Mony'];
			$return_data['income_time'] = $value['IncomeTime'];
			$return_data['aside1'] = $value['Aside1'];
			$return_data['aside2'] = $value['Aside2'];
			$return_data['aside3'] = $value['Aside3'];
			$return_data['aside4'] = $value['Aside4'];
			$return_data['aside5'] = $value['Aside5'];
			$return_data['aside6'] = $value['Aside6'];
			$return_data['aside7'] = $value['Aside7'];
			$return_data['aside8'] = $value['Aside8'];
			$return_data['aside9'] = $value['Aside9'];
			$return_data['aside10'] = $value['Aside10'];
			$return_data['process'] = 0;
			//$return_data['loaner_money'] = round(floor($value['Mony'] / $point2account * 100) /100, 2);
			$return_data['loaner_money'] = $value['Mony'];
			$sql = "insert into  {return_serial}  set `addtime` = '".time()."',`addip` = '".ip_address()."'";
			foreach($return_data as $key => $value){
				$sql .= ",`$key` = '$value'";
			}
			 
			$result = $mysql->db_query($sql);
			//ֻҪ��һ��û�д���ɹ������´��ٴ������δ������
			if ($result == false){
				break;
			}
		}
	}
	 
	 
	 
	// 	$data['page'] = $_A['page'];
	// 	$data['epage'] = $_A['epage'];
	// 	$result = accountClass::GetWsflList($data);

	// 	if (is_array($result)){
	// 		$pages->set_data($result);
	// 		$_A['wsfl_list'] = $result['list'];
	// 		$_A['showpage'] = $pages->show(3);

	// 	}else{
	// 		$msg = array($result);
	// 	}


	$msg = array("�����ɹ�����ȡ��{$total_rs_num}��������¼��");
}

//liukun add for bug 245 end
elseif ($_A['query_type'] == "wsfl_list"){
	$_A['list_title'] = "�˻���Ϣ�б�";

	if (isset($_REQUEST['user_id']) && $_REQUEST['user_id']!=""){
		$data['user_id'] = $_REQUEST['user_id'];
	}

	if (isset($_REQUEST['username']) && $_REQUEST['username']!=""){
		$data['username'] = urldecode($_REQUEST['username']);
	}

	$data['page'] = $_A['page'];
	$data['epage'] = $_A['epage'];
	$result = accountClass::GetWsflList($data);

	if (is_array($result)){
		$pages->set_data($result);
		$_A['wsfl_list'] = $result['list'];
		$_A['showpage'] = $pages->show(3);

	}else{
		$msg = array($result);
	}
}

elseif ($_A['query_type'] == "wsfl_cash"){
	//$point2account = isset($_G['system']['con_point2account'])?$_G['system']['con_point2account']:"2.52";
	//��ʼ�����ʽ��˻�
	$fl_time=$_REQUEST['fl_time'];
	$sql = "select sum(rs.loaner_money) as loaner_money, u.user_id as inner_user_id from  {return_serial}  as rs,  {user}  as u where rs.user_id= u.ws_user_id and process = 0 and rs.plate_num<2  and LEFT(rs.income_time, 10) = '{$fl_time}' group by rs.user_id";
	

	$process_list = $mysql->db_fetch_arrays($sql);

	foreach ($process_list as $key => $value)
	{
		if(round_money($value['loaner_money'])>=0.01)
		{
			$account_result =  accountClass::GetOne(array("user_id"=>$value['inner_user_id']));
			$account_log['user_id'] =$value['inner_user_id'];
			$account_log['type'] = "point2account";
	// 		$account_log['money'] = round(floor($value['mony'] / $point2account * 100) /100, 2);
			//ֱ��ʹ�û�ȡ������¼ʱ�������Ӧ��ʵ�ʽ��������¼���
			$account_log['money'] = round_money($value['loaner_money']);
			$account_log['total'] = $account_result['total']+$account_log['money'];
			$account_log['use_money'] = $account_result['use_money']+$account_log['money'];
			$account_log['no_use_money'] = $account_result['no_use_money'];
			$account_log['collection'] =$account_result['collection'];
			$account_log['to_user'] = 0;
			$account_log['remark'] = "���ʱ���";
			$result = accountClass::AddLog($account_log);
	
			//TODO ����account��ws_in_moneyֵ
			if ($result==false){
				break;
			}else{
				$ws_log['user_id']=$value['inner_user_id'];
				$ws_log['account']=$account_log['money'];
				$ws_log['type']="ws_return";
				$ws_log['direction']="1";
				$ws_log['remark']="���ʱ���";
				wsaccountClass::addWSlog($ws_log);
			}
		}

		//���ûع��ɹ����
		$sql = "update  {return_serial}  set `process` = 1 where LEFT(income_time, 10) = '{$fl_time}'";

		$result = $mysql->db_query($sql);
		if ($result==false){
			break;
		}
	}

	if ($result !== true){
		$msg = array($result);
	}else{
		$msg = array("�����ɹ�");
	}
}


elseif ($_A['query_type'] == "wsfl_cash_report"){
	$_A['list_title'] = "�˻���Ϣ�б�";

	if (isset($_REQUEST['user_id']) && $_REQUEST['user_id']!=""){
		$data['user_id'] = $_REQUEST['user_id'];
	}

	if (isset($_REQUEST['username']) && $_REQUEST['username']!=""){
		$data['username'] = urldecode($_REQUEST['username']);
	}

	$data['page'] = $_A['page'];
	$data['epage'] = $_A['epage'];
	$result = accountClass::GetWsflCashList($data);



	if (is_array($result)){
		$pages->set_data($result);
		$_A['wsfl_cash_list'] = $result['list'];
		$_A['showpage'] = $pages->show(3);

	}else{
		$msg = array($result);
	}
}

elseif ($_A['query_type'] == "wsfl_queue_list"){
	$_A['list_title'] = "�������в�ѯ";

	if (isset($_REQUEST['user_id']) && $_REQUEST['user_id']!=""){
		$data['user_id'] = $_REQUEST['user_id'];
	}

	if (isset($_REQUEST['username']) && $_REQUEST['username']!=""){
		$data['username'] = urldecode($_REQUEST['username']);
	}

	$data['page'] = $_A['page'];
	$data['epage'] = $_A['epage'];
	$result = accountClass::GetQueuelList($data);



	if (is_array($result)){
		$pages->set_data($result);
		$_A['wsfl_queue_list'] = $result['list'];
		$_A['showpage'] = $pages->show(3);

	}else{
		$msg = array($result);
	}
}
elseif($_A['query_type'] == "wsfl_queue_call")
{
	ini_set("max_execution_time", "1800000"); 
	ini_set('default_socket_timeout',600000);
	$bl=explode(',','2,2');
	$post_data=array();
	$post_data['dividends']=explode(',','120,500,120,500');
	$post_data['type16']=$bl[0];
	$post_data['type12016']=$bl[1];
	$post_data['Probability']=explode(',','0');
	$post_data['Probability12016']=explode(',','0');
	$_str=webService('C_Cal',$post_data);
	$msg = array($_str.'������ɣ�');	
}

elseif ($_A['query_type'] == "wsfl_queue_query"){
	$con_connect_ws = isset($_G['system']['con_connect_ws'])?$_G['system']['con_connect_ws']:"0";
	if ($con_connect_ws=="0"){
		die();
	}
	$point2account = isset($_G['system']['con_point2account'])?$_G['system']['con_point2account']:"2.52";

	$queue_id = $_REQUEST['id'];



	$post_data=array();
	//ÿ�ζ�����һ�δ���������һ����ʼ
	$post_data['ID']=$queue_id;
	//fb($post_data, FirePHP::TRACE);
	$ws_result = webService('C_Query',$post_data);


	if ($ws_result >= 0){
			
		$sql = " update  {return_queue}  set in_ed_money='{$ws_result}' where ws_queue_id='{$queue_id}' limit 1";
		$mysql ->db_query($sql);
			

	}







	$data['page'] = $_A['page'];
	$data['epage'] = $_A['epage'];
	$result = accountClass::GetQueuelList($data);



	if (is_array($result)){
		$pages->set_data($result);
		$_A['wsfl_queue_list'] = $result['list'];
		$_A['showpage'] = $pages->show(3);

	}else{
		$msg = array($result);
	}
}


elseif ($_A['query_type'] == "wsfl_queue_close"){
	$con_connect_ws = isset($_G['system']['con_connect_ws'])?$_G['system']['con_connect_ws']:"0";
	if ($con_connect_ws=="0"){
		die();
	}
	$point2account = isset($_G['system']['con_point2account'])?$_G['system']['con_point2account']:"2.52";
	$queue_id = $_REQUEST['id'];
	$post_data=array();
	//ÿ�ζ�����һ�δ���������һ����ʼ
	$post_data['ID']=$queue_id;
	//fb($post_data, FirePHP::TRACE);
	$ws_result = webService('C_Consume_Close',$post_data);

	if ($ws_result >= 0){			
		$sql = " update  {return_queue}  set status=1 where ws_queue_id={$queue_id} limit 1";
		$mysql ->db_query($sql);
	}
	$data['page'] = $_A['page'];
	$data['epage'] = $_A['epage'];
	$result = accountClass::GetQueuelList($data);
	if (is_array($result)){
		$pages->set_data($result);
		$_A['wsfl_queue_list'] = $result['list'];
		$_A['showpage'] = $pages->show(3);

	}else{
		$msg = array($result);
	}
}
elseif($_A['query_type'] == "wsfl_rebate_list")
{
	$web_id=strip_tags($_GET['web_id']);
	$user_name=strip_tags($_GET['user_name']);
	$user_id=intval($_GET['user_id']);
	$starttime=strip_tags($_GET['starttime']);
	$endtime=strip_tags($_GET['endtime']);
	$p = empty($_GET['p']) ? 1 : $_GET['p'];
	$type=$_REQUEST['type'];
	$url=$_A['query_url']."/wsfl_rebate_list&a=cash&starttime=$starttime&endtime=$endtime&p=$p&web_id=$web_id&type=$type";
	$sqlW='1=1';
	
	$PageSize = 20;  //ÿҳ��ʾ��¼��	
	if($user_id!=0)
	{
		$row=$mysql->db_fetch_array("select ws_user_id from {user} where user_id='{$user_id}' limit 1");
		$web_id=$row['ws_user_id'];
	}
	if($user_name!=0)
	{
		$row=$mysql->db_fetch_array("select ws_user_id from {user} where username='{$user_name}' limit 1");
		$web_id=$row['ws_user_id'];
	}
	
	$data=array();
$openurl='http://'.$_G['system']['con_webservice_url']."/connstr.asp?starttime=$starttime&endtime=$endtime&page=$p&web_id=$web_id&type=$type&rp=20";

	$str=sock_open($openurl,$data);	
	$str=explode('[#]',$str);

	$list=explode('<br>',$str[0]);
	$result=array();
	foreach ($list as $i=>$v)  //ת��������
	{
		$tem=explode('|',$v);
		foreach($tem as $_i=>$_v)
		{
			if($_i==0)	$result[$i]['listid']=$_v;
			if($_i==1)	$result[$i]['web_id']=$_v;
			if($_i==2)	$result[$i]['money']=$_v;
			if($_i==3)	$result[$i]['type']=$_v;
			if($_i==4)	$result[$i]['addtime']=$_v;
			if($_i==5)	$result[$i]['RebatesMoney']=$_v;
			if($_i==6)	$result[$i]['RebatesStatus']=$_v;				
			if($_i==10)	$result[$i]['Aside4']=$_v;
			if($_i==11)	$result[$i]['Aside5']=$_v;			
		}
	}
	$arr_user=array();
	foreach($result as $i=>$v)
	{
		if ($v['type'] == 0)
		{
			$result[$i]['inmoney'] = $v['money'] * 0.15;
			$result[$i]['type'] = '12%';
		}
		elseif ($v['type'] == 1)
		{
			$result[$i]['inmoney'] = $v['money'] * 0.16;
			$result[$i]['type'] = '16%';
		}
		elseif ($v['type'] == 2)
		{
			$result[$i]['inmoney'] = $v['money'] * 0.31;
			$result[$i]['type'] = '˫����';
		}
		if($v['RebatesStatus']==1)
		{
			$result[$i]['RebatesStatus']='������';	
		}
		else
		{
			$result[$i]['RebatesStatus']='����';
			$result[$i]['Aside4']='';
		}
		if(array_key_exists($v['web_id'],$arr_user))
		{
			$tem=explode('[#]',$arr_user[$v['web_id']]);
			$result[$i]['user_id'] = $tem[0];
			$result[$i]['user_name'] = $tem[1];
		}
		else
		{
			$row=$mysql->db_fetch_array("select user_id,username from {user} where ws_user_id='{$v['web_id']}' limit 1");
			
			if($row)
			{
				$result[$i]['user_id'] = $row['user_id'];
				$result[$i]['user_name'] = $row['username'];
				$arr_user[$v['web_id']]=$row['user_id'].'[#]'.$row['username'];		
			}
		}
	}
	$RecordCount = $str[1];//��ȡ�ܼ�¼��
	if(!empty($p))
	{
		$StartRow=($p-1)*$PageSize;
	}
	else
	{
		$StartRow=0;
		$p=1;
	}
	
	if($RecordCount>0)
	{
		$_A['page1']=page1($RecordCount,$PageSize,$p,$url);
		$_A['wsfl_rebate_list']=$result;
	}	
	
}

/**
 * ��ȹ���
 **/
elseif ($_A['query_type'] == "stock"){
	$_A['list_title'] = "�ɷݹ���";

	if (isset($_REQUEST['user_id']) && $_REQUEST['user_id']!=""){
		$data['user_id'] = $_REQUEST['user_id'];
	}

	if (isset($_REQUEST['username']) && $_REQUEST['username']!=""){
		$data['username'] = urldecode($_REQUEST['username']);
	}

	if (isset($_REQUEST['optype']) && $_REQUEST['optype']!=""){
		$data['optype'] = $_REQUEST['optype'];
	}

	if (isset($_REQUEST['status']) && $_REQUEST['status']!=""){
		$data['status'] = $_REQUEST['status'];
	}
	$data['page'] = $_A['page'];
	$data['epage'] = $_A['epage'];
	$result = accountClass::GetStockApplyList($data);

	if (is_array($result)){
		$pages->set_data($result);
		$_A['stock_list'] = $result['list'];
		$_A['showpage'] = $pages->show(3);

	}else{
		$msg = array($result);
	}
}

/**
 * ��ȹ���
 **/
elseif ($_A['query_type'] == "stock_view"){
	//check_rank("borrow_amount_view");//���Ȩ��
	$data['id'] = $_REQUEST['id'];
	$result = accountClass::GetStockOne($data);
	if (isset($_POST['status'])){
		$data['status'] = $_POST['status'];
		$data['verify_remark'] = $_POST['verify_remark'];

		$result = accountClass::CheckStock($data);

		if ($result !=1){
			$msg = array($result);
		}else{
			$msg = array("�����ɹ�","",$_A['query_url']."/stock");
		}
		$user->add_log($_log,$result);//��¼����
	}

	else{
		if (is_array($result)){

			$_A['stock_result'] = $result;


		}else{
			$msg = array($result);
		}

	}


}
elseif ($_A['query_type'] == "site"){	
	accountClass::subsite_jiesuan();
	$_A['subsite_money']=accountClass::get_subsite_money();
	$_A['list_title'] = "��վ�ʽ�";
}
elseif($_A['query_type']=='site_moneylog')
{
	$_G['linkage']['account_type']['subsite_reducemoney']='��ӱ�֤��';
	$_G['linkage']['account_type']['subsite_addmoney']='���ٱ�֤��';
	accountClass::subsite_jiesuan();
	$_A['subsite_money']=accountClass::get_subsite_money();	
	
	$_A['list_title'] = "��վ�ʽ�ʹ�ü�¼";

	if (isset($_REQUEST['user_id'])){
		$data['user_id'] = $_REQUEST['user_id'];
	}
	if (isset($_REQUEST['username'])){
		$data['username'] =urldecode( $_REQUEST['username']);
	}

	if (isset($_REQUEST['dotime1'])){
		$data['dotime1'] = $_REQUEST['dotime1'];
	}
	if (isset($_REQUEST['dotime2'])){
		$data['dotime2'] = $_REQUEST['dotime2'];
	}
	if (isset($_REQUEST['type'])){
		$data['type'] = $_REQUEST['type'];
	}	
	if(isset($_REQUEST['subsite_id']))
	{
		$data['subsite_id'] = $_REQUEST['subsite_id'];
	}
	$data['page'] = $_A['page'];
	$data['epage'] = $_A['epage'];
	//$result = accountClass::get_acountlist_site($data);
	
	if (isset($_REQUEST['typeaction']) && $_REQUEST['typeaction']=="excel"){		 
		$title = array("��¼ʱ��","�û�����","����","�ܽ��","�������","��ע","��¼��վ","��ؽ���");
		$data['limit'] = "all";
		$data['excel'] = "excel";
		$result = accountClass::get_subsite_moneylog($data);
		exportData("��վ�ʽ���ˮ��¼",$title,$result);
		exit;
	}
	$result1 = accountClass::get_subsite_moneylog($data);

	$pages->set_data($result1);
	$_A['subsite_moneylog'] = $result1['list'];
	$_A['account']=$result1['account'];
	$_A['showpage'] = $pages->show(3);
	
}
elseif ($_A['query_type'] == "site_changemoney")
{
	$_A['list_title'] = "���ı�֤��";
	include_once(ROOT_PATH."modules/subsite/subsite.class.php");
	$subsite=subsiteClass::GetOne(array('id'=>$_REQUEST['subsite_id']));
	$_A['subsite_name']=$subsite['sitename']."��".$subsite['website']."��";
	if(isset($_POST['subsite_id']))
	{
		$account_log=array();					
		$account_log['siteid']=(int)$_POST['subsite_id'];
		$account_log['user_id']=(int)$_SESSION['user_id'];
		
		$account_log['addtime']=time();
		$account_log['borrow_id']=0;
		$account_log['remark']=$_POST['remark'];
		$account_log['money']=(float)$_POST['money'];
		if($_POST['type']==1)
		{
			$account_log['type']='subsite_addmoney';
			$account_log['total']=$subsite['jiesuan_money']+$account_log['money'];
		}
		else
		{
			$account_log['type']='subsite_reducemoney';
			$account_log['total']=$subsite['jiesuan_money']-$account_log['money'];
		}
		accountClass::subsite_addlog($account_log);
		$msg = array("�����ɹ�","",$_A['query_url']."/site_moneylog&subsite_id=".$_REQUEST['subsite_id']."&a=cash");

	}
}
elseif($_A['query_type']=='autolist')
{
	$result=borrowClass::GetAllAutoList();
	$tmoney=0;
	$use_money=0;
	foreach($result as $row)
	{
		$t=min($row['use_money'],$row['tender_account']);
		
		$tmoney+=$t;
		$use_money+=$row['use_money'];
	}
	$_A['tmoney']=$tmoney;
	$_A['use_money']=$use_money;
	$_A['rate']=round($tmoney/$use_money,2)*100 . '%';
	$_A['autolist']=$result;
}
//��ֹ�Ҳ���
else{
	$msg = array("���������벻Ҫ�Ҳ���");
}


function sock_open($url,$data=array())
	{	
		$row = parse_url($url);
		$host = $row['host'];
		$port = isset($row['port']) ? $row['port']:80;
		
		$post='';//Ҫ�ύ������.
		foreach($data as $k=>$v)
		{
			//$post.=$k.'='.$v.'&';
			$post .= rawurlencode($k)."=".rawurlencode($v)."&";	//תURL��׼��
		}
		$fp = fsockopen($host, $port, $errno, $errstr, 30); 
		if (!$fp)
		{ 
			echo "$errstr ($errno)<br />\n"; 
		} 
		else 
		{
			$header = "GET $url HTTP/1.1\r\n"; 
			$header .= "Content-Type: application/x-www-form-urlencoded\r\n";
			$header .= "User-Agent: MSIE\r\n";
			$header .= "Host: $host\r\n"; 
			$header .= "Content-Length: ".strlen($post)."\r\n";
			$header .= "Connection: Close\r\n\r\n"; 
			$header .= $post."\r\n\r\n";		
			fputs($fp, $header); 
			//$status = stream_get_meta_data($fp);
			
			while (!feof($fp)) 
			{
				$tmp .= fgets($fp, 128);
			}
			fclose($fp);
			$tmp = explode("\r\n\r\n",$tmp);
			unset($tmp[0]);
			$tmp= implode("",$tmp);
		}
		return $tmp;
	}
	// ��ҳ����
function page1($num, $perpage, $curpage, $mpurl) {
	$multipage = '';
	//$mpurl .= strpos($mpurl, '?') ? '&amp;' : '?';
	if(strpos($mpurl,'?')===false)
		$mpurl .='?';
	else
		$mpurl .='&amp;';
	if($num > $perpage) {
		$page = 10;
		$offset = 5;
		$pages = @ceil($num / $perpage);
		if($page > $pages) {
			$from = 1;
			$to = $pages;
		} else {
			$from = $curpage - $offset;
			$to = $curpage + $page - $offset - 1;
			if($from < 1) {
				$to = $curpage + 1 - $from;
				$from = 1;
				if(($to - $from) < $page && ($to - $from) < $pages) {
					$to = $page;
				}
			} elseif($to > $pages) {
				$from = $curpage - $pages + $to;
				$to = $pages;
				if(($to - $from) < $page && ($to - $from) < $pages) {
					$from = $pages - $page + 1;
				}
			}
		}
		$multipage = ($curpage - $offset > 1 && $pages > $page ? '<a href="'.$mpurl.'page=1" class="p_redirect">��ҳ</a>' : '').($curpage > 1 ? '<a href="'.$mpurl.'p='.($curpage - 1).'" class="p_redirect">��һҳ</a>' : '');
		for($i = $from; $i <= $to; $i++) {
			$multipage .= $i == $curpage ? '<span class="p_curpage">'.$i.'</span>' : '<a href="'.$mpurl.'p='.$i.'" class="p_num">'.$i.'</a>';
		}
		$multipage .= ($curpage < $pages ? '<a href="'.$mpurl.'p='.($curpage + 1).'" class="p_redirect">��һҳ</a>' : '').($to < $pages ? '<a href="'.$mpurl.'p='.$pages.'" class="p_redirect">βҳ</a>' : '');
		$multipage = $multipage ? '<div class="p_bar"><span class="p_info">�ܼ�¼:'.$num.'</span>'.$multipage.'</div>' : '';
	}
	return $multipage;
}
?>