<!--�����б� ��ʼ-->
{ if $_A.query_type=="list"}
<table  border="0"  cellspacing="1" bgcolor="#CCCCCC" width="100%">
<form action="" method="post"  >
	<tr >
	  <td width="" class="main_td"><input type="checkbox" name="allcheck" onclick="checkFormAll(this.form)"/></td>
	  <td width="32%" class="main_td" >���ӱ���</td>
	  <td width="*" class="main_td">���</td>
	  <td width="*" class="main_td">����</td>
	  <td width="*" class="main_td">����ʱ��</td>
	   <td class="main_td">����</td>
	</tr>
	{list module="dwbbs" function="GetTopicsList" var="loop" showpage="3" status=1}
	{foreach from="$loop.list" item="var"}
	<tr {if $key%2==1}class="tr2"{/if} >
	 <td class="main_td1" align="center" ><input type="checkbox" name="aid[]" id="aid[]" value="{$item.id}"/></td>
	  <td >{$var.name}</td>
	  <td >{$var.forum_name}</td>
	  <td>{$var.username}</td>
	  <td align="left">{$var.addtime|date_format:"Y-m-d H:i:s"}</td>
	   <td  ><a href="{$_A.query_url}/edit&id={$var.id}">�༭</a> <a href="{$_A.query_url}/del&id={$var.id}">ɾ��</a>  Ȩ�� </td>
	</tr>
	{ /foreach}
	<tr>
			<td colspan="8"  class="action" >
			<div class="floatl"><select onchange="changeAction()" id="postaction" name="postaction">
		<option value="NOTHING">��ѡ�����</option>
		<optgroup label="----------------">
<option value="movePost">�ƶ������</option>
<option value="delPost">ɾ��</option>
<option value="upPost">����</option>
<option value="stampPost">����</option>
<option value="highlightPost">����</option>
		</optgroup>
		<optgroup label="----------------">
<option value="coverPost">������������</option>
<option value="coverPost_">�������</option>
		</optgroup>
		<optgroup label="----------------">
<option value="lockPost">��������</option>
<option value="lockPost_">��������</option>
		</optgroup>
		<optgroup label="----------------">
<option value="topPost">�ö�</option>
<option value="topPost_">����ö�</option>
		</optgroup>
		<optgroup label="----------------">
<option value="alltopPost">���ö�</option>
<option value="alltopPost_">������ö�</option>
		</optgroup>
		<optgroup label="----------------">
<option value="goodPost">����Ϊ����</option>
<option value="goodPost_">ȡ������</option>
		</optgroup>
	</select>
	<select name="movetofid" id="movetofid" style="display:none;">
		{loop module="dwbbs" function="ActionForum" action="list"}
			<option value="{$var.id}" {if $var.id==$magic.request.pid || $var.id==$_A.bbs_forum_result.pid} selected="selected"{/if}>{$var.aname}</option>
			{/loop}
	</select>
	<select name="stampid" id="stampid" style="display:none;"><option value="0">ȡ������</option><option value="1">����1</option><option value="2">����2</option></select>
	<span id="highlightopt" style="display:none;">
		<input type="text" class="text_css" size="8" style="" value="" id="highlightcolor" name="highlightfontC" onfocus="colorpicker.choose(event);" /> <img src="../images/ico_color.gif" align="absmiddle" border="0" id="img_color" class="colorpicker" onclick="colorpicker.choose(event);" /> &nbsp; 
		<input type="checkbox" value="1" name="highlightfontB[]" id="highlightfontB" class="checkbox_css" /> <b>B</b>
		<input type="checkbox" value="1" name="highlightfontI[]" id="highlightfontI" class="checkbox_css" /> <i>I</i> 
		<input type="checkbox" value="1" name="highlightfontU[]" id="highlightfontU" class="checkbox_css" /> <u>U</u>
	</span> <input type="submit" value="ȷ�ϲ���" /> 
			</div>
			<div class="floatr">
			
			</div>
			</td>
		</tr>
	<tr>
			<td colspan="8" class="page">
			{$loop.showpage} 
			</td>
		</tr>
	<tr >
	  <td  colspan="7" class="submit" ><input type="submit" value="ȷ���޸�"  />&nbsp;&nbsp;&nbsp;<input value="��Ӱ��" type="button" onclick="javascript:location='{$_A.query_url}/new';" /></td>
	</tr>
	{/list}
	</form>
</table>

{literal}
<script>
function changeAction(){
	var d = $("#postaction").val();
	setDisplay("movetofid",d=="movePost");
	setDisplay("stampid",d=="stampPost");
	setDisplay("highlightopt",d=="highlightPost");
}
</script>
{/literal}
<!--�����б� ����-->

<!--������� ��ʼ-->
{ elseif $_A.query_type=="verify"}
<table  border="0"  cellspacing="1" bgcolor="#CCCCCC" width="100%">
<form action="" method="post"  >
	<tr >
	  <td width="" class="main_td">����</td>
	  <td width="*" class="main_td">���/����/ʱ��</td>
	  <td class="main_td">����</td>
	  <td class="main_td">����</td>
	</tr>
	{list module="dwbbs" function="GetTopicsList" var="loop" showpage="3" status=0}
	{foreach from="$loop.list" item="var" key="_key"}
	<tr {if $key%2==1}class="tr2"{/if} >
	 <td class="main_td1" align="center" >
	 	<input type="radio" name="status[{$_key}]" value="0"  />����<br />
		<input type="radio" name="status[{$_key}]" value="1" checked="checked"  />ͨ��<br />
		<input type="radio" name="status[{$_key}]" value="2"  />ɾ��<br />
	 </td>
	  <td style="padding-left:10px;" align="left">��飺{$var.name}<br />����: admin
<br />ʱ��: 4����ǰ 
<br />
</td>
	  <td >{$var.name}<input type="hidden" name="tid[{$_key}]" value="{$var.id}" /></td>
	  <td width="320"><div style="width:300px; height:70px; overflow:auto; margin:5px;">{$var.content}</div></td>
	</tr>
	{ /foreach}
	<tr >
	  <td  colspan="7" class="submit" ><input type="submit" value="ȷ���޸�"  /></td>
	</tr>
</form>
</table>
<!--������� ����-->	
	
	
<!--�����б� ��ʼ-->
{ elseif $_A.query_type=="recycle"}
<table  border="0"  cellspacing="1" bgcolor="#CCCCCC" width="100%">
<form action="" method="post"  >
	<tr >
	  <td width="" class="main_td"><input type="checkbox" name="allcheck" onclick="checkFormAll(this.form)"/></td>
	  <td width="32%" class="main_td" >���ӱ���</td>
	  <td width="*" class="main_td">���</td>
	  <td width="*" class="main_td">����</td>
	  <td width="*" class="main_td">����ʱ��</td>
	   <td class="main_td">����</td>
	</tr>
	{list module="dwbbs" function="GetTopicsList" var="loop" showpage="3"}
	{foreach from="$loop.list" item="var"}
	<tr {if $key%2==1}class="tr2"{/if} >
	 <td class="main_td1" align="center" ><input type="checkbox" name="aid[]" id="aid[]" value="{$item.id}"/></td>
	  <td >{$var.name}</td>
	  <td >{$var.forum_name}</td>
	  <td>{$var.username}</td>
	  <td align="left">{$var.addtime|date_format:"Y-m-d H:i:s"}</td>
	   <td  > <a href="{$_A.query_url}/del&id={$var.id}">ɾ��</a>   </td>
	</tr>
	{ /foreach}
	<tr>
			<td colspan="8"  class="action" >
			<div class="floatl"><select onchange="changeAction()" id="postaction" name="postaction">
		<option value="NOTHING">��ѡ�����</option>
		
		</select>
	<input type="submit" value="ȷ�ϲ���" /> 
			</div>
			<div class="floatr">
			
			</div>
			</td>
		</tr>
	<tr>
			<td colspan="8" class="page">
			{$loop.showpage} 
			</td>
		</tr>
	{/list}
	</form>
</table>

{elseif $_A.query_type == "new" || $_A.query_type == "edit"}

<div class="module_add">

<form action="" method="post" name="form1" onsubmit="return check_form()"  >
{ if $_A.query_type=="edit"}<input type="hidden" value="{ $_A.bbs_forum_result.id}" name="id" />{ /if}
<div class="module_title"><strong>{ if $_A.query_type == "edit" }�༭{else}���{/if}����</strong></div>



<div class="module_border">
	<div class="l">���ӱ��⣺</div>
	<div class="c">
		<input type="text" align="absmiddle" name="name" value="{ $_A.bbs_topics_result.name}"/>
	</div>
</div>

<div class="module_border">
	<div class="l">�������ݽ���:</div>
	<div class="c">
		<textarea rows="5" cols="40" name="content">{ $_A.bbs_topics_result.content}</textarea>
	</div>
</div>


<div class="module_border">
	<div class="l">�Ƿ�����:</div>
	<div class="c">
			<input type="radio" name="status" value="0" {if $_A.bbs_topics_result.status==0 || $_A.bbs_topics_result.status==""} checked="checked"{/if} />��    <input type="radio" name="status" value="1" {if $_A.bbs_topics_result.status==1 } checked="checked"{/if} />�� 
	</div>
</div>



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
	
	alert(ts.length);
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
{/if}