/*
 * DC Vertical Mega Menu - jQuery vertical mega menu
 * Copyright (c) 2011 Design Chemical
 *
 * Dual licensed under the MIT and GPL licenses:
 * 	http://www.opensource.org/licenses/mit-license.php
 * 	http://www.gnu.org/licenses/gpl.html
 *
 */
(function($){

	//define the new for the plugin ans how to call it	
	$.fn.dcVerticalMegaMenu = function(options){
		//set default options  
		var defaults = {
			classParent: 'dc-mega',
			arrow: true,
			classArrow: 'dc-mega-icon',
			classContainer: 'sub-container',
			classSubMenu: 'sub',
			classMega: 'mega',
			classSubParent: 'mega-hdr',
			classSublink: 'mega-hdr',
			classRow: 'row',
			rowItems: 3,
			speed: 'fast',
			effect: 'show',
			direction: 'right'
		};

		//call in the default otions
		var options = $.extend(defaults, options);
		var $dcVerticalMegaMenuObj = this;

		//act upon the element that is passed into the design    
		return $dcVerticalMegaMenuObj.each(function(options){

			$mega = $(this);
			if(defaults.direction == 'left'){
				$mega.addClass('left');
			} else {
				$mega.addClass('right');
			}
			// Get Menu width
			var megawidth = $mega.width();
			
			// Set up menu
			$('> li',$mega).each(function(){
				
				var $parent = $(this);
				var $megaSub = $('> ul',$parent);
	
				if($megaSub.length > 0){
					
				$('> a',$parent).addClass(defaults.classParent).append('<span class="'+defaults.classArrow+'"></span>');
					$megaSub.addClass(defaults.classSubMenu).wrap('<div class="'+defaults.classContainer+'" />');
					var $container = $('.'+defaults.classContainer,$parent);
					
					if($('ul',$megaSub).length > 0){
						
						$parent.addClass(defaults.classParent+'-li');
						$container.addClass(defaults.classMega);
						
						// Set sub headers
						$('> li',$megaSub).each(function(){
							$(this).addClass('mega-unit');
							if($('> ul',this).length){
								$(this).addClass(defaults.classSubParent);
								$('> a',this).addClass(defaults.classSubParent+'-a');
							} else {
								$(this).addClass(defaults.classSublink);
								$('> a',this).addClass(defaults.classSublink+'-a');
							}
						});
						
						// Create Rows
						var hdrs = $('.mega-unit',$parent);
						rowSize = parseInt(defaults.rowItems);
						for(var i = 0; i < hdrs.length; i+=rowSize){
							hdrs.slice(i, i+rowSize).wrapAll('<div class="'+defaults.classRow+'" />');
						}

						// Get mega dimensions
						var itemwidth = $('.mega-unit',$megaSub).outerwidth(true);
						var rowItems = $('.row:eq(0) .mega-unit',$megaSub).length;
						var innerItemwidth = itemwidth * rowItems;
						var totalitemwidth = innerItemwidth + containerPad;

						// Set mega header height
						$('.row',this).each(function(){
							$('.mega-unit:last',this).addClass('last');
							var maxValue = undefined;
							$('.mega-unit > a',this).each(function(){
								var val = parseInt($(this).height());
								if (maxValue === undefined || maxValue < val){
									maxValue = val;
								}
							});
							$('.mega-unit > a',this).css('height',maxValue+'px');
							$(this).css('width',innerItemwidth+'px');
						});
						var subwidth = $megaSub.outerwidth(true);
						var totalwidth = $container.outerwidth(true);
						var containerPad = totalwidth - subwidth;
						// Calculate Row height
						$('.row',$megaSub).each(function(){
							var rowheight = $(this).height();
							$(this).parent('.row').css('height',rowheight+'px');
						});
						$('.row:last',$megaSub).addClass('last');
						$('.row:first',$megaSub).addClass('first');
					} else {
						$container.addClass('non-'+defaults.classMega);
					}
				} 
			
				var $container = $('.'+defaults.classContainer,$parent);
				// Get flyout height
				var subheight = $container.height();
				var itemheight = $parent.outerheight(true);
				// Set position to top of parent
				$container.css({
					height: subheight+'px',
					marginTop: -itemheight+'px',
					zIndex: '1000',
					width: subwidth+'px'
				}).hide();
			});

			// HoverIntent Configuration
			var config = {
				sensitivity: 2, // number = sensitivity threshold (must be 1 or higher)
				interval: 100, // number = milliseconds for onMouseOver polling interval
				over: megaOver, // function = onMouseOver callback (REQUIRED)
				timeout: 0, // number = milliseconds delay before onMouseOut
				out: megaOut // function = onMouseOut callback (REQUIRED)
			};
			
			$('li',$dcVerticalMegaMenuObj).hoverIntent(config);
				
			function megaOver(){
				$(this).addClass('mega-hover');
				var $link = $('> a',this);
				var $subNav = $('.sub',this);
				var $container = $('.sub-container',this);
				var width = $container.width();
				var outerheight = $container.outerheight(true);
				var height = $container.height();
				var itemheight = $(this).outerheight(true);
				var offset = $link.offset();
				var scrollTop = $(window).scrollTop();
				offset = offset.top - scrollTop
				var bodyheight = $(window).height();
				var maxheight = bodyheight - offset;
				var xsheight = maxheight - outerheight - itemheight;

				if(xsheight < 0){
					var containermargin = xsheight - itemheight;
					$container.css({marginTop: containermargin+'px'});
				}
				
				var containerposition = {right: megawidth};
				if(defaults.direction == 'right'){
					containerposition = {left: megawidth};
				}
				
				if(defaults.effect == 'fade'){
					$container.css(containerposition).fadeIn(defaults.speed);
				}
				if(defaults.effect == 'show'){
					$container.css(containerposition).show();
				}
				if(defaults.effect == 'slide'){
					$container.css({
						width: 0,
						height: 0,
						opacity: 0});
					
					if(defaults.direction == 'right'){
				
						$container.show().css({
							left: megawidth
						});
					} else {
					
						$container.show().css({
							right: megawidth
						});
					}
					$container.animate({
							width: width,
							height: height,
							opacity: 1
						}, defaults.speed);
				}
			}
			
			function megaOut(){
				$(this).removeClass('mega-hover');
				var $container = $('.sub-container',this);
				$container.hide();
			}
		});
	};
})(jQuery);