<?php
/**
 * Footer.
 *
 * @package YourPlaceGH
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
$nap     = ypgh_nap();
$archive = get_post_type_archive_link( 'property' );
$archive = $archive ? $archive : home_url( '/properties/' );
?>
<footer class="footer">
	<div class="container">
		<div class="cols">
			<div>
				<div class="brand" style="color:#fff"><b>YOURPLACE</b> <em style="color:var(--orange)">GH</em></div>
				<p>Discover top real estate listings in Ghana - buy, rent, and develop with a team that knows Accra street by street.</p>
				<ul class="fcontact">
					<li><svg viewBox="0 0 24 24"><path d="M12 2a7 7 0 00-7 7c0 5 7 13 7 13s7-8 7-13a7 7 0 00-7-7zm0 9.5A2.5 2.5 0 1112 6a2.5 2.5 0 010 5.5z"/></svg> <?php echo esc_html( $nap['address'] ); ?></li>
					<li><svg viewBox="0 0 24 24"><path d="M6.6 10.8a15.5 15.5 0 006.6 6.6l2.2-2.2a1 1 0 011-.24 11.4 11.4 0 003.6.57 1 1 0 011 1V20a1 1 0 01-1 1A17 17 0 013 4a1 1 0 011-1h3.5a1 1 0 011 1 11.4 11.4 0 00.57 3.6 1 1 0 01-.24 1l-2.23 2.2z"/></svg> <a href="tel:<?php echo esc_attr( preg_replace( '/\s+/', '', $nap['phone'] ) ); ?>"><?php echo esc_html( $nap['phone'] ); ?></a></li>
					<li><svg viewBox="0 0 24 24"><path d="M20 4H4a2 2 0 00-2 2v12a2 2 0 002 2h16a2 2 0 002-2V6a2 2 0 00-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z"/></svg> <a href="mailto:<?php echo esc_attr( $nap['email'] ); ?>"><?php echo esc_html( $nap['email'] ); ?></a></li>
				</ul>
				<div class="fsocial">
					<a href="<?php echo esc_url( $nap['facebook'] ); ?>" aria-label="Facebook"><svg viewBox="0 0 24 24"><path d="M14 9h3V6h-3c-1.7 0-3 1.3-3 3v2H9v3h2v7h3v-7h2.5l.5-3H14V9z"/></svg></a>
					<a href="<?php echo esc_url( $nap['twitter'] ); ?>" aria-label="X"><svg viewBox="0 0 24 24"><path d="M17 3h3l-7 8 8 10h-6l-5-6-5 6H2l8-9L2 3h6l4 5 5-5z"/></svg></a>
					<a href="<?php echo esc_url( $nap['linkedin'] ); ?>" aria-label="LinkedIn"><svg viewBox="0 0 24 24"><path d="M6.9 8.5H3.6V20h3.3V8.5zM5.2 3.6a1.9 1.9 0 100 3.8 1.9 1.9 0 000-3.8zM20.4 20h-3.3v-5.6c0-1.3 0-3-1.9-3s-2.1 1.4-2.1 2.9V20H9.8V8.5h3.1v1.6h.1c.4-.8 1.5-1.7 3.1-1.7 3.3 0 3.9 2.2 3.9 5V20z"/></svg></a>
				</div>
			</div>

			<div>
				<h4>Company</h4>
				<?php
				if ( has_nav_menu( 'footer-company' ) ) {
					wp_nav_menu( array( 'theme_location' => 'footer-company', 'container' => false, 'menu_class' => '', 'depth' => 1 ) );
				} else {
					echo '<ul>';
					echo '<li><a href="' . esc_url( home_url( '/about/' ) ) . '">About us</a></li>';
					echo '<li><a href="' . esc_url( home_url( '/blog/' ) ) . '">Blog</a></li>';
					echo '<li><a href="' . esc_url( $archive ) . '">All Listings</a></li>';
					echo '<li><a href="' . esc_url( home_url( '/#faq' ) ) . '">FAQ</a></li>';
					echo '<li><a href="' . esc_url( home_url( '/contact/' ) ) . '">Contact us</a></li>';
					echo '</ul>';
				}
				?>
			</div>

			<div>
				<h4>Services</h4>
				<?php
				if ( has_nav_menu( 'footer-services' ) ) {
					wp_nav_menu( array( 'theme_location' => 'footer-services', 'container' => false, 'menu_class' => '', 'depth' => 1 ) );
				} else {
					echo '<ul>';
					echo '<li><a href="' . esc_url( home_url( '/#services' ) ) . '">Sales &amp; Lettings</a></li>';
					echo '<li><a href="' . esc_url( home_url( '/#services' ) ) . '">Asset Management</a></li>';
					echo '<li><a href="' . esc_url( home_url( '/#services' ) ) . '">Property Development</a></li>';
					echo '<li><a href="' . esc_url( home_url( '/contact/' ) ) . '">Free Valuation</a></li>';
					echo '</ul>';
				}
				?>
			</div>

			<div>
				<h4>Newsletter</h4>
				<p>Get new listings and market updates by email. No spam.</p>
				<form class="news" action="<?php echo esc_url( home_url( '/' ) ); ?>" method="post" onsubmit="return false">
					<input type="email" name="ypgh_news_email" placeholder="Your email address" aria-label="Email">
					<button aria-label="Subscribe"><svg viewBox="0 0 24 24"><path d="M2 21l21-9L2 3v7l15 2-15 2z"/></svg></button>
				</form>
			</div>
		</div>

		<div class="copyright">
			<div class="container" style="padding:0">
				<span>All rights reserved &copy; <?php echo esc_html( get_bloginfo( 'name' ) ); ?> <?php echo esc_html( gmdate( 'Y' ) ); ?></span>
				<span><a href="<?php echo esc_url( home_url( '/terms/' ) ); ?>">Terms &amp; Conditions</a> &nbsp;&middot;&nbsp; <a href="<?php echo esc_url( home_url( '/privacy/' ) ); ?>">Privacy Policy</a></span>
			</div>
		</div>
	</div>
</footer>
<?php wp_footer(); ?>
</body>
</html>
