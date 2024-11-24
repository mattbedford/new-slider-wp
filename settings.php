<?php

namespace swiperwp;


class Settings
{
    public $fields = [];

<<<<<<< HEAD
    public function __construct(string $block_type, $block = null)
=======
    public function __construct(String $block_type, $block = null)
>>>>>>> pre-release
    {
        if(!$block || null === $block) return;

        $block_id = $block['id'];

        $this->fields = [
            "slider_selector_id" => $block_id,
            "slider_type" => $block_type,
            "pagination" => get_field('enable_pagination' ?? false),
            "navigation" => get_field('enable_nav') ?? false,
            "scrollbar" => get_field('enable_scrollbar') ?? false,
            "slides" => get_field('slides') ?? [],
        ];
    }
}