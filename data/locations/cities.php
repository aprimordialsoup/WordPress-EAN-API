<?php

include( 'json-header.php' );

$province = strtoupper( $_GET['p'] );
$country = strtoupper( $_GET['c'] );

$cities = array();

$row = 0;
if ( ( $handle = fopen( $file, 'r' ) ) !== FALSE ) {
    while ( ( $data = fgetcsv( $handle, 1000, ',' ) ) !== FALSE ) {
        $num = count( $data );
        $row++;
        if( $row > 1 ) {
            // get country code and compare
            $cc = $data[4];
            if( $country != $cc ) continue;
            // get province code and compare
            $prov = $data[6];
            if( $province != $prov ) continue;
            // get city code
            $id = $data[0];
            // add city to array if it doesn't exist
            if( $id != null && !isset( $cities[$id] ) ) {
                $cities[$id] = array();
                $city = array(
                    'code' => $data[0],
                    'name' => $data[10],
                    'metro_code' => $data[11]
                );
                array_push( $cities[$id] , $city );
            }
        }
    }
}

// sort
array_multisort( $cities, SORT_ASC ); 

// output
echo json_encode( $cities, JSON_UNESCAPED_UNICODE );
