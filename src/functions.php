<?php
/**
 * @package     Wright
 * @subpackage  Functions
 *
 * @copyright   Copyright (C) 2005 - 2018 Joomlashack.  All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

// Restrict Access to within Joomla
defined('_JEXEC') or die('Restricted access');

// Menu classes for Joomla 3
if (version_compare(JVERSION, '4', 'lt')) {
	$toolbarMenuClasses = 'navbar-fixed-top navbar-inverse';
	$mainMenuClasses    = '';
}
// Menu classes for Joomla 4
else {
	$toolbarMenuClasses = 'fixed-top';
	$mainMenuClasses    = 'navbar-dark bg-primary';
}