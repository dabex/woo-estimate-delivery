<?php
 class Woo_Estimate_Delivery_Public{	
	public function edd_on_cart_and_checkout( $cart_item_data, $cart_item ){
	    $options = get_option( 'edd_settings', array() );
		$delivery_message = $options['delivery_message' ];
        $date_formatz = $options['date_format'];
        $daterange = $options['display_range'];
        $delivery_global = $options['global_delivery'];
        $exclude_weekends = $options['exclude_weekends'];
        $currentTime = current_time( 'G:i' );
        $closing_time = $options['closing_time'];
        $next_day = $options['next_day_delivery'];
        $from_day_holiday = $options['date_from'];
        $to_day_holiday = $options['date_to'];
        $today = current_time( 'Y-m-d' );
        $edd_product = $cart_item['data']->get_meta('delivery_date_simple');
        if($cart_item['data'] -> is_type( 'variation' )){
         $edd_product = $cart_item['data']->get_meta('delivery_date_var');   
        }
        if ($edd_product){
            $delivery_global = $edd_product ;
        }
        if($from_day_holiday <= $today && $today <= $to_day_holiday){
                $ii = 1;
                $today = $to_day_holiday;
            }
        if ( $exclude_weekends == 'yes' ) {
            if ( $next_day == 'yes' ) {
                if ( current_time( 'G' ) < 24 && current_time( 'G' ) >= $closing_time ) {
                    $estimate_delivery = date_i18n( $date_formatz, strtotime($today . ' + 2' . ' Weekday'));
                    $estimate1 = date_i18n( $date_formatz, strtotime($today . ' + 1' . ' Weekday'));
                }
                if ( current_time( 'G' ) < $closing_time && current_time( 'G' ) > 00 ) {
                    $estimate_delivery = date_i18n( $date_formatz, strtotime($today . ' + 1' . ' Weekday'));
                }
            }
            if ( $delivery_global ) {
                $estimate_delivery = date_i18n( $date_formatz, strtotime($today . ' + ' . $delivery_global . ' Weekday'));
                $est1 = $delivery_global - 1;
                $estimate1 = date_i18n( $date_formatz, strtotime($today . ' + ' . $est1 . ' Weekday'));
            }
        }
        if ( $exclude_weekends == 'no' ) {
            if ( $next_day == 'yes' ) {
                if ( current_time( 'G' ) < 24 && current_time( 'G' ) >= $closing_time ) {
                    $estimate_delivery = date_i18n( $date_formatz, strtotime($today . ' + 2' . ' day'));
                    $estimate1 = date_i18n( $date_formatz, strtotime($today . ' + 1' . ' day'));
                }
                if ( current_time( 'G' ) < $closing_time && current_time( 'G' ) > 00 ) {
                    $estimate_delivery = date_i18n( $date_formatz, strtotime($today . ' + 1' . ' day'));
                }
            }
            if ( $delivery_global ) {
                $estimate_delivery = date_i18n( $date_formatz, strtotime($today . ' + ' . $delivery_global . ' day'));
                $est1 = $delivery_global - 1;
                $estimate_delivery = date_i18n( $date_formatz, strtotime($today . ' + ' . $est1 . ' day'));
            }
        }
        if ( $daterange == 'yes' ) {
            $cart_item_data[] = array(
                'name'  => esc_attr($delivery_message),
                'value' => esc_attr($estimate1). ' - ' . esc_attr($estimate_delivery),
            );
        } else {
            $cart_item_data[] = array(
                'name'  => esc_attr($delivery_message),
                'value' => esc_attr($estimate_delivery),
            );
        }
    return $cart_item_data;
	}
	public function show_delivery_date_single_product(){
	    global $product;
	    $options = get_option( 'edd_settings', array() );
	    $delivery_message = $options['delivery_message' ];
        $date_formatz = $options['date_format'];
        $daterange = $options['display_range'];
        $delivery_global = $options['global_delivery'];
        $exclude_weekends = $options['exclude_weekends'];
        $currentTime = current_time( 'G:i' );
        $closing_time = $options['closing_time'];
        $color = $options['color'];
        $datecolor = $options['date_color'];
        $next_day = $options['next_day_delivery'];
        $from_day_holiday = $options['date_from'];
        $to_day_holiday = $options['date_to'];
        $today = current_time( 'Y-m-d' );
        $product_delivery = get_post_meta( $product->get_id(), 'delivery_date_simple', true );
        $estimate_delivery = date_i18n( $date_formatz, strtotime($today . ' + ' . $delivery_global . ' Weekday'));
        if($from_day_holiday <= $today && $today <= $to_day_holiday){
                $ii = 1;
                $today = $to_day_holiday;
            }
	    if($product ->is_type('simple')){
	    if($product_delivery) {
	        $delivery_global = $product_delivery;
	    }
        if ( $exclude_weekends == 'yes' && $next_day == 'yes' ) {
                if ( current_time( 'G' ) < 24 && current_time( 'G' ) >= $closing_time ) {
                    $estimate_delivery = date_i18n( $date_formatz, strtotime($today . ' + 2' . ' Weekday'));
                    $estimate1 = date_i18n( $date_formatz, strtotime($today . ' + 1' . ' Weekday'));
                }
                if ( current_time( 'G' ) < $closing_time && current_time( 'G' ) > 00 ) {
                    $estimate_delivery = date_i18n( $date_formatz, strtotime($today . ' + 1' . ' Weekday'));
                }
            
            }
        if ( $exclude_weekends == 'yes' && $delivery_global ) {
                $estimate_delivery = date_i18n( $date_formatz, strtotime($today . ' + ' . $delivery_global . ' Weekday'));
                $est1 = $delivery_global - 1;
                $estimate1 = date_i18n( $date_formatz, strtotime($today . ' + ' . $est1 . ' Weekday'));
            }
        if ( $exclude_weekends == 'no' && $next_day == 'yes') {
                if ( current_time( 'G' ) < 24 && current_time( 'G' ) >= $closing_time ) {
                    $estimate_delivery = date_i18n( $date_formatz, strtotime($today . ' + 2' . ' day'));
                    $estimate1 = date_i18n( $date_formatz, strtotime($today . ' + 1' . ' day'));
                }
                if ( current_time( 'G' ) < $closing_time && current_time( 'G' ) > 00 ) {
                    $estimate_delivery = date_i18n( $date_formatz, strtotime($today . ' + 1' . ' day'));
                }
        }
        if ( $exclude_weekends == 'no' && $delivery_global ) {
                $estimate_delivery = date_i18n( $date_formatz, strtotime($today . ' + ' . $delivery_global . ' day'));
                $est1 = $delivery_global - 1;
                $estimate_delivery = date_i18n( $date_formatz, strtotime($today . ' + ' . $est1 . ' day'));
            }
        echo  '<div class="estimate-delivery">' ;
        echo  '<div class="text-del">' ;
        echo  '<span class="main-text-del"style="color:' . esc_attr($color) . '">' . esc_attr($delivery_message) . ': </span>' ;
        if ( $daterange == 'yes' ) {
            echo  '<span class="del-text" style="color:' . esc_attr($datecolor) . '"><strong>' . esc_attr($estimate1) . ' - ' . esc_attr($estimate_delivery) . '<strong></span>' ;
        } else {
            echo  '<span class="del-text" style="color:' . esc_attr($datecolor) . '"><strong>' . esc_attr($estimate_delivery) . '<strong></span>' ;
        }
        echo  '</div>' ;
        echo  '</div>' ;            
	    } 
	    }
	public function betterwoo_add_variations_data( $variations ){
        $delivery_var = get_post_meta( $variations['variation_id'], 'delivery_date_var', true );
        $options = get_option( 'edd_settings', array() );
	    $delivery_message = $options['delivery_message' ];
        $date_formatz = $options['date_format'];
        $daterange = $options['display_range'];
        $delivery_global = $options['global_delivery'];
        $exclude_weekends = $options['exclude_weekends'];
        $currentTime = current_time( 'G:i' );
        $closing_time = $options['closing_time'];
        $color = $options['color'];
        $datecolor = $options['date_color'];
        $next_day = $options['next_day_delivery'];
        $from_day_holiday = $options['date_from'];
        $to_day_holiday = $options['date_to'];
        $today = current_time( 'Y-m-d' );
        $variation_obj = wc_get_product( $variations['variation_id'] );
        $estimate_delivery = date_i18n( $date_formatz, strtotime($today . ' + ' . $delivery_global . ' Weekday'));
        if($from_day_holiday <= $today && $today <= $to_day_holiday){
                $ii = 1;
                $today = $to_day_holiday;
            }
        if ( $variation_obj->is_in_stock() ) {
            if (!empty($delivery_var)){
             $delivery_global = $delivery_var;   
            }
            if ( $exclude_weekends == 'yes' ) {
                    $estimate_delivery = date_i18n( $date_formatz, strtotime($today . ' + ' . $delivery_global . ' Weekday'));
                    $est1 = $delivery_global - 1;
                    $estimate1 = date_i18n( $date_formatz, strtotime($today . ' + ' . $est1 . ' Weekday'));
                    if ( $daterange == 'yes' ) {
                        $variations['delivery_variation'] = '<div class="estimate-delivery">' . '<div class="text-del">' . '<span class="main-text-del" style="color:' . esc_attr($color) . '">' . esc_attr($delivery_message) . ': </span>' . '<span class="del-text" style="color:' . esc_attr($datecolor) . '"><strong>' . esc_attr($estimate1) . ' - ' . $estimate_delivery . '<strong></span>' . '</div>' . '</div>';
                    } else {
                        $variations['delivery_variation'] = '<div class="estimate-delivery">' . '</div>' . '<div class="text-del">' . '<span class="main-text-del" style="color:' . esc_attr($color) . '">' . esc_attr($delivery_message) . ': </span>' . '<span class="del-text" style="color:' . $datecolor . '"><strong>' . esc_attr($estimate_delivery) . '<strong></span>' . '</div>' . '</div>';
                    }
                if ( $next_day == 'yes' ) {
                    if ( $today < 24 && $today >= $closing_time ) {
                        $estimate_delivery = date_i18n( $date_formatz, strtotime($today . ' + 2' . ' Weekday'));
                        $estimate1 = date_i18n( $date_formatz, strtotime($today . ' + 1' . ' Weekday'));
                        if ( $daterange == 'yes' ) {
                            $variations['delivery_variation'] = '<div class="estimate-delivery">' . '<div class="text-del">' . '<span class="main-text-del" style="color:' . esc_attr($color) . '">' . esc_attr($delivery_message) . ': </span>' . '<span class="del-text" style="color:' . esc_attr($datecolor) . '"><strong>' . esc_attr($estimate1) . ' - ' . esc_attr($estimate_delivery) . '<strong></span>' . '</div>' . '</div>';
                        } else {
                            $variations['delivery_variation'] = '<div class="estimate-delivery">' . '<div class="text-del">' . '<span class="main-text-del" style="color:' . esc_attr($color) . '">' . esc_attr($delivery_message) . ': </span>' . '<span class="del-text" style="color:' . esc_attr($datecolor) . '"><strong>' . esc_attr($estimate_delivery) . '<strong></span>' . '</div>' . '</div>';
                        }
                    } 
                    if ( $today < $closing_time && $today > 00 ) {
                        $estimate_delivery = date_i18n( $date_formatz, strtotime($today . ' + 1' . ' Weekday'));
                        $variations['delivery_variation'] = '<div class="estimate-delivery">' . '<div class="text-del">' . '<span class="main-text-del" style="color:' . esc_attr($color) . '">' . esc_attr($delivery_message) . ': </span>' . '<span class="del-text" style="color:' . esc_attr($datecolor) . '"><strong>' . esc_attr($estimate_delivery) . '<strong></span>' . '</div>' . '</div>';
                    }
                }
            }
            if ( $exclude_weekends == 'no' ) {
                if ( $delivery_global ) {
                    $estimate_delivery = date_i18n( $date_formatz, strtotime($today . ' + ' . $delivery_global . ' day'));
                    $est1 = $delivery_global - 1;
                    $estimate1 = date_i18n( $date_formatz, strtotime($today . ' + ' . $est1 . ' day'));
                    if ( $daterange == 'yes' ) {
                        $variations['delivery_variation'] = '<div class="estimate-delivery">' . '<div class="text-del">' . '<span class="main-text-del" style="color:' . esc_attr($color) . '">' . esc_attr($delivery_message) . ': </span>' . '<span class="del-text" style="color:' . esc_attr($datecolor) . '"><strong>' . esc_attr($estimate1) . ' - ' . esc_attr($estimate_delivery) . '<strong></span>' . '</div>' . '</div>';
                    } else {
                        $variations['delivery_variation'] = '<div class="estimate-delivery">' . '</div>' . '<div class="text-del">' . '<span class="main-text-del" style="color:' . esc_attr($color) . '">' . esc_attr($delivery_message) . ': </span>' . '<span class="del-text" style="color:' . esc_attr($datecolor) . '"><strong>' . esc_attr($estimate_delivery) . '<strong></span>' . '</div>' . '</div>';
                    }
                }
                if ( $next_day == 'yes' ) {
                    if ( current_time( 'G' ) < 24 && current_time( 'G' ) >= $closing_time ) {
                        $estimate_delivery = date_i18n( $date_formatz, strtotime($today . ' + 2' . ' day'));
                        $estimate1 = date_i18n( $date_formatz, strtotime($today . ' + 1' . ' day'));
                        if ( $daterange == 'yes' ) {
                            $variations['delivery_variation'] = '<div class="estimate-delivery">' . '</div>' . '<div class="text-del">' . '<span class="main-text-del" style="color:' . esc_attr($color) . '">' . esc_attr($delivery_message) . ': </span>' . '<span class="del-text" style="color:' . esc_attr($datecolor) . '"><strong>' . esc_attr($estimate1) . ' - ' . esc_attr($estimate_delivery) . '<strong></span>' . '</div>' . '</div>';
                        } else {
                            $variations['delivery_variation'] = '<div class="estimate-delivery">' . '<div class="text-del">' . '<span class="main-text-del" style="color:' . esc_attr($color) . '">' . esc_attr($delivery_message) . ': </span>' . '<span class="del-text" style="color:' . esc_attr($datecolor) . '"><strong>' . esc_attr($estimate_delivery) . '<strong></span>' . '</div>' . '</div>';
                        }
                    } 
                    if ( $today < $closing_time && $today > 00 ) {
                        $estimate_delivery = date_i18n( $date_formatz, strtotime($today . ' + 1' . ' day'));
                        $variations['delivery_variation'] = '<div class="estimate-delivery">' . '<div class="text-del">' . '<span class="main-text-del" style="color:' . esc_attr($color) . '">' . esc_attr($delivery_message) . ': </span>' . '<span class="del-text" style="color:' . esc_attr($datecolor) . '"><strong>' . esc_attr($estimate_delivery) . '<strong></span>' . '</div>' . '</div>';
                    }
                }
            }           
            return $variations;
        }
    }    
	}
