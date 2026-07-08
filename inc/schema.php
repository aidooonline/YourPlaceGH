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
		$graph[] = ypgh_listing_schema( get_queried_object_id() );
	}

	if ( is_singular( 'yp_location' ) ) {
		$graph[] = ypgh_location_schema( get_queried_object_id() );
		$faq     = ypgh_location_faq_schema( get_queried_object_id() );
		if ( $faq ) {
			$graph[] = $faq;
		}
	}

	// Breadcrumb trail on singular listing and location views.
	if ( is_singular( array( 'yp_listing', 'yp_location' ) ) ) {
		$graph[] = ypgh_breadcrumb_schema( get_queried_object_id() );
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

/**
 * Build a FAQPage node from location intelligence, if data exists.
 * These entity-linked answers are what AI search engines lift as citations.
 *
 * @param int $post_id Post ID.
 * @return array|null
 */
function ypgh_location_faq_schema( $post_id ) {
	$name = get_the_title( $post_id );
	$qa   = array();

	$safety = ypgh_loc_meta( 'safety', $post_id );
	if ( '' !== $safety ) {
		$qa[] = array(
			sprintf( 'Is %s a safe area to live in?', $name ),
			sprintf( '%s scores %s out of 5 on our safety index, based on local reporting and resident feedback.', $name, $safety ),
		);
	}

	$flood = ypgh_loc_meta( 'flood_risk', $post_id );
	if ( '' !== $flood ) {
		$qa[] = array(
			sprintf( 'Does %s flood?', $name ),
			sprintf( '%s carries a flood risk rating of %s out of 5, where 5 is the highest exposure. Check drainage and elevation before committing.', $name, $flood ),
		);
	}

	$title_risk = ypgh_loc_meta( 'title_risk', $post_id );
	if ( '' !== $title_risk ) {
		$qa[] = array(
			sprintf( 'Are land titles secure in %s?', $name ),
			sprintf( 'Land title risk in %s rates %s out of 5. Always confirm Lands Commission registration and run a title search before any purchase.', $name, $title_risk ),
		);
	}

	$rent = ypgh_loc_meta( 'avg_rent', $post_id );
	if ( '' !== $rent ) {
		$qa[] = array(
			sprintf( 'How much is rent in %s?', $name ),
			sprintf( 'A typical two-bedroom in %s rents around GHS %s per month. Landlords may still ask for advance, capped at 6 months by law.', $name, number_format( (float) $rent ) ),
		);
	}

	if ( empty( $qa ) ) {
		return null;
	}

	$entities = array();
	foreach ( $qa as $pair ) {
		$entities[] = array(
			'@type'          => 'Question',
			'name'           => $pair[0],
			'acceptedAnswer' => array(
				'@type' => 'Answer',
				'text'  => $pair[1],
			),
		);
	}

	return array(
		'@type'      => 'FAQPage',
		'@id'        => get_permalink( $post_id ) . '#faq',
		'mainEntity' => $entities,
	);
}

/**
 * Build a BreadcrumbList node.
 *
 * @param int $post_id Post ID.
 * @return array
 */
function ypgh_breadcrumb_schema( $post_id ) {
	$type    = get_post_type( $post_id );
	$archive = 'yp_location' === $type
		? array( __( 'Neighborhoods', 'ypgh' ), get_post_type_archive_link( 'yp_location' ) )
		: array( __( 'Listings', 'ypgh' ), get_post_type_archive_link( 'yp_listing' ) );

	$items = array(
		array( __( 'Home', 'ypgh' ), home_url( '/' ) ),
		array( $archive[0], $archive[1] ),
		array( get_the_title( $post_id ), get_permalink( $post_id ) ),
	);

	$elements = array();
	foreach ( $items as $i => $item ) {
		$elements[] = array(
			'@type'    => 'ListItem',
			'position' => $i + 1,
			'name'     => $item[0],
			'item'     => $item[1],
		);
	}

	return array(
		'@type'           => 'BreadcrumbList',
		'itemListElement' => $elements,
	);
}

/**
 * Output Open Graph and meta description tags.
 */
function ypgh_meta_tags() {
	$desc  = '';
	$image = '';
	$type  = 'website';

	if ( is_singular( array( 'yp_listing', 'yp_location' ) ) ) {
		$id   = get_queried_object_id();
		$desc = wp_strip_all_tags( get_the_excerpt( $id ) );
		$type = 'article';
		if ( has_post_thumbnail( $id ) ) {
			$image = get_the_post_thumbnail_url( $id, 'ypgh_hero' );
		}
	} elseif ( is_front_page() ) {
		$desc = __( 'Verified property and land across Ghana, with title checks, location intelligence, and plain rent advance guidance.', 'ypgh' );
	}

	if ( ! $desc ) {
		return;
	}

	$title = wp_get_document_title();
	$url   = is_singular() ? get_permalink( get_queried_object_id() ) : home_url( add_query_arg( array() ) );

	echo "\n";
	printf( '<meta name="description" content="%s">' . "\n", esc_attr( $desc ) );
	printf( '<meta property="og:type" content="%s">' . "\n", esc_attr( $type ) );
	printf( '<meta property="og:title" content="%s">' . "\n", esc_attr( $title ) );
	printf( '<meta property="og:description" content="%s">' . "\n", esc_attr( $desc ) );
	printf( '<meta property="og:url" content="%s">' . "\n", esc_url( $url ) );
	printf( '<meta property="og:site_name" content="%s">' . "\n", esc_attr( 'YourPlaceGH' ) );
	if ( $image ) {
		printf( '<meta property="og:image" content="%s">' . "\n", esc_url( $image ) );
		echo '<meta name="twitter:card" content="summary_large_image">' . "\n";
	}
}
add_action( 'wp_head', 'ypgh_meta_tags', 5 );
