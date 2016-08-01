<?php
!defined('IN_TEMPLATE') && exit('Access Denied');
?>
{include file="user_header.html" }
<link href="{$tempdir}/media/css/modal.css" rel="stylesheet" type="text/css" />

<!--用户注册 开始-->
<div id="main" class="clearfix">
<div class="user_action_main">
	<!--用户注册左边 开始-->
	<div class="user_action_reg_left">
		<!--用户注册 开始-->
		<div class="user_action_getpwd_top"></div>
		<div class="user_action_reg_submit" style="padding-top:0">
		
		<form action="" method="post" name="formUser" >
		<div class="user_action_reg_form">
			<p class="alert">{if $_U.getpwd_msg==""}请填写你的邮箱和用户名进行密码的重置{else}<font color="#FF0000">{$_U.getpwd_msg}</font>{/if}</p>
				<p style="margin-top:40px; margin-left:40px;">
				  <label  style="text-align:center; width:90px;  float:left">电子邮箱：</label>
				  <input  maxLength=32  class="user_aciton_input1" name=email id=email>
				</p>
				<p style="margin-top:40px;margin-left:40px;">
				  <label  style="text-align:center; width:90px; float:left">用户名：</label>
				  <input maxLength=15  class="user_aciton_input1" name=username id=username>
				</p>
				<p style="margin-top:40px;margin-left:40px;">
				  <label for="email" style=" float:left; text-align:center; width:90px; ">验证码：</label>
				  <span style="float:left;"><input maxLength=4  class="user_aciton_input" name=valicode id=valicode align="top" ></span>
				   <span style="float:left;margin-left:5px;">
				   <img src="/plugins/index.php?q=imgcode&height=23" alt="点击刷新" onClick="this.src='/plugins/index.php?q=imgcode&height=23&t=' + Math.random();"  />
				   </span>
				</p>
				<br/><br/>
				<p align="left" style="width:260px; margin-top:40px; margin-left:60px;"> 
				 <input type="submit" value="确认" class="btn-action"/>
				</p>
			
			</div>
		</form>
		</div>
		<div class="user_action_reg_foot"></div>
	</div>
</div>
</div>
<!--用户注册 结束-->
<script src="/themes/js/tab.js"></script>
<script src="/themes/js/alert.js"></script>
<script src="/themes/js/transition.js"></script>

{include file="user_footer.html"}