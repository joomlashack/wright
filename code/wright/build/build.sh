#!/bin/bash

# reset final css and temp folders
rm -f ../../css/joomla[0-9]*-[a-z]*.css
rm -rf .cache
mkdir .cache
#iterate styles
for f in ../../less/variables-[a-z]*.less
do
	c=${#f};
	c=$((c-26));
	f=${f:21:$c};
	#iterate Joomla versions
	for j in less/joomla[[:digit:]][[:digit:]].less
	do
		jv=${j:11:2};

		#create bootstrap file for each style/Joomla version
		df=".cache/style-joomla"$jv"-"$f".less";
		ds=""
		ds=$ds"@import \"../../../less/variables-"$f".less\"; ";
		ds=$ds"@import \"../less/bootstrap.less\"; ";
		ds=$ds"@import \"../less/typography.less\"; ";
		ds=$ds"@import \"../less/joomla"$jv".less\"; ";
		ds=$ds"@import \"../../../less/template.less\"; ";
		if [ -f ../../less/style-$f.less ];
		then
			ds=$ds"@import \"../../../less/style-"$f".less\"; ";
		fi
		echo $ds > $df;
		node_modules/.bin/recess --compress $df > ../../css/joomla$jv-$f.css

		#create responsive file for each style/Joomla version
		df=".cache/style-joomla"$jv"-"$f"-responsive.less";
		ds=""
		ds=$ds"@import \"../../../less/variables-"$f".less\"; ";
		ds=$ds"@import \"../less/responsive.less\"; ";
		ds=$ds"@import \"../less/joomla"$jv"-responsive.less\"; ";
		if [ -f ../../less/template-responsive.less ];
		then
			ds=$ds"@import \"../../../less/template-responsive.less\"; ";
		fi
		if [ -f ../../less/style-$f-responsive.less ];
		then
			ds=$ds"@import \"../../../less/style-"$f"-responsive.less\"; ";
		fi
		echo $ds > $df;
		node_modules/.bin/recess --compress $df > ../../css/joomla$jv-$f-responsive.css
	done
done

#copy images
cp -f libraries/bootstrap/img/* ../images/

#javascript files
rm -rf ../js/bootstrap.min.js

cat libraries/bootstrap/js/bootstrap-transition.js libraries/bootstrap/js/bootstrap-alert.js libraries/bootstrap/js/bootstrap-button.js libraries/bootstrap/js/bootstrap-carousel.js libraries/bootstrap/js/bootstrap-collapse.js libraries/bootstrap/js/bootstrap-dropdown.js libraries/bootstrap/js/bootstrap-modal.js libraries/bootstrap/js/bootstrap-tooltip.js libraries/bootstrap/js/bootstrap-popover.js libraries/bootstrap/js/bootstrap-scrollspy.js libraries/bootstrap/js/bootstrap-tab.js libraries/bootstrap/js/bootstrap-typeahead.js libraries/bootstrap/js/bootstrap-affix.js > .cache/bootstrap.js
./node_modules/.bin/uglifyjs -nc .cache/bootstrap.js > .cache/bootstrap.min.tmp.js
echo "/*!\n* Bootstrap.js by @fat & @mdo\n* Copyright 2012 Twitter, Inc.\n* http://www.apache.org/licenses/LICENSE-2.0.txt\n*/" > .cache/copyright.js
cat .cache/copyright.js .cache/bootstrap.min.tmp.js > ../js/bootstrap.min.js


#remove caches
rm -rf .cache