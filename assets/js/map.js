/**
 * Leaflet maps.
 * - Single view: one marker from #listing-map data attributes.
 * - Archive view: multiple pins from window.ypghPins, with grid/map toggle.
 */
(function () {
	'use strict';

	var TILE = 'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png';
	var ATTR = '&copy; OpenStreetMap contributors';

	function singleMap() {
		var el = document.getElementById('listing-map');
		if (!el || typeof L === 'undefined') { return; }

		var lat = parseFloat(el.dataset.lat);
		var lng = parseFloat(el.dataset.lng);
		var label = el.dataset.label || '';
		if (isNaN(lat) || isNaN(lng)) { return; }

		var map = L.map(el, { scrollWheelZoom: false }).setView([lat, lng], 15);
		L.tileLayer(TILE, { maxZoom: 19, attribution: ATTR }).addTo(map);
		var marker = L.marker([lat, lng]).addTo(map);
		if (label) { marker.bindPopup(label).openPopup(); }

		map.on('click', function () { map.scrollWheelZoom.enable(); });
		map.on('mouseout', function () { map.scrollWheelZoom.disable(); });
	}

	function archiveMap() {
		var el = document.getElementById('archive-map');
		if (!el || typeof L === 'undefined' || typeof window.ypghPins === 'undefined') { return; }

		var pins = window.ypghPins;
		if (!pins.length) {
			el.innerHTML = '<p class="map-empty">No mapped listings in this view.</p>';
			return;
		}

		var map = L.map(el, { scrollWheelZoom: true });
		L.tileLayer(TILE, { maxZoom: 19, attribution: ATTR }).addTo(map);

		var group = [];
		pins.forEach(function (p) {
			var m = L.marker([p.lat, p.lng]).addTo(map);
			m.bindPopup(
				'<strong>' + p.price + '</strong><br>' +
				'<a href="' + p.url + '">' + p.title + '</a>'
			);
			group.push([p.lat, p.lng]);
		});

		map.fitBounds(group, { padding: [40, 40], maxZoom: 15 });
	}

	function toggle() {
		var btn = document.getElementById('view-toggle');
		if (!btn) { return; }
		var grid = document.getElementById('listing-results');
		var mapWrap = document.getElementById('archive-map-wrap');
		var built = false;

		btn.addEventListener('click', function () {
			var showMap = mapWrap.hasAttribute('hidden');
			if (showMap) {
				mapWrap.removeAttribute('hidden');
				if (grid) { grid.setAttribute('hidden', ''); }
				btn.textContent = btn.dataset.gridLabel;
				if (!built) { archiveMap(); built = true; }
			} else {
				mapWrap.setAttribute('hidden', '');
				if (grid) { grid.removeAttribute('hidden'); }
				btn.textContent = btn.dataset.mapLabel;
			}
		});
	}

	document.addEventListener('DOMContentLoaded', function () {
		singleMap();
		toggle();
	});
})();
