<?php

class contact_us_widget extends WP_Widget
{
	function __construct() {
		parent::__construct(
			// Base ID of your widget
			'contact_us_widget', 

			// Widget name will appear in UI
			'Contact Widget',
			
			// Widget description
			array( 'description' => 'Contact us widget displaying a gravity form of your choice and team member section.', 'wpb_widget_domain', ) 
			);
	}

	function widget($args, $instance)
	{
		extract($args);

		$text = apply_filters('widget_text', $instance['text'], $instance);
		$number = apply_filters('widget_number', $instance['number'], $instance);
		$number = (!empty($number)) ? $number : '-1';

		$contact_args = array(
			'post_type' => 'team',
			'posts_per_page' => $number,
			'orderby' => 'date',
			'order' => 'DESC'
			);

		$post_query = new WP_Query( $contact_args );

		?>

		<div class="getInTouch">

			<div class="getInTouch__head">
				<h2><?php if (!empty($text)) { echo $text; } ?></h2>
			</div>

			<div class="getInTouch__form">
				<div class="getInTouch__form--left">

					<?php echo do_shortcode( '[gravityform id="' . $instance['gform_select'] . '" title="false" description="false"]' ); ?>

				</div>

				<?php if ( $post_query->have_posts() ) : ?>

					<div class="getInTouch__form--right">

						<?php while ( $post_query->have_posts() ) : $post_query->the_post(); 

						$address = get_post_meta( get_the_ID(), 'address_meta', true );
						$address = (!empty($address)) ? $address : '';
						$telephone = get_post_meta( get_the_ID(), 'telephone_meta', true );
						$telephone = (!empty($telephone)) ? $telephone : '';

						?>

						<p><?php echo get_the_title(); ?><br /><?php echo $address; ?> | <?php echo $telephone; ?></p>

						<?php endwhile; ?>

					</div>

				<?php endif; ?>

			</div>

		</div>



	<?php }

	function update($new_instance, $old_instance)
	{
		$instance = $old_instance;

		if ( current_user_can('unfiltered_html') ) {
			$instance['text'] = $new_instance['text'];
		} else {
			$instance['text'] = stripslashes(wp_filter_post_kses(addslashes($new_instance['text'])));
		}

		if ( current_user_can('unfiltered_html') ) {
			$instance['number'] = $new_instance['number'];
		} else {
			$instance['number'] = stripslashes(wp_filter_post_kses(addslashes($new_instance['number'])));
		}

		$instance['gform_select'] = $new_instance['gform_select'];

		return $instance;
	}

	function form($instance)
	{

		$instance = wp_parse_args((array)$instance, array('text' => ''));
		$text = format_to_edit($instance['text']);
		$text = (!empty($text)) ? $text : '';
		$number = format_to_edit($instance['number']);
		$number = (!empty($number)) ? $number : '';

		$select = "<select class='gform_select' name='" . $this->get_field_name('gform_select') . "' id='" . $this->get_field_id('gform_select') . "'>";
		$forms = RGFormsModel::get_forms( null, 'title' );
		foreach( $forms as $form ):
			$selected = ($form->id === $instance['gform_select']) ? 'selected' : '';
			$select .= "<option value='" . $form->id . "' " . $selected . ">" . $form->title . "</option>";
		endforeach;
		$select .= '</select>'; ?>

		<p>Add you contact us title here.
			<input style="margin: 10px 0;" type="text" value="<?php echo $text; ?>" class="widefat" id="<?php echo $this->get_field_id('text'); ?>"
			name="<?php echo $this->get_field_name('text'); ?>">
		</p>

		<p>Select your gravity form here -</p>
		<?php echo $select; ?>

		<p>Add you team sections <a target="_blank" href="/wp-admin/edit.php?post_type=team">here</a></p>

		<p>Amount of team members to display ( Maximum of 4 )
			<input style="margin: 10px 0;" type="text" value="<?php echo $number; ?>" class="widefat" id="<?php echo $this->get_field_id('number'); ?>"
			name="<?php echo $this->get_field_name('number'); ?>">
		</p>

		<?php

	}
}


function contact_widgets_init()
{
	register_widget('contact_us_widget');
}

add_action('widgets_init', 'contact_widgets_init');