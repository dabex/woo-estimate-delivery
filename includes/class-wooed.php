 <?php

class Woo_Estimate_Delivery {

	protected $loader;
	private $plugin_name;
	private $version;

	public function __construct() {

		if ( defined( 'WOOEDD_VERSION' ) ) {
			$this->version = WOOEDD_VERSION;
		} else {
			$this->version = '1.0.0';
		}
		$this->plugin_name = 'estimate_betterwoo';

		$this->betterwoo_load_dependencies();
		$this->betterwoo_set_locale();
		$this->betterwoo_admin_hooks();
		$this->betterwoo_public_hooks();

	}

	private function betterwoo_load_dependencies() {

		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-estimate-delivery-loader.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-estimate-delivery-admin.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-estimate-delivery-public.php';
		//require_once plugin_dir_path( dirname( __FILE__ ) ) . 'templates/woocommerce/single-product/add-to-cart/variation.php';
		$this->loader = new Woo_Estimate_Delivery_Loader();

	}

	private function betterwoo_set_locale() {

		$this->loader->add_action( 'plugins_loaded', $this, 'load_plugin_textdomain' );

	}

	private function betterwoo_admin_hooks() {
		$edd_admin = new Woo_Estimate_Delivery_Admin( $this->plugin_name, $this->version );
		$this->loader->add_filter( 'woocommerce_get_settings_pages', $edd_admin, 'edd_setting_page' );
		$this->loader->add_filter( 'plugin_action_links', $edd_admin, 'action_links', 10, 2 );
		$this->loader->add_action( 'admin_enqueue_scripts', $edd_admin, 'enqueue_color_picker');
		$this->loader->add_action( 'plugin_action_links_' . WOOEDD_SLUG, $edd_admin, 'settings_links', 15 );
		$this->loader->add_action( 'save_post', $edd_admin, 'update_product_meta' );
        $this->loader->add_action( 'woocommerce_product_options_shipping', $edd_admin, 'edd_simple_product' );
        $this->loader->add_action( 'woocommerce_variation_options_pricing', $edd_admin, 'delivery_date_variations', 10, 5 );
        $this->loader->add_action( 'woocommerce_save_product_variation', $edd_admin, 'betterwoo_save_variations', 10, 2 );
        $this->loader->add_action( 'woocommerce_locate_template', $edd_admin, 'better_wc_template', 10, 3 );
	}

	private function betterwoo_public_hooks() {

		$edd_public = new Woo_Estimate_Delivery_Public();
		$options = get_option( 'edd_settings', array() );
		if($options['show_delivery_in_cart'] == 'yes' ) {
		$this->loader->add_filter( 'woocommerce_get_item_data', $edd_public, 'edd_on_cart_and_checkout', 10, 2 );
		}
		$this->loader->add_filter( 'woocommerce_available_variation', $edd_public, 'betterwoo_add_variations_data' );
		$this->loader->add_filter( $options['single_product_position'], $edd_public, 'show_delivery_date_single_product', 6 );	
	}

	public function run() {
		$this->loader->run();
	}

	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'estimate_betterwoo',
			false,
			dirname( plugin_basename( __FILE__ ) ) . '/languages/'
		);

	}

}
