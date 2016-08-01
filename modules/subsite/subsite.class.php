<?
/******************************
 * $File: user.class.php
 * $Description: ���ݿ⴦���ļ�
 * $Author: ahui 
 * $Time:2010-03-09
 * $Update:None 
 * $UpdateDate:None 
******************************/
//liukun add for bug 52 begin
$firePHPEnable=TRUE;
if ($firePHPEnable){
	require_once('modules/FirePHPCore/FirePHP.class.php');
	require_once('modules/FirePHPCore/fb.php');
	ob_start();

	$firephp = FirePHP::getInstance(true);
}
//liukun add for bug 52 end
class subsiteClass{
	
	const ERROR = '���������벻Ҫ�Ҳ���';
	
	//�Ƿ�װ
	function IsInstall(){
		global $mysql;
		$sql = "select 1 from {module} where code='subsite'";
		return $mysql->db_fetch_array($sql);
	}
	/**
	 * ����б�
	 *
	 * @return Array
	 */
	function GetList($data = array()){
		global $mysql;
		
		$pid = isset($data['pid'])?$data['pid']:"";
		$page = empty($data['page'])?1:$data['page'];
		$epage = empty($data['epage'])?10:$data['epage'];
		
		$_sql = " where 1=1  ";
		
		$_select = ' ss.* ';
		
		if(isset($data['subsite']) && $data['subsite']==1){
			$_sql .= " and subsite=1 ";
		}
		
		$sql = "select SELECT from  {subsite}  as ss 
				{$_sql}   ORDER LIMIT";
				
		//�Ƿ���ʾȫ������Ϣ
		if (isset($data['limit']) ){
			$_limit = "";
			if ($data['limit'] != "all"){
				$_limit = "  limit ".$data['limit'];
			}
			$_result =  $mysql->db_fetch_arrays(str_replace(array('SELECT', 'ORDER', 'LIMIT'), array($_select, ' order by `id` asc', $_limit), $sql));
			//liukun add for bug 52 begin
			fb($_result, FirePHP::TRACE);
			//liukun add for bug 52 end
			return $_result;
		}
		
		
		$row = $mysql->db_fetch_array(str_replace(array('SELECT', 'ORDER', 'LIMIT'), array('count(1) as num', '', ''), $sql));
		
		$total = $row['num'];
		$total_page = ceil($total / $epage);
		$index = $epage * ($page - 1);
		$limit = " limit {$index}, {$epage}";
		
		$list = $mysql->db_fetch_arrays(str_replace(array('SELECT', 'ORDER', 'LIMIT'), array($_select, 'order by `order` desc,`id` desc', $limit), $sql));		
		$list = $list?$list:array();
		
		return array(
            'list' => $list,
            'total' => $total,
            'page' => $page,
            'epage' => $epage,
            'total_page' => $total_page
        );
		
	}

		
	function GetSubsiteList($data = array()){
		global $mysql;
		$sql = "select * from  {subsite}  ";
		return $mysql->db_fetch_arrays($sql);
	}
	
	/**
	 * �鿴�û�
	 *
	 * @param Array $data
	 * @return Array
	 */
	public static function GetOne($data = array()){
		global $mysql;
		$id = $data['id'];
		if($id == "") return self::ERROR;
		$id = $data['id'];
		$sql = "select * from {subsite} where id=$id";
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

		
		$_sql = "";
		$sql = "insert into  {subsite}  set ";
		foreach($data as $key => $value){
			$_sql[] = "`$key` = '$value'";
		}
        $mysql->db_query($sql.join(",",$_sql));
    	$id = $mysql->db_insert_id();
		return true;
	}
	

		
	/**
	 * ���
	 *
	 * @param Array $data
	 * @return Boolen
	 */
	function Update($data = array()){
		
		global $mysql;

		$id = $data['id'];
		
		$sql = "update  {subsite}  set ";
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
	public static function Delete($data = array()){
		global $mysql;
		$id = $data['id'];
		if (!is_array($id)){
			$id = array($id);
		}
		
		$sql = "delete from {subsite}  where id in (".join(",",$id).")";
		$mysql->db_query($sql);
		return true;
	}
	

}
?>