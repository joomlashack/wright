# [Joomlashack Wright v3.1](http://wright.joomlashack.com)

Latest version: **v.3.1**

The Wright Framework is used to create Joomla Templates.  The name is in honor of the famous architect, Frank Lloyd Wright, because the framework is like a blueprint.   It provides a solid foundation to build from, and helps to keep the entire template together while merging some unique features and tools.  This is the end result, which is a great tool integrated with the templates, providing many benefits.

## Wright General View

### The Wright-based Joomla Template - a "Strictly Joomla" approach to templates

Wright helps building light, non-bloated, and simple to install Joomla Templates to make your life easier.  We call them "strictly Joomla" because in most cases you are able to install them using only the Joomla CMS and it's built-in features.  This is different from other template frameworks because they require you to install extra plugins, extensions for the template to work.


### Bootstrapped and Joomla 2.5/3.x ready

Starting with Wright v.3 the framework is based on [Twitter Bootstrap](http://twitter.github.com/bootstrap/), making templates built on it responsive.  It also supports Joomla 2.5.x and Joomla 3.x.x


## Quick start

Three quick start options are available:

* [Check out the demo](http://wright.joomlashack.com/demo).
* [Download the latest release](http://wright.joomlashack.com/download) to start building your template (check out the **Developers** section in this document)
* Clone the repo: `git clone git://github.com/joomlashack/wright.git`


## Versioning

For transparency and insight into our release cycle, and for striving to maintain backward compatibility, Wright will be maintained under the Semantic Versioning guidelines as much as possible.

Releases will be numbered with the following format:

`<major>.<minor>.<patch>`

And constructed with the following guidelines:

* Breaking backward compatibility bumps the major (and resets the minor and patch)
* New additions without breaking backward compatibility bumps the minor (and resets the patch)
* Bug fixes and misc changes bumps the patch

For more information on SemVer, please visit http://semver.org/.


## Bug tracker

Have a bug or a feature request? [Please open a new issue](https://github.com/joomlashack/wright/issues?state=open). Before opening any issue, please search for existing issues and read the [Issue Guidelines](https://github.com/necolas/issue-guidelines), written by [Nicolas Gallagher](https://github.com/necolas/).


## Community

Keep track of development and community news.

* Follow [@joomlashack on Twitter](http://twitter.com/joomlashack).
* Read and subscribe to the [The Joomlashack Wright Blog](http://www.joomlashack.com/blog/wright-template-framework).
* Have a question that's not a feature request or bug report? [Ask in our forum](https://help.joomlashack.com/categories/20059413-Wright-Joomla-Template-Framework)



## Developers

A few notes when you start creating your new Joomla template using Wright.

### Joomla Template

The **js_wright** Joomla template (base template including Wright v.3) starts in the *code* folder.  The contents of that folder are an installable template file.

### Wright Framework

The Wright Framework overrides the *index.php* file of a Joomla template (and uses template.php file with its own structure) and needs all the *wright* folder to work (also located inside the *code* folder).

### templateDetails.xml

The templateDetails.xml file contains the basic configuration of a Joomla template.  If you’re creating your own template, be sure to change the name and description, plus the referenced folders (everything using *js_wright*) to your new template’s name.

## Contributing

Since migrated to GIT, Wright has been using [Vincent Driessen’s GIT model](http://nvie.com/posts/a-successful-git-branching-model/). According to that, please submit all pull requests done to either **develop**, **feature** or **hotfix** branches.

If you’re using a hotfix or feature branch, clearly specify the purpose of it.  The name of any feature version is free.  Hotfixes must all start with hotfix-*. 


### Wright v.2

Wright v.2 is still supported in **v.2** and **develop-v.2** branches.  They are used similar to **master** and **develop** branches.  Contributions to Wright v.2 should be done to **develop-v.2** branch or a new feature version (make sure you end any hotfix or feature version with *-v.2).


**Thanks!**

[The Joomlashack Team](http://www.joomlashack.com/about-joomlashack)


## Copyright and license

Copyright 2010-2013 Joomlashack

Licensed under the GNU/GPL v3 (the "License");
This framework is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.  

http://www.gnu.org/licenses/gpl.html

This framework is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU General Public License for more details.
