<?php

namespace block\classes;

use function SwiperWP\get_field;

class HtmlHero {

    private $number_of_slides = 0;
    private $fields = [];

    public function __construct(object $slider_selector)
    {
        if ( ! $slider_selector ) return null;

        $this->fields = [
            "slider_selector_id" => $slider_selector->ID,
            "slider_type" => get_field('slider_type', $slider_selector->ID),
            "pagination" => get_field('enable_pagination', $slider_selector->ID),
            "navigation" => get_field('enable_nav', $slider_selector->ID),
            "scrollbar" => get_field('enable_scrollbar', $slider_selector->ID),
            "slides" => get_field('slide', $slider_selector->ID) ?? null,
        ];
        $this->number_of_slides = count($fields["slides"]) ?? 0;


    }

}