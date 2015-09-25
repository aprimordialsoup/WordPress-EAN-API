<?php

echo "<br/>start<br/>";

// retrieve EAN details
$cid = get_option('ean_cid');
$key = get_option('ean_key');
$sec = get_option('ean_secret');

// instantiate EAN class
$foo = new psEan( $cid, $key, $sec );
var_dump( $foo );

echo "<br/>finish<br/>";
