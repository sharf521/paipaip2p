{if $_A.query_type == "new" || $_A.query_type == "edit" || $_A.query_type == "start" }
<div class="module_add">
<form name="form1" method="post" action=""  enctype="multipart/form-data">
	<div class="module_title"><strong>{ if $_A.query_type == "edit" }�༭{else}���{/if}</strong></div>
		
		
	
	
	<div class="module_border">
		<div class="w">֧����ʽ���ƣ�</div>
		<div class="c">
			<input type="text" name="name"  class="input_border" value="{ $_A.payment_result.name}" size="30" />
		</div>
	</div>
	{foreach from="$_A.payment_result.fields" item="item" }
	<div class="module_border">
		<div class="w">{$item.label}</div>
		<div class="c">
			{if $item.type=="string"}
			<input type="text" name="config[{$key}]"  class="input_border" value="{ $item.value}" size="30" />
			{elseif $item.type=="select"}
			<select name="config[{$key}]">
				{foreach from="$item.options" key="_key" item="var"}
				<option value="{$_key}" {if $item.value==$_key} selected="selected"{/if}>{$var}</option>
				{/foreach}
			</select>
			{/if}
		</div>
	</div>
	{/foreach}
	
	
	<div class="module_border">
		<div class="w">֧�����������ã�</div>
		<div class="c">
			<input type="radio" name="fee_type" value="0"  { if $_A.payment_result.fee_type == 0 ||$_A.payment_result.fee_type ==""}checked="checked"{/if} onclick="change(0)"/>�������շ� <input type="radio" name="fee_type" value="1"  { if $_A.payment_result.fee_type ==1 }checked="checked"{/if } onclick="change(1)"/>�̶����� </div>
	</div>
	<div class="module_border">
		<div class="w"></div>
		<div class="c">
			<div id="fee"> ���ʣ�<input type="text" name="max_fee" size="5" />% ˵�����˿ͽ�֧�������ܽ����Դ˷�����Ϊ������</div>
			<div id="fee_money" style="display:none"> ��<input type="text" name="max_money" size="5" />% ˵�����˿�ÿ�ʶ�����Ҫ֧���������ѣ�</div>
		 </div>
	</div>
	<div class="module_border">
		<div class="w">����:</div>
		<div class="c">
			<input type="text" name="order"  class="input_border" value="{ $_A.payment_result.order|default:10}" size="10" />
		</div>
	</div>

	{if $_A.payment_result.nid=='offline'}
        {if $_A.admin_type_id == 1}
        <div class="module_border">
            <div class="w">������վ��</div>
            <div class="c">
                <select name="areaid">
                {foreach from=$_A.subsite_list item=item}
                <option  value="{ $item.id}" {if $item.id==$_A.code_result.areaid} selected="selected"{/if} />{ $item.sitename}</option>
                
                {/foreach}
                </select>
            </div>
        </div>
        {else}
        <input type="text" name="areaid" value={$_A.areaid} /> 
        {/if}
    {/if}
    
	<div class="module_border">
		<div class="w">������</div>
		<div class="c">
			{editor name="description" type="sinaeditor" value="$_A.payment_result.description"}
		</div>
	</div>
    
    	
    
	
	<div class="module_submit" >
		<input type="hidden" name="nid" value="{ $_A.payment_result.nid }" />
		<input type="hidden" name="status" value="{ $_A.payment_result.status|default:1 }" />
		<input type="hidden" name="type" value="{ $_A.payment_result.type }" />
		{if $_A.query_type == "edit"}
		<input type="hidden" name="id" value="{ $magic.request.id }" />
		{/if}
		<input type="submit"  name="submit" value="ȷ���ύ" />
		<input type="reset"  name="reset" value="���ñ�" />
	</div>
	
</div>
</form>
{literal}
<script>
function change(type){
	if (type==1){
		$("#fee").hide();
		$("#fee_money").show();
	}else{
		$("#fee_money").hide();
		$("#fee").show();
	}

}
function check_form(){
/*
	 var frm = document.forms['form1'];
	 var title = frm.elements['name'].value;
	 var errorMsg = '';
	  if (title.length == 0 ) {
		errorMsg += '���������д' + '\n';
	  }
	  if (errorMsg.length > 0){
		alert(errorMsg); return false;
	  } else{  
		return true;
	  }
	  */
}

</script>
{/literal}

{elseif $_A.query_type == "all" }
<table  border="0"  cellspacing="1" bgcolor="#CCCCCC" width="100%">
	<form action="{$_A.query_url}/action{$_A.site_url}" method="post">
	<tr >
		<td width="*" class="main_td">֧��LOGO</td>
		<td width="*" class="main_td">֧������</td>
		<td width="*" class="main_td">֧������</td>
		<td width="" class="main_td">����</td>
	</tr>
	{ foreach  from=$_A.payment_list key=key item=item}
		<tr class="tr1">
		<td><img src="{ $item.logo}" height="50" /></td>
		<td>{$item.name}</td>
		<td align="left">{$item.description}</td>
		<td>{if $item.type==1}<a href="{$_A.query_url}/start{$_A.site_url}&nid={$item.nid}" >����</a>{else}<a href="{$_A.query_url}/new{$_A.site_url}&nid={$item.nid}" >���</a>{/if}</td>
		</tr>
		{ /foreach}
		
	</form>	
</table>

{elseif $_A.query_type == "list" }
<table  border="0"  cellspacing="1" bgcolor="#CCCCCC" width="100%">
	<form action="{$_A.query_url}/action{$_A.site_url}" method="post">
	<tr >
		<td width="*" class="main_td">֧��LOGO</td>
		<td width="*" class="main_td">֧������</td>
		<td width="*" class="main_td">֧������</td>
        <td width="*" class="main_td">����վ</td>
		<td width="" class="main_td">����</td>
	</tr>
	{ foreach  from=$_A.payment_list key=key item=item}
		<tr class="tr1">
		<td><img src="{ $item.logo}" height="50" /></td>
		<td>{$item.name}</td>
		<td align="left">{$item.description}</td>
        <td align="center">{if $item.nid=='offline'}{$item.sitename}{/if}</td>
		<td><a href="{$_A.query_url}/edit{$_A.site_url}&nid={$item.nid}&id={$item.id}" >����</a> |  <a href="#" onClick="javascript:if(confirm('ȷ��Ҫɾ����?ɾ���󽫲��ɻָ�')) location.href='{$_A.query_url}/del{$_A.site_url}&id={$item.id}'">ɾ��</a> | {if $item.status==1}<a href="{$_A.query_url}/list{$_A.site_url}&nid={$item.nid}&id={$item.id}&status=0" >ͣ��</a>{else}<a href="{$_A.query_url}/list{$_A.site_url}&nid={$item.nid}&id={$item.id}&status=1" >����</a>{/if} </td>
		</tr>
		{ /foreach}
		
	</form>
</table>
{/if}