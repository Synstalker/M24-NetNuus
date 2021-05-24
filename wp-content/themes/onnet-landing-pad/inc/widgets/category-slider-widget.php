<?php

class slider_category_widget extends WP_Widget
{
	/** constructor */
	public function __construct()
	{
		parent::__construct(
			false, $name = "Slider Category Widget", array(
				"description" => "Display stoies from one specific category.",
				"classname" => "widget_popular_posts"
				)
			);
	}

	/** @see WP_Widget::widget */
	function widget($args, $instance)
	{
		extract($args);
		global $wpdb;
		global $post;

		$cat = '';
		if ( $instance["cat"] != "0" ) :
			$catid = get_category_by_slug($instance["cat"]);
		$cat = "&cat=" . $catid->term_id;
		endif;

		$query_args = array(
			'post_type' => 'post',
			'posts_per_page' => 10,
			'cat' => $cat,
			'orderby' => 'date',
			'order' => 'DESC'
			);

			$post_query = new WP_Query( $query_args ); ?>
			<!--Show the Post Info -->

			<?php if ( $post_query->have_posts() ) : ?>

				<div class="carousel">

					<?php while ( $post_query->have_posts() ) : $post_query->the_post(); ?>

						<?php 

						$external = get_post_meta( get_the_ID(), 'external_link_meta', true ); 
						$image = wp_get_attachment_image_src( get_post_thumbnail_id(get_the_ID()), 'slider' );

						?>

						<div class="carousel__slide">
							<div class="carousel__slide__body">
								<a <?php if (!empty($external)) { echo "target='_blank'"; } ?> href="<?php if (!empty($external)) { echo $external; } else { the_permalink(); }?>">
									<?php if (!empty($image)) { ?>
									<img src="<?php echo $image[0]; ?>" alt="">
									<?php } ?>
									<h3><?php echo get_the_title(); ?></h3>
									<p>
									<?php if( !$post->post_excerpt ) {
										echo substr(get_the_content(), 0, 150) . '...';
									} else {
										echo get_the_excerpt();
									} ?>
									</p>
								</a>
							</div>
						</div>

					<?php endwhile; ?>

				</div>

			<?php endif; ?>

			<?php
		}

		/** @see WP_Widget::update */
		function update($new_instance, $old_instance)
		{
			return $new_instance;
		}

		/** @see WP_Widget::form */
		function form($instance)
		{
			$terms = get_terms('category', "orderby=count&hide_empty=0"); ?>
			<p>
				<label for="<?php echo $this->get_field_id('cat'); ?>">Category</label>
				<select size="1" class="widefat" id="<?php echo $this->get_field_id('cat'); ?>"
					name="<?php echo $this->get_field_name('cat'); ?>">
					<?php foreach ( $terms as $term => $details ) : ?>
						<option  <?php if ( isset($instance['cat']) && $instance['cat'] == $details->slug ) {
							echo "selected=\"selected\"";
						} ?> value="<?php echo $details->slug; ?>"><?php echo $details->name; ?></option>
					<?php endforeach; ?>
				</select>
			</p>
			<?php
	} // form
}// class

//This sample widget can then be registered in the widgets_init hook:

// register FooWidget widget
add_action('widgets_init', function(){
    return register_widget("slider_category_widget");
});
?>