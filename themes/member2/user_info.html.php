<?php
!defined('IN_TEMPLATE') && exit('Access Denied');
?>
{include file="user_header.html"}
<link href="{$tempdir}/media/css/modal.css" rel="stylesheet" type="text/css" />
<!--用户中心的主栏目 开始-->
<div id="main" class="clearfix" style="margin-top:0px;">
<div class="wrap950 ">
	<!--左边的导航 开始-->
	<div class="user_left">
		{include file="user_menu.html"}
	</div>
	<!--左边的导航 结束-->
	
	<!--右边的内容 开始-->
	<div class="user_right">
		<div class="user_right_menu">
			{if $_U.query_type=="userpwd" || $_U.query_type=="paypwd" || $_U.query_type=="protection" || $_U.query_type=="getpaypwd" || $_U.query_type=="serialStatusSet"}
			<ul id="tab" class="list-tab clearfix">
				
				<li {if $_U.query_type=="userpwd"} class="cur"{/if}><a href="{$_U.query_url}/userpwd">登录密码</a></li>
				<li {if $_U.query_type=="paypwd" || $_U.query_type=="getpaypwd"} class="cur"{/if}><a href="{$_U.query_url}/paypwd">交易密码</a></li>
				<li {if $_U.query_type=="protection"} class="cur"{/if}><a href="{$_U.query_url}/protection">密码保护</a></li>
				<!--<li {if $_U.query_type=="serialStatusSet"} class="cur"{/if}><a href="{$_U.query_url}/serialStatusSet">动态口令设置</a></li>-->
			</ul>
			{elseif $_U.query_type=="reginvite"  || $_U.query_type=="request" || $_U.query_type=="myfriend" || $_U.query_type=="black"|| $_U.query_type=="ticheng"}
			<ul id="tab" class="list-tab clearfix">
				<li {if $_U.query_type=="reginvite"} class="cur"{/if}><a href="{$_U.query_url}/reginvite">邀请好友</a></li>
				<li {if $_U.query_type=="request"} class="cur"{/if}><a href="{$_U.query_url}/request">好友请求</a></li>
				<li {if $_U.query_type=="myfriend"} class="cur"{/if}><a href="{$_U.query_url}/myfriend">我的好友</a></li>
				<li {if $_U.query_type=="black"} class="cur"{/if}><a href="{$_U.query_url}/black">黑名单</a></li>
				<li {if $_U.query_type=="ticheng"} class="cur"{/if}><a href="{$_U.query_url}/ticheng">好友提成</a></li>
			</ul>
			{elseif $_U.query_type=="credit" }
			<ul id="tab" class="list-tab clearfix">
			</ul>
			{elseif $_U.query_type=="myuser" }
			<ul id="tab" class="list-tab clearfix">
				<li {if $_U.query_type=="myuser"} class="cur"{/if}><a href="{$_U.query_url}/myuser">我的客户</a></li>
				<li ><a href="/?user&q=code/borrow/myuser">客户借款</a></li>
				<li ><a href="/?user&q=code/borrow/myuser_account">统计信息</a></li>
			</ul>
			{else}
			<ul id="tab" class="list-tab-narrow clearfix">
				<li {if $_U.query_type=="realname"} class="cur"{/if}><a href="{$_U.query_url}/realname">实名认证</a></li>
				<li {if $_U.query_type=="email_status"} class="cur"{/if}><a href="{$_U.query_url}/email_status">邮箱认证</a></li>
				<li {if $_U.query_type=="phone_status"} class="cur"{/if}><a href="{$_U.query_url}/phone_status">手机认证</a></li>
				<li {if $_U.query_type=="video_status"} class="cur"{/if}><a href="{$_U.query_url}/video_status">视频认证</a></li>
				<li {if $_U.query_type=="scene_status"} class="cur"{/if}><a href="{$_U.query_url}/scene_status">现场认证</a></li>
				<li ><a href="/?user&q=code/attestation">上传资料证明</a></li>
				<li {if $_U.query_type=="avatar"} class="cur"{/if}><a href="{$_U.query_url}/avatar">头像信息</a></li>
				<!--<li {if $_U.query_type=="privacy"} class="cur"{/if}><a href="{$_U.query_url}/privacy">设置隐私</a></li>-->
			</ul>
			{/if}
		</div>
		
		<div class="user_right_main">
		
		{if $_U.query_type=="avatar"}
		<!--头像 开始-->
		<div class="user_help alert">请上传你网站的头像</div>
		<div style="padding-left:350px;"><img src="{$_G.user_id|avatar|imgurl_format}"/></div>
		<div>{show_avatar}</div>
		<div class="user_right_foot alert">
		* 温馨提示：头像现在有三种，大，中，小
		</div>
		<!--头像 结束-->
		
		
		{elseif $_U.query_type=="privacy"}
		<div class="user_help">设置个人的隐私</div>
		<form action="" method="post">
		<div class="user_right_border">
			<div class="e">好友列表：</div>
			<div class="c">
				<script src="plugins/?q=linkage&nid=yinsi&name=friend&isid=false&value={$_U.user_privacy.friend}"></script>
			</div>
		</div>
		
		<div class="user_right_border">
			<div class="e">好友评论：</div>
			<div class="c">
				<script src="plugins/?q=linkage&nid=yinsi&name=friend_comment&isid=false&value={$_U.user_privacy.friend_comment}"></script>
			</div>
		</div>
		
		<div class="user_right_border">
			<div class="e">借款列表：</div>
			<div class="c">
				<script src="plugins/?q=linkage&nid=yinsi&name=borrow_list&isid=false&value={$_U.user_privacy.borrow_list}"></script>
			</div>
		</div>
		
		<div class="user_right_border">
			<div class="e">投标记录：</div>
			<div class="c">
				<script src="plugins/?q=linkage&nid=yinsi&name=loan_log&isid=false&value={$_U.user_privacy.loan_log}"></script>
			</div>
		</div>
			
		
		<div class="user_main_title">站内信/加为好友</div>
		<div class="user_right_border">
			<div class="e">谁可以给我发站内信：</div>
			<div class="c">
				<script src="plugins/?q=linkage&nid=yinsi&name=sent_msg&isid=false&value={$_U.user_privacy.sent_msg}"></script>
			</div>
		</div>
		
		<div class="user_right_border">
			<div class="e">谁可以向我发好友申请：</div>
			<div class="c">
				<script src="plugins/?q=linkage&nid=yinsi&name=friend_request&isid=false&value={$_U.user_privacy.friend_request}"></script>
			</div>
		</div>
		
		
		<div class="user_main_title">黑名单</div>
		<div class="user_right_border">
			<div class="e">谁可以看我的黑名单：</div>
			<div class="c">
				<select name="look_black">
					<option value="0" {if $_U.user_privacy.look_black==0} selected="selected"{/if}>不允许我的好友查看我的黑名单</option>
					<option value="1" {if $_U.user_privacy.look_black==1} selected="selected"{/if}>允许我的好友查看我的黑名单</option>
					<option value="2"{ if $_U.user_privacy.look_black==2} selected="selected"{/if}>仅允许我同意的好友查看我的黑名单</option>
				</select>
			</div>
		</div>
		
		<div class="user_right_border">
			<div class="e">允许黑名单向我发内信：</div>
			<div class="c">
				<input type="radio" name="allow_black_sent" value="1" { if $_U.user_privacy.allow_black_sent==1} checked="checked"{/if}/> 允许 <input type="radio" name="allow_black_sent" value="0"   { if $_U.user_privacy.allow_black_sent==0 || $_U.user_privacy.allow_black_sent==""} checked="checked"{/if} /> 不允许 
			</div>
		</div>
		<div class="user_right_border">
			<div class="e">允许黑名单向我发送好友请求：</div>
			<div class="c">
				<input type="radio" name="allow_black_request" value="1"  {if $_U.user_privacy.allow_black_request==1} checked="checked"{/if}/> 允许 <input type="radio" name="allow_black_request" value="0" {if $_U.user_privacy.allow_black_request==0 || $_U.user_privacy.allow_black_request==""} checked="checked"{/if}/> 不允许 
			</div>
		</div>
		
		<div class="user_right_border">
			<div class="e"></div>
			<div class="c">
				<input type="submit"  class="btn-action"  name="name"  value="确认提交" size="30" /> 
			</div>
		</div>
		</form>
		
		<div class="user_right_foot alert">
		* 温馨提示：请保护好自己的隐私
		</div>
		<!--账号充值 结束-->
		
		
		
		{elseif $_U.query_type=="userpwd"}
		<!--修改登录密码 开始-->
		<form action="" name="form1" method="post" onsubmit="return check_form()">
		<div class="user_help alert alert">密码请不要太简单，设成复杂一点，最好字母+符号</div>
		<div class="user_right_border">
			<div class="e">原始密码：</div>
			<div class="c">
				<input type="password" name="oldpassword" /> 
			</div>
		</div>
		<div class="user_right_border">
			<div class="e">新密码：</div>
			<div class="c">
				<input type="password" name="newpassword" /> 
			</div>
		</div>
		<div class="user_right_border">
			<div class="e">确认密码：</div>
			<div class="c">
				<input type="password" name="newpassword1" /> 
			</div>
		</div>
		<div class="user_right_border">
			<div class="e"></div>
			<div class="c">
				<input type="submit" class="btn-action" name="name"  value="确认提交" size="30" /> 
			</div>
		</div>
		</form>
		<div class="user_right_foot alert">
		* 温馨提示：我们将严格对用户的所有资料进行保密
		</div>
		{literal}<script>
			function check_form(){
				 var frm = document.forms['form1'];
				 var oldpassword = frm.elements['oldpassword'].value;
				 var newpassword = frm.elements['newpassword'].value;
				  var newpassword1 = frm.elements['newpassword1'].value;
				 var errorMsg = '';
				  if (oldpassword.length == 0 ) {
					errorMsg += '* 请输入旧的登录密码' + '\n';
				  }
				  if (newpassword.length == 0 ) {
					errorMsg += '* 新密码不能为空' + '\n';
				  }
				   if (newpassword.length >15 || newpassword.length<6 ) {
					errorMsg += '* 新密码长度在6到15之间' + '\n';
				  }
				    if (newpassword.length !=newpassword1.length) {
					errorMsg += '* 两次密码不一样' + '\n';
				  }
				  if (errorMsg.length > 0){
					alert(errorMsg); return false;
				  } else{  
					return true;
				}
			
			}
		</script>{/literal}
		<!--修改登录密码 结束-->
		
<!--  LiuYY 2012-05-31 -->
		{elseif $_U.query_type =="serialStatusSet"}
		<!--修改动态口令状态 开始-->
		
		<form action="" name="form1" method="post" onsubmit="" >
		<div class="user_help alert">动态口令可以确认用户的合法身份，从而在合法身份登录的基础上保障业务业务访问的安全性。</div>
		将动态口令应用于：<br/>
		{ if  $_G.user_result.serial_id == "" }
		<font color="red" >您的账号还未绑定动态口令，无法执行相关设置！</font>
		{/if}
		<div class="user_right_border">
			<div class="e">提现：</div>
			<div class="c">
				<input type="checkbox" name="carryout"  value="1" id="carryout" { if  $_G.user_result.serial_id == "" } disabled="disabled" {/if} /> 
			</div>
			<div class="e">登录：</div>
			<div class="c">
				<input type="checkbox"  name="login" value="1" id="login" {if  $_G.user_result.serial_id == "" } disabled="disabled" {/if} /> 
			</div>
			<input type="hidden" id="json_data" value='{$_G.user_result.serial_status}' />	
		</div>
		<input type="hidden" name="action" value="1" />
		<br/>
		<div class="">
			<div class="e"></div>
			请输入动态口令码: <input type="text" maxlength="6" name="uchoncode" {if $_G.user_result.serial_id == "" } disabled="disabled" {/if} /> 
			<div class="c">
			<br/>
				<input type="submit"  class="btn-action" name="name"  value="确认提交" size="30" { if  $_G.user_result.serial_id == "" } disabled="disabled" {/if} /> 
			</div>
		</div>
	
	
		</form>
		<div class="user_right_foot alert">
		* 温馨提示：我们将严格对用户的所有资料进行保密
		</div>
		{literal}
		<script src="j.js"></script>
		 <script >
		jQuery(function(){
			

			var json_data = jQuery("#json_data").attr('value');
			var obj=eval("("+json_data+")");
			if(obj.carryout=='1'){
				jQuery("#carryout").attr("checked","checked");
			}
			if(obj.login == '1'){
				jQuery("#login").attr("checked","checked");
			}
			
		});
    </script>{/literal}
		<!--修改动态口令状态 结束-->		
		{elseif $_U.query_type=="paypwd"}
		<!--修改安全密码 开始-->
		<form action="" name="form1" method="post" onsubmit="return check_form()">
		<div class="user_help alert alert">请把密码设置复杂,并认真保管好自己的密码!（字母+符号尤佳）</div>
		<div class="user_right_border">
			<div class="l">原始交易密码：</div>
			<div class="c">
				<input type="password" name="oldpassword" /> 请输入原交易密码。(初始交易密码与您注册时的登录密码一致)
			</div>
		</div>
		<div class="user_right_border">
			<div class="l">新交易密码：</div>
			<div class="c">
				<input type="password" name="newpassword" /> 
			</div>
		</div>
		<div class="user_right_border">
			<div class="l">确认交易密码：</div>
			<div class="c">
				<input type="password" name="newpassword1" /> 
			</div>
		</div>
		<div class="user_right_border">
			<div class="l">验证码：</div>
			<div class="c">
				<input name="valicode" type="text" size="11" maxlength="4"  tabindex="3"/>&nbsp;<img src="/plugins/?q=imgcode" alt="点击刷新" onClick="this.src='/plugins/?q=imgcode&t=' + Math.random();" align="absmiddle" style="cursor:pointer" />
			</div>
		</div>
		<div class="user_right_border">
			<div class="l"></div>
			<div class="c">
				<input type="submit"  class="btn-action" name="name"  value="确认提交" size="30" /> <a href="/?user&q=code/user/getpaypwd">忘记交易密码？</a>
			</div>
		</div>
		</form>
		<div class="user_right_foot alert">
		* 温馨提示：我们将严格对用户的所有资料进行保密
		</div>
		<!--修改安全密码 结束-->
		{literal}<script>
			function check_form(){
				 var frm = document.forms['form1'];
				 var oldpassword = frm.elements['oldpassword'].value;
				 var newpassword = frm.elements['newpassword'].value;
				  var newpassword1 = frm.elements['newpassword1'].value;
				 var errorMsg = '';
				  if (oldpassword.length == 0 ) {
					errorMsg += '* 请输入旧密码，如果没有设定交易密码，请输入登录密码' + '\n';
				  }
				  if (newpassword.length == 0 ) {
					errorMsg += '* 新密码不能为空' + '\n';
				  }
				   if (newpassword.length >15 || newpassword.length<6 ) {
					errorMsg += '* 新密码长度在6到15之间' + '\n';
				  }
				    if (newpassword.length !=newpassword1.length) {
					errorMsg += '* 两次密码不一样' + '\n';
				  }
				  if (errorMsg.length > 0){
					alert(errorMsg); return false;
				  } else{  
					return true;
				}
			
			}
		</script>{/literal}
		
		
		{elseif $_U.query_type=="getpaypwd"}
		<!--修改安全密码 开始-->
		{if $magic.request.id!=""}
		<form action="" name="form1" method="post" onsubmit="return check_form()" >
		<div class="user_help">请重新输入您的支付密码</div>
		<div class="user_right_border">
			<div class="l">请输入密码：</div>
			<div class="c">
				<input type="password" name="paypwd" />
			</div>
		</div>
		<div class="user_right_border">
			<div class="l">请再一次输入密码：</div>
			<div class="c">
				<input type="password" name="paypwd1" />
			</div>
		</div>
		<div class="user_right_border">
			<div class="l">验证码：</div>
			<div class="c">
				<input name="valicode" type="text" size="11" maxlength="4"  tabindex="3"/>&nbsp;<img src="/plugins/?q=imgcode" alt="点击刷新" onClick="this.src='/plugins/?q=imgcode&t=' + Math.random();" align="absmiddle" style="cursor:pointer" />
			</div>
		</div>
		<div class="user_right_border">
			<div class="l"></div>
			<div class="c">
				<input type="submit"  class="btn-action" name="name"  value="确认提交" size="30" /> 
			</div>
		</div>
		</form>
		{literal}<script>
			function check_form(){
				 var frm = document.forms['form1'];
				 var newpassword = frm.elements['paypwd'].value;
				  var newpassword1 = frm.elements['paypwd1'].value;
				 var errorMsg = '';
				  if (newpassword.length == 0 ) {
					errorMsg += '* 新密码不能为空' + '\n';
				  }
				   if (newpassword.length >15 || newpassword.length<6 ) {
					errorMsg += '* 新密码长度在6到15之间' + '\n';
				  }
				    if (newpassword.length !=newpassword1.length) {
					errorMsg += '* 两次密码不一样' + '\n';
				  }
				  if (errorMsg.length > 0){
					alert(errorMsg); return false;
				  } else{  
					return true;
				}
			
			}
		</script>{/literal}
		{else}
		<form action="" name="form1" method="post" >
		<div class="user_help">请登录邮箱找回</div>
		<div class="user_right_border">
			<div class="l">您的邮箱：</div>
			<div class="c">
				{$_G.user_result.email}
			</div>
		</div>
		<div class="user_right_border">
			<div class="l">验证码：</div>
			<div class="c">
				<input name="valicode" type="text" size="11" maxlength="4"  tabindex="3"/>&nbsp;<img src="/plugins/?q=imgcode" alt="点击刷新" onClick="this.src='/plugins/?q=imgcode&t=' + Math.random();" align="absmiddle" style="cursor:pointer" />
			</div>
		</div>
		<div class="user_right_border">
			<div class="l"></div>
			<div class="c">
				<input type="submit"  class="btn-action" name="name"  value="确认提交" size="30" /> 
			</div>
		</div>
		</form>
		{/if}
		<div class="user_right_foot alert">
		* 温馨提示：我们将严格对用户的所有资料进行保密
		</div>
		<!--修改安全密码 结束-->
		{elseif $_U.query_type=="protection"}
		<!--密码保护 开始-->
		 <form action="" method="post">
		{if $_U.answer_type=="2" || $_G.user_result.answer == "" }
		<div class="user_help alert">请选择一个新的账号保护问题,并输入答案。账号保护可以为您以后在忘记密码、重要设置等操作的时候,提供安全保障。 </div>
		<div class="user_right_border">
			<div class="l">请选择问题：</div>
			<div class="c">
				<script src="/plugins/?q=linkage&name=question&nid=pwd_protection&isid=false"></script> 
			</div>
		</div>
		<div class="user_right_border">
			<div class="l">请输入答案：</div>
			<div class="c">
				<input type="text" name="answer" /><input type="hidden" name="type" value="2" /> 
			</div>
		</div>
		<div class="user_right_border">
			<div class="l">验证码：</div>
			<div class="c">
				<input name="valicode" type="text" size="11" maxlength="4"  tabindex="3"/>&nbsp;<img src="/plugins/?q=imgcode" alt="点击刷新" onClick="this.src='/plugins/?q=imgcode&t=' + Math.random();" align="absmiddle" style="cursor:pointer" />
			</div>
		</div>
		{else}
		<div class="user_help alert">您已经设置了密码保护功能，请先输入答案再进行修改。 </div>
		<div class="user_right_border">
			<div class="l">请选择问题：</div>
			<div class="c">
				{$_G.user_result.question|linkage:"pwd_protection"} 
			</div>
		</div>
		<div class="user_right_border">
			<div class="l">请输入答案：</div>
			<div class="c">
				<input type="text" name="answer" /> <input type="hidden" name="type" value="1" />
			</div>
		</div>
		
		{/if}
		<div class="user_right_border">
			<div class="l"></div>
			<div class="c">
				<input type="submit"  class="btn-action" name="name"  value="确认提交" size="30" /> 
			</div>
		</div>
		<div class="user_right_foot alert">
		* 温馨提示：我们将严格对用户的所有资料进行保密
		</div>
		
		</form>
		<!--密码保护 结束-->
		
		
		<!--好友邀请 开始-->
		{elseif $_U.query_type=="reginvite"}
		<div class="user_help alert" style="text-align:left;" > 
		{article module="dynacontent" function="GetOneBytype" var="dynac" areaid="$_G.areaid" type_id="2"}
        {$dynac.content}
		{/article} 
		</div>
		<div class="user_right_border">
			<div class="l">邀请链接：</div>
			<div class="c">
				<textarea cols="60" rows="5" id="invite">http://{$magic.server.SERVER_NAME}/?user&q=action/reginvite&u={$_U.user_inviteid}</textarea> <input type="button" onclick="doCopy('invite')" value="复制" />
			</div>
		</div>
		<table  border="0"  cellspacing="1" class="table table-striped  table-condensed" style="width:98%">
			  <form action="" method="post">
				<tr class="head" >
					<td  >下线用户名 </td>
                    <td  >真实姓名 </td>
					<td  >注册时间 </td>
                    <td  >是否VIP会员 </td>					
				</tr>
				{list  module="user" function="GetFriendsInvite" var="loop" user_id="0" showpage="3"}
				{foreach from="$loop.list" item="item"}
				<tr >
					<td>{$item.username}</td>
                    <td>{$item.realname}</td>
					<td>{$item.addtime|date_format}</td>
                    <td>{ if $item.vip_status == 1}是{else}否{/if}</td>
				</tr>
				{/foreach}
				<tr >
					<td colspan="6" class="page">
						<div class="list_table_page">{$loop.showpage}</div>
					</td>
				</tr>
				{/list}
			</form>	
		</table>
		{literal}
		<script>
		
		function doCopy(id) { 
		  var codeid;
		  codeid=id;
		 if (document.all){
		   var obj;
		   obj=document.getElementById(codeid);
		   window.clipboardData.setData("text",obj.innerText)
		   alert("邀请链接地址复制成功，你可以直接复制发给你的好友");
		 }
		 else{
		   alert("此功能只能在IE上有效\n\n请在文本域中用Ctrl+A选择再复制");
		 }
		}

		</script>
		{/literal}
		<!--好友请求 结束-->
		
		<!--好友请求 开始-->
		{elseif $_U.query_type=="request"}
		<table  border="0"  cellspacing="1" class="table table-striped  table-condensed" style="width:98%">
			  <form action="" method="post">
				<tr class="head" >
					<td  >对方名称</td>
					<td  >请求时间</td>
					<td  >请求说明</td>
					<td  >操作</td>
				</tr>
				{list  module="user" function="GetFriendsRlist" var="loop" user_id="0" }
				{foreach from="$loop.list" item="item"}
				<tr >
					<td><a href="/u/{$item.user_id}" target="_blank">{$item.username}</a></td>
					<td>{$item.addtime|date_format}</td>
					<td>{$item.content}</td>
					<td><a href="javascript:void(0)" onclick='tipsWindown("加为好友","url:get?/?user&q=code/user/raddfriend&username={$item.username}",400,230,"true","","true","text");'>加为好友</a>  <a href="{$_U.query_url}/delfriend&username={$item.username}">删除好友</a> </td>
				</tr>
				{/foreach}
				<tr >
					<td colspan="4" class="page">
						<div class="list_table_page">{$loop.showpage}</div>
					</td>
				</tr>
				{/list}
			</form>	
		</table>
		<!--好友请求 结束-->
		
		<!--我的好友 开始-->
		{elseif $_U.query_type=="myfriend"}
		
		<div class="user_main_title" style="height:30px; padding-top:7px;"> 
		
		&nbsp; &nbsp; &nbsp; 用户名：<input type="text" name="username" id="username" value="{$magic.request.username}" /> <input value="搜索" type="button" onclick="sousuo('{$_U.query_url}/publish')"  />
		</div>
		
		<table  border="0"  cellspacing="1" class="table table-striped  table-condensed" style="width:98%">
			  <form action="" method="post">
				<tr class="head" >
					<td  >对方名称</td>
					<td  >加入时间</td>
					<td  >好友说明</td>
					<td  >操作</td>
				</tr>
				{list  module="user" function="GetFriendsList" var="loop" user_id="0" status=1 showpage="3" username="request"}
				{foreach from="$loop.list" item="item"}
				<tr >
					<td><a href="/u/{$item.friends_userid}" target="_blank">{$item.friend_username}</a></td>
					<td>{$item.addtime|date_format}</td>
					<td>{$item.content|default:"-"}</td>
					<td><a href="{$_U.query_url}/delfriend&username={$item.friend_username}">删除好友</a>  <a href="{$_U.query_url}/blackfriend&username={$item.friend_username}">设为黑名单</a></td>
				</tr>
				{/foreach}
				<tr >
					<td colspan="4" class="page">
						<div class="list_table_page">{$loop.showpage}</div>
					</td>
				</tr>
				{/list}
			</form>	
		</table>
		<!--我的好友 结束-->
				<script>
				
	var url = "{$_U.query_url}/{$_U.query_type}";
		{literal}
		function sousuo(){
			var _url = "";
			var username = jQuery("#username").val();
			if (username!=null){
				 _url += "&username="+username;
			}
			location.href=url+_url;
		}
</script>
{/literal}
		
		<!--黑名单 开始-->
		{elseif $_U.query_type=="black"}
		<!--
		<div class="user_main_title" style="height:30px; padding-top:7px;"> 
		好友类型：<script src="plugins/?q=linkage&nid=friends_type&isid=false"></script>
		&nbsp; &nbsp; &nbsp; 用户名：<input type="text" name="" /> <input value="搜索" type="submit"  class="btn-action" class="btn-class" />
		</div>
		-->
		<table  border="0"  cellspacing="1" class="table table-striped  table-condensed" style="width:98%">
			  <form action="" method="post">
				<tr class="head" >
					<td  >对方名称</td>
					<td  >操作</td>
				</tr>
				{list  module="user" function="GetFriendsList" var="loop" user_id="0" status=2}
				{foreach from="$loop.list" item="item"}
				<tr >
					<td><a href="/u/{$item.friends_userid}" target="_blank">{$item.friend_username}</a></td>
					<td><a href="{$_U.query_url}/delfriend&username={$item.friend_username}">删除好友</a>  <a href="{$_U.query_url}/readdfriend&username={$item.friend_username}">重新加为好友</a></td>
				</tr>
				{/foreach}
				<tr >
					<td colspan="4" class="page">
						<div class="list_table_page">{$loop.showpage}</div>
					</td>
				</tr>
				{/list}
			</form>	
		</table>
		<!--黑名单 结束-->
		<!-- 提成开始-->
		{elseif $_U.query_type=="ticheng"}
		<table  border="0"  cellspacing="1" class="table table-striped  table-condensed" style="width:98%">
				<tr class="head" >
					<td  >下线用户名</td>
					<td  >真实姓名</td>
					<td  >提成类型</td>
					<td  >支付时间</td>
					<td  >提成收入</td>
				</tr>
				{list  module="account" function="GetTichenList" var="loop" invite_username="$_G.user_result.username" showpage="3" }
				{foreach from="$loop.list" item="item"}
				<tr >
                    <td>{$item.username}</td>
                    <td>{$item.realname}</td>
                    <td>{$item.remark}</td>
					<td>{$item.addtime|date_format}</td>
                    <td>￥{$item.money}</td>
				</tr>
				{/foreach}
				<tr >
					<td colspan="5" class="page">
						<div class="list_table_page">{$loop.showpage}</div>
					</td>
				</tr>
				{/list}
		</table>
		<!--提成 结束-->
		
		{elseif $_U.query_type=="realname"}
		<!--修改登录密码 开始-->
		{if $_G.user_result.real_status==1} 
		<div class="user_help alert">恭喜您已经通过了实名认证，如要修改请跟客服联系，谢谢！</div>
		<div class="user_right_border" style="background: #E8EEE5">
			<div class="l">用户名：</div>
			<div class="c">
				{$_G.user_result.username} 
			</div>
		</div>
		
		<div class="user_right_border" style="background: #E8EEE5">
			<div class="l">真实姓名：</div>
			<div class="c">
				{$_G.user_result.realname} 
			</div>
		</div>
		
		<div class="user_right_border" style="background: #E8EEE5">
			<div class="l">性 别 ：</div>
			<div class="c">
				{if $_G.user_result.sex==1}男{else}女{/if} 
			</div>
		</div>
		
		<div class="user_right_border" style="background: #E8EEE5">
			<div class="l">民 族：</div>
			<div class="c">
				{$_G.user_result.nation|linkage}
			</div>
		</div>
		
		<div class="user_right_border" style="background: #E8EEE5">
			<div class="l">出生日期：</div>
			<div class="c">
				{$_G.user_result.birthday|date_format:"Y-m-d"}
			</div>
		</div>
		
		<div class="user_right_border" style="background: #E8EEE5">
			<div class="l">证件类别：</div>
			<div class="c">
				{$_G.user_result.card_type|linkage:"card_type"}
			</div>
		</div>
		
		<div class="user_right_border" style="background: #E8EEE5">
			<div class="l">证件号码：</div>
			<div class="c">
				{$_G.user_result.card_id}
			</div>
		</div>
		
		<div class="user_right_border" style="background: #E8EEE5">
			<div class="l">籍贯：</div>
			<div class="c">
				{$_G.user_result.area|area}
			</div>
		</div>
		<div class="user_right_border" style="background: #E8EEE5">
			<div class="l">身份证图片：</div>
			<div class="c">
				<a href="{$_G.user_result.card_pic1|imgurl_format}" target="_blank">正面</a> | <a href="{$_G.user_result.card_pic2|imgurl_format}" target="_blank">反面</a>
			</div>
		</div>
		{else}
		
		<form action="" name="form1" method="post" onsubmit="return check_form()" enctype="multipart/form-data">
		<div class="user_help alert">注意：请认真填写以下的内容，一旦通过实名认证以下信息将不能修改。{$_G.user_result.content}</div>
		<div class="user_right_border">
			<div class="l">用户名：</div>
			<div class="c">
				{$_G.user_result.username} 
			</div>
		</div>
		
		<div class="user_right_border">
			<div class="l">真实姓名：</div>
			<div class="c">
				<input  name="realname" value="{$_G.user_result.realname}" /><font color="#FF0000">*</font> 
			</div>
		</div>
		
		<div class="user_right_border">
			<div class="l">性 别 ：</div>
			<div class="c">
				<input type="radio" name="sex" value="1" {if $_G.user_result.sex=="1" || $_G.user_result.sex==""}checked="checked" {/if} />男 <input type="radio" name="sex" value="2"  {if $_G.user_result.sex=="2"}checked="checked" {/if} />女 <font color="#FF0000">*</font> 
				
			</div>
		</div>
		
		<div class="user_right_border">
			<div class="l">民 族：</div>
			<div class="c">
				<script src="/plugins/?q=linkage&nid=nation&name=nation&value={$_G.user_result.nation}" ></script> <font color="#FF0000">*</font> 
			</div>
		</div>
		
		<div class="user_right_border">
			<div class="l">出生日期：</div>
			<div class="c">
				<input type="text" name="birthday" value="{$_G.user_result.birthday|date_format:"Y-m-d"}" onclick="change_picktime()" />  <font color="#FF0000">*</font> 
			</div>
		</div>
		
		<div class="user_right_border">
			<div class="l">证件类别：</div>
			<div class="c">
				<script src="/plugins/?q=linkage&nid=card_type&name=card_type&isid=false&value={$_G.user_result.card_type}" ></script> <font color="#FF0000">*</font> 
			</div>
		</div>
		
		<div class="user_right_border">
			<div class="l">证件号码：</div>
			<div class="c">
				<input type="text" name="card_id" value="{$_G.user_result.card_id}" />  <font color="#FF0000">*</font> 
			</div>
		</div>
		
		<div class="user_right_border">
			<div class="l">籍贯：</div>
			<div class="c">
                           <script src="/plugins/?q=area&area={$_G.user_result.area}" type="text/javascript" ></script> <font color="#FF0000">*</font> 
			</div>
		</div>
		
		<div class="user_right_border">
			<div class="l">身份证正面上传：</div>
			<div class="c">
				<input type="file" name="card_pic1" size="20" class="input_border"/> {if $_G.user_result.card_pic1!=""}<a href="./{ $_G.user_result.card_pic1}" target="_blank" title="有图片">有图片</a>{/if}  <font color="#FF0000">* 文件类型为.jpg或 .gif类型，大小为1MB以内</font> 
			
                        </div>
		</div>
		
		
	<div class="user_right_border">
			<div class="l">身份证背面上传：</div>
			<div class="c">
				<input type="file" name="card_pic2" size="20" class="input_border"/> {if $_G.user_result.card_pic2!=""}<a href="./{ $_G.user_result.card_pic2}" target="_blank" title="有图片">有图片</a>{/if}  <font color="#FF0000">* 文件类型为.jpg或 .gif类型，大小为1MB以内</font> 
			
                        </div>
		</div>
		
		
		<div class="user_right_border">
			<div class="e"></div>
			<div class="c">
				{if $_G.user_result.use_money>=0}<input type="submit"  class="btn-action" name="name"  value="确认提交" size="30" /> {else} 您的余额为{$_G.user_result.use_money},请先 <a href="/?user&q=code/account/recharge_new"><font color="#FF0000">充值</font></a>。{/if}
			</div>
		</div>
		</form>{/if}
		<div class="user_right_foot alert">
		* 温馨提示：我们将对用户的所有资料进行严格的保密
		</div>
		{literal}<script>
			function check_form(){

				 var frm = document.forms['form1'];
                 var card_pic1 = (frm.elements['card_pic1'].value);
                 var card_pic2 = (frm.elements['card_pic2'].value);
				 var realname = frm.elements['realname'].value;
				 var birthday = frm.elements['birthday'].value;
				 var card_id = frm.elements['card_id'].value;
				 var area = frm.elements['area'].value;
				 var errorMsg = '';


				  if (realname.length == 0 ) {
					errorMsg += '* 真实姓名不能为空' + '\n';
				  }
				  if (birthday.length == 0 ) {
					birthday += '* 生日不能为空' + '\n';
				  }
				  if (card_id.length == 0 ) {
					errorMsg += '* 证件号码不能为空' + '\n';
				  }
				  if (area.length == 0 ) {
					errorMsg += '* 请填写籍贯' + '\n';
				  }
                                 var pos1 = card_pic1.lastIndexOf(".");
                                 var lastname1 = card_pic1.substring(pos1,card_pic1.length);

                                 var pos2 = card_pic2.lastIndexOf(".");
                                 var lastname2 = card_pic2.substring(pos2,card_pic2.length);

                                 if (!(lastname1.toLowerCase()==".jpg" || lastname1.toLowerCase()==".gif" ))
                                 {
                                     errorMsg += "*您上传的文件类型必须为.jpg或 .gif类型" + '\n';
                                 }

                                 if (!(lastname2.toLowerCase()==".jpg" || lastname2.toLowerCase()==".gif" ))
                                 {
                                     errorMsg += "*您上传的文件类型必须为.jpg或 .gif类型" + '\n';
                                 }
				   
				  if (errorMsg.length > 0){
					alert(errorMsg); return false;
				  } else{  
					return true;
				}
			
			}
		</script>{/literal}
		<!--修改登录密码 结束-->
		
		{elseif $_U.query_type=="email_status"}
		<!--邮箱认证 开始-->
		{if $_G.user_result.email_status==1}
		<div class="user_help alert">您的邮箱已经通过认证：<b>{$_G.user_result.email}</b> </div>
		
		{else}
		<div class="user_help alert">您的邮箱还没通过认证：<b>{$_G.user_result.email}</b></div>
		<div class="user_right_border">
			<div class="c">
				<form action="" method="post" onsubmit="this.elements['submit'].disabled='disabled';return true;">
				重设邮箱：<input type="text" name="email" value="{$_G.user_result.email}" />  <input type="submit"  class="btn-action" name="submit" value="重新激活"  />
				</form>
			</div>
		</div>
		{/if}
		<!--邮箱认证 结束-->
		
		
		{elseif $_U.query_type=="phone_status"}
		<!--邮箱认证 开始-->
		{if $_G.user_result.phone_status==1}
		<div class="user_help alert">您的手机已经通过认证，认证的手机号码为：<b>{$_G.user_result.phone}</b></div>

		{elseif $_G.user_result.phone_status==2}
		<div class="user_help alert">您的手机没有通过认证，请重新提交正确的手机号码</b></div>
		{else}
		<div class="user_help alert">
		{if $_G.user_result.phone_status!=0}您的手机客服正在审核中，请耐心等待。手机号：<font color="#FF0000">{$_G.user_result.phone_status|$_G.user_result.phone}</font>。{else}您的手机还没通过认证。{/if}</b></div>
		{/if}
		<div class="user_right_border">
			<div class="c">
				<form action="" method="post">手机号码：<input type="text" name="phone" id="phone" value="{if $_G.user_result.phone_status==0 ||  $_G.user_result.phone_status==1}{$_G.user_result.phone}{/if}" /> <input type="submit"  class="btn-action" value="确认提交" class="subphone" /><br /><br /></form>

			</div>
		</div>
        {literal}<script>
		jQuery(function(){
		jQuery('.subphone').click(function(){
			var phone = jQuery('#phone').val();
			if(phone==''){
				alert('手机号码不能为空'); 
				return false;
			}else{
				 reg=/^1[3|4|5|8][0-9]{9}$/; 
				if(!reg.test(phone)){
					alert('手机号码格式不正确！');
					return false;
				}
			}
		});
	});
			
		</script>{/literal}
		<!--邮箱认证 结束-->
		
		
		{elseif $_U.query_type=="video_status"}
		<!--视频认证 开始-->

                {if $_G.user_result.vedio_status==1}
		<div class="user_help alert">您已经通过了视频认证</div>
		{else}
		<div class="user_help alert">
		{if $_G.user_result.video_status!=0}您的视频认证已经提交，客服人员会及时的跟你联系。</font>。{else}欢迎进行视频认证。<div class="user_right_border">
			<div class="c">
				<form action="" method="post">


                                    如果你需要视频认证，请点按钮提交。<input type="submit"  class="btn-action" value="提交申请" name="submit" /><br />

				<!--{if $_G.user_result.use_money >0}如果你需要视频认证，请点按钮提交。<input type="submit"  class="btn-action" class="btn-class" value="提交申请" name="submit" /><br />
                                <br />
                                {else}<a href="/?user&q=code/account/recharge_new">
                                    <font color="#FF0000">请先充值</font></a>{/if}
                                -->
                                </form>

			</div>
		</div>{/if}</div>
		{/if}
		<!--视频认证 结束-->
		
		{elseif $_U.query_type=="scene_status"}
		<!--视频认证 开始-->
		{if $_G.user_result.vip_status!=1}
		<div class="user_help alert" style="text-align:left">你还不是VIP会员不能做现场认证。</a>
		<div class="c">
			如要申请成为VIP会员，请点按钮提交到VIP申请页。<input type="button" class="btn-action" onclick="javacript:location.href='/vip/index.html'" value="申请VIP会员"  /><br /><br /></form>

			</div>
		</div>
		{elseif $_G.user_result.scene_status==1}
		<div class="user_help alert">您已经通过了现场认证</b></div>
		{else}
		<div class="user_help alert">如果您需要现场认证，请您到公司地址。
		</div>
		{/if}
		<!--视频认证 结束-->
		
		
		
		<!--信用积分 开始-->
		{elseif $_U.query_type=="credit"}
		<div class="user_help" > 
		<strong>信用总得分：</strong> <font size="3" color="#FF0000"><strong>{$_U.user_cache.credit}</strong></font>  {$_U.user_cache.credit|credit}
		</div>
		<table  border="0"  cellspacing="1" class="table table-striped  table-condensed" style="width:98%">
			  <form action="" method="post">
				<tr class="head" >
					<td  >积分类型</td>
					<td  >积分</td>
                                        <td  >添加时间</td>
					<td  >备注</td>
				</tr>
				{loop module="credit" function="GetLogList" user_id="0" limit="all"}
				<tr >
					<td>{$var.type_name}</td>
					<td>{$var.value} 分</td>
                                        <td>{$var.addtime|date_format:"Y-m-d"}</td>
					<td>{$var.remark}</td>
				</tr>
				{/loop}
				<tr >
					<td colspan="4" class="page">
						<div class="list_table_page">{$_U.show_page}</div>
					</td>
				</tr>
			</form>	
		</table>
		<!--信用积分 结束-->
		
		<!--信用积分 开始-->
		{elseif $_U.query_type=="myuser"}
		<div class="user_help" > 
		{list  module="user" function="GetList" var="loop" epage=20  kefu_userid="$_G.user_id" showpage=3 }
			
		<strong>总客户：</strong> {$loop.total} 个
		</div>
		<table  border="0"  cellspacing="1" class="table table-striped  table-condensed" style="width:98%">
			  <form action="" method="post">
				<tr class="head" >
					<td  >用户名</td>
					<td  >真实姓名</td>
					<td  >性别</td>
					<td  >电话</td>
					<td  >QQ</td>
					<td  >邮箱</td>
					<td  >所在地</td>
					<td  >操作</td>
				</tr>
					{foreach from="$loop.list" item="item"}
				<tr >
					<td><A href="/u/{$item.user_id}" target="_blank">{$item.username}</A></td>
					<td><a href="/?user&q=code/borrow/myuser&user_id={$item.user_id}">{$item.realname}</a> </td>
					<td>{if $item.sex==1}男{else}女{/if}</td>
					<td>{$item.phone}</td>
					<td>{$item.qq}</td>
					<td>{$item.email}</td>
					<td>{$item.area|area}</td>
					<td><a href="/?user&q=code/attestation/myuser&user_id={$item.user_id}">资料证明</a> | <a href="/?user&q=code/borrow/myuserrepay&user_id={$item.user_id}">还款明细</a></td>
				</tr>
				{/foreach}
				<tr >
					<td colspan="4" class="page">
						<div class="list_table_page">是{$loop.showpage}</div>
					</td>
				</tr>
			</form>	
		</table>
		{/list}
		<!--信用积分 结束-->
		
		{/if}
</div>
</div>
</div>
</div>
<!--用户中心的主栏目 结束-->
{include file="user_footer.html"}
{literal}
<script language="javascript">
function reurl(){

    var url = location.href; //把当前页面的地址赋给变量 url

    var times = url.split("$"); //分切变量 url 分隔符号为 "$"
    var myDate = new Date();
    var mytime=myDate.getMilliseconds();     //获取当前时间

    if(times[1] != 1){ //如果$后的值不等于1表示没有刷新
        url += "&nowtime="+mytime;
        url += "&$1"; //把变量 url 的值加入 $1
        window.location.href=url;
        //self.location.replace(url); //刷新页面
        //window.location.reload();
    }
    if(times[1] == 1){
        window.location.reload();
    }
}

//window.onload = function () { setTimeout("reurl();",500) }
//location.reload(true);
</script>
{/literal}
<script src="/themes/js/modal.js"></script>
<script src="/themes/js/tab.js"></script>
<script src="/themes/js/alert.js"></script>
<script src="/themes/js/transition.js"></script>
<script type="text/javascript" src="/themes/js/tipswindown.js"></script>
<link href="{$tempdir}/media/css/tipswindown.css" rel="stylesheet" type="text/css" />
