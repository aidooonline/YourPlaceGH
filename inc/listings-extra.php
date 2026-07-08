<?php
/**
 * Auto reference codes and related listings.
 *
 * @package ypgh
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Assign a reference code when a listing is first published without one.
 *
 * @param int     $post_id Post ID.
 * @param WP_Post $post    Post object.
 */
function ypgh_assign_reference( $post_id, $post ) {
	if ( 'yp_listing' !== $post->post_type ) {
		return;
	}
	if ( wp_is_post_revision( $post_id ) || wp_is_post_autosave( $post_id ) ) {
		return;
	}
	if ( get_post_meta( $post_id, '_yp_ref', true ) ) {
		return;
	}
	$ref = 'YP-' . str_pad( (string) $post_id, 5, '0', STR_PAD_LEFT );
	update_post_meta( $post_id, '_yp_ref', $ref );
}
add_action( 'save_post_yp_listing', 'ypgh_assign_reference', 20, 2 );

/**
 * Query related listings by shared city, then property type.
 *
 * @param int $post_id Post ID.
 * @param int $limit   Max results.
 * @return WP_Query
 */
function ypgh_related_listings( $post_id, $limit = 3 ) {
	$tax_query = array( 'relation' => 'OR' );

	foreach ( array( 'yp_city', 'yp_ptype' ) as $tax ) {
		$terms = wp_get_post_terms( $post_id, $tax, array( 'fields' => 'ids' ) );
		if ( ! is_wp_error( $terms ) && $terms ) {
			$tax_query[] = array(
				'taxonomy' => $tax,
				'field'    => 'term_id',
				'terms'    => $terms,
			);
		}
	}

	$args = array(
		'post_type'           => 'yp_listing',
		'posts_per_page'      => $limit,
		'post__not_in'        => array( $post_id ),
		'ignore_sticky_posts' => true,
		'no_found_rows'       => true,
	);

	if ( count( $tax_query ) > 1 ) {
		$args['tax_query'] = $tax_query; // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_tax_query
	}

	return new WP_Query( $args );
}

/**
 * Render amenities list for a listing.
 *
 * @param int $post_id Post ID.
 */
function ypgh_render_amenities( $post_id = 0 ) {
	$post_id  = $post_id ? $post_id : get_the_ID();
	$amenities = get_the_terms( $post_id, 'yp_amenity' );
	if ( ! $amenities || is_wp_error( $amenities ) ) {
		return;
	}
	echo '<ul class="amenity-list">';
	foreach ( $amenities as $a ) {
		echo '<li>' . esc_html( $a->name ) . '</li>';
	}
	echo '</ul>';
}
