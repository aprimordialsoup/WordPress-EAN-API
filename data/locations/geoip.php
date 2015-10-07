<?php

// JSON feed
header('Content-Type: application/json; charset=utf-8');

$dirname = dirname(__FILE__).'/GeoLite2/';
$fileIPZIP = 'geoip-IPv4.csv.zip';
$fileIP = 'geoip-IPv4.csv';
$fileLOC = 'locations-en.csv';

// $ip = "24.114.49.94";
$ip = '135.23.244.166';

$geo_id = null;
$loc = array();

/**
 * Function for comparing a CIDR network range
 * with a user's IP to see if the user is in that network
 */
function ipCIDRCheck( $IP, $CIDR ) {
    list ($net, $mask) = split ( "/", $CIDR );

    $ip_net = ip2long( $net );
    $ip_mask = ~((1 << (32 - $mask)) - 1);

    $ip_ip = ip2long( $IP );

    $ip_ip_net = $ip_ip & $ip_mask;

    return ($ip_ip_net == $ip_net);
}

// check if geoIP file needs extracting
if( !file_exists($dirname.$fileIP) || filesize($dirname.$fileIP)<=0 ) {

    $archive = zip_open( $dirname.$fileIPZIP );
    while( $entry = zip_read( $archive ) ) {
        $size = zip_entry_filesize( $entry );
        if( zip_entry_name( $entry ) != $fileIP ) {
            continue;
        }
        $name = $dirname.$fileIP;
        $unzipped = fopen( $name, 'wb' );
        while( $size > 0 ){
            $chunkSize = ( $size > 10240 ) ? 10240 : $size;
            $size -= $chunkSize;
            $chunk = zip_entry_read( $entry, $chunkSize );
            if( $chunk !== false ) fwrite( $unzipped, $chunk );
        }

        fclose( $unzipped );
    }

}

// loop over the geoip file
// find a matching network
$row = 0;
if ( ( $handle = fopen( $dirname.$fileIP, 'r' ) ) !== FALSE ) {
    while ( ( $data = fgetcsv( $handle, 1000, ',' ) ) !== FALSE ) {
        $num = count( $data );
        $row++;
        if( $row > 1 ) {
            // get network
            $range = $data[0];
            // check if user's IP matches network
            if( ipCIDRCheck( $ip, $range ) ) {
                $geo_id = $data[1];
                $loc['postal'] = $data[6];
                $loc['lat'] = $data[7];
                $loc['lng'] = $data[8];
                break;
            }
        }
    }
}

// if a geo_id match is found then
// loop over the locations file to find
// country, province, city
if( $geo_id != null ) {
    $row = 0;
    if ( ( $handle = fopen( $dirname.$fileLOC, 'r' ) ) !== FALSE ) {
        while ( ( $data = fgetcsv( $handle, 1000, ',' ) ) !== FALSE ) {
            $num = count( $data );
            $row++;
            if( $row > 1 ) {
                // check if geo_id matches this row
                if( $geo_id == $data[0] ) {
                    $loc['country_code'] = $data[4];
                    $loc['country_name'] = $data[5];
                    $loc['province_code'] = $data[6];
                    $loc['province_name'] = $data[7];
                    $loc['city_code'] = $data[0];
                    $loc['city_name'] = $data[10];
                    break;
                }
            }
        }
    }
}

// output
echo json_encode( $loc, JSON_UNESCAPED_UNICODE );

