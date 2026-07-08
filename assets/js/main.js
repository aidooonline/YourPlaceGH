/**
 * YourPlaceGH front-end interactions.
 */
(function () {
	'use strict';

	var toggle = document.querySelector('.nav-toggle');
	var nav = document.querySelector('.primary-nav');
	if (toggle && nav) {
		toggle.addEventListener('click', function () {
			var open = nav.classList.toggle('is-open');
			toggle.setAttribute('aria-expanded', open ? 'true' : 'false');
		});
	}

	window.ypghSort = function (value) {
		var url = new URL(window.location.href);
		if (value) {
			url.searchParams.set('sort', value);
		} else {
			url.searchParams.delete('sort');
		}
		url.searchParams.delete('paged');
		window.location.href = url.toString();
	};
})();
