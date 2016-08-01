{if $_A.query_type == "list"}
<table  border="0"  cellspacing="1" bgcolor="#CCCCCC" width="100%">
	<tr >
		<td width="" class="main_td">ID</td>
		<td width="*" class="main_td">识别码</td>
		<td width="*" class="main_td">类型名称</td>
		<td width="*" class="main_td">申请费率</td>
		<td width="*" class="main_td">冻结比例</td>
		<td width="*" class="main_td">操作</td>
	</tr>
	<form action="" method="post">
	{ foreach  from=$_A.amount_type_list key=key item=item}
	<tr {if $key%2==1} class="tr2"{/if}>
		<td class="main_td1" align="center">{$item.id}</td>
		<td class="main_td1" align="center">{$item.amount_type_name}</td>
		<td class="main_td1" align="center">{$item.show_name}</td>
		<td class="main_td1" align="center">{$item.fee_rate}</td>
		<td class="main_td1" align="center">{$item.frost_rate}</td>
		<td class="main_td1" align="center"><a href="{$_A.query_url}/edit&type_id={$item.id}{$_A.site_url}">修改</a></td>
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
		<div class="l">识别码：</div>
		<div class="c">
			{ $_A.amount_type_result.amount_type_name }<input type="hidden" name="amount_type_name" value="{ $_A.amount_type_result.amount_type_name }" />
		</div>
	</div>
	
	<div class="module_border">
		<div class="l">类型名称：</div>
		<div class="c">
			<input name="show_name" type="text" value="{ $_A.amount_type_result.show_name }" class="input_border" />
		</div>
	</div>
	
	<div class="module_border">
		<div class="l">申请费率：</div>
		<div class="c">
			<input name="fee_rate" type="text" value="{ $_A.amount_type_result.fee_rate }" class="input_border" />
		</div>
	</div>
	
	<div class="module_border">
		<div class="l">冻结比例：</div>
		<div class="c">
			<input name="frost_rate" type="text" value="{ $_A.amount_type_result.frost_rate }" class="input_border" />
		</div>
	</div>
	
	
	
	<div class="module_submit border_b" >
	{ if $_A.query_type == "edit" }<input type="hidden" name="type_id" value="{ $_A.amount_type_result.id }" />{/if}
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