<?

/******************************
 * $File: user.class.php
* $Description: ���ݿ⴦���ļ�
* $Author: jackeng
* $Time:2011-06-03
* $Update:None
* $UpdateDate:None
******************************/
include_once("friends.class.php");
include_once(ROOT_PATH."core/webservice.php");

//liukun add for bug 52 begin
$firePHPEnable=TRUE;
if ($firePHPEnable){
	require_once('modules/FirePHPCore/FirePHP.class.php');
	require_once('modules/FirePHPCore/fb.php');
	ob_start();

	$firephp = FirePHP::getInstance(true);
}
//liukun add for bug 52 end

class userClass extends friendsClass{

	const ERROR = '���������벻Ҫ�Ҳ���';
	const TYPE_NAME_NO_EMPTY = '�������Ʋ���Ϊ��';
	const USERLOGIN_USERNAME_NO_EMPTY = '�û�������Ϊ��';
	const USERLOGIN_PASSWORD_NO_EMPTY = '���벻��Ϊ��';
	const USERLOGIN_USERNAME_PASSWORD_NO_RIGHT = '�û����������';
	const USER_ADD_LONG_USERNAME = '�û������Ȳ��ܳ���15���ַ�';
	const UESR_UCENTER_NO_RIGHT = 'Ucenter����ͬ��ע����Ϣ';
	const SENDEMAIL_EMAIL_NO_EMPTY = '�Ҳ�������';
	const USER_REG_EMAIL_EXIST = '�����Ѿ�����';
	const USER_REG_USERNAME_EXIST = '�û����Ѿ�����';
	const USER_REG_ERROR = '�û�ע��ʧ�ܣ��������Ա��ϵ';
	const USER_PROTECTION_ANSWER_NO_EMPTY = '�����뱣���𰸲���Ϊ��';
	const WEB_SERVICE_ERROR = -1;
	function userClass(){
		//�������ݿ������Ϣ
		global $mysql, $module;

		$this->mysql = $mysql;
		$this->ip = ip_address();//Ip
		$this->is_uc = false;
		$this->is_open_vip = false;

	}


	/**
	 * ����û��Ƿ��Ѿ���¼
	 *
	 * @param Varchar $username
	 * @return Bollen
	 */
	function check_login($res="no", $msg=""){
		global $magic;
		if ($res == "no" && $_SESSION['adminname'] == ""){
			$tpl = "admin_login.html";
			$magic->display($tpl);
			exit;
		}
	}

	/**
	 * ����û�������
	 *
	 * @param array $data
	 * @return array
	 */
	function CheckUsernamePassword($data = array()){
		global $mysql;
		$password = $data['password'];
		$user_id = $data['user_id'];
		$_sql = "";

		$sql = "select * from  {user}  where  user_id = '{$user_id}' and password='".md5($password)."'";
		$result = $mysql -> db_fetch_array($sql);
		if ($result == false) return false;
		return true;
	}


	/**
	 * �������
	 *
	 * @param array $data
	 * @return array
	 */
	function CheckEmail($data = array()){
		global $mysql;
		$email = $data['email'];
		$_sql = "";
		if (isset($data['user_id']) && $data['user_id']!=""){
			$_sql = " and user_id!= {$data['user_id']}";
		}
		$sql = "select * from  {user}  where  email = '{$email}' $_sql";
		$result = $mysql -> db_fetch_array($sql);
		//������䲻���ڵĻ��򷵻�
		if ($result == false) return false;
		return true;
	}

	/**
	 * ����û���
	 *
	 * @param array $data
	 * @return array
	 */
	function CheckUsername($data = array()){
		global $mysql;
		$username = $data['username'];

		//$username = iconv("UTF-8","GB2312",$username);

		$_sql = "";
		if (isset($data['user_id']) && $data['user_id']!=""){
			$_sql = " and user_id!= {$data['user_id']}";
		}
		$sql = "select * from  {user}  where  username = '{$username}' $_sql";

		$result = $mysql -> db_fetch_array($sql);
		if ($result == false) return false;
		return true;
	}


	/**
	 * ������֤
	 *
	 * @param array $data
	 * @return array
	 */
	function CheckIdcard($data = array()){
		global $mysql;
		$card_id  = $data['card_id'];
		$_sql = "";
		if (isset($data['user_id']) && $data['user_id']!=""){
			$_sql = " and user_id!= {$data['user_id']}";
		}
		$sql = "select * from  {user}  where  card_id  = '{$card_id}' $_sql limit 1";
		$result = $mysql -> db_fetch_array($sql);
		if ($result == false) return false;
		return true;
	}

	/**
	 * ����û�������
	 *
	 * @param array $data
	 * @return array
	 */
	function CheckUsernameEmail($data = array()){
		global $mysql;
		$email = $data['email'];
		$username = $data['username'];
		$user_id = $data['user_id'];
		$_sql = "";
		if ($user_id!=""){
			$_sql = " and user_id!={$user_id}";
		}
		$sql = "select * from  {user}  where  (email = '{$email}' or username = '{$username}')  $_sql";
		$result = $mysql -> db_fetch_array($sql);
		if ($result == false) return false;
		return true;
	}

	/**
	 * �û���¼
	 *
	 * @param array $data
	 * @return array
	 */
	function Login($data = array()){
		global $mysql;

		$user_id = isset($data['user_id'])?$data['user_id']:"";
		$username = isset($data['username'])?$data['username']:"";
		$password = isset($data['password'])?$data['password']:"";
		$direct_login = $data['direct_login'];
		$email = isset($data['email'])?$data['email']:"";
		if ($username=="" )	return self::USERLOGIN_USERNAME_NO_EMPTY;
		if ($password=="" )	return self::USERLOGIN_PASSWORD_NO_EMPTY;

		if($direct_login){
			// 			$sql = "select p1.*,p2.purview as pur,p2.type,p2.name as typename from  {user}  as p1 left join  {user_type}  as p2 on p1.type_id = p2.type_id where  (p1.email = '{$email}' or p1.user_id = '{$user_id}' or p1.username = '{$username}')";
			$sql = "select p1.*,p2.purview as pur,p2.type,p2.name as typename from  {user}  as p1 left join  {user_type}  as p2 on p1.type_id = p2.type_id where  p1.username = '{$username}'";
		}
		else{
			// 			$sql = "select p1.*,p2.purview as pur,p2.type,p2.name as typename from  {user}  as p1 left join  {user_type}  as p2 on p1.type_id = p2.type_id where p1.`password` = '".md5($password)."' and (p1.email = '{$email}' or p1.user_id = '{$user_id}' or p1.username = '{$username}')";
			$sql = "select p1.*,p2.purview as pur,p2.type,p2.name as typename from  {user}  as p1 left join  {user_type}  as p2 on p1.type_id = p2.type_id where p1.`password` = '".md5($password)."' and p1.username = '{$username}'";
		}
		if (isset($data['type']) && $data['type']!=""){
			$sql .= " and p2.type = '{$data['type']}'";
		}
		/*
		 if (isset($data['email']) && $data['email']!=""){
		$sql .= " and p1.email = '{$data['email']}'";
		}
		if (isset($data['user_id']) && $data['user_id']!=""){
		$sql .= " and p1.user_id = '{$data['user_id']}'";
		}
		if (isset($data['username']) && $data['username']!=""){
		$sql .= " and p1.username = '{$data['username']}'";
		}
		*/
		$result = $mysql->db_fetch_array($sql);

		if ($result == false){
			return self::USERLOGIN_USERNAME_PASSWORD_NO_RIGHT;
		}else{
			if(isset($data['superadmin']) && $data['superadmin']==true){
					
			}else{
				/* Author:LiuYY  function : track users login information */
				try{
					$s = "select user_id from  {user}  where username = '{$username}'";
					$u_id = $mysql->db_fetch_array($s);
					$time = time();
					$sql_track = "insert into  {usertrack}  set login_time = '".$time."',login_ip = '".ip_address()."',user_id = '{$u_id[user_id]}'";
					$mysql->db_query($sql_track);
				}catch(Exception $e){

				}
				$result['areaLoginMsg']=areaLoginCheck($u_id['user_id']);
				$sql = "update  {user}  set logintime = logintime + 1,uptime=lasttime,upip=lastip,lasttime='".time()."',lastip='".ip_address()."' where username='$username'";
				$mysql->db_query($sql);
			}
			return $result;
		}
	}
	function LoginUc($data = array()){
		global $mysql;

		$user_id = isset($data['user_id'])?$data['user_id']:"";
		$username = isset($data['username'])?$data['username']:"";
		$password = isset($data['password'])?$data['password']:"";
		$direct_login = $data['direct_login'];
		$email = isset($data['email'])?$data['email']:"";
		if ($username=="" )	return self::USERLOGIN_USERNAME_NO_EMPTY;
		if ($password=="" )	return self::USERLOGIN_PASSWORD_NO_EMPTY;

		$sql = "select p1.*,p2.purview as pur,p2.type,p2.name as typename from  {user}  as p1 left join  {user_type}  as p2 on p1.type_id = p2.type_id where  p1.username = '{$username}' ";
		if (isset($data['type']) && $data['type']!=""){
			$sql .= " and p2.type = '{$data['type']}'";
		}

		/*
		 if (isset($data['email']) && $data['email']!=""){
		$sql .= " and p1.email = '{$data['email']}'";
		}
		if (isset($data['user_id']) && $data['user_id']!=""){
		$sql .= " and p1.user_id = '{$data['user_id']}'";
		}
		if (isset($data['username']) && $data['username']!=""){
		$sql .= " and p1.username = '{$data['username']}'";
		}
		*/
		$result = $mysql->db_fetch_array($sql.' limit 1');

		if ($result == false){
			return self::USERLOGIN_USERNAME_PASSWORD_NO_RIGHT;
		}else{
			if(isset($data['superadmin']) && $data['superadmin']==true){
					
			}else{
				/* Author:LiuYY  function : track users login information */
				try{
					$s = "select user_id from  {user}  where username = '{$username}' limit 1";
					$u_id = $mysql->db_fetch_array($s);
					$time = time();
					$sql_track = "insert into  {usertrack}  set login_time = '".$time."',login_ip = '".ip_address()."',user_id = '{$u_id[user_id]}'";
					$mysql->db_query($sql_track);
				}catch(Exception $e){

				}
				$result['areaLoginMsg']=areaLoginCheck($u_id['user_id']);
				$sql = "update  {user}  set logintime = logintime + 1,uptime=lasttime,upip=lastip,lasttime='".time()."',lastip='".ip_address()."' where username='$username' limit 1";
				$mysql->db_query($sql);
			}
			return $result;
		}
	}
	public static function Isuc(){
		global $mysql;
		$sql = "select 1 from  {module}  where code = 'ucenter'";
		$result = $mysql->db_fetch_array($sql);
		return $result==false?false:true;
	}
	/**
	 * ����б�
	 *
	 * @return Array
	 */
	public static function GetList($data = array()){
		global $mysql;

		$type = isset($data['type'])?$data['type']:"";
		$page = empty($data['page'])?1:$data['page'];
		$epage = empty($data['epage'])?10:$data['epage'];

		$type_id = isset($data['type_id'])?$data['type_id']:"";
		$username = isset($data['username'])?$data['username']:"";
		$_sql = "";
		if ($type_id!=""){
			$_sql .= " and u.type_id in ($type_id)";
		}
		if ($type!=""){
			$_sql .= " and uy.type=$type";
		}
		if ($username!=""){
			$_sql .= " and u.username like '%$username%'";
		}
		if (isset($data['realname'])){
			$_sql .= " and u.realname like '%{$data['realname']}%'";
		}
		if (isset($data['email']) && $data['email']!=""){
			$_sql .= " and u.email like '%{$data['email']}%'";
		}
		if (isset($data['vip_status']) && $data['vip_status']!=""){
			$_sql .= " and uca.vip_status = {$data['vip_status']}";
		}
		if (isset($data['kefu_userid']) && $data['kefu_userid']!=""){
			$_sql .= " and uca.kefu_userid = {$data['kefu_userid']}";
		}
		if (isset($data['kefu_username']) && $data['kefu_username']!=""){
			$_sql .= " and uk.username like  '%{$data['kefu_username']}%'";
		}
		if (isset($data['real_status'])){
			$_sql .= " and u.real_status in ( {$data['real_status']})";
		}
		if (isset($data['avatar_status'])){
			$_sql .= " and u.avatar_status = {$data['avatar_status']}";
		}
		if (isset($data['phone_status'])){
			if($data['phone_status'] == 1){
				$_sql .= " and u.phone_status = {$data['phone_status']}";
			}else if($data['phone_status'] == 2) {
				$_sql .= " and u.phone_status > 1 ";
			}
		}
		if (isset($data['video_status'])){
			$_sql .= " and u.video_status = {$data['video_status']}";
		}

		//liukun add for subsite_id search begin
		if (isset($data['areaid']) && $data['areaid']!="0"){
			$_sql .= " and u.areaid = {$data['areaid']} ";
		}
		//liukun add for subsite_id search end

		$_select = " u.*,uy.name as typename,uca.vip_status,uca.vip_money,uk.username as kefu_username, se.sitename";
		$_order =  'order by u.`order` desc,u.user_id desc';

		if (isset($data['order'])){
			if ($data['order']=="new"){
				$_order= " order by u.addtime desc";
			}elseif ($data['order']=="integral"){
				$_order = " order by u.integral desc";
			}elseif ($data['order']=="hits"){
				$_order = " order by u.hits desc";
			}elseif ($data['order']=="real_status"){
				$_order = " order by u.real_status desc,u.user_id desc";
			}
		}
		$sql = "select SELECT
		from  {user}  as u
		left join  {user_type}  as uy on u.type_id=uy.type_id
		left join  {user_cache}  as uca on uca.user_id=u.user_id
		left join  {userinfo}  as uin on uin.user_id=u.user_id
		left join  {user}  as uk on uca.kefu_userid=uk.user_id
		left join {subsite} as se on u.areaid = se.id
		";
		if(self::Isuc()) {
			$sql .= " left join  {ucenter}  as uc on u.user_id=uc.user_id";
			if (isset($data['school'])){
				$_select = " u.*,uy.name as typename,uc.uc_user_id,us.school,us.professional";
				$sql .= " left join  {school_resume}  as us on u.user_id=us.user_id";
			}else{
				$_select = " u.*,uy.name as typename,uc.uc_user_id";
			}
		}
		$sql .= " where 1=1  $_sql	 ORDER LIMIT";

		//�Ƿ���ʾȫ������Ϣ
		if (isset($data['limit']) ){
			$_limit = "";
			if ($data['limit'] != "all"){
				$_limit = "  limit ".$data['limit'];
			}
			return $mysql->db_fetch_arrays(str_replace(array('SELECT', 'ORDER', 'LIMIT'), array($_select, $_order, $_limit), $sql));
		}
			
		$row = $mysql->db_fetch_array(str_replace(array('SELECT', 'ORDER', 'LIMIT'), array('count(1) as num', '', ''), $sql));

		$total = $row['num'];
		$total_page = ceil($total / $epage);
		$index = $epage * ($page - 1);
		$limit = " limit {$index}, {$epage}";
		$list = $mysql->db_fetch_arrays(str_replace(array('SELECT', 'ORDER', 'LIMIT'), array($_select,$_order, $limit), $sql));
		$list = $list?$list:array();

		return array(
				'list' => $list,
				'total' => $total,
				'page' => $page,
				'epage' => $epage,
				'total_page' => $total_page
		);

	}

	function GetOnes($data){
		global $mysql;
		$_sql = " where 1=1 ";
		if (isset($data['user_id']) && $data['user_id']!=""){
			$_sql .= " and user_id='{$data['user_id']}'";
		}
		if (isset($data['username']) && $data['username']!=""){
			$_sql .= " and username='{$data['username']}'";
		}
		if (isset($data['email']) && $data['email']!=""){
			$_sql .= " and email='{$data['email']}'";
		}
		$sql = "select * from  {user}  {$_sql} ";
		$result = $mysql -> db_fetch_array($sql);
		return $result;
	}

	/**
	 * �鿴�û�
	 *
	 * @param Array $data
	 * @return Array
	 */
	public static function GetOne($data = array()){
		global $mysql;
		$user_id = isset($data['user_id'])?$data['user_id']:"";
		$username = isset($data['username'])?$data['username']:"";
		$password = isset($data['password'])?$data['password']:"";
		$email = isset($data['email'])?$data['email']:"";
		$type_id = isset($data['type_id'])?$data['type_id']:"";
		//liukun add for �����϶�����ڣ�û��Ҫÿ�ζ���飬����ֻ��һ���ֶΣ�����Ҳһ�������
		// 		$sql = "CREATE TABLE IF NOT EXISTS  {user_cache}  (
		// 		`user_id` int(11) NOT NULL DEFAULT '0')";
		// 		$mysql ->db_query($sql);
		if ($user_id == "" && $username == "") return self::ERROR;
		$sql = "select p2.name as typename,p2.type,p3.*,p4.*,p5.*,p1.*  from  {user}  as p1
		left join  {user_type}  as p2 on  p1.type_id = p2.type_id
		left join  {user_cache}  as p3 on  p3.user_id = p1.user_id
		left join  {account}  as p4 on  p4.user_id = p1.user_id
		left join  {userinfo}  as p5 on  p5.user_id = p1.user_id
		where 1=1 ";
		
		if ($user_id!=""){
			$sql .= " and p1.user_id = $user_id";
		}

		if ($password!=""){
			$sql .= " and  p1.password = '".md5($password)."'";
		}

		if ($username!=""){
			$sql .= " and  p1.username = '$username'";
		}

		if ($email!=""){
			$sql .= " and  p1.email = '$email'";
		}

		if ($type_id!=""){
			$sql .= " and p1.type_id = '$type_id'";
		}


		return $mysql->db_fetch_array($sql);
	}
	
	//��ȡ�û����ű�����֤��Ϣ
	public static function GetCreditAudit($data = array()){
		global $mysql;
		$user_id = isset($data['user_id'])?$data['user_id']:"";
		$sql = "select *  from  {attestation}  
		where user_id={$user_id} and  type_id = 3 order by id desc limit 1 ";
		
		return $mysql->db_fetch_array($sql);
	}

	/**
	 * ���
	 *
	 * @param Array $index
	 * @param $user_id �����û�ID
	 * @return Boolen
	 */
	function AddUser($data = array()){
		global $mysql, $_G;
		$con_connect_ws = isset($_G['system']['con_connect_ws'])?$_G['system']['con_connect_ws']:"0";

		$password = '';
		if (!$data['username'] || !$data['password'] || !$data['email']) {
			return self::ERROR;
		}
		if (strlen($data['username'])>15){
			return self::USER_ADD_LONG_USERNAME;
		}
		if(self::CheckEmail($data)) return self::USER_REG_EMAIL_EXIST;
		if(self::CheckUsername($data)) return self::USER_REG_USERNAME_EXIST;

		$password = $data['password'];
		$data['password'] = md5($data['password']);



		//liukun add for bug 250 begin
		if ($con_connect_ws=="1"){

			$ws_user_id = webService('Regist');

			$data['ws_user_id'] = $ws_user_id;
		}

		$sql = "insert into  {user}  set `addtime` = '".time()."',`addip` = '".ip_address()."',`uptime` = '".time()."',`upip` = '".ip_address()."',`lasttime` = '".time()."',`lastip` = '".ip_address()."'";

		foreach($data as $key => $value){
			$sql .= ",`$key` = '$value'";
		}

		$result = $mysql->db_query($sql);
		if($result==false){
			return self::USER_REG_ERROR;
		}else{
			$user_id = $mysql->db_insert_id();

			//���뻺��
			self::AddUserCache(array("user_id"=>$user_id));

			//��Ϊ����
			if ($data['invite_userid'] !=""){
				$sql = "insert into  {friends}  set 		user_id='{$data['invite_userid']}',friends_userid='{$user_id}',type='1',status=1,addtime='".time()."'";
				$mysql ->db_query($sql);
				$sql = "insert into  {friends}  set 		friends_userid='{$data['invite_userid']}',user_id='{$user_id}',type='1',status=1,addtime='".time()."'";
				$mysql ->db_query($sql);
			}
			return $user_id;
		}
	}


	/**
	 * �޸�
	 *
	 * @param Array $index
	 * @return Boolen
	 */
	function UpdateUser($data = array()){
		global $mysql;
		$user_id = $data['user_id'];
		if ($user_id == "" )	return self::ERROR;

// 		$user_name = $this->getUserName($user_id);
// 		if (!$user_name) {
// 			return -1;
// 		}
// 		if ($this->is_uc) {
// 			if (!UcenterClient::updateUser($user_name, '', $index['password'], $index['email'])) {
// 				return -1;
// 			}
// 		}

		if (isset($data['password'])) {
			if ($data['password']!="") {
				$data['password'] = md5($data['password']);
			}
			else{
				unset($data['password']);
			}
		}
		$sql = "update  {user}  set `user_id` = {$user_id}";
		foreach($data as $key => $value){
			$sql .= ",`$key` = '$value'";
		}
		$sql .= " where `user_id` = $user_id";
		return $mysql->db_query($sql);
	}

	/**
	 * ���������û�
	 *
	 * @param Integer $type_id
	 * @return boolen
	 */
	function ActionUser($data = array()){
		global $mysql;
		$user_id = $data['user_id'];
		$order = $data['order'];
		if ($user_id == "" || $order == "" ) return self::ERROR;
		foreach ($user_id as $key => $id){
			$sql = "update  {user}  set `order`='".$order[$key]."' where user_id=$id";
			$mysql->db_query($sql);
		}
		return true;
	}


	/**
	 * �޸����뱣��
	 *
	 * @param Array $data
	 * @return Boolen
	 */
	function UpdateUserProtection($data = array()){
		global $mysql;
		$user_id = $data['user_id'];
		$answer = $data['answer'];
		if ($user_id == "" )	return self::ERROR;
		if ($answer == "" )	return self::USER_PROTECTION_ANSWER_NO_EMPTY;
		$sql = "update  {user}  set `user_id` = {$user_id}";
		foreach($data as $key => $value){
			$sql .= ",`$key` = '$value'";
		}
		$sql .= " where `user_id` = $user_id";
		return $mysql->db_query($sql);
	}

	/**
	 * �޸��û��ĸ�����Ϣ
	 *
	 * @param Array $data
	 * @return Boolen
	 */
	function UpdateUserAll($data = array()){
		global $mysql;
		$user_id = $data['user_id'];
		if ($user_id == "" )	return self::ERROR;
		$sql = "update  {user}  set `user_id` = {$user_id}";
		foreach($data as $key => $value){
			$sql .= ",`$key` = '$value'";
		}
		$sql .= " where `user_id` = $user_id";
		return $mysql->db_query($sql);
	}

	/**
	 * �޸��û��Ļ�����Ϣ
	 *
	 * @param Array $data
	 * @return Boolen
	 */
	function UpdateUserCache($data = array()){
		global $mysql;
		$user_id = $data['user_id'];
		if ($user_id == "" )	return self::ERROR;
		$sql = "update  {user_cache}  set `user_id` = {$user_id}";
		foreach($data as $key => $value){
			$sql .= ",`$key` = '$value'";
		}
		$sql .= " where `user_id` = $user_id";
		return $mysql->db_query($sql);
	}

	/**
	 * �޸�����
	 *
	 * @param Integer $user_id
	 * @param Array $index
	 * @return Boolen
	 */
	public static function OrderUser($data = array()){
		global $mysql;
		$user_id = $data['user_id'];
		$order = $data['order'];
		if ($user_id == "" || $order == "")	return self::ERROR;

		if (is_array($user_id)){
			foreach($user_id as $key => $value){
				$sql = "update  {user}  set `order` = $order[$key] where `user_id` = $value";
				$mysql->db_query($sql);
			}
		}
		return true;
	}





	/**
	 * ɾ���û�
	 *
	 * @param Array $data
	 * @return Boolen
	 */
	public static function DeleteUser($data = array()){
		global $mysql;
		$user_id = $data['user_id'];
		$type = $data['type'];//�û������ͣ��ǹ���Ա������ͨ�û�
		if ($user_id == "")	return self::ERROR;
		/*
		 if ($this->is_uc) {
		$uc_user_id = $this->getUserIdInUCenter($user_id);
		if (!$uc_user_id) {
		return -1;
		}
		if (!UcenterClient::deleteUser($uc_user_id)) {
		return -1;
		}
		$sql = "delete from  {ucenter}  where uc_user_id={$uc_user_id}";
		$this->mysql->db_query($sql);
		}
		*/
		$_sql = "";
		if ($type!=""){
			$_sql = " and type=$type";
		}

		$sql = "delete u from  {user}  u left join  {user_type}  ut on u.type_id=ut.type_id where u.user_id = $user_id  and ut.type=$type and u.user_id!=1 $_sql";
		return $mysql->db_query($sql);
	}





	/**
	 *��ӹ���Ա�Ĳ�����¼
	 *
	 * @return Boolean
	 */
	public function add_log($index,$result){
		global $mysql,$_G;
		$sql = "insert into  {user_log}  set `result`='$result',`user_id`='".$_G['user_id']."',`addtime`='".time()."',addip='".ip_address()."'";
		if (is_array($index)){
			foreach($index as $key => $value){
				$sql .= ",`$key` = '$value'";
			}
		}
		return $mysql->db_query($sql);
	}

	/**
	 *��ӹ���Ա�Ĳ�����¼
	 *
	 * @return Boolean
	 */
	public function AddLog($index,$result){
		global $mysql;
		$sql = "insert into  {user_log}  set `result`='$result',`user_id`='".$_SESSION['user_id']."',`addtime`='".time()."',addip='".ip_address()."'";
		if (is_array($index)){
			foreach($index as $key => $value){
				$sql .= ",`$key` = '$value'";
			}
		}
		return $mysql->db_query($sql);
	}

	/**
	 * ��ȡ�û���
	 * @param $u_id �û�ID
	 */
	public function GetUserName ($u_id) {
		$record = $this->mysql->db_fetch_array("select username from  {user}  where user_id={$u_id};");
		if (!$record) {
			return false;
		}
		return $record['username'];
	}

	/**
	 * ��ȡ�û���Ӧucenter uid
	 * @param $u_id
	 */
	public function GetUserIdInUCenter ($user_id) {
		$record = $this->mysql->db_fetch_array("select uc_user_id from  {ucenter}  where user_id={$user_id};");
		if (!$record) {
			return false;
		}
		return $record['uc_user_id'];
	}

	/**
	 * ��ȡ��Ա���ڳ�������
	 */
	public static function GetUserCity ($data = array()) {
		global $mysql;
		$user_id = $data['user_id'];
		if (empty($user_id)) return self::ERROR;
		$sql = "select a.name from  {user}  u left join {area} a on u.city=a.id
		where u.user_id={$user_id}";
		$area = $mysql->db_fetch_array($sql);

		return $area['name'];
	}

	/**
	 * ��ȡ�û����͵��б�
	 */
	public static function GetTypeList ($data = array()) {
		global $mysql;
		$_sql = "";
		if (isset($data['where']) && $data['where']!=""){
			$_sql .= $data['where'];
		}
		if (isset($data['type']) && $data['type']!=""){
			$_sql .= " and type=".$data['type'];
		}
		$sql = "select * from  {user_type}  where 1=1 $_sql order by `order` desc";
		$result = $mysql -> db_fetch_arrays($sql);
		return $result;
	}

	/**
	 * �鿴����
	 *
	 * @param Array $data
	 * @return Array
	 */
	public static function GetTypeOne($data = array()){
		global $mysql;
		if ($data['type_id'] == "") return self::ERROR;
		$sql = "select * from  {user_type}  where `type_id` = ".$data['type_id'];
		return $mysql->db_fetch_array($sql);
	}

	/**
	 * �������
	 *
	 * @param Array $index
	 * @return Boolen
	 */
	public static function Addtype($data = array()){
		global $mysql;
		if ($data['name'] == "")	return self::TYPE_NAME_NO_EMPTY;
		$sql = "insert into  {user_type}  set `addtime` = '".time()."',`addip` = '".ip_address()."'";
		if (is_array($data)){
			foreach($data as $key => $value){
				$sql .= ",`$key` = '$value'";
			}
		}
		return $mysql->db_query($sql);
	}

	/**
	 * �޸�����
	 *
	 * @param Array $index
	 * @return Boolen
	 */
	public static function UpdateType($data = array()){
		global $mysql;
		if ($data['name'] == "")	return self::TYPE_NAME_NO_EMPTY;
		$type_id = $data['type_id'];
		if ($type_id == "" )	return self::ERROR;
		$_sql = array();
		$sql = "update  {user_type}  set ";
		foreach($data as $key => $value){
			$_sql[]= "`$key` = '$value'";
		}

		$sql .= join(",",$_sql)." where `type_id` = $type_id";
		return $mysql->db_query($sql);
	}



	/**
	 * ɾ������
	 *
	 * @param Array $data
	 * @return boolen
	 */
	public static function DeleteType($data = array()){
		global $mysql;
		$type_id = $data['type_id'];
		if ($type_id == "") return self::ERROR;
		$sql = "delete from  {user_type}  where `type_id` = $type_id and type_id!=1";
		$mysql->db_query($sql);
		$sql  = "delete from  {user}  where `type_id` = $type_id and type_id!=1";
		$mysql->db_query($sql);
		return true;
	}

	/**
	 * ��������
	 *
	 * @param Integer $type_id
	 * @return boolen
	 */
	function OrderType($data = array()){
		global $mysql;
		$type_id = $data['type_id'];
		$order = $data['order'];
		if ($type_id == "" || $order == "" ) return self::ERROR;
		foreach ($type_id as $key => $id){
			$sql = "update  {user_type}  set `order`='".$order[$key]."' where type_id=$id";
			$mysql->db_query($sql);
		}
		return true;
	}

	/**
	 * �����ʼ�
	 *
	 * @param Array $data
	 * @return boolen
	 */
	function SendEmail($data = array()){
		global $mysql;
		require_once ROOT_PATH . 'plugins/mail/mail.php';

		$user_id = isset($data['user_id'])?$data['user_id']:'0';
		$title = isset($data['title'])?$data['title']:'ϵͳ��Ϣ';//�ʼ����͵ı���
		$email = isset($data['email'])?$data['email']:'';//�ʼ����͵�����
		$msg   = isset($data['msg'])?$data['msg']:'ϵͳ��Ϣ';//�ʼ����͵�����
		$type = isset($data['type'])?$data['type']:'system';//�ʼ����͵�����

		if($email == ""){
			return self::SENDEMAIL_EMAIL_NO_EMPTY;
		}

		$result = Mail::Send($title,$msg, array($email));

		$status = $result?1:0;

		$mysql->db_query("insert into  {user_sendemail_log}  set email='{$email}',user_id='{$user_id}',title='{$title}',msg='{$msg}',type='{$type}',status='{$status}',addtime='".time()."',addip='".ip_address()."'");
		return $result;
	}
	/**
	 * �����ʼ�
	 *
	 * @param Array $data
	 * @return boolen
	 */
	function SendEmailHouTai($data = array()){
		global $mysql;
		require_once ROOT_PATH . 'plugins/mail/mail.php';

		$user_id = isset($data['user_id'])?$data['user_id']:'0';
		$title = isset($data['title'])?$data['title']:'ϵͳ��Ϣ';//�ʼ����͵ı���
		$email = isset($data['email'])?$data['email']:'';//�ʼ����͵�����
		$msg   = isset($data['msg'])?$data['msg']:'ϵͳ��Ϣ';//�ʼ����͵�����
		$type = isset($data['type'])?$data['type']:'system';//�ʼ����͵�����
		
		$email_info = $data['email_info'];

		if($email == ""){
			return self::SENDEMAIL_EMAIL_NO_EMPTY;
		}

		$result = Mail::SendHouTai($title,$msg, array($email), $email_info);

		$status = $result?1:0;

		$mysql->db_query("insert into  {user_sendemail_log}  set email='{$email}',user_id='{$user_id}',title='{$title}',msg='{$msg}',type='{$type}',status='{$status}',addtime='".time()."',addip='".ip_address()."'");
		return $result;
	}

	/**
	 * �����Ա
	 * @param $param array('user_id' => '��ԱID')
	 * @return bool true/false
	 */
	function ActiveEmail ($data = array()) {
		global $mysql;
		$user_id = isset($data['user_id'])?$data['user_id']:'';
		if (empty($user_id)) return self::ERROR;
		$mysql->db_query("update  {user}  set email_status=1 where user_id=$user_id");
		$result = $mysql->db_fetch_array("select * from  {user}  where user_id=$user_id");
		return $result;
	}

	/**
	 * ����ͷ��
	 * @param $param array('user_id' => '��ԱID')
	 * @return bool true/false
	 */
	function ActiveAvatar ($data = array()) {
		global $mysql;
		$user_id = isset($data['user_id'])?$data['user_id']:'';
		if (empty($user_id)) return self::ERROR;
		$mysql->db_query("update  {user}  set avatar_status=1 where user_id=$user_id");
		$result = $mysql->db_fetch_array("select * from {user} where user_id=$user_id");
		return $result;
	}

	/**
	 * ����û��Ķ�̬
	 * @param $param array('user_id' => '��ԱID')
	 * @return bool true/false
	 */
	public static function GetUserTrend($data = array()){
		global $mysql;
		$_sql = " where 1=1 ";
		if (isset($data['user_id']) && $data['user_id']!=""){
			$_sql .= " and user_id in ({$data['user_id']})";
		}
		$_limit = "";
		if (isset($data['limit']) && $data['limit']!=""){
			$_limit = " limit {$data['limit']}";
		}
		$sql = "select friends_userid  from  {friends}  {$_sql} and status=1";

		$result = $mysql->db_fetch_arrays($sql);
		$_friend_userid = "";
		foreach ($result as $key => $value){
			$_friend_userid[] = $value['friends_userid'];
		}
		if ($_friend_userid!=""){
			$friend_userid = join(",",$_friend_userid);

			$sql = "select p1.*,p2.username from  {message}  as p1 left join  {user}  as p2 on p1.receive_user=p2.user_id where p1.receive_user in ({$friend_userid}) order by p1.addtime desc  {$_limit}";
			//echo $sql;
			$result =  $mysql->db_fetch_arrays($sql);

			foreach ($result as $key => $value){
				$result[$key]['name'] = htmlspecialchars_decode($value["name"],ENT_QUOTES);
			}

			return $result;
		}else{
			return "";
		}
	}

	/**
	 * ��Ӻ��ѵĶ�̬
	 * @param $param array('user_id' => '��ԱID')
	 * @return bool true/false
	 */
	public static function AddUserTrend($data = array()){
		global $mysql;
		if (!isset($data['user_id']) || $data['user_id']==""){
			return self::ERROR;
		}
		$sql = "insert into  {user_trend}  set user_id='{$data['user_id']}',addtime='".time()."',content='{$data['content']}'";
		return $mysql->db_query($sql);
	}

	/**
	 * ����û��Ļ���
	 * @param $param array('user_id' => '��ԱID')
	 * @return bool true/false
	 */
	public static function GetUserCache($data = array()){
		global $mysql,$_G;

		if (isset($data['user_id']) && $data['user_id']!=""){
			//liukun add for �����϶�����ڣ�û��Ҫÿ�ζ���飬����ֻ��һ���ֶΣ�����Ҳһ�������
			// 			$sql = "CREATE TABLE IF NOT EXISTS  {user_cache}  (
			// 			`user_id` int(11) NOT NULL DEFAULT '0')";
			// 			$mysql ->db_query($sql);
			$sql = "select p1.*,p3.username as kefu_username,p3.realname as  kefu_realname from  {user_cache}  as p1
			left join  {user}  as p3 on p1.kefu_userid = p3.user_id
			where p1.user_id ='{$data['user_id']}'";
			$result = $mysql->db_fetch_array($sql);
			if ($result == false) {
				//���뻺��
				self::AddUserCache(array("user_id"=>$data['user_id']));
				$result = $mysql->db_fetch_array($sql);
			}
		}else{
			$sql = "select * from  {user_cache}  order by user_id desc";
			$result = $mysql->db_fetch_arrays($sql);
		}

		return $result;
	}


	/**
	 * ���뻺��
	 * @param $param array('user_id' => '��ԱID')
	 * @return bool true/false
	 */
	public static function AddUserCache($data=array()){
		global $mysql,$_G;
		if ($data['user_id'] == "")	return self::ERROR;
		$_sql = array();
		$sql = "insert into   {user_cache}  set ";
		foreach($data as $key => $value){
			$_sql[] = "`$key` = '$value'";
		}
		if (isset($_G['system']["con_user_amount"]) && $_G['system']['con_user_amount']!=""){
			$sql .= "borrow_amount={$_G['system']['con_user_amount']},";
			$_amount = $_G['system']['con_user_amount'];
		}else{
			$sql .= "borrow_amount=2000,";
			$_amount = 2000;
		}
		$mysql->db_query($sql.join(",",$_sql));
		$sql = "insert into   {user_amount}  set credit={$_amount},credit_use={$_amount},credit_nouse=0,user_id={$data['user_id']}";
		$mysql->db_query($sql);
	}

	/**
	 * vip����
	 * @param $param array('user_id' => '��ԱID')
	 * @return bool true/false
	 */
	public static function ApplyUserVip($data=array()){
		global $mysql,$_G;
		require_once ROOT_PATH . 'modules/account/account.class.php';

		if ($data['user_id'] == "")	return self::ERROR;

		$user_id = $data['user_id'];
		$vip_money = (!isset($_G['system']['con_vip_money']) || $_G['system']['con_vip_money']=="")?120:$_G['system']['con_vip_money'];

		$account_result =  accountClass::GetOne(array("user_id"=>$user_id));

		if ($account_result['use_money'] < $vip_money){
			return "�������㡣";
		}

		$vip_log['user_id'] = $user_id;
		$vip_log['type'] = "vip";
		$vip_log['money'] = $vip_money;
		$vip_log['total'] = $account_result['total'];
		$vip_log['use_money'] = $account_result['use_money']-$vip_log['money'];
		$vip_log['no_use_money'] = $account_result['no_use_money'] + $vip_log['money'];
		$vip_log['collection'] = $account_result['collection'];
		$vip_log['to_user'] = "0";
		$vip_log['remark'] = "����VIP�����Ա��";
		accountClass::AddLog($vip_log);

		$sql = "update  {user_cache}  set kefu_userid = '{$data['kefu_userid']}',kefu_addtime = '".time()."',`vip_status`=2,`vip_remark` = '".$data['vip_remark']."' where user_id = {$data['user_id']}";
		return $mysql->db_query($sql);
	}

	function GetUserNum(){
		global $mysql;
		$sql = "select count(*) as num from  {user} ";
		$result = $mysql -> db_fetch_array($sql);
		return $result;
	}

	/**
	 * �ı�����
	 * @param $param array('user_id' => '��ԱID')
	 * @return bool true/false
	 */

	function TypeChange($data){
		global $mysql;
		$type = isset($data['type'])?$data['type']:"new";
		if ($type=="new"){
			$sql = "insert into  {user_typechange}  set old_type='{$data['old_type']}',new_type='{$data['new_type']}',user_id='{$data['user_id']}',addtime='".time()."',addip='".ip_address()."',content='{$data['content']}',status=0";
			return $mysql->db_query($sql);
		}elseif ($type=="update"){
			$sql = "update  {user_typechange}  set status='{$data['status']}' where id='{$data['id']}' ";
			$mysql->db_query($sql);
			$result = self::TypeChange(array("id"=>$data['id'],"type"=>"view"));
			if ($data['status']==1 && $result['user_id']!=1){
				$sql = "update  {user}  set type_id='{$result['new_tyoe']}' where user_id='{$result['user_id']}'";
				$mysql->db_query($sql);
			}
			return true;
		}elseif ($type=="view"){
			$sql = "select * from  {user_typechange}  where id='{$data['id']}'";
			return $mysql->db_fetch_array($sql);

		}elseif ($type=="list"){
			$page = empty($data['page'])?1:$data['page'];
			$epage = empty($data['epage'])?10:$data['epage'];
			$sql = "select SELECT from  {user_typechange}  as p1
			left join  {user}  as p2 on p1.user_id = p2.user_id
			left join  {user_type}  as p3 on p1.old_type = p3.type_id
			left join  {user_type}  as p4 on p1.new_type = p4.type_id

			ORDER LIMIT";
			$_select = "p1.*,p2.realname,p2.username,p3.name as old_typename,p4.name as new_typename";
			$_order = " order by p1.id desc";
			//�Ƿ���ʾȫ������Ϣ
			if (isset($data['limit']) ){
				$_limit = "";
				if ($data['limit'] != "all"){
					$_limit = "  limit ".$data['limit'];
				}
				return $mysql->db_fetch_arrays(str_replace(array('SELECT', 'ORDER', 'LIMIT'), array($_select, $_order, $_limit), $sql));
			}

			$row = $mysql->db_fetch_array(str_replace(array('SELECT', 'ORDER', 'LIMIT'), array('count(1) as num', '', ''), $sql));

			$total = $row['num'];
			$total_page = ceil($total / $epage);
			$index = $epage * ($page - 1);
			$limit = " limit {$index}, {$epage}";
			$list = $mysql->db_fetch_arrays(str_replace(array('SELECT', 'ORDER', 'LIMIT'), array($_select,$_order, $limit), $sql));
			$list = $list?$list:array();

			return array(
					'list' => $list,
					'total' => $total,
					'page' => $page,
					'epage' => $epage,
					'total_page' => $total_page
			);
		}
	}


	public static function GetUserBirthday(){
		global $mysql;
		$days = date('t',time());
		$first_time = date("m",time())."01";
		$end_time = date("m",time())."31";
		$sql = "select birthday,user_id,username,realname from  {user}   ";
		$result = $mysql->db_fetch_arrays($sql);
		$_result="";
		foreach ($result as $key => $value){
			if ($value['birthday']!=""){
				$btime = date("md",$value['birthday']);
				if ($btime>$first_time && $btime <$end_time){
					$_result[$key]['monthday'] = $btime;
					$_result[$key]['user_id'] = $value['user_id'];
					$_result[$key]['birthday'] = $value['birthday'];
					$_result[$key]['realname'] = $value['realname'];
				}
			}
		}
		sort($_result);
		return $_result;
	}
	
	//�Ƿ������ڴ���
	public static function isHasLastRepayment($data=array())
	{
		global $mysql;
		
		if (isset($data['user_id']) )
		{
			
			$sql="select b2.id from {borrow} b1 left join {borrow_repayment} b2 on b1.id=b2.borrow_id where b1.status=3 and b2.status=0 and b2.repayment_time <".time()." and b1.user_id=".$data['user_id'].' limit 1';
		}
		if (isset($data['borrow_id']) )
		{
			$sql="select id from {borrow_repayment} where status=0 and repayment_time <".time()." and borrow_id=".$data['borrow_id'].' limit 1';
		}
		$result = $mysql->db_fetch_array($sql);
		if(empty($result))
			return false;
		else
			return true;
	}
}
?>