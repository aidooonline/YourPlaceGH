<?php
/**
 * Contact form handler: admin-post + wp_mail.
 *
 * @package yourplacegh
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function ypgh_handle_contact() {
	$back = wp_get_referer() ? wp_get_referer() : home_url( '/' );
	$back = remove_query_arg( 'ypgh_sent', $back );

	if ( ! isset( $_POST['ypgh_contact_nonce'] ) || ! wp_verify_nonce( sanitize_key( $_POST['ypgh_contact_nonce'] ), 'ypgh_contact' ) ) {
		wp_safe_redirect( add_query_arg( 'ypgh_sent', 'err', $back ) );
		exit;
	}
	// Honeypot: silently accept.
	if ( ! empty( $_POST['ypgh_hp'] ) ) {
		wp_safe_redirect( add_query_arg( 'ypgh_sent', 'ok', $back ) );
		exit;
	}

	$name  = isset( $_POST['cf_name'] ) ? sanitize_text_field( wp_unslash( $_POST['cf_name'] ) ) : '';
	$phone = isset( $_POST['cf_phone'] ) ? sanitize_text_field( wp_unslash( $_POST['cf_phone'] ) ) : '';
	$email = isset( $_POST['cf_email'] ) ? sanitize_email( wp_unslash( $_POST['cf_email'] ) ) : '';
	$topic = isset( $_POST['cf_topic'] ) ? sanitize_text_field( wp_unslash( $_POST['cf_topic'] ) ) : '';
	$msg   = isset( $_POST['cf_msg'] ) ? sanitize_textarea_field( wp_unslash( $_POST['cf_msg'] ) ) : '';

	if ( ! $name || ! is_email( $email ) || ! $msg ) {
		wp_safe_redirect( add_query_arg( 'ypgh_sent', 'err', $back ) );
		exit;
	}

	$to      = get_option( 'admin_email' );
	$subject = 'Website enquiry: ' . $topic . ' - ' . $name;
	$body    = "Name: $name\nEmail: $email\nPhone: $phone\nTopic: $topic\n\nMessage:\n$msg\n\nSent from " . home_url( '/' );
	$headers = array( 'Reply-To: ' . $name . ' <' . $email . '>' );

	$sent = wp_mail( $to, $subject, $body, $headers );

	wp_safe_redirect( add_query_arg( 'ypgh_sent', $sent ? 'ok' : 'err', $back ) );
	exit;
}
add_action( 'admin_post_ypgh_contact', 'ypgh_handle_contact' );
add_action( 'admin_post_nopriv_ypgh_contact', 'ypgh_handle_contact' );
