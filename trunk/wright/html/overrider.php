<?php

class Overrider
{
	public $version;

	public function getVersion()
	{
		if (!isset($this->version)) {
			jimport('joomla.version');
			$version = new JVersion();
			$this->version = strtolower(ereg_replace("[^A-Za-z0-9_.]", "", $version->PRODUCT.'_'.$version->RELEASE ));
		}

		return $this->version;
	}

	public function getOverride($extension, $layout = 'default')
	{
		$type = substr($extension, 0, 3);

		$file = '';

		$app =& JFactory::getApplication();

		switch ($type)
		{
			case 'mod' :
				if (is_file(JPATH_THEMES.DS.$app->getTemplate().DS.'html'.DS.$extension.DS.self::getVersion().'.php'))
					$file = JPATH_THEMES.DS.$app->getTemplate().DS.'html'.DS.$extension.DS.self::getVersion().'.php';
				elseif (is_file(JPATH_THEMES.DS.$app->getTemplate().DS.'wright'.DS.'html'.DS.self::getVersion().DS.$extension.DS.$layout.'.php'))
					$file = JPATH_THEMES.DS.$app->getTemplate().DS.'wright'.DS.'html'.DS.self::getVersion().DS.$extension.DS.$layout.'.php';
				break;

			case 'com' :
				list($folder, $view) = explode('.', $extension);
				if (is_file(JPATH_THEMES.DS.$app->getTemplate().DS.'html'.DS.$folder.DS.$view.DS.self::getVersion().'.php'))
					$file = JPATH_THEMES.DS.$app->getTemplate().DS.'html'.DS.$folder.DS.$view.DS.self::getVersion().'.php';
				elseif (is_file(JPATH_THEMES.DS.$app->getTemplate().DS.'wright'.DS.'html'.DS.self::getVersion().DS.$folder.DS.$view.DS.$layout.'.php'))
					$file = JPATH_THEMES.DS.$app->getTemplate().DS.'wright'.DS.'html'.DS.self::getVersion().DS.$folder.DS.$view.DS.$layout.'.php';
				break;
		}
		return $file;
	}
}