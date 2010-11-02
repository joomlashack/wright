<?php

$app =& JFactory::getApplication();

require_once(JPATH_THEMES.DS.$app->getTemplate().DS.'html'.DS.'overrider.php');
$version = Overrider::getVersion();
if ($version == 'joomla_1.5') require_once(dirname(__FILE__).DS.$version.DS.'form.php');
else require_once(dirname(__FILE__).DS.$version.DS.'edit.php');