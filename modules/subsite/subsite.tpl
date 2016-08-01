{if $_A.query_type == "new" || $_A.query_type == "edit"}
<div class="module_add">

	<form action="" method="post"  name="form1" enctype="multipart/form-data">
	<div class="module_title"><strong>{ if $_A.query_type == "edit" }编辑{else}添加{/if}{$_A.list_title}</strong></div>
	
	<div class="module_border">
		<div class="l">所在地：</div>
		<div class="c">
			<script src="./plugins/index.php?&q=area&area={$_A.subsite_result.area}" type='text/javascript' language="javascript"></script>
		</div>
	</div>
	
	<div class="module_border">
		<div class="l">是否开通分站：</div>
		<div class="c">
			<input type="checkbox" name="subsite" value="1" {if $_A.subsite_result.subsite==1} checked="checked"{/if} />
		</div>
	</div>
	
	<div class="module_border">
		<div class="l">分站域名：</div>
		<div class="c">
			<input type="text" name="website"  class="input_border" value="{ $_A.subsite_result.website}" size="30" />(域名前不要添加http://)
		</div>
	</div>
	
	<div class="module_border">
		<div class="l">分站模板：</div>
		<div class="c">
			{linkages nid="system_themes" value="$_A.subsite_result.template" name="template" type="value" }
		</div>
	</div>
	
	<div class="module_border">
		<div class="l">分站名称：</div>
		<div class="c">
			<input type="text" name="sitename"  class="input_border" value="{ $_A.subsite_result.sitename}" size="30" />
		</div>
	</div>
    <div class="module_border">
		<div class="l">公司名称：</div>
		<div class="c">
			<input type="text" name="sitecompany"  class="input_border" value="{ $_A.subsite_result.sitecompany}" size="30" />
		</div>
	</div>
    <div class="module_border">
		<div class="l">营业执照号：</div>
		<div class="c">
			<input type="text" name="sitecompanyno"  class="input_border" value="{ $_A.subsite_result.sitecompanyno}" size="30" />
		</div>
	</div>
	
	<div class="module_border">
		<div class="l">分站ICP：</div>
		<div class="c">
			<input type="text" name="siteicp"  class="input_border" value="{ $_A.subsite_result.siteicp}" size="30" />
		</div>
	</div>
	
	<div class="module_border">
		<div class="l">LOGO上传:</div>
		<div class="c">
			<input type="file" name="sitelogo"  class="input_border" size="20" />{if $_A.subsite_result.sitelogo!=""}<a href="./{$_A.subsite_result.sitelogo}" target="_blank" title="有图片"><img src="{ $tpldir }/images/ico_1.jpg" border="0"  /></a>{/if}
		</div>
	</div>
		
	<div class="module_border">
		<div class="l">分站地址：</div>
		<div class="c">
			<input type="text" name="siteaddr"  class="input_border" value="{ $_A.subsite_result.siteaddr}" size="30" />
		</div>
	</div>
	<div class="module_border">
		<div class="l">分站客服电话：</div>
		<div class="c">
			<input type="text" name="sitetel"  class="input_border" value="{ $_A.subsite_result.sitetel}" size="30" />
		</div>
	</div>
	<div class="module_border">
		<div class="l">分站邮编：</div>
		<div class="c">
			<input type="text" name="sitepost"  class="input_border" value="{ $_A.subsite_result.sitepost}" size="30" />
		</div>
	</div>
	<div class="module_border">
		<div class="l">分站标种：</div>
	</div>	
	<div class="module_border">
		<div class="l">信用标：</div>
		<div class="c">
			<input type="checkbox" name="credit_biao_available" value="1" {if $_A.subsite_result.credit_biao_available==1} checked="checked"{/if} />
		</div>
		<div class="l">周转标：</div>
		<div class="c">
			<input type="checkbox" name="zhouzhuan_biao_available" value="1" {if $_A.subsite_result.zhouzhuan_biao_available==1} checked="checked"{/if} />
		</div>
		<div class="l">重组标：</div>
		<div class="c">
			<input type="checkbox" name="restructuring_biao_available" value="1" {if $_A.subsite_result.restructuring_biao_available==1} checked="checked"{/if} />
		</div>
		<div class="l">担保标：</div>
		<div class="c">
			<input type="checkbox" name="vouch_biao_available" value="1" {if $_A.subsite_result.vouch_biao_available==1} checked="checked"{/if} />
		</div>
		<div class="l">净值标：</div>
		<div class="c">
			<input type="checkbox" name="jin_biao_available" value="1" {if $_A.subsite_result.jin_biao_available==1} checked="checked"{/if} />
		</div>
		<div class="l">秒标：</div>
		<div class="c">
			<input type="checkbox" name="miao_biao_available" value="1" {if $_A.subsite_result.miao_biao_available==1} checked="checked"{/if} />
		</div>
		<div class="l">抵押标：</div>
		<div class="c">
			<input type="checkbox" name="fast_biao_available" value="1" {if $_A.subsite_result.fast_biao_available==1} checked="checked"{/if} />
		</div>
		<div class="l">质押标：</div>
		<div class="c">
			<input type="checkbox" name="pledge_biao_available" value="1" {if $_A.subsite_result.pledge_biao_available==1} checked="checked"{/if} />
		</div>
		<div class="l">流转标：</div>
		<div class="c">
			<input type="checkbox" name="circulation_biao_available" value="1" {if $_A.subsite_result.circulation_biao_available==1} checked="checked"{/if} />
		</div>
		<div class="l">爱心标：</div>
		<div class="c">
			<input type="checkbox" name="love_biao_available" value="1" {if $_A.subsite_result.love_biao_available==1} checked="checked"{/if} />
		</div>
        <div class="l">保险标：</div>
		<div class="c">
			<input type="checkbox" name="safety_biao_available" value="1" {if $_A.subsite_result.safety_biao_available==1} checked="checked"{/if} />
		</div>
	</div>
	
	
	<div class="module_border">
		<div class="l">分站对应供销商城域名：</div>
		<div class="c">
			<input type="text" name="mall_url"  class="input_border" value="{ $_A.subsite_result.mall_url}" size="30" />注：（前面不要加http://，结尾不要带/)
		</div>
	</div>	
	<div class="module_border">
		<div class="l">分站对应积分商城域名：</div>
		<div class="c">
			<input type="text" name="jf_mall_url"  class="input_border" value="{ $_A.subsite_result.jf_mall_url}" size="30" />注：（前面不要加http://，结尾不要带/)
		</div>
	</div>	

	<div class="module_border">
		<div class="l">分站VIP奖励类型：</div>
		<div class="c">
			<input name="vip_award_type" type="radio" value="0"  {if $_A.subsite_result.vip_award_type==0} checked="checked"{/if}/><label for="">返还VIP申请费</label> 
			<input name="vip_award_type" type="radio" value="1"  {if $_A.subsite_result.vip_award_type==1} checked="checked"{/if}/><label for="">邀请人获得提成</label> 
			<input name="vip_award_type" type="radio" value="2"  {if $_A.subsite_result.vip_award_type==2} checked="checked"{/if}/><label for="">webservice加倍返还</label> 
			<input name="vip_award_type" type="radio" value="3"  {if $_A.subsite_result.vip_award_type==3} checked="checked"{/if}/><label for="">webservice等额返还</label> 
		</div>
	</div>	

	<div class="module_border">
		<div class="l">只显示分站所发借款标：</div>
		<div class="c">
			<input type="checkbox" name="only_show_sitebiao" value="1" {if $_A.subsite_result.only_show_sitebiao==1} checked="checked"{/if} />
		</div>
	</div>
	<div class="module_border">
		<div class="l">只显示分站用户所发债权转让：</div>
		<div class="c">
			<input type="checkbox" name="only_show_siteright" value="1" {if $_A.subsite_result.only_show_siteright==1} checked="checked"{/if} />
		</div>
	</div>
	<div class="module_border">
		<div class="l">启用短信：</div>
		<div class="c">
			<input type="checkbox" name="sms_available" value="1" {if $_A.subsite_result.sms_available==1} checked="checked"{/if} />
		</div>
	</div>
	
	<div class="module_border">
		<div class="l">排序：</div>
		<div class="c">
			<input type="text" name="order"  class="input_border" value="{ $_A.subsite_result.order|default:10}" size="10" />
		</div>
	</div>

	<div class="module_border">
		<div class="l">分站标题（web页面title)：</div>
		<div class="c">
			<input type="text" name="sitetitle"  class="input_border" value="{ $_A.subsite_result.sitetitle}" size="30" />
		</div>
	</div>	
	
	<div class="module_border">
		<div class="l">分站关键词（web页面keywords)：</div>
		<div class="c">
			<textarea name="sitekeywords" cols="45" rows="5">{ $_A.subsite_result.sitekeywords}</textarea>
		</div>
	</div>	
	
	<div class="module_border">
		<div class="l">分站描述（web页面description)：</div>
		<div class="c">
			<textarea name="sitedesc" cols="45" rows="5">{ $_A.subsite_result.sitedesc}</textarea>
		</div>
	</div>			
	<div class="module_title">邮箱配置</div>	
	<div class="module_border">
		<div class="l">SMTP服务器：</div>
		<div class="c">
			<input type="text" name="site_email_host"  class="input_border" value="{ $_A.subsite_result.site_email_host}" size="30" />
		</div>
	</div>	
	<div class="module_border">
		<div class="l">SMTP服务器是否需要验证：</div>
		<div class="c">
			<input type="checkbox" name="site_email_auth" value="1" {if $_A.subsite_result.site_email_auth==1} checked="checked"{/if} />
		</div>
	</div>	
		<div class="module_border">
		<div class="l">邮箱地址：</div>
		<div class="c">
			<input type="text" name="site_email"  class="input_border" value="{ $_A.subsite_result.site_email}" size="30" />
		</div>
	</div>	
		<div class="module_border">
		<div class="l">邮箱密码：</div>
		<div class="c">
			<input type="password" name="site_email_pwd"  class="input_border" value="{ $_A.subsite_result.site_email_pwd}" size="30" />
		</div>
	</div>	
	<div class="module_title">其它设置</div>	
	<div class="module_border">
		<div class="l">统计代码：</div>
		<div class="c">
			<textarea name="statistics_code" cols="45" rows="5">{ $_A.subsite_result.statistics_code}</textarea>
		</div>
	</div>	
    <div class="module_border">
		<div class="l">一键加群代码：</div>
		<div class="c">
			<textarea name="qqgroup_code" cols="45" rows="5">{ $_A.subsite_result.qqgroup_code}</textarea>
		</div>
	</div>
    <div class="module_border">
		<div class="l">备注：</div>
		<div class="c">
			<textarea name="site_remark" cols="45" rows="5">{ $_A.subsite_result.site_remark}</textarea>
		</div>
	</div>			
	<div class="module_submit border_b" >
		<input type="hidden" name="pid" value="{$magic.request.pid|default:0}" />
		{ if $_A.query_type == "edit" }<input type="hidden" name="id" value="{ $_A.subsite_result.id }" />{/if}
		<input type="submit"  name="submit" value="确认提交" />
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
		errorMsg += '必须指定分站所在地' + '\n';
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
		<td class="main_td">分站</td>
		<td class="main_td">分站LOGO</td>
		<td class="main_td">分站域名</td>
		<td class="main_td">分站模板</td>
		<td class="main_td">开通分站</td>
		<td class="main_td">操作</td>
	</tr>
	{ foreach  from=$_A.area_list key=key item=item}
	<tr {if $key%2==1} class="tr2"{/if}>
		<td class="main_td1" align="center">{$item.id}</td>
		<td class="main_td1" align="center" >{$item.sitename}</td>
		<td class="main_td1" align="center" >{if $item.sitelogo!=""}<a href="./{$item.sitelogo}" target="_blank"><img height="20" src="./{$item.sitelogo}" border="0" /></a>{else}无logo{/if}</td>
		<td class="main_td1" align="center" >{$item.website}</td>
		<td class="main_td1" align="center" >{$item.template}</td>
		<td class="main_td1" align="center" ><input type="checkbox" name="subsite" disabled value="1" {if $item.subsite==1} checked="checked"{/if} /></td>
		<td class="main_td1" align="center" width="130"><a href="{$_A.query_url}/edit&pid={$item.pid}&id={$item.id}{$_A.site_url}">修改</a> / <a href="#" onClick="javascript:if(confirm('确定要删除吗?删除后将不可恢复')) location.href='{$_A.query_url}/del&id={$item.id}{$_A.site_url}'">删除</a></td>
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
