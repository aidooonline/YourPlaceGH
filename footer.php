<?php
/**
 * Footer: editorial four-column footer.
 *
 * @package yourplacegh
 */

$nap = ypgh_nap();
?>
<footer class="site-footer">
	<div class="wrap">
		<div class="footer-grid">
			<div>
				<a class="brand" href="<?php echo esc_url( home_url( '/' ) ); ?>">Yourplace<span class="dot">.</span>GH</a>
				<p class="f-tag"><?php esc_html_e( 'Full-service real estate for Accra: brokerage, consulting and construction under one roof. Rooted in Ga East, active city-wide, trusted by the diaspora.', 'yourplacegh' ); ?></p>
				<div class="f-social">
					<a href="<?php echo esc_url( $nap['facebook'] ); ?>" target="_blank" rel="noopener" aria-label="Facebook">FB</a>
					<a href="<?php echo esc_url( $nap['linkedin'] ); ?>" target="_blank" rel="noopener" aria-label="LinkedIn">IN</a>
				</div>
			</div>
			<div>
				<h4><?php esc_html_e( 'Explore', 'yourplacegh' ); ?></h4>
				<?php
				wp_nav_menu(
					array(
						'theme_location' => 'footer-company',
						'container'      => false,
						'fallback_cb'    => 'ypgh_nav_fallback',
						'depth'          => 1,
					)
				);
				?>
			</div>
			<div>
				<h4><?php esc_html_e( 'Services', 'yourplacegh' ); ?></h4>
				<ul>
					<li><a href="<?php echo esc_url( ypgh_page_url( 'services', '/services/' ) ); ?>#brokerage"><?php esc_html_e( 'Brokerage', 'yourplacegh' ); ?></a></li>
					<li><a href="<?php echo esc_url( ypgh_page_url( 'services', '/services/' ) ); ?>#consulting"><?php esc_html_e( 'Consulting', 'yourplacegh' ); ?></a></li>
					<li><a href="<?php echo esc_url( ypgh_page_url( 'services', '/services/' ) ); ?>#construction"><?php esc_html_e( 'Construction', 'yourplacegh' ); ?></a></li>
					<li><a href="<?php echo esc_url( ypgh_page_url( 'diaspora', '/diaspora/' ) ); ?>"><?php esc_html_e( 'Diaspora buyers', 'yourplacegh' ); ?></a></li>
				</ul>
			</div>
			<div>
				<h4><?php esc_html_e( 'Contact', 'yourplacegh' ); ?></h4>
				<ul class="f-contact">
					<li><span class="ic">&#9678;</span><span><?php echo esc_html( $nap['address'] ); ?></span></li>
					<li><span class="ic">&#9742;</span><a href="tel:+233539601097"><?php echo esc_html( $nap['phone'] ); ?></a></li>
					<li><span class="ic">&#9993;</span><a href="mailto:<?php echo esc_attr( $nap['email'] ); ?>"><?php echo esc_html( $nap['email'] ); ?></a></li>
					<li><span class="ic">&#9719;</span><span><?php esc_html_e( 'Mon - Fri: 8:00am - 5:30pm', 'yourplacegh' ); ?><br><?php esc_html_e( 'Sat: 9:00am - 2:00pm', 'yourplacegh' ); ?></span></li>
				</ul>
			</div>
		</div>
		<div class="copyright">
			<span>&copy; <?php echo esc_html( gmdate( 'Y' ) ); ?> Yourplace GH. <?php esc_html_e( 'All rights reserved.', 'yourplacegh' ); ?></span>
			<span><?php esc_html_e( 'Real estate, consulting and construction: Accra, Ghana.', 'yourplacegh' ); ?></span>
		</div>
	</div>
</footer>
<?php wp_footer(); ?>
</body>
</html>
