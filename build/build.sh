#!/bin/bash

rm -f ../code/css/joomla[0-9]*-[a-z]*.css
rm -rf ../sources/less/.cache
mkdir ../sources/less/.cache
for f in ../sources/less/variables-[a-z]*.less
do
	c=${#f};
	c=$((c-31));
	f=${f:26:$c};
	for j in ../sources/less/joomla[[:digit:]][[:digit:]].less
	do
		jv=${j:22:2};
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