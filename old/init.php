<?php
/**
 * Plugin Name: Swiper WP
 * Description: A tool to use in conjunction with ACF Pro to create a custom SwiperJS block.
 * Version:     2.0.0
 * Author:      Dev team
 * Text Domain: swiper-wp
 * License:     GPL v2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 */

namespace SwiperWP;

use Register;

include_once 'block/template.php';
include_once 'register.php';
new Register();