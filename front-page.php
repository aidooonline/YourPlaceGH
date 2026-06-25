<?php
/**
 * Front page.
 *
 * @package YourPlaceGH
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

get_template_part( 'template-parts/hero' );
get_template_part( 'template-parts/search' );
get_template_part( 'template-parts/services' );
get_template_part( 'template-parts/areas' );
get_template_part( 'template-parts/listings' );
get_template_part( 'template-parts/video' );
get_template_part( 'template-parts/trust' );
get_template_part( 'template-parts/faq' );
get_template_part( 'template-parts/cta' );

get_footer();
