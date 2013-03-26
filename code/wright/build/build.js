var v = process.versions;
if (v.node < '0.10.0') {
	console.log('Builder requieres at least Node.JS 0.10.0')
	return;
}

var fs = require('fs');
var os = require('os');
var recess = require('recess');
var ncp = require('ncp');
var UglifyJS = require("uglify-js");

ncp.limit = 16;

var exec = require('child_process').exec;
var isWin = !!os.platform().match(/^win/);  // detects platform to set the right folder separator
var DS = '/';
if (isWin) DS = '\\';

var cacheDir = '.cache';

function cleanCache() {
	// Recreates Cache folder
	if (fs.existsSync(cacheDir)) {
		var list = fs.readdirSync(cacheDir);
		if (list)
			list.forEach(function (f) {
				fs.unlinkSync(cacheDir + '/' + f);;
			});
	}
	else
		fs.mkdirSync(cacheDir);
}

// Removes old generated CSS files
var cssRegEx = /joomla([0-9]+)-([a-z0-9]+)(.*).css/i;
var list = fs.readdirSync('../../css/');
if (list)
	list.forEach(function (f) {
		if (cssRegEx.test(f)) {
			fs.unlinkSync('../../css/'+f);
		}
	})

cleanCache();

// Iterate LESS styles
var joomlalessRegEx = /joomla([0-9]+).less/i;
var stylelessRegEx = /variables-([a-z0-9]+).less/i;
fs.readdir('less', function (err, list) {
	if (list)
		list.forEach(function (f) {
			if (joomlalessRegEx.test(f)) {
				// specific Joomla version file
				var jv = f.match(joomlalessRegEx);  // Joomla version from joomlaxx.less file
				jv = jv[1];

				// Iterate styles
				fs.readdir('../../less', function(err, list) {
					if (list)
						list.forEach(function (f2) {
							if (stylelessRegEx.test(f2)) {
								var st = f2.match(stylelessRegEx);  // Style from variables-xx.less file
								st = st[1];

								// Create compiled less file for Joomla / Style
								var df = cacheDir + '/style-joomla' + jv + '-' + st + '.less';
								var dfcss = 'joomla' + jv + '-' + st + '.css';
								var s = '';

								s += '@import "../../../less/variables-' + st + '.less"; ';  
								s += '@import "../less/bootstrap.less"; ';  
								s += '@import "../less/typography.less"; ';  
								s += '@import "../less/joomla' + jv + '.less"; ';
								if (fs.existsSync('../../less/template.less'))  // Template file (if exists)
									s += '@import "../../../less/template.less"; ';
								if (fs.existsSync('../../less/style-' + st + '.less'))  // Style file (if exists)
									s += '@import "../../../less/style-' + st + '.less"; ';
								fs.writeFileSync(df, s);

								recess(df,{compile: true, compress: true}, function (err, obj) {
									if (err) {
										console.log('Error compiling ' + dfcss + ': ' + err);
									}
									else if (obj.errors.length > 0) {
										console.log('Error compiling ' + dfcss + ': ' + obj.errors);
									}
									else {
										console.log('Compiled file ' + dfcss);
										fs.writeFileSync('../../css/' + dfcss, obj.output);
									}
								});

								// Create responsive files
								var dfr = cacheDir + '/style-joomla' + jv + '-' + st + '-responsive.less';
								var dfcssr = 'joomla' + jv + '-' + st + '-responsive.css';
								var s = '';
								s += '@import "../../../less/variables-' + st + '.less"; ';  // Global style variables
								s += '@import "../less/responsive.less"; ';  // Bootstrap responsive less file
								s += '@import "../less/joomla' + jv + '-responsive.less"; ';  // Joomla version responsive file
								if (fs.existsSync('../../less/template-responsive.less'))  // Template responsive file (if exists)
									s += '@import "../../../less/template-responsive.less"; ';
								if (fs.existsSync('../../less/style-' + st + '-responsive.less'))  // Style responsive file (if exists)
									s += '@import "../../../less/style-' + st + '-responsive.less"; ';
								fs.writeFileSync(dfr, s);

								recess(dfr,{compile: true, compress: true}, function (err, obj) {
									if (err) {
										console.log('Error compiling ' + dfcssr + ': ' + err);
									}
									else if (obj.errors.length > 0) {
										console.log('Error compiling ' + dfcssr + ': ' + obj.errors);
									}
									else {
										console.log('Compiled file ' + dfcssr);
										fs.writeFileSync('../../css/' + dfcssr, obj.output);
									}
								});
							}
						})
				})

			}
		})
});

// Bootstrap Images
fs.readdir('libraries/bootstrap/img', function (err, list) {
	if (list)
		list.forEach(function (f) {
			ncp('libraries/bootstrap/img/' + f,'../images/' + f, function(err) {
				if (err) {
					console.log('Error copying images: ' + err);
				}
			});
		});
});

// JS Libraries
if (fs.existsSync('../js/bootstrap.min.js')) {
	fs.unlinkSync('../js/bootstrap.min.js');
}

var jslibs = new Array();
jslibs.push('libraries/bootstrap/js/bootstrap-transition.js');
jslibs.push('libraries/bootstrap/js/bootstrap-alert.js');
jslibs.push('libraries/bootstrap/js/bootstrap-button.js');
jslibs.push('libraries/bootstrap/js/bootstrap-carousel.js');
jslibs.push('libraries/bootstrap/js/bootstrap-collapse.js');
jslibs.push('libraries/bootstrap/js/bootstrap-dropdown.js');
jslibs.push('libraries/bootstrap/js/bootstrap-modal.js');
jslibs.push('libraries/bootstrap/js/bootstrap-tooltip.js');
jslibs.push('libraries/bootstrap/js/bootstrap-popover.js');
jslibs.push('libraries/bootstrap/js/bootstrap-scrollspy.js');
jslibs.push('libraries/bootstrap/js/bootstrap-tab.js');
jslibs.push('libraries/bootstrap/js/bootstrap-typeahead.js');
jslibs.push('libraries/bootstrap/js/bootstrap-affix.js');

var jss = '';
jslibs.forEach(function (f) {
	jss += fs.readFileSync(f,{encoding: 'utf8'});
})
var jssug = '/*!\n* Bootstrap.js by @fat & @mdo\n* Copyright 2012 Twitter, Inc.\n* http://www.apache.org/licenses/LICENSE-2.0.txt\n* Adapted for Wright v.3 Framework, from Joomlashack\n*/\n';
jssug += UglifyJS(jss, {show_copyright: 'true'});
fs.writeFileSync('../js/bootstrap.min.js',jssug,{flag: 'a+'});