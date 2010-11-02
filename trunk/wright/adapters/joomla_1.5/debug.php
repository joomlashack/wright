<?php

class AdapterJoomla_1_5Debug
{
	public function render($args)
	{
		return '<jdoc:include type="modules" name="debug" />';
	}
}