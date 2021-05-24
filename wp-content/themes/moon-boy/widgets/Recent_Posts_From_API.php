<?php
use Carbon_Fields\Widget;
use Carbon_Fields\Field;
use MoonBoy\YouTube;
use MoonBoy\View;

/**
 * Class Recent_Posts_From_API
 * @todo make a bridge between carbon fields and any widget within this project
 */
class Recent_Posts_From_API extends Widget {

	function __construct() {
		$this->setup( 'Recent_Posts_From_API', 'Recent Posts From API', 'Displays a posts received from an endpoint.', array(
			Field::make( 'number', 'count', 'Number of Posts to show' )->set_required(true)->set_default_value( 10 ),
			Field::make( 'number', 'update_interval', 'Update Interval (seconds)' )->set_required(true)->set_default_value(30 * 60),
			Field::make( 'text', 'api_url', 'API URL' )->set_required(true)->set_default_value( 'http://wsmobile.24.com/v2/Articles/Headlines/Netwerk24/NetNuus/?pageSize=%s' )->set_help_text('add in %s to use the number of posts value in the url'),
			Field::make( 'image', 'android_phone_image', 'Android Phone Image' )->set_width(50)->set_default_value(get_theme_file_uri('assets/images/defaults/phone-android.png')),
			Field::make( 'image', 'ios_phone_image', 'iOS Phone Image' )->set_width(50)->set_default_value(get_theme_file_uri('assets/images/defaults/phone-ios.png')),
			Field::make( 'image', 'fallback_app_stream_image', 'Fallback App Stream Image' )->set_default_value(get_theme_file_uri('assets/images/defaults/app-stream.png')),
			Field::make( 'checkbox', 'show_scroll_indicator', 'Show Scroll Indicator' )->set_option_value('yes')->set_default_value('yes'),
		) );
		$this->print_wrappers = false;
	}
	
	/**
	 * @param $setting_name
	 *
	 * @return bool|mixed
	 */
	private function get_setting($setting_name){
		$setting_value = false;
		$settings = $this->get_settings();
		$settings = array_filter( $settings );
		sort($settings);
		if( !isset( $settings[0]) ){
			return $setting_value;
		}
		foreach( $settings[0] as $key => $value ){
			if( $key !== '_'.$setting_name ){
				continue;
			}
			$setting_value = $value;
			//try get the default
			if( !$setting_value ){
				foreach( $this->custom_fields as $k => $field ){
					if( $field->get_name() !== $setting_name ){
						continue;
					}
					$setting_value = $field->get_default_value();
					break;
				}
			}
			break;
		}
		return $setting_value;
	}
	
	function front_end( $args, $instance ) {
		
		$ios_image = $this->get_setting('ios_phone_image' );
		$android_phone_image = $this->get_setting('android_phone_image' );
		$fallback_app_stream_image = $this->get_setting('fallback_app_stream_image' );
		
		//formats for the images
		$instance['ios_phone_image'] = intval( $ios_image ) === 0 ? $ios_image : wp_get_attachment_image_url($ios_image);
		$instance['android_phone_image'] = intval( $android_phone_image ) === 0 ? $android_phone_image : wp_get_attachment_image_url($android_phone_image);
		$instance['fallback_app_stream_image'] = !wp_attachment_is_image( $fallback_app_stream_image ) ? $fallback_app_stream_image : wp_get_attachment_image_url($fallback_app_stream_image);
		
		View::render('widgets/Recent_Posts_From_API.twig', wp_parse_args([
			'posts' => $this->get_posts( $instance )
		], $instance ));
	}
	
	/**
	 * @todo, maybe don't use the $instance variable here
	 *
	 * @param array $instance
	 *
	 * @return array|bool|mixed|object
	 */
	private function get_posts( $instance = [] ){
		$posts = [];
		$data = NULL;

		$requestInTransient = is_user_logged_in() || MoonBoy\is_debugging() ? false : get_transient( $this->id );

		if( $requestInTransient ){
			return $requestInTransient;
		}

		$api_url = sprintf( $instance['api_url'], $instance['count'] );
		$api_request = wp_remote_get( $api_url );

		if ( is_wp_error( $api_request ) ) {
			return $posts;
		}

		$body = wp_remote_retrieve_body( $api_request );
		$json = json_decode( $body );
		if( !$json ){
			return $posts;
		}

		/**
		 * Ensure there is an image for each item
		 * For video articles, grab the YouTube image
		 */
		foreach( $json as $post ){

			$post->excerpt = wp_trim_words( $post->title, 20 );
			if( $post->image->url ){
				continue;
			}

			$post->image->url = YouTube\get_thumbnail_url( $post->videoUrl );
		}
		
		set_transient( $this->id, $json, (int) $this->get_setting('update_interval') );

		$posts = $json;

		return $posts;
	}
	
}
add_action('widgets_init', 'load_widgets');
function load_widgets() {
	register_widget( 'Recent_Posts_From_API' );
}