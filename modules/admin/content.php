<?
/******************************
 * $File: site.php
 * $Description: վ��
 * $Author: ahui 
 * $Time:2010-03-09
 * $Update:None 
******************************/
if (!defined('ROOT_PATH'))  die('���ܷ���');//��ֱֹ�ӷ���




$_A['list_name'] = "վ�����";
$_A['list_menu'] = "<a href={$_A['admin_url']}&q=site/loop{$_A['site_url']}>վ�����</a> - <a href={$_A['admin_url']}&q=site/new{$_A['site_url']}>���վ��</a> - <a href={$_A['admin_url']}&q=site{$_A['site_url']}>����վ��</a>";





//����Ա��������
$_A['admin_type'] = userClass::GetTypeList(array("type"=>1,"where"=>" and type_id!=1"));
foreach($_A['admin_type'] as $key => $value){
	$_A['admin_type_check'][$value['type_id']] = $value['name'];
}



/**
 * ��ʾ����վ��
**/

if ($_A['query_class'] == "list" ){
	$_A['list_title'] = "վ���б�"; 
	$_A['list_menu'] = '';
}


$template = "admin_site.html.php";
?>