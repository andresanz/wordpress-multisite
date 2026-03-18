<?php
/**
 * BearPress functions and definitions.
 *
 * @package BearPress
 */

if ( ! defined( 'ABSPATH' ) ) exit;

define( 'BEARPRESS_VERSION', '1.0.0' );

/* ──────────────────────────────────────────────
   THEME SETUP
   ────────────────────────────────────────────── */
function bearpress_setup() {
    // Translations
    load_theme_textdomain( 'bearpress', get_template_directory() . '/languages' );

    // Title tag
    add_theme_support( 'title-tag' );

    // Post thumbnails (for OG image use, hidden in theme UI by default)
    add_theme_support( 'post-thumbnails' );

    // HTML5 markup
    add_theme_support( 'html5', [
        'search-form', 'comment-form', 'comment-list',
        'gallery', 'caption', 'style', 'script',
    ] );

    // Block editor color palette — force minimal
    add_theme_support( 'editor-color-palette', [
        [ 'name' => __( 'Black', 'bearpress' ),  'slug' => 'black',  'color' => '#333333' ],
        [ 'name' => __( 'White', 'bearpress' ),  'slug' => 'white',  'color' => '#ffffff' ],
        [ 'name' => __( 'Gray',  'bearpress' ),  'slug' => 'gray',   'color' => '#777777' ],
    ] );

    add_theme_support( 'disable-custom-colors' );
    add_theme_support( 'disable-custom-font-sizes' );
    add_theme_support( 'editor-font-sizes', [] );

    // Block editor styles (applies style.css to editor)
    add_theme_support( 'editor-styles' );
    add_editor_style( 'assets/css/editor.css' );

    // Automatic feed links
    add_theme_support( 'automatic-feed-links' );

    // Menus
    register_nav_menus( [
        'primary' => __( 'Primary Navigation', 'bearpress' ),
    ] );

    // Wide/full block alignment
    add_theme_support( 'align-wide' );

    // Responsive embeds
    add_theme_support( 'responsive-embeds' );
}
add_action( 'after_setup_theme', 'bearpress_setup' );

/* ──────────────────────────────────────────────
   ENQUEUE STYLES & SCRIPTS
   ────────────────────────────────────────────── */
function bearpress_enqueue() {
    wp_enqueue_style(
        'bearpress-style',
        get_stylesheet_uri(),
        [],
        BEARPRESS_VERSION
    );
}
add_action( 'wp_enqueue_scripts', 'bearpress_enqueue' );

/* ──────────────────────────────────────────────
   EXCERPT
   ────────────────────────────────────────────── */
function bearpress_excerpt_length( $length ) {
    return 30;
}
add_filter( 'excerpt_length', 'bearpress_excerpt_length' );

function bearpress_excerpt_more( $more ) {
    return '…';
}
add_filter( 'excerpt_more', 'bearpress_excerpt_more' );

/* ──────────────────────────────────────────────
   CUSTOMIZER
   ────────────────────────────────────────────── */
function bearpress_customize_register( $wp_customize ) {

    // ── Site Identity tweaks already built-in via WP ──

    // ── BearPress Options section ──
    $wp_customize->add_section( 'bearpress_options', [
        'title'    => __( 'BearPress Options', 'bearpress' ),
        'priority' => 30,
    ] );

    // Show/hide site description in header
    $wp_customize->add_setting( 'bearpress_show_tagline', [
        'default'           => true,
        'sanitize_callback' => 'rest_sanitize_boolean',
    ] );
    $wp_customize->add_control( 'bearpress_show_tagline', [
        'label'   => __( 'Show tagline in header', 'bearpress' ),
        'section' => 'bearpress_options',
        'type'    => 'checkbox',
    ] );

    // Show post dates in list
    $wp_customize->add_setting( 'bearpress_show_dates', [
        'default'           => true,
        'sanitize_callback' => 'rest_sanitize_boolean',
    ] );
    $wp_customize->add_control( 'bearpress_show_dates', [
        'label'   => __( 'Show dates in post list', 'bearpress' ),
        'section' => 'bearpress_options',
        'type'    => 'checkbox',
    ] );

    // Date format in list
    $wp_customize->add_setting( 'bearpress_date_format', [
        'default'           => 'Y-m-d',
        'sanitize_callback' => 'sanitize_text_field',
    ] );
    $wp_customize->add_control( 'bearpress_date_format', [
        'label'       => __( 'List date format', 'bearpress' ),
        'description' => __( 'PHP date format string. e.g. Y-m-d or M j, Y', 'bearpress' ),
        'section'     => 'bearpress_options',
        'type'        => 'text',
    ] );

    // Footer text
    $wp_customize->add_setting( 'bearpress_footer_text', [
        'default'           => '',
        'sanitize_callback' => 'wp_kses_post',
    ] );
    $wp_customize->add_control( 'bearpress_footer_text', [
        'label'   => __( 'Footer text (HTML allowed)', 'bearpress' ),
        'section' => 'bearpress_options',
        'type'    => 'textarea',
    ] );

    // Max width (override CSS variable)
    $wp_customize->add_setting( 'bearpress_max_width', [
        'default'           => '660',
        'sanitize_callback' => 'absint',
        'transport'         => 'postMessage',
    ] );
    $wp_customize->add_control( 'bearpress_max_width', [
        'label'       => __( 'Column width (px)', 'bearpress' ),
        'description' => __( 'BearBlog default is 660px', 'bearpress' ),
        'section'     => 'bearpress_options',
        'type'        => 'number',
        'input_attrs' => [ 'min' => 400, 'max' => 1200, 'step' => 10 ],
    ] );

    // Base font size
    $wp_customize->add_setting( 'bearpress_font_size', [
        'default'           => '16',
        'sanitize_callback' => 'absint',
        'transport'         => 'postMessage',
    ] );
    $wp_customize->add_control( 'bearpress_font_size', [
        'label'       => __( 'Base font size (px)', 'bearpress' ),
        'section'     => 'bearpress_options',
        'type'        => 'number',
        'input_attrs' => [ 'min' => 12, 'max' => 24, 'step' => 1 ],
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
}
add_action( 'customize_register', 'bearpress_customize_register' );

/* ──────────────────────────────────────────────
   INLINE CUSTOMIZER CSS
   ────────────────────────────────────────────── */
function bearpress_customizer_css() {
    $max_width  = absint( get_theme_mod( 'bearpress_max_width', 660 ) );
    $font_size  = absint( get_theme_mod( 'bearpress_font_size', 16 ) );
    ?>
    <style>
        :root {
            --max-width: <?php echo $max_width; ?>px;
            --base-size: <?php echo $font_size; ?>px;
        }
    </style>
    <?php
}
add_action( 'wp_head', 'bearpress_customizer_css' );

/* ──────────────────────────────────────────────
   HELPER: date format
   ────────────────────────────────────────────── */
function bearpress_post_date( $post_id = null ) {
    $fmt = get_theme_mod( 'bearpress_date_format', 'Y-m-d' );
    return get_the_date( $fmt, $post_id );
}

/* ──────────────────────────────────────────────
   REMOVE EMOJI SCRIPTS (keep it lean)
   ────────────────────────────────────────────── */
remove_action( 'wp_head',             'print_emoji_detection_script', 7 );
remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
remove_action( 'wp_print_styles',     'print_emoji_styles' );
remove_action( 'admin_print_styles',  'print_emoji_styles' );
remove_filter( 'the_content_feed',    'wp_staticize_emoji' );
remove_filter( 'comment_text_rss',    'wp_staticize_emoji' );
remove_filter( 'wp_mail',            'wp_staticize_emoji_for_email' );

/* ──────────────────────────────────────────────
   CLEAN UP WP HEAD
   ────────────────────────────────────────────── */
remove_action( 'wp_head', 'wp_generator' );
remove_action( 'wp_head', 'wlwmanifest_link' );
remove_action( 'wp_head', 'rsd_link' );
remove_action( 'wp_head', 'wp_shortlink_wp_head' );
