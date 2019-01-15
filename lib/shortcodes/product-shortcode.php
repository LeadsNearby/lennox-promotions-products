<?php
/*
 *
 * 	PRODUCT CATEGORIES LISTING
 *
 */
// [lnb-lennox-products]

add_shortcode( 'lnb-lennox-products', 'lnb_lennox_products_shortcode' );

function lnb_lennox_products_shortcode ( $atts ) {
	if ( get_option('lnb_lennox_api_key') != '' ) {
		if ( $_GET['cat'] != ''  ) {
			$lennoxDataType = 'category';
			$xml = lennox_get_xml( $lennoxDataType, $_GET['cat'] );
			$html = lennox_product_listing_xml_convert( $xml );
			return $html;
		}

		elseif ( $_GET['product'] != '' ) {
			$lennoxDataType = 'product';
			$lennoxProductID = str_replace(' ', '%20', $_GET['product'] );
			$xml = lennox_get_xml( $lennoxDataType, $lennoxProductID );
			$html = lennox_product_detail_xml_convert( $xml );
			return $html;
		}

		else {
			$xml = lennox_get_xml();
			$html = lennox_cat_main_xml_convert( $xml );
			return $html;
		}
	} else {
		return 'Please insert a valid API Key';
	}
}

?>
