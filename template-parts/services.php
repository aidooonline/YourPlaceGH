<?php
/**
 * What we do: three numbered pillars.
 *
 * @package yourplacegh
 */

$services_url = ypgh_page_url( 'services', '/services/' );
$pillars = array(
	array(
		'num'   => '01',
		'title' => 'Brokerage',
		'body'  => "Buying, selling, and renting across Accra's residential and commercial markets. We represent your interests - not the listing.",
		'items' => array( 'Residential sales & lettings', 'Land acquisition', 'Commercial leasing', 'Diaspora buyer support', 'Rental management' ),
		'link'  => $services_url . '#brokerage',
	),
	array(
		'num'   => '02',
		'title' => 'Real Estate Consulting',
		'body'  => 'Investment strategy, portfolio decisions, and market intelligence - grounded in a decade of hands-on Accra market experience.',
		'items' => array( 'Investment advisory', 'Property valuations', 'Market & feasibility reports', 'Developer partnerships', 'Title & due diligence support' ),
		'link'  => $services_url . '#consulting',
	),
	array(
		'num'   => '03',
		'title' => 'Construction',
		'body'  => 'From land to handover. We project-manage builds, source verified contractors, and oversee every phase so your investment is protected.',
		'items' => array( 'New build project management', 'Renovation & refurbishment', 'Contractor sourcing & oversight', 'Build-to-spec for buyers', 'Progress reporting' ),
		'link'  => $services_url . '#construction',
	),
);
?>
<section class="section">
	<div class="wrap">
		<div class="sec-head reveal">
			<div>
				<span class="eyebrow">What we do</span>
				<h2>More than an <span class="accent">estate agency</span></h2>
				<p class="lede">Most agencies stop at the listing. We go further - advising on strategy, navigating due diligence, and delivering the build when that's what the moment calls for. One firm. Full cycle.</p>
			</div>
			<a class="sec-link" href="<?php echo esc_url( $services_url ); ?>">All services &rarr;</a>
		</div>
		<div class="pillars">
			<?php foreach ( $pillars as $p ) : ?>
			<article class="pillar reveal">
				<div class="pillar-num"><?php echo esc_html( $p['num'] ); ?></div>
				<h3><a href="<?php echo esc_url( $p['link'] ); ?>"><?php echo esc_html( $p['title'] ); ?></a></h3>
				<p><?php echo esc_html( $p['body'] ); ?></p>
				<ul>
					<?php foreach ( $p['items'] as $it ) : ?><li><?php echo esc_html( $it ); ?></li><?php endforeach; ?>
				</ul>
			</article>
			<?php endforeach; ?>
		</div>
	</div>
</section>
