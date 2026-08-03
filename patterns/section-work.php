<?php
/**
 * Title: Section — Selected work
 * Slug: chaewon/section-work
 * Categories: featured
 * Description: A numbered section heading followed by project entries.
 *
 * Patterns are reusable chunks of block markup. The header comment
 * above is parsed by WordPress the same way style.css is — Slug and
 * Title are required. Once this file exists, the pattern appears in
 * the editor inserter under "Patterns", and can be referenced from a
 * template with <!-- wp:pattern {"slug":"chaewon/section-work"} /-->
 *
 * Because this is a .php file you can use translation functions and
 * esc_url( get_template_directory_uri() ) for image paths.
 *
 * @package Chaewon
 */

?>

<!-- wp:group {"style":{"spacing":{"padding":{"top":"var:preset|spacing|50","bottom":"var:preset|spacing|50"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group" style="padding-top:var(--wp--preset--spacing--50);padding-bottom:var(--wp--preset--spacing--50)">

	<!-- wp:paragraph {"className":"section-eyebrow"} -->
	<p class="section-eyebrow">01 — Selected work</p>
	<!-- /wp:paragraph -->

	<!-- wp:heading -->
	<h2 class="wp-block-heading">Things I've built</h2>
	<!-- /wp:heading -->

	<!-- wp:group {"className":"project-card reveal","style":{"spacing":{"margin":{"top":"var:preset|spacing|40"}}},"layout":{"type":"constrained"}} -->
	<div class="wp-block-group project-card reveal" style="margin-top:var(--wp--preset--spacing--40)">
		<!-- wp:paragraph {"fontSize":"small","textColor":"muted"} -->
		<p class="has-muted-color has-text-color has-small-font-size">Booking platform · Django REST, PostgreSQL, React</p>
		<!-- /wp:paragraph -->

		<!-- wp:heading {"level":3} -->
		<h3 class="wp-block-heading">Sysbox</h3>
		<!-- /wp:heading -->

		<!-- wp:paragraph -->
		<p>Replace this with the problem you were solving, what broke, and what you learned. Lead with the problem, not the stack.</p>
		<!-- /wp:paragraph -->
	</div>
	<!-- /wp:group -->

	<!-- wp:group {"className":"project-card reveal","style":{"spacing":{"margin":{"top":"var:preset|spacing|40"}}},"layout":{"type":"constrained"}} -->
	<div class="wp-block-group project-card reveal" style="margin-top:var(--wp--preset--spacing--40)">
		<!-- wp:paragraph {"fontSize":"small","textColor":"muted"} -->
		<p class="has-muted-color has-text-color has-small-font-size">Job orchestration · Kubernetes, Discord bot interface</p>
		<!-- /wp:paragraph -->

		<!-- wp:heading {"level":3} -->
		<h3 class="wp-block-heading">NoteApp Minion</h3>
		<!-- /wp:heading -->

		<!-- wp:paragraph -->
		<p>Replace this with the problem you were solving, what broke, and what you learned.</p>
		<!-- /wp:paragraph -->
	</div>
	<!-- /wp:group -->

</div>
<!-- /wp:group -->
