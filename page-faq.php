<?php
/**
 * Template Name: FAQ
 *
 * Curated, Ghana-specific real estate FAQs rendered as an accessible accordion,
 * with FAQPage JSON-LD for search and AI answer engines. Edit the $faqs array
 * to change questions, or ask to switch this to editor-driven content.
 *
 * @package ypgh
 */

get_header();

$faqs = array(
	array(
		'q' => __( 'How do I know a property listed here is genuine?', 'ypgh' ),
		'a' => __( 'Every listing on YourPlaceGH is checked before it goes live. We sight the title deed to confirm the seller can actually sell, note the Lands Commission registration status, and flag anything unresolved. A verified badge means the title has been sighted and confirmed.', 'ypgh' ),
	),
	array(
		'q' => __( 'What is the legal limit on rent advance in Ghana?', 'ypgh' ),
		'a' => __( 'Under the Rent Act 1963 (Act 220), a landlord cannot lawfully demand more than six months rent in advance for residential property. Many landlords still ask for one or two years, but any amount beyond six months is not enforceable in law. On our rentals we flag this clearly so you can negotiate or ask for a receipt.', 'ypgh' ),
	),
	array(
		'q' => __( 'What should I check before buying land in Ghana?', 'ypgh' ),
		'a' => __( 'Confirm the seller has good title, that the land is registered at the Lands Commission, and that there is a valid indenture and site plan. Check the land is not subject to litigation, is not sold to more than one buyer, and is not in a waterway or flood-prone zone. Our due diligence service runs these checks for you before you pay.', 'ypgh' ),
	),
	array(
		'q' => __( 'What are land guards and how do I avoid them?', 'ypgh' ),
		'a' => __( 'Land guards are groups who use intimidation to control disputed land, usually where title is unclear or a plot has been sold more than once. The best protection is clean documentation and a proper title search before purchase, which is exactly what we verify before listing a plot.', 'ypgh' ),
	),
	array(
		'q' => __( 'Can a foreigner or someone in the diaspora buy property in Ghana?', 'ypgh' ),
		'a' => __( 'Yes. Land in Ghana is held on a leasehold basis. Ghanaians can hold up to 99 years, while non-Ghanaians can hold a maximum of 50 years, renewable. Buyers abroad are more exposed to fraud, so we offer remote viewings, document checks, and a trusted person on the ground to protect you through the process.', 'ypgh' ),
	),
	array(
		'q' => __( 'What does a "plot" of land actually measure?', 'ypgh' ),
		'a' => __( 'A standard plot in Ghana is commonly around 70 by 100 feet, roughly 650 square metres, though sizes vary by area and seller. Because "plot" is not a fixed legal unit, always confirm the exact dimensions on the site plan rather than relying on the word alone.', 'ypgh' ),
	),
	array(
		'q' => __( 'Do you charge buyers or tenants to use YourPlaceGH?', 'ypgh' ),
		'a' => __( 'Browsing verified listings and neighborhood intelligence is free. Specialist services such as a formal title search, an independent valuation, or hands-on diaspora support are quoted upfront before any work begins, so there are no surprises.', 'ypgh' ),
	),
	array(
		'q' => __( 'How do I list my own property?', 'ypgh' ),
		'a' => __( 'Use the contact page or call the team. We will help you present the property properly, capture serious enquiries, and, where you want it, verify your documentation so your listing carries a trust badge that converts better.', 'ypgh' ),
	),
);

// Build FAQPage schema.
$entities = array();
foreach ( $faqs as $item ) {
	$entities[] = array(
		'@type'          => 'Question',
		'name'           => wp_strip_all_tags( $item['q'] ),
		'acceptedAnswer' => array(
			'@type' => 'Answer',
			'text'  => wp_strip_all_tags( $item['a'] ),
		),
	);
}
$faq_schema = array(
	'@context'   => 'https://schema.org',
	'@type'      => 'FAQPage',
	'mainEntity' => $entities,
);

while ( have_posts() ) :
	the_post();
	?>

<script type="application/ld+json"><?php echo wp_json_encode( $faq_schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></script>

<section class="page-hero">
	<div class="wrap">
		<p class="eyebrow"><?php esc_html_e( 'Questions, answered plainly', 'ypgh' ); ?></p>
		<h1><?php the_title(); ?></h1>
		<p class="page-hero-sub"><?php esc_html_e( 'Straight answers on titles, rent advance, land guards, and buying from abroad. If your question is not here, the team is a message away.', 'ypgh' ); ?></p>
	</div>
</section>

<section class="section">
	<div class="wrap wrap-narrow">
		<div class="faq-list">
			<?php foreach ( $faqs as $i => $item ) : ?>
				<div class="faq-item">
					<button class="faq-q" aria-expanded="false" aria-controls="faq-a-<?php echo esc_attr( $i ); ?>" id="faq-q-<?php echo esc_attr( $i ); ?>">
						<span><?php echo esc_html( $item['q'] ); ?></span>
						<span class="faq-chevron" aria-hidden="true"></span>
					</button>
					<div class="faq-a" id="faq-a-<?php echo esc_attr( $i ); ?>" role="region" aria-labelledby="faq-q-<?php echo esc_attr( $i ); ?>" hidden>
						<p><?php echo esc_html( $item['a'] ); ?></p>
					</div>
				</div>
			<?php endforeach; ?>
		</div>

		<div class="faq-cta">
			<p><?php esc_html_e( 'Still not sure about something?', 'ypgh' ); ?></p>
			<a class="btn btn-primary" href="<?php echo esc_url( home_url( '/contact/' ) ); ?>"><?php esc_html_e( 'Ask the team', 'ypgh' ); ?></a>
		</div>
	</div>
</section>

	<?php
endwhile;

get_footer();
