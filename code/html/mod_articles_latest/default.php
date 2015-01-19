<?php
/**
 * @package     Wright
 * @subpackage  Overrider
 *
 * @copyright   Copyright (C) 2005 - 2015 Joomlashack. Meritage Assets.  All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access.
defined('_JEXEC') or die;
$app = JFactory::getApplication();

// Adds nav nav-list to the list, to give it a menu-type look
$wrightAddNavs = true;

// Adds an icon to each article
$wrightAddIcon = true;

require_once JPATH_THEMES . '/' . $app->getTemplate() . '/wright/html/overrider.php';
require Overrider::getOverride('mod_articles_latest');
