<?php

class team_section_widget extends WP_Widget
{
	public function __construct()
	{
		$widget_ops = array('classname' => 'title', 'description' => __("Team widget pulling from team post type"));
		parent::__construct('title', __('Team Section Widget'), $widget_ops);
	}

	function widget($args, $instance)
	{
		extract($args);

		$text = apply_filters('widget_text', $instance['text'], $instance);
		
		$team_args = array(
			'post_type' => 'team',
			'posts_per_page' => -1,
			'orderby' => 'date',
			'order' => 'DESC'
			);

			$post_query = new WP_Query( $team_args ); ?>

			<?php if ( $post_query->have_posts() ) : ?>

				<div class="contactUs">

					<div class="contactUs__head">
						<h2><?php if (!empty($text)) { echo $text; } ?></h2>
					</div>

					<div class="contactUs__body">

						<?php while ( $post_query->have_posts() ) : $post_query->the_post(); ?>

							<?php

							$address = get_post_meta( get_the_ID(), 'address_meta', true );
							$address = (!empty($address)) ? $address : '';
							$telephone = get_post_meta( get_the_ID(), 'telephone_meta', true );
							$telephone = (!empty($telephone)) ? $telephone : '';

							?>
							
							<div>
								<h3><?php the_title(); ?></h3>
								Email: <a href="mailto:<?php echo $address; ?>"><?php echo $address; ?></a><br />
								Tel: <?php echo $telephone; ?>
							</div>

						<?php endwhile; ?>

					</div>
				</div>

			<?php endif;

		}

		function update($new_instance, $old_instance)
		{
			$instance = $old_instance;
			if ( current_user_can('unfiltered_html') ) {
				$instance['text'] = $new_instance['text'];
			}
			else {
				$instance['text'] = stripslashes(wp_filter_post_kses(addslashes($new_instance['text'])));
			}
			return $instance;
		}

		function form($instance)
		{
			$instance = wp_parse_args((array)$instance, array('text' => ''));
			$text = format_to_edit($instance['text']);
			?>

			<p>Add you team section title here.
				<input style="margin: 10px 0;" type="text" value="<?php echo $text; ?>" class="widefat" id="<?php echo $this->get_field_id('text'); ?>"
				name="<?php echo $this->get_field_name('text'); ?>">
			</p>

			<p>Add you team sections <a target="_blank" href="/wp-admin/edit.php?post_type=team">here</a></p>
			<?php
		}
	}


	function team_widgets_init()
	{
		register_widget('team_section_widget');
	}

	add_action('widgets_init', 'team_widgets_init');