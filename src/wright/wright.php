<?php
/**
 * @package     Wright
 * @subpackage  Main package
 *
 * @copyright   Copyright (C) 2005 - 2018 Joomlashack.  All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die('You are not allowed to directly access this file');

use Joomla\CMS\HTML\HTMLHelper;

if (version_compare(JVERSION, '3.0', 'lt'))
{
	// Check for PHP 5.2.4 if Joomla < 3.0
	if (version_compare(PHP_VERSION, '5.2.4', 'lt'))
	{
		print 'You are using an out of date version of PHP, version ' . PHP_VERSION . ' and Joomla 2.5 requires PHP 5.2.4 or greater. Please contact your host to use PHP 5.2.4 or greater (Joomla 5.3+ recommended).
			<br />Please check Joomla requirements in <a href="http://www.joomla.org/technical-requirements.html">http://www.joomla.org/technical-requirements.html</a>';
		die();
	}
}
else
{
	// Check for PHP 5.3.1 if Joomla >= 3.0
	if (version_compare(PHP_VERSION, '5.3.10', 'lt'))
	{
		print 'You are using an out of date version of PHP, version ' . PHP_VERSION . ' and Joomla 3.x requires PHP 5.3.10 or greater. Please contact your host to use PHP 5.3.10 or greater.
			<br />Please check Joomla requirements in <a href="http://www.joomla.org/technical-requirements.html">http://www.joomla.org/technical-requirements.html</a>';
		die();
	}
	else
	{
	}
}

// Includes WrightTemplateBase class for customizations to the template
require_once dirname(__FILE__) . '/template/wrighttemplatebase.php';

/**
 * Main Wright class
 *
 * @package     Wright
 * @subpackage  Main Package
 * @since       1.0
 */
class Wright
{
	public $template;

	public $document;

	public $adapter;

	public $params;

	public $baseurl;

	public $author;

	public $revision = "{version}";

	private $loadBootstrap = false;

	public $_jsScripts = Array();

	public $_jsDeclarations = Array();

	// Urls
	private $_urlTemplate = null;

	private $_urlWright = null;

	private $_urlJS = null;

	private $_selectedStyle = '';

	private $_baseVersion = '';

	public $_showBrowserWarning = false;

	public $_browserCompatibility = null;

	/**
	 * Main Wright function called to create the index.php file read by Joomla
	 *
	 * @return  void
	 */
	public function __construct()
	{
		// Initialize properties
		$document = JFactory::getDocument();
		$app = JFactory::getApplication();
		$this->document = $document;
		$this->params = $document->params;
		$this->baseurl = $document->baseurl;

		if ($app->isAdmin())
		{
			// If Wright is instanciated in backend, it stops loading
			return;
		}

		// Urls
		$this->_urlTemplate = JURI::root(true) . '/templates/' . $this->document->template;
		$this->_urlWright = $this->_urlTemplate . '/wright';
		$this->_urlJS = $this->_urlWright . '/js';

		// Add JavaScript CSS and Framework
        JHtml::_('bootstrap.framework');
        JHtml::_('bootstrap.loadCss', true, $this->document->direction);

		// Browser library
		include_once JPATH_SITE . '/templates/' . $this->document->template . '/wright/includes/browser.php';

		$this->author = simplexml_load_file(JPATH_BASE . DIRECTORY_SEPARATOR . 'templates' . DIRECTORY_SEPARATOR . $this->document->template . DIRECTORY_SEPARATOR . 'templateDetails.xml')->author;

		// Body classes
		$wrightBodyClass = '';
		$wrightBodyClass .= ($this->params->get('responsive', '1') == 1 ? ' responsive' : ' no-responsive');

		// Get the bootstrap row mode ( row )
		$wrightGridMode = $this->params->get('bs_rowmode', 'row');
		$wrightContainerClass = 'container';

		// Mobile Menu Icon/Text
		$wrightMobileMenuText = $this->params->get('mobile_menu_text', '');

		if ($wrightGridMode == 'row-fluid')
		{
			$wrightContainerClass = 'container-fluid';

			// Joomla 3
			if (version_compare(JVERSION, '4', 'lt')) {
				// Nothing to do here
			}
			// Joomla 4 - row-fluid doesn't exist in Bootstrap 4
			else {
				$wrightGridMode = 'row';
			}
		}

		require_once JPATH_THEMES . DIRECTORY_SEPARATOR . $document->template . DIRECTORY_SEPARATOR . 'wrighttemplate.php';

		if (is_file(JPATH_THEMES . DIRECTORY_SEPARATOR . $document->template . DIRECTORY_SEPARATOR . 'functions.php'))
		{
			include_once JPATH_THEMES . DIRECTORY_SEPARATOR . $document->template . DIRECTORY_SEPARATOR . 'functions.php';
		}

		// Get our template for further parsing, if custom file is found
		// it will use it instead of the default file
		$path = JPATH_SITE . '/templates/' . $document->template . '/' . 'template.php';
		$menu = $app->getMenu();

		// If homepage, load up home.php if found, or load custom.php if found
		$lang = JFactory::getLanguage();
		if ($menu->getActive() == $menu->getDefault($lang->getTag()) && is_file(JPATH_SITE . '/templates/' . $document->template . '/home.php'))
			$path = JPATH_SITE . '/templates/' . $document->template . '/home.php';
		elseif (is_file(JPATH_SITE . '/templates/' . $document->template . '/custom.php'))
			$path = JPATH_SITE . '/templates/' . $document->template . '/custom.php';

		// Include our file and capture buffer
		ob_start();
		include $path;
		$this->template = ob_get_contents();
		ob_end_clean();
	}

	/**
	 * Return the selected style
	 *
	 * @return  object  Wright class
	 */
	public function getSelectedStyle()
	{
		return $this->_selectedStyle;
	}

	/**
	 * Method to get an instance of this class
	 *
	 * @return  object  Wright class
	 */
	public static function getInstance()
	{
		static $instance = null;

		if ($instance === null)
		{
			$instance = new Wright;
		}

		return $instance;
	}

	/**
	 * Get template style
	 *
	 * @return  array
	 */
	public function getTemplateStyle()
	{
		return $this->_selectedStyle;
	}

	/**
	 * Method to display the whole template index.php generated by the functions in this class
	 *
	 * @return  boolean
	 */
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

	/**
	 * Method to generate the header
	 *
	 * @return  void
	 */
	public function header()
	{
		$user = JFactory::getUser();
		$input = JFactory::getApplication()->input;

		JHtml::_('behavior.framework', true);

		if ($this->document->params->get('modal', '1') == '1')
		{
			JHtml::_('behavior.modal');
		}

		if ($this->loadBootstrap)
		{
			// Load bootstrap JS
			$this->addJSScript($this->_urlJS . '/bootstrap.min.js');
		}

		if (version_compare(JVERSION, '4', 'lt')) {

			// Javascript for Joomla 3
			$this->addJSScript($this->_urlJS . '/utils-30.js');

			if ($this->document->params->get('documentationMode', '0') == '1')
			{
				$this->addJSScript($this->_urlTemplate . '/js/prettify.js');
				$this->addJSScriptDeclaration('$window = jQuery(window); $window.prettyPrint && prettyPrint();');
			}
		}
		else {

			// Javascript for Joomla 4
			$this->addJSScript($this->_urlJS . '/utils-40.js');

			// Alerts progressive enhancement
			HTMLHelper::_(
				'webcomponent',
				'vendor/joomla-custom-elements/joomla-alert.min.js',
				[
					'relative' => true,
					'version' => 'auto',
					'detectBrowser' => false,
					'detectDebug' => false
				]
			);
		}

		// Add header script if set
		if (trim($this->document->params->get('headerscript', '')) !== '')
		{
			$this->addJSScriptDeclaration($this->document->params->get('headerscript'));
		}

		// Set custom template theme for user
		if (!is_null($input->getVar('templateTheme', null)))
		{
			$user->setParam('theme', $input->getVar('templateTheme'));
			$user->save(true);
		}

		$this->_selectedStyle = $input->getVar('templateTheme', $user->getParam('theme', $this->document->params->get('style', 'generic')));

		if (!$this->checkStyleFiles())
		{
			$this->_selectedStyle = $this->document->params->get('style', 'generic');
			$this->checkStyleFiles();
		}

		$this->browserCompatibilityCheck();

		// Build css
		$this->css();
	}

	/**
	 * Adds browser compatibility check if it's selected in the backed
	 *
	 * @return  void
	 */
	private function browserCompatibilityCheck()
	{
		if ($this->document->params->get('browsercompatibilityswitch', '0') == '1')
		{
			$session = JFactory::getSession();
			$hideWarning = $session->get('hideWarning', 0, 'WrightTemplate_' . $this->document->template);

			if (!$hideWarning)
			{
				$browser = new Browser;
				$browserName = $browser->getBrowser();
				$browserVersion = $browser->getVersion();

				$this->_browserCompatibility = json_decode($this->document->params->get('browsercompatibility', ''));

				if ($this->_browserCompatibility == '')
				{
					$this->_browserCompatibility = $this->setupDefaultBrowserCompatibility();
				}

				if (property_exists($this->_browserCompatibility, $browserName))
				{
					if (version_compare($browserVersion, $this->_browserCompatibility->$browserName->minimumVersion, 'lt'))
					{
						$this->_showBrowserWarning = true;
					}
				}
				else
				{
					$this->_showBrowserWarning = true;
				}
			}

			if ($this->_showBrowserWarning)
			{
				$this->addJSScriptDeclaration('jQuery("#wrightBCW").modal();');
				$session->set('hideWarning', 1, 'WrightTemplate_' . $this->document->template);
			}
		}
	}

	/**
	 * Method to check if the style files are available un any version of Joomla (using the $this->_selectedStyle variable)
	 *
	 * @return  boolean
	 */
	private function checkStyleFiles()
	{
		$version = explode('.', JVERSION);
		$mainversion = $version[0];
		$subversion = $version[1];

		$fileFound = false;

		while (!$fileFound && $subversion >= 0)
		{
			$this->_baseVersion = $mainversion . $subversion;

			if (file_exists(JPATH_SITE . '/templates/' . $this->document->template . '/css/joomla' . $this->_baseVersion . '-' . $this->_selectedStyle . '-extended.css'))
			{
				$fileext = $this->_urlTemplate . '/css/joomla' . $this->_baseVersion . '-' . $this->_selectedStyle . '-extended.css';
				$fileFound = true;
			}
			else
			{
				$subversion--;
			}
		}

		return $fileFound;
	}

	/**
	 * Method to display the CSS files to the header
	 *
	 * @return  void
	 */
	private function css()
	{
		$styles = $this->loadCSSList();

		$this->addCSSToHead($styles);
	}

	/**
	 * Method to add the required css files into the document
	 *
	 * @param   array  $styles  Array of styles
	 *
	 * @return  void
	 */
	private function addCSSToHead($styles)
	{
		foreach ($styles as $folder => $files)
		{
			if (count($files))
			{
				foreach ($files as $style)
				{
					switch ($folder)
					{
                        case 'wrighttemplatecss':
                            $sheet = $this->_urlWright . '/css/' . $style;
                            break;
						default:
							$sheet = $this->_urlTemplate . '/css/' . $style;
					}

					$this->document->addStyleSheet($sheet);
				}
			}
		}
	}

	/**
	 * Method to load the list of CSS files
	 *
	 * @return  void
	 */
	private function loadCSSList()
	{
		jimport('joomla.filesystem.file');
		jimport('joomla.filesystem.folder');
		jimport('joomla.environment.browser');

		$browser = JBrowser::getInstance();
		$doc = JFactory::getDocument();

		$styles = Array();

		// CSS for Joomla 3
		if (version_compare(JVERSION, '4', 'lt')) {
			$styles['template'][] = 'style-' . $this->_selectedStyle . '.css';
			$styles['template'][] = 'joomla' . $this->_baseVersion . '-' . $this->_selectedStyle . '-extended.css';

			// Load responsive CSS always
			$styles['template'][] = 'joomla' . $this->_baseVersion . '-' . $this->_selectedStyle . '-responsive.css';

			// Load Font Awesome 4
			$styles['wrighttemplatecss'][] = 'font-awesome4.min.css';

			unset($doc->_styleSheets[$this->_urlTemplate . '/css/jui/bootstrap.min.css']);
			unset($doc->_styleSheets[$this->_urlTemplate . '/css/jui/bootstrap-responsive.min.css']);
			unset($doc->_styleSheets[$this->_urlTemplate . '/css/jui/bootstrap-extended.css']);

			// @todo check in J!4 if there is an existing RTL file
			unset($doc->_styleSheets[JURI::root(true) . '/media/jui/css/bootstrap-rtl.css']);

			// Unload core bootstrap CSS files
			unset($doc->_styleSheets[JURI::root(true) . '/media/vendor/bootstrap/css/bootstrap.css']);
			unset($doc->_styleSheets[JURI::root(true) . '/media/vendor/bootstrap/css/bootstrap.min.css']);

			if ($this->document->params->get('documentationMode', '0') == '1')
			{
				$styles['template'][] = 'docs.css';
			}

			if ($this->document->direction == 'rtl' && is_file(JPATH_SITE . '/templates/' . $this->document->template . '/css/rtl.css')) {
				$styles['template'][] = 'rtl.css';
			}
		}
		// CSS for Joomla 4
		else {
			$styles['template'][] = 'joomla-' . $this->_selectedStyle . '.css';

			// Load Font Awesome 5
			$styles['wrighttemplatecss'][] = 'font-awesome5.min.css';

			// @todo Add RTL for Bootstrap 4
			// @todo Add docs.css for Bootstrap 4
			unset($doc->_styleSheets[JURI::root(true) . '/media/vendor/bootstrap/css/bootstrap.min.css']);
		}

		// Add some stuff for lovely IE if needed
		if ($browser->getBrowser() == 'msie')
		{
			// Switch to allow specific versions of IE to have additional sheets
			$major = $browser->getMajor();

			if ((int) $major <= 9)
			{
				$this->document->addScript(JURI::root() . 'templates/' . $this->document->template . '/wright/js/html5shiv.min.js');
			}

			if (is_file(JPATH_SITE . '/templates/' . $this->document->template . '/css/ie.css'))
			{
				$styles['ie'][] = 'ie.css';
			}

			if (is_file(JPATH_SITE . '/templates/' . $this->document->template . '/css/ie' . $major . '.css'))
				$styles['ie'][] = 'ie' . $major . '.css';
		}

		// Check to see if custom.css file is present, and if so add it after all other css files
		if (is_file(JPATH_SITE . '/templates/' . $this->document->template . '/css/custom.css'))
		{
			$styles['template'][] = 'custom.css';
		}

		// Check to see if custom.js file is present
		if (is_file(JPATH_SITE . '/templates/' . $this->document->template . '/js/custom.js'))
		{
			$this->addJSScript($this->_urlTemplate . '/js/custom.js');
		}

		return $styles;
	}

	/**
	 * Method to generate the document according to the doctype
	 *
	 * @return  void
	 */
	private function doctype()
	{
		require dirname(__FILE__) . '/doctypes/' . $this->document->params->get('doctype', 'html5') . '.php';
		$adapter_name = 'HtmlAdapter' . $this->document->params->get('doctype', 'html5');
		$adapter = new $adapter_name($this->document->params);

		foreach ($adapter->getTags() as $name => $regex)
		{
			$action = 'get' . ucfirst($name);
			$this->template = preg_replace_callback($regex, array($adapter, $action), $this->template);
		}

		// Reorder columns based on the order
		$this->reorderContent();

		if (trim($this->document->params->get('footerscript')) != '')
		{
			$this->template = str_replace('</body>', '<script type="text/javascript">' . $this->document->params->get('footerscript') . '</script></body>', $this->template);
		}

		$this->template = str_replace('__cols__', $adapter->cols, $this->template);
	}

	/**
	 * Searches for platform specific tags, and has a callback function to
	 * handle the processing of each match
	 *
	 * @return  boolean
	 */
	private function platform()
	{
		// Get Joomla's version to get proper platform
		jimport('joomla.version');
		$version = new JVersion;
		$file = ucfirst(str_replace('.', '', JVERSION));

		// Load up the proper adapter
		require_once dirname(__FILE__) . '/adapters/joomla.php';
		$this->adapter = new WrightAdapterJoomla($file);
		$this->template = preg_replace_callback("/<w:(.*)\/>/i", array(get_class($this), 'platformTags'), $this->template);

		return true;
	}

	/**
	 * Processes each part of the template according to the matching arrays in the tags
	 *
	 * @param   array  $matches  Matching arrays in tags
	 *
	 * @return  boolean
	 */
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

	/**
	 * Borrowed from JDocumentHtml for compatibility (to count modules)
	 *
	 * @param   string  $condition  Module position to search
	 *
	 * @return  int
	 */
	function countModules($condition)
	{
		jimport('joomla.application.module.helper');

		$result = '';
		$words = explode(' ', $condition);

		for ($i = 0; $i < count($words); $i += 2)
		{
			// Odd parts (modules)
			$name = strtolower($words[$i]);
			$words[$i] = ((isset($this->_buffer['modules'][$name])) && ($this->_buffer['modules'][$name] === false)) ? 0 : count(JModuleHelper::getModules($name));
		}

		$str = 'return ' . implode(' ', $words) . ';';

		return eval($str);
	}

	/**
	 * Reorder main content / sidebars in the order selected by the user
	 *
	 * @return  string
	 */
	private function reorderContent()
	{
		// Regular patterns to identify every column.  Added id to avoid the annoying bug that avoids the user to use HTML5 tags
		$patterns = array(  'sidebar1' => '/<aside(.*)id="sidebar1">(.*)<\/aside>/isU',
							'sidebar2' => '/<aside(.*)id="sidebar2">(.*)<\/aside>/isU',
							'main' => '/<section(.*)id="main"(.*)>(.*)<\/section>/isU'
		);

		// Only this columns
		$allowedColNames = array_keys($patterns);
		$reorderedCols = array();
		$reorderedContent = '';

		// Get column configuration
		$columnCfg = $this->document->params->get('columns', 'sidebar1:3;main:6;sidebar2:3');
		$colStrings = explode(';', $columnCfg);

		if ($colStrings)
		{
			foreach ($colStrings as $colString)
			{
				list ($colName, $colWidth) = explode(':', $colString);

				if (in_array($colName, $allowedColNames))
				{
					$reorderedCols[] = $colName;
				}
			}
		}
		else
		{
		}

		// Get column contents with regular expressions
		$patternFound = false;

		foreach ($patterns as $column => $pattern)
		{
			// Save the content into a variable
			$$column = null;

			if (preg_match($pattern, $this->template, $matches))
			{
				$$column = $matches[0];

				$replacement = '';

				// Replace first column found with string '##wricolumns##' to reorder content later
				if (!$patternFound)
				{
					$replacement = '##wricolumns##';
					$patternFound = true;
				}

				$this->template = preg_replace($pattern, $replacement, $this->template);
			}
			else
			{
			}
		}

		// If columns reordered and column content found replace contents
		if ($reorderedCols && $patternFound)
		{
			foreach ($reorderedCols as $colName)
			{
				if (!is_null($$colName))
				{
					$reorderedContent .= $$colName;
				}
			}
		}
		else
		{
		}

		$this->template = preg_replace('/##wricolumns##/isU', $reorderedContent, $this->template);

		return $reorderedContent;
	}

	/**
	 * Add javascript file to the document
	 *
	 * @param   sting  $url  URL of the javascript to add
	 *
	 * @return  void
	 */
	private function addJSScript($url)
	{
		$javascriptBottom = ($this->document->params->get('javascriptBottom', 1) == 1 ? true : false);

		if ($javascriptBottom)
		{
			$this->_jsScripts[] = $url;
		}
		else
		{
			$document = JFactory::getDocument();
			$document->addScript($url);
		}
	}

	/**
	 * Add javascript declarations to the document
	 *
	 * @param   sting  $script  Script to add
	 *
	 * @return  void
	 */
	private function addJSScriptDeclaration($script)
	{
		$javascriptBottom = ($this->document->params->get('javascriptBottom', 1) == 1 ? true : false);

		if ($javascriptBottom)
		{
			$this->_jsDeclarations[] = $script;
		}
		else
		{
			$document = JFactory::getDocument();
			$document->addScriptDeclaration('jQuery( document ).ready(function( $ ) {' . $script . '});');
		}
	}

	/**
	 * Generate javascript when set at the bottom of the document
	 *
	 * @return  string
	 */
	public function generateJS()
	{
		$javascriptBottom = ($this->document->params->get('javascriptBottom', 1) == 1 ? true : false);

		if ($javascriptBottom)
		{
			$script = "\n";

			if ($this->_jsScripts)
			{
				foreach ($this->_jsScripts as $js)
				{
					$script .= "<script src='$js' type='text/javascript'></script>\n";
				}
			}

			if ($this->_jsDeclarations)
			{
				$script .= "<script type='text/javascript'>jQuery( document ).ready(function( $ ) {\n";

				foreach ($this->_jsDeclarations as $js)
				{
					$script .= "$js\n";
				}

				$script .= "});</script>\n";
			}

			return $script;
		}

		return "";
	}

	/**
	 * Setup test values
	 *
	 * @return  array
	 */
	public function setupDefaultBrowserCompatibility()
	{
		$defaultInput = new stdClass;

		$chromeObject = new stdClass;
		$firefoxObject = new stdClass;
		$ieObject = new stdClass;
		$safariObject = new stdClass;
		$operaObject = new stdClass;
		$iOSObject = new stdClass;

		$chromeObject->minimumVersion = '35';
		$chromeObject->recommended = true;
		$chromeObject->desktop = true;
		$chromeObject->mobile = true;
		$firefoxObject->minimumVersion = '28';
		$firefoxObject->recommended = false;
		$firefoxObject->desktop = true;
		$firefoxObject->mobile = false;
		$ieObject->minimumVersion = '8';
		$ieObject->recommended = false;
		$ieObject->desktop = true;
		$ieObject->mobile = false;
		$safariObject->minimumVersion = '7';
		$safariObject->recommended = false;
		$safariObject->desktop = true;
		$safariObject->mobile = false;
		$operaObject->minimumVersion = '24';
		$operaObject->recommended = false;
		$operaObject->desktop = true;
		$operaObject->mobile = false;
		$iOSObject->minimumVersion = '6';
		$iOSObject->recommended = false;
		$iOSObject->desktop = false;
		$iOSObject->mobile = true;

		$chromeName = Browser::BROWSER_CHROME;
		$firefoxName = Browser::BROWSER_FIREFOX;
		$ieName = Browser::BROWSER_IE;
		$safariName = Browser::BROWSER_SAFARI;
		$operaName = Browser::BROWSER_OPERA;
		$iPadName = Browser::BROWSER_IPAD;
		$iPhoneName = Browser::BROWSER_IPHONE;
		$iPodName = Browser::BROWSER_IPOD;

		$defaultInput->$chromeName = $chromeObject;
		$defaultInput->$firefoxName = $firefoxObject;
		$defaultInput->$ieName = $ieObject;
		$defaultInput->$safariName = $safariObject;
		$defaultInput->$operaName = $operaObject;
		$defaultInput->$iPadName = $iOSObject;
		$defaultInput->$iPhoneName = $iOSObject;
		$defaultInput->$iPodName = $iOSObject;

		return $defaultInput;
	}

	/**
	 * Return the Bootstrap column prefix
	 *
	 * @return  string
	 */
	public function setColumnPrefix()
	{

		if (version_compare(JVERSION, '4', 'lt')) {

			// Joomla 3
			$bsprefix_ = 'span';
		}
		else {

			// Joomla 4
			$bsprefix_ = 'col-md-';
		}

		return $bsprefix_;
	}
}
