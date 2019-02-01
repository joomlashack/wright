<?php
/**
 * @package     Wright
 * @subpackage  Template File
 *
 * @copyright   Copyright (C) 2005 - 2019 Joomlashack.   All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

define('_JEXEC', 1);

define('JPATH_BASE', __DIR__ . '/../../../..');

if (file_exists(JPATH_BASE . '/includes/defines.php'))
{
    include_once JPATH_BASE . '/includes/defines.php';
    echo 'defines! ';
}

if (file_exists(JPATH_BASE . '/includes/framework.php'))
{
    require_once JPATH_BASE . '/includes/framework.php';
    echo 'framework! ';
}

$app        = JFactory::getApplication('site');
$template   = $app->getTemplate(true);
$params     = $template->params;

if ($params->get('style', 'custom'))
{
    require_once dirname(__FILE__) . '/less/compiler.php';
    $build = new WrightLessCompiler;
    $build->start();
    echo $params->get('style', 'custom');
}