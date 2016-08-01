<?
/******************************
 * $File: limitapp.class.php
 * $Description: ���ݿ⴦���ļ�
 * $Author: ahui 
 * $Time:2010-03-09
 * $Update:None 
 * $UpdateDate:None 
******************************/
class limitappClass{
	
	const ERROR = '���������벻Ҫ�Ҳ���';

	/**
	 * �б�
	 *
	 * @return Array
	 */
	function GetList($data = array()){
		global $mysql;
		$user_id = empty($data['user_id'])?"":$data['user_id'];
		$username = empty($data['username'])?"":$data['username'];
		$status = empty($data['status'])?"":$data['status'];
	
		
		$page = empty($data['page'])?1:$data['page'];
		$epage = empty($data['epage'])?10:$data['epage'];
		
		$_sql = "where 1=1 ";		 
		if (!empty($user_id)){
			$_sql .= " and p2.user_id = $user_id";
		}
		if (!empty($username)){
			$_sql .= " and p2.username = '$username'";
		}
		if (!empty($status)){
			$_sql .= " and p1.status = '$status'";
		}
		
		$sql = "select SELECT from {limitapp} as p1 
				 left join {user} as p2 on p1.user_id=p2.user_id
				$_sql ORDER LIMIT";
				 
		
		$row = $mysql->db_fetch_array(str_replace(array('SELECT', 'ORDER', 'LIMIT'), array('count(1) as num', '', ''), $sql));
		
		$total = $row['num'];
		$total_page = ceil($total / $epage);
		$index = $epage * ($page - 1);
		$limit = " limit {$index}, {$epage}";
		
		$list = $mysql->db_fetch_arrays(str_replace(array('SELECT', 'ORDER', 'LIMIT'), array(' p1.*,p2.username ', 'order by p1.id desc', $limit), $sql));		
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
		$user_id = $data['user_id'];
		$id = $data['id'];
		$sql = "select p1.* ,p2.username,p2.realname from {limitapp} as p1 
				  left join {user} as p2 on p1.user_id=p2.user_id where p1.user_id=$user_id and p1.id=$id
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
       
		$sql = "insert into  {limitapp}  set `addtime` = '".time()."',`addip` = '".ip_address()."'";
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
	function Update($data = array()){
		global $mysql;
		$user_id = $data['user_id'];
        if ($data['user_id'] == "") {
            return self::ERROR;
        }
		
		$_sql = "";
		$sql = "update  {limitapp}  set ";
		foreach($data as $key => $value){
			$_sql[] .= "`$key` = '$value'";
		}
		$sql .= join(",",$_sql)." where user_id = '$user_id'";
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
		$sql = "delete from {limitapp}  where id in (".join(",",$id).")";
		return $mysql->db_query($sql);
	}
	
}
?>