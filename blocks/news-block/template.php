<?php
/**
 * News block
 *
 * @param array $block The block settings and attributes.
 * @param string $content Inner blocks content if jsx is enabled
 * @param boolean $is_preview True during preview render
 * @param array $context any context variables from parent blocks if applicable
 */

namespace swiperwp;

include_once 'SwiperNewsBlock.php';
if(!$block) {
    error_log("No block variable was passed to the template. Bailing.");
    return;
}
$swiper = new SwiperNewsBlock();
$swiper->build($block);
