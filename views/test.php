<?php

echo "<br/>start<br/>";

// retrieve EAN details
$cid = get_option('psean_cid');
$key = get_option('psean_key');
$sec = get_option('psean_secret');

// instantiate EAN class
$psean = new PS_EAN_API( $cid, $key, $sec );

// test hotel list call
$country = "CA";
$province = "ON";
$city = "Toronto";
$hotels = $psean->getHotelList( $country, $province, $city );

echo "<br/>";

foreach ($hotels as $key => $hotel) {
	// echo "bars: $key @ $value<br/><br/>";
	// var_dump( $hotel );
	?>
	<div role='hotel' style='border:1px solid blue;'>
		<img src='<?php echo PS_EAN_API::$IMGURL.$hotel->{'thumbNailUrl'} ?>' />
		<h3><?php echo $hotel->{'name'} ?></h3>
		<div role='ranking'><?php echo $hotel->{'hotelRating'} ?>/5 stars</div>
		<!-- <div role='reviews'>?reviews?</div> -->
		<div role='rate'>
			$<?php echo $hotel->{'RoomRateDetailsList'}->{'RoomRateDetails'}->{'RateInfo'}->{'ChargeableRateInfo'}->{'NightlyRatesPerRoom'}->{'NightlyRate'}->{'@rate'} ?>
			<?php echo $hotel->{'RoomRateDetailsList'}->{'RoomRateDetails'}->{'RateInfo'}->{'ChargeableRateInfo'}->{'@currencyCode'} ?>
		</div>
		<button role='select'>Select <?php echo $hotel->{'hotelId'} ?></button>
	</div>
	<?php
	// echo var_dump( $hotel[ $key ] );
}

echo "<br/>finish<br/>";
