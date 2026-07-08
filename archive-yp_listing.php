<?php
/**
 * Listing archive.
 *
 * @package ypgh
 */

get_header();
?>

<section class="archive-head">
	<div class="wrap">
		<h1><?php esc_html_e( 'Listings', 'ypgh' ); ?></h1>
		<?php get_template_part( 'template-parts/filter-bar' ); ?>
	</div>
</section>

<section class="section">
	<div class="wrap">
		<div class="archive-toolbar">
			<p class="result-count">
				<?php
				global $wp_query;
				printf(
					/* translators: %d: number of results. */
					esc_html( _n( '%d result', '%d results', (int) $wp_query->found_posts, 'ypgh' ) ),
					(int) $wp_query->found_posts
				);
				?>
			</p>
			<div class="toolbar-right">
				<button type="button" id="view-toggle" class="btn btn-ghost" data-map-label="<?php esc_attr_e( 'Map view', 'ypgh' ); ?>" data-grid-label="<?php esc_attr_e( 'Grid view', 'ypgh' ); ?>"><?php esc_html_e( 'Map view', 'ypgh' ); ?></button>
				<div class="sort">
					<label for="sort"><?php esc_html_e( 'Sort', 'ypgh' ); ?></label>
					<select id="sort" onchange="ypghSort(this.value)">
						<?php $sort = isset( $_GET['sort'] ) ? sanitize_key( wp_unslash( $_GET['sort'] ) ) : ''; // phpcs:ignore ?>
						<option value=""><?php esc_html_e( 'Newest', 'ypgh' ); ?></option>
						<option value="price_asc" <?php selected( $sort, 'price_asc' ); ?>><?php esc_html_e( 'Price low to high', 'ypgh' ); ?></option>
						<option value="price_desc" <?php selected( $sort, 'price_desc' ); ?>><?php esc_html_e( 'Price high to low', 'ypgh' ); ?></option>
					</select>
				</div>
			</div>
		</div>

		<?php if ( have_posts() ) : ?>
			<div id="archive-map-wrap" hidden>
				<div id="archive-map"></div>
			</div>

			<div id="listing-results" class="listing-grid">
				<?php
				while ( have_posts() ) :
					the_post();
					get_template_part( 'template-parts/listing-card' );
				endwhile;
				?>
			</div>

			<div class="pagination">
				<?php
				the_posts_pagination(
					array(
						'mid_size'  => 1,
						'prev_text' => __( 'Previous', 'ypgh' ),
						'next_text' => __( 'Next', 'ypgh' ),
					)
				);
				?>
			</div>
		<?php else : ?>
			<p class="empty"><?php esc_html_e( 'No listings match those filters. Try widening your price range or clearing the verified-only toggle.', 'ypgh' ); ?></p>
		<?php endif; ?>
	</div>
</section>

<?php
get_footer();
