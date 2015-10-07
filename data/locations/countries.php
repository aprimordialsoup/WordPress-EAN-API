<?php

include( 'json-header.php' );

$countries = array();

$row = 0;
if ( ( $handle = fopen( $file, 'r' ) ) !== FALSE ) {
    while ( ( $data = fgetcsv( $handle, 1000, ',' ) ) !== FALSE ) {
        $num = count( $data );
        $row++;
        if( $row > 1 ) {
            // get country code
            $cc = $data[4];
            // add country to array if it doesn't exist
            if( $cc != null && !isset( $countries[$cc] ) ) {
                $countries[$cc] = array();
                $country = array(
                    'code' => $data[4],
                    'name' => $data[5]
                );
                array_push( $countries[$cc] , $country );
            }
        }
    }
}

// sort
array_multisort( $countries, SORT_ASC ); 

// output
echo json_encode( $countries, JSON_UNESCAPED_UNICODE );
