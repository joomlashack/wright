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
        if (window.outerWidth < 980) {
             $wMenus = $('#menu, #toolbar, #bottom-menu');
             if($($wMenus).find('.dropdown-menu').length > 0) {

                 $($wMenus).find('.dropdown-toggle .caret').on('click', function(e){
                     e.preventDefault();

                     $wToggleIcon       = $(this);
                     $wDropdown         = $(this).parent().siblings('.dropdown-menu');
                     $wMenuContainer    = $(this).closest('.nav-collapse');

                     // Switch icon
                     if ($($wToggleIcon).is('.wMinus-icon')) {
                         $($wToggleIcon).removeClass('wMinus-icon');
                     }else{
                         $($wToggleIcon).addClass('wMinus-icon');
                     }

                     // Show/hide submenu
                     if ($($wDropdown).is('.wDropdown-open')) {
                         $($wDropdown).removeClass('wDropdown-open');
                     }else{
                         $($wDropdown).addClass('wDropdown-open');
                     }

                     // Resize container
                     $wTotalHeight = 0;
                     $($wMenuContainer).children().each(function(){
                         $wTotalHeight = $wTotalHeight + $(this).outerHeight(true);
                     });

                     $($wMenuContainer).css('height', $wTotalHeight);

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

    // Copied from protostar template - Set Bootstrap design style to radio buttons
    'use strict';

    var $w = $(window);

    $(document.body)
        .on('click', '.btn-group label:not(.active)', function() {
            var $label = $(this);
            var $input = $('#' + $label.attr('for'));

            if ($input.prop('checked')) {
                return;
            }

            $label.closest('.btn-group').find('label').removeClass('active btn-success btn-danger btn-primary');

            var btnClass = 'primary';

            if ($input.val() != '') {
                var reversed = $label.closest('.btn-group').hasClass('btn-group-reversed');
                btnClass = ($input.val() == 0 ? !reversed : reversed) ? 'danger' : 'success';
            }

            $label.addClass('active btn-' + btnClass);
            $input.prop('checked', true).trigger('change');
        })
        .on('subform-row-add', initRadioButtons);

    var initRadioButtons = function(event, container) {
        var $container = $(container || document);

        // Turn radios into btn-group
        $container.find('.radio.btn-group label').addClass('btn');

        // Handle disabled, prevent clicks on the container, and add disabled style to each button
        $container.find('fieldset.btn-group:disabled').each(function() {
            $(this).css('pointer-events', 'none').off('click').find('.btn').addClass('disabled');
        });

        // Setup coloring for buttons
        $container.find('.btn-group input:checked').each(function() {
            var $input = $(this);
            var $label = $('label[for=' + $input.attr('id') + ']');
            var btnClass = 'primary';

            if ($input.val() !== '') {
                var reversed = $input.parent().hasClass('btn-group-reversed');
                btnClass = ($input.val() == 0 ? !reversed : reversed) ? 'danger' : 'success';
            }

            $label.addClass('active btn-' + btnClass);
        });
    };

    initRadioButtons();
})(jQuery);