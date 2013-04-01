<?php

class WrightAdapterWordpressHead {

	public function render($args) {

		// add viewport meta for tablets
		$head = '<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">';

		return $head;		

	}

}