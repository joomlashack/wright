<?php
/**
 * @package     Wright
 * @subpackage  Component File
 *
 * @copyright   Copyright (C) 2005 - 2019 Joomlashack.   All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

// Restrict Access to within Joomla
defined('_JEXEC') or die('Restricted access');


// Include the framework
require_once dirname(__FILE__) . '/wright/wright.php';

// Initialize the framework and include header
$tpl = Wright::getInstance();
$tpl->renderCustomStyle();