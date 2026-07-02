<?php
/**
 * Front page: editorial homepage.
 *
 * @package yourplacegh
 */

get_header();

get_template_part( 'template-parts/hero' );
get_template_part( 'template-parts/search' );
get_template_part( 'template-parts/services' );
get_template_part( 'template-parts/listings' );
get_template_part( 'template-parts/areas' );
get_template_part( 'template-parts/why' );
get_template_part( 'template-parts/insights' );
get_template_part( 'template-parts/cta' );

get_footer();
