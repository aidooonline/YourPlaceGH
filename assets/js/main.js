/* YourPlaceGH theme scripts */
(function () {
	'use strict';

	var reduce = window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;

	/* ---------- Hero slider ---------- */
	function initHero() {
		var hero = document.getElementById('hero');
		if (!hero) return;
		var slides = hero.querySelectorAll('.slide');
		if (slides.length < 2) return;
		var dotsWrap = document.getElementById('dots');
		var i = 0, timer = null;

		var dots = [];
		if (dotsWrap) {
			slides.forEach(function (_, idx) {
				var b = document.createElement('button');
				b.setAttribute('aria-label', 'Slide ' + (idx + 1));
				if (idx === 0) b.className = 'active';
				b.addEventListener('click', function () { go(idx); });
				dotsWrap.appendChild(b);
				dots.push(b);
			});
		}

		function go(n) {
			slides[i].classList.remove('active');
			if (dots[i]) dots[i].classList.remove('active');
			i = (n + slides.length) % slides.length;
			slides[i].classList.add('active');
			if (dots[i]) dots[i].classList.add('active');
		}
		function next() { go(i + 1); }
		function prev() { go(i - 1); }
		function start() { if (!reduce) { stop(); timer = setInterval(next, 6000); } }
		function stop() { if (timer) clearInterval(timer); }

		var nb = document.getElementById('next'), pb = document.getElementById('prev');
		if (nb) nb.addEventListener('click', function () { next(); start(); });
		if (pb) pb.addEventListener('click', function () { prev(); start(); });
		start();
	}

	/* ---------- Sticky header (front page only) ---------- */
	function initSticky() {
		var header = document.getElementById('header');
		if (!header || header.classList.contains('solid')) return;
		function onScroll() {
			if (window.scrollY > 120) header.classList.add('scrolled');
			else header.classList.remove('scrolled');
		}
		window.addEventListener('scroll', onScroll, { passive: true });
		onScroll();
	}

	/* ---------- Mobile nav ---------- */
	function initNav() {
		var burger = document.getElementById('burger'), nav = document.getElementById('nav');
		if (!burger || !nav) return;
		burger.addEventListener('click', function () { nav.classList.toggle('open'); });
	}

	/* ---------- Reveal on scroll ---------- */
	function initReveal() {
		var items = document.querySelectorAll('.reveal');
		if (!items.length) return;
		if (reduce || !('IntersectionObserver' in window)) {
			items.forEach(function (el) { el.classList.add('in'); });
			return;
		}
		var obs = new IntersectionObserver(function (entries) {
			entries.forEach(function (e) {
				if (e.isIntersecting) { e.target.classList.add('in'); obs.unobserve(e.target); }
			});
		}, { threshold: 0.12 });
		items.forEach(function (el) { obs.observe(el); });
	}

	/* ---------- FAQ accordion ---------- */
	function initFaq() {
		var qs = document.querySelectorAll('.faq-q');
		qs.forEach(function (q) {
			q.addEventListener('click', function () {
				var item = q.closest('.faq-item');
				if (item) item.classList.toggle('open');
			});
		});
	}

	/* ---------- Single listing enquiry mailto ---------- */
	function initEnquiry() {
		var send = document.getElementById('sp-send');
		if (!send) return;
		send.addEventListener('click', function (ev) {
			var name = (document.getElementById('sp-name') || {}).value || '';
			var email = (document.getElementById('sp-email') || {}).value || '';
			var msg = (document.getElementById('sp-msg') || {}).value || '';
			var to = send.getAttribute('data-email');
			var subject = send.getAttribute('data-subject') || 'Property enquiry';
			var body = 'Name: ' + name + '\nEmail: ' + email + '\n\n' + msg;
			send.setAttribute('href', 'mailto:' + to + '?subject=' + encodeURIComponent(subject) + '&body=' + encodeURIComponent(body));
		});
	}

	document.addEventListener('DOMContentLoaded', function () {
		initHero();
		initSticky();
		initNav();
		initReveal();
		initFaq();
		initEnquiry();
	});
})();
