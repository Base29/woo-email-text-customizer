<?php

/*
 * Plugin Name: Email Text Customizer for WooCommerce
 * Plugin URI: https://www.enigmaweb.com.au
 * Description: Allows you to customize the text of all WooCommerce customer emails without having to delve into template code.
 * Author: Enigma Web
 * Author URI: https://www.enigmaweb.com.au
 * Version: 1.0
 * Text Domain: woo-email-text-customizer
 */

/**
 * Class WETC
 *
 * Main class
 */
class WETC {

	/**
	 * Do the magic
	 */
	public function __construct() {

		// Add required files
		$this->wetcRequired();

		// Add loading of plugin functions
		$this->wetcPluginLoad();

		// Add plugin UI components
		$this->wetcPluginUI();

	}

	/**
	 * Load plugin functions
	 */
	public function wetcPluginLoad() {

		/** Plugin core class instance */
		$core = new WETCCore;

		// Plugin core hooks
        $core->wetcCoreHooks();

	}

    public function wetcPluginUI(){

        /** Plugin UI class instance */
        $ui = new WETCUI;

    }

	/**
	 * Required stuff
	 */
	public function wetcRequired() {

		require_once 'woo-email-text-customizer-core.php';
		require_once 'woo-email-text-customizer-ui.php';

	}


}

/** Main Plugin Instance */
$WETC = new WETC;