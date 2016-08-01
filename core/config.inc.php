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
error_reporting(E_ALL || ~E_NOTICE);
//error_reporting(0);
//define('ROOT_PATH', ereg_replace("[/\\]{1,}", '/', dirname(__FILE__) )."/../" );//��Ŀ¼
define('ROOT_PATH', dirname(__FILE__) . '/../');
header('Content-Type:text/html;charset=GB2312');
define('IN_TEMPLATE', "TRUE");
 
//�趨cacha������Ŀ¼
$cachepath['pay']=ROOT_PATH."data/pay_cache/"; //֧�����ļ���¼

$rdGlobal['uc_on']=true; //UC�ӿڿ�����false�ر�,true����

/* ��ʼ������ */
@ini_set('memory_limit',          '128M');
/*@ini_set('session.cache_expire',  180);
@ini_set('session.use_trans_sid', 0);
@ini_set('session.use_cookies',   1);
@ini_set('session.auto_start',    0);*/
@ini_set('display_errors',        1);

/* �жϲ�ͬϵͳ�ָ��� */
if (DIRECTORY_SEPARATOR == '\\'){
    @ini_set('include_path','.;' . ROOT_PATH);
}else{
    @ini_set('include_path','.:' . ROOT_PATH);
}

date_default_timezone_set('Asia/Shanghai');//ʱ������

//memcache ��ʹ��
$memcache_result  = "0";
$memcache = "";
$memcachelife = "60";
/*
$memcache = new Memcache;  
$memcache->addServer('localhost', 11211);
$memcache_result = $memcache->getserverstatus('localhost', 11211); 
if ($memcache_result!=0){
	$memcache->connect('localhost', 11211) ; 
}

*/
require_once(ROOT_PATH.'core/config_db.php');//������Ϣ����

require_once(ROOT_PATH.'core/function.inc.php');//��վ�ĺ���

require_once(ROOT_PATH.'core/safe.inc.php');//��ȫ����
require_once(ROOT_PATH.'core/input.inc.php');//�������Ϣ

require_once(ROOT_PATH.'core/mysql.class.php');//���ݿ⴦���ļ�

require_once(ROOT_PATH.'core/apply.class.php');//����������

require_once(ROOT_PATH.'core/system.class.php');//ϵͳ����
$mysql = new Mysql($db_config);
$mysql->db_show_msg(true);

require_once('module.class.php');//ģ��Ĵ���
$module = new moduleClass();

require_once('page.class.php');//��ҳ��ʾ
$page = new Page();

require_once('pages.class.php');//��ҳ��ʾ2
$pages = new pages();
$_G['class_pages'] = $pages;

require_once('magic.class.php');//ģ������
$magic = new Magic();

require_once('user.class.php');//�û�
$user = new userClass();

require_once('upload.class.php');//�ϴ��ļ�ˮӡ��������
$upload = new upload();



$_log['url'] = $_SERVER['QUERY_STRING'];
$_log['query'] = !isset($_REQUEST['q'])?'':$_REQUEST['q'];

if(extension_loaded('zlib'))
{
	ini_set('zlib.output_compression', 'On');
	ini_set('zlib.output_compression_level', '9');
}
function_exists('register_shutdown_function') && register_shutdown_function('ini_end');
function ini_end()
{
	global $mysql;
	$mysql->db_close();
}