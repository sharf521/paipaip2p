<?php
!defined('IN_TEMPLATE') && exit('Access Denied');
?>
{include file="admin_head.html.php"}

<div class="main">
	<div class="main_left">
		{include file="admin_control_menu.html"}
	</div>
	<div class="main_right">
	
		<div class="main_site">
			<ul>
				<li class="site_sub">{$list_menu}</li>
				<li class="title">我的控制台</li>
			</ul>
		</div>
		
		<div class="main_content">
			
				{ if $s==""}
			<table  border="0"  cellspacing="1" bgcolor="#CCCCCC" width="100%">
			<form action="{$url}actions" method="post"  >
			
				<tr >
				  <td  class="main_td" >名称</td>
				  <td width="*" class="main_td">地址</td>
				  <!--<td  class="main_td">权限管理</td>-->
				  <td class="main_td">排序</td>
				   <td  class="main_td">编辑</td>
				</tr>
				{ foreach from=$list key=key item=item}
				<tr  {if $key%2==1}class="tr2"{/if}>
				  <td   class="main_td1" align="left" >&nbsp;&nbsp;{ $item.aname}</td>
				  <td align="left" class="main_td1" >
				 { $item.url}
				  </td>
				  <!--<td  class="main_td1" >{html_checkboxes options="$admin_type" name="purview" checked="$item.purview" kname = "$key"}</td>-->
				  <td class="main_td1" > <input type="text" name="order[{$key}]" value="{ $item.order}" size="5" /> <input type="hidden" name="id[{$key}]" value="{ $item.id}" /></td>
				   <td class="main_td1" ><a href="{$url}edit&id={$item.id}">修改</a> / <a href=" {$url}del&id={$item.id}">删除</a></td>
				</tr>
				{ /foreach}
				<tr >
				  <td  colspan="7" class="submit" > <input type="submit" value="确认修改"  />&nbsp;&nbsp;&nbsp;<input value="添加栏目" type="button" onclick="javascript:location='{ $url}new';" /></td>
				</tr>
				</form>
			</table>
			{elseif $s == "new" || $s == "edit"}
				<div class="module_add">
	
				<form name="form_user" method="post" action="{$query_site}&q=control/{ if $s == "edit" }update{else}add{/if}" >
				<div class="module_title"><strong>{ if $s == "edit" }编辑{else}添加{/if}目录</strong></div>
				
				<div class="module_border">
					<div class="l">所属目录：</div>
					<div class="c">
						<select name="pid"><option value="0">根目录</option>
						{foreach from="$list" item="item"}
						<option value="{$item.id}" {if $result.pid==$item.id} selected="selected"{/if}>{$item.aname}</option>
						{/foreach}
						</select>
					</div>
				</div>
				
				<div class="module_border">
					<div class="l">名称：</div>
					<div class="c">
						<input name="name" type="text" value="{$result.name}"  class="input_border" size="25" />
					</div>
				</div>
				
				<div class="module_border">
					<div class="l">地址：</div>
					<div class="c">
						<input name="url" type="text" value="{$result.url}"  class="input_border" size="25" />
					</div>
				</div>
				
				<div class="module_border">
					<div class="l">排序：</div>
					<div class="c">
						<input name="order" type="text" value="{$result.order|default:10}"  class="input_border" size="5" />
					</div>
				</div>
				<!--
				<div class="module_border">
					<div class="l">管理权限：</div>
					<div class="c">
						{html_checkboxes options="$admin_type" name="purview" checked="$result.purview"}
					</div>
				</div>
				-->
				<div class="module_submit"><input name="" type="submit" value=" 提交 " /> <input name="" type="reset" value=" 重置 " />{ if $s == "edit" }<input type="hidden" name="id" value="{$result.id}" />{/if}
				</div>
				 </form>
			</div>
				 {literal}
				<script>
				function check_form(){
					var frm = document.forms['form1'];
					 var title = frm.elements['name'].value;
					 var nid = frm.elements['nid'].value;
					 var errorMsg = '';
					  if (title.length == 0 ) {
						errorMsg += '参数名称必须填写' + '\n';
					  }
					  if (nid.length == 0 ) {
						errorMsg += '变量名必须填写' + '\n';
					  }
					  if (errorMsg.length > 0){
						alert(errorMsg); return false;
					  } else{  
						return true;
					  }
				}
				</script>
				{/literal}
			{else}
			{include file="$html_template"}
			{/if}
	
		</div>
	</div>
</div>

{include file="admin_foot.html"}

