<?php
!defined('IN_TEMPLATE') && exit('Access Denied');
?>
{include file="user_header.html"}
<link href="{$tempdir}/media/css/modal.css" rel="stylesheet" type="text/css" />
<!--�û����ĵ�����Ŀ ��ʼ-->
 <div id="main" class="clearfix" style="margin-top:5px;">
<div class="wrap950 " >
	<!--��ߵĵ��� ��ʼ-->
	<div class="user_left">
		{include file="user_menu.html"}
	</div>
	<!--��ߵĵ��� ����-->
	{article module="borrow" function="GetUserAllAccountInfo" user_id=0 var="acc"}
	<!--�ұߵ����� ��ʼ-->
	<div class="user_right ">

		<div class="user_right_l ">
		{if $_G.user_result.real_status==0}
		<div class="alert alert-error" id="user_amange">
		 <a class="close" data-dismiss="alert">��</a>
			{$_G.system.con_webname}�����㣺�㻹û�н���ʵ����֤��
			<a href="/index.php?user&q=code/user/realname"><strong>���Ƚ���ʵ����֤</strong>
			</a>
			</div>
		{/if}
		{if $_G.user_result.is_restructuring==1}
		<div class="alert alert-error" id="user_amange">
		 <a class="close" data-dismiss="alert">��</a>
		����ǰ����ծ������״̬�����ܷ���ͨ�꣬����Ͷ�꣬���ܵ������������֡�������ƽ̨����ծ�񳥻���Ϻ󣬴�״̬�Զ�ȡ����
		</div>
		{/if}
			<div class="user_right_lmain">
				<div class="user_right_img">
					<img src="{$_G.user_id|avatar}" height="97" width="97" class="picborder" style="border:1px dashed #000" />
					<a href="index.php?user&q=code/user/avatar" ><font color="#FF0000">[����ͷ��]</font></a>
				</div>
				<div class="user_right_txt">
					<ul>
                                            <li class="user_right_txt_a"><div class="floatl"><span >���õȼ���</span></div><a style="float: left;" href="/index.php?user&q=code/user/credit">{$_U.user_cache.credit|credit}</a><font color="red">{$_U.user_cache.credit}��</font>
                                            {article module="user" function="GetOne" user_id="0"}
                                            {$var.typename}
                                            {/article}
											 
                                            </li>
						<li style="overflow:hidden">
							<div class="floatl" ><span> ��&nbsp;&nbsp;&nbsp;   ֤��</span></div> 
							<a href="/index.php?user&q=code/user/realname"><div class="credit_pic_card_{$_G.user_result.real_status|default:0}" title="{if $_G.user_result.real_status==1}ʵ������֤{else}δʵ����֤{/if}"></div></a>
                            <a href="/index.php?user&q=code/user/phone_status" ><div class="credit_pic_phone_{if $_G.user_result.phone_status==1}1{else}0{/if}" title="{if $_G.user_result.phone_status==1}�ֻ�����֤{else}�ֻ�δ��֤{/if}"></div></a>
							<a href="/index.php?user&q=code/user/email_status"><div class="credit_pic_email_{$_G.user_result.email_status|default:0}" title="{if $_G.user_result.email_status==1}��������֤{else}����δ��֤{/if}"></div></a>
							<a href="/index.php?user&q=code/user/video_status"><div class="credit_pic_video_{$_G.user_result.video_status|default:0}" title="{if $_G.user_result.video_status==1}��Ƶ����֤{else}��Ƶδ��֤{/if}"></div></a>
							<a href="/vip/index.html"><div class="credit_pic_vip_{if $_G.user_result.vip_status==1}1{else}0{/if}" title="{if $_G.user_result.vip_status==1}VIP{else}��ͨ��Ա{/if}"></div></a>
							<a href="/index.php?user&q=code/user/scene_status"><div class="credit_pic_scene_{$_G.user_result.scene_status|default:0}" title="{if $_G.user_result.scene_status==1}��ͨ���ֳ���֤{else}δͨ���ֳ���֤{/if}"></div></a>
							<a href="/index.php?user&q=code/account/stock_manage"><div class="credit_pic_stock_{if $_G.user_result.stock > 0}1{else}0{/if}" ></div></a>
							<a href="/index.php?user&q=code/attestation/one&type=3"><div class="credit_pic_credit_{$_G.user_result.credit_status|default:0}" ></div></a>
							
						</li>

						<li>   
                                                    <!--
                                                    <a href="/index.php?user&q=code/borrow/limitapp&type=credit"><font color="#FF0000">�������ö��</font></a>
                                                    <a href="/index.php?user&q=code/borrow/limitapp&type=vouch"><font color="#FF0000">���뵣�����</font></a> -->
                                                    
                                                    <span style="color:red"> ���ö�ȣ�<font size="2">��{$acc.credit|default:0}</font>    </span>
                                                   <!--<span style="color:red"> ������ȣ�<font size="2">��{$acc.borrow_vouch|default:0}</font>    </span>
                                                   <span style="color:red"> Ͷ�ʵ�����ȣ�<font size="2">��{$acc.tender_vouch|default:0}</font>    </span>-->
              

                                                </li>
						<li><span>VIP ���ޣ� <a href="/vip/index.html">{if $_G.user_result.vip_status==1}
                                                            {$_G.user_result.vip_verify_time|date_format:"Y-m-d"} �� 
						{$_G.user_result.vip_verify_time+60*60*24*365|date_format:"Y-m-d"}
                                                
                                                            {elseif $_G.user_result.vip_status==-1}VIP�����{else}<font color="#999999">����VIP</font></font>{/if}</a></li>
						<li><span>ϵͳ��֪��</span><a href="/index.php?user&q=code/message"><font color="#FF0000">{$_U.user_cache.message}</font> ��δ����Ϣ</a>&nbsp; &nbsp; <a href="/index.php?user&q=code/user/request">{$_U.user_cache.friends_apply} ����������</a>
                                                <a href="/index.php?user&q=code/account/recharge_new"><font color="#FF0000">[�˺ų�ֵ]</font></a>
                                                {if in_array("credit", $biaotype_list) }   
                                                <a href="/index.php?user&q=code/borrow/limitapp&type=credit"><font color="#FF0000">[�������]</font></a>
                                                {/if}
                                                </li>
					</ul>
				</div>
			</div>
			<div style=" margin-top:10px; line-height:22px; display:none">�ϴε�¼IP��{$_G.user_result.upip}  <br />
            							�ϴε�¼ʱ�䣺{$_G.user_result.uptime|date_format:"Y-m-d H:i"}</div>
			<div class="user_right_li">
				<div class="title">

                                    <a href="/index.php?user&q=code/account">�˺�����</a> {if $_G.user_result.vip_status==1}{else}(<a href="/vip/index.html"><font color="#FF0000">�����ΪVIP��Ա</font></a></font>){/if}</div>
				<div class="content">
				
					
<table >
  <tr>
    <td width="33%"> �˻��ܶ<font>��{$acc.total|default:0}</font></td>
    <td width="65%"><a href="index.php?user&amp;q=code/account/log">�ʽ���ϸ</a> | <a href="index.php?user&amp;q=code/account">�˻��ʽ�����</a> </td>
  </tr>
  <tr>
    <td>������<font>��{$acc.use_money|default:0}</font></td>
    <td width="65%"><a href="index.php?user&amp;q=code/account/cash_new"><font style="font-size:12px;" ><strong>����</strong></font></a> <a href="index.php?user&amp;q=code/account/recharge_new"><font style="font-size:12px;" ><strong>��ֵ</strong></font> </a> <a href="/index.php?user&amp;q=code/account/bank">
            
            &nbsp;�����˻����� </a> <a href="/index.php?user&amp;q=code/account/recharge">
                &nbsp;��ֵ��¼��ѯ </a>
        &nbsp;<a href="/index.php?user&amp;q=code/account/cash">���ּ�¼��ѯ </a> </td>
  </tr>
  <tr>
    <td>�����ܶ<font>��{$acc.no_use_money|default:0}</font></td>
    <td width="65%"><a href="/index.php?user&amp;q=code/borrow/bid">���ڽ��е�Ͷ��</a> <a href="/index.php?user&amp;q=code/account/cash">�������������</a> 
    <?php  /*
    <a href="index.php?user&q=code/account/l2m&trantype=amount"><strong><font color="red">���̳�ת��</font></strong></a> */ ?></td>
  </tr>
  <tr>
    <td>���������ܶ<font>��{$acc.nocash_money|default:0}</font></td>
    <td width="65%">&nbsp;</td>
  </tr>
  <!--  add for bug 493 begin -->
  {if $_G.system.con_stock_valid=="1"}
  <tr>
    <td>��ǰӵ�еĹɷ�����<font>{$acc.stock|default:0}</font></td>
    <td width="65%">�ɷݼ�ֵ��<font>��{$acc.stock_value|default:0}</font>&nbsp;<a href="/index.php?user&q=code/account/stock_manage"><strong><font color="red">�ɷݹ���</font></strong></a></td>
  </tr>
  {/if}
  </table>
  <div class="title">���մ�������</div>
  <table>
  <tr>
    <td width="50%">�����ܶ<font>��{$acc.r_collection_total|default:0}</font></td>
    <td width="250px">������Ϣ��<font>��{$acc.r_collection_interest|default:0}</font></td>
  </tr>
  <tr>
    <td>������ս�<font>{$acc.r_collection_total_last|default:0}</font></td>
    <td width="65%">�������ʱ�䣺<font>{$acc.r_collection_last_time|date_format:"Y-m-d"}</font>
    <a href="index.php?user&q=code/borrow/gathering&status=0"><strong><font color="red">��Ҫ�տ�</font></strong></a></td>
  </tr>
  <tr>
    <td>��׬��Ϣ��<font>��{$acc.ed_interest|default:0}</font> </td>
    <td width="65%">��׬������<font>��{$acc.award_add|default:0}</font><!--���ۻ�ѣ�<font>��{if $_U.user_cache.vip_money=="" && $_G.user_result.vip_status==1}{$_G.system.con_vip_money}{else}0{/if}</font>--></td>
  </tr>
  <tr>
    <td>����ܶ<font>��{$acc.borrow_num|default:0}</font></td>
    <td width="65%">�����ܶ<font>��{$acc.wait_payment|default:0}</font> </td>
  </tr>
  <tr>
    <td>���������<font>��{$acc.new_repay_account|default:0}</font></td>
    <td width="65%">�������ʱ�䣺<font>{$acc.new_repay_time|date_format:"Y-m-d"|default:""}</font>
    <a href="index.php?user&q=code/borrow/repaymentplan"><strong><font color="red">��Ҫ����</font></strong></a></td>
  </tr>
  </table>
  <!--  add for bug 274 begin -->
  {if $_G.system.con_circulation=="1"}
  <div class="title">��ת������</div>
  <table>
  <tr>
    <td width="50%">���ع���ת�꣺<font>��{$acc.circulation_capital_c|default:0}</font></td>
    <td width="250px">������ת����Ϣ��<font>��{$acc.circulation_interest_c|default:0}</font></td>
  </tr>
  <tr>
    <td>��������ת�꣺<font>��{$acc.circulation_capital_r|default:0}</font></td>
    <td width="65%">��������ת����Ϣ��<font>��{$acc.circulation_interest_r|default:0}</font></td>
  </tr>
  </table>
  {/if}
  <!--  add for bug 274 end -->
  <div class="title">�������</div>
  <table>
  <tr>
    <td width="50%">���ö�ȣ�<font>��{$acc.credit|default:0}</font> </td>
    <td width="250px">�������ö�ȣ�<font>��{$acc.credit_use|default:0}</font></td>
  </tr>
  <!--<tr>
    <td>������ȣ�<font>��{$acc.borrow_vouch|default:0}</font></td>
    <td width="65%">���ý�����ȣ�<font>��{$acc.borrow_vouch_use|default:0}</font> </td>
  </tr>
  <tr>
    <td>Ͷ�ʵ�����ȣ�<font>��{$acc.tender_vouch|default:0}</font></td>
    <td width="65%">����Ͷ�ʵ�����ȣ�<font>��{$acc.tender_vouch_use|default:0}</font></td>
  </tr>
  <tr>
    <td>ծ�������ȣ�<font>��{$acc.restructuring|default:0}</font></td>
    <td width="65%">����ծ�������ȣ�<font>��{$acc.restructuring_use|default:0}</font></td>
  </tr>-->
  </table>
  <!--  add for bug 274 begin -->
  {if $_G.system.con_recharge_activity=="1"}
  <div class="title">��ֵ��������</div>
  <table>
  <tr>
    <td width="50%">��ֵ������<font>��{$acc.award|default:0}</font></td>
    <td width="250px">���ó�ֵ������<font>��{$acc.use_award|default:0}</font></td>
  </tr>
  <tr>
    <td>��ֵ������׬��Ϣ��<font>��{$acc.award_interest|default:0}</font></td>
    <td width="65%"><a href="index.php?user&q=code/account/l2m&trantype=award"><strong><font color="red">���̳�ת��</font></strong></a> <a href="index.php?user&amp;q=code/account/awardlog">������־</a></td>
  </tr>
</table>
{/if}
<!--  add for bug 274 end -->
  
  <?php
  /*
  
  <div class="title">�����̳���Ϣ</div>
  <table>
  <tr>
    <td width="50%"><i style="float:left;font-style:normal;">�ʽ�</i><span  id="gx_mall_money" style="color:red"></span></td>
    <td width="250px"><i style="float:left;font-style:normal;">�����ʽ�</i><span  id="gx_mall_money_dj" style="color:red"></span>
    </td>
  </tr>
  <tr>
    <td><i style="float:left;font-style:normal;">���֣�</i><span  id="gx_mall_jifen" style="color:red"></span></td>
    <td width="65%"><i style="float:left;font-style:normal;">������֣�</i><span  id="gx_mall_jifen_dj" style="color:red"></span></td>
  </tr>
</table>
  <div class="title">�����̳���Ϣ</div>
  <table>
  <tr>
    <td width="50%"><i style="float:left;font-style:normal;">�ʽ�</i><span  id="jf_mall_money" style="color:red"></span></td>
    <td width="250px"><i style="float:left;font-style:normal;">�����ʽ�</i><span  id="jf_mall_money_dj" style="color:red"></span>
    </td>
  </tr>
  <tr>
    <td><i style="float:left;font-style:normal;">���֣�</i><span  id="jf_mall_jifen" style="color:red"></span></td>
    <td width="65%"><i style="float:left;font-style:normal;">������֣�</i><span  id="jf_mall_jifen_dj" style="color:red"></span></td>
    <span style="display: none"><input id="codetime" name="codetime" type="button" value="������֤��"/></span>
  </tr>
</table>
{literal}
				<script language="javascript">
				$("#codetime").click(function() {
					
					$.ajax({
							 url: "/index.php?user&q=code/account/get_mall_info",
						     //    timeout: 20000,
										 success: function(data){
										 var obj = $.parseJSON(data);
										 
										 document.getElementById('gx_mall_money').innerHTML="��"+obj.mallinfo.mall_money;
										 document.getElementById('gx_mall_money_dj').innerHTML="��"+obj.mallinfo.mall_money_dj;
										 document.getElementById('gx_mall_jifen').innerHTML=obj.mallinfo.mall_jifen;
										 document.getElementById('gx_mall_jifen_dj').innerHTML=obj.mallinfo.mall_jifen_dj;
										 
										 document.getElementById('jf_mall_money').innerHTML="��"+obj.jf_mallinfo.mall_money;
										 document.getElementById('jf_mall_money_dj').innerHTML="��"+obj.jf_mallinfo.mall_money_dj;
										 document.getElementById('jf_mall_jifen').innerHTML=obj.jf_mallinfo.mall_jifen;
										 document.getElementById('jf_mall_jifen_dj').innerHTML=obj.jf_mallinfo.mall_jifen_dj;
										//alert(msg);  
											
									} ,
							 error: function (xmlHttpRequest, error) {
							     //alert(xmlHttpRequest+"("+error+")");  
							 }
						     });
				});
				//��ʱ���ȥ1�룬�����졢ʱ���֡���
				</script>
{/literal}		
{literal}
<script>
$("#codetime").click();	
</script>
{/literal}
  
  */
  ?>
  
  
  <div class="title">������Ϣ</div>
  <table>
  <tr>
    <td width="50%">���ɷ��úϼƣ�<font>��{$acc.ws_out_money|default:0}</font></td>
    <td width="250px">�ѻ�÷����ϼƣ�<font>��{$acc.ws_in_money|default:0}</font></td>
  </tr>
</table>
				</div>
			</div>
				{/article}

			<?php
			/*<div class="user_right_li">
				<div class="title">���Ѷ�̬</div>
				<div class="content">
					<ul>
						{loop module="user" function="GetUserTrend" limit="15" user_id="0"}
						<li><a href="/u/{$var.receive_user}" target="_blank"><font color="#FF0000">��{$var.username}��</font></a> {$var.name}-{$var.addtime|date_format:"Y-m-d H:i:s"} </li>
						{/loop}
					</ul>
				</div>
			</div>*/
			?>
           
		</div>
		
		<div class="user_right_r">
			{article module="borrow" function="Getkf"}
			{if $var.username}
			<div class="user_right_info">
				<div class="title">����ר���ͷ��������
                                </div>
				<div class="content">
					<ul>
						<li><img src="{$var.kefu_userid|avatar:'big'}" border="0" class="picborder" width="150px" height="160px"/></li>
						<li>�ͷ����ƣ�{$var.username}</li>
						<li>�ͷ�QQ��
                                                
                                                <a target="_blank" href="http://wpa.qq.com/msgrd?v=1&uin={$var.qq}&site=qq&menu=yes" >
                                                       <img border="0" src="http://wpa.qq.com/pa?p=1:{$var.qq}:1" alt="���������ҷ���Ϣ" title="���������ҷ���Ϣ">
                                                   </a>
                                                </li>
						<li>�ͷ��绰��{$var.phone}</li>
					</ul>
				</div>
			</div>
						{/if}
						{/article}

			<div class="list_2 clearfix">
				<div class="title">�������������</div> 
				<div  class="content">
				<ul>
				{article module="userinfo" function="GetOne" user_id="0"}
					<li><span><a href="/index.php?user&q=code/userinfo/building">{if $var.building_status==1}<font color="#009900">����д</font>{else}<font color="#FF0000">δ��д</font>{/if}</a></span>��������</li>
					<li><span><a href="/index.php?user&q=code/userinfo/company">{if $var.company_status==1}<font color="#009900">����д</font>{else}<font color="#FF0000">δ��д</font>{/if}</a></span>��λ����</li>
					<li><span><a href="/index.php?user&q=code/userinfo/firm">{if $var.firm_status==1}<font color="#009900">����д</font>{else}<font color="#FF0000">δ��д</font>{/if}</a></span>˽Ӫҵ��</li>
					<li><span><a href="/index.php?user&q=code/userinfo/finance">{if $var.finance_status==1}<font color="#009900">����д</font>{else}<font color="#FF0000">δ��д</font>{/if}</a></span>����״��</li>
					<li><span><a href="/index.php?user&q=code/userinfo/contact">{if $var.contact_status==1}<font color="#009900">����д</font>{else}<font color="#FF0000">δ��д</font>{/if}</a></span>��ϵ��ʽ</li>
					<li><span><a href="/index.php?user&q=code/userinfo/edu">{if $var.edu_status==1}<font color="#009900">����д</font>{else}<font color="#FF0000">δ��д</font>{/if}</a></span>��������</li>
					<li><span><a href="/index.php?user&q=code/userinfo/mall">{if $var.mall_status==1}<font color="#009900">����д</font>{else}<font color="#FF0000">δ��д</font>{/if}</a></span>�̳���Ϣ</li>
				</ul>
				{/article}
				</div>
			</div>
			
			<div class="list_2">
				<div class="title">��վ����</div>
				<div class="content">
					<ul>
						{loop module="article" function="GetList" status=1  limit="6" site_id="22" areaid="$_G.areaid"}
						<li><a href="/{$var.site_nid}/a{$var.id}.html" target="_blank">{$var.name|truncate:14}</a></li>
						{/loop}
					</ul>
				</div>
			</div>
			
			<div class="mt10">
            	<!--type_id="6" type_id="7" type_id="8"-->
				{loop module="scrollpic" function="GetList" areaid="$_G.areaid" var="var"  limit="1" type_id="6"}
	                <a href="{$var.url}"><img src="/{$var.pic}" height="100" width="185"></a>
	            {/loop}
			</div>
		
		</div>
		
	</div>
	<!--�ұߵ����� ����-->
</div>
</div>
<!--�û����ĵ�����Ŀ ����-->
<script src="/themes/js/modal.js"></script>
<script src="/themes/js/tab.js"></script>
<script src="/themes/js/alert.js"></script>
<script src="/themes/js/transition.js"></script>
{include file="user_footer.html"}