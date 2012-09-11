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

if (!function_exists("wright_joomla_breadcrumbs")) :
/*
	function wright_joomla_breadcrumbs_span($matches) {
		return "<li><span>" . $matches[1] . "</span></li>";
	}

	function wright_joomla_breadcrumbs_span_img($matches) {
		return "<li><span>" . $matches[1] . "</span><span class='divider'>/</span></li>";
	}

	function wright_joomla_breadcrumbs_a($matches) {
		return "<li><a" . $matches[1] . ">" . $matches[2] . "</a></li>";
	}

	function wright_joomla_breadcrumbs_a_img($matches) {
		return "<li><a" . $matches[1] . ">" . $matches[2] . "</a><span class='divider'>/</span></li>";
	}

	function wright_joomla_breadcrumbs($buffer) {
		$buffer = preg_replace('/<div class="breadcrumbs">/Ui', '<ul class="breadcrumbs">', $buffer);
		$buffer = preg_replace('/<\/div>/Ui', '</ul>', $buffer);
		$buffer = preg_replace('/<span class="showHere">([^<]*)<\/span>/Ui', '', $buffer);
		
		$buffer = preg_replace_callback('/<a([^>]*)>([^<]*)<\/a>([^<]*)<img([^>]*)>/Ui', "wright_joomla_breadcrumbs_a_img", $buffer);
		$buffer = preg_replace_callback('/<li>([^<]*)<a([^>]*)>([^<]*)<\/a>/Ui', "wright_joomla_breadcrumbs_a", $buffer);
		return $buffer;
	}*/

endif;

//ob_start("wright_joomla_breadcrumbs");
require('modules/mod_breadcrumbs/tmpl/default.php');
//ob_end_flush();
?>