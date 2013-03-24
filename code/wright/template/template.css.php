<?php
// Set flag that this is a parent file.
define('_JEXEC', 1);
define('DS', DIRECTORY_SEPARATOR);

if (!defined('_JDEFINES')) {
	define('JPATH_BASE', dirname(__FILE__).'/../../../..');
	define('JPATH_SITE', JPATH_BASE);
	require_once JPATH_BASE.'/includes/defines.php';
}

require_once JPATH_BASE.'/includes/framework.php';

$app = JFactory::getApplication('site');
$app->initialise();

$version = explode('.', JVERSION);
$version = $version[0].$version[1];

$template = $app->getTemplate(true);
$style = $template->params->get('style','generic');

header("Content-Type: text/css");
echo file_get_contents(JPATH_THEMES . '/' . $template->template . '/css/joomla' . $version . '-' . $style . '.css','r');