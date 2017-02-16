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
            register_activation_hook(plugin_basename('woo-email-text-customizer/woo-email-text-customizer.php'), array($this, 'wetcCheckWooDir'));

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

    public function wetcCheckWooDir(){
        $emailTempDir = get_template_directory().'/woocommerce/emails/';
        if(!is_dir($emailTempDir)){
            mkdir($emailTempDir, 0755, true);
            $this->wetcCopyEmailTemps($emailTempDir);
        } else {
            $this->wetcCopyEmailTemps($emailTempDir);
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

}