<?php
/**
 * Generic fallback template.
 *
 * @package yourplacegh
 */

get_header();
?>
<div class="page-head"><div class="wrap"><h1><?php echo is_search() ? 'Search results' : esc_html( get_the_title() ); ?></h1></div></div>
<section class="section">
	<div class="wrap">
		<?php
		if ( have_posts() ) {
			echo '<div class="posts-grid">';
			while ( have_posts() ) {
				the_post();
				?>
			<article class="post-card">
				<div class="pc-body">
					<div class="pc-meta"><?php echo esc_html( get_the_date() ); ?></div>
					<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
					<p><?php echo esc_html( wp_trim_words( get_the_excerpt(), 18 ) ); ?></p>
				</div>
			</article>
				<?php
			}
			echo '</div>';
		} else {
			echo '<p class="lede">Nothing found.</p>';
		}
		?>
	</div>
</section>
<?php get_footer(); ?>
