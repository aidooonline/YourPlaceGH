<?php
/**
 * Hero: editorial split with stats and featured-area chip.
 *
 * @package yourplacegh
 */

$hero_img = get_theme_mod( 'ypgh_hero1', YPGH_URI . '/assets/img/hero-1.jpg' );
?>
<section class="hero">
	<div class="hero-grid">
		<div class="hero-copy">
			<span class="eyebrow">Accra &middot; Ga East &middot; Pantang Corridor</span>
			<h1>Your place in Accra <span class="accent">starts here.</span></h1>
			<p class="hero-sub">Full-service real estate for those who want more than a listing. We find, consult, and build - so you move forward with confidence.</p>
			<div class="hero-actions">
				<a class="btn btn-gold" href="<?php echo esc_url( get_post_type_archive_link( 'property' ) ); ?>">Browse Properties</a>
				<a class="btn btn-ghost" href="<?php echo esc_url( ypgh_page_url( 'services', '/services/' ) ); ?>">Our Services</a>
			</div>
			<div class="hero-stats">
				<div class="stat"><div class="stat-num">10<em>+</em></div><div class="stat-label">Years in market</div></div>
				<div class="stat"><div class="stat-num">350<em>+</em></div><div class="stat-label">Transactions closed</div></div>
				<div class="stat"><div class="stat-num">3</div><div class="stat-label">Service pillars</div></div>
			</div>
		</div>
		<div class="hero-media" style="background-image:url('<?php echo esc_url( $hero_img ); ?>')">
			<div class="hero-chip">
				<div class="hc-label">Featured area</div>
				<div class="hc-value">Pantang &middot; Ga East</div>
			</div>
		</div>
	</div>
</section>
