### Slider WP Plugin
# A WordPress plugin to create and manage custom sliders, using SwiperJS. This is a developer-level, OOP plugin and not meant for mainstream usage.

## Features
- Automatic block registration
- ACF blocks representing the various slider types available
- Includes SwiperJS

## Getting started
- Ensure you have a running copy of ACF Pro on your site
- Install plugin by uploading to plugins dir
- Import the ACF json field settings file
- Add slider blocks where you like.

## Current sliders include
- News and events slider
- Hero slider
- WooCommerce related products slider
- Corporate partners slider

## Building on top of this
(Which is the whole point of this plugin...) Add a new directory to the /blocks folder. Inside it, make a `block.json`, `template.php` and `style.css`.
Update the `block.json` with its new name (matching the name of the new blocks/`block-name` folder you created) and icon. Then add a new class (called by `template.php`) to build the slider as you like.

The structure for your slider class is __not__ constrained by a contract or interface, though should follow this structure:

```php

class [slider-name] {

    private array $settings; // Config for SwiperJS
    private array $contents; // Slide contents -> title, link, picture, etc.
    private string $block_type = "[slider-name]"; // Set this to be same name as the folder/name of your block

    /**
    * $block is passed automatically by ACF
    */
    public function Build($block): void

    /**
    * Set things like slidesPerView, Breakpoints etc. for SwiperJS here.
    * Should also call external class Settings() which pulls data from ACF fieldgroup.
    * These two arrays are then merged into $this->settings
    */
    private function BuildSettings($block): void


    /**
    * Generate contents as you wish. Build a multi-level array format
    * then save it to $this->contents
    */
    private function GetContents(): void


    /**
    * Starts the html output for the slider according to SwiperJS format. You
    * probably don't need to change this.
    */    
    private function StartHtml(): void

    /**
    * Ends the html output for the slider according to SwiperJS format. You
    * probably don't need to change this.
    */   
    private function EndHtml(): void


    /**
    * Build the single slide output in html as you desire.
    */   
    private function PrintSlides(): void

    /**
    * This calls in the second external class object, 'JavascriptConfig()` to print out the
    * SwiperJS settings you set above. You shouldn't need to alter it directly.
    */   
    private function PrintJavascript(): void

}


```
