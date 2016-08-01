<?php
/******************************
 * $File: system.class.php
 * $Description: ģ���ദ���ļ�
 * $Author: ahui 
 * $Time:2010-03-09
 * $Update:None 
******************************/

class systemClass {
	const ERROR = '���������������Ա��ϵ';
	const SYSTEM_ADD_NO_CON = '���������� con_ ��ͷ��';
	const SYSTEM_NID_IS_EXIST = '��ʶID�Ѿ�����';
	
	/**
	 * ������ݱ�
	 * 
	 * @return Array
	 */
	function GetSystemTables($data = array()){
		global $mysql;
		$_result = "";
		$sql = "show tables";
		$result = $mysql->db_fetch_arrays($sql);
		foreach ($result as $key => $value){
			foreach($value as $val){
				$_val = explode("_",$val);
				if($mysql->db_prefix!="" && $_val[0]."_"==$mysql->db_prefix){
					$num = $mysql->db_count(str_replace($mysql->db_prefix,"",$val));
					$_result[$key]['name'] = $val;
					$_result[$key]['num'] = $num;
				}else{
					$num = $mysql->db_count($val);
					$_result[$key]['name'] = $val;
					$_result[$key]['num'] = $num;
				}
			}
		}
		return  $_result;
	
	}
	
	
	/**
	 * �������ݱ�
	 * 
	 * @return Array
	 */
	public static  function BackupTables($data = array() ){
		global $mysql;
		$filedir = $data['filedir'];
		$tables = $data['table'];
		$size = $data['size'];
		$tid = $data['tid'];//��ȡ�ĸ���
		$limit = $data['limit'];//���ȡ���Ǽ���
		$table_page = $data['table_page'];//�ļ��ķ�ҳ
		$table = $tables[$tid];
		if ($tables == "") return self::ERROR;
		
		/*
		 *���ݱ�ṹ
		*/
		if ($tid==0){
			$sql = "";
			$filename = $filedir."/show_table.sql";
			foreach ($tables as $key => $tbl){
				//$sql .="# ���ݱ�".$tbl."���Ľṹ;\r\n";	
				$sql .="DROP TABLE IF EXISTS `$tbl`;\r\n";//�������ھ�ɾ�����ڵı�
				$_sql = "show create table $tbl";
				$result = $mysql->db_fetch_array($_sql);
				$sql .= $result['Create Table'].";\r\n\r\n";
				mk_file($filename,$sql);
			}
		}
		
		if ($table != ""){
			$file = $filedir."/".$table."_".$table_page.".sql";
			$text = read_file($file);
			if (strlen($text) > $size * 1024) {
				 $file = $filedir."/".$table."_".($table_page+1).".sql";
				 $text = read_file($file);
			}
			/*
			 *��ȡ��������ֶ�
			*/
			$fields = $mysql->db_show_fields(str_replace($mysql->db_prefix,"",$table));
			$_fields = join(",",$fields);
			
			$sql = "select *  from `$table` limit $limit,100";
			
			$result= $mysql->db_fetch_arrays($sql)  ; 
			if (count($result)>0){
				foreach ($result as $key => $value){
					$text .= "insert into `$table` ( ";
					foreach ($fields as $fkey => $fvalue){
						$_value[$fkey] ="\"".mysql_escape_string($value[$fvalue])."\"";
						$_fie[$fkey] ="`$fvalue`";
					}
					$text .= join(",",$_fie).") values (".join(",",$_value).");\r\n\r\n";
					$limit++;
				}
				mk_file($file,$text);
				$data['limit'] = $limit;
				$data['table_page'] = $table_page;
				$data['tid'] = $tid;
			}else{
				$data['limit'] = 0;
				$data['table_page'] = 0;
				$data['tid'] = $tid+1;
			}
			return $data;
		}
		return "";
	}
	
	/**
	 * �������ݱ�
	 * 
	 * @return Array
	 */
	public static function RevertTables($data = array() ){
		global $mysql;
		
		$tables = $data['table'];
		$nameid = $data['nameid'];
		if (isset($tables[$nameid]) && $tables[$nameid]!=""){
			$value = $tables[$nameid];
			if ($value!="show_table.sql"){
				$sql = file_get_contents($data['filedir']."/".$value);
				$_sql = explode("\r\n",$sql);
				foreach ($_sql as $val){
					if ($val!=""){
						$mysql->db_query($val,"true");
					}
				}
			}
			return $value;
		}else{
			return "";
		}
	}
	
	
	/**
	 * �޸�ϵͳ��Ϣ
	 * 
	 * @return Array
	 */
	function  ActionSystem($data = array()){
		global $mysql;
		$class = $data["class"];
		$style = $data["style"];
		if ($class == "list"){
			//liukun add for bug 504 begin
// 			$sql = "select * from {system} where `style` = '$style' ";
			//�����Ӿɵ������� 
			$sql = "select * from {system} where `style` = '$style' order by id asc ";
			//liukun add for bug 504 end
				
			return $mysql->db_fetch_arrays($sql);
		}
		
		elseif ($class == "view"){
			$id = $data["id"];
			$sql = "select * from {system} where `style` = '$style' and `id` = '$id'";
			return $mysql->db_fetch_array($sql);
		}
		
		elseif ($class == "add"){
			unset($data['class']);
			if (!ereg ("^con_", $data['nid'])){
				return self::SYSTEM_ADD_NO_CON;
			}
			$_sql = "";
			$sql = "select * from {system} where nid = '".$data['nid']."'";
			$result = $mysql -> db_fetch_array($sql);
			if ($result!=false) return  self::SYSTEM_NID_IS_EXIST;
			$sql = "insert into  {system}  set ";
			foreach($data as $key => $value){
				$_sql[] = "`$key` = '$value'";
			}
			$result =  $mysql->db_query($sql.join(",",$_sql));
			if ($result == false) return self::ERROR;
			return true;
		}
		
		elseif ($class == "update"){
			unset($data['class']);
			if (!ereg ("^con_", $data['nid'])){
				return self::SYSTEM_ADD_NO_CON;
			}
			
			$sql = "select * from {system} where nid = '".$data['nid']."' and id !=".$data['id'];
			$result = $mysql -> db_fetch_array($sql);
			if ($result!=false) return  self::SYSTEM_NID_IS_EXIST;
			
			$_sql = "";
			$sql = "update  {system}  set ";
			foreach($data as $key => $value){
				$_sql[] = "`$key` = '$value'";
			}
			$result =  $mysql->db_query($sql.join(",",$_sql)." where id = '".$data['id']."'");
			if ($result == false) return self::ERROR;else return true;
			
		}
		
		elseif ($class == "action"){
			foreach ($data['value'] as $key =>$val){
				$val = nl2br($val);
				$sql  = "update {system} set `value` = '{$val}' where `nid` = '$key'";
				$mysql->db_query($sql);
			}
			return self::ERROR;
		}
	}
	
	/**
	 * �������ݱ�
	 * 
	 * @return Array
	 */
	function  GetRemindList($data = array()){
		$id = $data["id"];
			$sql = "select * from  {remind}  where `style` = '$style' and `id` = '$id'";
			return $mysql->db_fetch_array($sql);
	
	}
	
	//��վ�Ļ�����Ϣ
	public static function GetCacheOne($data=array()){
		global $mysql;
		if (isset($data['date'])){
			$date = $data['date'];
		}else{
			$date = date("Y-m-d",time());
		}
		$sql = "select * from  {cache}  where date ='{$date}'";
		$result = $mysql->db_fetch_array($sql);
		if ($result==false){
			//��ȡ�û�����
			$sql = "select count(*) as num from  {user}  ";
			$result = $mysql->db_fetch_array($sql);
			$user_num =  ($result!=false)?$result['num']:0;
			
			//���ע��Ļ�Ա
			$sql = "select username from  {user}  order by user_id desc";
			$result = $mysql->db_fetch_array($sql);
			$last_user =  ($result!=false)?$result['username']:0;
			
			//���뻺��
			$sql = "insert into  {cache}  set `last_user` = '{$last_user}',`user_num`='$user_num',`date` = '{$date}' ";
			$mysql->db_query($sql);
			
			//���»�ȡ
			$sql = "select * from  {cache}  where date ='{$date}'";
			$result = $mysql->db_fetch_array($sql);
		}
		return $result;
		
	}
	
		//��վ�Ļ�����Ϣ
	public static function Online($data=array()){
		global $mysql,$_G;
		
		//��ɾ��5�����ڵ����߼�¼
		$time = time() - 60*5;
		$sql = "delete from  {online}  where activetime<$time";
		$mysql->db_query($sql);
		
		//�ж��û�id��Ϊ��
		if (isset($data['user_id']) && $data['user_id']!=""){
			//�����û����߱�var_dump($data);
			$sql = "select 1 from  {online}  where  user_id = '{$data['user_id']}'";
			$result = $mysql -> db_fetch_array($sql);
			if($result==false){
				$sql = " select * from  {user} where user_id = '{$data['user_id']}'";
				$result = $mysql -> db_fetch_array($sql);
				if ($result!=false){
				$sql = " insert into  {online}  set user_id='{$result['user_id']}',type_id='{$result['type_id']}',username='{$result['username']}',ip='".ip_address()."',activetime='".time()."'";
				$result = $mysql->db_query($sql);
				}
				
			}
		}else{
			//������ο����ȡip�ж�
			$sql = "select 1 from  {online}  where  ip = '".ip_address()."'";
			$result = $mysql -> db_fetch_array($sql);
			if($result==false){
				$sql = " insert into  {online}  set user_id=0,type_id='',username='',activetime='".time()."',ip='".ip_address()."'";
				$mysql->db_query($sql);
			}
		}
		$sql = "select * from  {online}  ";
		$result = $mysql -> db_fetch_arrays($sql);
		$num =0 ;
		$user_num =0 ;
		$no_user_num =0 ;
		foreach ($result as $key => $value){
			if ($value['user_id']==0){
				$no_user_num++;
			}else{
				$user_num++;
			}
			$num++;
		}
		
		if  ($_G['cache']['user_online_num']<$num){
			$sql = "update  {cache}  set user_online_num='{$num}',user_online_time='".time()."' where date='".date("Y-m-d",time())."'";
			$mysql->db_query($sql);
		}
		return array("num"=>$num,"user_num"=>$user_num,"nouser_num"=>$no_user_num,"list"=>$result);
	}
	
	/**
	 * ����û��ļ�¼
	 * 
	 * @return Array
	 */
	function GetUserLog($data = array()){
		global $mysql,$_G;
		$_sql = " where 1=1 ";
		if (isset($data['username']) && $data['username']!=""){
			$_sql .= " and p2.username like '%{$data['username']}%'";
		}
		if (isset($data['quer']) && $data['quer']!=""){
			$_sql .= " and p1.query like '%{$data['quer']}%'";
		}
		$page = empty($data['page'])?1:$data['page'];
		$epage = empty($data['epage'])?10:$data['epage'];
		
		$_select = "p1.*,p2.username,p2.realname";
		$sql = "select SELECT from  {user_log}  as p1 left join  {user}  as p2 on p1.user_id=p2.user_id {$_sql} ORDER LIMIT";
		
		$row = $mysql->db_fetch_array(str_replace(array('SELECT', 'ORDER', 'LIMIT'), array('count(1) as num', '', ''), $sql));
		
		$total = $row['num'];
		$total_page = ceil($total / $epage);
		$index = $epage * ($page - 1);
		$limit = " limit {$index}, {$epage}";
		
		$list = $mysql->db_fetch_arrays(str_replace(array('SELECT', 'ORDER', 'LIMIT'), array($_select, 'order by p1.addtime desc', $limit), $sql));		
		return array(
            'list' => $list,
            'total' => $total,
            'page' => $page,
            'epage' => $epage,
            'total_page' => $total_page
        );
	}
	
	
	
	/**
	 * ���ͼƬ
	 * 
	 * @return Array
	 */
	function GetUpfiles($data = array()){
		global $mysql,$_G;
		$_sql = " where 1=1 ";
		if (isset($data['username']) && $data['username']!=""){
			$_sql .= " and p2.username like '%{$data['username']}%'";
		}
		if (isset($data['quer']) && $data['quer']!=""){
			$_sql .= " and p1.query like '%{$data['quer']}%'";
		}
		$page = empty($data['page'])?1:$data['page'];
		$epage = empty($data['epage'])?10:$data['epage'];
		
		$_select = "p1.*,p2.username,p2.realname,p3.name as codename";
		$sql = "select SELECT from  {upfiles}  as p1 left join  {user}  as p2 on p1.user_id=p2.user_id left join  {module}  as p3 on p1.code=p3.code {$_sql} ORDER LIMIT";
		
		$row = $mysql->db_fetch_array(str_replace(array('SELECT', 'ORDER', 'LIMIT'), array('count(1) as num', '', ''), $sql));
		
		$total = $row['num'];
		$total_page = ceil($total / $epage);
		$index = $epage * ($page - 1);
		$limit = " limit {$index}, {$epage}";
		
		$list = $mysql->db_fetch_arrays(str_replace(array('SELECT', 'ORDER', 'LIMIT'), array($_select, 'order by p1.addtime desc', $limit), $sql));		
		return array(
            'list' => $list,
            'total' => $total,
            'page' => $page,
            'epage' => $epage,
            'total_page' => $total_page
        );
	}
	
	
	/**
	 * ���ͼƬ
	 * 
	 * @return Array
	 */
	function GetUserCache($data = array()){
		global $mysql,$_G;
		$_sql = " where 1=1 ";
		if (isset($data['username']) && $data['username']!=""){
			$_sql .= " and p2.username like '%{$data['username']}%'";
		}
		if (isset($data['quer']) && $data['quer']!=""){
			$_sql .= " and p1.query like '%{$data['quer']}%'";
		}
		$page = empty($data['page'])?1:$data['page'];
		$epage = empty($data['epage'])?10:$data['epage'];
		
		$_select = "p1.*,p2.username,p2.realname,p3.name as codename";
		$sql = "select SELECT from  {upfiles}  as p1 left join  {user}  as p2 on p1.user_id=p2.user_id left join  {module}  as p3 on p1.code=p3.code {$_sql} ORDER LIMIT";
		
		$row = $mysql->db_fetch_array(str_replace(array('SELECT', 'ORDER', 'LIMIT'), array('count(1) as num', '', ''), $sql));
		
		$total = $row['num'];
		$total_page = ceil($total / $epage);
		$index = $epage * ($page - 1);
		$limit = " limit {$index}, {$epage}";
		
		$list = $mysql->db_fetch_arrays(str_replace(array('SELECT', 'ORDER', 'LIMIT'), array($_select, 'order by p1.addtime desc', $limit), $sql));		
		return array(
            'list' => $list,
            'total' => $total,
            'page' => $page,
            'epage' => $epage,
            'total_page' => $total_page
        );
	}
}
?>
