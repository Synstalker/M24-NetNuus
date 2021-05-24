<?php

// Register Team Post Type

function team_post_type() {

	$labels = array(
		'name'                => _x( 'Team', 'Post Type General Name', 'text_domain' ),
		'singular_name'       => _x( 'Team', 'Post Type Singular Name', 'text_domain' ),
		'menu_name'           => __( 'Team', 'text_domain' ),
		'name_admin_bar'      => __( 'Team', 'text_domain' ),
		'parent_item_colon'   => __( 'Parent Team section:', 'text_domain' ),
		'all_items'           => __( 'All Team Sections', 'text_domain' ),
		'add_new_item'        => __( 'Add New Team Section', 'text_domain' ),
		'add_new'             => __( 'Add New', 'text_domain' ),
		'new_item'            => __( 'New Team section', 'text_domain' ),
		'edit_item'           => __( 'Edit Team section', 'text_domain' ),
		'update_item'         => __( 'Update Team section', 'text_domain' ),
		'view_item'           => __( 'View Team section', 'text_domain' ),
		'search_items'        => __( 'Search Team section', 'text_domain' ),
		'not_found'           => __( 'Not found', 'text_domain' ),
		'not_found_in_trash'  => __( 'Not found in Trash', 'text_domain' ),
	);

	$args = array(
		'label'               => __( 'Team', 'text_domain' ),
		'description'         => __( 'Team sections', 'text_domain' ),
		'labels'              => $labels,
		'supports'            => array( ),
		'hierarchical'        => false,
		'public'              => true,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'menu_position'       => 5,
		'menu_icon'           => 'dashicons-admin-users',
		'show_in_admin_bar'   => true,
		'show_in_nav_menus'   => true,
		'can_export'          => true,
		'has_archive'         => false,
		'exclude_from_search' => true,
		'publicly_queryable'  => true,
		'capability_type'     => 'post',
		'supports' => array( 'title' )
	);

	register_post_type( 'team', $args );

}

// Hook into the 'init' action
add_action( 'init', 'team_post_type', 0 );