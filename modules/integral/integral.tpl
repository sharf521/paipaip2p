{if $_A.query_type == "new" || $_A.query_type == "edit"}
<div class="module_add">
	<form name="form1" method="post" action="" onsubmit="return check_form();" enctype="multipart/form-data">
	<div class="module_title"><strong>{ if $_A.query_type == "edit" }�༭{else}���{/if}����</strong></div>
	
	<div class="module_border">
		<div class="l">��Ʒ���ƣ�</div>
		<div class="c">
			<input type="text" name="name"  class="input_border" value="{ $_A.integral_result.name}" size="30" />
		</div>
	</div>
	
	
	<div class="module_border">
		<div class="l">���ԣ�</div>
		<div class="c">
			{foreach from="$_A.flag_list" item="var"}<input type="checkbox" name="flag[]" value="{$var.nid}" {$var.nid|checked:$_A.integral_result.flag }/>{$var.name} {/foreach}
		</div>
	</div>
	
	<div class="module_border">
		<div class="l">״̬��</div>
		<div class="c">
			<input type="radio" name="status" value="0"  { if $_A.integral_result.status == 0 }checked="checked"{/if}/>���� <input type="radio" name="status" value="1"  { if $_A.integral_result.status ==1 ||$_A.integral_result.status ==""}checked="checked"{/if}/>��ʾ 
		</div>
	</div>

	<div class="module_border">
		<div class="l">����</div>
		<div class="c">
			<input type="text" name="order"  class="input_border" value="{ $_A.integral_result.order|default:10}" size="10" />
		</div>
	</div>
	
	<div class="module_border">
		<div class="l">����ͼ��</div>
		<div class="c">
			<input type="file" name="litpic" size="30" class="input_border"/>{if $_A.integral_result.litpic!=""}<a href="./{$_A.integral_result.litpic}" target="_blank" title="��ͼƬ"><img src="{ $_A.tpldir }/images/ico_1.jpg" border="0"  /></a><input type="checkbox" name="clearlitpic" value="1" />ȥ������ͼ{/if}
		</div>
	</div>


	<div class="module_border">
		<div class="l">������֣�</div>
		<div class="c">
			<input type="text" name="need"  class="input_border" value="{ $_A.integral_result.need}" onkeyup="value=value.replace(/[^0-9]/g,'')" />
		</div>
	</div>
	
	<div class="module_border">
		<div class="l">������</div>
		<div class="c">
			<input type="text" name="number"  class="input_border" onkeyup="value=value.replace(/[^0-9]/g,'')" value="{ $_A.integral_result.number}" />
		</div>
	</div>
	
	<div class="module_border">
		<div class="l">�һ����У�</div>
		<div class="c">
			<script src="./plugins/index.php?&q=area&area={$_A.integral_result.area}" type='text/javascript' language="javascript"></script>
		</div>
	</div>

	<div class="module_border">
		<div class="l">����֣�</div>
		<div class="c">
			{editor name="content" type="sinaeditor" value="$_A.integral_result.content"}
		</div>
	</div>
	
	<div class="module_submit border_b" >
		{ if $_A.query_type == "edit" }<input type="hidden" name="id" value="{ $_A.integral_result.id }" />{/if}
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


{elseif $_A.query_type == "view"}
<div class="module_add">
	<div class="module_title"><strong>�鿴</strong></div>
	
	<div class="module_border">
		<div class="l">��Ʒ���ƣ�</div>
		<div class="c">
			{ $_A.integral_result.name}
		</div>
	</div>
	
	
	<div class="module_border">
		<div class="l">���ԣ�</div>
		<div class="c">
			 {$_A.integral_result.flag|flag}
		</div>
	</div>
	
	<div class="module_border">
		<div class="l">״̬��</div>
		<div class="c">
			{ if $_A.integral_result.status == 0 }����{else}��ʾ{/if} 
		</div>
	</div>

	<div class="module_border">
		<div class="l">����</div>
		<div class="c">
			{ $_A.integral_result.order}
		</div>
	</div>
	
	<div class="module_border">
		<div class="l">����ͼ��</div>
		<div class="c">
			{if $_A.integral_result.litpic!=""}<a href="./{$_A.integral_result.litpic}" target="_blank" title="��ͼƬ"><img src="{ $_A.tpldir }/images/ico_1.jpg" border="0"  /></a>{/if}
		</div>
	</div>


	<div class="module_border">
		<div class="l">������֣�</div>
		<div class="c">
			{ $_A.integral_result.need}
		</div>
	</div>
	
	<div class="module_border">
		<div class="l">������</div>
		<div class="c">
			{ $_A.integral_result.number}
		</div>
	</div>
	
	<div class="module_border">
		<div class="l">�һ����У�</div>
		<div class="c">
			{$_A.integral_result.area|area}
		</div>
	</div>

	<div class="module_border">
		<div class="l">����ݣ�</div>
		<div class="c">
			{$_A.integral_result.content}
		</div>
	</div>
</div>
{elseif $_A.query_type=="convert"}
<table  border="0"  cellspacing="1" bgcolor="#CCCCCC" width="100%">
	<form action="{$_A.query_url}/action{$_A.site_url}" method="post">
	<tr >
		<td class="main_td">ID</td>
		<td class="main_td">��Ʒ����</td>
		<td  class="main_td">�һ���</td>
		<td class="main_td">����</td>
		<td class="main_td">��ֵ</td>
		<td class="main_td">�ܶһ�����</td>
		<td  class="main_td">�һ�ʱ��</td>
		<td  class="main_td">״̬</td>
		<td class="main_td">����</td>
	</tr>
	{ foreach  from=$_A.integral_convert_list key=key item=item}
	<tr  {if $key%2==1}class="tr2"{/if}>
		<td>{ $item.id}</td>
		<td><a href="{$_A.query_url}/view&id={$item.integral_id}{$_A.site_url}">{$item.goods_name}</a></td>
		<td>{ $item.realname}({ $item.username})</td>
		<td>{$item.number}</td>
		<td>{$item.need}</td>
		<td>{ $item.integral}</td>
		<td>{ $item.addtime|date_format:"Y-m-d H:i"}</td>
		<td >{ if $item.status ==1}�Ѷһ�{ elseif $item.status ==2}�ر�{else}δ�һ�{/if}</td>
		<td><a href="{$_A.query_url}/convert_view&id={$item.id}">�鿴</a></td>
	</tr><input type="hidden" name="flag[{$key}]" value="{$item.flag}" />
	{ /foreach}
	<tr>
		<td colspan="9" class="page">
		{$_A.showpage}
		</td>
	</tr>
	</form>
</table>
<script>
 var url = '{$_A.query_url}';
{literal}
function sousuo(){
	var goods = $("#goods").val();
	location.href=url+"&goods="+goods;
}
</script>
{/literal}
{elseif $_A.query_type == "convert_view"}
<div class="module_add">
	<form action="" name="form1" method="post">
	<div class="module_title"><strong>�һ���Ϣ�鿴</strong></div>
	<div class="module_border">
		<div class="l">��Ʒ���ƣ�</div>
		<div class="c">
			<a href="{$_A.query_url}/view&id={$_A.integral_convert_result.integral_id}{$_A.site_url}" target="_blank">{ $_A.integral_convert_result.goods_name}</a>
		</div>
	</div>
	

	<div class="module_border">
		<div class="l">�һ��ˣ�</div>
		<div class="c">
			{ $_A.integral_convert_result.realname}({ $_A.integral_convert_result.username})
		</div>
	</div>
	
	<div class="module_border">
		<div class="l">�һ�������</div>
		<div class="c">
			{ $_A.integral_convert_result.number}
		</div>
	</div>
	
	<div class="module_border">
		<div class="l">�һ���ֵ��</div>
		<div class="c">
			{ $_A.integral_convert_result.need}
		</div>
	</div>
	
	<div class="module_border">
		<div class="l">Ӧ�ۻ��֣�</div>
		<div class="c">
			{ $_A.integral_convert_result.integral}
		</div>
	</div>
	
	<div class="module_border">
		<div class="l">״̬��</div>
		<div class="c">
			{if $_A.integral_convert_result.status!=1}
			<input type="radio" name="status" value="0" checked="checked" />δ�һ� <input type="radio" name="status" value="1" />�Ѷһ� <input type="radio" name="status" value="2" />�رմ˶һ����رպ󽫻Ὣ���ַ��ص��û��Ļ�������ȥ��
			{else}
				�Ѷһ�
			{/if}
		</div>
	</div>
	
	{if $_A.integral_convert_result.status==0}
	<div class="module_border">
		<div class="l">��ע��</div>
		<div class="c">
			<textarea name="remark" cols="50" rows="7">{$_A.integral_convert_result.remark}</textarea>
		</div>
	</div>
	
	<div class="module_submit">
		<input type="hidden" name="id" value="{$_A.integral_convert_result.id}" />
		<input type="submit" value="ȷ��" /> һ��ȷ���������޸�
	</div>
	{else}
	<div class="module_border">
		<div class="l">��ע��</div>
		<div class="c">
			{$_A.integral_convert_result.remark}
		</div>
	</div>
	{/if}
	</form>

</div>
{literal}
<script>
function check_form(){
	 var frm = document.forms['form1'];
	 var remark = frm.elements['remark'].value;
	 var errorMsg = '';
	  if (remark.length == 0 ) {
		errorMsg += '��ע����Ϊ��' + '\n';
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
<table  border="0"  cellspacing="1" bgcolor="#CCCCCC" width="100%">
	<form action="{$_A.query_url}/action{$_A.site_url}" method="post">
	<tr >
		<td class="main_td"><input type="checkbox" name="allcheck" onclick="checkFormAll(this.form)"/></td>
		<td class="main_td">ID</td>
		<td class="main_td">��Ʒ����</td>
		<td class="main_td">�������</td>
		<td class="main_td">����</td>
		<td  class="main_td">�Ѷһ�����</td>
		<td  class="main_td">״̬</td>
		<td  class="main_td">����</td>
		<td class="main_td">����</td>
	</tr>
	{ foreach  from=$_A.integral_list key=key item=item}
	<tr  {if $key%2==1}class="tr2"{/if}>
		<td><input type="checkbox" name="aid[{$key}]" value="{$item.id}"/></td>
		<td>{ $item.id}</td>
		<td>{$item.name}</td>
		<td>{$item.need}</td>
		<td>{ $item.number}</td>
		<td>{ $item.ex_number}</td>
		<td >{ if $item.status ==1}<a href="{$_A.query_url}{$_A.site_url}&status=0&id={ $item.id}">��ʾ</a>{else}<a href="{$_A.query_url}{$_A.site_url}&status=1&id={ $item.id}">����</a>{/if}</td>
		<td >{$item.flagname|default:-}{if $item.litpic!=""}ͼƬ{/if}</td>
		<td><a href="{$_A.query_url}/convert&id={$item.id}">�һ���</a>  <a href="{$_A.query_url}/view&id={$item.id}{$_A.site_url}">�鿴</a> <a href="{$_A.query_url}/edit&id={$item.id}{$_A.site_url}">�༭</a> <a href="#" onClick="javascript:if(confirm('ȷ��Ҫɾ����?ɾ���󽫲��ɻָ�')) location.href='{$_A.query_url}/del&id={$item.id}{$_A.site_url}'">ɾ��</a></td>
	</tr><input type="hidden" name="flag[{$key}]" value="{$item.flag}" />
	{ /foreach}
	<tr>
		<td colspan="9" class="action">
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
		<div class="floatr">
		��Ʒ���ƣ�<input type="text" name="goods" id="goods" value="{$magic.request.goods}"/>
		<input type="button" value="����" onclick="sousuo()" />
		</div>
		</td>
	</tr>
	<tr>
		<td colspan="9" class="page">
		{$_A.showpage}
		</td>
	</tr>
	</form>
</table>
<script>
 var url = '{$_A.query_url}';
{literal}
function sousuo(){
	var goods = $("#goods").val();
	location.href=url+"&goods="+goods;
}
</script>
{/literal}
{/if}