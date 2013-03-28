<?php

class WrightAdapterWordpress {


	public function get($config) {

		$tag = key($config);
		$file = dirname(__FILE__) . '/wordpress/' . $tag . '.php';
		$class = 'WrightAdapterWordpress' . ucfirst($tag);

		require_once($file);

		$item = new $class();

		return $item->render($config[$tag]);

	}


}