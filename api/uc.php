<?php

/**
 * [Discuz!] (C)2001-2099 Comsenz Inc.
 *            This is NOT a freeware, use is subject to license terms
 * 
 *            $Id: uc.php 25684 2011-11-17 08:45:40Z monkey $
 */
// error_reporting(0);
define('UC_CLIENT_VERSION', '1.6.0');
define('UC_CLIENT_RELEASE', '20110501');

define('API_DELETEUSER', 1);
define('API_RENAMEUSER', 1);
define('API_GETTAG', 1);
define('API_SYNLOGIN', 1);
define('API_SYNLOGOUT', 1);
define('API_UPDATEPW', 1);
define('API_UPDATEBADWORDS', 1);
define('API_UPDATEHOSTS', 1);
define('API_UPDATEAPPS', 1);
define('API_UPDATECLIENT', 1);
define('API_UPDATECREDIT', 1);
define('API_GETCREDIT', 1);
define('API_GETCREDITSETTINGS', 1);
define('API_UPDATECREDITSETTINGS', 1);
define('API_ADDFEED', 1);
define('API_RETURN_SUCCEED', '1');
define('API_RETURN_FAILED', '-1');
define('API_RETURN_FORBIDDEN', '1');

@define('IN_DISCUZ', true);
@define('IN_API', true);
@define('CURSCRIPT', 'api');

define('DISCUZ_ROOT', dirname(dirname(__FILE__)) . '/');
require_once DISCUZ_ROOT . './config_ucenter.php';
require_once DISCUZ_ROOT . './core/config.inc.php';
require_once DISCUZ_ROOT . './core/user.class.php';

if (!defined('IN_UC')) {
	$get = $post = array();

	$code = @$_GET['code'];
	parse_str(uc_api_authcode($code, 'DECODE', UC_KEY), $get);

	if (time() - $get['time'] > 3600) {
		 exit('Authracation has expiried');
	} 
	if (empty($get)) {
		 exit('Invalid Request');
	} 

	include_once DISCUZ_ROOT . './uc_client/lib/xml.class.php';
	$post = xml_unserialize(file_get_contents('php://input'));

	if (in_array($get['action'], array('test', 'deleteuser', 'renameuser', 'gettag', 'synlogin', 'synlogout', 'updatepw', 'updatebadwords', 'updatehosts', 'updateapps', 'updateclient', 'updatecredit', 'getcredit', 'getcreditsettings', 'updatecreditsettings', 'addfeed'))) {
		$uc_note = new uc_note();
		echo $uc_note -> $get['action']($get, $post);
		exit();
	} else {
		exit(API_RETURN_FAILED);
	} 
} else {
	exit;
} 

class uc_note {
	var $dbconfig = '';
	var $db = '';
	var $tablepre = '';
	var $appdir = '';

	function _serialize($arr, $htmlon = 0) {
		if (!function_exists('xml_serialize')) {
			include_once DISCUZ_ROOT . './uc_client/lib/xml.class.php';
		} 
		return xml_serialize($arr, $htmlon);
	} 

	function uc_note() {
	} 

	function test($get, $post) {
		return API_RETURN_SUCCEED;
	} 

	function deleteuser($get, $post) {
		global $_G;
		if (!API_DELETEUSER) {
			return API_RETURN_FORBIDDEN;
		} 
		$uids = str_replace("'", '', stripslashes($get['ids'])); 
		// $r =  explode(",", $uids);
		// for ($i=0;$i<count($r);$i++){
		// echo $name[i];
		// }
		return API_RETURN_SUCCEED;
	} 

	function renameuser($get, $post) {
		global $db;

		if (!API_RENAMEUSER) {
			return API_RETURN_FORBIDDEN;
		} 
		return API_RETURN_FORBIDDEN;
		$uid = intval($get['uid']);
		$newusername = $get['newusername'];
		$oldusername = $get['oldusername'];
		require DISCUZ_ROOT . './uc_client/client.php';
		list($uid, $username, $email) = uc_get_user($uid, 1);

		$oldinfo = $db -> get_one("SELECT uid,username,email FROM pv_members WHERE username='$oldusername'"); 
		// 鏇存柊鐢ㄦ埛鍚�
		if ($oldinfo && $oldinfo['username'] != stripcslashes($newusername)) {
			// 妫�祴鐢ㄦ埛鍚�
			$u = checkname($newusername);
			if ($u != 1) {
				return API_RETURN_FAILED;
			} 
			// 鏇存柊鐢ㄦ埛
			$db -> update("UPDATE pv_members SET username='$newusername' WHERE uid='$oldinfo[uid]'"); 
			// 鏇存柊涓庢鐢ㄦ埛鐩稿叧鐨勮祫鏂�
			$db -> update("UPDATE pv_video SET author='$newusername' WHERE authorid='$oldinfo[uid]'");
			$db -> update("UPDATE pv_reply SET author='$newusername' WHERE authorid='$oldinfo[uid]'");
			$db -> update("UPDATE pv_announce SET author='$newusername' WHERE author='" . addslashes($oldinfo['username']) . "'");
			return API_RETURN_SUCCEED;
		} 
		return API_RETURN_SUCCEED;
	} 

	function gettag($get, $post) {
		if (!API_GETTAG) {
			return API_RETURN_FORBIDDEN;
		} 
		return $this -> _serialize(array($get['id'], array()), 1);
	} 

	function synlogin($get, $post) {
		global $mysql;

		if (!API_SYNLOGIN) {
			return API_RETURN_FORBIDDEN;
		} 

		header('P3P: CP="CURa ADMa DEVa PSAo PSDo OUR BUS UNI PUR INT DEM STA PRE COM NAV OTC NOI DSP COR"');

		$cookietime = 31536000;
		$uid = intval($get['uid']);
		$username = $get['username'];
		$password = $get['password'];

		$sql = "select p1.*,p2.purview as pur,p2.type,p2.name as typename from {user} as p1 left join {user_type} as p2 on p1.type_id = p2.type_id where (p1.email = '{$username}' or p1.username = '{$username}')";
		$result = $mysql -> db_fetch_array($sql);
		/*
		if ($result == false) {
			require DISCUZ_ROOT . './uc_client/client.php';
			list($uid, $username, $email) = uc_get_user($uid, 1);

			$data = array();
			$data["email"] = $email;
			$data["username"] = $username;
			$data["realname"] = $username;
			$data["password"] = $password;
			$data["type_id"] = 2;

			$sql = "insert into {user} set `addtime` = '" . time() . "',`addip` = '127.0.0.1',`uptime` = '" . time() . "',`upip` = '127.0.0.1',`lasttime` = '127.0.0.1',`lastip` = '127.0.0.1'";

			foreach($data as $key => $value) {
				$sql .= ",`$key` = '$value'";
			} 

			$result = $mysql -> db_query($sql);
			if ($result != false) {
				$user_id = $mysql -> db_insert_id(); 
				// 鍔犲叆缂撳瓨
				userClass :: AddUserCache(array("user_id" => $user_id));

				$sql = "select p1.*,p2.purview as pur,p2.type,p2.name as typename from {user} as p1 left join {user_type} as p2 on p1.type_id = p2.type_id where (p1.email = '{$username}' or p1.username = '{$username}')";
				$result = $mysql -> db_fetch_array($sql);
			} 
		}  
		*/
		if ($result != false) {
			if (!isset($_SESSION)) {
				session_start();
				session_regenerate_id(true);
			} 
			$data = array();
			$data['username'] = $result['username'];
			$data['user_id'] = $result['user_id'];
			$data['user_typeid'] = $result['type_id'];
			$data['reg_step'] = "";
			set_session_2($data); //娉ㄥ唽session
			$ctime = (int)time() + (720 * 60);
			setcookie(Key2Url_2("user_id", "DWCMS"), authcode_($data['user_id'] . "," . time(), "ENCODE"), $ctime, '/');
		} 
		return API_RETURN_SUCCEED;
	} 

	function synlogout($get, $post) {
		if (!API_SYNLOGOUT) {
			return API_RETURN_FORBIDDEN;
		} 
	if (!isset($_SESSION)) {
				session_start();
				session_regenerate_id(true);
			} 
		header('P3P: CP="CURa ADMa DEVa PSAo PSDo OUR BUS UNI PUR INT DEM STA PRE COM NAV OTC NOI DSP COR"');

		$ctime = (int)time() - (72 * 60);
		setcookie(Key2Url_2("user_id", "DWCMS"), '', $ctime, '/');
		setcookie('PHPSESSID', '', $ctime, '/');
		if (isset($_SESSION['username'])) unset($_SESSION['username']);
		if (isset($_SESSION['user_realname'])) unset($_SESSION['user_realname']);
		if (isset($_SESSION['user_typename'])) unset($_SESSION['user_typename']);
		if (isset($_SESSION['user_id'])) unset($_SESSION['user_id']);
		if (isset($_SESSION['userid'])) unset($_SESSION['userid']);
		if (isset($_SESSION['usertype'])) unset($_SESSION['usertype']);
		if (isset($_SESSION['usertime'])) unset($_SESSION['usertime']);
		if (isset($_SESSION['reg_step'])) unset($_SESSION['reg_step']);
		return API_RETURN_SUCCEED;
	} 

	function updatepw($get, $post) {
		global $db;

		if (!API_UPDATEPW) {
			return API_RETURN_FORBIDDEN;
		} 

		$username = $get['username'];
		$newpw = md5(time() . rand(100000, 999999)); 
		// $db -> update("UPDATE pv_members SET password='" . $newpw . "' WHERE uid='{$username}'");
		return API_RETURN_SUCCEED;
	} 

	function updatebadwords($get, $post) {
		if (!API_UPDATEBADWORDS) {
			return API_RETURN_FORBIDDEN;
		} 

		$data = array();
		if (is_array($post)) {
			foreach($post as $k => $v) {
				$data['findpattern'][$k] = $v['findpattern'];
				$data['replace'][$k] = $v['replacement'];
			} 
		} 
		$cachefile = DISCUZ_ROOT . './uc_client/data/cache/badwords.php';
		$fp = fopen($cachefile, 'w');
		$s = "<?php\r\n";
		$s .= '$_CACHE[\'badwords\'] = ' . var_export($data, true) . ";\r\n";
		fwrite($fp, $s);
		fclose($fp);

		return API_RETURN_SUCCEED;
	} 

	function updatehosts($get, $post) {
		if (!API_UPDATEHOSTS) {
			return API_RETURN_FORBIDDEN;
		} 

		$cachefile = DISCUZ_ROOT . './uc_client/data/cache/hosts.php';
		$fp = fopen($cachefile, 'w');
		$s = "<?php\r\n";
		$s .= '$_CACHE[\'hosts\'] = ' . var_export($post, true) . ";\r\n";
		fwrite($fp, $s);
		fclose($fp);

		return API_RETURN_SUCCEED;
	} 

	function updateapps($get, $post) {
		if (!API_UPDATEAPPS) {
			return API_RETURN_FORBIDDEN;
		} 

		$UC_API = '';
		if ($post['UC_API']) {
			$UC_API = $post['UC_API'];
			unset($post['UC_API']);
		} 

		$cachefile = DISCUZ_ROOT . './uc_client/data/cache/apps.php';
		$fp = fopen($cachefile, 'w');
		$s = "<?php\r\n";
		$s .= '$_CACHE[\'apps\'] = ' . var_export($post, true) . ";\r\n";
		fwrite($fp, $s);
		fclose($fp);

		if ($UC_API && is_writeable(DISCUZ_ROOT . './config_ucenter.php')) {
			if (preg_match('/^https?:\/\//is', $UC_API)) {
				$configfile = trim(file_get_contents(DISCUZ_ROOT . './config_ucenter.php'));
				$configfile = substr($configfile, -2) == '?>' ? substr($configfile, 0, -2) : $configfile;
				$configfile = preg_replace("/define\('UC_API',\s*'.*?'\);/i", "define('UC_API', '" . addslashes($UC_API) . "');", $configfile);
				if ($fp = @fopen(DISCUZ_ROOT . './config_ucenter.php', 'w')) {
					@fwrite($fp, trim($configfile));
					@fclose($fp);
				} 
			} 
		} 
		return API_RETURN_SUCCEED;
	} 

	function updateclient($get, $post) {
		if (!API_UPDATECLIENT) {
			return API_RETURN_FORBIDDEN;
		} 

		$cachefile = DISCUZ_ROOT . './uc_client/data/cache/settings.php';
		$fp = fopen($cachefile, 'w');
		$s = "<?php\r\n";
		$s .= '$_CACHE[\'settings\'] = ' . var_export($post, true) . ";\r\n";
		fwrite($fp, $s);
		fclose($fp);

		return API_RETURN_SUCCEED;
	} 

	function updatecredit($get, $post) {
		global $db;

		if (!API_UPDATECREDIT) {
			return API_RETURN_FORBIDDEN;
		} 
		return API_RETURN_FORBIDDEN;

		$credit = $get['credit'];
		$amount = $get['amount'];
		$uid = $get['uid'];

		require DISCUZ_ROOT . './uc_client/client.php';
		list($uid, $username, $email) = uc_get_user($uid, 1);

		$query = $db -> get_one("SELECT m.uid,m.password,m.groupid,m.yz,md.onlineip FROM pv_members AS m LEFT JOIN pv_memberdata AS md ON md.uid=m.uid WHERE username='" . $username . "'");
		if ($query) {
			if ($credit == -1) {
				$db -> update("UPDATE pv_memberdata SET money=money+{$amount} WHERE uid='{$query[uid]}'");
			} elseif ($credit == -2) {
				$db -> update("UPDATE pv_memberdata SET rvrc=rvrc+{$amount} WHERE uid='{$query[uid]}'");
			} else {
				$db -> update("UPDATE pv_membercredit SET value=value+{$amount} WHERE uid='{$query[uid]}' and cid='$credit'");
				update_memberid($query['uid']);
			} 
		} 

		return API_RETURN_SUCCEED;
	} 

	function getcredit($get, $post) {
		global $db;

		if (!API_GETCREDIT) {
			return API_RETURN_FORBIDDEN;
		} 
		return API_RETURN_FORBIDDEN;
		$uid = intval($get['uid']);
		$credit = intval($get['credit']);

		$userdb = $db -> get_one("SELECT m.*,md.* FROM pv_members m LEFT JOIN pv_memberdata md ON m.uid=md.uid WHERE m.uid='$uid'");
		if (!$userdb) showmsg('user_not_exists', '', '', array($uid));

		$usercredit = array("-2" => "$userdb[rvrc]", "-1" => "$userdb[money]");
		$creditdb = get_custom_credit($uid);
		foreach($creditdb as $key => $value) {
			$usercredit[$key] = $value[1];
		} 

		return $usercredit[$credit];
	} 

	function getcreditsettings($get, $post) {
		global $db;

		if (!API_GETCREDITSETTINGS) {
			return API_RETURN_FORBIDDEN;
		} 
		return API_RETURN_FORBIDDEN;
		$credits = array();
		$credits[-1] = array('閲戦挶', '');
		$credits[-2] = array('濞佹湜', '');
		$credit = $db -> query("SELECT * FROM pv_credits ORDER BY cid");
		while ($creditdb = $db -> fetch_array($credit)) {
			$credits[$creditdb['cid']] = array(strip_tags($creditdb['name']), '');
		} 

		return $this -> _serialize($credits);
	} 

	function updatecreditsettings($get, $post) {
		if (!API_UPDATECREDITSETTINGS) {
			return API_RETURN_FORBIDDEN;
		} 

		$outextcredits = array();
		foreach($get['credit'] as $appid => $credititems) {
			if ($appid == UC_APPID) {
				foreach($credititems as $value) {
					$outextcredits[$value['appiddesc'] . '|' . $value['creditdesc']] = array('appiddesc' => $value['appiddesc'],
						'creditdesc' => $value['creditdesc'],
						'creditsrc' => $value['creditsrc'],
						'title' => $value['title'],
						'unit' => $value['unit'],
						'ratiosrc' => $value['ratiosrc'],
						'ratiodesc' => $value['ratiodesc'],
						'ratio' => $value['ratio']
						);
				} 
			} 
		} 
		$tmp = array();
		foreach($outextcredits as $value) {
			$key = $value['appiddesc'] . '|' . $value['creditdesc'];
			if (!isset($tmp[$key])) {
				$tmp[$key] = array('title' => $value['title'], 'unit' => $value['unit']);
			} 
			$tmp[$key]['ratiosrc'][$value['creditsrc']] = $value['ratiosrc'];
			$tmp[$key]['ratiodesc'][$value['creditsrc']] = $value['ratiodesc'];
			$tmp[$key]['creditsrc'][$value['creditsrc']] = $value['ratio'];
		} 
		$outextcredits = $tmp;

		$cachefile = DISCUZ_ROOT . './uc_client/data/cache/creditsettings.php';
		$fp = fopen($cachefile, 'w');
		$s = "<?php\r\n";
		$s .= '$_CACHE[\'creditsettings\'] = ' . var_export($outextcredits, true) . ";\r\n";
		fwrite($fp, $s);
		fclose($fp);

		return API_RETURN_SUCCEED;
	} 

	function addfeed($get, $post) {
		global $_G;

		if (!API_ADDFEED) {
			return API_RETURN_FORBIDDEN;
		} 
		return API_RETURN_SUCCEED;
	} 
} 

function Key2Url_2($key, $type) {
	return base64_encode ($type . $key) ;
} 

function set_session_2($data = array()) {
	$_SESSION['username'] = isset($data['username'])?$data['username']:"";
	$_SESSION['uc_user_id'] = isset($data['uc_user_id'])?$data['uc_user_id']:"";
	$_SESSION['user_typeid'] = isset($data['user_typeid'])?$data['user_typeid']:"";
	$_SESSION['usertime'] = time();
	$_SESSION['usertype'] = 0;
} 

function authcode_($string, $operation = 'DECODE', $key = '', $expiry = 0) {
	// 鍔ㄦ�瀵嗗寵闀垮害锛岀浉鍚岀殑鏄庢枃浼氱敓鎴愪笉鍚屽瘑鏂囧氨鏄緷闈犲姩鎬佸瘑鍖�
	$ckey_length = 4; 
	// 瀵嗗寵
	$key = md5($key ? $key : "dw10c20m05w18"); 
	// 瀵嗗寵a浼氬弬涓庡姞瑙ｅ瘑
	$keya = md5(substr($key, 0, 16)); 
	// 瀵嗗寵b浼氱敤鏉ュ仛鏁版嵁瀹屾暣鎬ч獙璇�
	$keyb = md5(substr($key, 16, 16)); 
	// 瀵嗗寵c鐢ㄤ簬鍙樺寲鐢熸垚鐨勫瘑鏂�
	$keyc = $ckey_length ? ($operation == 'DECODE' ? substr($string, 0, $ckey_length): substr(md5(microtime()), - $ckey_length)) : ''; 
	// 鍙備笌杩愮畻鐨勫瘑鍖�
	$cryptkey = $keya . md5($keya . $keyc);
	$key_length = strlen($cryptkey); 
	// 鏄庢枃锛屽墠10浣嶇敤鏉ヤ繚瀛樻椂闂存埑锛岃В瀵嗘椂楠岃瘉鏁版嵁鏈夋晥鎬э紝10鍒�6浣嶇敤鏉ヤ繚瀛�keyb(瀵嗗寵b)锛岃В瀵嗘椂浼氶�杩囪繖涓瘑鍖欓獙璇佹暟鎹畬鏁存�
	// 濡傛灉鏄В鐮佺殑璇濓紝浼氫粠绗�ckey_length浣嶅紑濮嬶紝鍥犱负瀵嗘枃鍓�ckey_length浣嶄繚瀛�鍔ㄦ�瀵嗗寵锛屼互淇濊瘉瑙ｅ瘑姝ｇ‘
	$string = $operation == 'DECODE' ? base64_decode(substr($string, $ckey_length)) : sprintf('%010d', $expiry ? $expiry + time() : 0) . substr(md5($string . $keyb), 0, 16) . $string;
	$string_length = strlen($string);
	$result = '';
	$box = range(0, 255);
	$rndkey = array(); 
	// 浜х敓瀵嗗寵绨�
	for($i = 0; $i <= 255; $i++) {
		$rndkey[$i] = ord($cryptkey[$i % $key_length]);
	} 
	// 鐢ㄥ浐瀹氱殑绠楁硶锛屾墦涔卞瘑鍖欑翱锛屽鍔犻殢鏈烘�锛屽ソ鍍忓緢澶嶆潅锛屽疄闄呬笂瀵瑰苟涓嶄細澧炲姞瀵嗘枃鐨勫己搴�
	for($j = $i = 0; $i < 256; $i++) {
		$j = ($j + $box[$i] + $rndkey[$i]) % 256;
		$tmp = $box[$i];
		$box[$i] = $box[$j];
		$box[$j] = $tmp;
	} 
	// 鏍稿績鍔犺В瀵嗛儴鍒�
	for($a = $j = $i = 0; $i < $string_length; $i++) {
		$a = ($a + 1) % 256;
		$j = ($j + $box[$a]) % 256;
		$tmp = $box[$a];
		$box[$a] = $box[$j];
		$box[$j] = $tmp; 
		// 浠庡瘑鍖欑翱寰楀嚭瀵嗗寵杩涜寮傛垨锛屽啀杞垚瀛楃
		$result .= chr(ord($string[$i]) ^ ($box[($box[$a] + $box[$j]) % 256]));
	} 

	if ($operation == 'DECODE') {
		// substr($result, 0, 10) == 0 楠岃瘉鏁版嵁鏈夋晥鎬�
		// substr($result, 0, 10) - time() > 0 楠岃瘉鏁版嵁鏈夋晥鎬�
		// substr($result, 10, 16) == substr(md5(substr($result, 26).$keyb), 0, 16) 楠岃瘉鏁版嵁瀹屾暣鎬�
		// 楠岃瘉鏁版嵁鏈夋晥鎬э紝璇风湅鏈姞瀵嗘槑鏂囩殑鏍煎紡
		if ((substr($result, 0, 10) == 0 || substr($result, 0, 10) - time() > 0) && substr($result, 10, 16) == substr(md5(substr($result, 26) . $keyb), 0, 16)) {
			return substr($result, 26);
		} else {
			return '';
		} 
	} else {
		// 鎶婂姩鎬佸瘑鍖欎繚瀛樺湪瀵嗘枃閲岋紝杩欎篃鏄负浠�箞鍚屾牱鐨勬槑鏂囷紝鐢熶骇涓嶅悓瀵嗘枃鍚庤兘瑙ｅ瘑鐨勫師鍥�
		// 鍥犱负鍔犲瘑鍚庣殑瀵嗘枃鍙兘鏄竴浜涚壒娈婂瓧绗︼紝澶嶅埗杩囩▼鍙兘浼氫涪澶憋紝鎵�互鐢╞ase64缂栫爜
		return $keyc . str_replace('=', '', base64_encode($result));
	} 
} 

function uc_api_authcode($string, $operation = 'DECODE', $key = '', $expiry = 0) {
	$ckey_length = 4;
	$key = md5($key != '' ? $key : getglobal('authkey'));
	$keya = md5(substr($key, 0, 16));
	$keyb = md5(substr($key, 16, 16));
	$keyc = $ckey_length ? ($operation == 'DECODE' ? substr($string, 0, $ckey_length): substr(md5(microtime()), - $ckey_length)) : '';

	$cryptkey = $keya . md5($keya . $keyc);
	$key_length = strlen($cryptkey);

	$string = $operation == 'DECODE' ? base64_decode(substr($string, $ckey_length)) : sprintf('%010d', $expiry ? $expiry + time() : 0) . substr(md5($string . $keyb), 0, 16) . $string;
	$string_length = strlen($string);

	$result = '';
	$box = range(0, 255);

	$rndkey = array();
	for($i = 0; $i <= 255; $i++) {
		$rndkey[$i] = ord($cryptkey[$i % $key_length]);
	} 

	for($j = $i = 0; $i < 256; $i++) {
		$j = ($j + $box[$i] + $rndkey[$i]) % 256;
		$tmp = $box[$i];
		$box[$i] = $box[$j];
		$box[$j] = $tmp;
	} 

	for($a = $j = $i = 0; $i < $string_length; $i++) {
		$a = ($a + 1) % 256;
		$j = ($j + $box[$a]) % 256;
		$tmp = $box[$a];
		$box[$a] = $box[$j];
		$box[$j] = $tmp;
		$result .= chr(ord($string[$i]) ^ ($box[($box[$a] + $box[$j]) % 256]));
	} 

	if ($operation == 'DECODE') {
		if ((substr($result, 0, 10) == 0 || substr($result, 0, 10) - time() > 0) && substr($result, 10, 16) == substr(md5(substr($result, 26) . $keyb), 0, 16)) {
			return substr($result, 26);
		} else {
			return '';
		} 
	} else {
		return $keyc . str_replace('=', '', base64_encode($result));
	} 
} 
