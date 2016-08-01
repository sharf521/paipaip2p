<?
/******************************
 * $File: attestation.class.php
 * $Description: ���ݿ⴦���ļ�
 * $Author: ahui 
 * $Time:2010-03-09
 * $Update:None 
 * $UpdateDate:None 
******************************/
require_once("modules/remind/remind.class.php");
class attestationClass{
	
	const ERROR = '���������벻Ҫ�Ҳ���';
	const ATTESTATION_TYPE_ID_NO_EMPTY = '����id����Ϊ��';

	/**
	 * �б�
	 *
	 * @return Array
	 */
	function GetList($data = array()){
		global $mysql;
		
		$page = empty($data['page'])?1:$data['page'];
		$epage = empty($data['epage'])?10:$data['epage'];
		
		$_sql = "where 1=1 ";		 
		if (isset($data['user_id']) && $data['user_id']!=""){
			$_sql .= " and p3.user_id = '{$data['user_id']}'";
		} 
		if (isset($data['username']) && $data['username']!=""){
			$_sql .= " and p3.username like '%{$data['username']}%'";
		}
		if (isset($data['realname']) && $data['realname']!=""){
			$_sql .= " and p3.realname like '%{$data['realname']}%'";
		}
		if (isset($data['type_id']) && $data['type_id']!=""){
			$_sql .= " and p1.type_id = '{$data['type_id']}'";
		} 
		if (isset($data['status']) && $data['status']!=""){
			$_sql .= " and p1.status = '{$data['status']}'";
		} 
		if (isset($data['kefu_userid']) && $data['kefu_userid']!=""){
			$sql = "select 1 from  {user_cache}  where kefu_userid={$data['kefu_userid']} and user_id='{$data['user_id']}'";
			$result  = $mysql->db_fetch_array($sql);
			if($result=="" || $result==false){
				return "���Ĳ�������";
			}
		} 
		
		//liukun add for subsite_id search begin
		if (isset($data['areaid']) && $data['areaid']!="0"){
			$_sql .= " and p3.areaid = {$data['areaid']} ";
		}
		//liukun add for subsite_id search end
		
		$sql = "select SELECT from  {attestation}  as p1 
				left join {attestation_type} as p2 on p1.type_id=p2.type_id  
				left join {user} as p3 on p1.user_id=p3.user_id
				$_sql ORDER LIMIT";
		$_select = " p1.*,p2.name as type_name,p3.username,p3.realname";		
		//�Ƿ���ʾȫ������Ϣ
		if (isset($data['limit']) && $data['limit']!="" ){
			$_limit = "";
			if ($data['limit'] != "all"){
				$_limit = " where limit ".$data['limit'];
			}
			return $mysql->db_fetch_arrays(str_replace(array('SELECT', 'ORDER', 'LIMIT'), array($_select, 'order by p1.`id` desc', $_limit), $sql));
		}
		$row = $mysql->db_fetch_array(str_replace(array('SELECT', 'ORDER', 'LIMIT'), array('count(1) as num', '', ''), $sql));
		
		$total = $row['num'];
		$total_page = ceil($total / $epage);
		$index = $epage * ($page - 1);
		$limit = " limit {$index}, {$epage}";
		
		$list = $mysql->db_fetch_arrays(str_replace(array('SELECT', 'ORDER', 'LIMIT'), array($_select, 'order by  p1.status asc,p1.id desc', $limit), $sql));		
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
	 * �鿴
	 *
	 * @param Array $data
	 * @return Array
	 */
	public static function GetOne($data = array()){
		global $mysql;
		$id = $data['id'];
		$sql = "select p1.* ,p1.jifen as h_jifen,p2.name as type_name,p2.jifen as d_jifen,p3.username, p2.fee, p2.urgent_fee from {attestation} as p1 
				left join {attestation_type} as p2 on p1.type_id=p2.type_id  left join {user} as p3 on p1.user_id=p3.user_id where p1.id=$id
				";
		return $mysql->db_fetch_array($sql);
	}
	
	/**
	 * ���
	 *
	 * @param Array $data
	 * @return Boolen
	 */
	function Add($data = array()){
		global $mysql;
        if ($data['type_id'] == "" ) {
            return self::ATTESTATION_TYPE_ID_NO_EMPTY;
        }
		
		$sql = "insert into  {attestation}  set `addtime` = '".time()."',`addip` = '".ip_address()."'";
		foreach($data as $key => $value){
			//$sql .= ",`$key` = '$value'";
			$sql .= ",`$key` = '".htmlspecialchars($value,ENT_QUOTES)."'";
		}
        return $mysql->db_query($sql);
	}
	
	
	/**
	 * �޸�
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
		$sql = "update  {attestation}  set ";
		foreach($data as $key => $value){
			$_sql[] .= "`$key` = '$value'";
		}
		$sql .= join(",",$_sql)." where id = '$id'";
        return $mysql->db_query($sql);
	}
	
		/**
	 * �޸�
	 *
	 * @param Array $data
	 * @return Boolen
	 */
	function Updatesql($sql){
		global $mysql;
        return $mysql->db_query($sql);
	}
	

	
	/**
	 * ɾ��
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
		$sql = "delete from {attestation}  where id in (".join(",",$id).")";
		return $mysql->db_query($sql);
	}
	
	
	/**
	 * �б�
	 *
	 * @return Array
	 */
	function GetTypeList($data = array()){
		global $mysql;
		
		$page = empty($data['page'])?1:$data['page'];
		$epage = empty($data['epage'])?10:$data['epage'];
		
		
		$sql = "select SELECT from {attestation_type} as p1  ORDER LIMIT";
		
		//�Ƿ���ʾȫ������Ϣ
		if (isset($data['limit']) ){
			$_limit = "";
			if ($data['limit'] != "all"){
				$_limit = " where limit ".$data['limit'];
			}
			return $mysql->db_fetch_arrays(str_replace(array('SELECT', 'ORDER', 'LIMIT'), array(' * ', 'order by p1.`order` desc, p1.`type_id` desc', $_limit), $sql));
		}
		
		
		$row = $mysql->db_fetch_array(str_replace(array('SELECT', 'ORDER', 'LIMIT'), array('count(1) as num', '', ''), $sql));
		
		$total = $row['num'];
		$total_page = ceil($total / $epage);
		$index = $epage * ($page - 1);
		$limit = " limit {$index}, {$epage}";
		
		$list = $mysql->db_fetch_arrays(str_replace(array('SELECT', 'ORDER', 'LIMIT'), array(' p1.*', 'order by p1.type_id desc', $limit), $sql));		
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
	 * �鿴
	 *
	 * @param Array $data
	 * @return Array
	 */
	public static function GetTypeOne($data = array()){
		global $mysql;
		$type_id = $data['type_id'];
		$sql = "select * from {attestation_type} as p1 where p1.type_id='{$type_id}' ";
		return $mysql->db_fetch_array($sql);
	}
	
	/**
	 * ���
	 *
	 * @param Array $data
	 * @return Boolen
	 */
	function AddType($data = array()){
		global $mysql;
        if ($data['name'] == "" ) {
            return self::ATTESTATION_TYPE_ID_NO_EMPTY;
        }
		
		$sql = "insert into  {attestation_type}  set `addtime` = '".time()."',`addip` = '".ip_address()."'";
		foreach($data as $key => $value){
			$sql .= ",`$key` = '$value'";
		}
        return $mysql->db_query($sql);
	}
	
	
	/**
	 * �޸�
	 *
	 * @param Array $data
	 * @return Boolen
	 */
	function UpdateType($data = array()){
		global $mysql;
		$type_id = $data['type_id'];
        if ($data['type_id'] == "") {
            return self::ERROR;
        }
		
		$_sql = "";
		$sql = "update  {attestation_type}  set ";
		foreach($data as $key => $value){
			$_sql[] .= "`$key` = '$value'";
		}
		$sql .= join(",",$_sql)." where type_id = '$type_id'";
		
        return $mysql->db_query($sql);
	}
	
	
	
	/**
	 * ɾ��
	 *
	 * @param Array $data
	 * @return Boolen
	 */
	public static function DeleteType($data = array()){
		global $mysql;
		$type_id = $data['type_id'];
		if (!is_array($type_id)){
			$type_id = array($type_id);
		}
		$sql = "delete from {attestation_type}  where type_id in (".join(",",$type_id).")";
		return $mysql->db_query($sql);
	}
	
	/**
	 * ��������
	 *
	 * @param Integer $type_id 
	 * @return boolen
	 */
	public static function OrderType($data = array()){
		global $mysql; 
		$type_id = $data['type_id'];
		$order = $data['order'];
		if ($type_id == "" || $order == "" ) return self::ERROR;
		foreach ($type_id as $key => $id){
			$sql = "update  {attestation_type}  set `order`='".$order[$key]."' where type_id=$id";
			$mysql->db_query($sql);
		}
		return true;
	}
}
?>