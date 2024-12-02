<?php

if (!defined('ABSPATH')) exit;

/**
 * License manager module
 */
function mcfw_updater_utility() {
    $prefix = 'MCFW_';
    $settings = [
        'prefix' => $prefix,
        'get_base' => MCFW_PLUGIN_BASENAME,
        'get_slug' => MCFW_PLUGIN_DIR,
        'get_version' => MCFW_BUILD,
        'get_api' => 'https://download.geekcodelab.com/',
        'license_update_class' => $prefix . 'Update_Checker'
    ];

    return $settings;
}

function mcfw_updater_activate() {

    // Refresh transients
    delete_site_transient('update_plugins');
    delete_transient('mcfw_plugin_updates');
    delete_transient('mcfw_plugin_auto_updates');
}

require_once(MCFW_PLUGIN_DIR_PATH . 'updater/class-update-checker.php');
