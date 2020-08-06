 <?php

/**
 * Plugin Name:       Woocommerce Estimate delivery per Product
 * Plugin URI:        https://wordpress.org/plugins/woo-estimate-delivery/
 * Description:       Add Delivery Date to your products! You can skip your holidays, you can add next day delivery, you can exclude weekend and show delivery date as a date range!
 * Version:           1.0.0
 * Author:            Daniel Florea
 * Text Domain:       estimate_betterwoo
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

define( 'WOOEDD_VERSION', '1.0.0' );
define( 'WOOEDD_SLUG', plugin_basename( __FILE__ ) );
define( 'WOOEDD_PATH', plugin_dir_path( __FILE__ ) );

require plugin_dir_path( __FILE__ ) . 'includes/class-wooed.php';

function run_woo_estimate_delivery() {
		
	$plugin = new Woo_Estimate_Delivery();
	$plugin->run();

}
run_woo_estimate_delivery();
