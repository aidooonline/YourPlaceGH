<?php
/**
 * Header: topbar + editorial sticky header.
 *
 * @package yourplacegh
 */

$nap = ypgh_nap();
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<div class="topbar">
	<div class="wrap">
		<ul>
			<li><a href="mailto:<?php echo esc_attr( $nap['email'] ); ?>"><?php echo esc_html( $nap['email'] ); ?></a></li>
			<li class="hide-m"><?php echo esc_html( $nap['address'] ); ?></li>
		</ul>
		<ul class="social">
			<li><a href="tel:+233539601097"><?php echo esc_html( $nap['phone'] ); ?></a></li>
			<li><a href="<?php echo esc_url( $nap['facebook'] ); ?>" target="_blank" rel="noopener">FB</a></li>
			<li><a href="<?php echo esc_url( $nap['linkedin'] ); ?>" target="_blank" rel="noopener">IN</a></li>
		</ul>
	</div>
</div>

<header class="site-header" id="header">
	<div class="wrap">
		<a class="brand" href="<?php echo esc_url( home_url( '/' ) ); ?>">
			<?php if ( has_custom_logo() ) : ?>
				<?php the_custom_logo(); ?>
			<?php else : ?>
				Yourplace<span class="dot">.</span>GH
			<?php endif; ?>
		</a>

		<nav class="nav" aria-label="<?php esc_attr_e( 'Primary', 'yourplacegh' ); ?>">
			<?php
			wp_nav_menu(
				array(
					'theme_location' => 'primary',
					'container'      => false,
					'fallback_cb'    => 'ypgh_nav_fallback',
					'depth'          => 1,
				)
			);
			?>
		</nav>

		<div class="header-cta">
			<a class="btn btn-gold" href="<?php echo esc_url( ypgh_page_url( 'contact', '/contact/' ) ); ?>"><?php esc_html_e( 'List with us', 'yourplacegh' ); ?></a>
			<button class="burger" id="burger" aria-label="<?php esc_attr_e( 'Menu', 'yourplacegh' ); ?>" aria-expanded="false">
				<span></span><span></span><span></span>
			</button>
		</div>
	</div>
</header>
