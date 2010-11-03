<?php

class AdapterJoomla_1_6Debug
{
	public function render($args)
	{
		return '<jdoc:include type="modules" name="debug" />';
	}
}