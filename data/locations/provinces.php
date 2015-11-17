<?php

include( 'json-header.php' );

// currently selected country
$country = strtoupper( $_GET['c'] );
// stores province objects
$provinces = array();
// stores province ids to avoid adding dupilcates
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
            // get province code
            $prov = $data[6];
            // add province to array if it doesn't exist
            if( $prov != null && !in_array( $prov, $hash ) ) {
                // add province to the hash table
                array_push( $hash, $prov );
                // add province to the provinces array
                $province = array(
                    'code' => $data[6],
                    'name' => $data[7]
                );
                array_push( $provinces , $province );
            }
        }
    }
}

// define custom sort function
function sort_by_name( $a, $b ) {
    return $a['name'] > $b['name'];
}

// sort
usort( $provinces, 'sort_by_name' );

// output
echo json_encode( $provinces, JSON_UNESCAPED_UNICODE );
