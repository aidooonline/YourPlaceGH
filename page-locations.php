<?php
/**
 * Template Name: Locations
 *
 * Browse-by-area hub. Shows neighborhood guides where they exist, and quick
 * links to listings filtered by city.
 *
 * @package ypgh
 */

get_header();

$locations = new WP_Query(
	array(
		'post_type'      => 'yp_location',
		'posts_per_page' => 12,
		'no_found_rows'  => true,
	)
);

$cities = get_terms(
	array(
		'taxonomy'   => 'yp_city',
		'hide_empty' => false,
	)
);

$archive = get_post_type_archive_link( 'yp_listing' );

while ( have_posts() ) :
	the_post();
	?>

<section class="page-hero">
	<div class="wrap">
		<p class="eyebrow"><?php esc_html_e( 'Where to live', 'ypgh' ); ?></p>
		<h1><?php the_title(); ?></h1>
		<p class="page-hero-sub"><?php esc_html_e( 'Explore areas across Accra and beyond. Each guide scores safety, utilities, flood risk, and land title risk, so you know the neighborhood before the address.', 'ypgh' ); ?></p>
	</div>
</section>

<section class="section">
	<div class="wrap">
		<?php if ( $locations->have_posts() ) : ?>
			<div class="section-head">
				<h2><?php esc_html_e( 'Neighborhood guides', 'ypgh' ); ?></h2>
				<a class="link-more" href="<?php echo esc_url( get_post_type_archive_link( 'yp_location' ) ); ?>"><?php esc_html_e( 'All areas', 'ypgh' ); ?></a>
			</div>
			<div class="location-grid">
				<?php
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
				wp_reset_postdata();
				?>
			</div>
		<?php else : ?>
			<p class="empty"><?php esc_html_e( 'Neighborhood guides are on the way. In the meantime, browse listings by area below.', 'ypgh' ); ?></p>
		<?php endif; ?>
	</div>
</section>

<?php if ( $cities && ! is_wp_error( $cities ) ) : ?>
	<section class="section section-alt">
		<div class="wrap">
			<p class="eyebrow"><?php esc_html_e( 'Browse listings by area', 'ypgh' ); ?></p>
			<h2 class="process-head"><?php esc_html_e( 'Jump straight to a location', 'ypgh' ); ?></h2>
			<div class="area-chips">
				<?php foreach ( $cities as $city ) : ?>
					<a class="area-chip" href="<?php echo esc_url( add_query_arg( 'yp_city', $city->slug, $archive ) ); ?>">
						<span class="area-chip-name"><?php echo esc_html( $city->name ); ?></span>
						<?php if ( $city->count ) : ?>
							<span class="area-chip-count"><?php echo esc_html( $city->count ); ?></span>
						<?php endif; ?>
					</a>
				<?php endforeach; ?>
			</div>
		</div>
	</section>
<?php endif; ?>

	<?php
endwhile;

get_footer();
