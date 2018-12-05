var disableToolbarResize = false;

if (typeof jQuery != 'undefined' && typeof MooTools != 'undefined' ) { 
	// fix for Bootstrap Carousel - conflicting with mootools-more
	(function($) {
		    Element.implement({
		        slide: function(how, mode){
		            return this;
		        }
		    });
    	})(jQuery);
}

(function($) {
	function wToolbar() {
		if (typeof wrightWrapperToolbar === 'undefined')
			wrightWrapperToolbar = '.wrapper-toolbar';
			
		$(wrightWrapperToolbar).each(function() {
			$(this).css('min-height',$(this).find('.navbar:first').height() + 'px');
		});
	}
	
	function fixImagesIE() {
		$('img').each(function() {
			if ($(this).attr('width') != undefined)
				$(this).width($(this).attr('width'));
		});
	}

    // Mobile menu dropdown
    function mobileMenu() {
        if ($(window).width() < 980) {
             var wMenus = $('#menu, #toolbar, #bottom-menu');
             if($(wMenus).find('.dropdown-menu').length > 0) {
                 $(wMenus).find('.dropdown-menu').css('display', 'none');

                 $(wMenus).find('.dropdown-toggle .caret').click(function(e){
                     e.preventDefault();

                     // Toggle in action
                     $(this).parent().siblings().toggle({
                         complete: function () {

                             var wCurrentToggle = $(this).siblings('.dropdown-toggle').find('.caret');
                             
                             // Switch open/close icon
                             if ($(wCurrentToggle).hasClass('wPlus-icon')) {
                                 $(wCurrentToggle).removeClass('wPlus-icon').addClass('wMinus-icon');
                             } else {
                                 $(wCurrentToggle).removeClass('wMinus-icon').addClass('wPlus-icon');
                             }

                             // Resize container
                             wMenuContainer = $(this).closest('.nav-collapse');
                             $(wMenuContainer).css('height', $(wMenuContainer).find('> ul.nav').height());
                         }
                     });

                     e.stopImmediatePropagation();
                 });
             }
        }
    }

	wToolbar();
	fixImagesIE();

	$(window).load(function () {
        mobileMenu();
		if (!disableToolbarResize)
			wToolbar();
	});
	$(window).resize(function() {
        mobileMenu();
		if (!disableToolbarResize)
			wToolbar();
	});

	// Hover change images
	$('img.wrightHover').mouseenter(function() {
		if ($(this).data('wrighthover') != '') {
			$(this).attr('src', $(this).data('wrighthover'));
		}
	}).mouseleave(function() {
		if ($(this).data('wrighthover') != '') {
			$(this).attr('src', $(this).data('wrighthoverorig'));
		}
	});

	// Hover change images
	$('img.wrightHoverNewsflash').closest('div').parent().mouseenter(function() {
		var img = $(this).find('img.wrightHoverNewsflash');
		if (img) {
			if (img.data('wrighthover') != '') {
				img.attr('src', img.data('wrighthover'));
			}
		}
	}).mouseleave(function() {
		var img = $(this).find('img.wrightHoverNewsflash');
		if (img) {
			if (img.data('wrighthover') != '') {
				img.attr('src', img.data('wrighthoverorig'));
			}
		}
	});
})(jQuery);
