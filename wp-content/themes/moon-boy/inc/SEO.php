<?php
namespace MoonBoy\SEO;
use MoonBoy;

add_action( 'wp_head', function(){
	if( '1' == get_option('blog_public') ){
		echo '<meta name="description" content="'.get_bloginfo('description').'" />';
	}
	
	/**
	 * WordPress does not add canonical urls for front-pages
	 * @see wp-includes/link-template.php:3558
	 */
	if( is_front_page() ){
		echo '<link rel="canonical" href="'.get_home_url().'"/>';
	}
	
}, MoonBoy\DEFAULT_FILTER_PRIORITY);