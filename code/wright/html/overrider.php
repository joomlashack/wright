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
                if (is_file(JPATH_THEMES.'/'.$app->getTemplate().'/'.'wright'.'/'.'html'.'/'.'joomla_'.implode('.', $version).'/'.$extension.'/'.$layout.'.php'))
					$file = JPATH_THEMES.'/'.$app->getTemplate().'/'.'wright'.'/'.'html'.'/'.'joomla_'.implode('.', $version).'/'.$extension.'/'.$layout.'.php';
				else
					$file = JPATH_SITE.'/modules/'.$extension.'/tmpl/'.$layout.'.php';
				break;

			case 'com' :
				list($folder, $view) = explode('.', $extension);
                if (is_file(JPATH_THEMES.'/'.$app->getTemplate().'/'.'wright'.'/'.'html'.'/'.'joomla_'.implode('.', $version).'/'.$folder.'/'.$view.'/'.$layout.'.php'))
					$file = JPATH_THEMES.'/'.$app->getTemplate().'/'.'wright'.'/'.'html'.'/'.'joomla_'.implode('.', $version).'/'.$folder.'/'.$view.'/'.$layout.'.php';
				else
					$file = JPATH_SITE.'/components/'.$folder.'/views/'.$view.'/tmpl/'.$layout.'.php';		
				break;
		}
		return $file;
	}
}
