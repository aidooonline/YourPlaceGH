<?php
/**
 * Property intelligence: latest posts.
 *
 * @package yourplacegh
 */

$q = new WP_Query(
	array(
		'post_type'      => 'post',
		'posts_per_page' => 3,
		'no_found_rows'  => true,
	)
);
if ( ! $q->have_posts() ) {
	return;
}
?>
<section class="section">
	<div class="wrap">
		<div class="sec-head reveal">
			<div>
				<span class="eyebrow">Insights</span>
				<h2>Property <span class="accent">intelligence</span></h2>
			</div>
			<a class="sec-link" href="<?php echo esc_url( ypgh_page_url( 'insights', '/insights/' ) ); ?>">All insights &rarr;</a>
		</div>
		<div class="posts-grid">
			<?php
			while ( $q->have_posts() ) :
				$q->the_post();
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
			<?php endwhile; wp_reset_postdata(); ?>
		</div>
	</div>
</section>
