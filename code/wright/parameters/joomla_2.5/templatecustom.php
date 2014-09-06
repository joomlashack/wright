<?php
/**
 * @package     Wright
 * @subpackage  Parameters
 *
 * @copyright   Copyright (C) 2005 - 2014 Joomlashack. Meritage Assets.  All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

// Restrict Access to within Joomla
defined('_JEXEC') or die('Restricted access');

if (file_exists(realpath(dirname(__FILE__) . '/../../../parameters/templatecustom.php')))
{
	require_once realpath(dirname(__FILE__) . '/../../../parameters/templatecustom.php');
}
else
{
	require_once realpath(dirname(__FILE__)) . '/templatecustomclass.php';
}
