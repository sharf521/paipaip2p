<?php
!defined('IN_TEMPLATE') && exit('Access Denied');
?>
<table  border="0"  cellspacing="1" bgcolor="#CCCCCC" width="100%">
	<tr >
		<td width="" class="main_td">ID</td>
		<td width="*" class="main_td">用户名</td>
		<td width="*" class="main_td">真实姓名</td>
		<td width="*" class="main_td">处理信息</td>
		<td width="*" class="main_td">地址</td>
		<th width="" class="main_td">状态</th>
		<th width="" class="main_td">添加时间</th>
		<th width="" class="main_td">IP</th>
	</tr>
	{ foreach  from=$_A.userlog_list key=key item=item}
	<tr {if $key%2==1} class="tr2"{/if}>
		<td class="main_td1" align="center">{ $item.log_id}</td>
		<td class="main_td1" align="center">{$item.username}</td>
		<td class="main_td1" align="center">{$item.realname}</td>
		<td class="main_td1" align="center">{$item.query}</td>
		<td class="main_td1" align="center">{$item.url}</td>
		<td class="main_td1" align="center">{if $item.result==1}成功{else}<font color="#FF0000">失败</font>{/if}</td>
		<td class="main_td1" align="center" >{$item.addtime|date_format:"Y-m-d H:i:s"}</td>
		<td class="main_td1" align="center" >{$item.addip}</td>
	</tr>
	{ /foreach}
	<tr>
			<td colspan="11" class="action">
			<div class="floatl">
			<script>
	  var url = '{$_A.query_url}';
	    {literal}
	  	function sousuo(){
			var username = $("#username").val();
			var quer = $("#quer").val();
			location.href=url+"&quer="+quer+"&username="+username;
		}
	  
	  </script>
	  {/literal}
			</div>
			<div class="floatr">
				用户名：<input type="text" name="username" id="username" value="{$magic.request.username}"/>  处理信息：<input type="text" name="quer" id="quer" value="{$magic.request.quer}"/> <input type="button" value="搜索" / onclick="sousuo()">
			</div>
			</td>
		</tr>
	<tr>
		<td colspan="7" class="page">
		{$_A.showpage}
		</td>
	</tr>
</table>
