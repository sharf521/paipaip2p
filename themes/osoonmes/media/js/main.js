$(function() {
	var currentDisplay;
	var curIndex;
	var bigNavli = $("#big_nav li");
	bigNavli.each(function(i, element) {
		if ($(bigNavli[i]).hasClass("current")) {
			curIndex = i;
			currentDisplay = bigNavli[i];
		}
		bigNavli[i].onmouseover = function() {
			$(this).addClass("current");
			$("#big_nav table").hide();
			$(this).find("table").show();
		}

		bigNavli[i].onmouseout = function() {
			$(this).removeClass("current");
			if (typeof currentDisplay == "undefined")
				return;
			currentDisplay.className = "current";
			$("#big_nav table").hide();
			$(currentDisplay).find("table").show();
		}
	});
});