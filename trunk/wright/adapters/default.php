<?php
/**
 * Abstract Adapter Class
 *
 * This class is to set the default platform parsing tags, and each subclass
 * can customize the output depending on the version of Joomla.
 *
 * @package Wright
 * @author Jeremy Wilken
 */

abstract class AdapterAbstract
{

	/**
	 * Handles the tag processing
	 *
	 * @param array $tag
	 * @return string
	 */

	public function get($config)
	{
		$tag = key($config);
		require_once 'joomla'.DS.$tag.'.php';
		$cn = 'AdapterJoomla'.ucfirst($tag);
		$item = new $cn();
		return $item->render($config[$tag]);
	}

}