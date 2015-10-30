<?php

/**
 * This function runs when the user first activates the plugin.
 * Can be used to configure default options, and settings.
 */
function psean_activate() {
    // register the default api key options
    $option = get_option('psean_cid');
    if( !isset($option) || $option == null ) {
        update_option( 'psean_cid' , '449397' );
    }
    $option = get_option('psean_key');
    if( !isset($option) || $option == null ) {
        update_option( 'psean_key' , '6kveen4qecnaekpanu06a5pqcr' );
    }
    $option = get_option('psean_secret');
    if( !isset($option) || $option == null ) {
        update_option( 'psean_secret' , '6kuv7u4iculqc' );
    }
    // register the default 'base_url' option
    $option = get_option('psean_base_url');
    if( !isset($option) || $option == null ) {
        update_option( 'psean_base_url' , 'ean' );
    }


}

/**
 * Queue up jQuery
 */
add_action('init', 'pseanapi_enqueue_scripts'); // Add Custom Scripts to wp_head
function pseanapi_enqueue_scripts() {
    // wp_register_script( $handle, $src, $deps, $ver, $in_footer );

    // jquery
    wp_enqueue_script( 'jquery' );
    // widget ajax handler
    wp_register_script( 'pseanapi_widget_ajax', plugin_dir_url( __FILE__ ).'/js/psean_widget_ajax.js', array('jquery'), '1.0.0');
    wp_enqueue_script( 'pseanapi_widget_ajax' );
}


/**
 * Add global JS variables
 */
add_action ( 'wp_head', 'pseanapi_js_variables' );
function pseanapi_js_variables(){ ?>
  <script>
    var pseanapi_site_url = <?php echo json_encode( site_url().'/' ); ?>;
    var pseanapi_ajaxurl = <?php echo json_encode( plugin_dir_url( __FILE__ ) ); ?>;
  </script><?php
}