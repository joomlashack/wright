if (typeof jQuery != 'undefined' && typeof MooTools != 'undefined' ) { 
	(function($) { 
		$(document).ready(function(){
			$('.carousel').each(function(index, element) {
				$(this)[index].slide = null;
			});
		});
	})(jQuery);
	(function($) { 
		$$('[data-toggle=collapse]').each(function (e) {
			$$(e.get('data-target'))[0].hide = null;
		});
	})(MooTools);

}