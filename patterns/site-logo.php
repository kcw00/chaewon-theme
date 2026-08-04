<?php
/**
 * Title: Site logo
 * Slug: chaewon/site-logo
 * Categories: chaewon
 * Description: The avatar mark that opens the header, linking home.
 * Inserter: no
 *
 * A pattern rather than raw HTML in parts/header.html because the image
 * path has to be built with get_template_directory_uri(). Hard-coding
 * /wp-content/themes/... would break the moment WordPress lives in a
 * subdirectory.
 *
 * The mark is drawn in pure black on transparency and inverted in CSS
 * for the dark scheme, so there is one file rather than two that can
 * drift apart.
 *
 * @package Chaewon
 */

?>

<!-- wp:html -->
<a class="site-avatar" href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
	<img
		src="<?php echo esc_url( get_template_directory_uri() . '/assets/img/avatar.png' ); ?>"
		alt="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?> — home"
		width="192"
		height="192"
		decoding="async"
	/>
</a>
<!-- /wp:html -->
