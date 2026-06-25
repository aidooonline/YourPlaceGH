<?php
/**
 * Single property.
 *
 * @package YourPlaceGH
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
$nap = ypgh_nap();

while ( have_posts() ) :
	the_post();
	$id     = get_the_ID();
	$area   = ypgh_first_term( $id, 'property_area' );
	$status = ypgh_first_term( $id, 'property_status' );
	$beds   = (int) ypgh_meta( $id, '_ypgh_beds', 0 );
	$baths  = (int) ypgh_meta( $id, '_ypgh_baths', 0 );
	$size   = ypgh_meta( $id, '_ypgh_size', '' );
	$addr   = ypgh_meta( $id, '_ypgh_address', '' );
	$lat    = ypgh_meta( $id, '_ypgh_lat', '' );
	$lng    = ypgh_meta( $id, '_ypgh_lng', '' );
	$img    = has_post_thumbnail( $id ) ? get_the_post_thumbnail_url( $id, 'full' ) : 'https://picsum.photos/seed/ypgh' . $id . '/1200/800';
	$phone  = preg_replace( '/\s+/', '', $nap['phone'] );
	$wa      = preg_replace( '/[^0-9]/', '', $nap['phone'] );
	if ( $wa && '0' === substr( $wa, 0, 1 ) ) {
		$wa = '233' . substr( $wa, 1 );
	}
	?>
	<div class="page-head">
		<div class="container">
			<h1><?php the_title(); ?></h1>
			<div class="crumbs"><a href="<?php echo esc_url( home_url( '/' ) ); ?>">Home</a> &middot; <a href="<?php echo esc_url( get_post_type_archive_link( 'property' ) ); ?>">Properties</a> &middot; <?php the_title(); ?></div>
		</div>
	</div>

	<section class="single-prop"><div class="container">
		<div class="sp-grid">
			<div>
				<div class="sp-media"><img src="<?php echo esc_url( $img ); ?>" alt="<?php echo esc_attr( get_the_title() ); ?>"></div>

				<div class="sp-head">
					<div>
						<h1 style="margin:0"><?php the_title(); ?></h1>
						<?php if ( $area ) : ?><div class="sp-loc"><svg viewBox="0 0 24 24"><path d="M12 2a7 7 0 00-7 7c0 5 7 13 7 13s7-8 7-13a7 7 0 00-7-7zm0 9.5A2.5 2.5 0 1112 6a2.5 2.5 0 010 5.5z"/></svg> <?php echo esc_html( $area->name ); ?>, Accra</div><?php endif; ?>
					</div>
					<div class="sp-price"><?php echo wp_kses_post( ypgh_price_html( $id ) ); ?></div>
				</div>

				<div class="sp-specs">
					<?php if ( $status ) : ?><span><?php echo esc_html( $status->name ); ?></span><?php endif; ?>
					<?php if ( $beds > 0 ) : ?><span><svg viewBox="0 0 24 24"><path d="M21 10V7a2 2 0 00-2-2h-5v4h-4V5H5a2 2 0 00-2 2v3a2 2 0 00-2 2v6h2v-2h18v2h2v-6a2 2 0 00-2-2z"/></svg><?php echo esc_html( $beds ); ?> Beds</span><?php endif; ?>
					<?php if ( $baths > 0 ) : ?><span><svg viewBox="0 0 24 24"><path d="M7 7a2 2 0 114 0H7zm-4 5V6a3 3 0 016 0h2a4 4 0 018 0v6h1v2a4 4 0 01-2 3.5V20h-2v-1H6v1H4v-1.5A4 4 0 012 14v-2h1z"/></svg><?php echo esc_html( $baths ); ?> Baths</span><?php endif; ?>
					<?php if ( $size ) : ?><span><svg viewBox="0 0 24 24"><path d="M3 3h8v2H5v6H3V3zm10 0h8v8h-2V5h-6V3zM3 13h2v6h6v2H3v-8zm16 0h2v8h-8v-2h6v-6z"/></svg><?php echo esc_html( $size ); ?></span><?php endif; ?>
				</div>

				<div class="sp-body"><?php the_content(); ?></div>

				<?php if ( '' !== $lat && '' !== $lng ) :
					$bbox_w = (float) $lng - 0.01;
					$bbox_s = (float) $lat - 0.01;
					$bbox_e = (float) $lng + 0.01;
					$bbox_n = (float) $lat + 0.01;
					$src    = 'https://www.openstreetmap.org/export/embed.html?bbox=' . $bbox_w . '%2C' . $bbox_s . '%2C' . $bbox_e . '%2C' . $bbox_n . '&layer=mapnik&marker=' . $lat . '%2C' . $lng;
					?>
					<div class="sp-map"><iframe loading="lazy" src="<?php echo esc_url( $src ); ?>" title="Map"></iframe></div>
				<?php endif; ?>
			</div>

			<aside class="sp-side">
				<h3>Enquire about this listing</h3>
				<div class="field-row"><input type="text" id="sp-name" placeholder="Your name"></div>
				<div class="field-row"><input type="email" id="sp-email" placeholder="Your email"></div>
				<div class="field-row"><textarea id="sp-msg" rows="4" placeholder="I'd like more details about this property."></textarea></div>
				<a class="btn btn-primary" id="sp-send"
				   data-email="<?php echo esc_attr( $nap['email'] ); ?>"
				   data-subject="Enquiry: <?php echo esc_attr( get_the_title() ); ?>"
				   href="mailto:<?php echo esc_attr( $nap['email'] ); ?>?subject=<?php echo rawurlencode( 'Enquiry: ' . get_the_title() ); ?>">Send enquiry</a>
				<a class="btn btn-white" style="margin-top:10px;width:100%;justify-content:center" href="tel:<?php echo esc_attr( $phone ); ?>">Call <?php echo esc_html( $nap['phone'] ); ?></a>
				<?php if ( $wa ) : ?>
					<a class="btn btn-white" style="margin-top:10px;width:100%;justify-content:center" target="_blank" rel="noopener" href="https://wa.me/<?php echo esc_attr( $wa ); ?>?text=<?php echo rawurlencode( 'Hi, I am interested in: ' . get_the_title() ); ?>">WhatsApp us</a>
				<?php endif; ?>
			</aside>
		</div>
	</div></section>
	<?php
endwhile;

get_footer();
