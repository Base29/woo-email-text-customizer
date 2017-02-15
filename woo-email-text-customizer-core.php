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
        add_action('init', array($this, 'wetcOnActivation'));
    }

    /**
     * Upon Activation
     *
     * Method to verify whether WooCommerce is installed and activated.
     */
    function wetcOnActivation(){
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
        echo '<p>Email Text Customizer for WooCommerce requires WooCommerce to be activated in order to work.</p>';
        echo '</div>';
    }

}