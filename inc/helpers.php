<?php
/**
 * Template helpers.
 *
 * @package ypgh
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Get a listing meta value.
 *
 * @param string $key     Field key without prefix.
 * @param int    $post_id Post ID.
 * @return string
 */
function ypgh_meta( $key, $post_id = 0 ) {
	$post_id = $post_id ? $post_id : get_the_ID();
	return get_post_meta( $post_id, '_yp_' . $key, true );
}

/**
 * Get a location intelligence meta value.
 *
 * @param string $key     Field key without prefix.
 * @param int    $post_id Post ID.
 * @return string
 */
function ypgh_loc_meta( $key, $post_id = 0 ) {
	$post_id = $post_id ? $post_id : get_the_ID();
	return get_post_meta( $post_id, '_yp_loc_' . $key, true );
}

/**
 * Format a listing price with currency and rent period.
 *
 * @param int $post_id Post ID.
 * @return string
 */
function ypgh_price( $post_id = 0 ) {
	$post_id  = $post_id ? $post_id : get_the_ID();
	$price    = ypgh_meta( 'price', $post_id );
	$currency = ypgh_meta( 'currency', $post_id );
	$currency = $currency ? $currency : 'GHS';
	$period   = ypgh_meta( 'rent_period', $post_id );

	if ( '' === $price ) {
		return __( 'Price on request', 'ypgh' );
	}

	$out = $currency . ' ' . number_format( (float) $price );
	if ( $period ) {
		$out .= ' / ' . $period;
	}
	return $out;
}

/**
 * Return the trust markers set on a listing.
 *
 * @param int $post_id Post ID.
 * @return array Label list.
 */
function ypgh_active_trust( $post_id = 0 ) {
	$post_id = $post_id ? $post_id : get_the_ID();
	$out     = array();
	foreach ( ypgh_trust_fields() as $key => $label ) {
		if ( '1' === get_post_meta( $post_id, '_yp_trust_' . $key, true ) ) {
			$out[] = $label;
		}
	}
	return $out;
}

/**
 * Rent advance advisory. Ghana law caps residential advance at 6 months.
 *
 * @param int $post_id Post ID.
 * @return string Advisory HTML or empty.
 */
function ypgh_rent_advance_notice( $post_id = 0 ) {
	$post_id = $post_id ? $post_id : get_the_ID();
	$months  = (int) ypgh_meta( 'rent_advance', $post_id );

	if ( $months <= 0 ) {
		return '';
	}

	if ( $months > 6 ) {
		return sprintf(
			/* translators: %d: number of months demanded. */
			esc_html__( 'This listing asks for %d months advance. Ghana Rent Act 1963 (Act 220) caps residential advance at 6 months. Amounts beyond that are not enforceable in law. Negotiate or request a receipt.', 'ypgh' ),
			$months
		);
	}

	return sprintf(
		/* translators: %d: number of months demanded. */
		esc_html__( 'Advance of %d months requested, within the 6-month legal limit.', 'ypgh' ),
		$months
	);
}

/**
 * Build a WhatsApp click-to-chat link for a listing.
 *
 * @param int $post_id Post ID.
 * @return string URL or empty.
 */
function ypgh_whatsapp_link( $post_id = 0 ) {
	$post_id = $post_id ? $post_id : get_the_ID();
	$number  = preg_replace( '/\D/', '', ypgh_meta( 'agent_whatsapp', $post_id ) );
	if ( ! $number ) {
		return '';
	}
	$text = rawurlencode( sprintf( 'Hello, I am interested in %s (%s)', get_the_title( $post_id ), get_permalink( $post_id ) ) );
	return 'https://wa.me/' . $number . '?text=' . $text;
}

/**
 * Render a compact stat row (beds, baths, area) with icons.
 *
 * @param int $post_id Post ID.
 */
function ypgh_stat_row( $post_id = 0 ) {
	$post_id = $post_id ? $post_id : get_the_ID();
	$beds    = ypgh_meta( 'beds', $post_id );
	$baths   = ypgh_meta( 'baths', $post_id );
	$area    = ypgh_meta( 'area', $post_id );
	$unit    = ypgh_meta( 'area_unit', $post_id );

	$icon_bed  = '<svg viewBox="0 0 24 24" aria-hidden="true"><path d="M2 17v-5a2 2 0 012-2h16a2 2 0 012 2v5"/><path d="M2 17h20M4 12V8a2 2 0 012-2h4a2 2 0 012 2v4M12 12V8a2 2 0 012-2h4a2 2 0 012 2v4"/></svg>';
	$icon_bath = '<svg viewBox="0 0 24 24" aria-hidden="true"><path d="M4 12V6a2 2 0 012-2 2 2 0 012 2M2 12h20v2a5 5 0 01-5 5H7a5 5 0 01-5-5v-2z"/></svg>';
	$icon_area = '<svg viewBox="0 0 24 24" aria-hidden="true"><rect x="3" y="3" width="18" height="18" rx="2"/><path d="M9 3v18M3 9h18"/></svg>';

	$parts = array();
	if ( '' !== $beds && '0' !== (string) $beds ) {
		$parts[] = '<span class="stat">' . $icon_bed . '<strong>' . esc_html( $beds ) . '</strong> ' . esc_html__( 'beds', 'ypgh' ) . '</span>';
	}
	if ( '' !== $baths && '0' !== (string) $baths ) {
		$parts[] = '<span class="stat">' . $icon_bath . '<strong>' . esc_html( $baths ) . '</strong> ' . esc_html__( 'baths', 'ypgh' ) . '</span>';
	}
	if ( '' !== $area ) {
		$parts[] = '<span class="stat">' . $icon_area . '<strong>' . esc_html( $area ) . '</strong> ' . esc_html( $unit ? $unit : 'sqm' ) . '</span>';
	}

	if ( $parts ) {
		echo '<div class="listing-stats">' . implode( '', $parts ) . '</div>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}
}

/**
 * Render a circular intelligence ring for a 0 to 5 score.
 *
 * @param string $label     Human label.
 * @param string $value     Score 0 to 5.
 * @param bool   $is_risk   If true, higher is worse (uses warn colour).
 */
function ypgh_intel_ring( $label, $value, $is_risk = false ) {
	if ( '' === $value ) {
		return;
	}
	$val   = max( 0, min( 5, (float) $value ) );
	$pct   = $val / 5;
	$r     = 30;
	$circ  = 2 * M_PI * $r;
	$offset = $circ * ( 1 - $pct );
	$cls   = $is_risk ? 'intel-ring is-risk' : 'intel-ring';
	?>
	<div class="<?php echo esc_attr( $cls ); ?>">
		<svg viewBox="0 0 78 78" role="img" aria-label="<?php echo esc_attr( $label . ': ' . $val . ' out of 5' ); ?>">
			<circle class="ring-track" cx="39" cy="39" r="<?php echo esc_attr( $r ); ?>" fill="none" stroke-width="7"></circle>
			<circle class="ring-fill" cx="39" cy="39" r="<?php echo esc_attr( $r ); ?>" fill="none" stroke-width="7"
				stroke-dasharray="<?php echo esc_attr( $circ ); ?>"
				stroke-dashoffset="<?php echo esc_attr( $offset ); ?>"></circle>
			<text class="ring-num" x="39" y="44" text-anchor="middle"><?php echo esc_html( rtrim( rtrim( number_format( $val, 1 ), '0' ), '.' ) ); ?></text>
		</svg>
		<span class="ring-label"><?php echo esc_html( $label ); ?></span>
	</div>
	<?php
}

/**
 * Contextual header (eyebrow, title, intro) for listing archive and taxonomy views.
 * Works for the post type archive, taxonomy term archives, and query-var filters.
 *
 * @return array
 */
function ypgh_archive_context() {
	$ctx = array(
		'eyebrow' => __( 'Browse the market', 'ypgh' ),
		'title'   => __( 'Listings', 'ypgh' ),
		'intro'   => __( 'Every listing is checked before it goes live. Filter by type, area, price, or verified status.', 'ypgh' ),
	);

	$status = is_tax( 'yp_status' ) ? get_queried_object()->slug : (string) get_query_var( 'yp_status' );
	$ptype  = is_tax( 'yp_ptype' ) ? get_queried_object()->slug : (string) get_query_var( 'yp_ptype' );
	$city   = is_tax( 'yp_city' ) ? get_queried_object()->slug : (string) get_query_var( 'yp_city' );

	if ( $status ) {
		$map = array(
			'for-sale'  => array( __( 'For sale', 'ypgh' ), __( 'Property for sale in Ghana', 'ypgh' ), __( 'Homes, apartments, and land for sale, each with the title sighted before it reaches you.', 'ypgh' ) ),
			'for-rent'  => array( __( 'For rent', 'ypgh' ), __( 'Property for rent in Ghana', 'ypgh' ), __( 'Rentals with the six month legal advance cap flagged, so you are never quietly overcharged.', 'ypgh' ) ),
			'short-let' => array( __( 'Short let', 'ypgh' ), __( 'Short let property in Ghana', 'ypgh' ), __( 'Furnished, serviced places for short stays, ready to move into.', 'ypgh' ) ),
		);
		if ( isset( $map[ $status ] ) ) {
			$ctx['eyebrow'] = $map[ $status ][0];
			$ctx['title']   = $map[ $status ][1];
			$ctx['intro']   = $map[ $status ][2];
		}
	} elseif ( $ptype ) {
		if ( 'land' === $ptype ) {
			$ctx['eyebrow'] = __( 'Land', 'ypgh' );
			$ctx['title']   = __( 'Land for sale in Ghana', 'ypgh' );
			$ctx['intro']   = __( 'Registered plots with documentation checked, title sighted, and litigation and land guard risk flagged before you pay.', 'ypgh' );
		} else {
			$term           = get_term_by( 'slug', $ptype, 'yp_ptype' );
			$name           = $term ? $term->name : ucfirst( $ptype );
			$ctx['eyebrow'] = $name;
			/* translators: %s: property type name. */
			$ctx['title']   = sprintf( __( '%s in Ghana', 'ypgh' ), $name );
			$ctx['intro']   = __( 'Verified listings, filtered to this property type.', 'ypgh' );
		}
	} elseif ( $city ) {
		$term           = get_term_by( 'slug', $city, 'yp_city' );
		$name           = $term ? $term->name : ucfirst( str_replace( '-', ' ', $city ) );
		$ctx['eyebrow'] = __( 'Location', 'ypgh' );
		/* translators: %s: city or area name. */
		$ctx['title']   = sprintf( __( 'Property in %s', 'ypgh' ), $name );
		$ctx['intro']   = __( 'Homes, apartments, and land in this area, each verified before listing.', 'ypgh' );
	}

	return $ctx;
}
