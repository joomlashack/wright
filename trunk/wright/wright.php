<?php
/**
 * @package Joomlashack Wright Framework
 * @copyright Joomlashack 2010. All Rights Reserved.
 *
 * @description
 *
 * It would be inadvisable to alter the contents of anything inside of this folder
 */

defined('_JEXEC') or die ('You are not allowed to directly access this file');

$doc = JFactory::getDocument();

class Wright extends JDocumentHTML
{
	public $template;
	public $document;
	public $adapter;
	public $params;

	function Wright() {
		// Initialize properties
		$document = JFactory::getDocument();
		$this->document = $document;
		$this->params =& $document->params;

		if (is_file(JPATH_THEMES.DS.$document->template.DS.'functions.php')) include_once(JPATH_THEMES.DS.$document->template.DS.'functions.php');

		// Get our template for further parsing, if custom file is found
		// it will use it instead of the default file
		$path = JPATH_THEMES.DS.$document->template.DS.'template.php';
		if (is_file(JPATH_THEMES.DS.$document->template.DS.'custom.php')) $path = JPATH_THEMES.DS.$document->template.DS.'custom.php';

		// Include our file and capture buffer
		ob_start();
		include($path);
		$this->template = ob_get_contents();
		ob_end_clean();
	}

	function getInstance() {
		static $instance = null;
		if ($instance === null) {
			$instance = new Wright();
		}
		return $instance;
	}

	public function display()
	{
		// Parse by platform
		$this->platform();

		// Parse by doctype
		$this->doctype();

		// Setup the header
		$this->header();

		print trim($this->template);
		return true;

	}

	public function header()
	{
		// Build css
		$this->css();

		// Remove mootools if set
		if ($this->document->params->get('mootools', '1') == '0')
		{
			$dochead = $this->document->getHeadData();
			reset($dochead['scripts']);
			foreach ($dochead['scripts'] as $script=>$type) {
				if (strpos($script, 'media/system/js/caption.js') || strpos($script, 'media/system/js/mootools.js')) {
					unset($dochead['scripts'][$script]);
				}
			}
			$this->document->setHeadData($dochead);
		}
	}

	private function css()
	{
		jimport('joomla.filesystem.file');
		jimport('joomla.filesystem.folder');
		jimport('joomla.environment.browser');

		// Variable holding any custom css built in here
		$code = '';

		$browser = JBrowser::getInstance();
		$sheet = $this->document->template.'.css';

		// Load stylesheets by scanning directory for any prefixed with an number and underscore: 1_***.cs
		$styles = JFolder::files(JPATH_THEMES.DS.$this->document->template.DS.'wright'.DS.'css', '\d{1,2}_.*.css', false, true);
		$styles = array_merge($styles, JFolder::files(JPATH_THEMES.DS.$this->document->template.DS.'css', '\d{1,2}_.*.css', false, true));

		// Load up a specific style if set
		if (is_file(JPATH_THEMES.DS.$this->document->template.DS.'css'.DS.'style-'.$this->document->params->get('style').'.css'))
			$styles[] = JPATH_THEMES.DS.$this->document->template.DS.'css'.DS.'style-'.$this->document->params->get('style').'.css';

		// Add some stuff for lovely IE if needed
		if ($browser->getBrowser() == 'msie')
		{
			$this->document->addScript(JURI::root().'templates/'.$this->document->template.'/js/html5.js');
			$this->document->addScript(JURI::root().'templates/'.$this->document->template.'/js/modernizr.js');
			if (is_file(JPATH_THEMES.DS.$this->document->template.DS.'css'.DS.'ie.css'))
			{
				$styles[] = JPATH_THEMES.DS.$this->document->template.DS.'css'.DS.'ie.css';
				$sheet = $this->document->template.'-ie.css';
			}

			// Switch to allow specific versions of IE to have additional sheets
			$major = $browser->getMajor();
			switch ($major)
			{
				case '6' :
					if (is_file(JPATH_THEMES.DS.$this->document->template.DS.'css'.DS.'ie6.css'))
						$styles[] = JPATH_THEMES.DS.$this->document->template.DS.'css'.DS.'ie6.css';
						$sheet = $this->document->template.'-ie6.css';
						$this->document->addScript(JURI::root().'templates/'.$this->document->template.'/js/dd_belatedpng.js');
					break;

				default :
					if (is_file(JPATH_THEMES.DS.$this->document->template.DS.'css'.DS.'ie'.$major.'.css'))
						$styles[] = JPATH_THEMES.DS.$this->document->template.DS.'css'.DS.'ie'.$major.'.css';
						$sheet = $this->document->template.'-ie'.$major.'.css';
					break;
			}
		}

		// Google Fonts Inclusion
		$fonts = array(		'Cantarell' => array('regular','italic','bold','bolditalic'),
							'Cardo' => array(),
							'Crimson+Text' => array(),
							'Cuprum' => array(),
							'Droid+Sans' => array('regular','bold'),
							'Droid+Sans+Mono' => array(),
							'Droid+Serif' => array('regular','italic','bold','bolditalic'),
							'IM+Fell+DW+Pica' => array('regular','italic'),
							'IM+Fell+DW+Pica+SC' => array(),
							'IM+Fell+DW+Double+Pica' => array('regular','italic'),
							'IM+Fell+DW+Double+Pica+SC' => array(),
							'IM+Fell+DW+English' => array('regular','italic'),
							'IM+Fell+DW+English+SC' => array(),
							'IM+Fell+DW+French+Canon' => array('regular','italic'),
							'IM+Fell+French+Canon+SC' => array(),
							'IM+Fell+Great+Primer' => array('regular','italic'),
							'IM+Fell+Great+Primer+SC' => array(),
							'Inconsolata' => array(),
							'Josefin+Sans+Std+Light' => array(),
							'Lobster' => array(),
							'Molengo' => array(),
							'Neucha' => array(),
							'Neuton' => array(),
							'Nobile' => array('regular','italic','bold','bolditalic'),
							'OFL+Sorts+Mill+Goudy+TT' => array('regular','italic'),
							'Old+Standard+TT' => array('regular','italic','bold'),
							'PT+Sans' => array('regular','italic','bold','bolditalic'),
							'PT+Sans+Caption' => array('regular','bold'),
							'PT+Sans+Narrow' => array('regular','bold'),
							'Philosopher' => array(),
							'Reenie+Beanie' => array(),
							'Tangerine' => array('regular','bold'),
							'Vollkorn' => array('regular','italic','bold','bolditalic'),
							'Yanone+Kaffeesatz' => array('extralight','light','regular','bold'),
				);
		if ($this->document->params->get('body_font') == 'googlefonts') {
			$body_googlefonts = explode(',', $this->document->params->get('body_googlefont'));
			$body_googlefont = array_shift($body_googlefonts);
			$possible_types = $fonts[$body_googlefont];
			$body_googletypes = array();
			foreach ($body_googlefonts as $body_googletype) {
				if (in_array($body_googletype, $possible_types)) $body_googletypes[] = $body_googletype;
			}
			$body_googlefont_url = (count($body_googletypes)) ? $body_googlefont.':'.implode(',', $body_googletypes) : $body_googlefont;
			$this->document->addStyleSheet('http://fonts.googleapis.com/css?family='.$body_googlefont_url.'&subset=latin');
			$body_cssfont = strtolower(str_replace('+', '', $body_googlefont));
			$code .= 'body.b_'.$body_cssfont.' * { font-family: "'.str_replace('+', ' ', $body_googlefont).'"; }';
		}

		if ($this->document->params->get('header_font') == 'googlefonts') {
			$header_googlefonts = explode(',', $this->document->params->get('header_googlefont'));
			$header_googlefont = array_shift($header_googlefonts);
			$possible_types = $fonts[$header_googlefont];
			$header_googletypes = array();
			foreach ($header_googlefonts as $header_googletype) {
				if (in_array($header_googletype, $possible_types)) $header_googletypes[] = $header_googletype;
			}
			$header_googlefont_url = (count($header_googletypes)) ? $header_googlefont.':'.implode(',', $header_googletypes) : $header_googlefont;
			$this->document->addStyleSheet('http://fonts.googleapis.com/css?family='.$header_googlefont_url.'&subset=latin');
			$header_cssfont = strtolower(str_replace('+', '', $header_googlefont));
			$code .= '* body.h_'.$header_cssfont.' h1, * body.h_'.$header_cssfont.' h2, * body.h_'.$header_cssfont.' h3, * body.h_'.$header_cssfont.' h4, * body.h_'.$header_cssfont.' h5, * body.h_'.$header_cssfont.' h6 { font-family: "'.str_replace('+', ' ', $header_googlefont).'"; }';
		}

		// Combine css into one file if files have been altered since cached copy
		$rebuild = false;
		if (is_file(JPATH_THEMES.DS.$this->document->template.DS.'css'.DS.$sheet)) $cachetime = filemtime(JPATH_THEMES.DS.$this->document->template.DS.'css'.DS.$sheet);
		else $cachetime = 0;
		foreach ($styles as $style)
		{
			if (filemtime($style) > $cachetime) $rebuild = true;
		}
		if ($rebuild)
		{
			$css = '/* DO NOT EDIT THIS FILE. IT IS AUTOGENERATED. SEE DOCUMENTATION */
				';
			foreach ($styles as $style)
			{
				$css .= JFile::read($style);
			}
			$css .= $code;
			JFile::write(JPATH_THEMES.DS.$this->document->template.DS.'css'.DS.$sheet, $css);
		}
		$this->document->addStyleSheet(JURI::root().'templates/'.$this->document->template.'/css/'.$sheet);
	}

	private function doctype()
	{
		require(dirname(__FILE__).DS.'doctypes'.DS.$this->document->params->get('doctype', 'html5').'.php');
		$adapter_name = 'HtmlAdapter'.$this->document->params->get('doctype','html5');
		$adapter = new $adapter_name($this->document->params);

		foreach ($adapter->getTags() as $name => $regex)
		{
			$action = 'get'.ucfirst($name);
			$this->template = preg_replace_callback($regex, array($adapter, $action), $this->template);
		}
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
		$file = strtolower(str_replace('!', '', $version->PRODUCT.'_'.$version->RELEASE));
		$class = ucfirst(str_replace('.','_',$file));

		// Load up the proper adapter
		require_once(dirname(__FILE__).DS.'adapters'.DS.$file.'.php');
		$classname = 'Adapter'.$class;
		$this->adapter = new $classname();
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

	function setGoogleFont($font, $type) {
		$this->document->params->set($type.'_font', 'googlefonts');
		$this->document->params->set($type.'_googlefont', str_replace(' ', '+', $font));
	}
}