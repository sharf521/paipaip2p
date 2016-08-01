<?php
!defined('IN_TEMPLATE') && exit('Access Denied');
?>
{include file="user_header.html"}
<link href="{$tempdir}/media/css/modal.css" rel="stylesheet" type="text/css" />
<!--�û����ĵ�����Ŀ ��ʼ-->
<div id="main" class="clearfix" style="margin-top:0px;">
<div class="wrap950 ">
	<!--��ߵĵ��� ��ʼ-->
	<div class="user_left">
		{include file="user_menu.html"}
	</div>
	<!--��ߵĵ��� ����-->
	
	<!--�ұߵ����� ��ʼ-->
	<div class="user_right">
		<div class="user_right_menu">
			{if $_U.query_type=="userpwd" || $_U.query_type=="paypwd" || $_U.query_type=="protection" || $_U.query_type=="getpaypwd" || $_U.query_type=="serialStatusSet"}
			<ul id="tab" class="list-tab clearfix">
				
				<li {if $_U.query_type=="userpwd"} class="cur"{/if}><a href="{$_U.query_url}/userpwd">��¼����</a></li>
				<li {if $_U.query_type=="paypwd" || $_U.query_type=="getpaypwd"} class="cur"{/if}><a href="{$_U.query_url}/paypwd">��������</a></li>
				<li {if $_U.query_type=="protection"} class="cur"{/if}><a href="{$_U.query_url}/protection">���뱣��</a></li>
				<!--<li {if $_U.query_type=="serialStatusSet"} class="cur"{/if}><a href="{$_U.query_url}/serialStatusSet">��̬��������</a></li>-->
			</ul>
			{elseif $_U.query_type=="reginvite"  || $_U.query_type=="request" || $_U.query_type=="myfriend" || $_U.query_type=="black"|| $_U.query_type=="ticheng"}
			<ul id="tab" class="list-tab clearfix">
				<li {if $_U.query_type=="reginvite"} class="cur"{/if}><a href="{$_U.query_url}/reginvite">�������</a></li>
				<li {if $_U.query_type=="request"} class="cur"{/if}><a href="{$_U.query_url}/request">��������</a></li>
				<li {if $_U.query_type=="myfriend"} class="cur"{/if}><a href="{$_U.query_url}/myfriend">�ҵĺ���</a></li>
				<li {if $_U.query_type=="black"} class="cur"{/if}><a href="{$_U.query_url}/black">������</a></li>
				<li {if $_U.query_type=="ticheng"} class="cur"{/if}><a href="{$_U.query_url}/ticheng">�������</a></li>
			</ul>
			{elseif $_U.query_type=="credit" }
			<ul id="tab" class="list-tab clearfix">
			</ul>
			{elseif $_U.query_type=="myuser" }
			<ul id="tab" class="list-tab clearfix">
				<li {if $_U.query_type=="myuser"} class="cur"{/if}><a href="{$_U.query_url}/myuser">�ҵĿͻ�</a></li>
				<li ><a href="/?user&q=code/borrow/myuser">�ͻ����</a></li>
				<li ><a href="/?user&q=code/borrow/myuser_account">ͳ����Ϣ</a></li>
			</ul>
			{else}
			<ul id="tab" class="list-tab-narrow clearfix">
				<li {if $_U.query_type=="realname"} class="cur"{/if}><a href="{$_U.query_url}/realname">ʵ����֤</a></li>
				<li {if $_U.query_type=="email_status"} class="cur"{/if}><a href="{$_U.query_url}/email_status">������֤</a></li>
				<li {if $_U.query_type=="phone_status"} class="cur"{/if}><a href="{$_U.query_url}/phone_status">�ֻ���֤</a></li>
				<li {if $_U.query_type=="video_status"} class="cur"{/if}><a href="{$_U.query_url}/video_status">��Ƶ��֤</a></li>
				<li {if $_U.query_type=="scene_status"} class="cur"{/if}><a href="{$_U.query_url}/scene_status">�ֳ���֤</a></li>
				<li ><a href="/?user&q=code/attestation">�ϴ�����֤��</a></li>
				<li {if $_U.query_type=="avatar"} class="cur"{/if}><a href="{$_U.query_url}/avatar">ͷ����Ϣ</a></li>
				<!--<li {if $_U.query_type=="privacy"} class="cur"{/if}><a href="{$_U.query_url}/privacy">������˽</a></li>-->
			</ul>
			{/if}
		</div>
		
		<div class="user_right_main">
		
		{if $_U.query_type=="avatar"}
		<!--ͷ�� ��ʼ-->
		<div class="user_help alert">���ϴ�����վ��ͷ��</div>
		<div style="padding-left:350px;"><img src="{$_G.user_id|avatar|imgurl_format}"/></div>
		<div>{show_avatar}</div>
		<div class="user_right_foot alert">
		* ��ܰ��ʾ��ͷ�����������֣����У�С
		</div>
		<!--ͷ�� ����-->
		
		
		{elseif $_U.query_type=="privacy"}
		<div class="user_help">���ø��˵���˽</div>
		<form action="" method="post">
		<div class="user_right_border">
			<div class="e">�����б�</div>
			<div class="c">
				<script src="plugins/?q=linkage&nid=yinsi&name=friend&isid=false&value={$_U.user_privacy.friend}"></script>
			</div>
		</div>
		
		<div class="user_right_border">
			<div class="e">�������ۣ�</div>
			<div class="c">
				<script src="plugins/?q=linkage&nid=yinsi&name=friend_comment&isid=false&value={$_U.user_privacy.friend_comment}"></script>
			</div>
		</div>
		
		<div class="user_right_border">
			<div class="e">����б�</div>
			<div class="c">
				<script src="plugins/?q=linkage&nid=yinsi&name=borrow_list&isid=false&value={$_U.user_privacy.borrow_list}"></script>
			</div>
		</div>
		
		<div class="user_right_border">
			<div class="e">Ͷ���¼��</div>
			<div class="c">
				<script src="plugins/?q=linkage&nid=yinsi&name=loan_log&isid=false&value={$_U.user_privacy.loan_log}"></script>
			</div>
		</div>
			
		
		<div class="user_main_title">վ����/��Ϊ����</div>
		<div class="user_right_border">
			<div class="e">˭���Ը��ҷ�վ���ţ�</div>
			<div class="c">
				<script src="plugins/?q=linkage&nid=yinsi&name=sent_msg&isid=false&value={$_U.user_privacy.sent_msg}"></script>
			</div>
		</div>
		
		<div class="user_right_border">
			<div class="e">˭�������ҷ��������룺</div>
			<div class="c">
				<script src="plugins/?q=linkage&nid=yinsi&name=friend_request&isid=false&value={$_U.user_privacy.friend_request}"></script>
			</div>
		</div>
		
		
		<div class="user_main_title">������</div>
		<div class="user_right_border">
			<div class="e">˭���Կ��ҵĺ�������</div>
			<div class="c">
				<select name="look_black">
					<option value="0" {if $_U.user_privacy.look_black==0} selected="selected"{/if}>�������ҵĺ��Ѳ鿴�ҵĺ�����</option>
					<option value="1" {if $_U.user_privacy.look_black==1} selected="selected"{/if}>�����ҵĺ��Ѳ鿴�ҵĺ�����</option>
					<option value="2"{ if $_U.user_privacy.look_black==2} selected="selected"{/if}>��������ͬ��ĺ��Ѳ鿴�ҵĺ�����</option>
				</select>
			</div>
		</div>
		
		<div class="user_right_border">
			<div class="e">������������ҷ����ţ�</div>
			<div class="c">
				<input type="radio" name="allow_black_sent" value="1" { if $_U.user_privacy.allow_black_sent==1} checked="checked"{/if}/> ���� <input type="radio" name="allow_black_sent" value="0"   { if $_U.user_privacy.allow_black_sent==0 || $_U.user_privacy.allow_black_sent==""} checked="checked"{/if} /> ������ 
			</div>
		</div>
		<div class="user_right_border">
			<div class="e">������������ҷ��ͺ�������</div>
			<div class="c">
				<input type="radio" name="allow_black_request" value="1"  {if $_U.user_privacy.allow_black_request==1} checked="checked"{/if}/> ���� <input type="radio" name="allow_black_request" value="0" {if $_U.user_privacy.allow_black_request==0 || $_U.user_privacy.allow_black_request==""} checked="checked"{/if}/> ������ 
			</div>
		</div>
		
		<div class="user_right_border">
			<div class="e"></div>
			<div class="c">
				<input type="submit"  class="btn-action"  name="name"  value="ȷ���ύ" size="30" /> 
			</div>
		</div>
		</form>
		
		<div class="user_right_foot alert">
		* ��ܰ��ʾ���뱣�����Լ�����˽
		</div>
		<!--�˺ų�ֵ ����-->
		
		
		
		{elseif $_U.query_type=="userpwd"}
		<!--�޸ĵ�¼���� ��ʼ-->
		<form action="" name="form1" method="post" onsubmit="return check_form()">
		<div class="user_help alert alert">�����벻Ҫ̫�򵥣���ɸ���һ�㣬�����ĸ+����</div>
		<div class="user_right_border">
			<div class="e">ԭʼ���룺</div>
			<div class="c">
				<input type="password" name="oldpassword" /> 
			</div>
		</div>
		<div class="user_right_border">
			<div class="e">�����룺</div>
			<div class="c">
				<input type="password" name="newpassword" /> 
			</div>
		</div>
		<div class="user_right_border">
			<div class="e">ȷ�����룺</div>
			<div class="c">
				<input type="password" name="newpassword1" /> 
			</div>
		</div>
		<div class="user_right_border">
			<div class="e"></div>
			<div class="c">
				<input type="submit" class="btn-action" name="name"  value="ȷ���ύ" size="30" /> 
			</div>
		</div>
		</form>
		<div class="user_right_foot alert">
		* ��ܰ��ʾ�����ǽ��ϸ���û����������Ͻ��б���
		</div>
		{literal}<script>
			function check_form(){
				 var frm = document.forms['form1'];
				 var oldpassword = frm.elements['oldpassword'].value;
				 var newpassword = frm.elements['newpassword'].value;
				  var newpassword1 = frm.elements['newpassword1'].value;
				 var errorMsg = '';
				  if (oldpassword.length == 0 ) {
					errorMsg += '* ������ɵĵ�¼����' + '\n';
				  }
				  if (newpassword.length == 0 ) {
					errorMsg += '* �����벻��Ϊ��' + '\n';
				  }
				   if (newpassword.length >15 || newpassword.length<6 ) {
					errorMsg += '* �����볤����6��15֮��' + '\n';
				  }
				    if (newpassword.length !=newpassword1.length) {
					errorMsg += '* �������벻һ��' + '\n';
				  }
				  if (errorMsg.length > 0){
					alert(errorMsg); return false;
				  } else{  
					return true;
				}
			
			}
		</script>{/literal}
		<!--�޸ĵ�¼���� ����-->
		
<!--  LiuYY 2012-05-31 -->
		{elseif $_U.query_type =="serialStatusSet"}
		<!--�޸Ķ�̬����״̬ ��ʼ-->
		
		<form action="" name="form1" method="post" onsubmit="" >
		<div class="user_help alert">��̬�������ȷ���û��ĺϷ���ݣ��Ӷ��ںϷ���ݵ�¼�Ļ����ϱ���ҵ��ҵ����ʵİ�ȫ�ԡ�</div>
		����̬����Ӧ���ڣ�<br/>
		{ if  $_G.user_result.serial_id == "" }
		<font color="red" >�����˺Ż�δ�󶨶�̬����޷�ִ��������ã�</font>
		{/if}
		<div class="user_right_border">
			<div class="e">���֣�</div>
			<div class="c">
				<input type="checkbox" name="carryout"  value="1" id="carryout" { if  $_G.user_result.serial_id == "" } disabled="disabled" {/if} /> 
			</div>
			<div class="e">��¼��</div>
			<div class="c">
				<input type="checkbox"  name="login" value="1" id="login" {if  $_G.user_result.serial_id == "" } disabled="disabled" {/if} /> 
			</div>
			<input type="hidden" id="json_data" value='{$_G.user_result.serial_status}' />	
		</div>
		<input type="hidden" name="action" value="1" />
		<br/>
		<div class="">
			<div class="e"></div>
			�����붯̬������: <input type="text" maxlength="6" name="uchoncode" {if $_G.user_result.serial_id == "" } disabled="disabled" {/if} /> 
			<div class="c">
			<br/>
				<input type="submit"  class="btn-action" name="name"  value="ȷ���ύ" size="30" { if  $_G.user_result.serial_id == "" } disabled="disabled" {/if} /> 
			</div>
		</div>
	
	
		</form>
		<div class="user_right_foot alert">
		* ��ܰ��ʾ�����ǽ��ϸ���û����������Ͻ��б���
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
		<!--�޸Ķ�̬����״̬ ����-->		
		{elseif $_U.query_type=="paypwd"}
		<!--�޸İ�ȫ���� ��ʼ-->
		<form action="" name="form1" method="post" onsubmit="return check_form()">
		<div class="user_help alert alert">����������ø���,�����汣�ܺ��Լ�������!����ĸ+�����ȼѣ�</div>
		<div class="user_right_border">
			<div class="l">ԭʼ�������룺</div>
			<div class="c">
				<input type="password" name="oldpassword" /> ������ԭ�������롣(��ʼ������������ע��ʱ�ĵ�¼����һ��)
			</div>
		</div>
		<div class="user_right_border">
			<div class="l">�½������룺</div>
			<div class="c">
				<input type="password" name="newpassword" /> 
			</div>
		</div>
		<div class="user_right_border">
			<div class="l">ȷ�Ͻ������룺</div>
			<div class="c">
				<input type="password" name="newpassword1" /> 
			</div>
		</div>
		<div class="user_right_border">
			<div class="l">��֤�룺</div>
			<div class="c">
				<input name="valicode" type="text" size="11" maxlength="4"  tabindex="3"/>&nbsp;<img src="/plugins/?q=imgcode" alt="���ˢ��" onClick="this.src='/plugins/?q=imgcode&t=' + Math.random();" align="absmiddle" style="cursor:pointer" />
			</div>
		</div>
		<div class="user_right_border">
			<div class="l"></div>
			<div class="c">
				<input type="submit"  class="btn-action" name="name"  value="ȷ���ύ" size="30" /> <a href="/?user&q=code/user/getpaypwd">���ǽ������룿</a>
			</div>
		</div>
		</form>
		<div class="user_right_foot alert">
		* ��ܰ��ʾ�����ǽ��ϸ���û����������Ͻ��б���
		</div>
		<!--�޸İ�ȫ���� ����-->
		{literal}<script>
			function check_form(){
				 var frm = document.forms['form1'];
				 var oldpassword = frm.elements['oldpassword'].value;
				 var newpassword = frm.elements['newpassword'].value;
				  var newpassword1 = frm.elements['newpassword1'].value;
				 var errorMsg = '';
				  if (oldpassword.length == 0 ) {
					errorMsg += '* ����������룬���û���趨�������룬�������¼����' + '\n';
				  }
				  if (newpassword.length == 0 ) {
					errorMsg += '* �����벻��Ϊ��' + '\n';
				  }
				   if (newpassword.length >15 || newpassword.length<6 ) {
					errorMsg += '* �����볤����6��15֮��' + '\n';
				  }
				    if (newpassword.length !=newpassword1.length) {
					errorMsg += '* �������벻һ��' + '\n';
				  }
				  if (errorMsg.length > 0){
					alert(errorMsg); return false;
				  } else{  
					return true;
				}
			
			}
		</script>{/literal}
		
		
		{elseif $_U.query_type=="getpaypwd"}
		<!--�޸İ�ȫ���� ��ʼ-->
		{if $magic.request.id!=""}
		<form action="" name="form1" method="post" onsubmit="return check_form()" >
		<div class="user_help">��������������֧������</div>
		<div class="user_right_border">
			<div class="l">���������룺</div>
			<div class="c">
				<input type="password" name="paypwd" />
			</div>
		</div>
		<div class="user_right_border">
			<div class="l">����һ���������룺</div>
			<div class="c">
				<input type="password" name="paypwd1" />
			</div>
		</div>
		<div class="user_right_border">
			<div class="l">��֤�룺</div>
			<div class="c">
				<input name="valicode" type="text" size="11" maxlength="4"  tabindex="3"/>&nbsp;<img src="/plugins/?q=imgcode" alt="���ˢ��" onClick="this.src='/plugins/?q=imgcode&t=' + Math.random();" align="absmiddle" style="cursor:pointer" />
			</div>
		</div>
		<div class="user_right_border">
			<div class="l"></div>
			<div class="c">
				<input type="submit"  class="btn-action" name="name"  value="ȷ���ύ" size="30" /> 
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
					errorMsg += '* �����벻��Ϊ��' + '\n';
				  }
				   if (newpassword.length >15 || newpassword.length<6 ) {
					errorMsg += '* �����볤����6��15֮��' + '\n';
				  }
				    if (newpassword.length !=newpassword1.length) {
					errorMsg += '* �������벻һ��' + '\n';
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
		<div class="user_help">���¼�����һ�</div>
		<div class="user_right_border">
			<div class="l">�������䣺</div>
			<div class="c">
				{$_G.user_result.email}
			</div>
		</div>
		<div class="user_right_border">
			<div class="l">��֤�룺</div>
			<div class="c">
				<input name="valicode" type="text" size="11" maxlength="4"  tabindex="3"/>&nbsp;<img src="/plugins/?q=imgcode" alt="���ˢ��" onClick="this.src='/plugins/?q=imgcode&t=' + Math.random();" align="absmiddle" style="cursor:pointer" />
			</div>
		</div>
		<div class="user_right_border">
			<div class="l"></div>
			<div class="c">
				<input type="submit"  class="btn-action" name="name"  value="ȷ���ύ" size="30" /> 
			</div>
		</div>
		</form>
		{/if}
		<div class="user_right_foot alert">
		* ��ܰ��ʾ�����ǽ��ϸ���û����������Ͻ��б���
		</div>
		<!--�޸İ�ȫ���� ����-->
		{elseif $_U.query_type=="protection"}
		<!--���뱣�� ��ʼ-->
		 <form action="" method="post">
		{if $_U.answer_type=="2" || $_G.user_result.answer == "" }
		<div class="user_help alert">��ѡ��һ���µ��˺ű�������,������𰸡��˺ű�������Ϊ���Ժ����������롢��Ҫ���õȲ�����ʱ��,�ṩ��ȫ���ϡ� </div>
		<div class="user_right_border">
			<div class="l">��ѡ�����⣺</div>
			<div class="c">
				<script src="/plugins/?q=linkage&name=question&nid=pwd_protection&isid=false"></script> 
			</div>
		</div>
		<div class="user_right_border">
			<div class="l">������𰸣�</div>
			<div class="c">
				<input type="text" name="answer" /><input type="hidden" name="type" value="2" /> 
			</div>
		</div>
		<div class="user_right_border">
			<div class="l">��֤�룺</div>
			<div class="c">
				<input name="valicode" type="text" size="11" maxlength="4"  tabindex="3"/>&nbsp;<img src="/plugins/?q=imgcode" alt="���ˢ��" onClick="this.src='/plugins/?q=imgcode&t=' + Math.random();" align="absmiddle" style="cursor:pointer" />
			</div>
		</div>
		{else}
		<div class="user_help alert">���Ѿ����������뱣�����ܣ�����������ٽ����޸ġ� </div>
		<div class="user_right_border">
			<div class="l">��ѡ�����⣺</div>
			<div class="c">
				{$_G.user_result.question|linkage:"pwd_protection"} 
			</div>
		</div>
		<div class="user_right_border">
			<div class="l">������𰸣�</div>
			<div class="c">
				<input type="text" name="answer" /> <input type="hidden" name="type" value="1" />
			</div>
		</div>
		
		{/if}
		<div class="user_right_border">
			<div class="l"></div>
			<div class="c">
				<input type="submit"  class="btn-action" name="name"  value="ȷ���ύ" size="30" /> 
			</div>
		</div>
		<div class="user_right_foot alert">
		* ��ܰ��ʾ�����ǽ��ϸ���û����������Ͻ��б���
		</div>
		
		</form>
		<!--���뱣�� ����-->
		
		
		<!--�������� ��ʼ-->
		{elseif $_U.query_type=="reginvite"}
		<div class="user_help alert" style="text-align:left;" > 
		{article module="dynacontent" function="GetOneBytype" var="dynac" areaid="$_G.areaid" type_id="2"}
        {$dynac.content}
		{/article} 
		</div>
		<div class="user_right_border">
			<div class="l">�������ӣ�</div>
			<div class="c">
				<textarea cols="60" rows="5" id="invite">http://{$magic.server.SERVER_NAME}/?user&q=action/reginvite&u={$_U.user_inviteid}</textarea> <input type="button" onclick="doCopy('invite')" value="����" />
			</div>
		</div>
		<table  border="0"  cellspacing="1" class="table table-striped  table-condensed" style="width:98%">
			  <form action="" method="post">
				<tr class="head" >
					<td  >�����û��� </td>
                    <td  >��ʵ���� </td>
					<td  >ע��ʱ�� </td>
                    <td  >�Ƿ�VIP��Ա </td>					
				</tr>
				{list  module="user" function="GetFriendsInvite" var="loop" user_id="0" showpage="3"}
				{foreach from="$loop.list" item="item"}
				<tr >
					<td>{$item.username}</td>
                    <td>{$item.realname}</td>
					<td>{$item.addtime|date_format}</td>
                    <td>{ if $item.vip_status == 1}��{else}��{/if}</td>
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
		   alert("�������ӵ�ַ���Ƴɹ��������ֱ�Ӹ��Ʒ�����ĺ���");
		 }
		 else{
		   alert("�˹���ֻ����IE����Ч\n\n�����ı�������Ctrl+Aѡ���ٸ���");
		 }
		}

		</script>
		{/literal}
		<!--�������� ����-->
		
		<!--�������� ��ʼ-->
		{elseif $_U.query_type=="request"}
		<table  border="0"  cellspacing="1" class="table table-striped  table-condensed" style="width:98%">
			  <form action="" method="post">
				<tr class="head" >
					<td  >�Է�����</td>
					<td  >����ʱ��</td>
					<td  >����˵��</td>
					<td  >����</td>
				</tr>
				{list  module="user" function="GetFriendsRlist" var="loop" user_id="0" }
				{foreach from="$loop.list" item="item"}
				<tr >
					<td><a href="/u/{$item.user_id}" target="_blank">{$item.username}</a></td>
					<td>{$item.addtime|date_format}</td>
					<td>{$item.content}</td>
					<td><a href="javascript:void(0)" onclick='tipsWindown("��Ϊ����","url:get?/?user&q=code/user/raddfriend&username={$item.username}",400,230,"true","","true","text");'>��Ϊ����</a>  <a href="{$_U.query_url}/delfriend&username={$item.username}">ɾ������</a> </td>
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
		<!--�������� ����-->
		
		<!--�ҵĺ��� ��ʼ-->
		{elseif $_U.query_type=="myfriend"}
		
		<div class="user_main_title" style="height:30px; padding-top:7px;"> 
		
		&nbsp; &nbsp; &nbsp; �û�����<input type="text" name="username" id="username" value="{$magic.request.username}" /> <input value="����" type="button" onclick="sousuo('{$_U.query_url}/publish')"  />
		</div>
		
		<table  border="0"  cellspacing="1" class="table table-striped  table-condensed" style="width:98%">
			  <form action="" method="post">
				<tr class="head" >
					<td  >�Է�����</td>
					<td  >����ʱ��</td>
					<td  >����˵��</td>
					<td  >����</td>
				</tr>
				{list  module="user" function="GetFriendsList" var="loop" user_id="0" status=1 showpage="3" username="request"}
				{foreach from="$loop.list" item="item"}
				<tr >
					<td><a href="/u/{$item.friends_userid}" target="_blank">{$item.friend_username}</a></td>
					<td>{$item.addtime|date_format}</td>
					<td>{$item.content|default:"-"}</td>
					<td><a href="{$_U.query_url}/delfriend&username={$item.friend_username}">ɾ������</a>  <a href="{$_U.query_url}/blackfriend&username={$item.friend_username}">��Ϊ������</a></td>
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
		<!--�ҵĺ��� ����-->
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
		
		<!--������ ��ʼ-->
		{elseif $_U.query_type=="black"}
		<!--
		<div class="user_main_title" style="height:30px; padding-top:7px;"> 
		�������ͣ�<script src="plugins/?q=linkage&nid=friends_type&isid=false"></script>
		&nbsp; &nbsp; &nbsp; �û�����<input type="text" name="" /> <input value="����" type="submit"  class="btn-action" class="btn-class" />
		</div>
		-->
		<table  border="0"  cellspacing="1" class="table table-striped  table-condensed" style="width:98%">
			  <form action="" method="post">
				<tr class="head" >
					<td  >�Է�����</td>
					<td  >����</td>
				</tr>
				{list  module="user" function="GetFriendsList" var="loop" user_id="0" status=2}
				{foreach from="$loop.list" item="item"}
				<tr >
					<td><a href="/u/{$item.friends_userid}" target="_blank">{$item.friend_username}</a></td>
					<td><a href="{$_U.query_url}/delfriend&username={$item.friend_username}">ɾ������</a>  <a href="{$_U.query_url}/readdfriend&username={$item.friend_username}">���¼�Ϊ����</a></td>
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
		<!--������ ����-->
		<!-- ��ɿ�ʼ-->
		{elseif $_U.query_type=="ticheng"}
		<table  border="0"  cellspacing="1" class="table table-striped  table-condensed" style="width:98%">
				<tr class="head" >
					<td  >�����û���</td>
					<td  >��ʵ����</td>
					<td  >�������</td>
					<td  >֧��ʱ��</td>
					<td  >�������</td>
				</tr>
				{list  module="account" function="GetTichenList" var="loop" invite_username="$_G.user_result.username" showpage="3" }
				{foreach from="$loop.list" item="item"}
				<tr >
                    <td>{$item.username}</td>
                    <td>{$item.realname}</td>
                    <td>{$item.remark}</td>
					<td>{$item.addtime|date_format}</td>
                    <td>��{$item.money}</td>
				</tr>
				{/foreach}
				<tr >
					<td colspan="5" class="page">
						<div class="list_table_page">{$loop.showpage}</div>
					</td>
				</tr>
				{/list}
		</table>
		<!--��� ����-->
		
		{elseif $_U.query_type=="realname"}
		<!--�޸ĵ�¼���� ��ʼ-->
		{if $_G.user_result.real_status==1} 
		<div class="user_help alert">��ϲ���Ѿ�ͨ����ʵ����֤����Ҫ�޸�����ͷ���ϵ��лл��</div>
		<div class="user_right_border" style="background: #E8EEE5">
			<div class="l">�û�����</div>
			<div class="c">
				{$_G.user_result.username} 
			</div>
		</div>
		
		<div class="user_right_border" style="background: #E8EEE5">
			<div class="l">��ʵ������</div>
			<div class="c">
				{$_G.user_result.realname} 
			</div>
		</div>
		
		<div class="user_right_border" style="background: #E8EEE5">
			<div class="l">�� �� ��</div>
			<div class="c">
				{if $_G.user_result.sex==1}��{else}Ů{/if} 
			</div>
		</div>
		
		<div class="user_right_border" style="background: #E8EEE5">
			<div class="l">�� �壺</div>
			<div class="c">
				{$_G.user_result.nation|linkage}
			</div>
		</div>
		
		<div class="user_right_border" style="background: #E8EEE5">
			<div class="l">�������ڣ�</div>
			<div class="c">
				{$_G.user_result.birthday|date_format:"Y-m-d"}
			</div>
		</div>
		
		<div class="user_right_border" style="background: #E8EEE5">
			<div class="l">֤�����</div>
			<div class="c">
				{$_G.user_result.card_type|linkage:"card_type"}
			</div>
		</div>
		
		<div class="user_right_border" style="background: #E8EEE5">
			<div class="l">֤�����룺</div>
			<div class="c">
				{$_G.user_result.card_id}
			</div>
		</div>
		
		<div class="user_right_border" style="background: #E8EEE5">
			<div class="l">���᣺</div>
			<div class="c">
				{$_G.user_result.area|area}
			</div>
		</div>
		<div class="user_right_border" style="background: #E8EEE5">
			<div class="l">���֤ͼƬ��</div>
			<div class="c">
				<a href="{$_G.user_result.card_pic1|imgurl_format}" target="_blank">����</a> | <a href="{$_G.user_result.card_pic2|imgurl_format}" target="_blank">����</a>
			</div>
		</div>
		{else}
		
		<form action="" name="form1" method="post" onsubmit="return check_form()" enctype="multipart/form-data">
		<div class="user_help alert">ע�⣺��������д���µ����ݣ�һ��ͨ��ʵ����֤������Ϣ�������޸ġ�{$_G.user_result.content}</div>
		<div class="user_right_border">
			<div class="l">�û�����</div>
			<div class="c">
				{$_G.user_result.username} 
			</div>
		</div>
		
		<div class="user_right_border">
			<div class="l">��ʵ������</div>
			<div class="c">
				<input  name="realname" value="{$_G.user_result.realname}" /><font color="#FF0000">*</font> 
			</div>
		</div>
		
		<div class="user_right_border">
			<div class="l">�� �� ��</div>
			<div class="c">
				<input type="radio" name="sex" value="1" {if $_G.user_result.sex=="1" || $_G.user_result.sex==""}checked="checked" {/if} />�� <input type="radio" name="sex" value="2"  {if $_G.user_result.sex=="2"}checked="checked" {/if} />Ů <font color="#FF0000">*</font> 
				
			</div>
		</div>
		
		<div class="user_right_border">
			<div class="l">�� �壺</div>
			<div class="c">
				<script src="/plugins/?q=linkage&nid=nation&name=nation&value={$_G.user_result.nation}" ></script> <font color="#FF0000">*</font> 
			</div>
		</div>
		
		<div class="user_right_border">
			<div class="l">�������ڣ�</div>
			<div class="c">
				<input type="text" name="birthday" value="{$_G.user_result.birthday|date_format:"Y-m-d"}" onclick="change_picktime()" />  <font color="#FF0000">*</font> 
			</div>
		</div>
		
		<div class="user_right_border">
			<div class="l">֤�����</div>
			<div class="c">
				<script src="/plugins/?q=linkage&nid=card_type&name=card_type&isid=false&value={$_G.user_result.card_type}" ></script> <font color="#FF0000">*</font> 
			</div>
		</div>
		
		<div class="user_right_border">
			<div class="l">֤�����룺</div>
			<div class="c">
				<input type="text" name="card_id" value="{$_G.user_result.card_id}" />  <font color="#FF0000">*</font> 
			</div>
		</div>
		
		<div class="user_right_border">
			<div class="l">���᣺</div>
			<div class="c">
                           <script src="/plugins/?q=area&area={$_G.user_result.area}" type="text/javascript" ></script> <font color="#FF0000">*</font> 
			</div>
		</div>
		
		<div class="user_right_border">
			<div class="l">���֤�����ϴ���</div>
			<div class="c">
				<input type="file" name="card_pic1" size="20" class="input_border"/> {if $_G.user_result.card_pic1!=""}<a href="./{ $_G.user_result.card_pic1}" target="_blank" title="��ͼƬ">��ͼƬ</a>{/if}  <font color="#FF0000">* �ļ�����Ϊ.jpg�� .gif���ͣ���СΪ1MB����</font> 
			
                        </div>
		</div>
		
		
	<div class="user_right_border">
			<div class="l">���֤�����ϴ���</div>
			<div class="c">
				<input type="file" name="card_pic2" size="20" class="input_border"/> {if $_G.user_result.card_pic2!=""}<a href="./{ $_G.user_result.card_pic2}" target="_blank" title="��ͼƬ">��ͼƬ</a>{/if}  <font color="#FF0000">* �ļ�����Ϊ.jpg�� .gif���ͣ���СΪ1MB����</font> 
			
                        </div>
		</div>
		
		
		<div class="user_right_border">
			<div class="e"></div>
			<div class="c">
				{if $_G.user_result.use_money>=0}<input type="submit"  class="btn-action" name="name"  value="ȷ���ύ" size="30" /> {else} �������Ϊ{$_G.user_result.use_money},���� <a href="/?user&q=code/account/recharge_new"><font color="#FF0000">��ֵ</font></a>��{/if}
			</div>
		</div>
		</form>{/if}
		<div class="user_right_foot alert">
		* ��ܰ��ʾ�����ǽ����û����������Ͻ����ϸ�ı���
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
					errorMsg += '* ��ʵ��������Ϊ��' + '\n';
				  }
				  if (birthday.length == 0 ) {
					birthday += '* ���ղ���Ϊ��' + '\n';
				  }
				  if (card_id.length == 0 ) {
					errorMsg += '* ֤�����벻��Ϊ��' + '\n';
				  }
				  if (area.length == 0 ) {
					errorMsg += '* ����д����' + '\n';
				  }
                                 var pos1 = card_pic1.lastIndexOf(".");
                                 var lastname1 = card_pic1.substring(pos1,card_pic1.length);

                                 var pos2 = card_pic2.lastIndexOf(".");
                                 var lastname2 = card_pic2.substring(pos2,card_pic2.length);

                                 if (!(lastname1.toLowerCase()==".jpg" || lastname1.toLowerCase()==".gif" ))
                                 {
                                     errorMsg += "*���ϴ����ļ����ͱ���Ϊ.jpg�� .gif����" + '\n';
                                 }

                                 if (!(lastname2.toLowerCase()==".jpg" || lastname2.toLowerCase()==".gif" ))
                                 {
                                     errorMsg += "*���ϴ����ļ����ͱ���Ϊ.jpg�� .gif����" + '\n';
                                 }
				   
				  if (errorMsg.length > 0){
					alert(errorMsg); return false;
				  } else{  
					return true;
				}
			
			}
		</script>{/literal}
		<!--�޸ĵ�¼���� ����-->
		
		{elseif $_U.query_type=="email_status"}
		<!--������֤ ��ʼ-->
		{if $_G.user_result.email_status==1}
		<div class="user_help alert">���������Ѿ�ͨ����֤��<b>{$_G.user_result.email}</b> </div>
		
		{else}
		<div class="user_help alert">�������仹ûͨ����֤��<b>{$_G.user_result.email}</b></div>
		<div class="user_right_border">
			<div class="c">
				<form action="" method="post" onsubmit="this.elements['submit'].disabled='disabled';return true;">
				�������䣺<input type="text" name="email" value="{$_G.user_result.email}" />  <input type="submit"  class="btn-action" name="submit" value="���¼���"  />
				</form>
			</div>
		</div>
		{/if}
		<!--������֤ ����-->
		
		
		{elseif $_U.query_type=="phone_status"}
		<!--������֤ ��ʼ-->
		{if $_G.user_result.phone_status==1}
		<div class="user_help alert">�����ֻ��Ѿ�ͨ����֤����֤���ֻ�����Ϊ��<b>{$_G.user_result.phone}</b></div>

		{elseif $_G.user_result.phone_status==2}
		<div class="user_help alert">�����ֻ�û��ͨ����֤���������ύ��ȷ���ֻ�����</b></div>
		{else}
		<div class="user_help alert">
		{if $_G.user_result.phone_status!=0}�����ֻ��ͷ���������У������ĵȴ����ֻ��ţ�<font color="#FF0000">{$_G.user_result.phone_status|$_G.user_result.phone}</font>��{else}�����ֻ���ûͨ����֤��{/if}</b></div>
		{/if}
		<div class="user_right_border">
			<div class="c">
				<form action="" method="post">�ֻ����룺<input type="text" name="phone" id="phone" value="{if $_G.user_result.phone_status==0 ||  $_G.user_result.phone_status==1}{$_G.user_result.phone}{/if}" /> <input type="submit"  class="btn-action" value="ȷ���ύ" class="subphone" /><br /><br /></form>

			</div>
		</div>
        {literal}<script>
		jQuery(function(){
		jQuery('.subphone').click(function(){
			var phone = jQuery('#phone').val();
			if(phone==''){
				alert('�ֻ����벻��Ϊ��'); 
				return false;
			}else{
				 reg=/^1[3|4|5|8][0-9]{9}$/; 
				if(!reg.test(phone)){
					alert('�ֻ������ʽ����ȷ��');
					return false;
				}
			}
		});
	});
			
		</script>{/literal}
		<!--������֤ ����-->
		
		
		{elseif $_U.query_type=="video_status"}
		<!--��Ƶ��֤ ��ʼ-->

                {if $_G.user_result.vedio_status==1}
		<div class="user_help alert">���Ѿ�ͨ������Ƶ��֤</div>
		{else}
		<div class="user_help alert">
		{if $_G.user_result.video_status!=0}������Ƶ��֤�Ѿ��ύ���ͷ���Ա�ἰʱ�ĸ�����ϵ��</font>��{else}��ӭ������Ƶ��֤��<div class="user_right_border">
			<div class="c">
				<form action="" method="post">


                                    �������Ҫ��Ƶ��֤����㰴ť�ύ��<input type="submit"  class="btn-action" value="�ύ����" name="submit" /><br />

				<!--{if $_G.user_result.use_money >0}�������Ҫ��Ƶ��֤����㰴ť�ύ��<input type="submit"  class="btn-action" class="btn-class" value="�ύ����" name="submit" /><br />
                                <br />
                                {else}<a href="/?user&q=code/account/recharge_new">
                                    <font color="#FF0000">���ȳ�ֵ</font></a>{/if}
                                -->
                                </form>

			</div>
		</div>{/if}</div>
		{/if}
		<!--��Ƶ��֤ ����-->
		
		{elseif $_U.query_type=="scene_status"}
		<!--��Ƶ��֤ ��ʼ-->
		{if $_G.user_result.vip_status!=1}
		<div class="user_help alert" style="text-align:left">�㻹����VIP��Ա�������ֳ���֤��</a>
		<div class="c">
			��Ҫ�����ΪVIP��Ա����㰴ť�ύ��VIP����ҳ��<input type="button" class="btn-action" onclick="javacript:location.href='/vip/index.html'" value="����VIP��Ա"  /><br /><br /></form>

			</div>
		</div>
		{elseif $_G.user_result.scene_status==1}
		<div class="user_help alert">���Ѿ�ͨ�����ֳ���֤</b></div>
		{else}
		<div class="user_help alert">�������Ҫ�ֳ���֤����������˾��ַ��
		</div>
		{/if}
		<!--��Ƶ��֤ ����-->
		
		
		
		<!--���û��� ��ʼ-->
		{elseif $_U.query_type=="credit"}
		<div class="user_help" > 
		<strong>�����ܵ÷֣�</strong> <font size="3" color="#FF0000"><strong>{$_U.user_cache.credit}</strong></font>  {$_U.user_cache.credit|credit}
		</div>
		<table  border="0"  cellspacing="1" class="table table-striped  table-condensed" style="width:98%">
			  <form action="" method="post">
				<tr class="head" >
					<td  >��������</td>
					<td  >����</td>
                                        <td  >���ʱ��</td>
					<td  >��ע</td>
				</tr>
				{loop module="credit" function="GetLogList" user_id="0" limit="all"}
				<tr >
					<td>{$var.type_name}</td>
					<td>{$var.value} ��</td>
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
		<!--���û��� ����-->
		
		<!--���û��� ��ʼ-->
		{elseif $_U.query_type=="myuser"}
		<div class="user_help" > 
		{list  module="user" function="GetList" var="loop" epage=20  kefu_userid="$_G.user_id" showpage=3 }
			
		<strong>�ܿͻ���</strong> {$loop.total} ��
		</div>
		<table  border="0"  cellspacing="1" class="table table-striped  table-condensed" style="width:98%">
			  <form action="" method="post">
				<tr class="head" >
					<td  >�û���</td>
					<td  >��ʵ����</td>
					<td  >�Ա�</td>
					<td  >�绰</td>
					<td  >QQ</td>
					<td  >����</td>
					<td  >���ڵ�</td>
					<td  >����</td>
				</tr>
					{foreach from="$loop.list" item="item"}
				<tr >
					<td><A href="/u/{$item.user_id}" target="_blank">{$item.username}</A></td>
					<td><a href="/?user&q=code/borrow/myuser&user_id={$item.user_id}">{$item.realname}</a> </td>
					<td>{if $item.sex==1}��{else}Ů{/if}</td>
					<td>{$item.phone}</td>
					<td>{$item.qq}</td>
					<td>{$item.email}</td>
					<td>{$item.area|area}</td>
					<td><a href="/?user&q=code/attestation/myuser&user_id={$item.user_id}">����֤��</a> | <a href="/?user&q=code/borrow/myuserrepay&user_id={$item.user_id}">������ϸ</a></td>
				</tr>
				{/foreach}
				<tr >
					<td colspan="4" class="page">
						<div class="list_table_page">��{$loop.showpage}</div>
					</td>
				</tr>
			</form>	
		</table>
		{/list}
		<!--���û��� ����-->
		
		{/if}
</div>
</div>
</div>
</div>
<!--�û����ĵ�����Ŀ ����-->
{include file="user_footer.html"}
{literal}
<script language="javascript">
function reurl(){

    var url = location.href; //�ѵ�ǰҳ��ĵ�ַ�������� url

    var times = url.split("$"); //���б��� url �ָ�����Ϊ "$"
    var myDate = new Date();
    var mytime=myDate.getMilliseconds();     //��ȡ��ǰʱ��

    if(times[1] != 1){ //���$���ֵ������1��ʾû��ˢ��
        url += "&nowtime="+mytime;
        url += "&$1"; //�ѱ��� url ��ֵ���� $1
        window.location.href=url;
        //self.location.replace(url); //ˢ��ҳ��
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
