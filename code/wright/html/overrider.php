<?php

class Overrider
{
	static $version;

	public static function getVersion()
	{
		if (!isset(self::$version)) {
			jimport('joomla.version');
			$version = new JVersion();
			self::$version = explode('.', $version->RELEASE);
		}

		return self::$version;
	}

	public static function getOverride($extension, $layout = 'default')
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
	                if (is_file(JPATH_THEMES.'/'.$app->getTemplate().'/'.'wright'.'/'.'html'.'/'.'joomla_'.$version[0].'.'.$subversion.'/'.$extension.'/'.$layout.'.php')) {
	                	$fileFound = true;
						$file = JPATH_THEMES.'/'.$app->getTemplate().'/'.'wright'.'/'.'html'.'/'.'joomla_'.$version[0].'.'.$subversion.'/'.$extension.'/'.$layout.'.php';
	                }
	                $subversion--;
				}
				if (!$fileFound)
					$file = JPATH_SITE.'/modules/'.$extension.'/tmpl/'.$layout.'.php';
				break;

			case 'com' :
				$fileFound = false;
				$subversion = $version[1];
				list($folder, $view) = explode('.', $extension);
				while (!$fileFound && $subversion >= 0) {
	                if (is_file(JPATH_THEMES.'/'.$app->getTemplate().'/'.'wright'.'/'.'html'.'/'.'joomla_'.$version[0].'.'.$subversion.'/'.$folder.'/'.$view.'/'.$layout.'.php')) {
	                	$fileFound = true;
						$file = JPATH_THEMES.'/'.$app->getTemplate().'/'.'wright'.'/'.'html'.'/'.'joomla_'.$version[0].'.'.$subversion.'/'.$folder.'/'.$view.'/'.$layout.'.php';
	                }
	                $subversion--;
				}
				if (!$fileFound)
					$file = JPATH_SITE.'/components/'.$folder.'/views/'.$view.'/tmpl/'.$layout.'.php';		
				break;
		}
		return $file;
	}
}
