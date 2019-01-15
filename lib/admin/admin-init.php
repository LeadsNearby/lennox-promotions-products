<?php

class lennox_admin_page {

	function __construct() {
		add_action( 'admin_menu', array( $this, 'lennox_admin_menu' ) );
	}

	function lennox_admin_menu() {
		add_options_page(
			'Lennox',
			'Lennox',
			'manage_options',
			'lennox-options',
			array(
				$this,
				'lennox_settings_page'
			)
		);
	}

	function lennox_settings_page() {
		
		if ( count($_POST) > 0 ) {
			$options = array (
				'lennox_api_key'
			);

			foreach ( $options as $opt ) {
				$old_value = get_option('lnb_'.$opt);
				$new_value = $_POST[$opt];
				if ($old_value != $new_value) {
					update_option('lnb_'.$opt, $new_value);
				}
			}			
		}

		// Add the html for the admin page
		ob_start(); ?>
		<div style="padding: 30px;">
			<img src="<? echo  Lennox_ASSETS . '/logo.png' ?>" />
			<form method="post" action="">
				<fieldset>
					<table>
						<tr>
							<td class="form-field">
						        <label style="font-weight:bold;" for="lennox_api_key">API Key</label>
								<input name="lennox_api_key" type="text" id="lennox_api_key" class="medium" value="<?php echo get_option('lnb_lennox_api_key'); ?>"/>
								<p><em>The API key is provided by Lennox</em></p>
							</td>
						</tr>
						<tr>
							<td class="form-field">
							    <label style="font-weight:bold;" for="lennox_nopromo_message">No Promo Message</label>
								<input name="lennox_nopromo_message" type="text" id="lennox_nopromo_message" class="medium" value="<?php echo get_option('lnb_lennox_nopromo_message'); ?>"/>
								<p><em>Add a messsage here if no national Lennox promotion is available</em></p>
							</td>
						</tr>
						<tr>
							<td class="form-field">
							    <label style="font-weight:bold;" for="lennox_nopromo_link">No Promo Link</label>
								<input name="lennox_nopromo_link" type="text" id="lennox_nopromo_link" class="medium" value="<?php echo get_option('lnb_lennox_nopromo_link'); ?>"/>
								<p><em>Add a URL to send a person if a no national Lennox promotion is available</em></p>
							</td>
						</tr>
						<tr>
							<td colspan="2">
								<p class="submit">
									<input type="submit" name="Submit" class="button-primary" value="Save Changes" />
									<input type="hidden" name="lnb_lennox_admin_html" value="save" style="display:none;" />
								</p>
							</td>
						</tr>												
					</table>			
				</fieldset>
			</form>
		</div>
		<? echo ob_get_clean();
	}
}

?>