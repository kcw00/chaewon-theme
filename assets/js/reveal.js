/**
 * Scroll reveal.
 *
 * Adds `is-visible` to any element carrying the `reveal` or
 * `reveal-stagger` class once it enters the viewport. The CSS in
 * style.css does the actual animating.
 *
 * Two deliberate choices worth understanding:
 *
 * 1. The `js-reveal-ready` class is added to <html> by this script.
 *    All the hiding CSS is scoped under that class, so if JavaScript
 *    fails to load, nothing is ever hidden. Content first.
 *
 * 2. The observer unobserves after firing. Elements animate once, not
 *    every time you scroll past. Re-animating on every pass is the
 *    single most common way scroll effects become annoying.
 */
( function () {
	'use strict';

	var SELECTOR = '.reveal, .reveal-stagger';

	function init() {
		var targets = document.querySelectorAll( SELECTOR );

		if ( ! targets.length ) {
			return;
		}

		// Respect the OS-level motion preference: show everything, skip
		// the animation entirely.
		var prefersReduced = window.matchMedia(
			'(prefers-reduced-motion: reduce)'
		).matches;

		if ( prefersReduced || ! ( 'IntersectionObserver' in window ) ) {
			targets.forEach( function ( el ) {
				el.classList.add( 'is-visible' );
			} );
			return;
		}

		// Only now do we allow the hiding CSS to apply.
		document.documentElement.classList.add( 'js-reveal-ready' );

		var observer = new IntersectionObserver(
			function ( entries ) {
				entries.forEach( function ( entry ) {
					if ( ! entry.isIntersecting ) {
						return;
					}
					entry.target.classList.add( 'is-visible' );
					observer.unobserve( entry.target );
				} );
			},
			{
				// Fire slightly before the element reaches the bottom
				// edge, so the motion finishes as it settles into view.
				rootMargin: '0px 0px -12% 0px',
				threshold: 0.1,
			}
		);

		targets.forEach( function ( el ) {
			observer.observe( el );
		} );
	}

	if ( document.readyState === 'loading' ) {
		document.addEventListener( 'DOMContentLoaded', init );
	} else {
		init();
	}
} )();
