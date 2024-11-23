<?php

namespace swiperwp;


abstract class JavascriptConfig
{

    public static function CreateSettings($args): void {

        $unique_id = $args['slider_selector_id'];
        ?>

        <script defer>
            var swiper<?php echo $unique_id; ?> = new Swiper('.swiper<?php echo $unique_id; ?>', {
                slidesPerView: 1,
                spaceBetween: 30,
                loop: true,
                breakpoints: {
                    <?php
                    if (isset($args['breakpoints'])) {

                        foreach ($args['breakpoints'] as $breakpoint => $breakpoint_args) {
                            echo $breakpoint . ": {";
                            echo "slidesPerView: " . $breakpoint_args['slides_per_view'] . ",";
                            echo "spaceBetween: " . $breakpoint_args['space_between'] . ",";
                            if (self::isNavigationEnabled($breakpoint_args)) {
                                echo "navigation: {";
                                echo "enabled: true";
                                echo "},";
                            } else {
                                echo "navigation: {";
                                echo "enabled: false";
                                echo "},";
                            }
                            echo "},";
                        }
                    } ?>
                },
                <?php if($args['pagination']) { ?>
                pagination: {
                    el: '.swiper-pagination<?php echo $unique_id; ?>',
                    clickable: true,
                },
                <?php } ?>

                <?php if($args['navigation']) { ?>
                navigation: {
                    nextEl: '.swiper-button-next<?php echo $unique_id; ?>',
                    prevEl: '.swiper-button-prev<?php echo $unique_id; ?>',
                }
                <?php } ?>

                <?php if($args['scrollbar']) { ?>
                scrollbar: {
                    el: '.swiper-scrollbar<?php echo $unique_id; ?>',
                }
            <?php } ?>
            });
        </script>

    <?php }


    public static function isNavigationEnabled(array $navigationSettings): bool
    {
        return !empty($navigationSettings['navigation']['enabled']) && boolval($navigationSettings['navigation']['enabled']) === true;
    }

}