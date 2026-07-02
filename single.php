<?php
/**
 * Single post: editorial article.
 *
 * @package yourplacegh
 */

get_header();

while ( have_posts() ) :
	the_post();
	?>
<article class="article">
	<div class="a-meta"><?php echo esc_html( get_the_date() ); ?> &middot; Yourplace GH</div>
	<h1><?php the_title(); ?></h1>
	<?php if ( has_post_thumbnail() ) : ?>
	<div class="a-media"><?php the_post_thumbnail( 'large' ); ?></div>
	<?php endif; ?>
	<div class="article-content"><?php the_content(); ?></div>
</article>
	<?php
endwhile;

get_template_part( 'template-parts/cta' );
get_footer();
