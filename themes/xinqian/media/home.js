// JavaScript Document
//header  start
function nav(obj,childul,childBox){
	var box = $(obj);
	var oli = $("li",childul);
	var oDiv = $(childBox);
	function showTab(){
		oli.each(function(i){
			if($(oli[i]).hasClass("active"))
				{    						
					oDiv.addClass("hide");
					$(oDiv[i]).removeClass("hide");
				}
			})
		}
	showTab();
	oli.mouseenter(function(){
		var index = oli.index(this);
		$(oli[index]).addClass("hover2").siblings().removeClass("hover2");
		oDiv.addClass("hide");
		$(oDiv[index]).removeClass("hide");
	})
	box.mouseleave(function(){
		oli.removeClass("hover2");
		showTab()
		})
}
//header end

//borrow.html start
//借款步骤
function borr_stepbox()
{
	$(document).ready(function(){
		 var uli = $("li",'.borr_stepbox');
		 var udiv = $('.jkbdivbox');	 
		  uli.click(function(){
			  var index = uli.index(this);
			  $(uli[index]).addClass("checkit").siblings().removeClass("checkit");
			   udiv.addClass("hide");
			   $(udiv[index]).removeClass("hide");
		  })
	});
}
//表种介绍
function kind()
{
	$(document).ready(function(){
		 var uli = $("li",'.kind');
		 var udiv = $('.introduction');	 
		  uli.click(function(){
			  var index = uli.index(this);
			  $(uli[index]).addClass("checktt").siblings().removeClass("checktt");
			   udiv.addClass("hide");
			   $(udiv[index]).removeClass("hide");
		  })
	});
}
//borrow.html end

//index.html start
//介绍导航
function column(obj,childul,childBox){
	var box = $(obj);
	var oli = $("li",childul);
	var oDiv = $(childBox);
	function showTab(){
		oli.each(function(i){
			if($(oli[i]).hasClass("checkdd"))
				{    						
					oDiv.addClass("hide");
					$(oDiv[i]).removeClass("hide");
				}
			})
		}
	showTab();
	oli.mouseenter(function(){
		var index = oli.index(this);
		$(oli[index]).addClass("checkdd").siblings().removeClass("checkdd");
		oDiv.addClass("hide");
		$(oDiv[index]).removeClass("hide");
	})
	box.mouseleave(function(){
		oli.removeClass("checkdd");
		showTab()
		})
}

function biao_ti()
{
	$(document).ready(function(){
		 var uli = $("li",'.biao_ti');
		 var udiv = $('.dynamic');	 
		  uli.click(function(){
			  var index = uli.index(this);
			  $(uli[index]).addClass("checktt").siblings().removeClass("checktt");
			   udiv.addClass("hide");
			   $(udiv[index]).removeClass("hide");
		  })
	});
}

function jkhklist()
{
	$(document).ready(function(){
		 var uli = $("li",'.jkhklist');
		 var udiv = $('.jkhknr');	 
		  uli.click(function(){
			  var index = uli.index(this);
			  $(uli[index]).addClass("checkjh").siblings().removeClass("checkjh");
			   udiv.addClass("hide");
			   $(udiv[index]).removeClass("hide");
		  })
	});
}
//index.html end

//borrow_list.html start
function change_span_insurance(v)
{
	var v=document.getElementById('insurance').value;
	var m=document.getElementById('account').value;
	if(v!=0 && m!=0)
	{
		if(v==1)
		{
			f=m*16/100;	
		}
		else
		{
			f=m*31/100;
		}
		document.getElementById('span_insurance').innerHTML='应缴纳'+f+'元';
	}
}

function checkDXB(){
    var frm = document.forms['form1'];
    if(frm.elements['isDXB'].checked){
        frm.elements['pwd'].disabled=false;
    }else{
        frm.elements['pwd'].disabled=true;
        frm.elements['pwd'].value="";
    }
}

function check_form(){
   
	 var frm = document.forms['form1'];
	 var account = frm.elements['account'].value;
	 var title = frm.elements['name'].value;
	 var style = frm.elements['style'].value;
	 var content = frm.elements['content'].value;
	 var time_limit = frm.elements['time_limit'].value;
	 var award = get_award_value();
	 var part_account = frm.elements['part_account'].value;
	 var funds = frm.elements['funds'].value;
	 var apr = frm.elements['apr'].value;
	 var valicode = frm.elements['valicode'].value;
	 var most_account = frm.elements['most_account'].value;
	 var use = frm.elements['most_account'].value;
	 var lowest_account = frm.elements['lowest_account'].value;
	
	 var errorMsg = '';
	  if (account.length == 0 ) {
		errorMsg += '- 总金额不能为空' + '\n';
	  }
	  
	  
	  
	  if (apr.length == 0 ) {
		errorMsg += '- 利率不能为空' + '\n';
	  }
	  alert(apr);
	  if(apr < biaotype_min_interest_rate){
		  errorMsg += '利率低于最小利率' + biaotype_min_interest_rate + '%\n';
	  }	
	  
	  if(apr > biaotype_max_interest_rate){
		  errorMsg += '利率大于最小利率' + biaotype_max_interest_rate + '%\n';
	  }	
		
	  
	  if (award==1 && (part_account=="" || part_account<5 || part_account>account*0.02)) {
		errorMsg += '- 固定金额分摊奖励不能低于5元,不能高于总标的金额的2%' + '\n';
	  }
	  if (award==2 && (funds =="" || funds<0.1 || funds>6)) {
		errorMsg += '- 投标金额比例奖励0.1%~6% ' + '\n';
	  }
	  if (most_account!=0 && parseInt(most_account)<parseInt(lowest_account)){
		  errorMsg += '- 投标最大金额不能小于最小金额' + '\n';
	  }
	  if (title.length == 0 ) {
		errorMsg += '- 标题不能为空' + '\n';
	  }
	  if (content.length == 0 ) {
		errorMsg += '- 内容不能为空' + '\n';
	  }
	  if (valicode.length == 0 ) {
		errorMsg += '- 验证码不能为空' + '\n';
	  }

	
	var awa = "";
	for(var i=0;i<frm.award.length;i++){   
	   if(frm.award[i].checked){
		 awa =  frm.award[i].value;
		}
	} 


	if(awa==1){
		if (part_account==""){
			errorMsg += '- 固定分摊比例奖励不能为空 ' + '\n';
		}
	}
	if(awa==2){
		if (funds==""){
			errorMsg += '- 投标金额比例奖励不能为空 ' + '\n';
		}
	}
	
	  if (errorMsg.length > 0){
		alert(errorMsg); return false;
	  } else{  
		return true;
	  }

}
function get_award_value()
{
    var form1 = document.forms['form1'];
    
    for (i=0; i<form1.award.length; i++)    {
        if (form1.award[i].checked)
        {
           return form1.award[i].value;
        }
    }
}
function change_j(type){
	var frm = document.forms['form1'];
	if (type==0){
                jQuery("#part_account").attr("disabled",true); 
		jQuery("#funds").attr("disabled",true); 
                jQuery("#is_false").attr("disabled",true); 
                
                //frm.elements['part_account'].disabled = "disabled";
		//frm.elements['funds'].disabled = "disabled";
		//frm.elements['is_false'].disabled = "disabled";
	}else if (type==1){
                jQuery("#part_account").attr("disabled",false); 
		jQuery("#funds").attr("disabled",true); 
                jQuery("#is_false").attr("disabled",false); 
                
		//frm.elements['part_account'].disabled = "";
		//frm.elements['funds'].disabled = "disabled";
		//frm.elements['is_false'].disabled = "";
	}else if (type==2){
            
                jQuery("#part_account").attr("disabled",true); 
		jQuery("#funds").attr("disabled",false); 
                jQuery("#is_false").attr("disabled",false); 
                
		//frm.elements['part_account'].disabled = "disabled";
		//frm.elements['funds'].disabled = "";
		//frm.elements['is_false'].disabled = "";
	}
}

function setTab(name,cursel,n)
{ 
	for(i=1;i<=n;i++){ 
	var menu=document.getElementById(name+i); 
	var con=document.getElementById("con_"+name+"_"+i); 
	menu.className=i==cursel?"hot":""; 
	con.style.display=i==cursel?"block":"none"; 
	} 
}
function showEditor(content)
{
	//下面引用不行哦
	//document.write(' <script src="/plugins/editor/kindeditor/kindeditor-min.js"> <\/script>');
	//document.write(' <script src="/plugins/editor/kindeditor/lang/zh_CN.js"> <\/script>');	
	var editor;
	KindEditor.ready(function(K) {
		editor = K.create('textarea[name="'+content+'"]', {
			resizeType : 1,
			allowPreviewEmoticons : false,
			allowImageUpload : true,
			items : [
				'fontname', 'fontsize', '|', 'forecolor', 'hilitecolor', 'bold', 'italic', 'underline',
				'removeformat', '|', 'justifyleft', 'justifycenter', 'justifyright', 'insertorderedlist',
				'insertunorderedlist', '|', 'emoticons', 'image', 'link']
		});
	});	
}

//borrow_list.html end

//invest.html start


//invest.html end