<?php

class WrightAdapterWordpressHead {

	public function render($args) {

		//TODO: handle the logic to replace the calls to get_header from the template file
		//i.e include from /html/wordpress the head.php (or a specialized-via-args version)

		//add viewport meta for tablets
		$head = '<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">' . PHP_EOL;

		//capture head contents
		ob_start();
		wp_head();
		$head .= ob_get_contents();
		ob_end_clean();

		return $head;

	}

}