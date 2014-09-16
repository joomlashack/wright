<?php
/**
 * @package     Wright
 * @subpackage  Main package
 *
 * @copyright   Copyright (C) 2005 - 2014 Joomlashack. Meritage Assets.  All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die('You are not allowed to directly access this file');

if (version_compare(JVERSION, '3.0', 'lt')) {
	// check for PHP 5.2.4 if Joomla < 3.0
	if (version_compare(PHP_VERSION, '5.2.4', 'lt')) {
		print 'You are using an out of date version of PHP, version ' . PHP_VERSION . ' and Joomla 2.5 requires PHP 5.2.4 or greater. Please contact your host to use PHP 5.2.4 or greater (Joomla 5.3+ recommended).
			<br />Please check Joomla requirements in <a href="http://www.joomla.org/technical-requirements.html">http://www.joomla.org/technical-requirements.html</a>';
		die();
	}
}
else {
	// check for PHP 5.3.1 if Joomla >= 3.0
	if (version_compare(PHP_VERSION, '5.3.1', 'lt')) {
		print 'You are using an out of date version of PHP, version ' . PHP_VERSION . ' and Joomla 3.x requires PHP 5.3.1 or greater. Please contact your host to use PHP 5.3.1 or greater.
			<br />Please check Joomla requirements in <a href="http://www.joomla.org/technical-requirements.html">http://www.joomla.org/technical-requirements.html</a>';
		die();
	}
}

// includes WrightTemplateBase class for customizations to the template
require_once(dirname(__FILE__) .'/'. 'template' .'/'. 'wrighttemplatebase.php');


class Wright
{
	public $template;
	public $document;
	public $adapter;
	public $params;
	public $baseurl;
	public $author;

	public $revision = "{version}";

	function Wright()
	{
		// Initialize properties
		$document = JFactory::getDocument();
		$app = JFactory::getApplication();
		$this->document = $document;
		$this->params = $document->params;
		$this->baseurl = $document->baseurl;
		$this->author = simplexml_load_file(JPATH_BASE .'/'. 'templates' .'/'. $this->document->template .'/'. 'templateDetails.xml')->author;

		if (is_file(JPATH_THEMES .'/'. $document->template .'/'. 'functions.php'))
			include_once(JPATH_THEMES .'/'. $document->template .'/'. 'functions.php');

		// Get our template for further parsing, if custom file is found
		// it will use it instead of the default file
		$path = JPATH_THEMES .'/'. $document->template .'/'. 'template.php';
		$menu = $app->getMenu();

		// If homepage, load up home.php if found
        if (version_compare(JVERSION, '1.6', 'lt')) {
            if ($menu->getActive() == $menu->getDefault() && is_file(JPATH_THEMES .'/'. $document->template .'/'. 'home.php'))
                $path = JPATH_THEMES .'/'. $document->template .'/'. 'home.php';
            elseif (is_file(JPATH_THEMES .'/'. $document->template .'/'. 'custom.php'))
                $path = JPATH_THEMES .'/'. $document->template .'/'. 'custom.php';
        }
        else {
            $lang = JFactory::getLanguage();
            if ($menu->getActive() == $menu->getDefault($lang->getTag()) && is_file(JPATH_THEMES .'/'. $document->template .'/'. 'home.php'))
                $path = JPATH_THEMES .'/'. $document->template .'/'. 'home.php';
            elseif (is_file(JPATH_THEMES .'/'. $document->template .'/'. 'custom.php'))
                $path = JPATH_THEMES .'/'. $document->template .'/'. 'custom.php';
        }


		// Include our file and capture buffer
		ob_start();
		include($path);
		$this->template = ob_get_contents();
		ob_end_clean();
	}

	static function getInstance()
	{
		static $instance = null;
		if ($instance === null)
		{
			$instance = new Wright();
		}

		return $instance;
	}

	public function display()
	{
		// Setup the header
		$this->header();

		// Parse by platform
		$this->platform();

		// Parse by doctype
		$this->doctype();

		print trim($this->template);

		return true;
	}

	public function header()
	{
		// Remove mootools if set
		if ($this->document->params->get('mootools', '1') == '0')
		{
			$dochead = $this->document->getHeadData();
			reset($dochead['scripts']);
			foreach ($dochead['scripts'] as $script => $type)
			{
				if (strpos($script, 'media/system/js/caption.js') || strpos($script, 'media/system/js/mootools.js') || strpos($script, 'media/system/js/mootools-core.js') || strpos($script, 'media/system/js/mootools-more.js'))
				{
					unset($dochead['scripts'][$script]);
				}
			}
			$this->document->setHeadData($dochead);
		}

		// Add header script if set
		if (trim($this->document->params->get('headerscript', '')) !== '')
		{
            $this->document->addScriptDeclaration($this->document->params->get('headerscript'));
		}

		// set custom template theme for user
		$user = JFactory::getUser();
		if (!is_null(JRequest::getVar('templateTheme', NULL)))
		{
			$user->setParam('theme', JRequest::getVar('templateTheme'));
			$user->save(true);
		}
		if ($user->getParam('theme'))
		{
			$this->document->params->set('style', $user->getParam('theme'));
		}

		// Build css
		$this->css();
	}

	private function css()
	{
		$styles = $this->loadCSSList();

		if ($this->document->params->get('csscache', 'no') == 'yes' && is_writable(JPATH_THEMES .'/'. $this->document->template .'/'. 'css'))
		{
			$this->processCSSCache($styles);
		}
		else
		{
			$this->addCSSToHead($styles);
		}
	}

	private function processCSSCache($styles)
	{
		// Combine css into one file if files have been altered since cached copy
		$rebuild = false;

		if (is_file(JPATH_THEMES .'/'. $this->document->template .'/'. 'css' .'/'. $this->document->template . '.css'))
			$cachetime = filemtime(JPATH_THEMES .'/'. $this->document->template .'/'. 'css' .'/'. $this->document->template . '.css');
		else
			$cachetime = 0;

		foreach ($styles as $folder => $files)
		{
			if (count($files))
			{
				foreach ($files as $style)
				{
					if ($folder == 'wright')
						$file = JPATH_THEMES .'/'. $this->document->template .'/'. 'wright' .'/'. 'css' .'/'. $style;
					elseif ($folder == 'template')
						$file = JPATH_THEMES .'/'. $this->document->template .'/'. 'css' .'/'. $style;
					else
						$file = JPATH_THEMES .'/'. $this->document->template .'/'. 'css' .'/'. $style;

					if (filemtime($file) > $cachetime)
						$rebuild = true;
				}
			}
		}

		if ($rebuild)
		{
			$css = '';
			foreach ($styles as $folder => $files)
			{
				if (count($files))
				{
					foreach ($files as $style)
					{
						if ($folder == 'wright')
							$css .= file_get_contents(JPATH_THEMES .'/'. $this->document->template .'/'. 'wright' .'/'. 'css' .'/'. $style);
						elseif ($folder == 'template')
							$css .= file_get_contents(JPATH_THEMES .'/'. $this->document->template .'/'. 'css' .'/'. $style);
						else
							$css .= file_get_contents(JPATH_THEMES .'/'. $this->document->template .'/'. 'css' .'/'. $style);
					}
				}
			}

			// Clean out any charsets
			$css = str_replace('@charset "utf-8";', '', $css);
			// Strip comments
			$css = preg_replace('/\/\*.*?\*\//s', '', $css);

			include('css' .'/'. 'csstidy' .'/'. 'class.csstidy.php');

			$tidy = new csstidy();
			$tidy->parse($css);

			file_put_contents(JPATH_THEMES .'/'. $this->document->template .'/'. 'css' .'/'. $this->document->template . '.css', $tidy->print->plain());
		}
		$this->document->addStyleSheet(JURI::root().'templates/' . $this->document->template . '/css/' . $this->document->template . '.css');
	}

	private function addCSSToHead($styles)
	{
		foreach ($styles as $folder => $files)
		{
			if (count($files))
			{
				foreach ($files as $style)
				{
					if ($folder == 'wright')
						$sheet = JURI::root().'templates/' . $this->document->template . '/wright/css/' . $style;
					elseif ($folder == 'template')
						$sheet = JURI::root().'templates/' . $this->document->template . '/css/' . $style;
					elseif ($folder == 'fontawesome')
						$sheet = JURI::root().'templates/' . $this->document->template . '/wright/fontawesome/css/' . $style;
					else
						$sheet = JURI::root().'templates/' . $this->document->template . '/css/' . $style;

					$this->document->addStyleSheet($sheet);
				}
			}
		}
	}

	private function loadCSSList()
	{
		jimport('joomla.filesystem.file');
		jimport('joomla.filesystem.folder');
		jimport('joomla.environment.browser');

		$browser = JBrowser::getInstance();

		$styles['fontawesome'] = array('font-awesome.min.css');

		// Load stylesheets by scanning directory for any prefixed with an number and underscore: 1_***.cs
		$styles['wright'] = array('reset.css', 'layout.css', 'typography.css');

		$fileFound = false;
		$version = explode('.', JVERSION);
		$subversion = $version[1];
		while (!$fileFound && $subversion >= 0) {
			$versioncss = $version[0].$subversion;
			if (is_file(JPATH_THEMES .'/'. $this->document->template .'/wright/css/joomla'.$versioncss.'.css'))
			{
				$styles['wright'][] = 'joomla'.$versioncss.'.css';
				$fileFound = true;
			}
			else
				$subversion--;
		}

		$styles['template'] = JFolder::files(JPATH_THEMES .'/'. $this->document->template .'/'. 'css', '\d{1,2}_.*.css');

		// Load up a specific style if set
		if (is_file(JPATH_THEMES .'/'. $this->document->template .'/'. 'css' .'/'. 'style-' . $this->document->params->get('style') . '.css'))
			$styles['template'][] = 'style-' . $this->document->params->get('style') . '.css';

		if ($this->document->params->get('mootools', '1') == '1')
			$this->document->addScript(JURI::root().'templates/' . $this->document->template . '/wright/js/utils.js');

		// Add some stuff for lovely IE if needed
		if ($browser->getBrowser() == 'msie')
		{
			// Switch to allow specific versions of IE to have additional sheets
			$major = $browser->getMajor();

			if ((int)$major <= 9) {
				$this->document->addScript(JURI::root().'templates/' . $this->document->template . '/wright/js/html5shiv.js');
			}

			if (is_file(JPATH_THEMES . '/' . $this->document->template . '/css/ie.css'))
			{
				$styles['ie'][] = 'ie.css';
			}

			switch ($major)
			{
				case '6' :
					if (is_file(JPATH_THEMES . '/' . $this->document->template . '/css/ie6.css'))
						$styles['ie'][] = 'ie6.css';
					$this->document->addScript(JURI::root().'templates/' . $this->document->template . '/wright/js/dd_belatedpng.js');
				case '7' :
					$styles['fontawesome'][] = 'font-awesome-ie7.min.css';
					// does not break for leaving defaults
				default :
					if (is_file(JPATH_THEMES . '/' . $this->document->template . '/css/ie' . $major . '.css'))
						$styles['ie'][] = 'ie' . $major . '.css';
			}
		}


		if ($this->document->direction == 'rtl' && is_file(JPATH_THEMES .'/'. $this->document->template .'/'. 'css' .'/'. 'rtl.css'))
			$styles['template'][] = 'rtl.css';

		//Check to see if custom.css file is present, and if so add it after all other css files
			if (is_file(JPATH_THEMES .'/'. $this->document->template .'/'. 'css' .'/'. 'custom.css'))
				$styles['template'][] = 'custom.css';

		return $styles;
	}

	private function doctype()
	{
		require(dirname(__FILE__) .'/'. 'doctypes' .'/'. $this->document->params->get('doctype', 'html5') . '.php');
		$adapter_name = 'HtmlAdapter' . $this->document->params->get('doctype', 'html5');
		$adapter = new $adapter_name($this->document->params);

		foreach ($adapter->getTags() as $name => $regex)
		{
			$action = 'get' . ucfirst($name);
			$this->template = preg_replace_callback($regex, array($adapter, $action), $this->template);
		}

        if (trim($this->document->params->get('footerscript')) != '') {
            $this->template = str_replace('</body>', '<script type="text/javascript">'.$this->document->params->get('footerscript').'</script></body>', $this->template);
        }
		$this->template = str_replace('__cols__', $adapter->cols, $this->template);
	}

	/**
	 * Searches for platform specific tags, and has a callback function to
	 * handle the processing of each match
	 *
	 * @access private
	 */
	private function platform()
	{
		// Get Joomla's version to get proper platform
		jimport('joomla.version');
		$version = new JVersion();
		$file = ucfirst(str_replace('.', '', $version->RELEASE));

		// Load up the proper adapter
		require_once(dirname(__FILE__) .'/'. 'adapters' .'/'. 'joomla.php');
		$this->adapter = new WrightAdapterJoomla($file);
		$this->template = preg_replace_callback("/<w:(.*)\/>/i", array(get_class($this), 'platformTags'), $this->template);
		return true;
	}

	private function platformTags($matches)
	{
		// Grab first match since there should only be one
		$match = $matches[1];

		// @TODO Craft a regex to better handle syntax possibilities
		if (strpos($match, '='))
		{
			$tag = substr($match, 0, strpos($match, ' '));
			$list = explode('" ', substr($match, trim(strpos($match, ' ') + 1)));

			$attributes = array();

			foreach ($list as $item)
			{
				if (strlen($item) > strrchr($item, '"'))
				{
					$name = substr($item, 0, strpos($item, '='));
					$value = substr($item, strpos($item, '"') + 1);
					$attributes[$name] = $value;
				}
			}
			$config = array(trim($tag) => $attributes);
		}
		else
		{
			$config = array(trim($match) => array());
		}
		return $this->adapter->get($config);
	}

	// Borrowed from JDocumentHtml for compatibility
	function countModules($condition)
	{
		jimport('joomla.application.module.helper');

		$result = '';
		$words = explode(' ', $condition);
		for ($i = 0; $i < count($words); $i+=2)
		{
			// odd parts (modules)
			$name = strtolower($words[$i]);
			$words[$i] = ((isset($this->_buffer['modules'][$name])) && ($this->_buffer['modules'][$name] === false)) ? 0 : count(JModuleHelper::getModules($name));
		}

		$str = 'return ' . implode(' ', $words) . ';';

		return eval($str);
	}

}
