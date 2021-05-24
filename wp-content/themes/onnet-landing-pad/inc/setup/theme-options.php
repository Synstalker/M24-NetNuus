<?php

/*
 * Admin Theme Options
 */
require get_template_directory() . '/admin/admin-framework.php';

add_filter('onnet_admin_options', 'theme_options', 10, 1);
function theme_options($current_options) {


	$options = array();

    // General

	$options[] = array(
		'name' => __('General', 'admin-framework'),
		'type' => 'heading'
		);

	$options[] = array(
		'name' => __('Check for in container full width layout', 'options_framework_theme'),
		'desc' => __('Full width in container layout removes padding on sides', 'options_framework_theme'),
		'id' => 'full_width_container',
		'std' => 0,
		'type' => 'checkbox'
		);

	$options[] = array(
		'name'	=> __( 'Logo image', 'admin' ),
		'desc'	=> __( 'Upload your full size logo image', 'admin' ),
		'id'	=> 'default_logo_image',
		'type'	=> 'upload'
		);

	$options[] = array(
		'name' 	=> __( 'Logo size', 'admin' ),
		'desc'	=> __( 'Eg: 240px', 'admin' ),
		'id' 	=> 'logo_size',
		'type'	=> 'text'
		);

	$options[] = array(
		'name'	=> __( 'Favicon', 'admin' ),
		'desc'	=> __( 'Upload your favicon image', 'admin' ),
		'id'	=> 'theme_favicon',
		'type'	=> 'upload'
		);

	$options[] = array(
		'name' => __('Show closing container', 'options_framework_theme'),
		'desc' => __('Closing container consists of text, image and option to add an effect.', 'options_framework_theme'),
		'id' => 'show_closing',
		'std' => 0,
		'type' => 'checkbox'
		);

	$options[] = array(
		'name'	=> __( 'Background', 'admin' ),
		'desc'	=> __( 'Upload your background image. ', 'admin' ),
		'id'	=> 'background_image',
		'type'	=> 'upload'
		);	

	$options[] = array(
		'name' 	=> __( 'Message', 'admin' ),
		'desc'	=> __( 'Add your custom closing message here.', 'admin' ),
		'id' 	=> 'closing_message',
		'type'	=> 'text'
		);

	$options[] = array(
		'name' 	=> __( 'Theme Color - Primary', 'admin' ),
		'desc'	=> __( 'Eg: #010101', 'admin' ),
		'id' 	=> 'theme_color',
		'std'	=> '#333333',
		'type'	=> 'color'
		);

	$options[] = array(
		'name' 	=> __( 'Theme Color - Secondary', 'admin' ),
		'desc'	=> __( 'Eg: #010101', 'admin' ),
		'id' 	=> 'theme_color_2',
		'std'	=> '#999999',
		'type'	=> 'color'
		);

	$options[] = array(
		'name' 	=> __( 'Theme Color - Tertiary', 'admin' ),
		'desc'	=> __( 'Eg: #010101', 'admin' ),
		'id' 	=> 'theme_color_3',
		'std'	=> '#999999',
		'type'	=> 'color'
		);

	$options[] = array(
		'name' 	=> __( 'Font Color - Primary', 'admin' ),
		'desc'	=> __( 'Eg: #010101', 'admin' ),
		'id' 	=> 'font_color',
		'std'	=> '#333333',
		'type'	=> 'color'
		);

	$options[] = array(
		'name' 	=> __( 'Font Color - Secondary', 'admin' ),
		'desc'	=> __( 'Eg: #010101', 'admin' ),
		'id' 	=> 'font_color_secondary',
		'std'	=> '#333333',
		'type'	=> 'color'
		);

	$options[] = array(
		'name' 	=> __( 'Font Color - hover state', 'admin' ),
		'desc'	=> __( 'Eg: #010101', 'admin' ),
		'id' 	=> 'font_color_hover',
		'std'	=> '#333333',
		'type'	=> 'color'
		);

	$options[] = array(
		'name' => __('Widget / General options', 'admin-framework'),
		'type' => 'heading'
		);

	$options[] = array(
		'name' 	=> __( 'Custom magazine gradient styling', 'admin' ),
		'id' 	=> 'gradient_styling',
		'type'	=> 'textarea'
		);

	$options[] = array(
		'name' 	=> __( 'Custom styling', 'admin' ),
		'id' 	=> 'custom_styling',
		'type'	=> 'textarea'
		);

	$options[] = array(
		'name' => __('Social networks', 'admin-framework'),
		'type' => 'heading'
		);

	$options[] = array(
		'name' 	=> __( 'Pinterest', 'admin' ),
		'desc'	=> __( 'Eg: https://www.pinterest.com/user', 'admin' ),
		'id' 	=> 'social_pinterest',
		'type'	=> 'text'
		);

	$options[] = array(
		'name' 	=> __( 'Facebook', 'admin' ),
		'desc'	=> __( 'Eg: https://www.facebook.com/user', 'admin' ),
		'id' 	=> 'social_facebook',
		'type'	=> 'text'
		);

	$options[] = array(
		'name' 	=> __( 'Twitter', 'admin' ),
		'desc'	=> __( 'Eg: https://twitter.com/user', 'admin' ),
		'id' 	=> 'social_twitter',
		'type'	=> 'text'
		);

	$options[] = array(
		'name' 	=> __( 'Instagram', 'admin' ),
		'desc'	=> __( 'Eg: https://instagram.com/user', 'admin' ),
		'id' 	=> 'social_instagram',
		'type'	=> 'text'
		);

	$options[] = array(
		'name' 	=> __( 'Youtube', 'admin' ),
		'desc'	=> __( 'Eg: https://youtube.com/user', 'admin' ),
		'id' 	=> 'social_youtube',
		'type'	=> 'text'
		);

	$options[] = array(
		'name' => __('404 Page', 'admin-framework'),
		'type' => 'heading'
		);

	$options[] = array(
		'name'	=> __( '404 Custom heading', 'admin' ),
		'desc'	=> __( 'Add your custom 404 page heading here', 'admin' ),
		'id'	=> 'custom_404_heading',
		'type'	=> 'text'
		);

	return array_merge($options, $current_options);
}