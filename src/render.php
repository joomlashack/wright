<?php
/**
 * @package     Wright
 * @subpackage  Component File
 *
 * @copyright   Copyright (C) 2005 - 2020 Joomlashack. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

// Restrict Access to within Joomla
defined('_JEXEC') or die('Restricted access');

$app = JFactory::getApplication();

require_once(JPATH_THEMES.'/'.$app->getTemplate().'/wright/build/render.php');
?>