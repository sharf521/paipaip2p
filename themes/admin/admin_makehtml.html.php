<?php
!defined('IN_TEMPLATE') && exit('Access Denied');
?>
{ if $t=="index"}
<div class="module_add">
	<div class="module_title"><strong>����html</strong> -> ��ҳ����</div>
	
	<div class="module_border" >
		<div align="center"><br /><br /><strong>������ҳ����ҳ��Ŀ¼Ϊ��һ�������ӵ���ҳλ��</strong><br /><br /><br /></div>
	</div>

	<div class="module_submit" >
		<input value="������ҳģ��" type="button" onclick="javascript:location='{$url}/index&action=do';" />
	</div>
</div>
{ elseif $t=="site"}
<div class="module_add">
	<form action="" method="post">
	<div class="module_title"><strong>����html</strong> -> ��Ŀ����</div>
	
	<div class="module_border">
		<div class="e">ѡ����Ŀ��</div>
		<div class="c">
			<select name="site_id">
			<option value="0">����ȫ����Ŀ</option>
			{foreach from=$sitelist item=item key=key}
			<option value="{ $key}" {if $result.pid == $key} selected="selected"{/if} >-{$item.pname}</option>
			{ /foreach}
			</select>
		</div>
	</div>

	<div class="module_border">
		<div class="e">ÿ�δ�������ļ�����</div>
		<div class="c">
			<input type="text" value="50" name="amount" />
		</div>
	</div>

	<div class="module_border">
		<div class="e">�Ƿ��������Ŀ��</div>
		<div class="c">
			<input type="radio" value="1" name="zilanmu" checked="checked" />��������Ŀ <input type="radio" value="0" name="zilanmu" />��������д��Ŀ
		</div>
	</div>

	<div class="module_submit" >
		<input value="������Ŀģ��" type="submit"  />
	</div>
	</form>
</div>
{/if}