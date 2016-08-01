<?
/******************************
 * $File: user.class.php
 * $Description: ���ݿ⴦���ļ�
 * $Author: ahui 
 * $Time:2010-03-09
 * $Update:None 
 * $UpdateDate:None 
******************************/
class applyClass {

	const ERROR = '���������벻Ҫ�Ҳ���';
	const APPLY_NO_START_APPLY = '�������Ļ��û��ʼ���������Ժ�����';
	const APPLY_FULL = '������������';
	const APPLY_END_APPLY = '�˻�Ѿ������������뼰ʱ��ע���ǵ���վ';
	const APPLY_REAPPLY = '���Ѿ������˻�������ظ�����';
	const APPLY_NOT_EXISTS = '�������Ļ������,�벻Ҫ�Ҳ���';

	const CANCELAPPLY_END_TIME = '������������������ȡ��';
	
	/**
	 * �����
	 * @param $id �ID
	 * @param $user_id ��ԱID
	 * @return
	 *		HuoDong::CANCELAPPLY_END_TIME ������������������ȡ��<br>
	 *		HuoDong::APPLY_FULL ������������<br>
	 *		HuoDong::APPLY_END_APPLY ���������<br>
	 *		HuoDong::APPLY_REAPPLY �ظ�����<br>
	 *		HuoDong::APPLY_NOT_EXISTS �������<br>
	 *		true �ɹ�
	 */
	public static function Apply ($data = array()) {
		global $mysql;
		
		$result = self::Check($data);
		if ($result!==true){
			return $result;
		}
		$code = $data['code'];
		$id = $data['id'];
		
		$data = array(
			'code'=>$code,
			'order'=>10,
			'aid' => $id,
			'user_id' =>  $data['user_id'],
			'username' =>  $data['username'],
			'realname' => $data['realname'],
			'phone' => $data['phone'],
			'email' => $data['email'],
			'qq' => $data['qq'],
			'addtime' => time(),
			'addip' => ip_address(),
			'status' => 0
		);
		foreach ($data as $key => $val){
			$_data[] = " {$key} ='{$val}'";
		}
		$sql = "insert into  {apply}  set ".join(",",$_data);
		$result = $mysql->db_query($sql);
		if (true !== $result) {
			return $result;
		}

		$sql = "update  {".$code."}  set apply_yesman = apply_yesman+1 where id={$id}";
		$mysql->db_query($sql);
		
		return true;
	}
	
	function Check($data = array()){
		global $mysql;
		$code = $data['code'];
		$id = $data['id'];
		$user_id = $data['user_id'];
		if ($user_id=="") return "�㻹û��½�����ȵ�¼";
		$result = $mysql->db_fetch_array("select * from  {".$code."}  where id={$id}");
		if (!$result) {
			return self::APPLY_NOT_EXISTS;
		}
		
		if (1 != $result['status'] ) {
			return self::APPLY_NO_START_APPLY;
		}
		if ($result['apply_yesman'] >= $result['apply_man']) {
			return self::APPLY_FULL;
		}
		if (time() > $result['apply_endtime']) {
			return self::APPLY_END_APPLY;
		}
		$sql = "select 1 from {apply} where code='{$code}' and  aid={$id} and user_id={$user_id}";
		if ($mysql->db_fetch_array($sql)) {
			return self::APPLY_REAPPLY;
		}
		return true;
	}
	
	/**
	 * ȡ�������
	 * @param $id �ID
	 * @param $user_id ��ԱID
	 * @return
	 *		HuoDong::CANCELAPPLY_END_TIME ������������������ȡ��<br>
	 *		true �ɹ�
	 */
	public static function CancelApply($data = array()) {
		global $mysql;
		$code = $data['code'];
		$id = $data['id'];
		$user_id = $data['user_id'];
		if (!$mysql->db_fetch_array("select 1 from  {apply}  where code='".$code."' and aid={$id} and user_id={$user_id}")) {
			return "���Ĳ������󣬴˱��������ڡ�";
		}
		$hd = $mysql->db_fetch_array("select apply_endtime from {".$code."} where id={$id}");
		if ($hd['apply_endtime'] <= time() - 60*60*1) {
			return self::CANCELAPPLY_END_TIME;
		}

		$sql = "
			update  {".$code."}  set apply_yesman=apply_yesman-1 where id={$id};
			delete from  {apply}  where code='".$code."' and aid={$id} and user_id={$user_id};
			";
		return $mysql->db_querys($sql);
		
	}
	
	
	//��õ���������Ϣ
	function GetApplyOne($data = array()){
		global $mysql;
		$_sql = "where 1=1 ";		 
		if (isset($data['id']) && $data['id']!=""){
			$_sql .= " and p1.id = {$data['id']}";
		}	 
		
		if (isset($data['user_id']) && $data['user_id']!=""){
			$_sql .= " and p1.user_id = {$data['user_id']}";
		}
		
		if (isset($data['code']) && $data['code']!=""){
			$_sql .= " and p1.code = '{$data['code']}'";
		}
		
		$sql = "select * from  {apply}  as p1 {$_sql}";
		
		return $mysql->db_fetch_array($sql);
	}
	
	//���еı�������
	function ActionApply ($data= array()){
		global $mysql;
		$sql = array();
		$code = $data['code'];
		$id = $data['aid'];
		$apply_list = self::GetApplyList(array("code"=>$data['code'],"id"=>$data['aid'],"limit"=>"all"));
		$_cp = 0;
		if ($apply_list!=false){
			foreach ($apply_list as $key => $value){
				$_apply_list[] = $value['username'];
				//��ɾ��
				if (!in_array($value['username'],$data['username'])){
					$sql[] = "delete from  {apply}  where username = '{$value['username']}' and code='{$data['code']}' and aid='{$data['aid']}'";
					$_cp ++;
				}
			}
			
		}
		
		
		//��ӻ��޸�
		$_add = 0;
		foreach ($data['username'] as $key => $value){
			if ($value!=""){
				if (in_array($value,$_apply_list)){
					$sql[] = "update  {apply}  set realname='{$data['realname'][$key]}',phone='{$data['phone'][$key]}',email='{$data['email'][$key]}',qq='{$data['qq'][$key]}',status='{$data['status'][$key]}',dotime='{$data['dotime'][$key]}',credit='{$data['credit'][$key]}',remark='{$data['remark'][$key]}' where username = '{$value}' and code='{$data['code']}' and aid='{$data['aid']}'";
				}else{
					$_sql = "select user_id from  {user}  where username = '{$value}'";
					$result = $mysql->db_fetch_array($_sql);
					if($result == false){
						$_username[] = $value; 
					}else{
						$sql[$key] = "insert into  {apply}  set realname='{$data['realname'][$key]}',
						phone='{$data['phone'][$key]}',
						email='{$data['email'][$key]}',
						qq='{$data['qq'][$key]}',
						status='{$data['status'][$key]}',
						dotime='{$data['dotime'][$key]}',
						credit='{$data['credit'][$key]}',
						remark='{$data['remark'][$key]}',
						aid='{$data['aid']}',
						code='{$data['code']}',
						`order`=10,
						user_id='{$result['user_id']}',
						addtime ='".time()."',
						addip = '".ip_address()."',
						username='{$value}' ";
						$_add ++;
					}
				}
			}
		}
		$mysql->db_querys(join(";",$sql));
		$sql = "update  {".$code."}  set apply_yesman = apply_yesman+$_add-$_cp where id={$id}";
		$mysql->db_query($sql);
		return true;
	}

/**
	 * �б�
	 *
	 * @return Array
	 */
	function GetApplyList($data = array()){
		global $mysql;
		
		$page = empty($data['page'])?1:$data['page'];
		$epage = empty($data['epage'])?10:$data['epage'];
		
		$_sql = "where 1=1 ";		 
		if (isset($data['id']) && $data['id']!=""){
			$_sql .= " and p1.aid = {$data['id']}";
		}
		
		if (isset($data['aid']) && $data['aid']!=""){
			$_sql .= " and p1.aid = {$data['aid']}";
		}
		
		if (isset($data['code']) && $data['code']!=""){
			$_sql .= " and p1.code = '{$data['code']}'";
		}
		
		$_select = "p1.*";
		$sql = "select SELECT
					from  {apply}  as p1
					 {$_sql}
				 ORDER LIMIT";
				 
		//�Ƿ���ʾȫ������Ϣ
		if (isset($data['limit']) ){
			$_limit = "";
			if ($data['limit'] != "all"){
				$_limit = "  limit ".$data['limit'];
			}
			$result =  $mysql->db_fetch_arrays(str_replace(array('SELECT', 'ORDER', 'LIMIT'), array($_select, 'order by p1.id ', $_limit), $sql));
			return $result;
		}	
		
		$row = $mysql->db_fetch_array(str_replace(array('SELECT', 'ORDER', 'LIMIT'), array('count(1) as num', '', ''), $sql));
		
		$total = $row['num'];
		$total_page = ceil($total / $epage);
		$index = $epage * ($page - 1);
		$limit = " limit {$index}, {$epage}";
		
		$list = $mysql->db_fetch_arrays(str_replace(array('SELECT', 'ORDER', 'LIMIT'), array($_select, 'order by p1.id ', $limit), $sql));		
		$list = $list?$list:array();
		
		
		return array(
            'list' => $list,
            'record_num' => $total,
            'total' => $total,
            'page' => $page,
            'epage' => $epage,
            'total_page' => $total_page
        );
		
	}
	
	
	/**
	 * �б�
	 *
	 * @return Array
	 */
	function GetApplyPhList($data = array()){
		global $mysql;
		
		$page = empty($data['page'])?1:$data['page'];
		$epage = empty($data['epage'])?10:$data['epage'];
		
		$_sql = "where 1=1 ";		 
		if (isset($data['id']) && $data['id']!=""){
			$_sql .= " and aid = {$data['id']}";
		}
		
		if (isset($data['code']) && $data['code']!=""){
			$_sql .= " and code = '{$data['code']}'";
		}
		$_order = " group by username order by num_dotime desc,user_id asc";
		$_select = "sum(dotime) as num_dotime,sum(credit) as num_credit,username,realname,user_id";
		$sql = "select SELECT from  {apply}  
					 {$_sql}
				 ORDER LIMIT";
				 
		//�Ƿ���ʾȫ������Ϣ
		if (isset($data['limit']) ){
			$_limit = "";
			if ($data['limit'] != "all"){
				$_limit = "  limit ".$data['limit'];
			}
			$result =  $mysql->db_fetch_arrays(str_replace(array('SELECT', 'ORDER', 'LIMIT'), array($_select,$_order, $_limit), $sql));
			return $result;
		}	
		
		$row = $mysql->db_fetch_array(str_replace(array('SELECT', 'ORDER', 'LIMIT'), array('count(username) as num', '', ''), $sql));
		
		$total = $row['num'];
		$total_page = ceil($total / $epage);
		$index = $epage * ($page - 1);
		$limit = " limit {$index}, {$epage}";
		
		$list = $mysql->db_fetch_arrays(str_replace(array('SELECT', 'ORDER', 'LIMIT'), array($_select,$_order, $limit), $sql));		
		$list = $list?$list:array();
		
		
		return array(
            'list' => $list,
            'record_num' => $total,
            'total' => $total,
            'page' => $page,
            'epage' => $epage,
            'total_page' => $total_page
        );
		
	}
	
	//���߱���������ʱ������
	function GetApplyNum($data = array()){
		global $mysql;
		$_sql = "where 1=1 ";
		if(isset($data['user_id']) && $data['user_id']!=""){
			$_sql .= " and `user_id` = '{$data['user_id']}'";
		}
		$sql = "select count(*) as num ,sum(dotime) as num_dotime,sum(credit) as num_credit from  {apply}  {$_sql}";
		
		return $mysql->db_fetch_array($sql);
	}

}
?>