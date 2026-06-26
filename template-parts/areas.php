<?php
/**
 * Search by area.
 *
 * @package YourPlaceGH
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$bg    = get_theme_mod( 'ypgh_areas_bg', '' );
$style = $bg ? ' style="background-image:url(\'' . esc_url( $bg ) . '\')"' : '';

$areas = get_terms( array(
	'taxonomy'   => 'property_area',
	'hide_empty' => false,
	'number'     => 4,
) );
?>
<section class="section areas-sec"<?php echo $style; // phpcs:ignore ?>>
	<div class="container">
		<div class="section-head reveal">
			<div class="eyebrow">Explore Accra</div>
			<h2>Search by area</h2>
		</div>

		<?php if ( ! is_wp_error( $areas ) && ! empty( $areas ) ) : ?>
		<div class="areas">
			<?php foreach ( $areas as $term ) :
				$img = get_term_meta( $term->term_id, '_ypgh_area_image', true );
				$tag = get_term_meta( $term->term_id, '_ypgh_area_tag', true );
				if ( ! $img ) {
					$img = YPGH_URI . '/assets/img/hero-2.jpg';
				}
				?>
				<a class="area reveal" href="<?php echo esc_url( get_term_link( $term ) ); ?>">
					<img src="<?php echo esc_url( $img ); ?>" alt="<?php echo esc_attr( $term->name ); ?>" loading="lazy">
					<div class="meta">
						<h3><?php echo esc_html( $term->name ); ?></h3>
						<span><?php echo esc_html( $tag ? $tag : $term->count . ' listings' ); ?></span>
					</div>
				</a>
			<?php endforeach; ?>
		</div>
		<?php else : ?>
			<p style="text-align:center;color:#cfd3d7">Areas appear here once added under Properties &rarr; Areas, or run Tools &rarr; YourPlaceGH Setup.</p>
		<?php endif; ?>
	</div>
</section>
