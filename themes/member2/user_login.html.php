<?php
!defined('IN_TEMPLATE') && exit('Access Denied');
?>
{include file="user_header.html" }
<form name="login" method="post" action="" id="log_in">
<div id="main" class="clearfix">
	<div class="box_mt10">
        <div class="deng-zhu-banner">
            {loop module="scrollpic" function="GetList" areaid="$_G.areaid" var="var"  limit="1" type_id="2"}
	                <a href="{$var.url}"><img src="/{$var.pic}" class="loginimg"></a>
	        {/loop}
        </div>
		<div class="box-con-loginbg">
			<div class="reg-header">
                <h3>用户登录</h3>
                
            </div>
            <ul>
                 <li class="reg-l-input">
                      <label>用户名：</label>
                      <input type="text"  id="keywords" name="keywords" maxlength="64" style="color:#383838; position:relative;"/>
                      
                  </li>
                  <li class="reg-l-input">
                      <label>密码：</label>
                      <input  type="password"  name="password" id="password" maxlength="16" value=""/>
                      
                 </li>
                  <li  class="reg-l-input">
                     <label>验证码：</label>
                      <input name="valicode" type="text" size="6" maxlength="4"    style=";width:100px;"/><img src="/plugins/index.php?q=imgcode" alt="点击刷新" onClick="this.src='/plugins/index.php?q=imgcode&t=' + Math.random();" align="absmiddle" style="cursor:pointer;width:80px; height:40px; " />
                       
                 </li>
                 <li style="display:none">
					<div class="reg-l-title">动态口令：</div>
					<div class="reg-l-input"> <input type="text" name="uchoncode" id="uchoncode" maxlength="6" /></div>
					<div class="reg-l-tips">(可选)</div>
				</li>
				<li class="li-ji-anniu">
                     <input type="submit" value="立即登录" class="btn-action" />
                </li>
                <li  class="reg-l-input">
                <span class="s01">还没有账号</span>
                <a class="a01" href="/index.action?user&q=action/reg">免费注册</a>
                 <a tabindex="100" class="a02" href="/index.php?user&q=action/getpwd">忘记密码</a>
                </li>
            </ul>
            <!--
			<ul class="reg-table">
			    <li>
					<div class="reg-l-title">
                          用户名：
                    </div>
					<div >
				
					</div>
				</li>
				<li>
					<div class="reg-l-title">密码：</div>
					<div class="reg-l-input"><input type="password"  name="password" id="password" maxlength="16" value=""/>
                    </div>
					<div class="reg-l-tips">
                         
                    </div>
				</li>
				<li>
					<div class="reg-l-title">验证码：</div>-->
					
				</li>				
				
			</ul>
            
		</div>
    
	</div>
     
</div>
</form>



{include file="user_footer.html" }