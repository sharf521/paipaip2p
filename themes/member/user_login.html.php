<?php
!defined('IN_TEMPLATE') && exit('Access Denied');
?>
{include file="user_header.html" }
<form name="login" method="post" action="" id="log_in">
<div id="main" class="clearfix">
	<div class="box mt10">
		<div class="box-con loginbg">
			<div class="reg-header"><h3>�û���¼</h3><span>��û���˺�<a href="/index.action?user&q=action/reg">���ע��</a></span></div>
			<ul class="reg-table">
				<li>
					<div class="reg-l-title">�û�����</div>
					<div class="reg-l-input">
						<!--  add for bug 58 begin -->
						<!-- 
						<select name="keywords" id="keywords" ><option value="user0015">user0015</option><option value="loaner">loaner</option><option value="borrower">borrower</option><option value="voucher">voucher</option></select>
						-->
						<input type="text"  id="keywords" name="keywords" maxlength="64" style="color:#999" >
						
						<!--  add for bug 58 end -->
					</div>
				</li>
				<li>
					<div class="reg-l-title">���룺</div>
					<div class="reg-l-input"><input type="password"  name="password" id="password" maxlength="16" value=""/></div>
					<div class="reg-l-tips"><a tabindex="100" href="/index.php?user&q=action/getpwd">��������</a></div>
				</li>
				<li>
					<div class="reg-l-title">��֤�룺</div>
					<div class="reg-l-input"><input name="valicode" type="text" size="6" maxlength="4"    style="float:left;width:100px;"/><img src="/plugins/index.php?q=imgcode" alt="���ˢ��" onClick="this.src='/plugins/index.php?q=imgcode&t=' + Math.random();" align="absmiddle" style="cursor:pointer;float:left;width:50px;" /></div>
				</li>				
				<li style="display:none">
					<div class="reg-l-title">��̬���</div>
					<div class="reg-l-input"> <input type="text" name="uchoncode" id="uchoncode" maxlength="6" /></div>
					<div class="reg-l-tips">(��ѡ)</div>
				</li>
				<li style="padding-left:90px">
                <input type="submit" value="������¼" class="btn-action" />
                </li>
			</ul>
            {loop module="scrollpic" function="GetList" areaid="$_G.areaid" var="var"  limit="1" type_id="2"}
	                <a href="{$var.url}"><img src="/{$var.pic}" class="loginimg" height="310" width="475" ></a>
	        {/loop}
		</div>
	</div>
</div>
</form>



{include file="user_footer.html" }