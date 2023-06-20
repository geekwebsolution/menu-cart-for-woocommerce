<?php
if (!class_exists('mcfwp_design')) {
    $mcfwp_design_options = get_option('mcfwp_design_options');
    $mcfwp_general_options1 = get_option('mcfwp_general_options');

    class mcfwp_design{
        public function __construct() {
                add_action( 'init', array( $this, 'mcfwp_set_design' ) );   
        }
        public function mcfwp_set_design(){
            if (!is_admin()) {
                add_action( 'wp_footer', array( $this, 'mcfwp_add_design' ), 999 );   
            }  
        }

        public function mcfwp_add_design(){
            global $mcfwp_design_options;
            global $mcfwp_general_options1;
      
            $mcfwp_cart_shape = $mcfwp_design_options['cart_shape'];
            $mcfwp_btn_border = explode(",",$mcfwp_design_options['btns_border']); ?>
    
                <style>
                    <?php
                        $cart_clr       = (isset($mcfwp_design_options['cart_color']) ? $mcfwp_design_options['cart_color'] : '');
                        $genral_cart_background_color       = (isset($mcfwp_design_options['genral_cart_background_color']) ? $mcfwp_design_options['genral_cart_background_color'] : '');

                        $menu_txt_color = (isset($mcfwp_design_options['menu_txt_color']) ? $mcfwp_design_options['menu_txt_color'] : '');
                        $menu_count_color = (isset($mcfwp_design_options['menu_count_color']) ? $mcfwp_design_options['menu_count_color'] : '');
                        $menu_txt_background_color = (isset($mcfwp_design_options['menu_txt_background_color']) ? $mcfwp_design_options['menu_txt_background_color'] : '');

                        if (!empty($cart_clr)) { ?>
                            .mcfwp-menu svg.mcfwp-svg path,
                            .mcfwp-menu svg.mcfwp-svg circle,
                            .mcfwp-cart svg.mcfwp-svg path,
                            .mcfwp-cart svg.mcfwp-svg circle,
                            .mcfwp-shortcode svg.mcfwp-svg path,
                            .mcfwp-shortcode svg.mcfwp-svg circle{
                                fill:<?php esc_attr_e($cart_clr . ' !important');  ?>
                            }
                        <?php }
                       
                        if (!empty($genral_cart_background_color)) { ?>
                            .mcfwp-menu a.mcfwp-menu-list{
                                background:<?php esc_attr_e( $genral_cart_background_color . ' !important');  ?>
                            }
                            <?php
                        }
                        
                        if (!empty($menu_txt_color)) { ?>
                            .mcfwp-menu .mcfwp-menu-list a, .mcfwp-menu .mcfwp-menu-list span, .mcfwp-shortcode a, .mcfwp-shortcode span{
                                color:<?php esc_attr_e($menu_txt_color . ' !important');  ?>
                            }
                        <?php }

                        if(!empty($menu_count_color)) { ?>
                        .mcfwp-menu .mcfwp-menu-list > span .mcfwp-item-count-only,
                            .mcfwp-menu .mcfwp-menu-list span span.mcfwp-item-count-only
                            {
                                color:<?php esc_attr_e($menu_count_color . ' !important');  ?>;
                            }
                        <?php }

                        if(!empty($menu_txt_background_color)) { ?>
                        .mcfwp-menu .mcfwp-menu-list > span .mcfwp-item-count-only,
                            .mcfwp-menu .mcfwp-menu-list span span.mcfwp-item-count-only
                            {
                                background:<?php esc_attr_e($menu_txt_background_color . ' !important');  ?>;
                            }
                        <?php }

                        $mcfwp_flyout_txt_clr        = (isset($mcfwp_design_options['txt_color']) ? $mcfwp_design_options['txt_color'] : '');
                        $flyout_background_color    = (isset($mcfwp_design_options['flyout_background_color']) ? $mcfwp_design_options['flyout_background_color'] : '');
                        $mcfwp_btn_back_clr          = (isset($mcfwp_design_options['btns_background_color']) ? $mcfwp_design_options['btns_background_color'] : '');
                        $mcfwp_hover_btn_clr         = (isset($mcfwp_design_options['btns_hover_background_color']) ? $mcfwp_design_options['btns_hover_background_color'] : '');
                        $mcfwp_btn_txt_clr           = (isset($mcfwp_design_options['btns_text_color']) ? $mcfwp_design_options['btns_text_color'] : '');
                        $mcfwp_hover_btn_txt_clr     = (isset($mcfwp_design_options['btns_hover_text_color']) ? $mcfwp_design_options['btns_hover_text_color'] : '');
                        $mcfwp_cnt_back_clr          = (isset($mcfwp_design_options['count_background_color']) ? $mcfwp_design_options['count_background_color'] : '');
                        $mcfwp_cnt_txt_clr           = (isset($mcfwp_design_options['count_text_color']) ? $mcfwp_design_options['count_text_color'] : '');
                        $mcfwp_cart_back_clr         = (isset($mcfwp_design_options['cart_background_color']) ? $mcfwp_design_options['cart_background_color'] : '');

                        if (!empty($mcfwp_flyout_txt_clr)) { ?>
                            .mcfwp-cart-item-qp a,
                            .mcfwp-cart-item-qp span,
                            .mcfwp-sub-total,
                            .mcfwp-mini-cart-main .mcfwp-empty-note{
                                color:<?php esc_attr_e($mcfwp_flyout_txt_clr . ' !important');  ?>
                            }
                            <?php
                        }
                        
                        if (!empty($flyout_background_color)) { ?>
                            .mcfwp-mini-cart-main{
                                background:<?php esc_attr_e($flyout_background_color . ' !important');  ?>
                            }
                        <?php }

                        if (!empty($mcfwp_btn_back_clr)) { ?>
                            .mcfwp-menu .mcfwp-mini-cart-main .mcfwp-cart-btn-wp a{
                                background:<?php esc_attr_e($mcfwp_btn_back_clr . ' !important');  ?>
                            }
                        <?php }
                         if (!empty($mcfwp_hover_btn_clr)) { ?>
                            .mcfwp-menu .mcfwp-mini-cart-main .mcfwp-cart-btn-wp a:hover{
                                background:<?php esc_attr_e($mcfwp_hover_btn_clr . ' !important');  ?>
                            }
                        <?php }
                        if (!empty($mcfwp_btn_txt_clr)) { ?>
                            .mcfwp-menu .mcfwp-mini-cart-main .mcfwp-cart-btn-wp a{
                                color:<?php esc_attr_e($mcfwp_btn_txt_clr . ' !important'); ?>
                            }
                        <?php } 
                        if (!empty($mcfwp_hover_btn_txt_clr)) { ?>
                            .mcfwp-menu .mcfwp-mini-cart-main .mcfwp-cart-btn-wp a:hover{
                                color:<?php esc_attr_e($mcfwp_hover_btn_txt_clr . ' !important'); ?>
                            }
                        <?php } 
                        if (!empty($mcfwp_cnt_back_clr)) { ?>
                            .mcfwp-sticky-count{
                                background:<?php esc_attr_e($mcfwp_cnt_back_clr . ' !important'); ?>
                            }
                        <?php } 
                        if (!empty($mcfwp_cnt_txt_clr)) { ?>
                            .mcfwp-sticky-count{
                                color:<?php esc_attr_e($mcfwp_cnt_txt_clr . ' !important'); ?>
                            }
                        <?php }
                        if (!empty($mcfwp_cart_back_clr)) { ?>
                            .mcfwp_cart_bottom_left, 
                            .mcfwp_cart_bottom_right, 
                            .mcfwp_cart_top_left, 
                            .mcfwp_cart_top_right {
                                background:<?php esc_attr_e($mcfwp_cart_back_clr . ' !important'); ?>
                            }
                        <?php }
                        if (!empty($mcfwp_btn_border[0])) { ?>
                            .mcfwp-menu .mcfwp-mini-cart-main .mcfwp-cart-btn-wp a{
                                border:<?php esc_attr_e($mcfwp_btn_border[0]); ?>px <?php esc_attr_e($mcfwp_btn_border[1]); ?> <?php esc_attr_e($mcfwp_btn_border[2]); ?> !important;
                            }
                        <?php
                        } 
              
                        if ($mcfwp_cart_shape == 'mcfwp_square_cart') { ?>
                            .mcfwp_cart_bottom_left, 
                            .mcfwp_cart_bottom_right, 
                            .mcfwp_cart_top_left, 
                            .mcfwp_cart_top_right,
                            .mcfwp-sticky-count{
                                border-radius: 0% !important;
                            }
                        <?php 
                        } ?>
                </style>
                <?php 
    
            $mcfwp_always_cart = ((isset($mcfwp_general_options1['always_display'])) && (!empty($mcfwp_general_options1['always_display'])) ? $mcfwp_general_options1['always_display'] : '');
            $items_count = esc_attr(count(WC()->cart->get_cart())); ?>
            <script type="text/javascript">
                jQuery(document).ready(function($) {
                   
                    var cnt =<?php esc_attr_e($items_count); ?>;
		            var always_display_cart = '<?php esc_attr_e($mcfwp_always_cart); ?>';
                    ((cnt <= 0 && always_display_cart != 'on') ? jQuery('.mcfwp-menu').hide() : jQuery('.mcfwp-menu').show());
                });
            </script>
        <?php }
    }
}