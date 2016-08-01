<?php
/**
 * @version 1.0
 */
//liukun add for bug 52 begin
$firePHPEnable=TRUE;
if ($firePHPEnable){
	require_once('modules/FirePHPCore/FirePHP.class.php');
	require_once('modules/FirePHPCore/fb.php');
	ob_start();

	$firephp = FirePHP::getInstance(true);
}
//liukun add for bug 52 end

class blacklistClass {

	const ERROR = '操作有误，请不要乱操作';

	/**
	 * 列表
	 *
	 * @return Array
	 */
	function GetList($data = array()){
		global $mysql;

		$page = empty($data['page'])?1:$data['page'];
		$epage = empty($data['epage'])?10:$data['epage'];
		$_sql = " where 1=1 ";



		//liukun add for site_id search begin
// 		if (isset($data['areaid']) && $data['areaid']!="0"){
// 			$_sql .= " and p1.areaid = {$data['areaid']} ";
// 		}
		//liukun add for biao_type search begin
		if (isset($data['username']) && $data['username']!=""){
			$_sql .= " and p1.username = '{$data['username']}' ";
		}
		if (isset($data['realname']) && $data['realname']!=""){
			$_sql .= " and p1.realname = '{$data['realname']}' ";
		}
		if (isset($data['card_id']) && $data['card_id']!=""){
			$_sql .= " and p1.card_id = '{$data['card_id']}' ";
		}
		if (isset($data['phone']) && $data['phone']!=""){
			$_sql .= " and p1.phone = '{$data['phone']}' ";
		}
		if (isset($data['email']) && $data['email']!=""){
			$_sql .= " and p1.email = '{$data['email']}' ";
		}

		if (isset($data['subsite'])){
			$_sql .= " and p1.areaid={$data['subsite']}";
		}

		// 		$_select = 'p1.*,p2.typename,p3.sitename  ';
		// 		$sql = "select SELECT from  {links}  as p1
		// 				left join {links_type} as p2 on p1.type_id= p2.id
		// 				left join {subsite} as p3 on p1.areaid = p3.id
		// 				{$_sql} ORDER LIMIT";
		$_select = 'p1.*  ';
		$sql = "select SELECT from  {blacklist}  as p1

		{$_sql} ORDER LIMIT";

		//是否显示全部的信息
		if (isset($data['limit']) ){
			$_limit = "";
			if ($data['limit'] != "all"){
				$_limit = "  limit ".$data['limit'];
			}
			return $mysql->db_fetch_arrays(str_replace(array('SELECT', 'ORDER', 'LIMIT'), array($_select,  'order by p1.`order` desc,p1.id desc', $_limit), $sql));
		}

		$row = $mysql->db_fetch_array(str_replace(array('SELECT', 'ORDER', 'LIMIT'), array('count(1) as num', '', ''), $sql));

		$total = $row['num'];
		$total_page = ceil($total / $epage);
		$index = $epage * ($page - 1);
		$limit = " limit {$index}, {$epage}";

		$list = $mysql->db_fetch_arrays(str_replace(array('SELECT', 'ORDER', 'LIMIT'), array($_select, 'order by p1.id desc', $limit), $sql));
		$list = $list?$list:array();


		return array(
				'list' => $list,
				'total' => $total,
				'page' => $page,
				'epage' => $epage,
				'total_page' => $total_page
		);

	}
	

	/**
	 * 查看
	 *
	 * @param Array $data
	 * @return Array
	 */
	public static function GetOne($data = array()){
		global $mysql;
		$id = $data['id'];

		$sql = "select p1.* from  {blacklist}  as p1 where p1.id=$id ";
		return $mysql->db_fetch_array($sql);
	}
	
	public static function GetOnebyUserid($data = array()){
		global $mysql;
		$user_id = $data['user_id'];
	
		$sql = "select p1.* from  {blacklist}  as p1 where p1.user_id={$user_id} and `inner` = 1";
		return $mysql->db_fetch_array($sql);
	}
	
	public static function GetCountbycardid($data = array()){
		global $mysql;
		$card_id = $data['card_id'];
	
		$sql = "select ifnull(sum(late_amount), 0) as late_amount,
				ifnull(sum(late_num), 0) as late_num,
				ifnull(sum(advance_amount), 0) as advance_amount,
				ifnull(sum(advance_num), 0) as advance_num,
				ifnull(max(late_day_num), 0) as late_day_num,
				card_id
				from  {blacklist}  where card_id = '{$card_id}' and `inner` = 0 
				group by card_id
				";
		return $mysql->db_fetch_array($sql);
	}

	/**
	 * 添加
	 *
	 * @param Array $data
	 * @return Boolen
	 */
	function Add($data = array()){
		global $mysql;

		$list = $data['list'];

		foreach ($list  as $key => $blackuser){
// 			$card_id = $blackuser['card_id'];
// 			$sql = "delete from   {blacklist}  where `card_id` = '{$card_id}' and `inner` = 0 ";
// 			$mysql->db_query($sql);
				
			$sql = "insert into  {blacklist}  set `addtime` = '".time()."',`addip` = '".ip_address()."'";
			foreach($blackuser as $key => $value){
				$sql .= ",`$key` = '$value'";
			}
		}
		return $mysql->db_query($sql);
	}


	/**
	 * 修改
	 *
	 * @param Array $data
	 * @return Boolen
	 */
	function Update($data = array()){
		global $mysql;
		$id = $data['id'];
		if ($data['id'] == "") {
			return self::ERROR;
		}

		$_sql = "";
		$sql = "update  {blacklist}  set ";
		foreach($data as $key => $value){
			$_sql[] .= "`$key` = '$value'";
		}
		$sql .= join(",",$_sql)." where id = '$id'";
		return $mysql->db_query($sql);
	}

	/**
	 * 删除
	 *
	 * @param Array $data
	 * @return Boolen
	 */
	public static function Delete($data = array()){
		global $mysql;
		$id = $data['id'];
		if (!is_array($id)){
			$id = array($id);
		}
		$sql = "delete from  {blacklist}   where id in (".join(",",$id).")";
		return $mysql->db_query($sql);
	}



}
?>
