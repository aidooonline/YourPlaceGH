<?php
/**
 * 404 template.
 *
 * @package yourplacegh
 */

get_header();
?>
<div class="error-page">
	<h1>404</h1>
	<h2>This page has <span class="accent">moved on.</span></h2>
	<p class="lede" style="margin:18px auto 34px">The page you're looking for doesn't exist. Let's get you back to somewhere useful.</p>
	<a class="btn btn-gold" href="<?php echo esc_url( home_url( '/' ) ); ?>">Back to home</a>
</div>
<?php get_footer(); ?>
