<?php



//Adding a check for PHP4 to cut down on support
if (version_compare(PHP_VERSION, '5', '<'))
{
	print 'You are using an out of date version of PHP, version ' . PHP_VERSION . ' and our products require PHP 5.2 or greater. Please contact your host to use PHP 5.2 or greater. All versions of PHP prior to this are unsupported, by us and by the PHP community.';
	die();
}

//include Wright dependencies
require_once('wright.php');

class WordpressWright extends Wright {

	public $params;

	private $_urlTemplate = null;
	private $_urlWright = null;
	private $_urlJS = null;

	private $_jsScripts = array();
	private $_jsDeclarations = array();

	private $_styles = array();

	public function WordpressWright() {

		//get options from wp theme definition or use defaults
		$this->params = get_option('wright_options');

		//fabricate urls
		$this->_urlTemplate = get_template_directory_uri();
		$this->_urlWright = $this->_urlTemplate . '/wright';
		$this->_urlFontAwesome = $this->_urlWright . '/fontawesome';
		$this->_urlJS = $this->_urlWright . '/js';

		//variables needed in template
		//FIXME: move this to an abstraction layer
		$gridMode = $this->getOption('bs_rowmode');
		$containerClass = 'container';
		if ($gridMode == 'row-fluid') {
			$containerClass = 'container-fluid';
		}
		$responsivePage = $this->getOption('responsive');
		$responsive = ' responsive';
		if ( ! $responsivePage) {
			$responsive = ' no-responsive';
		}

		//TODO: detect customizations before including
		$path = get_template_directory() . '/template.php';

		//capture it
		ob_start();
		require($path);
		$this->template = ob_get_contents();
		ob_end_clean();

	}

	protected function header() {

		//should we include jQuery?
		$loadJQuery = $this->params['jquery'];
		if ($loadJQuery) {
			switch ($loadJQuery) {
	      // load jQuery locally
	      case 1:
	          wp_enqueue_script('jquery');
	          break;
	      // load jQuery from Google
	      default:
	      		//TODO: add this to the local jquery object to be added at the end.
	          $jquery = 'http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js';
	          break;
      }

      //TODO: by default WP loads jQuery with noConflict activated, deactivate (requires wrapping)
      //if required by the parameter

		}

		//include Bootstrap (et al) (WP always requires bootstrap, it's not included by default)
		$this->addJSScript($this->_urlJS . '/bootstrap.min.js', 'bootstrap');
		$this->addJSScript($this->_urlJS . '/utils.js', 'utils');
		if ($this->params['stickyFooter']) {
			$this->addJSScript($this->_urlJS . '/stickyFooter.js', 'stickyFooter');
		}

		//add header script if it's set
		if (trim($this->params['headerscript']) != '') {
			$this->addJSScriptDeclaration($this->params['headerscript']);
		}

		//TODO: handle custom themes

		//documentation mode
		if ($this->params['documentationMode']) {
			$this->addJSScript($this->_urlTemplate . '/js/prettify.js', 'prettify');
			$this->addJSScriptDeclaration('$window = jQuery(window); $window.prettyPrint && prettyPrint();');
		}

		//Build css
		$this->css();

	}


	protected function addCSSToHead($styles) {

		foreach($styles as $folder => $files) {
			foreach($files as $style) {
				switch($folder) {
					case 'fontawesome':
						$sheet = $this->_urlFontAwesome . '/css/' . $style;
						break;
					case 'wrighttemplatecss':
						$sheet = $this->_urlWright . '/css/' . $style;
						break;
					default:
						$sheet = $this->_urlTemplate . '/css/' . $style;
				}

				//create a handle using the folder and css file names
				$handle = $style;

				//add it to the internal array (so it gets added later when the
				//wp_enqueue_style action hook is triggered)
				$this->_styles []= array(
						'handle' => $handle,
						'url' => $sheet
					);
			}
		}

	}

	protected function loadCSSList() {

		global $is_IE;

		$styles = array();

		//add Bootstrap styles, WP always requires them
		$styles['wrighttemplatecss'] []= 'bootstrap.min.css';

		//add the theme styles, taking in cosideration the "color scheme" selected in options
		//TODO: actually read the style option
		$styles['template'] []= 'style-generic.css';

		//do we need to add styles for Documentation mode?
		if ($this->params['documentationMode']) {
			$styles['template'] []= 'docs.css';
		}

		//add some stuff for IE
		if ($is_IE) {

			$browser = get_browser();

			//if version is < 9 add HTML5shiv
			if ( (int)$browser->majorver <= 9 ) {
				$this->addJSScript($this->_urlTemplate . '/wright/js/html5shiv.js');
			}

			//add general IE stylesheet
			if (is_file($this->_urlTemplate . '/css/ie.css'))
				$styles['ie'] []= 'ie.css';

			//if version is 7
			if ((int)$browser->majorver = 7) {
				$styles['fontawesome'] []= 'font-awesome-ie7.min.css';
			}

			//add default stylesheet
			if (is_file($this->_urlTemplate . '/css/ie' . $browser->majorver . '.css'))
				$styles['ie'] []= 'ie' . $browser->majorver . '.css';

		} //if browser is IE

		//add style variations depending on document language direction
		if (is_rtl() && is_file($this->_urlTemplate . '/css/rtl.css'))
			$styles['template'] []= 'rtl.css';

		//add custom css if it exists
		if (is_file($this->_urlTemplate . '/css/custom.css'))
			$styles['template'] []= 'custom.css';

		//FIXME: this overwrites the fontawesome style included above for IE7, is that intended?
		$styles['fontawesome'] = array();

		return $styles;

	}


	protected function doctype() {

		require(dirname(__FILE__) . '/doctypes/wphtml5.php');
		$adapter_name = 'HtmlAdapterWpHtml5';
		$adapter = new $adapter_name();

		foreach ($adapter->getTags() as $name => $regex)
		{
			$action = 'get' . ucfirst($name);
			$this->template = preg_replace_callback($regex, array($adapter, $action), $this->template);
		}


	}

	protected function platform() {

		require_once(dirname(__FILE__) . '/adapters/wordpress.php');
		$this->adapter = new WrightAdapterWordpress();
		$this->template = preg_replace_callback("/<w:(.*)\/>/i", array(get_class($this), 'platformTags'), $this->template);

	}

	protected function platformTags($matches)
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

	protected function addJSScript($url, $handle) {
		$js = array(
				'handle' => $handle,
				'url' => $url
			);

		//push it, it'll get actually added to the head (or before </body>) later
		$this->_jsScripts []= $js;

	}

	protected function addJSScriptDeclaration($script) {

		//push it, it'll get actually added to the head (or before </body>) later
		$this->_jsDeclarations []= $script;

	}

	//enqueues the scripts
	//this function is called from a wp_enqueue_scripts action hook.
	public function generateJS() {

		//do we have to add them in the footer?
		$javascriptBottom = $this->params['javascriptBottom'];

		//add script from urls
		foreach($this->_jsScripts as $js) {
			wp_enqueue_script($js['handle'], $js['url'], false, null, $javascriptBottom);
		}

	}

	//returns the script declarations
	//this function is called from either the wp_head or the wp_footer action hook
	public function generateJSDeclarations() {

		$js = '<script type="text/javascript">' . PHP_EOL;

		foreach($this->_jsDeclarations as $script) {
			$js .= $script . PHP_EOL;
		}

		$js .= '</script>' . PHP_EOL;

		return $js;

	}

	//enqueues the styles
	//this function is called from a wp_enqueue_styles action hook
	public function generateStyles() {

		//add all the styles
		foreach($this->_styles as $style) {
			wp_enqueue_style($style['handle'], $style['url'], false, null);
		}

	}

	//returns an option read from the Wright configuration
	public function getOption($option_name) {
		if (isset($this->params[$option_name]))
			return $this->params[$option_name];
		else
			return null;
	}

}