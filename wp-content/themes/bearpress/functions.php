<?php
/**
 * BearPress — functions.php
 */

defined( 'ABSPATH' ) || exit;

require get_template_directory() . '/inc/class-nav-walker.php';

// ── Theme setup ────────────────────────────────────────────────────────────────

function bearpress_setup() {
	load_theme_textdomain( 'bearpress', get_template_directory() . '/languages' );

	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );         // supported but not displayed by default
	add_theme_support( 'html5', [
		'search-form', 'comment-form', 'comment-list',
		'gallery', 'caption', 'style', 'script',
	] );
	add_theme_support( 'customize-selective-refresh-widgets' );
	add_theme_support( 'wp-block-styles' );
	add_theme_support( 'align-wide' );
	add_theme_support( 'editor-styles' );
	add_editor_style( 'style.css' );

	// Minimal custom logo — text title still preferred
	add_theme_support( 'custom-logo', [
		'height'      => 24,
		'width'       => 200,
		'flex-width'  => true,
		'flex-height' => true,
	] );

	register_nav_menus( [
		'primary' => __( 'Primary Menu', 'bearpress' ),
		'footer'  => __( 'Footer Menu', 'bearpress' ),
	] );
}
add_action( 'after_setup_theme', 'bearpress_setup' );

// ── Content width ──────────────────────────────────────────────────────────────

function bearpress_content_width() {
	$GLOBALS['content_width'] = 680;
}
add_action( 'after_setup_theme', 'bearpress_content_width', 0 );

// ── Enqueue styles (no JS needed) ─────────────────────────────────────────────

function bearpress_enqueue() {
	wp_enqueue_style(
		'bearpress-style',
		get_stylesheet_uri(),
		[],
		wp_get_theme()->get( 'Version' )
	);
}
add_action( 'wp_enqueue_scripts', 'bearpress_enqueue' );

// ── Widgets ────────────────────────────────────────────────────────────────────

function bearpress_widgets_init() {
	register_sidebar( [
		'name'          => __( 'Footer', 'bearpress' ),
		'id'            => 'footer-1',
		'description'   => __( 'Add widgets here to appear in the footer.', 'bearpress' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<p class="widget-title">',
		'after_title'   => '</p>',
	] );
}
add_action( 'widgets_init', 'bearpress_widgets_init' );

// ── Custom excerpt ─────────────────────────────────────────────────────────────

function bearpress_excerpt_length() {
	return 30;
}
add_filter( 'excerpt_length', 'bearpress_excerpt_length' );

function bearpress_excerpt_more() {
	return '…';
}
add_filter( 'excerpt_more', 'bearpress_excerpt_more' );

// ── Remove junk from <head> ────────────────────────────────────────────────────

remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
remove_action( 'wp_print_styles', 'print_emoji_styles' );
remove_action( 'wp_head', 'wp_generator' );
remove_action( 'wp_head', 'wlwmanifest_link' );
remove_action( 'wp_head', 'rsd_link' );
remove_action( 'wp_head', 'wp_shortlink_wp_head' );

// ── Customizer options ─────────────────────────────────────────────────────────

function bearpress_customize_register( $wp_customize ) {

	// ── Blog section ──────────────────────────────────────────────────────────

	$wp_customize->add_section( 'bearpress_options', [
		'title'    => __( 'BearPress Options', 'bearpress' ),
		'priority' => 130,
	] );

	// Show tagline inline with title
	$wp_customize->add_setting( 'bearpress_inline_tagline', [
		'default'           => true,
		'sanitize_callback' => 'rest_sanitize_boolean',
	] );
	$wp_customize->add_control( 'bearpress_inline_tagline', [
		'label'   => __( 'Show tagline inline with site title', 'bearpress' ),
		'section' => 'bearpress_options',
		'type'    => 'checkbox',
	] );

	// Show post dates on list
	$wp_customize->add_setting( 'bearpress_show_dates', [
		'default'           => true,
		'sanitize_callback' => 'rest_sanitize_boolean',
	] );
	$wp_customize->add_control( 'bearpress_show_dates', [
		'label'   => __( 'Show dates on post list', 'bearpress' ),
		'section' => 'bearpress_options',
		'type'    => 'checkbox',
	] );

	// Group posts by year on list
	$wp_customize->add_setting( 'bearpress_group_by_year', [
		'default'           => true,
		'sanitize_callback' => 'rest_sanitize_boolean',
	] );
	$wp_customize->add_control( 'bearpress_group_by_year', [
		'label'   => __( 'Group posts by year on index', 'bearpress' ),
		'section' => 'bearpress_options',
		'type'    => 'checkbox',
	] );

	// Show tags on single post
	$wp_customize->add_setting( 'bearpress_show_tags', [
		'default'           => true,
		'sanitize_callback' => 'rest_sanitize_boolean',
	] );
	$wp_customize->add_control( 'bearpress_show_tags', [
		'label'   => __( 'Show tags on single posts', 'bearpress' ),
		'section' => 'bearpress_options',
		'type'    => 'checkbox',
	] );

	// Footer text
	$wp_customize->add_setting( 'bearpress_footer_text', [
		'default'           => '',
		'sanitize_callback' => 'wp_kses_post',
	] );
	$wp_customize->add_control( 'bearpress_footer_text', [
		'label'   => __( 'Footer text (optional)', 'bearpress' ),
		'section' => 'bearpress_options',
		'type'    => 'text',
	] );

	// Accent color
	$wp_customize->add_setting( 'bearpress_accent_color', [
		'default'           => '#0000ff',
		'sanitize_callback' => 'sanitize_hex_color',
		'transport'         => 'postMessage',
	] );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'bearpress_accent_color', [
		'label'   => __( 'Link color', 'bearpress' ),
		'section' => 'bearpress_options',
	] ) );
}
add_action( 'customize_register', 'bearpress_customize_register' );

// Output customizer CSS inline
function bearpress_customizer_css() {
	$accent = get_theme_mod( 'bearpress_accent_color', '#0000ff' );
	if ( $accent && $accent !== '#0000ff' ) {
		echo '<style>:root{--accent:' . sanitize_hex_color( $accent ) . '}</style>';
	}
}
add_action( 'wp_head', 'bearpress_customizer_css' );

// ── Template helpers ────────────────────────────────────────────────────────────

/**
 * Render the post list date column.
 */
function bearpress_post_date( $post = null ) {
	if ( ! get_theme_mod( 'bearpress_show_dates', true ) ) return '';
	return '<span class="post-list-date">' . get_the_date( 'Y-m-d', $post ) . '</span>';
}

/**
 * Render post tags.
 */
function bearpress_post_tags() {
	if ( ! get_theme_mod( 'bearpress_show_tags', true ) ) return;
	$tags = get_the_tags();
	if ( ! $tags ) return;
	echo '<p class="post-tags">';
	foreach ( $tags as $tag ) {
		echo '<a href="' . esc_url( get_tag_link( $tag ) ) . '">' . esc_html( $tag->name ) . '</a> ';
	}
	echo '</p>';
}
