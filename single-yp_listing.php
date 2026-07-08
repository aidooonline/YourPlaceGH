<?php
/**
 * Single listing.
 *
 * @package ypgh
 */

get_header();

while ( have_posts() ) :
	the_post();

	$lat     = ypgh_meta( 'lat' );
	$lng     = ypgh_meta( 'lng' );
	$trust   = ypgh_active_trust();
	$wa      = ypgh_whatsapp_link();
	$phone   = ypgh_meta( 'agent_phone' );
	$advance = ypgh_rent_advance_notice();
	?>

<article class="single-listing">

	<div class="wrap">
		<nav class="crumbs" aria-label="<?php esc_attr_e( 'Breadcrumb', 'ypgh' ); ?>">
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Home', 'ypgh' ); ?></a>
			<span>/</span>
			<a href="<?php echo esc_url( get_post_type_archive_link( 'yp_listing' ) ); ?>"><?php esc_html_e( 'Listings', 'ypgh' ); ?></a>
		</nav>

		<header class="listing-head">
			<div>
				<h1><?php the_title(); ?></h1>
				<?php $address = ypgh_meta( 'address' ); ?>
				<?php if ( $address ) : ?>
					<p class="listing-address"><?php echo esc_html( $address ); ?></p>
				<?php endif; ?>
			</div>
			<p class="listing-price"><?php echo esc_html( ypgh_price() ); ?></p>
		</header>
	</div>

	<?php if ( has_post_thumbnail() ) : ?>
		<div class="wrap">
			<div class="listing-gallery"><?php the_post_thumbnail( 'ypgh_hero' ); ?></div>
			<?php
			$gallery = ypgh_gallery_ids();
			if ( $gallery ) :
				?>
				<div class="gallery-thumbs">
					<?php foreach ( $gallery as $img_id ) : ?>
						<a class="gallery-thumb" href="<?php echo esc_url( wp_get_attachment_image_url( $img_id, 'ypgh_hero' ) ); ?>" target="_blank" rel="noopener">
							<?php echo wp_get_attachment_image( $img_id, 'ypgh_card', false, array( 'loading' => 'lazy' ) ); ?>
						</a>
					<?php endforeach; ?>
				</div>
			<?php endif; ?>
		</div>
	<?php endif; ?>

	<div class="wrap listing-layout">
		<div class="listing-main">
			<?php ypgh_stat_row(); ?>

			<div class="listing-body">
				<?php the_content(); ?>
			</div>

			<?php if ( get_the_terms( get_the_ID(), 'yp_amenity' ) ) : ?>
				<div class="listing-amenities">
					<h2><?php esc_html_e( 'Amenities', 'ypgh' ); ?></h2>
					<?php ypgh_render_amenities(); ?>
				</div>
			<?php endif; ?>

			<?php if ( $advance ) : ?>
				<div class="advisory <?php echo (int) ypgh_meta( 'rent_advance' ) > 6 ? 'advisory-warn' : 'advisory-ok'; ?>">
					<strong><?php esc_html_e( 'Rent advance note', 'ypgh' ); ?></strong>
					<p><?php echo esc_html( $advance ); ?></p>
				</div>
			<?php endif; ?>

			<?php if ( $lat && $lng ) : ?>
				<div class="listing-map"
					id="listing-map"
					data-lat="<?php echo esc_attr( $lat ); ?>"
					data-lng="<?php echo esc_attr( $lng ); ?>"
					data-label="<?php echo esc_attr( get_the_title() ); ?>"></div>
			<?php endif; ?>
		</div>

		<aside class="listing-side">
			<div class="side-card trust-panel">
				<h2><?php esc_html_e( 'Trust safeguards', 'ypgh' ); ?></h2>
				<?php if ( $trust ) : ?>
					<ul class="trust-list">
						<?php foreach ( $trust as $item ) : ?>
							<li><?php echo esc_html( $item ); ?></li>
						<?php endforeach; ?>
					</ul>
				<?php else : ?>
					<p class="trust-empty"><?php esc_html_e( 'No verification confirmed yet. Ask the agent for the title deed and site plan before paying anything.', 'ypgh' ); ?></p>
				<?php endif; ?>
			</div>

			<div class="side-card contact-card">
				<h2><?php esc_html_e( 'Enquire', 'ypgh' ); ?></h2>
				<?php $agent = ypgh_meta( 'agent_name' ); ?>
				<?php if ( $agent ) : ?>
					<p class="agent-name"><?php echo esc_html( $agent ); ?></p>
				<?php endif; ?>
				<?php if ( $wa ) : ?>
					<a class="btn btn-primary btn-block" href="<?php echo esc_url( $wa ); ?>" target="_blank" rel="noopener"><?php esc_html_e( 'Message on WhatsApp', 'ypgh' ); ?></a>
				<?php endif; ?>
				<?php if ( $phone ) : ?>
					<a class="btn btn-ghost btn-block" href="tel:<?php echo esc_attr( preg_replace( '/\s+/', '', $phone ) ); ?>"><?php echo esc_html( $phone ); ?></a>
				<?php endif; ?>

				<div class="enquiry-divider"><span><?php esc_html_e( 'or send a message', 'ypgh' ); ?></span></div>

				<form id="ypgh-enquiry" class="enquiry-form">
					<input type="hidden" name="listing_id" value="<?php echo esc_attr( get_the_ID() ); ?>">
					<label class="screen-reader-text" for="enq-name"><?php esc_html_e( 'Your name', 'ypgh' ); ?></label>
					<input id="enq-name" type="text" name="name" placeholder="<?php esc_attr_e( 'Your name', 'ypgh' ); ?>" required>
					<label class="screen-reader-text" for="enq-phone"><?php esc_html_e( 'Phone', 'ypgh' ); ?></label>
					<input id="enq-phone" type="tel" name="phone" placeholder="<?php esc_attr_e( 'Phone', 'ypgh' ); ?>">
					<label class="screen-reader-text" for="enq-email"><?php esc_html_e( 'Email', 'ypgh' ); ?></label>
					<input id="enq-email" type="email" name="email" placeholder="<?php esc_attr_e( 'Email', 'ypgh' ); ?>">
					<label class="screen-reader-text" for="enq-msg"><?php esc_html_e( 'Message', 'ypgh' ); ?></label>
					<textarea id="enq-msg" name="message" rows="3" placeholder="<?php esc_attr_e( 'I would like to view this property.', 'ypgh' ); ?>"></textarea>
					<button type="submit" class="btn btn-primary btn-block"><?php esc_html_e( 'Send enquiry', 'ypgh' ); ?></button>
					<p class="enquiry-status" role="status" aria-live="polite"></p>
				</form>
			</div>
		</aside>
	</div>

	<?php
	$related = ypgh_related_listings( get_the_ID(), 3 );
	if ( $related->have_posts() ) :
		?>
		<div class="wrap related-wrap">
			<h2 class="related-head"><?php esc_html_e( 'Similar listings', 'ypgh' ); ?></h2>
			<div class="listing-grid">
				<?php
				while ( $related->have_posts() ) :
					$related->the_post();
					get_template_part( 'template-parts/listing-card' );
				endwhile;
				wp_reset_postdata();
				?>
			</div>
		</div>
	<?php endif; ?>

	<div class="mobile-cta">
		<span class="mobile-price"><?php echo esc_html( ypgh_price() ); ?></span>
		<?php if ( $wa ) : ?>
			<a class="btn btn-primary" href="<?php echo esc_url( $wa ); ?>" target="_blank" rel="noopener"><?php esc_html_e( 'WhatsApp', 'ypgh' ); ?></a>
		<?php elseif ( $phone ) : ?>
			<a class="btn btn-primary" href="tel:<?php echo esc_attr( preg_replace( '/\s+/', '', $phone ) ); ?>"><?php esc_html_e( 'Call', 'ypgh' ); ?></a>
		<?php endif; ?>
	</div>

</article>

	<?php
endwhile;

get_footer();
