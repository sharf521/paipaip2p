<?
if (!defined('ROOT_PATH'))  die('���ܷ���');//��ֱֹ�ӷ���
check_rank("fee_".$_t);//���Ȩ��

require_once 'fee.class.php';


$_A['list_purview'] = array("fee"=>array("���ù���"=>array("fee"=>"���ù���")));//Ȩ��
$_A['list_name'] = $_A['module_result']['name'];
$_A['list_menu'] = "";

	print_r($_REQUEST);
?>