{if $_A.query_type == "audit"}
<div class="module_add">
	<form name="form1" method="post" action="{$_A.query_url}/audit&a=attestation" onsubmit="return check_form();" enctype="multipart/form-data" >
	
	<div class="module_border">
		<div class="l">状态:</div>
		<div class="c">
		 <input type="radio" name="status" value="1" checked="checked"/>审核通过 <input type="radio" name="status" value="2" />审核不通过 </div>
	</div>
	
	<div class="module_border" >
		<div class="l">通过所得信用积分:</div>
		<div class="c">
			<input type="text" name="jifen" value="{$_A.arrestation_value}" size="5"> 分
		</div>
	</div>
	{if $magic.request.type == "video" || $magic.request.type == "scene"}
	<div class="module_border" >
		<div class="l">认证收费:</div>
		<div class="c">
			<input type="text" name="fee" value="0" size="5"> 元
		</div>
	</div>
	{/if}
	<!--
	<div class="module_border" >
		<div class="l">验证码:</div>
		<div class="c">
			<input name="valicode" type="text" size="11" maxlength="4"  tabindex="3"/>&nbsp;<img src="/plugins/index.php?q=imgcode" alt="点击刷新" onClick="this.src='/plugins/index.php?q=imgcode&t=' + Math.random();" align="absmiddle" style="cursor:pointer" />
		</div>
	</div>
	<div class="module_border" >
		<div class="l">相关图片1:</div>
		<div class="c">
			<input type="file" name="pic[]" > 
		</div>
	</div>
	

	<div class="module_border" >
		<div class="l">相关图片2:</div>
		<div class="c">
			<input type="file" name="pic[]" > 
		</div>
	</div>
	
	
	<div class="module_border" >
		<div class="l">相关图片3:</div>
		<div class="c">
			<input type="file" name="pic[]" > 
		</div>
	</div>
	-->
	<div class="module_border" >
		<div class="l">分站审核意见:</div>
		<div class="c">
			<textarea name="subsite_remark" cols="35" rows="5">{$_A.user_result.subsite_remark}</textarea>
		</div>
	</div>

	<div class="module_border" >
		<div class="l">审核备注:</div>
		<div class="c">
			<textarea name="content" cols="35" rows="5"></textarea>
		</div>
	</div>
	
	<div class="module_submit" >
		<input type="hidden" name="user_id" value="{ $magic.request.user_id }" />
		<input type="hidden" name="nid" value="{ $magic.request.type }" />
		<input type="submit"  name="reset" value="确认提交" />
	</div>
	</form>
</div>
{else}
<div class="module_add">
	<form name="form1" method="post" action="{$_A.query_url}/subsite_audit&a=attestation" onsubmit="return check_form();" enctype="multipart/form-data" >
	

	
	<div class="module_border" >
		<div class="l">分站审核意见:</div>
		<div class="c">
			<textarea name="subsite_remark" cols="35" rows="5">{$_A.user_result.subsite_remark}</textarea>
		</div>
	</div>

	<div class="module_submit" >
	<input type="hidden" name="user_id" value="{ $magic.request.user_id }" />
		<input type="submit"  name="reset" value="确认提交" />
	</div>
	</form>
</div>
{/if}