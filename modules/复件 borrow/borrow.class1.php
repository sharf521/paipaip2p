<?
/******************************
 * $File: borrow.class.php
* $Description: 数据库处理文件
* $Author: ahui
* $Time:2010-03-09
* $Update:None
* $UpdateDate:None
******************************/
include_once(ROOT_PATH."modules/account/account.class.php");
include_once("amount.class.php");
include_once(ROOT_PATH."modules/credit/credit.class.php");
require_once("modules/remind/remind.class.php");

require_once(ROOT_PATH."modules/borrow/biao/zhouzhuanbiao.class.php");
require_once(ROOT_PATH."modules/borrow/biao/creditbiao.class.php");
require_once(ROOT_PATH."modules/borrow/biao/jinbiao.class.php");
require_once(ROOT_PATH."modules/borrow/biao/fastbiao.class.php");
require_once(ROOT_PATH."modules/borrow/biao/miaobiao.class.php");
require_once(ROOT_PATH."modules/borrow/biao/vouchbiao.class.php");
require_once(ROOT_PATH."modules/borrow/biao/restructuringbiao.class.php");
require_once(ROOT_PATH."modules/borrow/biao/circulationbiao.class.php");
require_once(ROOT_PATH."modules/borrow/biao/pledgebiao.class.php");
require_once(ROOT_PATH."modules/borrow/biao/lovebiao.class.php");

include_once(ROOT_PATH."core/webservice.php");
include_once("modules/account/wsaccount.class.php");

//liukun add for bug 52 begin
$firePHPEnable=TRUE;
if ($firePHPEnable){
	require_once('modules/FirePHPCore/FirePHP.class.php');
	require_once('modules/FirePHPCore/fb.php');
	ob_start();

	$firephp = FirePHP::getInstance(true);
}
//liukun add for bug 52 end

function isTimePattern($str){
	if(preg_match('/^\d{4}-\d{2}-\d{2}$/', $str, $match) == 0 ){
		return false;
	}else{
		return true;
	}
}
class borrowClass extends amountClass{

	const ERROR = '操作有误，请不要乱操作';
	const BORROW_NAME_NO_EMPTY = '借款的标题不能为空';
	const BORROW_ACCOUNT_NO_EMPTY = '借款金额不能为空';
	const BORROW_APR_NO_EMPTY = '借款利率不能为空';
	const BORROW_ACCOUNT_NO_MAX = '借款不能高于最高额度';
	const BORROW_ACCOUNT_NO_MIN = '借款不能低于最低限额';
	const BORROW_APR_NO_MAX = '借款利率不能高于最高限额';
	const BORROW_APR_NO_MIN = '借款利率不能低于最低限额';
	const BORROW_REPAYMENT_NOT_ENOUGH = '帐户可用余额少于要还款的金额';
	const BORROW_ACCOUNT_MAZ_ACC = '借款额度不能大于最大额度';
	const NO_LOGIN = '还没有登录';
	/**
	 * 列表
	 *
	 * @return Array
	 */
	function GetListIndex($data = array()){
		global $mysql;
		$user_id = empty($data['user_id'])?"":intval($data['user_id']);
		$username = empty($data['username'])?"":$data['username'];

		$page = empty($data['page'])?1:intval($data['page']);
		$epage = empty($data['epage'])?10:intval($data['epage']);

		$_sql = "where 1=1 ";
		if (isset($data['user_id'])  && $data['user_id']!=""){
			$_sql .= " and p2.user_id = {$data['user_id']}";
		}
		if (isset($data['username'])  && $data['username']!=""){
			$_sql .= " and p2.username = '{$data['username']}'";
		}


		if (isset($data['type'])){
			$type = $data['type'];
			if ($type==""){
				$_sql .= "  and p1.status=1 and (p1.verify_time+p1.valid_time*24*60*60)>".time();
			}elseif ($type=="tendering"){
				$_sql .= "  and p1.status=1 and (p1.verify_time+p1.valid_time*24*60*60)>".time();
			}elseif ($type=="all"){
				$_sql .= "  and p1.status=1 ";
			}elseif ($type=="allIndex"){
				$_sql .= "  and (p1.status=1 or p1.status=3 )";
			}elseif ($type=="review"){
				$_sql .= " and p1.account=p1.account_yes ";
			}elseif ($type=="reviews"){
				$_sql .= " and p1.account=p1.account_yes ";
				$_sql .= " and p1.status=1";
			}elseif ($type=="success"){
				$_sql .= " and p1.status=3";
			}elseif ($type=="vouch"){
				$_sql .= " and p1.is_vouch=1 and p1.status=1";
			}elseif ($type=="now"){//正在还
				$_sql .= " and p1.repayment_account!=p1.repayment_yesaccount";
			}elseif ($type=="yes"){//已还
				$_sql .= " and p1.repayment_account=p1.repayment_yesaccount";
			}elseif ($type=="late"){//过期
				$_sql .= " and p1.verify_time+p1.valid_time*24*60*60<".time();
			}elseif ($type=="fast"){
				$_sql .= " and p1.is_fast=1 and (p1.status=1 or p1.status=3 ) and  (isnull(p1.isday) or p1.isday != 1)";
			}elseif ($type=="jin"){
				$_sql .= " and p1.is_jin=1 and (p1.status=1 or p1.status=3 )";
			}elseif ($type=="xin"){
				$_sql .= " and p1.is_jin !=1 and p1.is_fast !=1 and p1.is_vouch !=1 and p1.is_mb !=1   and (p1.status=1 or p1.status=3 )";
			}elseif ($type=="mb"){
				$_sql .= " and p1.is_mb =1   and p1.status=1 and isnull(p1.pwd)";
			}

		}


		if (isset($data['recMonth'])  && $data['recMonth']=="1"){
			$curDate = time();
			$curDateStart = $curDate-24*60*60*30;
			$_sql .= " and p1.addtime <= ".$curDate." and p1.addtime >=".$curDateStart;

		}else{
			if (isset($data['dotime2'])  && $data['dotime2']!=""){
				$dotime2 = ($data['dotime2']=="request")?$_REQUEST['dotime2']:$data['dotime2'];
				if( !isTimePattern($dotime2))$dotime2 = "";
				if ($dotime2!=""){
					$_sql .= " and p1.addtime < ".get_mktime($dotime2);
				}
			}
			if (isset($data['dotime1']) && $data['dotime1']!=""){
				$dotime1 = ($data['dotime1']=="request")?$_REQUEST['dotime1']:$data['dotime1'];
				if( !isTimePattern($dotime1))$dotime1 = "";
				if ($dotime1!=""){
					$_sql .= " and p1.addtime > ".get_mktime($dotime1);
				}
			}
		}
		if (isset($data['status']) && $data['status']!=""){
			$_sql .= " and p1.status in ({$data['status']})";
		}

		//add by jackfeng 2012-08-12
		if (isset($data['biaoType']) && $data['biaoType']!=""){
			if($data['biaoType'] == 1){
				$_sql .= " and p1.is_fast = 1";
			}
			if($data['biaoType'] == 2){
				$_sql .= " and p1.is_jin = 1";
			}
			if($data['biaoType'] == 3){
				$_sql .= " and p1.is_mb = 1";
			}
		}
		//end add

		//liukun add for biao_type search begin
		if (isset($data['biao_type']) && $data['biao_type']!=""){
			$_sql .= " and p1.biao_type = '{$data['biao_type']}' ";
		}
		//liukun add for biao_type search begin

		//liukun add for ontop search begin
		// 		if (isset($data['ontop']) && $data['ontop']!=""){
		// 			$_sql .= " and p1.isontop in ({$data['ontop']}) ";
		// 		}
		//liukun add for ontop search end

		//liukun add for site_id search begin
		// 		if (isset($data['areaid']) && $data['areaid']!="0"){
		// 			$_sql .= " and p1.areaid = {$data['areaid']} ";
		// 		}
		//liukun add for biao_type search begin



		if (isset($data['is_vouch']) && $data['is_vouch']!=""){
			$_sql .= " and p1.is_vouch in ({$data['is_vouch']})";
		}

		if (isset($data['limittime']) && $data['limittime']!=""){
			$data['limittime'] = intval($data['limittime']);// Add by Liuyaoyao 2012-04-24
			$_sql .= " and p1.time_limit = {$data['limittime']}";
		}

		if (isset($data['use']) && $data['use']!=""){
			$data['use'] = intval($data['use']);// Add by Liuyaoyao 2012-04-24
			$_sql .= " and p1.use in ({$data['use']})";
		}
		if (isset($data['award']) && $data['award']!=""){
			$data['award'] = intval($data['award']);// Add by Liuyaoyao 2012-04-24
			if($data['award']==1){
				$_sql .= " and p1.award >0";
			}else{
				$_sql .= " and p1.award = 0";
			}
		}

		if (isset($data['style']) && $data['style']!=""){
			$data['style'] = intval($data['style']);// Add by Liuyaoyao 2012-04-24
			$_sql .= " and p1.style in ({$data['style']})";
		}

		//add by weego for 我要投资搜索关键词 20120527
		$data['keywords']=urldecode($data['keywords']);
		$data['keywords']=safegl($data['keywords']);
			

		if (isset($data['keywords']) && $data['keywords']!=""){
			$_sql .= " and (p1.name like '%".$data['keywords']."%' or u.username like '%".$data['keywords']."%')";

		}

		/*
		 if (isset($data['province']) && $data['province']!=""){
		$data['province'] = intval($data['province']);// Add by Liuyaoyao 2012-04-24
		$_sql .= " and p2.province ={$data['province']}";
		}

		if (isset($data['city']) && $data['city']!=""){
		$data['city'] = intval($data['city']);// Add by Liuyaoyao 2012-04-24
		$_sql .= " and p2.city ={$data['city']}";
		}
		*/


		if (isset($data['use']) && $data['use']!=""){
			$data['use'] = intval($data['use']);// Add by Liuyaoyao 2012-04-24
			$_sql .= " and p1.use in ({$data['use']})";
		}

		if (isset($data['account1']) && $data['account1']!=""){
			$data['account1'] = intval($data['account1']);// Add by Liuyaoyao 2012-04-24
			$_sql .= " and p1.account >= {$data['account1']}";
		}

		if (isset($data['account2']) && $data['account2']!=""){
			$data['account2'] = intval($data['account2']);// Add by Liuyaoyao 2012-04-24
			$_sql .= " and p1.account <= {$data['account2']}";
		}
		$_order = " order by biaoindex asc, p1.`order` desc,p1.id desc ";


		if (isset($data['order']) && $data['order']!=""){
			$order = $data['order'];
			if ($order == "account_up"){
				$_order = " order by p1.`account`+0 desc ";
			}else if ($order == "account_down"){
				$_order = " order by p1.`account`+0 asc";
			}
			if ($order == "credit_up"){
				$_order = " order by p3.`value` desc,p1.id desc ";
			}else if ($order == "credit_down"){
				$_order = " order by p3.`value` asc,p1.id desc ";
			}

			if ($order == "apr_up"){
				$_order = " order by p1.`apr` desc,p1.id desc ";
			}else if ($order == "apr_down"){
				$_order = " order by p1.`apr` asc,p1.id desc ";
			}

			if ($order == "jindu_up"){
				$_order = " order by `scales` desc,p1.id desc ";

			}else if ($order == "jindu_down"){
				$_order = " order by `scales` asc,p1.id desc ";
			}
			if ($order == "flag"){
				$_order = " order by p1.is_vouch desc,p1.`flag` desc,p1.id desc ";
			}
			if ($order == "index"){
				$_order = " order by p1.status asc, p1.id desc ";
			}
				

		}


		$_select = " p1.*,p7.show_name as biao_type_name, p7.type_desc as biao_type_desc, p8.valid_unit_num, p8.unit_price, p8.total_unit_num, p6.isqiye,p6.id as fastid,p2.username,p2.area as user_area ,u.username as kefu_username,
		p2.qq,p3.value as credit_jifen,p4.pic as credit_pic,p5.area as add_area,p1.account_yes/p1.account as scales,
		case
		when p1.isontop = 2 and p1.areaid = {$data['areaid']} then 1
		when p1.areaid =  {$data['areaid']}  then 2
		when p1.areaid != {$data['areaid']}  and p2.city =  {$data['city']}  then 3
		else 4 end as biaoindex
		";
		$sql = "select SELECT from  {borrow}  as p1
		left join  {user}  as p2 on p1.user_id=p2.user_id
		left join  {user_cache}  as uca on uca.user_id=p1.user_id
		left join  {user}  as u on u.user_id=uca.kefu_userid
		left join  {credit}  as p3 on p1.user_id=p3.user_id
		left join  {credit_rank}  as p4 on p3.value<=p4.point2  and p3.value>=p4.point1
		left join  {userinfo}  as p5 on p1.user_id=p5.user_id
		left join  {daizi}  as p6 on p1.id=p6.borrow_id
		left join  {biao_type}  as p7 on p1.biao_type=p7.biao_type_name
		left join  {circulation}  as p8 on p1.id = p8.borrow_id
		$_sql ORDER LIMIT";
		//是否显示全部的信息
		if (isset($data['limit']) ){
			$_limit = "";
			if ($data['limit'] != "all"){
				$_limit = "  limit ".$data['limit'];
			}

			$list =  $mysql->db_fetch_arrays(str_replace(array('SELECT', 'ORDER', 'LIMIT'), array($_select, $_order, $_limit), $sql));

			foreach($list as $key => $value){
				$list[$key]['account_format'] =number_format($value['account']); //add by weego for format account 20120418
				//获取进度
				//$list[$key]['scale'] = round(100*$value['account_yes']/$value['account'],1);

				$scaleValue=100*($value['account_yes']/$value['account']);
				if($scaleValue>99.95 && $scaleValue<99.99999999){
					$list[$key]['scale']=99.9;
				}else{
					$list[$key]['scale'] = round(100*$value['account_yes']/$value['account'],1);
				}
				if($list[$key]['biao_type'] == 'circulation'){
					$list[$key]['scale'] = round(100 -  $list[$key]['valid_unit_num'] / $list[$key]['total_unit_num'] * 100, 2);
				}

				$list[$key]['other'] = $value['account'] - $value['account_yes'];
				$list[$key]['scale_width'] = round((20*$value['account_yes']/$value['account']))*7;
				$list[$key]['repayment_noaccount'] = $value['repayment_account'] - $value['repayment_yesaccount'];
				//获取担保进度

				//$list[$key]['lave_time'] = $value['verify_time'] + $value['valid_time']*24*60*60-time();
				$lave_time_t = $value['verify_time'] + $value['valid_time']*24*60*60-time();
				if($lave_time_t >0){
					$iDay = intval($lave_time_t/24/3600);
					$iHour = intval(($lave_time_t/3600)%24);
					$iMinute = intval(($lave_time_t/60)%60);
					if($iDay!=0) $list[$key]['lave_time'] = $iDay."天";
					if($iHour!=0) $list[$key]['lave_time'] = $list[$key]['lave_time'].$iHour."小时";
					if($iMinute!=0) $list[$key]['lave_time'] = $list[$key]['lave_time'].$iMinute."分";

				}else{
					$list[$key]['lave_time'] = "已结束";
					//$list[$key]['lave_time'] = "<img src='/themes/ruizhict/images/exh_p3.gif'>";
				}


				$list[$key]['vouch_scale'] = round(100*$value['vouch_account']/$value['account'],1);
				$list[$key]['vouch_other'] = $value['account'] - $value['vouch_account'];
				$list[$key]['vouchscale_width'] = round((20*$value['vouch_account']/$value['account']))*7;
				foreach ($value as $_key => $_value){
					$list[$key][$_key] = $_value;
				}

			}
			return $list;
		}

		if ($type=="success"){
			$row = $mysql->db_fetch_array(str_replace(array('SELECT', 'ORDER', 'LIMIT'), array('count(1) as num', '', ' limit 100'), $sql));
		}else{
			$row = $mysql->db_fetch_array(str_replace(array('SELECT', 'ORDER', 'LIMIT'), array('count(1) as num', '', ''), $sql));
		}

		$total = $row['num'];
		if ($type=="success"){
			$total = 100;
		}
		$total_page = ceil($total / $epage);
		$index = $epage * ($page - 1);
		$limit = " limit {$index}, {$epage}";
			

		$_list = $mysql->db_fetch_arrays(str_replace(array('SELECT', 'ORDER', 'LIMIT'), array($_select, $_order, $limit), $sql));
		$_list = $_list?$_list:array();
		$result = array();
		$list = array();

		foreach($_list as $key => $value){
			$list[$key]['account_format'] =number_format($value['account']); //add by weego for format account 20120418
			//获取进度
			//$list[$key]['scale'] = round(100*$value['account_yes']/$value['account'],1);

			$scaleValue=100*($value['account_yes']/$value['account']);
			if($scaleValue>99.95 && $scaleValue<99.99999999){
				$list[$key]['scale']=99.9;
			}else{
				$list[$key]['scale'] = round(100*$value['account_yes']/$value['account'],1);
			}
			if($value['biao_type'] == 'circulation'){
				$list[$key]['scale'] = round(100 -  $value['valid_unit_num'] / $value['total_unit_num'] * 100, 2);
			}
			$list[$key]['other'] = $value['account'] - $value['account_yes'];
			$list[$key]['scale_width'] = round((20*$value['account_yes']/$value['account']))*7;
			$list[$key]['repayment_noaccount'] = $value['repayment_account'] - $value['repayment_yesaccount'];
			//获取担保进度

			//$list[$key]['lave_time'] = $value['verify_time'] + $value['valid_time']*24*60*60-time();
			$lave_time_t = $value['verify_time'] + $value['valid_time']*24*60*60-time();
			if($lave_time_t >0){
				$iDay = intval($lave_time_t/24/3600);
				$iHour = intval(($lave_time_t/3600)%24);
				$iMinute = intval(($lave_time_t/60)%60);
				if($iDay!=0) $list[$key]['lave_time'] = $iDay."天";
				if($iHour!=0) $list[$key]['lave_time'] = $list[$key]['lave_time'].$iHour."小时";
				if($iMinute!=0) $list[$key]['lave_time'] = $list[$key]['lave_time'].$iMinute."分";

			}else{
				$list[$key]['lave_time'] = "已结束";
				//$list[$key]['lave_time'] = "<img src='/themes/ruizhict/images/exh_p3.gif'>";
			}


			$list[$key]['vouch_scale'] = round(100*$value['vouch_account']/$value['account'],1);
			$list[$key]['vouch_other'] = $value['account'] - $value['vouch_account'];
			$list[$key]['vouchscale_width'] = round((20*$value['vouch_account']/$value['account']))*7;
			foreach ($value as $_key => $_value){
				$list[$key][$_key] = $_value;
			}

		}

		return array(
				'list' => $list,
				'total' => $total,
				'page' => $page,
				'epage' => $epage,
				'total_page' => $total_page
		);

	}

	/**
	 * 列表
	 *
	 * @return Array
	 */
	function GetList($data = array()){
		global $mysql;
		$user_id = empty($data['user_id'])?"":intval($data['user_id']);
		$username = empty($data['username'])?"":$data['username'];

		$page = empty($data['page'])?1:intval($data['page']);
		$epage = empty($data['epage'])?10:intval($data['epage']);

		$_sql = "where 1=1 ";
		if (isset($data['user_id'])  && $data['user_id']!=""){
			$_sql .= " and p2.user_id = {$data['user_id']}";
		}
		if (isset($data['username'])  && $data['username']!=""){
			$_sql .= " and p2.username = '{$data['username']}'";
		}


		if (isset($data['type'])){
			$type = $data['type'];
			if ($type==""){
				$_sql .= "  and p1.status=1 and (p1.verify_time+p1.valid_time*24*60*60)>".time();
			}elseif ($type=="tendering"){
				$_sql .= "  and p1.status=1 and (p1.verify_time+p1.valid_time*24*60*60)>".time();
			}elseif ($type=="all"){
				$_sql .= "  and p1.status=1 ";
			}elseif ($type=="allIndex"){
				$_sql .= "  and (p1.status=1 or p1.status=3 )";
			}elseif ($type=="review"){
				//liukun add for bug 担保的时候，要判断担保也满了
				$_sql .= " and p1.account=p1.account_yes and (p1.is_vouch=0 or (p1.is_vouch=1 and p1.account=p1.vouch_account))";
			}elseif ($type=="reviews"){
				$_sql .= " and p1.account=p1.account_yes ";
				$_sql .= " and p1.status=1";
			}elseif ($type=="success"){
				$_sql .= " and p1.status=3";
			}elseif ($type=="vouch"){
				$_sql .= " and p1.is_vouch=1 and p1.status=1";
			}elseif ($type=="now"){//正在还
				$_sql .= " and p1.repayment_account!=p1.repayment_yesaccount";
			}elseif ($type=="yes"){//已还
				$_sql .= " and p1.repayment_account=p1.repayment_yesaccount";
			}elseif ($type=="late"){//过期
				$_sql .= " and p1.verify_time+p1.valid_time*24*60*60<".time();
			}elseif ($type=="fast"){
				$_sql .= " and p1.is_fast=1 and (p1.status=1 or p1.status=3 ) and  (isnull(p1.isday) or p1.isday != 1)";
			}elseif ($type=="jin"){
				$_sql .= " and p1.is_jin=1 and (p1.status=1 or p1.status=3 )";
			}elseif ($type=="xin"){
				$_sql .= " and p1.is_jin !=1 and p1.is_fast !=1 and p1.is_vouch !=1 and p1.is_mb !=1   and (p1.status=1 or p1.status=3 )";
			}elseif ($type=="mb"){
				$_sql .= " and p1.is_mb =1   and p1.status=1 and isnull(p1.pwd)";
			}

		}


		if (isset($data['recMonth'])  && $data['recMonth']=="1"){
			$curDate = time();
			$curDateStart = $curDate-24*60*60*30;
			$_sql .= " and p1.addtime <= ".$curDate." and p1.addtime >=".$curDateStart;

		}else{
			if (isset($data['dotime2'])  && $data['dotime2']!=""){
				$dotime2 = ($data['dotime2']=="request")?$_REQUEST['dotime2']:$data['dotime2'];
				if( !isTimePattern($dotime2))$dotime2 = "";
				if ($dotime2!=""){
					$_sql .= " and p1.addtime < ".get_mktime($dotime2);
				}
			}
			if (isset($data['dotime1']) && $data['dotime1']!=""){
				$dotime1 = ($data['dotime1']=="request")?$_REQUEST['dotime1']:$data['dotime1'];
				if( !isTimePattern($dotime1))$dotime1 = "";
				if ($dotime1!=""){
					$_sql .= " and p1.addtime > ".get_mktime($dotime1);
				}
			}
		}
		if (isset($data['status']) && $data['status']!=""){
			$_sql .= " and p1.status in ({$data['status']})";
		}

		//add by jackfeng 2012-08-12
		if (isset($data['biaoType']) && $data['biaoType']!=""){
			if($data['biaoType'] == 1){
				$_sql .= " and p1.is_fast = 1";
			}
			if($data['biaoType'] == 2){
				$_sql .= " and p1.is_jin = 1";
			}
			if($data['biaoType'] == 3){
				$_sql .= " and p1.is_mb = 1";
			}
		}
		//end add

		//liukun add for biao_type search begin
		if (isset($data['biao_type']) && $data['biao_type']!=""){
			$_sql .= " and p1.biao_type = '{$data['biao_type']}' ";
		}
		//liukun add for biao_type search begin

		//liukun add for ontop search begin
		if (isset($data['ontop']) && $data['ontop']!=""){
			$_sql .= " and p1.isontop in ({$data['ontop']}) ";
		}
		//liukun add for ontop search end

		//liukun add for site_id search begin
		if (isset($data['areaid']) && $data['areaid']!="0"){
			$_sql .= " and p1.areaid = {$data['areaid']} ";
		}
		//liukun add for biao_type search begin



		if (isset($data['is_vouch']) && $data['is_vouch']!=""){
			$_sql .= " and p1.is_vouch in ({$data['is_vouch']})";
		}

		if (isset($data['limittime']) && $data['limittime']!=""){
			$data['limittime'] = intval($data['limittime']);// Add by Liuyaoyao 2012-04-24
			$_sql .= " and p1.time_limit = {$data['limittime']}";
		}

		if (isset($data['use']) && $data['use']!=""){
			$data['use'] = intval($data['use']);// Add by Liuyaoyao 2012-04-24
			$_sql .= " and p1.use in ({$data['use']})";
		}
		if (isset($data['award']) && $data['award']!=""){
			$data['award'] = intval($data['award']);// Add by Liuyaoyao 2012-04-24
			if($data['award']==1){
				$_sql .= " and p1.award >0";
			}else{
				$_sql .= " and p1.award = 0";
			}
		}

		if (isset($data['style']) && $data['style']!=""){
			$data['style'] = intval($data['style']);// Add by Liuyaoyao 2012-04-24
			$_sql .= " and p1.style in ({$data['style']})";
		}

		//add by weego for 我要投资搜索关键词 20120527
		$data['keywords']=urldecode($data['keywords']);
		$data['keywords']=safegl($data['keywords']);
			

		if (isset($data['keywords']) && $data['keywords']!=""){
			$_sql .= " and (p1.name like '%".$data['keywords']."%' or u.username like '%".$data['keywords']."%')";

		}

		if (isset($data['province']) && $data['province']!=""){
			$data['province'] = intval($data['province']);// Add by Liuyaoyao 2012-04-24
			$_sql .= " and p2.province ={$data['province']}";
		}

		if (isset($data['city']) && $data['city']!=""){
			$data['city'] = intval($data['city']);// Add by Liuyaoyao 2012-04-24
			$_sql .= " and p2.city ={$data['city']}";
		}



		if (isset($data['use']) && $data['use']!=""){
			$data['use'] = intval($data['use']);// Add by Liuyaoyao 2012-04-24
			$_sql .= " and p1.use in ({$data['use']})";
		}

		if (isset($data['account1']) && $data['account1']!=""){
			$data['account1'] = intval($data['account1']);// Add by Liuyaoyao 2012-04-24
			$_sql .= " and p1.account >= {$data['account1']}";
		}

		if (isset($data['account2']) && $data['account2']!=""){
			$data['account2'] = intval($data['account2']);// Add by Liuyaoyao 2012-04-24
			$_sql .= " and p1.account <= {$data['account2']}";
		}
		$_order = " order by p1.`order` desc,p1.id desc ";


		if (isset($data['order']) && $data['order']!=""){
			$order = $data['order'];
			if ($order == "account_up"){
				$_order = " order by p1.`account`+0 desc ";
			}else if ($order == "account_down"){
				$_order = " order by p1.`account`+0 asc";
			}
			if ($order == "credit_up"){
				$_order = " order by p3.`value` desc,p1.id desc ";
			}else if ($order == "credit_down"){
				$_order = " order by p3.`value` asc,p1.id desc ";
			}

			if ($order == "apr_up"){
				$_order = " order by p1.`apr` desc,p1.id desc ";
			}else if ($order == "apr_down"){
				$_order = " order by p1.`apr` asc,p1.id desc ";
			}

			if ($order == "jindu_up"){
				$_order = " order by `scales` desc,p1.id desc ";

			}else if ($order == "jindu_down"){
				$_order = " order by `scales` asc,p1.id desc ";
			}
			if ($order == "flag"){
				$_order = " order by p1.is_vouch desc,p1.`flag` desc,p1.id desc ";
			}
			if ($order == "index"){
				$_order = " order by p1.status asc, p1.id desc ";
			}

		}


		$_select = " p1.*,p7.show_name as biao_type_name, p8.valid_unit_num, p8.unit_price, p8.total_unit_num, p6.isqiye,p6.id as fastid,
		p2.username,p2.area as user_area ,u.username as kefu_username,p2.qq,p3.value as credit_jifen,p4.pic as credit_pic,
		p5.area as add_area,p1.account_yes/p1.account as scales ";
		$sql = "select SELECT from  {borrow}  as p1
		left join  {user}  as p2 on p1.user_id=p2.user_id
		left join  {user_cache}  as uca on uca.user_id=p1.user_id
		left join  {user}  as u on u.user_id=uca.kefu_userid
		left join  {credit}  as p3 on p1.user_id=p3.user_id
		left join  {credit_rank}  as p4 on p3.value<=p4.point2  and p3.value>=p4.point1
		left join  {userinfo}  as p5 on p1.user_id=p5.user_id
		left join  {daizi}  as p6 on p1.id=p6.borrow_id
		left join  {biao_type}  as p7 on p1.biao_type=p7.biao_type_name
		left join  {circulation}  as p8 on p1.id = p8.borrow_id
		$_sql ORDER LIMIT";
		//是否显示全部的信息
		if (isset($data['limit']) ){
			$_limit = "";
			if ($data['limit'] != "all"){
				$_limit = "  limit ".$data['limit'];
			}

			$list =  $mysql->db_fetch_arrays(str_replace(array('SELECT', 'ORDER', 'LIMIT'), array($_select, $_order, $_limit), $sql));

			foreach($list as $key => $value){
				$list[$key]['account_format'] =number_format($value['account']); //add by weego for format account 20120418
				//获取进度
				//$list[$key]['scale'] = round(100*$value['account_yes']/$value['account'],1);

				$scaleValue=100*($value['account_yes']/$value['account']);
				if($scaleValue>99.95 && $scaleValue<99.99999999){
					$list[$key]['scale']=99.9;
				}else{
					$list[$key]['scale'] = round(100*$value['account_yes']/$value['account'],1);
				}
				if($list[$key]['biao_type'] == 'circulation'){
					$list[$key]['scale'] = round(100 -  $list[$key]['valid_unit_num'] / $list[$key]['total_unit_num'] * 100, 2);
				}

				$list[$key]['other'] = $value['account'] - $value['account_yes'];
				$list[$key]['scale_width'] = round((20*$value['account_yes']/$value['account']))*7;
				$list[$key]['repayment_noaccount'] = $value['repayment_account'] - $value['repayment_yesaccount'];
				//获取担保进度

				//$list[$key]['lave_time'] = $value['verify_time'] + $value['valid_time']*24*60*60-time();
				$lave_time_t = $value['verify_time'] + $value['valid_time']*24*60*60-time();
				if($lave_time_t >0){
					$iDay = intval($lave_time_t/24/3600);
					$iHour = intval(($lave_time_t/3600)%24);
					$iMinute = intval(($lave_time_t/60)%60);
					if($iDay!=0) $list[$key]['lave_time'] = $iDay."天";
					if($iHour!=0) $list[$key]['lave_time'] = $list[$key]['lave_time'].$iHour."小时";
					if($iMinute!=0) $list[$key]['lave_time'] = $list[$key]['lave_time'].$iMinute."分";

				}else{
					$list[$key]['lave_time'] = "已结束";
					//$list[$key]['lave_time'] = "<img src='/themes/ruizhict/images/exh_p3.gif'>";
				}


				$list[$key]['vouch_scale'] = round(100*$value['vouch_account']/$value['account'],1);
				$list[$key]['vouch_other'] = $value['account'] - $value['vouch_account'];
				$list[$key]['vouchscale_width'] = round((20*$value['vouch_account']/$value['account']))*7;
				foreach ($value as $_key => $_value){
					$list[$key][$_key] = $_value;
				}

			}
			return $list;
		}

		if ($type=="success"){
			$row = $mysql->db_fetch_array(str_replace(array('SELECT', 'ORDER', 'LIMIT'), array('count(1) as num', '', ' limit 100'), $sql));
		}else{
			$row = $mysql->db_fetch_array(str_replace(array('SELECT', 'ORDER', 'LIMIT'), array('count(1) as num', '', ''), $sql));
		}

		$total = $row['num'];
		if ($type=="success"){
			$total = 100;
		}
		$total_page = ceil($total / $epage);
		$index = $epage * ($page - 1);
		$limit = " limit {$index}, {$epage}";
			

		$_list = $mysql->db_fetch_arrays(str_replace(array('SELECT', 'ORDER', 'LIMIT'), array($_select, $_order, $limit), $sql));
		$_list = $_list?$_list:array();
		$result = array();
		$list = array();

		foreach($_list as $key => $value){
			$list[$key]['account_format'] =number_format($value['account']); //add by weego for format account 20120418
			//获取进度
			//$list[$key]['scale'] = round(100*$value['account_yes']/$value['account'],1);

			$scaleValue=100*($value['account_yes']/$value['account']);
			if($scaleValue>99.95 && $scaleValue<99.99999999){
				$list[$key]['scale']=99.9;
			}else{
				$list[$key]['scale'] = round(100*$value['account_yes']/$value['account'],1);
			}
			if($value['biao_type'] == 'circulation'){
				$list[$key]['scale'] = round(100 -  $value['valid_unit_num'] / $value['total_unit_num'] * 100, 2);
			}
			$list[$key]['other'] = $value['account'] - $value['account_yes'];
			$list[$key]['scale_width'] = round((20*$value['account_yes']/$value['account']))*7;
			$list[$key]['repayment_noaccount'] = $value['repayment_account'] - $value['repayment_yesaccount'];
			//获取担保进度

			//$list[$key]['lave_time'] = $value['verify_time'] + $value['valid_time']*24*60*60-time();
			$lave_time_t = $value['verify_time'] + $value['valid_time']*24*60*60-time();
			if($lave_time_t >0){
				$iDay = intval($lave_time_t/24/3600);
				$iHour = intval(($lave_time_t/3600)%24);
				$iMinute = intval(($lave_time_t/60)%60);
				if($iDay!=0) $list[$key]['lave_time'] = $iDay."天";
				if($iHour!=0) $list[$key]['lave_time'] = $list[$key]['lave_time'].$iHour."小时";
				if($iMinute!=0) $list[$key]['lave_time'] = $list[$key]['lave_time'].$iMinute."分";

			}else{
				$list[$key]['lave_time'] = "已结束";
				//$list[$key]['lave_time'] = "<img src='/themes/ruizhict/images/exh_p3.gif'>";
			}


			$list[$key]['vouch_scale'] = round(100*$value['vouch_account']/$value['account'],1);
			$list[$key]['vouch_other'] = $value['account'] - $value['vouch_account'];
			$list[$key]['vouchscale_width'] = round((20*$value['vouch_account']/$value['account']))*7;
			foreach ($value as $_key => $_value){
				$list[$key][$_key] = $_value;
			}

		}

		return array(
				'list' => $list,
				'total' => $total,
				'page' => $page,
				'epage' => $epage,
				'total_page' => $total_page
		);

	}

	function Getkf(){
		global $_G,$mysql;
		if($_G['user_id']==0){
			$kfUserId=0;
		}else{
			$kfUserId=$_G['user_id'];
		}
		$sql="select * from  {user}  as u left join  {user_cache}  as uca on uca.kefu_userid=u.user_id where uca.user_id=".$kfUserId;
		$row = $mysql->db_fetch_array($sql);
		return $row;
	}
	/**
	 * 查看
	 *
	 * @param Array $data
	 * @return Array
	 */
	public static function GetOne($data = array()){
		global $mysql;
		$_sql = "where 1=1 ";
		if (isset($data['user_id']) && $data['user_id']!=""){
			$_sql .= " and  p1.user_id = '{$data['user_id']}' ";
		}
		if (isset($data['id']) && $data['id']!=""){
			$_sql .= " and  p1.id = '{$data['id']}' ";
		}
		$sql = "select p1.* ,p2.username,p2.realname,p3.username as verify_username from  {borrow}  as p1
		left join  {user}  as p2 on p1.user_id=p2.user_id
		left join  {user}  as p3 on p1.verify_user = p3.user_id
		$_sql
		";
		$result = $mysql->db_fetch_array($sql);

		if (isset($data['tender_userid']) && $data['tender_userid']!=""){
			$sql = "select sum(account) as num from  {borrow_tender}  where user_id='{$data['tender_userid']}' and borrow_id={$data['id']}";
			$_result = $mysql->db_fetch_array($sql);
			$result['tender_yes'] = !empty($_result['num'])?$_result['num']:0;
		}
		return $result;
	}

	public static function CheckBorrowTender($data = array()){
		global $mysql;
		$_sql = "where 1=1 ";
		if (isset($data['user_id']) && $data['user_id']!=""){
			$_sql .= " and  p1.user_id = '{$data['user_id']}' ";
		}
		if (isset($data['id']) && $data['id']!=""){
			$_sql .= " and  p1.borrow_id = '{$data['id']}' ";
		}
		$sql = "select count(*) as checkStatus from  {borrow_tender}  as p1  $_sql ";
			
		$result = $mysql->db_fetch_array($sql);

		return $result;
	}

	public static function GetUserLog($data = array()){
		global $mysql;
		global $_G;
		include_once(ROOT_PATH."modules/account/account.inc.php");
		$jin_formula = isset($_G['system']['con_jin_formula'])?$_G['system']['con_jin_formula']:0;
		$jin_formula_vouch = isset($_G['system']['con_jin_formula_vouch'])?$_G['system']['con_jin_formula_vouch']:0;

		$_result = accountClass::GetUserLog($data);

		$user_id = $data['user_id'];
		$_result['borrow_account'] = 0;
		$sql = "select sum(account) as num from  {borrow}  where user_id = '{$user_id}' and (status=3)  ";
		$result = $mysql->db_fetch_array($sql);
		if ($result!=false){
			$_result['borrow_account'] = $result['num'];//借款总额
		}
			
		$_result['payment_times'] = 0;
		$sql = "select count(account) as num from  {borrow}  where user_id = '{$user_id}' and status=3  ";
		$result = $mysql->db_fetch_array($sql);
		if ($result!=false){
			$_result['payment_times'] = $result['num'];//借款总额
		}

		$sql = "select count(*) as num from  {borrow}  where user_id = '{$user_id}' ";
		$result = $mysql->db_fetch_array($sql);
		$_result['borrow_times'] =$result['num'];
		$_result['max_account'] =$_result['amount'] - $_result['borrow_account'];//最大额度

		//投资详情
		$sql = "select status,sum(account) as total_account  from  {borrow_tender}   where user_id = '{$user_id}' group by status ";
		$result = $mysql->db_fetch_arrays($sql);
		foreach ($result as  $key =>$value){
			$_result['invest_account'] += $value['total_account'];//投标总额
			if ($value['status']==1){
				//$_result['success_account'] = $value['total_account'];
			}
		}
			
		//利息
		$sql = "select p1.status ,sum(p1.repay_account) as total_repay_account ,sum(p1.interest) as total_interest_account,sum(p1.capital) as total_capital_account  from  {borrow_collection}  as p1 left join  {borrow_tender}  as p2  on p1.tender_id = p2.id  where p2.status=1  and  p2.user_id = '{$user_id}' and p2.borrow_id in (select id from  {borrow}  where status=3)  group by p1.status ";
		$result = $mysql->db_fetch_arrays($sql);
		foreach ($result as  $key =>$value){
			$_result['success_account'] += $value['total_capital_account'];//投标总额
			if ($value['status']==1){
				$_result['collection_account1'] += $value['total_repay_account'];
				$_result['collection_interest1'] += $value['total_interest_account'];
				$_result['collection_capital1'] += $value['total_capital_account'];
			}
			if ($value['status']==0){
				$_result['collection_account0'] += $value['total_repay_account'];
				$_result['collection_interest0'] += $value['total_interest_account'];
				$_result['collection_capital0'] += $value['total_capital_account'];
			}
			if ($value['status']==2){
				$_result['collection_account2'] += $value['total_repay_account'];
				$_result['collection_interest2'] += $value['total_interest_account'];
				$_result['collection_capital2'] += $value['total_capital_account'];
			}
		}
		$_result['collection_wait'] = 	$_result['collection_capital0'] + $_result['collection_interest0'];//待回收
		$_result['collection_yes'] = 	$_result['collection_capital1'] + $_result['collection_interest1']+$_result['collection_capital2'] + $_result['collection_interest2'];//已回收
		$_result['collection_capital1'] = $_result['collection_capital1']+$_result['collection_capital2'];
		//$_result['success_account'] = $_result['collection_capital0'] + $_result['collection_capital1'] + $_result['collection_capital2'];//借出总额
		//最近收款日期
		$sql = "select p1.repay_time  from  {borrow_collection}  as p1 left join  {borrow_tender}  as p2  on p1.tender_id = p2.id  where p2.status=1 and p1.status=0  and  p2.user_id = '{$user_id}' and p1.repay_time>".time()." order by p1.repay_time asc";
		$result = $mysql->db_fetch_array($sql);
		$_result['collection_repaytime'] = $result['repay_time'];

		//待还总额
		$_result_wait = self::GetWaitPayment(array("user_id"=>$user_id));
		$_result = array_merge ($_result, $_result_wait);


		//额度管理
		$_result_amount = amountClass::GetAmountOne($user_id);
		$_result = array_merge ($_result, $_result_amount);
			
		//可用担保额度应该是借要借入的担保标和已经成功借入的担保标

		//$sql = "select * from  {borrow_amountlog}  where user_id='{$user_id}' and type ='vouch' order by id desc";
		//$result = $mysql->db_fetch_array($sql);
		/*
		 $result = self::GetAmountLogOne(array("user_id"=>$user_id,"amount_type"=>"credit"));
		if ($result!=""){
		$_result['credit_amount_total'] = $result['account_total'];//可用额度
		$_result['credit_amount_use'] = $result['account_use'];//可用额度
		}

		$result = self::GetAmountLogOne(array("user_id"=>$user_id,"amount_type"=>"vouch"));
		if ($result!=""){
		$_result['vouch_amount_total'] = $result['account_total'];//可用投资担保额度
		$_result['vouch_amount_use'] = $result['account_use'];//可用投资担保额度
		}

		$result = self::GetAmountLogOne(array("user_id"=>$user_id,"amount_type"=>"borrowvouch"));
		if ($result!=""){
		$_result['borrowvouch_amount_total'] = $result['account_total'];//可用借款担保额度
		$_result['borrowvouch_amount_use'] = $result['account_use'];//可用借款担保额度
		}

		*/
			
		//最近还款时间和总额
		$sql = "select repayment_time,repayment_account from  {borrow_repayment}  where status !=1 and borrow_id in (select id from  {borrow}  where user_id = {$user_id} and status=3) order by repayment_time ";
		$result = $mysql->db_fetch_array($sql);
		$_result['new_repay_time'] = $result['repayment_time'];
		$_result['new_repay_account'] = $result['repayment_account'];
			
		//最近收款时间和时间
		$curDayTime = date("Y-m-d");
		$curDayTimeStr = strtotime($curDayTime);

		//liukun add for bug 52 begin
		fb($curDayTime, FirePHP::TRACE);
		fb($curDayTimeStr, FirePHP::TRACE);
		//liukun add for bug 52 end

		$sql = "select repay_time,repay_account  from  {borrow_collection}  where tender_id in ( select p2.id from  {borrow_tender}   as p2 left join  {borrow}  as p3 on p2.borrow_id=p3.id where p3.status=3 and p2.user_id = '{$user_id}' and p2.status=1) and repay_time > ".$curDayTimeStr." and status=0 order by repay_time asc";

		$result = $mysql->db_fetch_array($sql);
		$_result['new_collection_time'] = $result['repay_time'];
		$_result['new_collection_account'] = $result['repay_account'];

		//网站垫付总额
		//最近收款时间和时间
		$sql = "select sum(repay_account) as num_late_repay_account ,sum(interest) as num_late_interes from  {borrow_collection}  where tender_id in ( select id from  {borrow_tender}  where user_id = '{$user_id}' and status=1)  and status=2 order by repay_time asc";
		$result = $mysql->db_fetch_array($sql);
		$_result['num_late_repay_account'] = $result['num_late_repay_account'];
		$_result['num_late_interes'] = $result['num_late_interes'];

		//liukun add for bug 216 begin
		//根据债权表计算待收信息
		//待收总额 $total_collection += round (floor($_interest['repayment_account'] * $has_percent) / 100, 2);
		$sql = "select sum(round(floor(bt.repayment_account * br.has_percent) / 100, 2)) as r_collection_total, sum(round(round(bt.capital * br.has_percent) / 100, 2))  as r_collection_capital,
		sum(round(floor(bt.repayment_account * br.has_percent) / 100, 2) - round(round(bt.capital * br.has_percent) / 100, 2)) as  r_collection_interest
		from  {borrow_right}  br,   {borrow_repayment}  bt where br.creditor_id = {$user_id} and br.borrow_id = bt.borrow_id  and bt.status = 0 ";
		$result = $mysql->db_fetch_array($sql);

		$_result['r_collection_total'] = $result['r_collection_total'];
		$_result['r_collection_capital'] = $result['r_collection_capital'];
		$_result['r_collection_interest'] = $result['r_collection_interest'];

		//最近待收

		$sql = "select sum(round(floor(bt.repayment_account * br.has_percent) / 100, 2)) as r_collection_total_last, sum(round(round(bt.capital * br.has_percent) / 100, 2)) as r_collection_capital_last ,
		sum(round(floor(bt.repayment_account * br.has_percent) / 100, 2) - round(round(bt.capital * br.has_percent) / 100, 2)) as  r_collection_interest_last,
		bt.repayment_time
		from  {borrow_right}  br,   {borrow_repayment}  bt where br.creditor_id = {$user_id} and br.borrow_id = bt.borrow_id  and bt.status = 0
		group by bt.repayment_time order by bt.repayment_time asc limit 1";

		$result = $mysql->db_fetch_array($sql);

		$_result['r_collection_total_last'] = $result['r_collection_total_last'];
		$_result['r_collection_capital_last'] = $result['r_collection_capital_last'];
		$_result['r_collection_interest_last'] = $result['r_collection_interest_last'];
		$_result['r_collection_last_time'] = $result['repayment_time'];
		//liukun add for bug 216 end

		//统计流转标的待收信息
		//只需要统计现金购买的流转标即可
		$sql = "select sum(capital) circulation_capital_c, sum(interest) circulation_interest_c from  {circulation_buy_serial} 
		where buyer_id = {$user_id} and buyback = 0 and buy_type = 'account'";
		$result = $mysql->db_fetch_array($sql);
		$_result['circulation_capital_c'] = $result['circulation_capital_c'];
		$_result['circulation_interest_c'] = $result['circulation_interest_c'];

		//统计流转标的待还信息
		$sql = "select sum(cs.capital) circulation_capital_r, sum(cs.interest) circulation_interest_r from  {circulation_buy_serial}  cs,  {circulation}  cn,  {borrow}  bw
		where  cs.circulation_id = cn.id and cn.borrow_id = bw.id and cs.buyback = 0 and bw.user_id = {$user_id}";
		$result = $mysql->db_fetch_array($sql);
		$_result['circulation_capital_r'] = $result['circulation_capital_r'];
		$_result['circulation_interest_r'] = $result['circulation_interest_r'];

		//获取净值
		//没有启用任何净值公式，不能发标
		if ($jin_formula==0 && $jin_formula_vouch ==0){
			$jinAmount = 0;
		}

		//启用净值公式
		if ($jin_formula==1 && $jin_formula_vouch ==0){
			$jinAmount = accountClass::getJinAmount($data);
		}

		//启用担保模式净值公式
		if ($jin_formula==0 && $jin_formula_vouch ==1){
			$jinAmount = accountClass::getJinAmountVouch($data);
		}

		//启用两种净值公式，根据是否有担保额度选择净值计算公式
		if ($jin_formula==1 && $jin_formula_vouch ==1){
			$amount_result = amountClass::GetAmountOne($user_id, "tender_vouch");
			//有担保额度时使用担保模式净值公式
			if ($amount_result['account_all'] > 0){
				$jinAmount = accountClass::getJinAmountVouch($data);
			}
			else{
				$jinAmount = accountClass::getJinAmount($data);
			}
		}

		$_result['jinAmount'] = $jinAmount;

		//获取商城的用户信息
		// 		$sql = "select * from  {user}  where user_id = '{$user_id}'";
		// 		$result = $mysql->db_fetch_array($sql);
		// 		if ($result!=false){
		// 			$data['uc_user_id'] = $result['uc_user_id'];//借款总额
		// 		}

		// 		$mallinfo = accountClass::GetMallInfobyUc($data);

		// 		$_result['mallinfo'] = $mallinfo;

		//计算已赚利息
		//liukun add for bug 331 begin
		$sql = "select sum(bc.interest) ed_interest  from dw_borrow_collection bc, dw_borrow_right br
		where bc.borrow_right_id = br.id and br.creditor_id = {$user_id}
		and bc.status = 1";
		$result = $mysql->db_fetch_array($sql);
		if (!isset($result['ed_interest'])){
			$_result['ed_interest'] = 0;
		}else{
			$_result['ed_interest'] = $result['ed_interest'];
		}
		//liukun add for bug 331 end

		$stock_price = isset($_G['system']['con_stock_price'])?$_G['system']['con_stock_price']:"2.655";
		$_result['stock_value'] = round($_result['stock'] * $stock_price, 2);
		return $_result;

	}

	public static function GetUserAllAccountInfo($data = array()){
		global $mysql;
		global $_G;
		include_once(ROOT_PATH."modules/account/account.inc.php");
		$jin_formula = isset($_G['system']['con_jin_formula'])?$_G['system']['con_jin_formula']:0;
		$jin_formula_vouch = isset($_G['system']['con_jin_formula_vouch'])?$_G['system']['con_jin_formula_vouch']:0;

		$_result = accountClass::GetUserLog($data);

		$user_id = $data['user_id'];
		$_result['borrow_account'] = 0;
		$sql = "select sum(account) as num from  {borrow}  where user_id = '{$user_id}' and (status=3)  ";
		$result = $mysql->db_fetch_array($sql);
		if ($result!=false){
			$_result['borrow_account'] = $result['num'];//借款总额
		}
			
		$_result['payment_times'] = 0;
		$sql = "select count(account) as num from  {borrow}  where user_id = '{$user_id}' and status=3  ";
		$result = $mysql->db_fetch_array($sql);
		if ($result!=false){
			$_result['payment_times'] = $result['num'];//借款总额
		}

		$sql = "select count(*) as num from  {borrow}  where user_id = '{$user_id}' ";
		$result = $mysql->db_fetch_array($sql);
		$_result['borrow_times'] =$result['num'];
		$_result['max_account'] =$_result['amount'] - $_result['borrow_account'];//最大额度

		//投资详情
		$sql = "select status,sum(account) as total_account  from  {borrow_tender}   where user_id = '{$user_id}' group by status ";
		$result = $mysql->db_fetch_arrays($sql);
		foreach ($result as  $key =>$value){
			$_result['invest_account'] += $value['total_account'];//投标总额
			if ($value['status']==1){
				//$_result['success_account'] = $value['total_account'];
			}
		}
			
		//利息
		$sql = "select p1.status ,sum(p1.repay_account) as total_repay_account ,sum(p1.interest) as total_interest_account,sum(p1.capital) as total_capital_account  from  {borrow_collection}  as p1 left join  {borrow_tender}  as p2  on p1.tender_id = p2.id  where p2.status=1  and  p2.user_id = '{$user_id}' and p2.borrow_id in (select id from  {borrow}  where status=3)  group by p1.status ";
		$result = $mysql->db_fetch_arrays($sql);
		foreach ($result as  $key =>$value){
			$_result['success_account'] += $value['total_capital_account'];//投标总额
			if ($value['status']==1){
				$_result['collection_account1'] += $value['total_repay_account'];
				$_result['collection_interest1'] += $value['total_interest_account'];
				$_result['collection_capital1'] += $value['total_capital_account'];
			}
			if ($value['status']==0){
				$_result['collection_account0'] += $value['total_repay_account'];
				$_result['collection_interest0'] += $value['total_interest_account'];
				$_result['collection_capital0'] += $value['total_capital_account'];
			}
			if ($value['status']==2){
				$_result['collection_account2'] += $value['total_repay_account'];
				$_result['collection_interest2'] += $value['total_interest_account'];
				$_result['collection_capital2'] += $value['total_capital_account'];
			}
		}
		$_result['collection_wait'] = 	$_result['collection_capital0'] + $_result['collection_interest0'];//待回收
		$_result['collection_yes'] = 	$_result['collection_capital1'] + $_result['collection_interest1']+$_result['collection_capital2'] + $_result['collection_interest2'];//已回收
		$_result['collection_capital1'] = $_result['collection_capital1']+$_result['collection_capital2'];
		//$_result['success_account'] = $_result['collection_capital0'] + $_result['collection_capital1'] + $_result['collection_capital2'];//借出总额
		//最近收款日期
		$sql = "select p1.repay_time  from  {borrow_collection}  as p1 left join  {borrow_tender}  as p2  on p1.tender_id = p2.id  where p2.status=1 and p1.status=0  and  p2.user_id = '{$user_id}' and p1.repay_time>".time()." order by p1.repay_time asc";
		$result = $mysql->db_fetch_array($sql);
		$_result['collection_repaytime'] = $result['repay_time'];

		//待还总额
		$_result_wait = self::GetWaitPayment(array("user_id"=>$user_id));
		$_result = array_merge ($_result, $_result_wait);


		//额度管理
		$_result_amount = amountClass::GetAmountOne($user_id);
		$_result = array_merge ($_result, $_result_amount);
			
		//可用担保额度应该是借要借入的担保标和已经成功借入的担保标

		//$sql = "select * from  {borrow_amountlog}  where user_id='{$user_id}' and type ='vouch' order by id desc";
		//$result = $mysql->db_fetch_array($sql);
		/*
		 $result = self::GetAmountLogOne(array("user_id"=>$user_id,"amount_type"=>"credit"));
		if ($result!=""){
		$_result['credit_amount_total'] = $result['account_total'];//可用额度
		$_result['credit_amount_use'] = $result['account_use'];//可用额度
		}

		$result = self::GetAmountLogOne(array("user_id"=>$user_id,"amount_type"=>"vouch"));
		if ($result!=""){
		$_result['vouch_amount_total'] = $result['account_total'];//可用投资担保额度
		$_result['vouch_amount_use'] = $result['account_use'];//可用投资担保额度
		}

		$result = self::GetAmountLogOne(array("user_id"=>$user_id,"amount_type"=>"borrowvouch"));
		if ($result!=""){
		$_result['borrowvouch_amount_total'] = $result['account_total'];//可用借款担保额度
		$_result['borrowvouch_amount_use'] = $result['account_use'];//可用借款担保额度
		}

		*/
			
		//最近还款时间和总额
		$sql = "select repayment_time,repayment_account from  {borrow_repayment}  where status !=1 and borrow_id in (select id from  {borrow}  where user_id = {$user_id} and status=3) order by repayment_time ";
		$result = $mysql->db_fetch_array($sql);
		$_result['new_repay_time'] = $result['repayment_time'];
		$_result['new_repay_account'] = $result['repayment_account'];
			
		//最近收款时间和时间
		$curDayTime = date("Y-m-d");
		$curDayTimeStr = strtotime($curDayTime);

		//liukun add for bug 52 begin
		fb($curDayTime, FirePHP::TRACE);
		fb($curDayTimeStr, FirePHP::TRACE);
		//liukun add for bug 52 end

		$sql = "select repay_time,repay_account  from  {borrow_collection}  where tender_id in ( select p2.id from  {borrow_tender}   as p2 left join  {borrow}  as p3 on p2.borrow_id=p3.id where p3.status=3 and p2.user_id = '{$user_id}' and p2.status=1) and repay_time > ".$curDayTimeStr." and status=0 order by repay_time asc";

		$result = $mysql->db_fetch_array($sql);
		$_result['new_collection_time'] = $result['repay_time'];
		$_result['new_collection_account'] = $result['repay_account'];

		//网站垫付总额
		//最近收款时间和时间
		$sql = "select sum(repay_account) as num_late_repay_account ,sum(interest) as num_late_interes from  {borrow_collection}  where tender_id in ( select id from  {borrow_tender}  where user_id = '{$user_id}' and status=1)  and status=2 order by repay_time asc";
		$result = $mysql->db_fetch_array($sql);
		$_result['num_late_repay_account'] = $result['num_late_repay_account'];
		$_result['num_late_interes'] = $result['num_late_interes'];

		//liukun add for bug 216 begin
		//根据债权表计算待收信息
		//待收总额 $total_collection += round (floor($_interest['repayment_account'] * $has_percent) / 100, 2);
		$sql = "select sum(round(floor(bt.repayment_account * br.has_percent) / 100, 2)) as r_collection_total, sum(round(round(bt.capital * br.has_percent) / 100, 2))  as r_collection_capital,
		sum(round(floor(bt.repayment_account * br.has_percent) / 100, 2) - round(round(bt.capital * br.has_percent) / 100, 2)) as  r_collection_interest
		from  {borrow_right}  br,   {borrow_repayment}  bt where br.creditor_id = {$user_id} and br.borrow_id = bt.borrow_id  and bt.status = 0 ";
		$result = $mysql->db_fetch_array($sql);

		$_result['r_collection_total'] = $result['r_collection_total'];
		$_result['r_collection_capital'] = $result['r_collection_capital'];
		$_result['r_collection_interest'] = $result['r_collection_interest'];

		//最近待收

		$sql = "select sum(round(floor(bt.repayment_account * br.has_percent) / 100, 2)) as r_collection_total_last, sum(round(round(bt.capital * br.has_percent) / 100, 2)) as r_collection_capital_last ,
		sum(round(floor(bt.repayment_account * br.has_percent) / 100, 2) - round(round(bt.capital * br.has_percent) / 100, 2)) as  r_collection_interest_last,
		bt.repayment_time
		from  {borrow_right}  br,   {borrow_repayment}  bt where br.creditor_id = {$user_id} and br.borrow_id = bt.borrow_id  and bt.status = 0
		group by bt.repayment_time order by bt.repayment_time asc limit 1";

		$result = $mysql->db_fetch_array($sql);

		$_result['r_collection_total_last'] = $result['r_collection_total_last'];
		$_result['r_collection_capital_last'] = $result['r_collection_capital_last'];
		$_result['r_collection_interest_last'] = $result['r_collection_interest_last'];
		$_result['r_collection_last_time'] = $result['repayment_time'];
		//liukun add for bug 216 end

		//统计流转标的待收信息
		//只需要统计现金购买的流转标即可
		$sql = "select sum(capital) circulation_capital_c, sum(interest) circulation_interest_c from  {circulation_buy_serial} 
		where buyer_id = {$user_id} and buyback = 0 and buy_type = 'account'";
		$result = $mysql->db_fetch_array($sql);
		$_result['circulation_capital_c'] = $result['circulation_capital_c'];
		$_result['circulation_interest_c'] = $result['circulation_interest_c'];

		//统计流转标的待还信息
		$sql = "select sum(cs.capital) circulation_capital_r, sum(cs.interest) circulation_interest_r from  {circulation_buy_serial}  cs,  {circulation}  cn,  {borrow}  bw
		where  cs.circulation_id = cn.id and cn.borrow_id = bw.id and cs.buyback = 0 and bw.user_id = {$user_id}";
		$result = $mysql->db_fetch_array($sql);
		$_result['circulation_capital_r'] = $result['circulation_capital_r'];
		$_result['circulation_interest_r'] = $result['circulation_interest_r'];

		//获取净值
		//没有启用任何净值公式，不能发标
		if ($jin_formula==0 && $jin_formula_vouch ==0){
			$jinAmount = 0;
		}

		//启用净值公式
		if ($jin_formula==1 && $jin_formula_vouch ==0){
			$jinAmount = accountClass::getJinAmount($data);
		}

		//启用担保模式净值公式
		if ($jin_formula==0 && $jin_formula_vouch ==1){
			$jinAmount = accountClass::getJinAmountVouch($data);
		}

		//启用两种净值公式，根据是否有担保额度选择净值计算公式
		if ($jin_formula==1 && $jin_formula_vouch ==1){
			$amount_result = amountClass::GetAmountOne($user_id, "tender_vouch");
			//有担保额度时使用担保模式净值公式
			if ($amount_result['account_all'] > 0){
				$jinAmount = accountClass::getJinAmountVouch($data);
			}
			else{
				$jinAmount = accountClass::getJinAmount($data);
			}
		}

		$_result['jinAmount'] = $jinAmount;

		//获取商城的用户信息
		$sql = "select * from  {user}  where user_id = '{$user_id}'";
		$result = $mysql->db_fetch_array($sql);
		if ($result!=false){
			$data['uc_user_id'] = $result['uc_user_id'];//借款总额
		}

		$mallinfo = accountClass::GetMallInfobyUc($data);

		$_result['mallinfo'] = $mallinfo;

		//计算已赚利息
		//liukun add for bug 331 begin
		$sql = "select sum(bc.interest) ed_interest  from dw_borrow_collection bc, dw_borrow_right br
		where bc.borrow_right_id = br.id and br.creditor_id = {$user_id}
		and bc.status = 1";
		$result = $mysql->db_fetch_array($sql);
		if (!isset($result['ed_interest'])){
			$_result['ed_interest'] = 0;
		}else{
			$_result['ed_interest'] = $result['ed_interest'];
		}
		//liukun add for bug 331 end

		$stock_price = isset($_G['system']['con_stock_price'])?$_G['system']['con_stock_price']:"2.655";
		$_result['stock_value'] = round($_result['stock'] * $stock_price, 2);
		return $_result;

	}

	/**
	 * 查看
	 *
	 * @param Array $data
	 * @return Array
	 */
	public static function GetOnes($data = array()){
		global $mysql,$_G;
		$user_id = $data['user_id'];
		$id = $data['id'];

		$sql = "select * from {borrow} where status<2 and user_id='{$user_id}'";
		$result = $mysql->db_fetch_array($sql);
		if ($result != false){
			echo "<script>alert('您已经有一个借款标，请处理好借款标再进行借款!');location.href='/index.php?user&q=code/borrow/publish';</script>";
			exit;
		}

		if ($id=="") {
			$sql = "select * from {credit} where user_id='{$user_id}'";
			$result = $mysql->db_fetch_array($sql);

			if ($result==false || $result['value']<30){
				/*				echo "<script>alert('您的信用积分还未到30分，请先上传资料认证');location.href='/index.php?user&q=code/user/realname';</script>";
					exit;
				*/			}else{
				$sql = "select * from {borrow} where status<2 and user_id='{$user_id}'";
				$result = $mysql->db_fetch_array($sql);
				if ($result != false){
					echo "<script>alert('您已经有一个借款标，请处理好借款标再进行借款!!');location.href='/index.php?user&q=code/borrow/publish';</script>";
					exit;
				}
			}
		}else{
			$sql = "select p1.* ,p2.username,p2.realname from {borrow} as p1
			left join {user} as p2 on p1.user_id=p2.user_id
			where p1.user_id=$user_id and p1.id=$id and (p1.status=0 or p1.status=-1)
			";
			$result = $mysql->db_fetch_array($sql);
			if ($result == false){
				echo "<script>alert('您操作有误，请不要乱操作');location.href='/index.php?user&q=code/borrow/publish';</script>";
				exit;
			}else{
				return $result;
			}
		}
	}

	/**
	 * 查看
	 *
	 * @param Array $data
	 * @return Array
	 */
	public static function GetInvest($data = array()){
		global $mysql,$_G;

		$id = $data['id'];
		//获取借款标的响应信息
		$sql = "select * from  {borrow}   where  id = $id";
		$result['borrow'] = $mysql->db_fetch_array($sql);
		if ($result['borrow']==false){
			return self::ERROR;
		}
		$user_id = $result['borrow']['user_id'];

		//获取用户信息以及用户的积分
		$sql = "select p1.*,p2.value as credit_jifen,p3.pic as credit_pic from  {user}  as p1
		left join {credit} as p2 on p1.user_id=p2.user_id
		left join {credit_rank} as p3 on p2.value<=p3.point2  and p2.value>=p3.point1
		where  p1.user_id=$user_id";
		$result['user'] = $mysql->db_fetch_array($sql);

		//获取用户的基本资料
		$sql = "select * from  {userinfo}   where  user_id=$user_id";
		$result['userinfo'] = $mysql->db_fetch_array($sql);

		//获取进度
		$result['borrow']['other'] = $result['borrow']['account'] - $result['borrow']['account_yes'];

		$scaleValue = 100*$result['borrow']['account_yes']/$result['borrow']['account'];
		if($scaleValue>99.95 && $scaleValue<99.99999999){
			$result['borrow']['scale']=99.9;
		}else{
			$result['borrow']['scale'] = round(100*$result['borrow']['account_yes']/$result['borrow']['account'],1);
		}

		$result['borrow']['scale_width'] = round((20*$result['borrow']['account_yes']/$result['borrow']['account']))*7;
		$result['borrow']['lave_time'] = $result['borrow']['verify_time'] + $result['borrow']['valid_time']*24*60*60-time();
		$result['borrow']['rep_time'] = $result['borrow']['end_time'] - time();
		$_interest = self::EqualInterest(array("account"=>100,"year_apr"=> $result['borrow']['apr'],"month_times"=> $result['borrow']['time_limit'],"type"=>"all","borrow_style"=>$result['borrow']['borrow'],"isday"=>$result['borrow']['isday'],"time_limit_day"=>$result['borrow']['time_limit_day']));
		//repair by weego for 天标 20120525
		$result['borrow']['interest'] = $_interest['repayment_account']-100;

		//获取用户的资金账号信息
		$sql = "select * from  {account}   where  user_id={$user_id}";
		$result['account'] = $mysql->db_fetch_array($sql);

		//获取用户的资金账号信息
		if($_G['user_id'] == ""){
			$sql = "select * from  {account}   where  user_id=-1";
		}else{
			$sql = "select * from  {account}   where  user_id={$_G['user_id']}";
		}
		$result['user_account'] = $mysql->db_fetch_array($sql);

		//获取用户的资金账号信息
		$sql = "select p1.*,p2.username as kefu_username,p2.wangwang as kefu_wangwang,p2.qq as kefu_qq from  {user_cache}  as  p1 left join  {user}  as p2 on p2.user_id=p1.kefu_userid  where  p1.user_id={$user_id}";
		$result['user_cache'] = $mysql->db_fetch_array($sql);

		$result['borrow_all'] = self::GetBorrowAll(array("user_id"=>$user_id));

		//获取投资的担保额度
		if($_G['user_id'] == ""){
			$result['amount']=0;
		}else{
			$result['amount'] =  self::GetAmountOne($_G['user_id']);
		}
		//获取担保进度
		$result['borrow']['vouch_other'] = $result['borrow']['account'] - $result['borrow']['vouch_account'];
		$result['borrow']['vouch_scale'] = round(100*$result['borrow']['vouch_account']/$result['borrow']['account'],1);
		$result['borrow']['vouchscale_width'] = round((20*$result['borrow']['vouch_account']/$result['borrow']['account']))*7;

		//liukun add for bug 19 begin
		//如果是流转担保贷，则获取附加贷款信息
		if ($result['borrow']['is_circulation'] == 1){
			$sql = "select * from  {circulation}   where  borrow_id = $id";
			$result['circulation'] = $mysql->db_fetch_array($sql);
		}

		//liukun add for bug 19 end
		if($result['borrow']['biao_type'] == 'circulation'){
			$result['borrow']['scale'] = round(100 -  $result['circulation']['valid_unit_num'] / $result['circulation']['total_unit_num'] * 100, 2);
		}
		$valid_month_num = $result['circulation']['duration'] - floor((time() - $result['borrow']['verify_time']) / 3600 / 24 / 30);
		$result['circulation']['valid_month_num'] = $valid_month_num;
		return $result;
	}


	/**
	 * 查看
	 *
	 * @param Array $data
	 * @return Array
	 */
	public static function GetU($data = array()){
		global $mysql,$_G;

		$user_id = $_G['U_uid'];

		//获取用户信息以及用户的积分
		$sql = "select p1.*,p2.value as credit_jifen,p3.pic as credit_pic from  {user}  as p1
		left join {credit} as p2 on p1.user_id=p2.user_id
		left join {credit_rank} as p3 on p2.value<=p3.point2  and p2.value>=p3.point1
		where  p1.user_id=$user_id";
		$result['user'] = $mysql->db_fetch_array($sql);

		//获取用户的基本资料
		$sql = "select * from  {userinfo}   where  user_id=$user_id";
		$result['userinfo'] = $mysql->db_fetch_array($sql);


		//获取用户的资金账号信息
		$sql = "select * from  {account}   where  user_id={$user_id}";
		$result['account'] = $mysql->db_fetch_array($sql);

		//获取用户的资金账号信息
		$sql = "select * from  {account}   where  user_id={$_G['U_uid']}";
		$result['user_account'] = $mysql->db_fetch_array($sql);

		//获取用户的资金账号信息
		$sql = "select p1.*,p2.username as kefu_username,p2.wangwang as kefu_wangwang,p2.qq as kefu_qq from  {user_cache}  as  p1 left join  {user}  as p2 on p2.user_id=p1.kefu_userid  where  p1.user_id={$user_id}";
		$result['user_cache'] = $mysql->db_fetch_array($sql);

		$result['borrow_all'] = self::GetBorrowAll(array("user_id"=>$user_id));

		//获取投资的担保额度
		$result['amount'] =  self::GetAmountOne($_G['U_uid']);
		//userifn
		$sql = "select * from  {user}  where user_id = '{$user_id}'  ";
		$result_se = $mysql->db_fetch_array($sql);

		$result['phone_status']=$result_se['phone_status'];
		$result['video_status']=$result_se['video_status'];
		$result['scene_status']=$result_se['scene_status'];

		return $result;
	}



	/**
	 * 添加
	 *
	 * @param Array $data
	 * @return Boolen
	 */
	function Add($data = array()){
		global $mysql;global $_G;

		$biaotype_info = self::get_biao_type_info(array("biao_type"=>$data['biao_type']));
		//liukun add for bug 52 begin
		fb($biaotype_info, FirePHP::TRACE);
		//liukun add for bug 52 end

		$max_amount = $biaotype_info['max_amount'];
		$min_amount = $biaotype_info['min_amount'];
		$max_apr = $biaotype_info['max_interest_rate'] * 100;
		$min_apr = $biaotype_info['min_interest_rate'] * 100;

		if (!isset($data['user_id']) && trim($data['user_id'])==""){
			return self::NO_LOGIN;
		}
		if (!isset($data['name']) && trim($data['name'])==""){
			return self::BORROW_NAME_NO_EMPTY;
		}
		if (!isset($data['account']) || trim($data['account'])==""){
			return self::BORROW_ACCOUNT_NO_EMPTY;
		}

		if($data['account'] > $max_amount){
			return self::BORROW_ACCOUNT_NO_MAX;
		}

		if($data['account'] < $min_amount){
			return self::BORROW_ACCOUNT_NO_MIN;
		}
		if (!isset($data['apr']) || trim($data['apr'])==""){
			return self::BORROW_APR_NO_EMPTY;
		}
		if ($data['apr']>$max_apr){
			return self::BORROW_APR_NO_MAX;
		}
		if ($data['apr']<$min_apr){
			return self::BORROW_APR_NO_MIN;
		}
		if($biaotype_info['available'] == 0){
			$msg = "不能发此类型标";
			return $msg;
		}
		//liukun add for bug 166 begin
		$ishappy = $data['ishappy'];
		if ($ishappy==1){
			$account_result =  accountClass::GetOne(array("user_id"=>$data['user_id']));//获取当前用户的余额
			$freeze_happy_interest = round($data['account'] * $data['apr'] /100 /12 /30 * $data['valid_time'], 2);

			if($account_result['use_money'] < $freeze_happy_interest){
				$msg = "可用余额不够支付冻结的开心模式利息。";
				return $msg;
			}
		}
		//liukun add for bug 166 end

		//liukun add for bug 472 begin
		$mysql->db_query("start transaction");
		//liukun add for bug 472 end
		$transaction_result = true;
		try{

			$classname = $data['biao_type']."biaoClass";
			$dynaBiaoClass = new $classname();

			//这里要做一个特殊处理，因为要把新创建的借款标的ID传出来，给自动投标程序
			$transaction_result = $dynaBiaoClass->add($data);
			if ($transaction_result !==true){
				throw new Exception();
			}

			//liukun add for bug 166 begin
			//如果是开心模式的时候，要冻结发标有效期对应的利息
			if ($ishappy==1){
				$account_result =  accountClass::GetOne(array("user_id"=>$data['user_id']));//获取当前用户的余额
				$freeze_happy_interest = round($data['account'] * $data['apr'] /100 /12 /30 * $data['valid_time'], 2);
				$log['user_id'] = $data['user_id'];
				$log['type'] = "happy_interest_frost";
				$log['money'] = $freeze_happy_interest;
				$log['total'] = $account_result['total'];
				$log['use_money'] =  $account_result['use_money']-$log['money'];
				$log['no_use_money'] =  $account_result['no_use_money']+$log['money'];
				$log['collection'] =  $account_result['collection'];
				$log['to_user'] = 0;
				$log['remark'] = "开心模式时冻结的利息";
				$transaction_result = accountClass::AddLog($log);//添加记录
				if ($transaction_result !==true){
					throw new Exception();
				}
			}
			//liukun add for bug 166 end
		}
		catch (Exception $e){
			//必须保证所有不可接受的错误都返回异常，并执行了回滚
			$mysql->db_query("rollback");
		}
		//liukun add for bug 472 begin
		if($transaction_result===true){
			$mysql->db_query("commit");
		}else{
			$mysql->db_query("rollback");
		}
		return $transaction_result;
		//liukun add for bug 472 end
	}


	/**
	 * 修改
	 *
	 * @param Array $data
	 * @return Boolen
	 */
	function Update($data = array()){
		global $mysql;
		$user_id = $data['user_id'];
		if ($data['user_id'] == "") {
			return self::ERROR;
		}

		$_sql = "";
		$sql = "update  {borrow}  set ";
		foreach($data as $key => $value){
			$_sql[] .= "`$key` = '$value'";
		}
		$sql .= join(",",$_sql)." where user_id = '$user_id' and id='{$data['id']}' and (status=0 or status=-1)";

		return $mysql->db_query($sql);
	}

	/**
	 * 修改
	 *
	 * @param Array $data
	 * @return Boolen
	 */
	function UpdateSubRemark($data = array()){
		global $mysql;


		$_sql = "";
		$sql = "update  {borrow}  set ";
		foreach($data as $key => $value){
			$_sql[] .= "`$key` = '$value'";
		}
		$sql .= join(",",$_sql)." where id='{$data['id']}' and status=0";

		return $mysql->db_query($sql);
	}


	/**
	 * 修改
	 *
	 * @param Array $data
	 * @return Boolen
	 */
	function Action($data = array()){
		global $mysql;
		$id = $data['id'];
		if ($data['id'] == "") {
			return self::ERROR;
		}

		foreach($data['id'] as $key => $value){
			$sql = "update  {borrow}  set ";
			$sql .= "`flag` = '{$data['flag'][$key]}',`view_type` = '{$data['view'][$key]}' where id = '{$value}'";
			$mysql->db_query($sql);
		}
		return true;
			
	}

	/**
	 * 修改
	 *
	 * @param Array $data
	 * @return Boolen
	 */
	function Verify($data = array()){
		global $mysql;

		$borrow_id = $data['id'];
		$borrow_status = $data['status'];
		//liukun add for bug 472 begin
		$mysql->db_query("start transaction");
		//liukun add for bug 472 end
		$transaction_result = true;
		try{
			$sql = "update  {borrow}  set verify_time='".time()."',verify_user='{$data['verify_user']}',verify_remark='{$data['verify_remark']}',status='{$data['status']}' where  id='{$data['id']}' ";
			$transaction_result = $mysql->db_query($sql);
			if ($transaction_result !==true){
				throw new Exception();
			}

			$sql = "select * from {borrow}  where id={$borrow_id}";
			$borrow_result = $mysql->db_fetch_array($sql);

			$biao_type = $borrow_result['biao_type'];
			$classname = $biao_type."biaoClass";
			$dynaBiaoClass = new $classname();

			$transaction_result = $dynaBiaoClass->verify($borrow_result);
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
		}else{
			$mysql->db_query("rollback");
		}
		return $transaction_result;
		//liukun add for bug 472 end
	}


	/**
	 * 删除
	 *
	 * @param Array $data
	 * @return Boolen
	 */
	public static function Delete($data = array()){
		// 		global $mysql;
		// 		$id = $data['id'];
		// 		if (!is_array($id)){
		// 			$id = array($id);
		// 		}
		// 		if (isset($data['status']) && $data['status']!=""){
		// 			$_sql .= " and status ='".$data['status']."'";
		// 		}
		// 		if (isset($data['user_id'])  && $data['user_id']!=""){
		// 			$_sql = " and user_id={$data['user_id']} ";
		// 		}
		// 		$sql = "delete from {borrow}  where id in (".join(",",$id).") $_sql";
		// 		return $mysql->db_query($sql);
		return true;
	}

	/**
	 * 删除
	 *
	 * @param Array $data
	 * @return Boolen
	 */
	public static function onTop($data = array()){
		global $mysql;
		$max_top_num = isset($_G['system']['con_ontop_num'])?$_G['system']['con_ontop_num']:"5";
		$ontop_fee = isset($_G['system']['con_ontop_fee'])?$_G['system']['con_ontop_fee']:"200";

		$borrow_id = $data['id'];
		$user_id = $data['user_id'];

		//只能当前在初审通过招标中才能置顶
		//
		$sql = "select count(*) as num  from  {borrow}   where status = 1 and isontop = 2 ";
		$result = $mysql->db_fetch_array($sql);
		//liukun add for bug 60 begin
		if($result['num'] >= $max_top_num){
			return "对不起，置顶标已经达到最大个数（{$max_top_num}）!";
		}

		$account_result =  accountClass::GetOne(array("user_id"=>$user_id));
		if($account_result['use_money'] < $ontop_fee){
			return "余额不足支付置顶费!";
		}
		//设置状态为置顶
		$sql = "update  {borrow}  set isontop=2  where id={$borrow_id} ";
		$result = $mysql->db_query($sql);

		if($result ===true){
			$account_result =  accountClass::GetOne(array("user_id"=>$user_id));
			$log['user_id'] = $user_id;
			$log['type'] = "ontop_fee";
			$log['money'] = $ontop_fee;
			$log['total'] = $account_result['total']-$log['money'];
			$log['use_money'] = $account_result['use_money']-$log['money'];
			$log['no_use_money'] = $account_result['no_use_money'];
			$log['collection'] = $account_result['collection'];
			$log['to_user'] = $borrow_userid;
			$log['remark'] = "[{$borrow_url}]置顶收费";
			accountClass::AddLog($log);
		}


		return true;
	}
	/**
	 * 删除
	 *
	 * @param Array $data
	 * @return Boolen
	 */
	public static function Cancel($data = array()){
		global $mysql;
		global $_G;

		$_sql = " where 1=1 ";
		if (isset($data['id']) && $data['id']!=""){
			$_sql .= " and id={$data['id']} ";
		}else{
			return self::ERROR;
		}
		if (isset($data['user_id'])  && $data['user_id']!=""){
			$_sql .= " and user_id={$data['user_id']} ";
		}

		$ssql = "select * from {borrow}  where id=".$data['id']." ";
		$borrow_repayment_result = $mysql->db_fetch_array($ssql);

		//liukun add for bug 60 begin
		if(!(($borrow_repayment_result['status'] == 0) ||($borrow_repayment_result['status'] == 1))) {
			return "借款标不能撤销!";
		}

		//liukun add for bug 60 end

		//liukun add for bug 472 begin
		$mysql->db_query("start transaction");
		//liukun add for bug 472 end
		$transaction_result = true;
		try{
			//设置借款标为取消状态
			$sql = "update  {borrow}  set status=5  $_sql";
			$transaction_result = $mysql->db_query($sql);
			if ($transaction_result !==true){
				throw new Exception();
			}

			$borrow_userid = $borrow_repayment_result['user_id'];
			//返回所有投资者的金钱。
			//liukun add for bug 166 begin
			$ishappy = $borrow_repayment_result['ishappy'];
			$total_happy_interest = 0;
			//退回开心模式冻结的发标人利息
			if($ishappy==1){
				$account_result =  accountClass::GetOne(array("user_id"=>$borrow_userid));//获取当前用户的余额
				$freeze_happy_interest = round($borrow_repayment_result['account'] * $borrow_repayment_result['apr'] /100 /12 /30 * $borrow_repayment_result['valid_time'], 2);
				$log['user_id'] = $borrow_userid;
				$log['type'] = "happy_interest_unfrost";
				$log['money'] = $freeze_happy_interest;
				$log['total'] = $account_result['total'];
				$log['use_money'] =  $account_result['use_money']+$log['money'];
				$log['no_use_money'] =  $account_result['no_use_money']-$log['money'];
				$log['collection'] =  $account_result['collection'];
				$log['to_user'] = 0;
				$log['remark'] = "开心模式时冻结的利息解冻";
				$transaction_result = accountClass::AddLog($log);//添加记录
				if ($transaction_result !==true){
					throw new Exception();
				}
			}
			//liukun add for bug 166 end
			$sql = "select p1.*,p2.status as borrow_status,p2.name as borrow_name from {borrow_tender} as p1 left join  {borrow}  as p2 on p1.borrow_id=p2.id where p1.borrow_id={$data['id']}";
			$result = $mysql->db_fetch_arrays($sql);
			foreach ($result as $key => $value){
				$account_result =  accountClass::GetOne(array("user_id"=>$value['user_id']));
				$log['user_id'] = $value['user_id'];
				$log['type'] = "invest_false";
				$log['money'] = $value['account'];
				$log['total'] = $account_result['total'];
				$log['use_money'] = $account_result['use_money']+$log['money'];
				$log['no_use_money'] = $account_result['no_use_money']-$log['money'];
				$log['collection'] = $account_result['collection'];
				$log['to_user'] = 0;
				$log['remark'] = "招标[<a href=\'/invest/a{$data['id']}.html\' target=_blank>{$value['borrow_name']}</a>]失败返回的投标额";
				$transaction_result = accountClass::AddLog($log);
				if ($transaction_result !==true){
					throw new Exception();
				}

				//审核失败解冻投资本金保障费
				$insurance = $value['insurance'];
				$account_result =  accountClass::GetOne(array("user_id"=>$value['user_id']));
				$log['user_id'] = $value['user_id'];
				$log['type'] = "insurance_unfrost";
				$log['money'] = $insurance;
				$log['total'] = $account_result['total'];
				$log['use_money'] = $account_result['use_money']+$log['money'];
				$log['no_use_money'] = $account_result['no_use_money']-$log['money'];
				$log['collection'] = $account_result['collection'];
				$log['to_user'] = 0;
				$log['remark'] = "解冻本金保障费";
				$transaction_result = accountClass::AddLog($log);
				if ($transaction_result !==true){
					throw new Exception();
				};
					
				//liukun add for bug 166 begin
				if($ishappy==1){
					$happy_interest = round($value['account'] * $borrow_repayment_result['apr'] /100 /12 /30 * ceil((time() - $value['addtime']) / 3600 / 24), 2);
					$total_happy_interest += $happy_interest;

					$account_result =  accountClass::GetOne(array("user_id"=>$value['user_id']));
					$log['user_id'] = $value['user_id'];
					$log['type'] = "interest_happy";
					$log['money'] = $happy_interest;
					$log['total'] = $account_result['total']+$log['money'];
					$log['use_money'] = $account_result['use_money']+$log['money'];
					$log['no_use_money'] = $account_result['no_use_money'];
					$log['collection'] = $account_result['collection'];
					$log['to_user'] = $borrow_userid;
					$log['remark'] = "招标[{$borrow_url}]失败,开心模式得到的利息";
					$transaction_result = accountClass::AddLog($log);
					if ($transaction_result !==true){
						throw new Exception();
					}
				}
				//liukun add for bug 166 end


				//提醒设置
				$remind['nid'] = "loan_no_account";
				$remind['sent_user'] = "0";
				$remind['receive_user'] = $value['user_id'];
				$remind['title'] = "您所投资的标[{$value['borrow_name']}]已经撤消";
				$remind['content'] = "你所投资的标[<a href=\'/invest/a{$data['id']}.html\' target=_blank><font color=red>{$value['borrow_name']}</font></a>]在".date("Y-m-d",time())."已经撤消了，您所投标的金额已解冻了。";
				$remind['type'] = "system";
				remindClass::sendRemind($remind);

				$sql = "update  {borrow_tender}  set status=2 where id = '{$value['id']}'";
				$transaction_result = $mysql->db_query($sql);
				if ($transaction_result !==true){
					throw new Exception();
				}

			}

			//liukun add for bug 166 begin
			if ($ishappy==1 && $total_happy_interest > 0){
				$account_result =  accountClass::GetOne(array("user_id"=>$borrow_userid));
				$log['user_id'] = $borrow_userid;
				$log['type'] = "interest_happy_pay";
				$log['money'] = $total_happy_interest;
				$log['total'] = $account_result['total']-$log['money'];
				$log['use_money'] = $account_result['use_money']-$log['money'];
				$log['no_use_money'] = $account_result['no_use_money'];
				$log['collection'] = $account_result['collection'];
				$log['to_user'] = 0;
				$log['remark'] = "招标[{$borrow_url}]失败,开心模式付出的利息";
				$transaction_result = accountClass::AddLog($log);
				if ($transaction_result !==true){
					throw new Exception();
				}
			}
			//liukun add for bug 166 end

			$classname = $borrow_repayment_result['biao_type']."biaoClass";
			$dynaBiaoClass = new $classname();

			$transaction_result = $dynaBiaoClass->cancel($borrow_repayment_result);
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
		}else{
			$mysql->db_query("rollback");
		}
		return $transaction_result;
		//liukun add for bug 472 end
	}

	/**
	 * 列表
	 *
	 * @return Array
	 */
	function GetTenderList($data = array()){
		global $mysql;
		$user_id = empty($data['user_id'])?"":$data['user_id'];
		$username = empty($data['username'])?"":$data['username'];

		$page = empty($data['page'])?1:$data['page'];
		$epage = empty($data['epage'])?10:$data['epage'];

		$_sql = "where 1=1";
		if (!empty($user_id)){
			$_sql .= " and p1.user_id = $user_id";
		}
		if (!empty($username)){
			$_sql .= " and p2.username = '$username'";
		}
		if (isset($data['borrow_id']) && $data['borrow_id']!=""){
			$_sql .= " and p1.borrow_id = '{$data['borrow_id']}'";
		}

		if (isset($data['dotime2'])){
			$dotime2 = ($data['dotime2']=="request")?$_REQUEST['dotime2']:$data['dotime2'];
			if( !isTimePattern($dotime2))$dotime2 = "";
			if ($dotime2!=""){
				$_sql .= " and p1.addtime <= ".get_mktime($dotime2);
			}
		}
		if (isset($data['dotime1'])){
			$dotime1 = ($data['dotime1']=="request")?$_REQUEST['dotime1']:$data['dotime1'];
			if( !isTimePattern($dotime1))$dotime1 = "";
			if ($dotime1!=""){
				$_sql .= " and p1.addtime >= ".get_mktime($dotime1);
			}
		}
		if (isset($data['status']) && $data['status']!=""){
			$_sql .= " and p1.status in ({$data['status']})";
		}
		if (isset($data['borrow_status']) && $data['borrow_status']!=""){
			$_sql .= " and p3.status in ({$data['borrow_status']})";
		}

		if (isset($data['keywords']) && $data['keywords']!=""){
			$_sql .= " and p1.name like '%".safegl($data['keywords'])."%'";
		}

		/*
		 $_select = " p1.*,p1.account as tender_account,p1.repayment_account - p1.repayment_yesaccount - p1.repayment_yesinterest as wait,
		p1.repayment_account - p1.account as wait_in,p2.username,p3.account ,p3.account_yes,p3.apr,p3.time_limit,p3.name as borrow_name,p4.username as op_username,p5.value as credit_jifen,p6.pic as credit_pic";
		$sql = "select SELECT from {borrow_tender} as p1
		left join {borrow} as p3 on p3.id=p1.borrow_id
		left join {user} as p2 on p1.user_id=p2.user_id
		left join {user} as p4 on p3.user_id=p4.user_id
		left join {credit} as p5 on p3.user_id=p5.user_id
		left join {credit_rank} as p6 on p5.value<=p6.point2  and p5.value>=p6.point1
		$_sql ORDER LIMIT";
		*/
		$_select = "p1.*,p1.account as tender_account,p1.money as tender_money,p2.user_id as borrow_userid,p2.username as op_username,p4.username as username,p3.apr,p3.time_limit,p3.time_limit_day,p3.isday,p3.name as borrow_name,p3.id as borrow_id,p3.account ,p3.account_yes,p5.value as credit_jifen,p6.pic as credit_pic";
		$sql = "select SELECT from  {borrow_tender}  as p1
		left join  {borrow}  as p3 on p1.borrow_id=p3.id
		left join  {user}  as p2 on p3.user_id = p2.user_id
		left join  {user}  as p4 on p4.user_id = p1.user_id
		left join {credit} as p5 on p1.user_id=p5.user_id
		left join {credit_rank} as p6 on p5.value<=p6.point2  and p5.value>=p6.point1
		{$_sql}  order by p1.addtime desc LIMIT";

		//是否显示全部的信息
		if (isset($data['limit']) ){
			$_limit = "";
			if ($data['limit'] != "all"){
				$_limit = "  limit ".$data['limit'];
			}
			$result= $mysql->db_fetch_arrays(str_replace(array('SELECT', 'ORDER', 'LIMIT'), array($_select,  'order by p1.id desc', $_limit), $sql));

			foreach($result as $key => $value){
				//获取进度
				//获取进度
				$result[$key]['other'] = $value['account'] - $value['account_yes'];
				$result[$key]['scale'] = round(100*$value['account_yes']/$value['account'],1);
				$result[$key]['scale_width'] = round((20*$value['account_yes']/$value['account']))*7;
				$result[$key]['repayment_noaccount'] = $value['repayment_account'] - $value['repayment_yesaccount'];
				$_data['year_apr'] = $value['apr'];
				$_data['account'] = $value['tender_account'];
				$_data['month_times'] = $value['time_limit'];
				$_data['borrow_style'] = $value['style'];
				$_data['type'] = "all";
				///add by weego for 天标
				$_data['isday'] = $value['isday'];
				$_data['time_limit_day'] = $value['time_limit_day'];
				$result[$key]['equal'] = self::EqualInterest($_data);
			}
			return $result;
		}

		$row = $mysql->db_fetch_array(str_replace(array('SELECT', 'ORDER', 'LIMIT'), array('count(1) as num', '', ''), $sql));

		$total = $row['num'];
		$total_page = ceil($total / $epage);
		$index = $epage * ($page - 1);
		$limit = " limit {$index}, {$epage}";

		$list = $mysql->db_fetch_arrays(str_replace(array('SELECT', 'ORDER', 'LIMIT'), array($_select, 'order by p1.id desc', $limit), $sql));
		$list = $list?$list:array();
		foreach($list as $key => $value){
			//获取进度
			if(empty($value['account'])) $value['account']=1;
			$_data['year_apr'] = $value['apr'];
			$_data['account'] = $value['account'];
			$_data['month_times'] = $value['time_limit'];
			$_data['borrow_style'] = $value['style'];
			///add by weego for 天标
			$_data['isday'] = $value['isday'];
			$_data['time_limit_day'] = $value['time_limit_day'];
			$list[$key]['equal'] = self::EqualInterest($_data);
			$list[$key]['other'] = $value['account'] - $value['account_yes'];
			$list[$key]['scale'] = round(100*$value['account_yes']/$value['account'],1);
			$list[$key]['scale_width'] = round((20*$value['account_yes']/$value['account']))*7;
			$list[$key]['repayment_noaccount'] = $value['repayment_account'] - $value['repayment_yesaccount'];
		}

		return array(
				'list' => $list,
				'total' => $total,
				'page' => $page,
				'epage' => $epage,
				'total_page' => $total_page
		);

	}


	//借出明细账
	function GetTenderCollection($data){
		global $mysql;

		$page = empty($data['page'])?1:$data['page'];
		$epage = empty($data['epage'])?10:$data['epage'];

		$_sql = "where 1=1 ";
		if (!empty($data['user_id'])){
			$_sql .= " and p2.user_id = {$data['user_id']}";
		}
		if (isset($data['dotime2'])){
			$dotime2 = ($data['dotime2']=="request")?$_REQUEST['dotime2']:$data['dotime2'];
			if( !isTimePattern($dotime2))$dotime2 = "";
			if ($dotime2!=""){
				$_sql .= " and p1.addtime < ".get_mktime($dotime2);
			}
		}
		if (isset($data['dotime1'])){
			$dotime1 = ($data['dotime1']=="request")?$_REQUEST['dotime1']:$data['dotime1'];
			if( !isTimePattern($dotime1))$dotime1 = "";
			if ($dotime1!=""){
				$_sql .= " and p1.addtime > ".get_mktime($dotime1);
			}
		}
		$_select = "p1.*,p3.username";
		$sql = "select SELECT from {borrow_tender} as p1
		left join {borrow} as p2 on p2.id=p1.borrow_id
		left join {user} as p3 on p1.user_id=p3.user_id
		$_sql
		";


	}


	/**
	 * 担保列表
	 *
	 * @return Array
	 */
	function GetVouchList($data = array()){
		global $mysql;
		$user_id = empty($data['user_id'])?"":$data['user_id'];
		$username = empty($data['username'])?"":$data['username'];

		$page = empty($data['page'])?1:$data['page'];
		$epage = empty($data['epage'])?10:$data['epage'];

		$_sql = "where 1=1";
		if (!empty($user_id)){
			$_sql .= " and p1.user_id = $user_id";
		}
		if (!empty($username)){
			$_sql .= " and p2.username = '$username'";
		}
		if (isset($data['borrow_id']) && $data['borrow_id']!=""){
			$_sql .= " and p1.borrow_id = '{$data['borrow_id']}'";
		}

		if (isset($data['dotime2'])){
			$dotime2 = ($data['dotime2']=="request")?$_REQUEST['dotime2']:$data['dotime2'];
			if( !isTimePattern($dotime2))$dotime2 = "";
			if ($dotime2!=""){
				$_sql .= " and p1.addtime < ".get_mktime($dotime2);
			}
		}
		if (isset($data['dotime1'])){
			$dotime1 = ($data['dotime1']=="request")?$_REQUEST['dotime1']:$data['dotime1'];
			if( !isTimePattern($dotime1))$dotime1 = "";
			if ($dotime1!=""){
				$_sql .= " and p1.addtime > ".get_mktime($dotime1);
			}
		}
		if (isset($data['status']) && $data['status']!=""){
			$_sql .= " and p1.status in ({$data['status']})";
		}
		if (isset($data['borrow_status']) && $data['borrow_status']!=""){
			$_sql .= " and p3.status in ({$data['borrow_status']})";
		}


		$_select = "p1.*,p2.username,p3.name as borrow_name,p3.time_limit as borrow_period,p3.account as borrow_account,p4.username as borrow_username";
		$sql = "select SELECT from  {borrow_vouch}  as p1
		left join  {user}  as p2 on p2.user_id = p1.user_id
		left join  {borrow}  as p3 on p1.borrow_id = p3.id
		left join  {user}  as p4 on p4.user_id = p3.user_id
		{$_sql}  order by p1.addtime desc LIMIT";

		//是否显示全部的信息
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
		return array(
				'list' => $list,
				'total' => $total,
				'page' => $page,
				'epage' => $epage,
				'total_page' => $total_page
		);

	}

	/**
	 * 担保列表
	 *
	 * @return Array
	 */
	function GetVouchGroupList($data = array()){
		global $mysql;

		$_sql = "where 1=1";

		if (isset($data['borrow_id']) && $data['borrow_id']!=""){
			$_sql .= " and p1.borrow_id = '{$data['borrow_id']}'";
		}





		$_select = " sum(account) as account, sum(vouch_collection) as vouch_collection, user_id, vouch_type ";
		$sql = "select SELECT from  {borrow_vouch}  as p1

		{$_sql}  group by user_id, vouch_type";


		$result= $mysql->db_fetch_arrays(str_replace(array('SELECT', 'ORDER', 'LIMIT'), array($_select,  '', ''), $sql));
		return $result;




	}

	/**
	 * 只是投标的列表
	 *
	 * @return Array
	 */
	function GetTenderUserList($data = array()){
		global $mysql;

		$page = empty($data['page'])?1:$data['page'];
		$epage = empty($data['epage'])?10:$data['epage'];

		$_sql = "where 1=1 ";
		if (!empty($data['user_id'])){
			$_sql .= " and p2.user_id = {$data['user_id']}";
		}
		if (isset($data['username'])){
			if ($data['username']=="request"){
				$_sql .= " and p3.username like '%{$_REQUEST['username']}%'";
			}
		}
		if (isset($data['borrow_id']) && $data['borrow_id']!=""){
			$_sql .= " and p1.borrow_id = '{$data['borrow_id']}'";
		}
		if (isset($data['borrow_status']) && $data['borrow_status']!=""){
			$_sql .= " and p2.status = '{$data['borrow_status']}'";
		}
		if (isset($data['dotime2'])){
			$dotime2 = ($data['dotime2']=="request")?$_REQUEST['dotime2']:$data['dotime2'];
			if( !isTimePattern($dotime2))$dotime2 = "";
			if ($dotime2!=""){
				$_sql .= " and p1.addtime < ".get_mktime($dotime2);
			}
		}
		if (isset($data['dotime1'])){
			$dotime1 = ($data['dotime1']=="request")?$_REQUEST['dotime1']:$data['dotime1'];
			if( !isTimePattern($dotime1))$dotime1 = "";
			if ($dotime1!=""){
				$_sql .= " and p1.addtime > ".get_mktime($dotime1);
			}
		}
		$_select = "p1.*,p2.name as borrow_name,p3.username";
		$sql = "select SELECT from {borrow_tender} as p1
		left join {borrow} as p2 on p2.id=p1.borrow_id
		left join {user} as p3 on p1.user_id=p3.user_id
		$_sql order by p1.id desc
		";
		//是否显示全部的信息
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
		foreach ($list as $key => $value){
			$list[$key]['repayment_noaccount'] = $value['repayment_account']-$value['repayment_yesaccount'];
			$list[$key]['repayment_nointerest'] = $value['repayment_account']-$value['repayment_yesaccount']-$value['account'];
		}

		return array(
				'list' => $list,
				'total' => $total,
				'page' => $page,
				'epage' => $epage,
				'total_page' => $total_page
		);
	}

	/**
	 * 查看投标的信息
	 *
	 * @param Array $data
	 * @return Array
	 */
	public static function GetTenderOne($data = array()){
		global $mysql;
		$id = $data['id'];
		$sql = "select * from {borrow_tender}  where id=$id";
		$result = $mysql->db_fetch_array($sql);
		//获取用户的基本资料
		$sql = "select sum(money) as total from {borrow_tender}  where  borrow_id=$id";
		$_result = $mysql->db_fetch_array($sql);
		$result['other'] = $result['borrow']['account'] - $_result['total'];
		$result['scale'] = round(100*$_result['total']/$result['borrow']['account'],1);
		$result['scale_width'] = round((20*$_result['total']/$result['borrow']['account']))*7;
		return $result;
	}

	/**
	 * 添加投标
	 *
	 * @param Array $data
	 * @return Boolen
	 */
	public static function AddTender($data = array()){
		global $mysql,$_G;
		$con_connect_ws = isset($_G['system']['con_connect_ws'])?$_G['system']['con_connect_ws']:"0";

		if (!isset($data['borrow_id']) || $data['borrow_id']==""){
			return self::ERROR;
		}

		if ($_G['user_result']['islock']==1){
			return "您账号已经被锁定，不能进行投标，请跟管理员联系";
		}

		$borrow_id = $data['borrow_id'];

		$resultBorrow = self::GetOne(array("id"=>$data['borrow_id']));

		$classname = $resultBorrow['biao_type']."biaoClass";
		$dynaBiaoClass = new $classname();

		//liukun add for bug 122 begin
		$user_id = $data["user_id"];

		$userPermission = $dynaBiaoClass->getUserPermission($user_id);

		if ($userPermission['is_restructuring'] == 1){
			$result = "你目前是债务重组中，不能投标。";
			return $result;
		}
		//liukun add for bug 122 end

		//liukun add for bug 213 begin
		$sql = "Select count(*) as num From {borrow_tender}  where borrow_id={$borrow_id} and user_id={$user_id}";

		$tenderResult = $mysql->db_fetch_array($sql);
		$tendNum=$tenderResult["num"];

		$max_tender_times = $dynaBiaoClass->get_max_tender_times();

		if ($tendNum >= $max_tender_times){
			$msg = "对不起，你已经超过最大投标次数(".$max_tender_times."次),谢谢。";
			return $msg;
		}

		//liukun add for bug 472 begin
		$mysql->db_query("start transaction");
		//liukun add for bug 472 end
		$transaction_result = true;
		try{
			$sql = "update  {borrow}  set account_yes=account_yes+{$data['account']},tender_times=tender_times+1  where id='{$data['borrow_id']}'";
			$transaction_result = $mysql->db_query($sql);//更新已经投标的钱
			if ($transaction_result !==true){
				throw new Exception();
			}

			$sql = "insert into  {borrow_tender}  set `addtime` = '".time()."',`addip` = '".ip_address()."'";
			foreach($data as $key => $value){
				$sql .= ",`$key` = '$value'";
			}
			$transaction_result = $mysql->db_query($sql);
			if ($transaction_result !==true){
				throw new Exception();
			}
			$tender_id = $mysql->db_insert_id();

			if ($tender_id>0){

				$account_result =  accountClass::GetOne(array("user_id"=>$data['user_id']));//获取当前用户的余额

				$log['user_id'] = $data['user_id'];
				$log['type'] = "tender";
				$log['money'] = $data['account'] ;
				$log['total'] = $account_result['total'];
				$log['use_money'] =  $account_result['use_money']-$log['money'];
				$log['no_use_money'] =  $account_result['no_use_money']+$log['money'];
				$log['collection'] =  $account_result['collection'];
				//liukun add for bug 153 begin
				//$log['to_user'] = $borrow_result['user_id'];
				$log['to_user'] = 0;
				//liukun add for bug 153 end
				$log['remark'] = "冻结投资者的投标资金";
				$transaction_result = accountClass::AddLog($log);//添加记录
				if ($transaction_result !==true){
					throw new Exception();
				}
					
				//liukun add for bug 249 begin
				//liukun add for bug 266 begin
				if ($con_connect_ws=="1"){
					$insurance = $data['insurance'];
					if ($insurance > 0){
							
						//冻结扣除投资本金保障费
						$account_result =  accountClass::GetOne(array("user_id"=>$data['user_id']));
						$log['user_id'] = $data['user_id'];
						$log['type'] = "insurance_frost";
						$log['money'] = $insurance;
						$log['total'] = $account_result['total'];
						$log['use_money'] = $account_result['use_money']-$log['money'];
						$log['no_use_money'] = $account_result['no_use_money']+$log['money'];
						$log['collection'] = $account_result['collection'];
						$log['to_user'] = 0;
						$log['remark'] = "冻结本金保障费";
						$transaction_result = accountClass::AddLog($log);
						if ($transaction_result !==true){
							throw new Exception();
						}
					}
				}
				//liukun add for bug 266 end
				//liukun add for bug 249 end
					
					

				$tender_data['user_id'] = $data['user_id'];
				$tender_data['account'] = $data['account'];
				$tender_data['borrow_result'] = $resultBorrow;

					

				$transaction_result = $dynaBiaoClass->tender($tender_data);

				if ($transaction_result !==true){
					throw new Exception();
				};
			}
		}
		catch(Exception $e){
			$mysql->db_query("rollback");
		}

		//liukun add for bug 472 begin
		if($transaction_result===true){
			$mysql->db_query("commit");
		}else{
			$mysql->db_query("rollback");
		}
		return $transaction_result;
		//liukun add for bug 472 end
	}



	/**
	 * 添加担保
	 *
	 * @param Array $data
	 * @return Boolen
	 */
	public static function AddVouch($data = array()){
		global $mysql,$_G;

		$borrow_result = self::GetOne(array("id"=>$data['id'],"tender_userid"=>$_G['user_id']));//获取借款标的单独信息

		$user_id = $_G['user_id'];

		$classname = $borrow_result['biao_type']."biaoClass";
		$dynaBiaoClass = new $classname();

		//liukun add for bug 123 end
		$userPermission = $dynaBiaoClass->getUserPermission($user_id);

		if ($userPermission['is_restructuring'] == 1){
			$msg =  "你目前是债务重组中，不能担保。";
			return $msg;
		}
		//liukun add for bug 123 end

		if ($borrow_result['verify_time'] == "" || $borrow_result['status'] != 1){
			$msg = "此标尚未通过审核";
			return $msg;
		}elseif ($borrow_result['verify_time'] + $borrow_result['valid_time']>time()){
			$msg = "此标已过期";
			return $msg;
		}


		//liukun add for bug 472 begin
		$mysql->db_query("start transaction");
		//liukun add for bug 472 end
		$transaction_result = true;
		try{
			$data['borrow_result'] = $borrow_result;

			$transaction_result = $dynaBiaoClass->vouch($data);
			if ($transaction_result !==true){
				throw new Exception();
			};

		}
		catch(Exception $e){
			$mysql->db_query("rollback");
		}

		//liukun add for bug 472 begin
		if($transaction_result===true){
			$mysql->db_query("commit");
		}else{
			$mysql->db_query("rollback");
		}
		return $transaction_result;
	}

	/**
	 * 还款
	 *
	 * @param Array $data
	 * @return Array
	 */
	public static function Repay($data = array()){
		global $mysql,$_G;
		$id = $data['id'];
		if ($id == "request"){
			$id = $_REQUEST['id'];
		}
		$_sql = "";

		if (isset($data['user_id']) && $data['user_id']!=""){
			$_sql .= " and p2.user_id = '{$data['user_id']}'";
		}else{
			return self::ERROR;
		}
		$user_id = $data['user_id'];
		$current_time = time();
		// alpha add for bug 24 begin
		// 将is_restructuring 取出来
		// alpha add for bug 24 end
		// alpha add for bug 14 非提现标 还款后要更新非提现金额 begin
		// $sql = "select p1.*,p2.monthly_repayment as monthly_repayment,p2.is_mb as is_mb,p2.is_jin as is_jin,p2.is_fast as is_fast,p2.name as borrow_name,p2.repayment_account as all_repayment_account,p2.repayment_yesaccount as all_repayment_yesaccount,p2.user_id as borrow_userid,p2.repayment_yesinterest ,p2.time_limit,p2.isday,p2.time_limit_day,p2.forst_account,p2.account as borrow_account,p2.is_vouch,p2.success_time from {borrow_repayment} as p1,{borrow} as p2   where (p1.status=0 or p1.status=2) and p1.id=$id and p1.borrow_id=p2.id $_sql";
		// 将标is_nocash属性取出
		$sql = "select p1.*,p2.monthly_repayment as monthly_repayment,p2.is_mb as is_mb,p2.is_jin as is_jin,p2.is_fast as is_fast,p2.name as borrow_name,p2.repayment_account as all_repayment_account,p2.repayment_yesaccount as all_repayment_yesaccount,p2.user_id as borrow_userid,p2.repayment_yesinterest ,p2.time_limit,p2.isday,p2.time_limit_day,p2.forst_account,p2.account as borrow_account,p2.is_vouch,p2.success_time, p2.is_nocash, is_restructuring, p2.biao_type, p2.jin_model from {borrow_repayment} as p1,{borrow} as p2   where (p1.status=0 or p1.status=2) and p1.id=$id and p1.borrow_id=p2.id $_sql";
		// alpha add for bug 14 非提现标 还款后要更新非提现金额 end

		$borrow_repayment_result = $mysql->db_fetch_array($sql);

		$borrow_id = $borrow_repayment_result["borrow_id"];
		$success_time = $borrow_repayment_result["success_time"];
		$borrow_userid = $borrow_repayment_result["borrow_userid"];

		if ($borrow_repayment_result==false){
			return self::ERROR;
		}
		if ($borrow_repayment_result['status']==1){
			return "此期已经还款，请不要乱操作";
		}

		//判断上一期是否已还
		if ($borrow_repayment_result['order']!=0){
			$_order = $borrow_repayment_result['order']-1;
			$sql = "select status from  {borrow_repayment}  where `order`=$_order and borrow_id={$borrow_repayment_result['borrow_id']}";
			$result = $mysql->db_fetch_array($sql);
			if ($result!=false && $result['status']!=1){
				return "你上期的借款还没还，请先还上期的";
			}
		}

		$biao_type = $borrow_repayment_result['biao_type'];
		$classname = $biao_type."biaoClass";
		$dynaBiaoClass = new $classname();

		$late_result = $dynaBiaoClass->getLateInterest($borrow_repayment_result);
		//liukun add for bug 52 begin
		fb($borrow_repayment_result, FirePHP::TRACE);
		fb($late_result, FirePHP::TRACE);
		//liukun add for bug 52 end
		//判断可用余额是否够还款
		$sql = "select * from {account} where user_id = '{$data['user_id']}'";
		$account_result = $mysql->db_fetch_array($sql);
		if ($account_result['use_money']<$borrow_repayment_result['repayment_account']+$late_result['late_interest']){
			return self::BORROW_REPAYMENT_NOT_ENOUGH;
		}

		//扣除可用余额还款部分
		//判断是否逾期，
		//没逾期，逾期（担保标，非担保标）
		//TODO 逾期问题没有这么简单，有可能是在网站垫付之前还款
		//这里这个还款LOG写得不合适，正常还款时流水并不还给网站
		//不过也可以认为是先还网站，再由网站还给用户，这种方式可以接受


		//liukun add for bug 472 begin
		$mysql->db_query("start transaction");
		//liukun add for bug 472 end
		$transaction_result = true;
		try{
			//所有还款都可以看作直接还给网站，网站再还给真正的债权人
			$account_result =  accountClass::GetOne(array("user_id"=>$data['user_id']));
			$account_log['user_id'] =$data['user_id'];
			$account_log['type'] = "repayment";
			$account_log['money'] = $borrow_repayment_result['repayment_account'];
			$account_log['total'] =$account_result['total']-$account_log['money'];
			$account_log['use_money'] = $account_result['use_money']-$account_log['money'];
			$account_log['no_use_money'] = $account_result['no_use_money'];
			$account_log['collection'] = $account_result['collection'];
			$account_log['to_user'] = "0";
			$account_log['remark'] = "对[<a href=\'/invest/a{$borrow_repayment_result['borrow_id']}.html\' target=_blank>{$borrow_repayment_result['borrow_name']}</a>]还款";
			$transaction_result = accountClass::AddLog($account_log);
			if ($transaction_result !==true){
				throw new Exception();
			};

			//liukun add for bug 133 begin
			$_repay_time = $borrow_repayment_result['repayment_time'];
			$re_time = (strtotime(date("Y-m-d",$_repay_time))-strtotime(date("Y-m-d",time())))/(60*60*24);
			if($re_time>4){//提前4天以上
				$credit['nid'] = "advance_3day";
			}elseif ($re_time>2 && $re_time<=4){//提前3天，4天
				$credit['nid'] = "advance_1day";
			}else{
				$credit['nid'] = "advance_day";
			}
			$result = creditClass::GetTypeOne(array("nid"=>$credit['nid']));
			$credit['user_id'] = $data['user_id'];
			$credit['value'] = $result['value'];
			$credit['op_user'] = $_G['user_id'];
			$credit['op'] = 1;//增加
			$credit['type_id'] = $result['id'];
			$credit['remark'] = "提前还款成功加{$credit['value']}分";

			if($borrow_repayment_result['is_mb']!=1){//秒标、天标没有分 weego
				if($borrow_repayment_result['isday']!=1){
					creditClass::UpdateCredit($credit);//更新积分
				}
			}
			//liukun add for bug 133 end

			//判断是否是最后的还款，是则解冻借款担保金
			//liukun add for bug 303 begin 当选择一次性还款时，这里无法正常执行，因为不管是几个月，order都只是0，但time_limit=月数
			// 		if ($borrow_repayment_result['order']+1 == $borrow_repayment_result['time_limit']){
			if (($borrow_repayment_result['all_repayment_yesaccount']+$borrow_repayment_result['repayment_account']) == $borrow_repayment_result['all_repayment_account']){
				//liukun add for bug 303 end 当选择一次性还款时，这里无法正常执行，因为不管是几个月，order都只是0，但time_limit=月数
				//liukun add for bug 164 begin
				/* add by jackfeng 20120-1-1*/
				if ($borrow_repayment_result['forst_account'] > 0){
					$account_result =  accountClass::GetOne(array("user_id"=>$data['user_id']));
					$account_log['user_id'] =$data['user_id'];
					$account_log['type'] = "borrow_frost";
					$account_log['money'] = $borrow_repayment_result['forst_account'];
					$account_log['total'] =$account_result['total'];
					$account_log['use_money'] = $account_result['use_money']+$account_log['money'];
					$account_log['no_use_money'] = $account_result['no_use_money']-$account_log['money'];
					$account_log['collection'] = $account_result['collection'];
					$account_log['to_user'] = "0";
					$account_log['remark'] = "对[<a href=\'/invest/a{$borrow_repayment_result['borrow_id']}.html\' target=_blank>{$borrow_repayment_result['borrow_name']}</a>]借款保证金的解冻";
					$transaction_result = accountClass::AddLog($account_log);
					if ($transaction_result !==true){
						throw new Exception();
					};
				}
				//liukun add for bug 164 end



				$credit['nid'] = "borrow_success";
				$result = creditClass::GetTypeOne(array("nid"=>$credit['nid']));
				$credit['user_id'] = $data['user_id'];
				$credit['value'] = round($borrow_repayment_result['borrow_account']/100);
				$credit['op_user'] = $_G['user_id'];
				$credit['op'] = 1;//增加
				$credit['type_id'] = $result['id'];
				$credit['remark'] = "还款成功加{$credit['value']}分";


				if($borrow_repayment_result['is_mb']!=1){//秒标、天标没有分 weego
					if($borrow_repayment_result['isday']!=1){
						creditClass::UpdateCredit($credit);//更新积分
					}
				}

			}

			$_order = $borrow_repayment_result['order'];

			//如果网站没有代还，则需要自己还款
			//如果网站没有代还，增加投资人收款记录
			if ($borrow_repayment_result['status']!=2){
				//TODO 债权转让导致还款的改动
				//liukun add for bug 85 begin
				//$borrow_repayment_result['repayment_account']+$late_result['late_interest'];
				$interest_fee_rate = $dynaBiaoClass->get_interest_fee_rate();
				$sql = "select p1.* from  {borrow_right}  as p1 where p1.borrow_id='{$borrow_repayment_result['borrow_id']}' and p1.status = 1 ";

				$borrow_right_result = $mysql->db_fetch_arrays($sql);
				foreach ($borrow_right_result as $key => $value){
					$late_customer_interest = $late_result["late_customer_interest"];

					$repay_account = round($borrow_repayment_result['repayment_account'] * $value['has_percent'] / 100, 2);
					$repay_capital = round($borrow_repayment_result['capital'] * $value['has_percent'] / 100, 2);
					$repay_interest = round($borrow_repayment_result['interest'] * $value['has_percent'] / 100, 2);
					$repay_late_interest = round($late_customer_interest * $value['has_percent'] / 100, 2);


					$account_result =  accountClass::GetOne(array("user_id"=>$value['creditor_id']));
					$account_log['user_id'] =$value['creditor_id'];
					$account_log['type'] = "invest_repayment";
					//给客户计算收入的时候，为了防止出现给客户的总和大于借款人还款的总和，所以不使用4舍5入，而是使用floor，舍掉
					// 					$account_log['money'] = round($borrow_repayment_result['repayment_account'] * $value['has_percent'] / 100, 2);
					//因为PHP浮点数的特殊问题，当$has_percent为100时要特殊处理，不然floor后总是少一份，即使应该是刚好的值，比如128.14 * 100.00 / 100也总是会变成128.13
					if($value['has_percent'] == 100){
						$account_log['money'] = $borrow_repayment_result['repayment_account'];
					}
					else{
						$account_log['money'] = round(floor($borrow_repayment_result['repayment_account'] * $value['has_percent']) / 100, 2);
					}
						

					$account_log['total'] = $account_result['total'];
					$account_log['use_money'] = $account_result['use_money']+$account_log['money'];
					$account_log['no_use_money'] = $account_result['no_use_money'];
					$account_log['collection'] =$account_result['collection'] -$account_log['money'];
					$account_log['to_user'] = $borrow_userid;
					$account_log['remark'] = "客户对[<a href=\'/invest/a{$borrow_repayment_result['borrow_id']}.html\' target=_blank>{$borrow_repayment_result['borrow_name']}</a>]借款的还款(债权表)";
					$transaction_result = accountClass::AddLog($account_log);
					if ($transaction_result !==true){
						throw new Exception();
					};
					//liukun add for bug 157 begin
					//liukun add for bug 157 end
					$interest_fee = round($borrow_repayment_result['interest'] * $value['has_percent'] / 100 * $interest_fee_rate, 2);
					$account_result =  accountClass::GetOne(array("user_id"=>$value['creditor_id']));
					$log['user_id'] = $value['creditor_id'];
					$log['type'] = "tender_mange";//
					$log['money'] = $interest_fee;
					$log['total'] = $account_result['total']-$log['money'];
					$log['use_money'] = $account_result['use_money']-$log['money'];
					$log['no_use_money'] = $account_result['no_use_money'];
					$log['collection'] = $account_result['collection'];
					$log['to_user'] = 0;
					$log['remark'] = "用户成功还款扣除利息的管理费";
					$transaction_result = accountClass::AddLog($log);
					if ($transaction_result !==true){
						throw new Exception();
					};
					//
					$remind['nid'] = "loan_pay";
					$remind['sent_user'] = "0";
					$remind['receive_user'] = $value['creditor_id'];
					$remind['title'] = "客户对[{$borrow_repayment_result['borrow_name']}]借款的还款";
					$remind['content'] = "客户在".date("Y-m-d H:i:s")."对[<a href=\'/invest/a{$borrow_repayment_result['borrow_id']}.html\' target=_blank>{$borrow_repayment_result['borrow_name']}</a>]借款的还款,还款金额为{$account_log['money']}";
					$remind['type'] = "system";
					remindClass::sendRemind($remind);

					//逾期后网站没有代还，借款人还款，投资人有逾期利息收入


					if($repay_late_interest > 0){
						$account_result =  accountClass::GetOne(array("user_id"=>$value['creditor_id']));
						$account_log['user_id'] =$value['creditor_id'];
						$account_log['type'] = "late_collection";
						$account_log['money'] = $repay_late_interest;
						$account_log['total'] = $account_result['total']+$account_log['money'];
						$account_log['use_money'] = $account_result['use_money']+$account_log['money'];
						$account_log['no_use_money'] = $account_result['no_use_money'];
						$account_log['collection'] =$account_result['collection'];
						$account_log['to_user'] = $borrow_userid;
						$account_log['remark'] = "客户对[<a href=\'/invest/a{$borrow_repayment_result['borrow_id']}.html\' target=_blank>{$borrow_repayment_result['borrow_name']}</a>]偿还逾期利息(债权表),金额为{$account_log['money']}";
						$transaction_result = accountClass::AddLog($account_log);
						if ($transaction_result !==true){
							throw new Exception();
						};
					}

					//liukun add for bug 227 begin
					$sql = "insert into  {borrow_collection}  set `addtime` = '{$current_time}',`addip` = '".ip_address()."',`order`={$borrow_repayment_result['order']},`repay_yestime`='{$current_time}',
					`repay_yesaccount`={$repay_account},`interest`={$repay_interest},`capital`={$repay_capital}, `late_days`={$late_result['late_days']}, `late_interest`={$repay_late_interest},
					`borrow_right_id` = {$value['id']}, `status` = 1, interest_fee = {$interest_fee}
					";
					$transaction_result = $mysql ->db_query($sql);
					if ($transaction_result !==true){
						throw new Exception();
					};
					//liukun add for bug 227 end

				}

				//liukun add for bug 85 end

				//liukun add for bug 72 begin
				//dw_borrow_right_alienate 	valid 正常状态是1 当还款后（包括借款人还款和网站垫付），将状态更新为0
				//网站垫付时，也会进行相同的设置
				$sql = "update {borrow_right_alienate}  set valid = 0 where borrow_right_id in (select `id` from  {borrow_right}  as br where br.`borrow_id` = {$borrow_id} and br.status = 1)   ";
				$transaction_result = $mysql->db_query($sql);
				if ($transaction_result !==true){
					throw new Exception();
				};
				//liukun add for bug 72 end


			}

			//逾期还款
			//判断逾期利息是还给谁
			//如果网站已经代还，则把逾期利息还给网站
			//网站代还之前，借款人还款，用户能收到逾期利息

			if ($late_result['late_days']>0 ){
				//支付逾期利息
				$account_result =  accountClass::GetOne(array("user_id"=>$data['user_id']));
				$account_log['user_id'] =$data['user_id'];
				$account_log['type'] = "late_repayment";
				$account_log['money'] = $late_result['late_interest'];
				$account_log['total'] =$account_result['total']-$account_log['money'];
				$account_log['use_money'] = $account_result['use_money']-$account_log['money'];
				$account_log['no_use_money'] = $account_result['no_use_money'];
				$account_log['collection'] = $account_result['collection'];
				$account_log['to_user'] = "0";
				$account_log['remark'] = "对[<a href=\'/invest/a{$borrow_repayment_result['borrow_id']}.html\' target=_blank>{$borrow_repayment_result['borrow_name']}</a>]借款的逾期金额的扣除";
				$transaction_result = accountClass::AddLog($account_log);
				if ($transaction_result !==true){
					throw new Exception();
				};
				//如果是逾期还款，更新逾期时间和逾期利息信息
				$sql = "update {borrow_repayment}  set late_days = '{$late_result['late_days']}',late_interest = '{$late_result['late_interest']}' where id = {$id}";
				$transaction_result = $mysql->db_query($sql);
				if ($transaction_result !==true){
					throw new Exception();
				};
			}

			//添加最后的还款金额
			$sql = "update {borrow} set repayment_yesaccount= repayment_yesaccount + {$borrow_repayment_result['repayment_account']} where id={$borrow_repayment_result['borrow_id']}";
			$transaction_result = $mysql -> db_query($sql);
			if ($transaction_result !==true){
				throw new Exception();
			};

			//更新还款标的状态
			$sql = "update {borrow_repayment} set status=1,repayment_yesaccount='{$borrow_repayment_result['repayment_account']}',repayment_yestime='".time()."' where id=$id";
			$transaction_result = $mysql -> db_query($sql);
			if ($transaction_result !==true){
				throw new Exception();
			};


			//liukun add for bug 120 begin
			//判断是否还有欠款，如果没有，则设置is_restructuring=0
			$sql = "select count(*) as num  from  {borrow}  where user_id='{$user_id}' and status = 3 and repayment_account > repayment_yesaccount ";
			$borrow_not_repay_result = $mysql ->db_fetch_array($sql);

			if ($borrow_not_repay_result['num'] == 0){
				$sql = "update {user}  set is_restructuring = 0 where user_id = {$user_id}";
				$transaction_result = $mysql->db_query($sql);
				if ($transaction_result !==true){
					throw new Exception();
				};
			}

			//liukun add for bug 120 end
			// 将逾期利息信息也传入
			$borrow_repayment_result['late_result'] = $late_result;

			$transaction_result = $dynaBiaoClass->repay($borrow_repayment_result);

			if ($transaction_result !==true){
				throw new Exception();
			};
		}
		catch(Exception $e){
			$mysql->db_query("rollback");
		}

		//liukun add for bug 472 begin
		if($transaction_result===true){
			$mysql->db_query("commit");
		}else{
			$mysql->db_query("rollback");
		}
		return $transaction_result;
		//liukun add for bug 472 end
	}

	/**
	 * 查看投标的信息
	 *
	 * @param Array $data
	 * @return Array
	 */

	function GetRepaymentList($data = array()){
		global $mysql;

		$page = empty($data['page'])?1:$data['page'];
		$epage = empty($data['epage'])?10:$data['epage'];

		$_sql = " where p1.borrow_id=p2.id and p2.user_id=p3.user_id and p2.status=3 ";
		if (isset($data['id']) && $data['id']!=""){
			if ($data['id'] == "request"){
				$_sql .= " and p1.borrow_id= '{$_REQUEST['id']}'";
			}else{
				$_sql .= " and p1.borrow_id= '{$data['id']}'";
			}
		}
		if (isset($data['user_id']) && $data['user_id']!=""){
			$_sql .= " and p2.user_id = '{$data['user_id']}'";
		}
		if (isset($data['is_fast']) && $data['is_fast']==1){
			//$_sql .= " and p2.is_fast = 1";
		}
		if (isset($data['username']) && $data['username']!=""){
			$_sql .= " and p3.username like '%{$data['username']}%'";
		}

		if (isset($data['repayment_time']) && $data['repayment_time']!=""){
			if ($date['repayment_time']==0) $data['repayment_time'] = time();
			$_repayment_time = get_mktime(date("Y-m-d",$data['repayment_time']));
// 			if (isset($data['is_fast']) && $data['is_fast']==1){

// 			}else{
// 				$_sql .= " and p1.repayment_time < '{$_repayment_time}'";
// 			}
		}

		if (isset($data['dotime2'])){
			$dotime2 = ($data['dotime2']=="request")?$_REQUEST['dotime2']:$data['dotime2'];
			if( !isTimePattern($dotime2))$dotime2 = "";
			if ($dotime2!=""){
				$_sql .= " and p2.addtime < ".get_mktime($dotime2);
			}
		}
		if (isset($data['dotime1'])){
			$dotime1 = ($data['dotime1']=="request")?$_REQUEST['dotime1']:$data['dotime1'];
			if( !isTimePattern($dotime1))$dotime1 = "";
			if ($dotime1!=""){
				$_sql .= " and p2.addtime > ".get_mktime($dotime1);
			}
		}

		if (isset($data['status'])){
			$_sql .= " and p1.status in ({$data['status']})";
		}
		if (isset($data['kefu_userid']) && $data['kefu_userid']!=""){
			$sql = "select 1 from  {user_cache}  where kefu_userid={$data['kefu_userid']} and user_id='{$data['user_id']}'";
			$result  = $mysql->db_fetch_array($sql);
			if($result=="" || $result==false){
				return "您的操作有误";
			}
		}
		$keywords = empty($data['keywords'])?"":$data['keywords'];
		if ((!empty($keywords)  ) ){
			if ($keywords=="request"){
				if (isset($_REQUEST['keywords']) && $_REQUEST['keywords']!=""){
					$_sql .= " and p2.name like '%".safegl($_REQUEST['keywords'])."%'";
				}
			}else{
				$_sql .= " and p2.name like '%".safegl($keywords)."%'";
			}

		}

		//liukun add for subsite_id search begin
		if (isset($data['areaid']) && $data['areaid']!="0"){
			$_sql .= " and p2.areaid = {$data['areaid']}";
		}
		//liukun add for subsite_id search end

		$_order = " order by p1.repayment_time asc";
		if (isset($data['order']) && $data['order']!="" ){
			if ($data['order'] == "repayment_time"){
				$_order = " order by p1.repayment_time asc ";
			}elseif ($data['order'] == "order"){
				$_order = " order by p1.order asc ,p1.id desc";
			}
		}
		$_select = " p1.*,p2.name as borrow_name,p2.is_fast,p2.time_limit,p3.username,p3.user_id,p3.phone,p3.area, p2.biao_type ";
		$sql = "select SELECT from  {borrow_repayment}  as p1, {borrow}  as p2 , {user}  as p3  {$_sql} ORDER LIMIT";

		//是否显示全部的信息
		if (isset($data['limit']) ){
			$_limit = "";
			if ($data['limit'] != "all"){
				$_limit = "  limit ".$data['limit'];
			}
			$list = $mysql->db_fetch_arrays(str_replace(array('SELECT', 'ORDER', 'LIMIT'), array($_select,  $_order, $_limit), $sql));
			foreach ($list as $key => $value){
// 				$late = self::LateInterest(array("repayment_time"=>$value['repayment_time'],"account"=>$value['capital']));
// 				if ($value['status']!=1){
// 					$list[$key]['late_days'] = $late['late_days'];
// 					$list[$key]['late_interest'] = $late['late_interest'];
// 				}
				
				$repay_data['repayment_time']=$value['repayment_time'];
				$repay_data['repayment_account']=$value['repayment_account'];
				$repay_data['capital']=$value['capital'];
				$repay_data['status']=$value['status'];
				$repay_data['biao_type']=$value['biao_type'];
				$late = self::LateRepaymentInterest($repay_data);
				if ($value['status']!=1){
					$list[$key]['late_days'] = $late['late_days'];
					$list[$key]['late_interest'] = $late['late_interest'];
				}

				if($value['biao_type'] == 'vouch' || $value['biao_type'] == 'restructuring'){
					$v_sql = "select sum(repay_account) as num from  {borrow_vouch_collection}  where borrow_id = {$value['borrow_id']} and `order` = {$value['order']} and is_advance = 1";
						
						
					$vouch_advance = $mysql->db_fetch_array($v_sql);
						
					$list[$key]['vouch_advance'] = $vouch_advance;
				}
			}
			return $list;
		}

		//echo str_replace(array('SELECT', 'ORDER', 'LIMIT'), array($_select,  $_order, $_limit), $sql);
		$row = $mysql->db_fetch_array(str_replace(array('SELECT', 'ORDER', 'LIMIT'), array('count(1) as num', '', ''), $sql));

		$total = $row['num'];
		$total_page = ceil($total / $epage);
		$index = $epage * ($page - 1);
		$limit = " limit {$index}, {$epage}";
		$list = $mysql->db_fetch_arrays(str_replace(array('SELECT', 'ORDER', 'LIMIT'), array($_select,$_order, $limit), $sql));
		$list = $list?$list:array();
		foreach ($list as $key => $value){
			//if($list[$key]['is_fast']==1){
			//liukun add for daizi表不再使用 begin
			/*
			 $sf = "select isqiye,id from  {daizi}  where borrow_id = {$list[$key]['borrow_id']}";
			$list_fast = $mysql->db_fetch_array($sf);
			if($list_fast){
			$list[$key]['fastid'] = $list_fast['id'];
			$list[$key]['isqiye'] = $list_fast['isqiye'];
			}
			*/
			//}
			//liukun add for daizi表不再使用 end
			//$late = self::LateInterest(array("repayment_time"=>$value['repayment_time'],"account"=>$value['capital']));
			$repay_data['repayment_time']=$value['repayment_time'];
			$repay_data['repayment_account']=$value['repayment_account'];
			$repay_data['capital']=$value['capital'];
			$repay_data['status']=$value['status'];
			$repay_data['biao_type']=$value['biao_type'];
			$late = self::LateRepaymentInterest($repay_data);
			if ($value['status']!=1){
				$list[$key]['late_days'] = $late['late_days'];
				$list[$key]['late_interest'] = $late['late_interest'];
			}
			
			if ($value['status']!=1){
				$list[$key]['late_days'] = $late['late_days'];
				$list[$key]['late_interest'] = $late['late_interest'];
				if($value['biao_type'] == 'vouch'){
					$v_sql = "select sum(repay_account) as vouch_advance from  {borrow_vouch_collection}  where borrow_id = {$value['borrow_id']} and `order` = {$value['order']} and is_advance = 1";


					$vouch_result = $mysql->db_fetch_array($v_sql);

					$list[$key]['vouch_advance'] = $vouch_result['vouch_advance'];
				}
			}
		}
		return array(
				'list' => $list,
				'total' => $total,
				'page' => $page,
				'epage' => $epage,
				'total_page' => $total_page
		);

	}
	
	
	
	/**
	 * 查看投标的信息
	 *
	 * @param Array $data
	 * @return Array
	 */
	
	function GetLateFastRepaymentList($data = array()){
		global $mysql;
	
		$page = empty($data['page'])?1:$data['page'];
		$epage = empty($data['epage'])?10:$data['epage'];
	
		$_sql = " where p1.borrow_id=p2.id and p2.user_id=p3.user_id and p2.status=3 ";
		if (isset($data['id']) && $data['id']!=""){
			if ($data['id'] == "request"){
				$_sql .= " and p1.borrow_id= '{$_REQUEST['id']}'";
			}else{
				$_sql .= " and p1.borrow_id= '{$data['id']}'";
			}
		}
		if (isset($data['user_id']) && $data['user_id']!=""){
			$_sql .= " and p2.user_id = '{$data['user_id']}'";
		}
		if (isset($data['biao_type']) && $data['biao_type']==1){
			$_sql .= " and p2.biao_type = '{$data['biao_type']}'";
		}
		if (isset($data['username']) && $data['username']!=""){
			$_sql .= " and p3.username like '%{$data['username']}%'";
		}
		if (isset($data['isday']) && $data['isday']!="2"){
			if($data['isday']==1){
				$_sql .= " and p2.isday = {$data['isday']}";
			}else{
				$_sql .= " and isnull(p2.isday)";
			}
		}
		if (isset($data['repayment_time']) && $data['repayment_time']!=""){
			$_sql .= " and p1.repayment_time <= '{$data['repayment_time']}' and p1.repayment_time > ".time()." ";
		}
	
		if (isset($data['dotime2'])){
			$dotime2 = ($data['dotime2']=="request")?$_REQUEST['dotime2']:$data['dotime2'];
			if( !isTimePattern($dotime2))$dotime2 = "";
			if ($dotime2!=""){
				$_sql .= " and p2.addtime < ".get_mktime($dotime2);
			}
		}
		if (isset($data['dotime1'])){
			$dotime1 = ($data['dotime1']=="request")?$_REQUEST['dotime1']:$data['dotime1'];
			if( !isTimePattern($dotime1))$dotime1 = "";
			if ($dotime1!=""){
				$_sql .= " and p2.addtime > ".get_mktime($dotime1);
			}
		}
	
		if (isset($data['status'])){
			$_sql .= " and p1.status in ({$data['status']})";
		}
		if (isset($data['kefu_userid']) && $data['kefu_userid']!=""){
			$sql = "select 1 from  {user_cache}  where kefu_userid={$data['kefu_userid']} and user_id='{$data['user_id']}'";
			$result  = $mysql->db_fetch_array($sql);
			if($result=="" || $result==false){
				return "您的操作有误";
			}
		}
		$keywords = empty($data['keywords'])?"":$data['keywords'];
		if ((!empty($keywords)  ) ){
			if ($keywords=="request"){
				if (isset($_REQUEST['keywords']) && $_REQUEST['keywords']!=""){
					$_sql .= " and p2.name like '%".safegl($_REQUEST['keywords'])."%'";
				}
			}else{
				$_sql .= " and p2.name like '%".safegl($keywords)."%'";
			}
	
		}
	
		//liukun add for subsite_id search begin
		if (isset($data['areaid']) && $data['areaid']!="0"){
			$_sql .= " and p2.areaid = {$data['areaid']}";
		}
		//liukun add for subsite_id search end
	
		$_order = " order by p1.repayment_time asc";
		if (isset($data['order']) && $data['order']!="" ){
			if ($data['order'] == "repayment_time"){
				$_order = " order by p1.repayment_time asc ";
			}elseif ($data['order'] == "order"){
				$_order = " order by p1.order asc ,p1.id desc";
			}
		}
		$_select = " p1.*,p2.name as borrow_name,p2.is_fast,p2.time_limit,p3.username,p3.user_id,p3.phone,p3.area, p2.biao_type ";
		$sql = "select SELECT from  {borrow_repayment}  as p1, {borrow}  as p2 , {user}  as p3  {$_sql} ORDER LIMIT";
	
		//是否显示全部的信息
		if (isset($data['limit']) ){
			$_limit = "";
			if ($data['limit'] != "all"){
				$_limit = "  limit ".$data['limit'];
			}
			$list = $mysql->db_fetch_arrays(str_replace(array('SELECT', 'ORDER', 'LIMIT'), array($_select,  $_order, $_limit), $sql));
			foreach ($list as $key => $value){
				//$late = self::LateInterest(array("repayment_time"=>$value['repayment_time'],"account"=>$value['capital']));
				$repay_data['repayment_time']=$value['repayment_time'];
				$repay_data['repayment_account']=$value['repayment_account'];
				$repay_data['capital']=$value['capital'];
				$repay_data['status']=$value['status'];
				$repay_data['biao_type']=$value['biao_type'];
				$late = self::LateRepaymentInterest($repay_data);
				if ($value['status']!=1){
					$list[$key]['late_days'] = $late['late_days'];
					$list[$key]['late_interest'] = $late['late_interest'];
				}
	
				if($value['biao_type'] == 'vouch' || $value['biao_type'] == 'restructuring'){
					$v_sql = "select sum(repay_account) as num from  {borrow_vouch_collection}  where borrow_id = {$value['borrow_id']} and `order` = {$value['order']} and is_advance = 1";
	
	
					$vouch_advance = $mysql->db_fetch_array($v_sql);
	
					$list[$key]['vouch_advance'] = $vouch_advance;
				}
			}
			return $list;
		}
	
		//echo str_replace(array('SELECT', 'ORDER', 'LIMIT'), array($_select,  $_order, $_limit), $sql);
		$row = $mysql->db_fetch_array(str_replace(array('SELECT', 'ORDER', 'LIMIT'), array('count(1) as num', '', ''), $sql));
	
		$total = $row['num'];
		$total_page = ceil($total / $epage);
		$index = $epage * ($page - 1);
		$limit = " limit {$index}, {$epage}";
		$list = $mysql->db_fetch_arrays(str_replace(array('SELECT', 'ORDER', 'LIMIT'), array($_select,$_order, $limit), $sql));
		$list = $list?$list:array();
		foreach ($list as $key => $value){
			//if($list[$key]['is_fast']==1){
			//liukun add for daizi表不再使用 begin
			/*
			 $sf = "select isqiye,id from  {daizi}  where borrow_id = {$list[$key]['borrow_id']}";
			$list_fast = $mysql->db_fetch_array($sf);
			if($list_fast){
			$list[$key]['fastid'] = $list_fast['id'];
			$list[$key]['isqiye'] = $list_fast['isqiye'];
			}
			*/
			//}
			//liukun add for daizi表不再使用 end
			//$late = self::LateInterest(array("repayment_time"=>$value['repayment_time'],"account"=>$value['capital']));
			$repay_data['repayment_time']=$value['repayment_time'];
			$repay_data['repayment_account']=$value['repayment_account'];
			$repay_data['capital']=$value['capital'];
			$repay_data['status']=$value['status'];
			$repay_data['biao_type']=$value['biao_type'];
			$late = self::LateRepaymentInterest($repay_data);
			if ($value['status']!=1){
				$list[$key]['late_days'] = $late['late_days'];
				$list[$key]['late_interest'] = $late['late_interest'];
				if($value['biao_type'] == 'vouch'){
					$v_sql = "select sum(repay_account) as vouch_advance from  {borrow_vouch_collection}  where borrow_id = {$value['borrow_id']} and `order` = {$value['order']} and is_advance = 1";
	
	
					$vouch_result = $mysql->db_fetch_array($v_sql);
	
					$list[$key]['vouch_advance'] = $vouch_result['vouch_advance'];
				}
			}
		}
		return array(
				'list' => $list,
				'total' => $total,
				'page' => $page,
				'epage' => $epage,
				'total_page' => $total_page
		);
	
	}

	/**
	 * 查看投标的信息
	 *
	 * @param Array $data
	 * @return Array
	 */
	
	function GetLateRepaymentList($data = array()){
		global $mysql;
	
		$page = empty($data['page'])?1:$data['page'];
		$epage = empty($data['epage'])?10:$data['epage'];
	
		$_sql = " where p1.borrow_id=p2.id and p2.user_id=p3.user_id and p2.status=3 ";
		if (isset($data['id']) && $data['id']!=""){
			if ($data['id'] == "request"){
				$_sql .= " and p1.borrow_id= '{$_REQUEST['id']}'";
			}else{
				$_sql .= " and p1.borrow_id= '{$data['id']}'";
			}
		}
		if (isset($data['user_id']) && $data['user_id']!=""){
			$_sql .= " and p2.user_id = '{$data['user_id']}'";
		}
		if (isset($data['biao_type']) && $data['biao_type']==1){
			$_sql .= " and p2.biao_type = '{$data['biao_type']}'";
		}
		if (isset($data['isday']) && $data['isday']!="2"){
			if($data['isday']==1){
				$_sql .= " and p2.isday = {$data['isday']}";
			}else{
				$_sql .= " and isnull(p2.isday)";
			}
		}
		if (isset($data['username']) && $data['username']!=""){
			$_sql .= " and p3.username like '%{$data['username']}%'";
		}
	
		if (isset($data['repayment_time']) && $data['repayment_time']!=""){
			$_sql .= " and p1.repayment_time <= '{$data['repayment_time']}'  ";
		}
	
		if (isset($data['dotime2'])){
			$dotime2 = ($data['dotime2']=="request")?$_REQUEST['dotime2']:$data['dotime2'];
			if( !isTimePattern($dotime2))$dotime2 = "";
			if ($dotime2!=""){
				$_sql .= " and p2.addtime < ".get_mktime($dotime2);
			}
		}
		if (isset($data['dotime1'])){
			$dotime1 = ($data['dotime1']=="request")?$_REQUEST['dotime1']:$data['dotime1'];
			if( !isTimePattern($dotime1))$dotime1 = "";
			if ($dotime1!=""){
				$_sql .= " and p2.addtime > ".get_mktime($dotime1);
			}
		}
	
		if (isset($data['status'])){
			$_sql .= " and p1.status in ({$data['status']})";
		}
		if (isset($data['kefu_userid']) && $data['kefu_userid']!=""){
			$sql = "select 1 from  {user_cache}  where kefu_userid={$data['kefu_userid']} and user_id='{$data['user_id']}'";
			$result  = $mysql->db_fetch_array($sql);
			if($result=="" || $result==false){
				return "您的操作有误";
			}
		}
		$keywords = empty($data['keywords'])?"":$data['keywords'];
		if ((!empty($keywords)  ) ){
			if ($keywords=="request"){
				if (isset($_REQUEST['keywords']) && $_REQUEST['keywords']!=""){
					$_sql .= " and p2.name like '%".safegl($_REQUEST['keywords'])."%'";
				}
			}else{
				$_sql .= " and p2.name like '%".safegl($keywords)."%'";
			}
	
		}
	
		//liukun add for subsite_id search begin
		if (isset($data['areaid']) && $data['areaid']!="0"){
			$_sql .= " and p2.areaid = {$data['areaid']}";
		}
		//liukun add for subsite_id search end
	
		$_order = " order by p1.repayment_time asc";
		if (isset($data['order']) && $data['order']!="" ){
			if ($data['order'] == "repayment_time"){
				$_order = " order by p1.repayment_time asc ";
			}elseif ($data['order'] == "order"){
				$_order = " order by p1.order asc ,p1.id desc";
			}
		}
		$_select = " p1.*,p2.name as borrow_name,p2.is_fast,p2.time_limit,p3.username,p3.user_id,p3.phone,p3.area, p2.biao_type ";
		$sql = "select SELECT from  {borrow_repayment}  as p1, {borrow}  as p2 , {user}  as p3  {$_sql} ORDER LIMIT";
	
		//是否显示全部的信息
		if (isset($data['limit']) ){
			$_limit = "";
			if ($data['limit'] != "all"){
				$_limit = "  limit ".$data['limit'];
			}
			$list = $mysql->db_fetch_arrays(str_replace(array('SELECT', 'ORDER', 'LIMIT'), array($_select,  $_order, $_limit), $sql));
			foreach ($list as $key => $value){
				//$late = self::LateInterest(array("repayment_time"=>$value['repayment_time'],"account"=>$value['capital']));
				
				$repay_data['repayment_time']=$value['repayment_time'];
				$repay_data['repayment_account']=$value['repayment_account'];
				$repay_data['capital']=$value['capital'];
				$repay_data['status']=$value['status'];
				$repay_data['biao_type']=$value['biao_type'];
				$late = self::LateRepaymentInterest($repay_data);
				
				if ($value['status']!=1){
					$list[$key]['late_days'] = $late['late_days'];
					$list[$key]['late_interest'] = $late['late_interest'];
				}
	
				if($value['biao_type'] == 'vouch' || $value['biao_type'] == 'restructuring'){
					$v_sql = "select sum(repay_account) as num from  {borrow_vouch_collection}  where borrow_id = {$value['borrow_id']} and `order` = {$value['order']} and is_advance = 1";
	
	
					$vouch_advance = $mysql->db_fetch_array($v_sql);
	
					$list[$key]['vouch_advance'] = $vouch_advance;
				}
			}
			return $list;
		}
	
		//echo str_replace(array('SELECT', 'ORDER', 'LIMIT'), array($_select,  $_order, $_limit), $sql);
		$row = $mysql->db_fetch_array(str_replace(array('SELECT', 'ORDER', 'LIMIT'), array('count(1) as num', '', ''), $sql));
	
		$total = $row['num'];
		$total_page = ceil($total / $epage);
		$index = $epage * ($page - 1);
		$limit = " limit {$index}, {$epage}";
		$list = $mysql->db_fetch_arrays(str_replace(array('SELECT', 'ORDER', 'LIMIT'), array($_select,$_order, $limit), $sql));
		$list = $list?$list:array();
		foreach ($list as $key => $value){
			//if($list[$key]['is_fast']==1){
			//liukun add for daizi表不再使用 begin
			/*
			 $sf = "select isqiye,id from  {daizi}  where borrow_id = {$list[$key]['borrow_id']}";
			$list_fast = $mysql->db_fetch_array($sf);
			if($list_fast){
			$list[$key]['fastid'] = $list_fast['id'];
			$list[$key]['isqiye'] = $list_fast['isqiye'];
			}
			*/
			//}
			//liukun add for daizi表不再使用 end
			//$late = self::LateInterest(array("repayment_time"=>$value['repayment_time'],"account"=>$value['capital']));
			$repay_data['repayment_time']=$value['repayment_time'];
			$repay_data['repayment_account']=$value['repayment_account'];
			$repay_data['capital']=$value['capital'];
			$repay_data['status']=$value['status'];
			$repay_data['biao_type']=$value['biao_type'];
			$late = self::LateRepaymentInterest($repay_data);
			if ($value['status']!=1){
				$list[$key]['late_days'] = $late['late_days'];
				$list[$key]['late_interest'] = $late['late_interest'];
				if($value['biao_type'] == 'vouch'){
					$v_sql = "select sum(repay_account) as vouch_advance from  {borrow_vouch_collection}  where borrow_id = {$value['borrow_id']} and `order` = {$value['order']} and is_advance = 1";
	
	
					$vouch_result = $mysql->db_fetch_array($v_sql);
	
					$list[$key]['vouch_advance'] = $vouch_result['vouch_advance'];
				}
			}
		}
		return array(
				'list' => $list,
				'total' => $total,
				'page' => $page,
				'epage' => $epage,
				'total_page' => $total_page
		);
	
	}	
	
	//liukun add for bug 21 begin
	/**
	 * 查看投标的信息
	 *
	 * @param Array $data
	 * @return Array
	 */

	function GetAlienateRepaymentList($data = array()){
		global $mysql;

		$page = empty($data['page'])?1:$data['page'];
		$epage = empty($data['epage'])?10:$data['epage'];

		$_sql = " where p1.borrow_id=p2.borrow_id and p1.borrow_id = p3.id and  p1.status != 1";


		//liukun add fro bug 21 begin
		if (isset($data['borrow_right_id']) && $data['borrow_right_id']!="" ){
			$_sql .= " and p2.id={$data['borrow_right_id']}";
		}
		//liukun add fro bug 21 end

		// 		if (isset($data['user_id']) && $data['user_id']!=""){
		// 			$_sql .= " and p2.user_id = '{$data['user_id']}'";
		// 		}
		// 		if (isset($data['is_fast']) && $data['is_fast']==1){
		// 			//$_sql .= " and p2.is_fast = 1";
		// 		}
		// 		if (isset($data['username']) && $data['username']!=""){
		// 			$_sql .= " and p3.username like '%{$data['username']}%'";
		// 		}

		// 		if (isset($data['repayment_time']) && $data['repayment_time']!=""){
		// 			if ($date['repayment_time']==0) $data['repayment_time'] = time();
		// 			$_repayment_time = get_mktime(date("Y-m-d",$data['repayment_time']));
		// 			if (isset($data['is_fast']) && $data['is_fast']==1){

		// 			}else{
		// 				$_sql .= " and p1.repayment_time < '{$_repayment_time}'";
		// 			}
		// 		}

		// 		if (isset($data['dotime2'])){
		// 			$dotime2 = ($data['dotime2']=="request")?$_REQUEST['dotime2']:$data['dotime2'];
		// 			if( !isTimePattern($dotime2))$dotime2 = "";
		// 			if ($dotime2!=""){
		// 				$_sql .= " and p2.addtime < ".get_mktime($dotime2);
		// 			}
		// 		}
		// 		if (isset($data['dotime1'])){
		// 			$dotime1 = ($data['dotime1']=="request")?$_REQUEST['dotime1']:$data['dotime1'];
		// 			if( !isTimePattern($dotime1))$dotime1 = "";
		// 			if ($dotime1!=""){
		// 				$_sql .= " and p2.addtime > ".get_mktime($dotime1);
		// 			}
		// 		}

		// 		if (isset($data['status'])){
		// 			$_sql .= " and p1.status in ({$data['status']})";
		// 		}
		// 		if (isset($data['kefu_userid']) && $data['kefu_userid']!=""){
		// 			$sql = "select 1 from  {user_cache}  where kefu_userid={$data['kefu_userid']} and user_id='{$data['user_id']}'";
		// 			$result  = $mysql->db_fetch_array($sql);
		// 			if($result=="" || $result==false){
		// 				return "您的操作有误";
		// 			}
		// 		}
		// 		$keywords = empty($data['keywords'])?"":$data['keywords'];
		// 		if ((!empty($keywords)  ) ){
		// 			if ($keywords=="request"){
		// 				if (isset($_REQUEST['keywords']) && $_REQUEST['keywords']!=""){
		// 					$_sql .= " and p2.name like '%".safegl($_REQUEST['keywords'])."%'";
		// 				}
		// 			}else{
		// 				$_sql .= " and p2.name like '%".safegl($keywords)."%'";
		// 			}

		// 		}

		$_order = " order by p1.repayment_time asc";
		if (isset($data['order']) && $data['order']!="" ){
			if ($data['order'] == "repayment_time"){
				$_order = " order by p1.repayment_time asc ";
			}elseif ($data['order'] == "order"){
				$_order = " order by p1.order asc ,p1.id desc";
			}
		}



		$_select = " p1.*, round(p2.has_percent, 2) has_percent, p2.origin_creditor_level,  p3.name as borrow_name, p3.time_limit ";
		$sql = "select SELECT from  {borrow_repayment}  as p1, {borrow_right}  as p2,  {borrow}  as p3  {$_sql} ORDER LIMIT";

		//是否显示全部的信息
		if (isset($data['limit']) ){
			$_limit = "";
			if ($data['limit'] != "all"){
				$_limit = "  limit ".$data['limit'];
			}
			$list = $mysql->db_fetch_arrays(str_replace(array('SELECT', 'ORDER', 'LIMIT'), array($_select,  $_order, $_limit), $sql));
			foreach ($list as $key => $value){
				$late = self::LateInterest(array("repayment_time"=>$value['repayment_time'],"account"=>$value['capital']));
				if ($value['status']!=1){
					$list[$key]['late_days'] = $late['late_days'];
					$list[$key]['late_interest'] = $late['late_interest'];
				}
			}
			return $list;
		}

		//echo str_replace(array('SELECT', 'ORDER', 'LIMIT'), array($_select,  $_order, $_limit), $sql);
		$row = $mysql->db_fetch_array(str_replace(array('SELECT', 'ORDER', 'LIMIT'), array('count(1) as num', '', ''), $sql));

		$total = $row['num'];
		$total_page = ceil($total / $epage);
		$index = $epage * ($page - 1);
		$limit = " limit {$index}, {$epage}";
		$list = $mysql->db_fetch_arrays(str_replace(array('SELECT', 'ORDER', 'LIMIT'), array($_select,$_order, $limit), $sql));
		$list = $list?$list:array();
		foreach ($list as $key => $value){
			//if($list[$key]['is_fast']==1){
			$sf = "select isqiye,id from  {daizi}  where borrow_id = {$list[$key]['borrow_id']}";
			$list_fast = $mysql->db_fetch_array($sf);
			if($list_fast){
				$list[$key]['fastid'] = $list_fast['id'];
				$list[$key]['isqiye'] = $list_fast['isqiye'];
			}
			//}
			$late = self::LateInterest(array("repayment_time"=>$value['repayment_time'],"account"=>$value['capital']));
			if ($value['status']!=1){
				$list[$key]['late_days'] = $late['late_days'];
				$list[$key]['late_interest'] = $late['late_interest'];
			}
		}
		return array(
				'list' => $list,
				'total' => $total,
				'page' => $page,
				'epage' => $epage,
				'total_page' => $total_page
		);

	}
	//liukun add for bug 21 end


	function GetVouchRepayList($data = array()){
		global $mysql;

		$page = empty($data['page'])?1:$data['page'];
		$epage = empty($data['epage'])?10:$data['epage'];

		$_sql = " where p1.borrow_id=p2.id and p2.user_id=p3.user_id ";
		if (isset($data['id']) && $data['id']!=""){
			if ($data['id'] == "request"){
				$_sql .= " and p1.borrow_id= '{$_REQUEST['id']}'";
			}else{
				$_sql .= " and p1.borrow_id= '{$data['id']}'";
			}
		}
		if (isset($data['user_id']) && $data['user_id']!=""){
			$_sql .= " and p2.user_id = '{$data['user_id']}'";
		}
		if (isset($data['vouch_userid']) && $data['vouch_userid']!=""){
			$_sql .= " and p2.id in (select borrow_id from  {borrow_vouch}  where user_id={$data['vouch_userid']}) and p4.user_id = {$data['vouch_userid']} ";
		}
		if (isset($data['username']) && $data['username']!=""){
			$_sql .= " and p3.username like '%{$data['username']}%'";
		}
		if (isset($data['repayment_time']) && $data['repayment_time']!=""){
			if ($date['repayment_time']==0) $data['repayment_time'] = time();
			$_repayment_time = get_mktime(date("Y-m-d",$data['repayment_time']));
			$_sql .= " and p1.repayment_time < '{$_repayment_time}'";
		}

		if (isset($data['dotime2'])){
			$dotime2 = ($data['dotime2']=="request")?$_REQUEST['dotime2']:$data['dotime2'];
			if( !isTimePattern($dotime2))$dotime2 = "";
			if ($dotime2!=""){
				$_sql .= " and p2.addtime < ".get_mktime($dotime2);
			}
		}
		if (isset($data['dotime1'])){
			$dotime1 = ($data['dotime1']=="request")?$_REQUEST['dotime1']:$data['dotime1'];
			if( !isTimePattern($dotime1))$dotime1 = "";
			if ($dotime1!=""){
				$_sql .= " and p2.addtime > ".get_mktime($dotime1);
			}
		}
		if (isset($data['status'])){
			//liukun add for 当status是0时，表示查询借款人还没有还款的还款，这时，repayment status 0,2都算， 当status是1时表示查询借款人已经还款的还款，这时，repayment status 1
			if($data['status'] == 0){
				$_sql .= " and p1.status in (0, 2)";
			}
			elseif($data['status'] == 1){
				$_sql .= " and p1.status = 1";
			}
		}
		$keywords = empty($data['keywords'])?"":$data['keywords'];
		if ((!empty($keywords)  ) ){
			if ($keywords=="request"){
				if (isset($_REQUEST['keywords']) && $_REQUEST['keywords']!=""){
					$_sql .= " and p2.name like '%".safegl($_REQUEST['keywords'])."%'";
				}
			}else{
				$_sql .= " and p2.name like '%".safegl($keywords)."%'";
			}

		}

		$_order = " order by p1.id desc";
		if (isset($data['order']) && $data['order']!="" ){
			if ($data['order'] == "repayment_time"){
				$_order = " order by p1.repayment_time asc ";
			}elseif ($data['order'] == "order"){
				$_order = " order by p4.order asc ,p4.id asc";
			}
		}

		$_select = " p1.*,p2.name as borrow_name,p2.time_limit,p3.username as borrow_username, p4.id as vouch_id, p4.is_advance, p4.advance_time,p4.vouch_type, p4.repay_account as vouch_collection, p4.status as  repay_status  ";
		$sql = "select SELECT from  {borrow_repayment}  as p1 left join  {borrow}  as p2 on p1.borrow_id = p2.id left join  {user}  as p3 on p3.user_id=p2.user_id
		left join  {borrow_vouch_collection} as p4 on (p1.borrow_id = p4.borrow_id and p1.order = p4.order)
		{$_sql} ORDER LIMIT";

		//是否显示全部的信息
		if (isset($data['limit']) ){
			$_limit = "";
			if ($data['limit'] != "all"){
				$_limit = "  limit ".$data['limit'];
			}
			$list = $mysql->db_fetch_arrays(str_replace(array('SELECT', 'ORDER', 'LIMIT'), array($_select,  $_order, $_limit), $sql));
			foreach ($list as $key => $value){
				$late = self::LateInterest(array("repayment_time"=>$value['repayment_time'],"account"=>$value['capital']));
				if ($value['status']!=1){
					$list[$key]['late_days'] = $late['late_days'];
					$list[$key]['late_interest'] = $late['late_interest'];
				}
			}
			return $list;
		}

		$row = $mysql->db_fetch_array(str_replace(array('SELECT', 'ORDER', 'LIMIT'), array('count(1) as num', '', ''), $sql));

		$total = $row['num'];
		$total_page = ceil($total / $epage);
		$index = $epage * ($page - 1);
		$limit = " limit {$index}, {$epage}";
		$list = $mysql->db_fetch_arrays(str_replace(array('SELECT', 'ORDER', 'LIMIT'), array($_select,$_order, $limit), $sql));
		$list = $list?$list:array();
		foreach ($list as $key => $value){
			$late = self::LateInterest(array("repayment_time"=>$value['repayment_time'],"account"=>$value['capital']));
			if ($value['status']!=1){
				$list[$key]['late_days'] = $late['late_days'];
				$list[$key]['late_interest'] = $late['late_interest'];
			}
		}
		return array(
				'list' => $list,
				'total' => $total,
				'page' => $page,
				'epage' => $epage,
				'total_page' => $total_page
		);

	}

	//逾期利息计算
	//account 金额 repayment_time 还款时间
	function LateInterest($data){
		global $mysql,$_G;
		//$late_rate = isset($_G['system']['con_late_rate'])?$_G['system']['con_late_rate']:0.004;
		$late_rate=0.004;
		$now_time = get_mktime(date("Y-m-d",time()));
		$repayment_time = get_mktime(date("Y-m-d",$data['repayment_time']));
		$late_days = ($now_time - $repayment_time)/(60*60*24);
		$_late_days = explode(".",$late_days);
		$late_days = ($_late_days[0]<0)?0:$_late_days[0];

		if($late_days<=30){
			$late_interest = round($data['account']*0.004*$late_days,2);
		}else{
			$late_interest = round($data['account']*0.004*30 + $data['account']*0.012*($late_days-30),2);
		}

		if ($late_days==0) $late_interest=0;
		return array("late_days"=>$late_days,"late_interest"=>$late_interest );
	}

	//逾期利息计算
	//account 金额 repayment_time 还款时间
	function LateInterestFast($data){
		global $mysql,$_G;
		//$late_rate = isset($_G['system']['con_late_rate'])?$_G['system']['con_late_rate']:0.004;
		$late_rate=0.004;
		$now_time = get_mktime(date("Y-m-d",time()));
		$repayment_time = get_mktime(date("Y-m-d",$data['repayment_time']));
		$late_days = ($now_time - $repayment_time)/(60*60*24);
		$_late_days = explode(".",$late_days);
		$late_days = ($_late_days[0]<0)?0:$_late_days[0];

		$late_interest = round($data['account']*0.004*$late_days,2);

		if ($late_days==0) $late_interest=0;
		return array("late_days"=>$late_days,"late_interest"=>$late_interest );
	}
	
	function LateRepaymentInterest($data){
		global $mysql, $_G;
	
		$biao_type = $data['biao_type'];
	
		if (isset($_G['biao_type'][$biao_type])){
			$result = $_G['biao_type'][$biao_type];
		}else{
			$sql = "select * from  {biao_type}  where biao_type_name='{$biao_type}'";
			$result = $mysql ->db_fetch_array($sql);
		}
	
		$late_interest_rate['late_interest_rate'] = $result['late_interest_rate'];
		$late_interest_rate['late_customer_interest_rate'] = $result['late_customer_interest_rate'];
		$late_interest_rate['late_interest_scope'] = $result['late_interest_scope'];
	
		//1:逾期利息是应还本息的基础上罚息
		//0:逾期利息是应还本金的基础上罚息
		if ($late_interest_rate['late_interest_scope'] == 1){
			$loan_account = $data['repayment_account'];
		}else{
			$loan_account = $data['capital'];
		}
	
		$late_rate=$late_interest_rate['late_interest_rate'];
	
		$now_time = get_mktime(date("Y-m-d",time()));
		$repayment_time = get_mktime(date("Y-m-d",$data['repayment_time']));
		$late_days = ($now_time - $repayment_time)/(60*60*24);
		$_late_days = explode(".",$late_days);
		$late_days = ($_late_days[0]<0)?0:$_late_days[0];
	
		$late_interest = round($loan_account*$late_rate*$late_days,2);
	
	
	
	
		$interest_result['late_days'] = $late_days;
		$interest_result['late_interest'] = $late_interest;
	
		return $interest_result;
	
	}
	

	//网站逾期垫付
	function LateRepay($data){
		global $mysql,$_G;
		$repayment_id = $data['id'];

		$sql = "select p1.*,p2.name as borrow_name,p2.is_vouch, p2.biao_type from  {borrow_repayment}  as p1 left join  {borrow}  as p2 on p1.borrow_id = p2.id where p1.id = {$repayment_id}";
		$result = $mysql->db_fetch_array($sql);
		$borrow_repayment_result = $result;

		$borrow_result = self::GetOne(array("id"=>$result['borrow_id']));

		$borrow_id = $borrow_result["id"];
		$repayment_status = $borrow_repayment_result["status"];

		$biao_type = $borrow_result['biao_type'];
		$classname = $biao_type."biaoClass";
		$dynaBiaoClass = new $classname();
		$advance = $dynaBiaoClass->get_advance();

		$advance_time = $advance['advance_time'];


		//判断是否到了逾期垫付时间
		$repayment_time = $borrow_repayment_result['repayment_time'];
		//liukun add for bug 52 begin
		fb($advance, FirePHP::TRACE);
		fb($repayment_time, FirePHP::TRACE);
		fb($advance_time, FirePHP::TRACE);
		//liukun add for bug 52 end

		// 		$msg = array("此标尚未到逾期垫付时间");
		// 		return $msg;

		if($biao_type=="vouch"){
			$v_sql = "select count(*) as vouch_num from  {borrow_vouch_collection}  where borrow_id = {$value['borrow_id']} and `order` = {$value['order']} and is_advance = 0";


			$vouch_result = $mysql->db_fetch_array($v_sql);
			if ($vouch_result['vouch_num'] > 0 && time() < ($repayment_time + 3600 * 24 * $advance_time)){
				//担保人没有完全垫付，不能提前网站垫付
				$msg = array("此标尚未到逾期垫付时间");
				return $msg;
			}

		}else{

			if (time() < ($repayment_time + 3600 * 24 * $advance_time)){
				$msg = array("此标尚未到逾期垫付时间");
				return $msg;

			}
		}

		$late_result = $dynaBiaoClass->getLateInterest($borrow_repayment_result);


		$isVouch=$result['is_vouch'];

		if ($repayment_status==1){
			$msg = array("借款人已经还款");
			return $msg; ;
		}elseif ($repayment_status==2){//网站已经代还
			$msg = array("网站已经垫付");
			return $msg;
		}elseif ($repayment_status==0){

			//liukun add for bug 472 begin
			$mysql->db_query("start transaction");
			//liukun add for bug 472 end
			$transaction_result = true;
			try{
				//TODO 债权转让导致还款的改动
				//liukun add for bug 85 begin
				//$borrow_repayment_result['repayment_account']+$late_result['late_interest'];
				$normal_user_type =0;
				$vip_user_type =1;
				$interest_fee_rate = $dynaBiaoClass->get_interest_fee_rate();
				$sql = "select p1.* from  {borrow_right}  as p1 where p1.borrow_id='{$borrow_repayment_result['borrow_id']}' and p1.status = 1 ";

				$borrow_right_result = $mysql->db_fetch_arrays($sql);
				foreach ($borrow_right_result as $key => $value){
					if ($value['origin_creditor_level']==$normal_user_type){
						$advance_scope = $advance['advance_scope'];
						$advance_rate = $advance['advance_rate'];
					}
					if ($value['origin_creditor_level']==$vip_user_type){
						$advance_scope = $advance['advance_vip_scope'];
						$advance_rate = $advance['advance_vip_rate'];
					}

					//0,不垫付
					if ($advance_scope == 0){
						$advance_account = 0;
					}
					//1,垫付本金
					elseif ($advance_scope == 1){
						$advance_account=$borrow_repayment_result['capital'];
					}
					//2，垫付本金和利息
					else {
						$advance_account=$borrow_repayment_result['repayment_account'];
					}

					//liukun add for bug 52 begin
					fb($advance_scope, FirePHP::TRACE);
					fb($advance_rate, FirePHP::TRACE);
					fb($advance_account, FirePHP::TRACE);
					//liukun add for bug 52 end

					if ($advance_account > 0){
						$account_result =  accountClass::GetOne(array("user_id"=>$value['creditor_id']));
						$account_log['user_id'] =$value['creditor_id'];
						$account_log['type'] = "invest_repayment";
						$account_log['money'] = round($advance_account * $value['has_percent'] * $advance_rate / 100, 2);
						$account_log['total'] = $account_result['total'];
						$account_log['use_money'] = $account_result['use_money']+$account_log['money'];
						$account_log['no_use_money'] = $account_result['no_use_money'];
						$account_log['collection'] =$account_result['collection'] -$account_log['money'];
						$account_log['to_user'] = 0;
						$account_log['remark'] = "网站对[<a href=\'/invest/a{$borrow_repayment_result['borrow_id']}.html\' target=_blank>{$borrow_repayment_result['borrow_name']}</a>]借款的逾期垫付(债权表)";
						$transaction_result = accountClass::AddLog($account_log);
						if ($transaction_result !==true){
							throw new Exception();
						};
							
						//liukun add for bug 52 begin
						fb($account_log, FirePHP::TRACE);
						//liukun add for bug 52 end

						//liukun add for bug 157 begin
						//liukun add for bug 157 end
						if ($advance_scope == 2 && $interest_fee_rate > 0){
							$account_result =  accountClass::GetOne(array("user_id"=>$value['creditor_id']));
							$log['user_id'] = $value['creditor_id'];
							$log['type'] = "tender_mange";//
							$log['money'] = round($borrow_repayment_result['interest'] * $value['has_percent'] * $advance_rate / 100 * $interest_fee_rate, 2);
							$log['total'] = $account_result['total']-$log['money'];
							$log['use_money'] = $account_result['use_money']-$log['money'];
							$log['no_use_money'] = $account_result['no_use_money'];
							$log['collection'] = $account_result['collection'];
							$log['to_user'] = 0;
							$log['remark'] = "用户成功还款扣除利息的管理费";
							$transaction_result = accountClass::AddLog($log);
							if ($transaction_result !==true){
								throw new Exception();
							};

						}
					}

					//liukun add for bug 176 begin
					//如果不是本金利息一起垫付，或者垫付比例不是100%，那表示投资人有债权被注销，要写资金记录
					//liukun add for bug 52 begin
					fb($borrow_repayment_result['repayment_account'], FirePHP::TRACE);
					fb($advance_account, FirePHP::TRACE);
					fb($advance_rate, FirePHP::TRACE);
					//liukun add for bug 52 end
					if($borrow_repayment_result['repayment_account'] > $advance_account || $advance_rate < 1){
						$account_result =  accountClass::GetOne(array("user_id"=>$value['creditor_id']));
						$log['user_id'] = $value['creditor_id'];
						$log['type'] = "borrow_right_cancel";//
						$log['money'] = round($borrow_repayment_result['repayment_account'] * $value['has_percent'] / 100, 2) - round($advance_account * $value['has_percent'] * $advance_rate / 100, 2);
						$log['total'] = $account_result['total']-$log['money'];
						$log['use_money'] = $account_result['use_money'];
						$log['no_use_money'] = $account_result['no_use_money'];
						$log['collection'] = $account_result['collection']-$log['money'];
						$log['to_user'] = 0;
						$log['remark'] = "逾期借款没有全额垫付后，债权差额注销";
						$transaction_result = accountClass::AddLog($log);
						if ($transaction_result !==true){
							throw new Exception();
						};
					}
					//liukun add for bug 176 end
				}

				//liukun add for bug 85 end

				//liukun add for bug 149 begin
				$sql = "update  {borrow_repayment}  set status=2,webstatus=1, advance_time='".time()."' where id = {$repayment_id}";
				//liukun add for bug 149 end
				$transaction_result = $mysql -> db_query($sql);
				if ($transaction_result !==true){
					throw new Exception();
				};
				//liukun add for bug 72 begin
				//dw_borrow_right_alienate 	valid 正常状态是1 当还款后（包括借款人还款和网站垫付），将状态更新为0
				//网站垫付时，也会进行相同的设置
				$sql = "update {borrow_right_alienate}  set valid = 0 where borrow_right_id in (select `id` from  {borrow_right}  as br where br.`borrow_id` = {$borrow_id} and br.status = 1) ";
				$transaction_result = $mysql->db_query($sql);
				if ($transaction_result !==true){
					throw new Exception();
				};
				//liukun add for bug 72 end

				$transaction_result = $dynaBiaoClass->late_repay($borrow_repayment_result);

				if ($transaction_result !==true){
					throw new Exception();
				};
			}
			catch(Exception $e){
				$mysql->db_query("rollback");
			}

			//liukun add for bug 472 begin
			if($transaction_result===true){
				$mysql->db_query("commit");
			}else{
				$mysql->db_query("rollback");
			}
			return $transaction_result;
			//liukun add for bug 472 end
		}
	}

	/**
	 * 查看投标的信息
	 *
	 * @param Array $data
	 * @return Array
	 */
	public static function GetRepayment($data = array()){
		global $mysql;
		$id = $data['id'];
		$sql = "select * from {borrow}  where id=$id";
		$result = $mysql->db_fetch_array($sql);
		$data['account'] = $result['account'];
		$data['year_apr'] = $result['apr'];
		$data['month_times'] = $result['time_limit'];
		$data['borrow_time'] = $result['success_time'];
		$data['borrow_style'] = $result['style'];
		///add by weego for 天标
		$data['isday'] = $result['isday'];
		$data['time_limit_day'] = $result['time_limit_day'];
		return self::EqualInterest($data);
	}

	/**
	 * 查看投标的信息
	 *
	 * @param Array $data(user_id,id,status,remark)
	 * @return Array
	 */
	public static function AddRepayment($data = array()){
		global $mysql,$_G;

		$ws_fl_rate = isset($_G['system']['con_ws_fl_rate'])?$_G['system']['con_ws_fl_rate']:0.16;
		$point2account = isset($_G['system']['con_point2account'])?$_G['system']['con_point2account']:2.52;
		$con_connect_ws = isset($_G['system']['con_connect_ws'])?$_G['system']['con_connect_ws']:"0";

		$id = $data['id'];
		if ($id  =="") return self::ERROR;
		$status = $data['status'];

		$sql = "select * from {borrow}  where id=$id";
		$result = $mysql->db_fetch_array($sql);
		//保留borrow信息以备后用，减少不必要的查询
		$borrow_result = $result;
		if ($result['status'] ==3 || $result['status'] ==4){
			return "此标已经审核过或正在审核中，不能重复审核";
		}

		//liukun add for bug 472 begin
		$mysql->db_query("start transaction");
		//liukun add for bug 472 end
		$transaction_result=true;
		try {
			$sql = " update {borrow} set status='{$data['status']}' where id='{$id}'";
			$transaction_result = $mysql ->db_query($sql);
			if ($transaction_result !==true){
				throw new Exception();
			};
			/*if ($result['status']!=1){
			 return "此标已经审核过，不能再审核";
			}*/

			$user_id = $result['user_id'];
			$borrow_name = $result['name'];
			$borrow_account = $result['account'];
			$style = $result['style'];
			$award =$result['award'];
			$funds = $result['funds'];
			$is_vouch = $result['is_vouch'];//是否是担保标
			$vouch_award = $result['vouch_award'];//担保的奖励
			$part_account = $result['part_account'];
			$tender_times = $result['tender_times'];
			$month_times = $result['time_limit'];
			//add by weego 20120525
			$isday = $result['isday'];
			$time_limit_day = $result['time_limit_day'];

			$repayment_account  = $result['repayment_account'];
			$_data['account'] = $borrow_account;
			$_data['year_apr'] = $result['apr'];
			$_data['month_times'] = $month_times;
			$_data['borrow_time'] = $result['success_time'];
			$_data['borrow_style'] = $result['style'];

			$is_mb = $result['is_mb'];
			$is_fast = $result['is_fast'];
			$is_jin = $result['is_jin'];



			///add by weego for 天标
			$isday = $result['isday'];
			$time_limit_day = $result['time_limit_day'];
			$_data['isday'] = $result['isday'];
			$_data['time_limit_day'] = $result['time_limit_day'];

			// alpha add for bug 8   begin
			$is_zhouzhuan = $result['is_zhouzhuan'];
			// alpha add for bug 8   end

			// alpha add for bug 24  begin
			$is_restructuring = $result['is_restructuring'];
			// alpha add for bug 24  end

			$biao_type = $result['biao_type'];
			$classname = $borrow_result['biao_type']."biaoClass";
			$dynaBiaoClass = new $classname();






			//liukun add for bug 166 begin
			$ishappy = $borrow_result['ishappy'];
			//不管借款标是滞审核通过，都要先退回全部预先冻结的开心模式利息
			//退回开心模式冻结的发标人利息
			if($ishappy==1){
				$account_result =  accountClass::GetOne(array("user_id"=>$user_id));//获取当前用户的余额
				$freeze_happy_interest = round($borrow_result['account'] * $borrow_result['apr'] /100 /12 /30 * $borrow_result['valid_time'], 2);
				$log['user_id'] = $user_id;
				$log['type'] = "happy_interest_unfrost";
				$log['money'] = $freeze_happy_interest;
				$log['total'] = $account_result['total'];
				$log['use_money'] =  $account_result['use_money']+$log['money'];
				$log['no_use_money'] =  $account_result['no_use_money']-$log['money'];
				$log['collection'] =  $account_result['collection'];
				$log['to_user'] = 0;
				$log['remark'] = "开心模式时冻结的利息解冻";
				$transaction_result = accountClass::AddLog($log);//添加记录
				if ($transaction_result !==true){
					throw new Exception();
				};
			}
			//liukun add for bug 166 end


			$interest_result = self::EqualInterest($_data);
			$total_account = 0;
			$borrow_url = "<a href=\'/invest/a{$id}.html\' target=_blank>{$borrow_name}</a>";

			if ($status == 3){

				//如果成功，则将还款信息输进表里面去
				foreach ($interest_result as $key => $value){
					// 2012-06-14 修改还款时间 LiuYY
					$to_day = date("Y-m-d 23:59:59", $value['repayment_time']);
					$value['repayment_time'] = strtotime($to_day);

					$total_account = $total_account+$value['repayment_account'];//总还金额
					$sql = "insert into {borrow_repayment} set `addtime` = '".time()."',`addip` = '".ip_address()."',`borrow_id`='{$id}',`order`='{$key}',`repayment_time`='{$value['repayment_time']}',
					`repayment_account`='{$value['repayment_account']}',`interest`='{$value['interest']}',`capital`='{$value['capital']}'
					";

					$transaction_result = $mysql->db_query($sql);
					if ($transaction_result !==true){
						throw new Exception();
					};
					$repayment_account = $value['repayment_account'];
				}

				//扣除所有投资者的金钱。
				$sql = "select * from  {borrow_tender}   where borrow_id=$id";
				$result = $mysql->db_fetch_arrays($sql);
				foreach ($result as $key => $value){
					$account_result =  accountClass::GetOne(array("user_id"=>$value['user_id']));
					$log['user_id'] = $value['user_id'];
					$log['type'] = "invest";
					$log['money'] = $value['account'];
					$log['total'] = $account_result['total']-$log['money'];
					$log['use_money'] = $account_result['use_money'];
					$log['no_use_money'] = $account_result['no_use_money']-$log['money'];
					$log['collection'] = $account_result['collection'];
					$log['to_user'] = $user_id;
					$log['remark'] = "投标成功费用扣除";
					$transaction_result = accountClass::AddLog($log);
					if ($transaction_result !==true){
						throw new Exception();
					};


					//liukun add for bug 249 begin
					//liukun add for bug 267 begin
					$insurance = $value['insurance'];
					if ($insurance > 0){
						$post_data=array();
						$post_data['ID']=$account_result['ws_user_id'];
						$post_data['Money']=round($insurance / $ws_fl_rate * $point2account, 2);
						$post_data['MoneyType']=1;
						$post_data['Count']=1;
						//liukun add for bug 52 begin
						fb($post_data, FirePHP::TRACE);
						//liukun add for bug 52 end
						$ws_result = webService('C_Consume',$post_data);
						fb($ws_result, FirePHP::TRACE);
						if ($ws_result >= 1){

							$q_data['user_id'] = $value['user_id'];
							$q_data['ws_queue_id'] = $ws_result;
							$q_data['out_money'] = $insurance;
							$q_data['in_should_money'] = round($insurance / $ws_fl_rate, 2);
								

							$sql = "insert into  {return_queue}  set `addtime` = '".time()."',`addip` = '".ip_address()."'";
							foreach($q_data as $key => $q_value){
								$sql .= ",`$key` = '$q_value'";
							}
							$transaction_result =  $mysql->db_query($sql);
							if ($transaction_result !==true){
								throw new Exception();
							};

							$ws_log['user_id']=$value['user_id'];
							$ws_log['account']=$insurance;
							$ws_log['type']="insurance_fee";
							$ws_log['direction']="0";
							$ws_log['remark']="向webservice提交投资本金保障信息";
							$transaction_result = wsaccountClass::addWSlog($ws_log);
							if ($transaction_result !==true){
								throw new Exception();
							}
						}
						//扣除投资本金保障费
						$account_result =  accountClass::GetOne(array("user_id"=>$value['user_id']));
						$log['user_id'] = $value['user_id'];
						$log['type'] = "insurance";
						$log['money'] = $insurance;
						$log['total'] = $account_result['total']-$log['money'];
						$log['use_money'] = $account_result['use_money'];
						$log['no_use_money'] = $account_result['no_use_money']-$log['money'];
						$log['collection'] = $account_result['collection'];
						$log['to_user'] = 0;
						$log['remark'] = "缴纳本金保障费";
						$transaction_result = accountClass::AddLog($log);
						if ($transaction_result !==true){
							throw new Exception();
						};

							
					}

					//liukun add for bug 267 end
					//liukun add for bug 249 end


					//提醒设置
					$remind['nid'] = "loan_yes_account";
					$remind['sent_user'] = "0";
					$remind['receive_user'] = $value['user_id'];
					$remind['title'] = "[借出成功，扣除冻结款]恭喜您，你所投资的标[{$borrow_name}]满标审核成功.";
					$remind['content'] = "恭喜您，你所投资的标[<a href=\'/invest/a{$data['id']}.html\' target=_blank><font color=red>{$borrow_name}</font></a>]在".date("Y-m-d",time())."已经满标审核通过";
					$remind['type'] = "system";

					remindClass::sendRemind($remind);

					$credit['nid'] = "invest_success";
					$result = creditClass::GetTypeOne(array("nid"=>$credit['nid']));
					$credit['user_id'] = $value['user_id'];
					$credit['value'] = round($value['account']/100);
					$credit['op_user'] = $_G['user_id'];;
					$credit['op'] = 1;//增加
					$credit['type_id'] = $result['id'];
					$credit['remark'] = "投资成功加{$credit['value']}分";

					if($is_mb != 1){//秒标和天标不增加积分 jackfeng 2012 weego 20120525
						if($isday!=1){
							creditClass::UpdateCredit($credit);//更新积分
						}
					}
				}

				//liukun add for bug 73 begin
				//审核成功后，生成投资人的债权记录
				$sql = "select user_id as creditor_id, sum(account) total_tender from  {borrow_tender}   where borrow_id=$id group by user_id";
				$tender_result = $mysql->db_fetch_arrays($sql);
				foreach ($tender_result as $key => $value){
					//likun add for bug 75 begin
					$has_percent = $value['total_tender'] / $borrow_account *100;
					//likun add for bug 75 end
					//liukun add for bug 210 begin
					$sql = "select * from  {user_cache}   where user_id={$value['creditor_id']} ";
					$vip_result = $mysql->db_fetch_array($sql);
					//liukun add for bug 52 begin
					fb($vip_result, FirePHP::TRACE);
					//liukun add for bug 52 end
					$vip_status = $vip_result['vip_status'];
					fb($vip_status, FirePHP::TRACE);
					//liukun add for bug 210 end
					$sql = "insert into  {borrow_right}  set `addtime` = '".time()."',`addip` = '".ip_address()."',`borrow_id`='{$id}',`creditor_id`='{$value['creditor_id']}',`has_percent`='{$has_percent}',
					`status`=1,`valid_begin_time` = '".time()."', origin_creditor_level = {$vip_status}";

					//liukun add for bug

					$transaction_result = $mysql ->db_query($sql);
					if ($transaction_result !==true){
						throw new Exception();
					};

					//liukun add for bug 278 begin
					//计算用户的collection
					$total_collection = 0;
					foreach ($interest_result as $key => $_interest){
						//给客户计算收入的时候，为了防止出现给客户的总和大于借款人还款的总和，所以不使用4舍5入，而是使用floor，舍掉
						//因为PHP浮点数的特殊问题，当$has_percent为100时要特殊处理，不然floor后总是少一份，即使应该是刚好的值，比如128.14 * 100.00 / 100也总是会变成128.13
						if($has_percent == 100){
							$total_collection += $_interest['repayment_account'];
						}
						else{
							$total_collection += round (floor($_interest['repayment_account'] * $has_percent) / 100, 2);
						}

					}
					//添加待收的金额
					$account_result =  accountClass::GetOne(array("user_id"=>$value['creditor_id']));
					$log['user_id'] = $value['creditor_id'];
					$log['type'] = "collection";
					$log['money'] = $total_collection;
					$log['total'] = $account_result['total']+$log['money'];
					$log['use_money'] = $account_result['use_money'];
					$log['no_use_money'] = $account_result['no_use_money'];
					$log['collection'] = $account_result['collection']+$log['money'];
					$log['to_user'] = $user_id;
					$log['remark'] = "待收金额";
					$transaction_result = accountClass::AddLog($log);
					if ($transaction_result !==true){
						throw new Exception();
					};
					//liukun add for bug 278 end

				}
				//liukun add for bug 73 end


				//借款者总金额增加。
				$account_result =  accountClass::GetOne(array("user_id"=>$user_id));
				$borrow_log['user_id'] = $user_id;
				$borrow_log['type'] = "borrow_success";
				$borrow_log['money'] = $borrow_account;
				$borrow_log['total'] =$account_result['total']+$borrow_log['money'];
				$borrow_log['use_money'] = $account_result['use_money']+$borrow_log['money'];
				$borrow_log['no_use_money'] = $account_result['no_use_money'];
				$borrow_log['collection'] = $account_result['collection'];
				$borrow_log['to_user'] = "0";
				$borrow_log['remark'] = "通过[{$borrow_url}]借到的款";
				$transaction_result = accountClass::AddLog($borrow_log);
				if ($transaction_result !==true){
					throw new Exception();
				};

				//liukun add for bug 164 begin
				//冻结借款标的保证金10%。
				$frost_rate = $dynaBiaoClass->get_frost_rate();
				if ($frost_rate > 0){
					$account_result =  accountClass::GetOne(array("user_id"=>$user_id));
					$margin_log['user_id'] = $user_id;
					$margin_log['type'] = "margin";
					$margin_log['money'] =round($borrow_account*$frost_rate, 2);
					$margin_log['total'] = $account_result['total'];
					$margin_log['use_money'] = $account_result['use_money']-$margin_log['money'];
					$margin_log['no_use_money'] = $account_result['no_use_money']+$margin_log['money'];
					$margin_log['collection'] = $account_result['collection'];
					$margin_log['to_user'] = "0";
					$margin_log['remark'] = "冻结借款标的[{$borrow_url}]的保证金";
					$transaction_result = accountClass::AddLog($margin_log);
					if ($transaction_result !==true){
						throw new Exception();
					};
					//更新保证金
					$sql = "update  {borrow}  set forst_account='{$margin_log['money']}' where id='{$id}'";
					$transaction_result = $mysql -> db_query($sql);
					if ($transaction_result !==true){
						throw new Exception();
					};
				}
				//liukun add for bug 164 end

				$money = $dynaBiaoClass->getBorrowFee($borrow_result);
				//liukun add for bug 52 begin
				fb($money, FirePHP::TRACE);
				//liukun add for bug 52 end
				if ($money > 0){

					$account_result =  accountClass::GetOne(array("user_id"=>$user_id));
					$fee_log['user_id'] = $user_id;
					$fee_log['type'] = "borrow_fee";
					$fee_log['money'] = $money;
					$fee_log['total'] = $account_result['total']-$fee_log['money'];
					$fee_log['use_money'] = $account_result['use_money']-$fee_log['money'];
					$fee_log['no_use_money'] = $account_result['no_use_money'];
					$fee_log['collection'] = $account_result['collection'];
					$fee_log['to_user'] = "0";
					$fee_log['remark'] = "借款[{$borrow_url}]的手续费";

					$transaction_result = accountClass::AddLog($fee_log);
					if ($transaction_result !==true){
						throw new Exception();
					};
				}
				//借款成功加1分


				/*

				$credit['nid'] = "borrow_success";
				$result = creditClass::GetTypeOne(array("nid"=>$credit['nid']));
				$credit['user_id'] = $user_id;
				$credit['value'] = 1;
				$credit['op_user'] = $_G['user_id'];
				$credit['op'] = 1;//增加
				$credit['type_id'] = $result['id'];
				$credit['remark'] = "借款成功加1分";
				creditClass::UpdateCredit($credit);//更新积分
				*/


				//判断vip会员费是否扣除
				//accountClass::AccountVip(array("user_id"=>$user_id));

				//只有第一次借款的时候才扣除
				/*
				 $sql = "select p1.invite_userid,p1.invite_money,p2.username  from  {user}  as p1 left join  {user}  as p2 on p1.invite_userid = p2.user_id where p1.user_id = '{$user_id}' ";
				$result = $mysql ->db_fetch_array($sql);
				if ($result['invite_userid']!="" && $result['invite_money']!="" && $result['invite_money']<=0){
				//给介绍人提成
				$vip_ticheng = (!isset($_G['system']['con_vip_ticheng']) || $_G['system']['con_vip_ticheng']=="")?20:$_G['system']['con_vip_ticheng'];
				$account_result =  accountClass::GetOne(array("user_id"=>$result['invite_userid']));
				$ticheng_log['user_id'] = $result['invite_userid'];
				$ticheng_log['type'] = "ticheng";
				$ticheng_log['money'] = $vip_ticheng;
				$ticheng_log['total'] = $account_result['total']+$ticheng_log['money'];
				$ticheng_log['use_money'] = $account_result['use_money']+$ticheng_log['money'];
				$ticheng_log['no_use_money'] = $account_result['no_use_money'];
				$ticheng_log['collection'] = $account_result['collection'];
				$ticheng_log['to_user'] = "0";
				$ticheng_log['remark'] = "邀请用户注册(<a href=\'/u/{$result['invite_userid']}\' target=_blank>{$result['username']}</a>)成为VIP的提成";
				accountClass::AddLog($ticheng_log);
				$sql = "update  {user}  set invite_money=$vip_ticheng where user_id='{$user_id}'";
				$mysql -> db_query($sql);
				}
				*/

				//更新满标时的操作人
				$nowtime = time();
				//repair by weego 20120525 for 天标还款时间
				if($isday==1){
					$endtime=strtotime("$time_limit_day days",time());
				}else{
					$endtime = get_times(array("num"=>$month_times,"time"=>$nowtime));
				}

				if ($style==1){
					$_each_time = "每三个月后".date("d",$nowtime)."日";
				}else{
					$_each_time = "每月".date("d",$nowtime)."日";
				}
				$sql = " update {borrow} set success_time='{$nowtime}',end_time='{$endtime}',each_time='{$_each_time}',payment_account='{$repayment_account}' where id='{$id}'";
				$transaction_result = $mysql ->db_query($sql);
				if ($transaction_result !==true){
					throw new Exception();
				};

				//提醒设置
				$remind['nid'] = "borrow_review_yes";
				$remind['sent_user'] = "0";
				$remind['receive_user'] = $user_id;
				$remind['title'] = "恭喜您，你的借款标[{$borrow_name}]满标审核成功";
				$remind['content'] = "恭喜您，你的借款标[{$borrow_url}]在".date("Y-m-d",time())."已经审核通过";
				$remind['type'] = "system";
				remindClass::sendRemind($remind);

			}

			//满标审核失败
			elseif ($status == 4){
				//返回所有投资者的金钱。
				$ishappy = $borrow_result['ishappy'];
				$sql = "select * from {borrow_tender}  where borrow_id=$id";
				$result = $mysql->db_fetch_arrays($sql);
				$total_happy_interest = 0;
				foreach ($result as $key => $value){
					$account_result =  accountClass::GetOne(array("user_id"=>$value['user_id']));
					$log['user_id'] = $value['user_id'];
					$log['type'] = "invest_false";
					$log['money'] = $value['account'];
					$log['total'] = $account_result['total'];
					$log['use_money'] = $account_result['use_money']+$log['money'];
					$log['no_use_money'] = $account_result['no_use_money']-$log['money'];
					$log['collection'] = $account_result['collection'];
					$log['to_user'] = 0;
					$log['remark'] = "招标[{$borrow_url}]失败返回的投标额";
					$transaction_result = accountClass::AddLog($log);
					if ($transaction_result !==true){
						throw new Exception();
					};

					//审核失败解冻投资本金保障费
					$insurance = $value['insurance'];
					$account_result =  accountClass::GetOne(array("user_id"=>$value['user_id']));
					$log['user_id'] = $value['user_id'];
					$log['type'] = "insurance_unfrost";
					$log['money'] = $insurance;
					$log['total'] = $account_result['total'];
					$log['use_money'] = $account_result['use_money']+$log['money'];
					$log['no_use_money'] = $account_result['no_use_money']-$log['money'];
					$log['collection'] = $account_result['collection'];
					$log['to_user'] = 0;
					$log['remark'] = "解冻本金保障费";
					$transaction_result = accountClass::AddLog($log);
					if ($transaction_result !==true){
						throw new Exception();
					};

					//liukun add for bug 166 begin
					if($ishappy==1){
						$happy_interest = round($value['account'] * $borrow_result['apr'] /100 /12 /30 * ceil((time() - $value['addtime']) / 3600 / 24), 2);
						$total_happy_interest += $happy_interest;

						$account_result =  accountClass::GetOne(array("user_id"=>$value['user_id']));
						$log['user_id'] = $value['user_id'];
						$log['type'] = "interest_happy";
						$log['money'] = $happy_interest;
						$log['total'] = $account_result['total']+$log['money'];
						$log['use_money'] = $account_result['use_money']+$log['money'];
						$log['no_use_money'] = $account_result['no_use_money'];
						$log['collection'] = $account_result['collection'];
						$log['to_user'] = $user_id;
						$log['remark'] = "招标[{$borrow_url}]失败,开心模式得到的利息";
						$transaction_result = accountClass::AddLog($log);
						if ($transaction_result !==true){
							throw new Exception();
						};

					}
					//liukun add for bug 166 end

					//提醒设置
					$remind['nid'] = "loan_no_account";
					$remind['sent_user'] = "0";
					$remind['receive_user'] = $value['user_id'];
					$remind['title'] = "很遗憾，你所投资的标[{$borrow_name}]满标审核失败";
					$remind['content'] = "很遗憾，你所投资的标[<a href=\'/invest/a{$data['id']}.html\' target=_blank><font color=red>{$borrow_name}</font></a>]在".date("Y-m-d",time())."审核失败,失败原因：{$data['repayment_remark']}";
					$remind['type'] = "system";
					remindClass::sendRemind($remind);

				}

				//liukun add for bug 166 begin
				if($ishappy==1 && $total_happy_interest > 0){
					$account_result =  accountClass::GetOne(array("user_id"=>$user_id));
					$log['user_id'] = $user_id;
					$log['type'] = "interest_happy_pay";
					$log['money'] = $total_happy_interest;
					$log['total'] = $account_result['total']-$log['money'];
					$log['use_money'] = $account_result['use_money']-$log['money'];
					$log['no_use_money'] = $account_result['no_use_money'];
					$log['collection'] = $account_result['collection'];
					$log['to_user'] = 0;
					$log['remark'] = "招标[{$borrow_url}]失败,开心模式付出的利息";
					$transaction_result = accountClass::AddLog($log);
					if ($transaction_result !==true){
						throw new Exception();
					};
				}
				//liukun add for bug 166 end

				//提醒设置
				$remind['nid'] = "borrow_review_no";
				$remind['sent_user'] = "0";
				$remind['receive_user'] = $user_id;
				$remind['title'] = "很遗憾，您所申请的标[{$borrow_name}]满标审核失败";
				$remind['content'] = "很遗憾，您所申请的标[<a href=\'/invest/a{$data['id']}.html\' target=_blank><font color=red>{$borrow_name}</font></a>]在".date("Y-m-d",time())."审核失败,失败原因：{$data['repayment_remark']}";
				$remind['type'] = "system";
				remindClass::sendRemind($remind);
			}




			//如果有设置奖励并且招标成功，或者失败也奖励
			//liukun add for bug 165 begin
			//这里已经没有投标失败也奖励的逻辑了， 因为没有为$is_false设置值
			//liukun add for bug 165 begin

			if ($award==1 || $award==2){
				if ($status == 3 || $is_false==1){
					$sql = "select * from {borrow_tender}  where borrow_id=$id";
					$result = $mysql->db_fetch_arrays($sql);
					foreach ($result as $key => $value){
						//投标奖励扣除和增加。
						if ($award==1){
							$money = round(($value['account']/$borrow_account)*$part_account,2);
						}elseif ($award==2){
							$money = round((($funds/100)*$value['account']),2);
						}

						$account_result =  accountClass::GetOne(array("user_id"=>$value['user_id']));
						$log['user_id'] = $value['user_id'];
						$log['type'] = "award_add";
						$log['money'] = $money;
						$log['total'] = $account_result['total']+$money;
						$log['use_money'] = $account_result['use_money']+$money;
						$log['no_use_money'] = $account_result['no_use_money'];
						$log['collection'] = $account_result['collection'];
						$log['to_user'] = $user_id;
						$log['remark'] = "借款[{$borrow_url}]的奖励";
						$transaction_result = accountClass::AddLog($log);
						if ($transaction_result !==true){
							throw new Exception();
						};
						$account_result =  accountClass::GetOne(array("user_id"=>$user_id));
						$log['user_id'] = $user_id;
						$log['type'] = "award_lower";
						$log['money'] = $money;
						$log['total'] = $account_result['total']-$money;
						$log['use_money'] = $account_result['use_money']-$money;
						$log['no_use_money'] = $account_result['no_use_money'];
						$log['collection'] = $account_result['collection'];
						$log['to_user'] = $value['user_id'];
						$log['remark'] = "扣除借款[{$borrow_url}]的奖励";
						$transaction_result = accountClass::AddLog($log);
						if ($transaction_result !==true){
							throw new Exception();
						};
					}
				}
			}

			//更新满标时的操作人
			$sql = " update {borrow} set repayment_user='{$data['repayment_user']}',repayment_account='{$total_account}',repayment_remark='{$data['repayment_remark']}',repayment_time='".time()."',status='{$data['status']}' where id='{$id}'";
			$transaction_result = $mysql ->db_query($sql);
			if ($transaction_result !==true){
				throw new Exception();
			};
			//传入数据之前，要更新borrow_result
			$borrow_result['status'] = $data['status'];
			//把还款计划传入审核程序，因为有些审核流程需要根据还款计划中的值来计算
			$borrow_result['interest_result'] = $interest_result;
			$borrow_result['repayment_account'] = $total_account;
				
			$transaction_result = $dynaBiaoClass->full_verify($borrow_result);
			if ($transaction_result !==true){
				throw new Exception();
			};

		}
		catch(Exception $e){
			$mysql->db_query("rollback");
		}

		//liukun add for bug 472 begin
		if($transaction_result===true){
			$mysql->db_query("commit");
		}else{
			$mysql->db_query("rollback");
		}
		return $transaction_result;
		//liukun add for bug 472 end
	}


	public static function EqualInterest ($data = array()){
		if (isset($data['borrow_style']) && $data['borrow_style']!=""){
			$borrow_style = $data['borrow_style'];
		}else{
			$borrow_style = 0;
		}

		if ($borrow_style==0){
			return self::EqualMonth($data);
		}elseif ($borrow_style==1){
			return self::EqualSeason($data);
		}elseif ($borrow_style==2){
			return self::EqualEnd($data);
		}elseif ($borrow_style==3){
			return self::EqualEndMonth($data);
		}

	}

	//等额本息法
	//贷款本金×月利率×（1+月利率）还款月数/[（1+月利率）还款月数-1]
	//a*[i*(1+i)^n]/[(1+I)^n-1]
	//（a×i－b）×（1＋i）
	public static function EqualMonth ($data = array()){

		if (isset($data['account']) && $data['account']>0){
			$account = $data['account'];
		}else{
			return "";
		}

		if (isset($data['year_apr']) && $data['year_apr']>0){
			$year_apr = $data['year_apr'];
		}else{
			return "";
		}

		if (isset($data['month_times']) && $data['month_times']>0){
			$month_times = $data['month_times'];
		}
		if (isset($data['borrow_time']) && $data['borrow_time']>0){
			$borrow_time = $data['borrow_time'];
		}else{
			$borrow_time = time();
		}
		$month_apr = $year_apr/(12*100);
		//如果是天标 weego
		if($data['isday']==1){
			$month_apr=$month_apr*$data['time_limit_day']/30;
		}

		$_li = pow((1+$month_apr),$month_times);

		$repayment = @round($account * ($month_apr * $_li)/($_li-1),2);

		$_result = array();
		$totalRepaymentMoney = round($repayment*$month_times,2);
		if (isset($data['type']) && $data['type']=="all"){
			$_result['repayment_account'] = round($repayment*$month_times,2);
			$_result['monthly_repayment'] = round($repayment,2);
			$_result['month_apr'] = round($month_apr*100,2);

		}else{
			//$re_month = date("n",$borrow_time);

			for($i=0;$i<$month_times;$i++){
				if ($i==0){
					//liukun add for 0.01
					//$interest = round($account*$month_apr,3);
					$interest = round($account*$month_apr,2);
				}else{
					$_lu = pow((1+$month_apr),$i);
					//liukun add for 0.01
					//$interest = round(($account*$month_apr - $repayment)*$_lu + $repayment,3);
					$interest = round(($account*$month_apr - $repayment)*$_lu + $repayment,2);
				}
				$_result[$i]['repayment_account'] =  round($repayment,2); //月还款本息

				//repair by weego 20120525 for 天标还款时间
				if($data['isday']==1){
					$_result[$i]['repayment_time'] = strtotime("$data[time_limit_day] days",time());
				}else{
					$_result[$i]['repayment_time'] = get_times(array("time"=>$borrow_time,"num"=>$i+1));
				}

				$_result[$i]['interest'] = round($interest,2); //利息
				$_result[$i]['capital'] = round($repayment-$interest,2); //月还款本金
				//liukun add for bug 232 begin
				if (1==2){
					if($i==($month_times-1)){
						//0.01问题处理 weego 20120519
						$_result[$i]['repayment_account'] = $_result[$i]['capital']+$_result[$i]['interest'];
					}
				}
				//liukun add for bug 232 end
				$totalRepaymentMoney=round(($totalRepaymentMoney-$_result[$i]['repayment_account']),2);
				if($totalRepaymentMoney<0.1) {
					$totalRepaymentMoney=0;
				}
				$_result[$i]['totalRepaymentMoney'] = $totalRepaymentMoney; //余额
					
			}


		}
		//liukun add for bug 232 begin
		$_total_capital = 0;
		$_total_interest = 0;



		if ($month_times > 1){
			for($i=0;$i<$month_times-1;$i++){
				$_total_capital += $_result[$i]['capital'];
				$_total_interest += $_result[$i]['interest'];
			}
			//liukun add for bug 52 begin
			fb(round($repayment*$month_times,2), FirePHP::TRACE);
			fb($_total_capital, FirePHP::TRACE);
			fb($_total_interest, FirePHP::TRACE);
			fb($account, FirePHP::TRACE);
			//liukun add for bug 52 end
			$_result[$month_times-1]['capital'] = $account - $_total_capital;
			$_result[$month_times-1]['repayment_account'] = round($repayment*$month_times, 2) - $_total_capital - $_total_interest;
			$_result[$month_times-1]['interest'] = round($_result[$month_times-1]['repayment_account'] - $_result[$month_times-1]['capital'],2);

		}
		//liukun add for bug 232 end
		return $_result;
	}

	//按季等额本息法
	function EqualSeason ($data = array()){
			
		//借款的月数
		if (isset($data['month_times']) && $data['month_times']>0){
			$month_times = $data['month_times'];
		}

		//按季还款必须是季的倍数
		if ($month_times%3!=0){
			return false;
		}

		//借款的总金额
		if (isset($data['account']) && $data['account']>0){
			$account = $data['account'];
		}else{
			return "";
		}

		//借款的年利率
		if (isset($data['year_apr']) && $data['year_apr']>0){
			$year_apr = $data['year_apr'];
		}else{
			return "";
		}


		//借款的时间
		if (isset($data['borrow_time']) && $data['borrow_time']>0){
			$borrow_time = $data['borrow_time'];
		}else{
			$borrow_time = time();
		}

		//月利率
		$month_apr = $year_apr/(12*100);

		//得到总季数
		$_season = $month_times/3;

		//每季应还的本金
		$_season_money = round($account/$_season,2);

		//$re_month = date("n",$borrow_time);
		$_yes_account = 0 ;
		$repayment_account = 0;//总还款额
		for($i=0;$i<$month_times;$i++){
			$repay = $account - $_yes_account;//应还的金额

			$interest = round($repay*$month_apr,2);//利息等于应还金额乘月利率
			$repayment_account = $repayment_account+$interest;//总还款额+利息
			$capital = 0;
			if ($i%3==2){
				$capital = $_season_money;//本金只在第三个月还，本金等于借款金额除季度
				$_yes_account = $_yes_account+$capital;
				$repay = $account - $_yes_account;
				$repayment_account = $repayment_account+$capital;//总还款额+本金
			}

			$_result[$i]['repayment_account'] = $interest+$capital;
			$_result[$i]['repayment_time'] = get_times(array("time"=>$borrow_time,"num"=>$i+1));
			$_result[$i]['interest'] = $interest;
			$_result[$i]['capital'] = $capital;
		}
		if (isset($data['type']) && $data['type']=="all"){
			$_resul['repayment_account'] = $repayment_account;
			$_resul['monthly_repayment'] = round($repayment_account/$_season,2);
			$_resul['month_apr'] = round($month_apr*100,2);
			return $_resul;
		}else{
			return $_result;
		}
	}


	//到期付款
	function EqualEnd ($data = array()){
			
		//借款的月数
		if (isset($data['month_times']) && $data['month_times']>0){
			$month_times = $data['month_times'];
		}


		//借款的总金额
		if (isset($data['account']) && $data['account']>0){
			$account = $data['account'];
		}else{
			return "";
		}

		//借款的年利率
		if (isset($data['year_apr']) && $data['year_apr']>0){
			$year_apr = $data['year_apr'];
		}else{
			return "";
		}


		//借款的时间
		if (isset($data['borrow_time']) && $data['borrow_time']>0){
			$borrow_time = $data['borrow_time'];
		}else{
			$borrow_time = time();
		}

		//月利率
		$month_apr = $year_apr/(12*100);

		$interest = $month_apr*$month_times*$account;
		if (isset($data['type']) && $data['type']=="all"){
			$_resul['repayment_account'] = $account+$interest;
			$_resul['monthly_repayment'] = $account+$interest;
			$_resul['month_apr'] = $month_apr;
			return $_resul;
		}else{
			$_result[0]['repayment_account'] = $account+$interest;
			$_result[0]['repayment_time'] = get_times(array("time"=>$borrow_time,"num"=>$month_times));
			$_result[0]['interest'] = $interest;
			$_result[0]['capital'] = $account;
			return $_result;
		}
	}


	//到期还本，按月付息
	function EqualEndMonth ($data = array()){
			
		//借款的月数
		if (isset($data['month_times']) && $data['month_times']>0){
			$month_times = $data['month_times'];
		}

		//借款的总金额
		if (isset($data['account']) && $data['account']>0){
			$account = $data['account'];
		}else{
			return "";
		}

		//借款的年利率
		if (isset($data['year_apr']) && $data['year_apr']>0){
			$year_apr = $data['year_apr'];
		}else{
			return "";
		}


		//借款的时间
		if (isset($data['borrow_time']) && $data['borrow_time']>0){
			$borrow_time = $data['borrow_time'];
		}else{
			$borrow_time = time();
		}

		//月利率
		$month_apr = $year_apr/(12*100);



		//$re_month = date("n",$borrow_time);
		$_yes_account = 0 ;
		$repayment_account = 0;//总还款额

		$interest = round($account*$month_apr,2);//利息等于应还金额乘月利率
		for($i=0;$i<$month_times;$i++){
			$capital = 0;
			if ($i+1 == $month_times){
				$capital = $account;//本金只在第三个月还，本金等于借款金额除季度
			}

			$_result[$i]['repayment_account'] = $interest+$capital;
			$_result[$i]['repayment_time'] = get_times(array("time"=>$borrow_time,"num"=>$i+1));
			$_result[$i]['interest'] = $interest;
			$_result[$i]['capital'] = $capital;
				
			//liukun add for 只是为了工具箱页面计算还款余额而临时增加
			$_result[$i]['totalRepaymentMoney'] = ($account + $interest * $month_times) - ($interest * ($i + 1)) -$capital; //余额
		}
		if (isset($data['type']) && $data['type']=="all"){
			$_resul['repayment_account'] = $account + $interest*$month_times;
			$_resul['monthly_repayment'] = $interest;
			$_resul['month_apr'] = round($month_apr*100,2);
			return $_resul;
		}else{
			return $_result;
		}
	}


	//获取待还总额
	//用户id
	function GetWaitPayment($data){
		global $mysql;
		//待还总额
		$user_id= $data['user_id'];
		$sql = "select status,count(1) as repay_num,sum(repayment_account) as borrow_num ,sum(capital) as capital_num ,sum(repayment_yesaccount) as borrow_yesnum from  {borrow_repayment}  where borrow_id in (select id from  {borrow}  where user_id = {$user_id} and status=3) group by status ";
		$result = $mysql -> db_fetch_arrays($sql);
		$_result['wait_payment'] = $_result['borrow_yesnum'] = 0;
		foreach ($result as $key => $value){
			if ($value['status']==0 ){
				$_result['borrow_num0'] = $value['borrow_num'];
				$_result['borrow_capital_num0'] +=$value['capital_num'];//借款的金额
				$_result['borrow_repay0'] = $value['repay_num'];
			}elseif ($value['status']==2){//网站代还
				$_result['borrow_yesnum'] = $value['borrow_yesnum'];
				$_result['borrow_num2'] = $value['borrow_num'];
			}elseif ($value['status']==1){
				$_result['borrow_yesnum'] = $value['borrow_yesnum'];
				$_result['borrow_num1'] = round($value['borrow_num'],2);
			}
			$_result['borrow_capital_num'] +=$value['capital_num'];//借款的金额
		}
		$_result['wait_payment'] = $_result['borrow_num0']+$_result['borrow_num2'];//待还金额
		$_result['borrow_num'] =$_result['borrow_num0']+$_result['borrow_num1']+$_result['borrow_num2'];//借款总额
		$_result['use_amount'] = $_result['amount']-$_result['wait_payment'];//可用额度
		return $_result;

	}

	//取最佳提现金额值
	function GetCashGoodAmount($data){
		global $mysql,$_G;
		$user_id = $data['user_id'];

		$sql = "select total,use_money,collection from  {account}  where  user_id = '{$user_id}'";

		$result = $mysql->db_fetch_array($sql);
		$use_money = $result['use_money'];//可用余额
		$collection = $result['collection'];//待收金额
		$total = $result['total'];//待收金额

		//wait_payment
		$_result_wait = self::GetWaitPayment(array("user_id"=>$user_id));
		$wait_payment = $_result_wait["wait_payment"];//待还金额
		$jinAmount = $total - $wait_payment;

		//echo "净：".$jinAmount;
		//15天内的充值总值
		$dayTimeD=time()-15*86400;//15天前;
		$sql = "select sum(money) as num from  {account_recharge}  where user_id = '{$user_id}' and status=1 and addtime>".$dayTimeD;
		$result = $mysql->db_fetch_arrays($sql);
		//$cashRecDays=$result["num"];
		foreach ($result as $key => $value){
			$cashRecDays=$value["num"];
		}
		//echo "15天内的充值总值：".$cashRecDays;
		//15天内的信用还款额度
		$sql = "select sum(account) as num from  {user_amountlog}  where user_id = '{$user_id}' and amount_type='credit' and type='borrrow_repay' and addtime>".$dayTimeD;
		$result = $mysql->db_fetch_arrays($sql);
		//$cashRecDays=$result["num"];
		foreach ($result as $key => $value){
			$cashRepayDays=$value["num"];
		}
		//echo "15天内的信用还款额度：".$cashRepayDays;
		//已使用的信用额度
		$sql = "select credit,credit_use from  {user_amount}  where  user_id = {$user_id}";
			
		$result = $mysql->db_fetch_arrays($sql);
		foreach ($result as $key => $value){
			$credit_use=$value["credit"] - $value["credit_use"] ;//已使用的信用额度
		}
		// echo "已使用的信用额度：".$credit_use;
			


		// add by alpha for bug 12 begin 修改可提现金额
		// $yValue=$jinAmount - $cashRecDays + $credit_use*1.1 + $cashRepayDays;
			
		$sql = "select nocash_money from  {account}  where user_id = '{$user_id}' ";
		$result = $mysql->db_fetch_arrays($sql);
		//$cashRecDays=$result["num"];
		foreach ($result as $key => $value){
			$nocash_money=$value["nocash_money"];
		}
		$yValue=$jinAmount - $cashRecDays  + 1.1*$credit_use + $cashRepayDays - $nocash_money;
		// add by alpha for bug 12 end
			
		//if($yValue>50000){
		//$yValue=50000;
		//}
			
		//正在申请的提现
		$sql = "select sum(total) as num from  {account_cash}  where status=0 and user_id = '{$user_id}'";
		$result = $mysql->db_fetch_arrays($sql);
		//$cashRecDays=$result["num"];
		foreach ($result as $key => $value){
			$cashAmountV=$value["num"];
		}
		//echo "正在申请的提现：".$cashAmountV;
			
		// exit;
			
		$result=array();
		$yValueTmp = $yValue-$cashAmountV;
		if($yValueTmp<0) $yValueTmp=0;
		if($yValueTmp>$use_money) $yValueTmp=$use_money;
			
		$result["yValue"]=$yValueTmp;
		$result["txValue"]=$cashAmountV;
			
		return $result;
			
	}
	
	function GetCashMaxAmount($data){
		global $mysql,$_G;
		$user_id = $data['user_id'];
	
		$sql = "select * from  {account}  where  user_id = '{$user_id}'";
	
		$result = $mysql->db_fetch_array($sql);
		$use_money = $result['use_money'];//可用余额
		$nocash_money=$result["nocash_money"];
		$used_award = $result["award"] - $result["use_award"];
	
// 		//当天充值金额
// 		$today = strtotime(date("Y-m-d 00:00:00", time()));
// 		//根据开关决定
		
		
// 		$sql = "select sum(money) as num from  {account_recharge}  where user_id = '{$user_id}' and status=1 and addtime>".$today;
// 		$result = $mysql->db_fetch_array($sql);
		
// 		$cashToday=$result["num"];

		// add by alpha for bug 12 begin 修改可提现金额
		// $yValue=$jinAmount - $cashRecDays + $credit_use*1.1 + $cashRepayDays;
			
		
		$maxCashAmount=$use_money - $nocash_money - $used_award;
		// add by alpha for bug 12 end

		//正在申请的提现
		$sql = "select sum(total) as num from  {account_cash}  where status=0 and user_id = '{$user_id}'";
		$result = $mysql->db_fetch_array($sql);
		$cashingAmount=$value["num"];
		
		$result["use_money"]=$use_money;
		$result["nocash_money"]=$nocash_money;
		$result["used_award"]=$used_award;
		$result["maxCashAmount"]=$maxCashAmount;
		$result["cashingAmount"]=$cashingAmount;
			
		return $result;
			
	}	

	function GetCashFeeAmount_drop($data){
		global $mysql,$_G;
		$user_id = $data['user_id'];
		$cashAmount = $data['cashAmount'];//提现总额
		//****************************************
		/*
		 三个变量x,y,z
		x代表提现金额 y代表现在净资产减15天内的充值总值z代表提现手续费
		1.  0≤
		x ≤1500
		无论y为何值    z=0.002x


		2.  y≥x
		1500<x ≤30000     z=3
		30000<x ≤50000    z=5

		3. y <x
		1500<y ≤30000     z=3+(x-y)0.002
		30000<y ≤50000    z=5+(x-y)0.002
		*/
		//计算净资产=use_money + collection - wait_payment=可用余额+待收-待还
		$sql = "select * from  {account}  where  user_id = '{$user_id}'";

		$result = $mysql->db_fetch_array($sql);
		$use_money = $result['use_money'];//可用余额
		$collection = $result['collection'];//待收金额
		$total = $result['total'];//待收金额
		/*
		 if ($result!=false){
		foreach ($result as $key => $value){
		$use_money = $value['use_money'];//可用余额
		$collection = $value['collection'];//待收金额
		}
		}*/

		//wait_payment
		$_result_wait = self::GetWaitPayment(array("user_id"=>$user_id));
		$wait_payment = $_result_wait["wait_payment"];//待还金额
		$jinAmount = $total - $wait_payment;

		//15天内的充值总值
		$dayTimeD=time()-15*86400;//15天前;
		$sql = "select sum(money) as num from  {account_recharge}  where user_id = '{$user_id}' and status=1 and addtime>".$dayTimeD;
		$result = $mysql->db_fetch_arrays($sql);
		//$cashRecDays=$result["num"];
		foreach ($result as $key => $value){
			$cashRecDays=$value["num"];
		}
			
			
		//15天内的信用还款总额
		$sql = "select sum(account) as num from  {user_amountlog}  where user_id = '{$user_id}' and amount_type='credit' and type='borrrow_repay' and addtime>".$dayTimeD;
		$result = $mysql->db_fetch_arrays($sql);
		//$cashRecDays=$result["num"];
		foreach ($result as $key => $value){
			$cashRepayDays=$value["num"];
		}

		//正在申请的提现
		$sql = "select sum(total) as num from  {account_cash}  where status=0 and user_id = '{$user_id}'";
		$result = $mysql->db_fetch_arrays($sql);
		//$cashRecDays=$result["num"];
		foreach ($result as $key => $value){
			$cashAmountV=$value["num"];
		}
			
		//已使用的信用额度
		$sql = "select (credit-credit_use)  as num from  {user_amount}  where  user_id = '{$user_id}'";
		$result = $mysql->db_fetch_arrays($sql);
		foreach ($result as $key => $value){
			$credit_use=$value["num"];//已使用的信用额度
		}
			
		// add by alpha for bug 12 begin 修改可提现金额
		//$yValue=$jinAmount - $cashRecDays - $cashAmountV + 1.1*$credit_use + $cashRepayDays;
			
		$sql = "select nocash_money from  {account}  where user_id = '{$user_id}' ";
		$result = $mysql->db_fetch_arrays($sql);
		//$cashRecDays=$result["num"];
		foreach ($result as $key => $value){
			$nocash_money=$value["nocash_money"];
		}
		$yValue=$jinAmount - $cashRecDays - $cashAmountV + 1.1*$credit_use + $cashRepayDays - $nocash_money;
		// add by alpha for bug 12 end
			
		//1)x ≤1500 无论y为何值    z=0.002x
		if($cashAmount<=1500 || $yValue<=1500){
			$caseFee = 0.002*$cashAmount;
		}elseif($yValue >= $cashAmount){
			if($cashAmount>1500 && $cashAmount<=30000){
				$caseFee=3;
			}else{
				$caseFee=5;
			}
		}elseif($yValue < $cashAmount){
			if($yValue>1500 && $yValue<=30000){
				$caseFee=3+($cashAmount-$yValue)*0.002;
			}else{
				$caseFee=5+($cashAmount-$yValue)*0.002;
			}
		}
		
		
		return $caseFee;
			
	}
	
	function GetCashFeeAmount($data){
		global $mysql,$_G;
		$cash_recharge_day = isset($_G['system']['con_cash_recharge_day'])?$_G['system']['con_cash_recharge_day']:15;//开始的最低额度
		$cash_fee_recharge_tender = isset($_G['system']['con_cash_fee_recharge_tender'])?$_G['system']['con_cash_fee_recharge_tender']:0.002;//开始的最低额度
		$cash_fee_rechage_notender = isset($_G['system']['con_cash_fee_rechage_notender'])?$_G['system']['con_cash_fee_rechage_notender']:0.005;//开始的最低额度
		$cash_fee_out_recharge_rule = isset($_G['system']['con_cash_fee_out_recharge_rule'])?$_G['system']['con_cash_fee_out_recharge_rule']:'[{"begin":100,"end":30000,"fee":8},{"begin":30000.01,"end":50000,"fee":10}]';//开始的最低额度
		
		
		$user_id = $data['user_id'];
		$cashAmount = $data['cashAmount'];//提现总额
		
		$sql = "select * from  {account}  where  user_id = '{$user_id}'";
	
		$result = $mysql->db_fetch_array($sql);
		$use_money = $result['use_money'];//可用余额

		
		//15天内的充值总值
		//今天的第1秒
		$today = strtotime(date("Y-m-d 00:00:00", time()));
		//向前14天，那一秒开始算做15天以内
		$day15=$today-($cash_recharge_day - 1)*86400;//15天前;
		
		
		$sql = "select sum(money) as num from  {account_recharge}  where user_id = '{$user_id}' and status=1 and addtime>".$day15;
		$result = $mysql->db_fetch_array($sql);
		$recharge_total = $result['num'];
		
		//如果15天以内有过充值，那要判断是否投过标
		//投过任何标，担保，购买流转，购买债权
		//计算投标金额
		$sql = "select sum(account) as num from  {borrow_tender}  bt,  {borrow}   bw
				where bt.borrow_id = bw.id
				and bt.user_id = '{$user_id}' and bw.status=3 and bt.addtime>".$day15;
		$result = $mysql->db_fetch_array($sql);
		$tender_total = $result['num'];
		
		//计算担保金额
		$sql = "select sum(vouch_collection) as num from   {borrow_vouch}  bv,  {borrow}   bw
				where bv.borrow_id = bw.id
				and bv.user_id = '{$user_id}' and bw.status=3 and bt.addtime>".$day15;
		$result = $mysql->db_fetch_array($sql);
		$vouch_total = $result['num'];
		
		//计算购买的流转标
		$sql = "select sum(capital) as num from  {circulation_buy_serial}  
				where buyer_id = '{$user_id}' and buy_type='account' and addtime>".$day15;
		$result = $mysql->db_fetch_array($sql);
		$purchase_total = $result['num'];
		
		//计算购买的债权
		$sql = "select sum(ba.unit * bs.unit_num) as num from  {borrow_right_alienate_serial}  bs,  {borrow_right_alienate}  ba
				where bs.right_alienate_id = ba.id 
				and bs.buyer_id = '{$user_id}' and bs.addtime>".$day15;
		$result = $mysql->db_fetch_array($sql);
		$buy_right_total = $result['num'];
		
		//15内充值 只要投标的行为发生 提现 0.2% 没有投标 0.5% 15天后  不管是否投标提现3万元一下3元/笔，3-5万5元/笔
		//15天以内充过值
		if ($recharge_total > 0){
			//如果有过投资
			if(($tender_total + $vouch_total + $purchase_total +$buy_right_total) > 0){
				$fee = round($cashAmount * $cash_fee_recharge_tender, 2);
			}else{
				$fee = round($cashAmount * $cash_fee_rechage_notender, 2);
			}
		}else{
			$fee_array = json_decode($cash_fee_out_recharge_rule, true);
			//liukun add for bug 52 begin
			fb($fee_array, FirePHP::TRACE);
			//liukun add for bug 52 end
			foreach ($fee_array as $key => $value){
				if($value['begin'] <= $cashAmount && $value['end'] >= $cashAmount){
					$fee = $value['fee'];
				}
			}
		}
		
		return $fee;
	}

	//已成功的借款
	function GetBorrowSucces($data){
		global $mysql,$_G;
			
		$user_id =$data['user_id'];
		$page = empty($data['page'])?1:$data['page'];
		$epage = empty($data['epage'])?10:$data['epage'];
		$_sql = "";
		if (isset($data['type']) && $data['type']!=""){
			if ($data['type']=="wait"){
				$_sql = " and bo.repayment_yesaccount!=bo.repayment_account";
			}elseif ($data['type']=="yes"){
				$_sql = " and bo.repayment_yesaccount=bo.repayment_account ";
			}
		}

		if (isset($data['dotime1']) && $data['dotime1']!=""){
			$dotime1 = ($data['dotime1']=="request")?$_REQUEST['dotime1']:$data['dotime1'];
			if( !isTimePattern($dotime1))$dotime1 = "";
			if ($dotime1!=""){
				$_sql .= " and bt.addtime >= ".get_mktime($dotime1);
			}
		}

		if (isset($data['dotime2']) && $data['dotime2']!=""){
			$dotime2 = ($data['dotime2']=="request")?$_REQUEST['dotime2']:$data['dotime2'];
			if( !isTimePattern($dotime2))$dotime2 = "";
			if ($dotime2!=""){
				$_sql .= " and bt.addtime <= ".get_mktime($dotime2);
			}
		}

		if (isset($data['keywords']) && $data['keywords']!=""){
			$keywords = ($data['keywords']=="request")?$_REQUEST['keywords']:$data['keywords'];
			if ($keywords!=""){
				$_sql .= " and bo.name like'%".safegl($keywords)."%'";
			}
		}




		$_select  = "bo.*, round((floor((bo.repayment_account - bo.repayment_yesaccount) * br.has_percent) / 100),2) right_account ,bo.name as borrow_name, u.username,cr.value as credit,bo.id ";
		$sql = "select SELECT from  {borrow}  as bo, {borrow_right}  as br, {user}  as u, {credit}  as cr where br.creditor_id={$user_id}
		and bo.user_id=u.user_id  and cr.user_id=bo.user_id and br.borrow_id=bo.id and bo.status=3 and br.status = 1 {$_sql} order by bo.id desc";
		//是否显示全部的信息
		if (isset($data['limit']) ){
			$_limit = "";
			if ($data['limit'] != "all"){
				$_limit = "  limit ".$data['limit'];
			}
			return $mysql->db_fetch_arrays(str_replace(array('SELECT', 'ORDER', 'LIMIT'), array($_select,  'order by p1.id desc', $_limit), $sql));
		}

		$row = $mysql->db_fetch_array(str_replace(array('SELECT', 'ORDER', 'LIMIT'), array("count(*) as  num","",""),$sql));

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

	//liukun add from bug 21 begin
	//获取自己可以转让的债权列表
	function GetRightCanAlienate($data){
		global $mysql,$_G;
			
		$user_id =$data['user_id'];
		$page = empty($data['page'])?1:$data['page'];
		$epage = empty($data['epage'])?10:$data['epage'];
		$_sql = "";


		if (isset($data['dotime1']) && $data['dotime1']!=""){
			$dotime1 = ($data['dotime1']=="request")?$_REQUEST['dotime1']:$data['dotime1'];
			if( !isTimePattern($dotime1))$dotime1 = "";
			if ($dotime1!=""){
				$_sql .= " and bo.addtime >= ".get_mktime($dotime1);
			}
		}

		if (isset($data['dotime2']) && $data['dotime2']!=""){
			$dotime2 = ($data['dotime2']=="request")?$_REQUEST['dotime2']:$data['dotime2'];
			if( !isTimePattern($dotime2))$dotime2 = "";
			if ($dotime2!=""){
				$_sql .= " and bo.addtime <= ".get_mktime($dotime2);
			}
		}

		if (isset($data['keywords']) && $data['keywords']!=""){
			$keywords = ($data['keywords']=="request")?$_REQUEST['keywords']:$data['keywords'];
			if ($keywords!=""){
				$_sql .= " and bo.name like'%".safegl($keywords)."%'";
			}
		}

		//$_select  = "bt.repayment_yesaccount,bt.repayment_account,bt.addtime as tender_time,bt.account as anum,bt.repayment_account  - bt.account as inter,bo.name as borrow_name,bo.account,bo.time_limit,bo.isday,bo.time_limit_day,bo.apr,u.username,cr.value as credit,bo.id ";
		//$sql = "select SELECT from  {borrow_tender}  as bt, {borrow}  as bo, {user}  as u, {credit}  as cr where bt.user_id={$user_id} and bo.user_id=u.user_id  and cr.user_id=bo.user_id and bt.borrow_id=bo.id and bo.status=3 {$_sql} order by bo.id desc";
		//浮点数大小判断 为0是表示大于0.01
		//liukun add for bug 23
		$_select= "bo.*, bo.name borrow_name, round((bo.repayment_account - bo.repayment_yesaccount) * br.has_percent / 100,2) as has_right, round(br.has_percent, 2) has_percent, br.id as borrow_right_id, br.origin_creditor_level, ur.username, (bo.repayment_account - bo.repayment_yesaccount) as needrepayment";
		$sql = "select SELECT from  {borrow}  as bo,  {borrow_right}  as br,   {user}  as ur where bo.id = br.borrow_id and bo.user_id = ur.user_id and br.creditor_id = {$user_id} and bo.status = 3 and  ((bo.repayment_account + 0) >  bo.repayment_yesaccount)  and br.status =1 {$_sql} order by bo.id desc";
		$sql_num = "select SELECT from  {borrow}  as bo,  {borrow_right}  as br,   {user}  as ur where bo.id = br.borrow_id and bo.user_id = ur.user_id and br.creditor_id = {$user_id} and bo.status = 3 and ((bo.repayment_account + 0) >  bo.repayment_yesaccount) and br.status = 1 {$_sql} ";


		//是否显示全部的信息
		if (isset($data['limit']) ){
			$_limit = "";
			if ($data['limit'] != "all"){
				$_limit = "  limit ".$data['limit'];
			}
			return $mysql->db_fetch_arrays(str_replace(array('SELECT', 'ORDER', 'LIMIT'), array($_select,  'order by br.id desc', $_limit), $sql));
		}

		$row = $mysql->db_fetch_array(str_replace(array('SELECT', 'ORDER', 'LIMIT'), array("count(br.id) as  num","",""),$sql_num));

		$total = $row['num'];
		$total_page = ceil($total / $epage);
		$index = $epage * ($page - 1);
		$limit = " limit {$index}, {$epage}";

		$list = $mysql->db_fetch_arrays(str_replace(array('SELECT', 'ORDER', 'LIMIT'), array($_select, 'order by br.id desc', $limit), $sql));
		$list = $list?$list:array();
		return array(
				'list' => $list,
				'total' => $total,
				'page' => $page,
				'epage' => $epage,
				'total_page' => $total_page
		);
	}
	//liukun add from bug 21 end

	//收款明细
	function GetCollectionList($data){
		global $mysql,$_G;
		$_sql = " ";
		$__sql = " ";
		if (isset($data['user_id']) && $data['user_id']!="" ){
			$__sql .= " where user_id={$data['user_id']}";
		}
		if (isset($data['status']) && $data['status']!="" ){
			$_sql .= " and p1.status={$data['status']}";
		}
		if (isset($data['borrow_status']) && $data['borrow_status']!="" ){
			$_sql .= " and p3.status={$data['borrow_status']}";
		}
		if (isset($data['username']) && $data['username']!="" ){
			$_sql .= " and p4.username like '%{$data['username']}%' ";
		}
		//liukun add fro bug 21 begin
		if (isset($data['borrow_id']) && $data['borrow_id']!="" ){
			$_sql .= " and p2.borrow_id={$data['borrow_id']}";
		}
		//liukun add fro bug 21 end


		if (isset($data['dotime1']) && $data['dotime1']!=""){
			$dotime1 = ($data['dotime1']=="request")?$_REQUEST['dotime1']:$data['dotime1'];
			if( !isTimePattern($dotime1))$dotime1 = "";
			if ($dotime1!=""){
				$_sql .= " and p1.repay_time >= ".get_mktime($dotime1);
			}
		}

		if (isset($data['dotime2']) && $data['dotime2']!=""){
			$dotime2 = ($data['dotime2']=="request")?$_REQUEST['dotime2']:$data['dotime2'];
			if( !isTimePattern($dotime2))$dotime2 = "";
			if ($dotime2!=""){
				$_sql .= " and p1.repay_time <= ".get_mktime($dotime2);
			}
		}

		if (isset($data['keywords']) && $data['keywords']!=""){
			$keywords = ($data['keywords']=="request")?$_REQUEST['keywords']:$data['keywords'];
			if ($keywords!=""){
				$_sql .= " and p3.name like'%".safegl($keywords)."%'";
			}
		}

		$page = empty($data['page'])?1:$data['page'];
		$epage = empty($data['epage'])?10:$data['epage'];
		/*
		 $_select = 'p1.*,p3.name as borrow_name,p3.id as borrow_id,p3.time_limit,p4.username ';
		$sql = "select SELECT from  {borrow_collection}  as p1
		left join  {borrow_tender}  as p2 on  p1.tender_id = p2.id
		left join  {borrow}  as p3 on  p3.id = p2.borrow_id
		left join  {user}  as p4 on  p4.user_id = p3.user_id
		where p3.status=3  and p3.id in (select borrow_id from  {borrow_tender}  {$__sql})
		$_sql ORDER LIMIT";
		*/


		$_select = 'p1.*,p3.name as borrow_name,p3.id as borrow_id,p3.time_limit,p4.username ';
		$_order = " order by p1.id ";
		//$data['order']="order";
		if (isset($data['order']) && $data['order']!="" ){
			if ($data['order'] == "repay_time"){
				$_order = " order by p1.repay_time asc ";
			}elseif ($data['order'] == "order"){
				$_order = " order by p1.`order` desc,p1.id desc ";
			}
		}
		$sql = "select SELECT from  {borrow_collection}  as p1
		left join  {borrow_tender}  as p2 on  p1.tender_id = p2.id
		left join  {borrow}  as p3 on  p3.id = p2.borrow_id
		left join  {user}  as p4 on  p4.user_id = p3.user_id
		where p1.tender_id in (select id from  {borrow_tender} {$__sql})
		{$_sql} ORDER LIMIT";
			
		//是否显示全部的信息
		if (isset($data['limit']) ){
			$_limit = "";
			if ($data['limit'] != "all"){
				$_limit = "  limit ".$data['limit'];
			}
			$list  = $mysql->db_fetch_arrays(str_replace(array('SELECT', 'ORDER', 'LIMIT'), array($_select,  $_order, $_limit), $sql));
			foreach ($list as $key => $value){
				//*******
				$borrow_result = self::GetOne(array("id"=>$value['borrow_id']));//获取借款标的单独信息
				if($borrow_result['is_fast']==1){
					$late = self::LateInterestFast(array("repayment_time"=>$value['repay_time'],"account"=>$value['capital']));
				}else{
					$late = self::LateInterest(array("repayment_time"=>$value['repay_time'],"account"=>$value['capital']));
				}

				if ($value['status']!=1){
					$list[$key]['late_days'] = $late['late_days'];
					if($borrow_result['is_fast']==1){
						$list[$key]['late_interest'] = round($late['late_interest'],2);
					}else{
						if ($late['late_days']>30){
							$list[$key]['late_interest'] = 0;
						}else{
							$list[$key]['late_interest'] = round($late['late_interest']/2,2);
						}
					}

				}else{
					$list[$key]['late_interest'] = 0;
					$list[$key]['late_days'] = 0;
				}
			}
			return $list;
		}

		$row = $mysql->db_fetch_array(str_replace(array('SELECT', 'ORDER', 'LIMIT'), array(" count(*) as num ","",""),$sql));

		$total = $row['num'];
		$total_page = ceil($total / $epage);
		$index = $epage * ($page - 1);
		$limit = " limit {$index}, {$epage}";

		$list = $mysql->db_fetch_arrays(str_replace(array('SELECT', 'ORDER', 'LIMIT'), array($_select, $_order , $limit), $sql));
		$list = $list?$list:array();
		foreach ($list as $key => $value){
			$borrow_result = self::GetOne(array("id"=>$value['borrow_id']));//获取借款标的单独信息
			if($borrow_result['is_fast']==1){
				$late = self::LateInterestFast(array("repayment_time"=>$value['repay_time'],"account"=>$value['capital']));
			}else{
				$late = self::LateInterest(array("repayment_time"=>$value['repay_time'],"account"=>$value['capital']));
			}
			if ($value['status']!=1){
				$list[$key]['late_days'] = $late['late_days'];
				if($borrow_result['is_fast']==1){
					$list[$key]['late_interest'] = round($late['late_interest'],2);
				}else{
					if ($late['late_days']>30){
						$list[$key]['late_interest'] = 0;
					}else{
						$list[$key]['late_interest'] = round($late['late_interest']/2,2);
					}

				}
			}else{
				$list[$key]['late_interest'] = 0;
				$list[$key]['late_days'] = 0;
			}
		}
		return array(
				'list' => $list,
				'total' => $total,
				'page' => $page,
				'epage' => $epage,
				'total_page' => $total_page
		);
	}

	//已收款列表
	function GetCollectionedList($data){
		global $mysql,$_G;
		$_sql = " ";
		$__sql = " ";
		if (isset($data['user_id']) && $data['user_id']!="" ){
			$__sql .= " where creditor_id={$data['user_id']}";
		}
		if (isset($data['status']) && $data['status']!="" ){
			$_sql .= " and p1.status={$data['status']}";
		}
		if (isset($data['borrow_status']) && $data['borrow_status']!="" ){
			$_sql .= " and p3.status={$data['borrow_status']}";
		}
		if (isset($data['username']) && $data['username']!="" ){
			$_sql .= " and p4.username like '%{$data['username']}%' ";
		}
		//liukun add fro bug 21 begin
		if (isset($data['borrow_id']) && $data['borrow_id']!="" ){
			$_sql .= " and p2.borrow_id={$data['borrow_id']}";
		}
		//liukun add fro bug 21 end


		if (isset($data['dotime1']) && $data['dotime1']!=""){
			$dotime1 = ($data['dotime1']=="request")?$_REQUEST['dotime1']:$data['dotime1'];
			if( !isTimePattern($dotime1))$dotime1 = "";
			if ($dotime1!=""){
				$_sql .= " and p1.repay_time >= ".get_mktime($dotime1);
			}
		}

		if (isset($data['dotime2']) && $data['dotime2']!=""){
			$dotime2 = ($data['dotime2']=="request")?$_REQUEST['dotime2']:$data['dotime2'];
			if( !isTimePattern($dotime2))$dotime2 = "";
			if ($dotime2!=""){
				$_sql .= " and p1.repay_time <= ".get_mktime($dotime2);
			}
		}

		if (isset($data['keywords']) && $data['keywords']!=""){
			$keywords = ($data['keywords']=="request")?$_REQUEST['keywords']:$data['keywords'];
			if ($keywords!=""){
				$_sql .= " and p3.name like'%".safegl($keywords)."%'";
			}
		}

		$page = empty($data['page'])?1:$data['page'];
		$epage = empty($data['epage'])?10:$data['epage'];
		/*
		 $_select = 'p1.*,p3.name as borrow_name,p3.id as borrow_id,p3.time_limit,p4.username ';
		$sql = "select SELECT from  {borrow_collection}  as p1
		left join  {borrow_tender}  as p2 on  p1.tender_id = p2.id
		left join  {borrow}  as p3 on  p3.id = p2.borrow_id
		left join  {user}  as p4 on  p4.user_id = p3.user_id
		where p3.status=3  and p3.id in (select borrow_id from  {borrow_tender}  {$__sql})
		$_sql ORDER LIMIT";
		*/


		$_select = 'p1.*,p3.name as borrow_name,p3.id as borrow_id,p3.time_limit,p4.username ';
		$_order = " order by p1.id ";
		//$data['order']="order";
		if (isset($data['order']) && $data['order']!="" ){
			if ($data['order'] == "repay_time"){
				$_order = " order by p1.repay_time asc ";
			}elseif ($data['order'] == "order"){
				$_order = " order by p1.`order` desc,p1.id desc ";
			}
		}
		$sql = "select SELECT from  {borrow_collection}  as p1
		left join  {borrow_right}  as p2 on  p1.borrow_right_id = p2.id
		left join  {borrow}  as p3 on  p3.id = p2.borrow_id
		left join  {user}  as p4 on  p4.user_id = p3.user_id
		where p2.creditor_id = {$data['user_id']}
		{$_sql} ORDER LIMIT";
			
		//是否显示全部的信息
		if (isset($data['limit']) ){
			$_limit = "";
			if ($data['limit'] != "all"){
				$_limit = "  limit ".$data['limit'];
			}
			$list  = $mysql->db_fetch_arrays(str_replace(array('SELECT', 'ORDER', 'LIMIT'), array($_select,  $_order, $_limit), $sql));
			foreach ($list as $key => $value){
				//*******
				$borrow_result = self::GetOne(array("id"=>$value['borrow_id']));//获取借款标的单独信息
				if($borrow_result['is_fast']==1){
					$late = self::LateInterestFast(array("repayment_time"=>$value['repay_time'],"account"=>$value['capital']));
				}else{
					$late = self::LateInterest(array("repayment_time"=>$value['repay_time'],"account"=>$value['capital']));
				}

				if ($value['status']!=1){
					$list[$key]['late_days'] = $late['late_days'];
					if($borrow_result['is_fast']==1){
						$list[$key]['late_interest'] = round($late['late_interest'],2);
					}else{
						if ($late['late_days']>30){
							$list[$key]['late_interest'] = 0;
						}else{
							$list[$key]['late_interest'] = round($late['late_interest']/2,2);
						}
					}

				}else{
					$list[$key]['late_interest'] = 0;
					$list[$key]['late_days'] = 0;
				}
			}
			return $list;
		}

		$row = $mysql->db_fetch_array(str_replace(array('SELECT', 'ORDER', 'LIMIT'), array(" count(*) as num ","",""),$sql));

		$total = $row['num'];
		$total_page = ceil($total / $epage);
		$index = $epage * ($page - 1);
		$limit = " limit {$index}, {$epage}";

		$list = $mysql->db_fetch_arrays(str_replace(array('SELECT', 'ORDER', 'LIMIT'), array($_select, $_order , $limit), $sql));
		$list = $list?$list:array();
		foreach ($list as $key => $value){
			$borrow_result = self::GetOne(array("id"=>$value['borrow_id']));//获取借款标的单独信息
			if($borrow_result['is_fast']==1){
				$late = self::LateInterestFast(array("repayment_time"=>$value['repay_time'],"account"=>$value['capital']));
			}else{
				$late = self::LateInterest(array("repayment_time"=>$value['repay_time'],"account"=>$value['capital']));
			}
			if ($value['status']!=1){
				$list[$key]['late_days'] = $late['late_days'];
				if($borrow_result['is_fast']==1){
					$list[$key]['late_interest'] = round($late['late_interest'],2);
				}else{
					if ($late['late_days']>30){
						$list[$key]['late_interest'] = 0;
					}else{
						$list[$key]['late_interest'] = round($late['late_interest']/2,2);
					}

				}
			}else{
				$list[$key]['late_interest'] = 0;
				$list[$key]['late_days'] = 0;
			}
		}
		return array(
				'list' => $list,
				'total' => $total,
				'page' => $page,
				'epage' => $epage,
				'total_page' => $total_page
		);
	}

	//待收款列表
	function GetCollectioningList($data){
		global $mysql,$_G;
		$_sql = " ";
		$__sql = " ";
		if (isset($data['user_id']) && $data['user_id']!="" ){
			$__sql .= " where creditor_id={$data['user_id']}";
		}
		if (isset($data['status']) && $data['status']!="" ){
			$_sql .= " and p1.status={$data['status']}";
		}
		if (isset($data['borrow_status']) && $data['borrow_status']!="" ){
			$_sql .= " and p3.status={$data['borrow_status']}";
		}
		if (isset($data['username']) && $data['username']!="" ){
			$_sql .= " and p4.username like '%{$data['username']}%' ";
		}
		//liukun add fro bug 21 begin
		if (isset($data['borrow_id']) && $data['borrow_id']!="" ){
			$_sql .= " and p2.borrow_id={$data['borrow_id']}";
		}
		//liukun add fro bug 21 end


		if (isset($data['dotime1']) && $data['dotime1']!=""){
			$dotime1 = ($data['dotime1']=="request")?$_REQUEST['dotime1']:$data['dotime1'];
			if( !isTimePattern($dotime1))$dotime1 = "";
			if ($dotime1!=""){
				$_sql .= " and p1.repay_time >= ".get_mktime($dotime1);
			}
		}

		if (isset($data['dotime2']) && $data['dotime2']!=""){
			$dotime2 = ($data['dotime2']=="request")?$_REQUEST['dotime2']:$data['dotime2'];
			if( !isTimePattern($dotime2))$dotime2 = "";
			if ($dotime2!=""){
				$_sql .= " and p1.repay_time <= ".get_mktime($dotime2);
			}
		}

		if (isset($data['keywords']) && $data['keywords']!=""){
			$keywords = ($data['keywords']=="request")?$_REQUEST['keywords']:$data['keywords'];
			if ($keywords!=""){
				$_sql .= " and p3.name like'%".safegl($keywords)."%'";
			}
		}

		$page = empty($data['page'])?1:$data['page'];
		$epage = empty($data['epage'])?10:$data['epage'];
		/*
		 $_select = 'p1.*,p3.name as borrow_name,p3.id as borrow_id,p3.time_limit,p4.username ';
		$sql = "select SELECT from  {borrow_collection}  as p1
		left join  {borrow_tender}  as p2 on  p1.tender_id = p2.id
		left join  {borrow}  as p3 on  p3.id = p2.borrow_id
		left join  {user}  as p4 on  p4.user_id = p3.user_id
		where p3.status=3  and p3.id in (select borrow_id from  {borrow_tender}  {$__sql})
		$_sql ORDER LIMIT";
		*/


		$_select = 'p1.*, p2.has_percent,
		(round(floor(p1.repayment_account * p2.has_percent) / 100, 2)) as r_total, (round(round(p1.capital * p2.has_percent) / 100, 2)) as r_capital ,
		(round(floor(p1.repayment_account * p2.has_percent) / 100, 2) - round(round(p1.capital * p2.has_percent) / 100, 2)) as  r_interest,
		p3.name as borrow_name,p3.id as borrow_id,p3.time_limit,p4.username ';
		$_order = " ORDER BY p1.borrow_id, p1.`order` ";





		$sql = "select SELECT
		from  {borrow_repayment}  p1,  {borrow_right}  p2,  {borrow}  p3,  {user}  p4

		where p2.creditor_id = {$data['user_id']} and p1.borrow_id = p3.id
		AND p2.borrow_id = p3.id and p4.user_id = p3.user_id and p1.status = 0 and p2.status = 1
		{$_sql} ORDER LIMIT";
			
		//是否显示全部的信息
		if (isset($data['limit']) ){
			$_limit = "";
			if ($data['limit'] != "all"){
				$_limit = "  limit ".$data['limit'];
			}
			$list  = $mysql->db_fetch_arrays(str_replace(array('SELECT', 'ORDER', 'LIMIT'), array($_select,  $_order, $_limit), $sql));
			foreach ($list as $key => $value){
				//*******
				$borrow_result = self::GetOne(array("id"=>$value['borrow_id']));//获取借款标的单独信息
				if($borrow_result['is_fast']==1){
					$late = self::LateInterestFast(array("repayment_time"=>$value['repay_time'],"account"=>$value['capital']));
				}else{
					$late = self::LateInterest(array("repayment_time"=>$value['repay_time'],"account"=>$value['capital']));
				}

				if ($value['status']!=1){
					$list[$key]['late_days'] = $late['late_days'];
					if($borrow_result['is_fast']==1){
						$list[$key]['late_interest'] = round($late['late_interest'],2);
					}else{
						if ($late['late_days']>30){
							$list[$key]['late_interest'] = 0;
						}else{
							$list[$key]['late_interest'] = round($late['late_interest']/2,2);
						}
					}

				}else{
					$list[$key]['late_interest'] = 0;
					$list[$key]['late_days'] = 0;
				}
			}
			return $list;
		}

		$row = $mysql->db_fetch_array(str_replace(array('SELECT', 'ORDER', 'LIMIT'), array(" count(*) as num ","",""),$sql));

		$total = $row['num'];
		$total_page = ceil($total / $epage);
		$index = $epage * ($page - 1);
		$limit = " limit {$index}, {$epage}";

		$list = $mysql->db_fetch_arrays(str_replace(array('SELECT', 'ORDER', 'LIMIT'), array($_select, $_order , $limit), $sql));
		$list = $list?$list:array();
		foreach ($list as $key => $value){
			$borrow_result = self::GetOne(array("id"=>$value['borrow_id']));//获取借款标的单独信息
			if($borrow_result['is_fast']==1){
				$late = self::LateInterestFast(array("repayment_time"=>$value['repay_time'],"account"=>$value['capital']));
			}else{
				$late = self::LateInterest(array("repayment_time"=>$value['repay_time'],"account"=>$value['capital']));
			}
			if ($value['status']!=1){
				$list[$key]['late_days'] = $late['late_days'];
				if($borrow_result['is_fast']==1){
					$list[$key]['late_interest'] = round($late['late_interest'],2);
				}else{
					if ($late['late_days']>30){
						$list[$key]['late_interest'] = 0;
					}else{
						$list[$key]['late_interest'] = round($late['late_interest']/2,2);
					}

				}
			}else{
				$list[$key]['late_interest'] = 0;
				$list[$key]['late_days'] = 0;
			}
		}
		return array(
				'list' => $list,
				'total' => $total,
				'page' => $page,
				'epage' => $epage,
				'total_page' => $total_page
		);
	}

	function GetBorrowAll($data=array()){
		global $mysql;
		$user_id = $data['user_id'];
		$sql = "select * from  {borrow}  where user_id = {$user_id}";
		$result = $mysql->db_fetch_arrays($sql);
		$_result['success'] = $_result['false'] =  $_result['wait'] = $_result['pay_success'] = $_result['pay_advance'] = $_result['pay_expired'] = 0;
		foreach ($result as $key => $value){
			if ($value['status']==3){
				$_result['success'] ++;
			}
			if ($value['status']==3 && $value['repayment_account']!=$value['repayment_yesaccount']){
				$_result['wait'] ++;
			}
			if ($value['status']==0 || $value['status']==4){
				$_result['false'] ++;
			}
		}
		$sql = "select * from  {borrow_repayment}  where borrow_id in (select id from  {borrow}  where user_id = {$user_id} and status=3)";
		$result = $mysql->db_fetch_arrays($sql);
		foreach ($result as $key => $value){
			//已还款未过期
			//if ($value['status']==1 && $value['repayment_time']<$value['repayment_yestime']){
			if ($value['status']==1 && $value['repayment_yestime'] >0 ){
				$_result['pay_success'] ++;
			}
			//已还款过期
			if ($value['status']==1 && $value['repayment_time']>$value['repayment_yestime']){
				$_result['pay_expired'] ++;
			}
			//逾期未还
			if (($value['status']==0 || $value['status']==2 ) &&  date("Ymd",$value['repayment_time'])<date("Ymd",time())){
				$_result['pay_expiredno'] ++;
			}
			//逾期已还
			if ($value['status']==1 && date("Ymd",$value['repayment_time'])<date("Ymd",$value['repayment_yestime'])){
				$_result['pay_expiredyes'] ++;
			}
			//提前还款(提前5天还款算提前还款)
			if ($value['status']==1 && ($value['repayment_time']-$value['repayment_yestime'])>60*60*24*5){
				$_result['pay_advance'] ++;
			}
			//30天之外的逾期还款
			if ($value['status']==1 && $value['repayment_yestime']-$value['repayment_time']>60*60*24*30){
				$_result['pay_expired30'] ++;
			}
			//30天之内的逾期还款
			if ($value['status']==1 && $value['repayment_yestime']-$value['repayment_time']>60*60*24*15 && $value['repayment_yestime']-$value['repayment_time']<60*60*24*30){
				$_result['pay_expired30in'] ++;
			}
		}
		return $_result;
	}

	function GetAll($data=array()){
		global $mysql;
		$sql = "select sum(account) as sum from  {borrow} ";
		$result = $mysql->db_fetch_array($sql);
		$_result['borrow_all'] = $result['sum'];

		$sql = "select sum(account) as sum from  {borrow}  where status=3";
		$result = $mysql->db_fetch_array($sql);
		$_result['borrow_yesall'] = $result['sum'];


		$sql = "select count(account) as num from  {borrow} ";
		$result = $mysql->db_fetch_array($sql);
		$_result['borrow_times'] = $result['num'];

		$sql = "select count(account) as num from  {borrow}  where status=3";
		$result = $mysql->db_fetch_array($sql);
		$_result['borrow_yestimes'] = $result['num'];

		return $_result;
	}

	function ActionLiubiao($data){
		global $mysql;
		$status= $data['status'];
		if ($status==1){
			$result = self::Cancel($data);
		}elseif($status==2){
			$valid_time = $data['days'];
			$sql = "update  {borrow}  set valid_time=valid_time +{$valid_time} where id={$data['id']}";
			$mysql->db_query($sql);
		}
		return true;
	}


	//逾期还款列表
	function GetLateList($data = array()){
		global $mysql,$_G;

		$page = (!isset($data['page']) || $data['page']=="")?1:$data['page'];
		$epage = (!isset($data['epage']) || $data['epage']=="")?10:$data['epage'];

		$_select = 'p1.*,p3.*';
		$_order = " order by p1.id ";
		if (isset($data['late_day']) && $data['late_day']!=""){
			$_repayment_time = time()-60*60*24*$data['late_day'];
		}else{
			$_repayment_time = time();
		}

		$_sql = " where p1.repayment_time < '{$_repayment_time}' and p1.status!=1 and p1.borrow_id>0";
		$sql = "select SELECT from  {borrow_repayment}  as p1
		left join  {borrow}  as p2 on p1.borrow_id=p2.id
		left join  {user}  as p3 on p2.user_id=p3.user_id
		{$_sql} ORDER LIMIT";



		$_list = $mysql->db_fetch_arrays(str_replace(array('SELECT', 'ORDER', 'LIMIT'), array($_select, $_order , ""), $sql));
			
		foreach ($_list as $key => $value){
			$late = self::LateInterest(array("repayment_time"=>$value['repayment_time'],"account"=>$value['capital']));
			$list[$value['user_id']]['realname'] = $value['realname'];
			$list[$value['user_id']]['phone'] = $value['phone'];
			$list[$value['user_id']]['user_id'] = $value['user_id'];
			$list[$value['user_id']]['email'] = $value['email'];
			$list[$value['user_id']]['qq'] = $value['qq'];
			$list[$value['user_id']]['sex'] = $value['sex'];
			$list[$value['user_id']]['card_id'] = $value['card_id'];
			$list[$value['user_id']]['area'] = $value['area'];
			$list[$value['user_id']]['late_days'] += $late['late_days'];//总逾期天数
			if ($list[$value['user_id']]['late_numdays']<$late['late_days']){
				$list[$value['user_id']]['late_numdays'] =  $late['late_days'];
			}
			$list[$value['user_id']]['late_interest'] += round($late['late_interest']/2,2);
			$list[$value['user_id']]['late_account'] +=  $value['repayment_account'];//逾期总金额
			$list[$value['user_id']]['late_num'] ++;//逾期笔数
			if ($value['webstatus']==1){
				$list[$value['user_id']]['late_webnum'] +=1;//逾期笔数
			}

		}
		//是否显示全部的信息
		if (isset($data['limit']) ){
			if (count($list)>0){
				return array_slice ($list,0,$data['limit']);
			}else{
				return array();
			}
		}

		$total = count($list);
		$total_page = ceil($total / $epage);
		$index = $epage * ($page - 1);
		if (is_array($list)){
			$list = array_slice ($list,$index,$epage);
		}
		return array(
				'list' => $list,
				'total' => $total,
				'page' => $page,
				'epage' => $epage,
				'total_page' => $total_page
		);

	}


	//我的客户列表
	function GetMyuserList($data = array()){
		global $mysql,$_G;

		$page = (!isset($data['page']) || $data['page']=="")?1:$data['page'];
		$epage = (!isset($data['epage']) || $data['epage']=="")?10:$data['epage'];

		$_select = 'p1.*,p2.realname,p2.username';
		$_order = " order by p1.id ";
		$_sql = "";
		if (isset($data['suser_id']) && $data['suser_id']!=""){
			$_sql .= " and p1.user_id='{$data['suser_id']}'";
		}
		$sql = "select SELECT from  {borrow}  as p1 left join  {user}  as p2 on p1.user_id=p2.user_id where p1.user_id in (select user_id from  {user_cache}  where kefu_userid = '{$data['user_id']}')   {$_sql} ORDER LIMIT";
			
		//是否显示全部的信息
		if (isset($data['limit']) && $data['limit']!="" ){
			$_limit = "";
			if ($data['limit'] != "all"){
				$_limit = "  limit ".$data['limit'];
			}
			return $mysql->db_fetch_arrays(str_replace(array('SELECT', 'ORDER', 'LIMIT'), array($_select,  'order by p1.`order` desc,p1.id desc', $_limit), $sql));
		}

		$row = $mysql->db_fetch_array(str_replace(array('SELECT', 'ORDER', 'LIMIT'), array("count(*) as  num","",""),$sql));

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

	//统计
	function GetMyuserAcount($data = array()){
		global $mysql,$_G;
		$user_id = $data['user_id'];

		//第一步，先读取出客服下面的用户
		$sql = "select user_id from  {user_cache}  where kefu_userid = {$user_id}";
		$result = $mysql->db_fetch_arrays($sql);
		if ($result!=""){
			foreach ($result as $key => $value){
				$_result[] = $value["user_id"];
			}
			$_fuserid = join(",",$_result);
		}
		$_first_month = strtotime("2010-08-01");
		$_now_year = date("Y",time());
		$_now_month = date("n",time());
		$month = ($_now_year-2011)*12 + 5+$_now_month;//现在的月数

		//成功借款
		for ($i=1;$i<=$month;$i++){
			$up_month = strtotime("$i month",$_first_month);
			$now_month = strtotime("-1 month",$up_month);
			$nowlast_day = strtotime("-1 day",$up_month);

			$sql = "select sum(money) as num_money from  {account_log}  where user_id in ($_fuserid) and type='borrow_success' and addtime >= {$now_month} and addtime < {$nowlast_day}";
			$result = $mysql->db_fetch_array($sql);
			if ($result["num_money"]!=""){
				$_resul[date("Y-n",$now_month)]["borrow"] = $result["num_money"];
			}

			$sql = "select sum(money) as num_money from  {account_log}  where user_id in ($_fuserid) and type='invest' and addtime >= {$now_month} and addtime < {$nowlast_day}";
			$result = $mysql->db_fetch_array($sql);
			if ($result["num_money"]!=""){
				$_resul[date("Y-n",$now_month)]["tender"] = $result["num_money"];
			}

			$sql = "select count(1) as num_vip from  {account_log}  where user_id in ($_fuserid) and type='vip' and addtime >= {$now_month} and addtime < {$nowlast_day}";
			$result = $mysql->db_fetch_array($sql);
			if ($result["num_vip"]>0){
				$_resul[date("Y-n",$now_month)]["vip"] = $result["num_vip"];
			}

		}

		arsort($_resul);

		return $_resul;
	}

	//统计
	function Tongji($data = array()){
		global $mysql;

		//成功借款
		$sql = " select sum(account) as num from  {borrow}  where status=3 ";
		$result = $mysql->db_fetch_array($sql);
		$_result['success_num'] = $result['num'];

		//liukun add for site_id search begin
		$_sql = "";
		if (isset($data['areaid']) && $data['areaid']!="0"){
			$_sql = " and p2.areaid = {$data['areaid']} ";
		}
		//liukun add for biao_type search begin

		//逾期未还款
		$_repayment_time = time();
		$sql = " select p1.capital,p1.repayment_yestime,p1.repayment_time,p1.status  from   {borrow_repayment}  as p1
		left join  {borrow}  as p2 on p1.borrow_id=p2.id where p2.status=3 {$_sql}

		";
		$result = $mysql->db_fetch_arrays($sql);
		foreach ($result as $key => $value){
			$_result['success_sum'] += $value['capital'];//借款总额
			if ($value['status']==1){
				$_result['success_num1'] += $value['capital'];//成功还款总额
				if (date("Ymd",$value['repayment_time']) < date("Ymd",$value['repayment_yestime'])){
					$_result['success_laterepay'] += $value['capital'];
				}
			}
			if ($value['status']==0){
				$_result['success_num0'] += $value['capital'];//未还款总额
				if (date("Ymd",$value['repayment_time']) < date("Ymd",time())){
					$_result['false_laterepay'] += $value['capital'];
				}
			}
		}
		$_result['laterepay'] = $_result['success_laterepay'] + $_result['false_laterepay'];

		return $_result;
	}



	/**
	 * 添加
	 *
	 * @param Array $data
	 * @return Boolen
	 */
	function add_auto($data = array()){
		global $mysql;global $_G;

		$csql="select count(*) as t from {borrow_auto}  where user_id={$data['user_id']} ";
		$cn = $mysql->db_fetch_array($csql);
		if(isset($data['auto_id'])&&is_numeric($data['auto_id'])){
			//
		}else{
			if($cn['t']>=1){//只能添加一条规则
				return false;
			}
		}
			
		if($data['tender_scale']>20) $data['tender_scale'] = 20;
			
		$_sql=array();
		$_table_field =  $mysql->db_show_fields("borrow_auto");
		//liukun add for bug 52 begin
		fb($_table_field, FirePHP::TRACE);
		//liukun add for bug 52 end
		foreach($_table_field as $field_v){
			if(isset($data[$field_v])) $_sql[]="`$field_v` = '".$data[$field_v]."'";
			elseif($field_v == 'id') "";
			else  $_sql[]="`$field_v` = '0'";
		}
			
			
		if(isset($data['auto_id'])&&is_numeric($data['auto_id'])){
			$sql = "update  {borrow_auto}  set ";
		}else{
			$sql = "insert into  {borrow_auto}  set ";
		}
			
		$sql.=join(",",$_sql);
			
		if(isset($data['auto_id'])&&is_numeric($data['auto_id'])){
			$sql .= " where  id = {$data['auto_id']} ";
		}
			

		return $mysql->db_query($sql);
	}

	/**
	 * 添加
	 *
	 * @param Array $data
	 * @return Boolen
	 */
	function add_auto_back($data = array()){
		global $mysql;global $_G;

		$csql="select id from {auto_back}  where user_id={$data['user_id']} ";
		$cn = $mysql->db_fetch_array($csql);

		$_sql=array();
		$_table_field =  $mysql->db_show_fields("auto_back");//获取当前用户的余额
		foreach($_table_field as $field_v){
			if(isset($data[$field_v])) $_sql[]="`$field_v` = '".$data[$field_v]."'";
			elseif($field_v == 'id') "";
			else  $_sql[]="`$field_v` = '0'";
		}
			
			
		if(isset($data['auto_back_id'])&&is_numeric($data['auto_back_id'])){
			$sql = "update  {auto_back}  set ";
		}else{
			$sql = "insert into  {auto_back}  set ";
		}
			
		$sql.=join(",",$_sql);
			
		if(isset($data['auto_back_id'])&&is_numeric($data['auto_back_id'])){
			$sql .= " where  id = {$data['auto_back_id']} ";
		}
			

		return $mysql->db_query($sql);
	}

	function GetAutoList($data = array()){
		global $mysql;global $_G;
		$user_id = empty($data['user_id'])?"":$data['user_id'];
			
		$_select = " p1.* ";
		$_sql = "where 1=1 ";

		if (isset($data['user_id'])  && $data['user_id']!=""){
			$_sql .= " and p1.user_id = {$data['user_id']}";
		}

		$_order = " order by p1.`id` desc ";

		$_limit = "  limit 0,3";

		$sql = "select SELECT from  {borrow_auto}  as p1 $_sql ORDER LIMIT";
		//是否显示全部的信息
			
		$list =  $mysql->db_fetch_arrays(str_replace(array('SELECT', 'ORDER', 'LIMIT'), array($_select, $_order, $_limit), $sql));
			
		//			foreach($list as $key => $value){
		//				//获取进度
		//				$list[$key]['other'] = $value['account'] - $value['account_yes'];
		//				$list[$key]['scale'] = round(100*$value['account_yes']/$value['account'],1);
		//				$list[$key]['scale_width'] = round((20*$value['account_yes']/$value['account']))*7;
		//				$list[$key]['repayment_noaccount'] = $value['repayment_account'] - $value['repayment_yesaccount'];
		//
		//				//获取担保进度
		//				$list[$key]['vouch_scale'] = round(100*$value['vouch_account']/$value['account'],1);
		//				$list[$key]['vouch_other'] = $value['account'] - $value['vouch_account'];
		//				$list[$key]['vouchscale_width'] = round((20*$value['vouch_account']/$value['account']))*7;
		//			}
		return $list;

	}



	function GetAutoId($id){
		global $mysql;global $_G;
		$user_id = $_G['user_id'];
			
		$_select = " p1.* ";
		$_where = "where 1=1 ";

		if (isset($user_id)  && $user_id!=""){
			$_where .= " and p1.user_id = {$user_id}";
		}

		if (isset($id)  && $id!=""){
			$_where .= " and p1.id = {$id}";
		}

		$_order = " order by p1.`id` desc ";

		$_limit = "  limit 0,1";

		$sql = "select SELECT from  {borrow_auto}  as p1 $_where ORDER LIMIT";
		//是否显示全部的信息
			
		$row =  $mysql->db_fetch_array(str_replace(array('SELECT', 'ORDER', 'LIMIT'), array($_select, $_order, $_limit), $sql));
			
		return $row;

	}


	function GetAutoBackId(){
		global $mysql;global $_G;
		$user_id = $_G['user_id'];
			
		$_select = " p1.* ";
		$_where = "where 1=1 ";

		if (isset($user_id)  && $user_id!=""){
			$_where .= " and p1.user_id = {$user_id}";
		}

		$_order = " order by p1.`id` desc ";

		$_limit = "  limit 0,1";

		$sql = "select SELECT from  {auto_back}  as p1 $_where ORDER LIMIT";
		//是否显示全部的信息
			
		$row =  $mysql->db_fetch_array(str_replace(array('SELECT', 'ORDER', 'LIMIT'), array($_select, $_order, $_limit), $sql));
			
		return $row;

	}
	/**
	 * 获取待还列表
	 *
	 * @param Array $data
	 * @return Boolen
	 */
	function get_back_list($data = array()){
		global $mysql;global $_G;

		$ausql="select * from  {borrow_repayment}  where borrow_id = ".$data['id']."";
		$au_row = $mysql->db_fetch_arrays($ausql);//自动投标的用户

		return $au_row;
	}


	/**
	 * 添加
	 *
	 * @param Array $data
	 * @return Boolen
	 */
	function add_fast_biao($data = array()){
		global $mysql;global $_G;

		$_sql=array();
		$_table_field =  $mysql->db_show_fields("daizi");//获取当前用户的余额
		foreach($_table_field as $field_v){
			if(is_array($data[$field_v])){
				$data[$field_v] = implode(",",$data[$field_v]);
			}
			if(isset($data[$field_v])) $_sql[]="`$field_v` = '".$data[$field_v]."'";
			elseif($field_v == 'id') "";
			else  $_sql[]="`$field_v` = '0'";
		}
			
		$sql = "insert into  {daizi}  set ";
			
		$sql.=join(",",$_sql);
		$mysql->db_query($sql);
		$newid = $mysql->db_insert_id();
		return $newid;
	}
	/**
	 * 添加
	 *
	 * @param Array $data
	 * @return Boolen
	 */
	function del_auto($id){
		global $mysql;
			
		$where =" id ='{$id}' ";
			
		return $mysql->db_delete("borrow_auto",$where);
	}

	function auto_borrow($data_s=array()){
		global $mysql;
		global $_G;
		$con_auto_weight_beginapr = isset($_G['system']['con_auto_weight_beginapr'])?$_G['system']['con_auto_weight_beginapr']:0.25;
		$con_auto_weight_logintime = isset($_G['system']['con_auto_weight_logintime'])?$_G['system']['con_auto_weight_logintime']:0.15;
		$con_auto_weight_tendertime = isset($_G['system']['con_auto_weight_tendertime'])?$_G['system']['con_auto_weight_tendertime']:0.25;
		$con_auto_weight_ruleaccount = isset($_G['system']['con_auto_weight_ruleaccount'])?$_G['system']['con_auto_weight_ruleaccount']:0.1;
		$con_auto_weight_usemoney = isset($_G['system']['con_auto_weight_usemoney'])?$_G['system']['con_auto_weight_usemoney']:0.25;
		
		
		include_once(ROOT_PATH."modules/account/account.class.php");
		$borrow_id=$data_s['id'];
		$borrow_result = self::GetOne(array("id"=>$borrow_id));//获取借款标的单独信息
		if(in_array($borrow_result['biao_type'], array("miao", "love", "circulation")) || $borrow_result['pwd']<>''){
			return;
		}
		//$usql="select user_id from  {borrow_auto}  A where user_id<>'".$data_s['user_id']."' AND status=1 and exists (Select 1 from  {user}  B where B.user_id=A.user_id) order by id desc";
		//$usql="select user_id as userID from  {borrow_auto}   where status=1";
		/* 2012-06-14 自动投标新算法 By:Weego */
		$usql = "select user_id from
(
SELECT `dw_borrow_auto`.`user_id` AS `user_id`,
       (35 - `dw_borrow_auto`.`apr_first`) AS `apr_first`,
       ((unix_timestamp(now()) - `dw_user`.`lasttime`) / 86400)
          AS `last_login_time`,
       ((unix_timestamp(now()) - `dw_borrow_tender`.`addtime`) / 86400)
          AS `last_tender_time`,
       sqrt(sqrt(`dw_borrow_auto`.`tender_account`)) AS `tender_account`,
       sqrt(sqrt(`dw_account`.`use_money`)) AS `use_money`,
       (  (  (  (  ({$con_auto_weight_beginapr} * (35 - `dw_borrow_auto`.`apr_first`))
                 - (  {$con_auto_weight_logintime}
                    * ((unix_timestamp(now()) - `dw_user`.`lasttime`) / 86400)))
              + (  {$con_auto_weight_tendertime}
                 * (  (unix_timestamp(now()) - `dw_borrow_tender`.`addtime`)
                    / 86400)))
           + ({$con_auto_weight_ruleaccount} * sqrt(sqrt(`dw_borrow_auto`.`tender_account`))))
        + ({$con_auto_weight_usemoney} * sqrt(sqrt(`dw_account`.`use_money`))))
          AS `pr`
  FROM (   (   (   (SELECT max(`dw_borrow_tender`.`addtime`) AS `addtime`,
                           `dw_borrow_tender`.`user_id` AS `user_id`
                      FROM `dw_borrow_tender`
                    GROUP BY `dw_borrow_tender`.`user_id`) AS `dw_borrow_tender`
                JOIN
                   `dw_user`
                ON ((`dw_borrow_tender`.`user_id` = `dw_user`.`user_id`)))
            JOIN
               `dw_account`
            ON ((`dw_account`.`user_id` = `dw_user`.`user_id`)))
        JOIN
           `dw_borrow_auto`
        ON ((`dw_account`.`user_id` = `dw_borrow_auto`.`user_id`)))
 WHERE ((`dw_borrow_auto`.`status` = 1) AND (`dw_account`.`use_money` > '1'))
GROUP BY `dw_borrow_tender`.`user_id`
ORDER BY (  (  (  (  ({$con_auto_weight_beginapr} * (35 - `dw_borrow_auto`.`apr_first`))
                   - (  {$con_auto_weight_logintime}
                      * (  (unix_timestamp(now()) - `dw_user`.`lasttime`)
                         / 86400)))
                + (  {$con_auto_weight_tendertime}
                   * (  (unix_timestamp(now()) - `dw_borrow_tender`.`addtime`)
                      / 86400)))
             + ({$con_auto_weight_ruleaccount} * sqrt(sqrt(`dw_borrow_auto`.`tender_account`))))
          + ({$con_auto_weight_usemoney} * sqrt(sqrt(`dw_account`.`use_money`)))) DESC) as `dw_auto_tender_set` where user_id<>'".$data_s['user_id']."'";
		
		$result = $mysql->db_fetch_arrays($usql);

		//liukun add for bug 52 begin
		fb($result, FirePHP::TRACE);
		//liukun add for bug 52 end

		if($result==false){

		}else{ /*
			//$in_uid = "(".join(",",$result.")";
					//echo $in_uid;
					$in_uid = "(-1";
							//echo $result["userID"];
							foreach ($result as $key => $value){
							$in_uid .= ",".$value["user_id"];
							}

							$in_uid .=")";
			*/
			//$ausql="select * from  {borrow_auto}  where user_id in ".$in_uid." AND status=1 order by id desc";


			//$au_row = $mysql->db_fetch_arrays($ausql);//自动投标的用户

			$have_auto_do=array();
			foreach($result as $key => $value){
				$ausql="select * from  {borrow_auto}  where user_id = ".$value['user_id'];
				$v = $mysql->db_fetch_array($ausql);
				$borrow_result = self::GetOne(array("id"=>$borrow_id));//获取借款标的单独信息




				if(in_array($v['user_id'],$have_auto_do)){
					continue;
				}else{
					$uss = "select * from  {user}  where user_id = '".$v['user_id']."'";
					$u_row_detail = $mysql->db_fetch_arrays($uss);//当前自动投票的用户信息
				}

				if($v['tender_type']==1){
					$account_money=$v['tender_account'];
					$account_money_s=$v['tender_account'];
				}elseif($v['tender_type']==2){
					$account_money=($v['tender_scale']*$data_s['total_jie']/100);
					$account_money_s=($v['tender_scale']*$data_s['total_jie']/100);
				}
				if($account_money < $data_s['zuishao_jie']){
					continue;//不符合最低投资金额
				}
				//借款人信息
				$jksql="select * from  {user}  where user_id='".$borrow_result['user_id']."'";
				$jkr_row = $mysql->db_fetch_array($jksql);//当前自动投票的用户信息

				$jksql2="select * from  {user_cache}  where user_id='".$borrow_result['user_id']."'";
				$jkr_rowCache = $mysql->db_fetch_array($jksql2);//当前自动投票的用户信息

				if($v['video_status']==1 &&$jkr_row['video_status']==1){

				}elseif(empty($v['video_status'])){

				}else{
					continue;
				}

				if($v['scene_status'] == 1&&$jkr_row['scene_status']==1){

				}elseif(empty($v['scene_status'])){

				}else{
					continue;
				}

				//借款信息

				if($v['borrow_credit_status'] == 1){
					if($v['borrow_credit_first']<=$jkr_rowCache['credit']&&$v['borrow_credit_last']>=$jkr_rowCache['credit']){
							
					}else{
						continue;
					}

				}else{

				}//

				if($v['award_status'] == 1){
					if($v['award_first'] > 0){
						if($v['award_first']<=$borrow_result['funds']){

						}else{
							continue;
						}
					}
				}else{

				}//奖励

				if($v['apr_status'] == 1){
					if($v['apr_first']<=$borrow_result['apr']&&$v['apr_last']>=$borrow_result['apr']){
							
					}else{
						continue;
					}

				}else{

				}//利率


				/*if($v['vouch_status']){
					if($borrow_result['flag']==2){
					
				}else{
				continue;
				}

				}else{

				}//担宝*/

				/*
				 echo "#1#";
				echo $v['fast_status'];
				echo "<br>";
				echo "#2#";
				echo $v['jin_status'];
				echo "<br>";
				echo "#3#";
				echo $v['xin_status'];
				echo "<br>";
				echo $borrow_result['is_fast'];
				echo "<br>";
				echo "#4#";

				exit;
				* */
					
				//抵押标

				if($borrow_result['biao_type'] == "fast"){
					if($v['fast_status'] != 1){
						continue;//不符合条件
					}else{

					}
				}

				if($borrow_result['biao_type'] == "jin"){
					if($v['jin_status'] != 1){
						continue;//不符合条件
					}else{

					}
				}
				if($borrow_result['biao_type'] == "credit"){
					if($v['credit_status'] != 1){
						continue;//不符合条件
					}else{

					}
				}
				//liukun add for bug 52 begin
				fb($borrow_result['biao_type'], FirePHP::TRACE);
				fb($auto_borrow_per, FirePHP::TRACE);
				//liukun add for bug 52 end
				if($borrow_result['biao_type'] == "zhouzhuan"){
					if($v['zhouzhuan_status'] != 1){
						continue;//不符合条件
					}else{

					}
				}
				if($borrow_result['biao_type'] == "pledge"){
					if($v['pledge_status'] != 1){
						continue;//不符合条件
					}else{

					}
				}
				if($borrow_result['biao_type'] == "vouch"){
					if($v['vouch_status'] != 1){
						continue;//不符合条件
					}else{

					}
				}
				if($borrow_result['biao_type'] == "restructuring"){
					if($v['restructuring_status'] != 1){
						continue;//不符合条件
					}else{

					}
				}

				if($v['borrow_style_status'] == 1){
					if($v['borrow_style'] != $borrow_result['style']){
						continue;//不符合条件
					}else{
							
					}
				}
					
				/*
				 if($v['tuijian_status']){
				if($borrow_result['flag']==1){
					
				}else{
				continue;
				}

				}else{

				}//推荐
				* */

				//设定自动投标的百分比参数，剩下的给手动 add by weego 20120525 begin
				$auto_borrow_per=isset($_G['system']['con_auto_borrow_per'])?$_G['system']['con_auto_borrow_per']:"1";


				if($v['timelimit_status'] == 1){

					if($borrow_result['isday']==1){
						//如果是天标
						if($v['timelimit_day_first']<=$v['timelimit_day_last']
								&& $v['timelimit_day_last']>=$borrow_result['time_limit_day']
								&& $v['timelimit_day_first']<=$borrow_result['time_limit_day']
								&&$v['timelimit_day_first']>0){

						}else{
							continue;
						}

					}else{
						//如果是月标
						if($v['timelimit_month_first']<=$v['timelimit_month_last']
								&& $v['timelimit_month_last']>=$borrow_result['time_limit']
								&& $v['timelimit_month_first']<=$borrow_result['time_limit']
								&&$v['timelimit_month_first']>0){

						}else{
							continue;
						}
					}
				}else{

				}//借款期限
				//设定自动投标的百分比参数，剩下的给手动 add by weego 20120525 end

				if ($u_row_detail['islock']==1){
					continue;//$msg = array("您账号已经被锁定，不能进行投标，请跟管理员联系");
				}elseif (!is_array($borrow_result)){

					continue;//$msg = array($borrow_result);
				}elseif ($borrow_result['account_yes']>=($borrow_result['account']*$auto_borrow_per)){

					//continue;//$msg = array("此标已满，请勿再投");
					break;
				}elseif ($borrow_result['verify_time'] == "" || $borrow_result['status'] != 1){
					continue;//$msg = array("此标尚未通过审核");
				}elseif(!is_numeric($account_money)){

					continue;//$msg = array("请输入正确的金额");
				}elseif ($borrow_result['most_account']>0 && ($borrow_result['tender_yes'] > $borrow_result['most_account'] || $borrow_result['tender_yes']+$account_money>$borrow_result['most_account'])){

					continue;//$msg = array("你的总投标金额".($borrow_result['tender_yes']+$account_money)."已经超过最高金额{$borrow_result['most_account']}");
				}else{

					$account_result =  accountClass::GetOne(array("user_id"=>$v['user_id']));//获取当前用户的余额

					if (($borrow_result['account']*$auto_borrow_per-$borrow_result['account_yes'])<$account_money){
						$account_money = $borrow_result['account']*$auto_borrow_per-$borrow_result['account_yes'];
					}

					if($account_result['use_money']<=0){
						continue;
					}
					if ($account_result['use_money']<$account_money){
						//continue;//$msg = array("您的余额不足");
						$account_money = $account_result['use_money'];
					}


					////else{
					$data['borrow_id'] = $borrow_id;
					$data['money'] = $account_money_s;

					$data['account'] = $account_money;

					if($account_money < $data_s['zuishao_jie']){
						continue;//不符合最好投资金额
					}



					$data['user_id'] = $v['user_id'];
					$data['status'] = 1;

					$result = self::AddTender($data);//添加借款标

					//if ($result==false){
					//echo "自动投标失败";
					//$msg = array($result);
					//}else{

					if($result === true){
						//echo "自动投标成功";
						//$msg = array("投标成功","","/index.php?user&q=code/borrow/bid");

						$have_auto_do[]=$v['user_id'];//不再判断此用户
						//下面的记录已经在addtender中生成了

						continue;
					}
					//}
				}
			}//foreach
		}//if false
	}//function

	//liukun add for bug 19 begin
	/**
	 * 获取流转标详细信息
	 *
	 * @param Array $data
	 * @return Array
	 */
	public static function GetCirculationOne($data = array()){
		global $mysql;
		$_sql = "where 1=1 ";

		if (isset($data['id']) && $data['id']!=""){
			$_sql .= " and  p1.id = '{$data['id']}' ";
		}
		$sql = "select p1.*  from  {circulation}  as p1
		$_sql
		";
		$result = $mysql->db_fetch_array($sql);

		return $result;
	}

	/**
	 * 获取流转标详细信息
	 *
	 * @param Array $data
	 * @return Array
	 */
	public static function Testbreak($data = array()){
		global $mysql;

		$sql = "insert into  {test}  set `addtime` = '".time()."', comment='test'";
		foreach($data as $key => $value){
			$sql .= ",`$key` = '$value'";
		}
		while(true){
			$result = $mysql->db_query($sql);
		}

		return $result;
	}

	/**
	 * 获取流转标回购的信息
	 *
	 * @param Array $data
	 * @return Array
	 */
	public static function GetBuybackInfo($data = array()){
		global $mysql;

		$buy_id = $data['buy_id'];
		$buy_result = borrowClass::GetCirculationBuyDetail(array("id"=>$buy_id));
		$circulation_result = borrowClass::GetCirculationOne(array("id"=>$buy_result['circulation_id']));
		$borrow_result = borrowClass::GetOne(array("id"=>$circulation_result['borrow_id']));//获取借款标的单独信息
		$begin_interest_time = $buy_result['begin_interest_time'];
		$can_interest_month = floor((time() - $begin_interest_time) / 3600 / 24 / 30);
		//因为开始计息时间是当天晚上23：59：59，所以这里要处理一下，不然购买了立刻回购，这里的值成-1了
		$can_interest_month = ($can_interest_month>=0)?$can_interest_month:0;

		$circulation_id = $buy_result['circulation_id'];
		$unit_price = $circulation_result['unit_price'];
		$begin_apr= $circulation_result['begin_apr'];
		$unit_num = $buy_result['unit_num'];
		$buy_apr = $buy_result['buy_apr'];
		$buy_type = $buy_result['buy_type'];
		$begin_interest_time = $buy_result['begin_interest_time'];
		$end_interest_time = $buy_result['end_interest_time'];

		//liukun add for bug 163 begin
		//用户认购时选择的购买月数，如果回购时时间不足够，利息只算初始利率的一半
		$buy_month_num = $buy_result['buy_month_num'];
		//liukun add for bug 163 end
		if($can_interest_month < $buy_month_num){
			$buy_apr = $begin_apr / 2;
			$borrow_style = $borrow_result['style'];
			if($borrow_style == 3){
				$interest = round($unit_num * $unit_price * $buy_apr / 12 / 100 * $can_interest_month, 2) - ($buy_result['monthly_interest_repay'] * ($buy_result['buy_month_num'] - $buy_result['repay_month_num']));
			}else {
				$interest = round($unit_num * $unit_price * $buy_apr / 12 / 100 * $can_interest_month, 2);
			}
		}else{
			// 				$interest = $buy_result['interest'];
			$interest = $buy_result['monthly_interest_repay'] * $buy_result['repay_month_num'];
		
		}
		
		
		$account_money = $unit_num * $unit_price;

		$result['interest'] = $interest;
		$result['account_money'] = $account_money;
		$result['can_interest_month'] = $can_interest_month;
		$result['auto_repurchase'] = $buy_result['auto_repurchase'];

		return $result;
	}

	//liukun add for bug 19 end

	//liukun add for bug 19 begin
	//流转标认购记录
	function GetPurchasedList($data = array()){
		global $mysql;
		$user_id = empty($data['user_id'])?"":$data['user_id'];
		$username = empty($data['username'])?"":$data['username'];

		$page = empty($data['page'])?1:$data['page'];
		$epage = empty($data['epage'])?10:$data['epage'];

		$_sql = "where 1=1";
		if (!empty($user_id)){
			$_sql .= " and p1.buyer_id = $user_id";
		}

		// 		if (!empty($username)){
		// 			$_sql .= " and p2.username = '$username'";
		// 		}
		// 		if (isset($data['borrow_id']) && $data['borrow_id']!=""){
		// 			$_sql .= " and p1.borrow_id = '{$data['borrow_id']}'";
		// 		}

		if (isset($data['dotime2'])){
			$dotime2 = ($data['dotime2']=="request")?$_REQUEST['dotime2']:$data['dotime2'];
			if( !isTimePattern($dotime2))$dotime2 = "";
			if ($dotime2!=""){
				$_sql .= " and p1.addtime <= ".get_mktime($dotime2);
			}
		}
		if (isset($data['dotime1'])){
			$dotime1 = ($data['dotime1']=="request")?$_REQUEST['dotime1']:$data['dotime1'];
			if( !isTimePattern($dotime1))$dotime1 = "";
			if ($dotime1!=""){
				$_sql .= " and p1.addtime >= ".get_mktime($dotime1);
			}
		}
		// 		if (isset($data['status']) && $data['status']!=""){
		// 			$_sql .= " and p1.status in ({$data['status']})";
		// 		}
		// 		if (isset($data['borrow_status']) && $data['borrow_status']!=""){
		// 			$_sql .= " and p3.status in ({$data['borrow_status']})";
		// 		}

		if (isset($data['keywords']) && $data['keywords']!=""){
			$_sql .= " and p3.name like '%".safegl($data['keywords'])."%'";
		}

		/*
		 $_select = " p1.*,p1.account as tender_account,p1.repayment_account - p1.repayment_yesaccount - p1.repayment_yesinterest as wait,
		p1.repayment_account - p1.account as wait_in,p2.username,p3.account ,p3.account_yes,p3.apr,p3.time_limit,p3.name as borrow_name,p4.username as op_username,p5.value as credit_jifen,p6.pic as credit_pic";
		$sql = "select SELECT from {borrow_tender} as p1
		left join {borrow} as p3 on p3.id=p1.borrow_id
		left join {user} as p2 on p1.user_id=p2.user_id
		left join {user} as p4 on p3.user_id=p4.user_id
		left join {credit} as p5 on p3.user_id=p5.user_id
		left join {credit_rank} as p6 on p5.value<=p6.point2  and p5.value>=p6.point1
		$_sql ORDER LIMIT";
		*/
		$_select = "p1.*, p2.borrow_id, p2.unit_price, p3.name as circulation_name, p4.username seller_name";
		$sql = "select SELECT from  {circulation_buy_serial}  as p1
		,  {circulation}  as p2,  {borrow}  as p3,  {user}  as p4
		{$_sql} and p1.circulation_id = p2.id and p2.borrow_id = p3.id and p3.user_id = p4.user_id ORDER LIMIT";

		//是否显示全部的信息
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


		return array(
				'list' => $list,
				'total' => $total,
				'page' => $page,
				'epage' => $epage,
				'total_page' => $total_page
		);

	}


	//liukun add for bug 19 end

	//liukun add for bug 19 begin
	//正在认购的流转标
	function GetPurchasingList($data = array()){
		global $mysql;
		$user_id = empty($data['user_id'])?"":$data['user_id'];
		$username = empty($data['username'])?"":$data['username'];

		$page = empty($data['page'])?1:$data['page'];
		$epage = empty($data['epage'])?10:$data['epage'];

		$_sql = "where 1=1";
		// 		if (!empty($user_id)){
		// 			$_sql .= " and p2.user_id = $user_id";
		// 		}

		// 		if (!empty($username)){
		// 			$_sql .= " and p2.username = '$username'";
		// 		}
		// 		if (isset($data['borrow_id']) && $data['borrow_id']!=""){
		// 			$_sql .= " and p1.borrow_id = '{$data['borrow_id']}'";
		// 		}

		// 		if (isset($data['dotime2'])){
		// 			$dotime2 = ($data['dotime2']=="request")?$_REQUEST['dotime2']:$data['dotime2'];
		// 			if( !isTimePattern($dotime2))$dotime2 = "";
		// 			if ($dotime2!=""){
		// 				$_sql .= " and p1.addtime <= ".get_mktime($dotime2);
		// 			}
		// 		}
		// 		if (isset($data['dotime1'])){
		// 			$dotime1 = ($data['dotime1']=="request")?$_REQUEST['dotime1']:$data['dotime1'];
		// 			if( !isTimePattern($dotime1))$dotime1 = "";
		// 			if ($dotime1!=""){
		// 				$_sql .= " and p1.addtime >= ".get_mktime($dotime1);
		// 			}
		// 		}
		// 		if (isset($data['status']) && $data['status']!=""){
		// 			$_sql .= " and p1.status in ({$data['status']})";
		// 		}
		// 		if (isset($data['borrow_status']) && $data['borrow_status']!=""){
		// 			$_sql .= " and p3.status in ({$data['borrow_status']})";
		// 		}

		// 		if (isset($data['keywords']) && $data['keywords']!=""){
		// 			$_sql .= " and p1.name like '%".safegl($data['keywords'])."%'";
		// 		}

		/*
		 $_select = " p1.*,p1.account as tender_account,p1.repayment_account - p1.repayment_yesaccount - p1.repayment_yesinterest as wait,
		p1.repayment_account - p1.account as wait_in,p2.username,p3.account ,p3.account_yes,p3.apr,p3.time_limit,p3.name as borrow_name,p4.username as op_username,p5.value as credit_jifen,p6.pic as credit_pic";
		$sql = "select SELECT from {borrow_tender} as p1
		left join {borrow} as p3 on p3.id=p1.borrow_id
		left join {user} as p2 on p1.user_id=p2.user_id
		left join {user} as p4 on p3.user_id=p4.user_id
		left join {credit} as p5 on p3.user_id=p5.user_id
		left join {credit_rank} as p6 on p5.value<=p6.point2  and p5.value>=p6.point1
		$_sql ORDER LIMIT";
		*/
		$_select = "p1.*, p2.name as circulation_name, p2.verify_time ";
		$sql = "select SELECT from  {circulation}  as p1,
		 {borrow}  as p2
		{$_sql} and p1.borrow_id = p2.id ORDER LIMIT";

		//是否显示全部的信息
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


		return array(
				'list' => $list,
				'total' => $total,
				'page' => $page,
				'epage' => $epage,
				'total_page' => $total_page
		);

	}

	//正在认购的流转标
	function GetMyCirculationList($data = array()){
		global $mysql;
		$user_id = empty($data['user_id'])?"":$data['user_id'];
		$username = empty($data['username'])?"":$data['username'];

		$page = empty($data['page'])?1:$data['page'];
		$epage = empty($data['epage'])?10:$data['epage'];

		$_sql = "where 1=1";
		// 		if (!empty($user_id)){
		// 			$_sql .= " and p2.user_id = $user_id";
		// 		}

		// 		if (!empty($username)){
		// 			$_sql .= " and p2.username = '$username'";
		// 		}
		// 		if (isset($data['borrow_id']) && $data['borrow_id']!=""){
		// 			$_sql .= " and p1.borrow_id = '{$data['borrow_id']}'";
		// 		}

		// 		if (isset($data['dotime2'])){
		// 			$dotime2 = ($data['dotime2']=="request")?$_REQUEST['dotime2']:$data['dotime2'];
		// 			if( !isTimePattern($dotime2))$dotime2 = "";
		// 			if ($dotime2!=""){
		// 				$_sql .= " and p1.addtime <= ".get_mktime($dotime2);
		// 			}
		// 		}
		// 		if (isset($data['dotime1'])){
		// 			$dotime1 = ($data['dotime1']=="request")?$_REQUEST['dotime1']:$data['dotime1'];
		// 			if( !isTimePattern($dotime1))$dotime1 = "";
		// 			if ($dotime1!=""){
		// 				$_sql .= " and p1.addtime >= ".get_mktime($dotime1);
		// 			}
		// 		}
		// 		if (isset($data['status']) && $data['status']!=""){
		// 			$_sql .= " and p1.status in ({$data['status']})";
		// 		}
		// 		if (isset($data['borrow_status']) && $data['borrow_status']!=""){
		// 			$_sql .= " and p3.status in ({$data['borrow_status']})";
		// 		}

		// 		if (isset($data['keywords']) && $data['keywords']!=""){
		// 			$_sql .= " and p1.name like '%".safegl($data['keywords'])."%'";
		// 		}

		/*
		 $_select = " p1.*,p1.account as tender_account,p1.repayment_account - p1.repayment_yesaccount - p1.repayment_yesinterest as wait,
		p1.repayment_account - p1.account as wait_in,p2.username,p3.account ,p3.account_yes,p3.apr,p3.time_limit,p3.name as borrow_name,p4.username as op_username,p5.value as credit_jifen,p6.pic as credit_pic";
		$sql = "select SELECT from {borrow_tender} as p1
		left join {borrow} as p3 on p3.id=p1.borrow_id
		left join {user} as p2 on p1.user_id=p2.user_id
		left join {user} as p4 on p3.user_id=p4.user_id
		left join {credit} as p5 on p3.user_id=p5.user_id
		left join {credit_rank} as p6 on p5.value<=p6.point2  and p5.value>=p6.point1
		$_sql ORDER LIMIT";
		*/
		//liukun add for bug 52 begin
		fb($user_id, FirePHP::TRACE);
		fb($_sql, FirePHP::TRACE);
		//liukun add for bug 52 end
		$_select = "p1.*, p2.name as circulation_name, p2.verify_time, p2.status ";
		$sql = "select SELECT from  {circulation}  as p1,
		 {borrow}  as p2
		{$_sql} and p1.borrow_id = p2.id and p2.user_id = {$user_id} ORDER LIMIT";

		//是否显示全部的信息
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


		return array(
				'list' => $list,
				'total' => $total,
				'page' => $page,
				'epage' => $epage,
				'total_page' => $total_page
		);

	}

	//liukun add for bug 19 begin
	//流转标认购记录
	function GetCirculationSellList($data = array()){
		global $mysql;
		$user_id = empty($data['user_id'])?"":$data['user_id'];
		$username = empty($data['username'])?"":$data['username'];

		$page = empty($data['page'])?1:$data['page'];
		$epage = empty($data['epage'])?10:$data['epage'];

		$_sql = "where 1=1";
		if (!empty($user_id)){
			$_sql .= " and p3.user_id = $user_id";
		}

		// 		if (!empty($username)){
		// 			$_sql .= " and p2.username = '$username'";
		// 		}
		// 		if (isset($data['borrow_id']) && $data['borrow_id']!=""){
		// 			$_sql .= " and p1.borrow_id = '{$data['borrow_id']}'";
		// 		}

		// 		if (isset($data['dotime2'])){
		// 			$dotime2 = ($data['dotime2']=="request")?$_REQUEST['dotime2']:$data['dotime2'];
		// 			if( !isTimePattern($dotime2))$dotime2 = "";
		// 			if ($dotime2!=""){
		// 				$_sql .= " and p1.addtime <= ".get_mktime($dotime2);
		// 			}
		// 		}
		// 		if (isset($data['dotime1'])){
		// 			$dotime1 = ($data['dotime1']=="request")?$_REQUEST['dotime1']:$data['dotime1'];
		// 			if( !isTimePattern($dotime1))$dotime1 = "";
		// 			if ($dotime1!=""){
		// 				$_sql .= " and p1.addtime >= ".get_mktime($dotime1);
		// 			}
		// 		}
		// 		if (isset($data['status']) && $data['status']!=""){
		// 			$_sql .= " and p1.status in ({$data['status']})";
		// 		}
		// 		if (isset($data['borrow_status']) && $data['borrow_status']!=""){
		// 			$_sql .= " and p3.status in ({$data['borrow_status']})";
		// 		}

		// 		if (isset($data['keywords']) && $data['keywords']!=""){
		// 			$_sql .= " and p1.name like '%".safegl($data['keywords'])."%'";
		// 		}

		/*
		 $_select = " p1.*,p1.account as tender_account,p1.repayment_account - p1.repayment_yesaccount - p1.repayment_yesinterest as wait,
		p1.repayment_account - p1.account as wait_in,p2.username,p3.account ,p3.account_yes,p3.apr,p3.time_limit,p3.name as borrow_name,p4.username as op_username,p5.value as credit_jifen,p6.pic as credit_pic";
		$sql = "select SELECT from {borrow_tender} as p1
		left join {borrow} as p3 on p3.id=p1.borrow_id
		left join {user} as p2 on p1.user_id=p2.user_id
		left join {user} as p4 on p3.user_id=p4.user_id
		left join {credit} as p5 on p3.user_id=p5.user_id
		left join {credit_rank} as p6 on p5.value<=p6.point2  and p5.value>=p6.point1
		$_sql ORDER LIMIT";
		*/
		$_select = "p1.*, p2.borrow_id, p2.unit_price, p3.name as circulation_name, user.username buyer_name";
		$sql = "select SELECT from  {circulation_buy_serial}  as p1
		,  {circulation}  as p2,  {borrow}  as p3,  {user}  as user
		{$_sql} and p1.circulation_id = p2.id and p2.borrow_id = p3.id and p1.buyer_id = user.user_id ORDER LIMIT";

		//是否显示全部的信息
		if (isset($data['limit']) ){
			$_limit = "";
			if ($data['limit'] != "all"){
				$_limit = "  limit ".$data['limit'];
			}
			$result= $mysql->db_fetch_arrays(str_replace(array('SELECT', 'ORDER', 'LIMIT'), array($_select,  'order by p3.id desc, p1.id desc', $_limit), $sql));


			return $result;
		}

		$row = $mysql->db_fetch_array(str_replace(array('SELECT', 'ORDER', 'LIMIT'), array('count(1) as num', '', ''), $sql));

		$total = $row['num'];
		$total_page = ceil($total / $epage);
		$index = $epage * ($page - 1);
		$limit = " limit {$index}, {$epage}";

		$list = $mysql->db_fetch_arrays(str_replace(array('SELECT', 'ORDER', 'LIMIT'), array($_select, 'order by p3.id desc, p1.id desc', $limit), $sql));
		$list = $list?$list:array();


		return array(
				'list' => $list,
				'total' => $total,
				'page' => $page,
				'epage' => $epage,
				'total_page' => $total_page
		);

	}
	//liukun add for bug 19 end

	//liukun add for bug 19 begin
	//流转标认购记录
	function GetBuybackList($data = array()){
		global $mysql;
		$user_id = empty($data['user_id'])?"":$data['user_id'];

		$page = empty($data['page'])?1:$data['page'];
		$epage = empty($data['epage'])?10:$data['epage'];

		$_sql = "where 1=1";
		if (!empty($user_id)){
			$_sql .= " and bw.user_id = $user_id";
		}

		// 		if (!empty($username)){
		// 			$_sql .= " and p2.username = '$username'";
		// 		}
		// 		if (isset($data['borrow_id']) && $data['borrow_id']!=""){
		// 			$_sql .= " and p1.borrow_id = '{$data['borrow_id']}'";
		// 		}

		// 		if (isset($data['dotime2'])){
		// 			$dotime2 = ($data['dotime2']=="request")?$_REQUEST['dotime2']:$data['dotime2'];
		// 			if( !isTimePattern($dotime2))$dotime2 = "";
		// 			if ($dotime2!=""){
		// 				$_sql .= " and p1.addtime <= ".get_mktime($dotime2);
		// 			}
		// 		}
		// 		if (isset($data['dotime1'])){
		// 			$dotime1 = ($data['dotime1']=="request")?$_REQUEST['dotime1']:$data['dotime1'];
		// 			if( !isTimePattern($dotime1))$dotime1 = "";
		// 			if ($dotime1!=""){
		// 				$_sql .= " and p1.addtime >= ".get_mktime($dotime1);
		// 			}
		// 		}
		// 		if (isset($data['status']) && $data['status']!=""){
		// 			$_sql .= " and p1.status in ({$data['status']})";
		// 		}
		// 		if (isset($data['borrow_status']) && $data['borrow_status']!=""){
		// 			$_sql .= " and p3.status in ({$data['borrow_status']})";
		// 		}

		// 		if (isset($data['keywords']) && $data['keywords']!=""){
		// 			$_sql .= " and p1.name like '%".safegl($data['keywords'])."%'";
		// 		}

		/*
		 $_select = " p1.*,p1.account as tender_account,p1.repayment_account - p1.repayment_yesaccount - p1.repayment_yesinterest as wait,
		p1.repayment_account - p1.account as wait_in,p2.username,p3.account ,p3.account_yes,p3.apr,p3.time_limit,p3.name as borrow_name,p4.username as op_username,p5.value as credit_jifen,p6.pic as credit_pic";
		$sql = "select SELECT from {borrow_tender} as p1
		left join {borrow} as p3 on p3.id=p1.borrow_id
		left join {user} as p2 on p1.user_id=p2.user_id
		left join {user} as p4 on p3.user_id=p4.user_id
		left join {credit} as p5 on p3.user_id=p5.user_id
		left join {credit_rank} as p6 on p5.value<=p6.point2  and p5.value>=p6.point1
		$_sql ORDER LIMIT";
		*/
			
			
		$_select = " cs.end_interest_time, sum(cs.capital) need_capital,  sum(cs.interest) need_interest ";
		$sql = "select SELECT from (select cs.end_interest_time, sum(cs.capital) need_capital,  sum(cs.interest) need_interest from  {circulation_buy_serial}  cs,  {circulation}  cn , {borrow}  bw
		{$_sql} and cs.circulation_id = cn.id and cn.borrow_id = bw.id and  cs.buyback  = 0 group by cs.end_interest_time) as tmp ORDER LIMIT";

		//是否显示全部的信息
		if (isset($data['limit']) ){
			$_limit = "";
			if ($data['limit'] != "all"){
				$_limit = "  limit ".$data['limit'];
			}
			$result= $mysql->db_fetch_arrays(str_replace(array('SELECT', 'ORDER', 'LIMIT'), array("*",  'order by end_interest_time asc', $_limit), $sql));


			return $result;
		}

		$row = $mysql->db_fetch_array(str_replace(array('SELECT', 'ORDER', 'LIMIT'), array('count(1) as num', '', ''), $sql));

		$total = $row['num'];
		$total_page = ceil($total / $epage);
		$index = $epage * ($page - 1);
		$limit = " limit {$index}, {$epage}";

		$list = $mysql->db_fetch_arrays(str_replace(array('SELECT', 'ORDER', 'LIMIT'), array("*",  'order by end_interest_time asc', $limit), $sql));
		$list = $list?$list:array();


		return array(
				'list' => $list,
				'total' => $total,
				'page' => $page,
				'epage' => $epage,
				'total_page' => $total_page
		);

	}
	//liukun add for bug 19 end

	/**
	 * 获取流转标详细信息
	 *
	 * @param Array $data
	 * @return Array
	 */
	public static function GetCirculationBuyDetail($data = array()){
		global $mysql;
		$_sql = "where 1=1 ";

		if (isset($data['id']) && $data['id']!=""){
			$_sql .= " and  p1.id = '{$data['id']}' ";
		}
		$sql = "select p1.*  from  {circulation_buy_serial}  as p1
		$_sql
		";
		$result = $mysql->db_fetch_array($sql);

		return $result;
	}

	//liukun add for bug 19 end

	//liukun add for bug 21 begin
	/**
	 * 增加债权转让标记录
	 *
	 * @param Array $data
	 * @return Boolen
	 */
	function AddAlienate($data = array()){
		global $mysql, $_G;
		//liukun add for bug 52 begin
		fb($data, FirePHP::TRACE);
		//liukun add for bug 52 end
		$data['valid'] = 1;
		$data['status'] = 1;
		$data['valid_unit_num'] = round($data['price'] / $data['unit']);
		$data['total_unit_num'] = round($data['price'] / $data['unit']);

		$borrow_right_id = $data['borrow_right_id'];

		if (($data['price'] % $data['unit']) != 0){
			$msg = "转让价格必须是转让单位的整数倍。";
			return $msg;
		}

		//liukun add for bug 191 begin
		//判断是否已经存在有效的转让标
		$sql = "select count(*) as num  from  {borrow_right_alienate} 
		where borrow_right_id='{$borrow_right_id}' and status = 1 and valid = 1";
		$right_count_result = $mysql ->db_fetch_array($sql);

		if ($right_count_result['num'] >= 1){
			$msg = "已经有有效的债权转让标，不能重复转让。";
			return $msg;
		}
		//liukun add for bug 191 end


		//取出borrow_right的amount has_percent 存储到转让表中去，转让的时候要用到发标时的has_percent信息，
		$sql = "select br.has_percent, bo.repayment_account,  bo.repayment_yesaccount from  {borrow_right}  as br,  {borrow}  as bo
		where br.id='{$borrow_right_id}' and br.borrow_id = bo.id";
		$right_result = $mysql ->db_fetch_array($sql);


		$data['has_percent'] = $right_result['has_percent'];
		$data['amount'] = round(($right_result['repayment_account'] - $right_result['repayment_yesaccount']) * $right_result['has_percent'] / 100, 2);


		$sql = "insert into  {borrow_right_alienate}  set `addtime` = '".time()."',`addip` = '".ip_address()."'";
		foreach($data as $key => $value){
			$sql .= ",`$key` = '$value'";
		}
		$res = $mysql->db_query($sql);

		return $res;
	}
	//liukun add for bug 21 end

	//liukun add from bug 76 begin
	//获取已经发布的债权转让标列表
	function GetAlienateList($data){
		global $mysql,$_G;
			
		$user_id =$data['user_id'];
		$page = empty($data['page'])?1:$data['page'];
		$epage = empty($data['epage'])?10:$data['epage'];
		$_sql = "";
		// 		if (isset($data['type']) && $data['type']!=""){
		// 			if ($data['type']=="wait"){
		// 				$_sql = " and bt.repayment_yesaccount!=bt.repayment_account";
		// 			}elseif ($data['type']=="yes"){
		// 				$_sql = " and bt.repayment_yesaccount=bt.repayment_account ";
		// 			}
		// 		}

		// 		if (isset($data['dotime1']) && $data['dotime1']!=""){
		// 			$dotime1 = ($data['dotime1']=="request")?$_REQUEST['dotime1']:$data['dotime1'];
		// 			if( !isTimePattern($dotime1))$dotime1 = "";
		// 			if ($dotime1!=""){
		// 				$_sql .= " and bt.addtime >= ".get_mktime($dotime1);
		// 			}
		// 		}

		// 		if (isset($data['dotime2']) && $data['dotime2']!=""){
		// 			$dotime2 = ($data['dotime2']=="request")?$_REQUEST['dotime2']:$data['dotime2'];
		// 			if( !isTimePattern($dotime2))$dotime2 = "";
		// 			if ($dotime2!=""){
		// 				$_sql .= " and bt.addtime <= ".get_mktime($dotime2);
		// 			}
		// 		}

		// 		if (isset($data['keywords']) && $data['keywords']!=""){
		// 			$keywords = ($data['keywords']=="request")?$_REQUEST['keywords']:$data['keywords'];
		// 			if ($keywords!=""){
		// 				$_sql .= " and bo.name like'%".safegl($keywords)."%'";
		// 			}
		// 		}




		$_select= "ba.*, br.origin_creditor_level, bw.name borrow_name, bw.id borrow_id, user.username ";
		$sql = "select SELECT from  {borrow_right_alienate}  as ba,  {borrow_right}  as br,   {borrow}  as bw,  {user}  as user
		where ba.borrow_right_id = br.id and br.borrow_id=bw.id and br.creditor_id = user.user_id and ba.status = 1 and ba.valid = 1
		ORDER LIMIT ";


		//是否显示全部的信息
		if (isset($data['limit']) ){
			$_limit = "";
			if ($data['limit'] != "all"){
				$_limit = "  limit ".$data['limit'];
			}
			return $mysql->db_fetch_arrays(str_replace(array('SELECT', 'ORDER', 'LIMIT'), array($_select,  'order by ba.id desc', $_limit), $sql));
		}

		$row = $mysql->db_fetch_array(str_replace(array('SELECT', 'ORDER', 'LIMIT'), array("count(ba.id) as num","",""),$sql));

		$total = $row['num'];
		$total_page = ceil($total / $epage);
		$index = $epage * ($page - 1);
		$limit = " limit {$index}, {$epage}";

		$list = $mysql->db_fetch_arrays(str_replace(array('SELECT', 'ORDER', 'LIMIT'), array($_select, 'order by ba.id desc', $limit), $sql));
		$list = $list?$list:array();
		return array(
				'list' => $list,
				'total' => $total,
				'page' => $page,
				'epage' => $epage,
				'total_page' => $total_page
		);
	}
	//liukun add from bug 76 end

	/**
	 * 获取债权转让信息
	 *
	 * @param Array $data
	 * @return Array
	 */
	public static function GetAlienateDetail($data = array()){
		global $mysql;
		$_sql = "where 1=1 ";

		if (isset($data['id']) && $data['id']!=""){
			$_sql .= " and  p1.id = '{$data['id']}' ";
		}
		$sql = "select round(p1.has_percent, 2) right_percent, p1.*, p2.origin_creditor_level  from  {borrow_right_alienate}  as p1,  {borrow_right}  as p2
		$_sql and p1.borrow_right_id = p2.id
		";
		$result = $mysql->db_fetch_array($sql);

		return $result;
	}

	//liukun add for bug 78 begin


	/**
	 * 增加债权转让标记录
	 *
	 * @param Array $data
	 * @return Boolen
	 */
	function BuyAlienate($data = array()){
		global $mysql;global $_G;
		$alienate_fee_rate = isset($_G['system']['con_right_alienate_fee'])?$_G['system']['con_right_alienate_fee']:"0.04";

		//liukun add for bug 52 begin
		fb($data, FirePHP::TRACE);
		//liukun add for bug 52 end
		$buyer_id = $_G['user_id'];

		//liukun add for bug 188 begin
		$sql = "select * from  {user}  where user_id={$buyer_id}";
		$userPermission = $mysql ->db_fetch_array($sql);

		if ($userPermission['is_restructuring'] == 1){
			$msg = "你目前是债务重组中，不能购买债权";
			return $msg;
		}
		//liukun add for bug 188 end


		$data['buyer_id'] = $buyer_id;
		$data['buy_time'] = time();

		$right_alienate_id = $data['right_alienate_id'];

		$sql = "select ba.*, br.borrow_id, br.creditor_id, br.origin_creditor_level, ba.has_percent, br.has_percent left_percent,bw.name as borrow_name  from  {borrow_right_alienate}  ba,  {borrow_right}  as br,  {borrow}  as bw  where ba.id={$data['right_alienate_id']} and ba.borrow_right_id = br.id and br.borrow_id = bw.id";
		$right_result = $mysql ->db_fetch_array($sql);

		//自己不能购买自己的债权
		if($buyer_id == $right_result['creditor_id']){
			$msg = "自己不能购买。";
			return $msg;
		}

		$buy_unit_num = $data['unit_num'];
		// 购买份数要小于最大可购份数
		if($right_result['valid_unit_num'] < $data['unit_num']){
			$buy_unit_num = $right_result['valid_unit_num'];
		}
		//TODO 可用余额大于购买所需要的金额
		$account_result =  accountClass::GetOne(array("user_id"=>$buyer_id));
		if ($account_result['use_money'] < round($right_result[unit] * $buy_unit_num, 2)){
			$msg = "可用余额不足。";
			return $msg;
		}

		// 计算购买的原始债权的比例
		$data['bought_right_percent'] = $right_result['has_percent'] * $buy_unit_num / $right_result['total_unit_num'];
		$data['bought_right'] = round($right_result['amount'] / $right_result['has_percent']  * $data['bought_right_percent'], 2);


		//liukun add for bug 472 begin
		$mysql->db_query("start transaction");
		//liukun add for bug 472 end
		$transaction_result = true;
		try{
			$sql = "insert into  {borrow_right_alienate_serial}  set `addtime` = '".time()."',`addip` = '".ip_address()."'";
			foreach($data as $key => $value){
				$sql .= ",`$key` = '$value'";
			}
			$transaction_result = $mysql->db_query($sql);
			if ($transaction_result !==true){
				throw new Exception();
			}

			//更新债权转让信息
			$sql = "update  {borrow_right_alienate}  set `valid_unit_num` = valid_unit_num - {$buy_unit_num} where id = {$data['right_alienate_id']}";

			$transaction_result = $mysql->db_query($sql);
			if ($transaction_result !==true){
				throw new Exception();
			}
			//如果债权全部转让出去了，那borrow_right中就不在保留用户的债权0记录了--这种做法不合适
			if (($right_result['left_percent'] - $data['bought_right_percent'])<0.00000001){
				//转让完了，债权记录状态设置为转让完
				$sql = "update   {borrow_right}  set status = 2, has_percent = 0 where id = {$right_result['borrow_right_id']}";

				$transaction_result = $mysql->db_query($sql);
				if ($transaction_result !==true){
					throw new Exception();
				}

				//转让完了，债权转让标也要设置为发售完的状态
				$status = 2;
				$sql = "update  {borrow_right_alienate}  set `status` = {$status} where id = {$right_alienate_id}";

				$transaction_result = $mysql->db_query($sql);
				if ($transaction_result !==true){
					throw new Exception();
				}

			}else{
				//售出者减少债权
				$sql = "update  {borrow_right}  set has_percent = has_percent - {$data['bought_right_percent']} where id = {$right_result['borrow_right_id']}";

				$transaction_result = $mysql->db_query($sql);
				if ($transaction_result !==true){
					throw new Exception();
				}
			}


			//购入者如果原来有债权了，就update,如果没有的话，要新增一条债权记录
			$sql = "select count(id) as num from  {borrow_right}  where borrow_id = {$right_result['borrow_id']} and creditor_id = {$buyer_id} and status = 1 and origin_creditor_level = {$right_result['origin_creditor_level']}";
			$result = $mysql ->db_fetch_array($sql);

			if ($result['num'] == 0){
				$borrow_right_data['borrow_id'] = $right_result['borrow_id'];
				$borrow_right_data['creditor_id'] = $buyer_id;
				$borrow_right_data['status'] = 1;
				$borrow_right_data['valid_begin_time'] = time();
				$borrow_right_data['has_percent'] = $data['bought_right_percent'];
				$borrow_right_data['origin_creditor_level'] = $right_result['origin_creditor_level'];

				$sql = "insert into  {borrow_right}  set `addtime` = '".time()."',`addip` = '".ip_address()."'";
				foreach($borrow_right_data as $key => $value){
					$sql .= ",`$key` = '$value'";
				}
				$transaction_result = $mysql->db_query($sql);
				if ($transaction_result !==true){
					throw new Exception();
				}

			}
			else {
				$sql = "update  {borrow_right}  set has_percent = has_percent + {$data['bought_right_percent']} where borrow_id = {$right_result['borrow_id']} and creditor_id = {$buyer_id} and origin_creditor_level = {$right_result['origin_creditor_level']}";

				$transaction_result = $mysql->db_query($sql);
				if ($transaction_result !==true){
					throw new Exception();
				}
			}

			//代收的变动量
			$collection_amount = $data['bought_right'];
			//liukun add for bug 143 begin
			//售出者得到购买债权的资金,代收减少
			$account_result =  accountClass::GetOne(array("user_id"=>$right_result['creditor_id']));
			$account_log['user_id'] =$right_result['creditor_id'];
			$account_log['type'] = "sell_borrow_right";
			$account_log['money'] = round($right_result[unit] * $buy_unit_num, 2);
			$account_log['total'] = $account_result['total']+$account_log['money'] - $collection_amount;
			$account_log['use_money'] = $account_result['use_money']+$account_log['money'];
			$account_log['no_use_money'] = $account_result['no_use_money'];
			//liukun add for bug 138 begin
			$account_log['collection'] =$account_result['collection'] - $collection_amount;
			//liukun add for bug 138 end
			$account_log['to_user'] = $buyer_id;
			$account_log['remark'] = "售出[<a href=\'/invest/a{$right_result['borrow_id']}.html\' target=_blank>{$right_result['borrow_name']}</a>]债权收款(债权表)";
			$transaction_result = accountClass::AddLog($account_log);
			if ($transaction_result !==true){
				throw new Exception();
			}

			//购入者支付购买债权的资金,代收增加
			$account_result =  accountClass::GetOne(array("user_id"=>$buyer_id));
			$account_log['user_id'] =$buyer_id;
			$account_log['type'] = "buy_borrow_right";
			$account_log['money'] = round($right_result[unit] * $buy_unit_num, 2);
			$account_log['total'] = $account_result['total'] - $account_log['money'] + $collection_amount;
			$account_log['use_money'] = $account_result['use_money'] - $account_log['money'];
			$account_log['no_use_money'] = $account_result['no_use_money'];
			//liukun add for bug 138 begin
			$account_log['collection'] =$account_result['collection'] + $collection_amount;
			//liukun add for bug 138 end
			$account_log['to_user'] = $right_result['creditor_id'];
			$account_log['remark'] = "购入[<a href=\'/invest/a{$right_result['borrow_id']}.html\' target=_blank>{$right_result['borrow_name']}</a>]债权付款(债权表)";
			$transaction_result = accountClass::AddLog($account_log);
			if ($transaction_result !==true){
				throw new Exception();
			}
			//liukun add for bug 143 end

			//liukun add for bug 152 begin
			$alienate_fee = round($right_result[unit] * $buy_unit_num * $alienate_fee_rate, 2);
			$account_result =  accountClass::GetOne(array("user_id"=>$right_result['creditor_id']));
			$account_log['user_id'] =$right_result['creditor_id'];
			$account_log['type'] = "sell_borrow_right_fee";
			$account_log['money'] = $alienate_fee;
			$account_log['total'] = $account_result['total']-$account_log['money'];
			$account_log['use_money'] = $account_result['use_money']-$account_log['money'];
			$account_log['no_use_money'] = $account_result['no_use_money'];
			$account_log['collection'] =$account_result['collection'];
			$account_log['to_user'] = 0;
			$account_log['remark'] = "售出[<a href=\'/invest/a{$right_result['borrow_id']}.html\' target=_blank>{$right_result['borrow_name']}</a>]债权，转让成功收费(债权表)";
			$transaction_result = accountClass::AddLog($account_log);
			if ($transaction_result !==true){
				throw new Exception();
			}
			//liukun add for bug 152 end

		}
		catch(Exception $e){
			$mysql->db_query("rollback");
		}

		//liukun add for bug 472 begin
		if($transaction_result===true){
			$mysql->db_query("commit");
		}else{
			$mysql->db_query("rollback");
		}
		return $transaction_result;
		//liukun add for bug 472 end
	}
	//liukun add for bug 78 end

	//liukun add from bug 79 begin
	//获取我发布的债权转让标列表
	function GetMyPostedAlienateList($data){
		global $mysql,$_G;
			
		$user_id =$data['user_id'];
		$page = empty($data['page'])?1:$data['page'];
		$epage = empty($data['epage'])?10:$data['epage'];
		$_sql = "";
		// 		if (isset($data['type']) && $data['type']!=""){
		// 			if ($data['type']=="wait"){
		// 				$_sql = " and bt.repayment_yesaccount!=bt.repayment_account";
		// 			}elseif ($data['type']=="yes"){
		// 				$_sql = " and bt.repayment_yesaccount=bt.repayment_account ";
		// 			}
		// 		}

		// 		if (isset($data['dotime1']) && $data['dotime1']!=""){
		// 			$dotime1 = ($data['dotime1']=="request")?$_REQUEST['dotime1']:$data['dotime1'];
		// 			if( !isTimePattern($dotime1))$dotime1 = "";
		// 			if ($dotime1!=""){
		// 				$_sql .= " and bt.addtime >= ".get_mktime($dotime1);
		// 			}
		// 		}

		// 		if (isset($data['dotime2']) && $data['dotime2']!=""){
		// 			$dotime2 = ($data['dotime2']=="request")?$_REQUEST['dotime2']:$data['dotime2'];
		// 			if( !isTimePattern($dotime2))$dotime2 = "";
		// 			if ($dotime2!=""){
		// 				$_sql .= " and bt.addtime <= ".get_mktime($dotime2);
		// 			}
		// 		}

		// 		if (isset($data['keywords']) && $data['keywords']!=""){
		// 			$keywords = ($data['keywords']=="request")?$_REQUEST['keywords']:$data['keywords'];
		// 			if ($keywords!=""){
		// 				$_sql .= " and bo.name like'%".safegl($keywords)."%'";
		// 			}
		// 		}




		$_select= "ba.*, br.origin_creditor_level, bw.name borrow_name, bw.id borrow_id ";
		$sql = "select SELECT from  {borrow_right_alienate}  as ba,  {borrow_right}  as br,   {borrow}  as bw
		where ba.borrow_right_id = br.id and br.borrow_id=bw.id   and br.creditor_id = {$user_id} ORDER LIMIT ";


		//是否显示全部的信息
		if (isset($data['limit']) ){
			$_limit = "";
			if ($data['limit'] != "all"){
				$_limit = "  limit ".$data['limit'];
			}
			return $mysql->db_fetch_arrays(str_replace(array('SELECT', 'ORDER', 'LIMIT'), array($_select,  'order by ba.id desc', $_limit), $sql));
		}

		$row = $mysql->db_fetch_array(str_replace(array('SELECT', 'ORDER', 'LIMIT'), array("count(ba.id) as num","",""),$sql));

		$total = $row['num'];
		$total_page = ceil($total / $epage);
		$index = $epage * ($page - 1);
		$limit = " limit {$index}, {$epage}";

		$list = $mysql->db_fetch_arrays(str_replace(array('SELECT', 'ORDER', 'LIMIT'), array($_select, 'order by ba.id desc', $limit), $sql));
		$list = $list?$list:array();
		return array(
				'list' => $list,
				'total' => $total,
				'page' => $page,
				'epage' => $epage,
				'total_page' => $total_page
		);
	}
	//liukun add from bug 79 end

	//liukun add for bug 81 begin
	/**
	 * 增加债权转让标记录
	 *
	 * @param Array $data
	 * @return Boolen
	 */
	function CancelAlienate($data = array()){
		global $mysql;global $_G;
		$max = isset($_G['system']['con_borrow_maxaccount'])?$_G['system']['con_borrow_maxaccount']:"50000";
		$min = isset($_G['system']['con_borrow_minaccount'])?$_G['system']['con_borrow_minaccount']:"500";
		$apr = isset($_G['system']['con_borrow_apr'])?$_G['system']['con_borrow_apr']:"22.18";
		// 		if (!isset($data['user_id']) && trim($data['user_id'])==""){
		// 			return self::NO_LOGIN;
		// 		}
		// 		if (!isset($data['name']) && trim($data['name'])==""){
		// 			return self::BORROW_NAME_NO_EMPTY;
		// 		}
		// 		if (!isset($data['account']) || trim($data['account'])==""){
		// 			return self::BORROW_ACCOUNT_NO_EMPTY;
		// 		}
		// 		if ($data['is_vouch']!=1){
		// 			$result = self::GetAmountOne($data['user_id'],"credit");
		// 		}else{
		// 			$result = self::GetAmountOne($data['user_id'],"borrow_vouch");
		// 		}
		/*
		 if(!$data['is_fast']){
		$data['status'] = 1;
		$data['verify_user'] = 1;
		$data['verify_remark'] = '自动审核';
		$data['verify_time'] = time();
		}*/

		// 		if (!$data['is_mb'] && isset($data['account']) && $data['account']>$result['account_use']){
		// 			//return self::BORROW_ACCOUNT_MAZ_ACC;
		// 		}


		// 		if($data['account'] > $max){
		// 			return self::BORROW_ACCOUNT_NO_MAX;
		// 		}

		// 		if($data['account'] < $min){
		// 			return self::BORROW_ACCOUNT_NO_MIN;
		// 		}
		// 		if (!isset($data['apr']) || trim($data['apr'])==""){
		// 			return self::BORROW_APR_NO_EMPTY;
		// 		}
		// 		if ($data['apr']>$apr){
		// 			return self::BORROW_APR_NO_MAX;
		// 		}
		// 		$eq['account'] = $data['account'];
		// 		$eq['year_apr'] = $data['apr'];
		// 		$eq['month_times'] = $data['time_limit'];
		// 		$eq['type'] = "all";
		// 		$eq['borrow_style'] = $data['style'];
		// 		///add by weego for 天标
		// 		$eq['isday'] = $data['isday'];
		// 		$eq['time_limit_day'] = $data['time_limit_day'];
		// 		$result = self::EqualInterest($eq);
		// 		$data['repayment_account'] = $result['repayment_account'];
		// 		$data['monthly_repayment'] = $result['monthly_repayment'];
		// 		$fid = $data['fastid'];
		// 		unset($data['fastid']);
		//liukun add for bug 52 begin
		fb($data, FirePHP::TRACE);
		//liukun add for bug 52 end
		$right_alienate_id = $data['right_alienate_id'];

		//TODO 转让标的状态列表
		//TODO 这里先假定status为0时表示被撤消,1表示正在出售，2表示销售完毕
		$status = 0;
		$sql = "update  {borrow_right_alienate}  set `status` = {$status} where id = {$right_alienate_id}";

		$res = $mysql->db_query($sql);

		return $res;
	}
	//liukun add for bug 81 end

	//liukun add from bug 83 begin
	//获取我购买的债权列表
	function GetMyBuyAlienateList($data){
		global $mysql,$_G;
			
		$user_id =$data['user_id'];
		$page = empty($data['page'])?1:$data['page'];
		$epage = empty($data['epage'])?10:$data['epage'];
		$_sql = "";
		// 		if (isset($data['type']) && $data['type']!=""){
		// 			if ($data['type']=="wait"){
		// 				$_sql = " and bt.repayment_yesaccount!=bt.repayment_account";
		// 			}elseif ($data['type']=="yes"){
		// 				$_sql = " and bt.repayment_yesaccount=bt.repayment_account ";
		// 			}
		// 		}

		// 		if (isset($data['dotime1']) && $data['dotime1']!=""){
		// 			$dotime1 = ($data['dotime1']=="request")?$_REQUEST['dotime1']:$data['dotime1'];
		// 			if( !isTimePattern($dotime1))$dotime1 = "";
		// 			if ($dotime1!=""){
		// 				$_sql .= " and bt.addtime >= ".get_mktime($dotime1);
		// 			}
		// 		}

		// 		if (isset($data['dotime2']) && $data['dotime2']!=""){
		// 			$dotime2 = ($data['dotime2']=="request")?$_REQUEST['dotime2']:$data['dotime2'];
		// 			if( !isTimePattern($dotime2))$dotime2 = "";
		// 			if ($dotime2!=""){
		// 				$_sql .= " and bt.addtime <= ".get_mktime($dotime2);
		// 			}
		// 		}

		// 		if (isset($data['keywords']) && $data['keywords']!=""){
		// 			$keywords = ($data['keywords']=="request")?$_REQUEST['keywords']:$data['keywords'];
		// 			if ($keywords!=""){
		// 				$_sql .= " and bo.name like'%".safegl($keywords)."%'";
		// 			}
		// 		}



		$buyer_id = $_G['user_id'];

		$_select= "bs.*, round(bs.bought_right_percent, 2) bought_right_percent_f,  bw.name borrow_name, br.borrow_id, ba.unit ";
		$sql = "select SELECT from  {borrow_right_alienate_serial}  as bs,  {borrow_right_alienate} ba,  {borrow_right}  br,  {borrow}  bw
		where  bs.right_alienate_id = ba.id and ba.borrow_right_id = br.id and br.borrow_id = bw.id
		and bs.buyer_id = {$buyer_id}  ORDER LIMIT ";


		//是否显示全部的信息
		if (isset($data['limit']) ){
			$_limit = "";
			if ($data['limit'] != "all"){
				$_limit = "  limit ".$data['limit'];
			}
			return $mysql->db_fetch_arrays(str_replace(array('SELECT', 'ORDER', 'LIMIT'), array($_select,  'order by bs.id desc', $_limit), $sql));
		}

		$row = $mysql->db_fetch_array(str_replace(array('SELECT', 'ORDER', 'LIMIT'), array("count(bs.id) as num","",""),$sql));

		$total = $row['num'];
		$total_page = ceil($total / $epage);
		$index = $epage * ($page - 1);
		$limit = " limit {$index}, {$epage}";

		$list = $mysql->db_fetch_arrays(str_replace(array('SELECT', 'ORDER', 'LIMIT'), array($_select, 'order by bs.id desc', $limit), $sql));
		$list = $list?$list:array();
		return array(
				'list' => $list,
				'total' => $total,
				'page' => $page,
				'epage' => $epage,
				'total_page' => $total_page
		);
	}
	//liukun add from bug 83 end

	//liukun add from bug 84 begin
	//获取我购买的债权列表
	function GetMySellAlienateList($data){
		global $mysql,$_G;
			
		$user_id =$data['user_id'];
		$page = empty($data['page'])?1:$data['page'];
		$epage = empty($data['epage'])?10:$data['epage'];
		$_sql = "";
		// 		if (isset($data['type']) && $data['type']!=""){
		// 			if ($data['type']=="wait"){
		// 				$_sql = " and bt.repayment_yesaccount!=bt.repayment_account";
		// 			}elseif ($data['type']=="yes"){
		// 				$_sql = " and bt.repayment_yesaccount=bt.repayment_account ";
		// 			}
		// 		}

		// 		if (isset($data['dotime1']) && $data['dotime1']!=""){
		// 			$dotime1 = ($data['dotime1']=="request")?$_REQUEST['dotime1']:$data['dotime1'];
		// 			if( !isTimePattern($dotime1))$dotime1 = "";
		// 			if ($dotime1!=""){
		// 				$_sql .= " and bt.addtime >= ".get_mktime($dotime1);
		// 			}
		// 		}

		// 		if (isset($data['dotime2']) && $data['dotime2']!=""){
		// 			$dotime2 = ($data['dotime2']=="request")?$_REQUEST['dotime2']:$data['dotime2'];
		// 			if( !isTimePattern($dotime2))$dotime2 = "";
		// 			if ($dotime2!=""){
		// 				$_sql .= " and bt.addtime <= ".get_mktime($dotime2);
		// 			}
		// 		}

		// 		if (isset($data['keywords']) && $data['keywords']!=""){
		// 			$keywords = ($data['keywords']=="request")?$_REQUEST['keywords']:$data['keywords'];
		// 			if ($keywords!=""){
		// 				$_sql .= " and bo.name like'%".safegl($keywords)."%'";
		// 			}
		// 		}



		$creditor_id = $_G['user_id'];

		$_select= "bs.*, round(bs.bought_right_percent, 2) bought_right_percent_f, bw.name borrow_name, br.borrow_id, ba.unit, user.username ";
		$sql = "select SELECT from  {borrow_right_alienate_serial}  as bs,  {borrow_right_alienate} ba,  {borrow_right}  br,  {borrow}  bw,  {user}  user
		where  bs.right_alienate_id = ba.id and ba.borrow_right_id = br.id and br.borrow_id = bw.id
		and br.creditor_id = {$creditor_id} and bs.buyer_id = user.user_id ORDER LIMIT ";


		//是否显示全部的信息
		if (isset($data['limit']) ){
			$_limit = "";
			if ($data['limit'] != "all"){
				$_limit = "  limit ".$data['limit'];
			}
			return $mysql->db_fetch_arrays(str_replace(array('SELECT', 'ORDER', 'LIMIT'), array($_select,  'order by bs.id desc', $_limit), $sql));
		}

		$row = $mysql->db_fetch_array(str_replace(array('SELECT', 'ORDER', 'LIMIT'), array("count(bs.id) as num","",""),$sql));

		$total = $row['num'];
		$total_page = ceil($total / $epage);
		$index = $epage * ($page - 1);
		$limit = " limit {$index}, {$epage}";

		$list = $mysql->db_fetch_arrays(str_replace(array('SELECT', 'ORDER', 'LIMIT'), array($_select, 'order by bs.id desc', $limit), $sql));
		$list = $list?$list:array();
		return array(
				'list' => $list,
				'total' => $total,
				'page' => $page,
				'epage' => $epage,
				'total_page' => $total_page
		);
	}
	//liukun add from bug 84 end

	function get_biao_type_info($data = array()){
		global $mysql;

		$biao_type = $data['biao_type'];

		$sql = "select * from  {biao_type}  where biao_type_name='{$biao_type}'";
		$result = $mysql ->db_fetch_array($sql);

		return $result;

	}

	function get_available_biao_type($data = array()){
		global $mysql;
		if (isset($data['allow_biaotype']) && $data['allow_biaotype']!=""){
			$_where = " and biao_type_name in (";
			$allow_biaotype = explode(":", $data['allow_biaotype']);
			foreach ($allow_biaotype as $key => $value){

				$_where .="'".$value."', ";
			}
			$_where .= " '') ";
		}

		$sql = "select biao_type_name from  {biao_type}  where available = 1".$_where;
		$result = $mysql ->db_fetch_arrays($sql);

		//liukun add for bug 52 begin
		fb($result, FirePHP::TRACE);
		//liukun add for bug 52 end
		foreach ($result as $key => $value){
			$biao_type_list[] = $value['biao_type_name'];
		}

		return $biao_type_list;

	}

	//liukun add for bug 229 begin
	/**
	 * 获取标的分类统计：根据发标时选择的借款用途统计 borrow.use
	 *
	 * @param Array $data
	 * @return Array
	 */
	public static function GetBorrowStatistics($data = array()){
		global $mysql;

		$sql = "select * from  {linkage}  where type_id =(select id from  {linkage_type} 
		where nid = 'borrow_use')";
		$use_type = $mysql ->db_fetch_arrays($sql);

		//liukun add for site_id search begin
		if (isset($data['areaid']) && $data['areaid']!="0"){
			$_sql .= " and areaid = {$data['areaid']} ";
		}
		//liukun add for biao_type search begin

		$sql = "select count(*) as num, `use` from  {borrow} 
		where status = 1 or status = 3 ".$_sql
		."group by  `use`";
		$result = $mysql ->db_fetch_arrays($sql);

		//liukun add for bug 52 begin
		fb($use_type, FirePHP::TRACE);
		fb($result, FirePHP::TRACE);
		//liukun add for bug 52 end

		$borrow_total = 0;

		$i=0;
		foreach ($use_type as $key => $use){
			$use_type[$i]['borrow_num'] = 0;
			foreach ($result as $key => $value){
				if ($value['use'] == $use['id']){
					$use_type[$i]['borrow_num'] = $value['num'];
					$borrow_total += $value['num'];
					break;
				}
			}
			$i++;
		}

		$i=0;
		foreach ($use_type as $key => $use){
			$use_type[$i]['borrow_scale'] = round($use_type[$i]['borrow_num']/$borrow_total*100);
			$i++;
		}

		//liukun add for bug 52 begin
		fb($use_type, FirePHP::TRACE);
		//liukun add for bug 52 end

		return $use_type;
	}
	//liukun add for bug 229 end

	/**
	 * 获取标的分类统计：根据发标时选择的借款用途统计 borrow.use
	 *
	 * @param Array $data
	 * @return Array
	 */
	public static function voucherAdvance($data = array()){
		global $mysql;

		$result = true;
		$vouch_id = $data['id'];
		$voucher_userid = $data['user_id'];
		$borrow_id = $data['borrow_id'];
		$repayment_order = $data['order'];


		// 		$sql = "select * from  {borrow_vouch_collection}  where borrow_id=$borrow_id and `order`={$repayment_order} ";
		//后台逾期扣除的时候，只扣除没有主动垫付过的担保人的帐户
		//borrow_vouch_collection is_advance = 0 担保人没有主动垫付过的才会被处理
		$sql = "select * from  {borrow_vouch_collection}  where id = {$vouch_id} and user_id = {$voucher_userid}";


		$vouch_collection = $mysql->db_fetch_array($sql);
		if(!is_array($vouch_collection)){
			return "请求不合法";
		}
		if($vouch_collection['status'] ==1){
			return "借款人已经还款，不可以垫付";
		}
		if($vouch_collection['repay_time'] > time()){
			return "还没到还款时间，不可以垫付";
		}
		if($vouch_collection['is_advance']!=0){
			return "已经进行过垫付。";
		}
		$value = $vouch_collection;
		//执行担保人垫付（额度或者净值）

		if($value['vouch_type']=="amount"){
			//如果是用额度进行担保的，要直接去扣可用余额
			//有多少可供垫付的可用余额，就恢复多少担保额度
			$account_result =  accountClass::GetOne(array("user_id"=> $value['user_id']));
			$use_money = $account_result['use_money'];
			$need_money = $value['repay_account'];

			if($use_money < $need_money){
				return "可用余额不够进行垫付。";
			}

			$should_advance_amount = ($use_money >= $need_money)?0:($need_money - $use_money);
			$can_unfrost_amount = $value['repay_account'] - $should_advance_amount;

			$log['user_id'] =  $value['user_id'];
			$log['type'] = "tender_vouch_advance";//
			$log['money'] = $need_money;
			$log['total'] = $account_result['total']-$log['money'];
			$log['use_money'] = $account_result['use_money']-$log['money'];
			$log['no_use_money'] = $account_result['no_use_money'];
			$log['collection'] = $account_result['collection'];
			$log['to_user'] = 0;
			$log['remark'] = "担保标逾期，担保人使用可用余额垫付。";
			$result = accountClass::AddLog($log);
			if(!$result){
				return $result;
			}

			$amountlog_result = borrowClass::GetAmountOne($value['user_id'],"tender_vouch");
			$amountlog["user_id"] = $value['user_id'];
			$amountlog["type"] = "tender_vouch_repay";
			$amountlog["amount_type"] = "tender_vouch";
			$amountlog["account"] = $value['repay_account'];
			$amountlog["account_all"] = $amountlog_result['account_all'];
			$amountlog["account_use"] = $amountlog_result['account_use'] + $amountlog['account'];
			$amountlog["account_nouse"] = $amountlog_result['account_nouse'] - $amountlog['account'];
			$amountlog["remark"] = "担保标垫付成功，投资担保额度返还";
			$result = borrowClass::AddAmountLog($amountlog);
			if ($result != true){
				return $result;
			}
		}
		else{
			$account_result =  accountClass::GetOne(array("user_id"=> $value['user_id']));
			$log['user_id'] =  $value['user_id'];
			$log['type'] = "tender_vouch_advance";//
			$log['money'] = $value['repay_account'];
			$log['total'] = $account_result['total']-$log['money'];
			$log['use_money'] = $account_result['use_money'];
			$log['no_use_money'] = $account_result['no_use_money']-$log['money'];
			$log['collection'] = $account_result['collection'];
			$log['to_user'] = 0;
			$log['remark'] = "担保标逾期，担保人使用担保冻结可用余额进行垫付。";
			$result = accountClass::AddLog($log);
			if(!$result){
				return $result;
			}

		}
		$sql = "update  {borrow_vouch_collection}  set advance_time = ".time().",repay_yesaccount = {$value['repay_account']},is_advance=1 where id = {$value['id']}";
		$result = $mysql->db_query($sql);
		if(!$result){
			return $result;
		}

		return $result;

	}

	
	/**
	 * 自动回购
	 *
	 * @param Array $data
	 * @return Array
	 */
	public static function autobuyback($data = array()){
		global $mysql, $_G;
		$current_time = time();
		$sql = "insert into  {auto_log}  set `addtime` = '{$current_time}',`comment` = 'autoback begin'";
		$mysql->db_query($sql);

		$con_circulation_window_time = isset($_G['system']['con_circulation_window_time'])?$_G['system']['con_circulation_window_time']:"3";
		$sql = "select * from  {circulation_buy_serial}   where buyback = 0 AND end_interest_time < (".time()."- 3600 * 24 * {$con_circulation_window_time})";
		$result = $mysql->db_fetch_arrays($sql);
		foreach ($result as $key => $value){
			$buy_id = $value['id'];
			$buy_result = borrowClass::GetCirculationBuyDetail(array("id"=>$buy_id));
			fb($buy_result, FirePHP::TRACE);
			$circulation_result = borrowClass::GetCirculationOne(array("id"=>$buy_result['circulation_id']));
			fb($circulation_result, FirePHP::TRACE);
			$borrow_result = borrowClass::GetOne(array("id"=>$circulation_result['borrow_id']));//获取借款标的单独信息
			fb($borrow_result, FirePHP::TRACE);

			$current_time = time();

			$buyer_id = $buy_result['buyer_id'];
			$seller_id = $borrow_result['user_id'];

			$auto_repurchase = $value['auto_repurchase'];

			$begin_interest_time = $buy_result['begin_interest_time'];

			//因为有后台进程自动回购，所以不会出现用户购买3月，回购时已经过期超过1个月的情况
			$can_interest_month = floor((time() - $begin_interest_time) / 3600 / 24 / 30);
			//因为开始计息时间是当天晚上23：59：59，所以这里要处理一下，不然购买了立刻回购，这里的值成-1了
			$can_interest_month = ($can_interest_month>=0)?$can_interest_month:0;

			//liukun add for bug 52 begin
			fb($begin_interest_time, FirePHP::TRACE);
			fb(time(), FirePHP::TRACE);
			fb($can_interest_month, FirePHP::TRACE);
			//liukun add for bug 52 end

			if ($_G['user_result']['islock']==1){
				$msg = array("您账号已经被锁定，请跟管理员联系");
			}elseif ($can_interest_month <= 0){
				$msg = array("流转标购入不足一月，不能回购");
			}
			else{

				$circulation_id = $buy_result['circulation_id'];
				$unit_price = $circulation_result['unit_price'];
				$begin_apr= $circulation_result['begin_apr'];
				$unit_num = $buy_result['unit_num'];
				$buy_apr = $buy_result['buy_apr'];
				$buy_type = $buy_result['buy_type'];
				$begin_interest_time = $buy_result['begin_interest_time'];
				$end_interest_time = $buy_result['end_interest_time'];

				//计算所得利息
				//liukun add for bug 163 begin
				//用户认购时选择的购买月数，如果回购时时间不足够，利息只算初始利率的一半
				$buy_month_num = $buy_result['buy_month_num'];
				if($can_interest_month < $buy_month_num){
					$buy_apr = $begin_apr / 2;
					// 				$interest = round($unit_num * $unit_price * $buy_apr / 12 / 100 * $can_interest_month, 2);
					$borrow_style = $borrow_result['style'];
					if($borrow_style == 3){
						$interest = round($unit_num * $unit_price * $buy_apr / 12 / 100 * $can_interest_month, 2) - ($buy_result['monthly_interest_repay'] * ($buy_result['buy_month_num'] - $buy_result['repay_month_num']));
					}else {
						$interest = round($unit_num * $unit_price * $buy_apr / 12 / 100 * $can_interest_month, 2);
					}
				}else{
					// 				$interest = $buy_result['interest'];
					$interest = $buy_result['monthly_interest_repay'] * $buy_result['repay_month_num'];

				}
				//liukun add for bug 163 end
				$account_money = $buy_result['capital'];


				$account_result =  accountClass::GetOne(array("user_id"=>$seller_id));//获取发标人的余额

				//liukun add for bug 52 begin
				fb($account_money, FirePHP::TRACE);
				fb($buy_result['unit_num'], FirePHP::TRACE);
				fb($circulation_result['unit_price'], FirePHP::TRACE);
				fb($account_result['use_money'], FirePHP::TRACE);
				//liukun add for bug 52 end

				//liukun add for bug 240 begin
				/*
				 if ($account_result['use_money']<($account_money + $interest)){
				$msg = array("发标人余额不足，无法回购。");
				*/
				//liukun add for bug 240 end
				if(1==2){
				}else{

					//将成效的资金直接进行交易，增加投资人帐户，扣除发标人帐户

					//判断是否需要自动续购

					//判断流转标有效期
					$valid_month_num = $circulation_result['duration'] - floor((time() - $borrow_result['verify_time']) / 3600 / 24 / 30);

					//当充值活动不再有效后，如果是用充值奖励购买的流转标，就不能再自动续购了，即使用户设置过自动续购
					$sql = " SELECT count(*) as num FROM  {recharge_award_rule}  where begin_time < ".time()." and end_time > ".time();
					$rule_result = $mysql ->db_fetch_array($sql);

					$valid_award_rule = $rule_result['num'];


					//只有正常到期才有可能自动续购， $can_interest_month == $buy_month_num
					//只有流转标有效期大于认购期才能续购
					//用余额购买 或者 用奖励购买且当时是奖励活动中
					//如果自动回购就只收回利息
					//liukun add for bug 52 begin
					fb("begin", FirePHP::TRACE);
					fb($rule_result, FirePHP::TRACE);
					fb($valid_month_num, FirePHP::TRACE);
					fb($can_interest_month, FirePHP::TRACE);
					fb($buy_type, FirePHP::TRACE);
					fb($valid_award_rule, FirePHP::TRACE);
					fb("end", FirePHP::TRACE);

					//liukun add for bug 472 begin
					$mysql->db_query("start transaction");
					//liukun add for bug 472 end
					$transaction_result = true;
					try{
						//写入购买记录
						$borrow_url = "<a href=\'/invest/a{$borrow_result['id']}.html\' target=_blank>{$borrow_result['name']}</a>";
						$classname = $borrow_result['biao_type']."biaoClass";
						$dynaBiaoClass = new $classname();
						//收取管理费
						$interest_fee_rate = $dynaBiaoClass->get_interest_fee_rate();
						//收取管理费
						$fee_rate = $dynaBiaoClass->get_borrow_fee_rate();

						//liukun add for bug 52 end
						if($auto_repurchase == 1 && ($valid_month_num >= $buy_month_num &&   $can_interest_month == $buy_month_num)
								&&(($buy_type == "award" && $valid_award_rule > 0) || $buy_type == "account")){
							if ($buy_type == "award"){
								//奖励投标得到的利息不能重用，只能累计到利息项
								//liukun add for bug 174 begin
								$sql = "update  {account}  set ";
								$sql .= " award_interest = award_interest + {$interest}";
								$sql .= " where user_id=$buyer_id";
								//liukun add for bug 174 end

								$transaction_result = $mysql->db_query($sql);
								if ($transaction_result !==true){
									throw new Exception();
								}
								//增加award日志


								//liukun add for bug 174 begin
								//利息日志
								$award_log['user_id'] = $buyer_id;
								$award_log['type'] = "buyback_circulation_interest";
								$award_log['award'] = $interest;
								$award_log['remark'] = "成功回购流转标收款（利息）";
								$sql = "insert into  {recharge_award_log}  set `addtime` = '".time()."',`addip` = '".ip_address()."'";
								foreach($award_log as $key => $value){
									$sql .= ",`$key` = '$value'";
								}
								$transaction_result = $mysql->db_query($sql);
								if ($transaction_result !==true){
									throw new Exception();
								}
								//liukun add for bug 174 end

								//扣除利息管理费

								//liukun add for bug 174 begin
								$interest_fee = round($interest * $interest_fee_rate, 2);
								$sql = "update  {account}  set  ";
								$sql .= " award_interest = award_interest - {$interest_fee}";
								$sql .= " where user_id=$buyer_id";
								//liukun add for bug 174 end

								$transaction_result = $mysql->db_query($sql);
								if ($transaction_result !==true){
									throw new Exception();
								};

								$award_log['user_id'] = $buyer_id;
								$award_log['type'] = "tender_mange";
								$award_log['award'] =  -$interest_fee;
								$award_log['remark'] = "用户成功还款扣除利息的管理费";
								$sql = "insert into  {recharge_award_log}  set `addtime` = '".time()."',`addip` = '".ip_address()."'";
								foreach($award_log as $key => $value){
									$sql .= ",`$key` = '$value'";
								}
								$transaction_result = $mysql->db_query($sql);
								if ($transaction_result !==true){
									throw new Exception();
								};

							}
							else{
								//将成效的资金直接进行交易，增加投资人帐户，扣除发标人帐户
								$account_result =  accountClass::GetOne(array("user_id"=>$buyer_id));//获取当前用户的余额
								$log['user_id'] = $buyer_id;
								$log['type'] = "buyback_circulation";
								$log['money'] = $interest;
								$log['total'] = $account_result['total']+$log['money'];
								$log['use_money'] =  $account_result['use_money']+$log['money'];
								$log['no_use_money'] =  $account_result['no_use_money'];
								$log['collection'] =  $account_result['collection'];
								$log['to_user'] = $seller_id;
								$log['remark'] = "成功回购流转标收款（利息）";
								$transaction_result = accountClass::AddLog($log);//添加记录
								if ($transaction_result !==true){
									throw new Exception();
								}
								//自动续购时，代收不变（因为新的认购记录中待收本金和利息都与上次认购相同，所以只要增加本次回购得到 的利息即可

								//扣除利息管理费
								$interest_fee = round($interest * $interest_fee_rate, 2);
								$account_result =  accountClass::GetOne(array("user_id"=>$buyer_id));
								$log['user_id'] = $buyer_id;
								$log['type'] = "tender_mange";//
								$log['money'] = $interest_fee;
								$log['total'] = $account_result['total']-$log['money'];
								$log['use_money'] = $account_result['use_money']-$log['money'];
								$log['no_use_money'] = $account_result['no_use_money'];
								$log['collection'] = $account_result['collection'];
								$log['to_user'] = 0;
								$log['remark'] = "用户成功还款扣除利息的管理费";
								$transaction_result = accountClass::AddLog($log);
								if ($transaction_result !==true){
									throw new Exception();
								};
									
								//如果是按月还息的模式，那么续购成功要增加待收（就是每月支付的利息）
								$borrow_style = $borrow_result['style'];
								if($borrow_style == 3){
									//liukun add for bug 223 begin
									$account_result =  accountClass::GetOne(array("user_id"=>$buyer_id));//获取当前用户的余额
									$log['user_id'] = $buyer_id;
									$log['type'] = "purchase_circulation_collection";
									$log['money'] = $buy_result['monthly_interest_repay'] * ($buy_result['buy_month_num'] - 1);
									$log['total'] = $account_result['total']+$log['money'];
									$log['use_money'] =  $account_result['use_money'];
									$log['no_use_money'] =  $account_result['no_use_money'];
									$log['collection'] =  $account_result['collection']+$log['money'];
									$log['to_user'] = $seller_id;
									$log['remark'] = "续购成功，补足待收差额";
									$transaction_result = accountClass::AddLog($log);//添加记录
									if ($transaction_result !==true){
										throw new Exception();
									}
									//liukun add for bug 223 end
								}

							}
								
							//生成新的认购记录
							$buy_data['circulation_id'] = $buy_result['circulation_id'];
							$buy_data['buyer_id'] = $buy_result['buyer_id'];
							$buy_data['unit_num'] = $buy_result['unit_num'];
							$buy_data['buytime'] = time();
							$buy_data['auto_repurchase'] = $buy_result['auto_repurchase'];
							$buy_data['buy_month_num'] = $buy_result['buy_month_num'];
							$buy_data['buyback'] = 0;
								
							//liukun add for bug 215 begin
							if ($buy_result['auto_repurchase'] == 1){
								$buy_data['begin_interest_time'] = $buy_result['end_interest_time'];
							}
							else{
								//liukun add for bug 219 begin
								$buy_data['begin_interest_time'] = strtotime(date("Y-m-d 23:59:59", $current_time));
								//liukun add for bug 219 end
							}
							//liukun add for bug 215 end
								
							//计算计息结束时间
							$buy_data['end_interest_time'] = $buy_data['begin_interest_time'] + 30 * 24 * 3600 * $buy_data['buy_month_num'];
							$buy_data['buy_apr'] = $buy_result['buy_apr'];
							$buy_data['buy_type'] = $buy_result['buy_type'];
								
							//计算本金和正常回购时应得利息
							$buy_data['capital'] = $buy_result['capital'];

							$borrow_style = $borrow_result['style'];
							$buy_data['monthly_interest_repay'] = $buy_result['monthly_interest_repay'];
							if($borrow_style == 2){
								//到期全额还款就只有一期
								$buy_data['repay_month_num'] = 1;
								$buy_data['interest'] = $buy_data['monthly_interest_repay'];
							}else{
								//按月付息，到期还本
								$buy_data['repay_month_num'] = $buy_result['buy_month_num'];
								$buy_data['interest'] = $buy_data['monthly_interest_repay'] * $buy_data['buy_month_num'];
							}

							$buy_data['frost_account'] = $buy_result['frost_account'];

								
							$sql = "insert into  {circulation_buy_serial}  set `addtime` = '".time()."',`addip` = '".ip_address()."'";
							foreach($buy_data as $key => $value){
								$sql .= ",`$key` = '$value'";
							}
							$transaction_result = $mysql->db_query($sql);
							if ($transaction_result !==true){
								throw new Exception();
							}
							//增加已流转份数，自动续购不需要增加可购买份数
							$sell_num = $unit_num;
							$sql = "update  {circulation}  set  `circulated_num` = `circulated_num` + $sell_num";
							$sql .= " where id=$circulation_id";
								
							$transaction_result = $mysql->db_query($sql);
							if ($transaction_result !==true){
								throw new Exception();
							}
							//扣除发标人的资金（利息）
							$account_result =  accountClass::GetOne(array("user_id"=>$seller_id));//获取当前用户的余额
							//liukun add for bug 52 begin
								
								
							fb("begin", FirePHP::TRACE);
							fb($account_result, FirePHP::TRACE);
							fb("end", FirePHP::TRACE);
							//liukun add for bug 52 end
							$log['user_id'] = $seller_id;
							$log['type'] = "accept_buyback_circulation";
							$log['money'] = $interest;
							$log['total'] = $account_result['total']-$log['money'];
							$log['use_money'] =  $account_result['use_money']-$log['money'];
							$log['no_use_money'] =  $account_result['no_use_money'];
							$log['collection'] =  $account_result['collection'];
							$log['to_user'] = $buyer_id;
							$log['remark'] = "成功接受回购流转标申请付款（利息）";
							$transaction_result = accountClass::AddLog($log);//添加记录
							if ($transaction_result !==true){
								throw new Exception();
							}

							$borrow_fee = round($sell_num * $unit_price * $fee_rate['borrow_fee_rate'], 2);
							if ($borrow_fee > 0){

								$account_result =  accountClass::GetOne(array("user_id"=>$seller_id));
								$fee_log['user_id'] = $seller_id;
								$fee_log['type'] = "borrow_fee";
								$fee_log['money'] = $borrow_fee;
								$fee_log['total'] = $account_result['total']-$fee_log['money'];
								$fee_log['use_money'] = $account_result['use_money']-$fee_log['money'];
								$fee_log['no_use_money'] = $account_result['no_use_money'];
								$fee_log['collection'] = $account_result['collection'];
								$fee_log['to_user'] = "0";
								$fee_log['remark'] = "借款[{$borrow_url}]的手续费";

								$transaction_result = accountClass::AddLog($fee_log);
								if ($transaction_result !==true){
									throw new Exception();
								};
							}

						}else{
							if ($buy_type == "award"){
								//奖励投标得到的利息不能重用，只能累计到利息项
								//liukun add for bug 174 begin
								$sql = "update  {account}  set `use_award` = `use_award` + {$account_money}";
								$sql .= ", award_interest = award_interest + {$interest}";
								$sql .= " where user_id=$buyer_id";
								//liukun add for bug 174 end

								$mysql->db_query($sql);

								//增加award日志
								//投资本金日志
								$award_log['user_id'] = $buyer_id;
								$award_log['type'] = "buyback_circulation";
								$award_log['award'] = $account_money;
								$award_log['remark'] = "成功回购流转标收款（本金）";
								$sql = "insert into  {recharge_award_log}  set `addtime` = '".time()."',`addip` = '".ip_address()."'";
								foreach($award_log as $key => $value){
									$sql .= ",`$key` = '$value'";
								}
								$transaction_result = $result = $mysql->db_query($sql);
								if ($transaction_result !==true){
									throw new Exception();
								}
								//liukun add for bug 174 begin
								//利息日志
								$award_log['user_id'] = $buyer_id;
								$award_log['type'] = "buyback_circulation_interest";
								$award_log['award'] = $interest;
								$award_log['remark'] = "成功回购流转标收款（利息）";
								$sql = "insert into  {recharge_award_log}  set `addtime` = '".time()."',`addip` = '".ip_address()."'";
								foreach($award_log as $key => $value){
									$sql .= ",`$key` = '$value'";
								}
								$transaction_result = $mysql->db_query($sql);
								if ($transaction_result !==true){
									throw new Exception();
								}
								//liukun add for bug 174 end

								//扣除利息管理费
								if ($interest > 0){
									//liukun add for bug 174 begin
									$interest_fee = round($interest * $interest_fee_rate, 2);
									$sql = "update  {account}  set  ";
									$sql .= " award_interest = award_interest - {$interest_fee}";
									$sql .= " where user_id=$buyer_id";
									//liukun add for bug 174 end

									$transaction_result = $mysql->db_query($sql);
									if ($transaction_result !==true){
										throw new Exception();
									};

									$award_log['user_id'] = $buyer_id;
									$award_log['type'] = "tender_mange";
									$award_log['award'] =  -$interest_fee;
									$award_log['remark'] = "用户成功还款扣除利息的管理费";
									$sql = "insert into  {recharge_award_log}  set `addtime` = '".time()."',`addip` = '".ip_address()."'";
									foreach($award_log as $key => $value){
										$sql .= ",`$key` = '$value'";
									}
									$transaction_result = $mysql->db_query($sql);
									if ($transaction_result !==true){
										throw new Exception();
									};
								}

							}
							else{
								//将成效的资金直接进行交易，增加投资人帐户，扣除发标人帐户
								$account_result =  accountClass::GetOne(array("user_id"=>$buyer_id));//获取当前用户的余额
								$log['user_id'] = $buyer_id;
								$log['type'] = "buyback_circulation";
								$log['money'] = $account_money;
								$log['total'] = $account_result['total']+$log['money'];
								$log['use_money'] =  $account_result['use_money']+$log['money'];
								$log['no_use_money'] =  $account_result['no_use_money'];
								$log['collection'] =  $account_result['collection'];
								$log['to_user'] = $seller_id;
								$log['remark'] = "成功回购流转标收款（本金）";
								$transaction_result = accountClass::AddLog($log);//添加记录
								if ($transaction_result !==true){
									throw new Exception();
								}


								if ($interest > 0){
									$account_result =  accountClass::GetOne(array("user_id"=>$buyer_id));//获取当前用户的余额
									$log['user_id'] = $buyer_id;
									$log['type'] = "buyback_circulation";
									$log['money'] = $interest;
									$log['total'] = $account_result['total']+$log['money'];
									$log['use_money'] =  $account_result['use_money']+$log['money'];
									$log['no_use_money'] =  $account_result['no_use_money'];
									$log['collection'] =  $account_result['collection'];
									$log['to_user'] = $seller_id;
									$log['remark'] = "成功回购流转标收款（利息）";
								}else{
									$account_result =  accountClass::GetOne(array("user_id"=>$buyer_id));//获取当前用户的余额
									$log['user_id'] = $buyer_id;
									$log['type'] = "early_buyback_circulation";
									$log['money'] = -$interest;
									$log['total'] = $account_result['total']-$log['money'];
									$log['use_money'] =  $account_result['use_money']-$log['money'];
									$log['no_use_money'] =  $account_result['no_use_money'];
									$log['collection'] =  $account_result['collection'];
									$log['to_user'] = $seller_id;
									$log['remark'] = "提前回购差额（利息）";
								}
								$transaction_result = accountClass::AddLog($log);//添加记录
								if ($transaction_result !==true){
									throw new Exception();
								}
								//liukun add for bug 223 begin
								$account_result =  accountClass::GetOne(array("user_id"=>$buyer_id));//获取当前用户的余额
								$log['user_id'] = $buyer_id;
								$log['type'] = "buyback_circulation_collection";
								$log['money'] = $buy_result['capital'] + $buy_result['interest'];
								$log['total'] = $account_result['total']-$log['money'];
								$log['use_money'] =  $account_result['use_money'];
								$log['no_use_money'] =  $account_result['no_use_money'];
								$log['collection'] =  $account_result['collection']-$log['money'];
								$log['to_user'] = $seller_id;
								$log['remark'] = "成功回购流转标减少待收";
								$transaction_result = accountClass::AddLog($log);//添加记录
								if ($transaction_result !==true){
									throw new Exception();
								}
								//liukun add for bug 223 end
								if ($interest > 0){
									//扣除利息管理费
									$interest_fee = round($interest * $interest_fee_rate, 2);
									$account_result =  accountClass::GetOne(array("user_id"=>$buyer_id));
									$log['user_id'] = $buyer_id;
									$log['type'] = "tender_mange";//
									$log['money'] = $interest_fee;
									$log['total'] = $account_result['total']-$log['money'];
									$log['use_money'] = $account_result['use_money']-$log['money'];
									$log['no_use_money'] = $account_result['no_use_money'];
									$log['collection'] = $account_result['collection'];
									$log['to_user'] = 0;
									$log['remark'] = "用户成功还款扣除利息的管理费";
									$transaction_result = accountClass::AddLog($log);
									if ($transaction_result !==true){
										throw new Exception();
									};
								}
							}

							//增加流转标的可购买份数，增加已流转份数，自动续购不需要增加可购买份数这种操作
							$sell_num = $unit_num;
							$sql = "update  {circulation}  set `valid_unit_num` = `valid_unit_num` + $sell_num";
							$sql .= " where id=$circulation_id";

							$transaction_result = $mysql->db_query($sql);
							if ($transaction_result !==true){
								throw new Exception();
							}

							//解冻保证金
							if ($buy_result['frost_account'] > 0){
								$account_result =  accountClass::GetOne(array("user_id"=>$seller_id));
								$account_log['user_id'] =$seller_id;
								$account_log['type'] = "borrow_frost";
								$account_log['money'] = $buy_result['frost_account'];
								$account_log['total'] =$account_result['total'];
								$account_log['use_money'] = $account_result['use_money']+$account_log['money'];
								$account_log['no_use_money'] = $account_result['no_use_money']-$account_log['money'];
								$account_log['collection'] = $account_result['collection'];
								$account_log['to_user'] = "0";
								$account_log['remark'] = "对[{$borrow_url}]借款保证金的解冻";
								$transaction_result = accountClass::AddLog($account_log);
								if ($transaction_result !==true){
									throw new Exception();
								};
							}
							//扣除发标人的资金（本金+利息）
							$account_result =  accountClass::GetOne(array("user_id"=>$seller_id));//获取当前用户的余额
							$log['user_id'] = $seller_id;
							$log['type'] = "accept_buyback_circulation";
							$log['money'] = $account_money + $interest;
							$log['total'] = $account_result['total']-$log['money'];
							$log['use_money'] =  $account_result['use_money']-$log['money'];
							$log['no_use_money'] =  $account_result['no_use_money'];
							$log['collection'] =  $account_result['collection'];
							$log['to_user'] = $buyer_id;
							$log['remark'] = "成功接受回购流转标申请付款（本金+利息）";
							$transaction_result = accountClass::AddLog($log);//添加记录
							if ($transaction_result !==true){
								throw new Exception();
							}


						}
						//无论是否需要自动续购，肯定会收回投资利息

						//设置回购成功标记
						$sql = "update  {circulation_buy_serial}  set `buyback` = 1, `buyback_time` = '".time()."'";
						$sql .= " where id={$buy_id}";

						$transaction_result = $mysql->db_query($sql);
						if ($transaction_result !==true){
							throw new Exception();
						}

					}
					catch (Exception $e){
						$msg = array($transaction_result);
						//必须保证所有不可接受的错误都返回异常，并执行了回滚
						$mysql->db_query("rollback");
					}
					//liukun add for bug 472 begin
					if($transaction_result===true){
						$mysql->db_query("commit");
					}else{
						$mysql->db_query("rollback");
					}
				}
			}


		}

		$sql = "insert into  {auto_log}  set `addtime` = '{$current_time}',`comment` = 'autoback end'";
		$mysql->db_query($sql);

		return true;

	}

	/**
	 * 自动回购
	 *
	 * @param Array $data
	 * @return Array
	 */
	public static function autobuybackInterest($data = array()){
		global $mysql, $_G;

		$current_time = time();
		$sql = "insert into  {auto_log}  set `addtime` = '{$current_time}',`comment` = 'autoback interest begin'";
		$mysql->db_query($sql);

		$sql = "select cs.* from  {circulation_buy_serial}  cs,  {circulation}  cr,  {borrow}  bw
		where cs.circulation_id = cr.id and cr.borrow_id = bw.id
		and cs.buyback = 0 and bw.style = 3 and cs.end_interest_time > ".time()."  and
		(cs.begin_interest_time + (cs.buy_month_num - repay_month_num +1) * 3600 *24 * 30) < ".time();

		$result = $mysql->db_fetch_arrays($sql);
		foreach ($result as $key => $value){

			$buy_id = $value['id'];
			$buy_result = borrowClass::GetCirculationBuyDetail(array("id"=>$buy_id));
			fb($buy_result, FirePHP::TRACE);
			$circulation_result = borrowClass::GetCirculationOne(array("id"=>$buy_result['circulation_id']));
			fb($circulation_result, FirePHP::TRACE);
			$borrow_result = borrowClass::GetOne(array("id"=>$circulation_result['borrow_id']));//获取借款标的单独信息
			fb($borrow_result, FirePHP::TRACE);


			$buyer_id = $buy_result['buyer_id'];
			$seller_id = $borrow_result['user_id'];

			$auto_repurchase = $value['auto_repurchase'];

			$begin_interest_time = $buy_result['begin_interest_time'];





			if ($_G['user_result']['islock']==1){
				$msg = array("您账号已经被锁定，请跟管理员联系");
			}
			else{

				$circulation_id = $buy_result['circulation_id'];
				$unit_price = $circulation_result['unit_price'];
				$begin_apr= $circulation_result['begin_apr'];
				$unit_num = $buy_result['unit_num'];
				$buy_apr = $buy_result['buy_apr'];
				$buy_type = $buy_result['buy_type'];
				$begin_interest_time = $buy_result['begin_interest_time'];
				$end_interest_time = $buy_result['end_interest_time'];

				//计算所得利息
				//liukun add for bug 163 begin
				//用户认购时选择的购买月数，如果回购时时间不足够，利息只算初始利率的一半
				$buy_month_num = $buy_result['buy_month_num'];

				//按
				$interest = $buy_result['monthly_interest_repay'];

				//liukun add for bug 163 end
				$account_money = $buy_result['capital'];

				//liukun add for bug 240 begin
				/*
				 if ($account_result['use_money']<($account_money + $interest)){
				$msg = array("发标人余额不足，无法回购。");
				*/
				//liukun add for bug 240 end


				//将成效的资金直接进行交易，增加投资人帐户，扣除发标人帐户

				//只有正常到期才有可能自动续购， $can_interest_month == $buy_month_num
				//只有流转标有效期大于认购期才能续购
				//用余额购买 或者 用奖励购买且当时是奖励活动中
				//如果自动回购就只收回利息
				//liukun add for bug 52 begin
				fb("begin", FirePHP::TRACE);
				fb($rule_result, FirePHP::TRACE);
				fb($valid_month_num, FirePHP::TRACE);
				fb($can_interest_month, FirePHP::TRACE);
				fb($buy_type, FirePHP::TRACE);
				fb($valid_award_rule, FirePHP::TRACE);
				fb("end", FirePHP::TRACE);

				//liukun add for bug 472 begin
				$mysql->db_query("start transaction");
				//liukun add for bug 472 end
				$transaction_result = true;
				try{
					//写入购买记录
					$borrow_url = "<a href=\'/invest/a{$borrow_result['id']}.html\' target=_blank>{$borrow_result['name']}</a>";
					$classname = $borrow_result['biao_type']."biaoClass";
					$dynaBiaoClass = new $classname();
					//收取管理费
					$interest_fee_rate = $dynaBiaoClass->get_interest_fee_rate();
					//收取管理费


					//liukun add for bug 52 end

					if ($buy_type == "award"){
						//奖励投标得到的利息不能重用，只能累计到利息项
						//liukun add for bug 174 begin
						$sql = "update  {account}  set ";
						$sql .= " award_interest = award_interest + {$interest}";
						$sql .= " where user_id=$buyer_id";
						//liukun add for bug 174 end

						$transaction_result = $mysql->db_query($sql);
						if ($transaction_result !==true){
							throw new Exception();
						}
						//增加award日志


						//liukun add for bug 174 begin
						//利息日志
						$award_log['user_id'] = $buyer_id;
						$award_log['type'] = "buyback_circulation_interest";
						$award_log['award'] = $interest;
						$award_log['remark'] = "成功回购流转标收款（利息）";
						$sql = "insert into  {recharge_award_log}  set `addtime` = '".time()."',`addip` = '".ip_address()."'";
						foreach($award_log as $key => $value){
							$sql .= ",`$key` = '$value'";
						}
						$transaction_result = $mysql->db_query($sql);
						if ($transaction_result !==true){
							throw new Exception();
						}
						//liukun add for bug 174 end

						//扣除利息管理费

						//liukun add for bug 174 begin
						$interest_fee = round($interest * $interest_fee_rate, 2);
						$sql = "update  {account}  set  ";
						$sql .= " award_interest = award_interest - {$interest_fee}";
						$sql .= " where user_id=$buyer_id";
						//liukun add for bug 174 end

						$transaction_result = $mysql->db_query($sql);
						if ($transaction_result !==true){
							throw new Exception();
						};

						$award_log['user_id'] = $buyer_id;
						$award_log['type'] = "tender_mange";
						$award_log['award'] =  -$interest_fee;
						$award_log['remark'] = "用户成功还款扣除利息的管理费";
						$sql = "insert into  {recharge_award_log}  set `addtime` = '".time()."',`addip` = '".ip_address()."'";
						foreach($award_log as $key => $value){
							$sql .= ",`$key` = '$value'";
						}
						$transaction_result = $mysql->db_query($sql);
						if ($transaction_result !==true){
							throw new Exception();
						};

					}
					else{
						//将成效的资金直接进行交易，增加投资人帐户，扣除发标人帐户
						$account_result =  accountClass::GetOne(array("user_id"=>$buyer_id));//获取当前用户的余额
						$log['user_id'] = $buyer_id;
						$log['type'] = "buyback_circulation";
						$log['money'] = $interest;
						$log['total'] = $account_result['total']+$log['money'];
						$log['use_money'] =  $account_result['use_money']+$log['money'];
						$log['no_use_money'] =  $account_result['no_use_money'];
						$log['collection'] =  $account_result['collection'];
						$log['to_user'] = $seller_id;
						$log['remark'] = "成功回购流转标收款（利息）";
						$transaction_result = accountClass::AddLog($log);//添加记录
						if ($transaction_result !==true){
							throw new Exception();
						}
						//自动续购时，代收不变（因为新的认购记录中待收本金和利息都与上次认购相同，所以只要增加本次回购得到 的利息即可

						//扣除利息管理费
						$interest_fee = round($interest * $interest_fee_rate, 2);
						$account_result =  accountClass::GetOne(array("user_id"=>$buyer_id));
						$log['user_id'] = $buyer_id;
						$log['type'] = "tender_mange";//
						$log['money'] = $interest_fee;
						$log['total'] = $account_result['total']-$log['money'];
						$log['use_money'] = $account_result['use_money']-$log['money'];
						$log['no_use_money'] = $account_result['no_use_money'];
						$log['collection'] = $account_result['collection'];
						$log['to_user'] = 0;
						$log['remark'] = "用户成功还款扣除利息的管理费";
						$transaction_result = accountClass::AddLog($log);
						if ($transaction_result !==true){
							throw new Exception();
						};

						$account_result =  accountClass::GetOne(array("user_id"=>$buyer_id));//获取当前用户的余额
						$log['user_id'] = $buyer_id;
						$log['type'] = "buyback_circulation_collection";
						$log['money'] = $buy_result['monthly_interest_repay'];
						$log['total'] = $account_result['total']-$log['money'];
						$log['use_money'] =  $account_result['use_money'];
						$log['no_use_money'] =  $account_result['no_use_money'];
						$log['collection'] =  $account_result['collection']-$log['money'];
						$log['to_user'] = $seller_id;
						$log['remark'] = "成功回购流转标减少待收";
						$transaction_result = accountClass::AddLog($log);//添加记录
						if ($transaction_result !==true){
							throw new Exception();
						}

					}

						
						
					//扣除发标人的资金（利息）
					$account_result =  accountClass::GetOne(array("user_id"=>$seller_id));//获取当前用户的余额
					//liukun add for bug 52 begin


					fb("begin", FirePHP::TRACE);
					fb($account_result, FirePHP::TRACE);
					fb("end", FirePHP::TRACE);
					//liukun add for bug 52 end
					$log['user_id'] = $seller_id;
					$log['type'] = "accept_buyback_circulation";
					$log['money'] = $interest;
					$log['total'] = $account_result['total']-$log['money'];
					$log['use_money'] =  $account_result['use_money']-$log['money'];
					$log['no_use_money'] =  $account_result['no_use_money'];
					$log['collection'] =  $account_result['collection'];
					$log['to_user'] = $buyer_id;
					$log['remark'] = "成功接受回购流转标申请付款（利息）";
					$transaction_result = accountClass::AddLog($log);//添加记录
					if ($transaction_result !==true){
						throw new Exception();
					}

						


					//无论是否需要自动续购，肯定会收回投资利息

					//设置回购成功标记
					$sql = "update  {circulation_buy_serial}  set `interest` = `interest` - {$buy_result['monthly_interest_repay']}, `repay_month_num` = repay_month_num - 1, `last_repay_time` = '".time()."'";
					$sql .= " where id={$buy_id}";

					$transaction_result = $mysql->db_query($sql);
					if ($transaction_result !==true){
						throw new Exception();
					}

				}
				catch (Exception $e){
					$msg = array($transaction_result);
					//必须保证所有不可接受的错误都返回异常，并执行了回滚
					$mysql->db_query("rollback");
				}
				//liukun add for bug 472 begin
				if($transaction_result===true){
					$mysql->db_query("commit");
				}else{
					$mysql->db_query("rollback");
				}

			}

		}

		$current_time = time();
		$sql = "insert into  {auto_log}  set `addtime` = '{$current_time}',`comment` = 'autoback interest end'";
		$mysql->db_query($sql);

		return true;

	}

	/**
	 * 增加债权转让标记录
	 *
	 * @param Array $data
	 * @return Boolen
	 */
	function CancelVIP($data = array()){
		global $mysql;
		global $_G;

		$current_time = time();

		$vip_valid_time = 60*60*24*365;
		$sql = "insert into  {auto_log}  set `addtime` = '{$current_time}',`comment` = 'cancel vip begin'";
		$mysql->db_query($sql);

		$sql = "update  {user_cache}  set vip_status = 0 where (vip_verify_time + {$vip_valid_time}) < {$current_time} and vip_status = 1";

		$mysql->db_query($sql);

		$sql = "insert into  {auto_log}  set `addtime` = '{$current_time}',`comment` = 'cancel vip end'";
		$mysql->db_query($sql);

		return true;
	}

	function CancelAward($data = array()){
		global $mysql;
		global $_G;

		$current_time = time();
		$sql = "insert into  {auto_log}  set `addtime` = '{$current_time}',`comment` = 'cancel award begin'";
		$mysql->db_query($sql);

		$sql = "SELECT count(*) as cancel_user_num FROM  {account}  WHERE award > 0";
		$result = $mysql ->db_fetch_array($sql);
		$cancel_user_num = $result['cancel_user_num'];

		$sql = "SELECT count(*) as recharge_award_rule FROM  {recharge_award_rule}  WHERE begin_time < {$current_time} AND end_time > {$current_time}";
		$result = $mysql ->db_fetch_array($sql);
		$recharge_award_rule = $result['recharge_award_rule'];

		if ($cancel_user_num > 0 && $recharge_award_rule == 0){


			$sql = "SELECT user_id, award FROM  {account}  WHERE award > 0 ";

			$award_user_result = $mysql->db_fetch_arrays($sql);
			foreach ($award_user_result as $key => $value){
				//liukun add for bug 472 begin
				$mysql->db_query("start transaction");
				//liukun add for bug 472 end
				$transaction_result = true;
				try{
					$user_id = $value['user_id'];
					$award=$value['award'];

					$sql = "update  {account}  set `use_award` = `use_award` - {$award}, `award` = 0 ";
					$sql .= " where user_id=$user_id";

					$transaction_result = $mysql->db_query($sql);
					if ($transaction_result !==true){
						throw new Exception();
					}

					//增加award日志
					$award_log['user_id'] = $user_id;
					$award_log['type'] = "recharge_award_cancel";
					$award_log['award'] = -$award;
					$award_log['remark'] = "充值奖励取消";
					$sql = "insert into  {recharge_award_log}  set `addtime` = '".time()."',`addip` = '".ip_address()."'";
					foreach($award_log as $key => $value){
						$sql .= ",`$key` = '$value'";
					}
					$transaction_result = $mysql->db_query($sql);
					if ($transaction_result !==true){
						throw new Exception();
					}
				}
				catch (Exception $e){
					$msg = array($transaction_result);
					//必须保证所有不可接受的错误都返回异常，并执行了回滚
					$mysql->db_query("rollback");
				}
				//liukun add for bug 472 begin
				if($transaction_result===true){
					$mysql->db_query("commit");
				}else{
					$mysql->db_query("rollback");
				}
			}


		}

		$sql = "insert into  {auto_log}  set `addtime` = '{$current_time}',`comment` = 'cancel award end'";
		$mysql->db_query($sql);
	}



}
?>