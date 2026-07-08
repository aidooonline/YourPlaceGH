<?php
/**
 * Meta boxes for listings and locations.
 *
 * @package ypgh
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Listing meta field definitions.
 *
 * @return array
 */
function ypgh_listing_fields() {
	return array(
		'ref'            => array( 'label' => 'Reference code', 'type' => 'text' ),
		'price'          => array( 'label' => 'Price', 'type' => 'number' ),
		'currency'       => array( 'label' => 'Currency', 'type' => 'text', 'default' => 'GHS' ),
		'rent_period'    => array( 'label' => 'Rent period (rentals only)', 'type' => 'select', 'options' => array( '', 'month', 'year' ) ),
		'rent_advance'   => array( 'label' => 'Rent advance demanded (months)', 'type' => 'number' ),
		'beds'           => array( 'label' => 'Bedrooms', 'type' => 'number' ),
		'baths'          => array( 'label' => 'Bathrooms', 'type' => 'number' ),
		'area'           => array( 'label' => 'Area', 'type' => 'number' ),
		'area_unit'      => array( 'label' => 'Area unit', 'type' => 'select', 'options' => array( 'sqm', 'sqft', 'plots', 'acres' ) ),
		'address'        => array( 'label' => 'Address / area', 'type' => 'text' ),
		'lat'            => array( 'label' => 'Latitude', 'type' => 'text' ),
		'lng'            => array( 'label' => 'Longitude', 'type' => 'text' ),
		'agent_name'     => array( 'label' => 'Agent name', 'type' => 'text' ),
		'agent_phone'    => array( 'label' => 'Agent phone', 'type' => 'text' ),
		'agent_whatsapp' => array( 'label' => 'Agent WhatsApp (with country code)', 'type' => 'text' ),
	);
}

/**
 * Listing trust marker definitions.
 *
 * @return array
 */
function ypgh_trust_fields() {
	return array(
		'title_verified'   => 'Title deed sighted and verified',
		'lands_commission' => 'Registered at Lands Commission',
		'indenture'        => 'Indenture available',
		'site_plan'        => 'Site plan available',
		'litigation_free'  => 'Confirmed free of litigation',
	);
}

/**
 * Location intelligence field definitions (0 to 5 scores).
 *
 * @return array
 */
function ypgh_location_fields() {
	return array(
		'lat'          => array( 'label' => 'Latitude', 'type' => 'text' ),
		'lng'          => array( 'label' => 'Longitude', 'type' => 'text' ),
		'safety'       => array( 'label' => 'Safety score (0 to 5)', 'type' => 'number' ),
		'flood_risk'   => array( 'label' => 'Flood risk (0 low to 5 high)', 'type' => 'number' ),
		'utilities'    => array( 'label' => 'Utilities reliability (0 to 5)', 'type' => 'number' ),
		'road_access'  => array( 'label' => 'Road access (0 to 5)', 'type' => 'number' ),
		'title_risk'   => array( 'label' => 'Land title risk (0 low to 5 high)', 'type' => 'number' ),
		'avg_rent'     => array( 'label' => 'Typical 2-bed rent (GHS / month)', 'type' => 'number' ),
	);
}

/**
 * Register meta boxes.
 */
function ypgh_add_meta_boxes() {
	add_meta_box( 'ypgh_listing_details', __( 'Listing Details', 'ypgh' ), 'ypgh_render_listing_box', 'yp_listing', 'normal', 'high' );
	add_meta_box( 'ypgh_listing_trust', __( 'Trust Safeguards', 'ypgh' ), 'ypgh_render_trust_box', 'yp_listing', 'side', 'default' );
	add_meta_box( 'ypgh_location_intel', __( 'Location Intelligence', 'ypgh' ), 'ypgh_render_location_box', 'yp_location', 'normal', 'high' );
}
add_action( 'add_meta_boxes', 'ypgh_add_meta_boxes' );

/**
 * Render a group of simple fields.
 *
 * @param int    $post_id Post ID.
 * @param array  $fields  Field map.
 * @param string $prefix  Meta prefix.
 */
function ypgh_render_fields( $post_id, $fields, $prefix ) {
	echo '<div class="ypgh-metagrid" style="display:grid;grid-template-columns:1fr 1fr;gap:14px;">';
	foreach ( $fields as $key => $cfg ) {
		$meta_key = '_yp_' . $prefix . $key;
		$value    = get_post_meta( $post_id, $meta_key, true );
		if ( '' === $value && isset( $cfg['default'] ) ) {
			$value = $cfg['default'];
		}
		echo '<p style="margin:0;"><label style="display:block;font-weight:600;margin-bottom:4px;">' . esc_html( $cfg['label'] ) . '</label>';

		if ( 'select' === $cfg['type'] ) {
			echo '<select name="' . esc_attr( $meta_key ) . '" style="width:100%;">';
			foreach ( $cfg['options'] as $opt ) {
				echo '<option value="' . esc_attr( $opt ) . '" ' . selected( $value, $opt, false ) . '>' . esc_html( $opt ? $opt : 'select' ) . '</option>';
			}
			echo '</select>';
		} else {
			$type = 'number' === $cfg['type'] ? 'number' : 'text';
			echo '<input type="' . esc_attr( $type ) . '" name="' . esc_attr( $meta_key ) . '" value="' . esc_attr( $value ) . '" style="width:100%;" step="any" />';
		}
		echo '</p>';
	}
	echo '</div>';
}

/**
 * Listing details box.
 *
 * @param WP_Post $post Post object.
 */
function ypgh_render_listing_box( $post ) {
	wp_nonce_field( 'ypgh_save_meta', 'ypgh_meta_nonce' );
	ypgh_render_fields( $post->ID, ypgh_listing_fields(), '' );
}

/**
 * Trust markers box.
 *
 * @param WP_Post $post Post object.
 */
function ypgh_render_trust_box( $post ) {
	foreach ( ypgh_trust_fields() as $key => $label ) {
		$meta_key = '_yp_trust_' . $key;
		$checked  = checked( get_post_meta( $post->ID, $meta_key, true ), '1', false );
		echo '<p style="margin:0 0 8px;"><label><input type="checkbox" name="' . esc_attr( $meta_key ) . '" value="1" ' . $checked . ' /> ' . esc_html( $label ) . '</label></p>';
	}
}

/**
 * Location intelligence box.
 *
 * @param WP_Post $post Post object.
 */
function ypgh_render_location_box( $post ) {
	ypgh_render_fields( $post->ID, ypgh_location_fields(), 'loc_' );
}

/**
 * Persist meta on save.
 *
 * @param int $post_id Post ID.
 */
function ypgh_save_meta( $post_id ) {
	if ( ! isset( $_POST['ypgh_meta_nonce'] ) || ! wp_verify_nonce( sanitize_key( $_POST['ypgh_meta_nonce'] ), 'ypgh_save_meta' ) ) {
		return;
	}
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}

	$post_type = get_post_type( $post_id );

	if ( 'yp_listing' === $post_type ) {
		foreach ( ypgh_listing_fields() as $key => $cfg ) {
			$meta_key = '_yp_' . $key;
			if ( isset( $_POST[ $meta_key ] ) ) {
				update_post_meta( $post_id, $meta_key, sanitize_text_field( wp_unslash( $_POST[ $meta_key ] ) ) );
			}
		}
		foreach ( ypgh_trust_fields() as $key => $label ) {
			$meta_key = '_yp_trust_' . $key;
			update_post_meta( $post_id, $meta_key, isset( $_POST[ $meta_key ] ) ? '1' : '0' );
		}
	}

	if ( 'yp_location' === $post_type ) {
		foreach ( ypgh_location_fields() as $key => $cfg ) {
			$meta_key = '_yp_loc_' . $key;
			if ( isset( $_POST[ $meta_key ] ) ) {
				update_post_meta( $post_id, $meta_key, sanitize_text_field( wp_unslash( $_POST[ $meta_key ] ) ) );
			}
		}
	}
}
add_action( 'save_post', 'ypgh_save_meta' );
