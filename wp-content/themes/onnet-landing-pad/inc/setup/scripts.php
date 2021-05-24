<?php

/**
 * Enqueue scripts and styles.
 */

add_action('wp_enqueue_scripts', 'theme_scripts');
function theme_scripts() {

	wp_enqueue_script('jquery');

	if(!is_admin())
	{
		wp_enqueue_style( 'theme-font', theme_font_url(), array() );
	}

	// Load modernizr
	if(!is_admin())
	{
		wp_enqueue_script( 'modernizr', get_template_directory_uri() . '/js/modernizr.min.js', array() );
	}

	// Load our main stylesheet
	wp_enqueue_style('theme-style', get_stylesheet_uri(), array());

	// Load our main stylesheet
	wp_enqueue_style('frontend-css', get_template_directory_uri() . '/css/frontend.min.css', array());

	// Load our custom stylesheet
	wp_enqueue_style('custom-css-php', home_url() . '/?stylesheet=custom');

	// Load our custom stylesheet that should be merged into frontend-css later
	wp_enqueue_style( 'custom-css', get_template_directory_uri() . '/css/custom.css', array() );

	// Load our main script
	if(!is_admin())
	{
		wp_register_script( 'frontend-js', get_template_directory_uri() . '/js/frontend.min.js', array('jquery'), true );
		wp_enqueue_script( 'frontend-js' );
	}

}

add_action('admin_enqueue_scripts', 'theme_admin_scripts');
function theme_admin_scripts() {

	wp_enqueue_script('jquery');
	wp_enqueue_script('media-upload');
	wp_enqueue_script('thickbox');
	wp_enqueue_style('thickbox');

	// Load our widget scripts
	if(is_admin()) {

		wp_register_script( 'magazine-widget', get_template_directory_uri() . '/js/widget-magazine.js', true );
		wp_enqueue_script( 'magazine-widget' );

		wp_enqueue_style('backend-css', get_template_directory_uri() . '/css/backend.css', array());

	}

}