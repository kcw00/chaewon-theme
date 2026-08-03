<?php
/**
 * Title: Project card
 * Slug: chaewon/project-card
 * Categories: chaewon
 * Description: One project as a card. Designed to live inside a query loop.
 * Inserter: no
 *
 * Used by both the homepage work grid and the /projects/ archive, so the
 * card only ever exists in one place. It reads entirely from the current
 * post, which means it must sit inside a post-template (or anything else
 * that sets the global post) to render anything.
 *
 * The tagline is a bound custom field rather than a block with typed
 * content — see the `tagline` meta registered in functions.php.
 *
 * `Inserter: no` keeps it out of the block inserter, where it would
 * render empty and confuse whoever clicked it.
 *
 * @package Chaewon
 */

?>

<!-- wp:group {"className":"work-card","layout":{"type":"default"}} -->
<div class="wp-block-group work-card">

	<!-- wp:group {"className":"work-card__meta-row","layout":{"type":"default"}} -->
	<div class="wp-block-group work-card__meta-row">
		<!-- wp:post-terms {"term":"project_type","className":"work-card__meta label"} /-->

		<!-- wp:html -->
		<span class="work-card__arrow" aria-hidden="true">&#8599;&#65038;</span>
		<!-- /wp:html -->
	</div>
	<!-- /wp:group -->

	<!-- wp:post-title {"level":3,"isLink":true,"className":"work-card__title"} /-->

	<!-- wp:paragraph {"className":"work-card__tagline","metadata":{"bindings":{"content":{"source":"core/post-meta","args":{"key":"tagline"}}}}} -->
	<p class="work-card__tagline"></p>
	<!-- /wp:paragraph -->

	<!-- wp:post-excerpt {"excerptLength":32,"className":"work-card__body"} /-->

	<!-- wp:post-terms {"term":"project_tech","className":"work-card__tags","separator":""} /-->

</div>
<!-- /wp:group -->
