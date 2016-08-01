<?php

/**
 * �ջ���ַ
 *
 * $Author: ahui $
 * $Id: address.php $
 * $Time:2010-02-20 9:50 $
 * $Update:None $
*/

if (!defined('IN_ECS'))  die('Hacking attempt');

require(ROOT_PATH . '/servers/address.class.php');
$address = new address();


/* �ջ���ַ�б�ͱ༭ */
if ($t == ''  || $t == 'edit'){
	$result = $address->get($p,$epage,$user_id);
	$smarty->assign("result",$result['res']);
	
	$pager->set_data(array('total'=>$result['sum'],'perpage'=>$epage));
	$smarty->assign("pager",$pager->show(3));
	
	if ($_REQUEST['address_id'] != ""){
		$_result = $address->view($_REQUEST['address_id'],$user_id);
		$smarty->assign("_result",$_result);
		if ($_result == false){
			$msg = "�벻Ҫ�Ҳ���";
			show_msg($msg,"������һҳ","?s=address");
		}
	}
}

/* ��ȡ�ջ���ַ */
elseif ($t == 'get_address'){
	$result = $address->view($_REQUEST['address_id'],$user_id);
	if ($result<0 || $result == false){
		echo false;
	}else{
		$res = "";
		foreach ($result as $key => $result){
			$res .= $result."|@*"; 
		}
		echo $res;
	}
	exit;
}

/* �ջ���ַ��Ӻ��޸� */
elseif ($t == 'add' || $t == 'update'){
	$index['realname'] = $_POST['realname'];
	$index['email'] = $_POST['email'];
	$index['postcode'] = $_POST['postcode'];
	$index['qq'] = $_POST['qq'];
	$index['wangwang'] = $_POST['wangwang'];
	$index['tel'] = $_POST['tel'];
	$index['phone'] = $_POST['phone'];
	$index['province'] = $_POST['province'];
	$index['city'] = $_POST['city'];
	$index['area'] = $_POST['area'];
	$index['address'] = $_POST['address'];
	$index['building'] = $_POST['building'];
	$index['besttime'] = $_POST['besttime'];
	
	if ($t == 'update'){
		$address_id = $_POST['address_id'];
		$result = $address->update($index,$address_id,$user_id);
	}else{
		$result = $address->add($index,$user_id);
	}
	if ($result < 0 || $result == false){
		$msg = "���������������Ա��ϵ";
		show_msg($msg,"������һҳ",-1);
	}else{
		$msg = "�ջ���ַ�����ɹ�";
		show_msg($msg,"������һҳ",-1);
	}
}

//ajax�鿴
elseif ($t == 'view'){
	$epage = 3;
	$result = $address->get($p,$epage,$user_id);
	$smarty->assign("result",$result['res']);
	
	$pager->set_data(array('total'=>$result['sum'],'perpage'=>$epage));
	$pager->open_ajax("getAjaxTable");
	$smarty->assign("pager",$pager->show(3));
}

/* �ջ���ַɾ�� */
elseif ($t == 'del'){
	$address->del($_REQUEST['address_id'],$user_id);
	$msg = "ɾ���ɹ�";
	show_msg($msg,"������һҳ","?s=address");
}

//����
else{
	show_msg("�벻Ҫ�Ҳ���","������һҳ","?s=address");
}

$tpl = "user_address.html";
?>