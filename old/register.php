<?php





class Register {

  public function __construct() {

    \SwiperWP\add_action('init', [self::class, 'register_slider_block']);
    \SwiperWP\add_action('wp_enqueue_scripts', [self::class, 'CheckForSwiper']);
	  \SwiperWP\add_action('admin_enqueue_scripts', [self::class, 'CheckForSwiper']); // Load front-end styles & scripts even in editor view
	  \SwiperWP\add_action('admin_enqueue_scripts', [self::class, 'EditorScriptLoad']); // But load other stuff in editor view too
      
  }
  
  
  public static function EditorScriptLoad(): void
  {
	  \SwiperWP\wp_register_style('swiper-editor-styles', plugin_dir_url(__FILE__) . 'block/editor-style.css');
  }
	
  public static function CheckForSwiper (): void
  {
  	
    if ( \SwiperWP\has_block("acf/slider-block") || (\SwiperWP\is_single()) ) {
        \SwiperWP\wp_register_script(
            'swiper-js',
            'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js',
            [],
            false,
            false
        );
	   \SwiperWP\wp_register_style('swiper-custom-styles', plugin_dir_url(__FILE__) . 'block/style.css');
       \SwiperWP\wp_register_style('swiper-css', 'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css');
    } 
  }


    public static function register_slider_block() {
		
		
      	\SwiperWP\register_block_type(dirname(__FILE__) . '/block');

    }
}