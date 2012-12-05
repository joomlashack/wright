<?php
/**
 * @version		$Id: default.php 22355 2011-11-07 05:11:58Z github_bot $
 * @package		Joomla.Site
 * @subpackage	mod_menu
 * @copyright	Copyright (C) 2005 - 2011 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access.
defined('_JEXEC') or die;

if (!function_exists("wright_joomla_mod_search")) :	

function wright_joomla_mod_search($buffer) {
	$buffer = preg_replace('/<input([^>]*)class="button([^"]*)"([^>]*)>/Ui', '<input$1class="button$2 btn btn-primary"$3>', $buffer);
	$buffer = preg_replace('/<input([^>]*)type="image"([^>]*)class="button([^"]*) btn btn-primary"([^>]*)>/Ui', '<input$1type="image"$2class="button$3"$4>', $buffer);

	return $buffer;
				
}
	

endif;

ob_start("wright_joomla_mod_search");
require('modules/mod_search/tmpl/default.php');
ob_end_flush();
?>
