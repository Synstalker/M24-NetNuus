<?php
/*
 * Image Sizes
 */
function setup_theme_image_sizes()
{

	add_image_size( 'logo', 230, 9999, false );
	add_image_size( 'magazine', 250, 335, false );
	add_image_size( 'slider', 245, 164, true );
	add_image_size( 'posts', 300, 180, true );
	add_image_size( 'single', 480, 360, false );

}