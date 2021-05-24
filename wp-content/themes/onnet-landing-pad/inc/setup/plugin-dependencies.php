<?php

// Setup plugin dependencies
add_filter('theme_plugins_dependencies', 'theme_plugin_dependencies');
function theme_plugin_dependencies($plugins)
{
	$plugins[] = array(
		'name'               => 'Gravity Forms Placeholder Add-On',
		'slug'             => 'gravity-forms-placeholder-support-add-on',
		'required'           => true,
		'force_activation'   => true,
		'source'             => 'https://downloads.wordpress.org/plugin/gravity-forms-placeholder-support-add-on.zip'
		);

	$plugins[] = array(
		'name'             => 'Regenerate Thumbnails',
		'slug'             => 'regenerate-thumbnails',
		'required'         => false,
		'force_activation' => false,
		);

	$plugins[] = array(
		'name'             => 'Gravity Forms',
		'slug'             => 'gravityforms',
		'required'         => true,
		'force_activation' => true,
		'source'           => 'http://onnet.co.za.onnet.it/packages/gravityforms.zip'
		);

	return $plugins;
}