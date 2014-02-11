<?php
// Wright v.3 Override Helper: Joomla 2.5.18
/**
 * @version
 * @package		Wright
 * @subpackage	Overrides
 * @copyright	Copyright (C) 2005 - 2014 Joomlashack / Meritage Assets. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */
 
 
 // no direct access
 defined('_JEXEC') or die;
 
function wrightTransformArticleContent($content) {
	// Page Break Plugin
	$content = preg_replace("/dl([^>]*)class=\"tabs\"/Uis", 'dl$1class="tabs nav nav-tabs"', $content);  // Add tabs
 	$content = preg_replace("/<div class=\"pagination\">(.*)<li>([^>]*)<\/li>(.*)<\/div>/Uis", "<div class=\"pagination\">$1<li class=\"disabled\"><a href=\"#\" />$2</a></li>$3</div>", $content);  // Inside pagination

	return $content;
}

function wrightTransformArticleTOC($content) {
	$content = preg_replace("/<div id=\"article-index\">(.*)<ul>(.*)<\/div>/Uis", "<div id=\"article-index\">$1<ul class=\"nav nav-tabs nav-stacked\">$2</div>", $content);

	return $content;
}

function wrightTransformArticlePagination($content) {
	$content = preg_replace("/<li([^>]*)class=\"([^\"]*)\"([^>]*)>([^<]*)<span([^>]*)>([^<]*)<\/span>([^<]*)<\/li>/iUs", "<li$1class=\"$2 disabled\"$3>$4<a$5 href=\"#\">$6</a>$7</li>", $content);
	$content = preg_replace("/<li([^>]*)>([^<]*)<span([^>]*)>([0-9]+)<\/span>([^<]*)<\/li>/iUs", "<li$1 class=\"active\">$2<a$3 href=\"#\">$4</a>$5</li>", $content);
	return $content;
}

function wrightTransformArticlePager($content) {
	$content = preg_replace("/<ul class=\"pagenav\">/iUs", "<ul class=\"pagenav pager\">", $content);
	$content = preg_replace("/<li class=\"pagenav-next\">/iUs", "<li class=\"pagenav-next next\">", $content);
	$content = preg_replace("/<li class=\"pagenav-prev\">/iUs", "<li class=\"pagenav-prev previous\">", $content);
	return $content;
}

function getBlogItemLink($item) {
	if ($item->params->get('access-view')) {
		$link = JRoute::_(ContentHelperRoute::getArticleRoute($item->slug, $item->catid, $item->language));
	}
	else {
		$menu = JFactory::getApplication()->getMenu();
		$active = $menu->getActive();
		$itemId = $active->id;
		$link1 = JRoute::_('index.php?option=com_users&view=login&Itemid=' . $itemId);
		$returnURL = JRoute::_(ContentHelperRoute::getArticleRoute($item->slug, $item->catid, $item->language));
		$link = new JURI($link1);
		$link->setVar('return', base64_encode(urlencode($returnURL)));
	}
	return $link;
}

function getIntroImageFloat($item) {
	$images = json_decode($item->images);
	return (empty($images->float_intro)) ? $item->params->get('float_intro') : $images->float_intro;
}


?>
