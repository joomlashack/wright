jQuery(document).ready(function() {
	function stickyFooter() {
		if (jQuery('#footer')) {
			var h = jQuery('#footer').height();
			jQuery('.wrapper-footer').height(h);
		}
	}
	stickyFooter();
	jQuery(window).resize(function() {
		stickyFooter();
	});
});