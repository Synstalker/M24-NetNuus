<?php
namespace MoonBoy\Enqueues;

use const MoonBoy\DEFAULT_FILTER_PRIORITY;
use function MoonBoy\is_script_debug;

/**
 * @see wp-content/plugins/open-graph-metabox/open-graph-metabox.php:153
 */
add_action( 'admin_print_styles', function(){
	wp_deregister_style('open-graph-metabox-admin-styles');
}, 11);


add_action( 'wp_enqueue_scripts', function () {
	$prefix = is_script_debug() ? '' : '.min';
	$stylesheets = [
		"//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.0/css/bootstrap${prefix}.css",
		'assets/css/content/landing-page.css',
		'//cdnjs.cloudflare.com/ajax/libs/font-awesome/4.2.0/css/font-awesome.min.css',
		'//fonts.googleapis.com/css?family=Lato:400,700,900,100italic,300italic,400italic,700italic,900italic,300,100|Source+Sans+Pro',
		'//cdnjs.cloudflare.com/ajax/libs/jquery.perfect-scrollbar/1.3.0/css/perfect-scrollbar.min.css',
		'assets/css/content/style.css',
		'style.css',
//		'assets/css/content/frontend/frontend.css',
	];
	
	foreach ( $stylesheets as $key => $url ) {
		$url = false === strpos( $url, '//' ) ? get_theme_file_uri( $url ) : $url;
		wp_enqueue_style( "stylesheet-$key", $url );
	}
	
//	wp_enqueue_style( 'bootstrap', get_stylesheet_directory_uri().'/node_modules/bootstrap/dist/css/bootstrap.css' );
//	wp_enqueue_style( 'bootstrap', get_stylesheet_directory_uri().'/node_modules/font-awesome/css/font-awesome.css' );
//	wp_enqueue_style( 'perfect-scrollbar', get_stylesheet_directory_uri().'/node_modules/perfect-scrollbar/css/perfect-scrollbar.css' );
	
	$scripts = [
//		'//cdnjs.cloudflare.com/ajax/libs/jquery/1.10.2/jquery.min.js',
		'assets/js/jquery-ui-1.10.4.custom.min.js',
		'//cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.15.0/jquery.validate.min.js',
		'//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.0/js/bootstrap.min.js',
//		'assets/js/project.js'
	];
	
	foreach ( $scripts as $key => $url ) {
		$url = false === strpos( $url, '//' ) ? get_theme_file_uri( $url ) : $url;
		wp_enqueue_script( "script-$key", $url, ['jquery'], MOON_BOY_VER, true );
	}
	
//	wp_enqueue_script( 'jquery-validate', get_stylesheet_directory_uri().'/node_modules/jquery-validation/dist/jquery.validate.js' );
//	wp_enqueue_script( 'bootstrap', get_stylesheet_directory_uri().'/node_modules/bootstrap/dist/js/bootstrap.js' );
//	wp_enqueue_script( 'perfect-scrollbar', get_stylesheet_directory_uri().'/node_modules/perfect-scrollbar/dist/perfect-scrollbar.js' );
	
	wp_register_script( 'perfect-scrollbar','//cdnjs.cloudflare.com/ajax/libs/jquery.perfect-scrollbar/1.3.0/perfect-scrollbar.js', ['jquery'], MOON_BOY_VER );
	wp_register_script( 'project', get_theme_file_uri( 'assets/js/project.js' ), ['jquery','perfect-scrollbar'], MOON_BOY_VER, true );
	/**
	 * Hook into the data that will be localized
	 * add_filter( "MoonBoy\Enqueues\localized_info", function( $data ){} );
	 */
	$standardLocalizedInfo = !is_user_logged_in() ? [] : array(
		'Core' => array(
			'wp_is_mobile' => wp_is_mobile()
		),
		'Server' => (array) $_SERVER
	);
	wp_localize_script( 'project', 'MoonBoy', apply_filters( __NAMESPACE__.'\localized_info', $standardLocalizedInfo) );
	wp_enqueue_script( 'project' );
	
}, DEFAULT_FILTER_PRIORITY );