<?php
!defined('IN_TEMPLATE') && exit('Access Denied');
?>
{include file="user_header.html"}
<link href="{$tempdir}/media/css/modal.css" rel="stylesheet" type="text/css" />
<link href="{$tempdir}/media/css/auto_user.css" rel="stylesheet" type="text/css" />
{literal}
<script language="javascript">
    var userCredit = {$_U.user_cache.credit};
    if(userCredit<1500){
        alert("�Բ�����Ŀǰ�Ļ�����"+userCredit+"��Ŀǰֻ����1500�������ϵĿͻ�ʹ�ã����»�ȫ�濪�Ÿ������û��������ע��");
        location.href='/index.php?user';
    }
</script>

<style>
.auto_borrow_style tr{line-height:30px}
</style>
{/literal}

<!--�û����ĵ�����Ŀ ��ʼ-->
<div id="main" class="clearfix">
<div class="wrap950 ">
	<!--��ߵĵ��� ��ʼ-->
	<div class="user_left">
		{include file="user_menu.html"}
	</div>
	<!--��ߵĵ��� ����-->
	
	<!--�ұߵ����� ��ʼ-->
	<div class="user_right">
		<div class="user_right_menu">
			<ul id="tab" class="list-tab clearfix">
				<li {if $_U.query_type=="auto"} class="cur"{/if}><a href="{$_U.query_url}/auto">�Զ�Ͷ���б�</a></li>
				<li {if $_U.query_type=="auto_new"} class="cur"{/if}><a href="{$_U.query_url}/auto_new">����Զ�Ͷ��</a></li>
			</ul>
		</div>
		
		<div class="user_right_main" style="text-align:left;">
		<!--�Զ�Ͷ�� ��ʼ-->
		{if $_U.query_type=="auto"}
		<div class="user_help alert">
�Զ�Ͷ������������1������<br />
<!--2�����жϵ��з��������Ĺ���ʱ��Ϊ���Զ�Ͷ�꣬�������Ĺ���������á� -->
</div>
 
<!--������ϸ ����-->
		<table  border="0"  cellspacing="1" class="table table-striped  table-condensed" >
			  <form action="" method="post">
				<tr class="head" >					
					<td  >�Ƿ�����</td>
					<!--<td  >Ͷ������</td>-->
					<td  >Ͷ����</td>
                    <td>���ʽ</td>
					<td  >���ʷ�Χ</td>
					<td  >�������</td>
					<!--<td  >����</td>
					<td  >�渶</td>-->
					<td  >��Ľ���</td>
					<!--<td  >�Ƽ����</td>-->
					<td>Ͷ�ʱ���</td>
					<td>����</td>
				</tr>
				{loop module="borrow" function ="GetAutoList" " user_id="0" limit="all" order="order"}
				<span style="display:none">{$i++}</span>
				<tr {if $key%2==1} class="tr1"{/if}>					
					<td >{if $var.status==1}����{else}δ����{/if}</td>
					<!--<td>{if $var.tender_type==1}�����Ͷ��{else}������Ͷ��{/if}</td>-->
					<td>��{$var.tender_account}</td>
                    <td>{if $var.borrow_style_status==1}
                            {if $var.borrow_style=='0'}
                            ���·��ڻ���
                            {elseif $var.borrow_style=='3'}
                            ���¸�Ϣ���ڻ���
                            {elseif $var.borrow_style=='2'}
                            ����ȫ���
                            {/if}
                    {else}������{/if}</td>
					<td>{if $var.apr_status==1}{$var.apr_first}% ~ {$var.apr_last}%{else}������{/if}</td>
					<td>{if $var.timelimit_status==1}
                    {$var.timelimit_month_first}�� ~ {$var.timelimit_month_last} ��<br />
                    {$var.timelimit_day_first}�� ~ {$var.timelimit_day_last} ��
                    {else}������{/if}</td>
					
					<!--<td>{if $var.late_status==1}{$var.late_times}{else}������{/if}</td>
					<td>{if $var.dianfu_status==1}{$var.dianfu_times}{else}������{/if}</td>-->
					<td>{if $var.award_status==1}{$var.award_first}<!--~{$var.award_last}-->{else}������{/if}</td>
					<!--<td>{if $var.tuijian_status==1}��{else}������{/if}</td>-->
					<!--<td>{if $var.vouch_status==1}��{else}������{/if}</td>-->
                                        <td>
                                        {if $var.credit_status==1}���ñ�{/if}
                                        {if $var.zhouzhuan_status==1}��ת��{/if}
                                        	{if $var.jin_status==1}��ֵ��{/if}
                                            {if $var.fast_status==1}��Ѻ��{/if}
                                            {if $var.pledge_status==1}��Ѻ��{/if}
                                            </td>
					<td><a href="/index.php?user&q=code/borrow/auto_new&id={$var.id}">�޸�</a> <a href="#" onclick="javascript:if(confirm('��ȷ��Ҫɾ�����Զ�Ͷ����')) location.href='{$_U.query_url}/auto_del&id={$var.id}'">ɾ��</a></td>
				</tr>
				{/loop}
			</form>	
		</table>
		
	
		</div>
		
		
		<!--�Զ�Ͷ�� ����-->
		{elseif $_U.query_type=="auto_new"}
		<form  method="post" name="form1"  action="/index.php?user&q=code/borrow/auto_add" >
		<div class="user_help alert">
		�Զ�Ͷ��ʱ��ֻ������������ѡ�������ʱϵͳ�Ż�Ϊ���Զ�Ͷ�ꡣ
		</div>
		 <div  style=" width: 780px; margin:0 auto; padding-bottom:20px;"> 
        <div class="sideT" >
            <div class="user_right_title"> 
                <span class=""><strong style="color:red">��Ч״̬</strong></span></div> 
            <div class="set_table" style=" clear:both; float:left"> 
			
            <table border="0" style="text-align:left" class='auto_borrow_style'> 
                    <tr> 
                        <th> 
                            ״̬��
                        </th> 
                        <td> 
                           <input id="status" type="checkbox" name="status" value="1" {if $_U.auto_result.status==1} checked="checked" {/if}/><label for="">�Ƿ�����</label><span>(�����ѡ����ǰ���򲻻���Ч)</span> 
                        </td> 
                    </tr> 
                    <tr> 
                        <th> 
                            ��
                        </th> 
                        <td style="width:550px"> 
                            <span style='display:none;'><input  type="radio" name="tender_type" value="1" {if $_U.auto_result.tender_type==1 || $_U.auto_result.tender_type==""} checked="checked"{/if}  /></span> <label for="tender_type">ÿ��Ͷ��</label> 
                            <input name="tender_account" type="text" maxlength="5" id="tender_account"  style="width:80px;" value="{$_U.auto_result.tender_account}" />Ԫ<span>(����50Ԫ)</span> 
                           <!-- <span ><input  type="radio" name="tender_type" value="2"  {if $_U.auto_result.tender_type==2} checked="checked"{/if}  /><label for="tender_type">������Ͷ��</label></span> 
                            <input name="tender_scale" type="text" value="{$_U.auto_result.tender_scale}" maxlength="2"  style="width:80px;" />%<span>(ֻ����1%~<span id="">20</span>%)</span> -->
                        </td> 
                    </tr> 
                    <tr> 
                        <th> 
                        </th> 
                        <td  style="width:600px;"> 
                         <span style="color:Red;">���������ĵ����Ͷ�������Ա�ĵ������Ϊ׼�����С�ڱ�ĵ���СͶ������Ͷ��
                     
                        </span>
                      <br /> 
                        <span>����ǰ��������ʱϵͳ��Ϊ���Զ�Ͷ��Ķ�ȣ�Ͷ����ͱ�����ֻ��Ϊ����0��Ϊ��������</span>
                       </td> 
                        </tr> 
                    </table> 
            </div> 
            <!--
            <div class="user_right_title"> 
                <span class=""><strong style="color:red">�������Ϣ����</strong></span></div> 
            <div class="set_table" style=" clear:both;float:left"> 
                <table border="0" style="text-align:left"> 
                    <tr align="left"> 
                        <th> 
                            ��֤ѡ�
                        </th> 
                        <td> 
                            <input id="video_status" type="checkbox" name="video_status" value="1" {if $_U.auto_result.video_status==1} checked="checked"{/if} /><label for="video_status">����ͨ����Ƶ��֤</label> 
                            <input id="scene_status" type="checkbox" name="scene_status" value="1" {if $_U.auto_result.scene_status==1} checked="checked"{/if} /><label for="scene_status">����ͨ���ֳ���֤</label> 
                        </td> 
                        <td> 
                           <span>��ѡ����û�д������ơ�</span> 
                        </td> 
                    </tr> -->
                   <!--
                    <tr> 
                        <th> 
                            ��ϵѡ�
                        </th> 
                        <td> 
                            <input id="my_friend" type="checkbox" name="my_friend" value="1" {if $_U.auto_result.my_friend==1} checked="checked"{/if}/><label for="my_friend">�������ҵĺ���</label> 
                            <input id="not_black" type="checkbox" name="not_black" value="1" {if $_U.auto_result.not_black==1} checked="checked"{/if}/><label for="not_black">���벻���ҵĺ�������</label> 
                        </td> 
                        <td> 
                           <span>(��ѡ����û�д�������)</span> 
                        </td> 
                    </tr> 
                    <tr> 
                        <th> 
                            �������ã�
                        </th> 
                        <td> 
                            <input id="late_status" type="checkbox" name="late_status" value="1" {if $_U.auto_result.late_status==1} checked="checked"{/if} /><label for="late_status">���ڴ�������С�ڵ���(��)</label> 
                            <select name="late_times" id="late_times" style=" width: 50px;"> 
	<option {if $_U.auto_result.late_times==0 || $_U.auto_result.late_times==""} selected="selected"{/if} value="0">0</option> 
	<option value="1" {if $_U.auto_result.late_times==1} selected="selected"{/if} >1</option> 
	<option value="2" {if $_U.auto_result.late_times==2} selected="selected"{/if} >2</option> 
	<option value="3" {if $_U.auto_result.late_times==3} selected="selected"{/if} >3</option> 
	<option value="4" {if $_U.auto_result.late_times==4} selected="selected"{/if} >4</option> 
	<option value="5" {if $_U.auto_result.late_times==5} selected="selected"{/if} >5</option> 
	<option value="6" {if $_U.auto_result.late_times==6} selected="selected"{/if} >6</option> 
	<option value="7" {if $_U.auto_result.late_times==7} selected="selected"{/if} >7</option> 
	<option value="8" {if $_U.auto_result.late_times==8} selected="selected"{/if} >8</option> 
	<option value="9" {if $_U.auto_result.late_times==9} selected="selected"{/if} >9</option> 
	<option value="10" {if $_U.auto_result.late_times==10} selected="selected"{/if} >10</option> 
 
</select> 
                            
                        </td> 
                        <td> 
                           <input id="dianfu_status" type="checkbox" name="dianfu_status" value="1" {if $_U.auto_result.dianfu_status==1} checked="checked"{/if}  /><label for="dianfu_status">���渶��������С�ڵ���(��)</label> 
                            <select name="dianfu_times" id="dianfu_times" style=" width: 50px;"> 
	<option {if $_U.auto_result.dianfu_times==0 || $_U.auto_result.dianfu_times==""} selected="selected"{/if} value="0">0</option> 
	<option value="1" {if $_U.auto_result.dianfu_times==1} selected="selected"{/if} >1</option> 
	<option value="2" {if $_U.auto_result.dianfu_times==2} selected="selected"{/if} >2</option> 
	<option value="3" {if $_U.auto_result.dianfu_times==3} selected="selected"{/if} >3</option> 
	<option value="4" {if $_U.auto_result.dianfu_times==4} selected="selected"{/if} >4</option> 
	<option value="5" {if $_U.auto_result.dianfu_times==5} selected="selected"{/if} >5</option> 
	<option value="6" {if $_U.auto_result.dianfu_times==6} selected="selected"{/if} >6</option> 
	<option value="7" {if $_U.auto_result.dianfu_times==7} selected="selected"{/if} >7</option> 
	<option value="8" {if $_U.auto_result.dianfu_times==8} selected="selected"{/if} >8</option> 
	<option value="9" {if $_U.auto_result.dianfu_times==9} selected="selected"{/if} >9</option> 
	<option value="10" {if $_U.auto_result.dianfu_times==10} selected="selected"{/if} >10</option> 
 
</select> 
                        </td> 
                    </tr> 
                    <tr> 
                        <th> 
                            ��������
                        </th> 
                        <td style="width:380px"> 
                            <input type="checkbox" name="black_status" value="1" {if $_U.auto_result.black_status==1} checked="checked"{/if} /><label for="black_status">����վ</label> 
                            <select name="black_user" id="black_user" style=" width: 90px;"> 
	<option value="0" {if $_U.auto_result.black_user==0} selected="selected"{/if}>�����û�</option> 
	<option value="1" {if $_U.auto_result.black_user==1} selected="selected"{/if}>����VIP</option> 
	<option value="2" {if $_U.auto_result.black_user==2} selected="selected"{/if}>���ƻ�Ա</option> 
	<option value="3" {if $_U.auto_result.black_user==3} selected="selected"{/if}>���ƻ�Ա</option> 
	<option value="4" {if $_U.auto_result.black_user==4} selected="selected"{/if}>�׽��Ա</option> 
 
</select> 
                            <label for="black_times" id="black_times">��Ϊ��������������(��)</label> 
                            <select name="black_times" id="black_times" style=" width: 50px;"> 
	<option {if $_U.auto_result.black_times==0 || $_U.auto_result.black_times==""} selected="selected"{/if} value="0">0</option> 
	<option value="1" {if $_U.auto_result.black_times==1} selected="selected"{/if} >1</option> 
	<option value="2" {if $_U.auto_result.black_times==2} selected="selected"{/if} >2</option> 
	<option value="3" {if $_U.auto_result.black_times==3} selected="selected"{/if} >3</option> 
	<option value="4" {if $_U.auto_result.black_times==4} selected="selected"{/if} >4</option> 
	<option value="5" {if $_U.auto_result.black_times==5} selected="selected"{/if} >5</option> 
	<option value="6" {if $_U.auto_result.black_times==6} selected="selected"{/if} >6</option> 
	<option value="7" {if $_U.auto_result.black_times==7} selected="selected"{/if} >7</option> 
	<option value="8" {if $_U.auto_result.black_times==8} selected="selected"{/if} >8</option> 
	<option value="9" {if $_U.auto_result.black_times==9} selected="selected"{/if} >9</option> 
	<option value="10" {if $_U.auto_result.black_times==10} selected="selected"{/if} >10</option>
	<option value="15" {if $_U.auto_result.black_times==15} selected="selected"{/if}>15</option> 
	<option value="20" {if $_U.auto_result.black_times==20} selected="selected"{/if}>20</option> 
	<option value="25" {if $_U.auto_result.black_times==25} selected="selected"{/if}>25</option> 
	<option value="30" {if $_U.auto_result.black_times==30} selected="selected"{/if}>30</option> 
	<option value="40" {if $_U.auto_result.black_times==40} selected="selected"{/if}>40</option> 
	<option value="50" {if $_U.auto_result.black_times==50} selected="selected"{/if}>50</option> 
	<option value="80" {if $_U.auto_result.black_times==80} selected="selected"{/if}>80</option> 
	<option value="100" {if $_U.auto_result.black_times==100} selected="selected"{/if}>100</option> 
	<option value="150" {if $_U.auto_result.black_times==150} selected="selected"{/if}>150</option> 
	<option value="200" {if $_U.auto_result.black_times==200} selected="selected"{/if}>200</option> 
	<option value="250" {if $_U.auto_result.black_times==250} selected="selected"{/if}>250</option> 
	<option value="300" {if $_U.auto_result.black_times==300} selected="selected"{/if}>300</option> 
	<option value="500" {if $_U.auto_result.black_times==500} selected="selected"{/if}>500</option> 
	<option value="800" {if $_U.auto_result.black_times==800} selected="selected"{/if}>800</option> 
	<option value="1000" {if $_U.auto_result.black_times==1000} selected="selected"{/if}>1000</option> 
 
</select><label for="" id="">��</label> 
                        </td> 
                        <td><input id="not_late_black" type="checkbox" value="1" name="not_late_black" {if $_U.auto_result.not_late_black==1} checked="checked"{/if}/><label for="not_late_black">���벻����վ���ں�������</label></td> 
                        </tr> 
                    -->
                    <!--<tr> 
                        <th> 
                            ���û��֣�
                        </th> 
                        <td> 
                           <input id="borrow_credit_status" type="checkbox" name="borrow_credit_status" value="1" {if $_U.auto_result.borrow_credit_status==1} checked="checked"{/if}/><label for="borrow_credit_status">���ֱ���Ϊ</label> 
                           <input name="borrow_credit_first" type="text" value="{$_U.auto_result.borrow_credit_first}" maxlength="6" id="borrow_credit_first" style="width:50px;" />~<input name="borrow_credit_last" type="text" value="{$_U.auto_result.borrow_credit_last}" maxlength="6" id="borrow_credit_last"  style="width:50px;" /> 
                        </td> 
                       
                    </tr> 
                    
                </table> 
            </div> -->
            <div class="user_right_title"> 
                <span class=""><strong style="color:red">�����Ϣ����</strong></span></div> 
            <div class="set_table" style=" clear:both;"> 
                <table border="0" style="text-align:left; float:left" class='auto_borrow_style' > 
                <tr> 
                        <th> 
                            ���ʽ��
                        </th> 
                        <td> 
                            <input id="borrow_style_status" type="checkbox" name="borrow_style_status" value="1"  {if $_U.auto_result.borrow_style_status==1} checked="checked"{/if}/><label for="">����  ���ʽ����Ϊ</label> 
                            <select name="borrow_style" id="borrow_style" > 
	<option value="0"  {if $_U.auto_result.borrow_style==0} selected="selected"{/if}>���·��ڻ���</option> 
	<option value="3"  {if $_U.auto_result.borrow_style==3} selected="selected"{/if}>���¸�Ϣ���ڻ���</option> 
	<option value="2"  {if $_U.auto_result.borrow_style==2} selected="selected"{/if}>����ȫ���</option> 
 
</select> 
                        </td> 
                        <td><span>����ѡ����û�д������ơ�</span></td> 
                    </tr> 
                    <tr> 
                        <th> 
                            ������ޣ�
                        </th> 
                        <td style="width:400px"> 
                           <input id="timelimit_status"  name="timelimit_status" type="radio" value="0" checked="checked" {if $_U.auto_result.timelimit_status==0} checked="checked"{/if}/><label for="">���޶�����</label> 
                           <input id="timelimit_status" type="radio" name="timelimit_status" value="1"   name="timelimit_status" {if $_U.auto_result.timelimit_status==1} checked="checked"{/if}/><label for="">�����������</label> 
                        </td> 
                        <td> 
                            <span></span> 
                        </td> 
                    </tr> 
                <tr> 
                        <th> 
                        </th> 
                        <td style="width:400px"> 
                         �±꣺
		<select id="timelimit_month_first" name="timelimit_month_first" style=" width: 90px;"> 
			<option  {if $_U.auto_result.timelimit_month_first==0} selected="selected"{/if} value="0">��Ͷ�±�</option> 
            <option  {if $_U.auto_result.timelimit_month_first==1} selected="selected"{/if} value="1">1����</option> 
			<option  {if $_U.auto_result.timelimit_month_first==2} selected="selected"{/if} value="2">2����</option> 
			<option  {if $_U.auto_result.timelimit_month_first==3} selected="selected"{/if} value="3">3����</option> 
			<option  {if $_U.auto_result.timelimit_month_first==4} selected="selected"{/if} value="4">4����</option> 
			<option  {if $_U.auto_result.timelimit_month_first==5} selected="selected"{/if} value="5">5����</option> 
			<option  {if $_U.auto_result.timelimit_month_first==6} selected="selected"{/if} value="6">6����</option> 
			<option  {if $_U.auto_result.timelimit_month_first==7} selected="selected"{/if} value="7">7����</option> 
			<option  {if $_U.auto_result.timelimit_month_first==8} selected="selected"{/if} value="8">8����</option> 
			<option  {if $_U.auto_result.timelimit_month_first==9} selected="selected"{/if} value="9">9����</option> 
			<option  {if $_U.auto_result.timelimit_month_first==10} selected="selected"{/if} value="10">10����</option> 
			<option  {if $_U.auto_result.timelimit_month_first==11} selected="selected"{/if} value="11">11����</option> 
			<option  {if $_U.auto_result.timelimit_month_first==12} selected="selected"{/if} value="12">12����</option> 
		</select>
			~
		<select id="timelimit_month_last" name="timelimit_month_last" style=" width: 90px;"> 
			<option value="0"  {if $_U.auto_result.timelimit_month_last==0} selected="selected"{/if}>��Ͷ�±�</option> 
            <option value="1"  {if $_U.auto_result.timelimit_month_last==1} selected="selected"{/if}>1����</option> 
			<option value="2"  {if $_U.auto_result.timelimit_month_last==2} selected="selected"{/if}>2����</option> 
			<option value="3"  {if $_U.auto_result.timelimit_month_last==3} selected="selected"{/if}>3����</option> 
			<option value="4"  {if $_U.auto_result.timelimit_month_last==4} selected="selected"{/if}>4����</option> 
			<option value="5"  {if $_U.auto_result.timelimit_month_last==5} selected="selected"{/if}>5����</option> 
			<option value="6"  {if $_U.auto_result.timelimit_month_last==6} selected="selected"{/if}>6����</option> 
			<option value="7"  {if $_U.auto_result.timelimit_month_last==7} selected="selected"{/if}>7����</option> 
			<option value="8"  {if $_U.auto_result.timelimit_month_last==8} selected="selected"{/if}>8����</option> 
			<option value="9"  {if $_U.auto_result.timelimit_month_last==9} selected="selected"{/if}>9����</option> 
			<option value="10"  {if $_U.auto_result.timelimit_month_last==10} selected="selected"{/if}>10����</option> 
			<option value="11"  {if $_U.auto_result.timelimit_month_last==11} selected="selected"{/if}>11����</option> 
			<option value="12"  {if $_U.auto_result.timelimit_month_last==12} selected="selected"{/if}>12����</option> 
		</select>
                                                    
                        <br/>��꣺
                        
	<select id="timelimit_day_first" name="timelimit_day_first" style=" width: 90px;"> 
            <option  {if $_U.auto_result.timelimit_day_first==0} selected="selected"{/if} value="0">��Ͷ���</option> 
            <option  {if $_U.auto_result.timelimit_day_first==1} selected="selected"{/if} value="1">1��</option> 
			<option  {if $_U.auto_result.timelimit_day_first==2} selected="selected"{/if} value="2">2��</option> 
			<option  {if $_U.auto_result.timelimit_day_first==3} selected="selected"{/if} value="3">3��</option> 
			<option  {if $_U.auto_result.timelimit_day_first==4} selected="selected"{/if} value="4">4��</option> 
			<option  {if $_U.auto_result.timelimit_day_first==5} selected="selected"{/if} value="5">5��</option> 
			<option  {if $_U.auto_result.timelimit_day_first==6} selected="selected"{/if} value="6">6��</option> 
			<option  {if $_U.auto_result.timelimit_day_first==7} selected="selected"{/if} value="7">7��</option> 
			<option  {if $_U.auto_result.timelimit_day_first==8} selected="selected"{/if} value="8">8��</option> 
			<option  {if $_U.auto_result.timelimit_day_first==9} selected="selected"{/if} value="9">9��</option> 
			<option  {if $_U.auto_result.timelimit_day_first==10} selected="selected"{/if} value="10">10��</option> 
			<option  {if $_U.auto_result.timelimit_day_first==11} selected="selected"{/if} value="11">11��</option> 
			<option  {if $_U.auto_result.timelimit_day_first==12} selected="selected"{/if} value="12">12��</option> 
            <option  {if $_U.auto_result.timelimit_day_first==13} selected="selected"{/if} value="13">13��</option> 
            <option  {if $_U.auto_result.timelimit_day_first==14} selected="selected"{/if} value="14">14��</option> 
            <option  {if $_U.auto_result.timelimit_day_first==15} selected="selected"{/if} value="15">15��</option> 
            <option  {if $_U.auto_result.timelimit_day_first==16} selected="selected"{/if} value="16">16��</option> 
            <option  {if $_U.auto_result.timelimit_day_first==17} selected="selected"{/if} value="17">17��</option> 
            <option  {if $_U.auto_result.timelimit_day_first==18} selected="selected"{/if} value="18">18��</option> 
            <option  {if $_U.auto_result.timelimit_day_first==19} selected="selected"{/if} value="19">19��</option> 
            <option  {if $_U.auto_result.timelimit_day_first==20} selected="selected"{/if} value="20">20��</option> 
            <option  {if $_U.auto_result.timelimit_day_first==21} selected="selected"{/if} value="21">21��</option> 
            <option  {if $_U.auto_result.timelimit_day_first==22} selected="selected"{/if} value="22">22��</option> 
            <option  {if $_U.auto_result.timelimit_day_first==23} selected="selected"{/if} value="23">23��</option> 
            <option  {if $_U.auto_result.timelimit_day_first==24} selected="selected"{/if} value="24">24��</option> 
            <option  {if $_U.auto_result.timelimit_day_first==25} selected="selected"{/if} value="25">25��</option> 
	</select>
		~
		<select id="timelimit_day_last" name="timelimit_day_last" style=" width: 90px;"> 
			<option value="0"  {if $_U.auto_result.timelimit_day_last==0} selected="selected"{/if}>��Ͷ���</option> 
            <option value="1"  {if $_U.auto_result.timelimit_day_last==1} selected="selected"{/if}>1��</option> 
			<option value="2"  {if $_U.auto_result.timelimit_day_last==2} selected="selected"{/if}>2��</option> 
			<option value="3"  {if $_U.auto_result.timelimit_day_last==3} selected="selected"{/if}>3��</option> 
			<option value="4"  {if $_U.auto_result.timelimit_day_last==4} selected="selected"{/if}>4��</option> 
			<option value="5"  {if $_U.auto_result.timelimit_day_last==5} selected="selected"{/if}>5��</option> 
			<option value="6"  {if $_U.auto_result.timelimit_day_last==6} selected="selected"{/if}>6��</option> 
			<option value="7"  {if $_U.auto_result.timelimit_day_last==7} selected="selected"{/if}>7��</option> 
			<option value="8"  {if $_U.auto_result.timelimit_day_last==8} selected="selected"{/if}>8��</option> 
			<option value="9"  {if $_U.auto_result.timelimit_day_last==9} selected="selected"{/if}>9��</option> 
			<option value="10"  {if $_U.auto_result.timelimit_day_last==10} selected="selected"{/if}>10��</option> 
			<option value="11"  {if $_U.auto_result.timelimit_day_last==11} selected="selected"{/if}>11��</option> 
			<option value="12"  {if $_U.auto_result.timelimit_day_last==12} selected="selected"{/if}>12��</option> 
            <option value="13"  {if $_U.auto_result.timelimit_day_last==13} selected="selected"{/if}>13��</option> 
            <option value="14"  {if $_U.auto_result.timelimit_day_last==14} selected="selected"{/if}>14��</option> 
            <option value="15"  {if $_U.auto_result.timelimit_day_last==15} selected="selected"{/if}>15��</option> 
            <option value="16"  {if $_U.auto_result.timelimit_day_last==16} selected="selected"{/if}>16��</option> 
            <option value="17"  {if $_U.auto_result.timelimit_day_last==17} selected="selected"{/if}>17��</option> 
            <option value="18"  {if $_U.auto_result.timelimit_day_last==18} selected="selected"{/if}>18��</option> 
            <option value="19"  {if $_U.auto_result.timelimit_day_last==19} selected="selected"{/if}>19��</option> 
            <option value="20"  {if $_U.auto_result.timelimit_day_last==20} selected="selected"{/if}>20��</option> 
            <option value="21"  {if $_U.auto_result.timelimit_day_last==21} selected="selected"{/if}>21��</option> 
            <option value="22"  {if $_U.auto_result.timelimit_day_last==22} selected="selected"{/if}>22��</option> 
            <option value="23"  {if $_U.auto_result.timelimit_day_last==23} selected="selected"{/if}>23��</option> 
            <option value="24"  {if $_U.auto_result.timelimit_day_last==24} selected="selected"{/if}>24��</option> 
            <option value="25"  {if $_U.auto_result.timelimit_day_last==25} selected="selected"{/if}>25��</option> 
		</select>
                        </td> 
                        <td> 
                            <span></span> 
                        </td> 
                    </tr> 
                    
                 <tr> 
                        <th> 
                            �����ʣ�
                        </th> 
                        <td> 
                           <input id="apr_status" type="checkbox" name="apr_status" value="1"  {if $_U.auto_result.apr_status==1} checked="checked"{/if}/><label for="">���� ���ʷ�Χ��</label> 
                           
						<select name="apr_first" style=" width: 80px;"> 
														<option value="1"   {if $_U.auto_result.apr_first==1} selected="selected"{/if}>1%</option> 
														<option value="2"   {if $_U.auto_result.apr_first==2} selected="selected"{/if}>2%</option> 
														<option value="3"   {if $_U.auto_result.apr_first==3} selected="selected"{/if}>3%</option> 
														<option value="4"   {if $_U.auto_result.apr_first==4} selected="selected"{/if}>4%</option> 
														<option value="5"   {if $_U.auto_result.apr_first==5} selected="selected"{/if}>5%</option> 
														<option value="6"   {if $_U.auto_result.apr_first==6} selected="selected"{/if}>6%</option> 
														<option value="7"   {if $_U.auto_result.apr_first==7} selected="selected"{/if}>7%</option> 
														<option value="8"   {if $_U.auto_result.apr_first==8} selected="selected"{/if}>8%</option> 
														<option value="9"   {if $_U.auto_result.apr_first==9} selected="selected"{/if}>9%</option> 
														<option value="10"   {if $_U.auto_result.apr_first==10} selected="selected"{/if}>10%</option> 
														<option value="11"   {if $_U.auto_result.apr_first==11} selected="selected"{/if}>11%</option> 
														<option value="12"   {if $_U.auto_result.apr_first==12} selected="selected"{/if}>12%</option> 
														<option value="13"   {if $_U.auto_result.apr_first==13} selected="selected"{/if}>13%</option> 
														<option value="14"   {if $_U.auto_result.apr_first==14} selected="selected"{/if}>14%</option> 
														<option value="15"   {if $_U.auto_result.apr_first==15} selected="selected"{/if}>15%</option> 
														<option value="16"   {if $_U.auto_result.apr_first==16} selected="selected"{/if}>16%</option> 
														<option value="17"   {if $_U.auto_result.apr_first==17} selected="selected"{/if}>17%</option> 
														<option value="18"   {if $_U.auto_result.apr_first==18} selected="selected"{/if}>18%</option> 
														<option value="19"   {if $_U.auto_result.apr_first==19} selected="selected"{/if}>19%</option> 
														<option value="20"   {if $_U.auto_result.apr_first==20} selected="selected"{/if}>20%</option> 
														<option value="21"   {if $_U.auto_result.apr_first==21} selected="selected"{/if}>21%</option> 
														<option value="22"   {if $_U.auto_result.apr_first==22} selected="selected"{/if}>22%</option> 
														<option value="23"   {if $_U.auto_result.apr_first==23} selected="selected"{/if}>23%</option> 
														<option value="24"   {if $_U.auto_result.apr_first==24} selected="selected"{/if}>24%</option> 
														<option value="25"   {if $_U.auto_result.apr_first==25} selected="selected"{/if}>25%</option> 
							</select> 
                            ~
							<select name="apr_last" style=" width: 80px;"> 
						   								<option value="5"   {if $_U.auto_result.apr_last==5} selected="selected"{/if}>5%</option> 
														<option value="6"   {if $_U.auto_result.apr_last==6} selected="selected"{/if}>6%</option> 
														<option value="7"   {if $_U.auto_result.apr_last==7} selected="selected"{/if}>7%</option> 
														<option value="8"   {if $_U.auto_result.apr_last==8} selected="selected"{/if}>8%</option> 
														<option value="9"   {if $_U.auto_result.apr_last==9} selected="selected"{/if}>9%</option> 
														<option value="10"   {if $_U.auto_result.apr_last==10} selected="selected"{/if}>10%</option> 
														<option value="11"   {if $_U.auto_result.apr_last==11} selected="selected"{/if}>11%</option> 
														<option value="12"   {if $_U.auto_result.apr_last==12} selected="selected"{/if}>12%</option> 
														<option value="13"   {if $_U.auto_result.apr_last==13} selected="selected"{/if}>13%</option> 
														<option value="14"   {if $_U.auto_result.apr_last==14} selected="selected"{/if}>14%</option> 
														<option value="15"   {if $_U.auto_result.apr_last==15} selected="selected"{/if}>15%</option> 
														<option value="16"   {if $_U.auto_result.apr_last==16} selected="selected"{/if}>16%</option> 
														<option value="17"   {if $_U.auto_result.apr_last==17} selected="selected"{/if}>17%</option> 
														<option value="18"   {if $_U.auto_result.apr_last==18} selected="selected"{/if}>18%</option> 
														<option value="19"   {if $_U.auto_result.apr_last==19} selected="selected"{/if}>19%</option> 
														<option value="20"   {if $_U.auto_result.apr_last==20} selected="selected"{/if}>20%</option> 
														<option value="21"   {if $_U.auto_result.apr_last==21} selected="selected"{/if}>21%</option> 
														<option value="22"   {if $_U.auto_result.apr_last==22} selected="selected"{/if}>22%</option> 
														<option value="23"   {if $_U.auto_result.apr_last==23} selected="selected"{/if}>23%</option> 
														<option value="24"   {if $_U.auto_result.apr_last==24} selected="selected"{/if}>24%</option> 
														<option value="25"   {if $_U.auto_result.apr_last==25} selected="selected"{/if}>25%</option> 
							</select>	
                        </td> 
                        <td> 
                            <span>����������û�д������ơ�</span> 
                        </td> 
                    </tr> 
                <tr> 
                        <th> 
                            Ͷ�꽱����
                        </th> 
                        <td> 
                           <input  type="checkbox" name="award_status"  value="1" {if $_U.auto_result.award_status==1} checked="checked"{/if} />���� <label for="">����������ڵ���</label> 
                           <select name="award_first" style=" width: 80px;"> 
	<option  value="0" {if $_U.auto_result.award_first=="0"} selected="selected"{/if}>0%</option> 
	<option value="0.1" {if $_U.auto_result.award_first=="0.1"} selected="selected"{/if}>0.1%</option> 
	<option value="0.2" {if $_U.auto_result.award_first=="0.2"} selected="selected"{/if}>0.2%</option> 
	<option value="0.3" {if $_U.auto_result.award_first=="0.3"} selected="selected"{/if}>0.3%</option> 
	<option value="0.4" {if $_U.auto_result.award_first=="0.4"} selected="selected"{/if}>0.4%</option> 
	<option value="0.5" {if $_U.auto_result.award_first=="0.5"} selected="selected"{/if}>0.5%</option> 
	<option value="0.6" {if $_U.auto_result.award_first=="0.6"} selected="selected"{/if}>0.6%</option> 
	<option value="0.7" {if $_U.auto_result.award_first=="0.17"} selected="selected"{/if}>0.7%</option> 
	<option value="0.8" {if $_U.auto_result.award_first=="0.8"} selected="selected"{/if}>0.8%</option> 
	<option value="0.9" {if $_U.auto_result.award_first=="0.9"} selected="selected"{/if}>0.9%</option> 
	<option value="1" {if $_U.auto_result.award_first=="1"} selected="selected"{/if}>1%</option> 
	<option value="1.5" {if $_U.auto_result.award_first=="1.5"} selected="selected"{/if}>1.5%</option> 
	<option value="2" {if $_U.auto_result.award_first=="2"} selected="selected"{/if}>2%</option> 
 
</select> 
                           
                       <!--  ~    <select name="award_last" style=" width: 80px;"> 
	<option value="0.1" {if $_U.auto_result.award_first=="0.1"} selected="selected"{/if}>0.1%</option> 
	<option value="0.2" {if $_U.auto_result.award_first=="0.2"} selected="selected"{/if}>0.2%</option> 
	<option value="0.3" {if $_U.auto_result.award_first=="0.3"} selected="selected"{/if}>0.3%</option> 
	<option value="0.4" {if $_U.auto_result.award_first=="0.4"} selected="selected"{/if}>0.4%</option> 
	<option value="0.5" {if $_U.auto_result.award_first=="0.5"} selected="selected"{/if}>0.5%</option> 
	<option value="0.6" {if $_U.auto_result.award_first=="0.6"} selected="selected"{/if}>0.6%</option> 
	<option value="0.7" {if $_U.auto_result.award_first=="0.17"} selected="selected"{/if}>0.7%</option> 
	<option value="0.8" {if $_U.auto_result.award_first=="0.8"} selected="selected"{/if}>0.8%</option> 
	<option value="0.9" {if $_U.auto_result.award_first=="0.9"} selected="selected"{/if}>0.9%</option> 
	<option value="1" {if $_U.auto_result.award_first=="1"} selected="selected"{/if}>1%</option> 
	<option value="1.5" {if $_U.auto_result.award_first=="1.5"} selected="selected"{/if}>1.5%</option> 
	<option value="2" {if $_U.auto_result.award_first=="2"} selected="selected"{/if}>2%</option> 
 
</select> -->
                        </td> 
                        <td> 
                            <span>����������û�д������ơ�</span> 
                        </td> 
                    </tr> 
                 <tr> 
                        <th> 
                            Ͷ�ʱ��֣�
                        </th> 
                        <td> 
                           
                           <!--<input id="vouch_status" type="checkbox" name="vouch_status" value="1" {if $_U.auto_result.vouch_status==1} checked="checked"{/if} /><label for="vouch_status">����ΪѺ��</label>-->
                           <input id="credit_status" type="checkbox" name="credit_status" value="1" {if $_U.auto_result.credit_status==1} checked="checked"{/if} /><label for="credit_status">���ñ�</label>
                           <input id="zhouzhuan_status" type="checkbox" name="zhouzhuan_status" value="1" {if $_U.auto_result.zhouzhuan_status==1} checked="checked"{/if} /><label for="zhouzhuan_status">��ת��</label>
                           <input id="jin_status" type="checkbox" name="jin_status" value="1" {if $_U.auto_result.jin_status==1} checked="checked"{/if} /><label for="jin_status">��ֵ��</label>
                           <input id="fast_status" type="checkbox" name="fast_status" value="1" {if $_U.auto_result.fast_status==1} checked="checked"{/if} /><label for="fast_status">��Ѻ��</label>
                           <input id="pledge_status" type="checkbox" name="pledge_status" value="1" {if $_U.auto_result.pledge_status==1} checked="checked"{/if} /><label for="pledge_status">��Ѻ��</label>
                          <!-- <input id="vouch_status" type="checkbox" name="vouch_status" value="1" {if $_U.auto_result.vouch_status==1} checked="checked"{/if} /><label for="vouch_status">������</label>
                           <input id="restructuring_status" type="checkbox" name="restructuring_status" value="1" {if $_U.auto_result.restructuring_status==1} checked="checked"{/if} /><label for="restructuring_status">�����</label>-->
                           <!--
                           <input id="tuijian_status" type="checkbox" name="tuijian_status"  value="1" {if $_U.auto_result.tuijian_status==1} checked="checked"{/if}/><label for="tuijian_status">����Ϊ�Ƽ���</label> 
                           -->
                        </td>
                        <td> 
                            <span>��ѡ������Ͷ�ʱ��֣��ɶ�ѡ��</span> 
                        </td> 
                    </tr> 
                </table> 
                </div> 
        </div> 
        <div style="text-align:center; clear:both"> 
		<input type="hidden" name="auto_id" value="{$_U.auto_result.id}" />
        <input type="submit" class="btn-action" name="" value="����" id=""  /> 
        <input type="reset" class="btn-action" name="" value="ȡ��"   /> 
        </div> 
    </div> 
		</form>
	{/if}
		<script> 
var url = "{$_U.query_url}/{$_U.query_type}";
{literal}
function sousuo(urla){
	if (urla!="") url = urla;
	var _url = "";
	var dotime1 = $("#dotime1").val();
	var keywords = $("#keywords").val();
	var username = $("#username").val();
	var status = $("#status").val();
	var reply_status = $("#reply_status").val();
	var tender_username = $("#tender_username").val();
	var dotime2 = $("#dotime2").val();
	if (username!=null){
		 _url += "&username="+username;
	}
	if (tender_username!=null){
		 _url += "&tender_username="+tender_username;
	}
	if (status!=null){
		 _url += "&status="+status;
	}
	if (reply_status!=null){
		 _url += "&reply_status="+reply_status;
	}
	if (keywords!=null){
		 _url += "&keywords="+keywords;
	}
	if (dotime1!=null){
		 _url += "&dotime1="+dotime1;
	}
	if (dotime2!=null){
		 _url += "&dotime2="+dotime2;
	}
	location.href=url+_url;
}
 
</script>
{/literal}
</div>
</div>
</div>
</div>
<!--�û����ĵ�����Ŀ ����-->
<script src="/themes/js/modal.js"></script>
<script src="/themes/js/tab.js"></script>
<script src="/themes/js/alert.js"></script>
<script src="/themes/js/transition.js"></script>
{include file="user_footer.html"}