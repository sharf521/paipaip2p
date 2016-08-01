{if $_A.query_type == "new" || $_A.query_type == "edit"}
<div class="module_add">
	<form name="form1" method="post" action="" onsubmit="return check_form();" enctype="multipart/form-data" >
	<div class="module_title"><strong>{ if $_A.query_type == "edit" }编辑{else}添加{/if}动态内容</strong></div>
	
	<div class="module_border">
		<div class="l">动态内容名称：</div>
		<div class="c">
			<input type="text" name="webname"  class="input_border" value="{ $_A.dynacontent_result.webname}" size="30" />  
		</div>
	</div>
	
	<div class="module_border">
		<div class="l">类别：</div>
		<div class="c">
			<select name="type_id">
			{foreach from=$_A.dynacontent_type_list item=item}
			<option  value="{ $item.id}" {if $item.id==$_A.dynacontent_result.type_id} selected="selected"{/if} />{ $item.typename}</option>
			
			{/foreach}
			</select>
		</div>
	</div>
	
	<div class="module_border">
		<div class="l">所属分站：</div>
		<div class="c">
			<select name="areaid">
			{foreach from=$_A.subsite_list item=item}
			<option  value="{ $item.id}" {if $item.id==$_A.dynacontent_result.areaid} selected="selected"{/if} />{ $item.sitename}</option>
			
			{/foreach}
			</select>
		</div>
	</div>	
	
		<div class="module_border">
		<div class="l">排序：</div>
		<div class="c">
			<input type="text" name="order"  class="input_border" value="{ $_A.dynacontent_result.order|default:10}" size="10" />
		</div>
	</div>
	<div class="module_border">
		<div class="l">内容：</div>
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
		<input type="submit"  name="submit" value="确认提交" />
		<input type="reset"  name="reset" value="重置表单" />
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
		errorMsg += '网站标题必须填写' + '\n';
	  }
	  if (url.length == 0 ) {
		errorMsg += '链接地址不能为空' + '\n';
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
		<td width="*" class="main_td">名称</td>
		<td width="" class="main_td">操作</td>
	</tr>
	{ foreach  from=$_A.links_type_list key=key item=item}
	<tr {if $key%2==1} class="tr2"{/if}>
		<td class="main_td1" align="center">{ $item.id}</td>
		<td class="main_td1" align="left">&nbsp;&nbsp;&nbsp;<input type="text" value="{$item.typename}" name="typename[]" /><input type="hidden" name="id[]" value="{$item.id}" /></td>
		<td class="main_td1" align="center" width="160"><a href="#" onClick="javascript:if(confirm('确定要删除吗?删除后将不可恢复')) location.href='{$_A.query_url}/type&del_id={$item.id}'">删除</a> </td>
	</tr>
	{ /foreach}
	<tr >
		<td width="" class="main_td" colspan="3">新增一个类型：<input type="text" name="typename1" /></td>
	</tr>

<tr>
	<td bgcolor="#ffffff" colspan="3"  align="center">
	<input type="submit"  name="submit" value="确认提交" />
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
		<td width="" class="main_td">分站</td>
		<td width="" class="main_td">类型</td>
		<td width="" class="main_td">内容名称</td>
		<td width="" class="main_td">排序</td>
		<td width="" class="main_td">添加时间</td>
		<td width="" class="main_td">操作</div>
	</div>
	{ foreach  from=$_A.dynacontent_list key=key item=item}
	<tr {if $key%2==1} class="tr2"{/if}>
		<td class="main_td1" align="center">{ $item.id}</td>
		<td class="main_td1" align="center">{ $item.sitename}</td>
		<td class="main_td1" align="center">{$item.typename }</td>
		<td class="main_td1" align="center">{$item.webname}</td>
		<td class="main_td1" align="center" width="50"><input type="text" value="{$item.order|default:10}" name="order[]" size="5" /><input type="hidden" name="id[]" value="{$item.id}" /></td>
		<td class="main_td1" align="center" width="90">{$item.addtime|date_format:"Y-m-d"}</td>
		<td class="main_td1" align="center" width="130"><a href="{$_A.query_url}/edit&id={$item.id}">修改</a> / <a href="#" onClick="javascript:if(confirm('确定要删除吗?删除后将不可恢复')) location.href='{$_A.query_url}/del&id={$item.id}'">删除</a></div>
	</div>
	{ /foreach}
	<tr >
		<td colspan="8" class="submit">
			<input type="submit" name="submit" value="确认提交" />
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