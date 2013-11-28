<?php

//class to manage the Wright Framework settings pages
class WrightSettingsPage {

	//holds the values to be used in the fields callbacks
	private $options;

	public function __construct() {
		add_action('after_setup_theme', array($this, 'set_default_options'));
		add_action('admin_menu', array($this, 'add_settings_page'));
		add_action('admin_init', array($this, 'page_init'));
	}

	//sets the default values for options if they don't exist yet
	public function set_default_options() {

		//TODO: read these from templateDetails.xml

		//defaults
		$wright_default_options = array(
			'doctype' => 'html5',
			'jquery' => 1,
			'stickyFooter' => 1,
			'documentationMode' => 1,
			'javascriptBottom' => 0,
			'headerscript' => 'console.log("header script from options");',
			'bs_rowmode' => 'row-fluid',
			'responsive' => 1
		);

		$wright_options = get_option('wright_options');
		//TODO: enable the condition
		//if ($wright_options === false) {
			update_option('wright_options', $wright_default_options);
		//}

	}

	//add options page
	public function add_settings_page() {

		//the page will be displayed under "Settings"
		//TODO: move strings to lang file
		add_options_page(
				'Wright Framework',
				'Wright Framework Settings',
				'manage_options',
				'wright-framework',
				array($this, 'create_admin_page')
			);

	}

	//Options page callback -- creates the actual page
	public function create_admin_page() {

		//get the current values
		$this->options = get_option('wright_options');

		?>

		<div class="wrap">
			<?php get_screen_icon('options-general'); ?>
			<h2>Wright Framework Settings</h2>
			<form action="wright-options.php" method="post">
				<?php
					settings_fields('wright_options_group');
					do_settings_sections('wright-framework');
					submit_button();
				?>
			</form>
		</div>

		<?php

	} // function create_admin_page()

	//register and add settings
	public function page_init() {

		register_setting(
				'wright_options_group',
				'wright_options',
				array($this, 'sanitize')
			);

		//TODO: code something to read all this from templateDetails.xml
		add_settings_section(
				'wright_options_basic',
				'Basic',
				array($this, 'print_section_info'),
				'wright-framework'
			);

		//TODO: add each field, or, code something to read the templateDetails.xml file
		//and add them programatically from there
		/*
		add_settings_field(
				'jquery',
				'Load jQuery',
				array()
			);
		*/
	}

	//prints the section text
	public function print_section_info() {
		echo 'Enter your settings:';
	}
}


if ( is_admin() ) {
	$wright_settings_page = new WrightSettingsPage();
}
