<?php
!defined('IN_TEMPLATE') && exit('Access Denied');
?>
{include file="user_header.html"}
<link href="{$tempdir}/media/css/modal.css" rel="stylesheet" type="text/css" />
<div id="main" class="clearfix">

			<form action="" method="post" name="formUser" >
			<div class="user_action_reg_form">
				{if $_U.updatepwd_msg!=""}
                     <div class="mima_xiu_biaoti">
                     </div>
                     <div class="mima_xiu">
                             <div class="D01">��ϲ�� ��{$_U.updatepwd_msg}</div>
                             <div class="D02">�Ժ�ʹ���µ������¼�ʺţ����μǣ�</div>
                             <a class="A001">����Ҫ:</a>
                             <a class="A002"href="index.php?user&q=action/login" >���µ�¼</a>
                     </div>
					
                    
                </div>
				{else}
				<div class="alert alert-info" style=" background-color:#f5f5f5 ; border:0; color:#525252;"> <a class="close" data-dismiss="alert">x</a>{if $_U.update_msg==""}������������ĵ�¼����{else}{$_U.update_msg}{/if}</div> <br />
				<p class="YOMHHU">
				  <label for="email">�û�����</label>
				  <strong style="font-size:16px;">{$_U.user_result.username}</strong>
				</p>
				<br/>
				<p class="YOMHHU">
				  <label for="email">��&nbsp;&nbsp;&nbsp;&nbsp;�룺</label>
				  <input type="password" maxLength=15  class="user_aciton_input1" name=password id=password >
				</p>
				<br/>
				<p class="YOMHHU">
				  <label for="email">ȷ�����룺</label>
				  <input type="password"  maxLength=15  class="user_aciton_input1" name=confirm_password id=confirm_password  >
				</p>
				<br/>
				<p  align="left" class="YOMHHU">
				<span> <input type="submit" value="ȷ��" class="btn-action"  /> <input type="hidden" name="id" value="{$magic.request.id}" /></span>
				</p>	
				
				{/if}
			</div>
			</form>
		
</div>
<!--�û�ע�� ����-->
<script src="/themes/js/modal.js"></script>
<script src="/themes/js/tab.js"></script>
<script src="/themes/js/alert.js"></script>
<script src="/themes/js/transition.js"></script>

{include file="user_footer.html"}