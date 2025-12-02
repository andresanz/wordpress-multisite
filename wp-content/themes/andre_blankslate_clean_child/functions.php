<?php
/**
 * Andre Blank Slate Clean Child functions
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

function andre_clean_child_enqueue_styles() {
    // Parent theme style
    wp_enqueue_style(
        'blankslate-parent',
        get_template_directory_uri() . '/style.css',
        array(),
        wp_get_theme( get_template() )->get( 'Version' )
    );

    // Child theme style
    wp_enqueue_style(
        'andre-clean-child',
        get_stylesheet_directory_uri() . '/style.css',
        array( 'blankslate-parent' ),
        wp_get_theme()->get( 'Version' )
    );
}
add_action( 'wp_enqueue_scripts', 'andre_clean_child_enqueue_styles' );

/**
 * Register navigation menu and sidebar
 */
function andre_clean_child_setup() {
    register_nav_menus( array(
        'primary' => __( 'Primary Menu', 'andre-clean-child' ),
    ) );
}
add_action( 'after_setup_theme', 'andre_clean_child_setup' );

function andre_clean_child_widgets_init() {
    register_sidebar( array(
        'name'          => __( 'Primary Sidebar', 'andre-clean-child' ),
        'id'            => 'primary-sidebar',
        'description'   => __( 'Main sidebar that appears on the right.', 'andre-clean-child' ),
        'before_widget' => '<section id="%1$s" class="widget %2$s card">',
        'after_widget'  => '</section>',
        'before_title'  => '<h2 class="widget-title">',
        'after_title'   => '</h2>',
    ) );
}
add_action( 'widgets_init', 'andre_clean_child_widgets_init' );
