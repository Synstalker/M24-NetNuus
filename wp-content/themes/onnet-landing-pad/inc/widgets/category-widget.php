<?php

class category_widget extends WP_Widget
{
	public function __construct()
	{
		parent::__construct(
			false, $name = "Category Widget", array(
				"description" => "Display stoies from one specific category.",
				"classname" => "widget_popular_posts"
				)
			);
	}

	function widget($args, $instance)
	{
		extract($args);
		global $wpdb;
		$cat = '';
		if ( $instance["cat"] != "0" ) :
			$catid = get_category_by_slug($instance["cat"]);
		$cat = "&cat=" . $catid->term_id;
		endif;

		$query_args = array(
			'post_type' => 'post',
			'posts_per_page' => $instance['post_count'],
			'cat' => $cat,
			'orderby' => 'date',
			'order' => 'DESC'
			);

			$post_query = new WP_Query( $query_args ); 

			while ( $post_query->have_posts() ) : $post_query->the_post(); ?>

			<div class="continueDiscussion">

				<div class="continueDiscussion__img">
					<a href="<?php the_permalink(); ?>">
						<?php echo get_the_post_thumbnail(get_the_ID(), 'posts'); ?>
					</a>
				</div>

				<div class="continueDiscussion__body">
					<a href="<?php the_permalink(); ?>">
						<h2><?php echo wp_trim_words(get_the_title(), 10); ?></h2>
						<p><?php echo strip_shortcodes(wp_trim_words(get_the_content(), 95)); ?></p>
					</a>
				</div>

			</div>



		<?php endwhile; ?>
		<?php
	}


	function update($new_instance, $old_instance)
	{
		return $new_instance;
	}


	function form($instance)
	{
		$terms = get_terms('category', "orderby=name&hide_empty=0"); ?>
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
		<p><label for="<?php echo $this->get_field_id('post_count'); ?>">Post Count</label>
			<select size="1" class="widefat" id="<?php echo $this->get_field_id('post_count'); ?>"
				name="<?php echo $this->get_field_name('post_count'); ?>">
				<?php for ( $i = 1; $i < 11; $i++ ) : ?>
					<option
					<?php if (isset($instance['post_count']) && $instance['post_count'] == $i) : ?>selected="selected"<?php endif; ?>
					value="<?php echo $i; ?>"><?php echo $i; ?></option>
				<?php endfor; ?>
			</select>
		</p>
		<?php
	} // form
}// class

add_action('widgets_init', function(){
	return register_widget("category_widget");
});

?>