<?php
if (!class_exists('mcfwp_sticky_cart_settings')) {
    $mcfwp_sticky_cart_options = get_option('mcfwp_sticky_cart_options');

    class mcfwp_sticky_cart_settings
    {
        public function __construct()
        {
            add_action('admin_init', array($this, 'register_sticky_cart_settings_init'));
        }

        public function register_cart_settings_init()
        { ?>
            <form class="mcfwp-general-setting" action="options.php?tab=mcfwp-sticky-cart" method="post">
                <?php settings_fields('mcfwp-sticky-setting-options');   ?>
                <div class="mcfwp-section">
                    <?php do_settings_sections('mcfwp_sticky_setting_section'); ?>
                </div>
                <?php submit_button('Save Settings'); ?>
            </form>
        <?php
        }

        /* register setting */
        public function register_sticky_cart_settings_init()
        {
            register_setting('mcfwp-sticky-setting-options', 'mcfwp_sticky_cart_options', array($this, 'sanitize_settings'));

            add_settings_section(
                'mcfwp_sticky_setting_id',
                __('', 'menu-cart-for-woocommerce-pro'),
                array(),
                'mcfwp_sticky_setting_section'
            );

            add_settings_field(
                'sticky_sidebar_cart_status',
                __('Sticky Cart Button', 'menu-cart-for-woocommerce-pro'),
                array($this, 'sticky_sidebar_cart_status_callback'),
                'mcfwp_sticky_setting_section',
                'mcfwp_sticky_setting_id',
                [
                    'label_for'     => 'sticky_sidebar_cart_status',
                ]
            );

            add_settings_field(
                'item_count',
                __('Display Item count', 'menu-cart-for-woocommerce-pro'),
                array($this, 'item_count_callback'),
                'mcfwp_sticky_setting_section',
                'mcfwp_sticky_setting_id',
                [
                    'label_for'     => 'item_count',
                ]
            );

            add_settings_field(
                'sticky_cart_position',
                __('Sticky Cart position', 'menu-cart-for-woocommerce-pro'),
                array($this, 'sticky_cart_position_callback'),
                'mcfwp_sticky_setting_section',
                'mcfwp_sticky_setting_id',
                [
                    'label_for'     => 'sticky_cart_position',
                ]
            );

            add_settings_field(
                'sticky_cart_btn_redirect',
                __('Redirect to page', 'menu-cart-for-woocommerce-pro'),
                array($this, 'redirect_page_callback'),
                'mcfwp_sticky_setting_section',
                'mcfwp_sticky_setting_id',
                [
                    'label_for'     => 'sticky_cart_btn_redirect',
                ]
            );
        }

        public function sticky_sidebar_cart_status_callback($args)
        {
            global $mcfwp_sticky_cart_options;
            $value = isset($mcfwp_sticky_cart_options[$args['label_for']]) ? $mcfwp_sticky_cart_options[$args['label_for']] : '';        ?>
            <label class="mcfwp-switch">
                <input type="checkbox" class="mcfwp-checkbox" name="mcfwp_sticky_cart_options[<?php esc_attr_e($args['label_for']);  ?>]" value="on" <?php if ($value == 'on') {_e('checked', 'menu-cart-for-woocommerce-pro'); } ?>>
                <span class="mcfwp-slider"></span>
            </label>
        <?php
        }

        public function item_count_callback($args)
        {
            global $mcfwp_sticky_cart_options;
            $value = isset($mcfwp_sticky_cart_options[$args['label_for']]) ? $mcfwp_sticky_cart_options[$args['label_for']] : '';
            $options = array(
                'yes'   => 'Yes',
                'no'    => 'No',
            ); ?>
            <div class="mcfwp_price_wrap">
                <?php
                foreach ($options as $key => $values) { ?>
                    <div class="mcfwp_price_main">
                        <label>
                        <input type="radio" name="mcfwp_sticky_cart_options[<?php esc_attr_e($args['label_for']);  ?>]" value="<?php esc_attr_e($key); ?>" <?php if ($key == $value) {_e('checked', 'menu-cart-for-woocommerce-pro');} ?>><?php esc_attr_e($values); ?>
                        </label>
                    </div>
                <?php } ?>
            </div>
            <?php
        }

        public function sticky_cart_position_callback($args)
        {
            global $mcfwp_sticky_cart_options;
            $value = isset($mcfwp_sticky_cart_options[$args['label_for']]) ? $mcfwp_sticky_cart_options[$args['label_for']] : '';
            $options = array(
                'mcfwp_cart_top_left'        => 'Top Left',
                'mcfwp_cart_top_right'       => 'Top Right',
                'mcfwp_cart_bottom_left'     => 'Bottom Left',
                'mcfwp_cart_bottom_right'    => 'Bottom Right',
            ); ?>
            <select name="mcfwp_sticky_cart_options[<?php esc_attr_e($args['label_for']);  ?>]">
                <?php
                foreach ($options as $key => $values) { ?>
                    <option value="<?php esc_attr_e($key); ?>" <?php if ($key == $value) { _e('selected', 'menu-cart-for-woocommerce-pro'); } ?>><?php esc_attr_e($values); ?></option>
                <?php } ?>
            </select>
            <?php
        }

        public function redirect_page_callback($args){

            global $mcfwp_sticky_cart_options;
            $value = isset($mcfwp_sticky_cart_options[$args['label_for']]) ? $mcfwp_sticky_cart_options[$args['label_for']] : 'none';
            $options = array(
                'cart'      => 'Cart',
                'checkout'  => 'Checkout',
                'none'      => 'None',
            ); ?>
            <div class="mcfwp_price_wrap">
                <?php
                foreach ($options as $key => $values) { ?>
                    <div class="mcfwp_price_main">
                       
                        <label> <input type="radio" name="mcfwp_sticky_cart_options[<?php esc_attr_e($args['label_for']);  ?>]" value="<?php esc_attr_e($key); ?>" <?php if ($key == $value) { _e('checked', 'menu-cart-for-woocommerce-pro'); } ?>><?php esc_attr_e($values); ?></label>
                    </div>
                <?php } ?>
            </div>
            <?php
        }

        public function sanitize_settings($input){

            $new_input = array();

            if (isset($input['sticky_sidebar_cart_status']) && !empty($input['sticky_sidebar_cart_status'])) {
                $new_input['sticky_sidebar_cart_status'] = sanitize_text_field($input['sticky_sidebar_cart_status']);
            }

            if (isset($input['item_count']) && !empty($input['item_count'])) {
                $new_input['item_count'] = sanitize_text_field($input['item_count']);
            }

            if (isset($input['sticky_cart_position']) && !empty($input['sticky_cart_position'])) {
                $new_input['sticky_cart_position'] = sanitize_text_field($input['sticky_cart_position']);
            }

            if (isset($input['sticky_cart_btn_redirect']) && !empty($input['sticky_cart_btn_redirect'])) {
                $new_input['sticky_cart_btn_redirect'] = sanitize_text_field($input['sticky_cart_btn_redirect']);
            }
            return $new_input;
        }

        
    }
}
