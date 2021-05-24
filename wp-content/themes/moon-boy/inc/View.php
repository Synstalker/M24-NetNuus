<?php
namespace MoonBoy;

use Timber\Timber;

class View{
	
	/**
	 * @param $twig_file
	 * @param $context
	 *
	 * @return false|string     False on failure. The resulting template
	 */
	public static function compile( $twig_file, $context ){
		
		if( !class_exists('\Timber') ){
			return false;
		}
		
		return Timber::compile( $twig_file, $context );
	}
	
	/**
	 * @param $twig_file
	 * @param $context
	 *
	 * @return false|string     False on failure. The resulting template
	 */
	public static function render( $twig_file, $context ){
		
		if( !class_exists('\Timber') ){
			return false;
		}
		
		return Timber::render( $twig_file, $context );
	}
}