<?php
/**
 * Template Name: About
 *
 * @package ypgh
 */

get_header();

$values = array(
	array( 'verify',  __( 'Verify first', 'ypgh' ),   __( 'We check the title, the documentation, and the ground truth before a listing ever reaches you. Trust is earned with evidence, not slogans.', 'ypgh' ) ),
	array( 'plain',   __( 'Plain language', 'ypgh' ), __( 'No jargon, no hidden catches. We spell out rent advance limits, leasehold terms, and risks so you can decide with clear eyes.', 'ypgh' ) ),
	array( 'local',   __( 'Local knowledge', 'ypgh' ),__( 'We know the difference between a good plot and a disputed one, and which neighborhoods flood. That knowledge sits behind every listing.', 'ypgh' ) ),
);

if ( ! function_exists( 'ypgh_about_icon' ) ) :
	function ypgh_about_icon( $key ) {
		$m = array(
			'verify' => '<path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/><path d="M9 12l2 2 4-4"/>',
			'plain'  => '<path d="M4 6h16M4 12h16M4 18h10"/>',
			'local'  => '<path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0118 0z"/><circle cx="12" cy="10" r="3"/>',
		);
		$p = isset( $m[ $key ] ) ? $m[ $key ] : $m['verify'];
		return '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">' . $p . '</svg>';
	}
endif;

while ( have_posts() ) :
	the_post();
	?>

<section class="page-hero">
	<div class="wrap">
		<p class="eyebrow"><?php esc_html_e( 'Who we are', 'ypgh' ); ?></p>
		<h1><?php the_title(); ?></h1>
		<p class="page-hero-sub"><?php esc_html_e( 'YourPlaceGH exists because finding property in Ghana should not mean gambling with your money, your documents, or your peace of mind.', 'ypgh' ); ?></p>
	</div>
</section>

<section class="section">
	<div class="wrap about-story">
		<div class="about-story-head">
			<p class="eyebrow"><?php esc_html_e( 'Why we exist', 'ypgh' ); ?></p>
			<h2><?php esc_html_e( 'The market had a trust problem. So we built the fix.', 'ypgh' ); ?></h2>
		</div>
		<div class="about-story-body">
			<p><?php esc_html_e( 'Across Ghana, the same stories repeat: a plot sold to three different buyers, a deposit paid on land that turns out to be in litigation, a tenant asked for two years rent in advance against the law, land guards appearing after a handshake deal. The listings existed everywhere, but the checks did not.', 'ypgh' ); ?></p>
			<p><?php esc_html_e( 'YourPlaceGH was built to close that gap. We treat verification as the product, not an afterthought. Every property is sighted, every neighborhood is scored, and every rule that protects you is explained in plain terms. The result is a place to search that respects both your money and your time.', 'ypgh' ); ?></p>
			<p><?php esc_html_e( 'We are independent, we work for the person looking, and we would rather list fewer properties well than flood the page with plots we cannot stand behind.', 'ypgh' ); ?></p>
		</div>
	</div>
</section>

<section class="section section-alt">
	<div class="wrap">
		<p class="eyebrow"><?php esc_html_e( 'What we stand for', 'ypgh' ); ?></p>
		<h2 class="process-head"><?php esc_html_e( 'Three commitments behind every listing', 'ypgh' ); ?></h2>
		<div class="values-grid">
			<?php foreach ( $values as $v ) : ?>
				<div class="value-card">
					<span class="service-ic"><?php echo ypgh_about_icon( $v[0] ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span>
					<h3><?php echo esc_html( $v[1] ); ?></h3>
					<p><?php echo esc_html( $v[2] ); ?></p>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>

<section class="section trust-band">
	<div class="wrap trust-band-inner">
		<div class="about-facts">
			<div class="about-fact"><span class="about-fact-num">0</span><span class="about-fact-label"><?php esc_html_e( 'listings published without a title check', 'ypgh' ); ?></span></div>
			<div class="about-fact"><span class="about-fact-num">6</span><span class="about-fact-label"><?php esc_html_e( 'month legal rent advance cap, flagged on every rental', 'ypgh' ); ?></span></div>
			<div class="about-fact"><span class="about-fact-num">5</span><span class="about-fact-label"><?php esc_html_e( 'point intelligence score on safety, utilities, flood and title risk', 'ypgh' ); ?></span></div>
		</div>
	</div>
</section>

<section class="section">
	<div class="wrap">
		<div class="cta-band">
			<div>
				<h2><?php esc_html_e( 'See how a verified listing looks', 'ypgh' ); ?></h2>
				<p><?php esc_html_e( 'Browse property and land that has been checked, or talk to us about a title search or valuation.', 'ypgh' ); ?></p>
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
