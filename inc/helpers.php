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
 * Render a compact stat row (beds, baths, area) for a listing.
 *
 * @param int $post_id Post ID.
 */
function ypgh_stat_row( $post_id = 0 ) {
	$post_id = $post_id ? $post_id : get_the_ID();
	$beds    = ypgh_meta( 'beds', $post_id );
	$baths   = ypgh_meta( 'baths', $post_id );
	$area    = ypgh_meta( 'area', $post_id );
	$unit    = ypgh_meta( 'area_unit', $post_id );

	$parts = array();
	if ( '' !== $beds ) {
		$parts[] = '<span class="stat"><strong>' . esc_html( $beds ) . '</strong> ' . esc_html__( 'beds', 'ypgh' ) . '</span>';
	}
	if ( '' !== $baths ) {
		$parts[] = '<span class="stat"><strong>' . esc_html( $baths ) . '</strong> ' . esc_html__( 'baths', 'ypgh' ) . '</span>';
	}
	if ( '' !== $area ) {
		$parts[] = '<span class="stat"><strong>' . esc_html( $area ) . '</strong> ' . esc_html( $unit ? $unit : 'sqm' ) . '</span>';
	}

	if ( $parts ) {
		echo '<div class="listing-stats">' . implode( '', $parts ) . '</div>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}
}
