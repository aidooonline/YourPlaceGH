<?php
/**
 * YourPlaceGH theme bootstrap.
 *
 * @package ypgh
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'YPGH_VERSION', '2.0.0' );
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
require YPGH_DIR . '/inc/helpers.php';
require YPGH_DIR . '/inc/query.php';
require YPGH_DIR . '/inc/schema.php';

/**
 * Enqueue styles and scripts.
 */
function ypgh_assets() {
	// Fonts: Fraunces (display) + DM Sans (body).
	wp_enqueue_style(
		'ypgh-fonts',
		'https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,400;9..144,600;9..144,700&family=DM+Sans:wght@400;500;600;700&display=swap',
		array(),
		null
	);

	wp_enqueue_style( 'ypgh-main', YPGH_URI . '/assets/css/main.css', array(), YPGH_VERSION );
	wp_enqueue_script( 'ypgh-main', YPGH_URI . '/assets/js/main.js', array(), YPGH_VERSION, true );

	// Leaflet only where a map is needed.
	if ( is_singular( array( 'yp_listing', 'yp_location' ) ) || is_post_type_archive( 'yp_listing' ) ) {
		wp_enqueue_style( 'leaflet', 'https://unpkg.com/leaflet@1.9.4/dist/leaflet.css', array(), '1.9.4' );
		wp_enqueue_script( 'leaflet', 'https://unpkg.com/leaflet@1.9.4/dist/leaflet.js', array(), '1.9.4', true );
		wp_enqueue_script( 'ypgh-map', YPGH_URI . '/assets/js/map.js', array( 'leaflet' ), YPGH_VERSION, true );
	}
}
add_action( 'wp_enqueue_scripts', 'ypgh_assets' );

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
