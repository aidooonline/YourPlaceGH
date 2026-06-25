<?php
/**
 * Hero slider. Slide backgrounds use Customizer-overridable images with a
 * stable placeholder fallback.
 *
 * @package YourPlaceGH
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$slides = array(
	array(
		'bg'      => get_theme_mod( 'ypgh_hero1', 'https://picsum.photos/seed/ypgh1/1920/1080' ),
		'eyebrow' => 'Where your place becomes home',
		'title'   => 'Find Your Dream Property',
		'align'   => '',
	),
	array(
		'bg'      => get_theme_mod( 'ypgh_hero2', 'https://picsum.photos/seed/ypgh2/1920/1080' ),
		'eyebrow' => 'Real estate made simple',
		'title'   => 'Maximizing Value, Minimizing Hassle',
		'align'   => 'center',
	),
	array(
		'bg'      => get_theme_mod( 'ypgh_hero3', 'https://picsum.photos/seed/ypgh3/1920/1080' ),
		'eyebrow' => 'We care for you',
		'title'   => 'Expert Advice for Solid Foundations',
		'align'   => 'right',
	),
);
$enquire = esc_url( home_url( '/contact/' ) );
$home_ic = '<svg viewBox="0 0 24 24"><path d="M12 3l9 8h-3v8h-4v-5h-4v5H6v-8H3l9-8z"/></svg>';
?>
<section class="hero" id="hero">
	<?php foreach ( $slides as $i => $s ) : ?>
		<div class="slide<?php echo 0 === $i ? ' active' : ''; ?>" style="background-image:url('<?php echo esc_url( $s['bg'] ); ?>')">
			<div class="inner"><div class="container">
				<div class="copy <?php echo esc_attr( $s['align'] ); ?>">
					<div class="eyebrow"><?php echo $home_ic; // phpcs:ignore ?> <?php echo esc_html( $s['eyebrow'] ); ?></div>
					<h1><?php echo esc_html( $s['title'] ); ?></h1>
					<a class="btn btn-primary" href="<?php echo $enquire; ?>">Make An Enquiry</a>
				</div>
			</div></div>
		</div>
	<?php endforeach; ?>
	<div class="hero-nav"><button id="prev" aria-label="Previous">&#8249;</button><button id="next" aria-label="Next">&#8250;</button></div>
	<div class="dots" id="dots"></div>
</section>
