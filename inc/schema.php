<?php
/**
 * Structured data output.
 *
 * Always emits the differentiators that AIOSEO and friends do not:
 * RealEstateListing (+ Offer) on single listings, FAQPage + ItemList on the
 * homepage. Organization / WebSite / BreadcrumbList are only emitted when no
 * third-party SEO plugin is active, to avoid duplicate graphs.
 *
 * @package YourPlaceGH
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Print one JSON-LD block.
 */
function ypgh_print_jsonld( $data ) {
	if ( empty( $data ) ) {
		return;
	}
	echo "\n" . '<script type="application/ld+json">' . wp_json_encode( $data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE ) . '</script>' . "\n";
}

/**
 * Build the RealEstateListing graph for a property.
 */
function ypgh_listing_schema( $post_id ) {
	$status_term = ypgh_first_term( $post_id, 'property_status' );
	$area_term   = ypgh_first_term( $post_id, 'property_area' );
	$type_term   = ypgh_first_term( $post_id, 'property_type' );

	$price    = ypgh_meta( $post_id, '_ypgh_price', '' );
	$currency = ypgh_meta( $post_id, '_ypgh_currency', 'GHS' );
	$beds     = (int) ypgh_meta( $post_id, '_ypgh_beds', 0 );
	$address  = ypgh_meta( $post_id, '_ypgh_address', '' );
	$lat      = ypgh_meta( $post_id, '_ypgh_lat', '' );
	$lng      = ypgh_meta( $post_id, '_ypgh_lng', '' );

	$desc = has_excerpt( $post_id ) ? get_the_excerpt( $post_id ) : wp_trim_words( wp_strip_all_tags( get_post_field( 'post_content', $post_id ) ), 40 );

	$data = array(
		'@context' => 'https://schema.org',
		'@type'    => 'RealEstateListing',
		'@id'      => get_permalink( $post_id ) . '#listing',
		'name'     => get_the_title( $post_id ),
		'url'      => get_permalink( $post_id ),
		'datePosted' => get_post_time( 'c', true, $post_id ),
	);

	if ( $desc ) {
		$data['description'] = $desc;
	}
	if ( has_post_thumbnail( $post_id ) ) {
		$data['image'] = get_the_post_thumbnail_url( $post_id, 'large' );
	}
	if ( $type_term ) {
		$data['category'] = $type_term->name;
	}
	if ( $beds > 0 ) {
		$data['numberOfBedrooms'] = $beds;
	}

	$address_node = array( '@type' => 'PostalAddress', 'addressRegion' => 'Greater Accra', 'addressCountry' => 'GH' );
	if ( $address ) {
		$address_node['streetAddress'] = $address;
	}
	if ( $area_term ) {
		$address_node['addressLocality'] = $area_term->name;
	} else {
		$address_node['addressLocality'] = 'Accra';
	}
	$data['address'] = $address_node;

	if ( '' !== $lat && '' !== $lng ) {
		$data['geo'] = array(
			'@type'     => 'GeoCoordinates',
			'latitude'  => $lat,
			'longitude' => $lng,
		);
	}

	if ( '' !== $price ) {
		$fn = ( $status_term && false !== stripos( $status_term->slug, 'rent' ) ) ? 'http://purl.org/goodrelations/v1#LeaseOut' : 'http://purl.org/goodrelations/v1#Sell';
		$data['offers'] = array(
			'@type'           => 'Offer',
			'price'           => (float) $price,
			'priceCurrency'   => strtoupper( $currency ),
			'businessFunction'=> $fn,
			'availability'    => 'https://schema.org/InStock',
		);
	}

	return $data;
}

/**
 * Build the breadcrumb for a single listing.
 */
function ypgh_listing_breadcrumb( $post_id ) {
	$items = array(
		array( '@type' => 'ListItem', 'position' => 1, 'name' => 'Home', 'item' => home_url( '/' ) ),
	);
	$archive = get_post_type_archive_link( 'property' );
	if ( $archive ) {
		$items[] = array( '@type' => 'ListItem', 'position' => 2, 'name' => 'Properties', 'item' => $archive );
		$items[] = array( '@type' => 'ListItem', 'position' => 3, 'name' => get_the_title( $post_id ), 'item' => get_permalink( $post_id ) );
	} else {
		$items[] = array( '@type' => 'ListItem', 'position' => 2, 'name' => get_the_title( $post_id ), 'item' => get_permalink( $post_id ) );
	}
	return array(
		'@context'        => 'https://schema.org',
		'@type'           => 'BreadcrumbList',
		'itemListElement' => $items,
	);
}

/**
 * Build the FAQPage graph from the shared FAQ source.
 */
function ypgh_faq_schema() {
	$items  = ypgh_faq_items();
	$entity = array();
	foreach ( $items as $item ) {
		$entity[] = array(
			'@type'          => 'Question',
			'name'           => $item['q'],
			'acceptedAnswer' => array( '@type' => 'Answer', 'text' => $item['a'] ),
		);
	}
	return array(
		'@context'   => 'https://schema.org',
		'@type'      => 'FAQPage',
		'mainEntity' => $entity,
	);
}

/**
 * Build an ItemList of featured listings for the homepage.
 */
function ypgh_featured_itemlist() {
	$q = new WP_Query( array(
		'post_type'      => 'property',
		'posts_per_page' => 8,
		'meta_key'       => '_ypgh_featured',
		'meta_value'     => '1',
		'no_found_rows'  => true,
	) );
	if ( ! $q->have_posts() ) {
		return array();
	}
	$elements = array();
	$i = 0;
	foreach ( $q->posts as $p ) {
		$i++;
		$elements[] = array(
			'@type'    => 'ListItem',
			'position' => $i,
			'url'      => get_permalink( $p ),
			'name'     => get_the_title( $p ),
		);
	}
	wp_reset_postdata();
	return array(
		'@context'        => 'https://schema.org',
		'@type'           => 'ItemList',
		'name'            => 'Featured listings',
		'itemListElement' => $elements,
	);
}

/**
 * Organization + WebSite (only when no SEO plugin owns these).
 */
function ypgh_org_schema() {
	$nap   = ypgh_nap();
	$same  = array_filter( array( $nap['facebook'], $nap['linkedin'] ), function( $u ) { return $u && '#' !== $u; } );
	$org   = array(
		'@context'    => 'https://schema.org',
		'@type'       => 'RealEstateAgent',
		'@id'         => home_url( '/#organization' ),
		'name'        => get_bloginfo( 'name' ),
		'url'         => home_url( '/' ),
		'telephone'   => $nap['phone'],
		'email'       => $nap['email'],
		'address'     => array(
			'@type'          => 'PostalAddress',
			'streetAddress'  => $nap['address'],
			'addressLocality'=> 'Accra',
			'addressRegion'  => 'Greater Accra',
			'addressCountry' => 'GH',
		),
		'areaServed'  => 'Greater Accra, Ghana',
	);
	if ( ! empty( $same ) ) {
		$org['sameAs'] = array_values( $same );
	}
	$logo = function_exists( 'get_custom_logo' ) ? wp_get_attachment_image_url( get_theme_mod( 'custom_logo' ), 'full' ) : '';
	if ( $logo ) {
		$org['logo'] = $logo;
	}
	return $org;
}

/**
 * Emit schema into the head.
 */
function ypgh_output_schema() {
	$plugin = ypgh_seo_plugin_active();

	if ( is_front_page() ) {
		$list = ypgh_featured_itemlist();
		if ( ! empty( $list ) ) {
			ypgh_print_jsonld( $list );
		}
		if ( ! $plugin ) {
			ypgh_print_jsonld( ypgh_org_schema() );
		}
	}

	if ( is_page_template( 'templates/template-diaspora.php' ) ) {
		ypgh_print_jsonld( ypgh_faq_schema() );
	}

	if ( is_singular( 'property' ) ) {
		ypgh_print_jsonld( ypgh_listing_schema( get_the_ID() ) );
		if ( ! $plugin ) {
			ypgh_print_jsonld( ypgh_listing_breadcrumb( get_the_ID() ) );
		}
	}
}
add_action( 'wp_head', 'ypgh_output_schema', 20 );
