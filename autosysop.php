<?

session_cache_limiter('private,must-revalidate');

$_G = array();
//���������ļ�
include ("core/config.inc.php");

//ϵͳ������Ϣ
$system = array();
$system_name = array();
$_system = $mysql->db_selects("system");
foreach ($_system as $key => $value){
	$system[$value['nid']] = $value['value'];
	$system_name[$value['nid']] = $value['name'];
}
$_G['system'] = $system;
$_G['system_name'] = $system_name;


$_G['nowtime'] = time();//���ڵ�ʱ��

$_G['weburl'] = "http://".$_SERVER['SERVER_NAME'];//��ǰ������

include_once(ROOT_PATH."modules/borrow/borrow.class.php");
$data='';
//�Զ��ع�
$result = borrowClass::autobuyback($data);
//�Զ�������ת���Ϲ���Ϣ���ǵ��ڻع���
$result = borrowClass::autobuybackInterest($data);
//ȡ������VIP
$result = borrowClass::CancelVIP($data);
//�����ֳ�ֵ��������ڣ�ȡ����ֵ����
$result = borrowClass::CancelAward($data);
//��������Ͷ������ɽ���
$result = borrowClass::GetInviteTicheng($data);
//�������˿���������ɽ���
$result = borrowClass::GetInviteVouchTicheng($data);
//������������Ͷ�ʵ��������ɽ���
$result = borrowClass::GetInviteBorrowTicheng($data);
//�������˷�����ɽ���
$result = borrowClass::createBlackList($data);
$msg = "��̨�������!";
echo date('Y-m-d H:i:s');

echo $msg;

?>
