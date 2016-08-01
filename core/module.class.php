<?php
/******************************
 * $File: module.class.php
 * $Description: ģ���ദ���ļ�
 * $Author: ahui 
 * $Time:2010-03-09
 * $Update:None 
******************************/

class moduleClass {
	const ERROR = '���������������Ա��ϵ';
	const MODULE_NAME_NO_EMPTY = 'ģ�����Ʋ���Ϊ��';
	const MODULE_CODE_NO_EMPTY = 'ģ���ʶ������Ϊ��';
	const MODULE_INSTALL_YES = '��ģ���Ѿ���װ';
	const MODULE_PURVIEW_NO_EMPTY = 'ģ���Ȩ�ޱ�����д';
	const FIELDS_NAME_NO_ALLOW = '�ֶν�ֹ�ı�ʶ�����ֶ��Ѿ�����';
	const FIELDS_TYPE_NO_SYSTEM = 'ϵͳģ���ֹ���ֶ�';
	const FIELDS_UPDATE_ERROR = '�ֶθ��´����������Ա��ϵ';
	//���ģ����б�
	public static function  GetList($data = array()){
		global $mysql;
		
		//�Ѱ�װ��ģ��
		$sql = "select * from  {module}  order by `order` desc ";
		$module_list = $mysql->db_fetch_arrays($sql);
		
		//ģ�������е�ģ��
		$module_file = get_file("modules");
		
		
		//���Ѱ�װ��ģ����д���
		$_module_list = array();
		if ($module_list!=false){
			foreach ($module_list as $key => $value){
				$_module_list[] = $value['code'];
			}
		}
		
		$result = "";
		$type = isset($data['type'])?$data['type']:"";
		if ($type == ""){
			foreach($module_file as $code){
				if (file_exists("modules/$code/".$code.".info")){
					$url = "modules/$code/".$code.".info";
					include $url;
					$status = in_array($code,$_module_list)?1:0;
					$result[] = array_merge(get_module_info($code),array("status"=>$status,"code"=>$code));
				}
			}
			return $result;
		}elseif($type == "install"){
			return $module_list;
		}elseif($type == "unstall"){
			foreach($module_file as $code){
				if (file_exists("modules/$code/".$code.".info")){
					$url = "modules/$code/".$code.".info";
					include $url;
					if (!in_array($code,$_module_list)){
						$result[] = array_merge(get_module_info($code),array("code"=>$code));
					}
				}
			}
			return $result;
		}
	
	}
	
	//���ģ����б�
	public static function  GetOne($data = array()){
		global $mysql;
		
		$code = isset($data['code'])?$data['code']:"";
		if (empty($code)) return false;
		
		//�Ѱ�װ��ģ��
		$sql = "select * from  {module}  where code = '{$code}' ";
		return  $mysql->db_fetch_array($sql);
	
	}
	
	/**
	 * �޸��ֶ�����
	 *
	 * @param Array $fields_id 
	 * @param Array $order 
	 * @return Integer
	 */
	public static function OrderModule($module_id,$order){
		global $mysql;
		if ($module_id == "")  return -1;
		foreach ($module_id as $key => $item){
			$sql = "update  {module}  set `order`=".$order[$key]." where `module_id` = $item";
			$mysql->db_query($sql);
		}
		return true;
	}
	
	
	/**
	 * �޸��ֶ�����
	 *
	 * @param Array $fields_id 
	 * @param Array $order 
	 * @return Integer
	 */
	public static function UpdateModule($data){
		global $mysql;
		if (!isset($data['name']) || $data['name'] == "") return self::MODULE_NAME_NO_EMPTY;
		if (!isset($data['code']) || $data['code'] == "") return self::MODULE_CODE_NO_EMPTY;
		$code = $data['code'];
		
		$sql = "update  {module}  set ";
		foreach ($data as $key => $value){
			$_sql[] = "`$key`='$value'";
		}
		$sql .= join(",",$_sql);
		$sql .= " where code = '$code'";
		return  $mysql->db_query($sql);
	}
	
	
	/**
	 * �޸��ֶ�����
	 *
	 * @param Array $fields_id 
	 * @param Array $order 
	 * @return Integer
	 */
	public static function AddModule($data){
		global $mysql;
		$code = $data['code'];
		//�½�һ��������ģ��
		if (empty($code)){
			return slef::MODULE_CODE_NO_EMPTY;
		}else{
			
			//���ģ���Ƿ�װ
			$sql = "select * from  {module}  where code='$code'";
			$result = $mysql->db_fetch_array($sql);
			if($result !=false) return self::MODULE_INSTALL_YES;
			
			
			//ִ�����ݱ�
			$sql = file_get_contents(ROOT_PATH."modules/{$code}/{$code}.sql");
			$mysql->db_querys($sql);
			//ִ������
			if (file_exists(ROOT_PATH."modules/{$code}/data.php")){
				$sql = file_get_contents(ROOT_PATH."modules/{$code}/data.sql");
				$mysql->db_querys($sql);
			}
			
			//��ȡȨ��
			
			$_A['query_type'] = $_A['query_url'] = $_A['module_result']['name'] = $_A['site_url'] = "";
			include_once(ROOT_PATH."modules/{$code}/{$code}.php");
			$data['purview'] = serialize($_A['list_purview']);
			
			
			//����ģ���
			$sql = "insert into   {module}  set ";
			foreach ($data as $key => $value){
				$_sql[] = "`$key`='$value'";
			}
			$sql .= join(",",$_sql);
			$sql .= ",`addtime`='".time()."',`addip`='".ip_address()."'";
			return $mysql->db_query($sql);
		}
		
	}
	
	
	/**
	 * ж��ģ��
	 */
	function DeleteModule($data = array()){
		global $mysql;
		$code = $data['code'];
		if (empty($code)) return self::ERROR;
		
		$sql = "delete from {module} where code='$code' and type!='system'";
		$mysql->db_query($sql);
		
		$sql = "delete from {fields} where code='$code' ";
		$mysql->db_query($sql);
		
		$sql = "drop table IF  EXISTS  {".$code."} , {".$code."_type} , {".$code."_fields} ";
		$mysql->db_query($sql);
		
		if (isset( $data['table'] ) && $data['table'] != ""){
			$result = explode(",",$data['table']);
			foreach ($result as $val){
				if ($val !=""){
					$mysql->db_query("drop table IF  EXISTS  {".$val."} ");
				}
			}
		}
		return true;
		
	}
	
	//���ģ���ֶε��б�
	public static function  GetFieldsList($data = array()){
		global $mysql;
		
		//�Ѱ�װ��ģ��
		$code = $data['code'];
		if (empty($code)) return self::MODULE_NAME_NO_EMPTY;
		
		$sql = "select * from  {fields}  where code = '$code' order by `order` desc ";
		$result = $mysql->db_fetch_arrays($sql);
		return $result;
	}
	
	
	//���ģ����б�
	public static function  GetFieldsOne($data = array()){
		global $mysql;
		
		$code = isset($data['code'])?$data['code']:"";
		$fields_id = isset($data['fields_id'])?$data['fields_id']:"";
		if (empty($code)) return self::MODULE_NAME_NO_EMPTY;
		
		//�Ѱ�װ��ģ��
		$sql = "select * from  {fields}  where code = '{$code}' and fields_id={$fields_id} ";
		return  $mysql->db_fetch_array($sql);
	
	}
	
	/**
	 * ��ȡ�ֶ��б�
	 *
	 * @param Integer $fields_id 
	 * @return Array
	 */
	function GetFieldsInput($data = array()){
		global $mysql;
		$code = $data['code'];
		$result = $data['result'];
		if ($code == "") return self::ERROR;
		$input = array();
		$sql = "select * from  {fields}  where code = '$code' order by `order` desc ";
		$fields = $mysql->db_fetch_arrays($sql);
		if (is_array($fields)){
			for($i=0;$i<count($fields);$i++){
				$nid = $fields[$i]['nid'];
				if ($nid!=""){
					$fun = "input_".$fields[$i]['input'];
					if ($result != ""){
						$_default = $result[$nid];
					}else{
						$_default = $fields[$i]['default'];
					}
					$input[$i] = array($fields[$i]['name'],$fun($nid,$_default,$fields[$i]['select']));	
				}
			}
		}
		return $input;
	}
	
	
	/**
	 * ����ֶ�
	 *
	 * @param Integer $fields_id 
	 * @return Array
	 */
	public static function AddFields($data = array()){
		global $mysql;
		if (!isset($data['name']) || $data['name'] == "") return self::MODULE_NAME_NO_EMPTY;
		if (!isset($data['code']) || $data['code'] == "") return self::MODULE_CODE_NO_EMPTY;
		
		$code = $data['code'];
		$notallow = array("name","order","url","type","id","id","litpic","content","summary","hits","type_id","user_id");
		
		//����ʶ���Ƿ����
		$sql = "select * from {fields} where code='$code' and nid='".$data['nid']."' ";
		$result = $mysql->db_fetch_array($sql); 
		if ($result!=false || in_array($data['nid'],$notallow)){
			return self::FIELDS_NAME_NO_ALLOW; //һЩ��ֹ���ֶ�
		}
		
		//����Ƿ���ϵͳģ��
		$sql = "select * from {module} where code='$code' ";
		$result = $mysql->db_fetch_array($sql); 
		if ($result['type'] == "system" && $code !="user"){
			return self::FIELDS_TYPE_NO_SYSTEM; //ϵͳģ�鲻�ܼ��ֶ�
		}
		
		
		//���ֶα����������
		$_sql = array();
		$sql = "insert into  {fields}  set ";
		foreach ($data as $key => $value){
			$_sql[] = "`$key`='$value'";
		}	
		$sql .= join(",",$_sql);
		$result = $mysql->db_query($sql); 
		
		if ($data['type']=="varchar" || $data['type']=="int"){
			$data['size'] = 255;
		}
		$size = $data['size'];
		$type = $data['type'];
		$field_size = "";
		if (!empty($size)){
			$field_size="($size)";
		}
		
		//�ж�����������ģ�͵Ļ�������ģ���
		$fields_table = $code."_fields";
		
		$sql = "CREATE TABLE IF NOT EXISTS   {".$fields_table."}  (
		  `aid` int(11) unsigned NOT NULL ,
		  PRIMARY KEY (`aid`)
		) ENGINE=MyISAM  ;";
		$result = $mysql->db_query($sql); 
		
		//����������ֶ�
		$sql="alter table {".$fields_table."} add `".$data['nid']."`  ".$type.$field_size."  NULL ";
		return  $mysql->db_query($sql); 
	}
	
	/**
	 * �޸��ֶ�
	 *
	 * @param Array $data 
	 * @return Array
	 */
	function UpdateFields($data = array()){
		global $mysql;
		if (!isset($data['name']) || $data['name'] == "") return self::MODULE_NAME_NO_EMPTY;
		if (!isset($data['code']) || $data['code'] == "") return self::MODULE_CODE_NO_EMPTY;
		
		$fields_id = $data['fields_id'];
		$nid = $data['nid'];
		$code = $data['code'];
		if ($data['type']=="varchar" || $data['type']=="int"){
			$data['size'] = 255;
		}
		//�޸��ֶα����������
		$_sql = array();
		$sql = "update  {fields}  set ";
		foreach ($data as $key => $value){
			$_sql[] = "`$key`='$value'";
		}	
		$sql .= join(",",$_sql)." where `fields_id` = '$fields_id' ";
		$result = $mysql->db_query($sql);
		
		if ($result == false) return self::FIELDS_UPDATE_ERROR;
		
		$field_size = "";
		$size = $data['size'];
		$type = $data['type'];
		if ($type != "text" && $type != "longtext" && $type != "mediumtext" ){
			$field_size="(".$size.")";
		}
		
		$fields_table = $code."_fields";
		
		$sql="alter table  {".$fields_table."}  change $nid $nid ".$type.$field_size."  NULL ";
		return $mysql->db_query($sql);
	}
	
	/**
	 * �޸��ֶ�����
	 *
	 * @param Array $data 
	 * @return Boolen
	 */
	public static function OrderFields($data){
		global $mysql;
		$fields_id = $data['fields_id'];
		$order = $data['order'];
		if ($fields_id == "")  return -1;
		foreach ($fields_id as $key => $item){
			$sql = "update  {fields}  set `order`=".$order[$key]." where `fields_id` = $item";
			$mysql->db_query($sql);
		}
		return true;
	}
	
	
	/**
	 * ɾ���ֶ�
	 *
	 * @param Array $data 
	 * @return Boolen
	 */
	public static function DeleteFields($data = array()){
		global $mysql;
		$fields_id = $data['fields_id'];
		$code = $data['code'];
		$sql = "select nid from {fields} where code='$code' and fields_id='$fields_id' ";
		$result = $mysql->db_fetch_array($sql); 
		if ($result == false) return self::ERROR;
		$nid = $result['nid'];
		$sql = "delete  from {fields}  where nid='$nid' and code = '$code';";
		$mysql->db_query($sql);
		$sql = "alter table {".$code."_fields} drop $nid";
		$mysql->db_query($sql);
		return true;
	}
	
	/**
	 * ����ֶ�����
	 *
	 * @param Array $data 
	 * @return Boolen
	 */
	public static function AddFieldsTable($data = array()){
		global $mysql;
		$code = $data['code'];
		$id = $data['id'];
		if ($code == "") return self::ERROR;
		unset($data['code']);
		unset($data['id']);
		$sql = "insert into  {".$code."_fields}  set aid = '$id'";
		if (is_array($data)){
			foreach ($data as $key =>$value){
				if ($key!=""){
					$sql .= ",`$key`='$value'";
				}
			}
		}
		return $mysql->db_query($sql);
	}
	
	/**
	 * ����ֶ�����
	 *
	 * @param Array $data 
	 * @return Boolen
	 */
	public static function UpdateFieldsTable($data = array()){
		global $mysql;
		$code = $data['code'];
		$id = $data['id'];
		if ($code == "") return self::ERROR;
		unset($data['code']);
		unset($data['id']);
		$sql = "select * from {".$code."_fields} where aid = '$id'";
		$result = $mysql->db_fetch_array($sql);
		if ($result == false){
			$sql = "insert into  {".$code."_fields}  set aid = '$id'";
			foreach ($data as $key =>$value){
				if ($key!=""){
					$sql .= ",`$key`='$value'";
				}
			};
			$mysql->db_query($sql);
		}else{
			$sql = "update  {".$code."_fields}  set aid = '$id'";
			if (is_array($data)){
				foreach ($data as $key =>$value){
					if ($key!=""){
						$sql .= ",`$key`='$value'";
					}
				}
			}
			$sql .= " where aid = '$id'";
			$mysql->db_query($sql);
		}
		return true;
	}
	
	/**
	 * ɾ��
	 *
	 * @param Array $data
	 * @return Boolen
	 */
	public static function DeleteFieldsTable($data = array()){
		global $mysql;
		$code = $data['code'];
		$id = $data['id'];
		if (!is_array($id)){
			$id = array($id);
		}
		$sql = "delete from  {".$code."_fields}  where aid in (".join(",",$id).")";
		$mysql->db_query($sql);
		return true;
	}
	
	
		/**
	 * ����ֶ�����
	 *
	 * @param Array $data 
	 * @return Boolen
	 */
	public static function GetFieldsTable($data = array()){
		global $mysql;
		$code = $data['code'];
		$id = $data['id'];
		if ($code == "" || $id == "") return self::ERROR;
		$sql = "select * from  {".$code."_fields}  where aid = '$id'";
		return $mysql->db_fetch_array($sql);
	}
	
	/**
	 * �޸�����
	 *
	 * @param Array $code 
	 * @param Array $order 
	 * @return Integer
	 */
	function ActionModule($data = array()){
		global $mysql;
		$type = $data['type'];
		$code = $data['code'];
		$id = $data['id'];
		if($type == "order"){
			$order = $data['order'];
			if (!is_array($id))	return self::ERROR;
			foreach ($id as $key => $item){
				$sql = "update  {".$code."}  set `order`=".$order[$key]." where id=$item";
				$mysql->db_query($sql);
			}
			return true;
		}elseif($type == "status"){
			$status = $data['status'];
			$sql = "update {".$code."} set status=".$status." where id in (".join(",",$id).")";
			$mysql->db_query($sql);
			return true;
		}elseif($type == "flag"){
			$flag = $data['flag'];
			$change = $data['change'];
			foreach ($id as $key => $value){
				$_flag = array();
				if (isset($flag[$key]) && $flag[$key]!=""){
					$_flag = explode(",",$flag[$key]);
				}
				$_flag[] = $change;
				$_flag = join(",",array_unique ($_flag));
				$sql = "update {".$code."} set flag='".$_flag."' where id=$value";
				$result = $mysql->db_query($sql);
			}
			return true;
		}elseif($type == "del"){
			$sql = "delete from {".$code."}  where id in (".join(",",$id).")";
			$mysql->db_query($sql);
			/*
			$sql = "select 1 from {".$code."_fields} limit 1";
			$result = $mysql->db_fetch_array($sql);
			if ($result!=false){
				$sql = "delete from {".$code."_fields}  where aid in (".join(",",$id).")";
				$mysql->db_query($sql);
			}
			*/
			return true;
		}
	}
	
	
	/**
	 * ��ȡ���Ե��б�
	 *
	 * @param Array $fields_id 
	 * @param Array $order 
	 * @return Integer
	 */
	function GetFlagList($data = array()){
		global $mysql;
		$sql = "select * from {flag} ";
		$result = $mysql->db_fetch_arrays($sql); 
		return $result;
	}
	
	
	
	
	/**
	 * ���ģ��������б�
	 */
	function get_module($code="",$type="",$status=""){
		global $mysql;
		$sql = "select * from  {module}  where code!='' ";
		if ($type!="") {
			if ($type == "!system"){
				$sql.= " and type!='system'";
			}else{
				$sql.= " and type='$type'";
			}
		}
		if ($status!="") {
			$sql.= " and status=$status";
		}
		if (empty($code)){
			return $mysql->db_fetch_arrays($sql." order by `order` desc");
		}else{
			return $mysql->db_fetch_array($sql." and code = '$code'");
		}
	}
	
	
	/**
	 * ����µ�ģ��
	 */
	function add_module($var,$type=''){
		global $db_config;
		$code = $var['code'];
		if (!isset($code)) return false;
		if (!isset($var['purview']) || $var['purview'] == ""){
			$purview = array("$code"=>array($var['name']=>array($code."_list"=>"�����б�",$code."_new"=>"�������",$code."_view"=>"���ݲ鿴",$code."_edit"=>"�޸�����",$code."_del"=>"ɾ������",$code."_order"=>"�޸�����")));
			$var = array_merge($var,array("purview"=>serialize($purview)));
		}
		$sql = "select * from  {module}  where code='$code'";
		$result = $this->mysql->db_fetch_array($sql);
		if($result !=false) return -1;
		if ($type=="add"){
			$result = get_file("modules");
			if (in_array($code,$result)) return -1;
		}
		$module = $db_config['prefix']."module";
		$sql = "insert into  `$module` set ";
		foreach ($var as $key => $value){
			$_sql[] = "`$key`='$value'";
		}
		$sql .= join(",",$_sql);
		$sql .= ",`addtime`='".time()."',`addip`='$this->ip'";
		return $this->mysql->db_query($sql,"true");
	}
	
	
	/**
	 * �޸�ģ��
	 */
	function update_module($var,$code){
		$sql = "update  {module}  set ";
		foreach ($var as $key => $value){
			$_sql[] = "`$key`='$value'";
		}
		$sql .= join(",",$_sql);
		$sql .= " where code = '$code'";
		return $this->mysql->db_query($sql);
	}
	
	
	
	/**
	 * ж��ģ��
	 */
	function unstall_module($code,$other_table=""){
		$sql = "delete from {module} where code='$code' and type!='system'";
		$this->mysql->db_query($sql);
		$sql = "delete from {fields} where code='$code' ";
		$this->mysql->db_query($sql);
		$sql = "drop table IF  EXISTS  {".$code."} , {".$code."_type} , {".$code."_fields} ";
		$this->mysql->db_query($sql);
		if ($other_table != ""){
			$result = explode(",",$other_table);
				foreach ($result as $val){
				if ($val !=""){
					$this->mysql->db_query("drop table IF  EXISTS  {".$val."} ");
				}
			}
		}
		return true;
		
	}
	
	/**
	 * �ر�ģ��
	 */
	function close_module($code){
		$sql = "update {module} set status=0 where code='$code'";
		return $this->mysql->db_query($sql);
	}
	
	/**
	 * �ر�ģ��
	 */
	function open_module($code){
		$sql = "update {module} set status=1 where code='$code'";
		return $this->mysql->db_query($sql);
	}
	
	function get_module_content($code,$page="",$epage=10,$site_id=''){
		$_sql="";
		$sql = "select count(*) as num from  {".$code."} as p1 ";
		if ($site_id !="") $_sql .= " where p1.site_id=$site_id";
		$_result = $this->mysql->db_fetch_array($sql.$_sql);
		
		if ($page !=""){
			$vpage = ($page-1)*$epage;
		}
		$sql = "select p1.*,p2.name as site_name,p3.username from  {".$code."}  as p1 left join {site} as p2 on p1.site_id =p2.site_id  left join {user} as p3 on p1.user_id=p3.user_id ";
		$sql .= " $_sql order by p1.`order` desc,p1.id desc";
		if ($page !="") $sql .= " limit $vpage,$epage";
		$result = $this->mysql->db_fetch_arrays($sql);
		return array("result"=>$result,"num"=>$_result['num']);
	}
	
	function add_module_content($code,$var,$fields){
		$sql = "insert into  {".$code."}  set ";
		foreach ($var as $key =>$value){
			$sql .= "`$key`='$value',";
		}
		$sql .= "addtime='".time()."',addip='$this->ip'";
		$this->mysql->db_query($sql);
		$id = $this->mysql->db_insert_id();
		$sql = "insert into  {".$code."_fields}  set ";
		if (is_array($fields)){
			foreach ($fields as $key =>$value){
				if ($key!=""){
				$sql .= "`$key`='$value',";
				}
			}
		}
		$sql .= "article_id=$id";
		$this->mysql->db_query($sql);
		return true;
	}
	
	function update_module_content($code,$var,$fields,$id){
		if ($id == "") return false;
		$_sql = array();
		$sql = "update  {".$code."}  set ";
		foreach ($var as $key =>$value){
			$_sql[] = "`$key`='$value'";
		}
		$sql .= join(",",$_sql)." where id=$id";
		$this->mysql->db_query($sql);
		
		$_sql = array();
		if (is_array($fields)){
			$sql = "update  {".$code."_fields}  set ";
			foreach ($fields as $key =>$value){
				if ($key!=""){
				$_sql[] = "`$key`='$value'";
				}
			}
			$sql .= join(",",$_sql)." where article_id=$id";
			$this->mysql->db_query($sql);
		}
		return true;
	}
	
	
	function view_module_content($code,$id){
		if ($id == "") return false;
		$sql = "select p1.*,p2.name as site_name,p3.username,p4.* from  {".$code."}  as p1 left join {site} as p2 on p1.site_id =p2.site_id  left join {user} as p3 on p1.user_id=p3.user_id left join {".$code."_fields} as p4 on p1.id=p4.article_id where p1.id=$id";
		return $this->mysql->db_fetch_array($sql);
	}
	/**
	 * �޸�����
	 *
	 * @param Array $code 
	 * @param Array $order 
	 * @return Integer
	 */
	function order_module_content($code,$id,$order){
		if (!is_array($id))	return false;
		foreach ($id as $key => $item){
			$sql = "update  {".$code."}  set `order`=".$order[$key]." where id=$item";
			$this->mysql->db_query($sql);
		}
		return true;
	}
	
	function del_module_content($code,$id){
		if ($id == "") return false;
		$sql = "delete from  {".$code."}  where id=$id";
		return $this->mysql->db_query($sql);
	}
	
	function get_site($site_id=""){
		$sql = "select p1.*,p2.name as module_name from  {site}  as p1 left join  {module}  as p2 on p1.code = p2.code ";
		$_sql = " order by p1.`order` desc,p1.site_id";
		if ($site_id==""){
			return $this->mysql->db_fetch_arrays($sql.$_sql);
		}else{
			return $this->mysql->db_fetch_array($sql." where p1.site_id=$site_id".$_sql);
		}	
	}
	
	
	function get_sites($site_id=0,$status="",$pid="",$page="",$epage=10){
		$_sql="";
		if ($status!=""){
			$_sql .= " and status=$status"; 
		}
		
		$sql = "select count(*) as num from  {site}  where site_id!=''";
		$_result = $this->mysql->db_fetch_array($sql.$_sql);
		
		
		if ($site_id!=0){
			if ($pid==1){
				$_sql .= " and site_id=$site_id"; 
			}else{
				$_sql .= " and (pid=$site_id or site_id=$site_id)"; 
			}
		}
		if ($page !=""){
			$vpage = ($page-1)*$epage;
		}
		$sql = "select * from  {site}  where site_id!=''".$_sql;
		if ($page !="") $sql .= " limit $vpage,$epage";
		$result = $this->mysql->db_fetch_arrays($sql);
		return array("result"=>$result,"num"=>$_result['num']);
	}

	
	/**
	 * ��ȡ��Ӧ��ģ��
	 */
	function get_site_list($code){
		$sql = "select * from  {site}  where code='$code'";
		$result = $this->mysql->db_fetch_arrays($sql);
		$_result = "";
		foreach($result as $key => $value){
			$_result[$value['site_id']] = $value['name'];
		}
		return $_result;
	}
	
	
	/**
	 * ���վ��
	 *
	 * @param Array $val
	 * @return Integer
	 */
	function add_site($val){
		if ($val['name']=="" )	return -1;
		$sql = "select * from  {site}  where `nid`='".$val['nid']."' ";
		$result = $this->mysql->db_fetch_array($sql);
		if ($result!=false) return -2; //��ʶ���Ѿ����ڲ����ظ�
				
		//��ģ�ͱ������һ������
		$sql = "insert into  {site}  set `addtime`='".time()."',`addip`='$this->ip'";
		foreach ($val as $key => $value) {
			$sql .= ",`$key`='$value'";
		}
		return $this->mysql->db_query($sql);
	}
	
	/**
	 * �޸�վ����Ϣ
	 *
	 * @param Integer $site_id վ��ID
	 * @param Array $val 
	 * @return Integer
	 */
	function update_site($site_id,$val){
		if ($site_id=="" || $val['name']=="" )	return -1;
		
		$sql = "update  {site}  set ";
		foreach ($val as $key => $value) {
			$sql .= "`$key`='$value',";
		}
		$sql .= "`site_id`=$site_id where `site_id`=$site_id";
		return $this->mysql->db_query($sql);
	}
	
	
	/**
	 * �޸�վ��ģ��
	 *
	 * @param Integer $site_id վ��ID
	 * @param Array $val 
	 * @return Integer
	 */
	function update_site_tpl($site_id,$tpl,$type){
		if ($type=="" || $site_id=="") return "";
		if ($type=="all"){
			$site_id = $site_id;
		}elseif ($type=="brother"){
			$sql = "select pid from  {site}  where site_id=$site_id";
			$result = $this->mysql->db_fetch_array($sql);
			$site_id = $result['pid'];
		}
		$sql = "update  {site}  set ";
			foreach ($tpl as $key => $value) {
				$_sql[] = "`$key`='$value'";
			}
		$sql = $sql.join(",",$_sql)." where `pid`=$site_id";
		return $this->mysql->db_query($sql);
	}
	
	/**
	 * ���վ��λ��
	 *
	 * @param Integer $site_id վ��ID
	 * @param Array $val 
	 * @return Integer
	 */
	function get_site_position($site_id,$_pos=" -> ",$index="��ҳ",$res=array()){
		if ($site_id!=0){
			$sql = "select * from  {site}  where site_id=$site_id";
			$result = $this->mysql->db_fetch_array($sql);
			//$res = $_pos."<a href='?$site_id'>".$result['name']."</a>";
			$res[$site_id] = $result['name'];
			return $this->get_site_position($result['pid'],$_pos,$index,$res);
		}else{
			$result = "<a href='/'>$index</a>";
			ksort($res);
			foreach ($res as $key => $value){
				$result .= $_pos."<a href='".format_url("?$key",array($value['isurl'],$value['url']))."'>".$value."</a>";
			}
			return $result;
		}
	}
	
	/**
	 * ���վ��·��
	 *
	 * @param Integer $site_id վ��ID
	 * @param Array $val 
	 * @return Integer
	 */
	function get_site_path($site_id,$_pos="/",$index="/",$res=array()){
		if ($site_id!=0){
			$sql = "select * from  {site}  where site_id=$site_id";
			$result = $this->mysql->db_fetch_array($sql);
			//$res = $_pos."<a href='?$site_id'>".$result['name']."</a>";
			$res[$site_id] = $result['nid'];
			return $this->get_site_path($result['pid'],$_pos,$index,$res);
		}else{
			$result = $index;
			ksort($res);
			foreach ($res as $key => $value){
				$result .= $_pos.$value;
			}
			return $result;
		}
	}
	
	function del_site($site_id){
		$sql = "delete from  {site}  where site_id=$site_id ";
		return $this->mysql->db_query($sql);
	}
	function get_site_recycle(){
		$result = $this->get_site_li();
		foreach($result as $key => $value){
			$id[] = $value['site_id']; 
		}
		if (is_array($id)) {
			$_id = join(",",$id);
			$sql = "select p1.*,p2.name as module_name from  {site}  as p1 left join  {module}  as p2 on p1.code = p2.code where site_id not in($_id)";
			return $this->mysql->db_fetch_arrays($sql);
		}else{
			return "";
		}
	}
	function get_site_menu($usertype=""){
		$sql = "select * from  {site}  order by `order` desc";
		$result = $this->mysql->db_fetch_arrays($sql);
		$control_menu = array();
		if (is_array($result)){
			foreach ($result as $key => $value){
				if (($usertype !="" && in_array($usertype,explode(",",$value['rank']))) || $usertype ==1){
					if ($value['pid']==0){
						$control_menu[$key] = $value;
						foreach ($result as $_key => $_value){
							if (($usertype !="" && in_array($usertype,explode(",",$_value['rank']))) || $usertype ==1){
								if ($_value['pid']==$value['site_id']){
									$control_menu[$key]['sub'][$_key] = $_value;
									foreach ($result as $__key => $__value){
										if (($usertype !="" && in_array($usertype,explode(",",$__value['rank']))) || $usertype ==1){
											if ($__value['pid']==$_value['site_id']){
												$control_menu[$key]['sub'][$_key]['_sub'][$__key] = $__value;
											}
										}
									}
								}
							}
						}
					}
				}
			}
		}
		return $control_menu;
	}
	
	
	function get_site_li($site_id="",$code=""){
		$_result = "";
		$sql = "select p1.*,p2.name as module_name from  {site}  as p1 left join  {module}  as p2 on p1.code = p2.code where p1.site_id!=''";
		if ($site_id!="") {
			$sql .= " and p1.site_id!=$site_id";
		}
		if ($code!="") {
			$sql .= " and p1.code='$code'";
		}
		$sql .= " order by p1.`order` desc,p1.site_id";
		$result = $this->mysql->db_fetch_arrays($sql);
		
		if (count($result)>0){
			$i=0;
			if ($code=="") {
				foreach($result as $key => $value){
					if ($value['pid']==0){
						$_result[$i] = $value;
						$_result[$i]['aname'] = "<b>".$value['name']."</b>";
						$i++;
						foreach($result as $_key => $_value){
							if ($_value['pid']==$value['site_id']){
								$_result[$i] = $_value;
								$_result[$i]['aname'] = "-".$_value['name'];
								$i++;
								foreach($result as $__key => $__value){
									if ($__value['pid']==$_value['site_id']){
										$_result[$i] = $__value;
										$_result[$i]['aname'] = "--".$__value['name'];
										$i++;
										foreach($result as $___key => $___value){
											if ($___value['pid']==$__value['site_id']){
												$_result[$i] = $___value;
												$_result[$i]['aname'] = "--".$___value['name'];
												$i++;
											}
										}
									}
								}
							}
						}
					}
				}
			}else{
				foreach ($result as $key => $value){
					$_result[$key]['aname'] = $value['name'];
					$_result[$key]['site_id'] = $value['site_id'];
				}
			}
		}
		return $_result;
	}
	
	function aget_site_li($site_id="",$code=""){
		$_result = "";
		$sql = "select p1.*,p2.name as module_name from  {site}  as p1 left join  {module}  as p2 on p1.code = p2.code where p1.site_id!=''";
		if ($site_id!="") {
			$sql .= " and p1.site_id!=$site_id";
		}
		if ($code!="") {
			$sql .= " and p1.code='$code'";
		}
		$sql .= " order by p1.`order` desc,p1.site_id";
		$result = $this->mysql->db_fetch_arrays($sql);
		if (count($result)>0){
			foreach($result as $key => $value){
				$_result[$value['site_id']] = $value;
				$_result[$value['site_id']]['pname'] = $value['name'];
				$_result[$value['site_id']]['ppid'] = 0;
				$_result = $this->_get_site_li("-",$code,$value['site_id'],$site_id,$_result);
			}
		}
		return $_result;
	}
	function _aget_site_li($var,$code,$pid,$site_id,$_result){
		$sql = "select p1.*,p2.name as module_name from  {site}  as p1 left join  {module}  as p2 on p1.code = p2.code where p1.pid=$pid";		
		if ($code!="") {
			$sql .= " and p1.code='$code'";
		}
		if ($site_id!="") { 
			$sql .= " and p1.site_id!=$site_id and p1.pid!=$site_id";
		}
		$result = $this->mysql->db_fetch_arrays($sql);
		if (count($result)>0){
			foreach($result as $key => $value){
				$_result[$value['site_id']] = $value;
				$_result[$value['site_id']]['ppid'] = 0;
				$_result[$value['site_id']]['pname'] = $var.$value['name'];
				$_result[$pid]['ppid'] = 1;
				$_result = $this->_get_site_li($var."-",$code="",$value['site_id'],$site_id,$_result);
			}
		}
		return $_result;
	}
	
	function move_site($site_id,$pid){
		$sql = "update {site} set pid = $pid where site_id=$site_id";
		return $this->mysql->db_query($sql);
	}
	
	/**
	 * �޸��ֶ�����
	 *
	 * @param Array $fields_id 
	 * @param Array $order 
	 * @return Integer
	 */
	function order_site($site_id,$order){
		if ($site_id == "")  return -1;
		foreach ($site_id as $key => $item){
			$sql = "update  {site}  set `order`=".$order[$key]." where `site_id` = $item";
			$this->mysql->db_query($sql);
		}
		return true;
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	

	
	
	/**
	 * ��ȡ���Ե�����
	 *
	 * @param Array $fields_id 
	 * @param Array $order 
	 * @return Integer
	 */
	function get_flag_name($flag){
		if ($flag == "")  return "";
		$result = $this->mysql->db_selects("flag","","`order` desc");
		foreach($result as $key => $value){
			$flag_res[$value['nid']] = $value['name'];
		}
		$_flag = "";
		$flags = explode(",",$flag);
		foreach ($flags as $_key => $_value){
			$_flag .= $flag_res[$_value]." ";
		}
		return$_flag;
	}
	
	
	function create_file_info($var){
		if (!isset($var['date'])) $var['date'] = date("Y-m-d",time());
		$content = '<?
		$code = "'.$var['code'].'";
		$name = "'.$var['name'].'";
		$description = "'.$var['description'].'";
		$version = "'.$var['version'].'";
		$author = "'.$var['author'].'";
		$date = "'.$var['date'].'";
		$type = "'.$var['type'].'";
		?>';
		mk_file("modules/".$var['code']."/".$var['code'].".info",$content);
	}
	
	function create_file($var,$type,$url,$reurl=""){
		$content = read_file($url);
		if ($type == "sql" && $reurl =="") {
		
			$content = str_replace("{}","{cms_".$var['code']."}",$content);
			$content = str_replace("[]","{cms_".$var['code']."_fields}",$content);
			$_sql = explode(";",$content);
			foreach($_sql as $val){
				if ($val!=""){
					$this->mysql->db_query($val);
				}
			}
		}
		if ($reurl ==""){
			$_url = "modules/".$var['code']."/".$var['code'].".".$type;
		}else{
			$_url = $reurl;
		}
		mk_file($_url,$content);
	}
}
?>
