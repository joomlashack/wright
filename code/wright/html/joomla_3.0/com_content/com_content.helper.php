<?php
/**
 * @version
 * @package		Wright
 * @subpackage	Overrides
 * @copyright	Copyright (C) 2005 - 2013 Joomlashack / Meritage Assets. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */
 
 
 // no direct access
 defined('_JEXEC') or die;
 
function wrightTransformArticleContent($content) {
	// Page Break Plugin
	$content = preg_replace("/class=\"tabs\"/Uis", 'class="tabs nav nav-tabs"', $content);

	return $content;
}

function wrightTransformArticleTOC($content) {
	return $content;
}

function wrightTransformArticlePagination($content) {

	return $content;
}

function wrightTransformArticlePager($content) {
	return $content;
}


?>