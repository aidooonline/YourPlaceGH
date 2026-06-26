<?php
/**
 * Archive for properties and property taxonomies.
 *
 * @package YourPlaceGH
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

if ( is_tax() ) {
	$term  = get_queried_object();
	$title = $term ? $term->name : post_type_archive_title( '', false );
} else {
	$title = post_type_archive_title( '', false );
	$title = $title ? $title : __( 'Properties', 'yourplacegh' );
}
$archive = get_post_type_archive_link( 'property' );

$area_img = '';
$area_tag = '';
if ( is_tax( 'property_area' ) && $term ) {
	$area_img = get_term_meta( $term->term_id, '_ypgh_area_image', true );
	$area_tag = get_term_meta( $term->term_id, '_ypgh_area_tag', true );
}
$head_class = $area_img ? 'page-head has-img' : 'page-head';
$head_style = $area_img ? ' style="background-image:url(\'' . esc_url( $area_img ) . '\')"' : '';
?>
<div class="<?php echo esc_attr( $head_class ); ?>"<?php echo $head_style; // phpcs:ignore ?>>
	<div class="container">
		<?php if ( $area_tag ) : ?><div class="page-head-tag"><?php echo esc_html( $area_tag ); ?></div><?php endif; ?>
		<h1><?php echo esc_html( $title ); ?></h1>
		<div class="crumbs"><a href="<?php echo esc_url( home_url( '/' ) ); ?>">Home</a> &middot; <?php if ( is_tax() && $archive ) : ?><a href="<?php echo esc_url( $archive ); ?>">Properties</a> &middot; <?php endif; ?><?php echo esc_html( $title ); ?></div>
	</div>
</div>

<div class="container archive-search"><?php ypgh_search_bar(); ?></div>

<div class="container">
	<?php if ( have_posts() ) : ?>
		<p class="results-meta"><?php echo esc_html( $GLOBALS['wp_query']->found_posts ); ?> listing(s) found</p>
		<div class="listings">
			<?php while ( have_posts() ) : the_post(); ?>
				<div class="reveal"><?php ypgh_render_property_card( get_the_ID() ); ?></div>
			<?php endwhile; ?>
		</div>

		<div class="pagination">
			<?php echo paginate_links( array( 'mid_size' => 1, 'prev_text' => '&laquo;', 'next_text' => '&raquo;' ) ); // phpcs:ignore ?>
		</div>
	<?php else : ?>
		<p class="empty">No listings match your search. Try widening the filters above.</p>
	<?php endif; ?>
</div>

<div style="height:90px"></div>
<?php
get_footer();
