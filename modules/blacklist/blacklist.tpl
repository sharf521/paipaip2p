{if $_A.query_type == "new" || $_A.query_type == "edit"}
<div class="module_add">
	<form name="form1" method="post" action=""  enctype="multipart/form-data" >
	<div class="module_title"><strong>上传黑名单</div>
	
	<div class="module_border">
		<div class="l">黑名单上传:</div>
		<div class="c">
			<input type="file" name="logoimg"  class="input_border" size="20" />
		</div>
	</div>
	

	
	<div class="module_submit" >
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

</form>
{else}
<table  border="0"  cellspacing="1" bgcolor="#CCCCCC" width="100%">
  
	<tr >
		<td width="" class="main_td">平台</td>
		<td width="" class="main_td">注册名</td>
		<td width="" class="main_td">姓名</td>
		<td width="" class="main_td">性别</td>
		<td width="" class="main_td">身份证</td>
		<td width="" class="main_td">手机</td>
		<td width="" class="main_td">邮箱</td>
		<td width="" class="main_td">所在地</td>
		<td width="" class="main_td">现居住地</td>
		<td width="" class="main_td">逾期金额</td>
		<td width="" class="main_td">逾期笔数</td>
		<td width="" class="main_td">网站代还金额</td>
		<td width="" class="main_td">网站代还笔数</td>
		<td width="" class="main_td">逾期天数</td>
		<td width="" class="main_td">统计时间</td>
		<td width="" class="main_td">操作</td>
	</div>
	{ foreach  from=$_A.blacklist_list key=key item=item}
	<tr {if $key%2==1} class="tr2"{/if}>
		<td class="main_td1" align="center">{ $item.platform}</td>
		<td class="main_td1" align="center">{ $item.username}</td>
		<td class="main_td1" align="center">{$item.realname}</td>
		<td class="main_td1" align="center" >{ if $item.sex ==1}男{else}女{/if}</td>
		<td class="main_td1" align="center" >{$item.card_id }</td>
		<td class="main_td1" align="center" >{$item.phone }</td>
		<td class="main_td1" align="center" >{$item.email }</td>
		<td class="main_td1" align="center" >{$item.huhou_addr }</td>
		<td class="main_td1" align="center" >{$item.live_addr }</td>
		<td class="main_td1" align="center" >{$item.late_amount }</td>
		<td class="main_td1" align="center" >{$item.late_num }</td>
		<td class="main_td1" align="center" >{$item.advance_amount }</td>
		<td class="main_td1" align="center" >{$item.advance_num }</td>
		<td class="main_td1" align="center" >{$item.late_day_num }</td>
		<td class="main_td1" align="center" >{$item.count_date }</td>
		<td class="main_td1" align="center" ><a href="#" onClick="javascript:if(confirm('确定要删除吗?删除后将不可恢复')) location.href='{$_A.query_url}/del&id={$item.id}{$_A.site_url}'">删除</a></td>
		
	</div>
	{ /foreach}

	<tr>
		<td colspan="15" class="action">
		<form action="{$_A.query_url}/list" method="post">
		<div class="floatr">
			用户名：<input type="text" name="username" id="username" value="{$magic.request.username}"/>  姓名：<input type="text" name="realname" id="realname" value="{$magic.request.realname}"/>  
			身份证号：<input type="text" name="card_id" id="card_id" value="{$magic.request.card_id}"/>  手机号：<input type="text" name="phone" id="phone" value="{$magic.request.phone}"/>  
			邮箱：<input type="text" name="email" id="email" value="{$magic.request.email}"/>  <input type="submit" value="搜索" >
		</div>
	</form>	
		</td>
	</tr>
	<tr >
		<td colspan="15" class="page">
			{$_A.showpage}
		</td>
	</tr>

	
</table>
{/if}