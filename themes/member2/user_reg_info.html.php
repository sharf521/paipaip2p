{include file="user_header.html" }
<link href="{$tempdir}/media/css/modal.css" rel="stylesheet" type="text/css" />
<form action="" method="post" name="formUser" onSubmit="return userReg();" id="reg_sub">
<div id="main" class="clearfix" style="margin-top:10px;">
	{loop module="scrollpic" function="GetList" areaid="$_G.areaid" var="var"  limit="1" type_id="15"}
	<a href="{$var.url}"><img src="/{$var.pic}" style="width:1000px;height:150px;"></a>
	{/loop}
        
    <div class="reg-pro_reglc_mt10">
          <span>ע�Ჽ�裺</span><a>1.��дע����Ϣ</a> > <a>2.������֤ </a><a>> 3.�ϴ�ͷ��</a><a>> 4.ע�����</a>
    </div>
	<div class="box_mt10">
        <div class="guanggao">
			{loop module="scrollpic" function="GetList" areaid="$_G.areaid" var="var"  limit="1" type_id="14"}
	                <a href="{$var.url}"><img src="/{$var.pic}"></a>
	                {/loop}
	    </div>
        <div class="box-con">
            
			<div class="reg-header">
                 <h3>���ע��</h3>
           </div>
			<ul class="reg-table">
				<li class="reg-l-input">
					<label>�û�����</label>
					<input id="username" name="username" type="text" size="22" maxlength="60" value="" onFocus="this.className='biankuang1';"  onBlur="this.className='biankuang2';checkUsername(this.value);">
					<a id="username_notice"><span>*������4-15λ�ַ�</span></a> 
				</li>
				<li class="reg-l-input">
					<label>���룺</label>
					<input id="password" name="password" type="password" size="22" maxlength="60" value="" onFocus="this.className='biankuang1';"  onBlur="this.className='biankuang2';checkPassword(this.value);" >
					<a id="password_notice"><span>*������6��16λ����</span></a> 
				</li>
				<li class="reg-l-input">
					<label>ȷ�����룺</label>
					<input id="conform_password" name="confirm_password" type="password" size="22" maxlength="60" value="" onFocus="this.className='biankuang1';"  onBlur="this.className='biankuang2';checkConformPassword(this.value);">
                    <a id="conform_password_notice"><span>*���ظ��������������</span></a> 
				</li>
				<li class="reg-l-input">
					<label>Email��</label>
					<input id="email" name="email" type="text" size="22" maxlength="60" value="" onFocus="this.className='biankuang1';"  onBlur="this.className='biankuang2';checkEmail(this.value);">
					<a id="email_notice"><span>*�����������õ������ַ</span></a> 
				</li>
				<li class="reg-l-input">
					<label>��ʵ������</label>
					<input id="realname" name="realname" type="text" size="22" maxlength="60" value="" onFocus="this.className='biankuang1';"  onBlur="this.className='biankuang2';checkRealname(this.value);">
					<a id="realname_notice"><span>*����д�����ʵ����</span></a> 
				</li>
				<li class="reg-l-input">
					<label>�����ˣ�</label>
					<input id="invite_username" name="invite_username" type="text" size="22" maxlength="60" value="{$magic.session.reginvite_user_Name}" onFocus="this.className='biankuang1';"  onBlur="this.className='biankuang2';" >
					<a><span>�����˵ı�վ�û���</span></a>
				</li>
				<li class="reg-linput">
                     <input type="checkbox" name="ok" checked="checked" />                       
                     <label>�����Ķ�����ͬ��</label> 
				{loop module="links" function="GetList" subsite=$_G.areaid var="var"  limit="1" type="3"}
                     <a href="/{$var.logoimg}" target="_blank">ʹ��Э��</a>
                {/loop}
				</li>
				<li class="li-ji-anniu">
                     <input type="submit" class="btn-action" value="����ע��" />
                </li>
                <li class="reg-l-input02">
                     <span>���Ѿ����˺�</span>
                     <a href="/index.action?user&q=action/login">��¼</a>
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