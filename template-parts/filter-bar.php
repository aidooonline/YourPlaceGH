<?php
/**
 * Filter bar for listing archive.
 *
 * @package ypgh
 */

$action = get_post_type_archive_link( 'yp_listing' );

$ptypes = get_terms(
	array(
		'taxonomy'   => 'yp_ptype',
		'hide_empty' => false,
	)
);
$cities = get_terms(
	array(
		'taxonomy'   => 'yp_city',
		'hide_empty' => false,
	)
);
?>
<form class="filter-bar" method="get" action="<?php echo esc_url( $action ); ?>" role="search">
	<div class="filter-field">
		<label for="f-ptype"><?php esc_html_e( 'Property type', 'ypgh' ); ?></label>
		<select id="f-ptype" name="yp_ptype">
			<option value=""><?php esc_html_e( 'Any type', 'ypgh' ); ?></option>
			<?php foreach ( $ptypes as $t ) : ?>
				<option value="<?php echo esc_attr( $t->slug ); ?>" <?php selected( get_query_var( 'yp_ptype' ), $t->slug ); ?>><?php echo esc_html( $t->name ); ?></option>
			<?php endforeach; ?>
		</select>
	</div>

	<div class="filter-field">
		<label for="f-city"><?php esc_html_e( 'City', 'ypgh' ); ?></label>
		<select id="f-city" name="yp_city">
			<option value=""><?php esc_html_e( 'Anywhere', 'ypgh' ); ?></option>
			<?php foreach ( $cities as $t ) : ?>
				<option value="<?php echo esc_attr( $t->slug ); ?>" <?php selected( get_query_var( 'yp_city' ), $t->slug ); ?>><?php echo esc_html( $t->name ); ?></option>
			<?php endforeach; ?>
		</select>
	</div>

	<div class="filter-field">
		<label for="f-min"><?php esc_html_e( 'Min price', 'ypgh' ); ?></label>
		<input id="f-min" type="number" name="min_price" inputmode="numeric" value="<?php echo esc_attr( get_query_var( 'min_price' ) ); ?>" placeholder="0">
	</div>

	<div class="filter-field">
		<label for="f-max"><?php esc_html_e( 'Max price', 'ypgh' ); ?></label>
		<input id="f-max" type="number" name="max_price" inputmode="numeric" value="<?php echo esc_attr( get_query_var( 'max_price' ) ); ?>" placeholder="<?php esc_attr_e( 'Any', 'ypgh' ); ?>">
	</div>

	<div class="filter-field">
		<label for="f-beds"><?php esc_html_e( 'Beds', 'ypgh' ); ?></label>
		<select id="f-beds" name="min_beds">
			<option value=""><?php esc_html_e( 'Any', 'ypgh' ); ?></option>
			<?php for ( $i = 1; $i <= 5; $i++ ) : ?>
				<option value="<?php echo esc_attr( $i ); ?>" <?php selected( get_query_var( 'min_beds' ), (string) $i ); ?>><?php echo esc_html( $i ); ?>+</option>
			<?php endfor; ?>
		</select>
	</div>

	<label class="filter-check">
		<input type="checkbox" name="verified" value="1" <?php checked( get_query_var( 'verified' ), '1' ); ?>>
		<?php esc_html_e( 'Verified only', 'ypgh' ); ?>
	</label>

	<button type="submit" class="btn btn-primary"><?php esc_html_e( 'Search', 'ypgh' ); ?></button>
</form>
