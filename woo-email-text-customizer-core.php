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
    function wetcCoreHooks(){

        if(class_exists('WooCommerce')) {

            // Registration hook
            register_activation_hook(plugin_basename('woo-email-text-customizer/woo-email-text-customizer.php'), array($this, 'wetcOnActivation'));

        } else {
            // Init hook
            add_action('init', array($this, 'wetcWooCheck'));
        }

    }

    /**
     * Upon Activation
     *
     * Method to verify whether WooCommerce is installed and activated.
     */
    function wetcWooCheck(){
        if(!class_exists('WooCommerce')){
            if(is_plugin_active(plugin_basename('woo-email-text-customizer/woo-email-text-customizer.php'))){
                deactivate_plugins(plugin_basename('woo-email-text-customizer/woo-email-text-customizer.php'));
                add_action('admin_notices', array($this, 'wetcWooError'));
            }
        }
    }

	/**
	 * Error Message
	 *
	 * Message to show if Woo Commerce doesn't exists or not activate
	 */
    function wetcWooError(){
        echo '<div class="notice notice-error is-dismissible">';
        echo '<p>'.__('Email Text Customizer for WooCommerce requires WooCommerce to be activated in order to work.', 'woo-email-text-customizer').'</p>';
        echo '</div>';
    }

    /**
     * Copy Email Templates
     *
     * Method for copying woocommerce email templates from plugin to active theme.
     */

    public function wetcOnActivation(){
        $emailTempDir = get_template_directory().'/woocommerce/emails/';
        if(!is_dir($emailTempDir)){
            mkdir($emailTempDir, 0755, true);
            $this->wetcCopyEmailTemps($emailTempDir);
            //$this->wetcRegisterPluginOptions();
        } else {
            $this->wetcCopyEmailTemps($emailTempDir);
            //$this->wetcRegisterPluginOptions();
        }
    }

    /**
     * @param $emailTempDir
     */
    public function wetcCopyEmailTemps($emailTempDir){
        $files = glob(plugin_dir_path(__FILE__) . 'assets/email-templates/*.*');
        foreach ($files as $file) {
            $fileToGo = str_replace(plugin_dir_path(__FILE__).'assets/email-templates/', $emailTempDir, $file);
            copy($file, $fileToGo);
        }
    }

    function wetcRegisterPluginOptions(){
        add_option('wetc_cancelled_order_main_text', 'The order #%d from %s has been cancelled. The order was as follows:');
        add_option('wetc_failed_order_main_text', 'Payment for order #%d from %s has failed. The order was as follows:');
        add_option('wetc_new_order_main_text', 'You have received an order from %s. The order is as follows:');
        add_option('wetc_customer_completed_order_main_text', 'Hi there. Your recent order on %s has been completed. Your order details are shown below for your reference:');
        add_option('wetc_customer_invoice_main_text_pending', 'An order has been created for you on %s. To pay for this order please use the following link: %s');
        add_option('wetc_customer_invoice_main_text_complete', 'Order Completed');
        add_option('wetc_customer_new_account_main_text', 'Thanks for creating an account on %s. Your username is <strong>%s</strong>');
        add_option('wetc_customer_new_account_main_text_generate_pass', 'Your password has been automatically generated: <strong>%s</strong>');
        add_option('wetc_customer_note_main_text', 'Hello, a note has just been added to your order:');
        add_option('wetc_customer_on_hold_order_main_text', 'our order is on-hold until we confirm payment has been received. Your order details are shown below for your reference:');
        add_option('wetc_customer_processing_order_main_text', 'Your order has been received and is now being processed. Your order details are shown below for your reference:');
        add_option('wetc_customer_refunded_order_main_text_partial', 'Hi there. Your order on %s has been partially refunded.');
        add_option('wetc_customer_refunded_order_main_text_full', 'Hi there. Your order on %s has been refunded.');
        add_option('wetc_customer_reset_password_main_text', 'Someone requested that the password be reset for the following account:\n\nUsername: \n\nIf this was a mistake, just ignore this email and nothing will happen.\n\nTo reset your password, visit the following address:\n[ec_reset_password_link]');
        add_option('wetc_all_footer_text', '');

    }

}