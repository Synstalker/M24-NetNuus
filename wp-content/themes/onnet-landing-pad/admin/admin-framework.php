<?php
/** General file includes */
require_once dirname(__FILE__) . '/lib/functions.php';

/**
 * Automatic Updates & Emails
 *
 * We're turning everything off, we don't want anything to update
 * without our knowledge.
 */
add_filter('allow_dev_auto_core_updates', '__return_false');
add_filter('allow_minor_auto_core_updates', '__return_false');
add_filter('allow_major_auto_core_updates', '__return_false');
add_filter('auto_core_update_send_email', '__return_false');

add_filter('auto_update_plugin', '__return_false');
add_filter('auto_update_theme', '__return_false');
add_filter('auto_update_translation', '__return_false');

/**
 * Load admin-framework text domain
 */
add_action('after_setup_theme', 'load_admin_framework_languages');
function load_admin_framework_languages()
{
	load_theme_textdomain('admin-framework', dirname(__FILE__) . '/languages');
}

/**
 * Remove default wordpress widgets that are not required for
 * theme installations
 *
 * @return void
 */
//add_action('widgets_init', 'deregister_default_widgets', 11);
function deregister_default_widgets()
{
	unregister_widget('WP_Widget_Archives');
	unregister_widget('WP_Widget_Calendar');
	unregister_widget('WP_Widget_Categories');
	unregister_widget('WP_Nav_Menu_Widget');
	unregister_widget('WP_Widget_Meta');
	unregister_widget('WP_Widget_Pages');
	unregister_widget('WP_Widget_Recent_Comments');
	unregister_widget('WP_Widget_Recent_Posts');
	unregister_widget('WP_Widget_RSS');
	unregister_widget('WP_Widget_Search');
	unregister_widget('WP_Widget_Tag_Cloud');
	unregister_widget('WP_Widget_Text');
	unregister_widget('WP_Widget_Links');
}

/**
 * Loads the Options Panel
 *
 * If you're loading from a child theme use stylesheet_directory
 * instead of template_directory
 */
define('OPTIONS_FRAMEWORK_DIRECTORY', get_template_directory_uri() . '/admin/');
add_filter('options_framework_location', function ($arg)
{
	$arg[] = 'admin/lib/options.php';
	return $arg;
});
require_once dirname(__FILE__) . '/options-framework.php';

/**
 * Enqueue scripts and styles for the admin.
 *
 * @return void
 */
add_action('admin_enqueue_scripts', 'widget_admin_scripts_styles');
function widget_admin_scripts_styles()
{
	wp_enqueue_style('widget-colors', get_template_directory_uri() . '/admin/css/widget-colors.css', array(), date('Y-m-d', time()));
}

/**
 * Debug
 */
if ( !function_exists('debug') ):
	function debug($debug, $die = false)
	{
		if ( WP_DEBUG === true )
		{
			echo "<pre>";
			print_r($debug);
			echo "</pre>";
		}

		if ( $die == true && WP_DEBUG === true )
		{
			exit;
		}
	}
endif;

/**
 * Add Script Conditions
 */
if ( !function_exists('wp_script_add_data') ):
	function wp_script_add_data($handle, $key, $value)
	{
		global $wp_scripts;

		return $wp_scripts->add_data($handle, $key, $value);
	}
endif;

// Include Add Ons
foreach (glob(dirname(__FILE__)."/add-ons/*.php") as $filename)
{
	include_once $filename;
}
foreach (glob(dirname(__FILE__)."/add-ons/*/*.php") as $filename)
{
	include_once $filename;
}