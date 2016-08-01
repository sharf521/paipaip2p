<?php
!defined('IN_TEMPLATE') && exit('Access Denied');
?>
{include file="user_header.html"}
<link href="{$tempdir}/media/css/modal.css" rel="stylesheet" type="text/css" />
<div id="main" class="clearfix">

			<form action="" method="post" name="formUser" >
			<div class="user_action_reg_form">
				{if $_U.updatepwd_msg!=""}
                     <div class="mima_xiu_biaoti">
                     </div>
                     <div class="mima_xiu">
                             <div class="D01">恭喜您 ：{$_U.updatepwd_msg}</div>
                             <div class="D02">以后将使用新的密码登录帐号，请牢记！</div>
                             <a class="A001">您需要:</a>
                             <a class="A002"href="index.php?user&q=action/login" >重新登录</a>
                     </div>
					
                    
                </div>
				{else}
				<div class="alert alert-info" style=" background-color:#f5f5f5 ; border:0; color:#525252;"> <a class="close" data-dismiss="alert">x</a>{if $_U.update_msg==""}请重新设置你的登录密码{else}{$_U.update_msg}{/if}</div> <br />
				<p class="YOMHHU">
				  <label for="email">用户名：</label>
				  <strong style="font-size:16px;">{$_U.user_result.username}</strong>
				</p>
				<br/>
				<p class="YOMHHU">
				  <label for="email">密&nbsp;&nbsp;&nbsp;&nbsp;码：</label>
				  <input type="password" maxLength=15  class="user_aciton_input1" name=password id=password >
				</p>
				<br/>
				<p class="YOMHHU">
				  <label for="email">确认密码：</label>
				  <input type="password"  maxLength=15  class="user_aciton_input1" name=confirm_password id=confirm_password  >
				</p>
				<br/>
				<p  align="left" class="YOMHHU">
				<span> <input type="submit" value="确认" class="btn-action"  /> <input type="hidden" name="id" value="{$magic.request.id}" /></span>
				</p>	
				
				{/if}
			</div>
			</form>
		
</div>
<!--用户注册 结束-->
<script src="/themes/js/modal.js"></script>
<script src="/themes/js/tab.js"></script>
<script src="/themes/js/alert.js"></script>
<script src="/themes/js/transition.js"></script>

{include file="user_footer.html"}