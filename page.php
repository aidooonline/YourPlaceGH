<?php
/**
 * Default page template.
 *
 * @package yourplacegh
 */

get_header();

while ( have_posts() ) :
	the_post();
	?>
<div class="page-head"><div class="wrap"><h1><?php the_title(); ?></h1></div></div>
<section class="section"><div class="wrap"><div class="article-content" style="max-width:760px"><?php the_content(); ?></div></div></section>
	<?php
endwhile;

get_footer();
