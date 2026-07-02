<?php
/**
 * Featured listings: hand-picked properties.
 *
 * @package yourplacegh
 */

$q = new WP_Query(
	array(
		'post_type'      => 'property',
		'posts_per_page' => 3,
		'meta_key'       => '_ypgh_featured',
		'meta_value'     => '1',
		'no_found_rows'  => true,
	)
);
if ( ! $q->have_posts() ) {
	$q = new WP_Query(
		array(
			'post_type'      => 'property',
			'posts_per_page' => 3,
			'no_found_rows'  => true,
		)
	);
}
if ( ! $q->have_posts() ) {
	return;
}
?>
<section class="section soft">
	<div class="wrap">
		<div class="sec-head reveal">
			<div>
				<span class="eyebrow">Featured listings</span>
				<h2>Hand-picked <span class="accent">properties</span></h2>
			</div>
			<a class="sec-link" href="<?php echo esc_url( get_post_type_archive_link( 'property' ) ); ?>">View all listings &rarr;</a>
		</div>
		<div class="cards-grid">
			<?php
			while ( $q->have_posts() ) {
				$q->the_post();
				echo '<div class="reveal">';
				ypgh_render_property_card( get_the_ID() );
				echo '</div>';
			}
			wp_reset_postdata();
			?>
		</div>
	</div>
</section>
