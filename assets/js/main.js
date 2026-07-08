/**
 * YourPlaceGH front-end interactions.
 */
(function () {
	'use strict';

	// FAQ accordion.
	document.querySelectorAll('.faq-q').forEach(function (btn) {
		btn.addEventListener('click', function () {
			var open = btn.getAttribute('aria-expanded') === 'true';
			var panel = document.getElementById(btn.getAttribute('aria-controls'));
			btn.setAttribute('aria-expanded', open ? 'false' : 'true');
			btn.closest('.faq-item').classList.toggle('is-open', !open);
			if (panel) {
				if (open) { panel.setAttribute('hidden', ''); }
				else { panel.removeAttribute('hidden'); }
			}
		});
	});

	// Mobile nav toggle.
	var toggle = document.querySelector('.nav-toggle');
	var nav = document.querySelector('.primary-nav');
	if (toggle && nav) {
		toggle.addEventListener('click', function () {
			var open = nav.classList.toggle('is-open');
			toggle.setAttribute('aria-expanded', open ? 'true' : 'false');
		});
	}

	// Header shadow on scroll.
	var header = document.querySelector('.site-header');
	if (header) {
		var onScroll = function () {
			header.classList.toggle('is-scrolled', window.scrollY > 8);
		};
		onScroll();
		window.addEventListener('scroll', onScroll, { passive: true });
	}

	// Scroll reveal + ring fill, respecting reduced motion.
	var reduce = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
	if (!reduce && 'IntersectionObserver' in window) {
		document.querySelectorAll('.section, .listing-card, .location-card').forEach(function (el) {
			el.classList.add('reveal');
		});
		var io = new IntersectionObserver(function (entries) {
			entries.forEach(function (e) {
				if (e.isIntersecting) { e.target.classList.add('is-in'); io.unobserve(e.target); }
			});
		}, { threshold: 0.08, rootMargin: '0px 0px -40px 0px' });
		document.querySelectorAll('.reveal').forEach(function (el) { io.observe(el); });
	}

	// Archive sort.
	window.ypghSort = function (value) {
		var url = new URL(window.location.href);
		if (value) { url.searchParams.set('sort', value); }
		else { url.searchParams.delete('sort'); }
		url.searchParams.delete('paged');
		window.location.href = url.toString();
	};

	// ---------- Favorites (localStorage) ----------
	var FAV_KEY = 'ypgh_favorites';

	function favs() {
		try { return JSON.parse(localStorage.getItem(FAV_KEY)) || []; }
		catch (e) { return []; }
	}
	function saveFavs(list) {
		try { localStorage.setItem(FAV_KEY, JSON.stringify(list)); } catch (e) {}
	}
	function paintFavs() {
		var list = favs();
		document.querySelectorAll('.fav-btn').forEach(function (btn) {
			var id = btn.dataset.id;
			var on = list.indexOf(id) !== -1;
			btn.classList.toggle('is-fav', on);
			btn.setAttribute('aria-pressed', on ? 'true' : 'false');
		});
	}
	document.addEventListener('click', function (e) {
		var btn = e.target.closest('.fav-btn');
		if (!btn) { return; }
		e.preventDefault();
		var id = btn.dataset.id;
		var list = favs();
		var i = list.indexOf(id);
		if (i === -1) { list.push(id); } else { list.splice(i, 1); }
		saveFavs(list);
		paintFavs();
	});
	paintFavs();

	// ---------- Enquiry form ----------
	var form = document.getElementById('ypgh-enquiry');
	if (form && typeof ypghData !== 'undefined') {
		form.addEventListener('submit', function (e) {
			e.preventDefault();
			var status = form.querySelector('.enquiry-status');
			var submit = form.querySelector('button[type="submit"]');
			var data = new FormData(form);
			data.append('action', 'ypgh_lead');
			data.append('nonce', ypghData.nonce);

			submit.disabled = true;
			if (status) { status.textContent = 'Sending...'; status.className = 'enquiry-status'; }

			fetch(ypghData.ajaxUrl, { method: 'POST', body: data })
				.then(function (r) { return r.json().then(function (j) { return { ok: r.ok, j: j }; }); })
				.then(function (res) {
					if (res.ok && res.j.success) {
						form.reset();
						if (status) { status.textContent = res.j.data.message; status.className = 'enquiry-status is-ok'; }
					} else {
						var msg = (res.j.data && res.j.data.message) || 'Please check your details.';
						if (status) { status.textContent = msg; status.className = 'enquiry-status is-err'; }
					}
				})
				.catch(function () {
					if (status) { status.textContent = 'Network error. Try WhatsApp instead.'; status.className = 'enquiry-status is-err'; }
				})
				.finally(function () { submit.disabled = false; });
		});
	}
})();
