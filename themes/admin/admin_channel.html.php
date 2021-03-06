<?php
!defined('IN_TEMPLATE') && exit('Access Denied');
?>
{if $_A.query_class=="new" || $_A.query_class=="edit"}
<div class="module_add">

	<form action="{if $_A.query_class=="new" && $result.code!=""}{ $query_site}&q=module/{$result.code}/install{else}{ $url}/{ if $_A.query_class=="new"}add{ else}update{ /if}{ /if}" method="post" name="form1" onsubmit="return check_form();" >
	<div class="module_title"><strong>{ if $_A.query_class == "edit" }编辑{else}添加{/if}模块</strong></div>
	
	<div class="module_border">
		<div class="l">模块名称：</div>
		<div class="c">
			<input type="text" class="input_border" align="absmiddle" name="name" value="{ $result.name}" />
		</div>
	</div>
	
	<div class="module_border">
		<div class="l">识别ID（code）：</div>
		<div class="c">
			{ if $_A.query_class=="edit" || ($_A.query_class=="new" && $result.code!="")}{ $result.code}<input type="hidden" name="code" value="{ $result.code}" />{ else}
			<input type="text" align="absmiddle" name="code" value="" class="input_border" onkeyup="value=value.replace(/[^a-z_]/g,'')" />{ /if}
		</div>
	</div>
	
	<div class="module_border">
		<div class="l">类型：</div>
		<div class="c">
			{ $result.type|default:'cms'}<input type="hidden" name="type" value="{ $result.type|default:'cms'}" />
		</div>
	</div>
	
	<div class="module_border">
		<div class="l">排序：</div>
		<div class="c">
			<input type="text" class="input_border" align="absmiddle" name="order" value="{ $result.order|default:10}" size="4"/>
		</div>
	</div>
	
	<div class="module_border">
		<div class="l">状态：</div>
		<div class="c">
			<select name="status" class="input_border">
			<option value="1" { if $result.status=='1' || $result.status==""} selected="selected"{ /if}>开启</option>
			<option value="0"  { if $result.status=='0'} selected="selected"{ /if}>关闭</option>
		  </select>
		</div>
	</div>
	
	<div class="module_border">
		<div class="l">模板可选项：</div>
		<div class="c">
			<label><input type="checkbox" name="default_field[]" value="title" checked="checked" disabled="disabled"/>标题</label> {if $_A.query_class == "new"}{ html_checkboxes name="default_field" options=$_A.article_fields checked=all }{else}{ html_checkboxes name="default_field" options=$_A.article_fields checked=$result.default_field  }{/if}
		</div>
	</div>
	
	<div class="module_border">
		<div class="l">标题名称：</div>
		<div class="c">
			<input type="text" align="absmiddle" name="title_name" value="{$result.title_name|default:"标题"}" class="input_border"  />
		</div>
	</div>
	
	<div class="module_border">
		<div class="l">是否启用字段扩展：</div>
		<div class="c">
			<input type="radio" name="fields" value="1" {if $result.fields==1} checked="checked"{/if}/> 是 <input type="radio" name="fields" value="0" {if $result.fields==0 || $result.fields==""} checked="checked"{/if} /> 否 (启用的话字段将可以自定义的添加，修改)
		</div>
	</div>
	
	<div class="module_border">
		<div class="l">是否支持会员投稿：</div>
		<div class="c">
			<input type="radio" name="issent" value="1" {if $result.issent==1} checked="checked"{/if}/> 是 <input type="radio" name="issent" value="0" {if $result.issent==0 || $result.issent==""} checked="checked"{/if} /> 否
		</div>
	</div>
	
	<div class="module_border">
		<div class="l">投稿是否唯一：</div>
		<div class="c">
			<input type="radio" name="onlyone" value="1" {if $result.onlyone==1} checked="checked"{/if}/> 是 <input type="radio" name="onlyone" value="0" {if $result.onlyone==0 || $result.onlyone==""} checked="checked"{/if} /> 否
		</div>
	</div>
	
	<div class="module_border">
		<div class="l">投稿文章类型：</div>
		<div class="c">
			<input type="radio" name="article_status" value="1" {if $result.article_status==1} checked="checked"{/if}/> 已审核 <input type="radio" name="article_status" value="0" {if $result.article_status==0 || $result.article_status==""} checked="checked"{/if} /> 未审核
		</div>
	</div>
	
	<div class="module_border">
		<div class="l">默认访问类型：</div>
		<div class="c">
			 <input type="radio" name="visit_type" value="0" {if $result.visit_type==0 || $result.visit_type==""} checked="checked"{/if}  title="如：?3/1"/> 动态访问 <input type="radio" name="visit_type" value="1" {if $result.visit_type==1} checked="checked"{/if} title="如：?article/dongtai/1.html"/> 伪静态 <input type="radio" name="visit_type" value="2" {if $result.visit_type==2} checked="checked"{/if}/ title="如：/article/dongtai/1.html"> 生成html
		</div>
	</div>
	
	<div class="module_border">
		<div class="l">默认封面模板：</div>
		<div class="c">
			<input type="text" align="absmiddle" name="index_tpl" value="{$result.index_tpl|default:"[code].html"}" class="input_border"  />[code]表示此模块的识别id，以下类推
		</div>
	</div>
	
	<div class="module_border">
		<div class="l">默认列表模板：</div>
		<div class="c">
			<input type="text" align="absmiddle" name="list_tpl" value="{$result.list_tpl|default:"[code]_list.html"}" class="input_border"  />
		</div>
	</div>
	
	<div class="module_border">
		<div class="l">默认内容模板：</div>
		<div class="c">
			<input type="text" align="absmiddle" name="content_tpl" value="{$result.content_tpl|default:"[code]_content.html"}" class="input_border"  />
		</div>
	</div>
	
	<div class="module_border">
		<div class="l">搜索模板：</div>
		<div class="c">
			<input type="text" align="absmiddle" name="search_tpl" value="{$result.search_tpl|default:"[code]_search.html"}" class="input_border"  />
		</div>
	</div>
	
	<div class="module_border">
		<div class="l">简介：</div>
		<div class="c">
			<input type="text" align="absmiddle" name="description" value="{$result.description}" class="input_border"  />
		</div>
	</div>
	
	<div class="module_border">
		<div class="l">版本：</div>
		<div class="c">
			<input type="text" align="absmiddle" name="version" value="{$result.version|default:'1.0'}" class="input_border"  />
		</div>
	</div>
	
	<div class="module_border">
		<div class="l">作者：</div>
		<div class="c">
			<input type="text" align="absmiddle" name="author" value="{$result.author|default:'hycms'}" class="input_border"  />
		</div>
	</div>
	
	<div class="module_submit border_b" >
		<input type="submit" value=" 提 交 " class="submitstyle" name="submit_ok" />&nbsp;&nbsp;
		<input name="reset" type="reset" class="submitstyle" value=" 重 置 " />
	</div>
	</form>
</div>
{literal}
<script>
function check_form(){
	 var frm = document.forms['form1'];
	 var title = frm.elements['name'].value;
	 var code = frm.elements['code'].value;
	 var errorMsg = '';
	  if (title.length == 0 ) {
		errorMsg += '模块名称必须填写' + '\n';
	  }
	  if (code.length == 0 ) {
		errorMsg += '识别id必须填写' + '\n';
	  }
	  if (errorMsg.length > 0){
		alert(errorMsg); return false;
	  } else{  
		return true;
	  }
}
</script>
{/literal}

{elseif $_A.query_class=="list"}
<table width="100%" border="0" cellpadding="5" cellspacing="1" >
	<tr>
	  <td width="6%"class="main_td" >ID</td>
	  <td width="*" class="main_td">模块名称</td>
	  <td width="11%" class="main_td">识别ID</td>
	  <td width="18%" class="main_td">类型</td>
	  <td width="10%"class="main_td" >排序</td>
	  <th width="22%" class="main_td">管理</th>
	</tr>
	<form action="{$url}/order" method="post">
	{ foreach  from=$result key=key item=item}
	<tr  {if $key%2==1}class="tr2"{/if}>
	  <td align="center" bgcolor="#FFFFFF">{ $item.module_id}
      <input name="code[]" type="hidden" value="{$item.code}"  /></td>
	  <td bgcolor="#FFFFFF">{ $item.name}</td>
	  <td bgcolor="#FFFFFF" >{ $item.code}</td>
	  <td bgcolor="#FFFFFF" >{$item.type}</td>
	
      <td align="center" bgcolor="#FFFFFF" ><input name="order[]" type="text" value="{ $item.order}" size="6"  /><input name="module_id[]" type="hidden" value="{ $item.module_id}" size="6"  /></td>
	  <td bgcolor="#FFFFFF" ><a href="{ $url}/field&code={ $item.code}">字段</a> | <a href="{$url}/edit&code={ $item.code}">编辑</a> |<a href="{$query_site}&q=module/{$item.code}">管理</a> </td>
	</tr>
	{ /foreach}

	<tr >
	  <td  colspan="6" class="submit" ><input type="submit" value="修改排序" />&nbsp;&nbsp;&nbsp;&nbsp;<input value="添加新模块" type="button" onclick="javascript:location='{$url}/new';" /> </div>	
	</td>
	</tr></form>

</table>
{ elseif $_A.query_class=="field"}
<table width="100%" border="0" cellpadding="5" cellspacing="1" bgcolor="#dddddd">

	<tr class="tr">
	  <td width="*"  class="main_td">字段名称</td>
	  <td width="10%"  class="main_td">标识名</td>
	  <td width="10%" class="main_td">字段类型</td>
	  <td width="14%" class="main_td">长度</td>
	  <td width="14%" class="main_td">数据类型</td>
	  <td width="14%" class="main_td">排序</td>
	  <th width="17%" class="main_td">操作</th>
	</tr>
	<form action="{ $url}/field_order" method="post">
	{ if $result!=""}
	{ foreach  from=$result key=key item=item}
	<tr  {if $key%2==1} class="tr2"{/if}>
	  <td class="main_td1" align="center">{ $item.name}<input name="fields_id[]" type="hidden" value="{ $item.fields_id}"  /></td>
	   <td class="main_td1"align="center">{ $item.nid}</td>
	  <td  class="main_td1">{ $item.type}</td>
	   <td  class="main_td1">{ $item.size|default:"-"}</td>
	  <td class="main_td1">{ $item.input}</td>
	  <td class="main_td1"><input name="order[]" type="text" value="{ $item.order}" size="6"  /></td>
	  <td class="main_td1"> <a href="{ $url}/field_edit&code={$item.code}&nid={ $item.nid}">修改</a> | <a href="{ $url}/field_del&code={$item.code}&nid={ $item.nid}">删除</a> </td>
	</tr>
	{ /foreach}
	{ /if}
	<tr >
	  <td  colspan="7" class="submit" ><input type="submit" value="修改排序" />&nbsp;&nbsp;&nbsp;&nbsp;<input value="添加新字段" type="button" onclick="javascript:location='{ $url}/field_new&code={$magic.request.code}';" /> 
	</td>
	</tr></form>

	</table>
{ elseif $_A.query_class=="field_new" || $_A.query_class=="field_edit"}
{literal}
<script>
function check_form(){
	 var frm = document.forms['form1'];
	 var title = frm.elements['name'].value;
	 var nid = frm.elements['nid'].value;
	 var input = frm.elements['input'].value;
	 var selecte = frm.elements['select'].value;
	 var errorMsg = '';
	  if (title.length == 0 ) {
		errorMsg += '字段名称必须填写' + '\n';
	  }
	   if (nid.length == 0 ) {
		errorMsg += '标示名必须填写' + '\n';
	  }
	   if ((input == "select" || input == "checkbox" || input == "radio") && selecte=="") {
		errorMsg += '你选择的数据类型必须要填写字段的可选值，用英文的","隔开' + '\n';
	  }
	  if (errorMsg.length > 0){
		alert(errorMsg); return false;
	  } else{  
		return true;
	  }

}

</script>
{/literal}
<div class="module_add">

	<form action="{ $url}/field_{ if $_A.query_class=='field_new'}add{ else}update{ /if}&code={$magic.request.code}" method="post" name="form1"  onsubmit="return check_form()">
<input name="code" type="hidden" value="{ $magic.request.code}"  />
	<div class="module_title"><strong>{ if $_A.query_class == "edit" }编辑{else}添加{/if}字段</strong></div>
	
	<div class="module_border">
		<div class="l">字段名称：</div>
		<div class="c">
			<input type="text" class="input_border" align="absmiddle" name="name" value="{ $result.name}" />
		</div>
	</div>
	
	<div class="module_border">
		<div class="l">标示名：</div>
		<div class="c">
			{ if $_A.query_class=='field_new'}
		  <input type="text" align="absmiddle" name="nid" class="input_border"  onkeyup="value=value.replace(/[^a-z_]/g,'')"/>只能为字母或下划线{ else}{ $result.nid}<input type="hidden" align="absmiddle" name="nid" value="{ $result.nid}"    />{ /if}
		</div>
	</div>
	
	<div class="module_border">
		<div class="l">排序：</div>
		<div class="c">
			<input type="text" align="absmiddle" name="order" value="{ $result.order|default:10}"  />	 
		</div>
	</div>
	
	<div class="module_border">
		<div class="l">数据类型：</div>
		<div class="c">
			{html_options options =$fields_input selected =$result.input name="input"}
		</div>
	</div>
	
	<div class="module_border">
		<div class="l">字段类型：</div>
		<div class="c">
			{html_options options =$fields_type selected ="$result.type" name="type"}
		</div>
	</div>
   
    <div class="module_border">
		<div class="l">默认值：</div>
		<div class="c">
			<input name="default" id="default" type="text" value="{ $result.default}"/>
		</div>
	</div>
     <div class="module_border">
		<div class="l">字段可选：</div>
		<div class="c">
			<input name="select" type="text"  value="{ $result.select}"/> 多个可选值请用,号隔开
		</div>
	</div>
	
    <div class="module_border">
		<div class="l">字段描述：</div>
		<div class="c">
			<textarea name="description" cols="50" rows="7" >{ $result.description}</textarea>
		</div>
	</div>
	
	<div class="module_submit">
		<input type="submit" value=" 提 交 " class="submitstyle" name="submit_ok" />
      <input name="reset" type="reset" class="submitstyle" value=" 重 置 " /></td>
	</div>
	</form>
</div>
{ /if}