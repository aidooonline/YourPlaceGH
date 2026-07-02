<?php
/**
 * Diaspora FAQ items: used on the Diaspora template and in FAQPage schema.
 *
 * @package yourplacegh
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function ypgh_faq_items() {
	return array(
		array(
			'q' => 'Do I need to travel to Ghana to buy?',
			'a' => 'No. The entire process - search, due diligence, legal, and transaction - can be completed remotely. A well-structured power of attorney covers you at every stage. Most of our diaspora clients complete without ever flying in.',
		),
		array(
			'q' => 'What is a power of attorney and do I need one?',
			'a' => 'A POA authorises a trusted person in Ghana to sign documents on your behalf. For remote purchases it is essential. We guide you through the setup process - your local Ghanaian embassy or high commission can notarise the document in your country.',
		),
		array(
			'q' => 'How do I transfer money safely from abroad?',
			'a' => 'We advise on reputable USD-to-GHS transfer routes and work with transactions in both currencies. Most completions are handled in USD via bank-to-bank transfer. We never handle client funds directly - all payments go to solicitor-held accounts.',
		),
		array(
			'q' => 'Can Ghanaians living abroad own land in Ghana?',
			'a' => 'Yes. Ghanaian nationals living abroad retain full property rights in Ghana. Non-citizen buyers can also purchase leasehold interests (up to 50 years, renewable). Our legal partners advise on the most appropriate ownership structure for your situation.',
		),
		array(
			'q' => 'How long does the full process take?',
			'a' => 'From first call to completion typically takes 6 to 14 weeks depending on the property type and title status. Title registration at the Lands Commission adds 3 to 8 weeks after completion. We give you a realistic timeline upfront and update you throughout.',
		),
		array(
			'q' => 'What are your fees for diaspora clients?',
			'a' => 'Our brokerage fee is charged to the seller (standard industry practice in Ghana). Consulting and due diligence services are priced by scope. We will give you a full cost breakdown - including legal fees, stamp duty, and registration costs - before any commitment.',
		),
	);
}
