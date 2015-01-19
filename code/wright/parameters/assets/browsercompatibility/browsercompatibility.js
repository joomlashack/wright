jQuery( document ).ready(function( $ ) {
	function processWrightBrowserCompatTable() {
		var obj = {};
		jQuery('input.wbminv').each(function () {
			var browserName = jQuery(this).data('browser');
			var browserId = jQuery(this).data('browserid');
			var minVersion = parseFloat(jQuery(this).val());
			var desktop = false; if (jQuery('input#wbdesktop_' + browserId).is(':checked')) desktop = true;
			var mobile = false; if (jQuery('input#wbmobile_' + browserId).is(':checked')) mobile = true;
			var recommended = false; if (jQuery('input#wbrecommended_' + browserId).is(':checked')) recommended = true;

			if (minVersion > 0 || desktop || mobile || recommended)
			{
				var browserObj = {
					minimumVersion: minVersion,
					recommended: recommended,
					desktop: desktop,
					mobile: mobile
				};
				obj[browserName] = browserObj;
			}
		});
		jQuery('#wb_compatibility').val(JSON.stringify(obj));
	}

	jQuery('input.wbminv').change(function () {
		processWrightBrowserCompatTable();
	});

	jQuery('input.wbdesktop').change(function () {
		processWrightBrowserCompatTable();
	});

	jQuery('input.wbmobile').change(function () {
		processWrightBrowserCompatTable();
	});

	jQuery('input.wbrecommended').change(function () {
		processWrightBrowserCompatTable();
	});
});