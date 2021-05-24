<?php

// Add the Events Meta Boxes

add_action( 'add_meta_boxes', 'add_external_metaboxes' );

function add_external_metaboxes() {
	add_meta_box('external_link', 'External link', 'external_link', 'post', 'side', 'high');
}

// The Event Location Metabox

function external_link() {

	global $post;
	
	// Noncename needed to verify where the data originated
	echo '<input type="hidden" name="externalmeta_noncename" id="externalmeta_noncename" value="' . 
	wp_create_nonce( plugin_basename(__FILE__) ) . '" />';
	
	// Get the location data if its already been entered
	$external = get_post_meta($post->ID, 'external_link_meta', true);
	
	// Echo out the field
	echo '<p>Enter your post external link here.</p>';
	echo '<input type="text" name="external_link_meta" value="' . $external  . '" class="widefat" />';

}

// Save the Metabox Data

function save_external_meta($post_id, $post) {
	
	// verify this came from the our screen and with proper authorization,
	// because save_post can be triggered at other times
	if ( !wp_verify_nonce( $_POST['externalmeta_noncename'], plugin_basename(__FILE__) )) {
		return $post->ID;
	}

	// Is the user allowed to edit the post or page?
	if ( !current_user_can( 'edit_post', $post->ID ))
		return $post->ID;

	// OK, we're authenticated: we need to find and save the data
	// We'll put it into an array to make it easier to loop though.
	
	$external_meta['external_link_meta'] = $_POST['external_link_meta'];
	
	// Add values of $events_meta as custom fields
	
	foreach ($external_meta as $key => $value) { // Cycle through the $events_meta array!
		if( $post->post_type == 'revision' ) return; // Don't store custom data twice
		$value = implode(',', (array)$value); // If $value is an array, make it a CSV (unlikely)
		if(get_post_meta($post->ID, $key, FALSE)) { // If the custom field already has a value
			update_post_meta($post->ID, $key, $value);
		} else { // If the custom field doesn't have a value
			add_post_meta($post->ID, $key, $value);
		}
		if(!$value) delete_post_meta($post->ID, $key); // Delete if blank
	}

}

add_action('save_post', 'save_external_meta', 1, 2); // save the custom fields