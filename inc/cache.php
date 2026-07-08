<?php
/**
 * Lightweight transient caching for repeated front-end queries.
 *
 * @package ypgh
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Get cached post IDs for a query, or run and cache it.
 *
 * @param string $key  Cache key suffix.
 * @param array  $args WP_Query args.
 * @param int    $ttl  Seconds to cache.
 * @return int[] Post IDs.
 */
function ypgh_cached_ids( $key, $args, $ttl = HOUR_IN_SECONDS ) {
	$cache_key = 'ypgh_q_' . $key;
	$ids       = get_transient( $cache_key );

	if ( false === $ids ) {
		$args['fields']         = 'ids';
		$args['no_found_rows']  = true;
		$q                      = new WP_Query( $args );
		$ids                    = $q->posts;
		set_transient( $cache_key, $ids, $ttl );
	}

	return is_array( $ids ) ? $ids : array();
}

/**
 * Flush cached homepage queries when listings or locations change.
 *
 * @param int $post_id Post ID.
 */
function ypgh_flush_query_cache( $post_id ) {
	$type = get_post_type( $post_id );
	if ( in_array( $type, array( 'yp_listing', 'yp_location' ), true ) ) {
		delete_transient( 'ypgh_q_home_listings' );
		delete_transient( 'ypgh_q_home_locations' );
	}
}
add_action( 'save_post', 'ypgh_flush_query_cache' );
add_action( 'trashed_post', 'ypgh_flush_query_cache' );
add_action( 'untrashed_post', 'ypgh_flush_query_cache' );
