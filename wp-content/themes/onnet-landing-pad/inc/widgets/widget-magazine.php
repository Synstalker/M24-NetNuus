<?php

// Creating the widget 
class magazine_widget extends WP_Widget {

	function __construct() {
		parent::__construct(
			// Base ID of your widget
			'magazine_widget', 

			// Widget name will appear in UI
			__('Magazine Widget', 'magazine_widget_domain'),

			// Widget description
			array( 'description' => 'Magazine widget displaying a title, description, image and two buttons.', 'wpb_widget_domain', ) 
			);
	}

// Creating widget front-end
// This is where the action happens
	public function widget( $args, $instance ) {

		$title = apply_filters( 'widget_title', $instance['title'] );
		$description = wp_trim_words($instance['description'], 85);
		$digital_title = $instance['digital_title'];
		$digital_url = $instance['digital_url'];
		$print_title = $instance['print_title'];
		$print_url = $instance['print_url'];
		$magazine_cover = $instance['image']; ?>

		<?php if (!empty($title) && !empty($description) && !empty($magazine_cover)) { ?>

		<div class="getLatestMag">

			<div class="getLatestMag__magimg">
				<img src="<?php echo $magazine_cover; ?>" alt="<?php echo $title; ?>"/>
			</div>

			<div class="getLatestMag__body">
				<h2><?php echo $title; ?></h2>
				<p><?php echo $description; ?></p>
				<?php if (!empty($digital_title) && !empty($digital_url)) { ?>
				<a href="<?php echo $digital_url; ?>" target="_blank"><?php echo $digital_title; ?></a>
				<?php } ?>
				<?php if (!empty($print_title) && !empty($print_url)) { ?>
				<a href="<?php echo $print_url; ?>" target="_blank"><?php echo $print_title; ?></a>
				<?php } ?>
			</div>

		</div>

		<?php  }
	}

// Widget Backend 
	public function form( $instance )
	{

		$title = '';
		if( !empty( $instance['title'] ) ) {
			$title = $instance['title'];
		}

		$description = '';
		if( !empty( $instance['description'] ) ) {
			$description = $instance['description'];
		}

		$digital_title = '';
		if( !empty( $instance['digital_title'] ) ) {
			$digital_title = $instance['digital_title'];
		}

		$digital_url = '';
		if( !empty( $instance['digital_url'] ) ) {
			$digital_url = $instance['digital_url'];
		}

		$print_title = '';
		if( !empty( $instance['print_title'] ) ) {
			$print_title = $instance['print_title'];
		}

		$print_url = '';
		if( !empty( $instance['print_url'] ) ) {
			$print_url = $instance['print_url'];
		}

		$image = '';
		if(isset($instance['image']))
		{
			$image = $instance['image'];
		}
		?>
		<p>
			<label for="<?php echo $this->get_field_name( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_name( 'description' ); ?>"><?php _e( 'Description:' ); ?></label>
			<textarea class="widefat" id="<?php echo $this->get_field_id( 'description' ); ?>" name="<?php echo $this->get_field_name( 'description' ); ?>" type="text" ><?php echo esc_attr( $description ); ?></textarea>
		</p>

		<p>
			<label for="<?php echo $this->get_field_name( 'digital_title' ); ?>"><?php _e( 'Digital Title:' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'digital_title' ); ?>" name="<?php echo $this->get_field_name( 'digital_title' ); ?>" type="text" value="<?php echo esc_attr( $digital_title ); ?>" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_name( 'digital_url' ); ?>"><?php _e( 'Digital URL:' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'digital_url' ); ?>" name="<?php echo $this->get_field_name( 'digital_url' ); ?>" type="text" value="<?php echo esc_attr( $digital_url ); ?>" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_name( 'print_title' ); ?>"><?php _e( 'Print Title:' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'print_title' ); ?>" name="<?php echo $this->get_field_name( 'print_title' ); ?>" type="text" value="<?php echo esc_attr( $print_title ); ?>" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_name( 'print_url' ); ?>"><?php _e( 'Print URL:' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'print_url' ); ?>" name="<?php echo $this->get_field_name( 'print_url' ); ?>" type="text" value="<?php echo esc_attr( $print_url ); ?>" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_name( 'image' ); ?>"><?php _e( 'Magazine cover:' ); ?></label>
			<input name="<?php echo $this->get_field_name( 'image' ); ?>" id="<?php echo $this->get_field_id( 'image' ); ?>" class="widefat magazine_image" type="text" size="36"  value="<?php echo esc_url( $image ); ?>" />
			<input class="upload_image_button" type="button" value="Upload Image" />
			<button class="image-upload-clear">Clear</button>
		</p>

		<?php
	}

// Updating widget replacing old instances with new
	public function update( $new_instance, $old_instance ) {

		$instance = array();

		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		$instance['description'] = ( ! empty( $new_instance['description'] ) ) ? strip_tags( $new_instance['description'] ) : '';
		$instance['digital_title'] = ( ! empty( $new_instance['digital_title'] ) ) ? strip_tags( $new_instance['digital_title'] ) : '';
		$instance['digital_url'] = ( ! empty( $new_instance['digital_url'] ) ) ? strip_tags( $new_instance['digital_url'] ) : '';
		$instance['print_title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['print_title'] ) : '';
		$instance['print_url'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['print_url'] ) : '';
		$instance['image'] = ( ! empty( $new_instance['image'] ) ) ? strip_tags( $new_instance['image'] ) : '';

		return $instance;
	}

} // Class wpb_widget ends here

// Register and load the widget
function magazine_load_widget() {
	register_widget( 'magazine_widget' );
}

add_action( 'widgets_init', 'magazine_load_widget' );