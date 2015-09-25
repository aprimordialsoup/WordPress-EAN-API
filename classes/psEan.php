<?php

/**
 * PS EAN API Class
 * Used for generating requests to the EAN API
 * and retrieving the results from the response
 **/
class psEan {

	/**
	 * Constructor function
	 * stores passed customer id, api key, and secret
	 **/
	public function __construct( $cid, $key, $sec ) {
		// store passed variables
		$this->cid = $cid;
		$this->key = $key;
		$this->sec = $sec;
	}

}
