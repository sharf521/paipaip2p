// JavaScript Document

$(function(){
	var $this = $(".leftslide");
	var Timer;
	$this.hover(function(){
		clearInterval(Timer);					 
	},function(){
		Timer = setInterval(function(){
			scrolly($this);						
		},3000)	
	}).trigger("mouseleave")

	function scrolly(obj){
		var self = obj.find("ul:first");
		var heights = self.find("li:first").width();
		var widths = (self.find("li:first").width())*(self.find("li").length);
		var styles = {
			"marginLeft":"0",
			"width":widths+"px"
			}
		self.animate({"marginLeft":-heights+"px"},600,function(){
			self.css(styles).find("li:first").appendTo(self);
			})
		}
	
});	