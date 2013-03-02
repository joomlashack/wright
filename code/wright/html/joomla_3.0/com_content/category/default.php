<?php
/**
 * @package		Joomla.Site
 * @subpackage	com_content
 * @copyright	Copyright (C) 2005 - 2012 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die;
if (!function_exists("wright_joomla_content_category")) :

	function wright_joomla_content_category($buffer) {
		return $buffer;
	}

endif;

ob_start("wright_joomla_content_category");
require('components/com_content/views/category/tmpl/default.php');
ob_end_flush();

