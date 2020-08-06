<?php

class Woo_Estimate_Delivery_Admin {

	public function __construct() {}


	public function edd_setting_page( $settings ) {
		$settings[] = include 'class-wc-settings-estimate-delivery.php';
		return $settings;
	}

	public function edd_simple_product()
{
    $field = array(
        'id'          => 'delivery_date_simple',
        'class'       => 'show_if_simple',
        'label'       => esc_html__( 'Estimate Delivery Date', 'estimate_betterwoo' ),
        'data_type'   => 'number',
        'type'        => 'number',
        'desc_tip'    => 'true',
        'description' => 'Add only number of days',
    );
    woocommerce_wp_text_input( $field );
}
	/**
	 * Update the product meta with extra fields
	*/
	public function update_product_meta( $product_id ) {
	    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
    }
		if ( isset( $_POST['delivery_date_simple'] ) && '' != $_POST['delivery_date_simple'] ) {
		    update_post_meta( $product_id, 'delivery_date_simple', $_POST['delivery_date_simple'] );
		}

	}
	public function delivery_date_variations( $loop, $variation_data, $variation )
    {
    woocommerce_wp_text_input( array(
        'id'          => 'delivery_variation[' . $loop . ']',
        'class'       => 'short',
        'label'       => esc_html__( 'Estimate Delivery Date', 'woocommerce' ),
        'desc_tip'    => 'false',
        'description' => 'Add only number of days.',
        'value'       => get_post_meta( $variation->ID, 'delivery_date_var', true ),
    ) );
    }
    public function betterwoo_save_variations( $variation_id, $i )
    {
    $custom_field = $_POST['delivery_variation'][$i];
    if ( isset( $custom_field ) ) {
        update_post_meta( $variation_id, 'delivery_date_var', esc_attr( $custom_field ) );
    }
    }
    public function better_wc_template( $template, $template_name, $template_path )
    {
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'templates/woocommerce/single-product/add-to-cart/variation.php';
    $template_directory = trailingslashit( plugin_dir_path( __FILE__ ) ) . 'templates/woocommerce/';
    $path = $template_directory . $template_name;
    return ( file_exists( $path ) ? $path : $template );
    }
	public function enqueue_color_picker( $hook_suffix )
    {
    wp_enqueue_style( 'wp-color-picker' );
    wp_enqueue_script(
        'badge-color',
        plugins_url( 'assets/js/color.js', __FILE__ ),
        array( 'wp-color-picker' ),
        false,
        true
    );
	wp_enqueue_style( 'estimate-delivery-style', plugins_url( 'assets/css/estimate-delivery.css', __FILE__ ) );
    }

	public function action_links( $links, $file ){

		if ( 'woo-estimate-delivery/estimate-delivery.php' == $file ) {
			$links[] = '<a href="' . admin_url( 'admin.php?page=wc-settings&tab=estimate-delivery&section' ) . '">' . esc_html__( 'Setari', 'woo-estimate-delivery' ) . '</a>';
		}

		return $links;
	}

	public function settings_links( $links ){

		if ( is_array( $links ) ) {
            $links['estimate-delivery-settings'] = sprintf('<a href="%s">%s</a>', admin_url( 'admin.php?page=wc-settings&tab=estimate-delivery' ), __( 'Settings', 'woo-estimate-delivery' ) );
        }

		return $links;

	}

	}


