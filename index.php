<?php
/**
 * Generic fallback (blog index, search, etc.).
 *
 * @package YourPlaceGH
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>
<main class="content-wrap">
	<?php if ( have_posts() ) : ?>
		<?php if ( is_home() && ! is_front_page() ) : ?>
			<h1><?php single_post_title(); ?></h1>
		<?php elseif ( is_search() ) : ?>
			<h1><?php printf( esc_html__( 'Search results for: %s', 'yourplacegh' ), esc_html( get_search_query() ) ); ?></h1>
		<?php endif; ?>

		<?php while ( have_posts() ) : the_post(); ?>
			<article <?php post_class( 'reveal' ); ?> style="margin-bottom:40px">
				<h2 style="margin-bottom:8px"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
				<p style="color:var(--muted);font-size:14px"><?php echo esc_html( get_the_date() ); ?></p>
				<div><?php the_excerpt(); ?></div>
			</article>
		<?php endwhile; ?>

		<div class="pagination"><?php echo paginate_links( array( 'prev_text' => '&laquo;', 'next_text' => '&raquo;' ) ); // phpcs:ignore ?></div>
	<?php else : ?>
		<h1>Nothing found</h1>
		<p>No content matched your request. Try the <a href="<?php echo esc_url( home_url( '/' ) ); ?>">homepage</a> or search again.</p>
	<?php endif; ?>
</main>
<?php
get_footer();
