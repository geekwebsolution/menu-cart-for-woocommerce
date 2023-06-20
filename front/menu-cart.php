<?php
if (!class_exists('mcfwp_menu_cart')) {
    $mcfwp_general_options = get_option('mcfwp_general_options');
    $mcfwp_flyout_options=get_option('mcfwp_flyout_options');
    $mcfwp_design_options = get_option('mcfwp_design_options');

    class mcfwp_menu_cart{
        public function __construct() {
            add_action( 'woocommerce_init', array( $this, 'mcfwp_set_menu' ) );  
        }
        
        public function mcfwp_set_menu(){
            global $mcfwp_general_options;
            if (isset($mcfwp_general_options['menu_id']) && !empty($mcfwp_general_options['menu_id'])) {
                add_filter( 'wp_nav_menu_items', array( $this, 'add_menus' ), 10, 2 );
            }
        } 
        
        public function add_menus( $items, $args ) {
            global $mcfwp_general_options;
            global $mcfwp_flyout_options;
            global $mcfwp_design_options;
            global $woocommerce;
            $menus          =   explode(",",$mcfwp_general_options['menu_id']); 
            $cart_icon      =   $mcfwp_general_options['cart_icon'];

            $mcfwp_currency =  (isset($mcfwp_design_options['currency_position']) ? $mcfwp_design_options['currency_position'] : '');  
            $output = '';
            $output .= mcfwp_get_select_cart_icon($cart_icon);                 
            
            $page_redirect_url = (($mcfwp_general_options['page_redirect'] == 'checkout') ? wc_get_checkout_url() : wc_get_cart_url());
            if (((is_cart()==false) && (is_checkout() == false)) || (isset($mcfwp_general_options['show_on_cart_checkout_page']) && $mcfwp_general_options['show_on_cart_checkout_page']=='on')) {
                foreach ($menus as $key => $value) {
                    if ( $args->menu->term_id ==$value ) {
                        $mcfwp_menu_link = (isset($mcfwp_flyout_options['flyout_status']) && $mcfwp_flyout_options['flyout_contents'] == 'click') ? 'javascript:void(0);': $page_redirect_url;
                        $items .= '<li class="menu-item menu-item-type-post_type menu-item-object-page mcfwp-menu '.$mcfwp_currency.' '.(($mcfwp_flyout_options['flyout_contents'] == 'hover') ?  'mcfwp-menu-hover' : '').' '.(($mcfwp_general_options['menu_cart_formats'] == 'price_items' || $mcfwp_general_options['menu_cart_formats'] == 'items_price') ? 'mcfwp-menu-no-icon' : '').'">
                                <a href="'.$mcfwp_menu_link.'" class="mcfwp-menu-list"> <span>';
                                
                                if (($mcfwp_general_options['menu_cart_formats'] != 'items_price') && ($mcfwp_general_options['menu_cart_formats'] != 'price_items') ) {
                                    $items .= $output;
                                }
                                $items .= '<span class="mcfwp-mini-product-price-html "></span></span></a>';
                                $items .= '<div class="mcfwp-mini-cart-main"></div>';
                                            
                            $items .='</li>';
                            }   
                    }
                } 
                return $items;
            }
    }
} ?>