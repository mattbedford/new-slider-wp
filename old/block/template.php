<?php

namespace block;


use function SwiperWP\get_field;
use function SwiperWP\get_post;

class BlockBuild
{
	
    public static function BuildSliderBlock($block) 
    {

        $slider_selector = get_post($block['data']['slider-selector']);

        if ( ! $slider_selector ) {
            return;
        }

		$slide_type = strtolower(get_field('slider_type', $slider_selector->ID));


        // Polymorphism that could be any of "news", "logos", "hero", "products" or "partners"
        $command = "Html" . ucfirst($slide_type);
        include_once $command . ".php";

        if(!class_exists($command)) return;

        $slides_object = new $command();
        self::CreateSlider($slider_selector->ID, $slides_object);
    }

    public static function CreateSlider($slider_id, $slides_object): void
    {

        $args = [
            "slider_selector_id" => $slider_id,
            "slider_type" => get_field('slider_type'),
            "pagination" => get_field('enable_pagination'),
            "navigation" => get_field('enable_nav'),
            "scrollbar" => get_field('enable_scrollbar'),
        ];
        echo "<div class='swiper swiper" . $slider_id . "' data-slider-type='" . $slider_type . "'>";
        echo "<div class='swiper-wrapper'>";

        echo $slides_object->html;

        echo "</div>";
        if($args["pagination"]) {
            echo "<div class='swiper-pagination swiper-pagination{$slider_id}'></div>";
        }
        if($args["navigation"]) {
            echo "<div class='nav-wrap-prev'><div class='swiper-button-prev swiper-button-prev{$slider_id}'>";
            echo '<svg xmlns="http://www.w3.org/2000/svg" width="28" height="20" fill="none">
  <path fill="#03597E" d="M10.73 19.6a1.34 1.34 0 0 0 0-1.89L4.6 11.57h22.08c.73 0 1.33-.6 1.33-1.33 0-.74-.6-1.34-1.33-1.34H4.62l6.11-6.1c.51-.51.51-1.36 0-1.88a1.34 1.34 0 0 0-1.88 0L.36 9.41a1.17 1.17 0 0 0 0 1.7l8.48 8.5a1.34 1.34 0 0 0 1.9 0Z"/>
</svg>';
            echo "</div></div>";
            echo "<div class='nav-wrap-next'><div class='swiper-button-next swiper-button-next{$slider_id}'>";
            echo '<svg xmlns="http://www.w3.org/2000/svg" width="28" height="20" fill="none">
  <path fill="#03597E" d="M17.27.4a1.34 1.34 0 0 0 0 1.89l6.14 6.14H1.33C.6 8.43 0 9.03 0 9.76c0 .74.6 1.34 1.33 1.34h22.05l-6.11 6.1a1.34 1.34 0 0 0 0 1.88c.52.51 1.36.51 1.88 0l8.49-8.49a1.17 1.17 0 0 0 0-1.7L19.16.4a1.34 1.34 0 0 0-1.9 0Z"/>
</svg> ';
            echo "</div></div>";
        }
        if($args["scrollbar"]) {
            echo "<div class='swiper-scrollbar swiper-scrollbar{$slider_id}'></div>";
        }
        echo "</div>";

        $args = array_merge($args, $slides_object->settings);

        self::CreateSettings($slides_object, $args);

    }

    public static function CreateSettings($slides_object, $args): void {

        $unique_id = $args['slider_selector_id'];
        ?>

        <script defer>

            var swiper<?php echo $unique_id; ?> = new Swiper('.swiper<?php echo $unique_id; ?>', {
                slidesPerView: 1,
                spaceBetween: 30,
                loop: true,
                init: true,
                breakpoints: {
                    320: {
                        slidesPerView: <?php echo $args['320']['slides_per_view']; ?>,
                        spaceBetween: <?php echo $args['320']['space_between']; ?>,
                        navigation: {
                            <?php if( boolval($args['320']['navigation']['enabled']) === true) { ?>
                                enabled: true,
                            <?php } else { ?>
                                enabled: false,
                            <?php } ?>
                        }
                    },
                    900: {
                        slidesPerView: <?php echo $args['900']['slides_per_view']; ?>,
                        spaceBetween: <?php echo $args['900']['space_between']; ?>,
                        navigation: {
                            <?php if(boolval($args['900']['navigation']['enabled']) === true) { ?>
                            enabled: true,
                            <?php } else { ?>
                            enabled: false,
                            <?php } ?>
                        }
                    }
                }

            <?php if($slides_object->fields['pagination']) { ?>
                pagination: {
                    el: '.swiper-pagination<?php echo $unique_id; ?>',
                    clickable: true,
                },
            <?php } ?>

            <?php if($slides_object->fields['navigation']) { ?>
                navigation: {
                    nextEl: '.swiper-button-next<?php echo $unique_id; ?>',
                    prevEl: '.swiper-button-prev<?php echo $unique_id; ?>',
                }
            <?php } ?>

            <?php if($slides_object->fields['scrollbar']) { ?>
                scrollbar: {
                    el: '.swiper-scrollbar<?php echo $unique_id; ?>',
                }
            <?php } ?>

            </script>

   <?php }

}


