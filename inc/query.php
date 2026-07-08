<?php
/**
 * Search and filter query handling.
 *
 * @package ypgh
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register public query vars used by the filter bar.
 *
 * @param array $vars Query vars.
 * @return array
 */
function ypgh_query_vars( $vars ) {
	$vars[] = 'min_price';
	$vars[] = 'max_price';
	$vars[] = 'min_beds';
	$vars[] = 'verified';
	return $vars;
}
add_filter( 'query_vars', 'ypgh_query_vars' );

/**
 * Apply filters to the listing archive query.
 *
 * @param WP_Query $query Query object.
 */
function ypgh_filter_listings( $query ) {
	if ( is_admin() || ! $query->is_main_query() ) {
		return;
	}

	$is_listing_archive = $query->is_post_type_archive( 'yp_listing' )
		|| $query->is_tax( array( 'yp_status', 'yp_ptype', 'yp_city' ) );

	if ( ! $is_listing_archive ) {
		return;
	}

	$meta_query = array( 'relation' => 'AND' );

	$min_price = get_query_var( 'min_price' );
	$max_price = get_query_var( 'max_price' );

	if ( '' !== $min_price && is_numeric( $min_price ) ) {
		$meta_query[] = array(
			'key'     => '_yp_price',
			'value'   => (int) $min_price,
			'type'    => 'NUMERIC',
			'compare' => '>=',
		);
	}
	if ( '' !== $max_price && is_numeric( $max_price ) ) {
		$meta_query[] = array(
			'key'     => '_yp_price',
			'value'   => (int) $max_price,
			'type'    => 'NUMERIC',
			'compare' => '<=',
		);
	}

	$min_beds = get_query_var( 'min_beds' );
	if ( '' !== $min_beds && is_numeric( $min_beds ) ) {
		$meta_query[] = array(
			'key'     => '_yp_beds',
			'value'   => (int) $min_beds,
			'type'    => 'NUMERIC',
			'compare' => '>=',
		);
	}

	if ( '1' === (string) get_query_var( 'verified' ) ) {
		$meta_query[] = array(
			'key'     => '_yp_trust_title_verified',
			'value'   => '1',
			'compare' => '=',
		);
	}

	if ( count( $meta_query ) > 1 ) {
		$query->set( 'meta_query', $meta_query );
	}

	// Order by price when sorting is requested.
	$orderby = isset( $_GET['sort'] ) ? sanitize_key( wp_unslash( $_GET['sort'] ) ) : ''; // phpcs:ignore WordPress.Security.NonceVerification.Recommended
	if ( 'price_asc' === $orderby || 'price_desc' === $orderby ) {
		$query->set( 'meta_key', '_yp_price' );
		$query->set( 'orderby', 'meta_value_num' );
		$query->set( 'order', 'price_asc' === $orderby ? 'ASC' : 'DESC' );
	}
}
add_action( 'pre_get_posts', 'ypgh_filter_listings' );
