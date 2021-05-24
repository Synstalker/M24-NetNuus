<?php

add_action('after_setup_theme', 'setup_theme');
function setup_theme() {

	// Support for featured thumbnails
	add_theme_support('post-thumbnails');

	// Switch default core markup to output valid HTML5.
	add_theme_support('html5', array(
	  'search-form', 'comment-form', 'comment-list', 'gallery', 'caption'
	));

	// Image sizes
	setup_theme_image_sizes();

	// Menu locations
	setup_theme_menu_locations();
}