<?php

class mailchimp_newsletter_widget extends WP_Widget
{
	function __construct() {
		parent::__construct(
			// Base ID of your widget
			'mailchimp_newsletter_widget', 

			// Widget name will appear in UI
			'Mailchimp Newsltter Widget',
			
			// Widget description
			array( 'description' => 'Widget which will create a newsletter subscribe box', 'wpb_widget_domain', ) 
			);
	}

	function widget($args, $instance)
	{
		extract($args); ?>

		<div class="subscribeToNewsletter">

			<div class="subscribeToNewsletter__head">
				<h2>Subscribe to the Fairlady Newsletter</h2>
			</div>

			<div class="subscribeToNewsletter__form">
				<form>
					<div class="subscribeToNewsletter__form--left">
						<input name="email" type="email" placeholder="Email" required />
					</div>

					<div class="subscribeToNewsletter__form--right">
						<input type="submit" value="Subscribe Now!" />
					</div>


				</form>
			</div>

		</div>

		<?php }

		function update($new_instance, $old_instance)
		{
			$instance = $old_instance;

			return $instance;
		}

		function form($instance)
		{

		}
	}


	function mailchimp_newsletter_widgets_init()
	{
		register_widget('mailchimp_newsletter_widget');
	}

	add_action('widgets_init', 'mailchimp_newsletter_widgets_init');