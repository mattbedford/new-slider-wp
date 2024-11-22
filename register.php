<?php


namespace swiperwp;


if ( ! defined( 'ABSPATH' ) ) {
    exit;
}


class Register
{

    public function __construct() {

        // Register helper classes
        include_once 'settings.php';
        include_once 'JavascriptConfig.php';

        // get an array of all of the block.json files in the blocks directory
        $block_json_files = glob( dirname(__FILE__) . '/blocks/**/block.json' );

        // auto register all blocks that were found.
        foreach ( $block_json_files as $block_json_file ) {
            register_block_type($block_json_file);
        }

        // Singles will need SwiperJS scripts and style, so register them here.
        // Also adding global custom-styles to avoid repeating in blocks.
            \wp_register_script(
                'swiper-js',
                'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js',
                [],
                false,
                false
            );
            \wp_register_style('swiper-css', 'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css');
            \wp_register_style( 'custom-swiper-css' , plugin_dir_url( __FILE__ ) . 'style.css' );
    }


}