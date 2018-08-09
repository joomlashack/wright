jQuery(document).ready(function() {
	function stickyFooter() {
		if (jQuery('#footer')) {
			var h = jQuery('#footer').height();
			jQuery('.wrapper-footer').height(h);
            jQuery('body').css({'margin-bottom':h});
		}
	}
	jQuery(window).on('load', function () {
		jQuery('.wrapper-footer.sticky').css('bottom','0')
			.css('position','absolute')
			.css('z-index','100');
		stickyFooter();
	});
	stickyFooter();
	jQuery(window).resize(function() {
		stickyFooter();
	});
});
