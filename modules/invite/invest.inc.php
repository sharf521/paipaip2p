<?php
if (!defined('ROOT_PATH'))  die('���ܷ���');//��ֱֹ�ӷ���
include_once("invest.class.php");

if ($_U['query_type'] == "add"){	
	if (!isset($_POST['name'])){
		$msg = array("�벻Ҫ�Ҳ���","","/publish/index.html");
	}elseif ($_POST['valicode']!=$_SESSION['valicode']){
		$msg = array("��֤�벻��ȷ");
	}else{	
		$var = array("name","status","use","time_limit","style","account","apr","lowest_account","most_account","valid_time","award","part_account","funds","is_false","open_account","open_invest","open_tender","open_credit","content");
		$data = post_var($var);
		$data['user_id'] = $_G['user_id'];
		$result = investClass::Add($data);
		if ($result===true){
			$msg = array("��ӳɹ�");
		}else{
			$msg = array($result);
		}
		
	}
}

$template = "user_invest.html.php";
?>
