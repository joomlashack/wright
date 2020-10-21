jQuery(window).load(function () {
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
		jQuery(this).removeClass('span1');
		jQuery(this).removeClass('span2');
		jQuery(this).removeClass('span3');
		jQuery(this).removeClass('span4');
		jQuery(this).removeClass('span5');
		jQuery(this).removeClass('span6');
		jQuery(this).removeClass('span7');
		jQuery(this).removeClass('span8');
		jQuery(this).removeClass('span9');
		jQuery(this).removeClass('span10');
		jQuery(this).removeClass('span11');
		jQuery(this).removeClass('span12');
		jQuery(this).addClass('span' + jQuery(this).children('select').attr('value'));
	});
}

function swapColumns(col, dir) {
	var cols = jQuery('.columns.row-fluid > div.col');
	var index = 0;
	var selected = 'column_'+col;
	var selectedId = '.columns.row-fluid > #' + selected;
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

		colsSwapId = '.columns.row-fluid > #' + cols[swapindex].id;
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

		colsSwapId = '.columns.row-fluid > #' + cols[swapindex].id;
		jQuery(selectedId).after(jQuery(colsSwapId));
	}
	checkColumns();
	setColumnParam();
}
