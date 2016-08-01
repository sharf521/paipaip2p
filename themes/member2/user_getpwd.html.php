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
		<div class="user_action_reg_submit">
		
		<form action="" method="post" name="formUser" >
		<div class="user_action_reg_form">
			<div class="alert">{if $_U.getpwd_msg==""}请填写你的邮箱和用户名进行密码的重置{else}<font color="#FF0000">{$_U.getpwd_msg}</font>{/if}</div>
                <div class="zhao-hui-mi-ma">
                    <div class="biao-ti00">
                          <h3>密码找回</h3>
                    </div>
                    <div class="nei_rong">
                      <label  >电子邮箱：</label>
                      <input  maxLength=32  class="user_aciton_input1" name=email id=email>
                    </div>
                    <div class="nei_rong">
                      <label  >用户名：</label>
                      <input maxLength=15  class="user_aciton_input1" name=username id=username>
                    </div>
                    <div class="nei_rong02">
                      <label for="email">验证码：</label>
                      <input maxLength=4  class="user_aciton_input" name=valicode id=valicode >
                       <span style="margin-left:5px;">
                       <img src="/plugins/index.php?q=imgcode&height=23" alt="点击刷新" onClick="this.src='/plugins/index.php?q=imgcode&height=23&t=' + Math.random();"  />
                       </span>
                    </div>
                    
                    <div class="que-ding-anniu"> 
                     <input type="submit" value="确认" />
                    </div>
                </div>
                <div class="wang-ji-mima-tupian">
                      <img src="/themes/member/images/beijing-wangji.jpg"/>
                </div>
			
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