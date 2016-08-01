<?php
if (!defined('ROOT_PATH'))  die('���ܷ���');//��ֱֹ�ӷ���
include_once("borrow.class.php");

if ($_U['query_type'] == "add" || $_U['query_type'] == "update"){	
	if (!isset($_POST['name'])){
		$msg = array("�벻Ҫ�Ҳ���","","/publish/index.html");
	}elseif ($_POST['valicode']!=$_SESSION['valicode']){
		$msg = array("��֤�벻��ȷ");
	}else{	
		
		$var = array("name","use","time_limit","style","account","apr","lowest_account","most_account","valid_time","award","part_account","funds","is_false","open_account","open_borrow","open_tender","open_credit","content");
		$data = post_var($var);
		$data['open_account'] = 1;
		$data['open_borrow'] = 1;
		$data['open_credit'] = 1;
		
		if ($_POST['submit']=="����ݸ�"){
			$data['status'] = -1;
		}else{
			$data['status'] =0;
		}
		$data['user_id'] = $_G['user_id'];
		if ($_U['query_type'] == "add"){
			$result = borrowClass::Add($data);
		}else{
			$data['id'] = $_POST['id'];
			$data['user_id'] = $_G['user_id'];
			$result = borrowClass::Update($data);
		}
		if ($result===true){
			$msg = array("�������ɹ�","","/index.php?user&q=code/borrow/publish");
		}else{
			$msg = array($result);
		}
		
	}
	
}elseif ($_U['query_type'] == "cancel"){
	$data['id'] = $_REQUEST['id'];
	$data['user_id'] = $_G['user_id'];
	$result = borrowClass::Cancel($data);
	if ($result==false){
		$msg = array($result);
	}else{
		$msg = array("�����ɹ�");
	}
}

//ɾ��
elseif ($_U['query_type'] == "del"){
	$data['id'] = $_REQUEST['id'];
	$data['user_id'] = $_G['user_id'];
	$data['status'] = -1;
	$result = borrowClass::Delete($data);
	if ($result==false){
		$msg = array($result);
	}else{
		$msg = array("�б�ɾ���ɹ�!");
	}
}

//�û�Ͷ��
elseif ($_U['query_type'] == "tender"){
	if ($_SESSION['valicode']!=$_POST['valicode']){
		$msg = array("��֤�����");
	}else{
		include_once(ROOT_PATH."modules/account/account.class.php");
		$borrow_result = borrowClass::GetOne(array("id"=>$_POST['id']));//��ȡ����ĵ�����Ϣ
		if (!is_array($borrow_result)){
			$msg = array($borrow_result);
		}elseif ($borrow_result['account_yes']>=$borrow_result['account']){
			$msg = array("�˱�������������Ͷ");
		}elseif ($borrow_result['verify_time'] == "" || $borrow_result['status'] != 1){
			$msg = array("�˱���δͨ�����");
		}elseif ($borrow_result['verify_time'] + $borrow_result['valid_time']>time()){
			$msg = array("�˱��ѹ���");
		}else{
			$account_money = $_POST['money'];
			if (($borrow_result['account']-$borrow_result['account_yes'])<$account_money){
				$account_money = $borrow_result['account']-$borrow_result['account_yes'];
			}else{
				
			}
			$data['borrow_id'] = $_POST['id'];
			$data['money'] = $_POST['money'];
			
			$data['account'] = $account_money;
			$data['user_id'] = $_G['user_id'];
			$data['status'] = 1;
			
			$result = borrowClass::AddTender($data);//��ӽ���
			
			$account_result =  accountClass::GetOne(array("user_id"=>$_G['user_id']));//��ȡ��ǰ�û������
			
			$log['user_id'] = $_G['user_id'];
			$log['type'] = "tender";
			$log['money'] = $account_money;
			$log['total'] = $account_result['total'];
			$log['use_money'] =  $account_result['use_money']-$log['money'];
			$log['no_use_money'] =  $account_result['no_use_money']+$log['money'];
			$log['to_user'] = $borrow_result['user_id'];
			$log['remark'] = "Ͷ�궳���ʽ�";
			accountClass::AddLog($log);//��Ӽ�¼
			
			if ($result==false){
				$msg = array($result);
			}else{
				$msg = array("Ͷ��ɹ�","","/index.php?user&q=code/borrow/bid");
			}
		}
	}
}

//�鿴Ͷ��
elseif ($_U['query_type'] == "repayment_view"){
	$data['id'] = $_REQUEST['id'];
	if ($data['id']==""){
		$msg = array("������������");
	}
	$data['user_id'] = $_G['user_id'];
	$result =  borrowClass::GetOne($data);//��ȡ��ǰ�û������
	if ($result==false){
		$msg = array("���Ĳ�������");
	}else{
		$_U['borrow_result'] = $result;
	}
}

//����
elseif ($_U['query_type'] == "repay"){
	$data['id'] = $_REQUEST['id'];
	if ($data['id']==""){
		$msg = array("������������");
	}
	$data['user_id'] = $_G['user_id'];
	$result =  borrowClass::Repay($data);//��ȡ��ǰ�û������
	if ($result!==true){
		$msg = array($result);
	}else{
		$msg = array("����ɹ�","","/index.php?user&q=code/borrow/repayment");
	}
}
$template = "user_borrow.html.php";
?>
