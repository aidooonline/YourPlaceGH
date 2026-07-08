<?php
/**
 * Template Name: Contact
 *
 * Assign this template to a page, or name the page slug "contact".
 *
 * @package ypgh
 */

get_header();

// Office coordinates (Teshie, Accra).
$office_lat = '5.5850';
$office_lng = '-0.1050';

while ( have_posts() ) :
	the_post();
	?>

<section class="page-hero">
	<div class="wrap">
		<p class="eyebrow"><?php esc_html_e( 'Get in touch', 'ypgh' ); ?></p>
		<h1><?php the_title(); ?></h1>
		<p class="page-hero-sub"><?php esc_html_e( 'Questions about a listing, a title check, or advertising your property? Reach the team directly, or send a message and we will come back to you.', 'ypgh' ); ?></p>
	</div>
</section>

<section class="section">
	<div class="wrap contact-layout">

		<div class="contact-info">
			<div class="contact-cards">
				<div class="contact-card">
					<span class="contact-ic" data-ic="pin"></span>
					<h3><?php esc_html_e( 'Office', 'ypgh' ); ?></h3>
					<address>HN 7, Nii Adjei Nkroma Street,<br>Manet, Teshie, Accra</address>
				</div>
				<div class="contact-card">
					<span class="contact-ic" data-ic="phone"></span>
					<h3><?php esc_html_e( 'Call or WhatsApp', 'ypgh' ); ?></h3>
					<a href="tel:+233539601097">053 960 1097</a>
				</div>
				<div class="contact-card">
					<span class="contact-ic" data-ic="mail"></span>
					<h3><?php esc_html_e( 'Email', 'ypgh' ); ?></h3>
					<a href="mailto:info@yourplacegh.com">info@yourplacegh.com</a>
				</div>
				<div class="contact-card">
					<span class="contact-ic" data-ic="clock"></span>
					<h3><?php esc_html_e( 'Hours', 'ypgh' ); ?></h3>
					<p><?php esc_html_e( 'Mon to Sat, 8am to 6pm', 'ypgh' ); ?></p>
				</div>
			</div>

			<div class="listing-map contact-map" id="listing-map"
				data-lat="<?php echo esc_attr( $office_lat ); ?>"
				data-lng="<?php echo esc_attr( $office_lng ); ?>"
				data-label="<?php esc_attr_e( 'YourPlaceGH office', 'ypgh' ); ?>"></div>
		</div>

		<aside class="contact-form-card side-card">
			<h2><?php esc_html_e( 'Send a message', 'ypgh' ); ?></h2>
			<p class="contact-form-note"><?php esc_html_e( 'We reply within one working day.', 'ypgh' ); ?></p>
			<form id="ypgh-enquiry" class="enquiry-form">
				<input type="hidden" name="listing_id" value="0">
				<label class="screen-reader-text" for="c-name"><?php esc_html_e( 'Your name', 'ypgh' ); ?></label>
				<input id="c-name" type="text" name="name" placeholder="<?php esc_attr_e( 'Your name', 'ypgh' ); ?>" required>
				<label class="screen-reader-text" for="c-phone"><?php esc_html_e( 'Phone', 'ypgh' ); ?></label>
				<input id="c-phone" type="tel" name="phone" placeholder="<?php esc_attr_e( 'Phone', 'ypgh' ); ?>">
				<label class="screen-reader-text" for="c-email"><?php esc_html_e( 'Email', 'ypgh' ); ?></label>
				<input id="c-email" type="email" name="email" placeholder="<?php esc_attr_e( 'Email', 'ypgh' ); ?>">
				<label class="screen-reader-text" for="c-msg"><?php esc_html_e( 'Message', 'ypgh' ); ?></label>
				<textarea id="c-msg" name="message" rows="5" placeholder="<?php esc_attr_e( 'How can we help?', 'ypgh' ); ?>"></textarea>
				<button type="submit" class="btn btn-primary btn-block"><?php esc_html_e( 'Send message', 'ypgh' ); ?></button>
				<p class="enquiry-status" role="status" aria-live="polite"></p>
			</form>
		</aside>

	</div>
</section>

	<?php
endwhile;

get_footer();
