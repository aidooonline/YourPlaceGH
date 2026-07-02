<?php
/**
 * Insights: blog index.
 *
 * @package yourplacegh
 */

get_header();
?>
<div class="page-head">
	<div class="wrap">
		<span class="eyebrow">Insights</span>
		<h1>Property <span class="accent">intelligence</span></h1>
		<p class="lede">Market analysis, buying guides, and area intelligence for Accra - written by the team on the ground.</p>
	</div>
</div>

<section class="section">
	<div class="wrap">
		<?php if ( have_posts() ) : ?>
		<div class="posts-grid">
			<?php
			while ( have_posts() ) :
				the_post();
				$thumb = get_the_post_thumbnail_url( get_the_ID(), 'large' );
				?>
			<article class="post-card reveal">
				<a class="pc-media" href="<?php the_permalink(); ?>" <?php echo $thumb ? 'style="background-image:url(\'' . esc_url( $thumb ) . '\')"' : ''; ?> aria-label="<?php the_title_attribute(); ?>"></a>
				<div class="pc-body">
					<div class="pc-meta"><?php echo esc_html( get_the_date() ); ?></div>
					<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
					<p><?php echo esc_html( wp_trim_words( get_the_excerpt(), 18 ) ); ?></p>
					<a class="pc-more" href="<?php the_permalink(); ?>">Read more</a>
				</div>
			</article>
			<?php endwhile; ?>
		</div>
		<div class="pagination"><?php echo wp_kses_post( paginate_links( array( 'prev_text' => '&larr;', 'next_text' => '&rarr;' ) ) ); ?></div>
		<?php else : ?>
		<p class="lede">No insights published yet. Check back soon.</p>
		<?php endif; ?>
	</div>
</section>

<?php
get_template_part( 'template-parts/cta' );
get_footer();
