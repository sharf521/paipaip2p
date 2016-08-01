<?
/******************************
 * $File: sort.class.php
 * $Description: ֤��
 * $Author: ahui 
 * $Time:2010-08-09
 * $Update:None 
 * $UpdateDate:None 
******************************/
class sortClass{
	
	const ERROR = '���������벻Ҫ�Ҳ���';
	const sort_NAME_NO_EMPTY = '��֤���Ʋ���Ϊ��';

	/**
	 * ����б�
	 *
	 * @return Array
	 */
	function GetList($data = array()){
		global $mysql;
		
		$name = $data['name'];
		$nopid = $data['nopid'];
		$page = empty($data['page'])?1:$data['page'];
		$epage = empty($data['epage'])?10:$data['epage'];
		
		$_sql = " where 1=1 ";
		if ($name!=""){
			$_sql .= " and p1.`name` like '%$name%'";
		}
		if ($nopid!=""){
			$_sql .= " and p1.`pid` != $nopid and p1.id!=$nopid ";
		}
		
		$sql = "select SELECT from {sort} as p1 {$_sql}   ORDER LIMIT";
		
		//�Ƿ���ʾȫ������Ϣ
		if (isset($data['limit']) ){
			$_limit = "";
			if ($data['limit'] != "all"){
				$_limit = " where limit ".$data['limit'];
			}
			return $mysql->db_fetch_arrays(str_replace(array('SELECT', 'ORDER', 'LIMIT'), array(' * ', 'order by p1.`order` desc,p1.`id` desc', $_limit), $sql));
		}
		
		$row = $mysql->db_fetch_array(str_replace(array('SELECT', 'ORDER', 'LIMIT'), array('count(1) as num', '', ''), $sql));
		
		$total = $row['num'];
		$total_page = ceil($total / $epage);
		$index = $epage * ($page - 1);
		$limit = " limit {$index}, {$epage}";
		
		$list = $mysql->db_fetch_arrays(str_replace(array('SELECT', 'ORDER', 'LIMIT'), array(' p1.*', 'order by p1.`order` desc,p1.`id` desc', $limit), $sql));		
		$list = $list?$list:array();
		$flag_list = $data['flag_list'];
		if (count($list)>0){
			$data_flag['result'] = $data['flag_list'];
			foreach ($list as $key => $value){
				$data_flag['flag'] = $value['flag'];
				$list[$key]['flagname'] = getFlagName($data_flag);
			}
		}
		
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
		$fields = $data['fields'];
		if($id == "") return self::ERROR;
		if ($fields == 1){
			$sql = "select * from {sort} as p1 left join {sort_fields} as p2 on p1.id=p2.aid where p1.id=$id";
		}else{
			$sql = "select * from {sort} where id=$id";
		}
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
        if ($data['name'] == "" ) {
            return self::sort_NAME_NO_EMPTY;
        }
		$sql = "insert into  {sort}  set `addtime` = '".time()."',`addip` = '".ip_address()."'";
		
		foreach($data as $key => $value){
			$sql .= ",`$key` = '$value'";
		}
        $mysql->db_query($sql);
    	return $mysql->db_insert_id();
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
        if ($data['name'] == ""  || $data['id'] == "") {
            return self::ERROR;
        }
		$sql = "update  {sort}  set ";
		$_sql = "";
		foreach($data as $key => $value){
			$_sql[] .= "`$key` = '$value'";
		}
		$sql .= join(",",$_sql)." where id = '$id'";
        $result = $mysql->db_query($sql);
		if ($result == false) return self::ERROR;
		return true;
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
		$sql = "delete from {sort}  where id in (".join(",",$id).")";
		$mysql->db_query($sql);
		return true;
	}
	
	
	/**
	 * �б�
	 *
	 * @param Array $data
	 * @return Array
	 */
	public static function GetAgencyList($data = array()){
		global $mysql;
		
		$name = $data['name'];
		$page = empty($data['page'])?1:$data['page'];
		$epage = empty($data['epage'])?10:$data['epage'];
		
		$_sql = " where 1=1 ";
		if ($name!=""){
			$_sql .= " and p1.`name` like '%$name%'";
		}
		
		$sql = "select SELECT from {sort_agency} as p1 {$_sql}   ORDER ";
		$row = $mysql->db_fetch_array(str_replace(array('SELECT', 'ORDER', 'LIMIT'), array('count(1) as num', '', ''), $sql));
		
		$total = $row['num'];
		$total_page = ceil($total / $epage);
		$index = $epage * ($page - 1);
		$limit = " limit {$index}, {$epage}";
		
		$list = $mysql->db_fetch_arrays(str_replace(array('SELECT', 'ORDER', 'LIMIT'), array(' * ', 'order by p1.`order` desc,p1.`id` desc', $limit), $sql));		
		$list = $list?$list:array();
		
		if (isset($data['limit']) ){
			$limit = "";
			if ($limit != "all"){
				$limit = " where limit ".$data['limit'];
			}
			return $mysql->db_fetch_arrays(str_replace(array('SELECT', 'ORDER', 'LIMIT'), array(' * ', 'order by p1.`order` desc,p1.`id` desc', $limit), $sql));
		}
		
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
	public static function GetAgencyOne($data = array()){
		global $mysql;
		$id = $data['id'];
		if($id == "") return self::ERROR;
		$sql = "select * from {sort_agency} where id=$id";
		$result = $mysql->db_fetch_array($sql);
		if ($result == false) return self::ERROR;
		return $result;
	}
	
	/**
	 * ���
	 *
	 * @param Array $data
	 * @return Boolen
	 */
	function AddAgency($data = array()){
		global $mysql;
        if ($data['name'] == ""  ) {
            return self::ERROR;
        }
		
		$_sql = "";
		$sql = "insert into  {sort_agency}  set ";
		foreach($data as $key => $value){
			$_sql[] .= "`$key` = '$value'";
		}
		$sql .= join(",",$_sql)." ";
        $mysql->db_query($sql);
		return true;
	}
	
	
	/**
	 * �޸�
	 *
	 * @param Array $data
	 * @return Boolen
	 */
	public static function UpdateAgency($data = array()){
		global $mysql;
        if ($data['name'] == ""  || $data['id'] == "") {
            return self::ERROR;
        }
		$id = $data['id'];
		
		$sql = "update  {sort_agency}  set ";
		$_sql = "";
		foreach($data as $key => $value){
			$_sql[] .= "`$key` = '$value'";
		}
		$sql .= join(",",$_sql)." where id = '$id'";
        $mysql->db_query($sql);
		return true;
	}
	
	/**
	 * ɾ��
	 *
	 * @param Array $data
	 * @return Boolen
	 */
	public static function DeleteAgency($data = array()){
		global $mysql;
		$id = $data['id'];
		if (!is_array($id)){
			$id = array($id);
		}
		$sql = "delete from {sort_agency}  where id in (".join(",",$id).")";
		$mysql->db_query($sql);
		return true;
	}
	
}
?>