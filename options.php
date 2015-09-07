<?php

/**
 * Create plugin settings menu button
 **/
add_action( 'admin_menu', 'ean_admin_menu' );
function ean_admin_menu() {
	// create new top-level menu
	add_menu_page(
		'Expedia Affiliate Network',
		'EAN Settings',
		'administrator',
		__FILE__,
		'ean_admin_options_page',
		plugin_dir_url( __FILE__ ).'/images/menu_icon_bw_16.png'
	);
	// call register settings function
	add_action( 'admin_init', 'register_ean_admin_settings' );
}

/**
 * Register admin options
 * - groups
 * - individual settings
 * - fields for the settings
 **/
function register_ean_admin_settings() {
	// register section
	add_settings_section( 'ean_main', 'Main Settings', 'ean_main_text', 'ean_plugin' );
	// register settings
	register_setting( 'ean_admin_options', 'ean_cid', 'ean_cid_validate' );
	register_setting( 'ean_admin_options', 'ean_key', 'ean_key_validate' );
	register_setting( 'ean_admin_options', 'ean_secret', 'ean_secret_validate' );
	// add settings fields
	add_settings_field( 'ean_cid', 'CID', 'ean_input_cid', 'ean_plugin', 'ean_main' );
	add_settings_field( 'ean_key', 'API key', 'ean_input_key', 'ean_plugin', 'ean_main' );
	add_settings_field( 'ean_secret', 'Shared secret', 'ean_input_secret', 'ean_plugin', 'ean_main' );
}

// displays the text for the section
function ean_main_text() {
	echo '<p>Enter your Expedia Affiliate Network information here:</p>';
}

/**
 * Displays the inputs
 **/
function ean_input_cid() {
	$option = get_option('ean_cid');
	echo "<input id='ean_cid' name='ean_cid' type='text' value='{$option}' />";
}
function ean_input_key() {
	$option = get_option('ean_key');
	echo "<input id='ean_key' name='ean_key' type='text' value='{$option}' />";
}
function ean_input_secret() {
	$option = get_option('ean_secret');
	echo "<input id='ean_secret' name='ean_secret' type='text' value='{$option}' />";
}

/**
 * Validates the inputs
 **/
function ean_cid_validate( $input ) {
	return $input;
}
function ean_key_validate( $input ) {
	return $input;
}
function ean_secret_validate( $input ) {
	return $input;
}


/**
 * Renders the Settings page for the plugin
 **/
function ean_admin_options_page() {
?>
	<div class='wrap'>
		<h2>Expedia Affiliate Network Plugin</h2>
		<form method='post' action='options.php'> 
			<?php settings_fields( 'ean_admin_options' ); ?>
			<?php do_settings_sections( 'ean_plugin' ); ?>
		    <?php submit_button(); ?>
		</form>
	</div>
<?php
}

