<?php
/**
 * Single location (neighborhood guide).
 *
 * @package ypgh
 */

get_header();

while ( have_posts() ) :
	the_post();

	$lat    = ypgh_loc_meta( 'lat' );
	$lng    = ypgh_loc_meta( 'lng' );
	$scores = array(
		'safety'      => __( 'Safety', 'ypgh' ),
		'utilities'   => __( 'Utilities', 'ypgh' ),
		'road_access' => __( 'Road access', 'ypgh' ),
		'flood_risk'  => __( 'Flood risk', 'ypgh' ),
		'title_risk'  => __( 'Land title risk', 'ypgh' ),
	);
	?>

<article class="single-location">
	<div class="wrap">
		<nav class="crumbs" aria-label="<?php esc_attr_e( 'Breadcrumb', 'ypgh' ); ?>">
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Home', 'ypgh' ); ?></a>
			<span>/</span>
			<a href="<?php echo esc_url( get_post_type_archive_link( 'yp_location' ) ); ?>"><?php esc_html_e( 'Neighborhoods', 'ypgh' ); ?></a>
		</nav>

		<h1><?php the_title(); ?></h1>
	</div>

	<?php if ( has_post_thumbnail() ) : ?>
		<div class="wrap"><div class="location-hero"><?php the_post_thumbnail( 'ypgh_hero' ); ?></div></div>
	<?php endif; ?>

	<div class="wrap location-layout">
		<div class="location-main">
			<div class="listing-body"><?php the_content(); ?></div>

			<?php if ( $lat && $lng ) : ?>
				<div class="listing-map" id="listing-map"
					data-lat="<?php echo esc_attr( $lat ); ?>"
					data-lng="<?php echo esc_attr( $lng ); ?>"
					data-label="<?php echo esc_attr( get_the_title() ); ?>"></div>
			<?php endif; ?>
		</div>

		<aside class="location-side">
			<div class="side-card intel-card">
				<h2><?php esc_html_e( 'Location intelligence', 'ypgh' ); ?></h2>
				<p class="intel-note"><?php esc_html_e( 'Scored 0 to 5 from local reporting and resident feedback.', 'ypgh' ); ?></p>
				<div class="intel-rings">
					<?php
					ypgh_intel_ring( __( 'Safety', 'ypgh' ), ypgh_loc_meta( 'safety' ) );
					ypgh_intel_ring( __( 'Utilities', 'ypgh' ), ypgh_loc_meta( 'utilities' ) );
					ypgh_intel_ring( __( 'Road access', 'ypgh' ), ypgh_loc_meta( 'road_access' ) );
					ypgh_intel_ring( __( 'Flood risk', 'ypgh' ), ypgh_loc_meta( 'flood_risk' ), true );
					ypgh_intel_ring( __( 'Title risk', 'ypgh' ), ypgh_loc_meta( 'title_risk' ), true );
					?>
				</div>

				<?php $rent = ypgh_loc_meta( 'avg_rent' ); ?>
				<?php if ( '' !== $rent ) : ?>
					<p class="intel-rent"><?php esc_html_e( 'Typical 2-bed rent', 'ypgh' ); ?> <strong>GHS <?php echo esc_html( number_format( (float) $rent ) ); ?>/mo</strong></p>
				<?php endif; ?>
			</div>
		</aside>
	</div>
</article>

	<?php
endwhile;

get_footer();
