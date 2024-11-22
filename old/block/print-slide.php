<?php

namespace block;


use function SwiperWP\__;
use function SwiperWP\esc_html;
use function SwiperWP\get_field;
use function SwiperWP\get_post;
use function SwiperWP\get_term_link;
use function SwiperWP\get_the_category;
use function SwiperWP\get_the_date;
use function SwiperWP\get_the_permalink;
use function SwiperWP\get_the_post_thumbnail_url;
use function SwiperWP\term_exists;
use function SwiperWP\wp_date;
use function SwiperWP\wp_trim_words;

class PrintSlide
{
	
	
    public function hero($slide)
    {

        $headline = $slide['slide_headline'];
        $text = $slide['slide_text'];
        $background = $slide['slide_background_image'];
        $image = $slide['slide_image_content'];
        $link = $slide['slide_link'];

        echo "<div class='swiper-slide' style='background-image: url($background);'>";
            echo "<div class='slide-content'>";
				echo "<div class='slide-texts'>";
					echo "<h2>" . __($headline, 'swiper-wp') . "</h2>";
					echo "<p>" . __($text, 'swiper-wp') . "</p>";
					echo "<a href='$link' class='btn outline-btn invert'>" . __('Scopri di più', 'swiper-wp') . "</a>";
				echo "</div>";
            echo "</div>";
        echo "</div>";
    }
	
	
	public function logos($slide)
    {

        $headline = $slide['slide_headline'];
        $text = $slide['slide_text'];
        $background = $slide['slide_background_image'];
        $image = $slide['slide_image_content'];
        $link = $slide['slide_link'];

        echo "<div class='swiper-slide' style='background-image: url($background);'>";
            echo "<div class='slide-content'>";
				echo "<div class='slide-texts'>";
					echo "<h2>" . __($headline, 'swiper-wp') . "</h2>";
					echo "<p>" . __($text, 'swiper-wp') . "</p>";
					echo "<a href='$link' class='btn outline-btn invert'>" . __('Scopri di più', 'swiper-wp') . "</a>";
				echo "</div>";
            echo "</div>";
        echo "</div>";
    }
	
	
	public function news($news)
    {

			$headline = wp_trim_words($news->post_title, 12);
			$text = wp_trim_words(get_the_excerpt($news->ID), 15);
			$cats = get_the_category($news->ID);
			$cat = $cats[0]->name;
			$date = get_the_date('j F, Y', $news->ID);
		
			// Change display date on news card to be event date if it's an event.
			if($cats[0]->term_id === 78) { // Event category term_id is 78
				$event_date = get_field('event_start_date', $news->ID);
				if(!empty($event_date)) $date = wp_date('j F, Y', strtotime($event_date));
			}
		
			
			$image = get_the_post_thumbnail_url($news->ID, 'large');
			$link = get_the_permalink($news->ID); 

			echo "<div class='swiper-slide'>";
				echo "<div class='slide-content'>";
						echo "<a href='" . $link . "'>";
					echo "<div class='news-image'><img src='" . $image . "'>";
					echo "<div class='meta-wrap'>";
					echo "<h4><span>" . __($date, 'swiper-wp') . "</span><span>//</span><span>" . __($cat, 'swiper-wp') . "</span></h4></div></div>";
					echo "<div class='slide-texts'>";
						echo "<h2>" . __($headline, 'swiper-wp') . "</h2>";
					echo "<p>" . __($text, 'swiper-wp') . "</p>";
					echo "<button class='btn outline-btn'>" . __('Scopri di più', 'swiper-wp') . "</button>";
					echo "</div>";
						echo "</a>";
				echo "</div>";
			echo "</div>";
	}
	

	public function partners($partner) 
    {
			
			if(!term_exists($partner->term_id, 'produttore')) return;
		
			$id = $partner->term_id;
			$tax_term = $partner->taxonomy . "_" . $id;
			$image = "https://contradata.sh2.hidora.net/wp-content/uploads/woocommerce-placeholder.png";
			
			if(null !== get_field('logo_produttore', $tax_term)) {
				$image = get_field('logo_produttore', $tax_term);
			}
			$link = get_term_link($id);
			
			echo "<div class='swiper-slide partner'>";
				echo "<div class='slide-content partner-logo-wrap'>";
					echo "<a href='" . $link . "'>";
					echo "<img class='partner-logo' src='" . $image . "'>";
				echo "</a>";
			echo "</div>";
			echo "</div>";
		}
	
	
	public function products($product_id)
    {
			$products = get_post($product_id);
			$headline = wp_trim_words($products->post_title, 12);
			$text = wp_trim_words(get_the_excerpt($products->ID), 15);
			$image = get_the_post_thumbnail_url($products->ID, 'large');
			$link = get_the_permalink($products->ID); 

			
			echo "<div class='swiper-slide product'>";
				echo "<a href='" . esc_html($link) . "'>";
					echo "<div class='slide-content'>";
						echo "<div class='products-image'><img src='" . $image . "'></div>";
						echo "<div class='slide-texts'>";
							echo "<h2>" . __($headline, 'swiper-wp') . "</h2>";
							echo "<p>" . __($text, 'swiper-wp') . "</p>";
						echo "</div>";
						echo \Contradata\WP\Globals::ReturnCornerIcon();
					echo "</div>";
				echo "</a>";
			echo "</div>";
	}
	
}

