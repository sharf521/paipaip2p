<?php
!defined('IN_TEMPLATE') && exit('Access Denied');
?>
{include file="user_header.html"}
<link href="{$tempdir}/media/css/modal.css" rel="stylesheet" type="text/css" />
<!--�û����ĵ�����Ŀ ��ʼ-->
<div id="main" class="clearfix">
<div class="wrap950 mar10">
	<!--��ߵĵ��� ��ʼ-->
	<div class="user_left">
		{include file="user_menu.html"}
	</div>
	<!--��ߵĵ��� ����-->
	
	<!--�ұߵ����� ��ʼ-->
	<div class="user_right">
		<div class="user_right_menu">
			{if $_U.query_type=="myuser"}
			<ul>
				<li ><a href="index.php?user&q=code/user/myuser">�ҵĿͻ�</a></li>
				<li ><a href="index.php?user&q=code/borrow/myuser">�ͻ����</a></li>
			</ul>
			{else}
			<ul id="tab" class="list-tab clearfix">
				<li {if $_U.query_type=="list"} class="cur"{/if}><a href="{$_U.query_url}">֤������</a></li>
				<li {if $_U.query_type=="one"} class="cur"{/if}><a href="{$_U.query_url}/one">�����ϴ�</a></li>
				<!--
				<li {if $_U.query_type=="more"} class="cur"{/if}><a href="{$_U.query_url}/more">��������ϴ�</a></li>
				-->
			</ul>
			{/if}
		</div>
		
		
		
		<!--�ռ��� ��ʼ-->
		{if $_U.query_type=="list"}
	
		<div class="user_right_main">
			<table  border="0"  cellspacing="0" class="table table-striped  table-condensed">
			<form action="" method="post" id="form1">
				<tr class="head" >
				<td>˵����Ϣ </td>
				<td>��������</td>
				<td>�ϴ�ʱ�� </td>
				<td>���ʱ��</td>
				<td>���˵��</td>
				<td>���� </td>
				<td>״̬</td>
				<td>����</td>
				</tr>
			{list module="attestation" function="GetList" showpage="3" var="loop" user_id="0" epage=20}
				{ foreach  from=$loop.list key=key item=item}
				<tr  {if $key%2==1} class="tr1"{/if}>
				<td>{$item.name|default:-}</td>
				<td>{$item.type_name}</td>
				<td>{ $item.addtime|date_format:"Y-m-d H:i"}</td>
				<td>{ $item.verify_time|date_format:"Y-m-d H:i"|default:-}</td>
				<td>{$item.verify_remark|default:-}</td>
				<td>{$item.jifen|default:0} ��</td>
				<td>{if $item.status==0}δ���{elseif $item.status==2}���ʧ��{else}�����{/if}</td>
				
				<td><a href="{$item.litpic|imgurl_format}" target="_blank">�鿴</a></td>
				
				</tr>
				{ /foreach}
				<tr >
					<td colspan="11" class="page">
						{$loop.showpage}
					</td>
				</tr>
				{/list}
			</form>	
			</table>
			<!--�ռ��� ����-->
		</div>
		<!--�ҵĿͻ� ��ʼ-->
		{elseif $_U.query_type=="myuser"}
	
		<div class="user_right_main">
			<table  border="0"  cellspacing="0" class="table table-striped  table-condensed">
			<form action="" method="post" id="form1">
				<tr class="head" >
				<td>˵����Ϣ </td>
				<td>��������</td>
				<td>�ϴ�ʱ�� </td>
				<td>���ʱ��</td>
				<td>���˵��</td>
				<td>���� </td>
				<td>״̬</td>
				</tr>
				{ loop  module="attestation" function="GetList" user_id="$magic.request.user_id" kefu_userid="$_G.user_id" var="item" limit="all"}
				<tr  {if $key%2==1} class="tr1"{/if}>
				<td>{$item.name|default:-}</td>
				<td>{$item.type_name}</td>
				<td>{ $item.addtime|date_format:"Y-m-d H:i"}</td>
				<td>{ $item.verify_time|date_format:"Y-m-d H:i"|default:-}</td>
				<td>{$item.verify_remark|default:-}</td>
				<td>{$item.jifen|default:0} ��</td>
				<td>{if $item.status==0}δ���{elseif $item.status==2}���ʧ��{else}�����{/if}</td>
				
				
				</tr>
				{ /loop}
			</form>	
			</table>
			<!--�ҵĿͻ� ����-->
		</div>
		{elseif $_U.query_type=="one"}
		<div class="user_right_main">
			<form action="" name="form1" method="post" onsubmit="return check_form()" enctype="multipart/form-data">
			<div class="user_help alert"><font color="#FF0000">*</font> �����Ǳ��˵���ʵ����Ч����
			</div>
			<div class="user_right_border">
				<div class="l">�����ϴ���</div>
				<div class="c">
					<input type="file" name="litpic" /> �ϴ�����ͼƬΪ1M���ϴ��ĸ�ʽΪjpg.gif
				</div>
			</div>
			<div class="user_right_border">
				<div class="l">�ϴ����ͣ�</div>
				<div class="c">
					<select name="type_id">
					{foreach from="$_U.attestation_type_list" item="item"}
					{if $item.type_id == $magic.request.type} 
					<option value="{$item.type_id}" selected>{$item.name}</option>
					{else}
					<option value="{$item.type_id}">{$item.name}</option>
					{/if}
					{/foreach}
					</select>
				</div>
			</div>
			<div class="user_right_border">
				<div class="l">��ע˵����</div>
				<div class="c">
					<textarea cols="50" rows="5" name="name"></textarea>
				</div>
			</div>
			
			<div class="user_right_border">
			<div class="l" style="font-weight:bold; float:left;">��֤�룺</div>
			<div class="c">
				<input name="valicode" type="text" size="11" maxlength="4"  tabindex="3"  style="float:left;" />&nbsp;<img src="/plugins/index.php?q=imgcode" alt="���ˢ��" onClick="this.src='/plugins/index.php?q=imgcode&t=' + Math.random();"  style="cursor:pointer;" />
			</div>
		</div>
			<div class="user_right_border">
				<div class="e"></div>
				<div class="c">
					<input type="submit" class="btn-action" value="ȷ���ύ" size="30" /> 
				</div>
			</div>
			</form>
			<div class="user_right_foot alert">
			* ��ܰ��ʾ�����ǽ��ϸ���û����������Ͻ��б���
			</div>
		</div>
			{literal}<script>
				function check_form(){
					 var frm = document.forms['form1'];
					 var file = frm.elements['litpic'].value;
					 var errorMsg = '';
					  if (file.length == 0 ) {
						errorMsg += '* ͼƬ����Ϊ��' + '\n';
					  }
					 
					  if (errorMsg.length > 0){
						alert(errorMsg); return false;
					  } else{  
						return true;
					}
				
				}
			</script>{/literal}
			<!--�޸ĵ�¼���� ����-->
			
		{elseif $_U.query_type=="more"}
		<div class="user_right_main">
			<form action="" name="form1" method="post" onsubmit="return check_form()" enctype="multipart/form-data">
			<div class="user_help alert"><font color="#FF0000">*</font> �����Ǳ��˵��������<br />
					<font color="#FF0000">*</font> ��ʵ ��Ч<br />
			</div>
			
			<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,19,0" width="700" height="500">
  <param name="movie" value="/plugins/swfupload/swfupload.swf?config=/index.php%3fplugins%26ac=swfupload%26code=attestation" />
  <param name="quality" value="high" />
  <embed src="/plugins/swfupload/swfupload.swf?config=/index.php%3fplugins%26ac=swfupload%26code=attestation" quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" width="700" height="500"></embed>
</object>
			
			<div class="user_right_border">
				<div class="e"></div>
				<div class="c">
					<input type="submit" class="btn-action" value="ȷ���ύ" size="30" /> 
				</div>
			</div>
			</form>
	</div>
	
	
	
		{/if}
</div>
<!--�û����ĵ�����Ŀ ����-->
</div>
</div>
<script src="/themes/js/modal.js"></script>
<script src="/themes/js/tab.js"></script>
<script src="/themes/js/alert.js"></script>
<script src="/themes/js/transition.js"></script>
{include file="user_footer.html"}