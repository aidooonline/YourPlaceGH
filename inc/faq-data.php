<?php
/**
 * FAQ content. Single source for the visible homepage FAQ and the FAQPage
 * schema, so the structured data always matches what is on the page.
 *
 * @package YourPlaceGH
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * @return array List of question/answer pairs (plain text answers).
 */
function ypgh_faq_items() {
	return array(
		array(
			'q' => 'Where in Accra does Your Place GH operate?',
			'a' => 'We are based in Teshie, Accra and handle sales, rentals, and development across Greater Accra, including East Legon, Cantonments, Airport Residential, Spintex, and the Teshie to Nungua corridor.',
		),
		array(
			'q' => 'Do you work with buyers in the diaspora?',
			'a' => 'Yes. A large share of our clients are Ghanaians abroad. We run virtual viewings, verify title and documents on your behalf, and manage the purchase or build from start to finish so you do not need to be in the country.',
		),
		array(
			'q' => 'How do I know a property has clean title?',
			'a' => 'Before we list or recommend a property we confirm the land documentation and ownership. For any purchase we guide you through due diligence at the Lands Commission so you buy with clear, registered title.',
		),
		array(
			'q' => 'What fees should I expect when renting?',
			'a' => 'Rental terms in Accra vary by landlord. We set out the rent, advance period, and any agency fee in writing before you commit, so there are no surprises at signing.',
		),
		array(
			'q' => 'Can you manage a property I already own?',
			'a' => 'Yes. Our asset management service covers tenant sourcing and screening, rent collection, maintenance, and reporting, whether you hold one unit or a portfolio.',
		),
		array(
			'q' => 'Do you handle construction and development?',
			'a' => 'We guide construction projects from concept through to completion, including design coordination, contractor oversight, and budget tracking, so your build stays on time and on cost.',
		),
	);
}
