<?php
/**********************************************
***  Author: Ahui
***  Date:2008/08/05  
***  Filename: channel php
***  Describe: channel file
**********************************************/

class Channel{
	var $db_link;//���ݿ�������Ϣ
	var $db_show_error;//�Ƿ񽫴�����Ϣ��ӡ����
	var $db_prefix;//���ݿ�ǰ׺��
	
	function Channel(){
		global $mysql;
		$this->mysql = $mysql;
		$this->ip = ip_address();
	}
	
	/**
	 * ��������ģ����Ӧ�ı�
	 *
	 * ID��ģ�����ƣ���ʶ����
	 * 
	 * @return Integer
	 */
	function create_channel_table(){ //��������ģ����Ӧ�ı�
		$sql = "CREATE TABLE IF NOT EXISTS   {channel}  (
			  `channel_id` int(11) unsigned NOT NULL auto_increment,
			  `name` varchar(255) NOT NULL,
			  `nid` varchar(255) NOT NULL,
			  `module_id` int(11) NOT NULL,
			  `status` varchar(2) NOT NULL,
			  `order` int(11) NOT NULL,
			  `addtime` varchar(50) NOT NULL,
			  `addip` varchar(50) NOT NULL,
			  PRIMARY KEY  (`channel_id`)
			) ENGINE=MyISAM ;";
		
		return $this->mysql->db_query($sql);
	}
	
	/**
	 * ��������ģ���ֶ���Ӧ�ı�
	 *
	 * ID����������ģ�ͣ����ƣ���ʶ�������ͣ���С��
	 * 
	 * @return Integer
	 */
	function create_fields_table(){ 
		$sql = "CREATE TABLE IF NOT EXISTS  {fields}  (
		  `fields_id` int(11) unsigned NOT NULL auto_increment,
		  `channel_id` varchar(50) NOT NULL,
		  `name` varchar(50) NOT NULL,
		  `code` varchar(50) NOT NULL,
		  `type` varchar(50) NOT NULL,
		  `size` varchar(50) NOT NULL,
		  `input` varchar(50) NOT NULL,
		  `description` varchar(255) NOT NULL,
		  `default` varchar(255) NOT NULL,
		  `select` varchar(100) NOT NULL,
		  `order` int(11) NOT NULL default '0',
		  PRIMARY KEY  (`fields_id`)
		) ENGINE=MyISAM ";
		return $this->mysql->db_query($sql);
	}
	
	
	/**
	 * ��������ģ����Ӧ�ı�
	 *
	 * @return Integer
	 */
	function create_table($table,$query=true){ //����վ����Ӧ�ı�
		$sql = "CREATE TABLE IF NOT EXISTS  {$table}  (
		      `article_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
			  `user_id` int(11) NOT NULL DEFAULT '0',
			  `title` varchar(255) NOT NULL DEFAULT '',
			  `status` int(2) NOT NULL DEFAULT '0',
			  `litpic` varchar(255) NOT NULL DEFAULT '',
			  `jumpurl` varchar(255) NOT NULL DEFAULT '',
			  `summary` varchar(255) NOT NULL DEFAULT '',
			  `content` text NOT NULL,
			  `order` int(11) NOT NULL DEFAULT '0',
			  `hits` int(11) NOT NULL DEFAULT '0',
			  `comment` int(11) NOT NULL DEFAULT '0',
			  `addtime` varchar(50) NOT NULL DEFAULT '',
			  `addip` varchar(50) NOT NULL DEFAULT '',
			  PRIMARY KEY (`article_id`)
			) ENGINE=MyISAM;";
		if ($query) return $this->mysql->db_query($sql);
		else return $sql;
	}
	
	
	/**
	 * ��������ģ����Ӧ�ı�
	 *
	 * @return Integer
	 */
	function create_type_table($table,$query=true){ //����վ����Ӧ�ı�
		$table = $table."_type";
		$query = "CREATE TABLE  {$table}  (
		  	`type_id` int(11) unsigned NOT NULL auto_increment,
		  	`name` varchar(100)  NOT NULL default '0',
			`summary` varchar(200)  NOT NULL default '0',
			`remark` varchar(200)  NOT NULL default '0',
		  	`status` int(2)  NOT NULL default '0',
		  	`order` int(10)  NOT NULL default '0',
		  	`user_id` int(11)  NOT NULL default '0' ,
		  	`addtime` varchar(50) NOT NULL DEFAULT '',
			`addip` varchar(50) NOT NULL DEFAULT '',
		  PRIMARY KEY  (`type_id`)
		) ENGINE=MyISAM  ;";
		
		if ($query) return $this->mysql->db_query($sql);
		else return $sql;
	}
	/**
	 * ɾ������ģ���ֶλ�����
	 *
	 * @return Integer
	 */
	function drop_table($table){
		$query = "DROP TABLE  {$table} ;";
		return $this->mysql->db_query($sql);
	}
	
	/**
	 * �������ģ��
	 *
	 * @param Array $var 
	 * @return Integer
	 */
	function add_channel($var){
		if ($var['name']=="" || $var['code']=="" )	return -1;
		$code = $var['code'];
		$module_id = $var['module_id'];
		
		$sql = "select * from  {channel}  where `code`='$code' ";
		if ($this->mysql->db_fetch_array($sql)!=false) return -2; //ģ�͵ı�ʶ���Ѿ�����
				
		//��ģ�ͱ������һ������
		$sql = "insert into  {channel}  set ";
		foreach ($var as $key => $value ){
			$_sql[] = "`$key` = '$value'";
		}
		$sql = join(",",$_sql).$sql;
		$sql .= "`addtime`='".time()."',`addip`='$this->ip'";
		
		$this->mysql->db_query($sql);
		
		//������Ӧ�ı�
		return $this->create_table($code);
		
	}
	
	
	/**
	 * �޸�����ģ��
	 *
	 * @param Integer $channel_id
	 * @param Array $var 
	 * @return Integer
	 */
	function update_channel($channel_id,$var){
		if ($channel_id=="")	return -1;
		$query = "update  {channel}  set ";
		foreach ($var as $key => $value ){
			$query .= "`$key` = '$value',";
		}
		$query .= "`channel_id` = '$channel_id' where `channel_id` = $channel_id";
		return $this->mysql->db_query($sql);
	}
	
	/**
	 * �޸�����
	 *
	 * @param Array $channel_id 
	 * @param Array $order 
	 * @return Integer
	 */
	function order_channel($channel_id,$order){
		if ($channel_id == "")	return -1;
		foreach ($channel_id as $key => $item){
			$query = "update {channel} set `order`=".$order[$key]." where channel_id=$item";
			$this->mysql->db_query($sql);
		}
		return true;
	}
	
	/**
	 * ɾ������ģ�ͣ�����һ��ɾ��ģ�ͱ����վ����ֶα�ģ�ͱ�������Ӧ������
	 *
	 * @param Integer $channel_id 
	 * @return Integer
	 */
	function del_channel($channel_id){
		if ($channel_id=="") return -1;
		$sql = "select * from {channel} where channel_id=$channel_id ;";
		$row = $this->mysql->db_fetch_array($sql);
		$result = $this->mysql->drop_table($row['code']);//ɾ��ģ����Ӧ�ı�
		if($result==false) return false;
		
		$sql = "delete  from  {channel}   where `channel_id` = $channel_id;";
		$this->mysql->db_fetch_array($sql);;
		
		$sql = "delete  from  {site}   where `channel_id` = $channel_id;";
		$this->mysql->db_fetch_array($sql);
		
		$sql = "delete  from  {fields}   where `channel_id` = $channel_id;";
		$this->mysql->db_fetch_array($sql);
		
		return true;
	}
	
	
	
	/**
	 * ��ȡ����ģ��
	 *
	 * @param Integer $channel_id 
	 * @return Array
	 */
	function view_channel($channel_id){
		if ($channel_id=="") return -1;
		$sql = "select * {channel} from where channel_id=$channel_id;";
		return $this->mysql->db_fetch_array($sql);
	}

	/**
	 * ��ȡ����ģ���б�
	 *
	 * @param Integer $channel_id 
	 * @return Array
	 */
	function list_channel(){
		$query = "select * from  {channel}  order by `order` desc,`channel_id` desc ";
		return $this->mysql->db_fetch_arrays($sql);
	}
	
	
	
	
	
	
	
	/**
	 * ����ֶ�
	 *
	 * @param Integer $fields_id 
	 * @return Array
	 */
	function add_fields($channel_id,$var){
		$notallow = array("name","order","url","type","article_id","id","litpic","content","summary","hits","type_id","user_id");
		if ($channel_id=="" || $index['code'] == "" || $index['name'] =="")	return -1;
		
		//����ʶ���Ƿ����
		$sql = "select * from {fields} where code='".$index['code']."' and channel_id='$channel_id' ";
		$result = $this->mysql->db_fetch_array($sql); 
		
		if ($result!=false || in_array($code,$notallow)){
			return -3; //һЩ��ֹ���ֶ�
		}
		
		//���ֶα����������
		$sql = "insert into  {fields}  set channel_id='$channel_id'";
		foreach ($var as $key => $value){
			$sql .= ",`$key`='$value'";
		}	
		$result = $this->mysql->db_query($sql); 
		
		$size = $var['size'];
		$type = $var['type'];
		if (!empty($size)){
			$field_size="($size)";
		}
		
		//�ж�����������ģ�͵Ļ�������ģ���
		
		$fields_table = "{cms_".$code."_fields}";
		$query = "CREATE TABLE IF NOT EXISTS  $fields_table (
		  `content_id` int(11) NOT NULL
		) ENGINE=MyISAM  DEFAULT CHARSET=$this->dbLanguage;";
		$result = $this->mysql->db_query($sql); 
		
		//����������ֶ�
		$query="alter table {$fields_table} add `".$code."`  ".$type.$field_size." NOT NULL ";
		return  $this->mysql->db_query($sql); 
	}
	
	
	
	/**
	 * �޸��ֶ�
	 *
	 * @param Integer $fields_id 
	 * @return Array
	 */
	function update_fields($fields_id,$channel_id,$var){
		if ($channel_id==""  || $var['name'] =="")	return -1;
		$code = $var['code'];
		
		//�޸��ֶα����������
		$sql = "update  {fields}  set channel_id='$channel_id'";
		foreach ($var as $key => $value){
			$query .= ",`$key`='$value'";
		}	
		$sql .= " where `fields_id` = $fields_id ";
		if($this->mysql->db_query($sql) ==false) return false;
		
		$size = $var['size'];
		$type = $var['type'];
		if (!empty($size)){
			$field_size="(".$size.")";
		}
		
		//�ж�����������ģ�͵Ļ�������ģ���
		
		$fields_table = "{cms_".$code."_fields}";
		
		$sql="alter table $fields_table change $code $code ".$type.$field_size." NOT NULL ";
		return $this->mysql->db_query($sql);
	}
	
	
	/**
	 * ɾ���ֶ�
	 *
	 * @param Integer $fields_id 
	 * @return Array
	 */
	function del_fields($fields_id,$channel_id,$code){
		if ($fields_id=="" || $channel_id=="" || $code=="")	return -1;
		$fields_table = "{cms_".$code."_fields}";
		$sql = "delete  from {fields}  where fields_id=$fields_id;";
		$this->mysql->db_query($sql);
		$sql = "alter table $fields_table drop $nid";
		$this->mysql->db_query($sql);
		return 1;
	}
	

	/**
	 * ��ȡ�ֶ��б�
	 *
	 * @param Integer $fields_id 
	 * @return Array
	 */
	function list_fields($channel_id){
		if ($channel_id == "") return -1;
		$query = "select * from  {fields}   where `channel_id` = '$channel_id' order by `order` desc,`fields_id` ";
		return $this->mysql->db_fetch_arrays($sql);
	}
	
	/**
	 * ��ȡ�ֶ�
	 *
	 * @param Integer $fields_id 
	 * @return Array
	 */
	function view_fields($fields_id){
		if ($fields_id=="") return -1;
		$query = "select * from  {fields}  where fields_id=$fields_id ";
		return $this->mysql->db_fetch_array($sql);;
	}
	
	
	/**
	 * �޸��ֶ�����
	 *
	 * @param Array $fields_id 
	 * @param Array $order 
	 * @return Integer
	 */
	function order_fields($fields_id,$order){
		if ($fields_id == "")  return -1;
		foreach ($fields_id as $key => $item){
			$sql = "update  {fields}  set `order`=".$order[$key]." where `fields_id` = $item";
			$this->mysql->db_query($sql);
		}
		return true;
	}
	
	
	function create_file_info($var){
		$content = '<?
		\$code = "'.$var['code'].'";
		\$name = "'.$var['name'].'";
		\$description = "'.$var['description'].'";
		\$version = "'.$var['version'].'";
		\$author = "'.$var['author'].'";
		\$date = "'.$var['date'].'";
		?>';
		mk_file("modules/".$var['code']."/".$var['code'].".info",$content);
	}
	
	function create_file_sql($code){
		$content = $this->create_table($code,false);
		$content .= "\n\n\n\n".$this->create_type_table($code,false);
		mk_file("modules/".$var['code']."/".$var['code'].".sql",$content);
	}
	
	function create_file_index($code){
		$content = $this->create_table($code,false);
		$content .= "\n\n\n\n".$this->create_type_table($code,false);
		mk_file("modules/".$var['code']."/".$var['code'].".sql",$content);
	}
	
	function create_file_tpl($code){
		$content = $this->create_table($code,false);
		$content .= "\n\n\n\n".$this->create_type_table($code,false);
		mk_file("modules/".$var['code']."/".$var['code'].".sql",$content);
	}
	
	function create_file_class($code){
		$content = $this->create_table($code,false);
		$content .= "\n\n\n\n".$this->create_type_table($code,false);
		mk_file("modules/".$var['code']."/".$var['code'].".sql",$content);
	}
}
?>
