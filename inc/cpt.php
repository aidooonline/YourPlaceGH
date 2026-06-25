<?php
/**
 * Property custom post type, taxonomies, and search query mapping.
 *
 * @package YourPlaceGH
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register the property post type.
 */
function ypgh_register_cpt() {
	$labels = array(
		'name'               => __( 'Properties', 'yourplacegh' ),
		'singular_name'      => __( 'Property', 'yourplacegh' ),
		'add_new'            => __( 'Add Property', 'yourplacegh' ),
		'add_new_item'       => __( 'Add New Property', 'yourplacegh' ),
		'edit_item'          => __( 'Edit Property', 'yourplacegh' ),
		'new_item'           => __( 'New Property', 'yourplacegh' ),
		'view_item'          => __( 'View Property', 'yourplacegh' ),
		'search_items'       => __( 'Search Properties', 'yourplacegh' ),
		'not_found'          => __( 'No properties found', 'yourplacegh' ),
		'menu_name'          => __( 'Properties', 'yourplacegh' ),
	);

	register_post_type( 'property', array(
		'labels'        => $labels,
		'public'        => true,
		'has_archive'   => 'properties',
		'menu_icon'     => 'dashicons-admin-home',
		'menu_position' => 5,
		'supports'      => array( 'title', 'editor', 'thumbnail', 'excerpt' ),
		'rewrite'       => array( 'slug' => 'property', 'with_front' => false ),
		'show_in_rest'  => true,
	) );
}
add_action( 'init', 'ypgh_register_cpt' );

/**
 * Register the three property taxonomies.
 */
function ypgh_register_taxonomies() {
	register_taxonomy( 'property_status', 'property', array(
		'labels'       => array( 'name' => __( 'Status', 'yourplacegh' ), 'singular_name' => __( 'Status', 'yourplacegh' ) ),
		'hierarchical' => true,
		'public'       => true,
		'show_in_rest' => true,
		'rewrite'      => array( 'slug' => 'status', 'with_front' => false ),
	) );

	register_taxonomy( 'property_type', 'property', array(
		'labels'       => array( 'name' => __( 'Property Type', 'yourplacegh' ), 'singular_name' => __( 'Type', 'yourplacegh' ) ),
		'hierarchical' => true,
		'public'       => true,
		'show_in_rest' => true,
		'rewrite'      => array( 'slug' => 'type', 'with_front' => false ),
	) );

	register_taxonomy( 'property_area', 'property', array(
		'labels'       => array( 'name' => __( 'Areas', 'yourplacegh' ), 'singular_name' => __( 'Area', 'yourplacegh' ) ),
		'hierarchical' => true,
		'public'       => true,
		'show_in_rest' => true,
		'rewrite'      => array( 'slug' => 'area', 'with_front' => false ),
	) );
}
add_action( 'init', 'ypgh_register_taxonomies' );

/**
 * Map the search bar fields to a tax_query on the property archive.
 */
function ypgh_search_query( $query ) {
	if ( is_admin() || ! $query->is_main_query() ) {
		return;
	}
	if ( ! $query->is_post_type_archive( 'property' ) ) {
		return;
	}

	$tax_query = array();

	if ( ! empty( $_GET['status'] ) ) {
		$tax_query[] = array(
			'taxonomy' => 'property_status',
			'field'    => 'slug',
			'terms'    => sanitize_title( wp_unslash( $_GET['status'] ) ),
		);
	}
	if ( ! empty( $_GET['area'] ) ) {
		$tax_query[] = array(
			'taxonomy' => 'property_area',
			'field'    => 'slug',
			'terms'    => sanitize_title( wp_unslash( $_GET['area'] ) ),
		);
	}
	if ( ! empty( $_GET['ptype'] ) ) {
		$tax_query[] = array(
			'taxonomy' => 'property_type',
			'field'    => 'slug',
			'terms'    => sanitize_title( wp_unslash( $_GET['ptype'] ) ),
		);
	}

	if ( count( $tax_query ) > 1 ) {
		$tax_query['relation'] = 'AND';
	}
	if ( ! empty( $tax_query ) ) {
		$query->set( 'tax_query', $tax_query );
	}

	$query->set( 'posts_per_page', 9 );
}
add_action( 'pre_get_posts', 'ypgh_search_query' );

/**
 * Register types then flush rewrites on theme activation.
 */
function ypgh_flush_on_activation() {
	ypgh_register_cpt();
	ypgh_register_taxonomies();
	flush_rewrite_rules();
}
add_action( 'after_switch_theme', 'ypgh_flush_on_activation' );
