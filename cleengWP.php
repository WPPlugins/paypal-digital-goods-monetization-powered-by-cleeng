<?php
/*
  Plugin Name: PayPal Digital Goods powered by Cleeng
  Plugin URI: http://www.cleeng.com/
  Version: 2.2.15
  Description: PayPal Digital Goods powered by Cleeng makes one-click content monetization extremely easy. This plugin is for everybody who wish to sell easily quality digital content: articles, photos, apps, videos or any other digital goods. Users can purchase using PayPal Digital Goods, and leverage Cleeng's frictionless user experience - pay with one click and access content instantly.
  Author: Cleeng
  Author URI: http://cleeng.com
  License: New BSD License (http://cleeng.com/license/new-bsd.txt)
 */

/**
 * Plugin bootstrap
 */

// setup URL for assets
if (!defined('CLEENG_PLUGIN_URL')) {
    define('CLEENG_PLUGIN_URL',
            WP_PLUGIN_URL . '/' . str_replace(basename(__FILE__), "", plugin_basename(__FILE__)));
}
//echo CLEENG_PLUGIN_URL; die;
if (!class_exists('Cleeng_Core')) { // check if another instance of Cleeng For WordPress is already activated
    // load translations
    load_plugin_textdomain('cleeng', false, dirname(plugin_basename(__FILE__)) . '/languages/');

    // load and setup Cleeng_Core class,
    require_once dirname(__FILE__) . '/php/classes/Core.php';
    Cleeng_Core::get_instance()->setup();

    // register activation hook - it must be dont inside this file
    register_activation_hook(__FILE__, array('Cleeng_Core', 'activate'));
    register_deactivation_hook(__FILE__, array('Cleeng_Core', 'deactivate'));
} else {
    if (!function_exists('cleeng_multiple_instance_warning')) {
        function cleeng_multiple_instance_warning()
        {
            echo '<div class="updated">';
            echo '<p>Warning: you have multiple instances of Cleeng For WordPress installed. All additional installations will be disabled.</p>';
            echo '</div>';
        }

        add_action('admin_notices', 'cleeng_multiple_instance_warning');
    }
}
