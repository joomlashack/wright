<?php

$app =& JFactory::getApplication();

require_once(JPATH_THEMES.DS.$app->getTemplate().DS.'html'.DS.'overrider.php');
$version = Overrider::getVersion();
require_once(dirname(__FILE__).DS.$version.DS.'form.php');