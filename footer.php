<?php
/**
 * Footer.
 *
 * @package ypgh
 */

?>
</main>

<footer class="site-footer">
	<div class="wrap footer-grid">
		<div class="footer-brand">
			<span class="brand"><span class="brand-mark">YourPlace</span><span class="brand-gh">GH</span></span>
			<p class="footer-tag"><?php esc_html_e( 'Verified property and land across Ghana, with the trust checks the market forgets.', 'ypgh' ); ?></p>
		</div>

		<div class="footer-col">
			<h3><?php esc_html_e( 'Explore', 'ypgh' ); ?></h3>
			<?php
			wp_nav_menu(
				array(
					'theme_location' => 'footer',
					'container'      => false,
					'menu_class'     => 'footer-list',
					'fallback_cb'    => false,
					'depth'          => 1,
				)
			);
			?>
		</div>

		<div class="footer-col footer-contact">
			<h3><?php esc_html_e( 'Contact', 'ypgh' ); ?></h3>
			<address>
				HN 7, Nii Adjei Nkroma Street,<br>
				Manet, Teshie, Accra<br>
				<a href="tel:+233539601097">053 960 1097</a><br>
				<a href="mailto:info@yourplacegh.com">info@yourplacegh.com</a>
			</address>
		</div>
	</div>

	<div class="wrap footer-base">
		<p>&copy; <?php echo esc_html( gmdate( 'Y' ) ); ?> YourPlaceGH. <?php esc_html_e( 'All rights reserved.', 'ypgh' ); ?></p>
	</div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
