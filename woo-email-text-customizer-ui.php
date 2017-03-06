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
		echo '<div class="wrap">';
		echo '<h1 class="wp-heading-inline">Email Template Text Customizer </h1>';
		echo '<select name="email-template" id="wetc-email-template">';
		foreach ( new DirectoryIterator( plugin_dir_path( __FILE__ ) . "assets/email-templates" ) as $file ) {
			if ( $file->isFile() ) {
				print '<option>' . $file->getFilename() . '</option>';
			}
		}
		echo '</select>';
		echo '</div>';
	}

	private function pluginHeader() {

		$headsAttribs = "";


		echo $headsAttribs;
	}
}