{include file="user_header.html" }
<link href="{$tempdir}/media/css/modal.css" rel="stylesheet" type="text/css" />
<form action="" method="post" name="formUser" onSubmit="return userReg();" id="reg_sub">
<div id="main" class="clearfix" style="margin-top:10px;">
	{loop module="scrollpic" function="GetList" areaid="$_G.areaid" var="var"  limit="1" type_id="15"}
	<a href="{$var.url}"><img src="/{$var.pic}" style="width:950px;height:150px;"></a>
	{/loop}
        
    <div class="reg-pro reglc mt10">ע�Ჽ�裺<span>1.��дע����Ϣ</span> > 2.������֤ > 3.�ϴ�ͷ��> 4.ע�����</a></div>
	<div class="box mt10">
        
		<div class="box-con">
			<div class="reg-header"><h3>���ע��</h3><span>���Ѿ����˺�<a href="/index.action?user&q=action/login">��¼</a></span></div>
			<ul class="reg-table">
				<li>
					<div class="reg-l-title">�û�����</div>
					<div class="reg-l-input"><input id="username" name="username" type="text" size="22" maxlength="60" value="" onFocus="this.className='biankuang1';"  onBlur="this.className='biankuang2';checkUsername(this.value);"></div>
					<div class="reg-l-tips" id="username_notice"><span>*</span> ������4-15λ�ַ�.Ӣ��,����</div>
				</li>
				<li>
					<div class="reg-l-title">���룺</div>
					<div class="reg-l-input"><input id="password" name="password" type="password" size="22" maxlength="60" value="" onFocus="this.className='biankuang1';"  onBlur="this.className='biankuang2';checkPassword(this.value);" ></div>
					<div class="reg-l-tips" id="password_notice"><span>*</span> ������6��16λ����</div>
				</li>
				<li>
					<div class="reg-l-title">ȷ�����룺</div>
					<div class="reg-l-input"><input id="conform_password" name="confirm_password" type="password" size="22" maxlength="60" value="" onFocus="this.className='biankuang1';"  onBlur="this.className='biankuang2';checkConformPassword(this.value);"></div>
					<div class="reg-l-tips" id="conform_password_notice"><span>*</span> ���ظ��������������</div>
				</li>
				<li>
					<div class="reg-l-title">Email��</div>
					<div class="reg-l-input"><input id="email" name="email" type="text" size="22" maxlength="60" value="" onFocus="this.className='biankuang1';"  onBlur="this.className='biankuang2';checkEmail(this.value);"></div>
					<div class="reg-l-tips" id="email_notice"><span>*</span> �����������õ������ַ,��������֤</div>
				</li>
				<li>
					<div class="reg-l-title">��ʵ������</div>
					<div class="reg-l-input"><input id="realname" name="realname" type="text" size="22" maxlength="60" value="" onFocus="this.className='biankuang1';"  onBlur="this.className='biankuang2';checkRealname(this.value);"></div>
					<div class="reg-l-tips" id="realname_notice"><span>*</span> ����д�����ʵ����</div>
				</li>
				<li>
					<div class="reg-l-title">�����ˣ�</div>
					<div class="reg-l-input"><input id="invite_username" name="invite_username" type="text" size="22" maxlength="60" value="{$magic.session.reginvite_user_Name}" onFocus="this.className='biankuang1';"  onBlur="this.className='biankuang2';" ></div>
					<div class="reg-l-tips">�����˵ı�վ�û���</div>
				</li>
				<li class="reg-li" style="padding:10px 90px;"><input type="checkbox" name="ok" checked="checked" />�����Ķ�����ͬ�� 
				{loop module="links" function="GetList" subsite=$_G.areaid var="var"  limit="1" type="3"}
                        <a href="/{$var.logoimg}" target="_blank">ʹ��Э��</a>
                        {/loop}
				</li>
				<li class="reg-li" style="padding:10px 90px;"><input type="submit" class="btn-action" value="����ע��" /></li>
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