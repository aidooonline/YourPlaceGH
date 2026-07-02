<?php
/**
 * Our areas: term tiles with images.
 *
 * @package yourplacegh
 */

$terms = get_terms(
	array(
		'taxonomy'   => 'property_area',
		'hide_empty' => false,
		'number'     => 4,
	)
);
if ( is_wp_error( $terms ) || empty( $terms ) ) {
	return;
}
?>
<section class="section">
	<div class="wrap">
		<div class="sec-head reveal">
			<div>
				<span class="eyebrow">Our areas</span>
				<h2>We know these <span class="accent">streets</span></h2>
				<p class="lede">Deeply embedded in the Pantang and Ga East corridor - and active across Accra's most sought-after addresses. Local intelligence that no portal can replicate.</p>
			</div>
		</div>
		<div class="areas-grid">
			<?php
			foreach ( $terms as $term ) :
				$img = get_term_meta( $term->term_id, '_ypgh_area_image', true );
				$tag = get_term_meta( $term->term_id, '_ypgh_area_tag', true );
				if ( ! $img ) {
					$img = YPGH_URI . '/assets/img/hero-2.jpg';
				}
				?>
			<a class="area reveal" href="<?php echo esc_url( get_term_link( $term ) ); ?>" style="background-image:url('<?php echo esc_url( $img ); ?>')">
				<div class="area-info">
					<?php if ( $tag ) : ?><div class="a-tag"><?php echo esc_html( $tag ); ?></div><?php endif; ?>
					<h3><?php echo esc_html( $term->name ); ?></h3>
					<div class="a-count"><?php echo esc_html( $term->count ); ?> listings</div>
				</div>
			</a>
			<?php endforeach; ?>
		</div>
	</div>
</section>
