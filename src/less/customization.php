<?php
/**
 * @package     Wright
 * @subpackage  Template File
 *
 * @copyright   Copyright (C) 2005 - 2019 Joomlashack.   All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 *
 */

// No direct access
defined('_JEXEC') or die('Restricted access');

//$linkColor = $document->params->get('style', 'linkColor');

// Set your variables overrides for LESS with only CSS valid values - As example: HEX colors, width/height
// If the variable is '@variableName', remove @ - As example: '@color_one' becomes 'color_one'
$lessCustomizationVars = array (
    '@linkColor' => '#336699'
);

// Set the default template style. It will be used to compile the CSS using the variables above
$style = 'generic';