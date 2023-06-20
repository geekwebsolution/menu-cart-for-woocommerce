<?php
if (!class_exists('mcfwp_flyout_settings')) {
    $mcfwp_flyout_options = get_option('mcfwp_flyout_options');
    // echo '<pre>'; print_r($mcfwp_flyout_options  ); echo '</pre>';
    class mcfwp_flyout_settings{

        public function __construct(){
            add_action('admin_init', array($this, 'register_flyout_settings_init'));
        }

        public function register_flyout_design_settings_init(){ ?>

            <form class="mcfwp-general-setting" action="options.php?tab=mcfwp-flyout" method="post">
                <?php settings_fields('mcfwp-flyout-setting-options');   ?>
                <div class="mcfwp-section">
                    <?php do_settings_sections('mcfwp_flyout_setting_section'); ?>
                </div>
                <?php submit_button('Save Settings'); ?>
            </form>
        <?php
        }

        /* register setting */
        public function register_flyout_settings_init(){

            register_setting('mcfwp-flyout-setting-options', 'mcfwp_flyout_options', array($this, 'sanitize_settings'));

            add_settings_section(
                'mcfwp_flyout_setting_id',
                __('', 'menu-cart-for-woocommerce-pro'),
                array(),
                'mcfwp_flyout_setting_section'
            );

            add_settings_field(
                'flyout_status',
                __('Flyout <p>Only the desktop displays Flyout.<br>(window width above 991px)</p>', 'menu-cart-for-woocommerce-pro'),
                array($this, 'flyout_checkbox_callback'),
                'mcfwp_flyout_setting_section',
                'mcfwp_flyout_setting_id',
                [
                    'label_for'     => 'flyout_status',
                ]
            );

           
            add_settings_field(
                'product_image',
                __('Product Image', 'menu-cart-for-woocommerce-pro'),
                array($this, 'flyout_checkbox_callback'),
                'mcfwp_flyout_setting_section',
                'mcfwp_flyout_setting_id',
                [
                    'label_for'     => 'product_image',
                    'option_group' => 'wpdevref_options', 
                    'class'         => 'mcfwp_flyout_options mcfwp_flyout_first_options'
                ]
            );
            add_settings_field(
                'product_name',
                __('Product Name', 'menu-cart-for-woocommerce-pro'),
                array($this, 'flyout_checkbox_callback'),
                'mcfwp_flyout_setting_section',
                'mcfwp_flyout_setting_id',
                [
                    'label_for'     => 'product_name',
                    'option_group' => 'wpdevref_options', 
                    'class'         => 'mcfwp_flyout_options'
                ]
            );
            add_settings_field(
                'product_price',
                __('Product Price', 'menu-cart-for-woocommerce-pro'),
                array($this, 'flyout_checkbox_callback'),
                'mcfwp_flyout_setting_section',
                'mcfwp_flyout_setting_id',
                [
                    'label_for'     => 'product_price',
                    'option_group' => 'wpdevref_options', 
                    'class'         => 'mcfwp_flyout_options'
                ]
            );

            add_settings_field(
                'product_quantity',
                __('Product Quantity', 'menu-cart-for-woocommerce-pro'),
                array($this, 'flyout_checkbox_callback'),
                'mcfwp_flyout_setting_section',
                'mcfwp_flyout_setting_id',
                [
                    'label_for'     => 'product_quantity',
                    'option_group' => 'wpdevref_options', 
                    'class'         => 'mcfwp_flyout_options'
                ]
            );

            add_settings_field(
                'product_link',
                __('Link to a Product page', 'menu-cart-for-woocommerce-pro'),
                array($this, 'flyout_checkbox_callback'),
                'mcfwp_flyout_setting_section',
                'mcfwp_flyout_setting_id',
                [
                    'label_for'     => 'product_link',
                    'option_group' => 'wpdevref_options', 
                    'class'         => 'mcfwp_flyout_options'
                ]
            );

            add_settings_field(
                'product_total',
                __('Product Total', 'menu-cart-for-woocommerce-pro'),
                array($this, 'flyout_checkbox_callback'),
                'mcfwp_flyout_setting_section',
                'mcfwp_flyout_setting_id',
                [
                    'label_for'     => 'product_total',
                    'option_group' => 'wpdevref_options', 
                    'class'         => 'mcfwp_flyout_options'
                ]
            );

            add_settings_field(
                'remove_product_icon',
                __('Remove Product from cart', 'menu-cart-for-woocommerce-pro'),
                array($this, 'flyout_checkbox_callback'),
                'mcfwp_flyout_setting_section',
                'mcfwp_flyout_setting_id',
                [
                    'label_for'     => 'remove_product_icon',
                    'option_group' => 'wpdevref_options', 
                    'class'         => 'mcfwp_flyout_options mcfwp_flyout_last_options'
                ]
            );

            add_settings_field(
                'flyout_contents',
                __('Display Flyout contents', 'menu-cart-for-woocommerce-pro'),
                array($this, 'flyout_contents_radio_callback'),
                'mcfwp_flyout_setting_section',
                'mcfwp_flyout_setting_id',
                [
                    'label_for'     => 'flyout_contents',
                ]
            );

            add_settings_field(
                'total_price_type',
                __('Display Total', 'menu-cart-for-woocommerce-pro'),
                array($this, 'price_type_callback'),
                'mcfwp_flyout_setting_section',
                'mcfwp_flyout_setting_id',
                [
                    'label_for'     => 'total_price_type',
                ]
            );

            add_settings_field(
                'max_products',
                __("Set maximum number of products to display in fly-out", 'menu-cart-for-woocommerce-pro'),
                array($this, 'max_products_callback'),
                'mcfwp_flyout_setting_section',
                'mcfwp_flyout_setting_id',
                [
                    'label_for'     => 'max_products',
                ]
            );

            add_settings_field(
                'cart_checkout_btn',
                __("Display cart or checkout button on frontend", 'menu-cart-for-woocommerce-pro'),
                array($this, 'cart_checkout_btn_callback'),
                'mcfwp_flyout_setting_section',
                'mcfwp_flyout_setting_id',
                [
                    'label_for'     => 'cart_checkout_btn',
                ]
            );

            add_settings_field(
                'cart_btn_txt',
                __("Cart Button Text", 'menu-cart-for-woocommerce-pro'),
                array($this, 'cart_btn_txt_callback'),
                'mcfwp_flyout_setting_section',
                'mcfwp_flyout_setting_id',
                [
                    'label_for'     => 'cart_btn_txt',
                ]
            );

            add_settings_field(
                'checkout_btn_txt',
                __("Checkout Button Text", 'menu-cart-for-woocommerce-pro'),
                array($this, 'cart_btn_txt_callback'),
                'mcfwp_flyout_setting_section',
                'mcfwp_flyout_setting_id',
                [
                    'label_for'     => 'checkout_btn_txt',
                ]
            );

            add_settings_field(
                'empty_note_txt',
                __("Empty Note", 'menu-cart-for-woocommerce-pro'),
                array($this, 'cart_btn_txt_callback'),
                'mcfwp_flyout_setting_section',
                'mcfwp_flyout_setting_id',
                [
                    'label_for'     => 'empty_note_txt',
                ]
            );
        }

        public function flyout_checkbox_callback($args){

            global $mcfwp_flyout_options;
            $value = isset($mcfwp_flyout_options[$args['label_for']]) ? $mcfwp_flyout_options[$args['label_for']] : ''; ?>
            <label class="mcfwp-switch">
                <input type="checkbox" class="mcfwp-checkbox" name="mcfwp_flyout_options[<?php esc_attr_e($args['label_for']);  ?>]" value="on" <?php if ($value == 'on') { _e('checked');} ?>>
                <span class="mcfwp-slider"></span>
            </label>
            <?php
        }

        public function price_type_callback($args)
        {
            global $mcfwp_flyout_options;
            $value = isset($mcfwp_flyout_options[$args['label_for']]) ? $mcfwp_flyout_options[$args['label_for']] : '';
            $options = array(
                'total_including_discount'          => 'Subtotal (total of products)',
                'subtotal'         => 'Cart total (including discounts)',
                'checkout_total_including_shipping' => 'Checkout total (including discounts, fees & shipping)',
            ); ?>
            <select name="mcfwp_flyout_options[<?php esc_attr_e($args['label_for']);  ?>]">
                <?php
                foreach ($options as $key => $values) { ?>
                    <option value="<?php esc_attr_e($key); ?>" <?php if ($key == $value) { _e('selected', 'menu-cart-for-woocommerce-pro');} ?>>
                        <?php esc_attr_e($values); ?></option>
                <?php } ?>
            </select>
            <?php
        }

        public function flyout_contents_radio_callback($args){

            global $mcfwp_flyout_options;
            $value = isset($mcfwp_flyout_options[$args['label_for']]) ? $mcfwp_flyout_options[$args['label_for']] : '';
            $options = array(
                'click'          => 'On Menu Click ',
                'hover'         => 'On Menu Hover',
            );
     
            ?>
            <div class="mcfwp_price_wrap">
                <?php
                foreach ($options as $key => $values) { ?>
                    <div class="mcfwp_price_main">
                        <label><input type="radio" class="mcfwp_content" name="mcfwp_flyout_options[<?php esc_attr_e($args['label_for']);  ?>]" value="<?php esc_attr_e($key); ?>" <?php if ($key == $value) { _e('checked'); } ?>><?php esc_attr_e($values); ?></label>
                    </div>
                <?php } ?>
            </div>
            <?php
        }

        public function redirect_page_callback($args){

            global $mcfwp_flyout_options;
            $value = isset($mcfwp_flyout_options[$args['label_for']]) ? $mcfwp_flyout_options[$args['label_for']] : '';
            $options = array(
                'cart'          => 'Cart',
                'checkout'         => 'Checkout',
            ); ?>
            <?php
            foreach ($options as $key => $values) { ?>
                <div class="mcfwp_price_main">
                    <input type="radio" name="mcfwp_flyout_options[<?php esc_attr_e($args['label_for']);  ?>]" value="<?php esc_attr_e($key); ?>" <?php if ($key == $value) { _e('checked'); } ?>><?php esc_attr_e($values); ?>
                </div>
            <?php }
        }


        public function max_products_callback($args){

            global $mcfwp_flyout_options;
            $value = isset($mcfwp_flyout_options[$args['label_for']]) ? $mcfwp_flyout_options[$args['label_for']] : '';  ?>
            <select name="mcfwp_flyout_options[<?php esc_attr_e($args['label_for']);  ?>]">
                <?php
                for ($i = 1; $i <= 10; $i++) {  ?>
                    <option value="<?php esc_attr_e($i); ?>" <?php if ($value == $i) { _e('selected', 'menu-cart-for-woocommerce-pro'); } ?>><?php esc_attr_e($i); ?></option>
                <?php } ?>
                <option value="all" <?php if ($value == 'all') { _e('selected', 'menu-cart-for-woocommerce-pro'); } ?>>All</option>
            </select>
        <?php
        }

        public function cart_checkout_btn_callback($args){

            global $mcfwp_flyout_options;
            $value = isset($mcfwp_flyout_options[$args['label_for']]) ? $mcfwp_flyout_options[$args['label_for']] : '';
            $options = array(
                'cart'          => 'View cart only',
                'checkout'         => 'Checkout only',
                'cart_checkout' => 'Both cart and checkout',
                'no_any_btn'    =>  'Not any one'
            ); ?>
            <select name="mcfwp_flyout_options[<?php esc_attr_e($args['label_for']);  ?>]">
                <?php
                foreach ($options as $key => $values) { ?>
                    <option value="<?php esc_attr_e($key); ?>" <?php if ($key == $value) { _e('selected', 'menu-cart-for-woocommerce-pro'); } ?>><?php esc_attr_e($values); ?></option>
                <?php } ?>
            </select>
        <?php
        }

        public function cart_btn_txt_callback($args){

            global $mcfwp_flyout_options;
            $value = isset($mcfwp_flyout_options[$args['label_for']]) ? $mcfwp_flyout_options[$args['label_for']] : '';  ?>
            <input type="text" name="mcfwp_flyout_options[<?php esc_attr_e($args['label_for']);  ?>]" value="<?php esc_attr_e($value); ?>">
            <?php
        }

        public function sanitize_settings($input)
        {

            if (isset($input['flyout_status']) && !empty($input['flyout_status'])) {
                $new_input['flyout_status'] = sanitize_text_field($input['flyout_status']);
            }

            if (isset($input['product_image']) && !empty($input['product_image'])) {
                $new_input['product_image'] = sanitize_text_field($input['product_image']);
            }

            if (isset($input['product_name']) && !empty($input['product_name'])) {
                $new_input['product_name'] = sanitize_text_field($input['product_name']);
            }

            if (isset($input['product_price']) && !empty($input['product_price'])) {
                $new_input['product_price'] = sanitize_text_field($input['product_price']);
            }

            if (isset($input['product_quantity']) && !empty($input['product_quantity'])) {
                $new_input['product_quantity'] = sanitize_text_field($input['product_quantity']);
            }

            if (isset($input['product_link']) && !empty($input['product_link'])) {
                $new_input['product_link'] = sanitize_text_field($input['product_link']);
            }

            if (isset($input['product_total']) && !empty($input['product_total'])) {
                $new_input['product_total'] = sanitize_text_field($input['product_total']);
            }

            if (isset($input['remove_product_icon']) && !empty($input['remove_product_icon'])) {
                $new_input['remove_product_icon'] = sanitize_text_field($input['remove_product_icon']);
            }

            if (isset($input['flyout_contents']) && !empty($input['flyout_contents'])) {
                $new_input['flyout_contents'] = sanitize_text_field($input['flyout_contents']);
            }

            if (isset($input['max_products']) && !empty($input['max_products'])) {
                $new_input['max_products'] = sanitize_text_field($input['max_products']);
            }
            
            if (isset($input['total_price_type']) && !empty($input['total_price_type'])) {
                $new_input['total_price_type'] = sanitize_text_field($input['total_price_type']);
            }

            if (isset($input['cart_checkout_btn']) && !empty($input['cart_checkout_btn'])) {
                $new_input['cart_checkout_btn'] = sanitize_text_field($input['cart_checkout_btn']);
            }

            if (isset($input['cart_btn_txt']) && !empty($input['cart_btn_txt'])) {
                $new_input['cart_btn_txt'] = sanitize_text_field($input['cart_btn_txt']);
            }

            if (isset($input['checkout_btn_txt']) && !empty($input['checkout_btn_txt'])) {
                $new_input['checkout_btn_txt'] = sanitize_text_field($input['checkout_btn_txt']);
            }

            if (isset($input['empty_note_txt']) && !empty($input['empty_note_txt'])) {
                $new_input['empty_note_txt'] = sanitize_text_field($input['empty_note_txt']);
            }

            return $new_input;
        }
    }
}
