<?php
/**
 * Template Name: Insights
 *
 * Market insights and advice hub, driven by blog posts.
 *
 * @package ypgh
 */

get_header();

$paged   = max( 1, get_query_var( 'paged' ), get_query_var( 'page' ) );
$posts_q = new WP_Query(
	array(
		'post_type'      => 'post',
		'post_status'    => 'publish',
		'posts_per_page' => 9,
		'paged'          => $paged,
	)
);

while ( have_posts() ) :
	the_post();
	?>

<section class="page-hero">
	<div class="wrap">
		<p class="eyebrow"><?php esc_html_e( 'Market insights and advice', 'ypgh' ); ?></p>
		<h1><?php the_title(); ?></h1>
		<p class="page-hero-sub"><?php esc_html_e( 'Guides on buying land safely, understanding rent law, reading a title, and where the Ghana property market is heading.', 'ypgh' ); ?></p>
	</div>
</section>

<section class="section">
	<div class="wrap">
		<?php if ( $posts_q->have_posts() ) : ?>
			<div class="insight-grid">
				<?php
				while ( $posts_q->have_posts() ) :
					$posts_q->the_post();
					$cats = get_the_category();
					?>
					<article class="insight-card">
						<a class="insight-media" href="<?php the_permalink(); ?>">
							<?php if ( has_post_thumbnail() ) : ?>
								<?php the_post_thumbnail( 'ypgh_card', array( 'loading' => 'lazy' ) ); ?>
							<?php else : ?>
								<span class="insight-media-empty"><?php bloginfo( 'name' ); ?></span>
							<?php endif; ?>
						</a>
						<div class="insight-body">
							<?php if ( $cats ) : ?>
								<span class="insight-cat"><?php echo esc_html( $cats[0]->name ); ?></span>
							<?php endif; ?>
							<h3 class="insight-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
							<p class="insight-excerpt"><?php echo esc_html( wp_trim_words( get_the_excerpt(), 22 ) ); ?></p>
							<div class="insight-meta">
								<time datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>"><?php echo esc_html( get_the_date() ); ?></time>
								<span class="insight-read"><?php esc_html_e( 'Read', 'ypgh' ); ?></span>
							</div>
						</div>
					</article>
					<?php
				endwhile;
				?>
			</div>

			<?php if ( $posts_q->max_num_pages > 1 ) : ?>
				<div class="pagination">
					<div class="nav-links">
						<?php
						echo paginate_links(
							array(
								'total'     => $posts_q->max_num_pages,
								'current'   => $paged,
								'prev_text' => __( 'Previous', 'ypgh' ),
								'next_text' => __( 'Next', 'ypgh' ),
							)
						); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
						?>
					</div>
				</div>
			<?php endif; ?>
			<?php wp_reset_postdata(); ?>
		<?php else : ?>
			<p class="empty"><?php esc_html_e( 'No articles published yet. Insights and market guides will appear here.', 'ypgh' ); ?></p>
		<?php endif; ?>
	</div>
</section>

	<?php
endwhile;

get_footer();
