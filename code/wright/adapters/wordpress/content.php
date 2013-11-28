<?php

class WrightAdapterWordpressContent {

	public function render($args) {

		$content = '';
		$path = get_template_directory()  . '/wright/html/wordpress/content.php';

		//capture head contents
		ob_start();
		include($path);
		$content = ob_get_contents();
		ob_end_clean();


		/*
		//The Loop
		if (have_posts()) {

			while (have_posts()) {

				the_post();

				$raw_content = get_the_content();

				//apply filters manually since the get_ version of the_content() does not apply them automatically
				$content .= apply_filters('the_content', $raw_content);


			}

		}
		*/

		return $content;

	}

}