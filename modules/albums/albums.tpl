{if $_A.query_type == "new" || $_A.query_type == "edit"}
<div class="module_add">
	<form name="form1" method="post" action="" onsubmit="return check_form();" enctype="multipart/form-data">
	<div class="module_title"><strong>{ if $_A.query_type == "edit" }�༭{else}���{/if}����</strong></div>
	
	<div class="module_border">
		<div class="l">���ƣ�</div>
		<div class="c">
			<input type="text" name="name"  class="input_border" value="{ $_A.albums_result.name}" size="30" /> 
		</div>
	</div>
	
	<div class="module_border">
		<div class="l">������Ŀ��</div>
		<div class="c">
			<select name="site_id"><option value="0">Ĭ������</option>{foreach from=$_A.site_code_list item=item key=key}
<option value="{ $item.site_id}" {if $_A.albums_result.site_id == $item.site_id} selected="selected"{/if} >-{$item.name}</option>
{ /foreach}</select></div>
		</div>
	</div>
	
	<div class="module_border">
		<div class="l">�������ԣ�</div>
		<div class="c">
		{$_A.albums_result.flag|flag:"input" }		
		</div>
	</div>
	
	<div class="module_border">
		<div class="l">״̬��</div>
		<div class="c">
			<input type="radio" name="status" value="0"  { if $_A.albums_result.status == 0 }checked="checked"{/if}/>���� <input type="radio" name="status" value="1"  { if $_A.albums_result.status ==1 ||$_A.albums_result.status ==""}checked="checked"{/if}/>��ʾ 
		</div>
	</div>
	
	<div class="module_border">
		<div class="l">����:</div>
		<div class="c">
			<input type="text" name="order"  class="input_border" value="{ $_A.albums_result.order|default:10}" size="10" />
		</div>
	</div>
	
	<div class="module_border">
		<div class="l">����ͼ��</div>
		<div class="c">
			<input type="file" name="litpic" size="30" class="input_border"/>{if $_A.albums_result.litpic!=""}<a href="./{$_A.albums_result.litpic}" target="_blank" title="��ͼƬ"><img src="{ $tpldir }/images/ico_1.jpg" border="0"  /></a><input type="checkbox" name="clearlitpic" value="1" />ȥ������ͼ{/if}
		</div>
	</div>
	<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,19,0" width="700" height="500">
  <param name="movie" value="/plugins/swfupload/swfupload.swf?config=/index.php%3fplugins%26ac=swfupload%26code=albums" />
  <param name="quality" value="high" />
  <embed src="/plugins/swfupload/swfupload.swf?config=/index.php%3fplugins%26ac=swfupload%26code=albums" quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" width="700" height="500"></embed>
</object>
	
	
	<div class="module_submit" >
		{ if $_A.query_type == "edit" }<input type="hidden" name="id" value="{ $_A.albums_result.id }" />{/if}
		<input type="submit"  name="submit" value="ȷ���ύ" />
		<input type="reset"  name="reset" value="���ñ�" />
	</div>
</div>
</form>
{literal}
<script>
function check_form(){
	 var frm = document.forms['form1'];
	 var title = frm.elements['name'].value;
	  var litpic = frm.elements['litpic'].value;
	    var pics = frm.elements['pics[1]'].value;
	 var errorMsg = '';
	  if (title.length == 0 ) {
		errorMsg += '���������д' + '\n';
	  }
	  /*
	    if (litpic.length == 0 ) {
		errorMsg += '����ͼ������д' + '\n';
	  }
	    if (pics.length == 0 ) {
		errorMsg += 'ͼƬ������д' + '\n';
	  }
	  */
	  if (errorMsg.length > 0){
		alert(errorMsg); return false;
	  } else{  
		return true;
	  }
}

</script>
{/literal}
{elseif $_A.query_type == "view"}

{else}
<table  border="0"  cellspacing="1" bgcolor="#CCCCCC" width="100%">
		<form action="{$_A.query_url}/action{$_A.site_url}" method="post">
		<tr >
			<td width="" class="main_td"><input type="checkbox" name="allcheck" onclick="checkFormAll(this.form)"/></td>
			<td width="" class="main_td">ID</td>
			<td width="*" class="main_td">����</td>
			<td width="*" class="main_td">����</td>
			<td width="" class="main_td">״̬</td>
			<td width="" class="main_td">����</td>
			<td width="" class="main_td">����</td>
			<td width="" class="main_td">����</td>
		</tr>
		{ foreach  from=$_A.albums_list key=key item=item}
		<tr  {if $key%2==1}class="tr2"{/if}>
			<td ><input type="checkbox" name="aid[{$key}]" value="{$item.id}"/></td>
			<td >{ $item.id}</td>
			<td  align="center">{$item.name|truncate:34}</td>
			<td  align="center">{$item.site_name}</td>
			<td  >{ if $item.status ==1}<a href="{$_A.query_url}{$_A.site_url}&status=0&id={ $item.id}">��ʾ</a>{else}<a href="{$_A.query_url}{$_A.site_url}&status=1&id={ $item.id}">����</a>{/if}</td>
			<td  ><input type="text" name="order[{$key}]" value="{$item.order}" size="3" /><input type="hidden" name="id[{$key}]" value="{$item.id}" /></td>
			<td  >{$item.flagname|default:-}{if $item.litpic!=""}ͼƬ{/if}</td>
			<td ><a href="{$_A.query_url}/edit{$_A.site_url}&id={$item.id}" >�޸�</a> <a href="#" onClick="javascript:if(confirm('ȷ��Ҫɾ����?ɾ���󽫲��ɻָ�')) location.href='{$_A.query_url}/del{$_A.site_url}&id={$item.id}'">ɾ��</a></td>
		</tr><input type="hidden" name="flag[{$key}]" value="{$item.flag}" />
		{ /foreach}
		<tr>
			<td colspan="8" class="action">
			<div class="floatl"><select name="type">
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
				�ؼ��֣�<input type="text" name="keywords" id="keywords" value="{$magic.request.keywords}"/> <input type="button" value="����" / onclick="sousuo()">
			</div>
			</td>
		</tr>
		</form>	
		<tr>
			<td colspan="8" class="page"  >
			{$_A.showpage}
			</td>
		</tr>
		<script>
	  var url = '{$_A.query_url}';
	    {literal}
	  	function sousuo(){
			var username = $("#username").val();
			var keywords = $("#keywords").val();
			location.href=url+"&keywords="+keywords;
		}
	  
	  </script>
	  {/literal}
</table>
{/if}