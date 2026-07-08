<?php
/**
 * Custom post types and taxonomies.
 *
 * @package ypgh
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register the Listing and Location post types.
 */
function ypgh_register_post_types() {

	register_post_type(
		'yp_listing',
		array(
			'labels'       => array(
				'name'          => __( 'Listings', 'ypgh' ),
				'singular_name' => __( 'Listing', 'ypgh' ),
				'add_new_item'  => __( 'Add New Listing', 'ypgh' ),
				'edit_item'     => __( 'Edit Listing', 'ypgh' ),
				'search_items'  => __( 'Search Listings', 'ypgh' ),
			),
			'public'       => true,
			'has_archive'  => true,
			'rewrite'      => array(
				'slug'       => 'listings',
				'with_front' => false,
			),
			'supports'     => array( 'title', 'editor', 'thumbnail', 'excerpt', 'revisions' ),
			'menu_icon'    => 'dashicons-admin-multisite',
			'menu_position'=> 5,
			'show_in_rest' => true,
		)
	);

	register_post_type(
		'yp_location',
		array(
			'labels'       => array(
				'name'          => __( 'Locations', 'ypgh' ),
				'singular_name' => __( 'Location', 'ypgh' ),
				'add_new_item'  => __( 'Add New Neighborhood', 'ypgh' ),
				'edit_item'     => __( 'Edit Neighborhood', 'ypgh' ),
			),
			'public'       => true,
			'has_archive'  => true,
			'rewrite'      => array(
				'slug'       => 'neighborhoods',
				'with_front' => false,
			),
			'supports'     => array( 'title', 'editor', 'thumbnail', 'excerpt' ),
			'menu_icon'    => 'dashicons-location',
			'menu_position'=> 6,
			'show_in_rest' => true,
		)
	);
}
add_action( 'init', 'ypgh_register_post_types' );

/**
 * Register taxonomies for filtering.
 */
function ypgh_register_taxonomies() {

	// For sale / For rent / Short let.
	register_taxonomy(
		'yp_status',
		'yp_listing',
		array(
			'labels'            => array(
				'name'          => __( 'Listing Status', 'ypgh' ),
				'singular_name' => __( 'Status', 'ypgh' ),
			),
			'hierarchical'      => true,
			'public'            => true,
			'show_admin_column' => true,
			'show_in_rest'      => true,
			'rewrite'           => array( 'slug' => 'status' ),
		)
	);

	// House / Apartment / Land / Commercial.
	register_taxonomy(
		'yp_ptype',
		'yp_listing',
		array(
			'labels'            => array(
				'name'          => __( 'Property Type', 'ypgh' ),
				'singular_name' => __( 'Property Type', 'ypgh' ),
			),
			'hierarchical'      => true,
			'public'            => true,
			'show_admin_column' => true,
			'show_in_rest'      => true,
			'rewrite'           => array( 'slug' => 'type' ),
		)
	);

	// City / area taxonomy shared by listings and locations.
	register_taxonomy(
		'yp_city',
		array( 'yp_listing', 'yp_location' ),
		array(
			'labels'            => array(
				'name'          => __( 'Cities', 'ypgh' ),
				'singular_name' => __( 'City', 'ypgh' ),
			),
			'hierarchical'      => true,
			'public'            => true,
			'show_admin_column' => true,
			'show_in_rest'      => true,
			'rewrite'           => array( 'slug' => 'city' ),
		)
	);
}
add_action( 'init', 'ypgh_register_taxonomies' );

/**
 * Seed default terms on theme activation.
 */
function ypgh_seed_terms() {
	$defaults = array(
		'yp_status' => array( 'For Sale', 'For Rent', 'Short Let' ),
		'yp_ptype'  => array( 'House', 'Apartment', 'Serviced Apartment', 'Land', 'Commercial', 'Office' ),
	);

	foreach ( $defaults as $tax => $terms ) {
		foreach ( $terms as $term ) {
			if ( ! term_exists( $term, $tax ) ) {
				wp_insert_term( $term, $tax );
			}
		}
	}
}
