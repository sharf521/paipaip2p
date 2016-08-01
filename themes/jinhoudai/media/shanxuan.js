


/*var str = ".html?biao_type=2232tendering&style=3&money=3";
var url = window.location.href;
var mainurl=url.replace(window.location.search,'');
alert(mainurl);

alert(window.location.search);
var newstr = str.replace(eval(/[\?|&]biao_type=(\w+)/ig),'');  
alert(newstr); */



$.fn.sx = function(can) {
    can = $.extend({
        nuv: ".zj",//筛选结果
		zi: "sx_child",//所有筛选范围内的子类
		qingchu:'.qcqb',//清除全部
		over:'on'//选中状态样式名称
    },
    can || {});
/*删选过程*/
    $(this).find('a').click(function() {
		var urlParam=window.location.search;
		var urlMain=window.location.href.replace(urlParam,'');
        var rel = $(this).attr('rel');
        var name = $(this).attr('name');
		if($(this).attr('class').replace(can.zi,'').replace(/ /g,'')=="on")
		{
			urlParam=urlParam.replace(name+'='+rel,'');
		}
		else
		{
			//  str.replace(eval(/(\?|&)biao_type=(\w+)/ig),''); //字符串要加转义
			urlParam=urlParam.replace(eval("/\(\\?\|\&\)"+name+"\=\(\\w+\)/ig"),'');
			if (urlParam.split('?').length < 2)
			{
				urlParam = "?" + name + "=" + rel + urlParam;			
			}
			else
			{
				urlParam = urlParam+"&" + name + "=" + rel;	
			}	
		}
		url=urlMain+urlParam;
		url=url.replace('&&','&');
		url=url.replace('?&','?');
		window.location.href=url;
    })

	window.onload = function() {
/*选中*/
        $("."+can.zi).each(function() {
            var url = window.location.href;
            var pddq = $(this).attr('name') + "=" + $(this).attr('rel');
            if (url.split(pddq).length > 1) 
			{
				
                $(this).addClass('on');
                $(can.nuv).find(can.qingchu).before("<a rel=" + $(this).attr('rel') + " name=" + $(this).attr('name') + " href='javascript:;'>" + $(this).siblings('span').text() + $(this).text() + "</a> ")
            } else {
                $(this).removeClass('on')
            }
        })
/*清除全部按钮是否显示*/	
/*var url = window.location.href;	
		if(url.split('=').length>1){
				$(can.qingchu).show();
				}else{
					$(can.qingchu).hide();
		}*/
/*点击清除*/
	$(can.nuv).find('a').click(function() {
    	var url = window.location.href;
        var pddq = $(this).attr('name') + "=" + $(this).attr('rel');
		
        if (url.split('&').length < 2) {
             url = url.replace('?' + pddq, '')
        } else {
             if (url.split(pddq)[0].split('&').length < 2) {
                 url = url.replace(pddq + '&', '')
              } else {
                   url = url.replace('&' + pddq, '')
                }
            }
            window.location.href = url;
        })
/*清除全部*/
	$(can.qingchu).click(function(){
		var url = window.location.href;
		url = url.split('?')[0];
		window.location.href = url;
		})
    }
}