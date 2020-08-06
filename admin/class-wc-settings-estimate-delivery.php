<?php
/**
 * WooCommerce Facturare Settings
 *
 * @package WooCommerce/Admin
 * @version 2.4.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( class_exists( 'Woo_Estimate_Delivery_Settings', false ) ) {
	return new Woo_Estimate_Delivery_Settings();
}

/**
 * Woo_Estimate_Delivery_Settings.
 */
class Woo_Estimate_Delivery_Settings extends WC_Settings_Page
            {
                public function __construct()
                {
                    $this->id = 'estimate_delivery';
                    $this->label = esc_html__( 'Estimate Delivery', 'estimate_betterwoo' );
                    add_filter( 'woocommerce_settings_tabs_array', array( $this, 'add_settings_page' ), 20 );
                    add_action( 'woocommerce_settings_' . $this->id, array( $this, 'output' ) );
                    add_action( 'woocommerce_settings_save_' . $this->id, array( $this, 'save' ) );
                    add_action( 'woocommerce_sections_' . $this->id, array( $this, 'output_sections' ) );
                }
                
                public function get_sections()
                {
                    $sections = array(
                        '' => esc_html__( 'General Settings', 'estimate_betterwoo' ),
                    );
                    return apply_filters( 'woocommerce_get_sections_' . $this->id, $sections );
                }
                
                public function get_settings( $current_section = '' )
                {
                    if ( '' == $current_section ) {
                        $settings = apply_filters( 'estimate_betterwoo_settings', array(
                            array(
                            'name' => esc_html__( 'Estimate Delivery Date Settings', 'estimate_betterwoo' ),
                            'type' => 'title',
                            'desc' => '',
                            'id'   => 'edd_title',
                        ),
                            array(
                            'type'    => 'checkbox',
                            'id'      => 'edd_settings[exclude_weekends]',
                            'name'    => esc_html__( 'Exclude Weekends?', 'estimate_betterwoo' ),
                            'desc'    => esc_html__( 'Enable if you want to exclude weekends.', 'estimate_betterwoo' ),
                            'default' => 'no',
                        ),
                            array(
                            'type'    => 'checkbox',
                            'id'      => 'edd_settings[display_range]',
                            'name'    => esc_html__( 'Display as a range?', 'estimate_betterwoo' ),
                            'desc'    => esc_html__( 'Enable if you want to display estimate delivery date as a range of dates(wed, 22 feb - thu, 23 feb).', 'estimate_betterwoo' ),
                            'default' => 'no',
                        ),
                            array(
                            'type'        => 'text',
                            'id'          => 'edd_settings[delivery_message]',
                            'name'        => esc_html__( 'Global Message', 'estimate_betterwoo' ),
                            'placeholder' => esc_html__( 'Expected Delivery', 'estimate_betterwoo' ),
                            'desc'        => esc_html__( 'You can use this to change the defaut message for Estimate Delivery.', 'estimate_betterwoo' ),
                        ),
                            array(
                            'type'     => 'radio',
                            'id'       => 'edd_settings[date_format]',
                            'name'     => esc_html__( 'Date Format', 'estimate_betterwoo' ),
                            'desc'     => esc_html__( 'Choose your shopping closing time. This option will be useful for next day delivery. ', 'estimate_betterwoo' ),
                            'options'  => array(
                            'j F Y' => esc_html__( '24 July 2020', 'estimate_betterwoo' ),
                            'Y-m-d' => esc_html__( '2020-07-24', 'estimate_betterwoo' ),
                            'm/d/Y' => esc_html__( '07/24/2020', 'estimate_betterwoo' ),
                            'd/m/Y' => esc_html__( '24/07/2020', 'estimate_betterwoo' ),
                            'l, j F' => esc_html__( 'Friday, 24 July', 'estimate_betterwoo' ),
                        ),
                            'desc_tip' => true,
                        ),
                            array(
                            'type'               => 'text',
                            'id'                 => 'edd_settings[color]',
                            'name'               => esc_html__( 'Font Color Global Delivery Message' ),
                            'class'              => 'textedd-color',
                            'desc'               => '',
                            'data-default-color' => '#000',
                            'desc_tip' => false,
                        ),
                            array(
                            'type'               => 'text',
                            'id'                 => 'edd_settings[date_color]',
                            'name'               => esc_html__( 'Font Color for Delivery Date' ),
                            'class'              => 'deledd-color',
                            'desc'               => '',
                            'data-default-color' => '#000',
                            'desc_tip' => false,
                        ),
                            array(
                            'type'    => 'checkbox',
                            'id'      => 'edd_settings[next_day_delivery]',
                            'name'    => esc_html__( 'Next day delivery?', 'estimate_betterwoo' ),
                            'desc'    => esc_html__( 'Enable if you delivery in just 1 working day.', 'estimate_betterwoo' ),
                            'default' => 'no',
                        ),
                            array(
                            'type'     => 'select',
                            'id'       => 'edd_settings[closing_time]',
                            'name'     => esc_html__( 'Closing Time', 'estimate_betterwoo' ),
                            'desc'     => esc_html__( 'Choose your shopping closing time. This option will be useful for next day delivery. ', 'estimate_betterwoo' ),
                            'options'  => array(
                                '01' => esc_html__( '01:00', 'estimate_betterwoo' ),
                                '02' => esc_html__( '02:00', 'estimate_betterwoo' ),
                                '03' => esc_html__( '03:00', 'estimate_betterwoo' ),
                                '04' => esc_html__( '04:00', 'estimate_betterwoo' ),
                                '05' => esc_html__( '05:00', 'estimate_betterwoo' ),
                                '06' => esc_html__( '06:00', 'estimate_betterwoo' ),
                                '07' => esc_html__( '07:00', 'estimate_betterwoo' ),
                                '08' => esc_html__( '08:00', 'estimate_betterwoo' ),
                                '09' => esc_html__( '09:00', 'estimate_betterwoo' ),
                                '10' => esc_html__( '10:00', 'estimate_betterwoo' ),
                                '11' => esc_html__( '11:00', 'estimate_betterwoo' ),
                                '12' => esc_html__( '12:00', 'estimate_betterwoo' ),
                                '13' => esc_html__( '13:00', 'estimate_betterwoo' ),
                                '14' => esc_html__( '14:00', 'estimate_betterwoo' ),
                                '15' => esc_html__( '15:00', 'estimate_betterwoo' ),
                                '16' => esc_html__( '16:00', 'estimate_betterwoo' ),
                                '17' => esc_html__( '17:00', 'estimate_betterwoo' ),
                                '18' => esc_html__( '18:00', 'estimate_betterwoo' ),
                                '19' => esc_html__( '19:00', 'estimate_betterwoo' ),
                                '20' => esc_html__( '20:00', 'estimate_betterwoo' ),
                                '21' => esc_html__( '21:00', 'estimate_betterwoo' ),
                                '22' => esc_html__( '22:00', 'estimate_betterwoo' ),
                                '23' => esc_html__( '23:00', 'estimate_betterwoo' ),
                                '23' => esc_html__( '00:00', 'estimate_betterwoo' ),
                        ),
                            'desc_tip' => false,
                        ),
                            array(
                            'type' => 'number',
                            'id'   => 'edd_settings[global_delivery]',
                            'name' => esc_html__( 'Global Estimate Delivery' ),
                            'desc' => esc_html__( 'Set number of days for Estimate Delivery (all of your products)', 'estimate_betterwoo' ),
                        ),
                            array(
                            'type'    => 'radio',
                            'id'      => 'edd_settings[single_product_position]',
                            'name'    => esc_html__( 'Delivery Date Position', 'estimate_betterwoo' ),
                            'desc'    => esc_html__( 'Choose where do you want to show Delivery Date in product page', 'estimate_betterwoo' ),
                            'options'  => array(
                                'woocommerce_before_add_to_cart_form' => esc_html__( 'Before Add to Cart', 'estimate_betterwoo' ),
                                'woocommerce_after_add_to_cart_form' => esc_html__( 'After Add to Cart', 'estimate_betterwoo' ),
                                'woocommerce_product_meta_end' => esc_html__( 'After Product Meta', 'estimate_betterwoo' ),
                                'woocommerce_single_product_summary' => esc_html__( 'After Product Title', 'estimate_betterwoo' ),
                        ),
                            'desc_tip' => true,
                        ),
                            array(
                            'type'    => 'checkbox',
                            'id'      => 'edd_settings[show_delivery_in_cart]',
                            'name'    => esc_html__( 'Show Delivery Date in Cart/Checkout Page', 'estimate_betterwoo' ),
                            'desc'    => esc_html__( 'Enable if you want to show Delivery Date in Cart/Checkout Page', 'estimate_betterwoo' ),
                            'default' => 'no',
                        ),
                        
                            array(
                            'type' => 'sectionend',
                            'id'   => 'edd_title',
                        ),
                        array(
                            'name' => esc_html__( 'Holiday Period', 'estimate_betterwoo' ),
                            'type' => 'title',
                            'desc' => '',
                            'id'   => 'edd_title1',
                        ),    
                        array(
                            'type'               => 'date',
                            'id'                 => 'edd_settings[date_from]',
                            'name'               => esc_html__( 'From' ),
                            'class'              => 'date-picker',
                            'desc'               => ''
                        ),
                            array(
                            'type'               => 'date',
                            'id'                 => 'edd_settings[date_to]',
                            'name'               => esc_html__( 'To' ),
                            'class'              => 'date-picker',
                            'desc'               => ''
                        ),
                        array(
                            'type' => 'sectionend',
                            'id'   => 'edd_title1',
                        )
                        )
                        
                         );
                        
                    }
                    return apply_filters( 'woocommerce_get_settings_' . $this->id, $settings, $current_section );
                }
                
                /**
                 * Output the settings
                 *
                 * @since 1.0
                 */
                public function output()
                {
                    global  $current_section ;
                    $settings = $this->get_settings( $current_section );
                    WC_Admin_Settings::output_fields( $settings );
                }
                
                /**
                 * Save settings
                 *
                 * @since 1.0
                 */
                public function save()
                {
                    global  $current_section ;
                    $settings = $this->get_settings( $current_section );
                    WC_Admin_Settings::save_fields( $settings );
                }
                
				
            
            }
            return new Woo_Estimate_Delivery_Settings();