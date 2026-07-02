<?php
/**
 * Closing CTA strip.
 *
 * @package yourplacegh
 */
?>
<section class="cta-strip">
	<div class="wrap">
		<div>
			<h2>Ready to find your place in <span class="accent">Accra?</span></h2>
			<p>Tell us what you're looking for - a home, an investment, a plot, or a build. We'll be straight with you about what's realistic.</p>
		</div>
		<div class="cta-actions">
			<a class="btn btn-white" href="<?php echo esc_url( ypgh_page_url( 'contact', '/contact/' ) ); ?>">Start a conversation</a>
			<a class="btn btn-ghost-w" href="<?php echo esc_url( get_post_type_archive_link( 'property' ) ); ?>">Browse properties</a>
		</div>
	</div>
</section>
