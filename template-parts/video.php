<?php
/**
 * Video band.
 *
 * @package YourPlaceGH
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$bg  = get_theme_mod( 'ypgh_video_bg', YPGH_URI . '/assets/img/video.jpg' );
$url = get_theme_mod( 'ypgh_video_url', '' );
?>
<section class="video-sec" style="background-image:url('<?php echo esc_url( $bg ); ?>')">
	<?php if ( $url ) : ?>
		<a class="play" href="<?php echo esc_url( $url ); ?>" target="_blank" rel="noopener" aria-label="Play video"><svg viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg></a>
	<?php else : ?>
		<button class="play" id="ypgh-play" aria-label="Play video"><svg viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg></button>
	<?php endif; ?>
</section>
