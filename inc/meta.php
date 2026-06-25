<?php
/**
 * Native meta boxes (no ACF) for property listings, plus area term fields.
 *
 * @package YourPlaceGH
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register the listing details meta box.
 */
function ypgh_add_meta_boxes() {
	add_meta_box( 'ypgh_details', __( 'Listing Details', 'yourplacegh' ), 'ypgh_details_box', 'property', 'normal', 'high' );
}
add_action( 'add_meta_boxes', 'ypgh_add_meta_boxes' );

/**
 * Render the meta box.
 */
function ypgh_details_box( $post ) {
	wp_nonce_field( 'ypgh_save_details', 'ypgh_details_nonce' );

	$price    = ypgh_meta( $post->ID, '_ypgh_price', '' );
	$currency = ypgh_meta( $post->ID, '_ypgh_currency', 'GHS' );
	$period   = ypgh_meta( $post->ID, '_ypgh_period', '' );
	$beds     = ypgh_meta( $post->ID, '_ypgh_beds', '' );
	$baths    = ypgh_meta( $post->ID, '_ypgh_baths', '' );
	$size     = ypgh_meta( $post->ID, '_ypgh_size', '' );
	$address  = ypgh_meta( $post->ID, '_ypgh_address', '' );
	$lat      = ypgh_meta( $post->ID, '_ypgh_lat', '' );
	$lng      = ypgh_meta( $post->ID, '_ypgh_lng', '' );
	$featured = ypgh_meta( $post->ID, '_ypgh_featured', '' );

	$row = 'margin:0 0 14px;display:flex;flex-direction:column;gap:4px;max-width:420px';
	echo '<style>.ypgh-grid{display:grid;grid-template-columns:1fr 1fr;gap:18px;max-width:760px}.ypgh-grid label{font-weight:600}.ypgh-grid input,.ypgh-grid select{padding:7px 10px}</style>';
	echo '<div class="ypgh-grid">';

	printf( '<p style="%s"><label>Price</label><input type="number" step="any" name="_ypgh_price" value="%s"></p>', esc_attr( $row ), esc_attr( $price ) );

	echo '<p style="' . esc_attr( $row ) . '"><label>Currency</label><select name="_ypgh_currency">';
	foreach ( array( 'GHS', 'USD', 'EUR', 'GBP' ) as $c ) {
		printf( '<option value="%s" %s>%s</option>', esc_attr( $c ), selected( $currency, $c, false ), esc_html( $c ) );
	}
	echo '</select></p>';

	printf( '<p style="%s"><label>Price period (blank for sale, e.g. month)</label><input type="text" name="_ypgh_period" value="%s"></p>', esc_attr( $row ), esc_attr( $period ) );
	printf( '<p style="%s"><label>Size label (e.g. 320 m&sup2; or 1 acre)</label><input type="text" name="_ypgh_size" value="%s"></p>', esc_attr( $row ), esc_attr( $size ) );
	printf( '<p style="%s"><label>Bedrooms</label><input type="number" name="_ypgh_beds" value="%s"></p>', esc_attr( $row ), esc_attr( $beds ) );
	printf( '<p style="%s"><label>Bathrooms</label><input type="number" name="_ypgh_baths" value="%s"></p>', esc_attr( $row ), esc_attr( $baths ) );
	printf( '<p style="%s"><label>Street address</label><input type="text" name="_ypgh_address" value="%s"></p>', esc_attr( $row ), esc_attr( $address ) );
	printf( '<p style="%s"><label>Latitude</label><input type="text" name="_ypgh_lat" value="%s"></p>', esc_attr( $row ), esc_attr( $lat ) );
	printf( '<p style="%s"><label>Longitude</label><input type="text" name="_ypgh_lng" value="%s"></p>', esc_attr( $row ), esc_attr( $lng ) );

	echo '</div>';
	printf(
		'<p style="margin-top:14px"><label><input type="checkbox" name="_ypgh_featured" value="1" %s> Show in homepage Featured Listings</label></p>',
		checked( $featured, '1', false )
	);
}

/**
 * Save the meta box.
 */
function ypgh_save_details( $post_id ) {
	if ( ! isset( $_POST['ypgh_details_nonce'] ) || ! wp_verify_nonce( $_POST['ypgh_details_nonce'], 'ypgh_save_details' ) ) {
		return;
	}
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}

	$text_keys = array( '_ypgh_currency', '_ypgh_period', '_ypgh_size', '_ypgh_address', '_ypgh_lat', '_ypgh_lng' );
	foreach ( $text_keys as $k ) {
		if ( isset( $_POST[ $k ] ) ) {
			update_post_meta( $post_id, $k, sanitize_text_field( wp_unslash( $_POST[ $k ] ) ) );
		}
	}

	$num_keys = array( '_ypgh_price', '_ypgh_beds', '_ypgh_baths' );
	foreach ( $num_keys as $k ) {
		if ( isset( $_POST[ $k ] ) && '' !== $_POST[ $k ] ) {
			update_post_meta( $post_id, $k, preg_replace( '/[^0-9.]/', '', wp_unslash( $_POST[ $k ] ) ) );
		} else {
			delete_post_meta( $post_id, $k );
		}
	}

	if ( isset( $_POST['_ypgh_featured'] ) ) {
		update_post_meta( $post_id, '_ypgh_featured', '1' );
	} else {
		delete_post_meta( $post_id, '_ypgh_featured' );
	}
}
add_action( 'save_post_property', 'ypgh_save_details' );

/* -------------------------------------------------------------------------
 * Area term fields: image URL + short label (used in the Search By Area grid)
 * ---------------------------------------------------------------------- */

function ypgh_area_add_fields() {
	?>
	<div class="form-field">
		<label for="ypgh_area_image">Area image URL</label>
		<input type="text" name="ypgh_area_image" id="ypgh_area_image" value="">
		<p>Background image for this area card on the homepage.</p>
	</div>
	<div class="form-field">
		<label for="ypgh_area_tag">Short label</label>
		<input type="text" name="ypgh_area_tag" id="ypgh_area_tag" value="">
		<p>Small caption, e.g. Premium residential.</p>
	</div>
	<?php
}
add_action( 'property_area_add_form_fields', 'ypgh_area_add_fields' );

function ypgh_area_edit_fields( $term ) {
	$image = get_term_meta( $term->term_id, '_ypgh_area_image', true );
	$tag   = get_term_meta( $term->term_id, '_ypgh_area_tag', true );
	?>
	<tr class="form-field">
		<th scope="row"><label for="ypgh_area_image">Area image URL</label></th>
		<td><input type="text" name="ypgh_area_image" id="ypgh_area_image" value="<?php echo esc_attr( $image ); ?>" style="width:60%"></td>
	</tr>
	<tr class="form-field">
		<th scope="row"><label for="ypgh_area_tag">Short label</label></th>
		<td><input type="text" name="ypgh_area_tag" id="ypgh_area_tag" value="<?php echo esc_attr( $tag ); ?>" style="width:60%"></td>
	</tr>
	<?php
}
add_action( 'property_area_edit_form_fields', 'ypgh_area_edit_fields' );

function ypgh_area_save_fields( $term_id ) {
	if ( isset( $_POST['ypgh_area_image'] ) ) {
		update_term_meta( $term_id, '_ypgh_area_image', esc_url_raw( wp_unslash( $_POST['ypgh_area_image'] ) ) );
	}
	if ( isset( $_POST['ypgh_area_tag'] ) ) {
		update_term_meta( $term_id, '_ypgh_area_tag', sanitize_text_field( wp_unslash( $_POST['ypgh_area_tag'] ) ) );
	}
}
add_action( 'created_property_area', 'ypgh_area_save_fields' );
add_action( 'edited_property_area', 'ypgh_area_save_fields' );
