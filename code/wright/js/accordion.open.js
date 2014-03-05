//
// Verschachteltes Mootools-Accordion
// Nested Mootools Accordion
// 
// von / by Bogdan Günther
// http://www.medianotions.de
//


function addAccordion(togglers) {
	var content = new Array();
	var togglersf = new Array();

	var i = 0;
	togglers.forEach(function(toggler, idx) {
		if (toggler != undefined) {
			var href = toggler.get('href');
			toggler.removeProperty('href');
			toggler.addClass('nolink');
			toggler.set('html',toggler.get('html') + ('<span class="newlink">»</span>'));
			
			toggler.getParent().getChildren('ul').forEach(function(testcontent) {
				try {
					// Mootools 1.2 and above mode
					if (testcontent.get('tag') == 'ul') {
						togglersf[i] = toggler;
						content[i] = testcontent;						
					}
				}
				catch (e) {
					// Mootools 1.12 mode
					if (testcontent.getTag() == 'ul')
						togglersf[i] = toggler;
						content[i] = testcontent;
				}
			});
			
			var childrenTogglers = new Array();
	
			var j = 0;
			var lis = content[i].getChildren('li.parent');
			if (lis.getLast() != null) {
				lis.each(function (li) {
					if (li.hasClass('parent')) {
						var t = li.getChildren('a');
						if (!t.length)
							t = li.getChildren('span');
						if (t.length) {
							childrenTogglers[j] = t[0];
							j++;
						}
					}
				})
			}
			
			if (childrenTogglers.length) {
				addAccordion(childrenTogglers);
			}
			
			if (wrightAccordionHover)
				toggler.addEvent('mouseenter', function() { this.fireEvent('click'); });
			
			i++;
		}
	});
	
	new Fx.Accordion(togglersf, content, {
		opacity: false,
		display: -1,
		onActive: function (t, e) {
			t.addClass('open');
		},
		onBackground: function (t, e) {
			t.removeClass('open');
		}
	});
}

window.addEvent('domready', function() {
	
	// Anpassung IE6
	if(window.ie6) var heightValue='100%';
	else var heightValue='';
	
	try {
		i = 0;
		var togglers = new Array();
		$$('#sidebar1 ul.menu').getChildren('li.parent')[0].forEach(function (li) {
			if (li.hasClass('parent')) {
				var t = li.getChildren('a');
				if (!t.length)
					t = li.getChildren('span');
				togglers[i] = t[0];
				i++;
			}
		});

		addAccordion(togglers);

		$$('#sidebar1 ul.menu li.parent.active > a').each(function (p) {
			p.fireEvent('click');
		});
	
		$$('#sidebar1 ul.menu li.parent.active > span').each(function (p) {
			p.fireEvent('click');
		});
	}
	catch (e) {
		
	}

	try {
		i = 0;
		var togglers = new Array();
		$$('#sidebar2 ul.menu').getChildren('li.parent')[0].forEach(function (li) {
			if (li.hasClass('parent')) {
				var t = li.getChildren('a');
				if (!t.length)
					t = li.getChildren('span');
				togglers[i] = t[0];
				i++;
			}
		});

		addAccordion(togglers);

		$$('#sidebar2 ul.menu li.parent.active > a').each(function (p) {
			p.fireEvent('click');
		});
	
		$$('#sidebar2 ul.menu li.parent.active > span').each(function (p) {
			p.fireEvent('click');
		});
	}
	catch (e) {
		
	}
});
