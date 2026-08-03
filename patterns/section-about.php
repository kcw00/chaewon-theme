<?php
/**
 * Title: Chapter 01 — About me
 * Slug: chaewon/section-about
 * Categories: chaewon
 * Description: Numbered chapter rule, long-form prose, and a Seoul to Vancouver journey line.
 *
 * @package Chaewon
 */

?>

<!-- wp:group {"tagName":"section","align":"wide","className":"chapter","anchor":"about","layout":{"type":"default"}} -->
<section id="about" class="wp-block-group alignwide chapter">

	<!-- wp:group {"className":"chapter-rule","layout":{"type":"default"}} -->
	<div class="wp-block-group chapter-rule">
		<!-- wp:paragraph {"className":"chapter-rule__num"} -->
		<p class="chapter-rule__num">01</p>
		<!-- /wp:paragraph -->

		<!-- wp:paragraph {"className":"chapter-rule__label"} -->
		<p class="chapter-rule__label">About me</p>
		<!-- /wp:paragraph -->
	</div>
	<!-- /wp:group -->

	<!-- wp:heading {"className":"chapter-title"} -->
	<h2 class="wp-block-heading chapter-title">How I got here</h2>
	<!-- /wp:heading -->

	<!-- wp:paragraph {"className":"chapter-lead"} -->
	<p class="chapter-lead">A few honest paragraphs about where I started and what I am building now.</p>
	<!-- /wp:paragraph -->

	<!-- wp:group {"className":"about__prose prose","layout":{"type":"default"}} -->
	<div class="wp-block-group about__prose prose">
		<!-- wp:paragraph -->
		<p>I grew up in Seoul and moved to Vancouver, which is a longer story than it sounds and a shorter one than it felt. Most of what I know about being patient with a problem started somewhere in that gap.</p>
		<!-- /wp:paragraph -->

		<!-- wp:paragraph -->
		<p>I write backend services and then I run them. That second part is the one that changed how I write the first part &mdash; it is hard to ship something careless when you are the person who gets paged for it at 3am.</p>
		<!-- /wp:paragraph -->

		<!-- wp:paragraph -->
		<p>These days that means Django and Postgres, containers and Kubernetes, and a home cluster I keep breaking on purpose so I understand it before it breaks on its own. Still building. That part has not changed.</p>
		<!-- /wp:paragraph -->
	</div>
	<!-- /wp:group -->

	<!-- wp:html -->
	<div class="journey">
		<div class="journey__stop">
			<p class="journey__place">Seoul, KR</p>
		</div>

		<div class="journey__span">
			<span class="journey__dot journey__dot--start" aria-hidden="true"></span>
			<p class="journey__distance">~8,200 km</p>
			<span class="journey__dot journey__dot--end" aria-hidden="true"></span>
		</div>

		<div class="journey__stop journey__stop--end">
			<p class="journey__place">Vancouver, CA</p>
		</div>
	</div>
	<!-- /wp:html -->

</section>
<!-- /wp:group -->
