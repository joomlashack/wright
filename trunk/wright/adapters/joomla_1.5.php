<?php

require_once('default.php');

class AdapterJoomla_1_5 extends AdapterAbstract
{
	public function get($config)
	{
		$tag = key($config);
		require_once 'joomla_1.5'.DS.$tag.'.php';
		$cn = 'AdapterJoomla_1_5'.ucfirst($tag);
		$item = new $cn();
		return $item->render($config[$tag]);
	}
}