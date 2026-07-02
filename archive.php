<?php
/**
 * Property archive and taxonomy pages.
 *
 * @package yourplacegh
 */

get_header();

global $wp_query;

$title = 'Properties';
$term  = null;
if ( is_tax() ) {
	$term  = get_queried_object();
	$title = $term ? $term->name : $title;
} elseif ( is_post_type_archive( 'property' ) ) {
	$title = 'Properties in Accra';
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
	<div class="wrap">
		<?php if ( $area_tag ) : ?><div class="page-head-tag"><?php echo esc_html( $area_tag ); ?></div><?php endif; ?>
		<h1><?php echo esc_html( $title ); ?></h1>
		<div class="crumbs"><a href="<?php echo esc_url( home_url( '/' ) ); ?>">Home</a> &middot; <?php if ( is_tax() && $archive ) : ?><a href="<?php echo esc_url( $archive ); ?>">Properties</a> &middot; <?php endif; ?><?php echo esc_html( $title ); ?></div>
	</div>
</div>

<div class="archive-tools">
	<div class="wrap"><?php ypgh_search_bar(); ?></div>
</div>

<section class="section" style="padding-top:24px">
	<div class="wrap">
		<?php if ( have_posts() ) : ?>
			<p class="results-meta"><?php echo esc_html( (int) $wp_query->found_posts ); ?> listings found</p>
			<div class="cards-grid">
				<?php
				while ( have_posts() ) {
					the_post();
					echo '<div class="reveal">';
					ypgh_render_property_card( get_the_ID() );
					echo '</div>';
				}
				?>
			</div>
			<div class="pagination"><?php echo wp_kses_post( paginate_links( array( 'prev_text' => '&larr;', 'next_text' => '&rarr;' ) ) ); ?></div>
		<?php else : ?>
			<p class="results-meta" style="margin-top:34px">No listings match your search yet. Try widening the filters, or <a href="<?php echo esc_url( ypgh_page_url( 'contact', '/contact/' ) ); ?>" style="border-bottom:1px solid var(--gold)">tell us what you're looking for</a> - much of our inventory moves before it's listed.</p>
		<?php endif; ?>
	</div>
</section>

<?php
get_template_part( 'template-parts/cta' );
get_footer();
