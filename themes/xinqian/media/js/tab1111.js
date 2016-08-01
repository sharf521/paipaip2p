// function addLoadEvent(func) {
// var loadold = window.onload;
// if ( typeof window.onload != "function") {
// window.onload = func;
// } else {
// window.onload = function() {
// loadold();
// func();
// }
// };
// }
//
// function nav() {
// var onav = document.getElementById("nav");
// var onav_con = document.getElementById("nav_con");
// var osub_box = document.getElementById("sub_box");
// var oli = onav.getElementsByTagName("li");
// var op = osub_box.getElementsByTagName("p");
// for (var i = 0; i < oli.length; i++) {
// oli[i].index = i;
// if (op[i]) {
// op[i].style.marginLeft = oli[i].offsetLeft + 50 + 'px';
// };
// oli[i].onmouseover = function() {
// for (var n = 0; n < oli.length; n++) {
// oli[n].className = "";
// };
// for (var m = 0; m < op.length; m++) {
// op[m].style.display = "none";
// };
// this.className = "active";
// if (op[this.index]) {
// op[this.index].style.display = "block";
// if(op[this.index].offsetwidth > 920-oli[this.index].offsetLeft-115+81){
// op[this.index].style.right ="0px";
// op[this.index].style.marginLeft ="0px";
// op[this.index].style.marginRight = (920-oli[this.index].offsetLeft)-115+50+"px";
// }
// };
// }
// };
// }
//
// addLoadEvent(nav());

//同类名

function addLoadEvent(func) {
	var loadold = window.onload;
	if ( typeof window.onload != "function") {

		try {
			window.onload = func;
		} catch(err) {

		}
	} else {
		window.onload = function() {
			loadold();
			func();
		}
	};
}

function nav() {
	var onav = document.getElementById("nav");
	var onav_con = document.getElementById("nav_con");
	var osub_box = document.getElementById("sub_box");
	var oli = onav.getElementsByTagName("li");
	var op = osub_box.getElementsByTagName("p");
	var init_onav_obj;
	
//获取页面开始加载时 栏目为 active 的对象
		for ( i = 0; i < oli.length; i++) {
		   if(oli[i].className.indexOf('active')!=-1){
		   init_onav_obj=oli[i];
		   }
		}
//----------------------------------------------------------	

//当鼠标 移除 栏目div层时，恢复开始页面 栏目 active
	onav_con.onmouseout=function(event){
	e=event;
	e?e:e=window.event
	var rect=this.getBoundingClientRect();
//	console.dir(e.srcElement)
//	console.dir(e.clientX + "  " + e.clientY)
//	console.dir(e.x + "   " + rect.left+ "  " + e.y + "  " + rect.right)
//	console.debug(e.x + "   " + rect.left+ "  " + e.y + "  " + rect.right)
	if (e.clientX<=rect.left || e.clientX>=rect.right || e.clientY<=rect.top || e.clientY>=rect.bottom){
	}else{return;}
	
	 for (var j = 0; j < oli.length; j++) {
			oli[j].className = "";
			};
			for (var t = 0; t < op.length; t++) {
				op[t].style.display = "none";
			};
			init_onav_obj.className="active";
			op[init_onav_obj.index].style.display = "block";
	}
//----------------------------------------------------------
	for ( i = 0; i < oli.length; i++) {
		oli[i].onmouseover = function() {
			for (var j = 0; j < oli.length; j++) {
				oli[j].className = "";
			};
			for (var t = 0; t < op.length; t++) {
				op[t].style.display = "none";
			};
			this.className = "active";
					
		}
		for ( l = 0; l < op.length; l++) {
			if (oli[i].className.indexOf(op[l].className) >= 0) {
				oli[i].index = l;
				op[l].style.marginLeft = oli[i].offsetLeft + 50 + 'px';

				if (op[l].offsetwidth > 920 - oli[i].offsetLeft - 115 + 81) {
//					op[l].style.right = "0px";
					op[l].style.marginLeft = "0px";
//					op[l].style.marginRight = (920 - oli[i].offsetLeft) - 130 + 50 + "px";
				}
				oli[i].onmouseover = function() {
					for (var n = 0; n < oli.length; n++) {
						oli[n].className = "";
					};
					for (var m = 0; m < op.length; m++) {
						op[m].style.display = "none";
					};
					this.className = "active";
					op[this.index].style.display = "block";
					if (op[this.index].offsetwidth > 920 - this.offsetLeft - 115 + 81) {
//						op[this.index].style.right = "0px";
						op[this.index].style.marginLeft = "0px";
//						op[this.index].style.marginRight = (920 - this.offsetLeft) - 130 + 50 + "px";
					}
				}
			};
		}
	};
}
addLoadEvent(nav());

