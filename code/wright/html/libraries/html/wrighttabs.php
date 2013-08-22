<?php
/**
 * @package     Wright
 * @subpackage  Overrider
 *
 * @copyright   Copyright (C) 2005 - 2013 Joomlashack. Meritage Assets.  All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('JPATH_PLATFORM') or die;

require_once(JPATH_PLATFORM . '/joomla/html/html/tabs.php');

abstract class JHtmlWrightTabs extends JHtmlTabs
{
	public static function start($group = 'tabs', $params = array())
	{
		self::_loadBehavior($group, $params);

		return '<dl class="tabs nav nav-tabs" id="' . $group . '"><dt style="display:none;"></dt><dd style="display:none;">';  // Wright v.3: Added nav nav-tabs classes
	}

	public static function panel($text, $id)
	{
		return '</dd><dt class="tabs ' . $id . '"><span><h3><a href="javascript:void(0);">' . $text . '</a></h3></span></dt><dd class="tabs nav nav-tabs">';  // Wright v.3: Added nav nav-tabs classes
	}

}