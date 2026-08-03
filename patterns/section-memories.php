<?php
/**
 * Title: Chapter 04 — Memories
 * Slug: chaewon/section-memories
 * Categories: chaewon
 * Description: Masonry board mixing photo placeholders with short written notes.
 *
 * The photo slots are plates, not empty Image blocks. An Image block
 * with nothing attached renders to nothing on the front end, so a board
 * built from empty ones silently collapses. Select a plate in the editor
 * and replace it with an Image block when there is a photo for it.
 *
 * @package Chaewon
 */

?>

<!-- wp:group {"tagName":"section","align":"wide","className":"chapter","anchor":"memories","layout":{"type":"default"}} -->
<section id="memories" class="wp-block-group alignwide chapter">

	<!-- wp:group {"className":"chapter-rule","layout":{"type":"default"}} -->
	<div class="wp-block-group chapter-rule">
		<!-- wp:paragraph {"className":"chapter-rule__num"} -->
		<p class="chapter-rule__num">04</p>
		<!-- /wp:paragraph -->

		<!-- wp:paragraph {"className":"chapter-rule__label"} -->
		<p class="chapter-rule__label">Memories</p>
		<!-- /wp:paragraph -->
	</div>
	<!-- /wp:group -->

	<!-- wp:heading {"className":"chapter-title"} -->
	<h2 class="wp-block-heading chapter-title">Things I&rsquo;ve seen</h2>
	<!-- /wp:heading -->

	<!-- wp:paragraph {"className":"chapter-lead"} -->
	<p class="chapter-lead">Small things I noticed and did not want to lose.</p>
	<!-- /wp:paragraph -->

	<!-- wp:group {"className":"memory-board reveal","layout":{"type":"default"}} -->
	<div class="wp-block-group memory-board reveal">

		<!-- wp:group {"className":"memory-plate","layout":{"type":"default"}} -->
		<div class="wp-block-group memory-plate">
			<!-- wp:paragraph {"className":"label"} -->
			<p class="label">Seoul</p>
			<!-- /wp:paragraph -->
		</div>
		<!-- /wp:group -->

		<!-- wp:group {"className":"memory-note","layout":{"type":"default"}} -->
		<div class="wp-block-group memory-note">
			<!-- wp:paragraph {"className":"memory-note__text"} -->
			<p class="memory-note__text">Build slowly, build well. The work that lasts is rarely the work that was rushed.</p>
			<!-- /wp:paragraph -->

			<!-- wp:paragraph {"className":"memory-note__source label label--dot"} -->
			<p class="memory-note__source label label--dot">Note to self</p>
			<!-- /wp:paragraph -->
		</div>
		<!-- /wp:group -->

		<!-- wp:group {"className":"memory-plate memory-plate--square","layout":{"type":"default"}} -->
		<div class="wp-block-group memory-plate memory-plate--square">
			<!-- wp:paragraph {"className":"label"} -->
			<p class="label">Vancouver</p>
			<!-- /wp:paragraph -->
		</div>
		<!-- /wp:group -->

		<!-- wp:group {"className":"memory-plate memory-plate--wide","layout":{"type":"default"}} -->
		<div class="wp-block-group memory-plate memory-plate--wide">
			<!-- wp:paragraph {"className":"label"} -->
			<p class="label">Desk</p>
			<!-- /wp:paragraph -->
		</div>
		<!-- /wp:group -->

		<!-- wp:group {"className":"memory-note","layout":{"type":"default"}} -->
		<div class="wp-block-group memory-note">
			<!-- wp:paragraph {"className":"memory-note__text"} -->
			<p class="memory-note__text">Ship things that matter to people, not things that look good in a screenshot.</p>
			<!-- /wp:paragraph -->

			<!-- wp:paragraph {"className":"memory-note__source label"} -->
			<p class="memory-note__source label">Vancouver</p>
			<!-- /wp:paragraph -->
		</div>
		<!-- /wp:group -->

		<!-- wp:group {"className":"memory-plate","layout":{"type":"default"}} -->
		<div class="wp-block-group memory-plate">
			<!-- wp:paragraph {"className":"label"} -->
			<p class="label">Somewhere between</p>
			<!-- /wp:paragraph -->
		</div>
		<!-- /wp:group -->

	</div>
	<!-- /wp:group -->

</section>
<!-- /wp:group -->
