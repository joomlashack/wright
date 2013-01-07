jQuery(document).ready(function() {
	function stickyFooter() {
		if (jQuery('#footer')) {
			var h = jQuery('#footer').height();
			jQuery('.wrapper-footer').height(h);
		}
	}
	jQuery(window).load(function () {
		stickyFooter();
	});
	stickyFooter();
	jQuery(window).resize(function() {
		stickyFooter();
	});
});