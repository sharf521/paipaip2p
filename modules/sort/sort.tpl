{if $_A.query_type == "new" || $_A.query_type == "edit"}
<div class="module_add">
	<form name="form1" method="post" action="" onsubmit="return check_form();" enctype="multipart/form-data">
	<div class="module_title"><strong>{ if $_A.query_type == "edit" }�༭{else}���{/if}��Ŀ</strong></div>
	
	<div class="module_border">
		<div class="l">����Ŀ��</div>
		<div class="c">
			<select name="pid">
				<option value="0">��Ŀ¼</option>
				{foreach from="$_A.sort_list" item="var"}
				<option value="{$var.id}" {if $_A.sort_result.pid==$var.id || $magic.request.pid==$var.id} selected="selected"{/if}>{$var.aname}</option>
				{/foreach}
			</select>
		</div>
	</div>
	
	<div class="module_border">
		<div class="l">��Ŀ���ƣ�</div>
		<div class="c">
			<input type="text" name="name"  class="input_border" value="{ $_A.sort_result.name}" size="30" /> 
		</div>
	</div>
	
	
	<div class="module_border">
		<div class="l">�������ԣ�</div>
		<div class="c">
			{loop table="flag" order="`order` desc" var="var"}<input type="checkbox" name="flag[]" value="{$var.nid}" {$var.nid|checked:$_A.sort_result.flag }/>{$var.name} {/loop}
		</div>
	</div>
	
	
	<div class="module_border">
		<div class="l">״̬��</div>
		<div class="c">
			<input type="radio" name="status" value="0"  { if $_A.sort_result.status == 0 }checked="checked"{/if}/>���� <input type="radio" name="status" value="1"  { if $_A.sort_result.status ==1 ||$_A.sort_result.status ==""}checked="checked"{/if}/>��ʾ 
		</div>
	</div>

	<div class="module_border">
		<div class="l">����</div>
		<div class="c">
			<input type="text" name="order"  class="input_border" value="{ $_A.sort_result.order|default:10}" size="10" />
		</div>
	</div>
	

	<div class="module_border">
		<div class="l">��ĿͼƬ��</div>
		<div class="c">
			<input type="file" name="litpic" size="30" class="input_border"/>{if $_A.sort_result.litpic!=""}<a href="./{$_A.sort_result.litpic}" target="_blank" title="��ͼƬ"><img src="{ $tpldir }/images/ico_1.jpg" border="0"  /></a><input type="checkbox" name="clearpic" value="1" />ȥ������ͼ{/if}
		</div>
	</div>
	
	<div class="module_border">
		<div class="l">��飺</div>
		<div class="c">
			{editor name="content" type="sinaeditor" value="$_A.sort_result.content"}
		</div>
	</div>
	
	
	<div class="module_submit border_b" >
		{ if $_A.query_type == "edit" }<input type="hidden" name="id" value="{ $_A.sort_result.id }" />{/if}
		<input type="submit"  name="submit" value="ȷ���ύ" />
		<input type="reset"  name="reset" value="���ñ�" />
	</div>
	</form>
</div>

{literal}
<script>
function check_form(){
	 var frm = document.forms['form1'];
	 var title = frm.elements['name'].value;
	 var content = frm.elements['content'].value;
	 var errorMsg = '';
	  if (title.length == 0 ) {
		errorMsg += '���������д' + '\n';
	  }
	  if ($("#site_center").val()==""){
		errorMsg += '��ѡ����Ŀ' + '\n';
	}
	  if (errorMsg.length > 0){
		alert(errorMsg); return false;
	  } else{  
		return true;
	  }
}

</script>
{/literal}

{elseif $_A.query_type=="list"}
<table  border="0"  cellspacing="1" bgcolor="#CCCCCC" width="100%">
	<form action="{$_A.query_url}/action{$site_url}" method="post">
	<tr >
		<td width="" class="main_td"><input type="checkbox" name="allcheck" onclick="checkFormAll(this.form)"/></td>
		<td width="*" class="main_td">��Ŀ����</td>
		<td width="" class="main_td">״̬</td>
		<td width="" class="main_td">����</td>
		<td width="" class="main_td">����</td>
		<td width="" class="main_td">����</td>
	</tr>
	{ foreach  from=$_A.sort_list key=key item=item}
	<tr {if $key%2==1}class="tr2"{/if}>
		<td class="main_td1"><input type="checkbox" name="aid[{$key}]" value="{$item.id}"/></td>
		<td class="main_td1" align="left" >{$item.aname}</td>
		<td class="main_td1">{ if $item.status ==1}<a href="{$_A.query_url}{$site_url}&status=0&id={ $item.id}">��ʾ</a>{else}<a href="{$_A.query_url}{$site_url}&status=1&id={ $item.id}">����</a>{/if}</td>
		<td class="main_td1">{$item.flagname|default:-}</td>
		<td class="main_td1"><input type="text" name="order[{$key}]" value="{$item.order}" size="3" /><input type="hidden" name="id[{$key}]" value="{$item.id}" /></td>
		<td class="main_td1"><a href="{$_A.query_url}/new{$site_url}&pid={$item.id}" >����Ŀ</a>  /  <a href="{$_A.query_url}/edit{$site_url}&id={$item.id}" >�޸�</a> / <a href="#" onClick="javascript:if(confirm('ȷ��Ҫɾ����?ɾ���󽫲��ɻָ�')) location.href='{$_A.query_url}/del{$site_url}&id={$item.id}'">ɾ��</a></td>
	</tr><input type="hidden" name="flag[{$key}]" value="{$item.flag}" />
	{ /foreach}
	<tr>
		<td colspan="10" class="action">
		<div class="floatl">
		<select name="type">
		<option value="0">����</option>
		<option value="1">��ʾ</option>
		<option value="2">����</option>
		<option value="3">�Ƽ�</option>
		<option value="4">ͷ��</option>
		<option value="5">�õ�Ƭ</option>
		<option value="6">ɾ��</option>&nbsp;&nbsp;&nbsp;
		</select> <input type="submit" value="ȷ�ϲ���" /> ������ȫѡ
		</div>
		
		</td>
	</tr>
</table>

{/if}