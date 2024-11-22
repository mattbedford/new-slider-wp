<?php

namespace swiperwp;


class Settings
{
    public $fields = [];

    public function __construct($block = null)
    {
        if(!$block || null === $block) return;

        $block_id = $block['id'];

        $this->fields = [
            "slider_selector_id" => $block_id,
            "slider_type" => get_field('slider_type') ?? 'hero',
            "pagination" => get_field('enable_pagination' ?? false),
            "navigation" => get_field('enable_nav') ?? false,
            "scrollbar" => get_field('enable_scrollbar') ?? false,
            "slides" => get_field('slides') ?? [],
        ];
    }
}