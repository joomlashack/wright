<?php
defined('_JEXEC') or die('Restricted access');

// Include default pagination
$app =& JFactory::getApplication();
include(JPATH_THEMES.DS.$app->getTemplate().DS.'html'.DS.'overrides'.DS.'pagination.php');