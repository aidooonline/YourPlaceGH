#!/usr/bin/env bash
#
# YourPlaceGH demo seed. Creates taxonomy terms, sample listings with
# coordinates and trust markers, and neighborhood guides with location
# intelligence. Idempotent: skips items whose reference/marker already exists.
#
# Run from the WordPress root:  bash wp-content/themes/yourplacegh/tools/seed.sh
#
set -euo pipefail

WP="${WP_CLI:-wp}"

if ! command -v "$WP" >/dev/null 2>&1; then
	echo "WP-CLI not found. Set WP_CLI=/path/to/wp or install wp-cli."
	exit 1
fi

echo "Site: $($WP option get siteurl)"

# ---------- Taxonomy terms ----------
term() { $WP term create "$1" "$2" --slug="$3" >/dev/null 2>&1 || true; }

term yp_status "For Sale"  for-sale
term yp_status "For Rent"  for-rent
term yp_status "Short Let" short-let

term yp_ptype "House"     house
term yp_ptype "Apartment" apartment
term yp_ptype "Land"      land
term yp_ptype "Office"    office

term yp_city "East Legon"          east-legon
term yp_city "Cantonments"         cantonments
term yp_city "Airport Residential" airport-residential
term yp_city "Spintex"             spintex
term yp_city "Labone"              labone
term yp_city "Teshie"              teshie

for a in "Air conditioning:air-conditioning" "Borehole:borehole" "Standby generator:standby-generator" \
         "Swimming pool:swimming-pool" "Gated community:gated-community" "Fitted kitchen:fitted-kitchen" \
         "Boys quarters:boys-quarters" "CCTV:cctv"; do
	term yp_amenity "${a%%:*}" "${a##*:}"
done

# ---------- Helpers ----------
seed_marker() { $WP post list --post_type="$1" --meta_key=_yp_seed --meta_value="$2" --field=ID --posts_per_page=1 2>/dev/null; }

listing() {
	local marker="$1" title="$2" content="$3" status="$4" ptype="$5" city="$6"
	local price="$7" beds="$8" baths="$9" area="${10}" address="${11}" lat="${12}" lng="${13}"
	local verified="${14}" lands="${15}" rent_period="${16}" rent_advance="${17}" amenities="${18}"

	if [ -n "$(seed_marker yp_listing "$marker")" ]; then
		echo "  skip listing: $title"
		return
	fi

	local id
	id=$($WP post create --post_type=yp_listing --post_status=publish --porcelain \
		--post_title="$title" --post_content="$content")

	$WP post meta set "$id" _yp_seed "$marker"          >/dev/null
	$WP post meta set "$id" _yp_currency "GHS"           >/dev/null
	$WP post meta set "$id" _yp_price "$price"           >/dev/null
	$WP post meta set "$id" _yp_beds "$beds"             >/dev/null
	$WP post meta set "$id" _yp_baths "$baths"           >/dev/null
	$WP post meta set "$id" _yp_area "$area"             >/dev/null
	$WP post meta set "$id" _yp_area_unit "sqm"          >/dev/null
	$WP post meta set "$id" _yp_address "$address"       >/dev/null
	$WP post meta set "$id" _yp_lat "$lat"               >/dev/null
	$WP post meta set "$id" _yp_lng "$lng"               >/dev/null
	$WP post meta set "$id" _yp_agent_name "YourPlaceGH Sales" >/dev/null
	$WP post meta set "$id" _yp_agent_phone "053 960 1097"     >/dev/null
	$WP post meta set "$id" _yp_agent_whatsapp "233539601097"  >/dev/null
	$WP post meta set "$id" _yp_trust_title_verified "$verified"   >/dev/null
	$WP post meta set "$id" _yp_trust_lands_commission "$lands"    >/dev/null
	[ -n "$rent_period" ]  && $WP post meta set "$id" _yp_rent_period "$rent_period"   >/dev/null
	[ -n "$rent_advance" ] && $WP post meta set "$id" _yp_rent_advance "$rent_advance" >/dev/null

	$WP post term set "$id" yp_status "$status" --by=slug >/dev/null
	$WP post term set "$id" yp_ptype "$ptype"  --by=slug >/dev/null
	$WP post term set "$id" yp_city "$city"    --by=slug >/dev/null
	# shellcheck disable=SC2086
	$WP post term set "$id" yp_amenity $amenities --by=slug >/dev/null

	echo "  listing #$id: $title"
}

location() {
	local marker="$1" title="$2" content="$3" city="$4" lat="$5" lng="$6"
	local safety="$7" flood="$8" util="$9" road="${10}" title_risk="${11}" rent="${12}"

	if [ -n "$(seed_marker yp_location "$marker")" ]; then
		echo "  skip guide: $title"
		return
	fi

	local id
	id=$($WP post create --post_type=yp_location --post_status=publish --porcelain \
		--post_title="$title" --post_content="$content")

	$WP post meta set "$id" _yp_seed "$marker"            >/dev/null
	$WP post meta set "$id" _yp_loc_lat "$lat"            >/dev/null
	$WP post meta set "$id" _yp_loc_lng "$lng"            >/dev/null
	$WP post meta set "$id" _yp_loc_safety "$safety"      >/dev/null
	$WP post meta set "$id" _yp_loc_flood_risk "$flood"   >/dev/null
	$WP post meta set "$id" _yp_loc_utilities "$util"     >/dev/null
	$WP post meta set "$id" _yp_loc_road_access "$road"   >/dev/null
	$WP post meta set "$id" _yp_loc_title_risk "$title_risk" >/dev/null
	$WP post meta set "$id" _yp_loc_avg_rent "$rent"      >/dev/null
	$WP post term set "$id" yp_city "$city" --by=slug     >/dev/null

	echo "  guide #$id: $title"
}

echo "Seeding listings..."
listing L1 "4 Bedroom Townhouse, East Legon" \
	"<p>Spacious four bedroom townhouse in a gated East Legon enclave. Fitted kitchen, standby power, and boys quarters. Title deed sighted and registered.</p>" \
	for-sale house east-legon 3200000 4 4 320 "American House, East Legon, Accra" 5.6350 -0.1550 \
	1 1 "" "" "air-conditioning fitted-kitchen standby-generator gated-community boys-quarters"

listing L2 "2 Bedroom Apartment, Cantonments" \
	"<p>Modern two bedroom apartment near the embassies. Pool, gym, and 24 hour security. Available for rent.</p>" \
	for-rent apartment cantonments 9500 2 2 140 "Cantonments, Accra" 5.5750 -0.1750 \
	1 0 month 12 "air-conditioning swimming-pool cctv standby-generator"

listing L3 "Serviced 1 Bedroom, Airport Residential" \
	"<p>Fully serviced one bedroom in Airport Residential. Walk to shops and restaurants. Short let available.</p>" \
	short-let apartment airport-residential 850 1 1 65 "Airport Residential Area, Accra" 5.6050 -0.1720 \
	0 0 month 0 "air-conditioning cctv fitted-kitchen"

listing L4 "Half Plot of Land, Spintex" \
	"<p>Half plot of registered land along a Spintex link road. Documentation available including indenture and site plan.</p>" \
	for-sale land spintex 780000 0 0 340 "Spintex Road, Accra" 5.6300 -0.1050 \
	1 1 "" "" ""

listing L5 "5 Bedroom Detached House, Labone" \
	"<p>Executive five bedroom detached home in Labone with a large compound, borehole, and pool. Rent asked with two year advance.</p>" \
	for-rent house labone 22000 5 5 480 "Labone, Accra" 5.5680 -0.1720 \
	1 1 year 24 "swimming-pool borehole standby-generator gated-community boys-quarters cctv"

listing L6 "3 Bedroom Semi-Detached, Teshie" \
	"<p>Affordable three bedroom semi-detached near Teshie. Room to expand. Land title under registration at Lands Commission.</p>" \
	for-sale house teshie 1150000 3 2 210 "Teshie, Accra" 5.5850 -0.1050 \
	0 1 "" "" "borehole fitted-kitchen"

echo "Seeding neighborhood guides..."
location N1 "East Legon" \
	"<p>East Legon is one of Accra's most sought-after residential districts, popular with professionals and returning diaspora. Expect gated homes, good schools, and a lively food scene, balanced against traffic on the main arteries.</p>" \
	east-legon 5.6350 -0.1550 4 2 3 3 2 9500

location N2 "Cantonments" \
	"<p>Cantonments sits in the diplomatic heart of Accra, quiet, secure, and walkable. Housing skews to apartments and older detached homes. Prices are high and land rarely changes hands, which keeps title risk low.</p>" \
	cantonments 5.5750 -0.1750 5 1 4 4 1 11000

location N3 "Spintex" \
	"<p>Spintex is a fast-growing corridor between the motorway and the coast, with a mix of new estates and commercial frontage. Value is strong, but confirm drainage before buying, as some pockets flood in the rains.</p>" \
	spintex 5.6300 -0.1050 3 4 3 2 3 4200

echo
echo "Flushing caches and rewrites..."
$WP transient delete ypgh_q_home_listings  >/dev/null 2>&1 || true
$WP transient delete ypgh_q_home_locations >/dev/null 2>&1 || true
$WP rewrite flush >/dev/null 2>&1 || true

echo "Done. Visit /listings and /neighborhoods."
