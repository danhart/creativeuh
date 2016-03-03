$(function() {
	// Initalise Core
	core.init();					
});

var core = {

	init: function() {
		
		core.navMenu();
		
		core.siteSearch();
		
		core.studyOptions();
		
		core.slideShow();
		
		core.articleBoxFade();
				
	},
	
	navMenu: function() {
	
		/*
		$('#nav > ul > li').hover(
			function() {
				$(this).children('a').addClass('hovered');
				$(this).children('ul').show();
			},
			function() {
				$(this).children('a').removeClass('hovered');
				$(this).children('ul').hide();
			}
		); */
		
		$("#nav > ul > li").mouseenter(function(){
			$(this).children('a').addClass('hovered');
			$(this).children('ul').show();
		}).mouseleave(function(){
			$(this).children('a').removeClass('hovered');
			$(this).children('ul').hide();
		});

	},
	
	siteSearch: function() {
		$('#searchtext').focus(function() {
			$('#site_search').animate({
				width: '200px'
			}, 500, function() {
				// Animation complete.
			});
		});
		
		$('#searchtext').blur(function() {
			$('#site_search').animate({
				width: '110px'
			}, 500, function() {
				// Animation complete.
			});
		});
	},
	
	studyOptions: function() {
		var originalHeight = '230px';
		$('.study_option').css('height', 27);
		
		$('.study_option h4, .study_option img').click(function() {
			if ($(this).parent().css('height') == originalHeight) {
				var newHeight = 27;
				$(this).parent().find('.study_triangle_open').fadeOut();
				$(this).parent().find('.study_triangle_closed').fadeIn();
			} else {
				var newHeight = originalHeight;
				$(this).parent().find('.study_triangle_open').fadeIn();
				$(this).parent().find('.study_triangle_closed').fadeOut();
			}
			
			$(this).parent().stop().animate({
				height: newHeight
			}, 300, function() {
				// Animation complete.
			});
		});
	},
	
	slideShow: function() {
		if ($('#slideshow').length) {
			// Set the first slide as active
			$('#slideshow li').first().css('opacity', 1).addClass('active').siblings().css('opacity', 0);
			
			// Set the header background color to the first slide's color
			$('header#header').css('background-color', $('#slideshow li').first().find('img').attr('alt'));
			
			var firstSlide = $('#slideshow li').first().find('img');
			
			// Fix for IE <= 9 (yup none work properly!)
			firstSlide.one("load",function(){
				$('#slideshow').css('height', $(this).height());
			}).each(function(){
				if(this.complete || (jQuery.browser.msie && parseInt(jQuery.browser.version) == 6)) $(this).trigger("load");
			});
			
			// Start the slideshow
			if ($('#slideshow li').length > 1) {
				setInterval( "core.slideSwitch()", 7000 );
			}
		}
	},
	
	slideSwitch: function() {
		var active = $('#slideshow li.active');
		
		var next = (active.next().length) ? active.next() : $('#slideshow li').first();
		var nextBgColor = next.find('img').attr('alt');
		
		next.addClass('active').siblings().removeClass('active');
		
		active.animate({
			opacity: 0
		}, 1500);
		
		$('header#header').animate({
			'background-color': nextBgColor
		}, 1500);
		
		next.animate({
			opacity: 1
		}, 1500);
	},
	
	articleBoxFade: function() {
		$('.article_box').hover(function() {
			$(this).siblings('article').stop().fadeTo('normal', 0.6);
		},function() {
			$(this).siblings('article').stop().fadeTo('normal', 1);
		});
		
	}

};
