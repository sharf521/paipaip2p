<?php
!defined('IN_TEMPLATE') && exit('Access Denied');
?>
<table width="100%" border="0"  cellspacing="1" bgcolor="#CCCCCC">
	<form method="post" action="{$_A.query_url}/order">
	 <tr>
		  <td  class="main_td" width="15%">����ID</td>
		  <td class="main_td"> 
				��������
		  </td>
		  <td  class="main_td"> 
				����
		  </td>
		 <td  class="main_td"> 
				����
		  </td>
		</tr>
		{foreach from=$result item=item}
			 <tr {if $key%2==1}class="tr2"{/if}>
                  <td  bgcolor="#FFFFFF">
						{$item.nid}</td>
                  <td class="main_td1" width="20%"> {$item.name}
				  </td>
				  <td  class="main_td1"> 
						<input type="text" name="order[]" value="{$item.order}" size="5" /><input type="hidden" name="id[]" value="{$item.id}" />
				  </td>
				  <td  class="main_td1"> 
						{if $item.id>3}<a href="{$_A.query_url}/del&id={$item.id}">ɾ��</a>{else}-{/if}
			</div>
		</div>
		
		
				{/foreach}
	   <tr  >
			<td  colspan="4" class="submit">
			<input type="submit" value="�޸�����"  name="submit" />
			</td>
		</tr>
				
    </form>
 </table>
<div class="module_add">
		<form name="form_flag" method="post" action="{$_A.query_url}/add"  onsubmit="return check_flag();" >
		<div class="module_title"><strong>��������</strong></div>
		<div class="module_border">
			<div class="l">�������ƣ�</div>
			<div class="c">
				<input name="name" type="text" class="input_border"  size="20"/>
			</div>
		</div>
		
		<div class="module_border">
			<div class="l">����ID��</div>
			<div class="c">
				<input name="nid" type="text" class="input_border"  size="20"/>
			</div>
		</div>
		
		<div class="module_border">
			<div class="l">����</div>
			<div class="c">
				<input name="order" value="10" type="text" class="input_border"  size="5"/>
			</div>
		</div>
		
		<div class="module_submit"><input type="submit" value="��������"  name="submit" /></div>
    </form>
</div>