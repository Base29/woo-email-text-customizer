<?php

/**
 * Class WETCUI
 *
 * For plugin UI
 */
class WETCUI {
	/**
	 * WETCUI constructor.
	 */
	public function __construct() {
		add_action( 'admin_menu', array( $this, 'adminMenu' ) );
		add_action( 'wp_head', array( $this, 'pluginHeader' ) );

	}

	/**
	 * The method will show menu in the WooCommerce
	 */
	public function adminMenu() {
		add_submenu_page( 'woocommerce', 'Email Template Text  Customizer', 'Email Template  Text Customizer', 'manage_options',
			'wetc', array( $this, 'templateCustomizerPage' ) );
	}

	/**
	 * The Function will output the page
	 * */
	public function templateCustomizerPage() {
		echo '<h1 class="wp-heading-inline">Email Template Text Customizer</h1>';
		?>
				<select name="email-template" id="wetc-email-template">
					<?php
					foreach (new DirectoryIterator( plugin_dir_path( __FILE__ ) . "assets/email-templates") as $file) {
						if ($file->isFile()) {
							print '<option>'. $file->getFilename() . '</option>';
						}
					}
					?>
				</select>
		<?php
	}

	private function pluginHeader() {
		$headsAttribs = "";
		$headsAttribs .= '<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>';
		$headsAttribs .= '<script src="http://netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js"></script>';
		$headsAttribs .= '<script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>';

		echo $headsAttribs;

	}
}