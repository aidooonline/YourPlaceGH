<?php
/**
 * Header.
 *
 * @package YourPlaceGH
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
$nap = ypgh_nap();
?><!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<div class="topbar">
	<div class="container">
		<ul>
			<li><svg class="ic" viewBox="0 0 24 24"><path d="M20 4H4a2 2 0 00-2 2v12a2 2 0 002 2h16a2 2 0 002-2V6a2 2 0 00-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z"/></svg><a href="mailto:<?php echo esc_attr( $nap['email'] ); ?>"><?php echo esc_html( $nap['email'] ); ?></a></li>
			<li><svg class="ic" viewBox="0 0 24 24"><path d="M12 2a7 7 0 00-7 7c0 5 7 13 7 13s7-8 7-13a7 7 0 00-7-7zm0 9.5A2.5 2.5 0 1112 6a2.5 2.5 0 010 5.5z"/></svg><?php echo esc_html( $nap['address'] ); ?></li>
		</ul>
		<ul class="social">
			<li><a href="<?php echo esc_url( $nap['facebook'] ); ?>" aria-label="Facebook"><svg class="ic" viewBox="0 0 24 24"><path d="M14 9h3V6h-3c-1.7 0-3 1.3-3 3v2H9v3h2v7h3v-7h2.5l.5-3H14V9z"/></svg></a></li>
			<li><a href="<?php echo esc_url( $nap['twitter'] ); ?>" aria-label="X"><svg class="ic" viewBox="0 0 24 24"><path d="M17 3h3l-7 8 8 10h-6l-5-6-5 6H2l8-9L2 3h6l4 5 5-5z"/></svg></a></li>
			<li><a href="<?php echo esc_url( $nap['instagram'] ); ?>" aria-label="Instagram"><svg class="ic" viewBox="0 0 24 24"><path d="M12 2c2.7 0 3 0 4.1.1 1 0 1.7.2 2.3.5.6.2 1 .5 1.5 1s.8.9 1 1.5c.3.6.4 1.3.5 2.3 0 1.1.1 1.4.1 4.1s0 3-.1 4.1c0 1-.2 1.7-.5 2.3-.2.6-.5 1-1 1.5s-.9.8-1.5 1c-.6.3-1.3.4-2.3.5-1.1 0-1.4.1-4.1.1s-3 0-4.1-.1c-1 0-1.7-.2-2.3-.5-.6-.2-1-.5-1.5-1s-.8-.9-1-1.5c-.3-.6-.4-1.3-.5-2.3C2 15 2 14.7 2 12s0-3 .1-4.1c0-1 .2-1.7.5-2.3.2-.6.5-1 1-1.5s.9-.8 1.5-1c.6-.3 1.3-.4 2.3-.5C8.5 2 8.8 2 12 2zm0 5a5 5 0 100 10 5 5 0 000-10zm0 8.2A3.2 3.2 0 1112 8.8a3.2 3.2 0 010 6.4zM17.8 5.9a1.2 1.2 0 100 2.4 1.2 1.2 0 000-2.4z"/></svg></a></li>
			<li><a href="<?php echo esc_url( $nap['linkedin'] ); ?>" aria-label="LinkedIn"><svg class="ic" viewBox="0 0 24 24"><path d="M6.9 8.5H3.6V20h3.3V8.5zM5.2 3.6a1.9 1.9 0 100 3.8 1.9 1.9 0 000-3.8zM20.4 20h-3.3v-5.6c0-1.3 0-3-1.9-3s-2.1 1.4-2.1 2.9V20H9.8V8.5h3.1v1.6h.1c.4-.8 1.5-1.7 3.1-1.7 3.3 0 3.9 2.2 3.9 5V20z"/></svg></a></li>
		</ul>
	</div>
</div>

<header class="site-header<?php echo is_front_page() ? '' : ' solid'; ?>" id="header">
	<div class="container">
		<?php if ( has_custom_logo() ) : ?>
			<span class="brand"><?php the_custom_logo(); ?></span>
		<?php else : ?>
			<a class="brand" href="<?php echo esc_url( home_url( '/' ) ); ?>"><span class="mark"><span>Y</span></span><b>YOURPLACE</b> <em>GH</em></a>
		<?php endif; ?>

		<nav class="nav" id="nav">
			<?php
			if ( has_nav_menu( 'primary' ) ) {
				wp_nav_menu( array(
					'theme_location' => 'primary',
					'container'      => false,
					'menu_class'     => 'nav-menu',
					'depth'          => 2,
				) );
			} else {
				$archive = get_post_type_archive_link( 'property' );
				$archive = $archive ? $archive : home_url( '/properties/' );
				echo '<ul class="nav-menu">';
				echo '<li><a href="' . esc_url( home_url( '/about/' ) ) . '">About us</a></li>';
				echo '<li><a href="' . esc_url( $archive ) . '">Properties</a></li>';
				echo '<li><a href="' . esc_url( add_query_arg( 'status', 'land', $archive ) ) . '">Lands</a></li>';
				echo '<li><a href="' . esc_url( home_url( '/blog/' ) ) . '">Blog</a></li>';
				echo '<li><a href="' . esc_url( home_url( '/#faq' ) ) . '">FAQ</a></li>';
				echo '<li><a href="' . esc_url( home_url( '/contact/' ) ) . '">Contact</a></li>';
				echo '</ul>';
			}
			?>
			<a class="add-listing" href="<?php echo esc_url( home_url( '/add-listing/' ) ); ?>">Add Listing</a>
		</nav>

		<button class="burger" id="burger" aria-label="Menu"><span></span><span></span><span></span></button>
	</div>
</header>
