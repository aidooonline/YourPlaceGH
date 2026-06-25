<?php
/**
 * YourPlaceGH theme functions.
 *
 * @package YourPlaceGH
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'YPGH_VERSION', '2.0.0' );
define( 'YPGH_DIR', get_template_directory() );
define( 'YPGH_URI', get_template_directory_uri() );

if ( ! isset( $content_width ) ) {
	$content_width = 1200;
}

/**
 * Theme supports and menus.
 */
function ypgh_setup() {
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'custom-logo', array(
		'height'      => 64,
		'width'       => 240,
		'flex-height' => true,
		'flex-width'  => true,
	) );
	add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script' ) );

	register_nav_menus( array(
		'primary'         => __( 'Primary Menu', 'yourplacegh' ),
		'footer-company'  => __( 'Footer: Company', 'yourplacegh' ),
		'footer-services' => __( 'Footer: Services', 'yourplacegh' ),
	) );

	add_image_size( 'ypgh-card', 700, 525, true );
}
add_action( 'after_setup_theme', 'ypgh_setup' );

/**
 * Front-end assets.
 */
function ypgh_assets() {
	wp_enqueue_style(
		'ypgh-fonts',
		'https://fonts.googleapis.com/css2?family=Bricolage+Grotesque:wght@400;500;600;700;800&display=swap',
		array(),
		null
	);

	wp_enqueue_style(
		'ypgh-style',
		get_stylesheet_uri(),
		array( 'ypgh-fonts' ),
		YPGH_VERSION
	);

	wp_enqueue_script(
		'ypgh-main',
		YPGH_URI . '/assets/js/main.js',
		array(),
		YPGH_VERSION,
		true
	);
}
add_action( 'wp_enqueue_scripts', 'ypgh_assets' );

/**
 * Body classes used by the header logic.
 */
function ypgh_body_class( $classes ) {
	if ( is_front_page() ) {
		$classes[] = 'ypgh-front';
	} else {
		$classes[] = 'ypgh-inner';
	}
	return $classes;
}
add_filter( 'body_class', 'ypgh_body_class' );

/**
 * Hide the WordPress admin bar on the front end (it still shows in wp-admin).
 */
add_filter( 'show_admin_bar', '__return_false' );

require YPGH_DIR . '/inc/helpers.php';
require YPGH_DIR . '/inc/cpt.php';
require YPGH_DIR . '/inc/meta.php';
require YPGH_DIR . '/inc/faq-data.php';
require YPGH_DIR . '/inc/schema.php';
require YPGH_DIR . '/inc/seeder.php';
