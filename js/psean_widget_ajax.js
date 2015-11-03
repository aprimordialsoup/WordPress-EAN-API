/**
 * This function binds event listeners to the Widget inputs
 */
jQuery(document).ready(function () {

	var $ = jQuery;
	var url = pseanapi_site_url + 'ean/data/countries';

	$.getJSON( url, function (data) {

		// all country data
		//console.log( "data:", data );

		// store data into localStorage
		localStorage['data'] = JSON.stringify(data);

	}); // end of getJSON

	// parse data from localStorage
	var countryData = JSON.parse(localStorage['data']);
	console.log('countryData:', countryData);

	// listen for keypress on #ean_country
	$('#ean_country').keyup(function () {

		// clear output before displaying filtered data
		$('#output').empty();

		// get input of #ean_country
		var searchParam = $(this).val().toLowerCase();
		var searchLength = searchParam.length;
		console.log('keyup: ', searchParam);

		// filter data
		var filtered = $.grep(countryData, function(country) {
				return country.name.toLowerCase().substr(0, searchLength) === searchParam;
		}); // end of filtered
		console.log('filtered data: ', filtered)

		// display data only if search length > 0
		if (searchLength > 0) {

			$.each(filtered, function(index, country) {

					$('#output').append(country.name + '<br>');
			}); // end of filtered
		}

	}) // end of keyup

}) // end of doc ready
