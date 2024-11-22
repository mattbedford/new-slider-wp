<?php

namespace block\classes;

use block\PrintSlide;
use function SwiperWP\get_terms;

class HtmlPartners {

    private $fields = [];
    public $html = "";
    public $settings = [];

    public function __construct(object $slider_selector)
    {

        $this->settings = [
            "number_of_slides" => 5,
            "slides_per_view" => 1,
            "space_between" => 20,
            "loop" => true,
            "autoplay" => true,
            "breakpoints" => [
                900 => [
                    "slides_per_view" => 2,
                    "space_between" => 40,
                    "navigation" => [
                        "enabled" => true,
                    ],
                ],
                320 => [
                    "slides_per_view" => 1,
                    "space_between" => 20,
                    "navigation" => [
                        "enabled" => false,
                    ],
                ],
            ],

        ];

        $this->Contents();
    }

    private function Contents() {
        $this->fields['slides'] = get_terms([
            'taxonomy' => 'produttore',
            'parent'   => 0,
            'limit' => -1,
            'order' => 'ASC',
            'orderby' => 'name'
        ]);
        $slider_type = strval($this->fields["slider_type"]);

        include_once dirname(__DIR__) . '/print-slide.php';

        foreach( $this->fields["slides"] as $slide ) {
            $printer = new PrintSlide();
            $this->html .= $printer->$slider_type($slide);
        }
    }

}