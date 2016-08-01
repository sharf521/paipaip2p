<?php
/******************************
 * $File: config.inc.php
 * $Description: 网站配置文件
 * $Author: ahui 
 * $Time:2010-03-09
 * $Update:None 
 * $UpdateDate:None 
******************************/
session_cache_limiter('private,must-revalidate');
session_start();//打开缓存
error_reporting(E_ALL || ~E_NOTICE);
//error_reporting(0);
//define('ROOT_PATH', ereg_replace("[/\\]{1,}", '/', dirname(__FILE__) )."/../" );//根目录
define('ROOT_PATH', dirname(__FILE__) . '/../');
header('Content-Type:text/html;charset=GB2312');
define('IN_TEMPLATE', "TRUE");
 
//设定cacha缓存存放目录
$cachepath['pay']=ROOT_PATH."data/pay_cache/"; //支付的文件记录

$rdGlobal['uc_on']=true; //UC接口开启，false关闭,true开启

/* 初始化设置 */
@ini_set('memory_limit',          '128M');
/*@ini_set('session.cache_expire',  180);
@ini_set('session.use_trans_sid', 0);
@ini_set('session.use_cookies',   1);
@ini_set('session.auto_start',    0);*/
@ini_set('display_errors',        1);

/* 判断不同系统分隔符 */
if (DIRECTORY_SEPARATOR == '\\'){
    @ini_set('include_path','.;' . ROOT_PATH);
}else{
    @ini_set('include_path','.:' . ROOT_PATH);
}

date_default_timezone_set('Asia/Shanghai');//时区配置

//memcache 的使用
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
require_once(ROOT_PATH.'core/config_db.php');//基本信息设置

require_once(ROOT_PATH.'core/function.inc.php');//整站的函数

require_once(ROOT_PATH.'core/safe.inc.php');//安全设置
require_once(ROOT_PATH.'core/input.inc.php');//表单相关信息

require_once(ROOT_PATH.'core/mysql.class.php');//数据库处理文件

require_once(ROOT_PATH.'core/apply.class.php');//报名处理类

require_once(ROOT_PATH.'core/system.class.php');//系统设置
$mysql = new Mysql($db_config);
$mysql->db_show_msg(true);

require_once('module.class.php');//模块的处理
$module = new moduleClass();

require_once('page.class.php');//分页显示
$page = new Page();

require_once('pages.class.php');//分页显示2
$pages = new pages();
$_G['class_pages'] = $pages;

require_once('magic.class.php');//模板引擎
$magic = new Magic();

require_once('user.class.php');//用户
$user = new userClass();

require_once('upload.class.php');//上传文件水印裁切设置
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