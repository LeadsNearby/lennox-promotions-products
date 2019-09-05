<?php

/* Make API Call and Return XML */
function lennox_get_xml( $lennoxDataType = null, $lennoxDataID = null) {
	
	$APIKEY = get_option('lnb_lennox_api_key');

	// Set API URL
	$api_url = ( $lennoxDataType ) ? "http://api.lennox.com/v1/".$APIKEY."/".$lennoxDataType."/".$lennoxDataID : "http://api.lennox.com/v1/".$APIKEY."/categories";

	// Get and return XML
	$response = wp_remote_get($api_url);
	$body = wp_remote_retrieve_body($response);
	$xml = simplexml_load_string($body);
	return $xml;
}
