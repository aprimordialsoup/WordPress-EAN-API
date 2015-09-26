<?php

/**
 * PS EAN API Class
 * Used for generating requests to the EAN API
 * and retrieving the results from the response
 **/
class psEan {

	public static $IMGURL = "http://images.travelnow.com/";

	private static $URLS = array(
		'hotels' => array(
			'list' => 'http://api.ean.com/ean-services/rs/hotel/v3/list?'
		)
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
	 * @param counry
	 * @param province
	 * @param city
	 *
	 * @return an array of hotels
	 **/
	public function getHotelList( $country, $province, $city ) {
		// construct url base
		$url = psEan::$URLS['hotels']['list'];
		$url .= $this->baseURL();
		// append country, province, and city info
		$url .= "&countryCode=$country";
		$url .= "&stateProvinceCode=$province";
		$url .= "&city=$city";
		// append checkin/checkout dates in MM/DD/YYYY format
		$url .= "&arrivalDate=11/01/2015"; // TODO: make this dynamic
		$url .= "&departureDate=11/02/2015";
		// number of results to return does not work for a dateless request
		$url .= "&numberOfResults=50"; // TODO: make this dynamic
		// complete call
		// echo "<br/>[[[ " . $url . "]]]<br/>";
		$resp = $this->completeCall( $url );
		// parse returned data
		//// hotel list
		$list = $resp->{'HotelListResponse'};
		// $size = $list->{'HotelList'}->{'@size'};
		$htls = $list->{'HotelList'}->{'HotelSummary'};
		//// session id
		$this->csid = $list->{'customerSessionId'};
		$_SESSION['csid'] = $this->csid;
		// return the list of hotels
		return $htls;
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

}
