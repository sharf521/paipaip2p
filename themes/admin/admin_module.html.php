<?php
!defined('IN_TEMPLATE') && exit('Access Denied');
?>
{include file="admin_head.html.php"}

<!--模块列表 开始-->
{if $_A.query_class == "list"}
<table  border="0"  cellspacing="1" bgcolor="#CCCCCC" width="100%">
	<tr >
		<td width="" class="main_td">编号</td>
		<td width="*" class="main_td">名称</td>
		<th width="" class="main_td">描述</th>
		<th width="" class="main_td">版本</th>
		<th width="" class="main_td">作者</th>
		<th width="" class="main_td">更新时间</th>
	</tr>
	{ foreach  from=$_A.module_list key=key item=item}
	{if $item.type!='admin'}
	<tr {if $key%2==1}class="tr2"{/if}>
		<td align="center">{ $item.code}</td>
		<td align="center">{$item.name}</td>
		<td align="center">{$item.description}</td>
		<td align="center">{$item.version|default:"-"}</td>
		<td align="center">{$item.author|default:"-"}</td>
		<td align="center">{$item.date|default:"-"}</td>
		
	</tr>
	{/if}
	{ /foreach}	
</table>
<!--模块列表 结束-->	

<!--模块管理 开始-->	
{elseif $_A.query_class=="channel"}

	<!--已安装模块列表 开始-->
	{if $_A.query_type== "install"}
	<table  border="0"  cellspacing="1" bgcolor="#CCCCCC" width="100%">
		<tr >
			<td width="" class="main_td">编号</td>
			<td width="*" class="main_td">名称</td>
			<th width="" class="main_td">描述</th>
			<th width="" class="main_td">版本</th>
			<th width="" class="main_td">排序</th>
			<td width="" class="main_td">操作</td>
		</tr>
		<form action="{$_A.query_url}/order" method="post">
		{ foreach  from=$_A.module_list key=key item=item}
		{if $item.type!='admin'}
		<tr {if $key%2==1}class="tr2"{/if}>
			<td align="center">{ $item.code}</td>
			<td align="center">{$item.name}</td>
			<td align="center">{$item.description}</td>
			<td align="center">{$item.version|default:"-"}</td>
			<td align="center"><input name="order[]" type="text" value="{ $item.order}" size="6"  /><input name="module_id[]" type="hidden" value="{ $item.module_id}" size="6"  /></td>
			<td align="center" ><a href="{$_A.admin_url}&q=module/fields&code={ $item.code}">字段</a> | <a href="{$_A.query_url}/edit&code={ $item.code}">编辑</a> |  <a href="#" onClick="javascript:if(confirm('请确定是否要卸载此模块，此模块卸载后所有的数据都将清空，请慎重处理')) location.href='{$_A.query_url}/del&code={$item.code}'">卸载</a> | <a href="{$_A.admin_url}&q=module/{$item.code}">内容管理</a></td>
		</tr>
		{/if}
		{ /foreach}
		<tr >
			<td  colspan="6" class="submit" ><input type="submit" value="修改排序" />
				<input value="添加新模块" type="button" onclick="javascript:location='{$_A.query_url}/new';" /> </div>	
			</td>
		</tr>
		</form>
	</table>
	<!--已安装模块列表 结束-->
	
	<!--未安装模块列表 开始-->
	{elseif $_A.query_type== "unstall"}
	<table width="100%" border="0" cellpadding="5" cellspacing="1" >
	<tr>
		<td class="main_td">识别ID</td>
		<td width="*" class="main_td">模块名称</td>
		<td width="*" class="main_td">模块简介</td>
		<td width="*" class="main_td">版本号</td>
		<td class="main_td">类型</td>
		<th class="main_td">状态</th>
	</tr>
	{ foreach  from=$_A.module_list key=key item=item}
		<tr  {if $key%2==1}class="tr2"{/if}>
		<td  >{ $item.code}</td>
		<td >{ $item.name}</td>
		<td >{ $item.description}</td>
		<td >{ $item.version}</td>
		<td  >{$item.type}</td>
		<td  ><a href="{$_A.admin_url}&q=module/channel/new&code={$item.code}">安装</a></td>
	</tr>
	{ /foreach}
	</table>
	<!--未安装模块列表 结束-->
	
	<!--模块编辑 开始-->
	{elseif $_A.query_type== "edit" || $_A.query_type== "new"}
	<div class="module_add">
		<form action="" method="post" name="form1" onsubmit="return check_form();" >
		<div class="module_title"><strong>{ if $_A.query_type == "edit" }编辑{else}添加{/if}模块</strong></div>
		
		<div class="module_border">
			<div class="l">模块名称：</div>
			<div class="c">
				<input type="text" class="input_border" align="absmiddle" name="name" value="{$_A.module_result.name}" />
			</div>
		</div>
		
		<div class="module_border">
			<div class="l">识别ID（code）：</div>
			<div class="c">
				{ if $_A.query_type=="edit" || ($_A.query_type=="new" && $_A.module_result.code!="")}{$_A.module_result.code}<input type="hidden" name="code" value="{$_A.module_result.code}" />{ else}
				<input type="text" align="absmiddle" name="code" value="" class="input_border" onkeyup="value=value.replace(/[^a-z_]/g,'')" />{ /if}
			</div>
		</div>
		
		<div class="module_border">
			<div class="l">类型：</div>
			<div class="c">
				{$_A.module_result.type|default:'cms'}<input type="hidden" name="type" value="{$_A.module_result.type|default:'cms'}" />
			</div>
		</div>
		
		<div class="module_border">
			<div class="l">排序：</div>
			<div class="c">
				<input type="text" class="input_border" align="absmiddle" name="order" value="{$_A.module_result.order|default:10}" size="4"/>
			</div>
		</div>
		
		<div class="module_border">
			<div class="l">状态：</div>
			<div class="c">
				<select name="status" class="input_border">
				<option value="1" { if $_A.module_result.status=='1' || $_A.module_result.status==""} selected="selected"{ /if}>开启</option>
				<option value="0"  { if $_A.module_result.status=='0'} selected="selected"{ /if}>关闭</option>
			  </select>
			</div>
		</div>
		
		<div class="module_border">
			<div class="l">模板可选项：</div>
			<div class="c">
				<label><input type="checkbox" name="default_field[]" value="title" checked="checked" disabled="disabled"/>标题</label> {if $_A.query_type == "new"}{ html_checkboxes name="default_field" options="$_A.article_fields" checked="all" }{else}{ html_checkboxes name="default_field" options="$_A.article_fields" checked="$_A.module_result.default_field"  }{/if}
			</div>
		</div>
		
		<div class="module_border">
			<div class="l">标题名称：</div>
			<div class="c">
				<input type="text" align="absmiddle" name="title_name" value="{$_A.module_result.title_name|default:"标题"}" class="input_border"  />
			</div>
		</div>
		
		<div class="module_border">
			<div class="l">启用自定义字段：</div>
			<div class="c">
				<input type="radio" name="fields" value="1" {if  $_A.module_result.fields==1} checked="checked"{/if}/> 是 <input type="radio" name="fields" value="0" {if $_A.module_result.fields==0 || $_A.module_result.fields==""} checked="checked"{/if} /> 否
			</div>
		</div>
		
		<div class="module_border">
			<div class="l">是否支持会员投稿：</div>
			<div class="c">
				<input type="radio" name="issent" value="1" {if  $_A.module_result.issent==1} checked="checked"{/if}/> 是 <input type="radio" name="issent" value="0" {if $_A.module_result.issent==0 || $_A.module_result.issent==""} checked="checked"{/if} /> 否
			</div>
		</div>
		
		<div class="module_border">
			<div class="l">投稿是否唯一：</div>
			<div class="c">
				<input type="radio" name="onlyone" value="1" {if $_A.module_result.onlyone==1} checked="checked"{/if}/> 是 <input type="radio" name="onlyone" value="0" {if $_A.module_result.onlyone==0 || $_A.module_result.onlyone==""} checked="checked"{/if} /> 否
			</div>
		</div>
		
		<div class="module_border">
			<div class="l">投稿文章类型：</div>
			<div class="c">
				<input type="radio" name="article_status" value="1" {if $_A.module_result.article_status==1} checked="checked"{/if}/> 已审核 <input type="radio" name="article_status" value="0" {if $_A.module_result.article_status==0 || $_A.module_result.article_status==""} checked="checked"{/if} /> 未审核
			</div>
		</div>
		
		<div class="module_border">
			<div class="l">默认访问类型：</div>
			<div class="c">
				 <input type="radio" name="visit_type" value="0" {if $_A.module_result.visit_type==0 || $_A.module_result.visit_type==""} checked="checked"{/if}  title="如：?3/1"/> 动态访问 <input type="radio" name="visit_type" value="1" {if $_A.module_result.visit_type==1} checked="checked"{/if} title="如：?article/dongtai/1.html"/> 伪静态 <input type="radio" name="visit_type" value="2" {if $_A.module_result.visit_type==2} checked="checked"{/if}/ title="如：/article/dongtai/1.html"> 生成html
			</div>
		</div>
		
		<div class="module_border">
			<div class="l">默认封面模板：</div>
			<div class="c">
				<input type="text" align="absmiddle" name="index_tpl" value="{$_A.module_result.index_tpl|default:"[code].html"}" class="input_border"  />[code]表示此模块的识别id，以下类推
			</div>
		</div>
		
		<div class="module_border">
			<div class="l">默认列表模板：</div>
			<div class="c">
				<input type="text" align="absmiddle" name="list_tpl" value="{$_A.module_result.list_tpl|default:"[code]_list.html"}" class="input_border"  />
			</div>
		</div>
		
		<div class="module_border">
			<div class="l">默认内容模板：</div>
			<div class="c">
				<input type="text" align="absmiddle" name="content_tpl" value="{$_A.module_result.content_tpl|default:"[code]_content.html"}" class="input_border"  />
			</div>
		</div>
		
		<div class="module_border">
			<div class="l">搜索模板：</div>
			<div class="c">
				<input type="text" align="absmiddle" name="search_tpl" value="{$_A.module_result.search_tpl|default:"[code]_search.html"}" class="input_border"  />
			</div>
		</div>
		
		<div class="module_border">
			<div class="l">简介：</div>
			<div class="c">
				<input type="text" align="absmiddle" name="description" value="{$_A.module_result.description}" class="input_border"  />
			</div>
		</div>
		
		<div class="module_border">
			<div class="l">版本：</div>
			<div class="c">
				<input type="text" align="absmiddle" name="version" value="{$_A.module_result.version|default:'1.0'}" class="input_border"  />
			</div>
		</div>
		
		<div class="module_border">
			<div class="l">作者：</div>
			<div class="c">
				<input type="text" align="absmiddle" name="author" value="{$_A.module_result.author|default:'hycms'}" class="input_border"  />
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
	<!--模块编辑 结束-->
	
	<!--所有模块列表 开始-->
	{elseif $_A.query_type== "list"}
	<table width="100%" border="0" cellpadding="5" cellspacing="1" >
		<tr>
		  <td width="11%" class="main_td">识别ID</td>
		  <td width="*" class="main_td">模块名称</td>
		  <td width="*" class="main_td">模块简介</td>
		  <td width="*" class="main_td">版本号</td>
		  <td width="18%" class="main_td">类型</td>
		  <th width="22%" class="main_td">状态</th>
		</tr>
		{ foreach  from=$_A.module_list key=key item=item}
		<tr  {if $key%2==1}class="tr2"{/if}>
		  <td  >{ $item.code}</td>
		  <td >{ $item.name}</td>
		  <td >{ $item.description}</td>
		  <td >{ $item.version}</td>
		  <td  >{$item.type}</td>
		  <td  >{if $item.status == 1}<font color="#009900">已安装</font>{else}<font color="#FF0000">未安装</font>{/if}</td>
		</tr>
		{ /foreach}
	</table>
	<!--所有模块列表 结束-->
	{/if}
<!--模块管理 结束-->


<!--字段管理 开始-->
{elseif $_A.query_class=="fields"}

	{if $_A.query_type== "list"}
	<!--字段列表 开始-->
	<table width="100%" border="0" cellpadding="5" cellspacing="1" bgcolor="#dddddd">
		<tr class="tr">
		  <td class="main_td">字段名称</td>
		  <td class="main_td">标识名</td>
		  <td class="main_td">字段类型</td>
		  <td class="main_td">长度</td>
		  <td class="main_td">数据类型</td>
		  <td class="main_td">排序</td>
		  <th class="main_td">操作</th>
		</tr>
		<form action="{$_A.query_url}/order" method="post">
		{ foreach  from=$_A.fields_list key=key item=item}
		<tr  {if $key%2==1} class="tr2"{/if}>
			<td class="main_td1" align="center">{ $item.name}</td>
			<td class="main_td1"align="center">{ $item.nid}</td>
			<td  class="main_td1">{ $item.type}</td>
			<td  class="main_td1">{ $item.size|default:"-"}</td>
			<td class="main_td1">{ $item.input}</td>
			<td class="main_td1"><input name="order[]" type="text" value="{ $item.order}" size="6"  />
			<input name="fields_id[]" type="hidden" value="{ $item.fields_id}"  /></td>
			<td class="main_td1"> <a href="{$_A.query_url}/edit&code={$item.code}&fields_id={ $item.fields_id}">修改</a> | <a href="#" onClick="javascript:if(confirm('确定要删除吗?删除后将不可恢复')) location.href='{$_A.query_url}/del&code={$item.code}&fields_id={ $item.fields_id}'">删除</a> </td>
		</tr>
		{ /foreach}
		<tr >
			<td  colspan="7" class="submit" >
			<input type="submit" value="修改排序" />&nbsp;&nbsp;&nbsp;&nbsp;
			<input value="添加新字段" type="button" onclick="javascript:location='{$_A.query_url}/new&code={$magic.request.code}';" /> 
			</td>
		</tr>
		</form>
	</table>
	<!--字段列表 结束-->
	
	<!--添加字段 开始-->
	{elseif $_A.query_type== "new" || $_A.query_type== "edit"}
	<div class="module_add">
	<form action="" method="post" name="form1"  onsubmit="return check_form()">
	
		<div class="module_title"><strong>{ if $_A.query_type == "edit" }编辑{else}添加{/if}字段</strong></div>
		
		<div class="module_border">
			<div class="l">字段名称：</div>
			<div class="c">
				<input type="text" class="input_border" align="absmiddle" name="name" value="{$_A.fields_result.name}" />
			</div>
		</div>
		
		<div class="module_border">
			<div class="l">标示名：</div>
			<div class="c">
				{ if $_A.query_type=='new'}
			  <input type="text" align="absmiddle" name="nid" class="input_border"  onkeyup="value=value.replace(/[^a-z_]/g,'')"/>只能为字母或下划线{ else}{$_A.fields_result.nid}<input type="hidden" align="absmiddle" name="nid" value="{$_A.fields_result.nid}"    />{ /if}
			</div>
		</div>
		
		<div class="module_border">
			<div class="l">排序：</div>
			<div class="c">
				<input type="text" align="absmiddle" name="order" value="{$_A.fields_result.order|default:10}"  />	 
			</div>
		</div>
		
		<div class="module_border">
			<div class="l">数据类型：</div>
			<div class="c">
				{html_options options =$_A.fields_input selected =$_A.fields_result.input name="input"}
			</div>
		</div>
		
		<div class="module_border">
			<div class="l">字段类型：</div>
			<div class="c">
				{html_options options =$_A.fields_type selected =$_A.fields_result.type name="type"}
			</div>
		</div>
	   
		<div class="module_border">
			<div class="l">默认值：</div>
			<div class="c">
				<input name="default" id="default" type="text" value="{$_A.fields_result.default}"/>
			</div>
		</div>
		 <div class="module_border">
			<div class="l">字段可选：</div>
			<div class="c">
				<input name="select" type="text"  value="{$_A.fields_result.select}"/> 多个可选值请用,号隔开
			</div>
		</div>
		
		<div class="module_border">
			<div class="l">字段描述：</div>
			<div class="c">
				<textarea name="description" cols="50" rows="7" >{$_A.fields_result.description}</textarea>
			</div>
		</div>
		
		<div class="module_submit">
			<input name="code" type="hidden" value="{ $magic.request.code}"  />
			<input name="fields_id" type="hidden" value="{ $magic.request.fields_id}"  />
			<input type="submit" value=" 提 交 " class="submitstyle" name="submit_ok" />
			<input name="reset" type="reset" class="submitstyle" value=" 重 置 " /></td>
		</div>
		</form>
	</div>
	
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
	<!--添加字段 结束-->
	{/if}
<!--字段管理 结束-->


{elseif $_A.query_class=="update"}
<table  border="0"  cellspacing="1" bgcolor="#CCCCCC" width="100%">

<form action="{$_A.query_url}/{$result.type}&code={$magic.request.code}" method="post" name="form1" >

	<tr>
		<td align="right"  width="15%">模块名称：</td>
		<td align="left"  >{$result.name}
	  </td>
	</tr>
<tr>
		<td align="right"  width="15%">模块标识：</td>
		<td align="left"  >{$result.code}
	  </td>
	</tr>
	<tr>
		<td align="right"  width="15%">更新介绍：</td>
		<td align="left"  >{$result.description}
	  </td>
	</tr>
	<tr>
		<td align="right"  width="15%">更新版本：</td>
		<td align="left"  >{$result.version}
	  </td>
	</tr>
	<tr>
		<td align="right"  width="15%">类型：</td>
		<td align="left"  >{$result.type}
	  </td>
	</tr>
	<tr>
		<td align="right"  width="15%">更新时间：</td>
		<td align="left"  >{$result.date}
	  </td>
	</tr>
	<tr  >
		<td    colspan="2">
		<input type="hidden" name="list_code" value="{$result.code}" />
		&nbsp;&nbsp;&nbsp;&nbsp;<input type="submit" value=" 确认更新 "  name="submit_ok" />
		</td>
	</tr>
</table>
</form>
{else}
	{include file="$module_tpl" template_dir="$template_dir"}
{/if}


{include file="admin_foot.html"}

