<?php


$hotelid= $wp_query->query_vars['hotelid'];

echo "this is hotel id ".$hotelid;
// retrieve EAN details
$cid = get_option('ean_cid');
$key = get_option('ean_key');
$sec = get_option('ean_secret');

// instantiate EAN class
$psean = new PS_EAN_API( $cid, $key, $sec );

// TODO:
// instead of hard-coding the location
// receive this from the widget

// hotel info
$hotels = $psean->getHotelInfo($hotelid);
// echo "<h3>".$hotels->{'HotelSummary'}->{'name'}."</h3>";
// echo "<table cellpadding='5' border='1'>";
// echo "<tr>";
// echo "<td style='padding-top: 2px;'>information  =></td><td>". html_entity_decode($hotels->{'HotelDetails'}->{'areaInformation'})."</td>";
// echo "</tr>";
// echo "<tr>";
// echo "<td>\n Room information =><td>".html_entity_decode($hotels->{'HotelDetails'}->{'roomInformation'})."<td/>";
// echo "</tr>";
// echo "<tr>";
// echo "<td>\n check-in time =><td>".$hotels->{'HotelDetails'}->{'checkInTime'}."<td/>";
// echo "</tr>";  
// echo "<tr>";
// echo "<td>\n check-out time =><td>".$hotels->{'HotelDetails'}->{'checkOutTime'}."<td/>";
// echo "</tr>"; 
// echo "<tr>";
// $image =$hotels->{'HotelImages'}->{'HotelImage'};
// echo "<td>\n images =><td>";
// foreach ($image as $key => $value) {
	// echo '</br>'.$value->{'caption'}.'===>'; //.'====>'.'<img src="'.$value->{'url'}.'/>"';
 // echo "<br><a href=".$value->{'url'}."><img src='".$value->{'thumbnailUrl'}."' /></a>";
// }
// echo "<td/>";
// echo "</tr>"; 
// echo "</table>";
	
?>