<?php
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

	return $content;
}

function wrightTransformArticleTOC($content) {
	return $content;
}

function wrightTransformArticlePagination($content) {
	$content = preg_replace("/<li([^>]*)class=\"([^\"]*)\"([^>]*)>([^<]*)<span([^>]*)>([^<]*)<\/span>([^<]*)<\/li>/iUs", "<li$1class=\"$2 disabled\"$3>$4<a$5 href=\"#\">$6</a>$7</li>", $content);
	$content = preg_replace("/<li([^>]*)>([^<]*)<span([^>]*)>([0-9]+)<\/span>([^<]*)<\/li>/iUs", "<li$1 class=\"active\">$2<a$3 href=\"#\">$4</a>$5</li>", $content);
	return $content;
}

function wrightTransformArticlePager($content) {
	return $content;
}

function getBlogItemLink($item) {
	if ($item->params->get('access-view'))
	{
		$link = JRoute::_(ContentHelperRoute::getArticleRoute($item->slug, $item->catid));
	}
	else
	{
		$menu = JFactory::getApplication()->getMenu();
		$active = $menu->getActive();
		$itemId = $active->id;
		$link1 = JRoute::_('index.php?option=com_users&view=login&Itemid=' . $itemId);
		$returnURL = JRoute::_(ContentHelperRoute::getArticleRoute($item->slug, $item->catid));
		$link = new JUri($link1);
		$link->setVar('return', base64_encode($returnURL));
	}
	return $link;
}

function getIntroImageFloat($item) {
	$images = json_decode($item->images);
	return (empty($images->float_intro)) ? $item->params->get('float_intro') : $images->float_intro;
}

?>
