{ if $_A.query_type=="list"}
<table  border="0"  cellspacing="1" bgcolor="#CCCCCC" width="100%">
<form action="" method="post"  >
	<tr >
	  <td width="32%" class="main_td" >��������</td>
	  <td width="*" class="main_td">����ֵ</td>
	  <td width="22%" class="main_td">������</td>
	   <td width="12%" class="main_td">�༭</td>
	</tr>
	{ foreach from=$_A.system_list key=key item=item}
	<tr {if $key%2==1}class="tr2"{/if} >
	  <td   class="main_td1" >{ $item.name}</td>
	  <td align="left" class="main_td1" >
	  { if $item.type==0}
		<input type="text" value="{ $item.value|br2nl}" name="value[{ $item.nid}]"/>
	  { elseif $item.type==2}
	  <textarea name="value[{ $item.nid}]" cols="30" rows="4">{ $item.value|br2nl}</textarea>
	  { elseif $item.type==3} 
	  <input  name="value[{ $item.nid}]" value="{ $item.value|br2nl}" size="15"> <INPUT onclick="uploadImg('value[{ $item.nid}]');" type=button value=�ϴ�ͼƬ...>
	  { else}
	  <input type="radio" name="value[{ $item.nid}]" value="1" { if $item.value==1} checked="checked"{ /if} /> �� <input type="radio" name="value[{ $item.nid}]"  value="0"  { if $item.value==0} checked="checked"{ /if}/> ��
	  { /if}
	  </td>
	  <td class="main_td1" > &nbsp;{ $item.nid}</td>
	   <td class="main_td1" >{ if $item.status ==1}<a href="{$_A.query_url}/edit&id={$item.id}">�޸�</a> / <a href=" {$url}/del&id={$item.id}">ɾ��</a>{ else} - {/if}</td>
	</tr>
	{ /foreach}
	<tr >
	  <td  colspan="7" class="submit" ><input type="submit" value="ȷ���޸�"  />&nbsp;&nbsp;&nbsp;<input value="��Ӳ���" type="button" onclick="javascript:location='{$_A.query_url}/new';" /></td>
	</tr>
	</form>
</table>
{elseif $_A.query_type == "new" || $_A.query_type == "edit"}

<div class="module_add">

<form action="" method="post" name="form1" onsubmit="return check_form()"  >
{ if $_A.query_type=="edit"}<input type="hidden" value="{ $_A.system_result.id}" name="id" />{ /if}
<div class="module_title"><strong>{ if $_A.query_type == "edit" }�༭{else}���{/if}����</strong></div>


<div class="module_border">
<div class="l">�� �� �� �ƣ�</div>
<div class="c">
	<input type="text" align="absmiddle" name="name" value="{ $_A.system_result.name}"/>
</div>
</div>
<div class="module_border">
		<div class="l">��������</div>
		<div class="c">
			<input type="text" align="absmiddle" name="nid"  value="{ $_A.system_result.nid}"/>����ǰ���con_
</div>
</div>
<div class="module_border">
		<div class="l">�������ͣ�</div>
		<div class="c">
			
<input type="radio" value="0" name="type" checked="checked" onclick="change(0)" { if $_A.system_result.type==0} checked="checked"{ /if}/> �ı�/���� 
<input type="radio" value="1" name="type" onclick="change(1)" { if $_A.system_result.type==1} checked="checked"{ /if}/> ������Y/N��
<input type="radio" value="2" name="type" onclick="change(0)" { if $_A.system_result.type==2} checked="checked"{ /if}/> ����
<input type="radio" value="3" name="type" onclick="change(0)" { if $_A.system_result.type==3} checked="checked"{ /if}/>ͼƬ
</div>
</div>
<div class="module_border">
		<div class="l">����ֵ��</div>
		<div class="c">
			<div id="text_v" { if $_A.system_result.type==1 }style="display:none" { /if} align="left" >
		<input type="text" align="absmiddle" name="value1"  value="{ $_A.system_result.value}"/>
	</div>
	<div id="option_v" { if $_A.system_result.type==0 || $_A.system_result.type==3}style="display:none" { /if}>
		<input type="radio" value="1" name="value2" checked="checked" { if $_A.system_result.value==1} checked="checked"{ /if}/> ��
		<input type="radio" value="0" name="value2" { if $_A.system_result.value==0} checked="checked"{ /if}/> �� 
	</div>
</div>
</div>
<div class="module_border">
		<div class="l">״̬��</div>
		<div class="c">
			<input type="radio" value="0" name="status" checked="checked"  { if $_A.system_result.status==0} checked="checked"{ /if}/> ϵͳ <input type="radio" value="1" name="status" { if $_A.system_result.status==1 || $_A.system_result.status==""} checked="checked"{ /if}/> �Զ���
</div>
</div>

<div class="module_submit">
<input name="" type="submit" value=" �ύ " /> <input name="" type="reset" value=" ���� " /><input type="hidden" name="style" value="1" />

</div>
</form>
</div>
{literal}
<script>
function change(val){
if (val==0){
	document.getElementById("text_v").style.display ="";
	document.getElementById("option_v").style.display ="none";
}else{
	document.getElementById("text_v").style.display ="none";
	document.getElementById("option_v").style.display ="";
}
}
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
{/if}