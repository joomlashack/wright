<?php

class Overrider
{
	public $version;

	public function getVersion()
	{
		if (!isset($this->version)) {
			jimport('joomla.version');
			$version = new JVersion();
			$this->version = strtolower(ereg_replace("[^A-Za-z0-9_.]", "", $version->PRODUCT.'_'.$version->RELEASE ));
		}

		print '<!-- overrider -->';

		return $this->version;
	}
}