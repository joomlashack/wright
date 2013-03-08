if (typeof jQuery != 'undefined' && typeof MooTools != 'undefined' ) { 
	(function($) { 
		    Element.implement({
		        slide: function(how, mode){
		            return this;
		        }
		    });
    	})(jQuery);
	(function($) { 
		$$('[data-toggle=collapse]').each(function (e) {
			$$(e.get('data-target'))[0].hide = null;
		});
	})(MooTools);
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
	
	wToolbar();
	fixImagesIE();

	$(window).load(function () {
		wToolbar();
	});
	$(window).resize(function() {
		wToolbar();
	});
})(jQuery);