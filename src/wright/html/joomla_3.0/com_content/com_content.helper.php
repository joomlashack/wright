<?php
/**
 * @version
 * @package		Wright
 * @subpackage	Overrides
 * @copyright	Copyright (C) 2005 - 2020 Joomlashack.  All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

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

function getSiteLogo() {

	$app        = JFactory::getApplication();
	$template   = $app->getTemplate(true);
	$site_logo  = $template->params->get('logo','template');

	switch($site_logo) {

		// Image from images/ folder
		default:
			$site_logo = JURI::root() . 'images/' . $site_logo;
			break;

		// Logo image from template, template style or Wright framework
		case 'template':

			$template_style = $template->params->get('style');

			if (is_file(JPATH_ROOT . '/templates/' . $app->getTemplate() . '/images/' . $template_style . '/logo.png'))
			{
				$site_logo = JURI::root() . 'templates/' . $app->getTemplate() . '/images/' . $template_style . '/logo.png';
			}
			elseif (is_file(JPATH_ROOT . '/templates/' . $app->getTemplate() . '/images/' . $template_style . '/logo.png'))
			{
				$site_logo = JURI::root() . 'templates/' . $app->getTemplate() . '/images/' . $template_style . '/logo.png';
			}
			elseif (is_file(JPATH_ROOT . '/' . 'templates/' . $app->getTemplate() . '/images/logo.png'))
			{
				$site_logo = JURI::root() . 'templates/' . $app->getTemplate() . '/images/logo.png';
			}
			elseif (is_file(JPATH_ROOT . '/' . 'templates/' . $app->getTemplate() . '/images/logo.png'))
			{
				$site_logo = JURI::root() . 'templates/' . $app->getTemplate() . '/images/logo.png';
			}
			else
			{
				$site_logo = JURI::root() . 'templates/' . $app->getTemplate() . '/wright/images/logo.png';
			}
			break;

		// Extract image from a published module in "logo" position
		case 'module':

			$db = JFactory::getDbo();

			$query = $db->getQuery(true);
			$query->select($db->quoteName('content'))
				->from($db->quoteName('#__modules'))
				->where(
					$db->quoteName('position') . ' LIKE '. $db->quote('logo')
					. ' AND ' . $db->quoteName('published') . ' = '. $db->quote(1)
					. ' AND ' . $db->quoteName('module') . ' LIKE '. $db->quote('mod_custom')
				)
				->setLimit('1');
			$db->setQuery($query);
			$logo_module = $db->loadResult();

			preg_match_all(
				'|<img.*?src=[\'"](.*?)[\'"].*?>|i',
				$logo_module,
				$matches
			);

			$site_logo = filter_var(
				JURI::base() . str_replace(JURI::base(), '', $matches[1][0]),
				FILTER_SANITIZE_STRING
			);
			break;

		// No logo image! Just text
		case 'title':
			$site_logo = '';
			break;
	}

	return $site_logo;
}
