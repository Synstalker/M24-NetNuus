<?php
/**
 * Moon Boy Theme Customizer via Kirki
 *
 * @package moon-boy
 */

/**
 * @todo all require_once calls should be autoloaded, and if it's not available, only then manually call them
 */
require_once( __DIR__.'/Kirki_Field_GravityForms_Select.php' );

$fields = array(

);

$theme_mod_defaults = array(
	'fixed_background_image' => 'https://github.com/craigiswayne/moon-boy/wiki/assets/images/fixed-background-netnuus.png'
);

/**
 * Ensure that theme mods serve back the default value if none was ever set
 * ...independent of whether kirki is active or not
 */
foreach ( $theme_mod_defaults as $setting_name => $default_value ) {
	add_filter( "theme_mod_{$setting_name}", function ( $value ) use ( $theme_mod_defaults, $setting_name ) {
		return false === $value ? ( $theme_mod_defaults[ $setting_name ] ?? $value ) : $value;
	}, MoonBoy\DEFAULT_FILTER_PRIORITY );
}

$filter_defaults = array(
	'get_custom_logo' => sprintf( '<a href="%1$s" class="custom-logo-link" rel="home" itemprop="url"><img alt="%3$s" class="custom-logo" src="%2$s" itemprop="logo" /></a>',
		esc_url( home_url( '/' ) ),
		'https://github.com/craigiswayne/moon-boy/wiki/assets/images/logo-netnuus.png',
		get_bloginfo( 'name', 'display' )
	),
);


/**
 * Set a default custom logo if none is set
 * ... allows for setting this via the customizer as well :)
 */
add_filter( 'get_custom_logo', function ( $html, $blog_id ) use ( $filter_defaults ) {
	$result = $html === '' || ( is_customize_preview() && ! has_custom_logo() ) ? ( $filter_defaults[ current_filter() ] ?? $html ) : $html;
	
	return $result;
}, MoonBoy\DEFAULT_FILTER_PRIORITY, 2 );


/**
 * Guard clause in the event the kirki plugin is inactive or not installed
 */
if ( ! class_exists( 'Kirki' ) ) {
	return;
}

$kirki_json_config_file_path=ABSPATH.'/kirki.json';
$kirki_json_config_file = file_exists( $kirki_json_config_file_path ) ? file_get_contents( $kirki_json_config_file_path ) : null;
$kirki_json_config=json_decode( $kirki_json_config_file  );

if( key_exists('config', $kirki_json_config ) ){
	/**
	 * @see http://aristath.github.io/kirki/docs/config
	 */
	\Kirki::add_config( $kirki_json_config->config->id ?? get_stylesheet(), (array) $kirki_json_config->config );
}

if( key_exists( 'panels', $kirki_json_config ) && is_array( $kirki_json_config->panels ) ){
	foreach( $kirki_json_config->panels as $panel ){
		
		if( !$panel->id ){
			continue;
		}
		
		/**
		 * @see http://aristath.github.io/kirki/docs/adding-panels-and-sections
		 */
		\Kirki::add_panel( $panel->id, array(
			'priority'    => $panel->priority ?? 10,
			'title'       => __( $panel->title ) ?? __( $panel->id ),
			'description' => __( $panel->description ) ?? __( 'No description found...' ),
		) );
		
		if( key_exists( 'sections', $panel ) && is_array( $panel->sections )  ){
			foreach( $panel->sections as $section ){
				
				if( !$section->id ){
					continue;
				}
				
				/**
				 * @see http://aristath.github.io/kirki/docs/adding-panels-and-sections
				 */
				\Kirki::add_section( $section->id, array(
					'title'       => __( $section->title ) ?? $section->id,
					'description' => $section->description ?? 'No description provided...',
					'panel'       => $panel->id,
					'priority'    => $section->priority ?? 10,
				) );
				
				if( key_exists( 'fields', $section ) && is_array( $section->fields ) ){
					foreach( $section->fields as $field ){
						
						if( !$field->settings ){
							continue;
						}
						
						$field->section = $section->id;
						if( key_exists( 'choices', $field ) ){
							$field->choices = (array) $field->choices;
						}
						\Kirki::add_field( $kirki_json_config->config->id, (array) $field );
						
					}
				}
			}
		}
	}
}