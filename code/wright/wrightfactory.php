<?php

class WrightFactory {

	static $instance = null;

	static function getInstance() {

		if (self::$instance === null) {

			//build an instance depending on the platform we are running on

			//if we are on Joomla
			if (defined('_JEXEC')) {
				include_once('joomlawright.php');
				self::$instance = new JoomlaWright();
			}
			//if we are on Wordpress
			elseif(defined('ABSPATH')) {
				include_once('wordpresswright.php');
				self::$instance = new WordpressWright();
			}

		}

		return self::$instance;

	}

}