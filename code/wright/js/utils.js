window.addEvent('domready', function() {
	$$('.btn-group .dropdown-toggle').each(function(i) {
		i.addEvent('click', function() {
			if (i.getParent().getChildren('.dropdown-menu').getStyle('display') == 'block')
				i.getParent().getChildren('.dropdown-menu').setStyle('display','none');
			else
				i.getParent().getChildren('.dropdown-menu').setStyle('display','block');
		})
	});
});