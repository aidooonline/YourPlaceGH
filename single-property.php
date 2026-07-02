<?php
/**
 * Single property listing.
 *
 * @package yourplacegh
 */

get_header();

while ( have_posts() ) :
	the_post();
	$id     = get_the_ID();
	$status = ypgh_first_term( $id, 'property_status' );
	$area   = ypgh_first_term( $id, 'property_area' );
	$beds   = (int) ypgh_meta( $id, '_ypgh_beds', 0 );
	$baths  = (int) ypgh_meta( $id, '_ypgh_baths', 0 );
	$size   = ypgh_meta( $id, '_ypgh_size', '' );
	$addr   = ypgh_meta( $id, '_ypgh_address', '' );
	$lat    = ypgh_meta( $id, '_ypgh_lat', '' );
	$lng    = ypgh_meta( $id, '_ypgh_lng', '' );
	$img    = has_post_thumbnail() ? get_the_post_thumbnail_url( $id, 'full' ) : YPGH_URI . '/assets/img/listing.jpg';
	$nap    = ypgh_nap();
	?>
<div class="wrap">
	<div class="sp-wrap">
		<div>
			<div class="sp-gallery" style="background-image:url('<?php echo esc_url( $img ); ?>')"></div>
			<div class="sp-head">
				<div class="sp-title">
					<h1><?php the_title(); ?></h1>
					<div class="sp-loc"><?php echo esc_html( $addr ? $addr : ( $area ? $area->name . ', Accra' : 'Accra, Ghana' ) ); ?><?php echo $status ? ' &middot; ' . esc_html( $status->name ) : ''; ?></div>
				</div>
				<div class="sp-price"><?php echo wp_kses_post( ypgh_price_html( $id ) ); ?></div>
			</div>
			<div class="sp-specs">
				<?php if ( $beds > 0 ) : ?><div class="spec"><b><?php echo esc_html( $beds ); ?></b> Bedrooms</div><?php endif; ?>
				<?php if ( $baths > 0 ) : ?><div class="spec"><b><?php echo esc_html( $baths ); ?></b> Bathrooms</div><?php endif; ?>
				<?php if ( $size ) : ?><div class="spec"><b><?php echo esc_html( $size ); ?></b> Area</div><?php endif; ?>
				<?php if ( $area ) : ?><div class="spec"><b><?php echo esc_html( $area->name ); ?></b> Location</div><?php endif; ?>
			</div>
			<div class="sp-content"><?php the_content(); ?></div>
			<?php if ( $lat && $lng ) : ?>
			<div class="sp-map">
				<iframe title="Map" loading="lazy" src="https://www.openstreetmap.org/export/embed.html?bbox=<?php echo esc_attr( ( $lng - 0.01 ) . ',' . ( $lat - 0.006 ) . ',' . ( $lng + 0.01 ) . ',' . ( $lat + 0.006 ) ); ?>&amp;layer=mapnik&amp;marker=<?php echo esc_attr( $lat . ',' . $lng ); ?>"></iframe>
			</div>
			<?php endif; ?>
		</div>
		<aside>
			<div class="enquiry">
				<h3>Enquire about this property</h3>
				<p class="e-sub">We respond within one working day.</p>
				<div class="field"><label for="eq-name">Your name</label><input id="eq-name" type="text"></div>
				<div class="field"><label for="eq-email">Email</label><input id="eq-email" type="email"></div>
				<div class="field"><label for="eq-msg">Message</label><textarea id="eq-msg" rows="4">I'm interested in "<?php echo esc_attr( get_the_title() ); ?>". Please contact me.</textarea></div>
				<button class="btn btn-gold" id="eq-send" data-to="<?php echo esc_attr( $nap['email'] ); ?>" data-title="<?php echo esc_attr( get_the_title() ); ?>">Send enquiry</button>
				<div class="e-alt">
					<a href="tel:+233539601097">Call</a>
					<a href="https://wa.me/233539601097?text=<?php echo rawurlencode( 'Hello, I am interested in: ' . get_the_title() . ' - ' . get_permalink() ); ?>" target="_blank" rel="noopener">WhatsApp</a>
				</div>
			</div>
		</aside>
	</div>
</div>
	<?php
endwhile;

get_footer();
