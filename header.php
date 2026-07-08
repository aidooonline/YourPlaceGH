<?php
/**
 * Header.
 *
 * @package ypgh
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<a class="skip-link" href="#main"><?php esc_html_e( 'Skip to content', 'ypgh' ); ?></a>

<header class="site-header">
	<div class="wrap header-inner">
		<a class="brand" href="<?php echo esc_url( home_url( '/' ) ); ?>">
			<span class="brand-mark">YourPlace</span><span class="brand-gh">GH</span>
		</a>

		<nav class="primary-nav" aria-label="<?php esc_attr_e( 'Primary', 'ypgh' ); ?>">
			<?php
			wp_nav_menu(
				array(
					'theme_location' => 'primary',
					'container'      => false,
					'menu_class'     => 'nav-list',
					'fallback_cb'    => false,
					'depth'          => 2,
				)
			);
			?>
		</nav>

		<a class="btn btn-ghost" href="<?php echo esc_url( get_post_type_archive_link( 'yp_listing' ) ); ?>"><?php esc_html_e( 'Browse listings', 'ypgh' ); ?></a>

		<button class="nav-toggle" aria-expanded="false" aria-controls="mobile-nav" aria-label="<?php esc_attr_e( 'Menu', 'ypgh' ); ?>">
			<span></span><span></span><span></span>
		</button>
	</div>
</header>

<main id="main" class="site-main">
