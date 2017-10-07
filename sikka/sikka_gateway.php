<?php
/*
Plugin Name: Sikka - WooCommerce Gateway
Plugin URI: https://unclemusclez.com
Description: Extends WooCommerce by Adding the Sikka Gateway
Version: 1.0
Author: unclemusclez
Author URI: https://unsclemusclez.com
*/
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}
// Include our Gateway Class and register Payment Gateway with WooCommerce
add_action('plugins_loaded', 'sikka_init', 0);
function sikka_init()
{
    /* If the class doesn't exist (== WooCommerce isn't installed), return NULL */
    if (!class_exists('WC_Payment_Gateway')) return;


    /* If we made it this far, then include our Gateway Class */
    include_once('include/sikka_payments.php');
    require_once('library.php');

    // Lets add it too WooCommerce
    add_filter('woocommerce_payment_gateways', 'sikka_gateway');
    function sikka_gateway($methods)
    {
        $methods[] = 'Sikka_Gateway';
        return $methods;
    }
}

/*
 * Add custom link
 * The url will be http://yourworpress/wp-admin/admin.php?=wc-settings&tab=checkout
 */
add_filter('plugin_action_links_' . plugin_basename(__FILE__), 'sikka_payment');
function sikka_payment($links)
{
    $plugin_links = array(
        '<a href="' . admin_url('admin.php?page=wc-settings&tab=checkout') . '">' . __('Settings', 'sikka_payment') . '</a>',
    );

    return array_merge($plugin_links, $links);
}

add_action('admin_menu', 'sikka_create_menu');
function sikka_create_menu()
{
    add_menu_page(
        __('Sikka', 'textdomain'),
        'Sikka',
        'manage_options',
        'admin.php?page=wc-settings&tab=checkout&section=sikka_gateway',
        '',
        plugins_url('sikka/assets/icon.png'),
        56 // Position on menu, woocommerce has 55.5, products has 55.6

    );
}


