<?php
/**
 * Featured listings.
 *
 * @package YourPlaceGH
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$q = new WP_Query( array(
	'post_type'      => 'property',
	'posts_per_page' => 4,
	'meta_key'       => '_ypgh_featured',
	'meta_value'     => '1',
	'no_found_rows'  => true,
) );

// Fall back to the latest listings if nothing is flagged featured.
if ( ! $q->have_posts() ) {
	$q = new WP_Query( array(
		'post_type'      => 'property',
		'posts_per_page' => 4,
		'no_found_rows'  => true,
	) );
}

$archive = get_post_type_archive_link( 'property' );
?>
<section class="section soft" id="featured">
	<div class="container">
		<div class="section-head reveal">
			<div class="eyebrow">Handpicked</div>
			<h2>Featured listings</h2>
		</div>

		<?php if ( $q->have_posts() ) : ?>
			<div class="listings">
				<?php while ( $q->have_posts() ) : $q->the_post(); ?>
					<div class="reveal"><?php ypgh_render_property_card( get_the_ID() ); ?></div>
				<?php endwhile; ?>
			</div>
			<?php if ( $archive ) : ?>
				<div style="text-align:center;margin-top:48px"><a class="btn btn-primary" href="<?php echo esc_url( $archive ); ?>">View all listings</a></div>
			<?php endif; ?>
		<?php else : ?>
			<p class="empty">No listings yet. Add a property under the Properties menu, or run Tools &rarr; YourPlaceGH Setup to load samples.</p>
		<?php endif; ?>
	</div>
</section>
<?php wp_reset_postdata(); ?>
