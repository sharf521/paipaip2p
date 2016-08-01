{include file="user_header.html" }
<link href="{$tempdir}/media/css/modal.css" rel="stylesheet" type="text/css" />
<form action="" method="post" name="formUser" onSubmit="return userReg();" id="reg_sub">
<div id="main" class="clearfix" style="margin-top:10px;">
	{loop module="scrollpic" function="GetList" areaid="$_G.areaid" var="var"  limit="1" type_id="15"}
	<a href="{$var.url}"><img src="/{$var.pic}" style="width:950px;height:150px;"></a>
	{/loop}
        
    <div class="reg-pro reglc mt10">注册步骤：<span>1.填写注册信息</span> > 2.邮箱认证 > 3.上传头像> 4.注册完成</a></div>
	<div class="box mt10">
        
		<div class="box-con">
			<div class="reg-header"><h3>免费注册</h3><span>我已经有账号<a href="/index.action?user&q=action/login">登录</a></span></div>
			<ul class="reg-table">
				<li>
					<div class="reg-l-title">用户名：</div>
					<div class="reg-l-input"><input id="username" name="username" type="text" size="22" maxlength="60" value="" onFocus="this.className='biankuang1';"  onBlur="this.className='biankuang2';checkUsername(this.value);"></div>
					<div class="reg-l-tips" id="username_notice"><span>*</span> 请输入4-15位字符.英文,数字</div>
				</li>
				<li>
					<div class="reg-l-title">密码：</div>
					<div class="reg-l-input"><input id="password" name="password" type="password" size="22" maxlength="60" value="" onFocus="this.className='biankuang1';"  onBlur="this.className='biankuang2';checkPassword(this.value);" ></div>
					<div class="reg-l-tips" id="password_notice"><span>*</span> 请输入6到16位密码</div>
				</li>
				<li>
					<div class="reg-l-title">确认密码：</div>
					<div class="reg-l-input"><input id="conform_password" name="confirm_password" type="password" size="22" maxlength="60" value="" onFocus="this.className='biankuang1';"  onBlur="this.className='biankuang2';checkConformPassword(this.value);"></div>
					<div class="reg-l-tips" id="conform_password_notice"><span>*</span> 请重复输入上面的密码</div>
				</li>
				<li>
					<div class="reg-l-title">Email：</div>
					<div class="reg-l-input"><input id="email" name="email" type="text" size="22" maxlength="60" value="" onFocus="this.className='biankuang1';"  onBlur="this.className='biankuang2';checkEmail(this.value);"></div>
					<div class="reg-l-tips" id="email_notice"><span>*</span> 请输入您常用的邮箱地址,会邮箱认证</div>
				</li>
				<li>
					<div class="reg-l-title">真实姓名：</div>
					<div class="reg-l-input"><input id="realname" name="realname" type="text" size="22" maxlength="60" value="" onFocus="this.className='biankuang1';"  onBlur="this.className='biankuang2';checkRealname(this.value);"></div>
					<div class="reg-l-tips" id="realname_notice"><span>*</span> 请填写你的真实姓名</div>
				</li>
				<li>
					<div class="reg-l-title">介绍人：</div>
					<div class="reg-l-input"><input id="invite_username" name="invite_username" type="text" size="22" maxlength="60" value="{$magic.session.reginvite_user_Name}" onFocus="this.className='biankuang1';"  onBlur="this.className='biankuang2';" ></div>
					<div class="reg-l-tips">介绍人的本站用户名</div>
				</li>
				<li class="reg-li" style="padding:10px 90px;"><input type="checkbox" name="ok" checked="checked" />我已阅读并且同意 
				{loop module="links" function="GetList" subsite=$_G.areaid var="var"  limit="1" type="3"}
                        <a href="/{$var.logoimg}" target="_blank">使用协议</a>
                        {/loop}
				</li>
				<li class="reg-li" style="padding:10px 90px;"><input type="submit" class="btn-action" value="立即注册" /></li>
			</ul>
			<div class="guanggao">
			{loop module="scrollpic" function="GetList" areaid="$_G.areaid" var="var"  limit="1" type_id="14"}
	                <a href="{$var.url}"><img src="/{$var.pic}" style="width:315px;height:305px;"></a>
	                {/loop}
			</div>
		</div>
	</div>
</div>
</form>
{literal}
<script type="text/javascript">
jQuery('#reg_btn').click(function(){
	jQuery('#reg_sub').submit();
});
</script>

{/literal}
<script src="/themes/js/modal.js"></script>
<script src="/themes/js/tab.js"></script>
<script type="text/javascript"  src="/themes/js/user2.js"></script>
<script src="/themes/js/tooltip.js"></script>
<script src="/themes/js/popover.js"></script>
<script src="/themes/js/transition.js"></script>
{include file="user_footer.html" }