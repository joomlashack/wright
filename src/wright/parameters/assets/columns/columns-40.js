jQuery(window).on('load', function () {
	checkColumns();
	jQuery('select.columns').change(function() {
		changeColumns();
	});
});

function changeColumns() {
	checkColumns();
	setColumnParam();
}

function setColumnParam() {
	var widths = new Array();
	var widthsString = '';

	jQuery('div.js-col').each(function() {
        widths.push(jQuery(this).attr('id').substring(7)+':'+jQuery(this).find('select').val());
	});

	document.getElementById('jform[params][columns]').value = widths.join(';');
}

function checkColumns() {
	var widths = new Number(0);

	jQuery('select.columns').each(function(){
		widths += parseInt(jQuery(this).val());
	});

	if (widths !== 12)
	{
		jQuery('#column_info').css('display', 'inline-block');
	}
	else
	{
        jQuery('#column_info').css('display', 'none');
	}

	jQuery('div.js-col').each(function(){
		jQuery(this).removeClass('col-md-1');
		jQuery(this).removeClass('col-md-2');
		jQuery(this).removeClass('col-md-3');
		jQuery(this).removeClass('col-md-4');
		jQuery(this).removeClass('col-md-5');
		jQuery(this).removeClass('col-md-6');
		jQuery(this).removeClass('col-md-7');
		jQuery(this).removeClass('col-md-8');
		jQuery(this).removeClass('col-md-9');
		jQuery(this).removeClass('col-md-10');
		jQuery(this).removeClass('col-md-11');
		jQuery(this).removeClass('col-md-12');
		jQuery(this).addClass('col-md-' + jQuery(this).find('select').val());
	});
}

function swapColumns(col, dir) {
	var cols = jQuery('.js-columns.row > div.js-col');
	var index = 0;
	var selected = 'column_'+col;
	var selectedId = '.js-columns.row > #' + selected;
	var colsSwapId = '';

	if (dir == 'right')
	{
		cols.each(function() {
			if (jQuery(this).attr('id') == selected)
			{
				swapindex = index + 1;
			}

			index++;
		});

		colsSwapId = '.js-columns.row > #' + cols[swapindex].id;
		jQuery(selectedId).before(jQuery(colsSwapId));
	}
	else
	{
		cols.each(function() {
			if (jQuery(this).attr('id') == selected)
			{
				swapindex = index - 1;
			}

			index++;
		});

		colsSwapId = '.js-columns.row > #' + cols[swapindex].id;
		jQuery(selectedId).after(jQuery(colsSwapId));
	}
	checkColumns();
	setColumnParam();
}
