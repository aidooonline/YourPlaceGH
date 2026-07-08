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

	<button type="button" class="fav-btn" data-id="<?php echo esc_attr( get_the_ID() ); ?>" aria-pressed="false" aria-label="<?php esc_attr_e( 'Save listing', 'ypgh' ); ?>">
		<svg viewBox="0 0 24 24" width="20" height="20" aria-hidden="true"><path d="M12 21s-7.5-4.7-10-9.3C.7 9 1.4 5.8 4 4.5 6 3.5 8.3 4.2 9.5 6c.5.7.9 1.4 1.5 2 .6-.6 1-1.3 1.5-2 1.2-1.8 3.5-2.5 5.5-1.5 2.6 1.3 3.3 4.5 2 7.2C19.5 16.3 12 21 12 21z"/></svg>
	</button>

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
