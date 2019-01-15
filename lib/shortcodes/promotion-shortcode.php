<?php

// [lnb-lennox-promotions]
add_shortcode( 'lnb-lennox-promotions', 'lnb_lennox_promotions_shortcode' );

function lnb_lennox_promotions_shortcode ( $atts ) {

	$atts = shortcode_atts(array(
		'sidebar' => 'no',
	), $atts );

	$APIKEY = get_option('lnb_lennox_api_key');
	$NOPROMOMESSAGE = get_option('lnb_lennox_nopromo_message');
	$NOPROMOLINK = get_option('lnb_lennox_nopromo_link');
	$SITETITLE = get_bloginfo("name");

	?>
	<?php
		//LIVE PROMO API URL - will return promo ONLY IF one is currently active
		$api_url = "http://lennox.com/api/v1/" . $APIKEY . "/promotions/";


		//use the handy SimpleXML file loader
		$xml = simplexml_load_file($api_url);
		//SimpleXML will either return FALSE is unsuccessful
		//or an XML object if successful.
		if ($xml) {

			if ($xml->Promotion) {
				if ($atts['sidebar'] == 'yes') {
					$promo = $xml->Promotion->Sidebar;
					$response = '<div class="lennox-promo-container-sidebar">';
						if ($promo->Image):
							$response .= '<img style="width:100%" src="'.$promo->Image.'" alt="Lennox Promotion">';
						endif;
						if ($promo->Body):
							$response .= $promo->Body;
						endif;
		            $repsonse .= '</div>';
				} else {
					$promo = $xml->Promotion;

					$response = '<div class="lennox-promo-container test">';
						/*if ($promo->Page->Headline):
							$response .= '<h2>'.$promo->Page->Headline.'</h2>';
						endif;*/
						if ($promo->Page->Image):
							$response .= '<img style="width:100%" src="'.$promo->Page->Image.'" alt="Lennox Promotion">';
						endif;
						if ($promo->Page->Body):
							$response .= $promo->Page->Body;
						endif;
						if ($promo->Page->Details):
							$reponse .= $promo->Page->Details;
						endif;
						if ($promo->Page->Disclaimer):
							$response .= $promo->Page->Disclaimer;
						endif;
		            $repsonse .= '</div>';
		            $response .='</div><div class="lnb-clear" style="clear:both"></div>';
				}

			} //if Promo
			else {
				//$response = $xml->Response;
				$response = '<div style="font-size:1.2em; font-weight:bold">' . $NOPROMOMESSAGE . ' Click <a href="' .$NOPROMOLINK. '">here</a> for additional coupons and promotions offered by ' .$SITETITLE. '</div>';
			}

		} else {
			$response = "<p>There has been an error retrieving the XML.</p>";
		}
		return $response;

	?>

<?php } ?>