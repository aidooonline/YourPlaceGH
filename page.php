<?php
/**
 * Page.
 *
 * @package ypgh
 */

get_header();

while ( have_posts() ) :
	the_post();
	?>
<section class="page-hero">
	<div class="wrap">
		<p class="eyebrow"><?php esc_html_e( 'YourPlaceGH', 'ypgh' ); ?></p>
		<h1><?php the_title(); ?></h1>
	</div>
</section>

<section class="section">
	<div class="wrap wrap-narrow">
		<div class="listing-body page-content">
			<?php the_content(); ?>
			<?php
			wp_link_pages(
				array(
					'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'ypgh' ),
					'after'  => '</div>',
				)
			);
			?>
		</div>
	</div>
</section>
	<?php
endwhile;

get_footer();
