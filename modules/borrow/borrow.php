<?
if (!defined('ROOT_PATH'))  die('���ܷ���');//��ֱֹ�ӷ���
check_rank("borrow_".$_A['query_type']);//���Ȩ��

//include_once("borrow.class.php");

include_once(ROOT_PATH."modules/borrow/borrow.class.php");

require_once(ROOT_PATH."modules/borrow/biao/circulationbiao.class.php");
require_once(ROOT_PATH."modules/blacklist/blacklist.class.php");


//liukun add for bug 52 begin
$firePHPEnable=TRUE;
if ($firePHPEnable){
	require_once('modules/FirePHPCore/FirePHP.class.php');
	require_once('modules/FirePHPCore/fb.php');
	ob_start();

	$firephp = FirePHP::getInstance(true);
}
//liukun add for bug 52 end

$_A['list_purview'] =  array("borrow"=>array("������"=>array("borrow_list"=>"����б�",
		"borrow_new"=>"��ӽ��",
		"borrow_edit"=>"�༭���",
		"borrow_amount"=>"�����",
		"borrow_amount_view"=>"��ȹ���",
		"borrow_del"=>"ɾ�����",
		"borrow_view"=>"��˽��",
		"borrow_subremark"=>"��վ��˽��",
		"borrow_full"=>"�����б�",
		"borrow_repayment"=>"�ѻ���",
		"borrow_liubiao"=>"����",
		"borrow_late"=>"����",
		"borrow_full_view"=>"�������",
		"borrow_amount_subsite"=>"��վ��˶������")));
//  echo serialize($_A['list_purview']);
//Ȩ��
$_A['list_name'] = $_A['module_result']['name'];
$_A['list_menu'] = "<a href='{$_A['query_url']}{$_A['site_url']}'>���н��</a> - <a href='{$_A['query_url']}&status=0{$_A['site_url']}'>�������</a> -  <a href='{$_A['query_url']}&status=1{$_A['site_url']}'>�����б��</a> -  <a href='{$_A['query_url']}/full&status=1{$_A['site_url']}'>���������</a> -  <a href='{$_A['query_url']}/full&status=3{$_A['site_url']}'>�������ͨ��</a> - <a href='{$_A['query_url']}/full&status=4{$_A['site_url']}'>�������δͨ��</a> - <a href='{$_A['query_url']}/repayment{$_A['site_url']}&status=1'>�ѻ���</a>  -  <a href='{$_A['query_url']}/liubiao{$_A['site_url']}'>����</a>  - <a href='{$_A['query_url']}/late{$_A['site_url']}'>�������б�</a> - <a href='{$_A['query_url']}/lateFast{$_A['site_url']}'>���������б�</a>  - <a href='{$_A['query_url']}/amount{$_A['site_url']}'>�����</a> - <a href='{$_A['query_url']}/tongji{$_A['site_url']}'>ͳ��</a>  ";


/**
 * �������Ϊ�յĻ�����ʾ���е��ļ��б�
 **/

//������Ա�����ڵķ�վ��Ϣ����
$data['areaid'] = $_SESSION['areaid'];
$_A['areaid'] =  $_SESSION['areaid'];
$_A['admin_type_id'] =  $_SESSION['type_id'];
if ($_A['query_type'] == "list"){
	$_A['list_title'] = "��Ϣ�б�";

	if (isset($_POST['id']) && $_POST['id']!=""){
		$data['id'] = $_POST['id'];
		$data['flag'] = $_POST['flag'];
		$data['view'] = $_POST['view'];
		$result = borrowClass::Action($data);
		if ($result==true){
			$msg = array("�޸ĳɹ�","",$_A['query_url'].$_A['site_url']);
		}else{
			$msg = array("�޸�ʧ�ܣ��������Ա��ϵ");
		}

	}else{
		if (isset($_REQUEST['user_id'])){
			$data['user_id'] = $_REQUEST['user_id'];
		}
		if (isset($_REQUEST['status']) && $_REQUEST['status']!=""){
			$data['status'] = $_REQUEST['status'];
		}

		if (isset($_REQUEST['username']) && $_REQUEST['username']!=""){
			$data['username'] = $_REQUEST['username'];
		}

// 		if (isset($_REQUEST['is_vouch'])){
// 			$data['is_vouch'] = $_REQUEST['is_vouch'];
// 		}

		if (isset($_REQUEST['biao_type']) && $_REQUEST['biao_type']!="all"){
			$data['biao_type'] = $_REQUEST['biao_type'];
		}



		$data['page'] = $_A['page'];
		$data['epage'] = $_A['epage'];
		$result = borrowClass::GetList($data);

		

		if (is_array($result)){
			$pages->set_data($result);
			$_A['borrow_list'] = $result['list'];
			$_A['showpage'] = $pages->show(3);

		}else{
			$msg = array($result);
		}
	}
}

/**
 * ��ȹ���
 **/
elseif ($_A['query_type'] == "amount"){
	check_rank("borrow_amount");//���Ȩ��
	$_A['list_title'] = "��ȹ���";

	if (isset($_REQUEST['user_id']) && $_REQUEST['user_id']!=""){
		$data['user_id'] = $_REQUEST['user_id'];
	}

	if (isset($_REQUEST['username']) && $_REQUEST['username']!=""){
		$data['username'] = $_REQUEST['username'];
	}

	if (isset($_REQUEST['type']) && $_REQUEST['type']!=""){
		$data['type'] = $_REQUEST['type'];
	}

	if (isset($_REQUEST['status']) && $_REQUEST['status']!=""){
		$data['status'] = $_REQUEST['status'];
	}
	$data['page'] = $_A['page'];
	$data['epage'] = $_A['epage'];
	$result = borrowClass::GetAmountApplyList($data);

	if (is_array($result)){
		$pages->set_data($result);
		$_A['borrow_amount_list'] = $result['list'];
		$_A['showpage'] = $pages->show(3);

	}else{
		$msg = array($result);
	}
}

/**
 * ��ȹ���
 **/
elseif ($_A['query_type'] == "amount_view"){
	check_rank("borrow_amount_view");//���Ȩ��
	$data['id'] = $_REQUEST['id'];
	$result = borrowClass::GetAmountApplyOne($data);
	if (isset($_POST['status'])){
		$data['user_id'] = $result['user_id'];
		$data['status'] = $_POST['status'];
		$data['type'] = $_POST['type'];
		$data['account'] = $_POST['account'];
		$data['verify_remark'] = $_POST['verify_remark'];

		$result = borrowClass::CheckAmountApply($data);

		if ($result !=1){
			$msg = array($result);
		}else{
			$msg = array("�����ɹ�","",$_A['query_url']."/amount");
		}
		$user->add_log($_log,$result);//��¼����
	}

	else{
		if (is_array($result)){
			$sql = "select * from  {user_amount_type}  where amount_type_name='{$result['type']}'";
			$amount_type_result = $mysql ->db_fetch_array($sql);

			$_A['borrow_amount_result'] = $result;
			$_A['borrow_amount_result']['fee_rate'] = $amount_type_result['fee_rate'] * 100;
				
				
		}else{
			$msg = array($result);
		}

	}


}

/**
 * ��ȹ���
 **/
elseif ($_A['query_type'] == "amount_subsite"){
	check_rank("borrow_amount_subsite");//���Ȩ��
	$data['id'] = $_REQUEST['id'];
	$result = borrowClass::GetAmountApplyOne($data);
	if (isset($_POST['subsite_remark'])){
		$data['subsite_remark'] = $_POST['subsite_remark'];

		$result = borrowClass::UpdateAmountApply($data);

		if ($result !==true){
			$msg = array($result,"",$_A['query_url']."/amount");
		}else{
			$msg = array("�ύ�������ɹ�","",$_A['query_url']."/amount");
		}
		$user->add_log($_log,$result);//��¼����
	}

	else{
		if (is_array($result)){
			$_A['borrow_amount_result'] = $result;

		}else{
			$msg = array($result);
		}

	}


}


/**
 * ���
 **/
elseif ($_A['query_type'] == "new"  || $_A['query_type'] == "edit" ){
	check_rank("borrow_new");//���Ȩ��
	$_A['list_title'] = "������Ϣ";

	//��ȡ�û�id����Ϣ
	if (isset($_REQUEST['user_id']) && isset($_POST['username'])){
		if(isset($_POST['user_id']) && $_POST['user_id']!=""){
			$data['user_id'] = $_POST['user_id'];
			$result = userClass::GetOne($data);
		}elseif(isset($_POST['username']) && $_POST['username']!=""){
			$data['username'] = $_POST['username'];
			$result = userClass::GetOne($data);
		}
		if ($result==false){
			$msg = array("�Ҳ������û�");
		}else{
			echo "<script>location.href='".$_A['query_url']."/new&user_id={$result['user_id']}'</script>";
		}
	}

	elseif (isset($_POST['name'])){
		$var = array("user_id","name","use","time_limit","style","account","apr","lowest_account","most_account","valid_time","award","part_account","funds","is_false","open_account","open_borrow","open_tender","open_credit","content");
		$data = post_var($var);
		if ($_POST['status']!=0 || $_POST['status']!=-1){
			$msg = array("�˱��Ѿ����б�����Ѿ���ɣ������޸�","",$_A['query_url'].$_A['site_url']);
		}else{
			if ($_A['query_type'] == "new"){
				$result = borrowClass::Add($data);
			}else{
				$data['id'] = $_POST['id'];
				$result = borrowClass::Update($data);
			}
				
			if ($result !== true){
				$msg = array($result);
			}else{
				$msg = array("�����ɹ�","",$_A['query_url'].$_A['site_url']);
			}
		}
		$user->add_log($_log,$result);//��¼����
	}

	elseif ($_A['query_type'] == "edit" ){
		$data['user_id'] = $_REQUEST['user_id'];
		$data['id'] = $_REQUEST['id'];
		$result = borrowClass::GetOne($data);
		if (is_array($result)){
			$_A['borrow_result'] = $result;
		}else{
			$msg = array($result);
		}

	}


	elseif(isset($_REQUEST['user_id']) && !isset($_POST['username'])){
		$data['user_id'] = $_REQUEST['user_id'];
		$result = userClass::GetOne($data);
		if ($result==false){
			$msg = array("������������","",$_A['query_url']);
		}else{
			$_A['user_result'] = $result;
			//$result = borrowClass::GetOne($data);
			//$_A['borrow_result'] = $result;
		}

	}

}

/**
 * �鿴
 **/
elseif ($_A['query_type'] == "view"){
	check_rank("borrow_view");//���Ȩ��
	$_A['list_title'] = "�鿴��֤";
	if (isset($_POST['id'])){
		$var = array("id","status","verify_remark");
		$data = post_var($var);

		$data['verify_user'] = $_G['user_id'];
		$data['verify_time'] = time();

		$result = borrowClass::Verify($data);


		if ($result ==false){
			$msg = array($result);
		}else{
			//����û��Ķ�̬
			if($data['status']==1){
				//�Զ�Ͷ��
				$brsql="select * from  {borrow}  where id ='".$_POST['id']."'";
				$br_row = $mysql->db_fetch_array($brsql);

				if(in_array($br_row['biao_type'], array("miao", "love", "circulation")) || $br_row['pwd']<>''){
					//���Զ�Ͷ��
				}else{
					$auto['id']=$data['id'];
					$auto['user_id']=$br_row['user_id'];
					$auto['total_jie']=$br_row['account'];
					$auto['zuishao_jie']=$br_row['lowest_account'];
					borrowClass::auto_borrow($auto);
				}
				//�Զ�Ͷ��
				$_data['user_id'] = $_POST['user_id'];
				$_data['content'] = "�ɹ�������\"<a href=\'/invest/a{$data['id']}.html\' target=\'_blank\'>{$_POST['name']}</a>\"����";
				$result = userClass::AddUserTrend($_data);
			}
			$msg = array("��˲����ɹ�","",$_A['query_url'].$_A['site_url']);
		}
		$user->add_log($_log,$result);//��¼����
	}else{
		$data['id'] = $_REQUEST['id'];
		$data['user_id'] = $_REQUEST['user_id'];
		$_A['borrow_result'] = borrowClass::GetOne($data);
		$userinfo = userClass::GetOne(array("user_id" => $data['user_id']));

		$_A['blacklist_otherinfo'] = blacklistClass::GetCountbycardid(array("card_id" => $userinfo['card_id']));
		$_A['blacklist_info'] = blacklistClass::GetOnebyUserid(array("user_id" => $data['user_id']));
		//liukun add for bug 115 begin
		if ($_A['borrow_result']['biao_type'] == 'circulation'){
			$classname = $_A['borrow_result']['biao_type']."biaoClass";
			$dynaBiaoClass = new $classname();
				
				
			$add_result = $dynaBiaoClass->getAdditionalInfo(array("borrow_id"=>$_A['borrow_result']['id']));
				
			$_A['borrow_additional_info'] = $add_result;
				
		}
		//liukun add for bug 115 end
	}
}

/**
 * ɾ��
 **/
elseif ($_A['query_type'] == "subremark"){
	//check_rank("borrow_subremark");//���Ȩ��
	$_A['list_title'] = "�鿴��֤";
	if (isset($_POST['id'])){


		$data['id'] = $_POST['id'];
		$data['subsite_status'] = $_POST['subsite_status'];
		$data['subsite_remark'] = $_POST['subsite_remark'];

		$result = borrowClass::UpdateSubRemark($data);


		if ($result ==false){
			$msg = array($result);
		}else{
				
			$msg = array("��������������ɹ�","",$_A['query_url'].$_A['site_url']);
		}
		$user->add_log($_log,$result);//��¼����
	}else{
		$data['id'] = $_REQUEST['id'];
		$data['user_id'] = $_REQUEST['user_id'];
		$_A['borrow_result'] = borrowClass::GetOne($data);
		$data['id'] = $_REQUEST['id'];
		$data['user_id'] = $_REQUEST['user_id'];
		$_A['borrow_result'] = borrowClass::GetOne($data);
		$userinfo = userClass::GetOne(array("user_id" => $data['user_id']));

		$_A['blacklist_otherinfo'] = blacklistClass::GetCountbycardid(array("card_id" => $userinfo['card_id']));
		$_A['blacklist_info'] = blacklistClass::GetOnebyUserid(array("user_id" => $data['user_id']));
		//liukun add for bug 115 begin
		if ($_A['borrow_result']['biao_type'] == 'circulation'){
			$classname = $_A['borrow_result']['biao_type']."biaoClass";
			$dynaBiaoClass = new $classname();
				
				
			$add_result = $dynaBiaoClass->getAdditionalInfo(array("borrow_id"=>$_A['borrow_result']['id']));
				
			$_A['borrow_additional_info'] = $add_result;
				
		}
		//liukun add for bug 115 end
	}
}

/**
 * ɾ��
 **/
elseif ($_A['query_type'] == "del"){
	check_rank("borrow_del");//���Ȩ��
	$data['id'] = $_REQUEST['id'];
	$result = borrowClass::Delete($data);
	if ($result !== true){
		$msg = array($result);
	}else{
		$msg = array("ɾ���ɹ�","",$_A['query_url'].$_A['site_url']);
	}
	$user->add_log($_log,$result);//��¼����
}


/**
 * �����б�
 **/
elseif ($_A['query_type'] == "full"){
	check_rank("borrow_full");//���Ȩ��
	$_A['list_title'] = "��Ϣ�б�";

	$data['page'] = $_A['page'];
	$data['epage'] = $_A['epage'];
	$data['type'] = 'review';
	if (isset($_REQUEST['status']) && $_REQUEST['status']!=""){
		$data['status'] = $_REQUEST['status'];
	}
// 	if (isset($_REQUEST['biaoType']) && $_REQUEST['biaoType']!=""){
// 		$data['biaoType'] = $_REQUEST['biaoType'];
// 	}
	if (isset($_REQUEST['biao_type']) && $_REQUEST['biao_type']!="all"){
		$data['biao_type'] = $_REQUEST['biao_type'];
	}
	if (isset($_REQUEST['username']) && $_REQUEST['username']!=""){
		$data['username'] = $_REQUEST['username'];
	}
	$result = borrowClass::GetList($data);
	if (is_array($result)){
		$pages->set_data($result);
		$_A['borrow_list'] = $result['list'];
		$_A['showpage'] = $pages->show(3);
	}else{
		$msg = array($result);
	}
}


/**
 * �����б�
 **/
elseif ($_A['query_type'] == "cancel"){
	check_rank("borrow_cancel");//���Ȩ��
	$_A['list_title'] = "����";

	$data['id'] = $_REQUEST['id'];
	$result =  borrowClass::GetOne($data);
	if ($result['status']==0 || $result['status']==1){
		borrowClass::Cancel($data);
		$msg = array("���سɹ�","",$_A['query_url'].$_A['site_url']);
	}else{

		$msg = array("�˱겻������Ͷ�꣬���ܳ���");
	}

}

/**
 * �����б�
 **/
elseif ($_A['query_type'] == "ontop"){
	check_rank("borrow_ontop");//���Ȩ��
	$_A['list_title'] = "����";

	$data['id'] = $_REQUEST['id'];
	$result =  borrowClass::GetOne($data);
	if ($result['status']==1 && $result['isontop']==1){
		$result = borrowClass::onTop($result);
		if($result===true){
			$msg = array("�ö��ɹ�","",$_A['query_url'].$_A['site_url']);
		}
		else{
			$msg = array($result);
		}
	}else{

		$msg = array("�˱겻���ö�(ֻ�д��ڳ���ͨ��״̬�ı�����ö�)��");
	}

}

/**
 * �����б�
 **/
elseif ($_A['query_type'] == "repayment"){
	check_rank("borrow_repayment");//���Ȩ��
	$_A['list_title'] = "������Ϣ";

	$data['page'] = $_A['page'];
	$data['epage'] = 25;
	$data['order'] = "repayment_time";
	$data['borrow_status'] = 3;
	if (isset($_REQUEST['status']) && $_REQUEST['status']!=""){
		$data['status'] = $_REQUEST['status'];
	}
	if (isset($_REQUEST['username']) && $_REQUEST['username']!=""){
		$data['username'] = $_REQUEST['username'];
	}
	if (isset($_REQUEST['keywords']) && $_REQUEST['keywords']!=""){
		$data['keywords'] = $_REQUEST['keywords'];
	}

	$result = borrowClass::GetRepaymentList($data);
	if (is_array($result)){
		$pages->set_data($result);
		$_A['borrow_list'] = $result['list'];
		$_A['showpage'] = $pages->show(3);
	}else{
		$msg = array($result);
	}
}


/**
 * �����б�
 **/
elseif ($_A['query_type'] == "liubiao"){
	check_rank("borrow_liubiao");//���Ȩ��
	$_A['list_title'] = "����";

	$data['page'] = $_A['page'];
	$data['epage'] = 25;
	if (isset($_REQUEST['status']) && $_REQUEST['status']!=""){
		$data['status'] = $_REQUEST['status'];
	}
	$data['type'] = "late";
	$data['status'] = "1";
	$result = borrowClass::GetList($data);
	if (is_array($result)){
		$pages->set_data($result);
		$_A['borrow_list'] = $result['list'];
		$_A['showpage'] = $pages->show(3);
	}else{
		$msg = array($result);
	}
}
/**
 * �����б�
 **/
elseif ($_A['query_type'] == "liubiao_edit"){
	check_rank("borrow_liubiao");//���Ȩ��
	$_A['list_title'] = "�������";
	if (isset($_POST['status']) && $_POST['status']!=""){
		$data['days'] = (int)$_POST['days'];
		$data['id'] = $_REQUEST['id'];
		$data['status'] = $_POST['status'];
		$result = borrowClass::ActionLiubiao($data);
		$msg = array("�����ɹ�");
	}else{
		$data['id'] = $_REQUEST['id'];
		$result = borrowClass::GetOne($data);
		$_A['borrow_result'] = $result;
	}
}
/**
 * ���괦��
 **/
elseif ($_A['query_type'] == "full_view"){
	global $mysql;
	check_rank("borrow_full_view");//���Ȩ��
	$_A['list_title'] = "���괦��";
	if (isset($_POST['id'])){
		//liukun add for bug 58 begin
		if($_SESSION['valicode']!=$_POST['valicode']){
			$msg = array("��֤�벻��ȷ");
		}
		//liukun add for bug 58 end
		else{
			$var = array("id","status","repayment_remark");
			$data = post_var($var);
			$data['repayment_user'] = $_G['user_id'];
			 
			$sql = "select * from {borrow}  where id=".$_POST['id']." limit 1";
			$resultBorrow = $mysql->db_fetch_array($sql);
			if($resultBorrow['status']==3 || $resultBorrow['status']==4){
				$msg = array("�˱��Ѿ���˹���������˴����У������ظ����");
			}else{

				$result = borrowClass::AddRepayment($data);

				if ($result ==false){
					$msg = array($result);
				}else{
					/*$sqlsf = "select user_id from  {borrow}  where id = ".$_POST['id'];
					 $u = $mysql->db_fetch_arrays($sqlsf);
					$au_row = borrowClass::get_back_list(array("id"=>$_POST['id']));
					$data_z['user_id'] = $u['user_id'];//�����
					foreach($au_row as $v){
					$data_z['id']=$v['id'];

					$result =  borrowClass::Repay($data_z);//�Զ�����
					}*/
					$msg = array("�����ɹ�","",$_A['query_url']."/full".$_A['site_url']);
				}

			}
		}
		$user->add_log($_log,$result);//��¼����
	}else{
		$data['id'] = $_REQUEST['id'];
		$_A['borrow_result'] = borrowClass::GetOne($data);
		if ($_A['borrow_result']['status']!=1 || $_A['borrow_result']['account']!=$_A['borrow_result']['account_yes']){
			$msg = array("��ǰ�����û��Ѿ����� �� ���Ĳ�������, ��ˢ�±�ҳ��");
		}
		$data['borrow_id'] = $data['id'];
		$data['page'] = $_A['page'];
		$data['epage'] = $_A['epage'];
		$result = borrowClass::GetTenderList($data);

		//liukun add for bug 55 begin
		$vouchlist_result = borrowClass::GetVouchList($data);

		//liukun add for bug 55 end

		$_A['borrow_repayment'] = borrowClass::GetRepayment(array("id"=>$data['id']));
		if (is_array($result)){
			$pages->set_data($result);
			$_A['borrow_tender_list'] = $result['list'];
			$_A['borrow_vouch_list'] = $vouchlist_result['list'];
			$_A['showpage'] = $pages->show(3);

		}else{
			$msg = array($result);
		}
	}
}

/**
 * ���괦��  �����б�
 **/
elseif ($_A['query_type'] == "late"){
	check_rank("borrow_late");//���Ȩ��
	$_A['list_title'] = "������";
	if (isset($_POST['id'])){
		if($_SESSION['valicode']!=$_POST['valicode']){
			$msg = array("��֤�벻��ȷ");
		}else{
			$var = array("id","status","repayment_remark");
			$data = post_var($var);
			$data['repayment_user'] = $_G['user_id'];
			$result = borrowClass::AddRepayment($data);
			if ($result ==false){
				$msg = array($result);
			}else{
				$msg = array("�����ɹ�","",$_A['query_url']."/full".$_A['site_url']);
			}
			$_SESSION['valicode'] = "";
		}
		$user->add_log($_log,$result);//��¼����
	}else{
		$data['page'] = $_A['page'];
		$data['epage'] = $_A['epage'];
		$data['status'] = "0,2";
		$data['username'] = $_REQUEST['username'];
		$data['isday'] = $_REQUEST['isday'];

		$data['repayment_time'] = time();
		$result = borrowClass::GetLateRepaymentList($data);


		if (is_array($result))
		{
			/*//���һ�ڻ��ִ�н���˱�����
			foreach($result['list'] as $i=>$v)
			{
				if($v['insurance']!=0)
				{
					//ȡ���һ�ڵ�id
					$lastrepayid=borrowClass::getLastRepaymentId($v['borrow_id']);
					if($v['id']==$lastrepayid)
					{
						$result['list'][$i]['lastRepaymentId']=1;	
					}
				}
			}*/
			$pages->set_data($result);
			$_A['borrow_repayment_list'] = $result['list'];
			$_A['showpage'] = $pages->show(3);
		}else{
			$msg = array($result);
		}
	}
}
elseif($_A['query_type'] =="insurance_do")
{
	
	$result = borrowClass::insurance_do($_GET['id']);
	if ($result ===true){
		$msg = array("�����ɹ�","",$_A['query_url']."/late".$_A['site_url']);
	}else{		
		$msg = array($result);
	}
}
/**
 * ��Ѻ�굽�����һ�촦��
 **/
elseif ($_A['query_type'] == "lateFast"){
	$_A['list_title'] = "��������";
	if (isset($_POST['id'])){
		if($_SESSION['valicode']!=$_POST['valicode']){
			$msg = array("��֤�벻��ȷ");
		}else{
			$var = array("id","status","repayment_remark");
			$data = post_var($var);
			$data['repayment_user'] = $_G['user_id'];
			$result = borrowClass::AddRepayment($data);
			if ($result ==false){
				$msg = array($result);
			}else{
				$msg = array("�����ɹ�","",$_A['query_url']."/full".$_A['site_url']);
			}
			$_SESSION['valicode'] = "";
		}
		$user->add_log($_log,$result);//��¼����
	}else{
		$data['page'] = $_A['page'];
		$data['epage'] = $_A['epage'];
		$data['status'] = "0,2";

		$data['username'] = $_REQUEST['username'];
		$data['isday'] = $_REQUEST['isday'];

		//����Ԥ��ʱ�������ѯ�Ŀ�ʼʱ��
		//����ʱ��С�ڵ�ǰʱ�����Ԥ��ʱ��Ķ�����Ҫ��ѯ����
		$con_laterepay_alert_days = isset($_G['system']['con_laterepay_alert_days'])?$_G['system']['con_laterepay_alert_days']:3;
		$latepay_time = strtotime(date("Y-m-d 23:59:59", time())) + 3600*24*$con_laterepay_alert_days;

		$data['repayment_time'] = $latepay_time;

		$result = borrowClass::GetLateFastRepaymentList($data);

		if (is_array($result)){
			$pages->set_data($result);
			$_A['borrow_repayment_list'] = $result['list'];
			$_A['showpage'] = $pages->show(3);
		}else{
			$msg = array($result);
		}
	}
}
/**
 * ���ڻ�����վ����
 **/
elseif ($_A['query_type'] == "late_repay"){
	check_rank("borrow_late");//���Ȩ��
	$id = $_REQUEST['id'];
	$sql = "select status from  {borrow_repayment}  where id = {$id} limit 1";
	$result = $mysql->db_fetch_array($sql);
	if($result==false){
		$msg = array("���Ĳ�������");
	}else{
		if ($result['status']==1){
			$msg = array("�Ѿ�����벻Ҫ�Ҳ���");
		}elseif ($result['status']==2){
			$msg = array("��վ�Ѿ��������벻Ҫ�Ҳ���");
		}else{
			$n = borrowClass::LateRepay(array("id"=>$id));
			if($n===true) 
				$msg = array("����ɹ�");
			else 
				$msg=$n;
		}
	}

}

/**
 * ���ڻ�����վ����
 **/
elseif ($_A['query_type'] == "autobuyback"){
	//check_rank("borrow_late");//���Ȩ��
	borrowClass::autobuyback();
	borrowClass::autobuybackInterest();
	$msg = array("��ת��ع���ɡ�");
}

elseif ($_A['query_type'] == "cancelvip"){
	//check_rank("borrow_late");//���Ȩ��
	borrowClass::CancelVIP();
	$msg = array("�������VIP��ɡ�");
}

elseif ($_A['query_type'] == "cancelaward"){
	//check_rank("borrow_late");//���Ȩ��
	borrowClass::CancelAward();
	$msg = array("�����ֻ��������������ɡ�");
}
elseif ($_A['query_type'] == "auto"){
	$data = array();
	//�Զ��ع�
	$result = borrowClass::autobuyback($data);
	//�Զ�������ת���Ϲ���Ϣ���ǵ��ڻع���
	$result = borrowClass::autobuybackInterest($data);
	//ȡ������VIP
	$result = borrowClass::CancelVIP($data);
	//�����ֳ�ֵ��������ڣ�ȡ����ֵ����
	$result = borrowClass::CancelAward($data);
	//��������Ͷ������ɽ���
	$result = borrowClass::GetInviteTicheng($data);
	//�������˿���������ɽ���
	$result = borrowClass::GetInviteVouchTicheng($data);
	//������������Ͷ�ʵ��������ɽ���
	$result = borrowClass::GetInviteBorrowTicheng($data);
	//�������˷�����ɽ���
	$result = borrowClass::createBlackList($data);
	
	$msg = array("��̨�Զ�������ɡ�");
}

/**
 * ͳ��
 **/
elseif ($_A['query_type'] == "tongji"){
	$_A['borrow_tongji'] = borrowClass::Tongji($data);
	$_A['account_tongji'] = accountClass::Tongji($data);
}
//��ֹ�Ҳ���
else{
	$msg = array("���������벻Ҫ�Ҳ���","",$url);
}
?>