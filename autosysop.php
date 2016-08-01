<?

session_cache_limiter('private,must-revalidate');

$_G = array();
//基本配置文件
include ("core/config.inc.php");

//系统基本信息
$system = array();
$system_name = array();
$_system = $mysql->db_selects("system");
foreach ($_system as $key => $value){
	$system[$value['nid']] = $value['value'];
	$system_name[$value['nid']] = $value['name'];
}
$_G['system'] = $system;
$_G['system_name'] = $system_name;


$_G['nowtime'] = time();//现在的时间

$_G['weburl'] = "http://".$_SERVER['SERVER_NAME'];//当前的域名

include_once(ROOT_PATH."modules/borrow/borrow.class.php");
$data='';
//自动回购
$result = borrowClass::autobuyback($data);
//自动结算流转标认购利息（非到期回购）
$result = borrowClass::autobuybackInterest($data);
//取消过期VIP
$result = borrowClass::CancelVIP($data);
//非提现充值奖励活动到期，取消充值奖励
$result = borrowClass::CancelAward($data);
//被邀请人投标达标提成奖励
$result = borrowClass::GetInviteTicheng($data);
//被邀请人可用余额担保提成奖励
$result = borrowClass::GetInviteVouchTicheng($data);
//被邀请人申请投资担保额度提成奖励
$result = borrowClass::GetInviteBorrowTicheng($data);
//被邀请人发标提成奖励
$result = borrowClass::createBlackList($data);
$msg = "后台处理结束!";
echo date('Y-m-d H:i:s');

echo $msg;

?>
