<?php
/**
 * Page.
 *
 * @package ypgh
 */

get_header();
?>
<section class="section">
	<div class="wrap wrap-narrow">
		<?php while ( have_posts() ) : the_post(); ?>
			<h1 class="page-title"><?php the_title(); ?></h1>
			<div class="listing-body"><?php the_content(); ?></div>
		<?php endwhile; ?>
	</div>
</section>
<?php
get_footer();
