<?php
/**
 * Title: Chapter 02 — Selected work
 * Slug: chaewon/section-work
 * Categories: chaewon
 * Description: The four most recent projects as a bento grid, linking through to /projects/.
 *
 * Driven by the `project` post type rather than hand-written cards, so
 * adding a project in wp-admin puts it here and on the archive at once.
 * The card itself lives in chaewon/project-card and is shared with
 * /projects/, so the two can never drift apart.
 *
 * Card sizes come from the modifier classes in section 09 of style.css,
 * applied by nth-child on .work-grid--home. A query loop emits identical
 * markup for every post, so the bento has to be positional.
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

	<!-- wp:query {"queryId":3,"query":{"perPage":4,"pages":1,"offset":0,"postType":"project","order":"desc","orderBy":"date","inherit":false},"layout":{"type":"default"}} -->
	<div class="wp-block-query">

		<!-- wp:post-template {"className":"work-grid work-grid--home reveal-stagger"} -->
			<!-- wp:pattern {"slug":"chaewon/project-card"} /-->
		<!-- /wp:post-template -->

		<!-- wp:query-no-results -->
			<!-- wp:paragraph {"textColor":"muted"} -->
			<p class="has-muted-color has-text-color">No projects yet. Add one under Projects &rarr; Add Project and it will appear here.</p>
			<!-- /wp:paragraph -->
		<!-- /wp:query-no-results -->

	</div>
	<!-- /wp:query -->

	<!-- wp:paragraph {"className":"work-more"} -->
	<p class="work-more"><a class="link-arrow" href="/projects/">See all projects</a></p>
	<!-- /wp:paragraph -->

</section>
<!-- /wp:group -->
