<?php
/**
 * Services.
 *
 * @package YourPlaceGH
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
$contact = esc_url( home_url( '/contact/' ) );
?>
<section class="section" id="services">
	<div class="container">
		<div class="section-head reveal">
			<div class="eyebrow">Our Services</div>
			<h2>What we do for you</h2>
		</div>
		<div class="services">
			<div class="service reveal">
				<div class="ico"><svg viewBox="0 0 24 24"><path d="M12 3l9 8h-3v8h-4v-5h-4v5H6v-8H3l9-8z"/></svg></div>
				<h3>Sales &amp; Lettings</h3>
				<p>Expertly connecting you with the perfect property for sale and rent in Ghana.</p>
				<a class="more" href="<?php echo $contact; ?>">Find a home &rarr;</a>
			</div>
			<div class="service reveal">
				<div class="ico"><svg viewBox="0 0 24 24"><path d="M3 13h2v8H3v-8zm4-4h2v12H7V9zm4-4h2v16h-2V5zm4 8h2v8h-2v-8zm4-6h2v14h-2V7z"/></svg></div>
				<h3>Asset Management</h3>
				<p>Maximizing your real estate investments through professional asset management.</p>
				<a class="more" href="<?php echo $contact; ?>">Learn more &rarr;</a>
			</div>
			<div class="service reveal">
				<div class="ico"><svg viewBox="0 0 24 24"><path d="M12 2L2 7v2h20V7L12 2zM4 11v8H2v2h20v-2h-2v-8h-2v8h-3v-8h-2v8h-2v-8H9v8H6v-8H4z"/></svg></div>
				<h3>Property Development</h3>
				<p>Guiding your construction projects from concept through to completion.</p>
				<a class="more" href="<?php echo $contact; ?>">Start a project &rarr;</a>
			</div>
		</div>
	</div>
</section>
