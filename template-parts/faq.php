<?php
/**
 * Visible FAQ. Mirrors ypgh_faq_items() so the FAQPage schema matches the page.
 *
 * @package YourPlaceGH
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
$items = ypgh_faq_items();
?>
<section class="faq-sec" id="faq">
	<div class="container">
		<div class="section-head reveal">
			<div class="eyebrow">Good to know</div>
			<h2>Frequently asked questions</h2>
		</div>
		<div class="faq-list">
			<?php foreach ( $items as $item ) : ?>
				<div class="faq-item reveal">
					<button class="faq-q" type="button"><?php echo esc_html( $item['q'] ); ?><span class="pm">+</span></button>
					<div class="faq-a"><?php echo esc_html( $item['a'] ); ?></div>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>
