<?php
/**
 * @package     Wright
 * @subpackage  HTML Layouts
 *
 * @copyright   Copyright (C) 2005 - 2018 Joomlashack.  All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access.
defined('_JEXEC') or die;

$app = JFactory::getApplication();

require_once(JPATH_THEMES.'/'.$app->getTemplate().'/'.'wright'.'/'.'html'.'/'.'overrider.php');
include(Overrider::getOverride('lyt.joomla.content.intro_image'));
?>