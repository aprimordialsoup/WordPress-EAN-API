<script type="text/javascript" charset="utf-8" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.0.0-alpha1/jquery.min.js"></script>

<?php


echo "<br/>start<br/>";

// retrieve EAN details
$cid = get_option('psean_cid');
$key = get_option('psean_key');
$sec = get_option('psean_secret');

// instantiate EAN class
$psean = new PS_EAN_API( $cid, $key, $sec );

// TODO:
// instead of hard-coding the location
// receive this from the widget

// test hotel list call

//receiving location from widget

$country = $wp_query->query_vars['ean_country'];
$province = $wp_query->query_vars['ean_prov'];
$city = $wp_query->query_vars['ean_city'];
$ncity = urlencode($city);
$hotels = $psean->getHotelList( $country, $province, $ncity );

echo "<br/>";
if($hotels == NULL){
	echo "check location parameters";
}
else {
echo "<div id='content'>";
$psean->more($hotels);
echo "</div>";
echo "<br/>finish<br/>";
}
// TODO:
//append whole more() function in #content div
?>
<button id="but">more results</button>
<script>
$("#but").click(function(){
	$("#content").append("here to append more element</br>");
});
</script>