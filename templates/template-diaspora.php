<?php
/**
 * Template Name: Diaspora
 *
 * @package yourplacegh
 */

get_header();

$contact = ypgh_page_url( 'contact', '/contact/' );

$steps = array(
	array( '01', 'Discovery call', "We start with a video or WhatsApp call - understanding your budget, goals, timeline, and preferred areas. We'll be straight with you about what's realistic." ),
	array( '02', 'Shortlist & virtual viewings', 'We curate a personalised shortlist and conduct full video walkthroughs - exterior, interior, neighbourhood, and surroundings - with live commentary from our team on the ground.' ),
	array( '03', 'Due diligence report', 'Once you select a property or plot, we run a complete title search, encumbrance check, boundary verification, and legal review. You receive a written due diligence report before any money moves.' ),
	array( '04', 'Power of attorney', 'We guide you through setting up a notarised power of attorney - authorising a trusted representative in Ghana to sign on your behalf. Your solicitor or ours can draft this document.' ),
	array( '05', 'Transaction & legal', 'Your POA representative executes the SPA, stamp duty, and transfer documentation. We co-ordinate directly with your solicitor and the Lands Commission throughout.' ),
	array( '06', 'Handover & aftercare', 'We document the property condition at handover and provide a full handover report with photos and video. For construction clients, we continue as project managers through to completion.' ),
);

$checks = array(
	'Property search & shortlisting - curated to your brief, not what is easiest to sell',
	'Title search & due diligence - 30-year title history, encumbrance and litigation check',
	'Legal co-ordination - liaise with your solicitor or appoint one from our network',
	'POA guidance - support setting up your power of attorney in your country of residence',
	'Currency transfer advice - USD/GHS guidance and recommended transfer routes',
	'Transaction management - SPA, stamp duty, registration, completion',
	'Handover documentation - full photo and video record at keys-in-hand',
	'Post-purchase support - utility transfer, maintenance contacts, renovation referrals',
);
?>
<section class="hero">
	<div class="hero-grid">
		<div class="hero-copy">
			<span class="eyebrow">Diaspora buyers &middot; UK &middot; US &middot; Canada &middot; Europe</span>
			<h1>You make the decision. <span class="accent">We handle everything else.</span></h1>
			<p class="hero-sub">Buying property in Ghana from abroad doesn't have to be stressful. We manage the full process remotely - so you can invest with confidence from wherever you are.</p>
			<div class="hero-actions">
				<a class="btn btn-gold" href="<?php echo esc_url( $contact ); ?>">Start your search</a>
				<a class="btn btn-ghost" href="<?php echo esc_url( ypgh_page_url( 'insights', '/insights/' ) ); ?>">Read our guides</a>
			</div>
			<div class="hero-stats">
				<div class="stat"><div class="stat-num">40<em>+</em></div><div class="stat-label">Diaspora deals closed</div></div>
				<div class="stat"><div class="stat-num">6<em>-</em>14</div><div class="stat-label">Weeks to completion</div></div>
			</div>
		</div>
		<div class="hero-media" style="background-image:url('<?php echo esc_url( YPGH_URI . '/assets/img/hero-2.jpg' ); ?>')">
			<div class="hero-chip">
				<div class="hc-label">Fully remote</div>
				<div class="hc-value">No flight required</div>
			</div>
		</div>
	</div>
</section>

<section class="section">
	<div class="wrap">
		<div class="sec-head reveal">
			<div>
				<span class="eyebrow">The process</span>
				<h2>How it works - <span class="accent">from abroad</span></h2>
				<p class="lede">We've refined this process over 40+ diaspora transactions. You don't need to fly in until you want to - every stage can be handled remotely.</p>
			</div>
		</div>
		<div class="steps-grid">
			<?php foreach ( $steps as $s ) : ?>
			<div class="step reveal"><div class="step-num"><?php echo esc_html( $s[0] ); ?></div><h3><?php echo esc_html( $s[1] ); ?></h3><p><?php echo esc_html( $s[2] ); ?></p></div>
			<?php endforeach; ?>
		</div>
	</div>
</section>

<section class="section soft">
	<div class="wrap">
		<div class="check-grid">
			<div class="check-img reveal" style="background-image:url('<?php echo esc_url( YPGH_URI . '/assets/img/hero-3.jpg' ); ?>')"></div>
			<div class="reveal">
				<span class="eyebrow">What we handle for you</span>
				<h2>The full process - so you don't have to <span class="accent">fly in to find out</span></h2>
				<p class="lede">Most diaspora buyers lose deals, money, or both because they're working with agents who can't - or won't - handle the process end-to-end. We're not that agency.</p>
				<div class="check-list">
					<?php
					foreach ( $checks as $c ) :
						$parts = explode( ' - ', $c, 2 );
						?>
					<div class="check-item">
						<div class="c-ic">&#10003;</div>
						<div><b><?php echo esc_html( $parts[0] ); ?></b><?php echo isset( $parts[1] ) ? ' - ' . esc_html( $parts[1] ) : ''; ?></div>
					</div>
					<?php endforeach; ?>
				</div>
			</div>
		</div>
	</div>
</section>

<section class="section">
	<div class="wrap">
		<div class="faq-grid">
			<div class="reveal">
				<span class="eyebrow">Common questions</span>
				<h2>What diaspora buyers always <span class="accent">ask</span></h2>
				<p class="lede">Straight answers to the questions we hear on every first call.</p>
			</div>
			<div class="faq-list reveal">
				<?php foreach ( ypgh_faq_items() as $i => $faq ) : ?>
				<div class="faq-item<?php echo 0 === $i ? ' open' : ''; ?>">
					<button class="faq-q" aria-expanded="<?php echo 0 === $i ? 'true' : 'false'; ?>">
						<?php echo esc_html( $faq['q'] ); ?>
						<span class="ft">+</span>
					</button>
					<div class="faq-a"<?php echo 0 === $i ? ' style="max-height:400px"' : ''; ?>><p><?php echo esc_html( $faq['a'] ); ?></p></div>
				</div>
				<?php endforeach; ?>
			</div>
		</div>
	</div>
</section>

<?php
get_template_part( 'template-parts/cta' );
get_footer();
