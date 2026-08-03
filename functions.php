<?php
/**
 * Chaewon theme functions.
 *
 * A block theme needs far less PHP than a classic theme. Menus, widgets,
 * and thumbnail sizes are handled by theme.json and the Site Editor. What
 * is left is asset loading, the colour-scheme bootstrap, and a handful of
 * editor affordances.
 *
 * @package Chaewon
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Never allow direct file access.
}

/**
 * The key the colour scheme is stored under in localStorage.
 *
 * Read by the inline bootstrap below and written by assets/js/site.js.
 * Change it in one place only and the toggle silently stops persisting,
 * so the value is mirrored in a comment at the top of site.js.
 */
define( 'CHAEWON_SCHEME_KEY', 'chaewon-scheme' );

/**
 * Basic theme supports.
 *
 * Block themes opt into most of this automatically. These are the
 * exceptions worth declaring.
 */
function chaewon_setup(): void {
	// Embeds (YouTube and friends) scale to their container instead of
	// overflowing it on small screens.
	add_theme_support( 'responsive-embeds' );

	// Lets a block opt into full-width without the theme fighting it.
	add_theme_support( 'align-wide' );

	// Loads translations from /languages if any are ever added. The text
	// domain has to match the theme directory name, which is why
	// style.css declares "chaewon-theme" and not "chaewon".
	load_theme_textdomain( 'chaewon-theme', get_template_directory() . '/languages' );
}
add_action( 'after_setup_theme', 'chaewon_setup' );

/**
 * Load the front-end stylesheet and script.
 *
 * filemtime() is the version string so the browser cache busts every time
 * a file is saved. In development this removes the entire class of "I
 * changed the CSS and nothing happened" confusion.
 */
function chaewon_enqueue_assets(): void {
	$dir = get_template_directory();
	$uri = get_template_directory_uri();

	wp_enqueue_style(
		'chaewon-style',
		$uri . '/style.css',
		array(),
		filemtime( $dir . '/style.css' )
	);

	wp_enqueue_script(
		'chaewon-site',
		$uri . '/assets/js/site.js',
		array(),
		filemtime( $dir . '/assets/js/site.js' ),
		array(
			'strategy'  => 'defer',
			'in_footer' => true,
		)
	);
}
add_action( 'wp_enqueue_scripts', 'chaewon_enqueue_assets' );

/**
 * Set the colour scheme before the first paint.
 *
 * This has to be inline and it has to be blocking. A deferred or external
 * script runs after the browser has already painted, so the page flashes
 * light and then snaps to dark, which is worse than having no dark mode.
 *
 * It reads the stored preference first and falls back to the OS setting,
 * so someone whose system is dark gets dark on their first visit without
 * having touched the toggle.
 *
 * Priority 0 puts it ahead of the stylesheet, which is the whole point.
 */
function chaewon_color_scheme_bootstrap(): void {
	// wp_json_encode produces a safely quoted JS string literal.
	$key = wp_json_encode( CHAEWON_SCHEME_KEY );
	?>
	<script>
	( function () {
		var el = document.documentElement;
		try {
			var stored = localStorage.getItem( <?php echo $key; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?> );
			var prefersDark = window.matchMedia( '(prefers-color-scheme: dark)' ).matches;
			el.setAttribute( 'data-theme', stored === 'dark' || stored === 'light' ? stored : ( prefersDark ? 'dark' : 'light' ) );
		} catch ( e ) {
			// Private browsing can make localStorage throw on read. Light is
			// the safe default. Never leave the attribute unset: the toggle
			// button reads it to decide which way to switch.
			el.setAttribute( 'data-theme', 'light' );
		}
	} )();
	</script>
	<?php
}
add_action( 'wp_head', 'chaewon_color_scheme_bootstrap', 0 );

/**
 * Output a skip link as the first focusable element on the page.
 *
 * Without it, keyboard and screen-reader users tab through the whole
 * header on every single page load before reaching the content.
 */
function chaewon_skip_link(): void {
	printf(
		'<a class="skip-link" href="#content">%s</a>',
		esc_html__( 'Skip to content', 'chaewon-theme' )
	);
}
add_action( 'wp_body_open', 'chaewon_skip_link' );

/**
 * Load the same stylesheet inside the block editor.
 *
 * Without this the editor preview does not match the front end, and a lot
 * of time gets spent being confused about why. add_editor_style() reads
 * paths relative to the theme root.
 */
function chaewon_editor_styles(): void {
	add_editor_style( 'style.css' );
}
add_action( 'after_setup_theme', 'chaewon_editor_styles' );

/**
 * Register a pattern category.
 *
 * Without this the theme's patterns land in "Uncategorized" next to every
 * core pattern, which makes them effectively unfindable in the inserter.
 */
function chaewon_register_pattern_categories(): void {
	register_block_pattern_category(
		'chaewon',
		array(
			'label'       => __( 'Chaewon', 'chaewon-theme' ),
			'description' => __( 'Sections built for this portfolio.', 'chaewon-theme' ),
		)
	);
}
add_action( 'init', 'chaewon_register_pattern_categories' );

/**
 * Register block style variations.
 *
 * These appear in the Styles panel of the relevant block, so the card
 * treatments can be reused from the editor without anyone typing a CSS
 * class by hand. This is the block-theme way to hand a design decision
 * to whoever is editing content.
 */
function chaewon_register_block_styles(): void {
	$group_styles = array(
		'card'       => __( 'Card', 'chaewon-theme' ),
		'card-quiet' => __( 'Card (quiet)', 'chaewon-theme' ),
	);

	foreach ( $group_styles as $name => $label ) {
		register_block_style( 'core/group', compact( 'name', 'label' ) );
	}

	register_block_style(
		'core/paragraph',
		array(
			'name'  => 'label',
			'label' => __( 'Mono label', 'chaewon-theme' ),
		)
	);
}
add_action( 'init', 'chaewon_register_block_styles' );

/**
 * Bump this when the rewrite rules change shape.
 *
 * Registering a post type does not by itself teach WordPress the URLs for
 * it — the rewrite rules are cached in the database. Without a flush,
 * /projects/ returns 404 while every line of configuration looks correct,
 * which is a genuinely confusing hour to lose.
 */
define( 'CHAEWON_REWRITE_VERSION', '1' );

/**
 * The project post type, its two taxonomies, and its tagline field.
 *
 * Projects are a post type rather than pages because they need an archive
 * (/projects/) and a consistent single template. Making them pages would
 * mean hand-maintaining a list somewhere, which is the thing a CMS is
 * supposed to remove.
 *
 * project_type  — one term, the card eyebrow ("SaaS platform").
 * project_tech  — many terms, the chips at the bottom of a card.
 * tagline       — the italic line under the title. A meta field rather
 *                 than a taxonomy because it is prose, not a category,
 *                 and show_in_rest makes it available to block bindings.
 */
function chaewon_register_project_type(): void {
	register_post_type(
		'project',
		array(
			'labels'        => array(
				'name'          => __( 'Projects', 'chaewon-theme' ),
				'singular_name' => __( 'Project', 'chaewon-theme' ),
				'add_new_item'  => __( 'Add Project', 'chaewon-theme' ),
				'edit_item'     => __( 'Edit Project', 'chaewon-theme' ),
			),
			'public'        => true,
			'has_archive'   => 'projects',
			'rewrite'       => array( 'slug' => 'projects', 'with_front' => false ),
			'menu_icon'     => 'dashicons-portfolio',
			'menu_position' => 5,
			'supports'      => array( 'title', 'editor', 'excerpt', 'thumbnail', 'custom-fields', 'revisions' ),
			// Required for the block editor and for block bindings to see
			// the tagline field.
			'show_in_rest'  => true,
		)
	);

	register_taxonomy(
		'project_type',
		'project',
		array(
			'labels'            => array(
				'name'          => __( 'Project types', 'chaewon-theme' ),
				'singular_name' => __( 'Project type', 'chaewon-theme' ),
			),
			'public'            => true,
			'hierarchical'      => true,
			'show_in_rest'      => true,
			'show_admin_column' => true,
			'rewrite'           => array( 'slug' => 'project-type' ),
		)
	);

	register_taxonomy(
		'project_tech',
		'project',
		array(
			'labels'            => array(
				'name'          => __( 'Technologies', 'chaewon-theme' ),
				'singular_name' => __( 'Technology', 'chaewon-theme' ),
			),
			'public'            => true,
			'hierarchical'      => false,
			'show_in_rest'      => true,
			'show_admin_column' => true,
			'rewrite'           => array( 'slug' => 'tech' ),
		)
	);

	register_post_meta(
		'project',
		'tagline',
		array(
			'type'          => 'string',
			'single'        => true,
			'default'       => '',
			'show_in_rest'  => true,
			'auth_callback' => static function () {
				return current_user_can( 'edit_posts' );
			},
		)
	);
}
add_action( 'init', 'chaewon_register_project_type' );

/**
 * Flush rewrite rules once per rewrite version.
 *
 * flush_rewrite_rules() is expensive, so it must not run on every request.
 * Keying it to an option means it runs exactly once after a deploy that
 * changes URL shapes, and heals itself if the database is ever restored
 * from before the post type existed.
 *
 * Priority 20 so it runs after the post type is registered on init.
 */
function chaewon_maybe_flush_rewrites(): void {
	if ( get_option( 'chaewon_rewrite_version' ) === CHAEWON_REWRITE_VERSION ) {
		return;
	}

	flush_rewrite_rules();
	update_option( 'chaewon_rewrite_version', CHAEWON_REWRITE_VERSION );
}
add_action( 'init', 'chaewon_maybe_flush_rewrites', 20 );

/**
 * Also flush when the theme is activated, since that is the other moment
 * the rules can be stale.
 */
add_action( 'after_switch_theme', 'flush_rewrite_rules' );
