<?php

class WrightAdapterJoomlaHead
{
	public function render($args)
	{
		// add viewport meta for tablets always
		$head = '<meta name="viewport" content="width=device-width, initial-scale=1.0">' . "\n";
		$head .= '<jdoc:include type="head" />';
	    $head .= "\n";
		return $head;
	}
}
