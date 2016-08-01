{if $_A.query_type == "new" || $_A.query_type == "edit"}

{/literal}
{elseif $_A.query_type == "view"}
<div class="module_add">

	<form name="form1" method="post" action="{$_A.query_url}/{ if $_A.query_type == "edit" }update{else}add{/if}{$_A.site_url}" onsubmit="return check_form();" enctype="multipart/form-data">
	<div class="module_title"><strong>�鿴�ظ�����</strong></div>
	
	<div class="module_border">
		<div class="l">�����ˣ�</div>
		<div class="c">
			{$_A.comment_result.username}
		</div>
	</div>
	
	<div class="module_border">
		<div class="l">ģ�飺</div>
		<div class="c">
			{$_A.comment_result.module_name}
		</div>
	</div>
	
	<div class="module_border">
		<div class="l">�������£�</div>
		<div class="c">
			<a href="{$_A.comment_result.site_nid}/a{$_A.comment_result.article_id}.html" target="_blank">{$_A.comment_result.title}</a>
		</div>
	</div>
	
	<div class="module_border">
		<div class="l"> �������ݣ�</div>
		<div class="c">
			{$_A.comment_result.comment}
		</div>
	</div>
	
	<div class="module_border">
		<div class="l">�ظ���</div>
		<div class="c">
			<textarea name="comment" rows="5" cols="40"></textarea>
		</div>
	</div>
	
	<div class="module_submit border_b" >
		{ if $_A.query_type == "edit" }<input type="hidden" name="id" value="{ $_A.comment_result.id }" />{/if}
		<input type="submit"  name="submit" value="ȷ���ύ" />
		<input type="reset"  name="reset" value="���ñ�" />
	</div>
	</form>
</div>
{else}
<table  border="0"  cellspacing="1" bgcolor="#CCCCCC" width="100%">
	<form action="{$_A.query_url}/action{$_A.site_url}" method="post">
	<tr >
		<td  class="main_td"><input type="checkbox" name="allcheck" onclick="checkFormAll(this.form)"/></td>
		<td  class="main_td">ID</td>
		<td  class="main_td">����ģ��</td>
		<td  class="main_td">��������</td>
		<td  class="main_td">������</td>
		<td  class="main_td">��������</td>
		<td  class="main_td">״̬</td>
		<td  class="main_td">���� 
		</td>
	</tr>
	{ foreach  from=$_A.comment_list key=key item=item}
	<tr {if $key%2==1} class="tr2"{/if}>
		<td class="main_td1" align="center"><input type="checkbox" name="aid[{$key}]" value="{$item.id}"/></td>
		<td class="main_td1" align="center">{ $item.id}</td>
		<td class="main_td1" align="center">{$item.module_name|truncate:34}</td>
		<td class="main_td1" align="center">{ $item.comment}</td>
		<td class="main_td1" align="center">{ $item.realname}</td>
		<td class="main_td1" align="center">{ $item.addtime|date_format:"Y-m-d H:i"}</td>
		<td class="main_td1" align="center">{ if $item.status ==1}<a href="{$_A.query_url}{$_A.site_url}&status=0&id={ $item.id}">��ʾ</a>{else}<a href="{$_A.query_url}{$_A.site_url}&status=1&id={ $item.id}">����</a>{/if}</td>
		<td class="main_td1" align="center"><a href="{$_A.query_url}/view{$_A.site_url}&id={$item.id}&module_code={$item.module_code}" >�鿴</a> <a href="#" onClick="javascript:if(confirm('ȷ��Ҫɾ����?ɾ���󽫲��ɻָ�')) location.href='{$_A.query_url}/del{$_A.site_url}&id={$item.id}'">ɾ��</a> 
			</td>
	</tr><input type="hidden" name="flag[{$key}]" value="{$item.flag}" />
	{ /foreach}
	<tr >
		<td colspan="8" class="action">
		ģ�飺<input type="text" name="module_code" id="module_code" value="{$magic.request.module_code}"/>
		״̬��<select name="status" id="status">
			<option value="">ȫ��</option>
			<option value="0">����</option>
			<option value="1">��ʾ</option>
		</select>
		<input type="button" value="����" onclick="sousuo()" />
		 
			</td>
	</tr>
	<tr>
		<td colspan="8" class="page">
		{$page}
		 
		</td>
	</tr>
</table>
 <script>
	  var url = '{$_A.query_url}';
	    {literal}
	  	function sousuo(){
			var module_code = $("#module_code").val();
			var status = $("#status").val();
			location.href=url+"&status="+status+"&module_code="+module_code;
		}

	  </script>
	  {/literal}
{/if}