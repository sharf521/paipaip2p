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
				<li class="title">�ҵĿ���̨</li>
			</ul>
		</div>
		
		<div class="main_content">
			
				{ if $s==""}
			<table  border="0"  cellspacing="1" bgcolor="#CCCCCC" width="100%">
			<form action="{$url}actions" method="post"  >
			
				<tr >
				  <td  class="main_td" >����</td>
				  <td width="*" class="main_td">��ַ</td>
				  <!--<td  class="main_td">Ȩ�޹���</td>-->
				  <td class="main_td">����</td>
				   <td  class="main_td">�༭</td>
				</tr>
				{ foreach from=$list key=key item=item}
				<tr  {if $key%2==1}class="tr2"{/if}>
				  <td   class="main_td1" align="left" >&nbsp;&nbsp;{ $item.aname}</td>
				  <td align="left" class="main_td1" >
				 { $item.url}
				  </td>
				  <!--<td  class="main_td1" >{html_checkboxes options="$admin_type" name="purview" checked="$item.purview" kname = "$key"}</td>-->
				  <td class="main_td1" > <input type="text" name="order[{$key}]" value="{ $item.order}" size="5" /> <input type="hidden" name="id[{$key}]" value="{ $item.id}" /></td>
				   <td class="main_td1" ><a href="{$url}edit&id={$item.id}">�޸�</a> / <a href=" {$url}del&id={$item.id}">ɾ��</a></td>
				</tr>
				{ /foreach}
				<tr >
				  <td  colspan="7" class="submit" > <input type="submit" value="ȷ���޸�"  />&nbsp;&nbsp;&nbsp;<input value="������Ŀ" type="button" onclick="javascript:location='{ $url}new';" /></td>
				</tr>
				</form>
			</table>
			{elseif $s == "new" || $s == "edit"}
				<div class="module_add">
	
				<form name="form_user" method="post" action="{$query_site}&q=control/{ if $s == "edit" }update{else}add{/if}" >
				<div class="module_title"><strong>{ if $s == "edit" }�༭{else}����{/if}Ŀ¼</strong></div>
				
				<div class="module_border">
					<div class="l">����Ŀ¼��</div>
					<div class="c">
						<select name="pid"><option value="0">��Ŀ¼</option>
						{foreach from="$list" item="item"}
						<option value="{$item.id}" {if $result.pid==$item.id} selected="selected"{/if}>{$item.aname}</option>
						{/foreach}
						</select>
					</div>
				</div>
				
				<div class="module_border">
					<div class="l">���ƣ�</div>
					<div class="c">
						<input name="name" type="text" value="{$result.name}"  class="input_border" size="25" />
					</div>
				</div>
				
				<div class="module_border">
					<div class="l">��ַ��</div>
					<div class="c">
						<input name="url" type="text" value="{$result.url}"  class="input_border" size="25" />
					</div>
				</div>
				
				<div class="module_border">
					<div class="l">����</div>
					<div class="c">
						<input name="order" type="text" value="{$result.order|default:10}"  class="input_border" size="5" />
					</div>
				</div>
				<!--
				<div class="module_border">
					<div class="l">����Ȩ�ޣ�</div>
					<div class="c">
						{html_checkboxes options="$admin_type" name="purview" checked="$result.purview"}
					</div>
				</div>
				-->
				<div class="module_submit"><input name="" type="submit" value=" �ύ " /> <input name="" type="reset" value=" ���� " />{ if $s == "edit" }<input type="hidden" name="id" value="{$result.id}" />{/if}
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
						errorMsg += '�������Ʊ�����д' + '\n';
					  }
					  if (nid.length == 0 ) {
						errorMsg += '������������д' + '\n';
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
