<?php
if (!defined('ROOT_PATH'))  die('���ܷ���');//��ֱֹ�ӷ���
include_once("borrowline.class.php");

if ($_U['query_type'] == "add" ){	
	if (!isset($_POST['name'])){
		$msg = array("���������д");
	}elseif ($_POST['valicode']!=$_SESSION['valicode']){
		$msg = array("��֤�벻��ȷ");
	}else{	
		
		$var = array("name","borrow_use","type","email","borrow_qixian","province","city","area","account","content","pawn","sex","tel","xing");
		$data = post_var($var);
		$data['status'] = 0;
		$data['user_id'] = $_G['user_id'];
		if (isset($_REQUEST['id']) && $_REQUEST['id']!=""){
			$data['id'] = $_REQUEST['id'];
			$result = borrowlineClass::Update($data);
		}else{
			$result = borrowlineClass::Add($data);
		}
		if ($result===true){
			$msg = array("������������ɹ�","","/index.php?user&q=code/company/xuqiu");
		}else{
			$msg = array($result);
		}
	}
}elseif ($_U['query_type']=="del"){
	$data['id'] = $_REQUEST['id'];
	$data['user_id'] = $_G['user_id'];
	$result = borrowlineClass::Delete($data);
	if ($result!=false){
		$msg = array("ɾ������ɹ�","","index.php?user&q=code/company/xuqiu");
	}else{
		$msg = array($result);
	}
}
?>
