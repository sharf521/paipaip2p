{if $_A.query_type == "new" || $_A.query_type == "edit"}


{elseif $_A.query_type=="list"}
<table  border="0"  cellspacing="1" bgcolor="#CCCCCC" width="100%">
	  <form action="" method="post">
		<tr >
			<td width="" class="main_td">ID</td>
			<td width="*" class="main_td">�û���</td>
			<td width="*" class="main_td">������վ</td>
			<td width="" class="main_td">��ʵ����</td>
			<td width="" class="main_td">�����</td>
			<td width="" class="main_td">�������</td>
			<td width="" class="main_td">������</td>
			<td width="" class="main_td">���ս��</td>
                        <td width="" class="main_td">�������</td>
                        <td width="" class="main_td">���ʲ�</td>
		</tr>
		{ foreach  from=$_A.account_list key=key item=item}
		<tr  {if $key%2==1} class="tr2"{/if}>
			<td >{ $item.user_id}</td>
			<td><!--<a href="javascript:void(0)" onclick='tipsWindown("�û���ϸ��Ϣ�鿴","url:get?index.php?admin&q=module/user/view&user_id={$item.user_id}&type=scene",500,230,"true","","true","text");'></a>-->
                        {$item.username}
                        </td>
			<td >{$item.sitename}</td>
			<td >{$item.realname}</td>
			<td >{$item.total|default:0}</td>
			<td >{$item.use_money|default:0}</td>
			<td >{$item.no_use_money|default:0}</td>
			<td >{$item.collection|default:0}</td>
                        {article module="borrow" function="GetUserLog" user_id=$item.user_id var="acc"}
                        <td >
                        {$acc.wait_payment|default:0}
                        </td>
                        <td >
                        {$acc.jinAmount|default:0}
                        </td>
                        {/article}
                         
		</tr>
		{ /foreach}
		<tr>
		<td colspan="10" class="action">
		<div class="floatl">
		<input type="button" onclick="javascript:location.href='{$_A.query_url}&type=excel'" value="�����б�" />
		</div>
		<div class="floatr">
			�û�����<input type="text" name="username" id="username" value="{$magic.request.username|urldecode}"/> <input type="button" value="����" onclick="sousuo()">
		</div>
		</td>
	</tr>
		<tr>
			<td colspan="9" class="page">
			{$_A.showpage} 
			</td>
		</tr>
	</form>	
</table>




{elseif $_A.query_type=="ticheng"}
<table  border="0"  cellspacing="1" bgcolor="#CCCCCC" width="100%">
	  <form action="" method="post">
		<tr >
			<td width="" class="main_td">ʱ��</td>
			<td width="*" class="main_td">�û���</td>
			<td width="" class="main_td">����Ͷ���ܶ�(��)</td>
		</tr>
		{ foreach  from=$_A.account_ticheng key=key item=item}
		<tr  {if $key%2==1} class="tr2"{/if}>
			<td >{$item.addtimes}</td>
			<td><!--<a href="javascript:void(0)" onclick='tipsWindown("�û���ϸ��Ϣ�鿴","url:get?index.php?admin&q=module/user/view&user_id={$item.user_id}&type=scene",500,230,"true","","true","text");'></a>-->
                        {$item.usernames}
                        </td>
			<td >{$item.money}</td>
			
			
		</tr>
		{ /foreach}
		<tr>
		<td colspan="4" class="action">
		<div class="floatl">
		<input type="button" onclick="javascript:location.href='{$_A.query_url}/ticheng&type=excel'" value="�����б�" />
		</div>
		<div class="floatr">
			�û�����<input type="text" name="username" id="username" value="{$magic.request.username|urldecode}"/> <input type="button" value="����" onclick="sousuo()">
		</div>
		</td>
	</tr>
		<tr>
			<td colspan="4" class="page">
			{$_A.showpage} 
			</td>
		</tr>
	</form>	
</table>        




        
{elseif $_A.query_type=="vipTC"}
<table  border="0"  cellspacing="1" bgcolor="#CCCCCC" width="100%">
	  <form action="" method="post">
		<tr >
                        <td width="" class="main_td">�ƹ����û���</td>	
                         <td width="" class="main_td">�����û���</td>
			<td width="*" class="main_td">��ʵ����</td>
			<td width="" class="main_td">ע��ʱ��</td>
			<td width="" class="main_td">��������б�</td>

		</tr>
		{foreach  from=$_A.vipTC_list key=key item=item}
		<tr >
                                        <td>{$item.inviteUserName}</td>			
                                         <td>{$item.username}</td>
                                        <td>{$item.realname}</td>
					<td>{$item.addtime|date_format}</td>
                                        <td><a href="{$_A.query_url}/tcList&a=cash&username2={$item.username}">����鿴</a></td>
		</tr>
		{/foreach}
		<tr>
		<td colspan="10" class="action">
		<div class="floatl">
		
		</div>
		<div class="floatr">
			�������û�����<input type="text" name="username" id="username" value="{$magic.request.username|urldecode}"/>
                        �������û�����<input type="text" name="username2" id="username2" value="{$magic.request.username2|urldecode}"/>
                        <input type="button" value="����" onclick="sousuo()">
		</div>
		</td>
	</tr>
		<tr>
			<td colspan="9" class="page">
			{$_A.showpage} 
			</td>
		</tr>
	</form>	
</table>     
{elseif $_A.query_type=="tcList"}
<table  border="0"  cellspacing="1" bgcolor="#CCCCCC" width="100%">
	  <form action="" method="post">
		<tr >
                        <td width="" class="main_td">�ƹ����û���</td>	
                         <td width="" class="main_td">�����û���</td>
			<td width="*" class="main_td">��ʵ����</td>
			<td width="*" class="main_td">�������</td>
			<td width="" class="main_td">֧��ʱ��</td>
			<td width="" class="main_td">�������</td>

		</tr>
		{foreach  from=$_A.tichen_list key=key item=item}
		<tr >
                                        <td>{$item.invite_username}</td>			
                                         <td>{$item.username}</td>
                                        <td>{$item.realname}</td>
                                        <td>{$item.remark}</td>
					<td>{$item.addtime|date_format}</td>
                                        <td>{$item.money}Ԫ</td>
		</tr>
		{/foreach}
		<tr>
		<td colspan="10" class="action">
		<div class="floatl">
		
		</div>
		<div class="floatr">
			�������û�����<input type="text" name="username" id="username" value="{$magic.request.username|urldecode}"/>
                        �������û�����<input type="text" name="username2" id="username2" value="{$magic.request.username2|urldecode}"/>
                        <input type="button" value="����" onclick="sousuo()">
		</div>
		</td>
	</tr>
		<tr>
			<td colspan="9" class="page">
			{$_A.showpage} 
			</td>
		</tr>
	</form>	
</table>     

{elseif $_A.query_type=="moneyCheck"}
<table  border="0"  cellspacing="1" bgcolor="#CCCCCC" width="100%">
	  <form action="" method="post">
		<tr >
                        <td width="" class="main_td">�û���</td>	
			<!--<td width="*" class="main_td">��ʵ����</td>-->
			<td width="" class="main_td">�ʽ��ܶ�</td>
			<td width="" class="main_td">�����ʽ�</td>
			<td width="" class="main_td">�����ʽ�</td>
			<td width="" class="main_td">�����ʽ�(1)</td>
                        <td width="" class="main_td">�����ʽ�(2)</td>
                        <td width="" class="main_td">��ֵ�ʽ�(1)</td>
                        <td width="" class="main_td">��ֵ�ʽ�(2)</td>
                        <td width="" class="main_td">���У�����</td>
                        <td width="" class="main_td">���У�����1</td>
                        <td width="" class="main_td">���У�����2</td>
                        <td width="" class="main_td">�ɹ����ֽ��</td>
                        <td width="" class="main_td">����ʵ�ʵ���</td>
                        <td width="" class="main_td">���ַ���</td>
                        <td width="" class="main_td">Ͷ�꽱�����</td>
                        <td width="" class="main_td">Ͷ�������ʽ�</td>
                        <td width="" class="main_td">Ͷ��������Ϣ</td>
                        <td width="" class="main_td">Ͷ�������Ϣ</td>
                        <td width="" class="main_td">����ܽ��</td>
                        <td width="" class="main_td">���꽱��</td>
                        <td width="" class="main_td">�������</td>
                        <td width="" class="main_td">��������</td>
                        <td width="" class="main_td">������Ϣ</td>
                        <td width="" class="main_td">����ѻ���Ϣ</td>
                        <td width="" class="main_td">ϵͳ�۷�</td>
                        <td width="" class="main_td">�ƹ㽱��</td>
                        <td width="" class="main_td">VIP�۷�</td>
                        <td width="" class="main_td">�ʽ��ܶ�1</td>
                        <td width="" class="main_td">�ʽ��ܶ�2</td>

		</tr>
		{foreach  from=$_A.moneyCheck_list key=key item=item}
		<tr >
                                        <td>{$item.username}</td>
                                        <!--<td>{$item.realname}</td>-->
                                        <td>{$item.total}</td>
                                        <td>{$item.use_money}</td>
                                        <td>{$item.no_use_money}</td>
                                        <td>{$item.collection}</td>
                                        <td>{$item.collection2}</td>
                                        <td>{$item.reMoney}</td>
                                        <td>{$item.reMoney2}</td>
                                        <td>{$item.reMoney_1}</td>
                                        <td>{$item.reMoney_2}</td>
                                        <td>{$item.reMoney_3}</td>
                                        <td>{$item.txTotal}</td>
                                        <td>{$item.txCredited}</td>
                                        <td>{$item.txFee}</td>
                                        <td>{$item.awardAdd}</td>
                                        <td>{$item.collecdMoney}</td>
                                        <td>{$item.interestYes}</td>
                                        <td>{$item.interestWait}</td>
                                        <td>{$item.accountBorrow}</td>
                                        <td>{$item.borrowAward}</td>
                                        <td>{$item.borrowMgrFee}</td>
                                        <td>{$item.waitMoney_money}</td>
                                        <td>{$item.waitMoney_interest}</td>
                                        <td>
 <script>
     document.write({$item.repayment_yesaccount|default:0});
</script>
                                            </td>
                                        <td>{$item.feeSystem}</td>
                                        <td>{$item.invite_money}</td>
                                        <td>{$item.vipMoney}</td>
                                        <td>{$item.total1}</td>
                                        <td>{$item.total2}</td>
                                         
		</tr>
		{/foreach}
		<tr>
		<td colspan="24" class="action">
		<div class="floatl">
		<input type="button" onclick="javascript:location.href='{$_A.query_url}/moneyCheck&type=excel'" value="�����б�" />
		</div>
		<div class="floatr">
			�û�����<input type="text" name="username" id="username" value="{$magic.request.username|urldecode}"/>
                        <input type="button" value="����" onclick="sousuo()">
		</div>
		</td>
	</tr>
		<tr>
			<td colspan="24" class="page">
			{$_A.showpage} 
			</td>
		</tr>
	</form>	
</table>  
                        
{elseif $_A.query_type=="cashCK"}
<table  border="0"  cellspacing="1" bgcolor="#CCCCCC" width="100%">
	  <form action="" method="post">
		<tr >
			<td width="" class="main_td">ID</td>
			<td width="*" class="main_td">�û���</td>
			<td width="" class="main_td">��ʵ����</td>
			<td width="" class="main_td">Ͷ�ʵ������</td>
			<td width="" class="main_td">ʹ�õ����ö�ȣ�X��</td>
			<td width="" class="main_td">���ʲ�(W)</td>
			<td width="" class="main_td">������Ϣ(E)</td>
                        <td width="" class="main_td">���ֱ�׼��W+1.1X-E��</td>
		</tr>
		{ foreach  from=$_A.account_cashCK_list key=key item=item}
		<tr  {if $key%2==1} class="tr2"{/if}>
			<td >{ $item.user_id}</td>
			<td>
                        {$item.username}
                        </td>
			<td >{$item.realname}</td>
			<td >{$item.tender_vouch|default:0}</td>
			<td >
                        
                         <script>
                             document.write({$item.credit|default:0}-{$item.credit_use|default:0}+{$item.borrow_vouch|default:0}-{$item.borrow_vouch_use|default:0});
                         </script>
                         
                        </td>
			<td >
                            
                            {article module="borrow" function="GetUserLog" user_id=$item.user_id var="acc"}
                            <script>
                                document.write({$item.total|default:0}-{$acc.wait_payment|default:0});
                            </script>

                            {/article}
                            
                        </td>
			<td >
                        {article module="borrow" function="GetUserLog" user_id=$item.user_id var="acc"}
                            {$acc.collection_interest0|default:0}
                                                       
                        {/article}
                        </td>
                         <td >
                        {article module="borrow" function="GetUserLog" user_id=$item.user_id var="acc"}
          
                       
                        
                         <script>
                             document.write({$item.credit|default:0}*1.1-{$item.credit_use|default:0}*1.1+{$item.borrow_vouch|default:0}*1.1-{$item.borrow_vouch_use|default:0}*1.1+{$item.total|default:0}-{$acc.wait_payment|default:0}-{$acc.collection_interest0|default:0});
                         </script>
                        
                        {/article}
                        </td>
		</tr>
		{ /foreach}
		<tr>
		<td colspan="10" class="action">
		<div class="floatl">
                   
		</div>
		<div class="floatr">
			�û�����<input type="text" name="username" id="username" value="{$magic.request.username|urldecode}"/> <input type="button" value="����" onclick="sousuo()">
		</div>
		</td>
	</tr>
		<tr>
			<td colspan="9" class="page">
			{$_A.showpage} 
			</td>
		</tr>
	</form>	
</table>
                        
<!--���ּ�¼�б� ��ʼ-->
{elseif $_A.query_type=="cash"}
<table  border="0"  cellspacing="1" bgcolor="#CCCCCC" width="100%">
	  <form action="" method="post">
		<tr >
			<td width="" class="main_td">ID</td>
			<td width="*" class="main_td">�û�����</td>
			<td width="*" class="main_td">��ʵ����</td>
			<td width="" class="main_td">�����˺�</td>
			<td width="" class="main_td">��������</td>
			<td width="" class="main_td">֧��</td>
			<td width="" class="main_td">�����ܶ�</td>
			<td width="" class="main_td">���˽��</td>
			<td width="" class="main_td">������</td>
			<!--<td width="" class="main_td">����ֿ�</td>-->
			<td width="" class="main_td">����ʱ��</td>
			<td width="" class="main_td">״̬</td>
			<td width="" class="main_td">����</td>
		</tr>
		{ foreach  from=$_A.account_cash_list key=key item=item}
		<tr  {if $key%2==1} class="tr2"{/if}>
			<td >{ $item.id}</td>
			<td><a href="{$_A.query_url}/cash&username={$item.username}">{$item.username}</a></td>
			<td >{ $item.realname}</td>
			<td >{ $item.account}</td>
			<td >{ $item.bank_name}</td>
			<td >{ $item.branch}</td>
			<td >{ $item.total}</td>
			<td >{ $item.credited}</td>
			<td >{ $item.fee}</td>	
			<!--<td >{ $item.hongbao}</td>-->
			<td >{ $item.addtime|date_format:"Y-m-d H:i"}</td>
			<td >{if $item.status==0}�����{elseif  $item.status==1} ��ͨ�� {elseif $item.status==2}���ܾ�{/if}</td>
			<td ><a href="{$_A.query_url}/cash_view{$_A.site_url}&id={$item.id}">���/�鿴</a></td>
		</tr>
		{ /foreach}
		<tr>
		<td colspan="11" class="action">
		<div class="floatl">
                    <A href="?{$_A.query_string}&type=excel">������ǰ����</A>

		</div>
		<div class="floatr">
			�û�����<input type="text" name="username" id="username" value="{$magic.request.username|urldecode}"/> ״̬<select id="status" ><option value="">ȫ��</option><option value="1" {if $magic.request.status==1} selected="selected"{/if}>��ͨ��</option><option value="0" {if $magic.request.status=="0"} selected="selected"{/if}>δͨ��</option></select> <input type="button" value="����" / onclick="sousuo()">
		</div>
		</td>
	</tr>
		<tr>
			<td colspan="11" class="page">
			{$_A.showpage} 
			</td>
		</tr>
	</form>	
</table>
<!--���ּ�¼�б� ����-->


<!--������� ��ʼ-->
{elseif $_A.query_type == "cash_view"}
<div class="module_add">
	
	<form name="form1" method="post" action="" onsubmit="return check_form();" enctype="multipart/form-data" >
	<div class="module_title"><strong>�������/�鿴</strong></div>

	<div class="module_border">
		<div class="l">�û�����</div>
		<div class="c">
			{ $_A.account_cash_result.username}
		</div>
	</div>

	<div class="module_border">
		<div class="l">�������У�</div>
		<div class="c">
			{ $_A.account_cash_result.bank_name }
		</div>
	</div>

	<div class="module_border">
		<div class="l">����֧�У�</div>
		<div class="c">
			{ $_A.account_cash_result.branch }
		</div>
	</div>

	<div class="module_border">
		<div class="l">�����˺ţ�</div>
		<div class="c">
			{ $_A.account_cash_result.account }
		</div>
	</div>
	
	<div class="module_border">
		<div class="l">�����ܶ</div>
		<div class="c">
			{ $_A.account_cash_result.total }
		</div>
	</div>
	
	<div class="module_border">
		<div class="l">���˽�</div>
		<div class="c">
			{ $_A.account_cash_result.credited }
		</div>
	</div>
	
	<div class="module_border">
		<div class="l">���ʣ�</div>
		<div class="c">
			{ $_A.account_cash_result.fee }
		</div>
	</div>
	
	<div class="module_border">
		<div class="l">״̬��</div>
		<div class="c">
		{if $_A.account_cash_result.status==0}���������{elseif  $_A.account_cash_result.status==1} ������ͨ�� {elseif $_A.account_cash_result.status==2}���ֱ��ܾ�{/if}
		</div>
	</div>
	
	<div class="module_border">
		<div class="l">���ʱ��/IP:</div>
		<div class="c">
			{ $_A.account_cash_result.addtime|date_format:'Y-m-d H:i:s'}/{ $_A.account_cash_result.addip}</div>
	</div>
	
	{if $_A.account_cash_result.status==0}
	<div class="module_title"><strong>��˴�������Ϣ</strong></div>
	
	<div class="module_border">
		<div class="l">״̬:</div>
		<div class="c">
		<input type="radio" name="status" value="1" />���ͨ�� <input type="radio" name="status" value="2"/>��˲�ͨ�� </div>
	</div>
	
	<div class="module_border" >
		<div class="l">����������:</div>
		<div class="c">
			<input type="text" name="fee" value="{ $_A.account_cash_result.fee}" size="5">
		</div>
	</div>
	
	<div class="module_border" >
		<div class="l">��˱�ע:</div>
		<div class="c">
			<textarea name="verify_remark" cols="45" rows="5">{ $_A.account_result.verify_remark}</textarea>
		</div>
	</div>

	<div class="module_submit" >
		<input type="hidden" name="id" value="{ $_A.account_cash_result.id }" />
		<input type="hidden" name="user_id" value="{ $_A.account_cash_result.user_id }" />
		<input type="submit"  name="reset" value="��˴�������Ϣ" />
	</div>
	{else}
	<div class="module_border">
		<div class="l">�����Ϣ��</div>
		<div class="c">
			����ˣ�{ $_A.account_cash_result.verify_username },���ʱ�䣺{ $_A.account_cash_result.verify_time|date_format:"Y-m-d H:i" },��˱�ע��{ $_A.account_cash_result.verify_remark}
		</div>
	</div>
	{/if}
	</form>
</div>
{literal}
<script>
function check_form(){
	 var frm = document.forms['form1'];
	 var verify_remark = frm.elements['verify_remark'].value;
	 var errorMsg = '';
	  if (verify_remark.length == 0 ) {
		errorMsg += '��ע������д' + '\n';
	  }
	 if(frm.elements['status'][0].checked==false && frm.elements['status'][1].checked==false)
	 {
		 errorMsg += '��ѡ�����״̬��' + '\n';			
	 }
	  if (errorMsg.length > 0){
		alert(errorMsg); return false;
	  } else{  
		return true;
	  }
}
</script>
{/literal}


<!--��ֵ��¼�б� ��ʼ-->
{elseif $_A.query_type=="recharge"}
<table  border="0"  cellspacing="1" bgcolor="#CCCCCC" width="100%">
	  <form action="" method="post">
		<tr >
			<td width="" class="main_td">ID</td>
                        <td width="*" class="main_td">��ˮ��</td>
			<td width="*" class="main_td">�û�����</td>
			<td width="*" class="main_td">��ʵ����</td>
			<td width="" class="main_td">����</td>
			<td width="" class="main_td">��������</td>
			<td width="" class="main_td">��ֵ���</td>
			<td width="" class="main_td">����</td>
			<td width="" class="main_td">���˽��</td>
			<!--<td width="" class="main_td">�������</td>-->
			<td width="" class="main_td">��ֵ����</td>
			<td width="" class="main_td">��ֵʱ��</td>
			<td width="" class="main_td">״̬</td>
			<td width="" class="main_td">���з���</td>
			<td width="" class="main_td">����</td>
		</tr>
		{ foreach  from=$_A.account_recharge_list key=key item=item}
		<tr  {if $key%2==1} class="tr2"{/if}>
			<td >{ $item.id}</td>
                        <td >{ $item.trade_no}</td>
			<td><a href="{$_A.query_url}/recharge&username={$item.username}">{$item.username}</a></td>
			<td >{ $item.realname}</td>
			<td >{ if $item.type==1}���ϳ�ֵ{else}���³�ֵ{/if}</td>
			<td >{if $item.payment==0}�ֶ���ֵ{else}{ $item.payment_name}{/if}</td>
			<td >{ $item.money}Ԫ</td>
			<td >{ $item.fee}Ԫ</td>
			<td ><font color="#FF0000">{$item.total}Ԫ</font></td>
			<!--<td >{ $item.hongbao}Ԫ</td>-->
			<td >{ $item.award}Ԫ</td>
			<td >{ $item.addtime|date_format:"Y-m-d H:i"}</td>
			<td >{if $item.status==0 || $item.status== -1 }<font color="#6699CC">���</font>{elseif  $item.status==1} �ɹ� {else}<font color="#FF0000">ʧ��</font>{/if}</td>
               <td >{  if $item.return==""&& $item.type==1  }<span style="color:#F00">����δ����</span>{elseif $item.return<>""&& $item.type==1} �����ѵ���{else}���º˶�{/if}</td>

			<td ><a href="{$_A.query_url}/recharge_view{$_A.site_url}&id={$item.id}">���/�鿴</a></td>
		</tr>
		{ /foreach}
		<tr>
		<td colspan="11" class="action">
		<div class="floatl">
		 <A href="?{$_A.query_string}&type=excel">������ǰ����</A>
		</div>
		<div class="floatr">
		��ֵʱ�䣺<input type="text" name="dotime1" id="dotime1" value="{$magic.request.dotime1}" size="15" onclick="change_picktime()"/> �� <input type="text"  name="dotime2" value="{$magic.request.dotime2}" id="dotime2" size="15" onclick="change_picktime()"/>	
                    �û�����<input type="text" name="username" id="username" value="{$magic.request.username|urldecode}"/> ״̬<select id="status" ><option value="-1" {if $magic.request.status=="-1"} selected="selected"{/if}>δ���</option><option value="1" {if $magic.request.status==1} selected="selected"{/if}>��˳ɹ�</option><option value="2" {if $magic.request.status=="2"} selected="selected"{/if}>���ʧ��</option></select> <input type="button" value="����" / onclick="sousuo()">
		</div>
		</td>
	</tr>
		<tr>
			<td colspan="11" class="page">
			{$_A.showpage} 
			</td>
		</tr>
	</form>	
</table>
<!--��ֵ��¼�б� ����-->
<!--������� ��ʼ-->
{elseif $_A.query_type == "recharge_view"}
<div class="module_add">
	
	<form name="form1" method="post" action="" onsubmit="return check_form();" enctype="multipart/form-data" >
	<div class="module_title"><strong>��ֵ�鿴</strong></div>

	<div class="module_border">
		<div class="l">�û�����</div>
		<div class="c">
			<!--
			<a href="javascript:void(0)" onclick='tipsWindown("�û���ϸ��Ϣ�鿴","url:get?{$_A.query_url}/view&user_id={$_A.account_recharge_result.user_id}&type=scene",500,230,"true","","true","text");'></a>
			-->
			{ $_A.account_recharge_result.username}
		</div>
	</div>

	<div class="module_border">
		<div class="l">��ֵ���ͣ�</div>
		<div class="c">
			{if $_A.account_recharge_result.type==1}���ϳ�ֵ{else}���³�ֵ{/if}
		</div>
	</div>

	<div class="module_border">
		<div class="l">֧����ʽ��</div>
		<div class="c">
			{ $_A.account_recharge_result.payment_name}
		</div>
	</div>
	
	<div class="module_border">
		<div class="l">��ֵ�ܶ</div>
		<div class="c">
			{ $_A.account_recharge_result.money }Ԫ
		</div>
	</div>
	
	
	<div class="module_border">
		<div class="l">���ã�</div>
		<div class="c">
			{ $_A.account_recharge_result.fee }Ԫ
		</div>
	</div>
	
	<div class="module_border">
		<div class="l">ʵ�ʵ��ˣ�</div>
		<div class="c">
			{ $_A.account_recharge_result.total }Ԫ
		</div>
	</div>
	
	<div class="module_border">
		<div class="l">�û���ע��</div>
		<div class="c">
		{ $_A.account_recharge_result.remark }
		</div>
	</div>
	
	
	<div class="module_border">
		<div class="l">��ˮ�ţ�</div>
		<div class="c">
		{ $_A.account_recharge_result.remark }
		</div>
	</div>
	
	<div class="module_border">
		<div class="l">״̬��</div>
		<div class="c">
		{if $_A.account_recharge_result.status==0}�ȴ����{elseif  $_A.account_recharge_result.status==1} ��ֵ�ɹ� {elseif $_A.account_recharge_result.status==2}��ֵʧ��{/if}
		</div>
	</div>
	
	<div class="module_border">
		<div class="l">���ʱ��/IP:</div>
		<div class="c">
			{ $_A.account_recharge_result.addtime|date_format:'Y-m-d H:i:s'}/{ $_A.account_recharge_result.addip}</div>
	</div>
	
	{if $_A.account_recharge_result.status==0  }
	<div class="module_title"><strong>��˴˳�ֵ��Ϣ</strong></div>
	
	<div class="module_border">
		<div class="l">״̬:</div>
		<div class="c">
	<input type="radio" name="status" value="1"/>��ֵ�ɹ�   <input type="radio" name="status" value="2"  checked="checked"/>��ֵʧ�� </div>
	</div>
	
	<div class="module_border" >
		<div class="l">���˽��:</div>
		<div class="c">
			<input type="text" name="total" value="{ $_A.account_recharge_result.total }" size="15" readonly="">��һ�����ͨ���������ٽ����޸ģ�
		</div>
	</div>
	
	<div class="module_border" >
		<div class="l">��˱�ע:</div>
		<div class="c">
			<textarea name="verify_remark" cols="45" rows="5">{ $_A.account_recharge_result.verify_remark}</textarea>
		</div>
	</div>

	<div class="module_submit" >
		<input type="hidden" name="id" value="{ $_A.account_recharge_result.id }" />
		
		<input type="submit"  name="reset" value="��˴˳�ֵ��Ϣ" />
	</div>
	{else}
		{if $_A.account_recharge_result.type==2 }
	<div class="module_border">
		<div class="l">�����Ϣ��</div>
		<div class="c">
			����ˣ�{ $_A.account_result.verify_username },���ʱ�䣺{ $_A.account_result.verify_time|date_format:"Y-m-d H:i" },��˱�ע��{ $_A.account_result.verify_remark}
		</div>
	</div>
	{/if}
	{/if}
	</form>
</div>
{literal}
<script>
function check_form(){
	 var frm = document.forms['form1'];
	 var verify_remark = frm.elements['verify_remark'].value;
	 var errorMsg = '';
	  if (verify_remark.length == 0 ) {
		errorMsg += '��ע������д' + '\n';
	  }
	  
	  if (errorMsg.length > 0){
		alert(errorMsg); return false;
	  } else{  
		return true;
	  }
}
</script>
{/literal}



<!--��ӳ�ֵ��¼ ��ʼ-->
{elseif $_A.query_type == "recharge_new"}

<div class="module_add">
	
	<form name="form1" method="post" action="" onsubmit="return check_form();" enctype="multipart/form-data" >
	<div class="module_title"><strong>��ӳ�ֵ</strong></div>

	<div class="module_border">
		<div class="l">�û�����</div>
		<div class="c">
			<input type="text" name="username" />
		</div>
	</div>
	<div class="module_border">
		<div class="l">���ͣ�</div>
		<div class="c">
			���³�ֵ<input type="hidden" name="type" />
		</div>
	</div>
	<div class="module_border">
		<div class="l">��</div>
		<div class="c">
			<input type="text" name="money" />
		</div>
	</div>
	
	<div class="module_border">
		<div class="l">��ע��</div>
		<div class="c">
			<input type="text" name="remark" />
		</div>
	</div>
	
	<div class="module_submit" >
		
		<input type="submit"  name="reset" value="ȷ�ϳ�ֵ" />
	</div>
</form>
</div>

<!--��ӳ�ֵ��¼ ����-->




<!--��ӳ�ֵ��¼ ��ʼ-->
{elseif $_A.query_type == "deduct"}

<div class="module_add">
	
	<form name="form1" method="post" action="" onsubmit="return check_form();" enctype="multipart/form-data" >
	<div class="module_title"><strong>���ÿ۳�</strong></div>

	<div class="module_border">
		<div class="l">�û�����</div>
		<div class="c">
			<input type="text" name="username" />
		</div>
	</div>
	<div class="module_border">
		<div class="l">���ͣ�</div>
		<div class="c">
			<select name="type">
				<!--
				<option value="scene_account">�ֳ���֤����</option>
				<option value="vouch_advanced">�����渶�۷�</option>
				<option value="borrow_kouhui">����˷���ۻ�</option>
				-->
				<option value="account_other">����</option>
			</select>
		</div>
	</div>
	<div class="module_border">
		<div class="l">��</div>
		<div class="c">
			<input type="text" name="money" />
		</div>
	</div>
	
	<div class="module_border">
		<div class="l">��ע��</div>
		<div class="c">
			<input type="text" name="remark" />���磬�ֳ����ÿ۳�200Ԫ
		</div>
	</div>
	<div class="module_border">
		<div class="l">��֤�룺</div>
		<div class="c"><input  class="user_aciton_input"  name="valicode" type="text" size="8" maxlength="4" style=" padding-top:4px; height:16px; width:70px;"/>&nbsp;<img src="/plugins/index.php?q=imgcode" alt="���ˢ��" onClick="this.src='/plugins/index.php?q=imgcode&t=' + Math.random();" align="absmiddle" style="cursor:pointer" />
		</div>
	</div>
	<div class="module_submit" >
		
		<input type="submit"  name="reset" value="ȷ���۳�" />
	</div>
</form>
</div>

<!--��ӳ�ֵ��¼ ����-->

<!--�ʽ�ʹ�ü�¼�б� ��ʼ-->
{elseif $_A.query_type=="log"}
<table  border="0"  cellspacing="1" bgcolor="#CCCCCC" width="100%">
	  <form action="" method="post">
		<tr >
			<td width="" class="main_td">ID</td>
			<td width="*" class="main_td">�û�����</td>
			<td width="" class="main_td">����</td>
			<td width="" class="main_td">�ܽ��</td>
			<td width="" class="main_td">�������</td>
			<td width="" class="main_td">���ý��</td>
			<td width="" class="main_td">������</td>
			<td width="" class="main_td">���ս��</td>
			<td width="" class="main_td">���׶Է�</td>
			<td width="" class="main_td">��¼ʱ��</td>
            <td width="" class="main_td">��ע</td>
            <td width="" class="main_td">��¼��վ</td>
            <td width="" class="main_td">��ؽ���</td>
		</tr>
		{ foreach  from=$_A.account_log_list key=key item=item}
		<tr  {if $key%2==1} class="tr2"{/if}>
			<td >{ $item.id}</td>
			<td><a href="{$_A.query_url}/recharge&username={$item.username}">{$item.username}</a></td>
			<td >{ $item.type|linkage:"account_type"}</td>
			<td >{ $item.total}</td>
			<td >{ $item.money}</td>
			<td >{ $item.use_money}</td>
			<td >{ $item.no_use_money|default:0}</td>
			<td >{ $item.collection|default:0}</td>
			<td >{ $item.to_username|default:admin}</td>
			<td >{ $item.addtime|date_format:"Y-m-d H:i"}</td>
            <td >{ $item.remark}</td>
            <td >{ $item.sitename}</td>
            <td >{ $item.borrow_name}</td>
		</tr>
		{ /foreach}
		<tr>
		<td colspan="11" class="action">
		<div class="floatl">
<A href="?{$_A.query_string}&typeaction=excel">������ǰ����</A>
		</div>
		<div class="floatr">
			ʱ�䣺<input type="text" name="dotime1" id="dotime1" value="{$magic.request.dotime1|default:"$day7"|date_format:"Y-m-d"}" size="15" onclick="change_picktime()"/> �� <input type="text"  name="dotime2" value="{$magic.request.dotime2|default:"$nowtime"|date_format:"Y-m-d"}" id="dotime2" size="15" onclick="change_picktime()"/>   
		{linkages nid="account_type" value="$magic.request.type" name="type" type="value" default="ȫ��" } �û�����<input type="text" name="username" id="username" value="{$magic.request.username|urldecode}"/> ״̬<select id="status" ><option value="">ȫ��</option><option value="1" {if $magic.request.status==1} selected="selected"{/if}>��ͨ��</option><option value="0" {if $magic.request.status=="0"} selected="selected"{/if}>δͨ��</option></select> <input type="button" value="����" / onclick="sousuo()">
		</div>
		</td>
	</tr>
		<tr>
			<td colspan="11" class="page">
			{$_A.showpage} 
			</td>
		</tr>
	</form>	
</table>
<!--�ʽ�ʹ�ü�¼�б� ����-->

<!--��վ�ʽ��б� ��ʼ-->
{elseif $_A.query_type=="site"}
<table  border="0"  cellspacing="1" bgcolor="#CCCCCC" width="100%">
	  <form action="" method="post">
		<tr >
			<td width="" class="main_td">ID</td>
			<td width="*" class="main_td">��վ����</td>
			<td width="" class="main_td">����</td>
			<td width="" class="main_td">�ܽ��</td>
			<td width="" class="main_td">����</td>
		</tr>
		{ foreach  from=$_A.subsite_money key=key item=item}
		<tr  {if $key%2==1} class="tr2"{/if}>
			<td >{ $item.id}</td>
			<td>{$item.sitename}</td>
			<td align="left">{ $item.website}</td>
			<td >{ $item.jiesuan_money}</td>
            <td ><a href="{$_A.query_url}/site_changemoney&subsite_id={$item.id}&a=cash">���ı�֤��</a>&nbsp;&nbsp;
            <a href="{$_A.query_url}/site_moneylog&subsite_id={$item.id}&a=cash">�鿴��¼</a>
            </td>
		</tr>
		{ /foreach}
 		</form>
 </table>
{elseif $_A.query_type=="site_moneylog"}
<table  border="0"  cellspacing="1" bgcolor="#CCCCCC" width="100%">
	  <form action="" method="post">
		<tr >
			<td width="" class="main_td">ID</td>
            <td width="" class="main_td">��¼��վ</td>
			<td width="*" class="main_td">�û�����</td>
			<td width="" class="main_td">����</td>
			<td width="" class="main_td">�ܽ��</td>
			<td width="" class="main_td">�������</td>

			<td width="" class="main_td">��¼ʱ��</td>
            <td width="" class="main_td">��ע</td>
            
            <td width="" class="main_td">��ؽ���</td>
		</tr>
		{ foreach  from=$_A.subsite_moneylog key=key item=item}
		<tr  {if $key%2==1} class="tr2"{/if}>
			<td >{ $item.id}</td>
            <td >{ $item.sitename}</td>
			<td><a href="{$_A.query_url}/log&a=cash&username={$item.username}">{$item.username}</a></td>
			<td >{ $item.type|linkage:"account_type"}</td>
			<td >{ $item.total}</td>
			<td >{ $item.money}</td>
			
			<td >{ $item.addtime|date_format:"Y-m-d H:i"}</td>
            <td >{ $item.remark}</td>
            
            <td >{ $item.borrow_name}</td>
		</tr>
		{ /foreach}
		<tr>
		<td colspan="11" class="action">
		<div class="floatl">
<A href="?{$_A.query_string}&typeaction=excel">������ǰ����</A>
		</div>
		<div class="floatr">
        ���ƣ�{$_A.account}Ԫ&nbsp;&nbsp;
			ʱ�䣺<input type="text" name="dotime1" id="dotime1" value="{$magic.request.dotime1|default:"$day7"|date_format:"Y-m-d"}" size="15" onclick="change_picktime()"/> �� <input type="text"  name="dotime2" value="{$magic.request.dotime2|default:"$nowtime"|date_format:"Y-m-d"}" id="dotime2" size="15" onclick="change_picktime()"/>  
         <select name="subsite_id" id="subsite_id">
         <option value="">ȫ��</option>
        {foreach  from=$_A.subsite_money key=key item=item}
		<option value="{$item.id}" {if $magic.request.subsite_id== $item.id}selected{/if}>{$item.sitename}</option>
		{/foreach}
        </select>
             
		{linkages nid="account_type" value="$magic.request.type" name="type" type="value" default="ȫ��" } �û�����<input type="text" name="username" id="username" value="{$magic.request.username|urldecode}"/>  <input type="button" value="����" / onclick="sousuo()">
		</div>
		</td>
	</tr>
		<tr>
			<td colspan="11" class="page">
			{$_A.showpage} 
			</td>
		</tr>
	</form>	
</table>

{elseif $_A.query_type=="site_changemoney"}
<form name="form1" method="post" action="" onsubmit="return check_form();" enctype="multipart/form-data">
	<div class="module_title"><strong>��ӱ�֤��</strong></div>

	<div class="module_border">
		<div class="l">��վ���ƣ�</div>
		<div class="c">
			{$_A.subsite_name}
            <input type="hidden" name="subsite_id" value="{$magic.request.subsite_id}">
		</div>
	</div>
	<div class="module_border">
		<div class="l">���ͣ�</div>
		<div class="c">
			<input type="radio" name="type" checked="checked" value="1">��ӱ�֤��
            <input type="radio" name="type" value="2">���ٱ�֤��
		</div>
	</div>
	<div class="module_border">
		<div class="l">��</div>
		<div class="c">
			<input type="text" name="money">
		</div>
	</div>
	
	<div class="module_border">
		<div class="l">��ע��</div>
		<div class="c">
            <textarea cols="30" rows="3" name="remark"></textarea>
		</div>
	</div>
	<div class="module_submit">
		<input type="submit" name="reset" value="ȷ�����">
	</div>
</form>


<!--��վ�ʽ��б� ����-->


<!--�ʽ�ʹ�ü�¼�б� ��ʼ-->
{elseif $_A.query_type=="logtender"}
<table  border="0"  cellspacing="1" bgcolor="#CCCCCC" width="100%">
	  <form action="" method="post">
		<tr >
			<td width="" class="main_td">ID</td>
			<td width="*" class="main_td">�û�����</td>
			<td width="" class="main_td">����</td>
			<td width="" class="main_td">�ܽ��</td>
			<td width="" class="main_td">�������</td>
			<td width="" class="main_td">���ý��</td>
			<td width="" class="main_td">������</td>
			<td width="" class="main_td">���ս��</td>
			<td width="" class="main_td">���׶Է�</td>
			<td width="" class="main_td">��¼ʱ��</td>
            <td width="" class="main_td">��ע</td>
            <td width="" class="main_td">��¼��վ</td>
            <td width="" class="main_td">��ؽ���</td>
		</tr>
		{ foreach  from=$_A.account_log_list key=key item=item}
		<tr  {if $key%2==1} class="tr2"{/if}>
			<td >{ $item.id}</td>
			<td><a href="{$_A.query_url}/recharge&username={$item.username}">{$item.username}</a></td>
			<td >{ $item.type|linkage:"account_type"}</td>
			<td >{ $item.total}</td>
			<td >{ $item.money}</td>
			<td >{ $item.use_money}</td>
			<td >{ $item.no_use_money|default:0}</td>
			<td >{ $item.collection|default:0}</td>
			<td >{ $item.to_username|default:admin}</td>
			<td >{ $item.addtime|date_format:"Y-m-d H:i"}</td>
            <td >{ $item.remark}</td>
            <td >{ $item.sitename}</td>
            <td >{ $item.borrow_name}</td>
		</tr>
		{ /foreach}
		<tr>
		<td colspan="11" class="action">
		<div class="floatl">
<A href="?{$_A.query_string}&typeaction=excel">������ǰ����</A>
		</div>
		<div class="floatr">
			ʱ�䣺<input type="text" name="dotime1" id="dotime1" value="{$magic.request.dotime1|default:"$day7"|date_format:"Y-m-d"}" size="15" onclick="change_picktime()"/> �� <input type="text"  name="dotime2" value="{$magic.request.dotime2|default:"$nowtime"|date_format:"Y-m-d"}" id="dotime2" size="15" onclick="change_picktime()"/>
			��վ��<select name="subsite_id" id="subsite_id">
			{foreach from=$_A.subsite_list item=item}
			<option  value="{ $item.id}" {if $item.id==$magic.request.subsite_id} selected="selected"{/if} />{ $item.sitename}</option>
			
			{/foreach}
			</select>   
		 �û�����<input type="text" name="username" id="username" value="{$magic.request.username|urldecode}"/>  <input type="button" value="����" / onclick="sousuo()">
		</div>
		</td>
	</tr>
		<tr>
			<td colspan="11" class="page">
			{$_A.showpage} 
			</td>
		</tr>
	</form>	
</table>
<!--�ʽ�ʹ�ü�¼�б� ����-->

{elseif $_A.query_type=="wsfl_list"}
<table  border="0"  cellspacing="1" bgcolor="#CCCCCC" width="100%">
	  <form action="" method="post">
		<tr >
			<td width="" class="main_td">�û�ID</td>
			<td width="" class="main_td">ProcessID</td>
			<td width="*" class="main_td">�û���</td>
			<td width="" class="main_td">��ʵ����</td>
			<td width="" class="main_td">��������</td>
			<td width="" class="main_td">�������</td>
			<td width="" class="main_td">����״̬</td>
			<td width="" class="main_td">webservice user_id</td>
			<td width="" class="main_td">����ʱ��</td>
		</tr>
		{ foreach  from=$_A.wsfl_list key=key item=item}
		<tr  {if $key%2==1} class="tr2"{/if}>
			<td >{ $item.user_id}</td>
			<td >{ $item.process_id}</td>
			<td><!--<a href="javascript:void(0)" onclick='tipsWindown("�û���ϸ��Ϣ�鿴","url:get?index.php?admin&q=module/user/view&user_id={$item.user_id}&type=scene",500,230,"true","","true","text");'></a>-->
                        {$item.username}
                        </td>
			<td >{$item.realname}</td>
			<td >{$item.mony}</td>
			<td >{$item.loaner_money|default:0}</td>
			<td >{if $item.process==0}δ����{else}������{/if}</td>
			<td >{$item.ws_user_id}</td>
			<td >{$item.fl_time}</td>
                       
		</tr>
		{ /foreach}
		<tr>
		<td colspan="10" class="action">
		<div class="floatl">
		<input type="button" onclick="javascript:location.href='{$_A.query_url}&type=excel'" value="�����б�" />
		</div>
		<div class="floatr">
			�û�����<input type="text" name="username" id="username" value="{$magic.request.username|urldecode}"/> <input type="button" value="����" onclick="sousuo()">
		</div>
		</td>
	</tr>
		<tr>
			<td colspan="9" class="page">
			{$_A.showpage} 
			</td>
		</tr>
	</form>	
</table>

{elseif $_A.query_type=="wsfl_get_list"}
<table  border="0"  cellspacing="1" bgcolor="#CCCCCC" width="100%">
	  <form action="" method="post">
		<tr >
			<td width="" class="main_td">�û�ID</td>
			<td width="" class="main_td">ProcessID</td>
			<td width="*" class="main_td">�û���</td>
			<td width="" class="main_td">��ʵ����</td>
			<td width="" class="main_td">��������</td>
			<td width="" class="main_td">�������</td>
			<td width="" class="main_td">����״̬</td>
			<td width="" class="main_td">webservice user_id</td>
			<td width="" class="main_td">����ʱ��</td>
		</tr>
		{ foreach  from=$_A.wsfl_list key=key item=item}
		<tr  {if $key%2==1} class="tr2"{/if}>
			<td >{ $item.user_id}</td>
			<td >{ $item.process_id}</td>
			<td><!--<a href="javascript:void(0)" onclick='tipsWindown("�û���ϸ��Ϣ�鿴","url:get?index.php?admin&q=module/user/view&user_id={$item.user_id}&type=scene",500,230,"true","","true","text");'></a>-->
                        {$item.username}
                        </td>
			<td >{$item.realname}</td>
			<td >{$item.mony}</td>
			<td >{$item.loaner_money|default:0}</td>
			<td >{if $item.process==0}δ����{else}������{/if}</td>
			<td >{$item.ws_user_id}</td>
			<td >{$item.fl_time}</td>
                       
		</tr>
		{ /foreach}
		<tr>
		<td colspan="10" class="action">
		<div class="floatl">
		<input type="button" onclick="javascript:location.href='{$_A.query_url}&type=excel'" value="�����б�" />
		</div>
		<div class="floatr">
			�û�����<input type="text" name="username" id="username" value="{$magic.request.username|urldecode}"/> <input type="button" value="����" onclick="sousuo()">
		</div>
		</td>
	</tr>
		<tr>
			<td colspan="9" class="page">
			{$_A.showpage} 
			</td>
		</tr>
	</form>	
</table>

{elseif $_A.query_type=="wsfl_cash_report"}
<table  border="0"  cellspacing="1" bgcolor="#CCCCCC" width="100%">
	  <form action="" method="post">
		<tr >
			<td width="" class="main_td">��������</td>
			<td width="" class="main_td">���������ܺ�</td>
			<td width="" class="main_td">��������ܺ�</td>
			<td width="" class="main_td">����״̬</td>
			<td width="" class="main_td">����</td>
		</tr>
		{ foreach  from=$_A.wsfl_cash_list key=key item=item}
		<tr  {if $key%2==1} class="tr2"{/if}>
			<td >{$item.fl_time}</td>
			<td >{$item.total_mony|default:0}</td>
			<td >{$item.total_loaner_money|default:0}</td>
			<td >{if $item.process==0}δ����{else}������{/if}</td>
			<td >{if $item.process==0}<a href="{$_A.query_url}/wsfl_cash{$_A.site_url}&fl_time={$item.fl_time}">��������</a>{/if}</td>                        
		</tr>
		{ /foreach}
		<tr>
		<td colspan="10" class="action">
		<div class="floatl">
		<input type="button" onclick="javascript:location.href='{$_A.query_url}&type=excel'" value="�����б�" />
		</div>
		<div class="floatr">
			�û�����<input type="text" name="username" id="username" value="{$magic.request.username|urldecode}"/> <input type="button" value="����" onclick="sousuo()">
		</div>
		</td>
	</tr>
		<tr>
			<td colspan="9" class="page">
			{$_A.showpage} 
			</td>
		</tr>
	</form>	
</table>

{elseif $_A.query_type=="wsfl_queue_list" || $_A.query_type=="wsfl_queue_query" || $_A.query_type=="wsfl_queue_close"}
<table  border="0"  cellspacing="1" bgcolor="#CCCCCC" width="100%">
	  <form action="" method="post">
		<tr >
			<td width="" class="main_td">�û�ID</td>
			<td width="" class="main_td">�û���</td>
			<td width="" class="main_td">��ʵ����</td>
			<td width="" class="main_td">webservice userid</td>
			<td width="" class="main_td">����ID</td>
			<td width="" class="main_td">����</td>
			<td width="" class="main_td">Ӧ�÷���</td>
			<td width="" class="main_td">�Ѿ�����</td>
			<td width="" class="main_td">״̬</td>
			<td width="" class="main_td">����</td>
		</tr>
		{ foreach  from=$_A.wsfl_queue_list key=key item=item}
		<tr  {if $key%2==1} class="tr2"{/if}>
			<td >{$item.user_id}</td>
			<td >{$item.username}</td>
			<td >{$item.realname}</td>
			<td >{$item.ws_user_id}</td>
			<td >{$item.ws_queue_id}</td>
			<td >{$item.out_money|default:0}</td>
			<td >{$item.in_should_money|default:0}</td>
			<td >{$item.in_ed_money|default:0}</td>
			<td >{if $item.status==0}����{else}�ر�{/if}</td>
			<td ><a href="{$_A.query_url}/wsfl_queue_close{$_A.site_url}&id={$item.ws_queue_id}">��������</a> | <a href="{$_A.query_url}/wsfl_queue_query{$_A.site_url}&id={$item.ws_queue_id}">��ѯ��������</a></td>                        
		</tr>
		{ /foreach}
		<tr>
		<td colspan="10" class="action">
		<div class="floatl">
		<input type="button" onclick="javascript:location.href='{$_A.query_url}&type=excel'" value="�����б�" />
        <input type="button" value="���㷵��" onclick="javascript:location.href='{$_A.query_url}/wsfl_queue_call';this.disabled = true;"/>
		</div>
		<div class="floatr">
			�û�����<input type="text" name="username" id="username" value="{$magic.request.username|urldecode}"/> <input type="button" value="����" onclick="sousuo()">
		</div>
		</td>
	</tr>
		<tr>
			<td colspan="9" class="page">
			{$_A.showpage} 
			</td>
		</tr>
	</form>	
</table>

{elseif $_A.query_type=="wsfl_rebate_list"}
<table  border="0"  cellspacing="1" bgcolor="#CCCCCC" width="100%">
	  <form action="" method="post">
		<tr >
			<td width="" class="main_td">�û�ID</td>
			<td width="" class="main_td">�û���</td>
			<td width="" class="main_td">����ʱ��</td>
			<td width="" class="main_td">webservice userid</td>
			<td width="" class="main_td">����ID</td>
            <td width="" class="main_td">����</td>
			<td width="" class="main_td">����</td>
			<td width="" class="main_td">Ӧ�÷���</td>
			<td width="" class="main_td">�Ѿ�����</td>
			<td width="" class="main_td">״̬</td>
            <td width="" class="main_td">����ʱ��</td>
            
		</tr>
		{ foreach  from=$_A.wsfl_rebate_list key=key item=item}
		<tr  {if $key%2==1} class="tr2"{/if}>
			<td >{$item.user_id}</td>
			<td >{$item.user_name}</td>
			<td >{$item.addtime}</td>
			<td >{$item.web_id}</td>
			<td >{$item.listid}</td>
            <td >{$item.type}</td>
			<td >{$item.inmoney|default:0}</td>
			<td >{$item.money|default:0}</td>
			<td >{$item.RebatesMoney|default:0}</td>
			<td >{$item.RebatesStatus}</td>
            <td >{$item.Aside4}</td>
			                        
		</tr>
		{ /foreach}
		<tr>
		<td colspan="10" class="action">
		<div class="floatl">
		
        <input type="button" value="���㷵��" onclick="javascript:location.href='{$_A.query_url}/wsfl_queue_call';this.disabled = true;"/>
		</div>
		
		</td>
	</tr>
		<tr>
			<td colspan="9" class="page">
            {literal}
            <style type="text/css">
.p_bar {
clear:both;
margin:15px 0;
}
.p_bar a {
font-size:12px;
text-decoration:none;
padding:2px 5px;
}
.p_bar a:hover {
background:#F5FBFF;
border:1px solid #86B9D6;
text-decoration:none;
}
.p_info {
background:#F5FBFF;
border:1px solid #86B9D6;
margin-right:1px;
padding:2px 5px;
}
.p_num {
background:#FFF;
border:1px solid #DEDEB8;
margin-right:1px;
}
.p_redirect {
background:#FFF;
border:1px solid #DEDEB8;
margin-right:1px;
font-weight:700;
font-size:12px;
}
.p_curpage {
margin-right:1px;
border:1px solid #DEDEB8;
background:#FFFFD9;
color:#92A05A;
font-weight:700;
padding:2px 5px;
}
			</style>{/literal}
			{$_A.page1} 
			</td>
		</tr>
	</form>	
</table>

<!--��ȹ��� ��ʼ-->
{elseif $_A.query_type=="stock"}
<table  border="0"  cellspacing="1" bgcolor="#CCCCCC" width="100%">
	  <form action="" method="post">
		<tr >
			<td width="" class="main_td">ID</td>
			<td width="*" class="main_td" align="left">�û�����</td>
			<td width="" class="main_td" align="left">��������</td>
			<td width="" class="main_td" align="left">��������</td>
			<td width="" class="main_td" align="left">���׽��</td>
			<td width="" class="main_td" align="left">����ʱ��</td>
			<td width="" class="main_td" align="left">��ע</td>
			<td width="" class="main_td" align="left">״̬</td>
			<td width="" class="main_td" align="left">����</td>
		</tr>
		{ foreach  from=$_A.stock_list key=key item=item}
		<tr  {if $key%2==1} class="tr2"{/if}>
			<td >{ $item.id}</td>
			<td class="main_td1"  align="left"><a href="javascript:void(0)" onclick='tipsWindown("�û���ϸ��Ϣ�鿴","url:get?{$_A.admin_url}&q=module/user/view&user_id={$item.user_id}&type=scene",500,230,"true","","true","text");'>	{$item.username}</a></td>
			<td width="80" align="left">
				{if $item.optype =="0"}����
				{else}�۳�{/if}
			</td>
			<td width="70" align="left">{$item.num}</td>
			<td width="70"  align="left">{$item.trade_account}Ԫ</td>
			<td  align="left">{ $item.addtime|date_format}</td>
			<td  align="left">{ $item.remark}</td>
			<td  width="50" align="left">{if $item.status==0}�������{elseif $item.status==1}���ͨ��{else}��˲�ͨ��{/if}</td>
			<td  width="70" align="left">{if $item.status==0}<a href="{$_A.query_url}/stock_view{$_A.site_url}&id={$item.id}">���</a>{/if}</td>
		</tr>
		{ /foreach}
		<tr>
		<td colspan="11" class="action">
		<div class="floatl">
		
		</div>
		<div class="floatr">
			�û�����<input type="text" name="username" id="username" value="{$magic.request.username|urldecode}"/> ״̬<select id="status" ><option value="">ȫ��</option><option value="1" {if $magic.request.status==1} selected="selected"{/if}>��ͨ��</option><option value="0" {if $magic.request.status=="0"} selected="selected"{/if}>δͨ��</option></select> <input type="button" value="����" / onclick="sousuo('{$_A.query_url}/amount{$_A.site_url}')">
		</div>
		</td>
	</tr>
		<tr>
			<td colspan="11" class="page">
			{$_A.showpage} 
			</td>
		</tr>
	</form>	
</table>
<!--��ȹ��� ����-->


<!--�Զ�Ͷ�� ��ʼ-->
{elseif $_A.query_type=="autolist"}
<table  border="0"  cellspacing="1" bgcolor="#CCCCCC" width="100%">
			  <form action="" method="post">
				<tr>
                	<td class="main_td">�û����</td>
                    <td class="main_td">�û���</td>
                    <td class="main_td">����</td>
                    <td class="main_td">�ʻ��ܶ�</td>
                    <td class="main_td">�ʻ����</td>
					<td class="main_td">�Ƿ�����</td>
					
					<td class="main_td">Ͷ����</td>
                    <td class="main_td">���ʽ</td>
					<td class="main_td">���ʷ�Χ</td>
					<td class="main_td">�������</td>
					<td class="main_td">��Ľ���</td>
					<td class="main_td">Ͷ�ʱ���</td>					
				</tr>
				
                { foreach  from=$_A.autolist key=key item=var}
				
				<tr  {if $key%2==1} class="tr2"{/if}>
                	<td>{$var.user_id}</td>
                    <td>{$var.username}</td>
                    <td>{$var.realname}</td>
                    <td>��{$var.total}</td>
                    <td>��{$var.use_money}</td>
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
                    {$var.timelimit_month_first}�� ~ {$var.timelimit_month_last} ��  &nbsp;��&nbsp;
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
					
				</tr>
				{/foreach}
                <tr><td  colspan="10">��Ч��{$_A.tmoney} &nbsp; ��&nbsp;  
                �ܿ�����{$_A.use_money} &nbsp; ��&nbsp;
                 �ٷֱȣ�{$_A.rate}</td></tr>
			</form>	
		</table>
<!--�Զ�Ͷ�� ����-->

<!--������ ��ʼ-->
{elseif $_A.query_type=="stock_view"}
<div class="module_title"><strong>�ɷ��������</strong></div>
	<div class="module_border">
		<div class="l">�û�����</div>
		<div class="h">
			{$_A.stock_result.username}
		</div>
	</div>
	<div class="module_border">
		<div class="l">�����������ͣ�</div>
		<div class="h">
			{if $_A.stock_result.optype=="0"}<font color="#FF0000">����</font>{else}<font color="#FF0000">�۳�</font>{/if}
		</div>
	</div>
	<div class="module_border">
		<div class="l">������</div>
		<div class="h">
			{$_A.stock_result.num|default:0}
		</div>
	</div>
	<div class="module_border">
		<div class="l">���׽�</div>
		<div class="h">
			{$_A.stock_result.trade_account|default:0}
		</div>
	</div>	
	<div class="module_border">
		<div class="l">��ע��</div>
		<div class="h">
			{$_A.stock_result.remark}
		</div>
	</div>
	
	<div class="module_border">
		<div class="l">����ʱ�䣺</div>
		<div class="h">
			{$_A.stock_result.addtime|date_format}
		</div>
	</div>
	<div class="module_title"><strong>���</strong></div>
	<form method="post" action="">
	<div class="module_border">
		<div class="l">���״̬��</div>
		<div class="h">
			<input type="radio" name="status" value="1" />ͨ��  <input type="radio" name="status" value="2" checked="checked" />��ͨ��
		</div>
	</div>

	<div class="module_border">
		<div class="l">��˱�ע��</div>
		<div class="h">
			<textarea name="verify_remark" rows="5" cols="40" ></textarea>
		</div>
	</div>
	<div class="module_border">
		<div class="l"></div>
		<div class="h">
			<input type="submit" value="ȷ�����" />
		</div>
	</div>
	</form>

{/if}
<script>
var url = '{$_A.query_url}/{$_A.query_type}{$_A.site_url}';
{literal}
function sousuo(){
	var sou = "";
	var username = $("#username").val();
	if (username!=""){
		sou += "&username="+username;
	}
	var username2 = $("#username2").val();
	if (username2!=""){
		sou += "&username2="+username2;
	}
	var status = $("#status").val();
	if (status!="" && status!=null){
		sou += "&status="+status;
	}
	var dotime1 = $("#dotime1").val();
	var keywords = $("#keywords").val();
	//var username = $("#username").val();
    //var username2 = $("#username2").val();
	var dotime2 = $("#dotime2").val();
	var type = $("#type").val();
	var subsite_id = $("#subsite_id").val();
	/*
	if (username!=null){
		 sou += "&username="+username;
	}
	if (username2!=null){
		 sou += "&username2="+username2;
	}
	*/
	if (keywords!=null){
		 sou += "&keywords="+keywords;
	}
	if (dotime1!=null){
		 sou += "&dotime1="+dotime1;
	}
	if (dotime2!=null){
		 sou += "&dotime2="+dotime2;
	}
	if (type!=null){
		 sou += "&type="+type;
	}
	if (subsite_id!=null){
		 sou += "&subsite_id="+subsite_id;
	}
	
	if (sou!=""){
	location.href=url+sou;
	}
}

</script>
{/literal}