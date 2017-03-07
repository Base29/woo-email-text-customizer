<?php

/**
 * Class WETCCore
 *
 * For all plugin core functions
 */
class WETCCore {
	
	/**
	 * Core Hooks
	 *
	 * All the hooks for the plugin
	 * goes in this method
	 */
	function wetcCoreHooks() {
		
		if ( class_exists( 'WooCommerce' ) ) {
			
			// Registration hook
			register_activation_hook( plugin_basename( 'woo-email-text-customizer/woo-email-text-customizer.php' ), array(
				$this,
				'wetcOnActivation'
			) );
			
		} else {
			// Init hook
			add_action( 'init', array( $this, 'wetcWooCheck' ) );
		}
		
	}
	
	/**
	 * Upon Activation
	 *
	 * Method to verify whether WooCommerce is installed and activated.
	 */
	function wetcWooCheck() {
		if ( ! class_exists( 'WooCommerce' ) ) {
			if ( is_plugin_active( plugin_basename( 'woo-email-text-customizer/woo-email-text-customizer.php' ) ) ) {
				deactivate_plugins( plugin_basename( 'woo-email-text-customizer/woo-email-text-customizer.php' ) );
				add_action( 'admin_notices', array( $this, 'wetcWooError' ) );
			}
		} else {
			$this->wetcRegisterPluginOptions();
		}
	}
	
	/**
	 * Error Message
	 *
	 * Message to show if Woo Commerce doesn't exists or not activate
	 */
	function wetcWooError() {
		if ( ! class_exists( 'WooCommerce' ) ) {
			
			echo '<div class="notice notice-error is-dismissible">';
			echo '<p>' . __( 'Email Text Customizer for WooCommerce requires WooCommerce to be activated in order to work.', 'woo-email-text-customizer' ) . '</p>';
			echo '</div>';
		}
	}
	
	/**
	 * Copy Email Templates
	 *
	 * Method for copying woocommerce email templates from plugin to active theme.
	 */
	
	public function wetcOnActivation() {
		$emailTempDir = get_template_directory() . '/woocommerce/emails/';
		if ( ! is_dir( $emailTempDir ) ) {
			mkdir( $emailTempDir, 0755, true );
			$this->wetcCopyEmailTemps( $emailTempDir );
			//$this->wetcRegisterPluginOptions();
		} else {
			$this->wetcCopyEmailTemps( $emailTempDir );
			//$this->wetcRegisterPluginOptions();
		}
	}
	
	/**
	 * @param $emailTempDir
	 */
	public function wetcCopyEmailTemps( $emailTempDir ) {
		$files = glob( plugin_dir_path( __FILE__ ) . 'assets/email-templates/*.*' );
		foreach ( $files as $file ) {
			$fileToGo = str_replace( plugin_dir_path( __FILE__ ) . 'assets/email-templates/', $emailTempDir, $file );
			copy( $file, $fileToGo );
		}
	}
	
	function wetcRegisterPluginOptions() {
		add_option( 'wetc_cancelled-order_text', 'The order #%d from %s has been cancelled. The order was as 
		follows:' );
		add_option( 'wetc_failed-order_text', 'Payment for order #%d from %s has failed. The order was as 
		follows:' );
		add_option( 'wetc_new-order_text', 'You have received an order from %s. The order is as follows:' );
		add_option( 'wetc_completed-order_text', 'Hi there. Your recent order on %s has been completed. Your order details are shown below for your reference:' );
		add_option( 'wetc_new-account_text', 'Thanks for creating an account on %s. Your username is 
		<strong>%s</strong>' );
		add_option( 'wetc_customer-note_text', 'Hello, a note has just been added to your order:' );
		add_option( 'wetc_order-on-hold_text', 'our order is on-hold until we confirm payment has been received. Your order details are shown below for your reference:' );
		add_option( 'wetc_processing-order_text', 'Your order has been received and is now being processed. 
		Your order details are shown below for your reference:' );
		add_option( 'wetc_refunded-order_text', 'Hi there. Your order on %s has been refunded.' );
		add_option( 'wetc_reset-password_text', 'Someone requested that the password be reset for the following account:\n\nUsername: \n\nIf this was a mistake, just ignore this email and nothing will happen.\n\nTo reset your password, visit the following address:\n[ec_reset_password_link]' );
		add_option( 'wetc_customer-invoice_text', 'An order has been created for you on %s. To pay for this order please use the following link: %s' );
		add_option( 'wetc_customer_invoice_main_text_complete', 'Order Completed' );
		add_option( 'wetc_customer_new_account_main_text_generate_pass', 'Your password has been automatically generated: <strong>%s</strong>' );
		add_option( 'wetc_customer_refunded_order_main_text_partial', 'Hi there. Your order on %s has been partially refunded.' );
		add_option( 'wetc_all_footer_text', '' );
		
	}
	
}