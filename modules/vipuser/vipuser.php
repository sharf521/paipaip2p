<?
if (!defined('ROOT_PATH'))  die('���ܷ���');//��ֱֹ�ӷ���

check_rank("vipuser_".$_t);//���Ȩ��

require_once 'vipuser.class.php';

$_A['list_purview'] = array("vipuser"=>array("vip�û�"=>array("vipuser_list"=>"vip�б�","vipuser_new"=>"���vip","vipuser_del"=>"ɾ��vip","vipuser_nvipuser"=>"����vip��","vipuser_ac"=>"����¿�","vipuser_lc"=>"��ֵ���б�","vipuser_ct"=>"��ֵ������")));//Ȩ��
$_A['list_name'] = $_A['module_result']['name'];
$_A['list_menu'] = "<a href='{$_A['query_url']}{$_A['site_url']}'>VIP��Ա�б�</a> - <a href='{$_A['query_url']}/nvipuser{$_A['site_url']}'>����VIP��Ա</a> - <a href='{$_A['query_url']}/lc{$_A['site_url']}'>��ֵ���б�</a> - <a href='{$_A['query_url']}/ac{$_A['site_url']}'>����¿�</a> - <a href='{$_A['query_url']}/ct{$_A['site_url']}'>VIP���͹���</a>";

$module_result = moduleClass::GetOne(array("code"=>"schoolresume"));
if (!$module_result){
    $msg = array("���Ȱ�װѧ������ģ��","",$url);
}else{
	
	/**
	 * �������Ϊ�յĻ�����ʾ���е��ļ��б�
	**/
	 # �û�����VIP��
    if ($_A['query_type']=="list") {
		$data['realname'] = isset($_REQUEST['realname'])?$_REQUEST['realname']:"";
		$data['serial_number'] = isset($_REQUEST['serial_number'])?$_REQUEST['serial_number']:"";
		$data['page'] = $_A['page'];
		$data['epage'] = $_A['epage'];
        //$user_name = isset($_REQUEST['user_name'])?$_REQUEST['user_name']:0;
       // $serial_number = isset($_REQUEST['serial_number'])?$_REQUEST['serial_number']:0;
        //$p = isset($_REQUEST['page'])?$_REQUEST['page']:1;
        $result = VipUser::GetVipuserList($data);

		if (is_array($result)){
			$pages->set_data($result);
			$_A['vipuser_list'] = $result['list'];
			$_A['showpage'] = $pages->show(3);
		
		}else{
			$msg = array($result);
		}
    }
	
    # VIP�����͹���
    elseif('ct' == $_A['query_type']) {
        $rows = VipUser::ListCardType();
        $magic->assign('rows', $rows);
		if (isset($_POST['id']) && $_POST['id']!=""){
			var_dump($_POST);
		
		}elseif (isset($_REQUEST['id']) && $_REQUEST['id']!=""){
		 $result = VipUser::ViewCardType($_REQUEST['id']);
		 $magic->assign('result', $result);
		}
    }
	
    # ����VIP������
    elseif('act' == $_A['query_type']) {
        $name = trim($_POST['type']);
        $month_num = intval($_POST['month_num']);
        if (!VipUser::AddCardType($name, $month_num)) {
            $msg = array(VipUser::$msg,'','');
        }
        else {
            $msg = array('��ӳɹ�','',"{$_A['query_url']}/ct{$_A['site_url']}");
        }
    }
	
	# �޸�VIP������
    elseif('uct' == $_A['query_type']) {
        $name = trim($_POST['type']);
        $month_num = intval($_POST['month_num']);
        if (!VipUser::UpdateCardType($name, $month_num,$_POST['id'])) {
            $msg = array(VipUser::$msg,'','');
        }
        else {
            $msg = array('�޸ĳɹ�','',"{$_A['query_url']}/ct{$_A['site_url']}");
        }
    }
	
	
    # ɾ��VIP������
    elseif('dct' == $_A['query_type']) {
       $id = (int)$_GET['id'];
       if ($id) {
         $mysql->db_query('delete from {vip_card_type} where id='.$id);
       }
       $msg = array('�ɹ�ɾ��','',"{$_A['query_url']}/ct{$_A['site_url']}");
    }
	
    # VIP��
    elseif('lc' == $_A['query_type']) {
        $status = isset($_REQUEST['status'])?(int)$_REQUEST['status']:'';
        $serial_number = isset($_REQUEST['serial_number'])?$_REQUEST['serial_number']:0;
        $p = isset($_REQUEST['page'])?$_REQUEST['page']:1;
		$export = isset($_GET['export'])?(int)$_GET['export']:0;
        $status = $status >= 7?'':$status;

		if ($export <= 0) {
			$result = VipUser::ListCard($status, $serial_number, $p);
        
			$magic->assign('rows', $result['list']);
			$pages->set_data(array('total'=>$result['record_num'],'nowindex'=>$_page,'perpage'=>$result['page_size']));
			$magic->assign("page",$pages->show(3));
		}
		# ����
		else {
			$result = VipUser::ListCard($status, $serial_number, $p, 1000000);
			$result = $result['list'];
			$data = array();
			foreach ($result as $key =>$value){
				$data[$key] = array($value['serial_number'],$value['password'],$value['city'],$value['realname'],empty($value['open_time'])?"":date("Y-m-d",$value['open_time']),empty($value['end_date'])?"":date("Y-m-d",$value['end_date']),$value['vct_name'],$value['create_user']);
			}
			$filename = "��ֵ���б�-".date("Y-m-d",time());
			$title = array("����","����","����","��ֵ��ע","��ֵʱ��","����ʱ��","VIP����","������");
			exportData($filename,$title,$data);
			exit();
		}
        
    }
	
    # ����VIP��
    elseif('ac' == $_A['query_type']) {
        $step = isset($_POST['step'])?(int)$_POST['step']:0;
        if ($step) {
            $index['city'] = (int)$_POST['city'];
            $index['year'] = (int)$_POST['year'];
			$index['semester'] = trim($_POST['semester']);
			$index['number'] = (int)$_POST['number'];
			$index['pwd_word_num'] = (int)$_POST['pwd_word_num'];
            if(!VipUser::AddCard($index)) {
                $msg = array(VipUser::$msg,'','');
            }
            else{
                $msg = array('���ɳɹ�','',"{$_A['query_url']}/lc{$_A['site_url']}");
            }
        }
        else{
			$city = '';
			VipUser::GetCardWord($city);
            $year = date('Y');
			$years = array($year, $year + 1, $year + 2, $year + 3);
			$semester = 0==floor(date('m') / 6)?'A':'B';
			$magic->assign('years', $years);
			$magic->assign('semester', $semester);
			$magic->assign('city', $city);
        }
    }
	
    # �鿴VIP��
    elseif ('preview' == $_A['query_type']) {

        $id = isset($_REQUEST['id'])?(int)$_REQUEST['id']:0;
        if (!$id) {
            $msg = array('ID��Ч','','');
        }
        else{
            $result = VipUser::GetUserCardInfoById($id);
            $magic->assign('result', $result);
        }
    }
    # ɾ��VIP��
    elseif ('delcard' == $_A['query_type']) {
        $ids = isset($_REQUEST['aid'])?$_REQUEST['aid']:array();
		if (!empty ($ids)) {
			if(VipUser::DeleteCard($ids)) {
                $msg = array('ɾ���ɹ�','',"{$_A['query_url']}/lc");
            }
		}
		else {
			$msg = array('��ѡ��Ҫɾ���ļ�¼','',"{$_A['query_url']}/lc");
		}
    }
	
    # ����VIP��Ա
    elseif ('nvipuser' == $_A['query_type']) {

        $id = isset($_GET['id'])?$_GET['id']:0;
        $user_name = isset($_POST['user_name'])?$_POST['user_name']:0;
        $serial_number = isset($_POST['serial_number'])?$_POST['serial_number']:0;
		$vct_id = isset($_POST['vct_id'])?(int)$_POST['vct_id']:0;

        if ($user_name && $serial_number && $vct_id) {
            $result = VipUser::AddVipUser($user_name, $vct_id, $serial_number);

            if (true === $result) {
                $msg = array('�����ɹ�', '', "{$_A['query_url']}/lc");
            }
            elseif (false !== $result) {
                $msg = array($result);
            }
            else {
                $msg = array('����ʧ��');
            }
        }
		else {
			$vct = $mysql->db_fetch_arrays("select id, name from {vip_card_type}");
			$magic->assign('vct', $vct);
			if ($id > 0){
				$row = VipUser::GetUserCardInfoById($id);
				if ($row) {
					$magic->assign('serial_number', $row['serial_number']);
					$magic->assign('password', $row['password']);
				}
			}
		}
    }
	
	# �޸�״̬
	elseif ('editcard' == $_A['query_type']) {
		
		$id = isset($_REQUEST['id'])?(int)$_REQUEST['id']:0;
		$status = isset($_POST['status'])?$_POST['status']:'';
		$year = isset($_POST['year'])?(int)$_POST['year']:'';
		$month = isset($_POST['month'])?(int)$_POST['month']:'';
		
        $remark = isset($_POST['remark'])?trim($_POST['remark']):'';

        if (!$id) {
            $msg = array('��Ч����');
        }
        else {
			$month = $year * 12 + $month;
            switch ($status) {
                # ����
                case 'dj':
                    if ($month <= 0) {
                        $msg = array('����ʱ����Ч');
                        break;
                    }
					$result = VipUser::FreezeCard($id, $month, $remark);
                    if (true === $result){
                        $msg = array($result);
                        break;
                    }
                    $msg = array('�����ɹ�', '', "{$_A['query_url']}/lc");
                    break;
                # ͣ��
                case 'tz':
                    if ($month <= 0) {
                        $msg = array('ͣ��ʱ����Ч');
                        break;
                    }
                    if (!VipUser::StopCard($id, $month, $remark)){
                        $msg = array(VipUser::$msg);
                        break;
                    }
                    $msg = array('�����ɹ�', '', "{$_A['query_url']}/lc");
                    break;
                # ���
                case 'jy':
                    
                    if (!VipUser::InvalidCard($id, $remark)){
                        $msg = array(VipUser::$msg);
                        break;
                    }
                    $msg = array('�����ɹ�', '', "{$_A['query_url']}/lc");
                    break;
                # ����
                case 'jh' :
                     if (!VipUser::ActiveCard($id, $remark)){
                        $msg = array(VipUser::$msg);
                        break;
                     }
                    $msg = array('�����ɹ�', '', "{$_A['query_url']}/lc");
                    break;
				# ����
				case 'yq' :
					if ($month <= 0) {
                        $msg = array('����ʱ����Ч');
                        break;
                    }
					if (VipUser::UpdateExpireDate($id, $month, $remark)){
						$msg = array('�����ɹ�', '', "{$_A['query_url']}/lc");
					}
					else{
						$msg = array(VipUser::$msg);
					}
					break;
               default:
                    $result = VipUser::GetCardInfoById($id);
                    $magic->assign('result', $result);
                    break;
            }
        }
	}
	elseif ('history' == $_A['query_type']) {
		
		$id = isset($_GET['id'])?(int)$_GET['id']:0;
		$p = isset($_REQUEST['page'])?$_REQUEST['page']:1;
		if ($id) {
			$result = VipUser::GetHistory($id, $p);

			$magic->assign('result', $result['list']);
			$page->set_data(array('total'=>$result['record_num'],'perpage'=>$result['page_size']));
			$magic->assign("page",$page->show(3));
		}
		else {
			$msg = array('ID��Ч');
		}
	}
	
	# ��ȡ����VIP��Ա�ĸ�λ
	elseif ('getjob' == $_A['query_type']) {
		require_once ROOT_PATH . '/modules/jianzhi/jianzhi.class.php';
		$user_id = isset($_GET['id'])?(int)$_GET['id']:0;
		$p = isset($_GET['page'])?$_GET['page']:1;
		if ($user_id) {

			$vu = $mysql->db_fetch_array("select card_number from {vip_user} where user_id={$user_id}");
			$vip_user = VipUser::GetVipuserList(array("serial_number"=>$vu['card_number']));
			
			$result = VipUser::GetJobList($user_id, $p);
			$is_working = PartTime::IsWorking($user_id);
			$magic->assign('vip_user', $vip_user['list'][0]);
			$magic->assign('result', $result['list']);
			$magic->assign('user_id', $user_id);
			$magic->assign('is_working', $is_working);
			$pages->set_data(array('total'=>$result['record_num'],'nowindex'=>$_REQUEST['page'],'perpage'=>$result['page_size']));
			$magic->assign("page",$pages->show(3));
		}
		else {
			$msg = array('ID��Ч');
		}
	}
	elseif ('admit' == $_A['query_type']) {
		require_once ROOT_PATH . '/modules/jianzhi/jianzhi.class.php';
		$job_id   = isset($_GET['jid'])?(int)$_GET['jid']:0;
		$user_id = isset($_GET['uid'])?(int)$_GET['uid']:0;
		if ($job_id && $user_id) {
			PartTime::Admit($job_id, array($user_id));
			$msg = array('�����ɹ�','','');
		}
		else {
			$msg = array('ID��Ч');
		}
	}
	elseif ('export' == $_A['query_type']) {
		$result = VipUser::ListCard($status, $serial_number, $p, 1000000);
			$result = $result['list'];
		$filename = "��ֵ���б�-".date("Y-m-d",time());
		$title = array("����","����","����","��ֵ��ע","��ֵʱ��","����ʱ��","VIP����","������");
		exportData($filename,$title,$data);
		exit;
	}

}

?>