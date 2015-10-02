<?php

/**
 * Create plugin settings menu button
 */
add_action( 'admin_menu', 'psean_admin_menu' );
function psean_admin_menu() {
    // create new top-level menu
    // add_menu_page(
    //     'Expedia Affiliate Network',
    //     'EAN Settings',
    //     'administrator',
    //     __FILE__,
    //     'ean_admin_options_page',
    //     plugin_dir_url( __FILE__ ).'/images/menu_icon_bw_16.png'
    // );

    // create options submenu
    add_options_page(
        'Expedia Affiliate Network',
        'Expedia Affiliate Network',
        'administrator',
        'psean_admin_options_slug',
        'psean_admin_options_page'
    );

    // add hook for after the settings are saved
    add_action( 'updated_option', 'psean_updated_option' );

    // call register settings function
    add_action( 'admin_init', 'register_psean_admin_settings' );
}

/**
 * Register admin options
 * - sections
 * - individual settings
 * - fields for the settings
 */
function register_psean_admin_settings() {
    // register section ( $id, $title, $callback, $page )
    add_settings_section( 'psean_main', 'Expedia API Settings', 'psean_main_text', 'psean_plugin' );
    add_settings_section( 'psean_urls', 'URL Settings',         'psean_urls_text', 'psean_plugin' );
    // register settings
    register_setting( 'psean_admin_options', 'psean_cid',      'psean_cid_validate' );
    register_setting( 'psean_admin_options', 'psean_key',      'psean_key_validate' );
    register_setting( 'psean_admin_options', 'psean_secret',   'psean_secret_validate' );
    register_setting( 'psean_admin_options', 'psean_base_url', 'psean_base_url_validate' );
    // add settings fields
    add_settings_field( 'psean_cid',      'CID',           'psean_input_cid',      'psean_plugin', 'psean_main' );
    add_settings_field( 'psean_key',      'API key',       'psean_input_key',      'psean_plugin', 'psean_main' );
    add_settings_field( 'psean_secret',   'Shared secret', 'psean_input_secret',   'psean_plugin', 'psean_main' );
    add_settings_field( 'psean_base_url', 'Base URL',      'psean_input_base_url', 'psean_plugin', 'psean_urls' );
}

// displays the text for the sections
function psean_main_text() {
    ?>
    <p>Enter your Expedia Affiliate Network information here:</p>
    <?php
}
function psean_urls_text() {
    ?>
    <p>
    Enter the Base URL you wish for the plugin to use here:<br/>
    <span>(www.yoursite.com/<b>{base_url}</b>/)</span>
    </p>
    <?php
}

/**
 * Displays the inputs
 */
function psean_input_cid() {
    $option = get_option('psean_cid');
    echo "<input id='psean_cid' name='psean_cid' type='text' value='{$option}' />";
}
function psean_input_key() {
    $option = get_option('psean_key');
    echo "<input id='psean_key' name='psean_key' type='text' value='{$option}' />";
}
function psean_input_secret() {
    $option = get_option('psean_secret');
    echo "<input id='psean_secret' name='psean_secret' type='text' value='{$option}' />";
}
function psean_input_base_url() {
    $option = get_option('psean_base_url');
    echo "<input id='psean_base_url' name='psean_base_url' type='text' value='{$option}' />";
}

/**
 * Validates the inputs
 */
// TODO : validate these inputs
function psean_cid_validate( $input ) {
    return $input;
}
function psean_key_validate( $input ) {
    return $input;
}
function psean_secret_validate( $input ) {
    return $input;
}
function psean_base_url_validate( $input ) {
    return $input;
}


/**
 * Renders the Settings page for the plugin
 */
function psean_admin_options_page() {
?>
    <div class='wrap'>
        <h2>Expedia Affiliate Network Plugin</h2>
        <form method='post' action='options.php'> 
            <?php settings_fields( 'psean_admin_options' ); ?>
            <?php do_settings_sections( 'psean_plugin' ); ?>
            <?php submit_button(); ?>
        </form>
    </div>
<?php
}

/**
 * Runs when the options are being updated.
 * Used to filter actions for specific options being saved.
 */
function psean_updated_option( $opt=null ) {
    if( $opt == 'psean_base_url' ) {
        psean_rewrite_rules();
    }
}