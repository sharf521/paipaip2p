<?
if (!defined('ROOT_PATH'))  die('���ܷ���');//��ֱֹ�ӷ���
check_rank("lianmeng_".$_t);//���Ȩ��

$result = $module->get_module("lianmeng");
if ($t=="install"){
	$list_purview = array("lianmeng"=>array("���˳�Ա"=>array("lianmeng_list"=>"��Ա�б�","lianmeng_new"=>"��ӳ�Ա","lianmeng_del"=>"ɾ����Ա")));//Ȩ��
}elseif ($result == false ){
	$msg = array("��ģ����δ��װ���벻Ҫ�Ҳ���","",$url);
}else{

	$list_name = $result['name'];
	$list_menu = "<a href='{$url}/new{$site_url}'>��ӳ�Ա</a> | <a href='{$url}{$site_url}'>��Ա�б�</a> | <a href='{$url}/lian'>վ������</a>";

	//��ĿID����Ŀ������
	if (!isset($_REQUEST['site_id']) || $_REQUEST['site_id']==0){
		$site_id = "";
		$site_url = "";
	}else{
		$site_id = $_REQUEST['site_id'];
		$site = $module->get_site($site_id);
		$site_url = "&site_id=$site_id";
		$magic->assign("site_url",$site_url);
		$magic->assign("site_name"," -> ".$site['name']);
	}

	/**
	 * �������Ϊ�յĻ�����ʾ���е��ļ��б�
	**/
	if ($t == ""){
		//�޸�״̬
		if (isset($_REQUEST['id']) && isset($_REQUEST['status'])){
			$sql = "update {lianmeng} set status='".$_REQUEST['status']."' where id = ".$_REQUEST['id'];
			$mysql->db_query($sql);	
		}
		
		$_sql = " where 1=1 ";
		if (isset($_REQUEST['keywords']) && $_REQUEST['keywords'] !=""){
			$_sql .= " and `name` like '%".$_REQUEST['keywords']."%'";
		}
		if (isset($_SESSION['city_id']) && 0 != @$_SESSION['city_id']) {
			$_sql .= " and city in ({$_SESSION['city_id']})";
		}
		$sql = "select * from {lianmeng} $_sql order by id desc";
		$num_sql = "select count(*) as num from {lianmeng} $_sql order by id desc";
		
		$result = $mysql->db_list_res($sql,$p,$epage=10);
		foreach ($result as $key => $value){
			$result[$key]['flagname'] = $module->get_flag_name($value['flag']);
		}
		$magic->assign("result",$result);
		
		$num = $mysql->db_num($num_sql);
		$pages->set_data(array('total'=>$num,'perpage'=>$epage,'nowindex'=>$p));
		$magic->assign("page",$pages->show(3));
	}
	
	
	/**
	 * ���
	**/
	elseif ($t == "new" || $t == "edit" ){
		$site_list = $module->get_site_li("","lianmeng");
		$magic->assign("site_list",$site_list);
		if ($t == "edit"){
			$result = $mysql->db_select("lianmeng","id=".$_REQUEST['id']);
		}else{
			$result = array("site_id"=>$site_id);
		}
		$magic->assign("result",$result);
	}
	elseif ($t == "add" || $t == "update"){
		$var = array("name","order","status","litpic","clearlitpic","school","xuanyan","intime","province","city","area");
		$index = post_var($var);
		
		if ($t == "update"){
			$result = $mysql->db_update("lianmeng",$index,"id=".$_POST['id']);
			$__url = $url;
		}else{
			$result = $mysql->db_add("lianmeng",$index);
			$__url = $url."/new";
		}
		if ($result == false){
			$msg = array("���������������Ա��ϵ");
		}else{
			$msg = array("�����ɹ�","",$__url);
		}
		$user->add_log($_log,$result);//��¼����
	}
	
	/**
	 * �鿴
	**/
	elseif ($t == "view"){
		$result = $mysql->db_select("lianmeng","id=".$_REQUEST['id']);
		$magic->assign("result",$result);
	}
	
	
	/**
	 * ɾ��
	**/
	elseif ($t == "del"){
		$result = $mysql->db_delete("lianmeng","id=".$_REQUEST['id']);
		if ($result == false){
			$msg = array("���������������Ա��ϵ");
		}else{
			$msg = array("ɾ���ɹ�");
		}
		$user->add_log($_log,$result);//��¼����
	}
	
	elseif($t == "lian"){
		$sql = "select p1.*,p2.name as city_name,count(school) as num from {lianmeng} as p1 left join {area} as p2 on p1.city=p2.id  group by school";
	
		$result = $mysql -> db_list_res($sql,$p,15);
		$magic->assign("result",$result);
		
		//������.��ҳ����ʽ
		$num = $mysql -> db_fetch_arrays($sql);
		$pages->set_data(array('total'=>count($num),'perpage'=>15,'nowindex'=>$p));
		$magic->assign("page",$pages->show(3));
	
	}
	
}
?>