<?php
/**
 */

/**
 * �ۿ�
 *
 * @author TissotCai
 */
class discountClass {


    const NOT_EXISTS_USER   = '�û�������';
    const NOT_EXISTS_MODULE = 'ģ�鲻����';
    

	/**
	 * ��ȡ�ۿ��б�
	 *
	 * @return Array
	 */
	function GetList($data = array()){
		global $mysql;
		
		$page = empty($data['page'])?1:$data['page'];
		$epage = empty($data['epage'])?10:$data['epage'];
		
		
		$_select = 'p1.*,p2.name as city_name,p3.name as site_name,p3.nid as site_nid,p4.name as company_name';
		$sql = "select SELECT from {discount} as p1 
				left join {area} as p2  on p1.city = p2.id
				left join {site} as p3  on p1.site_id = p3.site_id
				left join {discount_company} as p4  on p1.company_id = p4.id
				$_sql ORDER LIMIT";
		
		//�Ƿ���ʾȫ������Ϣ
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
	 * �鿴
	 *
	 * @param Array $data
	 * @return Array
	 */
	public static function GetOne($data = array()){
		global $mysql;
		$_sql = " where 1=1 ";
		
		$id = $data['id'];
		
		$click = isset($data['click'])?$data['click']:"";
		if ($click){
			$sql = "update  {lianmeng} set hits=hits+1 where id=$id";
			$mysql->db_query($sql);
		}
		
		if (!empty($id)){
			$_sql .= " and p1.id=$id"; 
		}
		
		$sql = "select p1.*,p2.nid as site_nid,p2.name as site_name,p3.name as city_name from {discount} as p1 
				left join {site} as p2 on p1.site_id = p2.site_id
				left join {area} as p3  on p1.city = p3.id $_sql ";
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
       
		$sql = "insert into  {discount}  set `addtime` = '".time()."',`addip` = '".ip_address()."'";
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
		$id = $data['id'];
        if ($data['id'] == "") {
            return self::ERROR;
        }
		
		$_sql = "";
		$sql = "update  {discount}  set ";
		foreach($data as $key => $value){
			$_sql[] .= "`$key` = '$value'";
		}
		$sql .= join(",",$_sql)." where id = '$id'";
		
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
		$sql = "delete from {discount}  where id in (".join(",",$id).")";
		return $mysql->db_query($sql);
	}

    /**
     * �޸��ۿ�״̬
     * @param $id �ۿ�ID
     */
    public static function ChangeDiscountStatus ($id) {
        global $mysql;

        $mysql->db_query("update {discount} set status=1-status where id={$id}");

        return true;
    }
	
	
	/**
     * ��ȡ�ۿ��б�
	 * @param $where ���� array('goods'=>'Ь��'...)
     * @param $page ҳ��
     * @param $page_size ÿҳ��¼��
     */
    public static function GetCompanyList ($data) {
        global $mysql;

		
		$name = empty($data['name'])?"":$data['name'];
		$page = empty($data['page'])?1:$data['page'];
		$epage = empty($data['epage'])?10:$data['epage'];
		
		$_sql = " where 1=1 ";
		if ($name!=""){
			$_sql .= " and p1.`name` like '%$name%'";
		}
		
		 $sql = "select SELECT from  {discount_company} as p1  $_sql ORDER LIMIT";
		//�Ƿ���ʾȫ������Ϣ
		if (isset($data['limit']) ){
			$_limit = "";
			if ($data['limit'] != "all"){
				$_limit = "  limit ".$data['limit'];
			}
			return $mysql->db_fetch_arrays(str_replace(array('SELECT', 'ORDER', 'LIMIT'), array(' p1.*', 'order by p1.`id` desc', $_limit), $sql));
		}
		
		
		$row = $mysql->db_fetch_array(str_replace(array('SELECT', 'ORDER', 'LIMIT'), array('count(1) as num', '', ''), $sql));
		
		$total = $row['num'];
		$total_page = ceil($total / $epage);
		$index = $epage * ($page - 1);
		$limit = " limit {$index}, {$epage}";
		$sql = str_replace(array('SELECT', 'ORDER', 'LIMIT'), array(' p1.*', 'order by p1.`id` desc', $limit), $sql);
		$list = $mysql->db_fetch_arrays($sql);		
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
     * ��ù�˾����Ϣ
     * @param $id �ۿ�ID
     */
    public static function GetCompanyOne ($data) {
        global $mysql;
		$id = $data['id'];
       return  $mysql->db_fetch_array("select * from {discount_company} where id={$id}");

    }
	/**
	 * ���
	 *
	 * @param Array $data
	 * @return Boolen
	 */
	function AddCompany($data = array()){
		global $mysql;
       
		$sql = "insert into  {discount_company}  set `addtime` = '".time()."',`addip` = '".ip_address()."'";
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
	function UpdateCompany($data = array()){
		global $mysql;
		$id = $data['id'];
        if ($data['id'] == "") {
            return self::ERROR;
        }
		
		$_sql = "";
		$sql = "update  {discount_company}  set ";
		foreach($data as $key => $value){
			$_sql[] .= "`$key` = '$value'";
		}
		$sql .= join(",",$_sql)." where id = '$id'";
        return $mysql->db_query($sql);
	}
	
	/**
	 * ɾ��
	 *
	 * @param Array $data
	 * @return Boolen
	 */
	public static function DeleteCompany($data = array()){
		global $mysql;
		$id = $data['id'];
		if (!is_array($id)){
			$id = array($id);
		}
		$sql = "delete from {discount_company}  where id in (".join(",",$id).")";
		return $mysql->db_query($sql);
	}
}
?>
