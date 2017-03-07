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
	private $emails = null;
	
	public function __construct() {
		add_action('init', array($this, 'load') );
		add_action( 'admin_menu', array( $this, 'adminMenu' ) );
		add_action( 'admin_head', array( $this, 'pluginHeader' ) );
		
	}
	
	public function load(){
		if( class_exists('WC_Emails') ){
			$wc_emails = WC_Emails::instance();
			$emails = $wc_emails->get_emails();
			if( !empty($emails) )
				$this->emails = $emails;
		}
		
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
		?>
		<div class="wrap">
			<h1 class="">Email Template Text Customizer </h1>
			<h4>Please enter "#%d" for where you want the price to appear.</h4>
			<h4>Please enter "%s" for where you want the name to appear.</h4>
			<hr/>
			<div class="">
				<table class="widefat fixed" cellspacing="0">
					
					<?php
					foreach ( $this->emails as $index => $email ) { ?>
						<tr>
							<td><?php echo $email->title; ?></td>
						</tr>
					<?php }
					
					/*foreach (
						new DirectoryIterator( plugin_dir_path( __FILE__ ) . "assets/email-templates" ) as
						$file
					) { */?><!--
						<tr>
							<?php
/*							if ( $file->isFile() ) {
								print '<td>' . $file->getFilename() . '</td>';
								print '<td><textarea></textarea></td>';
							} */?>
						</tr>
						--><?php
/*					}*/
					?>
				</table>
			</div>
		</div>
		<?php
	}
	
	public
	function pluginHeader() {
		wp_enqueue_style( 'wetc_styles', plugins_url( "assets/css/style.css", __FILE__ ) );
	}
	
}