<?php



//Adding a check for PHP4 to cut down on support
if (version_compare(PHP_VERSION, '5', '<'))
{
	print 'You are using an out of date version of PHP, version ' . PHP_VERSION . ' and our products require PHP 5.2 or greater. Please contact your host to use PHP 5.2 or greater. All versions of PHP prior to this are unsupported, by us and by the PHP community.';
	die();
}

//include Wright options
require_once(get_stylesheet_directory() . '/theme-options.php');

class Wright {

	public function Wright() {


		global $wright_options;
		//get options from wp theme definition or use defaults
		$this->params = get_option('wright_options', $wright_options);

		//TODO: detect customizations before including
		$path = get_template_directory() . '/template.php';

		//capture it
		ob_start();
		include($path);
		$this->template = ob_get_contents();
		ob_end_clean();

	}

	static function getInstance() {
		static $instance = null;
		if ($instance === null) {
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

		//TODO
		// Parse by doctype
		$this->doctype(); 

		print trim($this->template);

		return true;
	}

	private function header() {
		//this should be moved to the platform specific adapter
		wp_enqueue_script('jquery');
		//move it to adapters parsing of <w:head/>?
		//wp_head();
	}

	private function platform() {

		require_once(dirname(__FILE__) . '/adapters/wordpress.php');
		$this->adapter = new WrightAdapterWordpress();
		$this->template = preg_replace_callback("/<w:(.*)\/>/i", array(get_class($this), 'platformTags'), $this->template);

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


	private function doctype() {

		require(dirname(__FILE__) . '/doctypes/wphtml5.php');
		$adapter_name = 'HtmlAdapterWpHtml5';
		$adapter = new $adapter_name();

		foreach ($adapter->getTags() as $name => $regex)
		{
			$action = 'get' . ucfirst($name);
			$this->template = preg_replace_callback($regex, array($adapter, $action), $this->template);
		}

	
	}

}