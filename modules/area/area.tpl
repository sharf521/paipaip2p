
<div class="module_add">

	<form action="" method="post" onsubmit="return check_form()" name="form1">
	<div class="module_title"><strong>{ if $_A.query_type == "edit" }�༭{else}���{/if}{$_A.list_title}</strong></div>
	
	<div class="module_border">
		<div class="l">{$_A.list_title}���ƣ�</div>
		<div class="c">
			<input type="text" name="name"  class="input_border" value="{ $_A.area_result.name}" size="30" />  
		</div>
	</div>
	
	<div class="module_border">
		<div class="l">{$_A.list_title}��ʶ����</div>
		<div class="c">
			<input type="text" name="nid"  class="input_border" value="{ $_A.area_result.nid}" size="30" />
		</div>
	</div>
	
	<!--
	<div class="module_border">
		<div class="l">ʡ�ݶ���������</div>
		<div class="c">
			<input type="text" name="domain"  class="input_border" value="{ $_A.area_result.domain|default:".xiuw.org"}" size="30" /> ���磺beijing.hycms.com
		</div>
	</div>
	-->
	<div class="module_border">
		<div class="l">����</div>
		<div class="c">
			<input type="text" name="order"  class="input_border" value="{ $_A.area_result.order|default:10}" size="10" />
		</div>
	</div>
	
	<div class="module_submit border_b" >
		<input type="hidden" name="pid" value="{$magic.request.pid|default:0}" />
		{ if $_A.query_type == "edit" }<input type="hidden" name="id" value="{ $_A.area_result.id }" />{/if}
		<input type="submit"  name="submit" value="ȷ���ύ" />
		<input type="button" onclick="javascript:location.href='{$_A.query_url}&action={$magic.request.action}&pid={$magic.request.pid}'" value="���{$_A.list_title}" />
	</div>
	</form>
</div>
<table  border="0"  cellspacing="1" bgcolor="#CCCCCC" width="100%">
	<form action="{$_A.query_url}/action" method="post">
	<tr >
		<td class="main_td">ID</td>
		<td class="main_td">��������</td>
		<td class="main_td">��ʶ��</td>
		<td class="main_td">����</td>
		<td class="main_td">����</td>
		<td class="main_td">����</td>
	</tr>
	{ foreach  from=$_A.area_list key=key item=item}
	<tr {if $key%2==1} class="tr2"{/if}>
		<td class="main_td1" align="center">{ $item.id}</td>
		<td class="main_td1" align="center" >{$item.name}</td>
		<td class="main_td1" align="center" >{$item.nid}</td>
		<td class="main_td1" align="center" >{$_A.list_title}</td>
		<td class="main_td1" align="center" ><input type="text" value="{$item.order|default:10}" name="order[]" size="5" /><input type="hidden" name="id[]" value="{$item.id}" /></td>
		<td class="main_td1" align="center" width="130">{if $magic.request.action=='' || $magic.request.action=='province'}<a href="{$_A.query_url}&action=city&pid={$item.id}{$_A.site_url}">����</a> /{elseif $magic.request.action=='city'} <a href="{$_A.query_url}&action=area&pid={$item.id}{$_A.site_url}">����</a> / {/if}<a href="{$_A.query_url}/edit&action={ $magic.request.action|default:'province'}&pid={$item.pid}&id={$item.id}{$_A.site_url}">�޸�</a> / <a href="#" onClick="javascript:if(confirm('ȷ��Ҫɾ����?ɾ���󽫲��ɻָ�')) location.href='{$_A.query_url}/del&id={$item.id}{$_A.site_url}'">ɾ��</a></td>
	</tr>
	{ /foreach}
	<tr >
		<td colspan="8" class="submit"  height="30">
			<input type="submit" name="submit" value="�޸�����" /><input type="hidden" name="type" value="0" />
		</td>
	</tr>
	<tr >
		<td colspan="8" class="page"  height="30">
			{$_A.showpage}
		</td>
	</tr>
	</form>	
</table>


{literal}
<script>
function check_form(){
	 var frm = document.forms['form1'];
	 var title = frm.elements['name'].value;
	 var nid = frm.elements['nid'].value;
	 var errorMsg = '';
	  if (title.length == 0 ) {
		errorMsg += '���Ʊ�����д' + '\n';
	  }
	  if (nid.length == 0 ) {
		errorMsg += '��ʶ��������д' + '\n';
	  }
	  if (errorMsg.length > 0){
		alert(errorMsg); return false;
	  } else{  
		return true;
	  }
}
</script>
{/literal}
