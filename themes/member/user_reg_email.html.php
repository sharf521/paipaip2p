{include file="user_header.html" }
<link href="{$tempdir}/media/css/main.css" type="text/css" rel="stylesheet" />
<link href="{$tempdir}/media/css/user.css" type="text/css" rel="stylesheet" />
<link href="{$tempdir}/media/css/tipswindown.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="/themes/js/jquery.js"></script>
<script type="text/javascript" src="/themes/js/user.js"></script>
<script type="text/javascript" src="/themes/js/tipswindown.js"></script>
<body>

<!--用户登录注册的头部 开始-->
<div id="main" style="margin-top:20px;">
<!--用户登录注册的头部 结束-->

<!--用户注册 开始-->
<div class="user_action_main topborder">

	<!--用户注册左边 开始-->
	<div class="user_action_reg_left">
		<!--用户注册 开始-->
		<div class="user_action_reg_top"></div>
		<div class="user_action_reg_submit">
			<div class="user_action_reg_a1"></div>
			<div class="user_action_reg_form" style="width:86%">
			<strong style="font-size:14px;">{$_U.sendemail}</strong> 将收到一封认证邮件，请查收。
成功认证后，你就可以畅快使用站内所有功能。<br /><br />

<a href="{$_U.emailurl}" target="_blank"><img src="{$tempdir}/images/renzheng.png" align="absmiddle" /></a><br /><br />

如果没有收到邮箱，请点击此 <a href="javascript:void(0);" onclick='tipsWindown("邮件激活","url:get?index.php?user&q=action/reg_send_email",300,100,"true","","true","text")'><font color="#FF0000">重新激活</font></a>你的邮箱。<br />
<a href="/index.php?user&q=action/reg_email&jump=true">如果不想认证，请点击这里跳过去</a>
			</div>
		</div>
		<div class="user_action_reg_foot"></div>
	</div>
	{include file="user_reg_right.html"}
</div>
</div>
<!--用户注册 结束-->


{include file="user_footer.html"}
