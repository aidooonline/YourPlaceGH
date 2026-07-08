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
		</div>
	<?php endif; ?>

	<div class="wrap listing-layout">
		<div class="listing-main">
			<?php ypgh_stat_row(); ?>

			<div class="listing-body">
				<?php the_content(); ?>
			</div>

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
			</div>
		</aside>
	</div>

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
