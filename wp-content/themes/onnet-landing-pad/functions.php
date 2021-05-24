<?php

// Include all files in folders (/inc/*)
foreach (glob(get_template_directory()."/inc/*/*.php") as $filename) {
	include $filename;
}

/**
 * Only enqueue the travelstart script for the necessary page template
 */
if( !function_exists( 'tf_add_travelstart_js' ) ){

    add_action( 'wp_enqueue_scripts', 'tf_add_travelstart_js' );

    /**
     * Enqueue Travelstart Bookings Page Script
     */
    function tf_add_travelstart_js(){
        if ( "template-travestart-bookings-page.php" === basename( get_page_template() ) ){
            wp_enqueue_script( 'travelstart-affiliate-tracking', get_stylesheet_directory_uri() . '/js/travelstart-affiliate-code-11.js', ['jquery'], '1.0.0', true );
        }
    }
}