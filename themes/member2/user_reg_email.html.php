{include file="user_header.html" }
<link href="{$tempdir}/media/css/main.css" type="text/css" rel="stylesheet" />
<link href="{$tempdir}/media/css/user.css" type="text/css" rel="stylesheet" />
<link href="{$tempdir}/media/css/tipswindown.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="/themes/js/jquery.js"></script>
<script type="text/javascript" src="/themes/js/user.js"></script>
<script type="text/javascript" src="/themes/js/tipswindown.js"></script>
<body>

<!--�û���¼ע���ͷ�� ��ʼ-->
<div id="main" style="margin-top:20px;">
<!--�û���¼ע���ͷ�� ����-->

<!--�û�ע�� ��ʼ-->
<div class="user_action_main topborder">

	<!--�û�ע����� ��ʼ-->
	<div class="user_action_reg_left">
		<!--�û�ע�� ��ʼ-->
		<div class="user_action_reg_top"></div>
		<div class="user_action_reg_submit">
			<div class="user_action_reg_a1"></div>
			<div class="user_action_reg_form" style="width:86%">
			<strong style="font-size:14px;">{$_U.sendemail}</strong> ���յ�һ����֤�ʼ�������ա�
�ɹ���֤����Ϳ��Գ���ʹ��վ�����й��ܡ�<br /><br />

<a href="{$_U.emailurl}" target="_blank"><img src="{$tempdir}/images/renzheng.png" align="absmiddle" /></a><br /><br />

���û���յ����䣬������ <a href="javascript:void(0);" onclick='tipsWindown("�ʼ�����","url:get?index.php?user&q=action/reg_send_email",300,100,"true","","true","text")'><font color="#FF0000">���¼���</font></a>������䡣<br />
<a href="/index.php?user&q=action/reg_email&jump=true">���������֤��������������ȥ</a>
			</div>
		</div>
		<div class="user_action_reg_foot"></div>
	</div>
	{include file="user_reg_right.html"}
</div>
</div>
<!--�û�ע�� ����-->


{include file="user_footer.html"}
