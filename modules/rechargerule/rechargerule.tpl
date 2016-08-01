{if $_A.query_type == "list"}
<table  border="0"  cellspacing="1" bgcolor="#CCCCCC" width="100%">
	<tr >
		<td width="" class="main_td">ID</td>
		<td width="*" class="main_td">最小金额</td>
		<th width="" class="main_td">最大金额</th>
		<th width="" class="main_td">奖励比例</th>
		<th width="" class="main_td">开始时间</th>
		<th width="" class="main_td">结束时间</th>
		<td width="" class="main_td">操作</td>
	</tr>
	<form action="" method="post">
	{ foreach  from=$_A.rule_list key=key item=item}
	<tr {if $key%2==1} class="tr2"{/if}>
		<td class="main_td1" align="center">{ $item.id}</td>
		<td class="main_td1" align="center">{$item.min_account}</td>
		<td class="main_td1" align="center" >{$item.max_account}</td>
		<td class="main_td1" align="center" >{$item.award_rate}</td>
		<td class="main_td1" align="center" >{$item.begin_time|date_format:"Y-m-d"}</td>
		<td class="main_td1" align="center" >{$item.end_time|date_format:"Y-m-d"}</td>
		<td class="main_td1" align="center"><a href="{$_A.query_url}/edit&rule_id={$item.id}{$_A.site_url}">修改</a> / <a href="#" onClick="javascript:if(confirm('确定要删除吗?删除后将不可恢复')) location.href='{$_A.query_url}/del&rule_id={$item.id}{$_A.site_url}'">删除</a> </td>
	</tr>
	{ /foreach}
	<tr>
		<td colspan="8" class="page">
		<input type="submit" value="修改排序" /
		</td>
	</tr>
	<tr>
		<td colspan="8" class="page">
		{$_A.showpage}
		</td>
	</tr>
	</form>
</table>


{elseif $_A.query_type == "new" || $_A.query_type == "edit"}
<div class="module_add">
	
	<form name="form_user" method="post" action="" { if $_A.query_type == "new" }{/if} >
	<div class="module_title"><strong>{ if $_A.query_type == "edit" }编辑{else}添加{/if}</strong></div>
	
	
	
	
	<div class="module_border">
		<div class="l">开始金额：</div>
		<div class="c">
			<input name="min_account" type="text" value="{ $_A.rule_result.min_account }" class="input_border" />
		</div>
	</div>
	
	<div class="module_border">
		<div class="l">结束金额：</div>
		<div class="c">
			<input name="max_account" type="text" value="{ $_A.rule_result.max_account }" class="input_border" />
		</div>
	</div>	
	
	<div class="module_border">
		<div class="l">奖励比例：</div>
		<div class="c">
			<input name="award_rate" type="text" value="{ $_A.rule_result.award_rate }" class="input_border" />%
		</div>
	</div>
	
	
	
	<div class="module_border">
		<div class="l">开始日期：</div>
		<div class="c">
		<input type="text" name="begin_time"  class="input_border" value="{$_A.rule_result.begin_time|date_format:"Y-m-d"}" size="20" onclick="change_picktime()"/> 
			
		</div>
	</div>
	
	<div class="module_border">
		<div class="l">结束日期：</div>
		<div class="c">
		<input type="text" name="end_time"  class="input_border" value="{$_A.rule_result.end_time|date_format:"Y-m-d"}" size="20" onclick="change_picktime()"/> 
			
		</div>
	</div>
	 
	  
	
	<div class="module_submit border_b" >
	{ if $_A.query_type == "edit" }<input type="hidden" name="rule_id" value="{ $_A.rule_result.id }" />{/if}
	<input type="submit" value="确认提交" />
	<input type="reset" name="reset" value="重置表单" />
	</div>
	</form>
</div>
{literal}
<script>
function joincity(id){
	alert($("#"+id+"city option").text());

}

function check_user(){
	 var frm = document.forms['form_user'];
	 var username = frm.elements['username'].value;
	 var password = frm.elements['password'].value;
	  var password1 = frm.elements['password1'].value;
	   var email = frm.elements['email'].value;
	 var errorMsg = '';
	  if (username.length == 0 ) {
		errorMsg += '用户名不能为空' + '\n';
	  }
	   if (username.length<4) {
		errorMsg += '用户名长度不能少于4位' + '\n';
	  }
	  if (password.length==0) {
		errorMsg += '密码不能为空' + '\n';
	  }
	  if (password.length<6) {
		errorMsg += '密码长度不能小于6位' + '\n';
	  }
	   if (password.length!=password1.length) {
		errorMsg += '两次密码不一样' + '\n';
	  }
	   if (email.length==0) {
		errorMsg += '邮箱不能为空' + '\n';
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