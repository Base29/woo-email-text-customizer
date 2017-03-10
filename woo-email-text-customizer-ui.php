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
		add_action( 'init', array( $this, 'load' ) );
		add_action( 'admin_init', array( $this, 'wetcRegisterSettings' ) );
		add_action( 'admin_menu', array( $this, 'adminMenu' ) );
		add_action( 'admin_head', array( $this, 'pluginHeader' ) );
		
	}
	
	public function load() {
		if ( class_exists( 'WC_Emails' ) ) {
			$wc_emails = WC_Emails::instance();
			$emails    = $wc_emails->get_emails();
			if ( ! empty( $emails ) ) {
				$this->emails = $emails;
			}
		}
		
	}
	
	public function wetcRegisterSettings() {
		foreach ( $this->emails as $index => $email ) {
			$name = 'wetc_' . str_replace( " ", "-", strtolower( $email->title ) ) . '_text';
			register_setting('wetc-settings', $name);
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
				<form method="post" action="options.php">
					<?php settings_fields( 'wetc-settings' ); ?>
					<?php do_settings_sections( 'wetc-settings' ); ?>
					<table class="widefat fixed" cellspacing="0">
						<thead>
						<th id="columnname" class="manage-column column-columnname wetc-template" scope="col"
						    colspan="2"><p><strong>Template
									Name</strong></p></th>
						<th id="columnname" class="manage-column column-columnname wetc-template" scope="col"
						    colspan="8"><p><strong>Template
									Heading Text</strong></p></th>
						</tr>
						</thead>
						<tbody>
						<input type="hidden" name="email-template-form" value="true">
						<?php
						foreach ( $this->emails as $index => $email ) {
							$name = 'wetc_' . str_replace( " ", "-", strtolower( $email->title ) ) . '_text';
							?>
							<tr>
								<td colspan="2" class="column-columnname"><p
										class="wetc-template"><?php echo $email->title; ?></p></td>
								<td colspan="8" class="column-columnname">
								<textarea name="<?php echo $name; ?>" style="resize: none;" class="wetc-textarea"><?php
									echo get_option( $name, 'N/A' );
									?></textarea>
								</td>
							</tr>
								
						<?php }
						echo '<tr><td>';
						submit_button();
						echo '</td></tr>';
						?>
						</tbody>
					</table>
				</form>
			</div>
		</div>
		<?php
	}
	
	public function pluginHeader() {
		wp_enqueue_style( 'wetc_styles', plugins_url( "assets/css/style.css", __FILE__ ) );
	}
	
//	public function saveOptions() {
//		if ( isset( $_REQUEST['wetc-email-template-form'] ) ) {
//			echo '<pre>';
//			print_r( $_REQUEST );
//			echo '</pre>';
//			update_option( 'wetc_new-order_text', $_REQUEST['wetc_new-order_text'] );
//			update_option( 'wetc_cancelled-order_text', $_REQUEST['wetc_cancelled-order_text'] );
//			update_option( 'wetc_failed-order_text', $_REQUEST['wetc_failed-order_text'] );
//			update_option( 'wetc_order-on-hold_text', $_REQUEST['wetc_order-on-hold_text'] );
//			update_option( 'wetc_processing-order_text', $_REQUEST['wetc_processing-order_text'] );
//			update_option( 'wetc_completed-order_text', $_REQUEST['wetc_completed-order_text'] );
//			update_option( 'wetc_refunded-order_text', $_REQUEST['wetc_refunded-order_text'] );
//			update_option( 'wetc_customer-invoice_text', $_REQUEST['wetc_customer-invoice_text'] );//
//			update_option( 'wetc_customer-note_text', $_REQUEST['wetc_customer-note_text'] );//
//			update_option( 'wetc_reset-password_text', $_REQUEST['wetc_reset-password_text'] );//
//			update_option( 'wetc_new-account_text', $_REQUEST['wetc_new-account_text'] ); //
//		}
//	}
}