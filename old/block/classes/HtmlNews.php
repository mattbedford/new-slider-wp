<?php

namespace block\classes;

use block\PrintSlide;
use function SwiperWP\get_field;
use function SwiperWP\get_posts;

class HtmlNews
{

    private $number_of_slides = 0;
    private $fields = [];


    public function __construct(object $slider_selector)
    {
        if ( ! $slider_selector ) return null;

        $fields = [
            "slider_selector_id" => $slider_selector->ID,
            "slider_type" => get_field('slider_type', $slider_selector->ID),
            "pagination" => get_field('enable_pagination', $slider_selector->ID),
            "navigation" => get_field('enable_nav', $slider_selector->ID),
            "scrollbar" => get_field('enable_scrollbar', $slider_selector->ID),
            "slides" => [1,2],
        ];

        return $fields;
    }

    public function Print(){
        $fields['slides'] = get_posts([
            "post_type" => "post",
            "numberposts" => 8,
        ]);

        include_once 'print-slide.php';
        $unique_id = $fields["slider_selector_id"];

        echo "<div class='swiper swiper" . $unique_id . "' data-slider-type='" . $slider_type . "'>";
        echo "<div class='swiper-wrapper'>";

        foreach( $fields["slides"] as $slide ) {
            $printer = new PrintSlide();
            $printer->$slider_type($slide);
        }
        echo "</div>";
    }
}



