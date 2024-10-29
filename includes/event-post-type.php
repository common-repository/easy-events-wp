<?php

/**
 * Register Event Post Type
 */
function easy_event_register_event_post_type() {
	$labels  = array(
		'name'               => _x(
			'Events', 'Post Type General Name',
			'easy_event'
		),
		'singular_name'      => _x(
			'Event', 'Post Type Singular Name',
			'easy_event'
		),
		'menu_name'          => __( 'Easy Event', 'easy_event' ),
		'name_admin_bar'     => __( 'Event', 'easy_event' ),
		'parent_item_colon'  => __( 'Parent Event:', 'easy_event' ),
		'all_items'          => __( 'All Events', 'easy_event' ),
		'add_new_item'       => __( 'Add New Event', 'easy_event' ),
		'add_new'            => __( 'Add New', 'easy_event' ),
		'new_item'           => __( 'New Event', 'easy_event' ),
		'edit_item'          => __( 'Edit Event', 'easy_event' ),
		'update_item'        => __( 'Update Event', 'easy_event' ),
		'view_item'          => __( 'View Event', 'easy_event' ),
		'search_items'       => __( 'Search Event', 'easy_event' ),
		'not_found'          => __( 'Not found', 'easy_event' ),
		'not_found_in_trash' => __( 'Not found in Trash', 'easy_event' ),
	);
	$rewrite = array(
		'slug'       => 'event',
		'with_front' => true,
		'pages'      => true,
		'feeds'      => true,
	);
	$args    = array(
		'label'               => __( 'Event', 'easy_event' ),
		'description'         => __( 'Easy Events', 'easy_event' ),
		'labels'              => $labels,
		'supports'            => array( 'title', 'editor', 'thumbnail', 'excerpt' ),
		'taxonomies'          => array( 'category', 'post_tag' ),
		'hierarchical'        => false,
		'public'              => true,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'menu_position'       => 7,
		'show_in_admin_bar'   => true,
		'show_in_nav_menus'   => true,
		'can_export'          => true,
		'has_archive'         => true,
		'exclude_from_search' => false,
		'publicly_queryable'  => true,
		'rewrite'             => $rewrite,
		'capability_type'     => 'page',
		'menu_icon'           => 'dashicons-calendar',
	);
	register_post_type( 'easy_event', $args );
}

add_action( 'easy_event_init', 'easy_event_register_event_post_type' );