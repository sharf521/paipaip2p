<?php
/**
 */
if (!defined('ROOT_PATH'))  die('���ܷ���');//��ֱֹ�ӷ���
check_rank("email_".$_t);//���Ȩ��

$style = 4;
$result = $mysql->db_selects("system","style={$style}");
if (!$result) {
    $sql = "INSERT INTO  {system}  (`name` ,`nid` ,`value` ,`type` ,`style` ,`status`)VALUES
                ('SMTP������', 'con_email_host', '', '0', '{$style}', '0'),
                ('SMTP�������Ƿ���Ҫ��֤', 'con_email_auth', '1', '1', '{$style}', '0'),
                ('�����ַ', 'con_email_email', '', '0', '{$style}', '0'),
                ('��������', 'con_email_pwd', '', '0', '{$style}', '0'),
                ('������Email', 'con_email_from', '', '0', '{$style}', '0'),
                ('�������ǳƻ�����', 'con_email_from_name', '', '0', '{$style}', '0')";
    $mysql->db_query($sql);
}
if ('reg' == $t) {
    
}
else{
    if (isset($_POST['submit'])) {
        $value = isset($_POST['value'])?$_POST['value']:array();
        $sql = array();
        foreach ($value as $key => $var) {
            array_push($sql, "set value='{$var}' where style='{$style}' and nid='{$key}'");
        }
        $sql = 'update {system} ' . implode(';update {system} ', $sql) . ';';
        $mysql->db_querys($sql);
        $msg = array('�����ɹ�', '', $url);
    }
    else{
        $result = $mysql->db_fetch_arrays("select * from {system} where style={$style}");
        $magic->assign('result', $result);
    }
}
if ($msg!=""){
	$template_tpl = show_msg($msg,$msg_tpl);//�������Ϣ����ֱ�Ӷ�ȡϵͳ����Ϣģ��
}else{
	$template_tpl = "admin_email.html.php";//����������ģ���ֱ�Ӷ�ȡģ�����ڵ���Ӧģ��
	$magic->assign("template_dir","");
}

$magic->assign("module_tpl",$template_tpl);
?>
