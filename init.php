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

    // extract data CSVs into JSON files
    // (runs only if needed)
    include plugin_dir_path( __FILE__ ).'data/locations/convert.php';
}
