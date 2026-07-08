<?php
/**
 * Front page.
 *
 * @package ypgh
 */

get_header();
?>

<section class="hero">
	<div class="wrap hero-inner">
		<p class="eyebrow"><?php esc_html_e( 'Property and land, verified', 'ypgh' ); ?></p>
		<h1 class="hero-title"><?php esc_html_e( 'Find a place in Ghana you can actually trust.', 'ypgh' ); ?></h1>
		<p class="hero-sub"><?php esc_html_e( 'Every listing carries title checks, location intelligence, and plain guidance on rent advance law. No land guards, no double sales, no surprises.', 'ypgh' ); ?></p>

		<?php get_template_part( 'template-parts/filter-bar' ); ?>
	</div>
</section>

<section class="section">
	<div class="wrap">
		<div class="section-head">
			<h2><?php esc_html_e( 'Latest listings', 'ypgh' ); ?></h2>
			<a class="link-more" href="<?php echo esc_url( get_post_type_archive_link( 'yp_listing' ) ); ?>"><?php esc_html_e( 'See all', 'ypgh' ); ?></a>
		</div>

		<?php
		$listings = new WP_Query(
			array(
				'post_type'      => 'yp_listing',
				'posts_per_page' => 6,
			)
		);
		if ( $listings->have_posts() ) :
			echo '<div class="listing-grid">';
			while ( $listings->have_posts() ) :
				$listings->the_post();
				get_template_part( 'template-parts/listing-card' );
			endwhile;
			echo '</div>';
			wp_reset_postdata();
		else :
			echo '<p class="empty">' . esc_html__( 'No listings published yet. Add your first from the dashboard.', 'ypgh' ) . '</p>';
		endif;
		?>
	</div>
</section>

<section class="section section-alt">
	<div class="wrap">
		<div class="section-head">
			<h2><?php esc_html_e( 'Neighborhood guides', 'ypgh' ); ?></h2>
			<a class="link-more" href="<?php echo esc_url( get_post_type_archive_link( 'yp_location' ) ); ?>"><?php esc_html_e( 'All areas', 'ypgh' ); ?></a>
		</div>

		<?php
		$locations = new WP_Query(
			array(
				'post_type'      => 'yp_location',
				'posts_per_page' => 3,
			)
		);
		if ( $locations->have_posts() ) :
			echo '<div class="location-grid">';
			while ( $locations->have_posts() ) :
				$locations->the_post();
				?>
				<a class="location-card" href="<?php the_permalink(); ?>">
					<?php if ( has_post_thumbnail() ) : ?>
						<?php the_post_thumbnail( 'ypgh_card', array( 'loading' => 'lazy' ) ); ?>
					<?php endif; ?>
					<span class="location-name"><?php the_title(); ?></span>
				</a>
				<?php
			endwhile;
			echo '</div>';
			wp_reset_postdata();
		else :
			echo '<p class="empty">' . esc_html__( 'Neighborhood guides are on the way.', 'ypgh' ) . '</p>';
		endif;
		?>
	</div>
</section>

<section class="section trust-band">
	<div class="wrap trust-band-inner">
		<h2><?php esc_html_e( 'The checks nobody else runs', 'ypgh' ); ?></h2>
		<div class="trust-cols">
			<div><h3><?php esc_html_e( 'Title sighted', 'ypgh' ); ?></h3><p><?php esc_html_e( 'We confirm the seller can actually sell before a listing goes live.', 'ypgh' ); ?></p></div>
			<div><h3><?php esc_html_e( 'Lands Commission', 'ypgh' ); ?></h3><p><?php esc_html_e( 'Registration status flagged on every plot, so you know what stage the paperwork sits at.', 'ypgh' ); ?></p></div>
			<div><h3><?php esc_html_e( 'Rent advance law', 'ypgh' ); ?></h3><p><?php esc_html_e( 'The 6-month legal cap spelled out on rentals that push for one or two years upfront.', 'ypgh' ); ?></p></div>
		</div>
	</div>
</section>

<?php
get_footer();
