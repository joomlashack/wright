<?php
//defaults
$wright_options = array(
	'doctype' => 'html5',
);

if ( is_admin() ) {

	function wright_register_settings() {
		register_setting('wright_framework_options', 'wright_options', 'wright_validate_options');
	}

	add_action('admin_init', 'wright_register_settings');

	function wright_validate_options($options) {
		//TODO: validate and clean up!
		return $options;
	}

} // if is_admin()