<?php
/**
 * JSON-LD schema layer for GEO and AI-search visibility.
 *
 * @package ypgh
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Print schema graph in the head.
 */
function ypgh_output_schema() {
	$graph = array();

	// Organization on every page.
	$graph[] = array(
		'@type'    => 'RealEstateAgent',
		'@id'      => home_url( '/#organization' ),
		'name'     => 'YourPlaceGH',
		'url'      => home_url( '/' ),
		'telephone'=> '+233539601097',
		'email'    => 'info@yourplacegh.com',
		'address'  => array(
			'@type'          => 'PostalAddress',
			'streetAddress'  => 'HN 7, Nii Adjei Nkroma Street, Manet, Teshie',
			'addressLocality'=> 'Accra',
			'addressCountry' => 'GH',
		),
		'areaServed' => array( '@type' => 'Country', 'name' => 'Ghana' ),
	);

	if ( is_singular( 'yp_listing' ) ) {
		$graph[] = ypgh_listing_schema( get_the_ID() );
	}

	if ( is_singular( 'yp_location' ) ) {
		$graph[] = ypgh_location_schema( get_the_ID() );
	}

	if ( empty( $graph ) ) {
		return;
	}

	$data = array(
		'@context' => 'https://schema.org',
		'@graph'   => $graph,
	);

	echo "\n" . '<script type="application/ld+json">' . wp_json_encode( $data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE ) . '</script>' . "\n";
}
add_action( 'wp_head', 'ypgh_output_schema', 20 );

/**
 * Build listing schema. Uses Residence with an Offer.
 *
 * @param int $post_id Post ID.
 * @return array
 */
function ypgh_listing_schema( $post_id ) {
	$currency = ypgh_meta( 'currency', $post_id );
	$currency = $currency ? $currency : 'GHS';
	$price    = ypgh_meta( 'price', $post_id );

	$node = array(
		'@type'       => 'Residence',
		'@id'         => get_permalink( $post_id ) . '#listing',
		'name'        => get_the_title( $post_id ),
		'description' => wp_strip_all_tags( get_the_excerpt( $post_id ) ),
		'url'         => get_permalink( $post_id ),
	);

	if ( has_post_thumbnail( $post_id ) ) {
		$node['image'] = get_the_post_thumbnail_url( $post_id, 'large' );
	}

	$address = ypgh_meta( 'address', $post_id );
	if ( $address ) {
		$node['address'] = array(
			'@type'          => 'PostalAddress',
			'streetAddress'  => $address,
			'addressCountry' => 'GH',
		);
	}

	$lat = ypgh_meta( 'lat', $post_id );
	$lng = ypgh_meta( 'lng', $post_id );
	if ( $lat && $lng ) {
		$node['geo'] = array(
			'@type'     => 'GeoCoordinates',
			'latitude'  => (float) $lat,
			'longitude' => (float) $lng,
		);
	}

	$beds = ypgh_meta( 'beds', $post_id );
	if ( '' !== $beds ) {
		$node['numberOfRooms'] = (int) $beds;
	}

	$area = ypgh_meta( 'area', $post_id );
	if ( '' !== $area ) {
		$node['floorSize'] = array(
			'@type'    => 'QuantitativeValue',
			'value'    => (float) $area,
			'unitText' => ypgh_meta( 'area_unit', $post_id ) ? ypgh_meta( 'area_unit', $post_id ) : 'sqm',
		);
	}

	if ( '' !== $price ) {
		$node['offers'] = array(
			'@type'         => 'Offer',
			'price'         => (float) $price,
			'priceCurrency' => $currency,
			'availability'  => 'https://schema.org/InStock',
		);
	}

	return $node;
}

/**
 * Build location (neighborhood) schema as a Place.
 *
 * @param int $post_id Post ID.
 * @return array
 */
function ypgh_location_schema( $post_id ) {
	$node = array(
		'@type'       => 'Place',
		'@id'         => get_permalink( $post_id ) . '#place',
		'name'        => get_the_title( $post_id ),
		'description' => wp_strip_all_tags( get_the_excerpt( $post_id ) ),
		'url'         => get_permalink( $post_id ),
	);

	$lat = ypgh_loc_meta( 'lat', $post_id );
	$lng = ypgh_loc_meta( 'lng', $post_id );
	if ( $lat && $lng ) {
		$node['geo'] = array(
			'@type'     => 'GeoCoordinates',
			'latitude'  => (float) $lat,
			'longitude' => (float) $lng,
		);
	}

	if ( has_post_thumbnail( $post_id ) ) {
		$node['image'] = get_the_post_thumbnail_url( $post_id, 'large' );
	}

	return $node;
}
