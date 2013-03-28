<?php

class WrightAdapterWordpressContent {

	public function render($args) {

		// add viewport meta for tablets
		ob_start();
		the_content();
		$content = ob_get_contents();
		ob_end_clean();

		return $content;

	}

}