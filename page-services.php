<?php
/**
 * Template Name: Services
 *
 * @package ypgh
 */

get_header();

/**
 * Service suite, refined from what Ghana portals and global platforms offer,
 * led by the trust and verification differentiator.
 */
$services = array(
	array(
		'icon'  => 'building',
		'title' => __( 'Verified listings', 'ypgh' ),
		'desc'  => __( 'Homes, apartments, offices, and land for sale or rent across Ghana. Nothing goes live until the title has been sighted, so you browse a market you can trust.', 'ypgh' ),
	),
	array(
		'icon'  => 'shield',
		'title' => __( 'Title and land due diligence', 'ypgh' ),
		'desc'  => __( 'Lands Commission searches, indenture and site plan checks, and confirmation that a plot is free of litigation, land guards, or a second sale, before any money changes hands.', 'ypgh' ),
	),
	array(
		'icon'  => 'scale',
		'title' => __( 'Independent valuation', 'ypgh' ),
		'desc'  => __( 'A fair market valuation from a qualified valuer, so you know what a property is really worth and never overpay on an inflated asking price.', 'ypgh' ),
	),
	array(
		'icon'  => 'radar',
		'title' => __( 'Location intelligence', 'ypgh' ),
		'desc'  => __( 'Safety, utilities, road access, flood risk, and land title risk scored for every neighborhood, so you know the area before you commit to the address.', 'ypgh' ),
	),
	array(
		'icon'  => 'badge',
		'title' => __( 'Agent and developer vetting', 'ypgh' ),
		'desc'  => __( 'We check standing with the relevant bodies and confirm track record, so you deal with genuine professionals rather than chancers working on commission alone.', 'ypgh' ),
	),
	array(
		'icon'  => 'file',
		'title' => __( 'Rent and tenancy advisory', 'ypgh' ),
		'desc'  => __( 'Plain guidance on the six month legal advance cap, tenancy terms, and your rights as a tenant, so you are never quietly overcharged one or two years upfront.', 'ypgh' ),
	),
	array(
		'icon'  => 'upload',
		'title' => __( 'List your property', 'ypgh' ),
		'desc'  => __( 'Owners and developers reach verified buyers and tenants with a clean listing, lead capture, and honest presentation that converts serious enquiries.', 'ypgh' ),
	),
	array(
		'icon'  => 'globe',
		'title' => __( 'Diaspora and expat support', 'ypgh' ),
		'desc'  => __( 'Remote viewings, leasehold guidance, and a trusted person on the ground, so buyers abroad can transact in Ghana with confidence and clear eyes.', 'ypgh' ),
	),
);

$steps = array(
	array( __( 'Tell us what you need', 'ypgh' ), __( 'Share the property, area, or budget you have in mind. We shortlist only what fits and what checks out.', 'ypgh' ) ),
	array( __( 'We verify before you view', 'ypgh' ), __( 'Title, documentation, and the neighborhood are checked and scored so a viewing is never a wasted trip.', 'ypgh' ) ),
	array( __( 'Decide with full information', 'ypgh' ), __( 'You get the valuation, the risks, and the paperwork status in plain language, then choose on your terms.', 'ypgh' ) ),
	array( __( 'Close with support', 'ypgh' ), __( 'We stay with you through negotiation and handover, and flag anything that does not add up.', 'ypgh' ) ),
);

if ( ! function_exists( 'ypgh_service_icon' ) ) :
	/**
	 * Inline SVG icon by key.
	 *
	 * @param string $key Icon name.
	 * @return string
	 */
	function ypgh_service_icon( $key ) {
	$icons = array(
		'building' => '<path d="M3 21h18M5 21V7l8-4v18M19 21V11l-6-3"/><path d="M9 9v.01M9 12v.01M9 15v.01M9 18v.01"/>',
		'shield'   => '<path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/><path d="M9 12l2 2 4-4"/>',
		'scale'    => '<path d="M12 3v18M8 21h8M3 7l9-2 9 2"/><path d="M6 7l-3 6a3 3 0 006 0zM18 7l-3 6a3 3 0 006 0z"/>',
		'radar'    => '<circle cx="12" cy="12" r="9"/><circle cx="12" cy="12" r="5"/><circle cx="12" cy="12" r="1.5"/>',
		'badge'    => '<path d="M12 2l2.5 2 3.5-.5.5 3.5 2 2.5-2 2.5-.5 3.5-3.5-.5L12 22l-2.5-2-3.5.5-.5-3.5-2-2.5 2-2.5.5-3.5 3.5.5z"/><path d="M9 12l2 2 4-4"/>',
		'file'     => '<path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/><path d="M14 2v6h6M9 13h6M9 17h6"/>',
		'upload'   => '<path d="M4 17v2a2 2 0 002 2h12a2 2 0 002-2v-2"/><path d="M12 3v13M7 8l5-5 5 5"/>',
		'globe'    => '<circle cx="12" cy="12" r="9"/><path d="M3 12h18M12 3a15 15 0 000 18M12 3a15 15 0 010 18"/>',
	);
	$path = isset( $icons[ $key ] ) ? $icons[ $key ] : $icons['building'];
		return '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">' . $path . '</svg>';
	}
endif;

while ( have_posts() ) :
	the_post();
	?>

<section class="page-hero">
	<div class="wrap">
		<p class="eyebrow"><?php esc_html_e( 'What we do', 'ypgh' ); ?></p>
		<h1><?php the_title(); ?></h1>
		<p class="page-hero-sub"><?php esc_html_e( 'YourPlaceGH is more than a listings board. We check what others take on trust, so buying, renting, or selling property in Ghana carries far less risk.', 'ypgh' ); ?></p>
	</div>
</section>

<section class="section">
	<div class="wrap">
		<div class="services-grid">
			<?php foreach ( $services as $s ) : ?>
				<article class="service-card">
					<span class="service-ic"><?php echo ypgh_service_icon( $s['icon'] ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span>
					<h3><?php echo esc_html( $s['title'] ); ?></h3>
					<p><?php echo esc_html( $s['desc'] ); ?></p>
				</article>
			<?php endforeach; ?>
		</div>
	</div>
</section>

<section class="section section-alt">
	<div class="wrap">
		<p class="eyebrow"><?php esc_html_e( 'How it works', 'ypgh' ); ?></p>
		<h2 class="process-head"><?php esc_html_e( 'A calmer way to buy or rent', 'ypgh' ); ?></h2>
		<div class="process-grid">
			<?php foreach ( $steps as $i => $step ) : ?>
				<div class="process-step">
					<span class="process-num"><?php echo esc_html( sprintf( '%02d', $i + 1 ) ); ?></span>
					<h3><?php echo esc_html( $step[0] ); ?></h3>
					<p><?php echo esc_html( $step[1] ); ?></p>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>

<section class="section">
	<div class="wrap">
		<div class="cta-band">
			<div>
				<h2><?php esc_html_e( 'Ready to start, or want a property checked?', 'ypgh' ); ?></h2>
				<p><?php esc_html_e( 'Browse verified listings, or talk to the team about a title search, valuation, or listing your own property.', 'ypgh' ); ?></p>
			</div>
			<div class="cta-actions">
				<a class="btn btn-primary" href="<?php echo esc_url( get_post_type_archive_link( 'yp_listing' ) ); ?>"><?php esc_html_e( 'Browse listings', 'ypgh' ); ?></a>
				<a class="btn btn-ghost" href="<?php echo esc_url( home_url( '/contact/' ) ); ?>"><?php esc_html_e( 'Talk to us', 'ypgh' ); ?></a>
			</div>
		</div>
	</div>
</section>

	<?php
endwhile;

get_footer();
