{ if $_A.query_type=="list"}
<table  border="0"  cellspacing="1" bgcolor="#CCCCCC" width="100%">
<form action="" method="post"  >
	<tr >
	  <td class="main_td" width="60">���ID</td>
	  <td width="32%" class="main_td" >�������</td>
	  <td width="*" class="main_td">����</td>
	  <td width="*" class="main_td">����</td>
	   <td class="main_td">����</td>
	</tr>
	{loop module="dwbbs" function="ActionForum" }
	<tr {if $key%2==1}class="tr2"{/if} >
	 <td >{ $var.id}<input type="hidden" name="id[]" value="{ $var.id}" /></td>
	  <td align="left">&nbsp;{$var.porder}<input type="text" name="name[]" value="{ $var.name}" size="10" /> {if $var.norder<3}<a href="{$_A.query_url}/new&pid={$var.id}"><img src="{$tpldir}/images/ico_add.gif" /></a>{/if}</td>
	  <td><a href="{$_A.query_url}/admins&fid={$var.id}">{$var.admins|default:"���ð���"}</a></td>
	  <td><input type="text" name="order[]" value="{ $var.order}" size="5" /></td>
	  <td><a href="{$_A.query_url}/edit&id={$var.id}">�༭</a> <a href="#" onClick="javascript:if(confirm('ȷ��Ҫɾ����?ɾ����ɾ���˰��������ļ�')) location.href='{$_A.query_url}/del&fid={$var.id}'">ɾ��</a> </td>
	</tr>
	{ /loop}
	<tr >
	  <td  colspan="7" class="submit" ><input type="submit" value="ȷ���޸�"  />&nbsp;&nbsp;&nbsp;<input value="��Ӱ��" type="button" onclick="javascript:location='{$_A.query_url}/new';" /></td>
	</tr>
	</form>
</table>
{elseif $_A.query_type == "new" || $_A.query_type == "edit"}

<div class="module_add">

<form action="" method="post" name="form1" onsubmit="return check_form()"  >
{ if $_A.query_type=="edit"}<input type="hidden" value="{ $_A.bbs_forum_result.id}" name="id" />{ /if}
<div class="module_title"><strong>{ if $_A.query_type == "edit" }�༭{else}���{/if}���</strong></div>

<div class="module_border">
	<div class="l">�ϼ����:</div>
	<div class="c">
		<select name="pid">
			<option value="0">��Ŀ¼</option>
			{loop module="dwbbs" function="ActionForum" action="list"}
			<option value="{$var.id}" {if $var.id==$magic.request.pid || $var.id==$_A.bbs_forum_result.pid} selected="selected"{/if}>{$var.aname}</option>
			{/loop}
		</select>
	</div>
</div>
<div class="module_border">
	<div class="l">����</div>
	<div class="c">
		<input type="text" size="5" name="order" value="{$_A.bbs_forum_result.order|default:0}" />
	</div>
</div>
<div class="module_border">
	<div class="l">����/������ƣ�</div>
	<div class="c">
		<input type="text" align="absmiddle" name="name" value="{ $_A.bbs_forum_result.name}"/>���÷���/�������
	</div>
</div>
{if $magic.request.pid>0 || $_A.bbs_forum_result.pid>0}
<div class="module_border">
	<div class="l">���ͼ�꣺</div>
	<div class="c">
			<input type="text" align="absmiddle" name="picurl"  value="{ $_A.bbs_forum_result.picurl}"/>
	</div>
</div>

<div class="module_border">
	<div class="l">������:</div>
	<div class="c">
		<textarea rows="5" cols="40" name="content">{ $_A.bbs_forum_result.content}</textarea>
	</div>
</div>

<div class="module_border">
	<div class="l">������</div>
	<div class="c">
			<textarea rows="5" cols="40" name="rules">{ $_A.bbs_forum_result.rules}</textarea>
	</div>
</div>


<div class="module_border">
	<div class="l">�������:</div>
	<div class="c">
		<input type="radio" name="isverify" value="0" {if $_A.bbs_forum_result.isverify==0  || $_A.bbs_forum_result.isverify==""} checked="checked"{/if} />����Ҫ���    <input type="radio" name="isverify" value="1" {if $_A.bbs_forum_result.isverify==1} checked="checked"{/if} />�������    <input type="radio" name="isverify" value="2" {if $_A.bbs_forum_result.isverify==2} checked="checked"{/if} />�������ͻظ�
	</div>
</div>
{/if}
<div class="module_border">
	<div class="l">�Ƿ�����:</div>
	<div class="c">
			<input type="radio" name="ishidden" value="0" {if $_A.bbs_forum_result.ishidden==0 || $_A.bbs_forum_result.ishidden==""} checked="checked"{/if} />��    <input type="radio" name="ishidden" value="1" {if $_A.bbs_forum_result.ishidden==1 } checked="checked"{/if} />�� 
	</div>
</div>

<div class="module_border">
	<div class="l">��ʾ��ʽ:</div>
	<div class="c">
		<select name="showtype">
			<option value="0" {if $_A.bbs_forum_result.showtype==0 || $_A.bbs_forum_result.showtype==""} selected="selected"{/if} >��ͨ��ʽ</option>
			<option value="1" {if $_A.bbs_forum_result.showtype==1} selected="selected"{/if}>������ʾ</option>
		</select>
		<span>���ø÷����¼��Ӱ�����ʾ��ʽ</span>
	</div>
</div>

<div class="module_border">
	<div class="l">�����ؼ����Ż�:</div>
	<div class="c">
			<textarea rows="5" cols="40" name="keywords">{ $_A.bbs_forum_result.keywords}</textarea>
	</div>
</div>
{if $magic.request.pid>0 || $_A.bbs_forum_result.pid>0}
<div class="module_title"><strong>Ȩ��</strong></div>

<div class="module_border">
	<div class="l">��������:</div>
	<div class="c">
		<input type="text" align="absmiddle" name="forumpass"  value="{ $_A.bbs_forum_result.forumpass}"/>
	</div>
</div>

<div class="module_border">
	<div class="l">��������û�:</div>
	<div class="c">
			<textarea rows="8" cols="20" name="forumusers">{ $_A.bbs_forum_result.forumusers}</textarea>���ÿ��Է��ʸð����û���ÿ����дһ���û���
	</div>
</div>

<div class="module_border">
	<div class="l">��������û���:</div>
	<div class="c">
			<select id=forumgroups style="PADDING-LEFT: 5px; WIDTH: 200px" multiple size=10 name=forumgroups>
			<option value=0>���з���</option>

<optgroup 
label=��ͨ�û���> 

{foreach from="$_A.user_type_list" item="var"}
{if $var.type==0}
<option value={$var.type_id}>{$var.name}</option>
{/if}
{/foreach}
</optgroup>
<optgroup 
label=������>

{foreach from="$_A.user_type_list" item="var"}
{if $var.type==1}
<option value={$var.type_id}>{$var.name}</option>
{/if}
{/foreach}

</optgroup></select>
	</div>
</div>
{/if}
<div class="module_submit">
	<input name="" type="submit" value=" �ύ " /> <input name="" type="reset" value=" ���� " /><input type="hidden" name="style" value="1" />
</div>

</form>
</div>
{literal}
<script>
function setSelect(){
	//alert(1);
}
function check_form(){
var frm = document.forms['form1'];
 var title = frm.elements['name'].value;
 var errorMsg = '';
  if (title.length == 0 ) {
	errorMsg += '�������Ʊ�����д' + '\n';
  }
  var forumgroups=document.getElementById('forumgroups');
	
	
	for(var i=0;i<ts.length;i++){
setSelect("forumgroups",ts[i]);
	}
  
  if (errorMsg.length > 0){
	alert(errorMsg); return false;
  } else{  
	return true;
  }
}
</script>
{/literal}
{ elseif $_A.query_type=="admins"}
<table  border="0"  cellspacing="1" bgcolor="#CCCCCC" width="100%">
	<form action="" method="post"  >
	<tr >
	  <td class="main_td" width="10%">ɾ��</td>
	  <td class="main_td"  width="20%">��ʾ˳��</td>
	  <td class="main_td" width="30%">�����û���</td>
	  <td width="*" class="main_td">�Ƿ��ϼ����</td>
	</tr>
	{foreach from="$_A.admins_list" item="item"  }
	<tr {if $key%2==1}class="tr2"{/if} >
	 <td >{if $item.isup==1}-{else}<input type="checkbox" value="" name="admins[{$key}][delid]" />{/if}</td>
	  <td>{if $item.isup==1}{$key}{else}<input type="text" value="{$key}" name="admins[{$key}][order]" size="4" />{/if}</td>
	  <td>{if $item.isup==1}{$item.name}{else}<input type="text" value="{$item.name}" name="admins[{$key}][name]" size="10" />{/if}</td>
	  <td>{if $item.isup==1}��{else}��{/if}</td>
	  
	</tr>
	{ /foreach}
</table>
	<div id="adminsdiv" style="border-top:1px solid #CCCCCC; ">
	<table  border="0"  cellspacing="1" bgcolor="#CCCCCC" width="100%">
	<tr >
	<td colspan="4" align="left" style="border-bottom:1px dashed #CCCCCC">&nbsp;&nbsp;<strong>��Ӱ���</strong>
	</td>
	</tr>
	<tr class="tr2">
	<td width="10%">-</td>
	  <td width="20%"><input type="text" value="" name="admins[{$key+1}][order]" size="4" /></td>
	  <td width="30%"><input type="text" value="" name="admins[{$key+1}][name]" size="10" /></td>
	  <td>��</td>  
	</tr>
	</table>
	</div>
<table  border="0"  cellspacing="1" bgcolor="#CCCCCC" width="100%">
	<tr >
	  <td  colspan="7" class="submit" ><input type="submit" value="ȷ���޸�"  />&nbsp;&nbsp;&nbsp;<input value="��Ӱ���" type="button" onclick="javascript:addAdmins('','','',false);" /></td>
	</tr>
	</form>
</table>


<script>
var maxIndex={$key+2};
{literal}
function addAdmins(adminid, ordernum, adminname, isparent){
	var namepre='admins';
	var checkboxstr='';
	var parstr='';
	var orderstr='';
	var namestr='';
	if(adminid==''){
		namepre='newadmins';
	}
	if(isparent){
		namestr=adminname;
		checkboxstr='<input type="checkbox" disabled="true" class="checkbox_css" />';
		orderstr='&nbsp;';
		parstr='<span style="color:#666666;">��</span>';
	}else{
		if(adminname!=""){
namestr=adminname+"<input type='hidden' value='"+adminname+"' size='10' name='admins["+maxIndex+"][name]' />";
		}else{
namestr="<input type='text' value='"+adminname+"' size='10' name='admins["+maxIndex+"][name]' class=\"text_css\" />";
		}
		//checkboxstr='<input type="checkbox" value="1" name="admins['+maxIndex+'][delid]" class="checkbox_css" />';
		checkboxstr = '-';
		orderstr='<input type="text" size="4" value="'+ordernum+'" name="admins['+maxIndex+'][order]" class=\"text_css\" />';
		parstr='��';
	}
	var trclass = "";
	if (maxIndex%2==1){
		 trclass = "class='tr2'";
	}
	var s="<table  border=0  cellspacing=0 bgcolor=\"#CCCCCC\" width=\"100%\"><tr "+trclass+"><td width='10%'><div class=\"rowdiv_0\" style=\"width:50px;\">"+checkboxstr+"</div></td><td width='20%'><div class=\"rowdiv_0\" style=\"width:80px;\">"+orderstr+"</div></td><td width='30%'><div class=\"rowdiv_0\" style=\"width:200px;\">"+namestr+"</div></td><td ><div class=\"rowdiv_0\" style=\"width:180px;\">"+parstr+"</div></td></tr></table>";
	var ele=document.createElement('div');
	ele.id="group_div_"+maxIndex;
	ele.innerHTML=s;
	E("adminsdiv").appendChild(ele);
	maxIndex++;
}
</script>
{/literal}
{ elseif $_A.query_type=="merge"}
<form action="" method="post">
<div class="module_title"><strong>���ϲ�</strong></div>

<div class="module_border">
	<div class="l">Դ���:</div>
	<div class="c">
		<select name="fromfid">
			{loop module="dwbbs" function="ActionForum" action="list"}
			<option value="{$var.id}" {if $var.id==$magic.request.pid || $var.id==$_A.bbs_forum_result.pid} selected="selected"{/if}>{$var.aname}</option>
			{/loop}
		</select> 
 Դ��������ȫ��ת��Ŀ���飬ͬʱɾ��Դ��� 

	</div>
</div>


<div class="module_border">
	<div class="l">Ŀ����:</div>
	<div class="c">
		<select name="tofid">
			{loop module="dwbbs" function="ActionForum" action="list"}
			<option value="{$var.id}" {if $var.id==$magic.request.pid || $var.id==$_A.bbs_forum_result.pid} selected="selected"{/if}>{$var.aname}</option>
			{/loop}
		</select>
	</div>
</div>

<div class="module_submit">
	<input name="" type="submit" value=" �ύ " /> <input name="" type="reset" value=" ���� " /><input type="hidden" name="style" value="1" />
</div>

</form>
{/if}