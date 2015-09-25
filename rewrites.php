<?php

// rewrite rules
add_action( 'init', 'pseanapi_rewrite_rules', 10, 0 );
function pseanapi_rewrite_rules() {
	// TODO: get rid of test page
    // test page
    add_rewrite_rule(
        '^test/?$',
        'index.php?psean=test',
        'top' );
}

// remembers the custom query vars
add_filter( 'query_vars', 'pseanapi_rewrite_query_vars' );
function pseanapi_rewrite_query_vars( $query_vars ){
    // the action being performed
    $query_vars[] = 'psean';
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

}