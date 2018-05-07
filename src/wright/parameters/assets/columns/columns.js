jQuery(window).ready(function () {
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

	jQuery('div.col').each(function() {
		widths.push(jQuery(this).attr('id').substring(7)+':'+jQuery(this).children('select').attr('value'));
	});

	document.getElementById('jform[params][columns]').value = widths.join(';');
}

function checkColumns() {
	var widths = new Number(0);

	jQuery('select.columns').each(function(){
		widths += parseInt(jQuery(this).attr('value'));
	});

	if (widths !== 12)
	{
		jQuery('#column_info').css('display', 'inline-block');
	}
	else
	{
        jQuery('#column_info').css('display', 'none');
	}

	jQuery('div.col').each(function(){
		jQuery(this).removeClass('col-1');
		jQuery(this).removeClass('col-2');
		jQuery(this).removeClass('col-3');
		jQuery(this).removeClass('col-4');
		jQuery(this).removeClass('col-5');
		jQuery(this).removeClass('col-6');
		jQuery(this).removeClass('col-7');
		jQuery(this).removeClass('col-8');
		jQuery(this).removeClass('col-9');
		jQuery(this).removeClass('col-10');
		jQuery(this).removeClass('col-11');
		jQuery(this).removeClass('col-12');
		jQuery(this).addClass('col-' + jQuery(this).children('select').attr('value'));
	});
}

function swapColumns(col, dir) {
	var cols = jQuery('.columns.row > div.col');
	var index = 0;
	var selected = 'column_'+col;
	var selectedId = '.columns.row > #' + selected;
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

		colsSwapId = '.columns.row > #' + cols[swapindex].id;
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

		colsSwapId = '.columns.row > #' + cols[swapindex].id;
		jQuery(selectedId).after(jQuery(colsSwapId));
	}
	checkColumns();
	setColumnParam();
}
