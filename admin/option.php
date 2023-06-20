<?php
include(MCFWP_PLUGIN_DIR_PATH . 'admin/settings/general-setting.php');
include(MCFWP_PLUGIN_DIR_PATH . 'admin/settings/flyout-setting.php');
include(MCFWP_PLUGIN_DIR_PATH . 'admin/settings/sticky-cart-setting.php');
include(MCFWP_PLUGIN_DIR_PATH . 'admin/settings/design-elements-setting.php');
include(MCFWP_PLUGIN_DIR_PATH . 'admin/settings/shortcode-setting.php');

$default_tab = null;
$tab = "";
$tab = isset($_GET['tab']) ? sanitize_text_field($_GET['tab']) : $default_tab;

if (!class_exists('mcfwp_settings')) {

    if ($tab == null) {
        $general  = new mcfwp_general_settings();
        add_action('admin_init', array($general, 'register_general_settings_init'));
    }

    if ($tab == "mcfwp-flyout") {
        $flyout  = new mcfwp_flyout_settings();
        add_action('admin_init', array($flyout, 'register_flyout_settings_init'));
    }

    if ($tab == "mcfwp-design-elements") {
        $design  = new mcfwp_design_elements_settings();
        add_action('admin_init', array($design, 'register_design_elements_settings_init'));
    }

    if ($tab == "mcfwp-sticky-cart") {
        $sticky  = new mcfwp_sticky_cart_settings();
        add_action('admin_init', array($sticky, 'register_sticky_cart_settings_init'));
    }

    if ($tab == "mcfwp-shortcode") {
        $sticky  = new mcfwp_shortcode_settings();
        add_action('admin_init', array($sticky, 'shortcode_settings_init'));
    }

    class mcfwp_settings
    {
        public function __construct()
        {
            add_action('admin_menu',  array($this, 'mcfwp_admin_menu_setting_page'));
        }

        function mcfwp_admin_menu_setting_page()
        {
            if (class_exists('WooCommerce')) {
                add_submenu_page('woocommerce', 'Menu Cart Pro', 'Menu Cart Pro', 'manage_options', 'mcfwp-option-page', array($this, 'menu_page_customize_callback'));
            }
        }

        function menu_page_customize_callback()
        {
            $default_tab = null;
            $tab = isset($_GET['tab']) ? sanitize_text_field($_GET['tab']) : $default_tab; ?>
            <div class="mcfwp-main-box">
                <div class="mcfwp-container">
                    <div class="mcfwp-header">
                        <h1 class="mcfwpp-h1"> <?php _e('Menu Cart For WooCommerce Pro', 'menu-cart-for-woocommerce-pro'); ?></h1>
                    </div>
                    <div class="mcfwp-option-section">
                        <div class="mcfwp-sidebar">
                            <ul class="mcfwp-tab-list">
                                <li>
                                    <a href="?page=mcfwp-option-page" class="nav-tab <?php if ($tab === null) : ?>nav-tab-active<?php endif; ?>">
                                        <span><img src="<?php _e(MCFWP_PLUGIN_URL . '/assets/images/gear.png'); ?>" alt=""></span>
                                        <?php _e('General Settings', 'menu-cart-for-woocommerce-pro'); ?>
                                    </a>
                                </li>
                                <li>
                                    <a href="?page=mcfwp-option-page&tab=mcfwp-flyout" class="nav-tab <?php if ($tab === 'mcfwp-flyout') : ?>nav-tab-active<?php endif; ?>">
                                        <span><img src="<?php _e(MCFWP_PLUGIN_URL . '/assets/images/web-browser.png'); ?>" alt=""></span>
                                        <?php _e('Flyout Settings', 'menu-cart-for-woocommerce-pro'); ?>
                                    </a>
                                </li>
                                <li>
                                    <a href="?page=mcfwp-option-page&tab=mcfwp-sticky-cart" class="nav-tab <?php if ($tab === 'mcfwp-sticky-cart') : ?>nav-tab-active<?php endif; ?>">
                                        <span><img src="<?php _e(MCFWP_PLUGIN_URL . '/assets/images/add-to-cart.png'); ?>" alt=""></span>
                                        <?php _e('Sticky Cart Settings', 'menu-cart-for-woocommerce-pro'); ?>
                                    </a>
                                </li>
                                <li>
                                    <a href="?page=mcfwp-option-page&tab=mcfwp-design-elements" class="nav-tab <?php if ($tab === 'mcfwp-design-elements') : ?>nav-tab-active<?php endif; ?>">
                                        <span><img src="<?php _e(MCFWP_PLUGIN_URL . '/assets/images/color-palette.png'); ?>" alt=""></span>
                                        <?php _e('Design Elements', 'menu-cart-for-woocommerce-pro'); ?>
                                    </a>
                                </li>
                                <li>
                                    <a href="?page=mcfwp-option-page&tab=mcfwp-shortcode" class="nav-tab <?php if ($tab === 'mcfwp-shortcode') : ?>nav-tab-active<?php endif; ?>">
                                        <span><img src="<?php _e(MCFWP_PLUGIN_URL . '/assets/images/coding.png'); ?>" alt=""></span>
                                        <?php _e('Shortcode', 'menu-cart-for-woocommerce-pro'); ?>
                                    </a>
                                </li>
                            </ul>
                        </div>

                        <div class="mcfwp-tabing-option">
                            <?php if ($tab == null) {
                                $general  = new mcfwp_general_settings();
                                $general->register_settings_init();
                            }

                            if ($tab == "mcfwp-flyout") {
                                $flyout  = new mcfwp_flyout_settings();
                                $flyout->register_flyout_design_settings_init();
                            }

                            if ($tab == "mcfwp-sticky-cart") {
                                $sticky  = new mcfwp_sticky_cart_settings();
                                $sticky->register_cart_settings_init();
                            }

                            if ($tab == "mcfwp-design-elements") {
                                $design  = new mcfwp_design_elements_settings();
                                $design->design_elements_setting_form_option();
                            } 

                            if ($tab == "mcfwp-shortcode") {
                                $design  = new mcfwp_shortcode_settings();
                                $design->shortcode_setting_form_option();
                            } ?>
                        </div>
                    </div>
                </div>
            </div>
<?php
        }
    }
    new mcfwp_settings();
}
