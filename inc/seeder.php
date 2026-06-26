<?php
/**
 * One-click setup: seeds terms, sample listings, and the primary menu.
 * Tools > YourPlaceGH Setup.
 *
 * @package YourPlaceGH
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function ypgh_setup_menu_page() {
	add_management_page( 'YourPlaceGH Setup', 'YourPlaceGH Setup', 'manage_options', 'ypgh-setup', 'ypgh_setup_page' );
}
add_action( 'admin_menu', 'ypgh_setup_menu_page' );

function ypgh_setup_page() {
	$done = false;
	if ( isset( $_POST['ypgh_seed'] ) && check_admin_referer( 'ypgh_seed_action', 'ypgh_seed_nonce' ) ) {
		ypgh_run_seed();
		flush_rewrite_rules();
		$done = true;
	}
	echo '<div class="wrap"><h1>YourPlaceGH Setup</h1>';
	if ( $done ) {
		echo '<div class="notice notice-success"><p>Setup complete: terms, sample listings, and the primary menu are in place. Permalinks were flushed.</p></div>';
	}
	echo '<p>Creates the property taxonomy terms, six sample listings (four featured), and a Primary menu assigned to the header. Safe to run more than once: existing terms and listings are not duplicated.</p>';
	echo '<form method="post">';
	wp_nonce_field( 'ypgh_seed_action', 'ypgh_seed_nonce' );
	echo '<p><button class="button button-primary" name="ypgh_seed" value="1">Run setup</button></p>';
	echo '</form></div>';
}

/**
 * Ensure a term exists; return its term_id.
 */
function ypgh_ensure_term( $name, $taxonomy, $meta = array() ) {
	$existing = get_term_by( 'name', $name, $taxonomy );
	if ( $existing ) {
		$term_id = $existing->term_id;
	} else {
		$res = wp_insert_term( $name, $taxonomy );
		if ( is_wp_error( $res ) ) {
			return 0;
		}
		$term_id = $res['term_id'];
	}
	foreach ( $meta as $k => $v ) {
		update_term_meta( $term_id, $k, $v );
	}
	return $term_id;
}

function ypgh_run_seed() {
	// Statuses, types, areas.
	foreach ( array( 'For Sale', 'For Rent', 'Short-stay', 'Land' ) as $s ) {
		ypgh_ensure_term( $s, 'property_status' );
	}
	foreach ( array( 'Apartment', 'Townhouse', 'Detached House', 'Serviced Plot' ) as $t ) {
		ypgh_ensure_term( $t, 'property_type' );
	}
	$areas = array(
		'East Legon'          => array( 'tag' => 'Premium residential', 'file' => 'east-legon.jpg' ),
		'Cantonments'         => array( 'tag' => 'Diplomatic district', 'file' => 'cantonments.jpg' ),
		'Airport Residential' => array( 'tag' => 'City convenience', 'file' => 'airport.jpg' ),
		'Teshie - Nungua'     => array( 'tag' => 'Coastal and growing', 'file' => 'teshie.jpg' ),
	);
	foreach ( $areas as $name => $cfg ) {
		ypgh_ensure_term( $name, 'property_area', array(
			'_ypgh_area_image' => get_template_directory_uri() . '/assets/img/areas/' . $cfg['file'],
			'_ypgh_area_tag'   => $cfg['tag'],
		) );
	}

	// Sample listings.
	$samples = array(
		array( 'title' => '4 Bedroom Townhouse', 'status' => 'For Sale', 'type' => 'Townhouse', 'area' => 'East Legon', 'price' => 2850000, 'cur' => 'GHS', 'period' => '', 'beds' => 4, 'baths' => 4, 'size' => '320 m&sup2;', 'featured' => 1 ),
		array( 'title' => 'Serviced 2 Bedroom Apartment', 'status' => 'For Rent', 'type' => 'Apartment', 'area' => 'Cantonments', 'price' => 12000, 'cur' => 'GHS', 'period' => 'month', 'beds' => 2, 'baths' => 2, 'size' => '110 m&sup2;', 'featured' => 1 ),
		array( 'title' => 'Executive 5 Bedroom Villa', 'status' => 'For Sale', 'type' => 'Detached House', 'area' => 'East Legon', 'price' => 6500000, 'cur' => 'GHS', 'period' => '', 'beds' => 5, 'baths' => 6, 'size' => '540 m&sup2;', 'featured' => 1 ),
		array( 'title' => 'Titled Residential Plot', 'status' => 'Land', 'type' => 'Serviced Plot', 'area' => 'Teshie - Nungua', 'price' => 220000, 'cur' => 'GHS', 'period' => '', 'beds' => 0, 'baths' => 0, 'size' => '1 acre', 'featured' => 1 ),
		array( 'title' => 'Modern 3 Bedroom Apartment', 'status' => 'For Rent', 'type' => 'Apartment', 'area' => 'Airport Residential', 'price' => 9500, 'cur' => 'GHS', 'period' => 'month', 'beds' => 3, 'baths' => 3, 'size' => '160 m&sup2;', 'featured' => 0 ),
		array( 'title' => 'Family Home with Garden', 'status' => 'For Sale', 'type' => 'Detached House', 'area' => 'Cantonments', 'price' => 4200000, 'cur' => 'GHS', 'period' => '', 'beds' => 4, 'baths' => 5, 'size' => '410 m&sup2;', 'featured' => 0 ),
	);

	foreach ( $samples as $s ) {
		$found  = get_posts( array(
			'post_type'              => 'property',
			'title'                  => $s['title'],
			'post_status'            => 'any',
			'numberposts'            => 1,
			'fields'                 => 'ids',
			'no_found_rows'          => true,
			'update_post_meta_cache' => false,
			'update_post_term_cache' => false,
		) );
		if ( ! empty( $found ) ) {
			continue;
		}
		$post_id = wp_insert_post( array(
			'post_type'    => 'property',
			'post_status'  => 'publish',
			'post_title'   => $s['title'],
			'post_content' => 'Sample listing seeded by the theme. Replace this description and add real photos for ' . $s['title'] . ' in ' . $s['area'] . ', Accra.',
		) );
		if ( ! $post_id || is_wp_error( $post_id ) ) {
			continue;
		}
		wp_set_object_terms( $post_id, $s['status'], 'property_status' );
		wp_set_object_terms( $post_id, $s['type'], 'property_type' );
		wp_set_object_terms( $post_id, $s['area'], 'property_area' );
		update_post_meta( $post_id, '_ypgh_price', $s['price'] );
		update_post_meta( $post_id, '_ypgh_currency', $s['cur'] );
		update_post_meta( $post_id, '_ypgh_period', $s['period'] );
		update_post_meta( $post_id, '_ypgh_beds', $s['beds'] );
		update_post_meta( $post_id, '_ypgh_baths', $s['baths'] );
		update_post_meta( $post_id, '_ypgh_size', $s['size'] );
		if ( $s['featured'] ) {
			update_post_meta( $post_id, '_ypgh_featured', '1' );
		}
	}

	ypgh_seed_menu();
}

/**
 * Create and assign the Primary menu if the location is empty.
 */
function ypgh_seed_menu() {
	$locations = get_nav_menu_locations();
	if ( ! empty( $locations['primary'] ) && wp_get_nav_menu_object( $locations['primary'] ) ) {
		return;
	}

	$menu_name = 'Primary';
	$menu      = wp_get_nav_menu_object( $menu_name );
	if ( ! $menu ) {
		$menu_id = wp_create_nav_menu( $menu_name );
	} else {
		$menu_id = $menu->term_id;
	}
	if ( is_wp_error( $menu_id ) ) {
		return;
	}

	$archive = get_post_type_archive_link( 'property' );
	$items   = array(
		array( 'About us', home_url( '/about/' ) ),
		array( 'Properties', $archive ? $archive : home_url( '/properties/' ) ),
		array( 'Lands', add_query_arg( 'status', 'land', $archive ? $archive : home_url( '/properties/' ) ) ),
		array( 'Blog', home_url( '/blog/' ) ),
		array( 'FAQ', home_url( '/#faq' ) ),
		array( 'Contact', home_url( '/contact/' ) ),
	);
	foreach ( $items as $it ) {
		wp_update_nav_menu_item( $menu_id, 0, array(
			'menu-item-title'  => $it[0],
			'menu-item-url'    => $it[1],
			'menu-item-status' => 'publish',
			'menu-item-type'   => 'custom',
		) );
	}

	$locations            = get_theme_mod( 'nav_menu_locations', array() );
	$locations['primary'] = $menu_id;
	set_theme_mod( 'nav_menu_locations', $locations );
}
