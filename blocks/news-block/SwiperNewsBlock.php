<?php


namespace swiperwp;


class SwiperNewsBlock
{

    private $settings;
    private $contents;
    private $block_type = "news";



    public function Build($block): void
    {
        $this->BuildSettings($block);
        $this->GetContents();
        $this->StartHtml();
        $this->PrintSlides();
        $this->EndHtml();
        $this->PrintJavascript();
    }


    private function BuildSettings($block): void
    {
        $settings_object = new Settings($this->block_type, $block);

        $config = [
            "number_of_slides" => 0,
            "slides_per_view" => 4,
            "space_between" => 20,
            "loop" => true,
            "autoplay" => false,
            "breakpoints" => [
                1400 => [
                    "slides_per_view" => 3,
                    "space_between" => 20,
                    "navigation" => [
                        "enabled" => true,
                    ],
                ],
                900 => [
                    "slides_per_view" => 3,
                    "space_between" => 20,
                    "navigation" => [
                        "enabled" => true,
                    ],
                ],
                767 => [
                    "slides_per_view" => 2,
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

    private function GetContents(): void
    {

        $news_posts = get_posts([
            "post_type" => "post",
            "numberposts" => 8,
        ]);
                
        if($news_posts) {
            foreach($news_posts as $post) {

                $cats = get_the_category($post->ID);

                // Change display date on news card to be event date if it's an event.
                $date = get_the_date('j F, Y', $post->ID);

                if(is_array($cats) && $cats[0]->term_id === 78) { // Event category term_id is 78
                    $event_date = get_field('event_start_date', $post->ID);
                    if(!empty($event_date)) {
                        $date = wp_date('j F, Y', strtotime($event_date));
                    }
                }
                $image = get_the_post_thumbnail_url($post->ID, 'large');
                $link = get_the_permalink($post->ID);

                $this->contents[] = [
                    "headline" => wp_trim_words($post->post_title, 12),
                    "text" => wp_trim_words(get_the_excerpt($post->ID), 15),
                    "cats" => $cats,
                    "cat" => $cats[0]->name,
                    "date" => $date,
                    "image" => $image ?? "/wp-content/uploads/2024/09/placeholder.jpg",
                    "link" => $link,
                ];

            }
        }

        if(is_iterable($this->contents)) {
            $this->settings["number_of_slides"] = count($this->contents) ?? 0;
        }

    }

    private function StartHtml(): void
    {
        $slider_type = $this->settings['slider_type'];
        $slider_id = $this->settings['slider_selector_id'];

        echo "<div class='swiper swiper" . $slider_id . "' data-slider-type='" . $slider_type . "'>";
        echo "<div class='swiper-wrapper'>";
    }

    private function EndHtml(): void
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

    private function PrintSlides(): void
    {

        foreach ($this->contents as $slide) {

            error_log("Slide is:" . print_r($slide, true));

            echo "<div class='swiper-slide'>";
            echo "<div class='slide-content'>";
            echo "<a href='" . $slide['link'] . "'>";
            echo "<div class='news-image'><img src='" . $slide['image'] . "'>";
            echo "<div class='meta-wrap'>";
            echo "<h4><span>" . __($slide['date'], 'swiperwp') . "</span><span>//</span><span>" . __($slide['cat'], 'swiperwp') . "</span></h4></div></div>";
            echo "<div class='slide-texts'>";
            echo "<h2>" . __($slide['headline'], 'swiperwp') . "</h2>";
            echo "<p>" . __($slide['text'], 'swiper-wp') . "</p>";
            echo "<button class='btn outline-btn'>" . __('Scopri di più', 'swiperwp') . "</button>";
            echo "</div>";
            echo "</a>";
            echo "</div>";
            echo "</div>";

        }
    }

    private function PrintJavascript(): void
    {

        JavascriptConfig::CreateSettings($this->settings);
    }

}