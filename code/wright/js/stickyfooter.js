jQuery(document).ready(function() {
	function wrightStickyFooter() {
		if (jQuery('#footer')) {
			var h = jQuery('#footer').height();
			jQuery('.wrapper-footer').height(h);
		}
	}
	jQuery(window).load(function () {
		jQuery('#footer.sticky').css('bottom','0')
			.css('position','absolute')
			.css('z-index','1000');
		wrightStickyFooter();
	});
	wrightStickyFooter();
	jQuery(window).resize(function() {
		wrightStickyFooter();
	});
});
