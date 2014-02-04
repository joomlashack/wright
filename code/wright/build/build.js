var v = process.versions;
if (v.node < '0.10.0') {
	console.log('Builder requieres at least Node.JS 0.10.0')
	return;
}

var copyFileSync = function(srcFile, destFile, encoding) {
  var content = fs.readFileSync(srcFile, encoding);
  fs.writeFileSync(destFile, content, encoding);
}

var fs = require('fs');
var os = require('os');
var less = require('less');
var UglifyJS = require("uglify-js");

var exec = require('child_process').exec;
var isWin = !!os.platform().match(/^win/);  // detects platform to set the right folder separator
var DS = '/';
if (isWin) DS = '\\';

var cacheDir = '.cache';

function cleanDir(mydir) {
	// Recreates Cache folder
	if (fs.existsSync(mydir)) {
		var list = fs.readdirSync(mydir);
		if (list)
			list.forEach(function (f) {
				fs.unlinkSync(mydir + '/' + f);;
			});
	}
	else
		fs.mkdirSync(mydir);
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

// Template JUI
var templateJSjui = '../../js/jui';
var templateCSSjui = '../../css/jui';

cleanDir(cacheDir);
cleanDir(templateJSjui);
cleanDir(templateCSSjui);

// Iterate LESS styles
var joomlalessRegEx = /joomla([0-9]+).less/i;
var stylelessRegEx = /variables-([a-z0-9\-]+).less/i;

var filesToParse = new Array();
var filesToParseNo = 0;
var parsedFiles = 0;

function parseLessFiles() {
	var parserOptions = {};
	var parser = new less.Parser(parserOptions);

	var df = filesToParse[parsedFiles][0];
	var dfcss = filesToParse[parsedFiles][1];

	var data = fs.readFileSync(df,'utf8');

	parser.parse(data, function (err, tree) {
		if (err) {
			console.log('Error compiling ' + dfcss + ':' + err);
		}
		else {
			var css = tree.toCSS({
				compress: true,
				yuicompress: true
			});
			console.log('Compiled file ' + dfcss);
			fs.writeFileSync('../../css/' + dfcss, css);

			parsedFiles++;
			if (parsedFiles < filesToParseNo) {
				parser = null;
				parseLessFiles();
			}
		}
	});
}

// Read command line arguments
var buildThemesString = '["all"]';
if (process.argv[2] != undefined) {
	buildThemesString = '["' + process.argv[2].replace(',','","') + '"]';
}
var buildThemes = JSON.parse(buildThemesString);

// Iterate styles
var list = fs.readdirSync('../../less');
if (list) {
	list.forEach(function (f) {
		if (stylelessRegEx.test(f)) {
			var st = f.match(stylelessRegEx);  // Style from variables-xx.less file
			st = st[1];

			// Less source and CSS compiled files for the style
			var df = cacheDir + '/style-' + st + '.less';
			var dfcss = 'style-' + st + '.css';

			var s = '';

			// Bootstrap base files
			s += '@import url("../../less/variables-' + st + '.less"); ';  
			s += '@import url("less/bootstrap.less"); ';
			fs.writeFileSync(df, s);

			// Bootstrap base file
			if (buildThemes.indexOf(st) != -1 || buildThemes.indexOf('all') != -1) {
				filesToParse[filesToParseNo] = new Array();
				filesToParse[filesToParseNo][0] = df;
				filesToParse[filesToParseNo][1] = dfcss;
				filesToParse[filesToParseNo][2] = st;
				filesToParseNo++;
			}

			var list2 = fs.readdirSync('less');
			if (list2) {
				list2.forEach(function (f2) {
					if (joomlalessRegEx.test(f2)) {
						// specific Joomla version file
						var jv = f2.match(joomlalessRegEx);  // Joomla version from joomlaxx.less file
						jv = jv[1];

						// Less source and CSS compiled files for the style and Joomla version
						var dfext = cacheDir + '/style-joomla' + jv + '-' + st + '-extended.less';
						var dfr = cacheDir + '/style-joomla' + jv + '-' + st + '-responsive.less';
						var dfcssext = 'joomla' + jv + '-' + st + '-extended.css';
						var dfcssr = 'joomla' + jv + '-' + st + '-responsive.css';
						var s = '';

						// Bootstrap extended files (Joomla specifics)
						s = '';
						s += '@import url("../../less/variables-' + st + '.less"); ';  
						s += '@import url("libraries/bootstrap/less/mixins.less"); ';  
						s += '@import url("less/typography.less"); ';
						s += '@import url("less/joomla.less"); ';
						s += '@import url("less/joomla' + jv + '.less"); ';
						if (fs.existsSync('../../less/template.less'))  // Template file (if exists)
							s += '@import url("../../less/template.less"); ';
						if (fs.existsSync('../../less/style-' + st + '.less'))  // Style file (if exists)
							s += '@import url("../../less/style-' + st + '.less"); ';
						fs.writeFileSync(dfext, s);

						// Bootstrap responsive files
						var s = '';
						s += '@import url("../../less/variables-' + st + '.less"); ';  // Global style variables
						s += '@import url("less/responsive.less"); ';  // Bootstrap responsive less file
						s += '@import url("less/joomla-responsive.less"); ';  // Joomla general responsive file
						s += '@import url("less/joomla' + jv + '-responsive.less"); ';  // Joomla version responsive file
						if (fs.existsSync('../../less/template-responsive.less'))  // Template responsive file (if exists)
							s += '@import url("../../less/template-responsive.less"); ';
						if (fs.existsSync('../../less/style-' + st + '-responsive.less'))  // Style responsive file (if exists)
							s += '@import url("../../less/style-' + st + '-responsive.less"); ';
						fs.writeFileSync(dfr, s);

						if (buildThemes.indexOf(st) != -1 || buildThemes.indexOf('all') != -1) {
							// extended file (Joomla and template specifics)
							filesToParse[filesToParseNo] = new Array();
							filesToParse[filesToParseNo][0] = dfext;
							filesToParse[filesToParseNo][1] = dfcssext;
							filesToParse[filesToParseNo][2] = st;
							filesToParseNo++;

							// extended file (Joomla and template specifics)
							filesToParse[filesToParseNo] = new Array();
							filesToParse[filesToParseNo][0] = dfr;
							filesToParse[filesToParseNo][1] = dfcssr;
							filesToParse[filesToParseNo][2] = st;
							filesToParseNo++;
						}
					}
				});
			}
		}
	})
}

if (filesToParseNo) {
	parseLessFiles();
}
else {
	console.log('No LESS files found to parse, no CSS was built');
}

// Bootstrap Images
fs.readdir('libraries/bootstrap/img', function (err, list) {
	if (list)
		list.forEach(function (f) {
			copyFileSync('libraries/bootstrap/img/' + f,'../images/' + f,'binary');
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


// copy files to Joomla! JUI folders
copyFileSync('../css/bootstrap.min.css',templateCSSjui + '/bootstrap.min.css','utf8');
copyFileSync('../css/bootstrap-responsive.min.css',templateCSSjui + '/bootstrap-responsive.min.css','utf8');
copyFileSync('../css/bootstrap-extended.css',templateCSSjui + '/bootstrap-extended.css','utf8');
copyFileSync('../js/jquery.min.js',templateJSjui + '/jquery.min.js','utf8');
copyFileSync('../js/bootstrap.min.js',templateJSjui + '/bootstrap.min.js','utf8');
