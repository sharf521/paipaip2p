<?php
/******************************
 * $File: config.inc.php
 * $Description: ��վ�����ļ�
 * $Author: ahui 
 * $Time:2010-03-09
 * $Update:None 
 * $UpdateDate:None 
******************************/
session_cache_limiter('private,must-revalidate');
session_start();//�򿪻���
//error_reporting(E_ALL || ~E_NOTICE);
//error_reporting(E_ALL );//�������д���

//define('ROOT_PATH', ereg_replace("[/\\]{1,}", '/', dirname(__FILE__) )."/../" );//��Ŀ¼
define('ROOT_PATH', dirname(__FILE__) . '/../');
header('Content-Type:text/html;charset=GB2312');
 
print_r($_SESSION['purview']);

?>
