<?php
/**
 * Template Name: Contact
 *
 * @package yourplacegh
 */

get_header();

$nap    = ypgh_nap();
$wa     = 'https://wa.me/233539601097';
$maps   = 'https://maps.google.com/?q=' . rawurlencode( $nap['address'] );
$status = isset( $_GET['ypgh_sent'] ) ? sanitize_key( wp_unslash( $_GET['ypgh_sent'] ) ) : '';
?>
<div class="page-head">
	<div class="wrap">
		<span class="eyebrow">We're here - let's talk</span>
		<h1>Get in touch <span class="accent">with us</span></h1>
		<p class="lede">Whether you're ready to buy, looking to sell, or just starting your property journey - our team is available and responsive. We typically respond within 24 hours.</p>
	</div>
</div>

<section class="section">
	<div class="wrap">
		<div class="contact-grid">
			<div class="reveal">
				<span class="eyebrow">Reach us directly</span>
				<h2>Choose your <span class="accent">channel</span></h2>
				<div class="quick-contacts">
					<a class="qc" href="tel:+233539601097">
						<div class="qc-ic">&#9742;</div>
						<div><div class="qc-label">Call us directly</div><div class="qc-value"><?php echo esc_html( $nap['phone'] ); ?></div></div>
					</a>
					<a class="qc" href="mailto:<?php echo esc_attr( $nap['email'] ); ?>">
						<div class="qc-ic">&#9993;</div>
						<div><div class="qc-label">Email our team</div><div class="qc-value"><?php echo esc_html( $nap['email'] ); ?></div></div>
					</a>
					<a class="qc" href="<?php echo esc_url( $wa ); ?>" target="_blank" rel="noopener">
						<div class="qc-ic">&#9672;</div>
						<div><div class="qc-label">WhatsApp</div><div class="qc-value">Chat with us now</div></div>
					</a>
					<a class="qc" href="<?php echo esc_url( $maps ); ?>" target="_blank" rel="noopener">
						<div class="qc-ic">&#9678;</div>
						<div><div class="qc-label">Office location</div><div class="qc-value"><?php echo esc_html( $nap['address'] ); ?></div></div>
					</a>
				</div>
				<div class="office-hours">
					<h4>Opening hours</h4>
					<div class="oh-row"><span>Monday - Friday</span><span class="open">8:00am - 5:30pm</span></div>
					<div class="oh-row"><span>Saturday</span><span class="open">9:00am - 2:00pm</span></div>
					<div class="oh-row"><span>Sunday</span><span>Closed</span></div>
				</div>
			</div>

			<div class="contact-form reveal">
				<h3>Send us a message</h3>
				<p class="cf-sub">Tell us what you're looking for and we'll come back within one working day.</p>

				<?php if ( 'ok' === $status ) : ?>
					<div class="form-msg ok">Thank you - your message has been sent. We'll be in touch within 24 hours.</div>
				<?php elseif ( 'err' === $status ) : ?>
					<div class="form-msg err">Something went wrong sending your message. Please try again, or reach us directly by phone or WhatsApp.</div>
				<?php endif; ?>

				<form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
					<input type="hidden" name="action" value="ypgh_contact">
					<?php wp_nonce_field( 'ypgh_contact', 'ypgh_contact_nonce' ); ?>
					<input type="text" name="ypgh_hp" value="" style="display:none" tabindex="-1" autocomplete="off" aria-hidden="true">
					<div class="cf-row">
						<div class="cf-field">
							<label for="cf-name">Full name</label>
							<input type="text" id="cf-name" name="cf_name" required>
						</div>
						<div class="cf-field">
							<label for="cf-phone">Phone / WhatsApp</label>
							<input type="text" id="cf-phone" name="cf_phone">
						</div>
					</div>
					<div class="cf-field">
						<label for="cf-email">Email</label>
						<input type="email" id="cf-email" name="cf_email" required>
					</div>
					<div class="cf-field">
						<label for="cf-topic">I'm interested in</label>
						<select id="cf-topic" name="cf_topic">
							<option>Buying a property</option>
							<option>Selling a property</option>
							<option>Renting</option>
							<option>Land / due diligence</option>
							<option>Construction / build management</option>
							<option>Diaspora purchase</option>
							<option>Something else</option>
						</select>
					</div>
					<div class="cf-field">
						<label for="cf-msg">Message</label>
						<textarea id="cf-msg" name="cf_msg" rows="5" required></textarea>
					</div>
					<button type="submit" class="btn btn-gold">Send message</button>
					<p class="form-note">We never share your details. You'll only hear from our team.</p>
				</form>
			</div>
		</div>
	</div>
</section>

<?php
get_template_part( 'template-parts/cta' );
get_footer();
