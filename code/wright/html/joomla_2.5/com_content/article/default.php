<?php
/**
 * @package		Joomla.Site
 * @subpackage	com_content
 * @copyright	Copyright (C) 2005 - 2012 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die;
if (!function_exists("wright_joomla_content_article")) :
	
	$wright_bootstrap_images = '';
	
	function wright_joomla_content_article_image($matches) {
		$width = '';
		global $wright_bootstrap_images;
		if ($matches[1] == "none")
			$width = ' width="98%"';
		
		return '<div class="img-fulltext-' . $matches[1] . '">' . $matches[2] . '<img' . $width . ' class="' . $wright_bootstrap_images . '" ' . $matches[3] . '>';
	}

	function wright_joomla_content_article_image_full($matches) {
		$width = '';
		global $wright_bootstrap_images;
		if ($matches[1] == "none")
			$width = ' width="98%"';
		
		return '<div class="img-intro-' . $matches[1] . '">' . $matches[2] . '<img' . $width . ' class="' . $wright_bootstrap_images . '" ' . $matches[3] . '>';
	}
	
	function wright_joomla_content_article($buffer) {

		// Bootstrapped images
		global $wright_bootstrap_images;	
		$app = JFactory::getApplication();
		$template = $app->getTemplate(true);
		$params = $template->params;
		$wright_bootstrap_images = $params->get('bootstrap_images','');
		$buffer = preg_replace_callback('/<div class="img-fulltext-([a-z]+)">([^<]*)<img([^>]*)>/Ui', 'wright_joomla_content_article_image', $buffer);
		$buffer = preg_replace_callback('/<div class="img-intro-([a-z]+)">([^<]*)<img([^>]*)>/Ui', 'wright_joomla_content_article_image_full', $buffer);
		
		$buffer = preg_replace('/<dd class="category-name">/Ui', '<dd class="category-name"><i class="icon-folder-close"></i>', $buffer);
		$buffer = preg_replace('/<dd class="create">/Ui', '<dd class="create"><i class="icon-calendar"></i>', $buffer);
		$buffer = preg_replace('/<dd class="modified">/Ui', '<dd class="modified"><i class="icon-edit"></i>', $buffer);
		$buffer = preg_replace('/<dd class="published">/Ui', '<dd class="published"><i class="icon-table"></i>', $buffer);
		$buffer = preg_replace('/<dd class="createdby">/Ui', '<dd class="createdby"><i class="icon-user"></i>', $buffer);
		$buffer = preg_replace('/<dd class="hits">/Ui', '<dd class="hits"><i class="icon-signal"></i>', $buffer);
		$buffer = preg_replace('/<dd class="parent-category-name">/Ui', '<dd class="hits"><i class="icon-folder-close"></i>', $buffer);
	    $buffer = preg_replace('/<ul class="actions">/Ui', '<ul class="btn-group actions">', $buffer);
		$buffer = preg_replace('/<li class="([^-]+)-icon">/Ui', '<li class="btn $1-icon">', $buffer);
		$buffer = preg_replace('/<li>Next/Ui', '<li class="disabled"><a>Next</a> ', $buffer);
		$buffer = preg_replace('/<li>Prev/Ui', '<li class="disabled"><a>Prev</a> ', $buffer);
		$buffer = preg_replace('/class="tabs"/Ui', 'class="tabs nav nav-tabs"', $buffer); 


		$buffer = preg_replace('/<div id="article-index">([^<]*)<h3>([^<]*)<\/h3>([^<]*)<ul>/Ui', '<div id="article-index">$1<h3>$2</h3>$3<ul class="nav nav-tabs nav-stacked">', $buffer);
		$buffer = preg_replace('/<div id="article-index">([^<]*)<ul>/Ui', '<div id="article-index">$1<ul class="nav nav-tabs nav-stacked">', $buffer);
		
		return $buffer;
	}

endif;


ob_start("wright_joomla_content_article");
require('components/com_content/views/article/tmpl/default.php');
ob_end_flush();


?>
