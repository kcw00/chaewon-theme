<?php
/**
 * Title: Chapter 05 — Say hello
 * Slug: chaewon/section-contact
 * Categories: chaewon
 * Description: Centred closing section with an email address and a call to action.
 *
 * Unlike the sections above, this group uses constrained layout. The
 * auto margins WordPress emits for constrained children are what centre
 * the content here, which is the intended effect for the last page.
 *
 * @package Chaewon
 */

?>

<!-- wp:group {"tagName":"section","align":"wide","className":"chapter contact","anchor":"contact","layout":{"type":"constrained"}} -->
<section id="contact" class="wp-block-group alignwide chapter contact">

	<!-- wp:group {"className":"chapter-rule","align":"wide","layout":{"type":"default"}} -->
	<div class="wp-block-group alignwide chapter-rule">
		<!-- wp:paragraph {"className":"chapter-rule__num"} -->
		<p class="chapter-rule__num">05</p>
		<!-- /wp:paragraph -->

		<!-- wp:paragraph {"className":"chapter-rule__label"} -->
		<p class="chapter-rule__label">Say hello</p>
		<!-- /wp:paragraph -->
	</div>
	<!-- /wp:group -->

	<!-- wp:paragraph {"className":"contact__eyebrow"} -->
	<p class="contact__eyebrow">One more thing</p>
	<!-- /wp:paragraph -->

	<!-- wp:heading {"className":"contact__title"} -->
	<h2 class="wp-block-heading contact__title">Let&rsquo;s build something<br><mark style="background-color:rgba(0, 0, 0, 0)" class="has-inline-color has-signal-color">worth running.</mark></h2>
	<!-- /wp:heading -->

	<!-- wp:paragraph {"className":"contact__body"} -->
	<p class="contact__body">A role, a project, or just a question about something on this page &mdash; I am always glad to hear from someone building something they care about.</p>
	<!-- /wp:paragraph -->

	<!-- wp:paragraph {"className":"contact__address"} -->
	<p class="contact__address"><a href="mailto:kimchaewon877@gmail.com">kimchaewon877@gmail.com</a></p>
	<!-- /wp:paragraph -->

	<!-- wp:group {"className":"contact__actions","layout":{"type":"default"}} -->
	<div class="wp-block-group contact__actions">

		<!-- wp:buttons -->
		<div class="wp-block-buttons">
			<!-- wp:button -->
			<div class="wp-block-button"><a class="wp-block-button__link wp-element-button" href="mailto:kimchaewon877@gmail.com">Send an email</a></div>
			<!-- /wp:button -->
		</div>
		<!-- /wp:buttons -->

		<!-- wp:paragraph {"style":{"spacing":{"margin":{"top":"0","bottom":"0"}}}} -->
		<p style="margin-top:0;margin-bottom:0"><a class="link-arrow" href="https://www.linkedin.com/in/chaewon-kim-6b145825b/">LinkedIn</a></p>
		<!-- /wp:paragraph -->

	</div>
	<!-- /wp:group -->

</section>
<!-- /wp:group -->
