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

// Access template parameters
$document = JFactory::getDocument();

// Set your variables overrides for variables-something.less.
// These variables overrides are defined on templateDetails.xml below 'style' field
$lessCustomizationVars = array (
    '@linkColor' => $document->params->get('linkColor', '#08c')
);

// Set the default template style. This is defined on templateDetails.xml as default value for 'style' field
$style = 'generic';

// Don't touch the code below
require_once dirname(__FILE__) . '/../wright/build/less/compiler.php';
$build = new WrightLessCompiler;
$build->start($style, $lessCustomizationVars);