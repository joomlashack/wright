var fs = require('fs');
var os = require('os');
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
								var s = '';
								s += '@import "../../../less/variables-' + st + '.less"; ';  // Global style variables
								s += '@import "../less/bootstrap.less"; ';  // Bootstrap less file
								s += '@import "../less/typography.less"; ';  // Global typography file
								s += '@import "../less/joomla' + jv + '.less"; ';  // Joomla version file
								if (fs.existsSync('../../less/template.less'))  // Template file (if exists)
									s += '@import "../../../less/template.less"; ';
								if (fs.existsSync('../../less/style-' + st + '.less'))  // Style file (if exists)
									s += '@import "../../../less/style-' + st + '.less"; ';
								fs.writeFile(df, s);

								exec('node_modules' + DS + '.bin' + DS + 'recess --compress ' + df + ' > ../../css/joomla' + jv + '-' + st + '.css', function callback(error, stdout, stderr){
									if (stderr != '')
										console.log('Errors while creating file joomla' + jv + '-' + st + '.css: ' + stderr);
									else
										console.log('Crated file joomla' + jv + '-' + st + '.css');
								});

								// Create responsive files
								var df = cacheDir + '/style-joomla' + jv + '-' + st + '-responsive.less';
								var s = '';
								s += '@import "../../../less/variables-' + st + '.less"; ';  // Global style variables
								s += '@import "../less/responsive.less"; ';  // Bootstrap responsive less file
								s += '@import "../less/joomla' + jv + '-responsive.less"; ';  // Joomla version responsive file
								if (fs.existsSync('../../less/template-responsive.less'))  // Template responsive file (if exists)
									s += '@import "../../../less/template-responsive.less"; ';
								if (fs.existsSync('../../less/style-' + st + '-responsive.less'))  // Style responsive file (if exists)
									s += '@import "../../../less/style-' + st + '-responsive.less"; ';
								fs.writeFile(df, s);

								exec('node_modules' + DS + '.bin' + DS + 'recess --compress ' + df + ' > ../../css/joomla' + jv + '-' + st + '-responsive.css', function callback(error, stdout, stderr){
									if (stderr != '')
										console.log('Errors while creating file joomla' + jv + '-' + st + '-responsive.css: ' + stderr);
									else
										console.log('Crated file joomla' + jv + '-' + st + '-responsive.css');
								});
							}
						})
				})

			}
		})
});