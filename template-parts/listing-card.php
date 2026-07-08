<?php
/**
 * Listing card.
 *
 * @package ypgh
 */

$trust = ypgh_active_trust();
?>
<article <?php post_class( 'listing-card' ); ?>>
	<a class="card-media" href="<?php the_permalink(); ?>">
		<?php if ( has_post_thumbnail() ) : ?>
			<?php the_post_thumbnail( 'ypgh_card', array( 'loading' => 'lazy' ) ); ?>
		<?php else : ?>
			<span class="card-media-empty"><?php esc_html_e( 'No photo yet', 'ypgh' ); ?></span>
		<?php endif; ?>

		<?php
		$status = get_the_terms( get_the_ID(), 'yp_status' );
		if ( $status && ! is_wp_error( $status ) ) :
			?>
			<span class="card-status"><?php echo esc_html( $status[0]->name ); ?></span>
		<?php endif; ?>

		<?php if ( in_array( 'Title deed sighted and verified', $trust, true ) ) : ?>
			<span class="card-verified" title="<?php esc_attr_e( 'Title verified', 'ypgh' ); ?>"><?php esc_html_e( 'Verified', 'ypgh' ); ?></span>
		<?php endif; ?>
	</a>

	<div class="card-body">
		<p class="card-price"><?php echo esc_html( ypgh_price() ); ?></p>
		<h3 class="card-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>

		<?php $address = ypgh_meta( 'address' ); ?>
		<?php if ( $address ) : ?>
			<p class="card-address"><?php echo esc_html( $address ); ?></p>
		<?php endif; ?>

		<?php ypgh_stat_row(); ?>
	</div>
</article>
