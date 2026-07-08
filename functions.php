<?php
/**
 * YourPlaceGH theme bootstrap.
 *
 * @package ypgh
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'YPGH_VERSION', '2.2.0' );
define( 'YPGH_DIR', get_template_directory() );
define( 'YPGH_URI', get_template_directory_uri() );

/**
 * Theme supports.
 */
function ypgh_setup() {
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'html5', array( 'search-form', 'gallery', 'caption', 'style', 'script' ) );
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'responsive-embeds' );

	add_image_size( 'ypgh_card', 720, 480, true );
	add_image_size( 'ypgh_hero', 1600, 900, true );

	register_nav_menus(
		array(
			'primary' => __( 'Primary Menu', 'ypgh' ),
			'footer'  => __( 'Footer Menu', 'ypgh' ),
		)
	);
}
add_action( 'after_setup_theme', 'ypgh_setup' );

/**
 * Includes.
 */
require YPGH_DIR . '/inc/cpt.php';
require YPGH_DIR . '/inc/meta.php';
require YPGH_DIR . '/inc/gallery.php';
require YPGH_DIR . '/inc/listings-extra.php';
require YPGH_DIR . '/inc/helpers.php';
require YPGH_DIR . '/inc/query.php';
require YPGH_DIR . '/inc/schema.php';
require YPGH_DIR . '/inc/leads.php';
require YPGH_DIR . '/inc/cache.php';

/**
 * Enqueue styles and scripts.
 */
function ypgh_assets() {
	// Modern type system: Bricolage Grotesque (display), Inter (UI), DM Mono (data).
	wp_enqueue_style(
		'ypgh-fonts',
		'https://fonts.googleapis.com/css2?family=Bricolage+Grotesque:opsz,wght@12..96,500;12..96,600;12..96,700;12..96,800&family=Inter:wght@400;500;600;700&family=DM+Mono:wght@400;500&display=swap',
		array(),
		null
	);

	wp_enqueue_style( 'ypgh-main', YPGH_URI . '/assets/css/main.css', array(), YPGH_VERSION );
	wp_enqueue_script( 'ypgh-main', YPGH_URI . '/assets/js/main.js', array(), YPGH_VERSION, true );

	// Shared config for AJAX (enquiries) and favorites.
	wp_localize_script(
		'ypgh-main',
		'ypghData',
		array(
			'ajaxUrl' => admin_url( 'admin-ajax.php' ),
			'nonce'   => wp_create_nonce( 'ypgh_lead' ),
		)
	);

	$needs_map = is_singular( array( 'yp_listing', 'yp_location' ) ) || is_post_type_archive( 'yp_listing' );

	if ( $needs_map ) {
		wp_enqueue_style( 'leaflet', 'https://unpkg.com/leaflet@1.9.4/dist/leaflet.css', array(), '1.9.4' );
		wp_enqueue_script( 'leaflet', 'https://unpkg.com/leaflet@1.9.4/dist/leaflet.js', array(), '1.9.4', true );
		wp_enqueue_script( 'ypgh-map', YPGH_URI . '/assets/js/map.js', array( 'leaflet' ), YPGH_VERSION, true );

		// Archive gets a multi-pin dataset.
		if ( is_post_type_archive( 'yp_listing' ) ) {
			wp_localize_script( 'ypgh-map', 'ypghPins', ypgh_archive_pins() );
		}
	}
}
add_action( 'wp_enqueue_scripts', 'ypgh_assets' );

/**
 * Preconnect to font and tile hosts for faster first paint.
 */
function ypgh_resource_hints( $urls, $relation ) {
	if ( 'preconnect' === $relation ) {
		$urls[] = 'https://fonts.googleapis.com';
		$urls[] = array( 'href' => 'https://fonts.gstatic.com', 'crossorigin' );
	}
	return $urls;
}
add_filter( 'wp_resource_hints', 'ypgh_resource_hints', 10, 2 );

/**
 * Build a lightweight pin dataset from the current listing archive query.
 *
 * @return array
 */
function ypgh_archive_pins() {
	global $wp_query;
	$pins = array();

	if ( empty( $wp_query->posts ) ) {
		return $pins;
	}

	foreach ( $wp_query->posts as $p ) {
		$lat = get_post_meta( $p->ID, '_yp_lat', true );
		$lng = get_post_meta( $p->ID, '_yp_lng', true );
		if ( ! $lat || ! $lng ) {
			continue;
		}
		$pins[] = array(
			'lat'   => (float) $lat,
			'lng'   => (float) $lng,
			'title' => get_the_title( $p->ID ),
			'price' => ypgh_price( $p->ID ),
			'url'   => get_permalink( $p->ID ),
		);
	}

	return $pins;
}

/**
 * Flush rewrite rules on activation and seed terms.
 */
function ypgh_activate() {
	ypgh_register_post_types();
	ypgh_register_taxonomies();
	ypgh_seed_terms();
	flush_rewrite_rules();
}
add_action( 'after_switch_theme', 'ypgh_activate' );

/**
 * Excerpt length trim for cards.
 *
 * @param int $length Word count.
 * @return int
 */
function ypgh_excerpt_length( $length ) {
	return 22;
}
add_filter( 'excerpt_length', 'ypgh_excerpt_length' );

/**
 * Excerpt more string.
 *
 * @return string
 */
function ypgh_excerpt_more() {
	return '&hellip;';
}
add_filter( 'excerpt_more', 'ypgh_excerpt_more' );
