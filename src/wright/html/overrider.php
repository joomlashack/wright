<?php
/**
 * @package     Wright
 * @subpackage  Overrider
 *
 * @copyright   Copyright (C) 2005 - 2019 Joomlashack.   All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;
include_once(JPATH_THEMES.'/'.JFactory::getApplication()->getTemplate().'/wright/html/libraries/wrighthtml.php');
include_once(JPATH_THEMES.'/'.JFactory::getApplication()->getTemplate().'/wright/html/jlayouthelper.php');

class Overrider
{
	static $version;

	public static function getVersion()
	{
		if (!isset(self::$version)) {
			jimport('joomla.version');
			$version = new JVersion();
			self::$version = explode('.', JVERSION);
		}

		return self::$version;
	}

	public static function getOverride($extension, $layout = 'default', $strictOverride = false)
	{
		$type = substr($extension, 0, 3);

		$file = '';

		$app = JFactory::getApplication();

        $version = self::getVersion();

		switch ($type)
		{
			case 'mod' :
				$fileFound = false;
				$subversion = $version[1];
				while (!$fileFound && $subversion >= 0) {
	                if (is_file(JPATH_THEMES.'/'.$app->getTemplate().'/'.'overrides'.'/'.'joomla_'.$version[0].'.'.$subversion.'/'.$extension.'/'.$layout.'.php')) {
	                	$fileFound = true;
						$file = JPATH_THEMES.'/'.$app->getTemplate().'/'.'overrides'.'/'.'joomla_'.$version[0].'.'.$subversion.'/'.$extension.'/'.$layout.'.php';
	                }
                    elseif (is_file(JPATH_THEMES.'/'.$app->getTemplate().'/'.'wright'.'/'.'html'.'/'.'joomla_'.$version[0].'.'.$subversion.'/'.$extension.'/'.$layout.'.php')) {
                        $fileFound = true;
                        $file = JPATH_THEMES.'/'.$app->getTemplate().'/'.'wright'.'/'.'html'.'/'.'joomla_'.$version[0].'.'.$subversion.'/'.$extension.'/'.$layout.'.php';
                    }
                    else {
                        // Nothing to do here
                    }
	                $subversion--;
				}
				if (!$fileFound) {
					if ($strictOverride) return false;
					$file = JPATH_SITE.'/modules/'.$extension.'/tmpl/'.$layout.'.php';
				}
				break;

			case 'com' :
				// overriding components: 'com_xx.yy','zz' => (components/com_xx/tmpl/yy/zz.php)
				$fileFound = false;
				$subversion = $version[1];
				list($folder, $view) = explode('.', $extension);
				while (!$fileFound && $subversion >= 0) {
	                if (is_file(JPATH_THEMES.'/'.$app->getTemplate().'/'.'overrides'.'/'.'joomla_'.$version[0].'.'.$subversion.'/'.$folder.'/'.$view.'/'.$layout.'.php')) {
                        $fileFound = true;
                        $file = JPATH_THEMES.'/'.$app->getTemplate().'/'.'overrides'.'/'.'joomla_'.$version[0].'.'.$subversion.'/'.$folder.'/'.$view.'/'.$layout.'.php';
	                }
	                elseif (is_file(JPATH_THEMES.'/'.$app->getTemplate().'/'.'wright'.'/'.'html'.'/'.'joomla_'.$version[0].'.'.$subversion.'/'.$folder.'/'.$view.'/'.$layout.'.php')) {
	                	$fileFound = true;
						$file = JPATH_THEMES.'/'.$app->getTemplate().'/'.'wright'.'/'.'html'.'/'.'joomla_'.$version[0].'.'.$subversion.'/'.$folder.'/'.$view.'/'.$layout.'.php';
	                }
	                else {
                        // Nothing to do here
	                }
	                $subversion--;
				}
				if (!$fileFound) {
					if ($strictOverride) return false;

					// Default path for components tmpl in Joomla 3
					if (version_compare(JVERSION, '4', 'lt')) {
						$file = JPATH_SITE.'/components/'.$folder.'/views/'.$view.'/tmpl/'.$layout.'.php';
					}
					// Default path for components tmpl in Joomla 4
					else {
						$file = JPATH_SITE.'/components/'.$folder.'/tmpl/'.$view.'/'.$layout.'.php';
					}
				}
				break;

			case 'lyt' :
				// overriding layouts (Joomla 3.1+): lyt_xx.yy.zz (joomla/content/info_block)
				$fileFound = false;
				$override = str_replace('.', '/', substr($extension, 4));
				$subversion = $version[1];
				while (!$fileFound && $subversion >= 0) {
	                if (is_file(JPATH_THEMES.'/'.$app->getTemplate().'/'.'overrides'.'/'.'joomla_'.$version[0].'.'.$subversion.'/layouts/'.$override.'.php')) {
                        $fileFound = true;
                        $file = JPATH_THEMES.'/'.$app->getTemplate().'/'.'overrides'.'/'.'joomla_'.$version[0].'.'.$subversion.'/layouts/'.$override.'.php';
	                }
	                elseif (is_file(JPATH_THEMES.'/'.$app->getTemplate().'/'.'wright'.'/'.'html'.'/'.'joomla_'.$version[0].'.'.$subversion.'/layouts/'.$override.'.php')) {
                        $fileFound = true;
                        $file = JPATH_THEMES.'/'.$app->getTemplate().'/'.'wright'.'/'.'html'.'/'.'joomla_'.$version[0].'.'.$subversion.'/layouts/'.$override.'.php';
	                }
	                else {
                        // Nothing to do here
	                }
	                $subversion--;
				}
				if (!$fileFound) {
					if ($strictOverride) return false;
					$file = JPATH_SITE.'/layouts/'.$override.'.php';
				}
				break;

            case 'plg' :
				// overriding plugins (Joomla 4.0+): 'plg.xx.yy', 'zz' (plugins/xx/yy/tmpl/zz.php)
                $fileFound = false;
                $override = str_replace('.', '_', substr($extension, 4));
                $subversion = $version[1];

                while (!$fileFound && $subversion >= 0) {
                    // Load core Wright override
                    if (is_file(JPATH_THEMES.'/'.$app->getTemplate().'/'.'overrides'.'/'.'joomla_'.$version[0].'.'.$subversion.'/plg_'.$override.'/'.$layout.'.php')) {
                        $fileFound = true;
                        $file = JPATH_THEMES.'/'.$app->getTemplate().'/'.'overrides'.'/'.'joomla_'.$version[0].'.'.$subversion.'/plg_'.$override.'/'.$layout.'.php';
                    }
                    // Load override from 'overrides' folder
                    elseif (is_file(JPATH_THEMES.'/'.$app->getTemplate().'/'.'wright'.'/'.'html'.'/'.'joomla_'.$version[0].'.'.$subversion.'/plg_'.$override.'/'.$layout.'.php')) {
                        $fileFound = true;
                        $file = JPATH_THEMES.'/'.$app->getTemplate().'/'.'wright'.'/'.'html'.'/'.'joomla_'.$version[0].'.'.$subversion.'/plg_'.$override.'/'.$layout.'.php';
                    }
                    else {
                        // Nothing to do here
                    }
                    $subversion--;
                }

                // No template override. Load core view.
                if (!$fileFound) {
                    if ($strictOverride) return false;
                    $override = str_replace('_', '/', $override);
                    $file = JPATH_SITE.'/plugins/'.$override.'/tmpl/'.$layout.'.php';
                }
                break;
		}
		return $file;
	}
}
