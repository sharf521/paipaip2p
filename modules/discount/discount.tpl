{if $_A.query_type == "new" || $_A.query_type == "edit"}
<div class="module_add">
	
	<form name="form1" method="post" action="" onsubmit="return check_form();" enctype="multipart/form-data">
	<div class="module_title"><strong>{ if $_A.query_type == "edit" }�༭{else}���{/if}�ۿ�</strong></div>
	
	<div class="module_border">
		<div class="l">�̼����ƣ�</div>
		<div class="c">
			<select name="company_id">
			{foreach from="$_A.discount_company_list" item="item"}
				<option value="{$item.id}" {if $item.id==$_A.discount_result.id} selected="selected"{/if}>{$item.name}</option>
			{/foreach}
			</select> <a href="{$_A.query_url}/company_new{$_A.site_url}">����̼�</a>
		</div>
	</div>
	
	<div class="module_border">
		<div class="l">����ͼ��</div>
		<div class="c">
			<input type="file" name="litpic" size="30" class="input_border"/>{if $_A.discount_result.litpic!=""}<a href="./{$_A.discount_result.litpic}" target="_blank" title="��ͼƬ"><img src="{ $tpldir }/images/ico_1.jpg" border="0"  /></a><input type="checkbox" name="clearpic" value="1" />ȥ������ͼ{/if}
		</div>
	</div>
	
	<div class="module_border">
		<div class="l">��ַ��</div>
		<div class="c">
			<input type="text" name="address"  class="input_border" value="{ $_A.discount_result.address}" size="30"  />
		</div>
	</div>
	
	<div class="module_border">
		<div class="l">���ࣺ</div>
		<div class="c">
			<input type="text" name="type" id="type"  class="input_border" value="{ $_A.discount_result.type}" size="30"/><script src="/plugins/index.php?q=liandong&name=types&nid=zhekou_type&id=type"></script>
		</div>
	</div>
	
	<div class="module_border">
		<div class="l">��Ȧ��</div>
		<div class="c">
			<input type="text" name="business_district"  class="input_border" value="{ $_A.discount_result.business_district}" size="30"  />
		</div>
	</div>
	
	
	
	<div class="module_border">
		<div class="l">���⣺</div>
		<div class="c">
			<input type="text" name="name"  class="input_border" value="{ $_A.discount_result.name}" size="30"  />
		</div>
	</div>
	
	<div class="module_border">
		<div class="l">���У�</div>
		<div class="c">
			<script src="./plugins/index.php?&q=area&area={$_A.discount_result.area}" type='text/javascript' language="javascript"></script>
		</div>
	</div>
	
	
	<div class="module_border">
		<div class="l">��ǩ��</div>
		<div class="c">
			<input type="text" name="tag"  class="input_border" value="{ $_A.discount_result.tag}" size="30"  />
		</div>
	</div>
	
	<div class="module_border">
		<div class="l">��ʼʱ�䣺</div>
		<div class="c">
			<script src="./plugins/index.php?&q=protime&name=start_date&type=y,m,d&time={$_A.discount_result.start_date}" type='text/javascript' language="javascript"></script>
		</div>
	</div>
	
	<div class="module_border">
		<div class="l">����ʱ�䣺</div>
		<div class="c">
			<script src="./plugins/index.php?&q=protime&name=end_date&type=y,m,d&time={$_A.discount_result.end_date}" type='text/javascript' language="javascript"></script>
		</div>
	</div>
	
	<div class="module_border">
		<div class="l">�����ߣ�</div>
		<div class="c">
			<input type="text" name="post_user"  class="input_border" value="{ $_A.discount_result.post_user}" size="30"  />
		</div>
	</div>
	
	<div class="module_border">
		<div class="l">״̬��</div>
		<div class="c">
			<input type="radio" name="status" value="0"  { if $_A.discount_result.status == 0 }checked="checked"{/if}/>���� <input type="radio" name="status" value="1"  { if $_A.discount_result.status ==1 ||$_A.discount_result.status ==""}checked="checked"{/if}/>��ʾ
		</div>
	</div>
	
	<div class="module_border">
		<div class="l">���ݣ�</div>
		<div class="c">
			{editor name="comment" type="sinaeditor" value="$_A.discount_result.comment"}
		</div>
	</div>
	
	<div class="module_submit" >
		{ if $_A.query_type == "edit" }<input type="hidden" name="id" value="{ $_A.discount_result.id }" size="30"  />{/if}
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
	 var errorMsg = '';
	  if (title.length == 0 ) {
		errorMsg += '���������д' + '\n';
	  }
	  if (errorMsg.length > 0){
		alert(errorMsg); return false;
	  } else{
		return true;
	  }
}

</script>
{/literal}
{elseif $_A.query_type=="company"}
<table  border="0"  cellspacing="1" bgcolor="#CCCCCC" width="100%">
	<form action="{$_A.query_url}/action{$_A.site_url}" method="post">
	<tr >
		<td class="main_td">ID</td>
		<td class="main_td">�̼�����</td>
		<td class="main_td">�Ż�����</td>
		<td  class="main_td">��ϵ��</td>
		<td  class="main_td">��ϵ�绰</td>
		<td class="main_td">����</td>
	</tr>
	{ foreach  from=$_A.discount_company_list key=key item=item}
	<tr  {if $key%2==1}class="tr2"{/if}>
		<td class="main_td1" align="center">{ $item.id}</td>
		<td class="main_td1" align="center">{$item.name}</td>
		<td class="main_td1" align="center">{$item.type}</td>
		<td class="main_td1" align="center">{ $item.linkman}</td>
		<td class="main_td1" align="center">{$item.tel}</td>
		<td class="main_td1" align="center"><a href="{$_A.query_url}/company_edit&id={$item.id}">�༭</a> | <a href="#" onClick="javascript:if(confirm('ȷ��Ҫɾ����?ɾ���󽫲��ɻָ�')) location.href='{$_A.query_url}/company_del{$_A.site_url}&id={$item.id}'">ɾ��</a></td>
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
{elseif $_A.query_type == "company_new" || $_A.query_type == "company_edit"}
<div class="module_add">
	
	<form name="form1" method="post" action="" onsubmit="return check_form();" enctype="multipart/form-data">
	<div class="module_title"><strong>{ if $_A.query_type == "edit" }�༭{else}���{/if}�ۿ��̼�</strong></div>
	
	<div class="module_border">
		<div class="l">�̼����ƣ�</div>
		<div class="c">
			<input type="text" name="name"  id="name"  class="input_border" value="{ $_A.discount_company_result.name}" />
		</div>
	</div>
	
	<div class="module_border">
		<div class="l">���Ʒ��</div>
		<div class="c">
			<input type="text" name="goods"  class="input_border" value="{ $_A.discount_company_result.goods}" />
		</div>
	</div>
	
	<div class="module_border">
		<div class="l">�Ż����ͣ�</div>
		<div class="c">
			<input type="text" name="type"  id="type"  class="input_border" value="{ $_A.discount_company_result.type}" /><script src="/plugins/index.php?q=liandong&name=types&nid=discount_type&id=type"></script>
		</div>
	</div>
	
	<div class="module_border">
		<div class="l">��ϵ�ˣ�</div>
		<div class="c">
			<input type="text" name="linkman"  class="input_border" value="{ $_A.discount_company_result.linkman}" />
		</div>
	</div>
	
	<div class="module_border">
		<div class="l">��ϵ�绰 ��</div>
		<div class="c">
			<input type="text" name="tel"  class="input_border" value="{ $_A.discount_company_result.tel}" />
		</div>
	</div>
	
	<div class="module_border">
		<div class="l">���ݣ�</div>
		<div class="c">
			{editor name="content" type="sinaeditor" value="$_A.discount_company_result.content"}
		</div>
	</div>
	
	<div class="module_submit" >
		{ if $_A.query_type == "company_edit" }<input type="hidden" name="id" value="{ $_A.discount_company_result.id }" />{/if}
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
	 var errorMsg = '';
	  if (title.length == 0 ) {
		errorMsg += '���������д' + '\n';
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
		<td  class="main_td">ID</td>
		<td class="main_td">�̼�</td>
		<td class="main_td">�ۿ۱���</td>
		<td class="main_td">�Ż�����</td>
		<td class="main_td">��ʼ����</td>
		<td class="main_td">��������</td>
		<td class="main_td">״̬</td>
		<td class="main_td">����</td>
	</tr>
	{ foreach  from=$_A.discount_list key=key item=item}
	<tr {if $key%2==1} class="tr2"{/if}>
		<td class="main_td1" align="center"><input type="checkbox" name="aid[{$key}]" value="{$item.id}"/></td>
		<td class="main_td1" align="center">{ $item.id}</td>
		<td class="main_td1" align="center">{$item.company_name}</td>
		<td class="main_td1" align="center">{$item.name}</td>
		<td class="main_td1" align="center">{ $item.type}</td>
		<td class="main_td1" align="center">{ $item.start_date|date_format 'Y-m-d'}</td>
		<td class="main_td1" align="center">{ $item.end_date|date_format 'Y-m-d'}</td>
		<td class="main_td1" align="center" width="50">{ if $item.status ==1}<a href="{$_A.query_url}{$_A.site_url}&status=0&id={ $item.id}">��ʾ</a>{else}<a href="{$_A.query_url}{$_A.site_url}&status=1&id={ $item.id}">����</a>{/if}</td>
		<td class="main_td1" align="center"><a href="{$_A.query_url}/edit&id={$item.id}{$_A.site_url}">�༭</a>|<a href="#" onClick="javascript:if(confirm('ȷ��Ҫɾ����?ɾ���󽫲��ɻָ�')) location.href='{$_A.query_url}/del&id={$item.id}{$_A.site_url}'">ɾ��</a></td>
	</tr><input type="hidden" name="flag[{$key}]" value="{$item.flag}" />
	{ /foreach}
	<tr>
		<td colspan="9" class="action" >
		<div class="floatl">&nbsp;&nbsp; <select name="type">
		<option value="6">ɾ��</option>&nbsp;&nbsp;&nbsp;
		</select> <input type="submit" value="ȷ�ϲ���" /> ������ȫѡ
		</div><div class="floatr">
	
		�̼ң�<input type="text" name="shop" id="shop" value="{$magic.request.shop}"/>
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
			var shop = $("#shop").val();
			location.href=url+"&shop="+shop;
		}

	  </script>
	  {/literal}
{/if}