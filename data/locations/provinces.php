<?php

include( 'json-header.php' );

$country = strtoupper( $_GET['c'] );

$provinces = array();

$row = 0;
if ( ( $handle = fopen( $file, 'r' ) ) !== FALSE ) {
    while ( ( $data = fgetcsv( $handle, 1000, ',' ) ) !== FALSE ) {
        $num = count( $data );
        $row++;
        if( $row > 1 ) {
            // get country code and compare
            $cc = $data[4];
            if( $country != $cc ) continue;
            // get province code
            $prov = $data[6];
            // add province to array if it doesn't exist
            if( $prov != null && !isset( $provinces[$prov] ) ) {
                $provinces[$prov] = array();
                $province = array(
                    'code' => $data[6],
                    'name' => $data[7]
                );
                array_push( $provinces[$prov] , $province );
            }
        }
    }
}

// sort
array_multisort( $provinces, SORT_ASC ); 

// output
echo json_encode( $provinces, JSON_UNESCAPED_UNICODE );
