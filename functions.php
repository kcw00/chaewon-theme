<?php
/**
 * Chaewon theme functions.
 *
 * A block theme needs far less PHP than a classic theme. Most of what
 * used to live here (menus, widgets, thumbnail sizes) is now handled by
 * theme.json and the Site Editor. What remains is asset loading.
 *
 * @package Chaewon
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Never allow direct file access.
}

/**
 * Load the front-end stylesheet and scripts.
 *
 * filemtime() is used as the version string so the browser cache busts
 * every time you save the file. In development this saves you from
 * hard-refreshing after every change.
 */
function chaewon_enqueue_assets(): void {
	$theme_dir = get_stylesheet_directory();
	$theme_uri = get_stylesheet_directory_uri();

	wp_enqueue_style(
		'chaewon-style',
		$theme_uri . '/style.css',
		array(),
		filemtime( $theme_dir . '/style.css' )
	);

	wp_enqueue_script(
		'chaewon-reveal',
		$theme_uri . '/assets/js/reveal.js',
		array(),
		filemtime( $theme_dir . '/assets/js/reveal.js' ),
		array(
			'strategy'  => 'defer',
			'in_footer' => true,
		)
	);
}
add_action( 'wp_enqueue_scripts', 'chaewon_enqueue_assets' );

/**
 * Load the same stylesheet inside the block editor.
 *
 * Without this, the editor preview will not match the front end and you
 * will spend a lot of time confused about why. add_editor_style() reads
 * paths relative to the theme root.
 */
function chaewon_editor_styles(): void {
	add_editor_style( 'style.css' );
}
add_action( 'after_setup_theme', 'chaewon_editor_styles' );

/**
 * Register a block style variation.
 *
 * This adds a "Card" option to the Styles panel of every Group block,
 * so the pattern below can be reused from the editor without anyone
 * typing a CSS class by hand. This is the block-theme way to expose
 * design options to a non-technical editor.
 */
function chaewon_register_block_styles(): void {
	register_block_style(
		'core/group',
		array(
			'name'  => 'project-card',
			'label' => __( 'Project card', 'chaewon' ),
		)
	);
}
add_action( 'init', 'chaewon_register_block_styles' );
