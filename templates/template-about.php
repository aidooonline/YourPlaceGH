<?php
/**
 * Template Name: About
 *
 * @package yourplacegh
 */

get_header();

$timeline = array(
	array( '2015', 'Founded in Pantang', 'Yourplace GH begins as a neighbourhood brokerage - two agents, deep local roots, and a conviction that buyers deserved better guidance than listing portals could offer.' ),
	array( '2017', 'Consulting arm launched', 'After repeated client requests for due diligence support on land purchases, we formalised an investment advisory and due diligence service - one that quickly became our most referred offering.' ),
	array( '2020', 'Construction management added', 'Clients who trusted us to find land trusted us to build on it. We assembled a vetted network of contractors, architects, and project managers - and our first managed build completed on time and under budget.' ),
	array( 'Today', 'Accra-wide. Diaspora-ready.', 'Operating across Pantang, Oyarifa, East Legon, Cantonments, and beyond - with a growing diaspora client base from the UK, US, and Canada who rely on us to manage the full process remotely.' ),
);

$values = array(
	array( '&#9678;', 'Local over generic', "Area knowledge compounds. We know which plots have boundary disputes, which developments have infrastructure problems, and which landlords honour their leases. That intelligence doesn't come from a portal." ),
	array( '&#9672;', 'Client-side always', 'We never represent both parties in a transaction. Conflicts of interest erode trust faster than any bad deal. You get our undivided loyalty - or we refer you to someone better placed to help.' ),
	array( '&#10038;', 'Transparency first', "If a property has a problem, we tell you before you find it yourself. If our fees seem high relative to the deal, we'll explain why - or adjust them. Honest conversations save expensive surprises." ),
	array( '&#11041;', 'Long-term thinking', 'We make more money from referrals than from commissions. So we prioritise the relationship over the transaction. A client who buys once and sends three friends is worth far more than a quick close.' ),
	array( '&#10059;', 'Due diligence is non-negotiable', "Ghana's real estate market rewards patience and penalises shortcuts. We never rush a title check, skip a site visit, or skip the legal review. If we're not comfortable, we say so." ),
	array( '&#9680;', 'Community rooted', 'Pantang is our home ground, not just a market to extract from. We invest in local relationships, support community development where we can, and take pride in the corridor we have helped grow.' ),
);

$team = array(
	array( 'Abena Mensah', 'Founder & Lead Broker', "9 years in Ga East residential. Built the company from a single neighbourhood desk into Accra's most referred brokerage.", 'AM' ),
	array( 'Kofi Asante', 'Head of Consulting', 'Former land economist with the Lands Commission. Leads all due diligence, investment analysis, and diaspora advisory mandates.', 'KA' ),
	array( 'Efua Darko', 'Construction Lead', 'Civil engineer with 12 years on residential and commercial builds across Greater Accra. Oversees every managed project from permit to handover.', 'ED' ),
);
?>
<section class="hero">
	<div class="hero-grid">
		<div class="hero-copy">
			<span class="eyebrow">About Yourplace GH</span>
			<h1>Built from the ground up. <span class="accent">Literally.</span></h1>
			<p class="hero-sub">We started in Pantang when few agencies were paying attention. That early ground-work became our competitive edge - and the reason our clients trust us with decisions that matter.</p>
			<div class="hero-stats">
				<div class="stat"><div class="stat-num">9<em>+</em></div><div class="stat-label">Years in Accra</div></div>
				<div class="stat"><div class="stat-num">200<em>+</em></div><div class="stat-label">Transactions</div></div>
				<div class="stat"><div class="stat-num">18<em>+</em></div><div class="stat-label">Builds managed</div></div>
			</div>
		</div>
		<div class="hero-media" style="background-image:url('<?php echo esc_url( YPGH_URI . '/assets/img/hero-1.jpg' ); ?>')"></div>
	</div>
</section>

<section class="section">
	<div class="wrap">
		<div class="story-grid">
			<div class="reveal">
				<span class="eyebrow">Our story</span>
				<h2>From one corridor. To all of <span class="accent">Accra.</span></h2>
				<div class="story-pull">"We didn't start with a grand strategy. We started by <span>knowing our neighbourhood better than anyone.</span>"</div>
				<div class="timeline">
					<?php foreach ( $timeline as $t ) : ?>
					<div class="tl-item">
						<div class="tl-dot"></div>
						<div>
							<div class="tl-year"><?php echo esc_html( $t[0] ); ?></div>
							<div class="tl-title"><?php echo esc_html( $t[1] ); ?></div>
							<div class="tl-body"><?php echo esc_html( $t[2] ); ?></div>
						</div>
					</div>
					<?php endforeach; ?>
				</div>
			</div>
			<div class="story-side reveal">
				<div class="story-mark" aria-hidden="true"><span>Y<i>G</i></span></div>
				<p>We have never been a listing aggregator. Every property we handle, we've visited. Every landlord we list, we've met. Every client we advise, we represent exclusively - never both buyer and seller in the same transaction.</p>
				<p>That principle has cost us deals. It's also given us the only thing that matters in this business: a reputation that generates more referrals than any marketing campaign.</p>
			</div>
		</div>
	</div>
</section>

<section class="section soft">
	<div class="wrap">
		<div class="sec-head reveal">
			<div>
				<span class="eyebrow">How we operate</span>
				<h2>Our <span class="accent">values</span></h2>
			</div>
		</div>
		<div class="values-grid">
			<?php foreach ( $values as $v ) : ?>
			<div class="value reveal">
				<div class="v-ic"><?php echo $v[0]; // phpcs:ignore ?></div>
				<h3><?php echo esc_html( $v[1] ); ?></h3>
				<p><?php echo esc_html( $v[2] ); ?></p>
			</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>

<section class="section">
	<div class="wrap">
		<div class="sec-head reveal">
			<div>
				<span class="eyebrow">The team</span>
				<h2>The people behind your <span class="accent">next move</span></h2>
			</div>
		</div>
		<div class="team-grid">
			<?php foreach ( $team as $m ) : ?>
			<article class="team-card reveal">
				<div class="team-img"><span><?php echo esc_html( $m[3] ); ?></span></div>
				<div class="team-info">
					<div class="team-name"><?php echo esc_html( $m[0] ); ?></div>
					<div class="team-role"><?php echo esc_html( $m[1] ); ?></div>
					<div class="team-bio"><?php echo esc_html( $m[2] ); ?></div>
				</div>
			</article>
			<?php endforeach; ?>
		</div>
	</div>
</section>

<?php
get_template_part( 'template-parts/cta' );
get_footer();
