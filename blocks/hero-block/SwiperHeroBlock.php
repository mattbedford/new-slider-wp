<?php


namespace swiperwp;


class SwiperHeroBlock
{

    private $settings;
    private $contents;

    public function Build($block): void
    {
        //$this->EnqueueScriptsAndStyles();
        $this->BuildSettings($block);
        $this->GetContents();
        $this->StartHtml();
        $this->PrintSlides();
        $this->EndHtml();
        $this->PrintJavascript();
    }


    private function BuildSettings($block)
    {
        $settings_object = new Settings($block);

        $config = [
            "number_of_slides" => 0,
            "slides_per_view" => 1,
            "space_between" => 20,
            "loop" => true,
            "autoplay" => false,
            "breakpoints" => [
                900 => [
                    "slides_per_view" => 1,
                    "space_between" => 20,
                    "navigation" => [
                        "enabled" => true,
                    ],
                ],
                767 => [
                    "slides_per_view" => 1,
                    "space_between" => 20,
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
        $this->settings = array_merge($settings_object->fields, $config);
    }

    private function GetContents()
    {
        if($this->settings["slides"]) {
            foreach($this->settings["slides"] as $single_slide) {

                $this->contents[] = [
                    'headline' => $single_slide['slide_headline'] ?? null,
                    'text' => $single_slide['slide_text'] ?? null,
                    'background' => $single_slide['slide_background_image'] ?? null,
                    'link' => $single_slide['slide_link'] ?? null,
                ];
            }
        }

        if(is_iterable($this->contents)) {
            $this->settings["number_of_slides"] = count($this->contents) ?? 0;
        }

    }

    private function StartHtml()
    {
        $slider_type = $this->settings['slider_type'];
        $slider_id = $this->settings['slider_selector_id'];

        echo "<div class='swiper swiper" . $slider_id . "' data-slider-type='" . $slider_type . "'>";
        echo "<div class='swiper-wrapper'>";
    }

    private function EndHtml()
    {
        $slider_id = $this->settings['slider_selector_id'];

        echo "</div>";
        if($this->settings["pagination"]) {
            echo "<div class='swiper-pagination swiper-pagination{$slider_id}'></div>";
        }

        if($this->settings["navigation"]) {
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

        if($this->settings["scrollbar"]) {
            echo "<div class='swiper-scrollbar swiper-scrollbar{$slider_id}'></div>";
        }

        echo "</div>";
    }

    private function PrintSlides()
    {

        foreach ($this->contents as $slide) {

            error_log("Slide is:" . print_r($slide, true));

            echo "<div class='swiper-slide' style='background-image: url(" . $slide['background'] . ");'>";
            echo "<div class='slide-content'>";
            echo "<div class='slide-texts'>";
            echo "<h2>" . __($slide['headline'], 'swiperwp') . "</h2>";
            echo "<p>" . __($slide['text'], 'swiperwp') . "</p>";
            echo "<a href='" . $slide["link"] . "' class='btn outline-btn invert'>" . __('Scopri di più', 'swiperwp') . "</a>";
            echo "</div>";
            echo "</div>";
            echo "</div>";

        }
    }

    private function PrintJavascript()
    {

        JavascriptConfig::CreateSettings($this->settings);
    }

}