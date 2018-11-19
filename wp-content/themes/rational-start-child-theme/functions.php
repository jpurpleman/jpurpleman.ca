<?php

add_action( 'wp_enqueue_scripts', 'rational_start_parent_theme_enqueue_styles' );

function rational_start_parent_theme_enqueue_styles() {
    wp_enqueue_style( 'rational-start-style', get_template_directory_uri() . '/style.css' );
    wp_enqueue_style( 'rational-start-child-theme-style',
        get_stylesheet_directory_uri() . '/style.css',
        array( 'rational-start-style' )
    );

}


    function fb_change_mce_buttons( $initArray ) {
    $initArray['width'] = '720px';
    return $initArray;
    }
    add_filter('tiny_mce_before_init', 'fb_change_mce_buttons');
