<?php

require_once('default.php');

class AdapterJoomla_1_6 extends AdapterAbstract
{
	public function get($config)
	{
		$tag = key($config);
		require_once 'joomla_1.6'.DS.$tag.'.php';
		$cn = 'AdapterJoomla_1_6'.ucfirst($tag);
		$item = new $cn();
		return $item->render($config[$tag]);
	}
}