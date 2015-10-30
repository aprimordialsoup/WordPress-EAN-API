<?php

$base_url = dirname( __FILE__ ).'/';

// check countries json
$json = $base_url.'countries.json';
if( !file_exists( $json ) ) {

	// locations CSV file
	$file = 'GeoLite2/locations-en.csv';

	// stores country objects
	$countries = array();
	// stores country ids to avoid adding duplicates
	$hash = array();

	$row = 0;
	if ( ( $handle = fopen( $file, 'r' ) ) !== FALSE ) {
	    while ( ( $data = fgetcsv( $handle, 1000, ',' ) ) !== FALSE ) {
	        $num = count( $data );
	        $row++;
	        if( $row > 1 ) {
	            // get country code
	            $cc = $data[4];
	            // add country to array only if it doesn't exist
	            if( $cc != null && !in_array( $cc, $hash ) ) {
	                // add country id to hash table
	                array_push( $hash, $cc );
	                // add country to countries array
	                $country = array(
	                    'code' => $data[4],
	                    'name' => $data[5]
	                );
	                array_push( $countries , $country );
	            }
	        }
	    }
	}

	// define custom sort function
	function sort_by_name( $a, $b ) {
	    return $a['name'] > $b['name'];
	}

	// sort
	usort( $countries, 'sort_by_name' );

	// output
	// echo json_encode( $countries, JSON_UNESCAPED_UNICODE );
	$data = json_encode( $countries, JSON_UNESCAPED_UNICODE );
	file_put_contents( $json, $data )

}

/**** need to figure out a way
      to make this generate files
      as requests come in *******
      aka caching ***************
      
// check provinces json
$json = $base_url.'provinces.json';
if( !file_exists( $json ) ) {

	// locations CSV file
	$file = 'GeoLite2/locations-en.csv';

	$country = strtoupper( $_GET['c'] );

	$provinces = array();

	$row = 0;
	if ( ( $handle = fopen( $file, 'r' ) ) !== FALSE ) {
	    while ( ( $data = fgetcsv( $handle, 1000, ',' ) ) !== FALSE ) {
	        $num = count( $data );
	        $row++;
	        if( $row > 1 ) {
	            // get country code
	            $cc = $data[4];
	            // add country to array only if it doesn't exist
	            if( $cc != null && !in_array( $cc, $hash ) ) {
	                // add country id to hash table
	                array_push( $hash, $cc );
	                // add country to countries array
	                $country = array(
	                    'code' => $data[4],
	                    'name' => $data[5]
	                );
	                array_push( $countries , $country );
	            }
	        }
	    }
	}

	// define custom sort function
	function sort_by_name( $a, $b ) {
	    return $a['name'] > $b['name'];
	}

	// sort
	usort( $countries, 'sort_by_name' );

	// output
	// echo json_encode( $countries, JSON_UNESCAPED_UNICODE );
	$data = json_encode( $countries, JSON_UNESCAPED_UNICODE );
	file_put_contents( $json, $data )

}


// check cities json
$json = $base_url.'cities.json';
if( !file_exists( $json ) ) {

	// locations CSV file
	$file = 'GeoLite2/locations-en.csv';

	// stores country objects
	$countries = array();
	// stores country ids to avoid adding duplicates
	$hash = array();

	$row = 0;
	if ( ( $handle = fopen( $file, 'r' ) ) !== FALSE ) {
	    while ( ( $data = fgetcsv( $handle, 1000, ',' ) ) !== FALSE ) {
	        $num = count( $data );
	        $row++;
	        if( $row > 1 ) {
	            // get country code
	            $cc = $data[4];
	            // add country to array only if it doesn't exist
	            if( $cc != null && !in_array( $cc, $hash ) ) {
	                // add country id to hash table
	                array_push( $hash, $cc );
	                // add country to countries array
	                $country = array(
	                    'code' => $data[4],
	                    'name' => $data[5]
	                );
	                array_push( $countries , $country );
	            }
	        }
	    }
	}

	// define custom sort function
	function sort_by_name( $a, $b ) {
	    return $a['name'] > $b['name'];
	}

	// sort
	usort( $countries, 'sort_by_name' );

	// output
	// echo json_encode( $countries, JSON_UNESCAPED_UNICODE );
	$data = json_encode( $countries, JSON_UNESCAPED_UNICODE );
	file_put_contents( $json, $data )

}
*/

