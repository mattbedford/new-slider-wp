<?php

namespace swiperwp;


abstract class JavascriptConfig
{
    public static function CreateSettings($args): void {

        error_log("args are: " . print_r($args, true));
        $unique_id = $args['slider_selector_id'];
        ?>

        <script defer>
            var swiper<?php echo $unique_id; ?> = new Swiper('.swiper<?php echo $unique_id; ?>', {
                slidesPerView: 1,
                spaceBetween: 30,
                loop: true,
                breakpoints: {
                    320: {
                        slidesPerView: <?php echo $args['breakpoints'][320]['slides_per_view']; ?>,
                        spaceBetween: <?php echo $args['breakpoints'][320]['space_between']; ?>,
                        navigation: {
                            <?php if(boolval($args['breakpoints'][320]['navigation']['enabled']) === true) { ?>
                            enabled: true,
                            <?php } else { ?>
                            enabled: false,
                            <?php } ?>
                        }
                    },
                    767: {
                        slidesPerView: <?php echo $args['breakpoints'][767]['slides_per_view']; ?>,
                        spaceBetween: <?php echo $args['breakpoints'][767]['space_between']; ?>,
                        navigation: {
                            <?php if(boolval($args['breakpoints'][767]['navigation']['enabled']) === true) { ?>
                            enabled: true,
                            <?php } else { ?>
                            enabled: false,
                            <?php } ?>
                        }
                    },
                    900: {
                        slidesPerView: <?php echo $args['breakpoints'][900]['slides_per_view']; ?>,
                        spaceBetween: <?php echo $args['breakpoints'][900]['space_between']; ?>,
                        navigation: {
                        <?php if(boolval($args['breakpoints'][900]['navigation']['enabled']) === true) { ?>
                            enabled: true,
                            <?php } else { ?>
                            enabled: false,
                            <?php } ?>
                        }
                    }
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
}