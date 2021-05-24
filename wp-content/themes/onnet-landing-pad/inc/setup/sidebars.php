<?php

/**
 * Setting up sidebars
 */

function the_sidebars_init()
{
    if (function_exists('register_sidebar')) {
        register_sidebar(array(
            'name' => 'General Hompage',
            'id' => 'general_homepage',
            'before_widget' => '<div id="" class="widget">',
            'after_widget' => '</div>',
            'before_title' => '<h2>',
            'after_title' => '</h2>',
        ));
    }
}

add_action( 'widgets_init', 'the_sidebars_init' );