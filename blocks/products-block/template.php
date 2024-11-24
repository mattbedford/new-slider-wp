<?php
/**
 * Products block
 *
 * @param array $block The block settings and attributes.
 * @param string $content Inner blocks content if jsx is enabled
 * @param boolean $is_preview True during preview render
 * @param array $context any context variables from parent blocks if applicable
 */

namespace swiperwp;

include_once 'SwiperProductsBlock.php';
if(!$block) {
    error_log("No block variable was passed to the template. Bailing.");
    return;
}
$swiper = new SwiperProductsBlock();
$swiper->build($block);
