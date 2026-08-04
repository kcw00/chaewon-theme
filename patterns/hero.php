<?php
/**
 * Title: Hero
 * Slug: chaewon/hero
 * Categories: chaewon, featured
 * Description: Full-viewport opening screen — name, tagline, and two calls to action.
 *
 * Patterns are reusable chunks of block markup. WordPress parses the
 * header comment above the same way it parses style.css; Title and Slug
 * are required. Once this file exists the pattern appears in the editor
 * inserter and can be referenced from a template with:
 *
 *     <!-- wp:pattern {"slug":"chaewon/hero"} /-->
 *
 * Being a .php file means translation functions and
 * get_template_directory_uri() are available for asset paths.
 *
 * @package Chaewon
 */

?>

<!-- wp:group {"tagName":"section","align":"wide","className":"hero","layout":{"type":"default"}} -->
<section class="wp-block-group alignwide hero">

	<!-- wp:heading {"level":1,"className":"hero__name"} -->
	<h1 class="wp-block-heading hero__name">Chaewon<br><mark style="background-color:rgba(0, 0, 0, 0)" class="has-inline-color has-signal-color">Kim</mark></h1>
	<!-- /wp:heading -->

	<!-- wp:paragraph {"className":"hero__tagline"} -->
	<p class="hero__tagline">Software engineer &mdash; I build the systems I run, and run the systems I build.</p>
	<!-- /wp:paragraph -->

	<!-- wp:group {"className":"hero__actions","layout":{"type":"default"}} -->
	<div class="wp-block-group hero__actions">

		<!-- wp:buttons -->
		<div class="wp-block-buttons">
			<!-- wp:button -->
			<div class="wp-block-button"><a class="wp-block-button__link wp-element-button" href="#work">See the work</a></div>
			<!-- /wp:button -->
		</div>
		<!-- /wp:buttons -->

		<!-- wp:paragraph {"style":{"spacing":{"margin":{"top":"0","bottom":"0"}}}} -->
		<p style="margin-top:0;margin-bottom:0"><a class="link-arrow" href="#about">About me</a></p>
		<!-- /wp:paragraph -->

	</div>
	<!-- /wp:group -->

	<!-- wp:paragraph {"className":"hero__cue label"} -->
	<p class="hero__cue label">Scroll</p>
	<!-- /wp:paragraph -->

</section>
<!-- /wp:group -->
