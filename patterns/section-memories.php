<?php
/**
 * Title: Chapter 04 — Memories
 * Slug: chaewon/section-memories
 * Categories: chaewon
 * Description: Masonry board of photographs.
 *
 * The photos are theme assets rather than media-library attachments, so
 * they travel with the repository and a fresh install is not an empty
 * board. That is the trade: they are swapped by replacing a file in
 * assets/img/memories/ rather than through the media picker.
 *
 * Each tile carries a ratio modifier. The photos are mostly 3:4, so the
 * ratios are what create variety across the board; object-fit: cover
 * does the cropping.
 *
 * @package Chaewon
 */

$chaewon_memories = get_template_directory_uri() . '/assets/img/memories/';

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

		<!-- wp:image {"className":"memory-photo memory-photo--tall"} -->
		<figure class="wp-block-image memory-photo memory-photo--tall"><img src="<?php echo esc_url( $chaewon_memories . 'rockies.jpg' ); ?>" alt="Looking out over a still pond towards a mountain face, framed by pines." decoding="async" /></figure>
		<!-- /wp:image -->

		<!-- wp:image {"className":"memory-photo memory-photo--short"} -->
		<figure class="wp-block-image memory-photo memory-photo--short"><img src="<?php echo esc_url( $chaewon_memories . 'seoul.jpg' ); ?>" alt="A red arch bridge across a wide river at dusk." loading="lazy" decoding="async" /></figure>
		<!-- /wp:image -->

		<!-- wp:image {"className":"memory-photo memory-photo--square memory-photo--offset-sm"} -->
		<figure class="wp-block-image memory-photo memory-photo--square memory-photo--offset-sm"><img src="<?php echo esc_url( $chaewon_memories . 'balcony.jpg' ); ?>" alt="A shiba inu sitting on a balcony, watching the city in the rain." loading="lazy" decoding="async" /></figure>
		<!-- /wp:image -->

		<!-- wp:image {"className":"memory-photo memory-photo--wide"} -->
		<figure class="wp-block-image memory-photo memory-photo--wide"><img src="<?php echo esc_url( $chaewon_memories . 'shiba.jpg' ); ?>" alt="A shiba inu grinning on a grassy lookout above the water." loading="lazy" decoding="async" /></figure>
		<!-- /wp:image -->

		<!-- wp:image {"className":"memory-photo memory-photo--short memory-photo--offset"} -->
		<figure class="wp-block-image memory-photo memory-photo--short memory-photo--offset"><img src="<?php echo esc_url( $chaewon_memories . 'japan.jpg' ); ?>" alt="A quiet street corner with a vending machine against a tiled apartment block." loading="lazy" decoding="async" /></figure>
		<!-- /wp:image -->

		<!-- wp:image {"className":"memory-photo memory-photo--tall"} -->
		<figure class="wp-block-image memory-photo memory-photo--tall"><img src="<?php echo esc_url( $chaewon_memories . 'lake.jpg' ); ?>" alt="Crouching by a windy lake shore with a dog, hills across the water." loading="lazy" decoding="async" /></figure>
		<!-- /wp:image -->

	</div>
	<!-- /wp:group -->

</section>
<!-- /wp:group -->
