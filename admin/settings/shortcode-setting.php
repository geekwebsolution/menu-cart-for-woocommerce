<?php
if (!class_exists('mcfwp_shortcode_settings')) {
    $mcfwp_shortcode_options = get_option('mcfwp_shortcode_options');

    class mcfwp_shortcode_settings
    {
        public function __construct()
        {
            add_action('admin_init', array($this, 'shortcode_settings_init'));
        }

        public function shortcode_setting_form_option()
        { ?>
            <form class="mcfwp-general-setting" action="options.php?tab=mcfwp-shortcode" method="post">
           
                <?php settings_fields('mcfwp-shortcode-setting-options');   ?>
                <div class="mcfwp-section">
                    <?php do_settings_sections('mcfwp_shortcode_setting_section'); ?>
                </div>
                <?php submit_button('Save Settings'); ?>
            </form>
        <?php
        }

        /* register setting */
        public function shortcode_settings_init()
        {
            register_setting('mcfwp-shortcode-setting-options', 'mcfwp_shortcode_options', array($this, 'sanitize_settings'));

            add_settings_section(
                'mcfwp_shortcode_setting_id',
                __('', 'menu-cart-for-woocommerce-pro'),
                array(),
                'mcfwp_shortcode_setting_section'
            );

            add_settings_field(
                'shortcode_copy',
                __('Shortcode', 'menu-cart-for-woocommerce-pro'),
                array($this, 'shortcode_callback'),
                'mcfwp_shortcode_setting_section',
                'mcfwp_shortcode_setting_id',
                [
                    'label_for'     => 'shortcode_copy',
                ]
            );

            add_settings_field(
                'flyout_status',
                __('Flyout <p>Only the desktop displays Flyout.<br>(window width above 991px)</p>', 'menu-cart-for-woocommerce-pro'),
                array($this, 'flyout_checkbox_callback'),
                'mcfwp_shortcode_setting_section',
                'mcfwp_shortcode_setting_id',
                [
                    'label_for'     => 'flyout_status',
                ]
            );

            add_settings_field(
                'flyout_contents',
                __('Display Flyout contents', 'menu-cart-for-woocommerce-pro'),
                array($this, 'flyout_contents_radio_callback'),
                'mcfwp_shortcode_setting_section',
                'mcfwp_shortcode_setting_id',
                [
                    'label_for'     => 'flyout_contents',
                ]
            );

          

         
        }

        public function shortcode_callback(){
            ?>
            <div class="mcfwp_shortcode_input_wp">
            <input type="text" readonly value="[mcfwp_cart_menu]" id="mcfwp_shortcode_copy" >
            <div class="mcfwp_shortcode_tooltip">

                <svg  id="mcfwp_copy_icon"xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:svgjs="http://svgjs.com/svgjs" width="512" height="512" x="0" y="0" viewBox="0 0 699.428 699.428" style="enable-background:new 0 0 512 512" xml:space="preserve" class=""><path d="M502.714,0c-2.71,0-262.286,0-262.286,0C194.178,0,153,42.425,153,87.429l-25.267,0.59     c-46.228,0-84.019,41.834-84.019,86.838V612c0,45.004,41.179,87.428,87.429,87.428H459c46.249,0,87.428-42.424,87.428-87.428     h21.857c46.25,0,87.429-42.424,87.429-87.428v-349.19L502.714,0z M459,655.715H131.143c-22.95,0-43.714-21.441-43.714-43.715     V174.857c0-22.272,18.688-42.993,41.638-42.993L153,131.143v393.429C153,569.576,194.178,612,240.428,612h262.286     C502.714,634.273,481.949,655.715,459,655.715z M612,524.572c0,22.271-20.765,43.713-43.715,43.713H240.428     c-22.95,0-43.714-21.441-43.714-43.713V87.429c0-22.272,20.764-43.714,43.714-43.714H459c-0.351,50.337,0,87.975,0,87.975     c0,45.419,40.872,86.882,87.428,86.882c0,0,23.213,0,65.572,0V524.572z M546.428,174.857c-23.277,0-43.714-42.293-43.714-64.981     c0,0,0-22.994,0-65.484v-0.044L612,174.857H546.428z M502.714,306.394H306c-12.065,0-21.857,9.77-21.857,21.835     c0,12.065,9.792,21.835,21.857,21.835h196.714c12.065,0,21.857-9.771,21.857-21.835     C524.571,316.164,514.779,306.394,502.714,306.394z M502.714,415.57H306c-12.065,0-21.857,9.77-21.857,21.834     c0,12.066,9.792,21.836,21.857,21.836h196.714c12.065,0,21.857-9.77,21.857-21.836C524.571,425.34,514.779,415.57,502.714,415.57     z" fill="#1d6e69" data-original="#000000" class=""></path></svg>
                <span class="mcfwp_tooltiptext" id="mcfwp_shortcodeTooltip">Copy to clipboard</span>
            </div>
            </div>
            <?php
        }


        public function flyout_checkbox_callback($args){

            global $mcfwp_shortcode_options;
            $value = isset($mcfwp_shortcode_options[$args['label_for']]) ? $mcfwp_shortcode_options[$args['label_for']] : ''; ?>
            <label class="mcfwp-switch">
                <input type="checkbox" class="mcfwp-checkbox" name="mcfwp_shortcode_options[<?php esc_attr_e($args['label_for']);  ?>]" value="on" <?php if ($value == 'on') { _e('checked');} ?>>
                <span class="mcfwp-slider"></span>
            </label>
            <?php
        }

        public function flyout_contents_radio_callback($args){

            global $mcfwp_shortcode_options;
            $value = isset($mcfwp_shortcode_options[$args['label_for']]) ? $mcfwp_shortcode_options[$args['label_for']] : '';
            $options = array(
                'click'          => 'On Menu Click ',
                'hover'         => 'On Menu Hover',
            ); ?>
            <div class="mcfwp_price_wrap">
                <?php
                foreach ($options as $key => $values) { ?>
                    <div class="mcfwp_price_main">
                        <label><input type="radio" class="mcfwp_content" name="mcfwp_shortcode_options[<?php esc_attr_e($args['label_for']);  ?>]" value="<?php esc_attr_e($key); ?>" <?php if ($key == $value) { _e('checked'); } ?>><?php esc_attr_e($values); ?></label>
                    </div>
                <?php } ?>
            </div>
            <?php
        }


        public function sanitize_settings($input)
        {

            if (isset($input['flyout_status']) && !empty($input['flyout_status'])) {
                $new_input['flyout_status'] = sanitize_text_field($input['flyout_status']);
            }

            if (isset($input['flyout_contents']) && !empty($input['flyout_contents'])) {
                $new_input['flyout_contents'] = sanitize_text_field($input['flyout_contents']);
            }

         

            return $new_input;
        }
       
    

        
    }
}
