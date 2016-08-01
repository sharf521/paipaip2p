<?php
/**
 * @author Tissot.Cai(Email:Tissot.Cai@gmail.com)
 * @version 1.0
 */

class dynacontentClass {

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
		if (isset($data['logo'])){
			if ($data['logo']=="true"){
				$_sql .= " and p1.logoimg!=''";
			}else{
				$_sql .= " and p1.logoimg=''";
			}
		}
		
		if (isset($data['type']) && $data['type']!=""){
			
				$_sql .= " and p1.type_id= {$data['type']} ";
			
		}
		
		//liukun add for site_id search begin
		if (isset($data['areaid']) && $data['areaid']!="0"){
			$_sql .= " and p1.areaid = {$data['areaid']} ";
		}
		//liukun add for biao_type search begin
		
		if (isset($data['subsite'])){
			$_sql .= " and p1.areaid={$data['subsite']}";
		}
		
		$_select = 'p1.*,p2.typename,p3.sitename  ';
		$sql = "select SELECT from  {dynacontent}  as p1 
				left join {dynacontent_type} as p2 on p1.type_id= p2.id
				left join {subsite} as p3 on p1.areaid = p3.id
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
		
		$sql = "select p1.* from {dynacontent} as p1 where p1.id=$id ";
		return $mysql->db_fetch_array($sql);
	}
	
	
	/**
	 * 查看
	 *
	 * @param Array $data
	 * @return Array
	 */
	public static function GetOneBytype($data = array()){
		global $mysql;
		$areaid = $data['areaid'];
		$type_id = $data['type_id'];
		
	
		$sql = "select p1.* from {dynacontent} as p1 where p1.type_id={$type_id} and areaid={$areaid} order by id desc limit 1";
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
		
		$sql = "insert into  {dynacontent}  set `addtime` = '".time()."',`addip` = '".ip_address()."'";
		foreach($data as $key => $value){
			$sql .= ",`$key` = '$value'";
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
		$sql = "update  {dynacontent}  set ";
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
		$sql = "delete from  {dynacontent}   where id in (".join(",",$id).")";
		return $mysql->db_query($sql);
	}
	
	
	/**
	 * 类型列表
	 *
	 * @return Array
	 */
	function GetTypeList($data = array()){
		global $mysql;
		$sql = "select * from  {dynacontent_type}  ";
		return $mysql->db_fetch_arrays($sql);	
	}
	
	/**
	 * 类型列表
	 *
	 * @return Array
	 */
	function GetTypeOne($data = array()){
		global $mysql;
		$sql = "select * from  {dynacontent_type}   where id='{$data['id']}'";
		return $mysql->db_fetch_array($sql);	
	}
}
?>
