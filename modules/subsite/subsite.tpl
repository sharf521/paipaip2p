{if $_A.query_type == "new" || $_A.query_type == "edit"}
<div class="module_add">

	<form action="" method="post"  name="form1" enctype="multipart/form-data">
	<div class="module_title"><strong>{ if $_A.query_type == "edit" }�༭{else}���{/if}{$_A.list_title}</strong></div>
	
	<div class="module_border">
		<div class="l">���ڵأ�</div>
		<div class="c">
			<script src="./plugins/index.php?&q=area&area={$_A.subsite_result.area}" type='text/javascript' language="javascript"></script>
		</div>
	</div>
	
	<div class="module_border">
		<div class="l">�Ƿ�ͨ��վ��</div>
		<div class="c">
			<input type="checkbox" name="subsite" value="1" {if $_A.subsite_result.subsite==1} checked="checked"{/if} />
		</div>
	</div>
	
	<div class="module_border">
		<div class="l">��վ������</div>
		<div class="c">
			<input type="text" name="website"  class="input_border" value="{ $_A.subsite_result.website}" size="30" />(����ǰ��Ҫ���http://)
		</div>
	</div>
	
	<div class="module_border">
		<div class="l">��վģ�壺</div>
		<div class="c">
			{linkages nid="system_themes" value="$_A.subsite_result.template" name="template" type="value" }
		</div>
	</div>
	
	<div class="module_border">
		<div class="l">��վ���ƣ�</div>
		<div class="c">
			<input type="text" name="sitename"  class="input_border" value="{ $_A.subsite_result.sitename}" size="30" />
		</div>
	</div>
    <div class="module_border">
		<div class="l">��˾���ƣ�</div>
		<div class="c">
			<input type="text" name="sitecompany"  class="input_border" value="{ $_A.subsite_result.sitecompany}" size="30" />
		</div>
	</div>
    <div class="module_border">
		<div class="l">Ӫҵִ�պţ�</div>
		<div class="c">
			<input type="text" name="sitecompanyno"  class="input_border" value="{ $_A.subsite_result.sitecompanyno}" size="30" />
		</div>
	</div>
	
	<div class="module_border">
		<div class="l">��վICP��</div>
		<div class="c">
			<input type="text" name="siteicp"  class="input_border" value="{ $_A.subsite_result.siteicp}" size="30" />
		</div>
	</div>
	
	<div class="module_border">
		<div class="l">LOGO�ϴ�:</div>
		<div class="c">
			<input type="file" name="sitelogo"  class="input_border" size="20" />{if $_A.subsite_result.sitelogo!=""}<a href="./{$_A.subsite_result.sitelogo}" target="_blank" title="��ͼƬ"><img src="{ $tpldir }/images/ico_1.jpg" border="0"  /></a>{/if}
		</div>
	</div>
		
	<div class="module_border">
		<div class="l">��վ��ַ��</div>
		<div class="c">
			<input type="text" name="siteaddr"  class="input_border" value="{ $_A.subsite_result.siteaddr}" size="30" />
		</div>
	</div>
	<div class="module_border">
		<div class="l">��վ�ͷ��绰��</div>
		<div class="c">
			<input type="text" name="sitetel"  class="input_border" value="{ $_A.subsite_result.sitetel}" size="30" />
		</div>
	</div>
	<div class="module_border">
		<div class="l">��վ�ʱࣺ</div>
		<div class="c">
			<input type="text" name="sitepost"  class="input_border" value="{ $_A.subsite_result.sitepost}" size="30" />
		</div>
	</div>
	<div class="module_border">
		<div class="l">��վ���֣�</div>
	</div>	
	<div class="module_border">
		<div class="l">���ñ꣺</div>
		<div class="c">
			<input type="checkbox" name="credit_biao_available" value="1" {if $_A.subsite_result.credit_biao_available==1} checked="checked"{/if} />
		</div>
		<div class="l">��ת�꣺</div>
		<div class="c">
			<input type="checkbox" name="zhouzhuan_biao_available" value="1" {if $_A.subsite_result.zhouzhuan_biao_available==1} checked="checked"{/if} />
		</div>
		<div class="l">����꣺</div>
		<div class="c">
			<input type="checkbox" name="restructuring_biao_available" value="1" {if $_A.subsite_result.restructuring_biao_available==1} checked="checked"{/if} />
		</div>
		<div class="l">�����꣺</div>
		<div class="c">
			<input type="checkbox" name="vouch_biao_available" value="1" {if $_A.subsite_result.vouch_biao_available==1} checked="checked"{/if} />
		</div>
		<div class="l">��ֵ�꣺</div>
		<div class="c">
			<input type="checkbox" name="jin_biao_available" value="1" {if $_A.subsite_result.jin_biao_available==1} checked="checked"{/if} />
		</div>
		<div class="l">��꣺</div>
		<div class="c">
			<input type="checkbox" name="miao_biao_available" value="1" {if $_A.subsite_result.miao_biao_available==1} checked="checked"{/if} />
		</div>
		<div class="l">��Ѻ�꣺</div>
		<div class="c">
			<input type="checkbox" name="fast_biao_available" value="1" {if $_A.subsite_result.fast_biao_available==1} checked="checked"{/if} />
		</div>
		<div class="l">��Ѻ�꣺</div>
		<div class="c">
			<input type="checkbox" name="pledge_biao_available" value="1" {if $_A.subsite_result.pledge_biao_available==1} checked="checked"{/if} />
		</div>
		<div class="l">��ת�꣺</div>
		<div class="c">
			<input type="checkbox" name="circulation_biao_available" value="1" {if $_A.subsite_result.circulation_biao_available==1} checked="checked"{/if} />
		</div>
		<div class="l">���ı꣺</div>
		<div class="c">
			<input type="checkbox" name="love_biao_available" value="1" {if $_A.subsite_result.love_biao_available==1} checked="checked"{/if} />
		</div>
        <div class="l">���ձ꣺</div>
		<div class="c">
			<input type="checkbox" name="safety_biao_available" value="1" {if $_A.subsite_result.safety_biao_available==1} checked="checked"{/if} />
		</div>
	</div>
	
	
	<div class="module_border">
		<div class="l">��վ��Ӧ�����̳�������</div>
		<div class="c">
			<input type="text" name="mall_url"  class="input_border" value="{ $_A.subsite_result.mall_url}" size="30" />ע����ǰ�治Ҫ��http://����β��Ҫ��/)
		</div>
	</div>	
	<div class="module_border">
		<div class="l">��վ��Ӧ�����̳�������</div>
		<div class="c">
			<input type="text" name="jf_mall_url"  class="input_border" value="{ $_A.subsite_result.jf_mall_url}" size="30" />ע����ǰ�治Ҫ��http://����β��Ҫ��/)
		</div>
	</div>	

	<div class="module_border">
		<div class="l">��վVIP�������ͣ�</div>
		<div class="c">
			<input name="vip_award_type" type="radio" value="0"  {if $_A.subsite_result.vip_award_type==0} checked="checked"{/if}/><label for="">����VIP�����</label> 
			<input name="vip_award_type" type="radio" value="1"  {if $_A.subsite_result.vip_award_type==1} checked="checked"{/if}/><label for="">�����˻�����</label> 
			<input name="vip_award_type" type="radio" value="2"  {if $_A.subsite_result.vip_award_type==2} checked="checked"{/if}/><label for="">webservice�ӱ�����</label> 
			<input name="vip_award_type" type="radio" value="3"  {if $_A.subsite_result.vip_award_type==3} checked="checked"{/if}/><label for="">webservice�ȶ��</label> 
		</div>
	</div>	

	<div class="module_border">
		<div class="l">ֻ��ʾ��վ�������꣺</div>
		<div class="c">
			<input type="checkbox" name="only_show_sitebiao" value="1" {if $_A.subsite_result.only_show_sitebiao==1} checked="checked"{/if} />
		</div>
	</div>
	<div class="module_border">
		<div class="l">ֻ��ʾ��վ�û�����ծȨת�ã�</div>
		<div class="c">
			<input type="checkbox" name="only_show_siteright" value="1" {if $_A.subsite_result.only_show_siteright==1} checked="checked"{/if} />
		</div>
	</div>
	<div class="module_border">
		<div class="l">���ö��ţ�</div>
		<div class="c">
			<input type="checkbox" name="sms_available" value="1" {if $_A.subsite_result.sms_available==1} checked="checked"{/if} />
		</div>
	</div>
	
	<div class="module_border">
		<div class="l">����</div>
		<div class="c">
			<input type="text" name="order"  class="input_border" value="{ $_A.subsite_result.order|default:10}" size="10" />
		</div>
	</div>

	<div class="module_border">
		<div class="l">��վ���⣨webҳ��title)��</div>
		<div class="c">
			<input type="text" name="sitetitle"  class="input_border" value="{ $_A.subsite_result.sitetitle}" size="30" />
		</div>
	</div>	
	
	<div class="module_border">
		<div class="l">��վ�ؼ��ʣ�webҳ��keywords)��</div>
		<div class="c">
			<textarea name="sitekeywords" cols="45" rows="5">{ $_A.subsite_result.sitekeywords}</textarea>
		</div>
	</div>	
	
	<div class="module_border">
		<div class="l">��վ������webҳ��description)��</div>
		<div class="c">
			<textarea name="sitedesc" cols="45" rows="5">{ $_A.subsite_result.sitedesc}</textarea>
		</div>
	</div>			
	<div class="module_title">��������</div>	
	<div class="module_border">
		<div class="l">SMTP��������</div>
		<div class="c">
			<input type="text" name="site_email_host"  class="input_border" value="{ $_A.subsite_result.site_email_host}" size="30" />
		</div>
	</div>	
	<div class="module_border">
		<div class="l">SMTP�������Ƿ���Ҫ��֤��</div>
		<div class="c">
			<input type="checkbox" name="site_email_auth" value="1" {if $_A.subsite_result.site_email_auth==1} checked="checked"{/if} />
		</div>
	</div>	
		<div class="module_border">
		<div class="l">�����ַ��</div>
		<div class="c">
			<input type="text" name="site_email"  class="input_border" value="{ $_A.subsite_result.site_email}" size="30" />
		</div>
	</div>	
		<div class="module_border">
		<div class="l">�������룺</div>
		<div class="c">
			<input type="password" name="site_email_pwd"  class="input_border" value="{ $_A.subsite_result.site_email_pwd}" size="30" />
		</div>
	</div>	
	<div class="module_title">��������</div>	
	<div class="module_border">
		<div class="l">ͳ�ƴ��룺</div>
		<div class="c">
			<textarea name="statistics_code" cols="45" rows="5">{ $_A.subsite_result.statistics_code}</textarea>
		</div>
	</div>	
    <div class="module_border">
		<div class="l">һ����Ⱥ���룺</div>
		<div class="c">
			<textarea name="qqgroup_code" cols="45" rows="5">{ $_A.subsite_result.qqgroup_code}</textarea>
		</div>
	</div>
    <div class="module_border">
		<div class="l">��ע��</div>
		<div class="c">
			<textarea name="site_remark" cols="45" rows="5">{ $_A.subsite_result.site_remark}</textarea>
		</div>
	</div>			
	<div class="module_submit border_b" >
		<input type="hidden" name="pid" value="{$magic.request.pid|default:0}" />
		{ if $_A.query_type == "edit" }<input type="hidden" name="id" value="{ $_A.subsite_result.id }" />{/if}
		<input type="submit"  name="submit" value="ȷ���ύ" />
	</div>
	</form>
</div>
{literal}
<script>
function check_form(){
	 var frm = document.forms['form1'];
	 var province = frm.elements['province'].value;
	 var city = frm.elements['city'].value;
	 var area = frm.elements['area'].value;
	 var errorMsg = '';
	 
	  if ((province+city+area).length == 0 ) {
		errorMsg += '����ָ����վ���ڵ�' + '\n';
	  }

	  if (errorMsg.length > 0){
		alert(errorMsg); return false;
	  } else{  
		return true;
	  }
}
</script>
{/literal}
{elseif $_A.query_type == "list"}
 <table  border="0"  cellspacing="1" bgcolor="#CCCCCC" width="100%">
	<tr >
		<td class="main_td">ID</td>
		<td class="main_td">��վ</td>
		<td class="main_td">��վLOGO</td>
		<td class="main_td">��վ����</td>
		<td class="main_td">��վģ��</td>
		<td class="main_td">��ͨ��վ</td>
		<td class="main_td">����</td>
	</tr>
	{ foreach  from=$_A.area_list key=key item=item}
	<tr {if $key%2==1} class="tr2"{/if}>
		<td class="main_td1" align="center">{$item.id}</td>
		<td class="main_td1" align="center" >{$item.sitename}</td>
		<td class="main_td1" align="center" >{if $item.sitelogo!=""}<a href="./{$item.sitelogo}" target="_blank"><img height="20" src="./{$item.sitelogo}" border="0" /></a>{else}��logo{/if}</td>
		<td class="main_td1" align="center" >{$item.website}</td>
		<td class="main_td1" align="center" >{$item.template}</td>
		<td class="main_td1" align="center" ><input type="checkbox" name="subsite" disabled value="1" {if $item.subsite==1} checked="checked"{/if} /></td>
		<td class="main_td1" align="center" width="130"><a href="{$_A.query_url}/edit&pid={$item.pid}&id={$item.id}{$_A.site_url}">�޸�</a> / <a href="#" onClick="javascript:if(confirm('ȷ��Ҫɾ����?ɾ���󽫲��ɻָ�')) location.href='{$_A.query_url}/del&id={$item.id}{$_A.site_url}'">ɾ��</a></td>
	</tr>
	{ /foreach}
	<tr >
		<td colspan="8" class="page"  height="30">
			{$_A.showpage}
		</td>
	</tr>
	</form>	
</table>
{/if}
