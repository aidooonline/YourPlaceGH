<?php
/**
 * Trust / partner logos.
 *
 * @package YourPlaceGH
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
$logos = array( 'FNB', 'Stanbic Bank', 'GREPA', 'NAR &middot; ABR', 'CIPS' );
?>
<section class="trust">
	<div class="container">
		<div class="row reveal">
			<?php foreach ( $logos as $logo ) : ?>
				<div class="logo"><?php echo wp_kses_post( $logo ); ?></div>
			<?php endforeach; ?>
		</div>
		<p class="cap">Working alongside Ghana's trusted financial and professional bodies.</p>
	</div>
</section>
