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

	$tag_class = 'tag';
	if ( $status ) {
		if ( false !== stripos( $status->slug, 'sale' ) ) {
			$tag_class .= ' sale';
		} elseif ( false !== stripos( $status->slug, 'rent' ) ) {
			$tag_class .= ' rent';
		}
	}
	?>
	<article class="card">
		<a class="card-media" href="<?php echo esc_url( $link ); ?>" style="background-image:url('<?php echo esc_url( ypgh_card_image( $post_id ) ); ?>')" aria-label="<?php echo esc_attr( get_the_title( $post_id ) ); ?>">
			<?php if ( $status ) : ?><span class="<?php echo esc_attr( $tag_class ); ?>"><?php echo esc_html( $status->name ); ?></span><?php endif; ?>
		</a>
		<div class="card-body">
			<div class="price"><?php echo wp_kses_post( ypgh_price_html( $post_id ) ); ?></div>
			<h3><a href="<?php echo esc_url( $link ); ?>"><?php echo esc_html( get_the_title( $post_id ) ); ?></a></h3>
			<?php if ( $area ) : ?><div class="loc"><?php echo esc_html( $area->name ); ?></div><?php endif; ?>
		</div>
		<div class="card-specs">
			<?php if ( $beds > 0 ) : ?><span class="spec"><b><?php echo esc_html( $beds ); ?></b> Beds</span><?php endif; ?>
			<?php if ( $baths > 0 ) : ?><span class="spec"><b><?php echo esc_html( $baths ); ?></b> Baths</span><?php endif; ?>
			<?php if ( $size ) : ?><span class="spec"><b><?php echo esc_html( $size ); ?></b> Area</span><?php endif; ?>
			<?php if ( $beds <= 0 && $baths <= 0 && ! $size ) : ?><span class="spec"><b><?php esc_html_e( 'View', 'yourplacegh' ); ?></b> Details</span><?php endif; ?>
		</div>
	</article>
	<?php
}

/**
 * Resolve a theme page URL by slug with a fallback path.
 */
function ypgh_page_url( $slug, $fallback = '/' ) {
	$page = get_page_by_path( $slug );
	if ( $page ) {
		return get_permalink( $page );
	}
	return home_url( $fallback );
}

/**
 * Primary menu fallback: core pages + property archive.
 */
function ypgh_nav_fallback() {
	$archive = get_post_type_archive_link( 'property' );
	echo '<ul>';
	echo '<li><a href="' . esc_url( $archive ? $archive : home_url( '/' ) ) . '">Properties</a></li>';
	echo '<li><a href="' . esc_url( ypgh_page_url( 'services', '/services/' ) ) . '">Services</a></li>';
	echo '<li><a href="' . esc_url( ypgh_page_url( 'diaspora', '/diaspora/' ) ) . '">Diaspora</a></li>';
	echo '<li><a href="' . esc_url( ypgh_page_url( 'insights', '/insights/' ) ) . '">Insights</a></li>';
	echo '<li><a href="' . esc_url( ypgh_page_url( 'about', '/about/' ) ) . '">About</a></li>';
	echo '<li><a href="' . esc_url( ypgh_page_url( 'contact', '/contact/' ) ) . '">Contact</a></li>';
	echo '</ul>';
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
