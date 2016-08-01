<?php
/**
 */
include("phpmailer/class.phpmailer.php");
class Mail {

    public static $msg = '';

    /**
     * �����ʼ�
     * @param $subject ����
     * @param $body �ʼ�����
     * @param $from ��������
     * @param $from_name �����ǳ�
     * @param $to �ʼ������� array(
     *      array(mail_address, mail_name)
     * )
     * @return bool
     */
    public static function Send ($subject, $body, $to) {
        global $mysql, $_G;
        $mail = new PHPMailer();
        $body = eregi_replace("[\]",'',$body);
        
        $mail->CharSet = 'gbk';
        $mail->IsSMTP();
        # ���SMTP�������Ƿ���Ҫ��֤��trueΪ��Ҫ��falseΪ����Ҫ
        $mail->SMTPAuth   = $_G['system']['con_email_auth']?true:false;
        # �������SMTP������
        $mail->Host       = $_G['system']['con_email_host'];
        # �����ͨSMTP��������䣻����һ��163�������
        $mail->Username   = $_G['system']['con_email_email'];
        # ��� ���������Ӧ������
        $mail->Password   = $_G['system']['con_email_pwd'];
        # ���������Email
        $mail->From       = $_G['system']['con_email_from'];
        # ����������ǳƻ�����
        $mail->FromName   = $_G['system']['con_webname'];
        # ����ʼ����⣨���⣩
        $mail->Subject    = $subject;
        # ��ѡ�����ı��������û�����������
        $mail->AltBody    = "";
        # �Զ����е�����
        $mail->WordWrap   = 50;

        $mail->MsgHTML($body);

        # �ظ������ַ
        $mail->AddReplyTo($mail->From, $mail->FromName);

        # ��Ӹ���,ע��·��
        # $mail->AddAttachment("/path/to/file.zip");
        # $mail->AddAttachment("/path/to/image.jpg", "new.jpg");

        # �ռ��˵�ַ������һ�������˵������ַ������Ӷ�������������ռ��˳ƺ�
        //foreach ($to as $list) {
            //$mail->AddAddress($list[0], $list[1]);
        //}
		
		$mail->AddAddress(join(",",$to));
		
        # �Ƿ���HTML��ʽ���ͣ�������ǣ���ɾ������
        $mail->IsHTML(true);



        if(!$mail->Send()) {

          self::$msg = $mail->ErrorInfo;
          return false;
        }

        return true;
    }
    /**
     * �����ʼ�
     * @param $subject ����
     * @param $body �ʼ�����
     * @param $from ��������
     * @param $from_name �����ǳ�
     * @param $to �ʼ������� array(
     *      array(mail_address, mail_name)
     * )
     * @return bool
     */
    public static function SendHouTai ($subject, $body, $to, $email_info) {
        global $mysql, $_G;

        $mail = new PHPMailer();
        $body = eregi_replace("[\]",'',$body);
        
        $mail->CharSet = 'gbk';
        $mail->IsSMTP();        
       
        # ���SMTP�������Ƿ���Ҫ��֤��trueΪ��Ҫ��falseΪ����Ҫ
        $mail->SMTPAuth   = $email_info['site_email_auth']?true:false;
        # �������SMTP������
        $mail->Host       = $email_info['site_email_host'];
        # �����ͨSMTP��������䣻����һ��163�������
        $mail->Username   = $email_info['site_email'];
        # ��� ���������Ӧ������
        $mail->Password   = $email_info['site_email_pwd'];
        # ���������Email
        $mail->From       = $email_info['site_email'];
        # ����������ǳƻ�����
        $mail->FromName   = $email_info['sitename'];;
        # ����ʼ����⣨���⣩
        $mail->Subject    = $subject;
        # ��ѡ�����ı��������û�����������
        $mail->AltBody    = "";
        # �Զ����е�����
        $mail->WordWrap   = 50;

        $mail->MsgHTML($body);

        # �ظ������ַ
        $mail->AddReplyTo($mail->From, $mail->FromName);

        # ��Ӹ���,ע��·��
        # $mail->AddAttachment("/path/to/file.zip");
        # $mail->AddAttachment("/path/to/image.jpg", "new.jpg");

        # �ռ��˵�ַ������һ�������˵������ַ������Ӷ�������������ռ��˳ƺ�
        //foreach ($to as $list) {
            //$mail->AddAddress($list[0], $list[1]);
        //}
		
		$mail->AddAddress(join(",",$to));
		
        # �Ƿ���HTML��ʽ���ͣ�������ǣ���ɾ������
        $mail->IsHTML(true);

        if(!$mail->Send()) {
          self::$msg = $mail->ErrorInfo;
          return false;
        }

        return true;
    }
}
?>
