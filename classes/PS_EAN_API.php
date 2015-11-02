<?php

/**
 * PS EAN API Class
 * Used for generating requests to the EAN API
 * and retrieving the results from the response
 **/
class PS_EAN_API {

	public static $IMGURL = "http://images.travelnow.com/";

	private static $URLS = array(
		'hotels' => array(
			'list' => 'http://api.ean.com/ean-services/rs/hotel/v3/list?',
			'info' => 'http://api.ean.com/ean-services/rs/hotel/v3/info?'		)
	);

	/**
	 * Constructor function
	 * stores passed customer id, api key, and secret
	 **/
	public function __construct( $cid, $key, $sec ) {
		// store passed variables
		$this->cid = $cid;
		$this->key = $key;
		$this->sec = $sec;
		// customerSessionId
		$this->csid = isset($_SESSION['csid']) ? $_SESSION['csid'] : null;
	}

	/**
	 * Retrieves a list of hotels for a given location
	 *
	 * @param string $counry The country to search
	 * @param string $province The province to search
	 * @param string $city The city to search
	 *
	 * @return an array of hotels
	 **/
	public function getHotelList( $country, $province, $city ) {
		// construct url base
		$url = PS_EAN_API::$URLS['hotels']['list'];
		$url .= $this->baseURL();
		// append country, province, and city info
		$url .= "&countryCode=$country";
		$url .= "&stateProvinceCode=$province";
		$url .= "&city=$city";
		// append checkin/checkout dates in MM/DD/YYYY format
		$url .= "&arrivalDate=11/01/2015"; // TODO: make this dynamic
		$url .= "&departureDate=11/02/2015";
		// number of results to return does not work for a dateless request
		$url .= "&numberOfResults=5"; // TODO: make this dynamic
		// complete call
		// echo "<br/>[[[ " . $url . "]]]<br/>";
		$resp = $this->completeCall( $url );
		// parse returned data
		//// hotel list
		$list = $resp->{'HotelListResponse'};
		// $size = $list->{'HotelList'}->{'@size'};
		//$htls = $list->{'HotelList'}->{'HotelSummary'};
		//// session id
		$this->csid = $list->{'customerSessionId'};
		$_SESSION['csid'] = $this->csid;
		// return the list of hotels
		return $list;
		// each hotel contains:
		// 
		// @order
		// hotelId
		// airportCode
		// countryCode
		// stateProvinceCode
		// city
		// address1
		// postalCode
		// name
		// supplierType
		// propertyCategory
		// hotelRating
		// confidenceRating
		// amenityMask
		// locationDescription
		// shortDescription
		// highRate
		// lowRate
		// rateCurrencyCode
		// latitude
		// longitude
		// proximityDistance
		// proximityUnit
		// hotelInDestination
		// thumbNailUrl
		// deepLink
		// RoomRateDetailsList
		//// RoomRateDetails
		////// roomTypeCode
		////// rateCode
		////// maxRoomOccupancy
		////// quotedRoomOccupancy
		////// minGuestAge
		////// roomDescription
		////// promoId
		////// promoDescription
		////// currentAllotment
		////// propertyAvailable
		////// propertyRestricted
		////// expediaPropertyId
		////// rateKey
		////// RateInfo
		//////// priceBreakdown
		//////// @promo
		//////// @rateChange
		//////// ChargeableRateInfo
		////////// @averageBaseRate
		////////// @averageRate
		////////// @commissionableUsdTotal
		////////// @currencyCode
		////////// @maxNightlyRate
		////////// @nightlyRateTotal
		////////// @surchargeTotal
		////////// @total
		////////// NightlyRatesPerRoom
		//////////// @size
		//////////// NightlyRate
		////////////// @baseRate
		////////////// @rate
		////////////// @promo
		////////// Surcharges
		//////////// @size
		//////////// Surcharge
		////////////// @type
		////////////// @amount
	}

	/**
	 * TODO: LEAVE A DESCRIPTION
	 */
	public function getHotelInfo( $hotelid ) {
		// construct url base
		$url = PS_EAN_API::$URLS['hotels']['info'];
		$url .= $this->baseURL();

		// append country, province, and city info
		$url .= "&hotelId=$hotelid";
	    $url .= "&options=0";

		// complete call
		// echo "<br/>[[[ " . $url . "]]]<br/>";
		$resp = $this->completeCall( $url );
		// parse returned data
		//// hotel info
		$info = $resp->{'HotelInformationResponse'};
		// $size = $list->{'HotelList'}->{'@size'};
			
		return $info;

	}
	
	/**
	 * Constructs a base URL with
	 * - apiExperience
	 * - cid
	 * - apiKey
	 * - sig
	 * to be used when making a request
	 **/
	private function baseURL() {
		$str = "";
		// apiExperience
		// $str .= "&apiExperience=PARTNER_WEBSITE";
		$str .= "&apiExperience=PARTNER_MOBILE_WEB";
		// cid
		$str .= "&cid=" . $this->cid;
		// apiKey
		$str .= "&apiKey=" . $this->key;
		// sig
		$timestamp = gmdate('U');
		$str .= "&sig=" . md5( $this->key . $this->sec . $timestamp );
		// locale
		// $str .= "&locale=en_CA";
		// currencyCode
		$str .= "&currencyCode=CAD";
		// customerSessionId
		if( isset($this->csid) ) {
			$str .= "&customerSessionId=" . $this->csid;
		}
		// return base
		return $str;
	}

	/**
	 * Completes the call to the API
	 **/
	private function completeCall( $url ) {
		$response = file_get_contents( $url );
		return json_decode( $response );
	}
public function more($hotels){
	set_query_var('cachk', $hotels->{'cacheKey'} );	
	set_query_var('cachl', $hotels->{'cacheLocation'} );
	$hotels = $hotels->{'HotelList'}->{'HotelSummary'};
	
foreach ($hotels as $key => $hotel) {
	// echo "bars: $key @ $value<br/><br/>";
	// var_dump( $hotel );
	?>
	<div role='hotel' style='border:1px solid;'>
		<img src='<?php echo PS_EAN_API::$IMGURL.$hotel->{'thumbNailUrl'} ?>'/>
		<h3><?php echo $hotel->{'name'} ?></h3>
		<div id="rate">
		<?php
		$r =  $hotel->{'hotelRating'};
		// TODO:
		// do not round, instead display full and half stars
		$n = round($r); 
		$x = 0;
		for( $x; $x<$n; $x++ ){
			echo "★";
		}
		?>
		</div>
		<!-- <div role='ranking'><?php echo $hotel->{'hotelRating'} ?>/5 stars</div> -->
		<div role='address'><?php echo $hotel->{'address1'} .", ". $hotel->{'city'} .",". $hotel->{'countryCode'} ?></div>
		<?php /*
			<iframe
			  width="200"
			  height="200"
			  frameborder="0" style="border:0"
			  src="https://www.google.com/maps/embed/v1/view?key=AIzaSyBsQ_K-mlyd_eaBqo7Ms7-2GLunFapyZYI&center=<?php echo $hotel->{'latitude'}.",".$hotel->{'longitude'}?>&zoom=18">
			</iframe>
		*/ ?>
		<!-- <div role='reviews'>?reviews?</div> -->
		<div role='rate'>
			$<?php echo $hotel->{'RoomRateDetailsList'}->{'RoomRateDetails'}->{'RateInfo'}->{'ChargeableRateInfo'}->{'NightlyRatesPerRoom'}->{'NightlyRate'}->{'@rate'} ?>
			<?php echo $hotel->{'RoomRateDetailsList'}->{'RoomRateDetails'}->{'RateInfo'}->{'ChargeableRateInfo'}->{'@currencyCode'} ?>
		</div>,

		<!-- button -->
		<br/>
		<?php $url = get_site_url() . '/' . get_option('psean_base_url') . '/hotel/' . $hotel->{'hotelId'}; ?>
		<a href='<?php echo $url; ?>'>[ Select ]</a>
	</div>
</br>
	<?php
	// echo var_dump( $hotel[ $key ] );
}
}
}
