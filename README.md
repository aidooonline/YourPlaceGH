# YourPlaceGH

Real estate marketplace and location intelligence theme for Ghana. Custom PHP, no page builder.

## What it does
- Listings (`yp_listing`) and neighborhood guides (`yp_location`) as custom post types
- Search and filter by property type, city, price range, bedrooms, and verified-only
- Trust safeguards on every listing: title sighted, Lands Commission status, indenture, site plan, litigation-free
- Rent advance advisory that flags demands above the 6-month legal cap (Rent Act 1963, Act 220)
- Location intelligence scores: safety, utilities, road access, flood risk, land title risk, typical rent
- Leaflet maps on listing and location pages
- JSON-LD schema layer (RealEstateAgent, Residence + Offer, Place) for GEO and AI-search visibility

## Design tokens
- Orange `#F15A2B`, slate `#242C34`
- Fraunces (display), DM Sans (body)

## Structure
```
yourplacegh/
  functions.php            bootstrap, setup, enqueue
  inc/
    cpt.php                post types + taxonomies (yp_status, yp_ptype, yp_city)
    meta.php               listing + location meta boxes, trust markers
    helpers.php            price, trust, rent advisory, whatsapp, stat row
    query.php              filter + sort via pre_get_posts
    schema.php             JSON-LD graph
  template-parts/          listing-card, filter-bar
  assets/css/main.css      tokens + full layout, responsive
  assets/js/main.js        nav toggle + sort
  assets/js/map.js         Leaflet
```

## Install
1. Upload `yourplacegh/` to `wp-content/themes/`
2. Activate. This registers post types, seeds status and property-type terms, and flushes rewrites.
3. Set a static front page or leave `front-page.php` to drive the homepage.
4. Add listings and neighborhood guides from the dashboard.

## NAP
HN 7, Nii Adjei Nkroma Street, Manet, Teshie, Accra / 053 960 1097 / info@yourplacegh.com

## Deploy
`.cpanel.yml` copies theme files into `public_html/wp-content/themes/yourplacegh` on git pull.

## Sprints delivered
- S1 Foundation: CPTs, taxonomies, meta, trust markers, search/filter, single + archive templates, schema, maps
- S2 Listings depth: multi-image gallery, amenities taxonomy, auto reference codes, related listings
- S3 Map search: archive map view with pins and grid/map toggle
- S4 GEO/SEO: Open Graph + meta description, BreadcrumbList and FAQPage schema
- S5 Conversion: AJAX enquiry form saving leads as a CPT + admin email, localStorage favorites
- S6 Performance: transient query caching with invalidation, resource hints

Built from the Master Architect Blueprint (2026).
