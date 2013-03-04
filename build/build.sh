#!/bin/bash

# reset final css and temp folders
rm -f ../code/css/joomla[0-9]*-[a-z]*.css
rm -rf ../sources/less/.cache
mkdir ../sources/less/.cache
#iterate styles
for f in ../sources/less/variables-[a-z]*.less
do
	c=${#f};
	c=$((c-31));
	f=${f:26:$c};
	#iterate Joomla versions
	for j in ../sources/less/joomla[[:digit:]][[:digit:]].less
	do
		jv=${j:22:2};

		#create bootstrap file for each style/Joomla version
		df="../sources/less/.cache/style-joomla"$jv"-"$f".less";
		ds=""
		ds=$ds"@import \"../variables-"$f".less\"; ";
		ds=$ds"@import \"../bootstrap.less\"; ";
		ds=$ds"@import \"../typography.less\"; ";
		ds=$ds"@import \"../joomla"$jv".less\"; ";
		ds=$ds"@import \"../template.less\"; ";
		if [ -f ../sources/less/style-$f.less ];
		then
			ds=$ds"@import \"../style-"$f".less\"; ";
		fi
		echo $ds > $df;
		node_modules/.bin/recess --compress $df > ../code/css/joomla$jv-$f.css

		#create responsive file for each style/Joomla version
		df="../sources/less/.cache/style-joomla"$jv"-"$f"-responsive.less";
		ds=""
		ds=$ds"@import \"../variables-"$f".less\"; ";
		ds=$ds"@import \"../responsive.less\"; ";
		ds=$ds"@import \"../joomla"$jv"-responsive.less\"; ";
		if [ -f ../sources/less/template-responsive.less ];
		then
			ds=$ds"@import \"../template-responsive.less\"; ";
		fi
		if [ -f ../sources/less/style-$f-responsive.less ];
		then
			ds=$ds"@import \"../style-"$f"-responsive.less\"; ";
		fi
		echo $ds > $df;
		node_modules/.bin/recess --compress $df > ../code/css/joomla$jv-$f-responsive.css
	done
done

#copy images
cp -f libraries/bootstrap/img/* ../code/wright/images/

#javascript files
rm -rf ../code/wright/js/bootstrap.min.js
rm -rf ../sources/.cache
mkdir ../sources/.cache

cat libraries/bootstrap/js/bootstrap-transition.js libraries/bootstrap/js/bootstrap-alert.js libraries/bootstrap/js/bootstrap-button.js libraries/bootstrap/js/bootstrap-carousel.js libraries/bootstrap/js/bootstrap-collapse.js libraries/bootstrap/js/bootstrap-dropdown.js libraries/bootstrap/js/bootstrap-modal.js libraries/bootstrap/js/bootstrap-tooltip.js libraries/bootstrap/js/bootstrap-popover.js libraries/bootstrap/js/bootstrap-scrollspy.js libraries/bootstrap/js/bootstrap-tab.js libraries/bootstrap/js/bootstrap-typeahead.js libraries/bootstrap/js/bootstrap-affix.js > ../sources/.cache/bootstrap.js
./node_modules/.bin/uglifyjs -nc ../sources/.cache/bootstrap.js > ../sources/.cache/bootstrap.min.tmp.js
echo "/*!\n* Bootstrap.js by @fat & @mdo\n* Copyright 2012 Twitter, Inc.\n* http://www.apache.org/licenses/LICENSE-2.0.txt\n*/" > ../sources/.cache/copyright.js
cat ../sources/.cache/copyright.js ../sources/.cache/bootstrap.min.tmp.js > ../code/wright/js/bootstrap.min.js


#remove caches
rm -rf ../sources/.cache
rm -rf ../sources/less/.cache