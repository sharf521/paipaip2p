<?php
if (!defined('ROOT_PATH'))  die('���ܷ���');//��ֱֹ�ӷ���
include_once("arealinks.class.php");


//ǰ̨��
if ($_G['query_type'] == "list"){	
	$result =arealinksClass::GetList($data);
	$_G['magic_result'] = $result;
}


?>
