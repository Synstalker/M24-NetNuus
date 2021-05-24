<?php
namespace MoonBoy;

use Carbon_Fields\Carbon_Fields;
const DEFAULT_FILTER_PRIORITY = 17;

if ( !defined( 'MOON_BOY_VER' ) ) {
	define( 'MOON_BOY_VER', wp_get_theme('moon-boy')->get('Version') ?? 'unknown' );
}

if( defined( 'ABSPATH') && file_exists( ABSPATH.'/vendor/autoload.php' ) ){
	require_once( ABSPATH.'/vendor/autoload.php' );
}

function is_debugging(){
	return defined( 'WP_DEBUG' ) && WP_DEBUG;
}

function is_script_debug(){
	return defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG;
}

if( class_exists( '\Carbon_Fields\Carbon_Fields' ) ){
	add_action( 'after_setup_theme', function(){
		Carbon_Fields::boot();
	});
}
