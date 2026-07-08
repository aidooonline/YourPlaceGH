<?php
/**
 * Enquiry leads: stored as a private CPT and emailed to the admin.
 *
 * @package ypgh
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register the lead post type (admin only, not public).
 */
function ypgh_register_leads() {
	register_post_type(
		'yp_lead',
		array(
			'labels'          => array(
				'name'          => __( 'Leads', 'ypgh' ),
				'singular_name' => __( 'Lead', 'ypgh' ),
			),
			'public'          => false,
			'show_ui'         => true,
			'show_in_menu'    => true,
			'menu_icon'       => 'dashicons-email-alt',
			'menu_position'   => 7,
			'capability_type' => 'post',
			'supports'        => array( 'title' ),
		)
	);
}
add_action( 'init', 'ypgh_register_leads' );

/**
 * Handle an enquiry submission from the listing page.
 */
function ypgh_handle_lead() {
	check_ajax_referer( 'ypgh_lead', 'nonce' );

	$name    = isset( $_POST['name'] ) ? sanitize_text_field( wp_unslash( $_POST['name'] ) ) : '';
	$phone   = isset( $_POST['phone'] ) ? sanitize_text_field( wp_unslash( $_POST['phone'] ) ) : '';
	$email   = isset( $_POST['email'] ) ? sanitize_email( wp_unslash( $_POST['email'] ) ) : '';
	$message = isset( $_POST['message'] ) ? sanitize_textarea_field( wp_unslash( $_POST['message'] ) ) : '';
	$listing = isset( $_POST['listing_id'] ) ? absint( $_POST['listing_id'] ) : 0;

	if ( '' === $name || ( '' === $phone && '' === $email ) ) {
		wp_send_json_error( array( 'message' => __( 'Add your name and a phone number or email.', 'ypgh' ) ), 422 );
	}

	$listing_title = $listing ? get_the_title( $listing ) : __( 'General enquiry', 'ypgh' );

	$lead_id = wp_insert_post(
		array(
			'post_type'   => 'yp_lead',
			'post_status' => 'publish',
			'post_title'  => sprintf( '%s - %s', $name, $listing_title ),
		)
	);

	if ( is_wp_error( $lead_id ) || ! $lead_id ) {
		wp_send_json_error( array( 'message' => __( 'Something went wrong. Try WhatsApp instead.', 'ypgh' ) ), 500 );
	}

	update_post_meta( $lead_id, '_lead_name', $name );
	update_post_meta( $lead_id, '_lead_phone', $phone );
	update_post_meta( $lead_id, '_lead_email', $email );
	update_post_meta( $lead_id, '_lead_message', $message );
	update_post_meta( $lead_id, '_lead_listing', $listing );
	update_post_meta( $lead_id, '_lead_listing_url', $listing ? get_permalink( $listing ) : '' );

	$admin_email = get_option( 'admin_email' );
	$subject     = sprintf( 'New enquiry: %s', $listing_title );
	$body        = sprintf(
		"Name: %s\nPhone: %s\nEmail: %s\nListing: %s\nURL: %s\n\nMessage:\n%s",
		$name,
		$phone,
		$email,
		$listing_title,
		$listing ? get_permalink( $listing ) : 'n/a',
		$message
	);
	wp_mail( $admin_email, $subject, $body );

	wp_send_json_success( array( 'message' => __( 'Thanks. The agent will reach out shortly.', 'ypgh' ) ) );
}
add_action( 'wp_ajax_ypgh_lead', 'ypgh_handle_lead' );
add_action( 'wp_ajax_nopriv_ypgh_lead', 'ypgh_handle_lead' );

/**
 * Show lead details in the admin edit screen.
 */
function ypgh_lead_detail_box() {
	add_meta_box( 'ypgh_lead_detail', __( 'Enquiry Detail', 'ypgh' ), 'ypgh_render_lead_detail', 'yp_lead', 'normal', 'high' );
}
add_action( 'add_meta_boxes', 'ypgh_lead_detail_box' );

/**
 * Render read-only lead details.
 *
 * @param WP_Post $post Post object.
 */
function ypgh_render_lead_detail( $post ) {
	$fields = array(
		'_lead_name'        => __( 'Name', 'ypgh' ),
		'_lead_phone'       => __( 'Phone', 'ypgh' ),
		'_lead_email'       => __( 'Email', 'ypgh' ),
		'_lead_listing_url' => __( 'Listing URL', 'ypgh' ),
		'_lead_message'     => __( 'Message', 'ypgh' ),
	);
	echo '<table class="widefat"><tbody>';
	foreach ( $fields as $key => $label ) {
		$val = get_post_meta( $post->ID, $key, true );
		if ( '_lead_listing_url' === $key && $val ) {
			$val = '<a href="' . esc_url( $val ) . '" target="_blank" rel="noopener">' . esc_html( $val ) . '</a>';
		} else {
			$val = esc_html( $val );
		}
		echo '<tr><th style="width:140px;text-align:left;">' . esc_html( $label ) . '</th><td>' . $val . '</td></tr>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}
	echo '</tbody></table>';
}
