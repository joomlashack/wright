<?php
/**
 * @package     Wright
 * @subpackage  Component File
 *
 * @copyright   Copyright (C) 2005 - 2015 Joomlashack. Meritage Assets.  All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

// Restrict Access to within Joomla
defined('_JEXEC') or die('Restricted access');


// Include the framework
require dirname(__FILE__) . '/wright/wright.php';

// Initialize the framework and include header
$tpl = Wright::getInstance();
$tpl->header();

?>
<!DOCTYPE html>
<html lang="<?php
	echo $this->language;
		?>" dir="<?php
	echo $this->direction;
		?>" >
	<head>
		<jdoc:include type="head" />
	</head>
	<body class="contentpane">
		<jdoc:include type="message" />
		<jdoc:include type="component" />
	</body>
</html>
