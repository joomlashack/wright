<?php
/**
 * @copyright	Copyright (C) 2005 - 2010 Joomlashack LLC
 * @author		Jeremy Wilken
 * @package		Wright
 */
// no direct access
defined('_JEXEC') or die('Restricted access');
?>
<!-- Doctype will be replaced with the user selected doctype -->
<doctype>
<!-- HTML tag will be replaced with the appropriate format for selected doctype -->
<html>
<head>
	<!-- The Wright:head tag handles most things in the header -->
	<w:head />
</head>
<body class="test">
	<div class="container_12">
		<!-- Outputs the navigation with name of topmenu -->
		<w:nav name="topmenu" class="topmenu" wrapclass="grid_12" />
	</div>

	<div class="container_12">
		<header class="masthead">
			<!-- Outputs a grid based on settings of two boxes, the left is an image and the right is a newsflash module -->
			<w:logo />
			<!-- Outputs the navigation with default settings -->
			<w:nav />
		</header>
		<div class="grid_12">
			<!-- Grid -->
			<w:module type="grid" wrapper="banner_wrap" name="banner" chrome="wrightflexgrid" />
		</div>
		<section id="main">
			<w:module name="before" />
			<w:content />
			<w:module name="after" />
		</section>
		<aside id="sidebar1">
			<w:module name="sidebar1" chrome="xhtml" />
		</aside>
		<aside id="sidebar2">
			<w:module name="sidebar2" chrome="xhtml" />
		</aside>
		<footer class="grid_12">
			<w:module type="grid" wrapper="footer_wrap" name="footer" chrome="wrightflexgrid" />
			<!-- The Wright:footer tag handles the generation of the branding and footer -->
			<w:footer />
		</footer>
	</div>
<w:debug />
</body>
</html>