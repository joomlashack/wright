<?php
/**
 * @package     Wright
 * @subpackage  Overrider
 *
 * @copyright   Copyright (C) 2005 - 2018 Joomlashack.  All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access.
defined('_JEXEC') or die;
$app = JFactory::getApplication();

$wrightMaxColumns       = 4;  // Max number of columns in horizontal layout
$wrightEnableIntroText  = $params->get('show_introtext', 1); // Display intro text

require_once(JPATH_THEMES.'/'.$app->getTemplate().'/'.'wright'.'/'.'html'.'/'.'overrider.php');
require(Overrider::getOverride('mod_articles_news','horizontal'));
