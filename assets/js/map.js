/**
 * Leaflet map for single listing and location pages.
 */
(function () {
	'use strict';

	var el = document.getElementById('listing-map');
	if (!el || typeof L === 'undefined') {
		return;
	}

	var lat = parseFloat(el.dataset.lat);
	var lng = parseFloat(el.dataset.lng);
	var label = el.dataset.label || '';

	if (isNaN(lat) || isNaN(lng)) {
		return;
	}

	var map = L.map(el, { scrollWheelZoom: false }).setView([lat, lng], 15);

	L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
		maxZoom: 19,
		attribution: '&copy; OpenStreetMap contributors'
	}).addTo(map);

	var marker = L.marker([lat, lng]).addTo(map);
	if (label) {
		marker.bindPopup(label).openPopup();
	}

	map.on('click', function () { map.scrollWheelZoom.enable(); });
	map.on('mouseout', function () { map.scrollWheelZoom.disable(); });
})();
