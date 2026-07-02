<?php
/**
 * Template Name: Services
 *
 * @package yourplacegh
 */

get_header();

$contact  = ypgh_page_url( 'contact', '/contact/' );
$diaspora = ypgh_page_url( 'diaspora', '/diaspora/' );
$archive  = get_post_type_archive_link( 'property' );

$pillars = array(
	array(
		'id'    => 'brokerage',
		'num'   => '01',
		'eyebrow' => 'Brokerage',
		'title' => 'Buying, selling & <span class="accent">renting - done right</span>',
		'body'  => 'We represent buyers, sellers, and landlords with equal commitment. No dual-agency conflicts. No listing-portal rushes. Just deep local knowledge, honest pricing, and a transaction process you can follow from offer to keys.',
		'badge_num'   => '9+',
		'badge_label' => 'Years active',
		'img'   => YPGH_URI . '/assets/img/hero-1.jpg',
		'features' => array(
			array( '&#9678;', 'Buyer representation', 'We work exclusively for you - identifying off-market options, running title checks, and negotiating the best terms. You never pay more than the property is worth.' ),
			array( '&#9672;', 'Vendor services', 'Professional valuation, staging guidance, and active marketing across digital and diaspora channels. We target the buyers who will actually complete.' ),
			array( '&#10038;', 'Tenancy & landlord management', 'Tenant sourcing, vetting, lease drafting, and rent collection - structured to protect landlords while keeping good tenants long-term.' ),
		),
		'cta'  => array( 'Start a conversation', 'contact', 'Browse listings', 'archive' ),
	),
	array(
		'id'    => 'consulting',
		'num'   => '02',
		'eyebrow' => 'Consulting',
		'title' => 'Investment clarity in a complex <span class="accent">market</span>',
		'body'  => "Ghana's real estate market rewards those who understand it - and punishes those who don't. Our consulting service gives investors, diaspora buyers, and developers the clarity they need to act with confidence and avoid expensive mistakes.",
		'badge_num'   => 'GHS',
		'badge_label' => 'Yield advice',
		'img'   => YPGH_URI . '/assets/img/hero-2.jpg',
		'features' => array(
			array( '&#9678;', 'Land due diligence', 'Title search, encumbrance check, site visits, and litigation history - before you commit a single cedi. Our due diligence report is your contract protection.' ),
			array( '&#9672;', 'Investment analysis', 'Rental yield modelling, comparable pricing, area growth projections, and developer track record review - structured for both personal use and portfolio decisions.' ),
			array( '&#10038;', 'Diaspora advisory', 'Remote acquisition from the UK, US, Canada, or Europe - power of attorney, currency transfer guidance, legal co-ordination, and virtual site tours. You stay in control.' ),
		),
		'cta'  => array( 'Diaspora buyers guide', 'diaspora', 'Talk to a consultant', 'contact' ),
	),
	array(
		'id'    => 'construction',
		'num'   => '03',
		'eyebrow' => 'Construction',
		'title' => 'We manage the build. You receive <span class="accent">the keys.</span>',
		'body'  => 'Found the land. Done the deal. Now build - without losing months, money, or sleep to contractor management. Our construction arm coordinates architects, engineers, and ground crews so your project arrives on time and on budget.',
		'badge_num'   => '18+',
		'badge_label' => 'Builds managed',
		'img'   => YPGH_URI . '/assets/img/hero-3.jpg',
		'features' => array(
			array( '&#9678;', 'Project management', 'End-to-end oversight of your residential or commercial build - from planning permits and design sign-off through to inspections and handover.' ),
			array( '&#9672;', 'Contractor sourcing & supervision', 'We maintain a vetted network of architects, structural engineers, and tradespeople. No guesswork hiring. Quality is supervised and certified at every stage.' ),
			array( '&#10038;', 'Renovation & finishing', 'Property upgrades that add measurable value - from compound expansion to interior finishing, tiling, plumbing, and electrical to professional standard.' ),
		),
		'cta'  => array( 'Discuss your project', 'contact', 'Get a quote', 'contact' ),
	),
);

$links = array(
	'contact'  => $contact,
	'diaspora' => $diaspora,
	'archive'  => $archive ? $archive : home_url( '/' ),
);
?>
<div class="page-head">
	<div class="wrap">
		<span class="eyebrow">What we do</span>
		<h1>Three services. One team. <span class="accent">No handoffs.</span></h1>
		<p class="lede">From your first viewing to your completed build - Yourplace GH is the only real estate partner you'll need in Accra.</p>
		<div class="service-nav">
			<a class="snav-item" href="#brokerage">01 &middot; Brokerage</a>
			<a class="snav-item" href="#consulting">02 &middot; Consulting</a>
			<a class="snav-item" href="#construction">03 &middot; Construction</a>
		</div>
	</div>
</div>

<?php foreach ( $pillars as $i => $p ) : ?>
<section class="pillar-sec" id="<?php echo esc_attr( $p['id'] ); ?>">
	<div class="wrap">
		<div class="pillar-grid<?php echo ( 1 === $i % 2 ) ? ' reverse' : ''; ?>">
			<div class="pillar-img reveal" style="background-image:url('<?php echo esc_url( $p['img'] ); ?>')">
				<div class="pillar-badge">
					<div class="pb-num"><?php echo esc_html( $p['badge_num'] ); ?></div>
					<div class="pb-label"><?php echo esc_html( $p['badge_label'] ); ?></div>
				</div>
			</div>
			<div class="reveal">
				<div class="big-num"><?php echo esc_html( $p['num'] ); ?></div>
				<span class="eyebrow"><?php echo esc_html( $p['eyebrow'] ); ?></span>
				<h2><?php echo wp_kses_post( $p['title'] ); ?></h2>
				<p class="lede"><?php echo esc_html( $p['body'] ); ?></p>
				<div>
					<?php foreach ( $p['features'] as $f ) : ?>
					<div class="feature">
						<div class="f-ic"><?php echo $f[0]; // phpcs:ignore ?></div>
						<div>
							<h4><?php echo esc_html( $f[1] ); ?></h4>
							<p><?php echo esc_html( $f[2] ); ?></p>
						</div>
					</div>
					<?php endforeach; ?>
				</div>
				<div class="pillar-cta">
					<a class="btn btn-gold" href="<?php echo esc_url( $links[ $p['cta'][1] ] ); ?>"><?php echo esc_html( $p['cta'][0] ); ?></a>
					<a class="btn btn-ghost" href="<?php echo esc_url( $links[ $p['cta'][3] ] ); ?>"><?php echo esc_html( $p['cta'][2] ); ?></a>
				</div>
			</div>
		</div>
	</div>
</section>
<?php endforeach; ?>

<section class="section soft">
	<div class="wrap">
		<div class="sec-head reveal">
			<div>
				<span class="eyebrow">How we work</span>
				<h2>A process you can <span class="accent">follow</span></h2>
			</div>
		</div>
		<div class="steps-grid">
			<div class="step reveal"><div class="step-num">01</div><h3>Listen first</h3><p>Every engagement starts with your goals, your budget, and your timeline - not our inventory. We tell you what's realistic before anything else.</p></div>
			<div class="step reveal"><div class="step-num">02</div><h3>Verify everything</h3><p>Titles, boundaries, encumbrances, landlords, contractors. Nothing moves forward until the facts check out - in writing.</p></div>
			<div class="step reveal"><div class="step-num">03</div><h3>Deliver and stay</h3><p>Keys, reports, and handover documentation - then aftercare. Most of our business comes from referrals, and we work to keep it that way.</p></div>
		</div>
	</div>
</section>

<?php
get_template_part( 'template-parts/cta' );
get_footer();
