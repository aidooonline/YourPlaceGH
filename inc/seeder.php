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
		echo '<div class="notice notice-success"><p>Setup complete: terms, listings, pages, reading settings, and the primary menu are in place. Permalinks were flushed.</p></div>';
	}
	echo '<p>Creates the property taxonomy terms, six sample listings (three featured), the core pages (Home, Services, Diaspora, About, Contact, Insights) with templates assigned, sets the static front page and posts page, and assigns the Primary menu. Safe to run more than once: nothing is duplicated.</p>';
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
	foreach ( array( 'For Sale', 'For Rent', 'Land' ) as $s ) {
		ypgh_ensure_term( $s, 'property_status' );
	}
	foreach ( array( 'House', 'Apartment', 'Land', 'Commercial' ) as $t ) {
		ypgh_ensure_term( $t, 'property_type' );
	}
	$areas = array(
		'Pantang'    => array( 'tag' => 'Our home ground', 'image' => 'https://images.pexels.com/photos/18346466/pexels-photo-18346466.jpeg?auto=compress&cs=tinysrgb&w=1600' ),
		'Oyarifa'    => array( 'tag' => 'Ga East corridor', 'image' => get_template_directory_uri() . '/assets/img/areas/airport.jpg' ),
		'East Legon' => array( 'tag' => 'Premium residential', 'image' => 'https://images.pexels.com/photos/31782030/pexels-photo-31782030.jpeg?auto=compress&cs=tinysrgb&w=1600' ),
		'Accra Wide' => array( 'tag' => 'Airport, Cantonments & beyond', 'image' => 'https://images.pexels.com/photos/31800284/pexels-photo-31800284.jpeg?auto=compress&cs=tinysrgb&w=1600' ),
	);
	foreach ( $areas as $name => $cfg ) {
		ypgh_ensure_term( $name, 'property_area', array(
			'_ypgh_area_image' => $cfg['image'],
			'_ypgh_area_tag'   => $cfg['tag'],
		) );
	}

	// Sample listings (from the approved site content).
	$samples = array(
		array( 'title' => '4 Bedroom Detached House', 'status' => 'For Sale', 'type' => 'House', 'area' => 'Pantang', 'price' => 185000, 'cur' => 'USD', 'period' => '', 'beds' => 4, 'baths' => 3, 'size' => '260 m&sup2;', 'featured' => 1 ),
		array( 'title' => '3 Bedroom Furnished Apartment', 'status' => 'For Rent', 'type' => 'Apartment', 'area' => 'East Legon', 'price' => 1800, 'cur' => 'USD', 'period' => 'mo', 'beds' => 3, 'baths' => 2, 'size' => '140 m&sup2;', 'featured' => 1 ),
		array( 'title' => 'Serviced Plot - 1 Acre', 'status' => 'Land', 'type' => 'Land', 'area' => 'Oyarifa', 'price' => 42000, 'cur' => 'USD', 'period' => '', 'beds' => 0, 'baths' => 0, 'size' => '1 acre', 'featured' => 1 ),
		array( 'title' => '5 Bedroom Executive Home', 'status' => 'For Sale', 'type' => 'House', 'area' => 'East Legon', 'price' => 520000, 'cur' => 'USD', 'period' => '', 'beds' => 5, 'baths' => 5, 'size' => '480 m&sup2;', 'featured' => 0 ),
		array( 'title' => '2 Bedroom Apartment', 'status' => 'For Rent', 'type' => 'Apartment', 'area' => 'Accra Wide', 'price' => 950, 'cur' => 'USD', 'period' => 'mo', 'beds' => 2, 'baths' => 2, 'size' => '95 m&sup2;', 'featured' => 0 ),
		array( 'title' => 'Walled Corner Plot', 'status' => 'Land', 'type' => 'Land', 'area' => 'Pantang', 'price' => 28000, 'cur' => 'USD', 'period' => '', 'beds' => 0, 'baths' => 0, 'size' => '70 x 100 ft', 'featured' => 0 ),
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

	ypgh_seed_pages();
	ypgh_seed_menu();
}

/**
 * Create the core pages with their templates and set front/posts pages.
 */
function ypgh_seed_pages() {
	$pages = array(
		'home'     => array( 'Home', '' ),
		'services' => array( 'Services', 'templates/template-services.php' ),
		'diaspora' => array( 'Diaspora', 'templates/template-diaspora.php' ),
		'about'    => array( 'About', 'templates/template-about.php' ),
		'contact'  => array( 'Contact', 'templates/template-contact.php' ),
		'insights' => array( 'Insights', '' ),
	);
	$ids = array();
	foreach ( $pages as $slug => $cfg ) {
		$page = get_page_by_path( $slug );
		if ( ! $page ) {
			$page_id = wp_insert_post( array(
				'post_type'   => 'page',
				'post_status' => 'publish',
				'post_title'  => $cfg[0],
				'post_name'   => $slug,
			) );
		} else {
			$page_id = $page->ID;
		}
		if ( $page_id && ! is_wp_error( $page_id ) ) {
			if ( $cfg[1] ) {
				update_post_meta( $page_id, '_wp_page_template', $cfg[1] );
			}
			$ids[ $slug ] = $page_id;
		}
	}
	if ( ! empty( $ids['home'] ) && ! empty( $ids['insights'] ) ) {
		update_option( 'show_on_front', 'page' );
		update_option( 'page_on_front', $ids['home'] );
		update_option( 'page_for_posts', $ids['insights'] );
	}
}

/**
 * Create and assign the Primary menu if the location is empty.
 */
function ypgh_seed_menu() {
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

	// Rebuild items so the nav always reflects the current site structure.
	$existing = wp_get_nav_menu_items( $menu_id );
	if ( $existing ) {
		foreach ( $existing as $item ) {
			wp_delete_post( $item->ID, true );
		}
	}

	$archive = get_post_type_archive_link( 'property' );
	$items   = array(
		array( 'Properties', $archive ? $archive : home_url( '/properties/' ) ),
		array( 'Services', home_url( '/services/' ) ),
		array( 'Diaspora', home_url( '/diaspora/' ) ),
		array( 'Insights', home_url( '/insights/' ) ),
		array( 'About', home_url( '/about/' ) ),
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
