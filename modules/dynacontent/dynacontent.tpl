{if $_A.query_type == "new" || $_A.query_type == "edit"}
<div class="module_add">
	<form name="form1" method="post" action="" onsubmit="return check_form();" enctype="multipart/form-data" >
	<div class="module_title"><strong>{ if $_A.query_type == "edit" }�༭{else}���{/if}��̬����</strong></div>
	
	<div class="module_border">
		<div class="l">��̬�������ƣ�</div>
		<div class="c">
			<input type="text" name="webname"  class="input_border" value="{ $_A.dynacontent_result.webname}" size="30" />  
		</div>
	</div>
	
	<div class="module_border">
		<div class="l">���</div>
		<div class="c">
			<select name="type_id">
			{foreach from=$_A.dynacontent_type_list item=item}
			<option  value="{ $item.id}" {if $item.id==$_A.dynacontent_result.type_id} selected="selected"{/if} />{ $item.typename}</option>
			
			{/foreach}
			</select>
		</div>
	</div>
	
	<div class="module_border">
		<div class="l">������վ��</div>
		<div class="c">
			<select name="areaid">
			{foreach from=$_A.subsite_list item=item}
			<option  value="{ $item.id}" {if $item.id==$_A.dynacontent_result.areaid} selected="selected"{/if} />{ $item.sitename}</option>
			
			{/foreach}
			</select>
		</div>
	</div>	
	
		<div class="module_border">
		<div class="l">����</div>
		<div class="c">
			<input type="text" name="order"  class="input_border" value="{ $_A.dynacontent_result.order|default:10}" size="10" />
		</div>
	</div>
	<div class="module_border">
		<div class="l">���ݣ�</div>
		<div class="c">            
            <script type="text/javascript" charset="gbk" src="/plugins/ueditor/ueditor.config.js"></script>
			<script type="text/javascript" charset="gbk" src="/plugins/ueditor/ueditor.all.min.js"> </script>
            <script type="text/javascript" charset="gbk" src="/plugins/ueditor/lang/zh-cn/zh-cn.js"></script>
            <script id="content" name="content" type="text/plain" style="width:800px; height:400px;">{$_A.dynacontent_result.content}</script>
            {literal}
            <script type="text/javascript">	
                var ue = UE.getEditor('content',{
                    serverUrl:"/plugins/ueditor/php/controller.php?type=admin"
                })
            </script>
            {/literal}
		</div>
	</div>
	
	<div class="module_submit" >
		{ if $_A.query_type == "edit" }<input type="hidden" name="id" value="{ $_A.dynacontent_result.id }" />{/if}
		<input type="submit"  name="submit" value="ȷ���ύ" />
		<input type="reset"  name="reset" value="���ñ�" />
		</div>
	</div>
	</form>
</div>

{literal}
<script>	
function check_form(){
	 var frm = document.forms['form1'];
	 var webname = frm.elements['webname'].value;
	 var url = frm.elements['url'].value;
	 var errorMsg = '';
	  if (webname.length == 0 ) {
		errorMsg += '��վ���������д' + '\n';
	  }
	  if (url.length == 0 ) {
		errorMsg += '���ӵ�ַ����Ϊ��' + '\n';
	  }
	  if (errorMsg.length > 0){
		alert(errorMsg); return false;
	  } else{  
		return true;
	  }
}

</script>
{/literal}
{elseif $_A.query_type == "type"}
<form name="form1" method="post" action="" >
<table width="100%" border="0"  cellspacing="1" bgcolor="#CCCCCC">
<tr >
		<td width="" class="main_td">ID</td>
		<td width="*" class="main_td">����</td>
		<td width="" class="main_td">����</td>
	</tr>
	{ foreach  from=$_A.links_type_list key=key item=item}
	<tr {if $key%2==1} class="tr2"{/if}>
		<td class="main_td1" align="center">{ $item.id}</td>
		<td class="main_td1" align="left">&nbsp;&nbsp;&nbsp;<input type="text" value="{$item.typename}" name="typename[]" /><input type="hidden" name="id[]" value="{$item.id}" /></td>
		<td class="main_td1" align="center" width="160"><a href="#" onClick="javascript:if(confirm('ȷ��Ҫɾ����?ɾ���󽫲��ɻָ�')) location.href='{$_A.query_url}/type&del_id={$item.id}'">ɾ��</a> </td>
	</tr>
	{ /foreach}
	<tr >
		<td width="" class="main_td" colspan="3">����һ�����ͣ�<input type="text" name="typename1" /></td>
	</tr>

<tr>
	<td bgcolor="#ffffff" colspan="3"  align="center">
	<input type="submit"  name="submit" value="ȷ���ύ" />
	</tr>
<tr>
</table>
</form>
{elseif $_A.query_type == "view"}

{else}
<table  border="0"  cellspacing="1" bgcolor="#CCCCCC" width="100%">
  <form action="{$_A.query_url}/order" method="post">
	<tr >
		<td width="" class="main_td">ID</td>
		<td width="" class="main_td">��վ</td>
		<td width="" class="main_td">����</td>
		<td width="" class="main_td">��������</td>
		<td width="" class="main_td">����</td>
		<td width="" class="main_td">���ʱ��</td>
		<td width="" class="main_td">����</div>
	</div>
	{ foreach  from=$_A.dynacontent_list key=key item=item}
	<tr {if $key%2==1} class="tr2"{/if}>
		<td class="main_td1" align="center">{ $item.id}</td>
		<td class="main_td1" align="center">{ $item.sitename}</td>
		<td class="main_td1" align="center">{$item.typename }</td>
		<td class="main_td1" align="center">{$item.webname}</td>
		<td class="main_td1" align="center" width="50"><input type="text" value="{$item.order|default:10}" name="order[]" size="5" /><input type="hidden" name="id[]" value="{$item.id}" /></td>
		<td class="main_td1" align="center" width="90">{$item.addtime|date_format:"Y-m-d"}</td>
		<td class="main_td1" align="center" width="130"><a href="{$_A.query_url}/edit&id={$item.id}">�޸�</a> / <a href="#" onClick="javascript:if(confirm('ȷ��Ҫɾ����?ɾ���󽫲��ɻָ�')) location.href='{$_A.query_url}/del&id={$item.id}'">ɾ��</a></div>
	</div>
	{ /foreach}
	<tr >
		<td colspan="8" class="submit">
			<input type="submit" name="submit" value="ȷ���ύ" />
		</td>
	</tr>
	<tr >
		<td colspan="8" class="page">
			{$_A.showpage}
		</td>
	</tr>
	</form>	
</table>
{/if}