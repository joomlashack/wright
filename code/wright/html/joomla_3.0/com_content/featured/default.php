<?php
/**
 * @package		Joomla.Site
 * @subpackage	com_content
 * @copyright	Copyright (C) 2005 - 2012 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die;
if (!function_exists("wright_joomla_content_featured")) :

	function wright_joomla_content_featured($buffer) {
		// Bootstrapped images		
		$app = JFactory::getApplication();
		$template = $app->getTemplate(true);
		$params = $template->params;
		$bootstrap_images = $params->get('bootstrap_images','');
		$buffer = preg_replace('/<div class="([^>]*)item-image">([^<]*)<img([^>]*)>/Ui','<div class="$1item-image">$2<img width="98%" class="' . $bootstrap_images . '" $3>',$buffer);
		$buffer = preg_replace('/<div class="img-intro-([a-z]+)">([^<]*)<img([^>]*)>/Ui','<div class="img-intro-$1">$2<img width="98%" class="' . $bootstrap_images . '" $3>',$buffer);		

		return $buffer;
	}

endif;

ob_start("wright_joomla_content_featured");
require('components/com_content/views/featured/tmpl/default.php');
ob_end_flush();

