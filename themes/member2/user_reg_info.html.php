{include file="user_header.html" }
<link href="{$tempdir}/media/css/modal.css" rel="stylesheet" type="text/css" />
<form action="" method="post" name="formUser" onSubmit="return userReg();" id="reg_sub">
<div id="main" class="clearfix" style="margin-top:10px;">
	{loop module="scrollpic" function="GetList" areaid="$_G.areaid" var="var"  limit="1" type_id="15"}
	<a href="{$var.url}"><img src="/{$var.pic}" style="width:1000px;height:150px;"></a>
	{/loop}
        
    <div class="reg-pro_reglc_mt10">
          <span>注册步骤：</span><a>1.填写注册信息</a> > <a>2.邮箱认证 </a><a>> 3.上传头像</a><a>> 4.注册完成</a>
    </div>
	<div class="box_mt10">
        <div class="guanggao">
			{loop module="scrollpic" function="GetList" areaid="$_G.areaid" var="var"  limit="1" type_id="14"}
	                <a href="{$var.url}"><img src="/{$var.pic}"></a>
	                {/loop}
	    </div>
        <div class="box-con">
            
			<div class="reg-header">
                 <h3>免费注册</h3>
           </div>
			<ul class="reg-table">
				<li class="reg-l-input">
					<label>用户名：</label>
					<input id="username" name="username" type="text" size="22" maxlength="60" value="" onFocus="this.className='biankuang1';"  onBlur="this.className='biankuang2';checkUsername(this.value);">
					<a id="username_notice"><span>*请输入4-15位字符</span></a> 
				</li>
				<li class="reg-l-input">
					<label>密码：</label>
					<input id="password" name="password" type="password" size="22" maxlength="60" value="" onFocus="this.className='biankuang1';"  onBlur="this.className='biankuang2';checkPassword(this.value);" >
					<a id="password_notice"><span>*请输入6到16位密码</span></a> 
				</li>
				<li class="reg-l-input">
					<label>确认密码：</label>
					<input id="conform_password" name="confirm_password" type="password" size="22" maxlength="60" value="" onFocus="this.className='biankuang1';"  onBlur="this.className='biankuang2';checkConformPassword(this.value);">
                    <a id="conform_password_notice"><span>*请重复输入上面的密码</span></a> 
				</li>
				<li class="reg-l-input">
					<label>Email：</label>
					<input id="email" name="email" type="text" size="22" maxlength="60" value="" onFocus="this.className='biankuang1';"  onBlur="this.className='biankuang2';checkEmail(this.value);">
					<a id="email_notice"><span>*请输入您常用的邮箱地址</span></a> 
				</li>
				<li class="reg-l-input">
					<label>真实姓名：</label>
					<input id="realname" name="realname" type="text" size="22" maxlength="60" value="" onFocus="this.className='biankuang1';"  onBlur="this.className='biankuang2';checkRealname(this.value);">
					<a id="realname_notice"><span>*请填写你的真实姓名</span></a> 
				</li>
				<li class="reg-l-input">
					<label>介绍人：</label>
					<input id="invite_username" name="invite_username" type="text" size="22" maxlength="60" value="{$magic.session.reginvite_user_Name}" onFocus="this.className='biankuang1';"  onBlur="this.className='biankuang2';" >
					<a><span>介绍人的本站用户名</span></a>
				</li>
				<li class="reg-linput">
                     <input type="checkbox" name="ok" checked="checked" />                       
                     <label>我已阅读并且同意</label> 
				{loop module="links" function="GetList" subsite=$_G.areaid var="var"  limit="1" type="3"}
                     <a href="/{$var.logoimg}" target="_blank">使用协议</a>
                {/loop}
				</li>
				<li class="li-ji-anniu">
                     <input type="submit" class="btn-action" value="立即注册" />
                </li>
                <li class="reg-l-input02">
                     <span>我已经有账号</span>
                     <a href="/index.action?user&q=action/login">登录</a>
                </li>
			</ul>
			
		</div>
	</div>
</div>
</form>

<script src="/themes/js/modal.js"></script>
<script src="/themes/js/tab.js"></script>
<script type="text/javascript"  src="/themes/js/user2.js"></script>
<script src="/themes/js/tooltip.js"></script>
<script src="/themes/js/popover.js"></script>
<script src="/themes/js/transition.js"></script>
{include file="user_footer.html" }