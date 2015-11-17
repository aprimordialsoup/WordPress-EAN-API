<?php

include( 'json-header.php' );

// currently selected province and country
$province = strtoupper( $_GET['p'] );
$country = strtoupper( $_GET['c'] );
// stores city objects
$cities = array();
// stores cities to avoid adding duplicates
$hash = array();

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
            if( $id != null && !in_array( $id, $hash ) ) {
                // add city to the hash table
                array_push( $hash, $id );
                // add city to the cities array
                $city = array(
                    'code' => $data[0],
                    'name' => $data[10],
                    'metro_code' => $data[11]
                );
                array_push( $cities , $city );
            }
        }
    }
}

// define custom sort function
function sort_by_name( $a, $b ) {
    return $a['name'] > $b['name'];
}

// sort
usort( $cities, 'sort_by_name' );

// output
echo json_encode( $cities, JSON_UNESCAPED_UNICODE );
