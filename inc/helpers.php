<?php
/**
 * Template helpers.
 *
 * @package YourPlaceGH
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Business contact details. Each value is overridable in the Customizer
 * (Appearance > Customize is not wired here yet, so theme mods + defaults).
 *
 * @return array
 */
function ypgh_nap() {
	return array(
		'email'    => get_theme_mod( 'ypgh_email', 'info@yourplacegh.com' ),
		'phone'    => get_theme_mod( 'ypgh_phone', '053 960 1097' ),
		'address'  => get_theme_mod( 'ypgh_address', 'HN 7, Nii Adjei Nkroma Street, Manet, Teshie - Accra' ),
		'facebook' => get_theme_mod( 'ypgh_facebook', 'https://www.facebook.com/profile.php?id=100063910215831' ),
		'linkedin' => get_theme_mod( 'ypgh_linkedin', 'https://www.linkedin.com/company/yourplace-gh/' ),
		'twitter'  => get_theme_mod( 'ypgh_twitter', '#' ),
		'instagram'=> get_theme_mod( 'ypgh_instagram', '#' ),
	);
}

/**
 * Single meta getter with default.
 */
function ypgh_meta( $post_id, $key, $default = '' ) {
	$val = get_post_meta( $post_id, $key, true );
	return ( '' === $val || null === $val ) ? $default : $val;
}

/**
 * Currency symbol for a stored currency code.
 */
function ypgh_currency_symbol( $code ) {
	$map = array(
		'GHS' => 'GH&#8373;',
		'USD' => '$',
		'EUR' => '&euro;',
		'GBP' => '&pound;',
	);
	$code = strtoupper( $code );
	return isset( $map[ $code ] ) ? $map[ $code ] : esc_html( $code ) . ' ';
}

/**
 * Formatted price markup for a property.
 */
function ypgh_price_html( $post_id ) {
	$price = ypgh_meta( $post_id, '_ypgh_price', '' );
	if ( '' === $price ) {
		return '<span class="price">Price on request</span>';
	}
	$currency = ypgh_meta( $post_id, '_ypgh_currency', 'GHS' );
	$period   = ypgh_meta( $post_id, '_ypgh_period', '' );
	$symbol   = ypgh_currency_symbol( $currency );
	$amount   = number_format( (float) $price, 0 );
	$out      = '<span class="price">' . $symbol . '&nbsp;' . esc_html( $amount );
	if ( $period ) {
		$out .= '<small>&nbsp;/ ' . esc_html( $period ) . '</small>';
	}
	$out .= '</span>';
	return $out;
}

/**
 * First term name for a property in a taxonomy.
 */
function ypgh_first_term( $post_id, $taxonomy ) {
	$terms = get_the_terms( $post_id, $taxonomy );
	if ( is_wp_error( $terms ) || empty( $terms ) ) {
		return null;
	}
	return $terms[0];
}

/**
 * Card image URL: featured image, else a stable placeholder seeded by ID.
 */
function ypgh_card_image( $post_id ) {
	if ( has_post_thumbnail( $post_id ) ) {
		return get_the_post_thumbnail_url( $post_id, 'ypgh-card' );
	}
	return YPGH_URI . '/assets/img/listing.jpg';
}

/**
 * Render one property card. Shared by the homepage and archive.
 */
function ypgh_render_property_card( $post_id ) {
	$status = ypgh_first_term( $post_id, 'property_status' );
	$area   = ypgh_first_term( $post_id, 'property_area' );
	$beds   = (int) ypgh_meta( $post_id, '_ypgh_beds', 0 );
	$baths  = (int) ypgh_meta( $post_id, '_ypgh_baths', 0 );
	$size   = ypgh_meta( $post_id, '_ypgh_size', '' );
	$link   = get_permalink( $post_id );
	?>
	<article class="card">
		<div class="ph">
			<?php if ( $status ) : ?><span class="tag"><?php echo esc_html( $status->name ); ?></span><?php endif; ?>
			<a class="fav" href="<?php echo esc_url( $link ); ?>" aria-label="View listing">&#9825;</a>
			<a href="<?php echo esc_url( $link ); ?>"><img src="<?php echo esc_url( ypgh_card_image( $post_id ) ); ?>" alt="<?php echo esc_attr( get_the_title( $post_id ) ); ?>" loading="lazy"></a>
		</div>
		<div class="body">
			<div class="price"><?php echo wp_kses_post( ypgh_price_html( $post_id ) ); ?></div>
			<h3><a href="<?php echo esc_url( $link ); ?>"><?php echo esc_html( get_the_title( $post_id ) ); ?></a></h3>
			<?php if ( $area ) : ?>
			<div class="loc"><svg viewBox="0 0 24 24"><path d="M12 2a7 7 0 00-7 7c0 5 7 13 7 13s7-8 7-13a7 7 0 00-7-7zm0 9.5A2.5 2.5 0 1112 6a2.5 2.5 0 010 5.5z"/></svg> <?php echo esc_html( $area->name ); ?></div>
			<?php endif; ?>
			<div class="specs">
				<?php if ( $beds > 0 ) : ?><span><svg viewBox="0 0 24 24"><path d="M21 10V7a2 2 0 00-2-2h-5v4h-4V5H5a2 2 0 00-2 2v3a2 2 0 00-2 2v6h2v-2h18v2h2v-6a2 2 0 00-2-2z"/></svg><?php echo esc_html( $beds ); ?></span><?php endif; ?>
				<?php if ( $baths > 0 ) : ?><span><svg viewBox="0 0 24 24"><path d="M7 7a2 2 0 114 0H7zm-4 5V6a3 3 0 016 0h2a4 4 0 018 0v6h1v2a4 4 0 01-2 3.5V20h-2v-1H6v1H4v-1.5A4 4 0 012 14v-2h1z"/></svg><?php echo esc_html( $baths ); ?></span><?php endif; ?>
				<?php if ( $size ) : ?><span><svg viewBox="0 0 24 24"><path d="M3 3h8v2H5v6H3V3zm10 0h8v8h-2V5h-6V3zM3 13h2v6h6v2H3v-8zm16 0h2v8h-8v-2h6v-6z"/></svg><?php echo esc_html( $size ); ?></span><?php endif; ?>
			</div>
		</div>
	</article>
	<?php
}

/**
 * The search bar. Submits to the property archive with status/area/ptype.
 * Pre-selects current values on the archive.
 */
function ypgh_search_bar() {
	$action  = get_post_type_archive_link( 'property' );
	$action  = $action ? $action : home_url( '/' );
	$cur_st  = isset( $_GET['status'] ) ? sanitize_title( wp_unslash( $_GET['status'] ) ) : '';
	$cur_ar  = isset( $_GET['area'] ) ? sanitize_title( wp_unslash( $_GET['area'] ) ) : '';
	$cur_tp  = isset( $_GET['ptype'] ) ? sanitize_title( wp_unslash( $_GET['ptype'] ) ) : '';

	$statuses = get_terms( array( 'taxonomy' => 'property_status', 'hide_empty' => false ) );
	$areas    = get_terms( array( 'taxonomy' => 'property_area', 'hide_empty' => false ) );
	$types    = get_terms( array( 'taxonomy' => 'property_type', 'hide_empty' => false ) );
	?>
	<form class="searchbar" method="get" action="<?php echo esc_url( $action ); ?>">
		<div class="field">
			<label for="ypgh-status">Looking for</label>
			<select name="status" id="ypgh-status">
				<option value="">Any</option>
				<?php if ( ! is_wp_error( $statuses ) ) foreach ( $statuses as $t ) : ?>
					<option value="<?php echo esc_attr( $t->slug ); ?>" <?php selected( $cur_st, $t->slug ); ?>><?php echo esc_html( $t->name ); ?></option>
				<?php endforeach; ?>
			</select>
		</div>
		<div class="field">
			<label for="ypgh-area">Location</label>
			<select name="area" id="ypgh-area">
				<option value="">Any area</option>
				<?php if ( ! is_wp_error( $areas ) ) foreach ( $areas as $t ) : ?>
					<option value="<?php echo esc_attr( $t->slug ); ?>" <?php selected( $cur_ar, $t->slug ); ?>><?php echo esc_html( $t->name ); ?></option>
				<?php endforeach; ?>
			</select>
		</div>
		<div class="field">
			<label for="ypgh-type">Property Type</label>
			<select name="ptype" id="ypgh-type">
				<option value="">Any type</option>
				<?php if ( ! is_wp_error( $types ) ) foreach ( $types as $t ) : ?>
					<option value="<?php echo esc_attr( $t->slug ); ?>" <?php selected( $cur_tp, $t->slug ); ?>><?php echo esc_html( $t->name ); ?></option>
				<?php endforeach; ?>
			</select>
		</div>
		<button type="submit" class="go">Find Now</button>
	</form>
	<?php
}

/**
 * Detect a third-party SEO plugin so the theme does not emit duplicate
 * Organization/WebSite/Breadcrumb schema. The live site runs AIOSEO.
 */
function ypgh_seo_plugin_active() {
	return (
		function_exists( 'aioseo' ) ||
		defined( 'AIOSEO_VERSION' ) ||
		defined( 'WPSEO_VERSION' ) ||
		class_exists( 'RankMath' ) ||
		function_exists( 'the_seo_framework' )
	);
}
