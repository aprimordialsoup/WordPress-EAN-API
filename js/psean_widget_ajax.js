/**
 * This function binds event listeners to the Widget inputs
 */
jQuery(document).ready(function () {

	var $ = jQuery;

	// listen for key presses on the country input
	// drop down a list of matching countries
	$('#ean_country').keyup( function () {
		// get value of country search
		var searchParam = $(this).val();
		var searchLength = searchParam.length;

		console.log('key pressed',searchParam);

		var url = pseanapi_site_url + 'ean/data/countries';

		$.getJSON( url, function (data) {
			// all the data
			// console.log( "data:", data );

			var filtered = $.grep( data, function(v) {
				return v.name.toLowerCase().substr(0,searchLength) === searchParam;
			});

			// filtered data
			console.log( "filtered data: ", filtered );

			// var returnedData = data.AD[0];
			// console.log(returnedData.code);

		}); // end of getJSON
	}); // end of keypress
}) // end of doc ready
