<?php
/**
 * @package		Joomla.Site
 * @subpackage	com_content
 * @copyright	Copyright (C) 2005 - 2012 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die;

if (!function_exists("wright_joomla_content_category_blog")) :

	function replace_readmore_blog($matches) {
		return '<p class="readmore">' . $matches[1] . '<a' . $matches[2] . ' class="btn ">';
		
	}
	
	function wright_joomla_content_category_blog_columns($buffer) {
		if (preg_match('/<div([^>]*)class="([^"]*)items-row([^"]*)cols-([0-9]+)([^"]*)"([^>]*)>/Ui', $buffer, $matches)) {
			$cols = $matches[4];
			
			$span = 1;
			switch ($cols) {
				case "1":
					$span = 12;
					break;
				case "2":
					$span = 6;
					break;
				case "3":
					$span = 4;
					break;
				case "4":
					$span = 3;
					break;
				case "5":
					$span = 2;
					break;
				case "6":
					$span = 2;
					break;
				default:
					$span = 1;
			}
			
			$buffer = preg_replace('/<div([^>]*)class="([^"]*)item([^"]*)column-([0-9]+)([^"]*)"([^>]*)>/Ui',
				'<div$1class="$2item$3column-$4$5 span' . $span . '"$6>', $buffer);
		}

		return $buffer;
	}
	
	function wright_joomla_content_category_blog_image($matches) {
		$width = '';
		global $wright_bootstrap_images;
		if ($matches[1] == "none")
			$width = ' width="98%"';
		
		return '<div class="img-fulltext-' . $matches[1] . '">' . $matches[2] . '<img' . $width . ' class="' . $wright_bootstrap_images . '" ' . $matches[3] . '>';
	}

	function wright_joomla_content_category_blog_image_full($matches) {
		$width = '';
		global $wright_bootstrap_images;
		if ($matches[1] == "none")
			$width = ' width="98%"';
		
		return '<div class="img-intro-' . $matches[1] . '">' . $matches[2] . '<img' . $width . ' class="' . $wright_bootstrap_images . '" ' . $matches[3] . '>';
	}
	
	
	function wright_joomla_content_category_blog($buffer) {		
		// Bootstrapped images
		global $wright_bootstrap_images;	
		global $wright_joomla_content_category_blog_nocols;
		
		$app = JFactory::getApplication();
		$template = $app->getTemplate(true);
		$params = $template->params;
		$wright_bootstrap_images = $params->get('bootstrap_images','');
		$buffer = preg_replace_callback('/<div class="img-fulltext-([a-z]+)">([^<]*)<img([^>]*)>/Ui', 'wright_joomla_content_category_blog_image', $buffer);
		$buffer = preg_replace_callback('/<div class="img-intro-([a-z]+)">([^<]*)<img([^>]*)>/Ui', 'wright_joomla_content_category_blog_image_full', $buffer);
		
		$buffer = preg_replace('/<dd class="category-name">/Ui', '<dd class="category-name"><i class="icon-folder-close"></i>', $buffer);
		$buffer = preg_replace('/<dd class="create">/Ui', '<dd class="create"><i class="icon-calendar"></i>', $buffer);
		$buffer = preg_replace('/<dd class="modified">/Ui', '<dd class="modified"><i class="icon-edit"></i>', $buffer);
		$buffer = preg_replace('/<dd class="published">/Ui', '<dd class="published"><i class="icon-table"></i>', $buffer);
		$buffer = preg_replace('/<dd class="createdby">/Ui', '<dd class="createdby"><i class="icon-user"></i>', $buffer);
		$buffer = preg_replace('/<dd class="hits">/Ui', '<dd class="hits"><i class="icon-signal"></i>', $buffer);
		$buffer = preg_replace('/<dd class="parent-category-name">/Ui', '<dd class="hits"><i class="icon-folder-close"></i>', $buffer);
	    $buffer = preg_replace('/<ul class="actions">/Ui', '<ul class="btn-group actions">', $buffer);
		$buffer = preg_replace('/<li class="([^-]+)-icon">/Ui', '<li class="btn $1-icon">', $buffer);
		
		$buffer = preg_replace_callback('/<p class="readmore">([^<]*)<a([^>]*)>/Ui', "replace_readmore_blog", $buffer);	
		$buffer = preg_replace('/ class="button"/Ui', 'class="button btn " style="display:block; float:right; margin-left:5px;"', $buffer);
		
		$buffer = preg_replace('/<h2>/Ui', '<div class="page-header"> <h2>', $buffer);
		$buffer = preg_replace('/<\/h2>/Ui', '</h2> </div>', $buffer);
		$buffer = preg_replace('/<div class="items-more">/Ui', '<div class="items-more well">', $buffer);
		$buffer = preg_replace('/<ol>/Ui', '<ol class="nav nav-list">', $buffer);
		
		$buffer = preg_replace('/<span class="item-title">/Ui', '<span class="item-title"><i class="icon-folder-open"></i>', $buffer);
		$buffer = preg_replace('/<dl>/Ui', '<dl class="label label-info">', $buffer);
		
		$buffer = preg_replace('/<span class="pagenav">/Ui', '<span class="pagenav disabled"><a>', $buffer);
		$buffer = preg_replace('/<\/span><\/li>/Ui', '</a></span></li>', $buffer);
		
		if (!$wright_joomla_content_category_blog_nocols) {
			$buffer = preg_replace('/<div class="blog">/Ui', '<div class="blog row-fluid">', $buffer);
			$buffer = wright_joomla_content_category_blog_columns($buffer);
		}
		
		return $buffer;
	}

endif;

ob_start("wright_joomla_content_category_blog");
require('components/com_content/views/category/tmpl/blog.php');
ob_end_flush();

