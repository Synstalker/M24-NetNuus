<?php

class everlytic_newsletter_widget_two extends WP_Widget
{
	function __construct() {
		parent::__construct(
			// Base ID of your widget
			'everlytic_newsletter_widget_two',

			// Widget name will appear in UI
			'Everlytic Newsletter Widget V2',

			// Widget description
			array( 'description' => 'Widget which will create a newsletter subscribe . This will only work for a single list.', 'wpb_widget_domain', )
			);
	}

	function widget($args, $instance)
	{
		$title = apply_filters( 'widget_title', $instance['title'] );
        $body_copy = $instance['body_copy'];
        $form_hash = $instance['form_hash'];
		$list_id = $instance['list_id'];
		$subscribe_url = $instance['subscribe_url'];
		$first_name_label = $instance['first_name_label'];
		$first_name_placeholder = $instance['first_name_placeholder'];
		$last_name_label = $instance['last_name_label'];
		$last_name_placeholder = $instance['last_name_placeholder'];
		$email_label = $instance['email_label'];
		$email_placeholder = $instance['email_placeholder'];
		$submit_label = $instance['submit_label'];
        //New
		$list_title = $instance['list_title'];
        $list_label = $instance['list_label'];

		?>

        <div class="subscribeToNewsletter" xmlns="http://www.w3.org/1999/html">

            <?php if (!empty($title)) { ?>
                <div class="subscribeToNewsletter__head">
                    <h2><?php echo $title; ?></h2>
                </div>
            <?php } ?>

            <?php if (!empty($body_copy)) { ?>
				<div class="subscribeToNewsletter__body" style="padding:0 40px 40px 40px;">
					<p><?php echo $body_copy; ?></p>
				</div>
			<?php } ?>

			<div class="subscribeToNewsletter__form">
				<form action="<?php echo (!empty($subscribe_url)) ? $subscribe_url :  ''; ?>" method="post" id="item-form" name="item-form" target="_blank">

					<input type="hidden" name="op" value="subscribe" id="op">

					<?php if (!empty($first_name_label)) { ?>
					<label for="contact_name"><?php echo $first_name_label; ?></label>
					<?php } ?>
					<input id="contact_name"
					       placeholder="<?php echo (!empty($first_name_placeholder)) ? $first_name_placeholder :  'First Name'; ?>"
					       required="required"
					       type="text"
					       name="contact_name"
					       value="">

					<?php if (!empty($last_name_label)) { ?>
					<label for="contact_lastname"><?php echo $last_name_label; ?></label>
					<?php } ?>
					<input id="contact_lastname"
					       placeholder="<?php echo (!empty($last_name_placeholder)) ? $last_name_placeholder :  'Last Name'; ?>"
					       required="required"
					       type="text"
					       name="contact_lastname"
					       value="">

					<?php if (!empty($email_label)) { ?>
					<label for="contact_email"><?php echo $email_label; ?></label>
					<?php } ?>
					<input id="contact_email"
					       placeholder="<?php echo (!empty($email_placeholder)) ? $email_placeholder :  'Email Address'; ?>"
					       required="required"
					       type="text"
					       name="contact_email"
					       value="">

					<!-- Combined newsletters lists  -->
                    <label><?php echo (!empty($list_title)) ? $list_title :  'Select the list/lists you would like to be subscribed to'; ?></label>

					<div class="newsletter_checkbox_list">

					<?php
					$list_id = explode(',',$list_id);
					$list_label = explode(',',$list_label);


					if(count($list_id) > 1) {
						for ($i = 0; $i < count($list_id); $i++) {
							$label = !empty($list_label[$i]) ? $list_label[$i] : 'No label';
							echo '<input id="list_' . $list_id[$i] . '" type="checkbox" name="list_id[]" value="' . $list_id[$i] . '"><label for="list_' . $list_id[$i] . '" class="checkbox_label">' . $label . '</label>';
							if($i !== (count($list_id) - 1)){
								echo '<br>';
							}
						}
					}else{
						$label = !empty($list_label[0]) ? $list_label[0] : 'No label';
						echo '<input id="list_' . $list_id[0] . '" type="checkbox" name="list_id[]" value="' . $list_id[0] . '"><label for="list_' . $list_id[0] . '" class="checkbox_label">' . $label . '</label><br>';
					}
					?>

					</div>
					<div id="lists_error_box"></div>

					<input type="submit" value="<?php echo (!empty($submit_label)) ? $submit_label :  'Submit'; ?>">
					<input type="hidden" name="form_hash" value="<?php echo (!empty($form_hash)) ? $form_hash :  'Tts1BrWKPQ2kMybL'; ?>" id="form_hash">

				</form>
			</div>
		</div>

		<?php }

		public function update( $new_instance, $old_instance ) {

		$instance = array();

		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
        $instance['body_copy'] = ( ! empty( $new_instance['body_copy'] ) ) ? strip_tags( $new_instance['body_copy'] ) : '';
		$instance['form_hash'] = ( ! empty( $new_instance['form_hash'] ) ) ? strip_tags( $new_instance['form_hash'] ) : '';
		$instance['list_id'] = ( ! empty( $new_instance['list_id'] ) ) ? strip_tags( $new_instance['list_id'] ) : '';
		$instance['subscribe_url'] = ( ! empty( $new_instance['subscribe_url'] ) ) ? strip_tags( $new_instance['subscribe_url'] ) : '';
		$instance['first_name_label'] = ( ! empty( $new_instance['first_name_label'] ) ) ? strip_tags( $new_instance['first_name_label'] ) : '';
		$instance['first_name_placeholder'] = ( ! empty( $new_instance['first_name_placeholder'] ) ) ? strip_tags( $new_instance['first_name_placeholder'] ) : '';
		$instance['last_name_label'] = ( ! empty( $new_instance['last_name_label'] ) ) ? strip_tags( $new_instance['last_name_label'] ) : '';
		$instance['last_name_placeholder'] = ( ! empty( $new_instance['last_name_placeholder'] ) ) ? strip_tags( $new_instance['last_name_placeholder'] ) : '';
		$instance['email_label'] = ( ! empty( $new_instance['email_label'] ) ) ? strip_tags( $new_instance['email_label'] ) : '';
		$instance['email_placeholder'] = ( ! empty( $new_instance['email_placeholder'] ) ) ? strip_tags( $new_instance['email_placeholder'] ) : '';
		$instance['submit_label'] = ( ! empty( $new_instance['submit_label'] ) ) ? strip_tags( $new_instance['submit_label'] ) : '';

        $instance['list_label'] = ( ! empty( $new_instance['list_label'] ) ) ? strip_tags( $new_instance['list_label'] ) : '';
        $instance['list_title'] = ( ! empty( $new_instance['list_title'] ) ) ? strip_tags( $new_instance['list_title'] ) : '';

		return $instance;
	}

		function form($instance)
		{
			$title = '';
			if( !empty( $instance['title'] ) ) {
				$title = $instance['title'];
			}

            $body_copy = '';
            if( !empty( $instance['body_copy'] ) ) {
                $body_copy = $instance['body_copy'];
            }

			$form_hash = '';
			if( !empty( $instance['form_hash'] ) ) {
				$form_hash = $instance['form_hash'];
			}

			$list_id = '';
			if( !empty( $instance['list_id'] ) ) {
				$list_id = $instance['list_id'];
			}

			$list_label = '';
			if( !empty( $instance['list_label'] ) ) {
				$list_label = $instance['list_label'];
			}

			$list_title = '';
			if( !empty( $instance['list_title'] ) ) {
				$list_title = $instance['list_title'];
			}

			$subscribe_url = '';
			if( !empty( $instance['subscribe_url'] ) ) {
				$subscribe_url = $instance['subscribe_url'];
			}

			$first_name_label = '';
			if( !empty( $instance['first_name_label'] ) ) {
				$first_name_label = $instance['first_name_label'];
			}

			$first_name_placeholder = '';
			if( !empty( $instance['first_name_placeholder'] ) ) {
				$first_name_placeholder = $instance['first_name_placeholder'];
			}

			$last_name_label = '';
			if( !empty( $instance['last_name_label'] ) ) {
				$last_name_label = $instance['last_name_label'];
			}

			$last_name_placeholder = '';
			if( !empty( $instance['last_name_placeholder'] ) ) {
				$last_name_placeholder = $instance['last_name_placeholder'];
			}

			$email_label = '';
			if( !empty( $instance['email_label'] ) ) {
				$email_label = $instance['email_label'];
			}

			$email_placeholder = '';
			if( !empty( $instance['email_placeholder'] ) ) {
				$email_placeholder = $instance['email_placeholder'];
			}

			$submit_label = '';
			if( !empty( $instance['submit_label'] ) ) {
				$submit_label = $instance['submit_label'];
			}

			?>

            <p>
                <label for="<?php echo $this->get_field_name( 'title' ); ?>"><?php _e( 'Widget Title:' ); ?></label>
                <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
            </p>

            <p>
				<label for="<?php echo $this->get_field_name( 'body_copy' ); ?>"><?php _e( 'Body Copy:' ); ?></label>
				<textarea class="widefat" id="<?php echo $this->get_field_id( 'body_copy' ); ?>" name="<?php echo $this->get_field_name( 'body_copy' ); ?>" type="text" /><?php echo esc_textarea( $body_copy ); ?></textarea>
			</p>

			<p>
				<label for="<?php echo $this->get_field_name( 'form_hash' ); ?>"><?php _e( 'Form Hash:' ); ?></label>
				<input class="widefat" id="<?php echo $this->get_field_id( 'form_hash' ); ?>" name="<?php echo $this->get_field_name( 'form_hash' ); ?>" type="text" value="<?php echo esc_attr( $form_hash ); ?>" />
			</p>

			<p>
				<label for="<?php echo $this->get_field_name( 'list_id' ); ?>"><?php _e( 'List ID (Separate multiples with commas):' ); ?></label>
				<input class="widefat" id="<?php echo $this->get_field_id( 'list_id' ); ?>" name="<?php echo $this->get_field_name( 'list_id' ); ?>" type="text" value="<?php echo esc_attr( $list_id ); ?>" />
			</p>

            <p>
                <label for="<?php echo $this->get_field_name( 'list_title' ); ?>"><?php _e( 'List Title:' ); ?></label>
                <input class="widefat" id="<?php echo $this->get_field_id( 'list_title' ); ?>" name="<?php echo $this->get_field_name( 'list_title' ); ?>" type="text" value="<?php echo esc_attr( $list_title ); ?>" />
            </p>

			<p>
                <label for="<?php echo $this->get_field_name( 'list_label' ); ?>"><?php _e( 'List Labels (Separate multiples with commas):' ); ?></label>
                <input class="widefat" id="<?php echo $this->get_field_id( 'list_label' ); ?>" name="<?php echo $this->get_field_name( 'list_label' ); ?>" type="text" value="<?php echo esc_attr( $list_label ); ?>" />
            </p>

			<p>
				<label for="<?php echo $this->get_field_name( 'subscribe_url' ); ?>"><?php _e( 'Subscribe URL:' ); ?></label>
				<input class="widefat" id="<?php echo $this->get_field_id( 'subscribe_url' ); ?>" name="<?php echo $this->get_field_name( 'subscribe_url' ); ?>" type="text" value="<?php echo esc_attr( $subscribe_url ); ?>" />
			</p>

			<p>
				<label for="<?php echo $this->get_field_name( 'first_name_label' ); ?>"><?php _e( 'First name Label:' ); ?></label>
				<input class="widefat" id="<?php echo $this->get_field_id( 'first_name_label' ); ?>" name="<?php echo $this->get_field_name( 'first_name_label' ); ?>" type="text" value="<?php echo esc_attr( $first_name_label ); ?>" />
			</p>

			<p>
				<label for="<?php echo $this->get_field_name( 'first_name_placeholder' ); ?>"><?php _e( 'First name Placeholder:' ); ?></label>
				<input class="widefat" id="<?php echo $this->get_field_id( 'first_name_placeholder' ); ?>" name="<?php echo $this->get_field_name( 'first_name_placeholder' ); ?>" type="text" value="<?php echo esc_attr( $first_name_placeholder ); ?>" />
			</p>

			<p>
				<label for="<?php echo $this->get_field_name( 'last_name_label' ); ?>"><?php _e( 'Last name Label:' ); ?></label>
				<input class="widefat" id="<?php echo $this->get_field_id( 'last_name_label' ); ?>" name="<?php echo $this->get_field_name( 'last_name_label' ); ?>" type="text" value="<?php echo esc_attr( $last_name_label ); ?>" />
			</p>

			<p>
				<label for="<?php echo $this->get_field_name( 'last_name_placeholder' ); ?>"><?php _e( 'Last name Placeholder:' ); ?></label>
				<input class="widefat" id="<?php echo $this->get_field_id( 'last_name_placeholder' ); ?>" name="<?php echo $this->get_field_name( 'last_name_placeholder' ); ?>" type="text" value="<?php echo esc_attr( $last_name_placeholder ); ?>" />
			</p>

			<p>
				<label for="<?php echo $this->get_field_name( 'email_label' ); ?>"><?php _e( 'Email Label:' ); ?></label>
				<input class="widefat" id="<?php echo $this->get_field_id( 'email_label' ); ?>" name="<?php echo $this->get_field_name( 'email_label' ); ?>" type="text" value="<?php echo esc_attr( $email_label ); ?>" />
			</p>

			<p>
				<label for="<?php echo $this->get_field_name( 'email_placeholder' ); ?>"><?php _e( 'Email Placeholder:' ); ?></label>
				<input class="widefat" id="<?php echo $this->get_field_id( 'email_placeholder' ); ?>" name="<?php echo $this->get_field_name( 'email_placeholder' ); ?>" type="text" value="<?php echo esc_attr( $email_placeholder ); ?>" />
			</p>

			<p>
				<label for="<?php echo $this->get_field_name( 'submit_label' ); ?>"><?php _e( 'Submit Label:' ); ?></label>
				<input class="widefat" id="<?php echo $this->get_field_id( 'submit_label' ); ?>" name="<?php echo $this->get_field_name( 'submit_label' ); ?>" type="text" value="<?php echo esc_attr( $submit_label ); ?>" />
			</p>

			<?php

		}
	}


	function everlytic_newsletter_widgets_two_init()
	{
		register_widget('everlytic_newsletter_widget_two');
	}

	add_action('widgets_init', 'everlytic_newsletter_widgets_two_init');