<?php

/**
 * Plugin Name: Swiper WP
 * Description: Custom block carousel module built with SwiperJS and Gutenberg blocks
 * Version:     1.0.0
 * Author:      Dev Team
 * Text Domain: swiperwp
 * Requires PHP:    8.1
 * License:     GPL v2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 */


namespace swiperwp;

if (!defined('ABSPATH')) {
    exit;
}

class SwiperWp
{

    public function __construct()
    {
        // ACF Pro is required, but we don't include it in plugin headers
        // as it is currently unavailable on wp repos.
        if (!function_exists('is_plugin_active')) {
            include_once ABSPATH . 'wp-admin/includes/plugin.php';
        }

        // If we find ACF Pro, then go ahead and register our blocks.
        if (is_plugin_active('advanced-custom-fields-pro/acf.php')) {

            include_once 'register.php';
            add_action('init', function () {
                new Register();
            });

        }
    }
}

new SwiperWp();
