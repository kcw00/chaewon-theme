<?php
/**
 * Title: Chapter 02 — Selected work
 * Slug: chaewon/section-work
 * Categories: chaewon
 * Description: Bento grid of project cards — one feature, one tall, two smaller.
 *
 * Card size is set by a modifier class on the group: --feature, --tall,
 * --narrow, or --wide. Change the modifier to rearrange the grid; the
 * spans are defined once in section 09 of style.css.
 *
 * @package Chaewon
 */

?>

<!-- wp:group {"tagName":"section","align":"wide","className":"chapter","anchor":"work","layout":{"type":"default"}} -->
<section id="work" class="wp-block-group alignwide chapter">

	<!-- wp:group {"className":"chapter-rule","layout":{"type":"default"}} -->
	<div class="wp-block-group chapter-rule">
		<!-- wp:paragraph {"className":"chapter-rule__num"} -->
		<p class="chapter-rule__num">02</p>
		<!-- /wp:paragraph -->

		<!-- wp:paragraph {"className":"chapter-rule__label"} -->
		<p class="chapter-rule__label">Selected work</p>
		<!-- /wp:paragraph -->
	</div>
	<!-- /wp:group -->

	<!-- wp:heading {"className":"chapter-title"} -->
	<h2 class="wp-block-heading chapter-title">Things I&rsquo;ve built</h2>
	<!-- /wp:heading -->

	<!-- wp:paragraph {"className":"chapter-lead"} -->
	<p class="chapter-lead">The ones I would actually walk you through, not the ones that pad a list.</p>
	<!-- /wp:paragraph -->

	<!-- wp:group {"className":"work-grid reveal-stagger","layout":{"type":"default"}} -->
	<div class="wp-block-group work-grid reveal-stagger">

		<!-- wp:group {"className":"work-card work-card--feature","layout":{"type":"default"}} -->
		<div class="wp-block-group work-card work-card--feature">
			<!-- wp:group {"className":"work-card__meta-row","layout":{"type":"default"}} -->
			<div class="wp-block-group work-card__meta-row">
				<!-- wp:paragraph {"className":"work-card__meta label label--dot"} -->
				<p class="work-card__meta label label--dot">Booking platform &middot; 2024&ndash;</p>
				<!-- /wp:paragraph -->

				<!-- wp:html -->
				<span class="work-card__arrow" aria-hidden="true">&#8599;</span>
				<!-- /wp:html -->
			</div>
			<!-- /wp:group -->

			<!-- wp:heading {"level":3,"className":"work-card__title"} -->
			<h3 class="wp-block-heading work-card__title"><a class="work-card__link" href="https://github.com/kcw00">Booking Platform</a></h3>
			<!-- /wp:heading -->

			<!-- wp:paragraph {"className":"work-card__tagline"} -->
			<p class="work-card__tagline">Scheduling that survives the double-book.</p>
			<!-- /wp:paragraph -->

			<!-- wp:paragraph {"className":"work-card__body"} -->
			<p class="work-card__body">Replace this with the problem you were solving. What broke, what you tried first, and what you would do differently. Lead with the problem, not the stack &mdash; anyone can list technologies, and nobody remembers them.</p>
			<!-- /wp:paragraph -->

			<!-- wp:group {"className":"work-card__tags","layout":{"type":"default"}} -->
			<div class="wp-block-group work-card__tags">
				<!-- wp:paragraph {"className":"label label--chip"} -->
				<p class="label label--chip">Django REST</p>
				<!-- /wp:paragraph -->
				<!-- wp:paragraph {"className":"label label--chip"} -->
				<p class="label label--chip">PostgreSQL</p>
				<!-- /wp:paragraph -->
				<!-- wp:paragraph {"className":"label label--chip"} -->
				<p class="label label--chip">React</p>
				<!-- /wp:paragraph -->
			</div>
			<!-- /wp:group -->
		</div>
		<!-- /wp:group -->

		<!-- wp:group {"className":"work-card work-card--tall","layout":{"type":"default"}} -->
		<div class="wp-block-group work-card work-card--tall">
			<!-- wp:group {"className":"work-card__meta-row","layout":{"type":"default"}} -->
			<div class="wp-block-group work-card__meta-row">
				<!-- wp:paragraph {"className":"work-card__meta label"} -->
				<p class="work-card__meta label">Full stack &middot; 2023&ndash;</p>
				<!-- /wp:paragraph -->

				<!-- wp:html -->
				<span class="work-card__arrow" aria-hidden="true">&#8599;</span>
				<!-- /wp:html -->
			</div>
			<!-- /wp:group -->

			<!-- wp:heading {"level":3,"className":"work-card__title"} -->
			<h3 class="wp-block-heading work-card__title"><a class="work-card__link" href="https://github.com/kcw00">NoteApp</a></h3>
			<!-- /wp:heading -->

			<!-- wp:paragraph {"className":"work-card__tagline"} -->
			<p class="work-card__tagline">Notes that stay where you put them.</p>
			<!-- /wp:paragraph -->

			<!-- wp:paragraph {"className":"work-card__body"} -->
			<p class="work-card__body">What it does, and the one decision you are still not sure about.</p>
			<!-- /wp:paragraph -->

			<!-- wp:group {"className":"work-card__tags","layout":{"type":"default"}} -->
			<div class="wp-block-group work-card__tags">
				<!-- wp:paragraph {"className":"label label--chip"} -->
				<p class="label label--chip">Node</p>
				<!-- /wp:paragraph -->
				<!-- wp:paragraph {"className":"label label--chip"} -->
				<p class="label label--chip">Postgres</p>
				<!-- /wp:paragraph -->
			</div>
			<!-- /wp:group -->
		</div>
		<!-- /wp:group -->

		<!-- wp:group {"className":"work-card work-card--narrow","layout":{"type":"default"}} -->
		<div class="wp-block-group work-card work-card--narrow">
			<!-- wp:group {"className":"work-card__meta-row","layout":{"type":"default"}} -->
			<div class="wp-block-group work-card__meta-row">
				<!-- wp:paragraph {"className":"work-card__meta label"} -->
				<p class="work-card__meta label">Orchestration &middot; 2025</p>
				<!-- /wp:paragraph -->

				<!-- wp:html -->
				<span class="work-card__arrow" aria-hidden="true">&#8599;</span>
				<!-- /wp:html -->
			</div>
			<!-- /wp:group -->

			<!-- wp:heading {"level":3,"className":"work-card__title"} -->
			<h3 class="wp-block-heading work-card__title"><a class="work-card__link" href="https://github.com/kcw00">NoteApp Minion</a></h3>
			<!-- /wp:heading -->

			<!-- wp:paragraph {"className":"work-card__body"} -->
			<p class="work-card__body">Background jobs I can trigger and watch from Discord, because that is where I already am.</p>
			<!-- /wp:paragraph -->

			<!-- wp:group {"className":"work-card__tags","layout":{"type":"default"}} -->
			<div class="wp-block-group work-card__tags">
				<!-- wp:paragraph {"className":"label label--chip"} -->
				<p class="label label--chip">Kubernetes</p>
				<!-- /wp:paragraph -->
			</div>
			<!-- /wp:group -->
		</div>
		<!-- /wp:group -->

		<!-- wp:group {"className":"work-card work-card--wide","layout":{"type":"default"}} -->
		<div class="wp-block-group work-card work-card--wide">
			<!-- wp:group {"className":"work-card__meta-row","layout":{"type":"default"}} -->
			<div class="wp-block-group work-card__meta-row">
				<!-- wp:paragraph {"className":"work-card__meta label"} -->
				<p class="work-card__meta label">Infrastructure &middot; ongoing</p>
				<!-- /wp:paragraph -->

				<!-- wp:html -->
				<span class="work-card__arrow" aria-hidden="true">&#8599;</span>
				<!-- /wp:html -->
			</div>
			<!-- /wp:group -->

			<!-- wp:heading {"level":3,"className":"work-card__title"} -->
			<h3 class="wp-block-heading work-card__title"><a class="work-card__link" href="https://github.com/kcw00">Home Cluster</a></h3>
			<!-- /wp:heading -->

			<!-- wp:paragraph {"className":"work-card__body"} -->
			<p class="work-card__body">A hybrid k3s cluster I run at home and break on purpose. Everything I know about failure modes I learned here first and in production second.</p>
			<!-- /wp:paragraph -->

			<!-- wp:group {"className":"work-card__tags","layout":{"type":"default"}} -->
			<div class="wp-block-group work-card__tags">
				<!-- wp:paragraph {"className":"label label--chip"} -->
				<p class="label label--chip">k3s</p>
				<!-- /wp:paragraph -->
				<!-- wp:paragraph {"className":"label label--chip"} -->
				<p class="label label--chip">Docker</p>
				<!-- /wp:paragraph -->
				<!-- wp:paragraph {"className":"label label--chip"} -->
				<p class="label label--chip">Nginx</p>
				<!-- /wp:paragraph -->
			</div>
			<!-- /wp:group -->
		</div>
		<!-- /wp:group -->

	</div>
	<!-- /wp:group -->

	<!-- wp:paragraph {"className":"work-more"} -->
	<p class="work-more"><a class="link-arrow" href="https://github.com/kcw00">Everything else on GitHub</a></p>
	<!-- /wp:paragraph -->

</section>
<!-- /wp:group -->
