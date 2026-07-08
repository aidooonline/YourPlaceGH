<?php
/**
 * Fallback index.
 *
 * @package ypgh
 */

get_header();
?>
<section class="section">
	<div class="wrap">
		<?php if ( have_posts() ) : ?>
			<?php if ( is_home() && ! is_front_page() ) : ?>
				<h1 class="page-title"><?php single_post_title(); ?></h1>
			<?php endif; ?>
			<div class="post-list">
				<?php while ( have_posts() ) : the_post(); ?>
					<article <?php post_class( 'post-item' ); ?>>
						<h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
						<div class="post-excerpt"><?php the_excerpt(); ?></div>
					</article>
				<?php endwhile; ?>
			</div>
			<div class="pagination"><?php the_posts_pagination( array( 'mid_size' => 1 ) ); ?></div>
		<?php else : ?>
			<p class="empty"><?php esc_html_e( 'Nothing here yet.', 'ypgh' ); ?></p>
		<?php endif; ?>
	</div>
</section>
<?php
get_footer();
