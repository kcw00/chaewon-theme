<?php
/**
 * Title: Chapter 03 — Notes & writing
 * Slug: chaewon/section-notes
 * Categories: chaewon
 * Description: Query loop over the four most recent posts, with date, title, and excerpt.
 *
 * This is the one section driven by real data rather than fixed copy.
 * The query block pulls published posts, so writing a post is all it
 * takes to fill it. core/query-no-results covers the empty state, which
 * is what a brand new install actually looks like.
 *
 * @package Chaewon
 */

?>

<!-- wp:group {"tagName":"section","align":"wide","className":"chapter","anchor":"notes","layout":{"type":"default"}} -->
<section id="notes" class="wp-block-group alignwide chapter">

	<!-- wp:group {"className":"chapter-rule","layout":{"type":"default"}} -->
	<div class="wp-block-group chapter-rule">
		<!-- wp:paragraph {"className":"chapter-rule__num"} -->
		<p class="chapter-rule__num">03</p>
		<!-- /wp:paragraph -->

		<!-- wp:paragraph {"className":"chapter-rule__label"} -->
		<p class="chapter-rule__label">Notes &amp; writing</p>
		<!-- /wp:paragraph -->
	</div>
	<!-- /wp:group -->

	<!-- wp:heading {"className":"chapter-title"} -->
	<h2 class="wp-block-heading chapter-title">Notes &amp; writing</h2>
	<!-- /wp:heading -->

	<!-- wp:paragraph {"className":"chapter-lead"} -->
	<p class="chapter-lead">Things I wanted to write down before they drifted away.</p>
	<!-- /wp:paragraph -->

	<!-- wp:query {"queryId":1,"query":{"perPage":4,"pages":1,"offset":0,"postType":"post","order":"desc","orderBy":"date","inherit":false},"className":"notes-list","layout":{"type":"default"}} -->
	<div class="wp-block-query notes-list">

		<!-- wp:post-template -->
			<!-- wp:post-date {"format":"Y","isLink":false} /-->

			<!-- wp:group {"className":"notes-row__body","layout":{"type":"default"}} -->
			<div class="wp-block-group notes-row__body">
				<!-- wp:post-title {"level":3,"isLink":true} /-->
				<!-- wp:post-excerpt {"excerptLength":26} /-->
			</div>
			<!-- /wp:group -->

			<!-- wp:html -->
			<span class="notes-row__arrow" aria-hidden="true">&rarr;</span>
			<!-- /wp:html -->
		<!-- /wp:post-template -->

		<!-- wp:query-no-results -->
			<!-- wp:paragraph {"textColor":"muted"} -->
			<p class="has-muted-color has-text-color">No posts yet. Write one in Posts &rarr; Add New and it will appear here.</p>
			<!-- /wp:paragraph -->
		<!-- /wp:query-no-results -->

	</div>
	<!-- /wp:query -->

	<!-- wp:paragraph {"className":"notes-more"} -->
	<p class="notes-more"><a class="link-arrow" href="/writing/">Browse all writing</a></p>
	<!-- /wp:paragraph -->

</section>
<!-- /wp:group -->
