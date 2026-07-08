<?php
/**
 * Location archive.
 *
 * @package ypgh
 */

get_header();
?>
<section class="archive-head">
	<div class="wrap">
		<h1><?php esc_html_e( 'Neighborhood guides', 'ypgh' ); ?></h1>
		<p class="archive-intro"><?php esc_html_e( 'Honest read-outs on safety, utilities, flood risk, and land title risk for areas across Ghana.', 'ypgh' ); ?></p>
	</div>
</section>

<section class="section">
	<div class="wrap">
		<?php if ( have_posts() ) : ?>
			<div class="location-grid">
				<?php while ( have_posts() ) : the_post(); ?>
					<a class="location-card" href="<?php the_permalink(); ?>">
						<?php if ( has_post_thumbnail() ) : the_post_thumbnail( 'ypgh_card', array( 'loading' => 'lazy' ) ); endif; ?>
						<span class="location-name"><?php the_title(); ?></span>
					</a>
				<?php endwhile; ?>
			</div>
			<div class="pagination"><?php the_posts_pagination( array( 'mid_size' => 1 ) ); ?></div>
		<?php else : ?>
			<p class="empty"><?php esc_html_e( 'No neighborhood guides published yet.', 'ypgh' ); ?></p>
		<?php endif; ?>
	</div>
</section>
<?php
get_footer();
