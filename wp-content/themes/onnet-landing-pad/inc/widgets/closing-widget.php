<?php

class closing_widget extends WP_Widget
{
	function __construct() {
		parent::__construct(
			// Base ID of your widget
			'closing_widget', 

			// Widget name will appear in UI
			'Closing Widget',
			
			// Widget description
			array( 'description' => 'Closing widget creates a box with customisable content done in theme options', 'wpb_widget_domain', ) 
			);
	}

	function widget($args, $instance)
	{

		// Closing background
		$show = of_get_option('show_closing');
		$background = of_get_option('background_image');
		$message = of_get_option('closing_message');

		if ($show === '1') { ?>

		<div class="closeDownMessage" <?php if (!empty($background)) { ?> style="background: url('<?php echo $background; ?>') #ccc;" <?php } ?> >
			<div class="closeDownMessage__body">
				<?php if (!empty($message)) { ?>
				<p><?php echo $message; ?></p>
				<?php } ?>
			</div>
		</div>

		<?php }

	}

	function update($new_instance, $old_instance)
	{
		$instance = $old_instance;

		return $instance;
	}

	function form($instance)
	{ ?>

		<p>Edit your theme options <a target="_blank" href="/wp-admin/themes.php?page=options-framework">here</a></p>

		<?php

	}
}


function closing_widgets_init()
{
	register_widget('closing_widget');
}

add_action('widgets_init', 'closing_widgets_init');