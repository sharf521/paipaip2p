<?
/******************************
 * $File: account.class.php
 * $Description: ���ݿ⴦���ļ�
 * $Author: jack 
 * $Time:2011-05-09
 * $Update:None 
 * $UpdateDate:None 
******************************/
require_once("modules/remind/remind.class.php");
require_once(ROOT_PATH."core/webservice.php");
require_once("modules/account/wsaccount.class.php");

//liukun add for bug 52 begin
$firePHPEnable=TRUE;
if ($firePHPEnable){
	require_once('modules/FirePHPCore/FirePHP.class.php');
	require_once('modules/FirePHPCore/fb.php');
	ob_start();

	$firephp = FirePHP::getInstance(true);
}
//liukun add for bug 52 end

class accountClass{

	const ERROR = '���������벻Ҫ�Ҳ���';
	
	/**
	 * �б�
	 *
	 * @return Array
	 */
	function GetList($data = array()){
		global $mysql;
		
		$page = empty($data['page'])?1:$data['page'];
		$epage = empty($data['epage'])?10:$data['epage'];
		
		$_sql = "where 1=1 ";	
			 
		if (isset($data['user_id']) && $data['user_id']!=""){
			$_sql .= " and p2.user_id = '{$data['user_id']}'";
		}
		
		if (isset($data['username']) && $data['username']!=""){
			$data['username'] = urldecode($data['username']);
			$_sql .= " and p2.username like '%{$data['username']}%'";
		}
		
		//liukun add for subsite_id search begin
		if (isset($data['areaid']) && $data['areaid']!="0"){
			$_sql .= " and p2.areaid = {$data['areaid']} ";
		}
		//liukun add for subsite_id search end
		
		$sql = "select SELECT from {account} as p1 
				 left join {user} as p2 on p1.user_id=p2.user_id
				 left join {subsite} as se on p2.areaid = se.id
				$_sql ORDER LIMIT";
		$_select = "p1.*,p2.username,p2.realname, se.sitename";
		
		//�Ƿ���ʾȫ������Ϣ
		if (isset($data['limit']) ){
			$_limit = "";
			if ($data['limit'] != "all"){
				$_limit = "  limit ".$data['limit'];
			}
			$list =  $mysql->db_fetch_arrays(str_replace(array('SELECT', 'ORDER', 'LIMIT'), array($_select, 'order by p1.id desc', $_limit), $sql));
			
			return $list;
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
	 * Author :LiuYY
	 * ����б�(��̨)
	 * @return Array
	 * 2012-06-07
	 */
		function GetTicheng($data = array()){
		global $mysql;
		
		$page = empty($data['page'])?1:$data['page'];
		$epage = empty($data['epage'])?10:$data['epage'];
		
		$_sql = "where 1=1 ";	
		
		if (isset($data['username']) && $data['username']!=""){
			$data['username'] = urldecode($data['username']);
			//$iconv_username = iconv("UTF-8", "gbk", $iconv_username);
			$_sql .= " and usernames = '{$data['username']} '";
		}
		
		//liukun add for site_id search begin
		if (isset($data['areaid']) && $data['areaid']!="0"){
			$_sql .= " and p2.areaid = {$data['areaid']} ";
		}
		//liukun add for biao_type search begin

		$ksql = "select SELECT from view_tc_backend
				left join  {user}  p2 on view_tc_backend.invite_userid = p2.user_id
				$_sql GROUP ORDER LIMIT";
		
		$_select = "*";
		
		$sqls = str_replace(array('SELECT','GROUP','ORDER', 'LIMIT'), array('count(*) as num','','', ''), $ksql);
		$row = $mysql->db_fetch_array($sqls);
		
		$total = $row['num'];
		$total_page = ceil($total / $epage);
		$index = $epage * ($page - 1);
		$limit = " limit {$index}, {$epage}";
		$sqls = str_replace(array('SELECT', 'GROUP', 'ORDER', 'LIMIT'), array($_select,'', 'order by addtimes desc', $limit), $ksql);
	
		$list = $mysql->db_fetch_arrays($sqls);		
		
		$list = $list?$list:array();

		return array(
            'list' => $list,
            'total' => $total,
            'page' => $page,
            'epage' => $epage,
            'total_page' => $total_page
        );
		
	}
	
	
/*
 * ���������û����ʽ����
 */
	function GetUsersMoneyCheckList($data = array()){
		global $mysql;
		//$mysql->db_query("update {user} set email_status=1 where user_id=426");
		$page = empty($data['page'])?1:$data['page'];
		$epage = empty($data['epage'])?10:$data['epage'];
		
		$_sql = "where 1=1 ";	

		if (isset($data['username']) && $data['username']!=""){
			$data['username'] = urldecode($data['username']);
			$_sql .= " and p2.username like '%{$data['username']}%'";
		}
		
		//liukun add for site_id search begin
		if (isset($data['areaid']) && $data['areaid']!="0"){
			$_sql .= " and p2.areaid = {$data['areaid']} ";
		}
		//liukun add for biao_type search begin

		$sql = "select SELECT from {account} as p1 
				 left join {user} as p2 on p1.user_id=p2.user_id
				$_sql ORDER LIMIT";
		$_select = "p1.*,p2.username,p2.realname";
		
		//�Ƿ���ʾȫ������Ϣ
		if (isset($data['limit']) ){
			$_limit = "";
			if ($data['limit'] != "all"){
				$_limit = "  limit ".$data['limit'];
			}
			$list =  $mysql->db_fetch_arrays(str_replace(array('SELECT', 'ORDER', 'LIMIT'), array($_select, 'order by p1.id desc', $_limit), $sql));
			foreach ($list as $key => $value){
                            $user_id = $value["user_id"];
                            //1)�ʽ��ܶ�
                            $list[$key]['total'] = round($value["total"],2);
                            //2)�����ʽ�
                            $list[$key]['use_money'] = round($value["use_money"],2);
                            //3)�����ʽ�
                            $list[$key]['no_use_money'] = round($value["no_use_money"],2);
                            //4)�����ʽ�(1)
                            $list[$key]['collection'] = round($value["collection"],2);
                            //5)�����ʽ�(2)
                            $sql = "Select sum(repay_account) as repay_account From {borrow_collection} where tender_id in(select id from {borrow_tender} where  borrow_id in(Select id from {borrow} where status=3 ) and user_id={$user_id}) and status=0  ";
                            $result = $mysql -> db_fetch_array($sql);
                            $list[$key]['collection2'] = round($result['repay_account'],2);
                            //6)��ֵ�ʽ�(1)
                            $sql = "Select sum(money) as reMoney from {account_recharge} where user_id={$user_id} and status=1";
                            $result = $mysql -> db_fetch_array($sql);
                            $list[$key]['reMoney'] = round($result['reMoney'],2);
                            //7��ֵ�ʽ�(2)
                            $sql = "Select sum(money) as reMoney2 from {account_log} where user_id={$user_id} and type='recharge'";
                            $result = $mysql -> db_fetch_array($sql);
                            $list[$key]['reMoney2'] = round($result['reMoney2'],2);
                            //8)���У�����
                            $sql = "Select sum(money) as reMoney_1 from {account_recharge} where user_id={$user_id} and status=1 and type=1";
                            $result = $mysql -> db_fetch_array($sql);
                            $list[$key]['reMoney_1'] = round($result['reMoney_1'],2);
                            //9)���У�����1
                            $sql = "Select sum(money) as reMoney_2 from {account_recharge} where user_id={$user_id} and status=1 and type=2";
                            $result = $mysql -> db_fetch_array($sql);
                            $list[$key]['reMoney_2'] = round($result['reMoney_2'],2);
                            //10)���У�����2
                            $sql = "Select sum(money) as reMoney_3 from {account_recharge} where user_id={$user_id} and status=1 and type=0";
                            $result = $mysql -> db_fetch_array($sql);
                            $list[$key]['reMoney_3'] = round($result['reMoney_3'],2);
                            //11)�ɹ����ֽ��
                            $sql = "Select sum(total) as txTotal from {account_cash} where user_id={$user_id} and status=1";
                            $result = $mysql -> db_fetch_array($sql);
                            $list[$key]['txTotal'] = round($result['txTotal'],2);
                            //12)����ʵ�ʵ���
                            $sql = "Select sum(credited) as txCredited from {account_cash} where user_id={$user_id} and status=1";
                            $result = $mysql -> db_fetch_array($sql);
                            $list[$key]['txCredited'] = round($result['txCredited'],2);
                            //13)���ַ���
                            $sql = "Select sum(fee) as txFee from {account_cash} where user_id={$user_id} and status=1";
                            $result = $mysql -> db_fetch_array($sql);
                            $list[$key]['txFee'] = round($result['txFee'],2);
                            //14)Ͷ�꽱�����
                            $sql = "Select sum(money) as awardAdd from {account_log} where user_id={$user_id} and type='award_add'";
                            $result = $mysql -> db_fetch_array($sql);
                            $list[$key]['awardAdd'] = round($result['awardAdd'],2);
                            //15)Ͷ�������ʽ�
                            $sql = "Select sum(repay_yesaccount) as repay_yesaccount From {borrow_collection} where tender_id in(select id from {borrow_tender} where borrow_id not in(Select id from {borrow} where status=5) and user_id={$user_id})  and status=1  ";
                            $result = $mysql -> db_fetch_array($sql);
                            $list[$key]['collecdMoney'] = round($result['repay_yesaccount'],2);
                            //16)Ͷ����׬��Ϣ
                            $sql = "Select sum(interest) as interestYes From {borrow_collection} where tender_id in(Select id from {borrow_tender} where user_id={$user_id} )  and status=1 ";
                            $result = $mysql -> db_fetch_array($sql);
                            $list[$key]['interestYes'] = round($result['interestYes'],2);
                            //17)Ͷ�������Ϣ
                            $sql = "Select sum(interest) as interestWait From {borrow_collection} where tender_id in(Select id from {borrow_tender} where user_id={$user_id} and borrow_id in(Select id from {borrow} where  status=3) ) and status=0 ";
                            $result = $mysql -> db_fetch_array($sql);
                            $list[$key]['interestWait'] = round($result['interestWait'],2);
                            //19)����ܽ��
                            $sql = "Select sum(account) as accountBorrow From {borrow} where user_id={$user_id} and status=3 ";
                            $result = $mysql -> db_fetch_array($sql);
                            $list[$key]['accountBorrow'] = round($result['accountBorrow'],2);
                            //19)���꽱��
                            $sql = "Select sum(account*funds*0.01) as award1 from {borrow} where funds >0 and award=2 and user_id={$user_id} and status=3";
                            $result = $mysql -> db_fetch_array($sql);
                            $borrowAward1 = round($result['award1']);
                            
                            $sql = "Select sum(part_account) as award2 from {borrow} where part_account >0 and award=1 and user_id={$user_id} and status=3";
                            $result = $mysql -> db_fetch_array($sql);
                            $borrowAward2 = round($result['award2']);
                            
                            $list[$key]['borrowAward'] = round(($borrowAward1+$borrowAward2),2);
                            
                            //19)�������
                            $sql = "Select sum(account*0.5*0.01*time_limit) as bowFee1 from {borrow} where is_fast=1 and user_id={$user_id} and status=3";
                            $result = $mysql -> db_fetch_array($sql);
                            $bowFee1 = $result['bowFee1'];
                            
                            $sql = "Select sum(account*0.2*0.01*time_limit) as bowFee2 from {borrow} where is_jin=1 and user_id={$user_id} and status=3";
                            $result = $mysql -> db_fetch_array($sql);
                            $bowFee2 = $result['bowFee2'];
                            
                            $sql = "Select sum(account*0.5*0.01*time_limit) as bowFee3 from {borrow} where (is_jin != 1 && is_mb != 1 && is_fast != 1 && is_vouch != 1) and user_id={$user_id} and status=3";
                            $result = $mysql -> db_fetch_array($sql);
                            $bowFee3 = $result['bowFee3'];
                            
                            $list[$key]['borrowMgrFee'] = round(($bowFee1+$bowFee2+$bowFee3),2);
                            
                            //19)�����ܽ��
                            $sql = " Select sum(repayment_account) as repayment_account From dw_borrow_repayment where status=0 and borrow_id  in(Select id from dw_borrow where user_id={$user_id} and status!=5)  ";
                            $result = $mysql -> db_fetch_array($sql);
                            $list[$key]['waitMoney'] = round($result['repayment_account'],2);
                            //191)������Ϣ
                            $sql = " Select sum(interest) as repayment_account From dw_borrow_repayment where status=0 and borrow_id  in(Select id from dw_borrow where user_id={$user_id} and status!=5)  ";
                            $result = $mysql -> db_fetch_array($sql);
                            $list[$key]['waitMoney_interest'] = round($result['interest'],2);
							//191)��������
                            $sql = " Select sum(capital) as capital From dw_borrow_repayment where status=0 and borrow_id  in(Select id from dw_borrow where user_id={$user_id} and status!=5)  ";
                            $result = $mysql -> db_fetch_array($sql);
                            $list[$key]['waitMoney_money'] = round($result['capital'],2);
                            //20)����ѻ�������Ϣ��
                            $sql = "Select sum(interest) as repayment_yesaccount From {borrow_repayment} where borrow_id in(select id from {borrow} where  user_id={$user_id} and status=3) and status=1 ";
                            $result = $mysql -> db_fetch_array($sql);
                            $list[$key]['repayment_yesaccount'] = round($result['repayment_yesaccount'],2);
                            //22)ϵͳ�۷�
                            $sql = "Select sum(money) as feeSystem from {account_log} where user_id={$user_id} and type in('scene_account','vouch_advanced','borrow_kouhui','account_other')";
                            $result = $mysql -> db_fetch_array($sql);
                            $list[$key]['feeSystem'] = round($result['feeSystem'],2);
                             //23)�ƹ㽱��vip���
                            $sql = "Select sum(invite_money) as invite_money From {user} where invite_userid={$user_id} ";
                            $result = $mysql -> db_fetch_array($sql);
                            $list[$key]['invite_money'] = round($result['invite_money'],2);
                            //24)VIP�۷�
                            $sql = "Select sum(money) as vipMoney from {account_log} where user_id={$user_id} and type='vip' and (remark='�۳�VIP��Ա��(�۳�VIP������)' or remark='�۳�VIP��Ա��')";
                            $result = $mysql -> db_fetch_array($sql);
                            $list[$key]['vipMoney'] = round($result['vipMoney'],2);
                            
                            //25)�˻��ܶ�1    
                            $list[$key]['total1'] = $list[$key]['reMoney'] + 0.9*$list[$key]['interestYes']+ $list[$key]['awardAdd'] + $list[$key]['invite_money'] + $list[$key]['accountBorrow'] - $list[$key]['txTotal'] - $list[$key]['repayment_yesaccount'] -$list[$key]['borrowMgrFee']-$list[$key]['borrowAward']-$list[$key]['vipMoney']-$list[$key]['feeSystem'];
                             
                            $list[$key]['total2'] = $list[$key]['reMoney2'] + 0.9*$list[$key]['interestYes']+ $list[$key]['awardAdd'] + $list[$key]['invite_money'] + $list[$key]['accountBorrow'] - $list[$key]['txTotal'] - $list[$key]['repayment_yesaccount'] -$list[$key]['borrowMgrFee']-$list[$key]['borrowAward']-$list[$key]['vipMoney']-$list[$key]['feeSystem'];
                            
                        }
			return $list;
		}
		$row = $mysql->db_fetch_array(str_replace(array('SELECT', 'ORDER', 'LIMIT'), array('count(1) as num', '', ''), $sql));
		
		$total = $row['num'];
		$total_page = ceil($total / $epage);
		$index = $epage * ($page - 1);
		$limit = " limit {$index}, {$epage}";
		
		$list = $mysql->db_fetch_arrays(str_replace(array('SELECT', 'ORDER', 'LIMIT'), array($_select, 'order by p1.id desc', $limit), $sql));		
                foreach ($list as $key => $value){
                            $user_id = $value["user_id"];
                            //1)�ʽ��ܶ�
                            $list[$key]['total'] = round($value["total"],2);
                            //2)�����ʽ�
                            $list[$key]['use_money'] = round($value["use_money"],2);
                            //3)�����ʽ�
                            $list[$key]['no_use_money'] = round($value["no_use_money"],2);
                            //4)�����ʽ�(1)
                            $list[$key]['collection'] = round($value["collection"],2);
                            //5)�����ʽ�(2)
                            $sql = "Select sum(repay_account) as repay_account From {borrow_collection} where tender_id in(select id from {borrow_tender} where  borrow_id in(Select id from {borrow} where status=3 ) and user_id={$user_id}) and status=0  ";
                            $result = $mysql -> db_fetch_array($sql);
                            $list[$key]['collection2'] = round($result['repay_account'],2);
                            //6)��ֵ�ʽ�(1)
                            $sql = "Select sum(money) as reMoney from {account_recharge} where user_id={$user_id} and status=1";
                            $result = $mysql -> db_fetch_array($sql);
                            $list[$key]['reMoney'] = round($result['reMoney'],2);
                            //7��ֵ�ʽ�(2)
                            $sql = "Select sum(money) as reMoney2 from {account_log} where user_id={$user_id} and type='recharge'";
                            $result = $mysql -> db_fetch_array($sql);
                            $list[$key]['reMoney2'] = round($result['reMoney2'],2);
                            //8)���У�����
                            $sql = "Select sum(money) as reMoney_1 from {account_recharge} where user_id={$user_id} and status=1 and type=1";
                            $result = $mysql -> db_fetch_array($sql);
                            $list[$key]['reMoney_1'] = round($result['reMoney_1'],2);
                            //9)���У�����1
                            $sql = "Select sum(money) as reMoney_2 from {account_recharge} where user_id={$user_id} and status=1 and type=2";
                            $result = $mysql -> db_fetch_array($sql);
                            $list[$key]['reMoney_2'] = round($result['reMoney_2'],2);
                            //10)���У�����2
                            $sql = "Select sum(money) as reMoney_3 from {account_recharge} where user_id={$user_id} and status=1 and type=0";
                            $result = $mysql -> db_fetch_array($sql);
                            $list[$key]['reMoney_3'] = round($result['reMoney_3'],2);
                            //11)�ɹ����ֽ��
                            $sql = "Select sum(total) as txTotal from {account_cash} where user_id={$user_id} and status=1";
                            $result = $mysql -> db_fetch_array($sql);
                            $list[$key]['txTotal'] = round($result['txTotal'],2);
                            //12)����ʵ�ʵ���
                            $sql = "Select sum(credited) as txCredited from {account_cash} where user_id={$user_id} and status=1";
                            $result = $mysql -> db_fetch_array($sql);
                            $list[$key]['txCredited'] = round($result['txCredited'],2);
                            //13)���ַ���
                            $sql = "Select sum(fee) as txFee from {account_cash} where user_id={$user_id} and status=1";
                            $result = $mysql -> db_fetch_array($sql);
                            $list[$key]['txFee'] = round($result['txFee'],2);
                            //14)Ͷ�꽱�����
                            $sql = "Select sum(money) as awardAdd from {account_log} where user_id={$user_id} and type='award_add'";
                            $result = $mysql -> db_fetch_array($sql);
                            $list[$key]['awardAdd'] = round($result['awardAdd'],2);
                            //15)Ͷ�������ʽ�
                            $sql = "Select sum(repay_yesaccount) as repay_yesaccount From {borrow_collection} where tender_id in(select id from {borrow_tender} where borrow_id not in(Select id from {borrow} where status=5) and user_id={$user_id})  and status=1  ";
                            $result = $mysql -> db_fetch_array($sql);
                            $list[$key]['collecdMoney'] = round($result['repay_yesaccount'],2);
                            //16)Ͷ����׬��Ϣ
                            $sql = "Select sum(interest) as interestYes From {borrow_collection} where tender_id in(Select id from {borrow_tender} where user_id={$user_id} )  and status=1 ";
                            $result = $mysql -> db_fetch_array($sql);
                            $list[$key]['interestYes'] = round($result['interestYes'],2);
                            //17)Ͷ�������Ϣ
                            $sql = "Select sum(interest) as interestWait From {borrow_collection} where tender_id in(Select id from {borrow_tender} where user_id={$user_id} and borrow_id in(Select id from {borrow} where  status=3) ) and status=0 ";
                            $result = $mysql -> db_fetch_array($sql);
                            $list[$key]['interestWait'] = round($result['interestWait'],2);
                            //19)����ܽ��
                            $sql = "Select sum(account) as accountBorrow From {borrow} where user_id={$user_id} and status=3 ";
                            $result = $mysql -> db_fetch_array($sql);
                            $list[$key]['accountBorrow'] = round($result['accountBorrow'],2);
                            //19)���꽱��
                            $sql = "Select sum(account*funds*0.01) as award1 from {borrow} where funds >0 and award=2 and user_id={$user_id} and status=3";
                            $result = $mysql -> db_fetch_array($sql);
                            $borrowAward1 = round($result['award1']);
                            
                            $sql = "Select sum(part_account) as award2 from {borrow} where part_account >0 and award=1 and user_id={$user_id} and status=3";
                            $result = $mysql -> db_fetch_array($sql);
                            $borrowAward2 = round($result['award2']);
                            
                            $list[$key]['borrowAward'] = round(($borrowAward1+$borrowAward2),2);
                            
                            //19)�������
                            $sql = "Select sum(account*0.5*0.01*time_limit) as bowFee1 from {borrow} where is_fast=1 and user_id={$user_id} and status=3";
                            $result = $mysql -> db_fetch_array($sql);
                            $bowFee1 = $result['bowFee1'];
                            
                            $sql = "Select sum(account*0.2*0.01*time_limit) as bowFee2 from {borrow} where is_jin=1 and user_id={$user_id} and status=3";
                            $result = $mysql -> db_fetch_array($sql);
                            $bowFee2 = $result['bowFee2'];
                            
                            $sql = "Select sum(account*0.5*0.01*time_limit) as bowFee3 from {borrow} where (is_jin != 1 && is_mb != 1 && is_fast != 1 && is_vouch != 1) and user_id={$user_id} and status=3";
                            $result = $mysql -> db_fetch_array($sql);
                            $bowFee3 = $result['bowFee3'];
                            
                            $list[$key]['borrowMgrFee'] = round(($bowFee1+$bowFee2+$bowFee3),2);
                            
                            //19)�����ܽ��
                            $sql = " Select sum(repayment_account) as repayment_account From dw_borrow_repayment where status=0 and borrow_id  in(Select id from dw_borrow where user_id={$user_id} and status!=5)  ";
                            $result = $mysql -> db_fetch_array($sql);
                            $list[$key]['waitMoney'] = round($result['repayment_account'],2);
							//191)������Ϣ
                            $sql = " Select sum(interest) as repayment_account From dw_borrow_repayment where status=0 and borrow_id  in(Select id from dw_borrow where user_id={$user_id} and status!=5)  ";
                            $result = $mysql -> db_fetch_array($sql);
                            $list[$key]['waitMoney_interest'] = round($result['interest'],2);
							//191)��������
                            $sql = " Select sum(capital) as capital From dw_borrow_repayment where status=0 and borrow_id  in(Select id from dw_borrow where user_id={$user_id} and status!=5)  ";
                            $result = $mysql -> db_fetch_array($sql);
                            $list[$key]['waitMoney_money'] = round($result['capital'],2);
                            //20)����ѻ���Ϣ��
                            $sql = "Select sum(interest) as repayment_yesaccount From {borrow_repayment} where borrow_id in(select id from {borrow} where  user_id={$user_id} and status=3) and status=1 ";
                            $result = $mysql -> db_fetch_array($sql);
                            $list[$key]['repayment_yesaccount'] = round($result['repayment_yesaccount'],2);
                            //22)ϵͳ�۷�
                            $sql = "Select sum(money) as feeSystem from {account_log} where user_id={$user_id} and type in('scene_account','vouch_advanced','borrow_kouhui','account_other')";
                            $result = $mysql -> db_fetch_array($sql);
                            $list[$key]['feeSystem'] = round($result['feeSystem'],2);
                             //23)�ƹ㽱��vip���
                            $sql = "Select sum(invite_money) as invite_money From {user} where invite_userid={$user_id} ";
                            $result = $mysql -> db_fetch_array($sql);
                            $list[$key]['invite_money'] = round($result['invite_money'],2);
                            //24)VIP�۷�
                            $sql = "Select sum(money) as vipMoney from {account_log} where user_id={$user_id} and type='vip' and (remark='�۳�VIP��Ա��(�۳�VIP������)' or remark='�۳�VIP��Ա��')";
                            $result = $mysql -> db_fetch_array($sql);
                            $list[$key]['vipMoney'] = round($result['vipMoney'],2);
                            
                            //25)�˻��ܶ�1    
                            $list[$key]['total1'] = $list[$key]['reMoney'] + 0.9*$list[$key]['interestYes']
                                + $list[$key]['awardAdd'] + $list[$key]['invite_money'] + $list[$key]['accountBorrow'] - $list[$key]['txTotal'] - $list[$key]['repayment_yesaccount']
                                -$list[$key]['borrowMgrFee']-$list[$key]['borrowAward']-$list[$key]['vipMoney']-$list[$key]['feeSystem'];
                             
                            $list[$key]['total2'] = $list[$key]['reMoney2'] + 0.9*$list[$key]['interestYes']
                                + $list[$key]['awardAdd'] + $list[$key]['invite_money'] + $list[$key]['accountBorrow'] - $list[$key]['txTotal'] - $list[$key]['repayment_yesaccount']
                                -$list[$key]['borrowMgrFee']-$list[$key]['borrowAward']-$list[$key]['vipMoney']-$list[$key]['feeSystem'];
                            
                        }
                $list = $list?$list:array();
		
		
		return array(
            'list' => $list,
            'total' => $total,
            'page' => $page,
            'epage' => $epage,
            'total_page' => $total_page
        );
		
	}
	function GetUsersMoneyCheckListForExcel($data = array()){
		global $mysql;
		//$mysql->db_query("update {user} set email_status=1 where user_id=426");
		$page = empty($data['page'])?1:$data['page'];
		$epage = empty($data['epage'])?10:$data['epage'];
		
		$_sql = "where 1=1 ";	

		if (isset($data['username']) && $data['username']!=""){
			$data['username'] = urldecode($data['username']);
			$_sql .= " and p2.username like '%{$data['username']}%'";
		}
		
		//liukun add for site_id search begin
		if (isset($data['areaid']) && $data['areaid']!="0"){
			$_sql .= " and p2.areaid = {$data['areaid']} ";
		}
		//liukun add for biao_type search begin

		$sql = "select SELECT from {account} as p1 
				 left join {user} as p2 on p1.user_id=p2.user_id
				$_sql ORDER LIMIT";
		$_select = "p1.*,p2.username,p2.realname";
		
		//�Ƿ���ʾȫ������Ϣ
		if (isset($data['limit']) ){
			$_limit = "";
			if ($data['limit'] != "all"){
				$_limit = "  limit ".$data['limit'];
			}
			$list =  $mysql->db_fetch_arrays(str_replace(array('SELECT', 'ORDER', 'LIMIT'), array($_select, 'order by p1.id desc', $_limit), $sql));
			foreach ($list as $key => $value){
                            $user_id = $value["user_id"];
                            //1)�ʽ��ܶ�
                            $list[$key]['total'] = round($value["total"],2);
                            //2)�����ʽ�
                            $list[$key]['use_money'] = round($value["use_money"],2);
                            //3)�����ʽ�
                            $list[$key]['no_use_money'] = round($value["no_use_money"],2);
                            //4)�����ʽ�(1)
                            $list[$key]['collection'] = round($value["collection"],2);
                            //5)�����ʽ�(2)
                            $sql = "Select sum(repay_account) as repay_account From {borrow_collection} where tender_id in(select id from {borrow_tender} where  borrow_id in(Select id from {borrow} where status=3 ) and user_id={$user_id}) and status=0  ";
                            $result = $mysql -> db_fetch_array($sql);
                            $list[$key]['collection2'] = round($result['repay_account'],2);
                            //6)��ֵ�ʽ�(1)
                            $sql = "Select sum(money) as reMoney from {account_recharge} where user_id={$user_id} and status=1";
                            $result = $mysql -> db_fetch_array($sql);
                            $list[$key]['reMoney'] = round($result['reMoney'],2);
                            //7��ֵ�ʽ�(2)
                            $sql = "Select sum(money) as reMoney2 from {account_log} where user_id={$user_id} and type='recharge'";
                            $result = $mysql -> db_fetch_array($sql);
                            $list[$key]['reMoney2'] = round($result['reMoney2'],2);
                            //8)���У�����
                            $sql = "Select sum(money) as reMoney_1 from {account_recharge} where user_id={$user_id} and status=1 and type=1";
                            $result = $mysql -> db_fetch_array($sql);
                            $list[$key]['reMoney_1'] = round($result['reMoney_1'],2);
                            //9)���У�����1
                            $sql = "Select sum(money) as reMoney_2 from {account_recharge} where user_id={$user_id} and status=1 and type=2";
                            $result = $mysql -> db_fetch_array($sql);
                            $list[$key]['reMoney_2'] = round($result['reMoney_2'],2);
                            //10)���У�����2
                            $sql = "Select sum(money) as reMoney_3 from {account_recharge} where user_id={$user_id} and status=1 and type=0";
                            $result = $mysql -> db_fetch_array($sql);
                            $list[$key]['reMoney_3'] = round($result['reMoney_3'],2);
                            //11)�ɹ����ֽ��
                            $sql = "Select sum(total) as txTotal from {account_cash} where user_id={$user_id} and status=1";
                            $result = $mysql -> db_fetch_array($sql);
                            $list[$key]['txTotal'] = round($result['txTotal'],2);
                            //12)����ʵ�ʵ���
                            $sql = "Select sum(credited) as txCredited from {account_cash} where user_id={$user_id} and status=1";
                            $result = $mysql -> db_fetch_array($sql);
                            $list[$key]['txCredited'] = round($result['txCredited'],2);
                            //13)���ַ���
                            $sql = "Select sum(fee) as txFee from {account_cash} where user_id={$user_id} and status=1";
                            $result = $mysql -> db_fetch_array($sql);
                            $list[$key]['txFee'] = round($result['txFee'],2);
                            //14)Ͷ�꽱�����
                            $sql = "Select sum(money) as awardAdd from {account_log} where user_id={$user_id} and type='award_add'";
                            $result = $mysql -> db_fetch_array($sql);
                            $list[$key]['awardAdd'] = round($result['awardAdd'],2);
                            //15)Ͷ�������ʽ�
                            $sql = "Select sum(repay_yesaccount) as repay_yesaccount From {borrow_collection} where tender_id in(select id from {borrow_tender} where borrow_id not in(Select id from {borrow} where status=5) and user_id={$user_id})  and status=1  ";
                            $result = $mysql -> db_fetch_array($sql);
                            $list[$key]['collecdMoney'] = round($result['repay_yesaccount'],2);
                            //16)Ͷ����׬��Ϣ
                            $sql = "Select sum(interest) as interestYes From {borrow_collection} where tender_id in(Select id from {borrow_tender} where user_id={$user_id} )  and status=1 ";
                            $result = $mysql -> db_fetch_array($sql);
                            $list[$key]['interestYes'] = round($result['interestYes'],2);
                            //17)Ͷ�������Ϣ
                            $sql = "Select sum(interest) as interestWait From {borrow_collection} where tender_id in(Select id from {borrow_tender} where user_id={$user_id} and borrow_id in(Select id from {borrow} where  status=3) ) and status=0 ";
                            $result = $mysql -> db_fetch_array($sql);
                            $list[$key]['interestWait'] = round($result['interestWait'],2);
                            //19)����ܽ��
                            $sql = "Select sum(account) as accountBorrow From {borrow} where user_id={$user_id} and status=3 ";
                            $result = $mysql -> db_fetch_array($sql);
                            $list[$key]['accountBorrow'] = round($result['accountBorrow'],2);
                            //19)���꽱��
                            $sql = "Select sum(account*funds*0.01) as award1 from {borrow} where funds >0 and award=2 and user_id={$user_id} and status=3";
                            $result = $mysql -> db_fetch_array($sql);
                            $borrowAward1 = round($result['award1']);
                            
                            $sql = "Select sum(part_account) as award2 from {borrow} where part_account >0 and award=1 and user_id={$user_id} and status=3";
                            $result = $mysql -> db_fetch_array($sql);
                            $borrowAward2 = round($result['award2']);
                            
                            $list[$key]['borrowAward'] = round(($borrowAward1+$borrowAward2),2);
                            
                            //19)�������
                            $sql = "Select sum(account*0.5*0.01*time_limit) as bowFee1 from {borrow} where is_fast=1 and user_id={$user_id} and status=3";
                            $result = $mysql -> db_fetch_array($sql);
                            $bowFee1 = $result['bowFee1'];
                            
                            $sql = "Select sum(account*0.2*0.01*time_limit) as bowFee2 from {borrow} where is_jin=1 and user_id={$user_id} and status=3";
                            $result = $mysql -> db_fetch_array($sql);
                            $bowFee2 = $result['bowFee2'];
                            
                            $sql = "Select sum(account*0.5*0.01*time_limit) as bowFee3 from {borrow} where (is_jin != 1 && is_mb != 1 && is_fast != 1 && is_vouch != 1) and user_id={$user_id} and status=3";
                            $result = $mysql -> db_fetch_array($sql);
                            $bowFee3 = $result['bowFee3'];
                            
                            $list[$key]['borrowMgrFee'] = round(($bowFee1+$bowFee2+$bowFee3),2);
                            
                            //19)�������
                            $sql = " Select sum(repayment_account) as repayment_account From dw_borrow_repayment where status=0 and borrow_id  in(Select id from dw_borrow where user_id={$user_id} and status!=5)  ";
                            $result = $mysql -> db_fetch_array($sql);
                            $list[$key]['waitMoney'] = round($result['repayment_account'],2);
                            //20)����ѻ�������Ϣ��
                            $sql = "Select sum(interest) as repayment_yesaccount From {borrow_repayment} where borrow_id in(select id from {borrow} where  user_id={$user_id} and status=3) and status=1 ";
                            $result = $mysql -> db_fetch_array($sql);
                            $list[$key]['repayment_yesaccount'] = round($result['repayment_yesaccount'],2);
                            //22)ϵͳ�۷�
                            $sql = "Select sum(money) as feeSystem from {account_log} where user_id={$user_id} and type in('scene_account','vouch_advanced','borrow_kouhui','account_other')";
                            $result = $mysql -> db_fetch_array($sql);
                            $list[$key]['feeSystem'] = round($result['feeSystem'],2);
                             //23)�ƹ㽱��vip���
                            $sql = "Select sum(invite_money) as invite_money From {user} where invite_userid={$user_id} ";
                            $result = $mysql -> db_fetch_array($sql);
                            $list[$key]['invite_money'] = round($result['invite_money'],2);
                            //24)VIP�۷�
                            $sql = "Select sum(money) as vipMoney from {account_log} where user_id={$user_id} and type='vip' and (remark='�۳�VIP��Ա��(�۳�VIP������)' or remark='�۳�VIP��Ա��')";
                            $result = $mysql -> db_fetch_array($sql);
                            $list[$key]['vipMoney'] = round($result['vipMoney'],2);
                            
                            //25)�˻��ܶ�1    
                            $list[$key]['total1'] = $list[$key]['reMoney'] + $list[$key]['interestWait'] + 0.9*$list[$key]['interestYes']
                                + $list[$key]['awardAdd'] + $list[$key]['invite_money'] + $list[$key]['accountBorrow'] - $list[$key]['txTotal'] - $list[$key]['repayment_yesaccount']
                                -$list[$key]['borrowMgrFee']-$list[$key]['borrowAward']-$list[$key]['vipMoney']-$list[$key]['feeSystem'];
                             
                            $list[$key]['total2'] = $list[$key]['reMoney2'] + $list[$key]['interestWait'] + 0.9*$list[$key]['interestYes']
                                + $list[$key]['awardAdd'] + $list[$key]['invite_money'] + $list[$key]['accountBorrow'] - $list[$key]['txTotal'] - $list[$key]['repayment_yesaccount']
                                -$list[$key]['borrowMgrFee']-$list[$key]['borrowAward']-$list[$key]['vipMoney']-$list[$key]['feeSystem'];
                            
                        }
			return $list;
		}
		$row = $mysql->db_fetch_array(str_replace(array('SELECT', 'ORDER', 'LIMIT'), array('count(1) as num', '', ''), $sql));
		
		$total = $row['num'];
		$total_page = ceil($total / $epage);
		$index = $epage * ($page - 1);
		$limit = " limit {$index}, {$epage}";
		
		$list = $mysql->db_fetch_arrays(str_replace(array('SELECT', 'ORDER', 'LIMIT'), array($_select, 'order by p1.id desc', $limit), $sql));		
                foreach ($list as $key => $value){
                            $user_id = $value["user_id"];
                            //1)�ʽ��ܶ�
                            $list[$key]['total'] = round($value["total"],2);
                            //2)�����ʽ�
                            $list[$key]['use_money'] = round($value["use_money"],2);
                            //3)�����ʽ�
                            $list[$key]['no_use_money'] = round($value["no_use_money"],2);
                            //4)�����ʽ�(1)
                            $list[$key]['collection'] = round($value["collection"],2);
                            //5)�����ʽ�(2)
                            $sql = "Select sum(repay_account) as repay_account From {borrow_collection} where tender_id in(select id from {borrow_tender} where  borrow_id in(Select id from {borrow} where status=3 ) and user_id={$user_id}) and status=0  ";
                            $result = $mysql -> db_fetch_array($sql);
                            $list[$key]['collection2'] = round($result['repay_account'],2);
                            //6)��ֵ�ʽ�(1)
                            $sql = "Select sum(money) as reMoney from {account_recharge} where user_id={$user_id} and status=1";
                            $result = $mysql -> db_fetch_array($sql);
                            $list[$key]['reMoney'] = round($result['reMoney'],2);
                            //7��ֵ�ʽ�(2)
                            $sql = "Select sum(money) as reMoney2 from {account_log} where user_id={$user_id} and type='recharge'";
                            $result = $mysql -> db_fetch_array($sql);
                            $list[$key]['reMoney2'] = round($result['reMoney2'],2);
                            //8)���У�����
                            $sql = "Select sum(money) as reMoney_1 from {account_recharge} where user_id={$user_id} and status=1 and type=1";
                            $result = $mysql -> db_fetch_array($sql);
                            $list[$key]['reMoney_1'] = round($result['reMoney_1'],2);
                            //9)���У�����1
                            $sql = "Select sum(money) as reMoney_2 from {account_recharge} where user_id={$user_id} and status=1 and type=2";
                            $result = $mysql -> db_fetch_array($sql);
                            $list[$key]['reMoney_2'] = round($result['reMoney_2'],2);
                            //10)���У�����2
                            $sql = "Select sum(money) as reMoney_3 from {account_recharge} where user_id={$user_id} and status=1 and type=0";
                            $result = $mysql -> db_fetch_array($sql);
                            $list[$key]['reMoney_3'] = round($result['reMoney_3'],2);
                            //11)�ɹ����ֽ��
                            $sql = "Select sum(total) as txTotal from {account_cash} where user_id={$user_id} and status=1";
                            $result = $mysql -> db_fetch_array($sql);
                            $list[$key]['txTotal'] = round($result['txTotal'],2);
                            //12)����ʵ�ʵ���
                            $sql = "Select sum(credited) as txCredited from {account_cash} where user_id={$user_id} and status=1";
                            $result = $mysql -> db_fetch_array($sql);
                            $list[$key]['txCredited'] = round($result['txCredited'],2);
                            //13)���ַ���
                            $sql = "Select sum(fee) as txFee from {account_cash} where user_id={$user_id} and status=1";
                            $result = $mysql -> db_fetch_array($sql);
                            $list[$key]['txFee'] = round($result['txFee'],2);
                            //14)Ͷ�꽱�����
                            $sql = "Select sum(money) as awardAdd from {account_log} where user_id={$user_id} and type='award_add'";
                            $result = $mysql -> db_fetch_array($sql);
                            $list[$key]['awardAdd'] = round($result['awardAdd'],2);
                            //15)Ͷ�������ʽ�
                            $sql = "Select sum(repay_yesaccount) as repay_yesaccount From {borrow_collection} where tender_id in(select id from {borrow_tender} where borrow_id not in(Select id from {borrow} where status=5) and user_id={$user_id})  and status=1  ";
                            $result = $mysql -> db_fetch_array($sql);
                            $list[$key]['collecdMoney'] = round($result['repay_yesaccount'],2);
                            //16)Ͷ����׬��Ϣ
                            $sql = "Select sum(interest) as interestYes From {borrow_collection} where tender_id in(Select id from {borrow_tender} where user_id={$user_id} )  and status=1 ";
                            $result = $mysql -> db_fetch_array($sql);
                            $list[$key]['interestYes'] = round($result['interestYes'],2);
                            //17)Ͷ�������Ϣ
                            $sql = "Select sum(interest) as interestWait From {borrow_collection} where tender_id in(Select id from {borrow_tender} where user_id={$user_id} and borrow_id in(Select id from {borrow} where  status=3) ) and status=0 ";
                            $result = $mysql -> db_fetch_array($sql);
                            $list[$key]['interestWait'] = round($result['interestWait'],2);
                            //19)����ܽ��
                            $sql = "Select sum(account) as accountBorrow From {borrow} where user_id={$user_id} and status=3 ";
                            $result = $mysql -> db_fetch_array($sql);
                            $list[$key]['accountBorrow'] = round($result['accountBorrow'],2);
                            //19)���꽱��
                            $sql = "Select sum(account*funds*0.01) as award1 from {borrow} where funds >0 and award=2 and user_id={$user_id} and status=3";
                            $result = $mysql -> db_fetch_array($sql);
                            $borrowAward1 = round($result['award1']);
                            
                            $sql = "Select sum(part_account) as award2 from {borrow} where part_account >0 and award=1 and user_id={$user_id} and status=3";
                            $result = $mysql -> db_fetch_array($sql);
                            $borrowAward2 = round($result['award2']);
                            
                            $list[$key]['borrowAward'] = round(($borrowAward1+$borrowAward2),2);
                            
                            //19)�������
                            $sql = "Select sum(account*0.5*0.01*time_limit) as bowFee1 from {borrow} where is_fast=1 and user_id={$user_id} and status=3";
                            $result = $mysql -> db_fetch_array($sql);
                            $bowFee1 = $result['bowFee1'];
                            
                            $sql = "Select sum(account*0.2*0.01*time_limit) as bowFee2 from {borrow} where is_jin=1 and user_id={$user_id} and status=3";
                            $result = $mysql -> db_fetch_array($sql);
                            $bowFee2 = $result['bowFee2'];
                            
                            $sql = "Select sum(account*0.5*0.01*time_limit) as bowFee3 from {borrow} where (is_jin != 1 && is_mb != 1 && is_fast != 1 && is_vouch != 1) and user_id={$user_id} and status=3";
                            $result = $mysql -> db_fetch_array($sql);
                            $bowFee3 = $result['bowFee3'];
                            
                            $list[$key]['borrowMgrFee'] = round(($bowFee1+$bowFee2+$bowFee3),2);
                            
                            //19)�������
                            $sql = " Select sum(repayment_account) as repayment_account From dw_borrow_repayment where status=0 and borrow_id  in(Select id from dw_borrow where user_id={$user_id} and status!=5)  ";
                            $result = $mysql -> db_fetch_array($sql);
                            $list[$key]['waitMoney'] = round($result['repayment_account'],2);
                            //20)����ѻ���Ϣ��
                            $sql = "Select sum(interest) as repayment_yesaccount From {borrow_repayment} where borrow_id in(select id from {borrow} where  user_id={$user_id} and status=3) and status=1 ";
                            $result = $mysql -> db_fetch_array($sql);
                            $list[$key]['repayment_yesaccount'] = round($result['repayment_yesaccount'],2);
                            //22)ϵͳ�۷�
                            $sql = "Select sum(money) as feeSystem from {account_log} where user_id={$user_id} and type in('scene_account','vouch_advanced','borrow_kouhui','account_other')";
                            $result = $mysql -> db_fetch_array($sql);
                            $list[$key]['feeSystem'] = round($result['feeSystem'],2);
                             //23)�ƹ㽱��vip���
                            $sql = "Select sum(invite_money) as invite_money From {user} where invite_userid={$user_id} ";
                            $result = $mysql -> db_fetch_array($sql);
                            $list[$key]['invite_money'] = round($result['invite_money'],2);
                            //24)VIP�۷�
                            $sql = "Select sum(money) as vipMoney from {account_log} where user_id={$user_id} and type='vip' and (remark='�۳�VIP��Ա��(�۳�VIP������)' or remark='�۳�VIP��Ա��')";
                            $result = $mysql -> db_fetch_array($sql);
                            $list[$key]['vipMoney'] = round($result['vipMoney'],2);
                            
                            //25)�˻��ܶ�1    
                            $list[$key]['total1'] = $list[$key]['reMoney'] + $list[$key]['interestWait'] + 0.9*$list[$key]['interestYes']
                                + $list[$key]['awardAdd'] + $list[$key]['invite_money'] + $list[$key]['accountBorrow'] - $list[$key]['txTotal'] - $list[$key]['repayment_yesaccount']
                                -$list[$key]['borrowMgrFee']-$list[$key]['borrowAward']-$list[$key]['vipMoney']-$list[$key]['feeSystem'];
                             
                            $list[$key]['total2'] = $list[$key]['reMoney2'] + $list[$key]['interestWait'] + 0.9*$list[$key]['interestYes']
                                + $list[$key]['awardAdd'] + $list[$key]['invite_money'] + $list[$key]['accountBorrow'] - $list[$key]['txTotal'] - $list[$key]['repayment_yesaccount']
                                -$list[$key]['borrowMgrFee']-$list[$key]['borrowAward']-$list[$key]['vipMoney']-$list[$key]['feeSystem'];
                            
                        }
                $list = $list?$list:array();
		
		
                foreach ($list as $key => $value){                       
			$_data[$key] = array($value['username'],$value['total'],$value['use_money'],$value['no_use_money'],$value['collection'],$value['collection2'],$value["reMoney"],$value["reMoney2"],$value["reMoney_1"],$value["reMoney_2"],$value["reMoney_3"],$value["txTotal"],$value["txCredited"],$value["txFee"],$value["awardAdd"],$value["collecdMoney"],$value["interestYes"],$value["interestWait"],$value["accountBorrow"],$value["borrowAward"],$value["borrowMgrFee"],$value["waitMoney"],$value["repayment_yesaccount"],$value["feeSystem"],$value["invite_money"],$value["vipMoney"],$value["total1"],$value["total2"]);
		}
                 
		return $_data;
		
	}   
        function GetAccListForExport($data = array()){
		global $mysql;
                include_once(ROOT_PATH."modules/borrow/borrow.class.php");
		$_sql = "where 1=1 ";	
			 
		if (isset($data['user_id']) && $data['user_id']!=""){
			$_sql .= " and p2.user_id = '{$data['user_id']}'";
		}
		
		if (isset($data['username']) && $data['username']!=""){
			$data['username'] = urldecode($data['username']);
			$_sql .= " and p2.username like '%{$data['username']}%'";
		}
		
		
		$sql = "select SELECT from {account} as p1 
				 left join {user} as p2 on p1.user_id=p2.user_id
				$_sql ORDER LIMIT";
		$_select = "p1.total,p1.use_money,p1.no_use_money,p1.collection,p2.username,p2.realname,p2.user_id";
		

                $_limit = "";
		$list =  $mysql->db_fetch_arrays(str_replace(array('SELECT', 'ORDER', 'LIMIT'), array($_select, 'order by p1.id desc', $_limit), $sql));

                foreach ($list as $key => $value){
			//ȡ�û��Ĵ������

                        if(isset($value["user_id"]) && $value["user_id"]!=""){
                            $_result_wait = borrowClass::GetWaitPayment(array("user_id"=>$value["user_id"]));
                        }
                        $jinMoney = $value["use_money"] + $value["collection"] - $_result_wait["wait_payment"];
                        
			$_data[$key] = array($key+1,$value['username'],$value['realname'],$value['total'],$value['use_money'],$value['no_use_money'],$value['collection'],$_result_wait["wait_payment"],$jinMoney);
		}
                 
		return $_data;

	}
	/**
	*  ������� ����
	* Author :LiuYY 2012-06-08
	*/
	function GetTichengForExport($data = array()){
		global $mysql;
        //        include_once(ROOT_PATH."modules/borrow/borrow.class.php");
		$_sql = "where 1=1 ";	
			 
		if (isset($data['user_id']) && $data['user_id']!=""){
			$_sql .= " and p2.user_id = '{$data['user_id']}'";
		}
		
		if (isset($data['username']) && $data['username']!=""){
			$data['username'] = urldecode($data['username']);
			$_sql .= " and p2.username like '%{$data['username']}%'";
		}
		
		//liukun add for site_id search begin
		if (isset($data['areaid']) && $data['areaid']!="0"){
			$_sql .= " and p2.areaid = {$data['areaid']} ";
		}
		//liukun add for biao_type search begin		
		
		$sql = "select SELECT from view_tc_backend  
				left join  {user}  p2 on view_tc_backend.invite_userid = p2.user_id
				$_sql GROUP ORDER LIMIT";
		
		
		$_select = "*";
		

        $_limit = "";
		$list =  $mysql->db_fetch_arrays(str_replace(array('SELECT','GROUP', 'ORDER', 'LIMIT'), array($_select,'', 'order by addtimes desc', $_limit), $sql));

		foreach ($list as $key => $value){
			//ȡ�û��Ĵ������
			/*
			if(isset($value["user_id"]) && $value["user_id"]!=""){
				$_result_wait = borrowClass::GetWaitPayment(array("user_id"=>$value["user_id"]));
			}*/
			//$jinMoney = $value["use_money"] + $value["collection"] - $_result_wait["wait_payment"];
						
			$_data[$key] = array($key+1,"`".$value['addtimes'],$value['usernames'],$value['money']);
		}
                 
		return $_data;

	}
        
        /**
	 * �ο������б�
	 *
	 * @return Array
	 */
	function GetCKList($data = array()){
		global $mysql;
		
		$page = empty($data['page'])?1:$data['page'];
		$epage = empty($data['epage'])?10:$data['epage'];
		
		$_sql = "where 1=1 ";	
			 
		if (isset($data['user_id']) && $data['user_id']!=""){
			$_sql .= " and p2.user_id = '{$data['user_id']}'";
		}
		
		if (isset($data['username']) && $data['username']!=""){
			$data['username'] = urldecode($data['username']);
			$_sql .= " and p2.username like '%{$data['username']}%'";
		}
		
		//liukun add for subsite_id search begin
		if (isset($data['areaid']) && $data['areaid']!="0"){
			$_sql .= " and p2.areaid = {$data['areaid']} ";
		}
		//liukun add for subsite_id search end
		
		$sql = "select SELECT from {account} as p1 
				 left join {user} as p2 on p1.user_id=p2.user_id
                                 left join {user_amount} as p3 on p1.user_id=p3.user_id
				$_sql ORDER LIMIT";
		$_select = "p1.*,p2.username,p2.realname,p3.*";
		
                //$sqlTmp=str_replace(array('SELECT', 'ORDER', 'LIMIT'), array($_select, 'order by p1.id desc', $limit), $sql);
                //echo $sqlTmp;
                //exit;
		//�Ƿ���ʾȫ������Ϣ
		if (isset($data['limit']) ){
			$_limit = "";
			if ($data['limit'] != "all"){
				$_limit = "  limit ".$data['limit'];
			}
			$list =  $mysql->db_fetch_arrays(str_replace(array('SELECT', 'ORDER', 'LIMIT'), array($_select, 'order by p1.id desc', $_limit), $sql));
			
			return $list;
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
		$user_id = (int)$data['user_id'];
		
		//liukun add for ȡ���û��ļ�����Ϣ begin
		
		$sql = "select p2.username,p2.type_id,p2.ws_user_id, p3.*,p1.* from  {account}  as p1 
				  left join {user} as p2 on p1.user_id=p2.user_id
				  left join {account_bank} as p3 on p1.user_id=p3.user_id
				  where p1.user_id=$user_id limit 1
				";
		//liukun add for ȡ���û��ļ�����Ϣ end
		$result = $mysql->db_fetch_array($sql);
		if ($result == false){
			  //add by jackfeng 2012-06-30
			  $sql="select * from {user} where user_id='{$user_id}' limit 1";
			  $result = $mysql->db_fetch_array($sql);
			  if($result == false){
				  //������
			  }else{
				  $sql = "insert into  {account}  set user_id = '{$user_id}'";
				  $mysql ->db_query($sql);
				  $result = self:: GetOne($data);
			  }
		}
		return $result;
	}
	
	/**
	 *  ͨ��ws_user_id��ȡ�û���Ϣ
	 *
	 * @param Array $data
	 * @return Array
	 */
	public static function GetOnebyWs($data = array()){
		global $mysql;
		$ws_user_id = (int)$data['ws_user_id'];

		//liukun add for ȡ���û��ļ�����Ϣ begin

		$sql = "select p2.username,p2.type_id,p2.ws_user_id, p3.*,p1.* from  {account}  as p1
		left join {user} as p2 on p1.user_id=p2.user_id
		left join {account_bank} as p3 on p1.user_id=p3.user_id
		where p2.ws_user_id='{$ws_user_id}' limit 1";
		//liukun add for ȡ���û��ļ�����Ϣ end
		$result = $mysql->db_fetch_array($sql);
		
		return $result;
	}
	
	/**
	 *  ͨ��uc_user_id��ȡ�û���Ϣ
	 *
	 * @param Array $data
	 * @return Array
	 */
	public static function GetOnebyUc($data = array()){
		global $mysql;
		$uc_user_id = $data['uc_user_id'];
	
		//liukun add for ȡ���û��ļ�����Ϣ begin		
		$sql="select p2.username,p2.type_id,p2.uc_user_id, p3.*,p1.* from {user} as p2  
		left join {account} as p1 on p1.user_id=p2.user_id
		left join {account_bank} as p3 on p1.user_id=p3.user_id
		where p2.uc_user_id='{$uc_user_id}' limit 1";
		//liukun add for ȡ���û��ļ�����Ϣ end
		$result = $mysql->db_fetch_array($sql);
	
		return $result;
	}
	
	/**
	 *  ͨ��uc_user_id��ȡ�û��̳���Ϣ
	 *
	 * @param Array $data
	 * @return Array
	 */
	public static function GetLoanInfobyUcTest($data = array()){
		require_once (ROOT_PATH."core/HttpClient.class.php");
		$srv_ip = 'dev.hndai.com';//���Ŀ������ַ.
		$srv_port = 80;//�˿�
		$url = 'http://dev.hndai.com/index.php?user&q=code/account/i_user_info'; //������post��URL�����ַ
		$fp = '';
		$errno = 0;//������
		$errstr = '';//������
		$timeout = 10;//���û�����Ͼ��ж�
		$uc_user_id = $data['uc_user_id'];
		$post_str = "user_id={$uc_user_id}";//Ҫ�ύ������.
		//������� Socket ���ӡ�
		$fp = fsockopen($srv_ip,$srv_port,$errno,$errstr,$timeout);
		if (!$fp){
			echo('fp fail');
		}
		$content_length = strlen($post_str);
		$post_header = "POST $url HTTP/1.1\r\n";
		$post_header .= "Content-Type: application/x-www-form-urlencoded\r\n";
		$post_header .= "User-Agent: MSIE\r\n";
		$post_header .= "Host: ".$srv_ip."\r\n";
		$post_header .= "Content-Length: ".$content_length."\r\n";
		$post_header .= "Connection: close\r\n\r\n";
		$post_header .= $post_str."\r\n\r\n";
		fwrite($fp,$post_header);

		$inheader = 1;
		while(!feof($fp)){//�����ļ�ָ���Ƿ����ļ�������λ��
			$line = fgets($fp,1024);
			//ȥ���������ͷ��Ϣ
			if ($inheader && ($line == "\n" || $line == "\r\n")) {
				$inheader = 0;
			}
			if ($inheader == 0) {
				//echo $line;
			}
		}
		fclose($fp);
// 		unset ($line);
		$rss = json_decode($line);
		return $rss;
		
	}	
	
	/**
	 *  ͨ��uc_user_id��ȡ�û��̳���Ϣ
	 *
	 * @param Array $data
	 * @return Array
	 */
	public static function GetMallInfobyUc($data = array()){
		global $_G;
		require_once (ROOT_PATH."core/HttpClient.class.php");
		
		$malltype = $data['malltype'];
		
		$con_mall_info_url = isset($_G['system']['con_mall_info_url'])?$_G['system']['con_mall_info_url']:"";
		$con_mall_key = isset($_G['system']['con_mall_key'])?$_G['system']['con_mall_key']:"1234567890";
		
		if($malltype == "gx"){
			$mallurl = $_G['mall_url'];
		}elseif($malltype == "jf"){
			$mallurl = $_G['jf_mall_url'];
		}
		//���û��������Ϣֱ�ӷ���0ֵ
		/*
		"money":"0.00000","money_dj":"0.00000","jifen":"0.00000","jifen_dj":"0.00000"
		��4���ֱ���ɶ��˼��
		���ϴ�������  10:10:29
		������ �ʽ𡢶����ʽ𡢻��֡��������
		*/
		if ($mallurl=="" || $con_mall_info_url=="" || !isset($data['uc_user_id'])){
			$rss['mall_money'] = 0;
			$rss['mall_money_dj'] = 0;
			$rss['mall_jifen'] = 0;
			$rss['mall_jifen_dj'] = 0;
			return $rss;
		}
		
		$srv_ip = $mallurl;//���Ŀ������ַ.
		$srv_port = 80;//�˿�
		$url = "http://".$mallurl.$con_mall_info_url; //������post��URL�����ַ
		$fp = '';
		$errno = 0;//������
		$errstr = '';//������
		$timeout = 10;//���û�����Ͼ��ж�
		//TODO ����mall��Ϣʱ��uc_user_id��Ҫ����
		$e_uc_user_id = DeCode($data['uc_user_id'],'E',$con_mall_key);
		$post_str = "&user_id={$e_uc_user_id}";//Ҫ�ύ������.
		//������� Socket ���ӡ�
		$fp = fsockopen($srv_ip,$srv_port,$errno,$errstr,$timeout);
		if (!$fp){
			$rss['mall_money'] = 0;
			$rss['mall_money_dj'] = 0;
			$rss['mall_jifen'] = 0;
			$rss['mall_jifen_dj'] = 0;
			return $rss;
		}
		$content_length = strlen($post_str);
		$post_header = "POST $url HTTP/1.1\r\n";
		$post_header .= "Content-Type: application/x-www-form-urlencoded\r\n";
		$post_header .= "User-Agent: MSIE\r\n";
		$post_header .= "Host: ".$srv_ip."\r\n";
		$post_header .= "Content-Length: ".$content_length."\r\n";
		$post_header .= "Connection: close\r\n\r\n";
		$post_header .= $post_str."\r\n\r\n";
		fwrite($fp,$post_header);
	
		$inheader = 1;
		while(!feof($fp)){//�����ļ�ָ���Ƿ����ļ�������λ��
			$line = fgets($fp,1024);
			//ȥ���������ͷ��Ϣ
			if ($inheader && ($line == "\n" || $line == "\r\n")) {
				$inheader = 0;
			}
			if ($inheader == 0) {
				//echo $line;
			}
		}
		fclose($fp);
		// 		unset ($line);
		//TODO ������ת��ΪǮ
		
		$arr = json_decode($line);
		if (is_array($arr)){
			$rss['mall_money'] = $arr->money;
			$rss['mall_money_dj'] = $arr->money_dj;
			$rss['mall_jifen'] = $arr->jifen;
			$rss['mall_jifen_dj'] = $arr->jifen_dj;
		}
		else{
			$rss['mall_money'] = 0;
			$rss['mall_money_dj'] = 0;
			$rss['mall_jifen'] = 0;
			$rss['mall_jifen_dj'] = 0;
		}
		return $rss;
	
	}
	
	public static function L2MbyUc($data = array()){
		global $mysql, $_G;
		require_once (ROOT_PATH."core/HttpClient.class.php");
		$trantype = $data['trantype'];
		$malltype = $data['malltype'];
		
// 		$con_mall_addr = isset($_G['system']['con_mall_addr'])?$_G['system']['con_mall_addr']:"";
// 		$con_mall_port = isset($_G['system']['con_mall_port'])?$_G['system']['con_mall_port']:0;
		// 		$con_mall_info_url = isset($_G['system']['con_mall_info_url'])?$_G['system']['con_mall_info_url']:"";
// 		http://www.imm023.com/index.php?app=user&act=i_awardl2m&user_id=wvmEtJgwZwo8E6Io&money=10
		if($malltype == "gx"){
			$mallurl = $_G['mall_url'];
		}elseif($malltype == "jf"){
			$mallurl = $_G['jf_mall_url'];
		}
		
		if ($trantype == 'amount'){
			//$con_mall_info_url = "http://www.imm023.com/index.php?app=user&act=i_accountl2m";
			$l2m_url = isset($_G['system']['con_account_l2m_url'])?$_G['system']['con_account_l2m_url']:"";
			$tran_limit = isset($_G['system']['con_amount_tran_limit'])?$_G['system']['con_amount_tran_limit']:0;
		}elseif($trantype == 'award'){
			//$con_mall_info_url = "http://www.imm023.com/index.php?app=user&act=i_accountl2m";
			$l2m_url = isset($_G['system']['con_award_l2m_url'])?$_G['system']['con_award_l2m_url']:"";
			$tran_limit = isset($_G['system']['con_award_tran_limit'])?$_G['system']['con_award_tran_limit']:0;
		}
		
// 		$con_mall_info_url = "http://www.imm023.com/index.php?app=user&act=i_awardl2m";
		$con_mall_key = isset($_G['system']['con_mall_key'])?$_G['system']['con_mall_key']:"1234567890";
	
		//���û��������Ϣֱ�ӷ���0ֵ
		/*
		 "money":"0.00000","money_dj":"0.00000","jifen":"0.00000","jifen_dj":"0.00000"
		��4���ֱ���ɶ��˼��
		���ϴ�������  10:10:29
		������ �ʽ𡢶����ʽ𡢻��֡��������
		*/
		$user_id= $data['user_id'];
		$money = $data['amount'];
		if ($mallurl =="" || $l2m_url=="" || !is_numeric($money) || $money < 0){
			$msg = "���󲻺Ϸ���";
			return $msg;
		}
		$op_money = round($money, 2);
		
		if($op_money < $tran_limit){
			$msg = "ת�ʽ��С����С����{$tran_limit}Ԫ��";
			return $msg;
		}
		
		$account_result =  self::GetOne(array("user_id"=>$user_id));//��ȡ��ǰ�û������
		if($trantype == "amount"){
			if (($account_result['use_money'] - $account_result['nocash_money']) < $op_money){
				$msg = "���㣬ת��ʧ�ܡ�";
				return $msg;
			}
		}else{
			if ($account_result['award_interest'] < $op_money){
				$msg = "��׬��Ϣ���㣬ת��ʧ�ܡ�";
				return $msg;
			}
		}
		
		$srv_ip = $mallurl;//���Ŀ������ַ.
		$srv_port = 80;//�˿�
		$url = "http://".$mallurl.$l2m_url; //������post��URL�����ַ
		$fp = '';
		$errno = 0;//������
		$errstr = '';//������
		$timeout = 10;//���û�����Ͼ��ж�
		//TODO ����mall��Ϣʱ��uc_user_id��Ҫ����
		//echo $url;
		$sql = "select * from  {user}  where user_id = '{$user_id}' limit 1";
		$result = $mysql->db_fetch_array($sql);
		if ($result!=false){
			$data['uc_user_id'] = $result['uc_user_id'];//����ܶ�
		}
		$e_uc_user_id = DeCode($data['uc_user_id'],'E',$con_mall_key);
		$post_str = "&user_id={$e_uc_user_id}&money={$data['amount']}";//Ҫ�ύ������.
		//������� Socket ���ӡ�
		$fp = fsockopen($srv_ip,$srv_port,$errno,$errstr,$timeout);
		if (!$fp){
			echo('fp fail');
		}
		//echo $post_str;
		$content_length = strlen($post_str);
		$post_header = "POST $url HTTP/1.1\r\n";
		$post_header .= "Content-Type: application/x-www-form-urlencoded\r\n";
		$post_header .= "User-Agent: MSIE\r\n";
		$post_header .= "Host: ".$srv_ip."\r\n";
		$post_header .= "Content-Length: ".$content_length."\r\n";
		$post_header .= "Connection: close\r\n\r\n";
		$post_header .= $post_str."\r\n\r\n";
		fwrite($fp,$post_header);
	
		$inheader = 1;
		while(!feof($fp)){//�����ļ�ָ���Ƿ����ļ�������λ��
			$line = fgets($fp,1024);
			//ȥ���������ͷ��Ϣ
			if ($inheader && ($line == "\n" || $line == "\r\n")) {
				$inheader = 0;
			}
			if ($inheader == 0) {
				//echo $line;
			}
		}
		fclose($fp);
		// 		unset ($line);
		//echo $line;
		$arr = json_decode($line);
		$account_result =  self::GetOne(array("user_id"=>$user_id));//��ȡ��ǰ�û������
		if ($arr->result == 1){
			if($trantype == "amount"){				
				$op_log['user_id'] = $user_id;
				$op_log['type'] = "i_accountl2m";
				$op_log['money'] = $money;
				$op_log['total'] = $account_result['total']-$op_log['money'];
				$op_log['use_money'] = $account_result['use_money']-$op_log['money'];
				$op_log['no_use_money'] = $account_result['no_use_money'];
				$op_log['collection'] = $account_result['collection'];
				$op_log['to_user'] = "0";
				$op_log['remark'] = "���̳�ת���ʽ�";
				$result=accountClass::AddLog($op_log);
			}elseif($trantype == "award"){
				$sql = "update  {account}  set ";
				$sql .= " award_interest = award_interest - {$money}";
				$sql .= " where user_id={$user_id} limit 1";
				//liukun add for bug 174 end				
				$mysql->db_query($sql);				
				$award_log['user_id'] = $user_id;
				$award_log['type'] = "i_awardl2m";
				$award_log['award'] = -$money;
				$award_log['remark'] = "���̳�ת����ֵ������׬��Ϣ";
				$sql = "insert into  {recharge_award_log}  set `addtime` = '".time()."',`addip` = '".ip_address()."'";
				foreach($award_log as $key => $value){
					$sql .= ",`$key` = '$value'";
				}
				$result = $mysql->db_query($sql);
			}
			
			return true;
		}else{
			if($arr->error=='no_user')	return "�̳��û���û�м�����½��������ԣ�";
		}	
	}	
	
	public static function GetUserLog($data = array()){
		global $mysql;
		$user_id = (int)$data['user_id'];
		$sql = "select type,sum(money) as num from  {account_log}  where user_id = '{$user_id}' group by type ";
		$result = $mysql->db_fetch_arrays($sql);
		$_result = "";
		foreach ($result as $key => $value){
			$_result[$value['type']] = $value['num'];
		}
		
		$sql = "select * from  {account}  where user_id = '{$user_id}'  ";
		$result = $mysql->db_fetch_array($sql);
		if($result!=false){
			foreach ($result as $key => $value){
				$_result[$key] = $value;
			}
		}
		
		//�����
		$sql = "select borrow_amount from  {user_cache}  where user_id = {$user_id} limit 1";
		$result = $mysql -> db_fetch_array($sql);
		$_result['amount'] = $result['borrow_amount'];//����ܶ�
		
		/*
		//��ʵ����
		$sql = "select realname from  {user} where user_id = {$user_id} ";
		$result = $mysql -> db_fetch_array($sql);
		$_result['realname'] = $result['realname'];//��ʵ����	
		*/

		
		//��ֵ��ͳ��
		$sql = "select type,sum(money) as num from  {account_recharge}  where user_id = '{$user_id}' and status=1 group by type ";
		$result = $mysql->db_fetch_arrays($sql);
		foreach ($result as $key => $value){
			if ( $value['type']==0){
				$key = "recharge_shoudong";
			}elseif ( $value['type']==1){
				$key = "recharge_online";
			}else{
				$key = "recharge_downline";
			}
			$_result[$key] = $value['num'];
		}
		$sql = "select sum(money) as num from  {account_recharge}  where user_id = '{$user_id}' and status=1  ";
		$result = $mysql->db_fetch_array($sql);
		$_result['recharge_success'] = $result['num'];
		$_result['recharge'] =  $result['num'];
		$sql = "select sum(money) as num from  {account_recharge}  where user_id = '{$user_id}' and status=0  ";
		$result = $mysql->db_fetch_array($sql);
		$_result['recharge_false'] = $result['num'];
		
		//���ֵ�ͳ��
		$sql = "select status,sum(total) as num,sum(credited) as cnum,sum(fee) as fnum from  {account_cash}  where user_id = '{$user_id}'  group by status ";
		$result = $mysql->db_fetch_arrays($sql);
		foreach ($result as $key => $value){
			if ( $value['status']==2){
				$key = "cash_false";
			}elseif ( $value['status']==1){
				$key = "cash_success";
			}elseif ( $value['status']==3){
				$key = "cash_cancel";
			}else{
				$key = "cash_wait";
			}
			$_result[$key] = array("money"=>$value['num'],"credited"=>$value['cnum'],"fee"=>$value['fnum']);
		}
		
		return $_result;
	}
	
	
	function ActionAccount($data=array()){
		global $mysql;
		
		if (isset($data['user_id'])){
			$user_id = $data['user_id'];
		
			unset($data['user_id']);
			$sql = "select * from {account} where user_id=$user_id limit 1";
			$result = $mysql->db_fetch_array($sql);
			if ($result == false){
				
				//add by jackfeng 2012-06-30
				$sql="select * from {user} where user_id='{$user_id}' limit 1";
				$result = $mysql->db_fetch_array($sql);
				if($result == false){
					//������
					//û�д��û����ڣ�Ҳû�д��˻����ڣ����ش��󣬲��ټ�������
					return false;
				}else{
					$sql = "insert into  {account}  set `user_id` = '$user_id'";
					foreach($data as $key => $value){
						$sql .= ",`$key` = '$value'";
					}
				}
			}else{
				$sql = "update  {account}  set `user_id` = '$user_id'";
				foreach($data as $key => $value){
					$sql .= ",`$key` = '$value'";
				}
				$sql .= " where user_id=$user_id limit 1";
			}
			return $mysql->db_query($sql);
		}else{
			return self::ERROR;
		}
		
	}
	
	/**
	 * �鿴������Ϣ
	 *
	 * @param Array $data
	 * @return Array
	 */
	public static function GetBankOne($data = array()){
		global $mysql;
		$user_id = (int)$data['user_id'];
		$sql = "select p1.username,p1.email,p1.realname,p1.paypassword,p2.*,p3.* from {user} as p1 
				  left join {account_bank} as p2 on p1.user_id=p2.user_id 
				  left join {account} as p3 on p3.user_id=p1.user_id
				  where p1.user_id=$user_id limit 1";
		return $mysql->db_fetch_array($sql);
	}
	
	/**
	 * ��ӻ��޸������˺�
	 *
	 * @param Array $data
	 * @return Boolen
	 */
	function ActionBank($data = array()){
		global $mysql;
        $user_id = isset($data['user_id'])?$data['user_id']:"";
		if (empty($user_id)) return self::ERROR;
       
		$sql = "select * from {account_bank} where user_id = $user_id";
		$result = $mysql->db_fetch_array($sql);
		if ($result == false){
			$sql = "insert into  {account_bank}  set `addtime` = '".time()."',`addip` = '".ip_address()."'";
			foreach($data as $key => $value){
				$sql .= ",`$key` = '$value'";
			}
		}else{
			$sql = "update  {account_bank}  set `addtime` = '".time()."',`addip` = '".ip_address()."'";
			foreach($data as $key => $value){
				$sql .= ",`$key` = '$value'";
			}
			$sql .= " where user_id=$user_id";
		}
        return $mysql->db_query($sql);
	}
	
	/**
	 * ������ּ�¼
	 *
	 * @param Array $data
	 * @return Boolen
	 */
	function AddCash($data = array()){
		global $mysql;
        $user_id = isset($data['user_id'])?$data['user_id']:"";
		if (empty($user_id)) return self::ERROR;
       
		$sql = "insert into  {account_cash}  set `addtime` = '".time()."',`addip` = '".ip_address()."'";
		foreach($data as $key => $value){
			$sql .= ",`$key` = '$value'";
		}
		
        return $mysql->db_query($sql);
	}
	
	/**
	 * ����ʽ�ʹ�ü�¼
	 *
	 * @param Array $data
	 * @return Boolen
	 */
	function AddLog($data = array()){
		global $mysql;
        $user_id = isset($data['user_id'])?$data['user_id']:"";
		if (empty($user_id)) return false;
       	$total = $data['total'];		
		if(abs($data['money'])!=0.01 && round(abs($data['collection']),2)==0.01)
		{
			$data['collection']=0;	//��ֹ����Ϊ0.01��-0.01
			if(round($data['collection'],2)==0.01)
			{
				$data['total'] -= 0.01;
			}
			else
			{
				$data['total'] += 0.01; // -0.01  �ܶ����0.01
			}
			$data['remark'].='<!--0.01-->';
		}		
		$sql = "insert into  {account_log}  set `addtime` = '".time()."',`addip` = '".ip_address()."'";
		foreach($data as $key => $value){
			$sql .= ",`$key` = '$value'";
		}
		$result = $mysql->db_query($sql);
		//����ʽ���־û��д�ɹ������ܼ��������ʽ��˻�
		if ($result != true){
			return false;
		}
		$account['user_id'] = $user_id;
		$account['total'] = $total;
		if(isset($data['use_money'])){
			$account['use_money'] = $data['use_money'];
		}
		if(isset($data['no_use_money'])){
			$account['no_use_money'] = $data['no_use_money'];
		}
		if(isset($data['collection'])){
			$account['collection'] = $data['collection'];
		}
		$result = self::ActionAccount($account);
		
		//liukun add for bug 104 begin
        //return ;
		//liukun add for bug 104 end
		return $result;
	}
	
	
	/**
	 * �޸�
	 *
	 * @param Array $data
	 * @return Boolen
	 */
	function Update($data = array()){
		global $mysql;
		$user_id = $data['user_id'];
        if ($data['user_id'] == "") return self::ERROR;
		
		$_sql = "";
		$sql = "update  {account}  set ";
		foreach($data as $key => $value){
			$_sql[] .= "`$key` = '$value'";
		}
		$sql .= join(",",$_sql)." where user_id = '$user_id'";
        return $mysql->db_query($sql);
	}
	
	
	/**
	 * ���ּ�¼
	 *
	 * @return Array
	 */
	function GetCashList($data = array()){
		global $mysql;
		$user_id = empty($data['user_id'])?"":$data['user_id'];
		$username = empty($data['username'])?"":$data['username'];
	
		$page = empty($data['page'])?1:$data['page'];
		$epage = empty($data['epage'])?10:$data['epage'];
		
		$_sql = "where 1=1 ";		 
		if (!empty($user_id)){
			$_sql .= " and p2.user_id = $user_id";
		}
		if (!empty($username)){
			$_sql .= " and p2.username = '$username'";
		}
		
		if (isset($data['status']) && $data['status']!=""){
			$_sql .= " and p1.status = '{$data['status']}' ";
		}
		
		//liukun add for subsite_id search begin
		if (isset($data['areaid']) && $data['areaid']!="0"){
			$_sql .= " and p2.areaid = {$data['areaid']} ";
		}
		//liukun add for subsite_id search end
		
		$sql = "select SELECT from {account_cash} as p1 
				 left join {user} as p2 on p1.user_id=p2.user_id
				 left join {linkage} as p3 on p1.bank=p3.id
				$_sql ORDER LIMIT";
		$_select = "p1.*,p2.username,p2.realname,p3.name as bank_name";		 
		//�Ƿ���ʾȫ������Ϣ
		if (isset($data['limit']) ){
			$_limit = "";
			if ($data['limit'] != "all"){
				$_limit = "  limit ".$data['limit'];
			}
			$list =  $mysql->db_fetch_arrays(str_replace(array('SELECT', 'ORDER', 'LIMIT'), array($_select, 'order by p1.id desc', $_limit), $sql));
			
			return $list;
		}
		$row = $mysql->db_fetch_array(str_replace(array('SELECT', 'ORDER', 'LIMIT'), array('count(1) as num', '', ''), $sql));
		
		$total = $row['num'];
		$total_page = ceil($total / $epage);
		$index = $epage * ($page - 1);
		$limit = " limit {$index}, {$epage}";
		
		$list = $mysql->db_fetch_arrays(str_replace(array('SELECT', 'ORDER', 'LIMIT'), array(' p1.*,p2.username,p2.realname,p3.name as bank_name', 'order by p1.id desc', $limit), $sql));		
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
	public static function GetCashOne($data = array()){
		global $mysql;
		$id = $data['id'];
		$user_id = $data['user_id'];
		 if (empty($id) && empty($user_id)) return self::ERROR;
		 
		 $_sql = "where 1=1 ";		 
		if (!empty($id)){
			$_sql .= " and p1.id = '$id'";
		}	 
		if (!empty($user_id)){
			$_sql .= " and p1.user_id = '$user_id'";
		}
		
		$sql = "select p1.* ,p2.username,p2.email,p3.name as bank_name,p4.username as verify_username from {account_cash} as p1 
				  left join {user} as p2 on p1.user_id=p2.user_id
				  left join {linkage} as p3 on p1.bank=p3.id
				  left join {user} as p4 on p1.verify_userid=p4.user_id
				  {$_sql}
				";
		return $mysql->db_fetch_array($sql);
	}
	
	
	
	
	/**
	 * ������ּ�¼
	 *
	 * @param Array $data
	 * @return Boolen
	 */
	function UpdateCash($data = array()){
		global $mysql;
		$id = $data['id'];
        if (empty($id)) return self::ERROR;
		$user_id = $data['user_id'];
		$_sql = "";
		$sql = "update  {account_cash}  set ";
		foreach($data as $key => $value){
			$_sql[] .= "`$key` = '$value'";
		}
		$sql .= join(",",$_sql)." where id = '$id' and user_id='$user_id' limit 1";
        return $mysql->db_query($sql);
	}
	
	/**
	 * ��ֵ��¼
	 *
	 * @return Array
	 */
	function GetRechargeList($data = array()){
		global $mysql;
   
		$user_id = empty($data['user_id'])?"":$data['user_id'];
		$username = empty($data['username'])?"":$data['username'];
                $status = empty($data['status'])?"":$data['status'];
                
                $dotime1 = empty($data['dotime1'])?"":$data['dotime1'];
                $dotime2 = empty($data['dotime2'])?"":$data['dotime2'];
	
		$page = empty($data['page'])?1:$data['page'];
		$epage = empty($data['epage'])?10:$data['epage'];
		
		$_sql = "where 1=1 and p1.status != -1 ";		 
		if (!empty($user_id)){
			$_sql .= " and p2.user_id = $user_id";
		}
		if (!empty($username)){
			$_sql .= " and p2.username = '$username'";
		}
                
		if (!empty($dotime1)){
			$_sql .= " and p1.addtime  >= ".get_mktime($dotime1);
		}
                
		if (!empty($dotime2)){
			$_sql .= " and p1.addtime  <= ".get_mktime($dotime2);
		}
                
                //echo $data['status'];
                if (empty($status))$status=0;
                if($status=="-1")$status=0;
		if ( $status != "-2"){
			$_sql .= " and p1.status = ".$status;
		} 
		
		//liukun add for subsite_id search begin
		if (isset($data['areaid']) && $data['areaid']!="0"){
			$_sql .= " and p2.areaid = {$data['areaid']} ";
		}
		//liukun add for subsite_id search end
		
		$sql = "select SELECT from {account_recharge} as p1 
				 left join {user} as p2 on p1.user_id=p2.user_id
				 left join {payment} as p3 on p1.payment=p3.id
				$_sql ORDER LIMIT";
                
			$_select = "p1.*,p1.money,p1.money-p1.fee as total,p2.username,p2.realname,p3.name as payment_name";	 
		//�Ƿ���ʾȫ������Ϣ
		if (isset($data['limit']) ){
			$_limit = "";
			if ($data['limit'] != "all"){
				$_limit = "  limit ".$data['limit'];
			}
                   
			$result= $mysql->db_fetch_arrays(str_replace(array('SELECT', 'ORDER', 'LIMIT'), array($_select,  'order by p1.addtime desc', $_limit), $sql));
			
                        return $result;
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
	public static function GetRechargeOne($data = array()){
		global $mysql;
		$_sql = "where 1=1 ";		 
		if (isset($data['id']) && $data['id']!=""){
			$_sql .= " and p1.id = {$data['id']}";
		} 
		if (isset($data['user_id']) && $data['user_id']!=""){
			$_sql .= " and p2.user_id = {$data['user_id']}";
		}
		if (isset($data['trade_no']) && $data['trade_no']!=""){
			$_sql .= " and p1.trade_no = {$data['trade_no']}";
		}
		
		$sql = "select p1.*,p1.money-p1.fee as total,p2.username,p2.email,p3.name as payment_name,p4.username as verify_username,p5.total as user_total,p5.use_money as user_use_money,p5.no_use_money as  user_no_user_money from {account_recharge} as p1 
				 left join {user} as p2 on p1.user_id=p2.user_id
				 left join {payment} as p3 on p1.payment=p3.nid
				 left join {user} as p4 on p1.verify_userid=p4.user_id
				 left join {account} as p5 on p1.user_id=p5.user_id
				$_sql";
		return $mysql->db_fetch_array($sql);
	}
	
	
	/**
	 * ��ӳ�ֵ��¼
	 *
	 * @param Array $data
	 * @return Boolen
	 */
	function AddRecharge($data = array()){
		global $mysql;
        $user_id = isset($data['user_id'])?$data['user_id']:"";
		if (empty($user_id)) return self::ERROR;
       
		$sql = "insert into  {account_recharge}  set `addtime` = '".time()."',`addip` = '".ip_address()."'";
		foreach($data as $key => $value){
			$sql .= ",`$key` = '$value'";
		}
		
		$result =  $mysql->db_query($sql);
		
		
		return $result;
	}
	
	/**
	 * ��ֵ���
	 *
	 * @param Array $data
	 * @return Boolen
	 */
	function UpdateRecharge($data = array()){
		global $mysql;
		$id = $data['id'];
        if (empty($id)) return self::ERROR;
		
		$_sql = "";
		$sql = "update  {account_recharge}  set ";
		foreach($data as $key => $value){
			$_sql[] .= "`$key` = '$value'";
		}
		$sql .= join(",",$_sql)." where id = '$id'";
        return $mysql->db_query($sql);
	}
	
	
	
	/**
	 * �ʽ�ʹ�ü�¼
	 *
	 * @return Array
	 */
	function GetLogList($data = array()){
		global $mysql;
		$user_id = empty($data['user_id'])?"":$data['user_id'];
		$username = empty($data['username'])?"":$data['username'];
	
		$page = empty($data['page'])?1:$data['page'];
		$epage = empty($data['epage'])?10:$data['epage'];
		
		$_sql = "where 1=1 ";		 
		if (!empty($user_id)){
			$_sql .= " and p2.user_id = $user_id";
		}
		if (!empty($username)){
			$_sql .= " and p2.username = '$username'";
		}
		
		if (isset($data['dotime1']) && $data['dotime1']!=""){
			$_sql .= " and p1.addtime >= '".strtotime($data['dotime1'])."'";
		}
		if (isset($data['dotime2']) && $data['dotime2']!=""){
			$_sql .= " and p1.addtime <= '".strtotime($data['dotime2'])."'";
		}
		if (isset($data['type']) && $data['type']!=""){
			$_sql .= " and p1.type = '".$data['type']."'";
		}
		
		//liukun add for subsite_id search begin
		if (isset($data['areaid']) && $data['areaid']!="0"){
			$_sql .= " and p2.areaid = {$data['areaid']} ";
		}
		//liukun add for subsite_id search end
		if (isset($data['subsite_id']) && $data['subsite_id']!=""){
			$_sql .= " and p1.areaid = '".$data['subsite_id']."'";
		}
		
		if (isset($data['borrow_status']) && $data['borrow_status']!=""){
			$_sql .= " and p5.status = {$data['borrow_status']} ";
		}
		
		
		$_select = "p1.*,p2.username,p3.username as to_username, p4.sitename, p5.name as borrow_name ";
		$sql = "select SELECT from {account_log} as p1 
				 left join {user} as p2 on p1.user_id=p2.user_id
				 left join {user} as p3 on p3.user_id=p1.to_user 
				 left join {subsite} as p4 on p4.id=p2.areaid 
				 left join {borrow} as p5 on p5.id=p1.borrow_id 
				$_sql ORDER LIMIT";
				 
		//�Ƿ���ʾȫ������Ϣ
		if (isset($data['limit']) ){
			$_limit = "";
			if ($data['limit'] != "all"){
				$_limit = "  limit ".$data['limit'];
			}
			$result= $mysql->db_fetch_arrays(str_replace(array('SELECT', 'ORDER', 'LIMIT'), array($_select,  'order by p1.id desc', $_limit), $sql));
			return $result;
		}	
		$row = $mysql->db_fetch_array(str_replace(array('SELECT', 'ORDER', 'LIMIT'), array('count(1) as num', '', ''), $sql));
		
		$total = $row['num'];
		$total_page = ceil($total / $epage);
		$index = $epage * ($page - 1);
		$limit = " limit {$index}, {$epage}";
		
		$list = $mysql->db_fetch_arrays(str_replace(array('SELECT', 'ORDER', 'LIMIT'), array($_select, 'order by p1.id desc', $limit), $sql));		
		$list = $list?$list:array();
		$row = $mysql->db_fetch_array(str_replace(array('SELECT', 'ORDER', 'LIMIT'), array('sum(money) as num', '', ''), $sql));
		return array(
            'list' => $list,
            'total' => $total,
            'page' => $page,
            'epage' => $epage,
            'account' => $row['num'],
            'total_page' => $total_page
        );
		
	}
	
	/*
	 ��վ����
	*/
	function subsite_addlog($data=array())
	{
		global $mysql;
		$sql = "insert into  {subsite_moneylog}  set ";
		foreach($data as $key => $value){
			$sql .= "`$key` = '$value',";
		}
		$sql=substr($sql,0,-1);
		$result = $mysql->db_query($sql);
		//����ʽ���־û��д�ɹ������ܼ��������ʽ��˻�
		if ($result != true){
			return false;
		}
		$result = $mysql->db_query("update {subsite} set jiesuan_time=".time().",jiesuan_money={$data['total']} where id={$data['siteid']} limit 1");
		if ($result != true){
			return false;
		}
		return true;
	}
	public static function subsite_jiesuan($data=array())
	{
		global $mysql;
		$sites=$mysql->db_fetch_arrays("select id,recharge_rate,jiesuan_time,jiesuan_money from {subsite}");
		$mysql->db_query("start transaction");
		$transaction_result = true;		
		try{
			foreach($sites as $site)
			{				
				$total=$site['jiesuan_money'];
				$result=$mysql->db_fetch_arrays("select p1.user_id,p1.money,p1.type,p1.remark,p1.addtime,p1.borrow_id from {account_log} as p1 left join {user} as p2 on p1.user_id=p2.user_id	 where p2.areaid={$site['id']} and p1.addtime>{$site['jiesuan_time']}");				
				foreach($result as $row)
				{
					$account_log=array();					
					$account_log['siteid']=$site['id'];
					$account_log['user_id']=$row['user_id'];
					$account_log['type']=$row['type'];
					$account_log['addtime']=$row['addtime'];
					$account_log['borrow_id']=(int)$row['borrow_id'];
					$account_log['remark']=addslashes($row['remark']);
					if($row['type']=='recharge_online')//���߳�ֵ
					{
						$account_log['money']=round_money($row['money'] * $site['recharge_rate'],2);
						$account_log['total']=$total-$account_log['money'];
					}
					elseif($row['type']=='recharge_award')//��ֵ����
					{
						$account_log['money']=$row['money'];
						$account_log['total']=$total-$account_log['money'];
					}
					elseif($row['type']=='site_repayment')//��վ�渶
					{
						$account_log['money']=$row['money'];
						$account_log['total']=$total-$account_log['money'];
					}
					elseif($row['type']=='tender_mange')//���������
					{	
						$account_log['money']=$row['money'];
						$account_log['total']=$total+$account_log['money'];
					}
					elseif($row['type']=='ontop_fee')//�ö�����
					{	
						$account_log['money']=$row['money'];
						$account_log['total']=$total+$account_log['money'];
					}
					elseif($row['type']=='borrow_fee')//��Ϣ�����
					{
						$account_log['money']=$row['money'];
						$account_log['total']=$total+$account_log['money'];
					}
					elseif($row['type']=='late_repayment')//���ڷ�Ϣ
					{	
						$account_log['money']=bcmul($row['money'],0.5,2);
						$account_log['total']=$total+$account_log['money'];
					}
					elseif($row['type']=='vouch_ticheng')//�����û�������ɽ���
					{
						$account_log['money']=$row['money'];
						$account_log['total']=$total+$account_log['money'];
					}
					elseif($row['type']=='vouch_amount_ticheng')//�����û����뵣�������ɽ���
					{
						$account_log['money']=$row['money'];
						$account_log['total']=$total+$account_log['money'];
					}
					elseif($row['type']=='borrow_ticheng')//�����û����������������
					{
						$account_log['money']=$row['money'];
						$account_log['total']=$total+$account_log['money'];
					}
					else				
					{
						continue;
					}
					$total=$account_log['total'];
					if($account_log['money']!=0)
					{
						$transaction_result = accountClass::subsite_addlog($account_log);
						if ($transaction_result !==true){
							throw new Exception();
						};
					}
				}
			}
		}catch(Exception $e){$mysql->db_query("rollback");}
		if($transaction_result===true){
			$mysql->db_query("commit");
		}else{
			$mysql->db_query("rollback");
		}		
	}
	function get_subsite_money($data=array())
	{
		global $mysql;
		$_sql="select * from {subsite} where 1=1";
		if (isset($data['areaid']) && $data['areaid']!="0"){
			$_sql .= " and id = {$data['areaid']} ";
		}
		$result=$mysql->db_fetch_arrays($_sql);
		return $result;
	}
	function get_subsite_moneylog($data=array())
	{
		global $mysql;
		$user_id = empty($data['user_id'])?"":$data['user_id'];
		$username = empty($data['username'])?"":$data['username'];	
		$page = empty($data['page'])?1:$data['page'];
		$epage = empty($data['epage'])?10:$data['epage'];		
		$_sql = "where 1=1 ";
		if (!empty($user_id)){
			$_sql .= " and p2.user_id = $user_id";
		}
		if (!empty($username)){
			$_sql .= " and p2.username = '$username'";
		}
		
		if (isset($data['dotime1']) && $data['dotime1']!=""){
			$_sql .= " and p1.addtime >= '".strtotime($data['dotime1'])."'";
		}
		if (isset($data['dotime2']) && $data['dotime2']!=""){
			$_sql .= " and p1.addtime <= '".strtotime($data['dotime2'])."'";
		}
		if (isset($data['type']) && $data['type']!=""){
			$_sql .= " and p1.type = '".$data['type']."'";
		}
		
		//liukun add for subsite_id search begin
		if (isset($data['areaid']) && $data['areaid']!="0"){
			$_sql .= " and p1.siteid = {$data['areaid']} ";
		}
		//liukun add for subsite_id search end
		if (isset($data['subsite_id']) && $data['subsite_id']!=""){
			$_sql .= " and p1.siteid = '".$data['subsite_id']."'";
		}
		
		if (isset($data['borrow_status']) && $data['borrow_status']!=""){
			$_sql .= " and p5.status = {$data['borrow_status']} ";
		}		
		$_select = "p1.*,p2.username,p4.sitename, p5.name as borrow_name ";
		$sql = "select SELECT from {subsite_moneylog} as p1 
				 left join {user} as p2 on p1.user_id=p2.user_id
				 left join {subsite} as p4 on p4.id=p1.siteid 
				 left join {borrow} as p5 on p5.id=p1.borrow_id 
				$_sql ORDER LIMIT";				 
		
		//forExcel start
		if(isset($data['excel']) && $data['excel']=='excel')
		{
			$result= $mysql->db_fetch_arrays(str_replace(array('SELECT', 'ORDER', 'LIMIT'), array($_select,  'order by p1.id desc', $_limit), $sql));
			 foreach ($result as $key => $value){
				$_data[$key] = array(date('Y-m-d H:i:s',$value['addtime']),$value['username'],$value['type'],$value['total'],$value['money'],$value['remark'],$value['sitename'],$value['borrow_name']);
			}     
			return $_data;	
		}
		//forExcel end
		
		//�Ƿ���ʾȫ������Ϣ
		if (isset($data['limit']) ){
			$_limit = "";
			if ($data['limit'] != "all"){
				$_limit = "  limit ".$data['limit'];
			}
			$result= $mysql->db_fetch_arrays(str_replace(array('SELECT', 'ORDER', 'LIMIT'), array($_select,  'order by p1.id desc', $_limit), $sql));
			return $result;
		}		
		$row = $mysql->db_fetch_array(str_replace(array('SELECT', 'ORDER', 'LIMIT'), array('count(1) as num', '', ''), $sql));
		
		$total = $row['num'];
		$total_page = ceil($total / $epage);
		$index = $epage * ($page - 1);
		$limit = " limit {$index}, {$epage}";
		
		$list = $mysql->db_fetch_arrays(str_replace(array('SELECT', 'ORDER', 'LIMIT'), array($_select, 'order by p1.id desc', $limit), $sql));		
		$list = $list?$list:array();
		$row = $mysql->db_fetch_array(str_replace(array('SELECT', 'ORDER', 'LIMIT'), array('sum(p1.money) as num', '', ''), $sql));
		
		return array(
            'list' => $list,
            'total' => $total,
            'page' => $page,
            'epage' => $epage,
            'account' => $row['num'],
            'total_page' => $total_page
        );		
	}	
	
	function get_acountlist_site($data=array())
	{
		global $mysql;
		$site_id = (int)$data['site_id'];
		$_sql = "where 1=1 ";
		
		if (isset($data['dotime1']) && $data['dotime1']!=""){
			$_sql .= " and p1.addtime >= '".strtotime($data['dotime1'])."'";
		}
		if (isset($data['dotime2']) && $data['dotime2']!=""){
			$_sql .= " and p1.addtime <= '".strtotime($data['dotime2'])."'";
		}
		$sql="select id,sitename,recharge_rate from {subsite}";
		if($site_id!=0)
		{
			$sql.=" where id=$site_id limit 1";	
		}
		$sites=$mysql->db_fetch_arrays($sql);
		$result=array();
		$arr_type=array('recharge_online','recharge_award','recharge_fee','tender_mange','ontop_fee','borrow_fee','late_repayment','vouch_ticheng','vouch_amount_ticheng','borrow_ticheng');
		foreach($sites as $row)
		{
			$areaid=$row['id'];			
			/*$sql="select round(payment_account-account,2) as miao from {borrow} p1
			 left join {user} p2 on p1.user_id=p2.user_id 
			 $_sql and p2.areaid=$areaid and p1.status=3";
			 $row1=$mysql->db_fetch_array($sql);
			 $result[$areaid]['miao']=$row1['miao'];	*/		
			
			$result[$areaid]['sitename']=$row['sitename'];
			$result[$areaid]['recharge_rate']=$row['recharge_rate'];
			foreach($arr_type as $v)
			{
				$sql="select sum(money) as money from {account_log} as p1 
				left join {user} as p2 on p1.user_id=p2.user_id		 
				$_sql and p2.areaid=$areaid and p1.type='$v'";
				$_row=$mysql->db_fetch_array($sql);
				$result[$areaid][$v]=$_row['money'];
				if($v=='tender_mange')
				{
					$result[$areaid][$v]=$result[$areaid][$v];
				}
				elseif($v=='late_repayment')
				{
					$result[$areaid][$v]=bcmul($result[$areaid][$v],0.5,2);	
				}
				elseif($v=='recharge_online')
				{
					$result[$areaid][$v]=bcmul($result[$areaid][$v],$result[$areaid]['recharge_rate'],2);	
				}
			}
			$result[$areaid]['jiesuan']=$result[$areaid]['recharge_fee']
			+$result[$areaid]['tender_mange']
			+$result[$areaid]['ontop_fee']
			+$result[$areaid]['borrow_fee']
			+$result[$areaid]['late_rate']
			-$result[$areaid]['recharge_online']
			-$result[$areaid]['recharge_award']
			-$result[$areaid]['vouch_ticheng']
			-$result[$areaid]['vouch_amount_ticheng']
			-$result[$areaid]['borrow_ticheng'];
		}
		return $result;
			
	}
	/**
	 * �ʽ�ʹ�ü�¼
	 *
	 * @return Array
	 */
	function GetAwardLogList($data = array()){
		global $mysql;
		$user_id = empty($data['user_id'])?"":$data['user_id'];
		$username = empty($data['username'])?"":$data['username'];
	
		$page = empty($data['page'])?1:$data['page'];
		$epage = empty($data['epage'])?10:$data['epage'];
	
		$_sql = "where 1=1 ";
		if (!empty($user_id)){
			$_sql .= " and p2.user_id = $user_id";
		}
		if (!empty($username)){
			$_sql .= " and p2.username = '$username'";
		}
	
		if (isset($data['dotime1']) && $data['dotime1']!=""){
			$_sql .= " and p1.addtime >= '".strtotime($data['dotime1'])."'";
		}
		if (isset($data['dotime2']) && $data['dotime2']!=""){
			$_sql .= " and p1.addtime <= '".strtotime($data['dotime2'])."'";
		}
		if (isset($data['type']) && $data['type']!=""){
			$_sql .= " and p1.type = '".$data['type']."'";
		}
	
		//liukun add for subsite_id search begin
		if (isset($data['areaid']) && $data['areaid']!="0"){
			$_sql .= " and p2.areaid = {$data['areaid']} ";
		}
		//liukun add for subsite_id search end
	
		$_select = "p1.*,p2.username";
		$sql = "select SELECT from  {recharge_award_log}  as p1
		left join {user} as p2 on p1.user_id=p2.user_id
		$_sql ORDER LIMIT";
			
		//�Ƿ���ʾȫ������Ϣ
		if (isset($data['limit']) ){
		$_limit = "";
		if ($data['limit'] != "all"){
		$_limit = "  limit ".$data['limit'];
		}
		$result= $mysql->db_fetch_arrays(str_replace(array('SELECT', 'ORDER', 'LIMIT'), array($_select,  'order by p1.addtime desc, p1.id desc', $_limit), $sql));
				return $result;
		}
		$row = $mysql->db_fetch_array(str_replace(array('SELECT', 'ORDER', 'LIMIT'), array('count(1) as num', '', ''), $sql));
	
		$total = $row['num'];
		$total_page = ceil($total / $epage);
		$index = $epage * ($page - 1);
		$limit = " limit {$index}, {$epage}";
	
		$list = $mysql->db_fetch_arrays(str_replace(array('SELECT', 'ORDER', 'LIMIT'), array($_select, 'order by p1.addtime desc, p1.id desc', $limit), $sql));
				$list = $list?$list:array();
				$row = $mysql->db_fetch_array(str_replace(array('SELECT', 'ORDER', 'LIMIT'), array('count(1) as num', '', ''), $sql));
				return array(
				'list' => $list,
				'total' => $total,
				'page' => $page,
				'epage' => $epage,
				'account' => $row['num'],
				'total_page' => $total_page
				);
	
	}
	
	/**
	 * �ʽ�ʹ�ü�¼
	 *
	 * @return Array
	 */
	function GetLogListForExcel($data = array()){
		global $mysql;
		$user_id = empty($data['user_id'])?"":$data['user_id'];
		$username = empty($data['username'])?"":$data['username'];
	
		$page = empty($data['page'])?1:$data['page'];
		$epage = empty($data['epage'])?10:$data['epage'];
		
		$_sql = "where 1=1 ";		 
		if (!empty($user_id)){
			$_sql .= " and p2.user_id = $user_id";
		}
		if (!empty($username)){
			$_sql .= " and p2.username = '$username'";
		}
		
		if (isset($data['dotime1']) && $data['dotime1']!=""){
			$_sql .= " and p1.addtime >= '".strtotime($data['dotime1'])."'";
		}
		if (isset($data['dotime2']) && $data['dotime2']!=""){
			$_sql .= " and p1.addtime <= '".strtotime($data['dotime2'])."'";
		}
		if (isset($data['type']) && $data['type']!="" && $data['type']!="excel"){
			$_sql .= " and p1.type = '".$data['type']."'";
		}
		
		//liukun add for subsite_id search begin
		if (isset($data['areaid']) && $data['areaid']!="0"){
			$_sql .= " and p2.areaid = {$data['areaid']} ";
		}
		//liukun add for subsite_id search end
		
		if (isset($data['borrow_status']) && $data['borrow_status']!=""){
			$_sql .= " and p5.status = {$data['borrow_status']} ";
		}
		
// 		$_select = "p1.*,p2.username,p3.username as to_username";
// 		$sql = "select SELECT from {account_log} as p1 
// 				 left join {user} as p2 on p1.user_id=p2.user_id
// 				 left join {user} as p3 on p3.user_id=p1.to_user 
// 				$_sql ORDER LIMIT";
		
		$_select = "p1.*,p2.username,p3.username as to_username, p4.sitename, p5.name as borrow_name ";
		$sql = "select SELECT from {account_log} as p1
		left join {user} as p2 on p1.user_id=p2.user_id
		left join {user} as p3 on p3.user_id=p1.to_user
		left join {subsite} as p4 on p4.id=p1.areaid
		left join {borrow} as p5 on p5.id=p1.borrow_id
		$_sql ORDER LIMIT";
				 
		//�Ƿ���ʾȫ������Ϣ
		$_limit = "";
		if ($data['limit'] != "all"){
			$_limit = "  limit ".$data['limit'];
		}

		$result= $mysql->db_fetch_arrays(str_replace(array('SELECT', 'ORDER', 'LIMIT'), array($_select,  'order by p1.addtime desc', $_limit), $sql));

                foreach ($result as $key => $value){
			$_data[$key] = array(date('Y-m-d H:i:s',$value['addtime']),$value['username'],$value['type'],$value['total'],$value['money'],$value['use_money'],$value['no_use_money'],$value['collection'],$value['to_username'],$value['remark'],$value['sitename'],$value['borrow_name']);
		}
      
		return $_data;
		
	}        
        
        
	/**
	 *�ʽ�ͳ��
	 *
	 * @return Array
	 */
	function GetLogCount($data = array()){
		global $mysql;
		$_sql = "where 1=1 ";
		if (isset($data['user_id']) && $data['user_id']!="" ){
			$_sql .= " and p1.user_id={$data['user_id']}";
		}
		
		$_select = "p1.*";
		$sql = "select SELECT from {account_log} as p1 $_sql ORDER LIMIT";
		$first_time = (isset($data['dotime2']) && $data['dotime2']!="")?$data['dotime2']:date("Y-m-d",time());
		$_first_time = strtotime($first_time);
		if (isset($data['dotime1']) && $data['dotime1']!="" ){
			$end_time =  strtotime($data['dotime1']);
		}else{
			$end_time = $_first_time - 7*60*60*24;
		}
		$result = $mysql->db_fetch_arrays(str_replace(array('SELECT', 'ORDER', 'LIMIT'), array($_select, '', ''), $sql));
		
		$_result = "";
		$i=round(($_first_time - $end_time)/(60*60*24));
		if ($i>60) $i=60;
		for ($j=0;$j<=$i;$j++){
			$day_ftime =  $_first_time - 60*60*24*$j;
			$date = date("Y-m-d",$day_ftime);
			$_result[$date]['i'] = $j;
			foreach ($result as $key=>$value){
				if ($value['addtime']>=$day_ftime && $value['addtime']<=$day_ftime+60*60*24){
					$_result[$date][$value['type']] += $value['money'];
				}
			}
		}
		return $_result;
	}
	
	
	/**
	 * ��ȡ�û��ʽ��ȫ����¼,
	 *
	 * @return Array
	 */
	function GetAccountAll($data = array()){
		global $mysql;
		$user_id = (int)$data['user_id'];
		
		//�ʽ��˺����
		$sql = "select * from  {account}  where user_id = {$user_id} limit 1";
		$result = $mysql -> db_fetch_array($sql);
		//�ʽ��˺����
		$sql = "select borrow_amount from  {user_cache}  where user_id = {$user_id} limit 1";
		$_result = $mysql -> db_fetch_array($sql);
		$result['amount'] = round($_result['borrow_amount'],2);//����ܶ�
		
		//�����ܶ�
		$sql = "select sum(repayment_account) as borrow_num ,sum(repayment_yesaccount) as borrow_yesnum from {borrow_repayment} where borrow_id in (select id from  {borrow}  where user_id = {$user_id}) ";
		$_result = $mysql -> db_fetch_array($sql);
		$result['wait_payment'] = round(($_result['borrow_num'] - $_result['borrow_yesnum']),2);//�����ܶ�
		$result['borrow_num'] = round($_result['borrow_num'],2);//����ܶ�
		$result['borrow_yesnum'] = round($_result['borrow_yesnum'],2);//�ѻ��ܶ�
		$result['use_amount'] = round($result['amount']-$result['wait_payment'],2);
		
		//�����ܽ��,������Ϣ
		$sql = "select sum(account) as account_num,sum(interest) as interest_num,sum(repayment_account) as repayment_account_num,sum(repayment_yesaccount) as repayment_yesaccount_num,sum(wait_account) as wait_account_num,sum(wait_interest) as wait_interest_num,sum(repayment_yesinterest) as repayment_yesinterest_num from {borrow_tender} where  borrow_id in (select id from  {borrow}  where status=3) and user_id=$user_id";
		$_result = $mysql -> db_fetch_array($sql);
		$result['tender_num'] = round($_result['account_num'],2);//Ͷ���ܶ�
		$result['tender_numall'] = round($_result['repayment_account_num'],2);//Ͷ���ܶ�+��Ϣ
		$result['tender_yesnum'] = round($_result['repayment_yesaccount_num'],2);//�����ܶ�
		$result['tender_wait'] =  round($_result['wait_account_num'],2);//�����ܶ�
		$result['tender_wait_interest'] = round($_result['wait_interest_num'],2);//������Ϣ
		$result['tender_interest'] = round(($_result['repayment_account_num'] - $_result['account_num']),2);//��׬��Ϣ
		
		
		return $result;
	}
		
		
		
	//��ȡ�ʽ��¼���б������ͺ�ʱ�����
	function GetLogGroup($data = array()){
		global $mysql;
		$_sql = "";
		if (isset($data['user_id']) && $data['user_id']!="" ){
			$_sql .= " and p1.user_id={$data['user_id']}";
		}
		$sql = "select sum(p1.money) as num,p1.type,p2.name from  {account_log}  as p1 left join  {linkage}  as p2 on p2.value=p1.type where p2.type_id=30 {$_sql} and p1.type in ('borrow_success','borrow_fee','margin','award_lower','fee') group by type order by p1.type desc";
		$result = $mysql->db_fetch_arrays($sql);
		return $result;
	
	}
	
	//���߳�ֵ�������ݴ���
	function  OnlineReturn ($data = array()){
		global $mysql, $_G;
		$online_recharge_award = isset($_G['system']['con_online_recharge_award'])?$_G['system']['con_online_recharge_award']:0;
		$trade_no = $data['trade_no'];
		
		$rechage_result = self::GetRechargeOne(array("trade_no"=>$trade_no));
		if($rechage_result['status']==0){
			$user_id = str_replace($rechage_result['addtime'],"",$trade_no);
			$user_id = substr($user_id,0,strlen($user_id)-1);
			//liukun add for bug 169 begin
			$current_time=time();
			$recharge_money = $rechage_result['money'];
			$sql="select * from {recharge_award_rule} where min_account <='{$recharge_money}' and max_account >= '{$recharge_money}' and begin_time <= {$current_time} and end_time >= {$current_time} limit 1";
			$rule_result = $mysql->db_fetch_array($sql);
			if($rule_result == false){
				//û�н����
			}
			$award_rate=$rule_result['award_rate'];
			$recharge_award = 0;
			
			if ($award_rate > 0){
				$recharge_award = round($recharge_money * $award_rate / 100, 2);
				$sql = "update  {account}  set `award` = `award` + {$recharge_award}, `use_award` = `use_award` + {$recharge_award}";
				$sql .= " where user_id=$user_id";
				
				$mysql->db_query($sql);
					
				//����award��־
				$award_log['user_id'] = $user_id;
				$award_log['type'] = "recharge_award";
				$award_log['award'] = $recharge_award;
				$award_log['remark'] = "��ֵ����";
				$sql = "insert into  {recharge_award_log}  set `addtime` = '".time()."',`addip` = '".ip_address()."'";
				foreach($award_log as $key => $value){
					$sql .= ",`$key` = '$value'";
				}
				$mysql->db_query($sql);
			}
			//liukun add for bug 169 end
			
			
			$account_result =  self::GetOne(array("user_id"=>$user_id));		
			$log['user_id'] = $user_id;
			$log['type'] = "recharge_online";
			$log['money'] = $rechage_result['money'];
			$log['total'] = $account_result['total']+$rechage_result['money'];
			$log['use_money'] = $account_result['use_money']+$rechage_result['money'];
			$log['no_use_money'] = $account_result['no_use_money'];
			$log['collection'] = $account_result['collection'];
			$log['to_user'] = 0;
			$log['remark'] = "���߳�ֵ";
			accountClass::AddLog($log);			
			
			if(1==2){
				//��ʱ��֧�ֳ�ֵ������
				$account_result =  self::GetOne(array("user_id"=>$user_id));
				$log['user_id'] = $user_id;
				$log['type'] = "fee";
				$log['money'] =$rechage_result['fee'];
				$log['total'] = $account_result['total']-$log['money'];
				$log['use_money'] = $account_result['use_money']-$log['money'];
				$log['no_use_money'] = $account_result['no_use_money'];
				$log['collection'] = $account_result['collection'];
				$log['to_user'] = 0;
				$log['remark'] = "���߳�ֵ������";
				accountClass::AddLog($log);
			}			
			//��ֵ�ֽ���
			$log['money'] =round($rechage_result['money'] * $online_recharge_award, 2);
			if($log['money'] >0)
			{
				$account_result =  self::GetOne(array("user_id"=>$user_id));
				$log['user_id'] = $user_id;
				$log['type'] = "recharge_award";
				
				$log['total'] = $account_result['total']+$log['money'];
				$log['use_money'] = $account_result['use_money']+$log['money'];
				$log['no_use_money'] = $account_result['no_use_money'];
				$log['collection'] = $account_result['collection'];
				$log['to_user'] = 0;
				$log['remark'] = "���߳�ֵ����";
				accountClass::AddLog($log);
			}
			$rec['id'] = $rechage_result['id'];
			$rec['return'] = serialize($_REQUEST);
			$rec['status'] = 1;
			$rec['verify_userid'] = 0;
			$rec['verify_time'] = time();
			$rec['verify_remark'] = "�ɹ���ֵ";
			//liukun add for bug 221 begin
			$rec['award'] = $recharge_award;
			//liukun add for bug 221 end
			
			self::UpdateRecharge($rec);
		}
		return true;
	}
	
	//VIP���õĿ۳�
	function AccountVip($data = array()){
		global $mysql,$_G;
		$user_id = $data['user_id'];
		$sql = "select p1.vip_money,p1.vip_status,p2.* from  {user_cache}  as p1 left join  {account}  as p2 on p1.user_id=p2.user_id where p1.user_id = {$user_id}";
		$result = $mysql->db_fetch_array($sql);
		$vip_money = (!isset($_G['system']['con_vip_money']) || $_G['system']['con_vip_money']=="")?150:$_G['system']['con_vip_money'];
		$ws_fl_rate = isset($_G['system']['con_ws_fl_rate'])?$_G['system']['con_ws_fl_rate']:0.16;
		$point2account = isset($_G['system']['con_point2account'])?$_G['system']['con_point2account']:2.52;
		$con_connect_ws = isset($_G['system']['con_connect_ws'])?$_G['system']['con_connect_ws']:"0";
		//�ж�vip��ǮΪ0������Ǯ���ٿ�
		//if ($result['vip_money']=="" && $result['use_money']>=$vip_money && $result['vip_status']==1){
// 		if ($result['vip_money']=="0"  && $result['vip_status']==1){
		if ($result['vip_status']==1){
			//�۳�vip�Ļ�Ա�ѡ�
			if( $data['from']=="account"){
				$account_result =  self::GetOne(array("user_id"=>$user_id));
				$vip_log['user_id'] = $user_id;
				$vip_log['type'] = "vip";
				$vip_log['money'] = $vip_money;
				$vip_log['total'] = $account_result['total']-$vip_log['money'];
				$vip_log['use_money'] = $account_result['use_money']-$vip_log['money'];
				$vip_log['no_use_money'] = $account_result['no_use_money'];
				$vip_log['collection'] = $account_result['collection'];
				$vip_log['to_user'] = "0";
				$vip_log['remark'] = "�۳�VIP��Ա��(���³�ֵ�п۷�)";
				self::AddLog($vip_log);
			}else{
				$account_result =  self::GetOne(array("user_id"=>$user_id));
				$vip_log['user_id'] = $user_id;
				$vip_log['type'] = "vip";
				$vip_log['money'] = $vip_money;
				$vip_log['total'] = $account_result['total']-$vip_log['money'];
				$vip_log['use_money'] = $account_result['use_money'];
				$vip_log['no_use_money'] = $account_result['no_use_money']-$vip_log['money'];
				$vip_log['collection'] = $account_result['collection'];
				$vip_log['to_user'] = "0";
				$vip_log['remark'] = "�۳�VIP��Ա��(�۳�VIP������)";
				self::AddLog($vip_log);
			}

			$sql = "update  {user_cache}  set vip_money=$vip_money where user_id='{$user_id}'";
			$mysql -> db_query($sql);
		}
	}
	
	//�ʽ�۳��������ֳ���֤���� type,money,remark
	function Deduct($data){
		global $mysql,$_G;
		$account_result =  self::GetOne(array("user_id"=>$data['user_id']));		
		if($account_result['use_money'] < $data['money']){
			return "�˿ͻ��������㣬�������Ϊ{$account_result['use_money']}";
		}
		if($data['money'] < 0){
			return "��������Ϊ����";
		}
		$log['user_id'] = $data['user_id'];
		$log['type'] = $data['type'];
		$log['money'] = $data['money'];
		$log['total'] = $account_result['total']-$data['money'];
		$log['use_money'] = $account_result['use_money']-$data['money'];
		$log['no_use_money'] = $account_result['no_use_money'];
		$log['collection'] = $account_result['collection'];
		$log['to_user'] = 0;
		$log['remark'] = $data['remark'];
		accountClass::AddLog($log);
		
		require_once("modules/message/message.class.php");
		$message['sent_user'] = "0";
		$message['receive_user'] = $data['user_id'];
//                 if($data['type'] == "scene_account"){
//                     $message['name'] = "�ֳ���֤����";
//                 }else 
                if($data['type'] == "vouch_advanced"){
                    $message['name'] = "�����渶�۷�";
                }else if($data['type'] == "borrow_kouhui"){
                    $message['name'] = "����˷���ۻ�";
                }else{
                    $message['name'] = $data['remark'];
                }
		$message['content'] = $data['remark'];
		$message['type'] = "system";
		$message['status'] = 0;
		messageClass::Add($message);//���Ͷ���Ϣ
		return true;
	}
	
	function Tongji($data = array()){
		global $mysql,$_G;
		$_first_month = strtotime("2010-08-01");
		$_now_year = date("Y",time());
		$_now_month = date("n",time());
		$month = ($_now_year-2011)*12 + 5+$_now_month;//���ڵ�����
		
		//�ɹ����
		for ($i=1;$i<=$month;$i++){
			$up_month = strtotime("$i month",$_first_month);
			$now_month = strtotime("-1 month",$up_month);
			$nowlast_day = strtotime("-1 day",$up_month);
			
			//liukun add for site_id search begin
			$_sql = "";
			if (isset($data['areaid']) && $data['areaid']!="0"){
				$_sql = " and p3.areaid = {$data['areaid']} ";
			}
			//liukun add for biao_type search begin
			
			$sql = "select sum(p1.money) as num,p1.type,p2.name as type_name from  {account_log}  as p1 left join  {linkage}  as p2 on p1.type=p2.value 
					left join  {user}  as p3 on p1.user_id = p3.user_id  
					where p2.type_id=30 and p1.addtime >= {$now_month} and p1.addtime < {$nowlast_day} 
					{$_sql}
					group by  p1.type ";
			$result = $mysql->db_fetch_arrays($sql);
			
			if (count($result)>0){
			$_result[date("Y-n",$now_month)] = $result;
			}
		}
		return $_result;
	
	}

	//�����û���ֵ���
	function getJinAmount($data = array()){
		global $mysql, $_G;
		$stock_price = isset($_G['system']['con_stock_price'])?$_G['system']['con_stock_price']:"0";
		$jin_rate = isset($_G['system']['con_jin_rate'])?$_G['system']['con_jin_rate']:"1";
		$dsjin_rate = isset($_G['system']['con_dsjin_rate'])?$_G['system']['con_dsjin_rate']:"1";
		
		
		
		$userAccount = self::GetOne($data);
		$user_id = $data['user_id'];
		
		//TODO��ֵ���㷽��
		//liukun add for bug 98 begin
		//Ͷ�궳��
		$sql = "select ifnull(sum(bt.account), 0) as tender_nouse from  {borrow_tender}  bt,  {borrow}  bw 
				where bt.user_id = {$user_id} and bt.borrow_id = bw.id and bw.status = 1";
		$result = $mysql->db_fetch_array($sql);
		$tender_nouse = $result['tender_nouse'];
		//����
		$sql = "select ifnull(sum(repayment_account - repayment_yesaccount ), 0) as repayment FROM   {borrow}  bw
				where bw.user_id = {$user_id} and bw.status = 3";
		$result = $mysql->db_fetch_array($sql);
		$repayment = $result['repayment'];
		
		//���ձ���
		$sql = "select sum(round(floor(bt.capital * br.has_percent) / 100, 2)) as cb_capital
		from  {borrow_right}  br,   {borrow_repayment}  bt where br.creditor_id = {$user_id} and br.borrow_id = bt.borrow_id  and bt.status = 0 ";
		$result = $mysql->db_fetch_array($sql);

		$cb_capital = $result['cb_capital'];		
		
		//��ת���ձ���
		$sql="select sum(cbs.capital) as cb_capital from {circulation_buy_serial} cbs,{circulation} c,{borrow} b
		where cbs.circulation_id=c.id and c.borrow_id=b.id and b.status=1 and cbs.buyback=0 and cbs.buyer_id={$user_id}";
		$result = $mysql->db_fetch_array($sql);
		$cb_capital_lz = $result['cb_capital'];
		
		
		/*
		//liukun add for bug 207 begin
		//ת���е�ծȨ
		$sql = "select ifnull(sum( ba.amount / ba.has_percent * br.has_percent), 0) as right_alienate  from  {borrow_right_alienate}   ba,  {borrow_right}  br
				where ba.borrow_right_id = br.id and br.creditor_id = {$user_id} and ba.status = 1 and ba.valid = 1 ";
		$result = $mysql->db_fetch_array($sql);
		$right_alienate = $result['right_alienate'];
		//liukun add for bug 207 end
		*/
		
		//liukun add for bug 98 end
		
		
/*	���ڣ���ֵ���= (������� + Ͷ�궳�� + ���ձ�Ϣ - ����ת�õ�ծȨ +�ɷݼ�ֵ) * ��ֵ�� -����;
//��ֵҪ����������ģ���û�лع�����ת��
		$jinAmount = round(($userAccount['use_money'] + $tender_nouse + $userAccount['collection'] - $right_alienate 
				 +  $userAccount['stock']*$stock_price)*$jin_rate  -$repayment, 2); 
	�����󣺾�ֵ���= (������� + Ͷ�궳��+�ɷݼ�ֵ) * n+�����ձ���+��ת���ձ���*n -������Ϣ;
*/
	$jinAmount =round_money(($userAccount['use_money'] + $tender_nouse + $userAccount['stock']*$stock_price) *$jin_rate + ($cb_capital+$cb_capital_lz)* $dsjin_rate   -$repayment); 
	
		return $jinAmount;
	}
	
	//�����û���ֵ���
	function getJinAmountVouch($data = array()){
		global $mysql, $_G;
		$stock_price = isset($_G['system']['con_stock_price'])?$_G['system']['con_stock_price']:"0";
		$jin_rate = isset($_G['system']['con_jin_rate'])?$_G['system']['con_jin_rate']:"1";
		$dsjin_rate = isset($_G['system']['con_dsjin_rate'])?$_G['system']['con_dsjin_rate']:"1";
		$userAccount = self::GetOne($data);
		$user_id = $data['user_id'];
	
		//TODO��ֵ���㷽��
		//liukun add for bug 98 begin
		//Ͷ�궳��
		$sql = "select ifnull(sum(bt.account), 0) as tender_nouse from  {borrow_tender}  bt,  {borrow}  bw
		where bt.user_id = {$user_id} and bt.borrow_id = bw.id and bw.status = 1";
		$result = $mysql->db_fetch_array($sql);
		$tender_nouse = $result['tender_nouse'];
		//����
		$sql = "select ifnull(sum(repayment_account - repayment_yesaccount ), 0) as repayment FROM   {borrow}  bw
		where bw.user_id = {$user_id} and bw.status = 3";
		$result = $mysql->db_fetch_array($sql);
		$repayment = $result['repayment'];
		//liukun add for bug 207 begin
		
		/*
		//ת���е�ծȨ
		$sql = "select ifnull(sum( ba.amount / ba.has_percent * br.has_percent), 0) as right_alienate  from  {borrow_right_alienate}   ba,  {borrow_right}  br
				where ba.borrow_right_id = br.id and br.creditor_id = {$user_id} and ba.status = 1 and ba.valid = 1 ";
				$result = $mysql->db_fetch_array($sql);
				$right_alienate = $result['right_alienate'];
				//liukun add for bug 207 end
				*/
				
		//���ձ���
		$sql = "select sum(round(floor(bt.capital * br.has_percent) / 100, 2)) as cb_capital
		from  {borrow_right}  br,   {borrow_repayment}  bt where br.creditor_id = {$user_id} and br.borrow_id = bt.borrow_id  and bt.status = 0 ";
		$result = $mysql->db_fetch_array($sql);

		$cb_capital = $result['cb_capital'];		
		
		//��ת���ձ���
		$sql="select sum(cbs.capital) as cb_capital from {circulation_buy_serial} cbs,{circulation} c,{borrow} b
		where cbs.circulation_id=c.id and c.borrow_id=b.id and b.status=1 and cbs.buyback=0 and cbs.buyer_id={$user_id}";
		$result = $mysql->db_fetch_array($sql);
		$cb_capital_lz = $result['cb_capital'];
		
		/*
		��ֵ��ȣ�����ģʽ�� = (������� + Ͷ�궳�� + ���ձ�Ϣ - ����ת�õ�ծȨ +�ɷݼ�ֵ) * ��ֵ�� -���� -��Ͷ�ʵ�����ȡ�
��ֵ��ȣ�����ģʽ�� = (������� + Ͷ�궳��+�ɷݼ�ֵ) * n+�����ձ���+��ת���ձ���*n -������Ϣ-��Ͷ�ʵ�����ȡ�
		
		
	
		//��ֵҪ����������ģ���û�лع�����ת��
		$jinAmount = round(($userAccount['use_money'] + $tender_nouse + $userAccount['collection'] - $right_alienate
				+  $userAccount['stock']*$stock_price) * $jin_rate -$repayment, 2);

		*/
		
		$jinAmount =round_money(($userAccount['use_money'] + $tender_nouse + $userAccount['stock']*$stock_price) *$jin_rate + ($cb_capital+$cb_capital_lz)* $dsjin_rate   -$repayment); 
		

		
		//��ֵҪ��ȥͶ�ʵ������
		$amount_result = amountClass::GetAmountOne($user_id, "tender_vouch");
		$jinAmount -= $amount_result['account_all'];
				//liukun add for bug 98 end
	
		
		return $jinAmount;
	}	
	
	/**
	 * �ο������б�
	 *
	 * @return Array
	 */
	function GetWsflList($data = array()){
		global $mysql;
	
		$page = empty($data['page'])?1:$data['page'];
		$epage = empty($data['epage'])?10:$data['epage'];
	
		$_sql = " ";
	
		if (isset($data['user_id']) && $data['user_id']!=""){
			$_sql .= " and p2.user_id = '{$data['user_id']}'";
		}
	
		if (isset($data['username']) && $data['username']!=""){
			$data['username'] = urldecode($data['username']);
			$_sql .= " and p2.username like '%{$data['username']}%'";
		}
	
		//liukun add for subsite_id search begin
		if (isset($data['areaid']) && $data['areaid']!="0"){
			$_sql .= " and p2.areaid = {$data['areaid']} ";
		}
		//liukun add for subsite_id search end
		
// 		select p2.user_id, p2.username, p1.user_id as ws_user_id, p1.mony, p1.loaner_money ,LEFT(p1.income_time, 10) as fl_time from dw_return_serial rs
// 		, dw_user ur where rs.user_id = ur.ws_user_id
		
	
		$sql = "select SELECT from  {return_serial}  as p1,
		  {user}   p2 where p1.user_id=p2.ws_user_id
		$_sql ORDER LIMIT";
		$_select = " p2.user_id, p2.username, p2.realname , p1.user_id as ws_user_id, p1.mony, p1.loaner_money ,LEFT(p1.income_time, 10) as fl_time, p1.process, p1.process_id ";
	
		//$sqlTmp=str_replace(array('SELECT', 'ORDER', 'LIMIT'), array($_select, 'order by p1.id desc', $limit), $sql);
		//echo $sqlTmp;
		//exit;
		//�Ƿ���ʾȫ������Ϣ
		if (isset($data['limit']) ){
				$_limit = "";
		if ($data['limit'] != "all"){
				$_limit = "  limit ".$data['limit'];
		}
		$list =  $mysql->db_fetch_arrays(str_replace(array('SELECT', 'ORDER', 'LIMIT'), array($_select, 'order by p1.id desc', $_limit), $sql));
			
		return $list;
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
	 * �ο������б�
	 *
	 * @return Array
	 */
	function GetWsflCashList($data = array()){
		global $mysql;
	
		$page = empty($data['page'])?1:$data['page'];
		$epage = empty($data['epage'])?10:$data['epage'];
	
		$_sql = "";
	
		if (isset($data['user_id']) && $data['user_id']!=""){
			$_sql .= " and p2.user_id = '{$data['user_id']}'";
		}
	
		if (isset($data['username']) && $data['username']!=""){
			$data['username'] = urldecode($data['username']);
			$_sql .= " and p2.username like '%{$data['username']}%'";
		}
	
		//liukun add for subsite_id search begin
		if (isset($data['areaid']) && $data['areaid']!="0"){
			$_sql .= " and p2.areaid = {$data['areaid']} ";
		}
		//liukun add for subsite_id search end
	
		// 		select p2.user_id, p2.username, p1.user_id as ws_user_id, p1.mony, p1.loaner_money ,LEFT(p1.income_time, 10) as fl_time from dw_return_serial rs
		// 		, dw_user ur where rs.user_id = ur.ws_user_id
	
// 		select  sum(rs.mony), sum(rs.loaner_money) ,LEFT(rs.income_time, 10) fl_time, rs.process from dw_return_serial rs
// 		, dw_user ur where rs.user_id = ur.ws_user_id group by LEFT(rs.income_time, 10), rs. process
		
		$sql = "select SELECT from  {return_serial}  as p1
		,  {user}  as p2 where p1.user_id=p2.ws_user_id
		$_sql group by LEFT(p1.income_time, 10) , p1.process ORDER LIMIT";
		$_select = " sum(p1.mony) as total_mony, sum(p1.loaner_money) as total_loaner_money ,LEFT(p1.income_time, 10) fl_time, p1.process ";
		
		
	
		//$sqlTmp=str_replace(array('SELECT', 'ORDER', 'LIMIT'), array($_select, 'order by p1.id desc', $limit), $sql);
		//echo $sqlTmp;
		//exit;
		//�Ƿ���ʾȫ������Ϣ
		if (isset($data['limit']) ){
			$_limit = "";
			if ($data['limit'] != "all"){
				$_limit = "  limit ".$data['limit'];
			}
			$list =  $mysql->db_fetch_arrays(str_replace(array('SELECT', 'ORDER', 'LIMIT'), array($_select, 'order by fl_time desc, p1.process asc', $_limit), $sql));
				
			return $list;
		}
		$sql_num = "select count(1) as num from (select LEFT(p1.income_time, 10) fl_time from  {return_serial}  as p1,
					  {user}  as p2 where p1.user_id=p2.ws_user_id
					$_sql group by LEFT(p1.income_time, 10) , p1.process) as tmp_table";
		
		$row = $mysql->db_fetch_array($sql_num);
	
		$total = $row['num'];
		$total_page = ceil($total / $epage);
		$index = $epage * ($page - 1);
		$limit = " limit {$index}, {$epage}";
	
		$list = $mysql->db_fetch_arrays(str_replace(array('SELECT', 'ORDER', 'LIMIT'), array($_select, 'order by fl_time desc', $limit), $sql));
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
	 * �ο������б�
	 *
	 * @return Array
	 */
function GetQueuelList($data = array()){
		global $mysql;
	
		$page = empty($data['page'])?1:$data['page'];
		$epage = empty($data['epage'])?10:$data['epage'];
	
		$_sql = " ";
	
		if (isset($data['user_id']) && $data['user_id']!=""){
			$_sql .= " and p2.user_id = '{$data['user_id']}'";
		}
	
		if (isset($data['username']) && $data['username']!=""){
			$data['username'] = urldecode($data['username']);
			$_sql .= " and p2.username like '%{$data['username']}%'";
		}
	
		//liukun add for subsite_id search begin
		if (isset($data['areaid']) && $data['areaid']!="0"){
			$_sql .= " and p2.areaid = {$data['areaid']} ";
		}
		//liukun add for subsite_id search end
		
// 		select p2.user_id, p2.username, p1.user_id as ws_user_id, p1.mony, p1.loaner_money ,LEFT(p1.income_time, 10) as fl_time from dw_return_serial rs
// 		, dw_user ur where rs.user_id = ur.ws_user_id
		
	
		$sql = "select SELECT from  {return_queue}  as p1,
		  {user}   p2 where p1.user_id=p2.user_id
		$_sql ORDER LIMIT";
		$_select = "p1.*, p2.username, p2.realname , p2.ws_user_id ";
	
		//$sqlTmp=str_replace(array('SELECT', 'ORDER', 'LIMIT'), array($_select, 'order by p1.id desc', $limit), $sql);
		//echo $sqlTmp;
		//exit;
		//�Ƿ���ʾȫ������Ϣ
		if (isset($data['limit']) ){
				$_limit = "";
		if ($data['limit'] != "all"){
				$_limit = "  limit ".$data['limit'];
		}
		$list =  $mysql->db_fetch_arrays(str_replace(array('SELECT', 'ORDER', 'LIMIT'), array($_select, 'order by p1.id desc', $_limit), $sql));
			
		return $list;
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
	 * ����û��Ĺɷ�����
	 *
	 * @param Array $data
	 * @return Boolen
	 */
	function AddStockApply($data = array()){
		global $mysql;
		global $_G;
		$user_id = $data['user_id'];
		if (!isset($user_id))
			return false;//����û������ڣ��򷵻�
		$stock_price = isset($_G['system']['con_stock_price'])?$_G['system']['con_stock_price']:"2.655";
	
	
		$stock_num = $data['num'];
		$optype = $data['optype'];
		$stock_fee =  round($stock_num * $stock_price, 2);
		$account_result =  accountClass::GetOne(array("user_id"=>$user_id));//��ȡ��ǰ�û������
		//liukun add for bug ������Ϲ�����ô��Ҫ�ж�����Ƿ�
		if ($optype == "0"){
			if($account_result['use_money'] < $stock_fee){
				$msg="�������㣬�޷����빺��";
				return $msg;
			}
		}
		//liukun add for bug ������۳���Ҫ�ж��Ƿ����㹻�ķ���
		if ($optype == "1"){
			if($account_result['stock'] < $stock_num){
				$msg="�����۳������������з������޷������۳���";
				return $msg;
			}
		}
		$mysql->db_query("start transaction");
		//liukun add for bug 472 end
		$transaction_result = true;
		try{
			
			//������Ϲ����������
			if ($optype == "0"){
				$account_result =  accountClass::GetOne(array("user_id"=>$user_id));//��ȡ��ǰ�û������
	
				$log['user_id'] = $user_id;
				$log['type'] = "buy_stock_fee_frost";
				$log['money'] = $stock_fee;
				$log['total'] = $account_result['total'];
				$log['use_money'] =  $account_result['use_money']-$log['money'];
				$log['no_use_money'] =  $account_result['no_use_money']+$log['money'];
				$log['collection'] =  $account_result['collection'];
				$log['to_user'] = 0;
				$log['remark'] = "�Ϲ��ɷ����붳�������";
	
				$transaction_result = accountClass::AddLog($log);//��Ӽ�¼
				if ($transaction_result !==true){
					throw new Exception();
				}
			}
			
			//������۳�������ɷ�
			if ($optype == "1"){
				$sql = "update  {account}  set `stock` = `stock` - {$stock_num}, `no_use_stock` = `no_use_stock` + {$stock_num} ";
				
				$sql .= " where user_id={$user_id}";
				$transaction_result = $mysql->db_query($sql);
				if ($transaction_result !==true){
					throw new Exception();
				}
			}
	
	
			$data["trade_account"] = $stock_fee;
			$data["status"] = 0;
			$sql = "insert into  {stock_serial}  set `addtime` = '".time()."',`addip` = '".ip_address()."'";
			foreach($data as $key => $value){
				$sql .= ",`$key` = '$value'";
			}
			$transaction_result = $mysql->db_query($sql);
			if ($transaction_result !==true){
				throw new Exception();
			}
		}
	
		catch (Exception $e){
			//���뱣֤���в��ɽ��ܵĴ��󶼷����쳣����ִ���˻ع�
			$mysql->db_query("rollback");
		}
		//liukun add for bug 472 begin
		if($transaction_result===true){
			$mysql->db_query("commit");
			return true;
		}else{
			$mysql->db_query("rollback");
			return $transaction_result;
		}
	}
		
	/**
	 * �б�
	 *
	 * @return Array
	 */
	function GetStockApplyList($data = array()){
		global $mysql;
	
		$page = empty($data['page'])?1:$data['page'];
		$epage = empty($data['epage'])?10:$data['epage'];
	
		$_sql = "where 1=1 ";
	
		if (isset($data['status']) && $data['status']!=""){
			$_sql .= " and p1.status = {$data['status']}";
		}
		if (isset($data['user_id']) && $data['user_id']!=""){
			$_sql .= " and p1.user_id = {$data['user_id']}";
		}
		if (isset($data['username']) && $data['username']!=""){
			$_sql .= " and p2.username like '%{$data['username']}%' ";
		}
		if (isset($data['optype']) && $data['optype']!=""){
			$_sql .= " and p1.optype = {$data['optype']} ";
		}
		//liukun add for site_id search begin
		if (isset($data['areaid']) && $data['areaid']!="0"){
			$_sql .= " and p2.areaid = {$data['areaid']} ";
		}
		//liukun add for biao_type search begin
	
		$_select = 'p1.*,p2.username';
		$sql = "select SELECT from  {stock_serial}  as p1
		left join {user} as p2 on p1.user_id=p2.user_id
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
	
	function GetStockOne($data){
		global $mysql;
		fb($data, FirePHP::TRACE);
		$sql = " where 1=1 ";
		if (isset($data['user_id'])){
			$sql .= " and p1.user_id={$data['user_id']}  ";
		}
		if (isset($data['id'])){
			$sql .= " and p1.id={$data['id']} ";
		}
		$sql = "select p1.*,p2.username from  {stock_serial}  as  p1 left join  {user}  as p2 on p1.user_id=p2.user_id " . $sql ." order by p1.id desc";
		$result = $mysql ->db_fetch_array($sql);
	
		return $result;
	}
	
	function CheckStock($data){
		global $mysql,$_G;
	
		$result = self::GetStockOne(array("id"=>$data['id']));//��ȡ��ȵ���Ϣ�����Ƿ��Ѿ�������
		$user_id = $result['user_id'];
		$stock_num = $result['num'];
		$optype =  $result['optype'];
		$trade_account = $result['trade_account'];
		//liukun add for bug 52 begin
		fb($data, FirePHP::TRACE);
		fb($result, FirePHP::TRACE);
		//liukun add for bug 52 end
		if ($result['status']!=0){
			return "�Ѿ���˹����벻Ҫ�ظ�������";
		}
	
		//liukun add for bug 472 begin
		$mysql->db_query("start transaction");
		//liukun add for bug 472 end
		$transaction_result = true;
		try{
			
			//���ͨ���Ĵ���
			if ($data['status'] == "1"){
				if ($optype == "0"){
					$account_result =  accountClass::GetOne(array("user_id"=>$user_id));//��ȡ��ǰ�û������
				
					$log['user_id'] = $user_id;
					$log['type'] = "buy_stock_fee";
					$log['money'] = $trade_account;
					$log['total'] = $account_result['total']-$log['money'];
					$log['use_money'] =  $account_result['use_money'];
					$log['no_use_money'] =  $account_result['no_use_money']-$log['money'];
					$log['collection'] =  $account_result['collection'];
					$log['to_user'] = 0;
					$log['remark'] = "�Ϲ��ɷ�֧��";
				
					$transaction_result = accountClass::AddLog($log);//��Ӽ�¼
					if ($transaction_result !==true){
						throw new Exception();
					}
					
					$sql = "update  {account}  set `stock` = `stock` + {$stock_num} ";
					
					$sql .= " where user_id={$user_id}";
					$transaction_result = $mysql->db_query($sql);
					if ($transaction_result !==true){
						throw new Exception();
					}
				}
					
				//������۳�������ɷ�
				if ($optype == "1"){
					$account_result =  accountClass::GetOne(array("user_id"=>$user_id));//��ȡ��ǰ�û������
					
					$log['user_id'] = $user_id;
					$log['type'] = "sell_stock_fee";
					$log['money'] = $trade_account;
					$log['total'] = $account_result['total']+$log['money'];
					$log['use_money'] =  $account_result['use_money']+$log['money'];
					$log['no_use_money'] =  $account_result['no_use_money'];
					$log['collection'] =  $account_result['collection'];
					$log['to_user'] = 0;
					$log['remark'] = "�۳��ɷ�����";
					
					$transaction_result = accountClass::AddLog($log);//��Ӽ�¼
					if ($transaction_result !==true){
						throw new Exception();
					}
					
					$sql = "update  {account}  set `no_use_stock` = `no_use_stock` - {$stock_num} ";
				
					$sql .= " where user_id={$user_id}";
					$transaction_result = $mysql->db_query($sql);
					if ($transaction_result !==true){
						throw new Exception();
					}
				}
				
				
				
			}
			
			//��˲�ͨ���Ĵ���
			if ($data['status'] == "2"){
				if ($optype == "0"){
					$account_result =  accountClass::GetOne(array("user_id"=>$user_id));//��ȡ��ǰ�û������
				
					$log['user_id'] = $user_id;
					$log['type'] = "buy_stock_fee_unfrost";
					$log['money'] = $trade_account;
					$log['total'] = $account_result['total'];
					$log['use_money'] =  $account_result['use_money']+$log['money'];
					$log['no_use_money'] =  $account_result['no_use_money']-$log['money'];
					$log['collection'] =  $account_result['collection'];
					$log['to_user'] = 0;
					$log['remark'] = "�Ϲ��ɷݶ�������˻�";
				
					$transaction_result = accountClass::AddLog($log);//��Ӽ�¼
					if ($transaction_result !==true){
						throw new Exception();
					}
						
					
				}
					
				//������۳�������ɷ�
				if ($optype == "1"){
					
						
					$sql = "update  {account}  set `stock` = `stock` + {$stock_num}, `no_use_stock` = `no_use_stock` - {$stock_num} ";
				
					$sql .= " where user_id={$user_id}";
					$transaction_result = $mysql->db_query($sql);
					if ($transaction_result !==true){
						throw new Exception();
					}
				}
			}
			
			//�����Ƿ�����ͨ����Ҫ�ⶳ����ʱ����ķ���
			$sql = "update  {stock_serial}  set status={$data['status']},verify_time='".time()."',verify_user=".$_G['user_id'].",verify_remark='{$data['verify_remark']}' where id = {$data['id']}";
			$transaction_result = $mysql ->db_query($sql);
			if ($transaction_result !==true){
				throw new Exception();
			}
			
	
		}
		catch(Exception $e){
			$mysql->db_query("rollback");
		}
	
		//liukun add for bug 472 begin
		if($transaction_result===true){
			$mysql->db_query("commit");
			return true;
		}else{
			$mysql->db_query("rollback");
			return $transaction_result;
		}
		//liukun add for bug 472 end
	
	}
	
	/**
	 * �ʽ�ʹ�ü�¼
	 *
	 * @return Array
	 */
	function GetTichenList($data = array()){
		global $mysql;
		$username = empty($data['username'])?"":$data['username'];
		$invite_username = empty($data['invite_username'])?"":$data['invite_username'];
	
		$page = empty($data['page'])?1:$data['page'];
		$epage = empty($data['epage'])?10:$data['epage'];
	
		$_sql = "where 1=1 ";

		if (!empty($username)){
			$_sql .= " and p2.username = '{$username}'";
		}
		if (!empty($invite_username)){
			$_sql .= " and p3.username = '{$invite_username}'";
		}
	
		if (isset($data['dotime1']) && $data['dotime1']!=""){
			$_sql .= " and p1.addtime >= '".strtotime($data['dotime1'])."'";
		}
		if (isset($data['dotime2']) && $data['dotime2']!=""){
			$_sql .= " and p1.addtime <= '".strtotime($data['dotime2'])."'";
		}
		if (isset($data['type']) && $data['type']!=""){
			$_sql .= " and p1.type = '".$data['type']."'";
		}
	
		//liukun add for subsite_id search begin
		if (isset($data['areaid']) && $data['areaid']!="0"){
			$_sql .= " and p2.areaid = {$data['areaid']} ";
		}
		//liukun add for subsite_id search end

		
// 		$_select = "select p1.*, ur.username, ur.invite_userid, iur.username as invite_username from {account_log} p1, {user} p2, {user} p3
// 		where p1.user_id = p2.user_id and p2.invite_userid = p3.user_id and p1.type in ('ticheng', 'vouch_ticheng', 'vouch_amount_ticheng')
// 		$_sql ORDER LIMIT";
		
		$_select = " p1.*, p2.username, p2.realname, p2.invite_userid, p3.username as invite_username ";
		$sql = "select SELECT from {ticheng_log} p1, {user} p2, {user} p3
		$_sql and p1.user_id = p2.user_id and p2.invite_userid = p3.user_id 
		 ORDER LIMIT";
			
		//�Ƿ���ʾȫ������Ϣ
		if (isset($data['limit']) ){
		$_limit = "";
		if ($data['limit'] != "all"){
		$_limit = "  limit ".$data['limit'];
		}
		$result= $mysql->db_fetch_arrays(str_replace(array('SELECT', 'ORDER', 'LIMIT'), array($_select,  'order by p1.addtime desc', $_limit), $sql));
				return $result;
		}
		$row = $mysql->db_fetch_array(str_replace(array('SELECT', 'ORDER', 'LIMIT'), array('count(1) as num', '', ''), $sql));
	
		$total = $row['num'];
		$total_page = ceil($total / $epage);
		$index = $epage * ($page - 1);
		$limit = " limit {$index}, {$epage}";
	
		$list = $mysql->db_fetch_arrays(str_replace(array('SELECT', 'ORDER', 'LIMIT'), array($_select, 'order by p1.addtime desc,id desc', $limit), $sql));
				$list = $list?$list:array();
				return array(
				'list' => $list,
				'total' => $total,
				'page' => $page,
				'epage' => $epage,
				'account' => $row['num'],
				'total_page' => $total_page
				);
	
	}
}
?>