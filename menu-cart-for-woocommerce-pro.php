<?php
/*
Plugin Name:  Menu Cart For Woocommerce Pro
Description: Use our best, most professional, an innovative plugin to show your cart to the next level. This plugin allows you to show your cart details on the menu. There is no need to go on the cart page, it lets you see your cart detail wherever you are.
Author: Geek Code Lab
Version: 1.3
WC tested up to: 7.8.0
Author URI: https://geekcodelab.com/
Text Domain : menu-cart-for-woocommerce-pro
*/

if (!defined('ABSPATH')) exit;

if (!defined("MCFWP_PLUGIN_DIR_PATH"))

    define("MCFWP_PLUGIN_DIR_PATH", plugin_dir_path(__FILE__));

if (!defined("MCFWP_PLUGIN_URL"))

    define("MCFWP_PLUGIN_URL", plugins_url() . '/' . basename(dirname(__FILE__)));

define("mcfwp_BUILD", '1.3');

register_activation_hook(__FILE__, 'mcfwp_plugin_active_menu_cart_for_woocommerce');
function mcfwp_plugin_active_menu_cart_for_woocommerce(){

    if (!class_exists('WooCommerce')) {
        die('Menu Cart For Woocommerce Plugin can not activate as it requires <b>WooCommerce</b> plugin.');
    }

    $mcfwp_general_defaults_options =  $mcfwp_flyout_defaults_options  =  $mcfwp_sticky_defaults_options  =  $mcfwp_design_defaults_options  = "";
    
    if (is_plugin_active( 'menu-cart-for-woocommerce/menu-cart-for-woocommerce.php' ) ) {		
		deactivate_plugins('menu-cart-for-woocommerce/menu-cart-for-woocommerce.php');
        
    }
    $mcfwp_general_defaults_options = get_option('mcfw_general_options');
    $mcfwp_flyout_defaults_options  = get_option('mcfw_flyout_options');
    $mcfwp_sticky_defaults_options  = get_option('mcfw_sticky_cart_options');
    $mcfwp_design_defaults_options  = get_option('mcfw_design_options');

    if(empty($mcfwp_general_defaults_options)){
        $mcfwp_general_defaults_options = array(
            'always_display'    => 'on',
            'price_format'      => 'currency_symbol',       
            'cart_icon'         => 'cart1',
            'menu_cart_formats' => 'icon_items_price',
            'page_redirect'     => 'cart',
        );
    }

    if(empty($mcfwp_flyout_defaults_options)){
        $mcfwp_flyout_defaults_options = array(
            'product_image'     => 'on',
            'product_name'      => 'on',
            'product_price'     => 'on',
            'product_quantity'  => 'on',
            'product_total'     => 'on',
            'flyout_contents'   => 'hover',
            'page_redirect'     => 'cart',
            'total_price_type'  => 'subtotal',
            'max_products'      => '5',
            'cart_checkout_btn' => 'cart_checkout',
            'cart_btn_txt'      => 'View cart',
            'checkout_btn_txt'  => 'Checkout',
            'empty_note_txt'    => 'Your Cart Is Currently Empty.'
        );
    }

    if(empty($mcfwp_sticky_defaults_options)){
        $mcfwp_sticky_defaults_options = array(
            'item_count'            => 'yes',
            'sticky_cart_position'  => 'mcfwp_cart_bottom_right'
        );
    }

    if(empty($mcfwp_design_defaults_options)){

        $mcfwp_design_defaults_options = array(
            'currency_position'         => 'mcfwp_currency_postion_left_withspace',
            'cart_shape'                => 'mcfwp_round_cart',
            'btns_border'               => ',none,',
            'menu_txt_color'            => '#ffffff',
            'menu_txt_background_color' => '#ff0000'
        );
    }

    $mcfwp_shortcode_defaults_options = array(
        'flyout_contents' => 'hover'
    );

    $mcfwp_general_options       = get_option('mcfwp_general_options');
    $mcfwp_flyout_options        = get_option('mcfwp_flyout_options');
    $mcfwp_sticky_cart_options   = get_option('mcfwp_sticky_cart_options');
    $mcfwp_design_options        = get_option('mcfwp_design_options');
    $mcfwp_shortcode_options     = get_option('mcfwp_shortcode_options');

    if(!empty($mcfwp_general_options)){
        $mcfwp_general_defaults_options = $mcfwp_general_options;
    }
    if(!empty($mcfwp_flyout_options)){
        $mcfwp_flyout_defaults_options = $mcfwp_flyout_options;
    }
    if(!empty($mcfwp_sticky_cart_options)){
        $mcfwp_sticky_defaults_options = $mcfwp_sticky_cart_options;
    }
    if(!empty($mcfwp_design_options)){
        $mcfwp_design_defaults_options = $mcfwp_design_options;
    }
    if(!empty($mcfwp_shortcode_options)){
        $mcfwp_shortcode_defaults_options = $mcfwp_shortcode_options;
    }


    if(isset($mcfwp_general_defaults_options) || isset($mcfwp_flyout_defaults_options) || isset($mcfwp_sticky_defaults_options) || isset($mcfwp_design_defaults_options) || isset($mcfwp_shortcode_defaults_options) ) {
        update_option('mcfwp_general_options', $mcfwp_general_defaults_options);
        update_option('mcfwp_flyout_options', $mcfwp_flyout_defaults_options);
        update_option('mcfwp_sticky_cart_options', $mcfwp_sticky_defaults_options);
        update_option('mcfwp_design_options', $mcfwp_design_defaults_options);
        update_option('mcfwp_shortcode_options', $mcfwp_shortcode_defaults_options);
    }


}

require_once(MCFWP_PLUGIN_DIR_PATH . 'admin/option.php');
require_once(MCFWP_PLUGIN_DIR_PATH . 'front/index.php');

add_action('admin_print_styles', 'mcfwp_admin_style');
function mcfwp_admin_style()
{
    if (is_admin()) {
        $js        =    plugins_url('/assets/js/admin-script.js', __FILE__);
        wp_enqueue_style('mcfwp_coloris_style', plugins_url('assets/css/coloris.min.css', __FILE__), '', mcfwp_BUILD);
        wp_enqueue_style('mcfwp-select2-style', plugins_url('/assets/css/select2.min.css', __FILE__), '', mcfwp_BUILD);
        wp_enqueue_style('mcfwp_admin_style', plugins_url('assets/css/admin-style.css', __FILE__), '', mcfwp_BUILD);

        wp_enqueue_script('mcfwp-admin-select2-js', plugins_url('/assets/js/select2.min.js', __FILE__), array('jquery'), mcfwp_BUILD);
        wp_enqueue_script('mcfwp-admin-coloris-js', plugins_url('/assets/js/coloris.min.js', __FILE__), array('jquery'), mcfwp_BUILD);
        wp_enqueue_script('mcfwp_admin_js',  plugins_url('/assets/js/admin-script.js', __FILE__), array('jquery', 'wp-color-picker'), mcfwp_BUILD);
    }
}

add_action('wp_enqueue_scripts', 'mcfwp_include_front_script');
function mcfwp_include_front_script()
{
    wp_enqueue_style("mcfwp_front_style", plugins_url("/assets/css/front_style.css", __FILE__), '', mcfwp_BUILD);
    wp_enqueue_script('mcfwp-front-js', plugins_url('/assets/js/front-script.js', __FILE__), array('jquery'), mcfwp_BUILD);
    wp_localize_script('mcfwp-front-js', 'mcfwpObj', ['ajaxurl' => admin_url('admin-ajax.php'), 'general_data' => get_option('mcfwp_general_options')]);
}

function mcfwp_plugin_add_settings_link($links)
{
    $support_link = '<a href="https://geekcodelab.com/contact/"  target="_blank" >' . __('Support') . '</a>';
    array_unshift($links, $support_link);

    $settings_link = '<a href="admin.php?page=mcfwp-option-page">' . __('Settings') . '</a>';
    array_unshift($links, $settings_link);
    return $links;
}
$plugin = plugin_basename(__FILE__);
add_filter("plugin_action_links_$plugin", 'mcfwp_plugin_add_settings_link');

/** after page update button text html  */
add_filter('woocommerce_add_to_cart_fragments', 'mcfwp_update_menu_count');
function mcfwp_update_menu_count($fragments){

    ob_start();
    $mcfwp_general_options1 = get_option('mcfwp_general_options');
    $mcfwp_flyout_options1 = get_option('mcfwp_flyout_options');
   

    $items_count = esc_attr(count(WC()->cart->get_cart()));
 
    $currency = esc_attr(($mcfwp_general_options1['price_format'] == 'currency') ? get_woocommerce_currency() : get_woocommerce_currency_symbol());
    $menu_cart_formats = $mcfwp_general_options1['menu_cart_formats'];

    if ( WC()->cart->display_prices_including_tax() ) {
        $menu_price = (float) WC()->cart->get_subtotal() + (float) WC()->cart->get_subtotal_tax();
    } else {
        $menu_price = (float) WC()->cart->get_subtotal();
    }

    $item_join_label = ((isset($items_count)) && ($items_count > 1)) ? 'items' : 'item' ;
    $output = '';
    $mcfwp_currency_class =  (isset($mcfwp_design_options['currency_position']) ? $mcfwp_design_options['currency_position'] : ''); 

    $price_currency = '<span class="mcfwp-mini-cart-price-wp"><span  class="mcfwp-flyout-currency">' . $currency . '</span>'.$menu_price . '</span>';
    switch ($menu_cart_formats) {
        case 'icon_only':
            $output .= '';
            break;

        case 'icon_items':
            $output .= '' . $items_count . ' '.$item_join_label.' </span>';
            break;

        case 'icon_price':
            $output .= $price_currency;
            break;

        case 'items_price':
            $output .= '' . $items_count . ' '.$item_join_label.' - ' . $price_currency;
            break;

        case 'price_items':
            $output .= $price_currency . '- ' . $items_count . ' '.$item_join_label;
            break;

        case 'icon_price_items':
            $output .= $price_currency . '- ' . $items_count . ' '.$item_join_label;
            break;
        case 'icon_item_count':
            $output .= $items_count;
            break;

        default:
            $output .= '' . $items_count . ' '.$item_join_label.' - ' . $price_currency;
            break;
    }  
    ?>
  
    <span class="mcfwp-mini-product-price-html <?php echo($menu_cart_formats == 'icon_item_count')?'mcfwp-item-count-only': ''; ?>">
        <?php _e($output); ?>
    </span>

    <?php
    $fragments['.mcfwp-mini-product-price-html'] = ob_get_clean();
    
    return $fragments;
}


/** Flyout HTML Start  */
add_filter('woocommerce_add_to_cart_fragments', 'mcfwp_update_flyout');
function mcfwp_update_flyout($fragments){

    ob_start();
    $mcfwp_flyout_options1 = get_option('mcfwp_flyout_options');
    $mcfwp_general_options1 = get_option('mcfwp_general_options');
    $items_count = esc_attr(count(WC()->cart->get_cart()));
    $currency = esc_attr(($mcfwp_general_options1['price_format'] == 'currency') ? get_woocommerce_currency() : get_woocommerce_currency_symbol());

    if (!empty($mcfwp_flyout_options1['flyout_status'])  && ($mcfwp_flyout_options1['flyout_status'] == 'on')) { 

        $allow_pro_image    = isset($mcfwp_flyout_options1['product_image']) ? $mcfwp_flyout_options1['product_image'] : '' ;
        $allow_pro_name     = isset($mcfwp_flyout_options1['product_name']) ? $mcfwp_flyout_options1['product_name'] : '' ;
        $allow_pro_price    = isset($mcfwp_flyout_options1['product_price']) ? $mcfwp_flyout_options1['product_price'] : '' ;
        $allow_pro_quantity = isset($mcfwp_flyout_options1['product_quantity']) ? $mcfwp_flyout_options1['product_quantity'] : '' ;
        $allow_pro_link     = isset($mcfwp_flyout_options1['product_link']) ? $mcfwp_flyout_options1['product_link'] : '' ;
        $allow_pro_total    = isset($mcfwp_flyout_options1['product_total']) ? $mcfwp_flyout_options1['product_total'] : '' ;
        $allow_remove_icon  = isset($mcfwp_flyout_options1['remove_product_icon']) ? $mcfwp_flyout_options1['remove_product_icon'] : '' ;
        $empty_note_txt     = isset($mcfwp_flyout_options1['empty_note_txt']) ? $mcfwp_flyout_options1['empty_note_txt'] : '' ;
        ?>

        <div class="mcfwp-mini-cart-main">
            <?php 
            if ($items_count != 0) { ?>
                <div class="mcfwp-flyout-product-list">
                    <?php
                    $i = 1;
                    $mcfe_total = (($mcfwp_flyout_options1['max_products'] == 'all') ? $items_count : $mcfwp_flyout_options1['max_products']);

                    foreach (WC()->cart->get_cart() as $cart_item_key => $cart_item) {
                        if ($i <= $mcfe_total) {
                            $i++;
                            $product = $cart_item['data'];
                            $product_id = $cart_item['product_id'];
                            $product_img = esc_url(get_the_post_thumbnail_url($product_id)); ?>
                            <div class="mcfwp-flyout-product">
                                <?php 
                                if(!empty($allow_pro_image)){ ?>
                                    <div class="mcfwp-pro-img">
                                        <?php
                                        if(!empty($allow_pro_link)){ ?>
                                            <a href="<?php esc_attr_e(get_permalink($product_id)); ?>" title="<?php esc_attr_e($product->name); ?>" ><img src="<?php esc_attr_e($product_img); ?>" alt="" width="70" height="70" alt="<?php esc_attr_e($product->name); ?>"></a>
                                            <?php
                                        }else{?>
                                            <img src="<?php esc_attr_e($product_img); ?>" alt="" width="70" height="70" alt="<?php esc_attr_e($product->name); ?>">
                                            <?php
                                        }?>
                                    </div>
                                    <?php
                                }?>
                                <div class="mcfwp-cart-item-qp">
                                    <?php 

                                    if(!empty($allow_remove_icon)){
                                        ?>
                                        <span data-id="<?php _e($product_id,'menu-cart-for-woocommerce-pro'); ?>" class="mcfwp-remove-cart-item">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13.667" viewBox="0 0 13 13.667">
                                                <g id="Group_1" data-name="Group 1" transform="translate(-2.25 -1.75)">
                                                    <path id="Path_1" data-name="Path 1" d="M11.976,16.417H6.856a2.033,2.033,0,0,1-2-1.907L4.25,5.283a.507.507,0,0,1,.133-.367A.513.513,0,0,1,4.75,4.75h9.333a.5.5,0,0,1,.5.533L14,14.51A2.033,2.033,0,0,1,11.976,16.417ZM5.31,5.75l.513,8.7a1.033,1.033,0,0,0,1.033.967h5.12a1.04,1.04,0,0,0,1.033-.967l.54-8.667Z" transform="translate(-0.666 -1)" fill="#dd1818"/>
                                                    <path id="Path_2" data-name="Path 2" d="M14.75,5.75h-12a.5.5,0,1,1,0-1h12a.5.5,0,0,1,0,1Z" transform="translate(0 -1)" fill="#dd1818"/>
                                                    <path id="Path_3" data-name="Path 3" d="M12.75,4.75h-4a.507.507,0,0,1-.5-.5V3.05a1.333,1.333,0,0,1,1.3-1.3h2.4a1.333,1.333,0,0,1,1.3,1.333V4.25A.507.507,0,0,1,12.75,4.75Zm-3.5-1h3V3.083a.3.3,0,0,0-.3-.3H9.55a.3.3,0,0,0-.3.3Z" transform="translate(-2)" fill="#dd1818"/>
                                                    <path id="Path_4" data-name="Path 4" d="M14.75,15.083a.507.507,0,0,1-.5-.5V9.25a.5.5,0,0,1,1,0v5.333A.507.507,0,0,1,14.75,15.083Z" transform="translate(-4 -2.333)" fill="#dd1818"/>
                                                    <path id="Path_5" data-name="Path 5" d="M8.75,15.083a.507.507,0,0,1-.5-.5V9.25a.5.5,0,0,1,1,0v5.333A.507.507,0,0,1,8.75,15.083Z" transform="translate(-2 -2.333)" fill="#dd1818"/>
                                                    <path id="Path_6" data-name="Path 6" d="M11.75,15.083a.507.507,0,0,1-.5-.5V9.25a.5.5,0,0,1,1,0v5.333A.507.507,0,0,1,11.75,15.083Z" transform="translate(-3 -2.333)" fill="#dd1818"/>
                                                </g>
                                            </svg>
                                        </span>
                                        <?php
                                    }
                                    if(!empty($allow_pro_name)){
                                        if(!empty($allow_pro_link)){
                                            ?>
                                                <a href="<?php esc_attr_e(get_permalink($product_id)); ?>" class="mcfwp-cart-item-name"><?php esc_attr_e($product->name); ?></a>
                                            <?php
                                        }else{
                                            ?>
                                                <span class="mcfwp-cart-item-name"><?php esc_attr_e($product->name); ?></span>
                                            <?php
                                        }
                                       
                                    }
                                    if(!empty($allow_pro_quantity)){
                                        ?>
                                        <span>
                                            <?php esc_attr_e($cart_item['quantity']);
                                            if(!empty($allow_pro_quantity) && !empty($allow_pro_price)){
                                                ?> X <?php
                                            }                                            
                                            ?>
                                        </span>
                                        <?php
                                    }
                                    
                                    if(!empty($allow_pro_price)){
                                        $cart_price = WC()->cart->get_product_price( $product );
                                        ?>
                                        <span class="mcfwp-mini-product-price-html ">
                                            <span class="mcfwp-mini-cart-price-wp">
                                                <?php _e( $cart_price ); ?>
                                            </span>
                                        </span>
                                        <?php
                                        if(!empty($allow_pro_total)){
                                            ?>
                                            <span>=</span><?php
                                        }
                                    }
                                    if(!empty($allow_pro_total)){
                                        ?>
                                        <span class="mcfwp-mini-product-price-html ">
                                            <span class="mcfwp-flyout-product-total mcfwp-mini-cart-price-wp" >
                                                <span class="mcfwp-flyout-currency"><?php esc_attr_e($currency); ?></span>
                                                <?php esc_attr_e($cart_item['quantity']*$product->price); ?>
                                            </span>
                                        </span>
                                        <?php
                                    }
                                    ?>
                                </div>
                            </div>
                            <?php 
                        }
                    } ?>
                </div>
                <?php
                $btns = $mcfwp_flyout_options1['cart_checkout_btn'];
                if ($btns != 'no_any_btn') { ?>
                    <div class="mcfwp-cart-btn-wp mcfwp_for_des">
                        <?php
                        if ($btns == 'cart' || $btns == 'cart_checkout') { ?> 
                            <a class="btn button mcfwp-btns" href="<?php esc_attr_e(wc_get_cart_url()); ?>"><?php esc_attr_e(!empty($mcfwp_flyout_options1['cart_btn_txt']) ? $mcfwp_flyout_options1['cart_btn_txt'] : 'View Cart'); ?></a><?php 
                        }
                        if ($btns == 'checkout' || $btns == 'cart_checkout') { ?>
                            <a class="btn button mcfwp-btns" href="<?php esc_attr_e(wc_get_checkout_url()); ?>"><?php esc_attr_e(!empty($mcfwp_flyout_options1['checkout_btn_txt']) ? $mcfwp_flyout_options1['checkout_btn_txt'] : 'CheckOut'); ?></a><?php 
                        }  ?>
                    </div>

                    <div class="mcfwp-cart-btn-wp mcfwp_for_mob">
                        <?php
                        if ($btns == 'cart' || $btns == 'cart_checkout') { ?> <a class="mcfwp-btns" href="<?php esc_attr_e(wc_get_cart_url()); ?>"><?php esc_attr_e(!empty($mcfwp_flyout_options1['cart_btn_txt']) ? $mcfwp_flyout_options1['cart_btn_txt'] : 'View Cart'); ?></a><?php }
                        
                        if ($btns == 'checkout' || $btns == 'cart_checkout') { ?>
                            <a class="mcfwp-btns" href="<?php esc_attr_e(wc_get_checkout_url()); ?>"><?php esc_attr_e(!empty($mcfwp_flyout_options1['checkout_btn_txt']) ? $mcfwp_flyout_options1['checkout_btn_txt'] : 'CheckOut'); ?></a><?php 
                        }  ?>
                    </div>
                <?php } ?>
                <div class="mcfwp-sub-total mcfwp-mini-product-price-html">
                    <?php 
                    if (isset($mcfwp_flyout_options1['total_price_type']) && $mcfwp_flyout_options1['total_price_type'] == 'total_including_discount') {
                        if ( WC()->cart->display_prices_including_tax() ) {
                            $price = (float) WC()->cart->get_subtotal() + (float) WC()->cart->get_subtotal_tax();
                        } else {
                            $price = (float) WC()->cart->get_subtotal();
                        }
                    } elseif (isset($mcfwp_flyout_options1['total_price_type']) && $mcfwp_flyout_options1['total_price_type'] == 'checkout_total_including_shipping') {
                        $price = (float) WC()->cart->get_total('edit');
                    } else {
                        if ( WC()->cart->display_prices_including_tax() ) {
                            $price = (float) WC()->cart->get_cart_contents_total() + (float) WC()->cart->get_cart_contents_tax();
                        } else {
                            $price = (float) WC()->cart->get_cart_contents_total();
                        }
                    }
                    ?>
                    <label><?php if($mcfwp_flyout_options1['total_price_type'] == 'total_including_discount') { esc_html_e('Subtotal','menu-cart-for-woocommerce-pro'); }else{ esc_html_e('Total','menu-cart-for-woocommerce-pro'); } ?>:</label>
                    <b>
                        <span class="mcfwp-mini-cart-price-wp">
                            <span class="mcfwp-flyout-currency"><?php esc_attr_e($currency); ?></span>
                            <?php esc_attr_e($price); ?>
                        </span>
                    </b>
                </div>
                <?php
            } else { ?>
                <p class="mcfwp-empty-note"><?php _e($empty_note_txt, 'menu-cart-for-woocommerce-pro'); ?></p>
            <?php } ?>
        </div>
    <?php  }
    $fragments['.mcfwp-mini-cart-main'] = ob_get_clean();
    return $fragments;
}


add_filter('woocommerce_add_to_cart_fragments', 'mcfwp_update_sticky_count');
function mcfwp_update_sticky_count($fragments){
    ob_start();
    $mcfwp_general_options1 = get_option('mcfwp_general_options');
    $mcfwp_sticky_cart_options = get_option('mcfwp_sticky_cart_options');

    $items_count = esc_attr(count(WC()->cart->get_cart()));

    ?>
    <span class="mcfwp-sticky-count">
        <span><?php esc_attr_e($items_count); ?></span>
    </span>
<?php
    $fragments['.mcfwp-sticky-count'] = ob_get_clean();
    return $fragments;
}

add_action('wp_ajax_mcfwp_remove_cart_iteam','mcfwp_remove_cart_iteam');
add_action( 'wp_ajax_nopriv_mcfwp_remove_cart_iteam', 'mcfwp_remove_cart_iteam' );

function mcfwp_remove_cart_iteam() {	
    $product_id = $_POST['product_id'];
    $product_cart_id = WC()->cart->generate_cart_id( $product_id );
    $cart_item_key = WC()->cart->find_product_in_cart( $product_cart_id );
    if ( $cart_item_key ) WC()->cart->remove_cart_item( $cart_item_key );
    die;
}

function mcfwp_custom_content_after_body_open_tag() {
    ?>
    <div class="mcfwp-overlay mcfwp-hidden"></div>
    <?php
}

add_action('wp_body_open', 'mcfwp_custom_content_after_body_open_tag');