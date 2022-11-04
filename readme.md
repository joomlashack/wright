The Wright Framework is used to create Joomla 3 templates.  

This framework will not be updated for Joomla 4.

The name is in honor of the famous architect, Frank Lloyd Wright, because the framework is like a blueprint.   It provides a solid foundation to build from, and helps to keep the entire template together while merging some unique features and tools.  This is the end result, which is a great tool integrated with the templates, providing many benefits.

## Wright General Overview

### The Wright-based Joomla Template - a "Strictly Joomla" approach to templates

Wright helped building light, non-bloated, and simple to install Joomla templates.  We called them "strictly Joomla" because in most cases the templates do no require any extra extensions to function, only the Joomla CMS and it's built-in features.  This iw different from many other template frameworks that required you to install extra plugins and/or components for the template to work.

## Versioning

For transparency and insight into our release cycle, and for striving to maintain backward compatibility, Wright was maintained under the Semantic Versioning guidelines as much as possible.

Releases were numbered with the following format:

`<major>.<minor>.<patch>`

And constructed with the following guidelines:

* Breaking backward compatibility bumps the major (and resets the minor and patch)
* New additions without breaking backward compatibility bumps the minor (and resets the patch)
* Bug fixes and misc changes bumps the patch

For more information on SemVer, please visit http://semver.org/.

### Bootstrapped

Wright was based on version 2 of [Twitter Bootstrap](http://twitter.github.com/bootstrap/). 

## Developers

A few notes on creating your new Joomla template using Wright.

### Joomla Template

The **js_wright** Joomla template (base template including Wright v.3) starts in the *code* folder.  The contents of that folder are an installable template file.

### Wright Framework

The Wright Framework overrides the *index.php* file of a Joomla template (and uses template.php file with its own structure) and needs all the *wright* folder to work (also located inside the *code* folder).

### templateDetails.xml

The templateDetails.xml file contains the basic configuration of a Joomla template.  If you’re creating your own template, be sure to change the name and description, plus the referenced folders (everything using *js_wright*) to your new template’s name.

## Contributing

Wright ueses [Vincent Driessen’s GIT model](http://nvie.com/posts/a-successful-git-branching-model/). According to that, please submit all pull requests done to either **develop**, **feature** or **hotfix** branches.

If you’re using a hotfix or feature branch, clearly specify the purpose of it.  The name of any feature version is free.  Hotfixes must all start with hotfix-*.

**Thanks!**

[The Joomlashack Team](http://www.joomlashack.com/about-joomlashack)

## Copyright and license

Copyright 2005 - Joomlashack

Licensed under the GNU/GPL v3 (the "License");
This framework is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.

http://www.gnu.org/licenses/gpl.html

This framework is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU General Public License for more details.
