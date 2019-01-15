<?php
/* Plugin Name: Lennox Promotions & Products
Plugin URI: http://leadsnearby.com/
Description: Creates shortcode to include Lennox Promotions and Special offers on website.

Version: 1.1.0
Author: Leads Nearby
Author URI: http://leadsnearby.com/
License: GPLv2 or later
 */

define('Lennox_MAIN', plugin_dir_path(__FILE__));
define('Lennox_LIB', Lennox_MAIN . 'lib/');
define('Lennox_CLASSES', Lennox_LIB . 'classes/');
define('Lennox_SHORTCODES', Lennox_LIB . 'shortcodes/');
define('Lennox_ASSETS', plugins_url('assets/', __FILE__));

require_once Lennox_LIB . 'functions.php';

// Initialize Admin
if (is_admin()):
    require_once Lennox_LIB . 'admin/admin-init.php';
    new lennox_admin_page;
endif;

// Load Shortcodes
require_once Lennox_SHORTCODES . 'promotion-shortcode.php';
require_once Lennox_SHORTCODES . 'product-shortcode.php';
require_once Lennox_LIB . 'xml-helpers.php';

// Enqueue Styles
function lnb_lennox_styles() {
    wp_register_style('lennox-styles', Lennox_ASSETS . 'css/styles.css');

    if (!is_admin()):
        wp_enqueue_style('lennox-styles');
    endif;
}
add_action('wp_enqueue_scripts', 'lnb_lennox_styles');

// Load JS for Products
function lnb_lennox_scripts() {
    wp_register_script('lennox-product-api-helperjs', Lennox_ASSETS . 'js/products-helper.js', array(), '1.0.0', true);
    wp_enqueue_script('lennox-product-api-helperjs');
}
add_action('wp_enqueue_scripts', 'lnb_lennox_scripts');

add_action('admin_init', function () {
    if (class_exists('\lnb\core\GitHubPluginUpdater')) {
        new \lnb\core\GitHubPluginUpdater(__FILE__, 'lennox-promotions-products');
    }
}, 99);
