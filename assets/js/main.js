/**
 * YourPlaceGH v3 front-end behaviour.
 * Mobile nav, scroll reveals, FAQ accordion, enquiry mailto builder.
 */
(function () {
	'use strict';

	/* ---------- Mobile nav ---------- */
	var header = document.getElementById('header');
	var burger = document.getElementById('burger');

	if (header && burger) {
		burger.addEventListener('click', function (e) {
			e.stopPropagation();
			var open = header.classList.toggle('menu-open');
			burger.setAttribute('aria-expanded', open ? 'true' : 'false');
		});

		header.addEventListener('click', function (e) {
			if (e.target.closest('.nav a')) {
				header.classList.remove('menu-open');
				burger.setAttribute('aria-expanded', 'false');
			}
		});

		document.addEventListener('click', function (e) {
			if (header.classList.contains('menu-open') && !header.contains(e.target)) {
				header.classList.remove('menu-open');
				burger.setAttribute('aria-expanded', 'false');
			}
		});

		document.addEventListener('keydown', function (e) {
			if ('Escape' === e.key) {
				header.classList.remove('menu-open');
				burger.setAttribute('aria-expanded', 'false');
			}
		});

		window.addEventListener('resize', function () {
			if (window.innerWidth > 1024) {
				header.classList.remove('menu-open');
				burger.setAttribute('aria-expanded', 'false');
			}
		});
	}

	/* ---------- Scroll reveals ---------- */
	var reveals = document.querySelectorAll('.reveal');
	var reduced = window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;

	if (reveals.length) {
		if (reduced || !('IntersectionObserver' in window)) {
			reveals.forEach(function (el) { el.classList.add('in'); });
		} else {
			var io = new IntersectionObserver(function (entries) {
				entries.forEach(function (entry) {
					if (entry.isIntersecting) {
						entry.target.classList.add('in');
						io.unobserve(entry.target);
					}
				});
			}, { threshold: 0.12, rootMargin: '0px 0px -40px 0px' });
			reveals.forEach(function (el) { io.observe(el); });
		}
	}

	/* ---------- FAQ accordion ---------- */
	document.querySelectorAll('.faq-item').forEach(function (item) {
		var q = item.querySelector('.faq-q');
		var a = item.querySelector('.faq-a');
		if (!q || !a) {
			return;
		}
		q.addEventListener('click', function () {
			var isOpen = item.classList.contains('open');
			item.closest('.faq-list').querySelectorAll('.faq-item.open').forEach(function (other) {
				other.classList.remove('open');
				other.querySelector('.faq-a').style.maxHeight = '';
				other.querySelector('.faq-q').setAttribute('aria-expanded', 'false');
			});
			if (!isOpen) {
				item.classList.add('open');
				a.style.maxHeight = a.scrollHeight + 'px';
				q.setAttribute('aria-expanded', 'true');
			}
		});
	});

	/* ---------- Enquiry mailto builder ---------- */
	var send = document.getElementById('eq-send');
	if (send) {
		send.addEventListener('click', function () {
			var name = (document.getElementById('eq-name') || {}).value || '';
			var email = (document.getElementById('eq-email') || {}).value || '';
			var msg = (document.getElementById('eq-msg') || {}).value || '';
			var subject = 'Property enquiry: ' + (send.getAttribute('data-title') || '');
			var body = msg + '\n\nName: ' + name + '\nEmail: ' + email + '\nPage: ' + window.location.href;
			window.location.href = 'mailto:' + (send.getAttribute('data-to') || '') +
				'?subject=' + encodeURIComponent(subject) +
				'&body=' + encodeURIComponent(body);
		});
	}
})();
