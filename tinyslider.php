<?php
/*
Plugin Name: TinySlider
Plugin URI: http://example.com/
Description: This plugin for slider
Version: 1.0
Author: sadathimel
Author URI: http://github.com/sadathossen
License: GPLv2 or later
Text Domain: tinyslider
Domain Path: /languages
 */

function tinys_load_textdomain() {
    load_plugin_textdomain( 'tinyslider', false, dirname( __FILE__ ) . "/languages" );
}
add_action( 'plugin_loaded', 'tinys_load_textdomain' );

function tiny_assets() {
    wp_enqueue_style( 'tinyslider-css', "//cdnjs.cloudflare.com/ajax/libs/tiny-slider/2.9.3/tiny-slider.css", null );
    wp_enqueue_script( 'tinyslider-js', "//cdnjs.cloudflare.com/ajax/libs/tiny-slider/2.9.2/min/tiny-slider.js", null, '1.0', true );

    wp_enqueue_script( 'tinyslider-main-js', plugin_dir_url( __FILE__ ) . "/assets/js/main.js", ['jquery'], '1.0', true );
}
add_action( 'wp_enqueue_scripts', 'tiny_assets' );

function tinys_init() {
    add_image_size( 'tiny-slider', 800, 600, true );
}
add_action( 'init', 'tinys_init' );

function tinys_shortcode_tslider( $arguments, $content ) {
    $defaults = [
        'width'  => '800',
        'height' => '600',
        'id'     => '',
    ];
    $attributes = shortcode_atts( $defaults, $arguments );
    $content    = do_shortcode( $content );

    $shortcode_output = <<<EOD
         <div id="{$attributes['id']}" style="width:{$attributes['width']} height:{$attributes['height']}">
            <div class="slider">
                {$content}
            </div>
        </div>
    EOD;
    return $shortcode_output;
}
add_shortcode( 'tslider', 'tinys_shortcode_tslider' );

function tinys_shortcode_tslide( $arguments ) {
    $defaults = [
        'caption' => '',
        'id'      => '',
        'size'    => 'large',
    ];
    $attributes = shortcode_atts( $defaults, $arguments );
    $image_src  = wp_get_attachment_image_src( $attributes['id'], $attributes['size'] );
}
add_shortcode( 'tslide', 'tinys_shortcode_tslide' );