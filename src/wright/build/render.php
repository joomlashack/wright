<?php
/**
 * @package     Wright
 * @subpackage  Template File
 *
 * @copyright   Copyright (C) 2005 - 2020 Joomlashack. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 *
 */

// Restrict Access to within Joomla
defined('_JEXEC') or die('Restricted access');

$app = JFactory::getApplication();

if($app->input->get('c') == 1) {

    // Include the framework
    require_once JPATH_THEMES.'/'.$app->getTemplate().'/wright/wright.php';

    // Initialize the framework and render custom style
    $tpl = Wright::getInstance();
    $tpl->renderCustomStyle();
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta name="robots" content="noindex,nofollow">
</head>
<body>
</body>
</html>
