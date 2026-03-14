<?php
/**
 * BearPress — functions.php
 */

if ( ! defined( 'ABSPATH' ) ) exit;

// ──────────────────────────────────────────
// Theme Setup
// ──────────────────────────────────────────
function bearpress_setup() {
	load_theme_textdomain( 'bearpress', get_template_directory() . '/languages' );

	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'html5', [
		'search-form', 'comment-form', 'comment-list',
		'gallery', 'caption', 'style', 'script',
	] );
	add_theme_support( 'customize-selective-refresh-widgets' );
	add_theme_support( 'wp-block-styles' );

	register_nav_menus( [
		'primary' => __( 'Primary Menu', 'bearpress' ),
	] );
}
add_action( 'after_setup_theme', 'bearpress_setup' );

// ──────────────────────────────────────────
// Enqueue
// ──────────────────────────────────────────
function bearpress_enqueue() {
	wp_enqueue_style(
		'bearpress-style',
		get_stylesheet_uri(),
		[],
		wp_get_theme()->get( 'Version' )
	);
}
add_action( 'wp_enqueue_scripts', 'bearpress_enqueue' );

// ──────────────────────────────────────────
// Content Width
// ──────────────────────────────────────────
function bearpress_content_width() {
	$GLOBALS['content_width'] = 680;
}
add_action( 'after_setup_theme', 'bearpress_content_width', 0 );

// ──────────────────────────────────────────
// Widgets
// ──────────────────────────────────────────
function bearpress_widgets_init() {
	register_sidebar( [
		'name'          => __( 'Footer', 'bearpress' ),
		'id'            => 'footer-1',
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	] );
}
add_action( 'widgets_init', 'bearpress_widgets_init' );

// ──────────────────────────────────────────
// Excerpt length
// ──────────────────────────────────────────
function bearpress_excerpt_length() { return 30; }
add_filter( 'excerpt_length', 'bearpress_excerpt_length' );

function bearpress_excerpt_more() { return '…'; }
add_filter( 'excerpt_more', 'bearpress_excerpt_more' );

// ──────────────────────────────────────────
// Remove bloat
// ──────────────────────────────────────────
remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
remove_action( 'wp_print_styles', 'print_emoji_styles' );
remove_action( 'wp_head', 'wp_generator' );
remove_action( 'wp_head', 'wlwmanifest_link' );
remove_action( 'wp_head', 'rsd_link' );
remove_action( 'wp_head', 'wp_shortlink_wp_head' );
