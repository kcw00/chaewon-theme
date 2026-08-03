/**
 * Chaewon theme behaviour.
 *
 * Four small things, no dependencies, no build step:
 *
 *   1. Colour scheme toggle
 *   2. Scroll reveal
 *   3. Scroll progress for the left rail
 *   4. Header scrolled state
 *
 * Everything here is an enhancement. The page is complete and readable
 * with this file removed — that is the constraint the whole design works
 * inside, and it is worth keeping.
 */
( function () {
	'use strict';

	/**
	 * Mirrors CHAEWON_SCHEME_KEY in functions.php.
	 *
	 * The inline bootstrap in <head> reads this key before first paint;
	 * this file writes it. Change one without the other and the toggle
	 * still works for the session but forgets on reload.
	 */
	var SCHEME_KEY = 'chaewon-scheme';

	var prefersReduced = window.matchMedia( '(prefers-reduced-motion: reduce)' ).matches;

	/* ---------------------------------------------------------------
	 * 1. Colour scheme
	 *
	 * The attribute is already correct when this runs — the inline
	 * bootstrap set it. All this does is wire up the button and keep
	 * its accessible state honest.
	 * --------------------------------------------------------------- */

	function initScheme() {
		var buttons = document.querySelectorAll( '[data-scheme-toggle]' );

		if ( ! buttons.length ) {
			return;
		}

		function current() {
			return document.documentElement.getAttribute( 'data-theme' ) === 'dark'
				? 'dark'
				: 'light';
		}

		function sync() {
			var isDark = current() === 'dark';

			Array.prototype.forEach.call( buttons, function ( button ) {
				// aria-pressed communicates the state of a toggle button.
				// Without it the control announces as a plain button and a
				// screen-reader user cannot tell which scheme is active.
				button.setAttribute( 'aria-pressed', String( isDark ) );
				button.setAttribute(
					'aria-label',
					isDark ? 'Switch to light theme' : 'Switch to dark theme'
				);
			} );
		}

		function set( scheme, persist ) {
			document.documentElement.setAttribute( 'data-theme', scheme );

			if ( persist ) {
				try {
					localStorage.setItem( SCHEME_KEY, scheme );
				} catch ( e ) {
					// Storage can be full or blocked. The toggle still works
					// for this page view; it just will not be remembered.
				}
			}

			sync();
		}

		sync();

		Array.prototype.forEach.call( buttons, function ( button ) {
			button.addEventListener( 'click', function () {
				set( current() === 'dark' ? 'light' : 'dark', true );
			} );
		} );

		// Follow the OS setting live, but only for visitors who have never
		// made an explicit choice. Overriding a deliberate choice because
		// the sun went down is the kind of thing that feels broken.
		var query = window.matchMedia( '(prefers-color-scheme: dark)' );

		function onSystemChange( event ) {
			var stored = null;

			try {
				stored = localStorage.getItem( SCHEME_KEY );
			} catch ( e ) {
				// Treat unreadable storage as "no preference recorded".
			}

			if ( stored === 'dark' || stored === 'light' ) {
				return;
			}

			set( event.matches ? 'dark' : 'light', false );
		}

		if ( query.addEventListener ) {
			query.addEventListener( 'change', onSystemChange );
		} else if ( query.addListener ) {
			// Safari before 14.
			query.addListener( onSystemChange );
		}
	}

	/* ---------------------------------------------------------------
	 * 2. Scroll reveal
	 *
	 * Adds `is-visible` to `.reveal` and `.reveal-stagger` elements as
	 * they enter the viewport. All the hiding CSS is scoped under
	 * `.js-reveal-ready`, which is added to <html> only here — so if this
	 * file never runs, nothing is ever hidden.
	 * --------------------------------------------------------------- */

	function initReveal() {
		var targets = document.querySelectorAll( '.reveal, .reveal-stagger' );

		if ( ! targets.length ) {
			return;
		}

		function showAll() {
			Array.prototype.forEach.call( targets, function ( el ) {
				el.classList.add( 'is-visible' );
			} );
		}

		if ( prefersReduced || ! ( 'IntersectionObserver' in window ) ) {
			showAll();
			return;
		}

		// Only now is it safe to let the hiding rules apply.
		document.documentElement.classList.add( 'js-reveal-ready' );

		var observer = new IntersectionObserver(
			function ( entries ) {
				entries.forEach( function ( entry ) {
					if ( ! entry.isIntersecting ) {
						return;
					}

					entry.target.classList.add( 'is-visible' );

					// Animate once. Replaying on every pass is the single
					// most common way scroll effects become irritating.
					observer.unobserve( entry.target );
				} );
			},
			{
				// Fire a little before the element reaches the bottom edge,
				// so the motion finishes as it settles into view.
				rootMargin: '0px 0px -12% 0px',
				threshold: 0.1,
			}
		);

		Array.prototype.forEach.call( targets, function ( el ) {
			observer.observe( el );
		} );
	}

	/* ---------------------------------------------------------------
	 * 3 + 4. Scroll progress and header state
	 *
	 * One scroll listener for both, throttled to one write per animation
	 * frame. Reading scrollY and writing a custom property on every raw
	 * scroll event is a reliable way to make a page feel heavy.
	 * --------------------------------------------------------------- */

	function initScroll() {
		var root = document.documentElement;
		var header = document.querySelector( '.site-header' );
		var ticking = false;

		function update() {
			ticking = false;

			var max = root.scrollHeight - window.innerHeight;
			var progress = max > 0 ? window.scrollY / max : 0;

			// Clamp: elastic scrolling on macOS and iOS reports values
			// outside the document, which would push the rail dot past the
			// end of its track.
			progress = Math.min( 1, Math.max( 0, progress ) );

			root.style.setProperty( '--scroll-progress', progress.toFixed( 4 ) );

			if ( header ) {
				header.classList.toggle( 'is-scrolled', window.scrollY > 24 );
			}
		}

		function onScroll() {
			if ( ticking ) {
				return;
			}

			ticking = true;
			window.requestAnimationFrame( update );
		}

		window.addEventListener( 'scroll', onScroll, { passive: true } );
		window.addEventListener( 'resize', onScroll, { passive: true } );

		update();
	}

	function init() {
		initScheme();
		initReveal();
		initScroll();
	}

	if ( document.readyState === 'loading' ) {
		document.addEventListener( 'DOMContentLoaded', init );
	} else {
		init();
	}
} )();
