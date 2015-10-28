<?php

// rewrite rules
// add_action( 'init', 'psean_rewrite_rules', 10, 0 );
function psean_rewrite_rules() {
    // ( $regex, $redirect, $after )

    // TODO: get rid of test page
    // test page
    add_rewrite_rule(
        '^test/?$',
        'index.php?psean=test',
        'top' );
		

    // json data pages
    $base_url = get_option('psean_base_url');
    //// countries
    add_rewrite_rule(
        $base_url.'/data/countries/?$',
        substr( plugin_dir_path( __FILE__ ), 1 ) . 'data/locations/countries.php',
        'top'
    );
    //// provinces
    add_rewrite_rule(
        $base_url.'/data/provinces/([^/].*)/?$',
        substr( plugin_dir_path( __FILE__ ), 1 ) . 'data/locations/provinces.php?c=$1',
        'top'
    );
    //// cities
    add_rewrite_rule(
        $base_url.'/data/cities/([^/].*)/([^/].*)/?$',
        substr( plugin_dir_path( __FILE__ ), 1 ) . 'data/locations/cities.php?p=$1&c=$2',
        'top'
    );
	
    // hotel list
    add_rewrite_rule(
        $base_url.'/hotel/list/?$',
        'index.php?psean=hotel-list',
        'top' );
    // hotel info
    add_rewrite_rule(
        $base_url.'/hotel/([^/].*)/?$',
        'index.php?psean=hotel-info&hotelid=$matches[1]',
        'top' );


    // flush rewrite rules
    flush_rewrite_rules();
}


// remembers the custom query vars
add_filter( 'query_vars', 'psean_rewrite_query_vars' );
function psean_rewrite_query_vars( $query_vars ){
    // the action being performed
    $query_vars[] = 'psean';
    // hotel id
    $query_vars[] = 'hotelid';
    // return
    return $query_vars;
}

// rewrite action
add_action( 'template_redirect', 'execute_action' );
function execute_action() {
    // TODO: remove debug info:
    /*
    if( get_query_var('psean') ) {
        $out = '';
        $out .= ':::';
        $out .= get_query_var('psean');
        $out .= ':::';
        $out .= '<br/>';
        echo $out;
    }
    /**/
    // TODO: remove test
    // test page
    if( get_query_var('psean')
    && get_query_var('psean') == 'test' ) {
        add_filter( 'template_include', function() {
            return plugin_dir_path( __FILE__ ) . 'views/test.php';
        });
    }

    // hotel list
    if( get_query_var('psean')
    && get_query_var('psean') == 'hotel-list' ) {
        add_filter( 'template_include', function() {
            return plugin_dir_path( __FILE__ ) . 'views/hotel/list.php';
        });
    }

    // hotel info
    if( get_query_var('psean')
    && get_query_var('psean') == 'hotel-info'
    && get_query_var('hotelid')
    && intval(get_query_var('hotelid')) > 0 ) {
        add_filter( 'template_include', function() {
            return plugin_dir_path( __FILE__ ) . 'views/hotel/info.php';
        });
    }

}