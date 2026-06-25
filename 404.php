<?php
/**
 * 404.
 *
 * @package YourPlaceGH
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
$archive = get_post_type_archive_link( 'property' );
?>
<main class="content-wrap" style="text-align:center">
	<h1>Page not found</h1>
	<p>The page you were looking for is not here. It may have moved, or the link may be out of date.</p>
	<p style="margin-top:24px">
		<a class="btn btn-primary" href="<?php echo esc_url( home_url( '/' ) ); ?>">Back to home</a>
		<?php if ( $archive ) : ?><a class="btn btn-white" href="<?php echo esc_url( $archive ); ?>">Browse listings</a><?php endif; ?>
	</p>
</main>
<?php
get_footer();
